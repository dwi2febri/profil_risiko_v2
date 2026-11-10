<?php
/** Branch print projections use the same read-only calculators as the KC forms. */
function cetak_ringkas_kc_snapshot(mysqli $conn, int $id): ?array
{
    static $cache;
    $cache ??= new WeakMap();
    $reports = $cache[$conn] ?? [];
    if (array_key_exists($id, $reports)) return $reports[$id];
    require_once dirname(__DIR__) . '/admin/includes/hasil_laporan_cabang_data.php';
    $frame = $id > 0 ? hasil_kc_source_db_one($conn,
        "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id' LIMIT 1") : null;
    $snapshot = null;
    if ((int)($frame['user'] ?? 0) === 3) {
        $rows = [];
        foreach (['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'] as $risk) {
            $rows[$risk] = hasil_kc_source_inherent_result($conn, $id, $risk);
            // Nilai Profil uses exclusive upper boundaries for its computed ranks.
            if (($rows[$risk]['_source'] ?? '') === 'Perhitungan Profil KC dari parameter terpilih'
                || trim((string)$rows[$risk]['hasil_peringkat']) === '') {
                $value = (float)$rows[$risk]['hasil_tingkat_risiko'];
                $rows[$risk]['hasil_peringkat'] = match (true) {
                    $value < 1 || $value > 5 => '',
                    $value < 1.25 => 'Sangat Rendah',
                    $value < 2.25 => 'Rendah',
                    $value < 3.25 => 'Sedang',
                    $value < 4.25 => 'Tinggi',
                    default => 'Sangat Tinggi',
                };
            }
        }
        $weights = hasil_kc_weights($conn, $frame['tahun'], 3)['bobot'];
        $snapshot = ['risks' => $rows, 'total' => hasil_kc_composite($rows, $weights)];
    }
    $reports[$id] = $snapshot;
    $cache[$conn] = $reports;
    return $snapshot;
}

/** Shared letterhead repeated by the outer print table on every physical page. */
function cetak_ringkas_letterhead(array $frame, string $projectRoot): string
{
    $esc = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    $logo = '';
    foreach (['admin/laporan/logo.png', 'admin/pembanding/logo.png', 'admin_kc/laporan/logo.png', 'admin/logo.png', 'logo.png', 'pic_area_semarang/logo.png', 'pic_area_semarang/assets/logo.png'] as $relative) {
        $path = $projectRoot . '/' . $relative;
        if (is_file($path)) {
            $bytes = file_get_contents($path);
            if ($bytes !== false && $bytes !== '') {
                $logo = '<img class="report-letterhead-logo" src="data:image/png;base64,' . base64_encode($bytes) . '" alt="Logo BKK Jateng">';
                break;
            }
        }
    }
    $office = strtoupper(trim((string)($frame['cabang'] ?? '')));
    return '<header class="report-letterhead">' . $logo
        . '<div class="report-letterhead-title">HASIL PELAPORAN PROFIL RISIKO' . ($office !== '' ? ' ' . $esc($office) : '')
        . '<br>PT. BPR BKK JATENG (PERSERODA)</div>'
        . '<div class="report-letterhead-address">Jl. Tanjung No.11-A Sekayu, Semarang Tengah, Kota Semarang 50132 - info@bprbkkinfo.com - (024) 86405241 - 0815 1400 0400</div></header>';
}

/** Keep the assessment summaries used by the compact complete report. */
function cetak_ringkas_sections(array $sections, bool $isCabang = false): array
{
    return array_values(array_filter($sections, static function(array $section) use ($isCabang): bool {
        $title = (string)($section['title'] ?? '');
        if ($isCabang && preg_match('/\bKPMR\b/i', $title)) return false;
        return !preg_match('/-\s*(?:KPMR\s*1|Inheren\s*1)\s*$/i', $title)
            && !preg_match('/\bProfil\s+(?:Nilai\s+Konsolidasi|Peringkat)\s*$/i', $title);
    }));
}

/** Reuse the saved overall profile narrative shown on the Nilai Profil form. */
function cetak_ringkas_cover_uraian($conn, int $id): string
{
    if ($id <= 0 || !pdf_table_exists($conn, 'nilai_profil')) return '';
    $row = pdf_one($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko='".$id."' LIMIT 1");
    $text = trim((string)($row['ket_nilai_risiko'] ?? ''));
    if ($text === '') return '';
    return '<section class="cover-narrative"><h2>URAIAN PROFIL RISIKO</h2><div class="cover-narrative-text">'
        .htmlspecialchars($text, ENT_QUOTES, 'UTF-8').'</div></section>';
}

/** Separate scores and grades into two visible rows in each per-risk profile. */
function cetak_ringkas_profile_table(array $row, string $caption, bool $isCabang): string
{
    $esc = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
    $scores = $isCabang ? ['in' => 'Tingkat Risiko Inheren'] : [
        'in' => 'Tingkat Risiko Inheren', 'kp' => 'Tingkat KPMR', 't' => 'Tingkat Risiko'
    ];
    $html = '<table class="pdf-profile-single profile-score-rows'.($isCabang ? ' profil-cabang-only' : '').'"><thead>'
        .'<tr><th colspan="'.($isCabang ? 2 : 5).'">'.$esc($caption).'</th></tr><tr><th>Jenis Risiko</th>';
    foreach ($scores as $heading) $html .= '<th>'.$esc($heading).'</th>';
    if (!$isCabang) $html .= '<th>Tingkat Kualitas Manajemen Risiko</th>';
    $html .= '</tr></thead><tbody><tr class="profile-score-values"><td rowspan="2"><b>'.$esc($row['label'] ?? '').'</b></td>';
    foreach ($scores as $key => $heading) $html .= '<td class="valrank">'.$esc(pdf_num($row['nilai_'.$key] ?? 0)).'</td>';
    if (!$isCabang) $html .= '<td rowspan="2" class="quality-cell">'.$esc($row['kualitas'] ?? '').'</td>';
    $html .= '</tr><tr class="profile-score-ranks">';
    foreach ($scores as $key => $heading) $html .= '<td class="valrank"><b>'.$esc($row['rank_'.$key] ?? '').'</b></td>';
    return $html.'</tr></tbody></table>';
}
