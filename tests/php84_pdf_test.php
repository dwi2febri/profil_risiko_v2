<?php
// Run each PDF library in its own process because copies define the same classes.
if (PHP_SAPI !== 'cli') exit(1);
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) {
    if (error_reporting() & $severity) throw new ErrorException($message, 0, $severity, $file, $line);
    return false;
});
$library = $argv[1] ?? __DIR__ . '/../admin/laporan/fpdf182/fpdf.php';
require $library;
$temporaryFiles = [];
try {
    $image = imagecreatetruecolor(2, 2);
    $imagePath = tempnam(sys_get_temp_dir(), 'php84-image-');
    $temporaryFiles[] = $imagePath;
    imagepng($image, $imagePath);
    $pdf = new FPDF();
    $pdf->SetTitle("Profil risiko \xE9");
    $pdf->SetAuthor('BKK Jateng');
    $pdf->SetSubject('Uji kompatibilitas');
    $pdf->SetKeywords('profil risiko');
    $pdf->SetCreator('SIMPRO');
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(50, 10, 'Profil Risiko PHP 8.4');
    $pdf->Image($imagePath, 10, 30, 2, 2, 'PNG');
    $content = FPDF_VERSION === '1.6' ? $pdf->Output('', 'S') : $pdf->Output('S');
    if (!str_starts_with($content, '%PDF-') || !str_contains($content, '%%EOF')) throw new RuntimeException('Invalid PDF output');
    if (isset($argv[2])) {
        $inputPath = tempnam(sys_get_temp_dir(), 'php84-pdf-');
        $temporaryFiles[] = $inputPath;
        file_put_contents($inputPath, $content);
        require $argv[2] . '/fpdi.php';
        $import = new FPDI();
        if ($import->setSourceFile($inputPath) !== 1) throw new RuntimeException('PDF import failed');
        $template = $import->importPage(1);
        $import->AddPage();
        $import->useTemplate($template);
        $merged = FPDF_VERSION === '1.6' ? $import->Output('', 'S') : $import->Output('S');
        if (!str_starts_with($merged, '%PDF-')) throw new RuntimeException('Imported PDF output failed');
    }
    echo 'PASS: ', $library, isset($argv[2]) ? ' + FPDI import' : '', PHP_EOL;
} finally {
    foreach ($temporaryFiles as $path) if (is_file($path)) unlink($path);
}
