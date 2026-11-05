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

themes = {'kredit':'318354','operasional':'0070C0','kepatuhan':'9954CC','likuiditas':'F29727','reputasi':'D54F79','stratejik':'595959'}
for name in ['all', 'solo', 'filtered', 'empty']:
    expected = json.loads((directory / (name + '.expected.json')).read_text(encoding='utf-8'))
    with zipfile.ZipFile(directory / (name + '.xlsx')) as package:
        assert package.testzip() is None
        for path in package.namelist():
            if path.endswith(('.xml', '.rels')):
                ET.fromstring(package.read(path))
        workbook = ET.fromstring(package.read('xl/workbook.xml'))
        assert len(workbook.find('s:sheets', ns)) == 1
        styles = ET.fromstring(package.read('xl/styles.xml'))
        xfs, fills = styles.find('s:cellXfs', ns), styles.find('s:fills', ns)
        sheet = ET.fromstring(package.read('xl/worksheets/sheet1.xml'))
        cells = {cell.get('r'): cell for cell in sheet.findall('.//s:sheetData/s:row/s:c', ns)}
        merges = {merge.get('ref') for merge in sheet.find('s:mergeCells', ns)}
        assert sheet.find('s:sheetViews/s:sheetView/s:pane', ns).get('topLeftCell') == 'C1'
        assert value(cells['A1']) == expected['reportTitle']
        assert value(cells['A2']) == 'PT BPR BKK JATENG (PERSERODA)'
        assert value(cells['A3']) == expected['periodTitle']
        max_pillars = max(len(section['headers'])-6 for section in expected['sections'])
        highest, last = 4+max_pillars, 5+max_pillars
        def fill(address):
            style = xfs[int(cells[address].get('s'))]
            colour = fills[int(style.get('fillId'))].find('s:patternFill/s:fgColor', ns)
            return colour.get('rgb')[2:] if colour is not None else None
        for section in expected['sections']:
            title = str(section['number'])+'. '+section['name'].upper()
            title_row = next(int(re.search(r'\d+', address).group()) for address, cell in cells.items() if value(cell) == title)
            header = title_row+1
            pillars = len(section['headers'])-6
            top = 4+pillars
            assert value(cells['C'+str(header)]) == section['name']
            assert value(cells['C'+str(header+1)]) == 'Inheren'
            assert f'A{header}:A{header+2}' in merges
            assert f'B{header}:B{header+2}' in merges
            assert f'{letters(top)}{header}:{letters(highest)}{header+2}' in merges
            assert fill('C'+str(header)) == themes[section['key']]
            assert fill('A'+str(header)) == (themes[section['key']] if section['key']=='kredit' else 'FFFF00')
            for column in range(2,pillars+3):
                assert value(cells[letters(column)+str(header+2)]) == section['headers'][column]
            for offset, row in enumerate(section['rows']):
                row_number = header+3+offset
                if row['average']:
                    assert value(cells['A'+str(row_number)]) == row['cells'][1]['text']
                    assert fill('C'+str(row_number)) == themes[section['key']]
                else:
                    assert fill('A'+str(row_number)) == 'C6E0B4'
                    assert fill('B'+str(row_number)) == 'C6E0B4'
                for column, expected_cell in enumerate(row['cells']):
                    if row['average'] and column < 2:
                        continue
                    physical = last if column==len(row['cells'])-1 else column
                    cell = cells[letters(physical)+str(row_number)]
                    assert value(cell) == (expected_cell['value'] if expected_cell.get('value') is not None else expected_cell['text'])
                    if not row['average'] and 2 <= column < len(row['cells'])-3:
                        assert fill(letters(physical)+str(row_number)) is None
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
    print(f'PASS {name}: one Excel sheet with {len(expected["sections"])} stacked themed tables, merged headers, identity/average colours, all values and complete PDF parameter descriptions')
