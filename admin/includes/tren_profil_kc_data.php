<?php
require_once __DIR__ . '/hasil_laporan_cabang_data.php';

/** Inclusive quarter range, bounded before loading reports. */
function tren_kc_periods(int $startYear, int $startQuarter, int $endYear, int $endQuarter): array
{
    if ($startYear < 2000 || $endYear > 2100 || $startQuarter < 1 || $startQuarter > 4 || $endQuarter < 1 || $endQuarter > 4) {
        throw new InvalidArgumentException('Tahun harus 2000–2100 dan triwulan harus 1–4.');
    }
    $start = $startYear * 4 + $startQuarter - 1;
    $end = $endYear * 4 + $endQuarter - 1;
    if ($end < $start) throw new InvalidArgumentException('Periode akhir harus sama atau sesudah periode awal.');
    if ($end - $start >= 40) throw new InvalidArgumentException('Pilih rentang paling banyak 10 tahun (40 triwulan).');
    $periods = [];
    for ($index = $start; $index <= $end; $index++) {
        $year = intdiv($index, 4); $quarter = $index % 4 + 1;
        $periods[$year . '-' . $quarter] = ['year'=>$year, 'quarter'=>$quarter, 'label'=>'TW ' . $quarter . ' ' . $year];
    }
    return $periods;
}

function tren_kc_load(mysqli $db, array $periods, int $startBranch, int $endBranch): array
{
    $first = reset($periods); $last = end($periods);
    $query = simpro_db_query($db, 'SELECT id_profil_risiko,kantor_cabang,tahun,periode
        FROM frame_laporan_profil_risiko WHERE user=3 AND kantor_cabang BETWEEN ? AND ?
        AND (tahun*4+periode) BETWEEN ? AND ? ORDER BY id_profil_risiko DESC', [
        $startBranch, $endBranch, $first['year']*4+$first['quarter'], $last['year']*4+$last['quarter'],
    ]);
    $frames = []; $chosen = [];
    while ($frame = mysqli_fetch_assoc($query)) {
        $key = $frame['kantor_cabang'] . '|' . $frame['tahun'] . '-' . $frame['periode'];
        if (isset($chosen[$key])) continue;
        $chosen[$key] = true;
        // The shared loader accepts any stable key; report IDs keep periods distinct.
        $frames[(int)$frame['id_profil_risiko']] = $frame;
    }
    $results = hasil_kc_load_results($db, $frames);
    $series = [];
    foreach ($frames as $id=>$frame) {
        $key = $frame['tahun'] . '-' . $frame['periode'];
        $values = [];
        foreach (['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'] as $risk) {
            $value = $results[$id][$risk]['hasil_tingkat_risiko'] ?? null;
            $values[$risk] = hasil_kc_valid_score($value) ? (float)$value : null;
        }
        $value = $results[$id]['total']['total_nilai'] ?? null;
        $values['komposit'] = hasil_kc_valid_score($value) ? (float)$value : null;
        $series[(int)$frame['kantor_cabang']][$key] = ['id'=>$id, 'values'=>$values];
    }
    return $series;
}

/** Fixed 1–5 scale; missing periods break the line rather than becoming zero. */
function tren_kc_sparkline(array $values): string
{
    $points = []; $paths = []; $dots = []; $count = count($values);
    foreach (array_values($values) as $index=>$value) {
        if (!hasil_kc_valid_score($value)) {
            if ($points) $paths[] = implode(' ', $points);
            $points = []; continue;
        }
        $x = $count === 1 ? 55 : 5 + $index * 100 / ($count-1);
        $y = 33 - ((float)$value - 1) * 7;
        $point = number_format($x, 2, '.', '') . ',' . number_format($y, 2, '.', '');
        $points[] = $point;
        $dots[] = '<circle cx="' . number_format($x, 2, '.', '') . '" cy="' . number_format($y, 2, '.', '') . '" r="1.8"/>';
    }
    if ($points) $paths[] = implode(' ', $points);
    if (!$dots) return '<span class="tren-kc-missing">—</span>';
    $start = reset($values); $end = end($values);
    $delta = hasil_kc_valid_score($start) && hasil_kc_valid_score($end) ? round($end-$start, 2) : null;
    $label = $delta === null ? 'Pembanding awal/akhir belum lengkap' : ($delta > 0 ? 'Naik +' : ($delta < 0 ? 'Turun ' : 'Tetap ')) . number_format($delta, 2, ',', '.');
    $svg = '<svg viewBox="0 0 110 38" role="img" aria-label="' . hasil_kc_escape($label) . '"><title>' . hasil_kc_escape($label) . '</title>';
    foreach ($paths as $path) $svg .= '<polyline points="' . $path . '" fill="none" stroke-width="1.6"/>';
    return $svg . implode('', $dots) . '</svg><small>' . ($delta === null ? 'Belum lengkap' : ($delta > 0 ? '+' : '') . number_format($delta, 2, ',', '.')) . '</small>';
}
