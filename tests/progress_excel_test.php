<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../conn/conn.php';
function progress_excel_check($condition, $message) {
    if (!$condition) throw new RuntimeException($message);
}
function progress_excel_validate($xml) {
    progress_excel_check(str_starts_with($xml, '<?xml '), 'Download contains page HTML before XML');
    $document = new DOMDocument();
    libxml_use_internal_errors(true);
    progress_excel_check($document->loadXML($xml), 'Invalid workbook XML');
    $ns = 'urn:schemas-microsoft-com:office:spreadsheet';
    $sheets = $document->getElementsByTagNameNS($ns, 'Worksheet');
    progress_excel_check($sheets->length === 2, 'Expected branch and division sheets');
    $names = [];
    foreach ($sheets as $sheet) {
        $name = $sheet->getAttributeNS($ns, 'Name'); $names[] = $name;
        $expected = str_contains($name, 'Cabang') ? 15 : 21;
        $occupied = []; $rowNumber = 0;
        foreach ($sheet->getElementsByTagNameNS($ns, 'Row') as $row) {
            $rowNumber++; $column = 1;
            foreach ($row->childNodes as $cell) {
                if (!$cell instanceof DOMElement || $cell->localName !== 'Cell') continue;
                if ($cell->hasAttributeNS($ns, 'Index')) $column = (int)$cell->getAttributeNS($ns, 'Index');
                $across = (int)$cell->getAttributeNS($ns, 'MergeAcross');
                $down = (int)$cell->getAttributeNS($ns, 'MergeDown');
                for ($r = $rowNumber; $r <= $rowNumber + $down; $r++) {
                    for ($c = $column; $c <= $column + $across; $c++) {
                        progress_excel_check(empty($occupied[$r][$c]), "$name: overlapping cell at row $r column $c");
                        progress_excel_check($c <= $expected, "$name: cell outside worksheet width");
                        $occupied[$r][$c] = true;
                    }
                }
                $column += $across + 1;
            }
            if ($rowNumber >= 3) progress_excel_check(count($occupied[$rowNumber] ?? []) === $expected, "$name: incomplete row $rowNumber");
        }
        progress_excel_check($rowNumber === (str_contains($name, 'Cabang') ? 32 : 12), "$name: branch/division rows missing");
    }
    progress_excel_check($names === ['Profil Risiko Cabang', 'Profil Risiko Divisi'], 'Unexpected sheet names');
}
$base = 'http://127.0.0.1/profil_risiko_v2/';
$directory = __DIR__.'/../.local/monitoring-review';
if (!is_dir($directory)) mkdir($directory, 0777, true);
foreach (['admin'=>'admin', 'admin_kc'=>'admin kc'] as $folder=>$role) {
    $cookies = tempnam(sys_get_temp_dir(), 'progress-excel-');
    $client = curl_init();
    curl_setopt_array($client, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_COOKIEJAR=>$cookies,
        CURLOPT_COOKIEFILE=>$cookies, CURLOPT_TIMEOUT=>60]);
    try {
        $account = mysqli_fetch_assoc(simpro_db_query($conn, 'SELECT username,password FROM user WHERE tipe=? ORDER BY user_id LIMIT 1', [$role]));
        progress_excel_check((bool)$account, 'Missing test account');
        curl_setopt_array($client, [CURLOPT_URL=>$base, CURLOPT_POST=>true, CURLOPT_POSTFIELDS=>http_build_query($account)]);
        curl_exec($client);
        progress_excel_check(curl_getinfo($client, CURLINFO_HTTP_CODE) === 302, 'Test login failed');
        foreach ([1,2] as $period) {
            curl_setopt_array($client, [CURLOPT_URL=>$base.$folder.'/progress_pengisian?tahun=2026&periode='.$period.'&cetak_excel=1', CURLOPT_POST=>false, CURLOPT_FOLLOWLOCATION=>true]);
            $xml = curl_exec($client);
            progress_excel_check(is_string($xml), 'Download failed: '.curl_error($client));
            progress_excel_check(curl_getinfo($client, CURLINFO_HTTP_CODE) === 200, 'Export HTTP '.curl_getinfo($client, CURLINFO_HTTP_CODE).' at '.curl_getinfo($client, CURLINFO_EFFECTIVE_URL));
            progress_excel_check(str_contains((string)curl_getinfo($client, CURLINFO_CONTENT_TYPE), 'application/vnd.ms-excel'), 'Wrong download content type');
            progress_excel_validate($xml);
            file_put_contents($directory.'/progress-'.$folder.'-tw'.$period.'.xls', $xml);
            echo 'PASS ', $folder, ' TW ', $period, ': clean XML, two sheets, 28 branches/8 divisions, no merged-cell overlap', PHP_EOL;
        }
    } finally {
        curl_setopt_array($client, [CURLOPT_URL=>$base.$folder.'/logout.php', CURLOPT_POST=>false, CURLOPT_FOLLOWLOCATION=>false]);
        curl_exec($client); curl_close($client); @unlink($cookies);
    }
}
