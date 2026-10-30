<?php
if (PHP_SAPI !== 'cli') exit(1);
function esc_pdf($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function pdf_table_exists($conn, $table) { return false; }
function pdf_tgl_indo_long($date) { return '29 Oktober 2026'; }
function check_declaration($condition, $file) {
    if (!$condition) throw new RuntimeException('Incorrect declaration: '.$file);
}
$files = glob(__DIR__.'/../*/laporan/cetak_laporan_profil_risiko.php');
foreach ($files as $index => $file) {
    $source = file_get_contents($file);
    $start = strpos($source, 'function pdf_pernyataan_ttd_html(');
    $end = strpos($source, "\n".'$id = ', $start);
    $name = 'declaration_for_role_'.$index;
    eval(str_replace('pdf_pernyataan_ttd_html(', $name.'(', substr($source, $start, $end-$start)));
    foreach ([1, 2, 4, 5] as $type) {
        $html = $name(null, ['user'=>$type, 'tipe_user'=>'Profil Risiko Non Cabang', 'nama'=>'Must not appear']);
        check_declaration(str_contains($html, 'hasil perbaikan oleh Kantor Pusat dan RTU'), $file);
        check_declaration(str_contains($html, '<th>Kepala Bidang</th><th>Kepala Divisi</th>'), $file);
        check_declaration(substr_count($html, '<b>Nama : </b>') === 2, $file);
        check_declaration(!str_contains($html, 'Status Konfirmasi') && !str_contains($html, 'Must not appear'), $file);
    }
    $branch = $name(null, ['user'=>3, 'tipe_user'=>'Profil Risiko Kantor Cabang', 'nama'=>'Nama Petugas']);
    check_declaration(str_contains($branch, 'hasil perbaikan oleh Kantor Cabang') && str_contains($branch, 'Status Konfirmasi'), $file);
    check_declaration(str_contains($branch, '<th>Kepala Cabang</th><th>Risk Residence Area</th>') && str_contains($branch, 'Nama Petugas'), $file);
}
echo 'PASS non-branch and branch declarations for ', count($files), " roles\n";
