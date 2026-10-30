<?php
if (PHP_SAPI !== 'cli') exit(1);
$files = array_merge(
    glob(__DIR__.'/../*/laporan/menu_laporan_awal.php'),
    glob(__DIR__.'/../*/laporan/progress_pengisian.php')
);
$errors = [];
foreach ($files as $file) {
    try {
        token_get_all(file_get_contents($file), TOKEN_PARSE);
    } catch (ParseError $error) {
        $errors[] = basename(dirname(dirname($file))).'/laporan/'.basename($file).': '.$error->getMessage();
    }
}
if ($errors) {
    fwrite(STDERR, implode(PHP_EOL, $errors).PHP_EOL);
    exit(1);
}
echo 'PASS ', count($files), ' report/export pages with short_open_tag=', ini_get('short_open_tag'), PHP_EOL;
