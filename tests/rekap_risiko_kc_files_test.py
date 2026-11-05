"""Validate exported per-risk tables including full highest-parameter descriptions."""
import json
import re
import zipfile
from pathlib import Path
from xml.etree import ElementTree as ET
import fitz

directory = Path(__file__).resolve().parents[1] / '.local/risk-recap-export-review'
ns = {'s': 'http://schemas.openxmlformats.org/spreadsheetml/2006/main'}
colours = {'blue': 'E7F1FF', 'green': 'E9F8ED', 'yellow': 'FFF7CC', 'orange': 'FFF0DC', 'red': 'FDE7E7'}
def letters(index):
    out = ''
    while index >= 0:
        out = chr(65 + index % 26) + out
        index = index // 26 - 1
    return out
def value(cell):
    return ''.join(cell.itertext()) if cell.get('t') == 'inlineStr' else float(cell.findtext('s:v', '', ns))

for name in ['all', 'filtered', 'empty']:
    expected = json.loads((directory / (name + '.expected.json')).read_text(encoding='utf-8'))
    with zipfile.ZipFile(directory / (name + '.xlsx')) as package:
        assert package.testzip() is None
        for path in package.namelist():
            if path.endswith(('.xml', '.rels')):
                ET.fromstring(package.read(path))
        workbook = ET.fromstring(package.read('xl/workbook.xml'))
        assert len(workbook.find('s:sheets', ns)) == len(expected['sections'])
        styles = ET.fromstring(package.read('xl/styles.xml'))
        xfs, fills = styles.find('s:cellXfs', ns), styles.find('s:fills', ns)
        for number, section in enumerate(expected['sections'], 1):
            sheet = ET.fromstring(package.read(f'xl/worksheets/sheet{number}.xml'))
            cells = {cell.get('r'): cell for cell in sheet.findall('.//s:sheetData/s:row/s:c', ns)}
            assert [value(cells[letters(c) + '12']) for c in range(len(section['headers']))] == section['headers']
            assert sheet.find('s:sheetViews/s:sheetView/s:pane', ns).get('topLeftCell') == 'C13'
            for row_number, row in enumerate(section['rows'], 13):
                for column, expected_cell in enumerate(row['cells']):
                    cell = cells[letters(column) + str(row_number)]
                    assert value(cell) == (expected_cell['value'] if expected_cell.get('value') is not None else expected_cell['text'])
                    if expected_cell.get('band'):
                        fill = fills[int(xfs[int(cell.get('s'))].get('fillId'))].find('s:patternFill/s:fgColor', ns)
                        assert fill.get('rgb')[2:] == colours[expected_cell['band']]
    pdf = fitz.open(directory / (name + '.pdf'))
    all_text = '\n'.join(page.get_text() for page in pdf)
    compact = re.sub(r'\s+', '', all_text)
    for section in expected['sections']:
        assert section['name'] in all_text
        for row in section['rows']:
            for cell in row['cells']:
                assert re.sub(r'\s+', '', cell['text']) in compact, (name, cell['text'])
    for page in pdf:
        text = page.get_text()
        assert 'Parameter Tertinggi di Pilar Tersebut' in ' '.join(text.split())
        assert 'Sangat rendah' in text
        for word in page.get_text('words'):
            assert word[0] >= 0 and word[2] <= page.rect.width + .5 and word[1] >= 0 and word[3] <= page.rect.height + .5, (name, word)
    pdf[0].get_pixmap(matrix=fitz.Matrix(1.2, 1.2)).save(directory / (name + '-pdf.png'))
    print(f'PASS {name}: {len(expected["sections"])} Excel sheets, all cell values/colours and complete PDF parameter descriptions within page bounds')
