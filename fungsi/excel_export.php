<?php
/** Minimal XLSX writer. All values are inline strings, so formulas are never executed. */
function simpro_excel_file(string $target, array $headings, iterable $rows): void
{
    $xml = static function($value): string {
        $text = mb_substr((string)$value, 0, 32767, 'UTF-8');
        $text = preg_replace('/[^\x{9}\x{A}\x{D}\x{20}-\x{D7FF}\x{E000}-\x{FFFD}\x{10000}-\x{10FFFF}]/u', '', $text) ?? '';
        return htmlspecialchars($text, ENT_XML1 | ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    };
    $sheetPath = tempnam(sys_get_temp_dir(), 'simpro-sheet-');
    $stream = fopen($sheetPath, 'wb');
    $zip = new ZipArchive();
    try {
        if (!$stream || $zip->open($target, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) throw new RuntimeException('Tidak dapat membuat file Excel.');
        fwrite($stream, '<?xml version="1.0" encoding="UTF-8"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetViews><sheetView workbookViewId="0"><pane ySplit="1" topLeftCell="A2" state="frozen"/></sheetView></sheetViews><cols>');
        foreach ($headings as $index=>$heading) {
            $column=$index+1; $width=in_array($index,[1,4,5],true)?45:23;
            fwrite($stream, '<col min="'.$column.'" max="'.$column.'" width="'.$width.'" customWidth="1"/>');
        }
        fwrite($stream, '</cols><sheetData>');
        $number=0;
        $writeRow = static function(array $row, bool $header=false) use ($stream, $xml, &$number): void {
            ++$number; fwrite($stream, '<row r="'.$number.'">');
            foreach (array_values($row) as $index=>$value) {
                $col=''; $n=$index+1;
                while ($n>0) { $n--; $col=chr(65+$n%26).$col; $n=intdiv($n,26); }
                fwrite($stream, '<c r="'.$col.$number.'" t="inlineStr" s="'.($header?1:0).'"><is><t xml:space="preserve">'.$xml($value).'</t></is></c>');
            }
            fwrite($stream, '</row>');
        };
        $writeRow($headings, true);
        foreach ($rows as $row) $writeRow($row);
        fwrite($stream, '</sheetData><autoFilter ref="A1:'.chr(64+count($headings)).$number.'"/></worksheet>');
        fclose($stream); $stream=null;
        $zip->addFromString('[Content_Types].xml', '<?xml version="1.0"?><Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/></Types>');
        $zip->addFromString('_rels/.rels', '<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
        $zip->addFromString('xl/workbook.xml', '<?xml version="1.0"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Log Aktivitas" sheetId="1" r:id="rId1"/></sheets></workbook>');
        $zip->addFromString('xl/_rels/workbook.xml.rels', '<?xml version="1.0"?><Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
        $zip->addFromString('xl/styles.xml', '<?xml version="1.0"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="2"><font><sz val="11"/><name val="Calibri"/></font><font><b/><sz val="11"/><name val="Calibri"/></font></fonts><fills count="2"><fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill></fills><borders count="1"><border/></borders><cellStyleXfs count="1"><xf/></cellStyleXfs><cellXfs count="2"><xf fontId="0" fillId="0" borderId="0" xfId="0"/><xf fontId="1" fillId="0" borderId="0" xfId="0" applyFont="1"/></cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
        $zip->addFile($sheetPath, 'xl/worksheets/sheet1.xml');
        if (!$zip->close()) throw new RuntimeException('Gagal menyimpan Excel.');
    } finally {
        if (is_resource($stream)) fclose($stream);
        @unlink($sheetPath);
    }
}
