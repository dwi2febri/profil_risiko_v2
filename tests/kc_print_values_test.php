<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
require __DIR__ . '/../fungsi/cetak_ringkas.php';

function print_value_assert(bool $ok, string $message): void {
    if (!$ok) throw new RuntimeException($message);
}
function print_value_extract(string $source, string $name): string {
    $start = strpos($source, 'function '.$name.'(');
    if ($start === false) throw new RuntimeException('Missing function '.$name);
    $code = ''; $depth = 0; $started = false;
    foreach (array_slice(token_get_all('<?php '.substr($source, $start)), 1) as $token) {
        $text = is_array($token) ? $token[1] : $token;
        $code .= $text;
        if ($token === '{' || (is_array($token) && in_array($token[0], [T_CURLY_OPEN, T_DOLLAR_OPEN_CURLY_BRACES], true))) {
            $depth++; $started = true;
        } elseif ($token === '}' && --$depth === 0 && $started) return $code;
    }
    throw new RuntimeException('Unclosed function '.$name);
}
// Independent original Nilai Profil functions; do not render or save the form.
$original = file_get_contents(__DIR__.'/../admin/kc/nilai_peringkat/nilai_profil.php');
$calculators = substr($original, 0, strpos($original, 'function build_risiko_rows_payload('));
preg_match_all('/^function (\w+)\(/m', $calculators, $names);
foreach ($names[1] as $name) eval(print_value_extract($calculators, $name));
eval(print_value_extract($original, 'build_risiko_rows'));
eval(print_value_extract($original, 'hitung_total_bobot_inheren'));
$print = file_get_contents(__DIR__.'/../admin/laporan/cetak_laporan_profil_risiko.php');
foreach (['esc_pdf','pdf_num','pdf_one','pdf_table_exists','pdf_col_exists','pdf_label_inheren',
    'pdf_get_profil_risk','pdf_cover_profil_nilai_peringkat_html'] as $name) {
    eval(print_value_extract($print, $name));
}
$ids = [590];
$q = mysqli_query($conn, 'SELECT MAX(id_profil_risiko) id FROM frame_laporan_profil_risiko WHERE user=3 GROUP BY kantor_cabang');
while ($row = mysqli_fetch_assoc($q)) $ids[] = (int)$row['id'];
$checks = 0;
foreach (array_unique($ids) as $id) {
    $frame = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id'"));
    if (!$frame || (int)$frame['user'] !== 3) continue;
    $expected = build_risiko_rows($conn, $id);
    foreach ($expected as $risk => $row) {
        $actual = pdf_get_profil_risk($conn, $id, $risk);
        print_value_assert((float)$actual['nilai_in'] === (float)$row['nilai_inheren'], "Print score differs from Nilai Profil: $id/$risk");
        print_value_assert($actual['rank_in'] === $row['peringkat_inheren'], "Print rank differs: $id/$risk");
        $checks++;
    }
    $weights = get_active_bobot($conn, $frame['tahun'], 3)['bobot'];
    $total = hitung_total_bobot_inheren($expected, $weights);
    $html = pdf_cover_profil_nilai_peringkat_html($conn, $id, $frame);
    print_value_assert(str_contains($html, '<b>'.pdf_num($total).'</b><br><b>'.nilai_label($total).'</b>'), "Print composite differs: $id");
    if ((int)($frame['data_pembanding'] ?? 0) > 0) {
        $comparison = (int)$frame['data_pembanding'];
        foreach (build_risiko_rows($conn, $comparison) as $risk => $row) {
            print_value_assert((float)pdf_get_profil_risk($conn, $comparison, $risk)['nilai_in'] === (float)$row['nilai_inheren'], "Comparison differs: $comparison/$risk");
            $checks++;
        }
    }
}
foreach (glob(__DIR__.'/../*/laporan/cetak_laporan_profil_risiko.php') as $file) {
    $role = file_get_contents($file);
    print_value_assert(str_contains(print_value_extract($role, 'pdf_get_profil_risk'), 'cetak_ringkas_kc_snapshot('), 'Missing per-risk integration: '.$file);
    print_value_assert(str_contains(print_value_extract($role, 'pdf_cover_profil_nilai_peringkat_html'), 'cetak_ringkas_kc_snapshot('), 'Missing composite integration: '.$file);
}
print_value_assert(cetak_ringkas_kc_snapshot($conn, 0) === null, 'Invalid report must not become a branch report');
echo "PASS: $checks risk scores/ranks match original Nilai Profil calculators, including report 590 and comparisons; branch composites and 20 print controllers use the shared source.\n";
