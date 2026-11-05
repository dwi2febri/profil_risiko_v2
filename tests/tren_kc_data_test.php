<?php
require_once __DIR__ . '/../conn/conn.php';
require_once __DIR__ . '/../admin/includes/tren_profil_kc_data.php';
function tren_test(bool $ok, string $message): void { if (!$ok) throw new RuntimeException($message); }
$periods = tren_kc_periods(2025, 4, 2026, 2);
tren_test(array_keys($periods) === ['2025-4','2026-1','2026-2'], 'Inclusive cross-year range');
foreach ([[2026,3,2026,2],[2026,0,2026,2],[2026,1,2026,5],[1999,1,2026,1],[2024,1,2034,1]] as $invalid) {
    try { tren_kc_periods(...$invalid); throw new RuntimeException('Invalid range accepted'); } catch (InvalidArgumentException $expected) {}
}
tren_test(count(tren_kc_periods(2024,1,2033,4)) === 40, '40-quarter limit');
$svg = tren_kc_sparkline([2,null,4]);
tren_test(substr_count($svg, '<polyline') === 2, 'Line must break at missing period');
tren_test(str_contains($svg, '+2,00') && substr_count($svg, '<circle') === 2, 'Endpoint delta and missing value');
tren_test(!str_contains(tren_kc_sparkline([null,2,3]), '+1,00'), 'Do not substitute missing first period');
tren_test(!str_contains(tren_kc_sparkline([null,null]), '<svg'), 'No fabricated empty chart');
$all = tren_kc_load($conn, $periods, 1, 28);
$solo = tren_kc_load($conn, $periods, 8, 14);
foreach ($solo as $branch=>$values) tren_test($branch>=8 && $branch<=14 && $values===$all[$branch], 'Region must match same source');
foreach ($periods as $key=>$period) {
    $frames = [];
    $query = simpro_db_query($conn, 'SELECT * FROM frame_laporan_profil_risiko WHERE user=3 AND tahun=? AND periode=? AND kantor_cabang BETWEEN 1 AND 28 ORDER BY id_profil_risiko DESC', [$period['year'],$period['quarter']]);
    while ($frame=mysqli_fetch_assoc($query)) if (!isset($frames[(int)$frame['kantor_cabang']])) $frames[(int)$frame['kantor_cabang']]=$frame;
    $source = hasil_kc_load_results($conn, $frames);
    foreach ($frames as $branch=>$frame) {
        tren_test($all[$branch][$key]['id']===(int)$frame['id_profil_risiko'], 'Latest report per branch and period');
        foreach (['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik','komposit'] as $risk) {
            $value=$risk==='komposit'?($source[$branch]['total']['total_nilai']??null):($source[$branch][$risk]['hasil_tingkat_risiko']??null);
            $expected=hasil_kc_valid_score($value)?(float)$value:null;
            tren_test($all[$branch][$key]['values'][$risk]===$expected, 'Score differs from KC results: '.$branch.' '.$key.' '.$risk);
        }
    }
}
echo "PASS: range validation, missing periods, latest report, six risk sources, composite and region consistency\n";
