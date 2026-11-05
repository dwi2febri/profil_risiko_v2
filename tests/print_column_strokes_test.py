"""Check actual PDF column alignment AND thickness, beyond CSS declarations."""
from pathlib import Path
import re
import sys

import fitz

pdf = Path(sys.argv[1]) if len(sys.argv) > 1 else Path(__file__).resolve().parent.parent / '.local/monitoring-review/compact-summaries-print.pdf'
kinds = set()
samples = pages = 0
with fitz.open(pdf) as document:
    for number, page in enumerate(document, 1):
        kind = re.search(r'RISIKO\s+(KREDIT|OPERASIONAL|KEPATUHAN|LIKUIDITAS|REPUTASI|STRATEJIK)\s+(INHEREN|KPMR)', page.get_text()[:500])
        headings = page.search_for('PERINGKAT')
        if not kind or not headings:
            continue
        heading = headings[0]
        raster = page.get_pixmap(matrix=fitz.Matrix(4, 4), alpha=False)
        pixels = memoryview(raster.samples)
        # Header and body deliberately share the same clipped stroke painter.
        # Read the header stroke from pixels instead of assuming a native border.
        header_y = round((heading.y0 + heading.y1) * 2)
        runs = []
        for x in range(round((heading.x0 - 15) * 4), round((heading.x0 - 1) * 4)):
            offset = (header_y * raster.width + x) * 3
            if max(pixels[offset:offset + 3]) < 150:
                if runs and runs[-1][-1] == x - 1:
                    runs[-1].append(x)
                else:
                    runs.append([x])
        runs = [run for run in runs if 2 <= len(run) <= 4]
        assert runs, (number, 'Header divider missing or too thick')
        run = runs[-1]
        centre = (run[0] + run[-1] + 1) / 8
        checked = 0
        recaps = page.search_for('REKAP PENILAIAN')
        stop = min([page.rect.height - 40] + [rect.y0 - 20 for rect in recaps if rect.y0 > heading.y1])
        text_bands = [(word[1] - 1, word[3] + 1) for word in page.get_text('words')
                      if word[0] < centre + 2 and word[2] > centre - 2]
        for y in range(round((heading.y1 + 25) * 4), round(stop * 4), 37):
            if any(top <= y / 4 <= bottom for top, bottom in text_bands):
                continue
            dark = []
            for x in range(round(centre * 4) - 8, round(centre * 4) + 9):
                offset = (y * raster.width + x) * 3
                if max(pixels[offset:offset + 3]) < 150:
                    dark.append(x)
            # Empty pillar/title bands have no divider; horizontal rules cover
            # the whole scan window and are tested separately by grid tests.
            if not dark or len(dark) > 8:
                continue
            stroke_centre = (min(dark) + max(dark) + 1) / 8
            stroke_width = len(dark) / 4
            assert abs(stroke_centre - centre) <= .125, (number, 'shifted divider', stroke_centre, centre)
            assert .5 <= stroke_width <= 1, (number, 'doubled/thick divider', stroke_width, y / 4, dark)
            checked += 1
        if checked:
            kinds.add(kind.groups())
            samples += checked
            pages += 1
expected = {(risk, 'KPMR') for risk in ['KREDIT', 'OPERASIONAL', 'KEPATUHAN', 'LIKUIDITAS', 'REPUTASI', 'STRATEJIK']}
expected |= {(risk, 'INHEREN') for risk in ['OPERASIONAL', 'KEPATUHAN', 'REPUTASI', 'STRATEJIK']}
assert expected <= kinds, f'Missing risk tables: {expected - kinds}'
print(f'PASS {len(kinds)} assessment tables, {pages} PDF pages, {samples} stroke samples: header/body edges coincide and strokes remain single-width')
