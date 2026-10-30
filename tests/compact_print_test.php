<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../fungsi/cetak_ringkas.php';
$files = glob(__DIR__ . '/../*/laporan/cetak_laporan_profil_risiko.php');
foreach ($files as $file) {
    $source = file_get_contents($file);
    $start = strpos($source, '$sections = [');
    $end = strpos($source, '];', $start) + 2;
    eval(substr($source, $start, $end - $start));
    $compact = cetak_ringkas_sections($sections);
    if (count($compact) !== 18) throw new RuntimeException('Unexpected section count: ' . $file);
    $branch = cetak_ringkas_sections($sections, true);
    if (count($branch) !== 12 || preg_grep('/KPMR/i', array_column($branch, 'title'))) throw new RuntimeException('Branch KPMR sections still printed: '.$file);
    $titles = array_column($compact, 'title');
    if (preg_grep('/Profil (?:Nilai Konsolidasi|Peringkat)$/i', $titles)) throw new RuntimeException('Removed profile sections still printed: ' . $file);
    if (count(preg_grep('/KPMR 2$/', $titles)) !== 6 || count(preg_grep('/Inheren 2$/', $titles)) !== 4 || preg_grep('/(?:KPMR|Inheren) 1$/', $titles)) throw new RuntimeException('Print sections not compact: ' . $file);
    if (!str_contains($source, 'compactRiskPrintColumns(clone, expectedTitle);') || !str_contains($source, 'cetak_ringkas_sections($sections, $isProfilCabangCetak)')) throw new RuntimeException('Shared compact helpers missing: ' . $file);
    if (str_contains($source, 'return (stripos($title, \'KPMR\') === false)')) throw new RuntimeException('Branch output still removes KPMR 2');
}
echo 'PASS compact section selection and print integration for ', count($files), " roles\n";
