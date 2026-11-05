"""Validate real browser-generated XLSX/PDF values, fills, trend images and bounds."""
import json
import re
import zipfile
from collections import Counter
from pathlib import Path
from xml.etree import ElementTree as ET
import fitz

root = Path(__file__).resolve().parents[1] / '.local/tren-kc-export-review'
ns = {'s': 'http://schemas.openxmlformats.org/spreadsheetml/2006/main'}
palette = {'blue': 'E7F1FF', 'green': 'E9F8ED', 'yellow': 'FFF7CC', 'orange': 'FFF0DC', 'red': 'FDE7E7'}

def column(index):
    result = ''
    while index >= 0:
        result = chr(65 + index % 26) + result
        index = index // 26 - 1
    return result

def value(cell):
    if cell.get('t') == 'inlineStr':
        return ''.join(cell.itertext())
    return float(cell.findtext('s:v', '', ns))

for name in ['all', 'filtered', 'long', 'empty']:
    expected = json.loads((root / (name + '.expected.json')).read_text(encoding='utf-8'))
    with zipfile.ZipFile(root / (name + '.xlsx')) as package:
        assert package.testzip() is None
        for path in package.namelist():
            if path.endswith(('.xml', '.rels')):
                ET.fromstring(package.read(path))
        sheet = ET.fromstring(package.read('xl/worksheets/sheet1.xml'))
        styles = ET.fromstring(package.read('xl/styles.xml'))
        cells = {cell.get('r'): cell for cell in sheet.findall('.//s:sheetData/s:row/s:c', ns)}
        formats = {int(item.get('numFmtId')): item.get('formatCode') for item in styles.findall('s:numFmts/s:numFmt', ns)}
        xfs = styles.find('s:cellXfs', ns)
        fills = styles.find('s:fills', ns)
        for group in expected['groups']:
            assert all(re.fullmatch(r'TW [1-4] \d{4}', period) for period in group['periods'])
        image_count = 0
        for index, row in enumerate(expected['rows'], 15):
            assert value(cells[('A' if row['area'] else 'B') + str(index)]) == row['name']
            if not row['area']:
                assert value(cells['A' + str(index)]) == row['code']  # leading zero retained
            current = 2
            for group in row['groups']:
                for score in group['cells']:
                    cell = cells[column(current) + str(index)]
                    assert value(cell) == (score['value'] if score['value'] is not None else '—')
                    style = xfs[int(cell.get('s'))]
                    fill = fills[int(style.get('fillId'))].find('s:patternFill/s:fgColor', ns)
                    assert (fill.get('rgb')[2:] if fill is not None else None) == (palette.get(score['band']))
                    if score['sample']:
                        assert score['sample'] in formats[int(style.get('numFmtId'))]
                    current += 1
                assert value(cells[column(current) + str(index)]) == group['delta']
                image_count += any(cell['value'] is not None for cell in group['cells'])
                current += 1
        images = [path for path in package.namelist() if path.endswith('.png')]
        assert len(images) == image_count
        for image in images:
            assert package.read(image).startswith(b'\x89PNG\r\n\x1a\n')
        assert sheet.find('s:sheetViews/s:sheetView/s:pane', ns).get('topLeftCell') == 'C15'
        all_text = ' '.join(cell.text or '' for cell in sheet.iter())
        for label in ['Keterangan warna berdasarkan peringkat', 'Sangat rendah', 'Rendah', 'Sedang', 'Tinggi', 'Sangat tinggi']:
            assert label in all_text
    document = fitz.open(root / (name + '.pdf'))
    text = '\n'.join(page.get_text() for page in document)
    assert expected['metadata'] in ' '.join(text.split())
    required = Counter()
    for row in expected['rows']:
        assert row['name'] in text
        for group in row['groups']:
            required.update(f"{score['value']:.2f}".replace('.', ',') for score in group['cells'] if score['value'] is not None)
    found = Counter(re.findall(r'(?<![\d,])\d,\d{2}(?!\d)', text))
    for number, count in required.items():
        assert found[number] >= count, (name, number, count, found[number])
    for group in expected['groups']:
        assert group['name'] in text
        for period in group['periods']:
            assert period in ' '.join(text.split())
    for page in document:
        for word in page.get_text('words'):
            assert word[0] >= 0 and word[2] <= page.rect.width + .5 and word[1] >= 0 and word[3] <= page.rect.height + .5, (name, word)
        assert 'Sangat rendah' in page.get_text()  # legend on every risk/period section
    document[0].get_pixmap(matrix=fitz.Matrix(1.2, 1.2)).save(root / (name + '.png'))
    print(f'PASS {name}: scores/colours, {image_count} Excel trend images, legends, PDF period coverage and page bounds')
