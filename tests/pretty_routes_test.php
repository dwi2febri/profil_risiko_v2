<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../fungsi/pretty_routes.php';
$base = '/profil_risiko_v2/admin/';
$cases = [
    [[], $base],
    [['page'=>'dashboard'], $base.'dashboard'],
    [['page'=>'pembanding'], $base.'pembanding/'],
    [['page'=>'menulapawal','id'=>''], $base.'laporan/'],
    [['page'=>'menulapawal','id'=>'556','tab'=>'final'], $base.'laporan/556/final'],
    [['page'=>'hasil_lapkc','tahun'=>'2026','periode'=>'2'], $base.'hasil_lapkc?tahun=2026&periode=2'],
    [['page'=>'kre_inhern','id'=>'545'], $base.'kre_inhern?id=545'],
];
foreach ($cases as [$params, $expected]) {
    if (simpro_route_url($base, $params) !== $expected) throw new RuntimeException('Wrong route: '.json_encode($params));
}
if (simpro_route_absolute_location('../login.php', $base) !== '/profil_risiko_v2/login.php') throw new RuntimeException('Login redirect incorrect');
if (simpro_route_absolute_location('index.php?page=menulapawal', $base) !== $base.'index.php?page=menulapawal') throw new RuntimeException('Relative redirect incorrect');
if (simpro_route_url($base, ['page'=>'../conn/conn']) !== $base.'index.php?page=..%2Fconn%2Fconn') throw new RuntimeException('Unsafe route accepted');
$files = glob(__DIR__.'/../*/laporan/cetak_laporan_profil_risiko.php');
foreach ($files as $file) {
    $index = dirname(dirname($file)).'/index.php';
    $source = file_get_contents($index);
    if (substr_count($source, 'simpro_routes_bootstrap()') !== 1 || !str_contains($source, '<base href=')) throw new RuntimeException('Missing/duplicate role bootstrap: '.$index);
}
echo 'PASS route aliases, query preservation, redirects and integration for ', count($files), " roles\n";
