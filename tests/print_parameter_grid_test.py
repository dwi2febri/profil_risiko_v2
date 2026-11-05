"""Regression for column dividers ending before the final Operational subparameter.

Run after node tests/compact_print_browser_test.cjs --summaries.
Checks the actual drawn PDF strokes, including the boundary before the recap.
"""
from pathlib import Path
import sys

import fitz

pdf = Path(sys.argv[1]) if len(sys.argv) > 1 else Path(__file__).resolve().parent.parent / '.local/monitoring-review/compact-summaries-print.pdf'
checked = 0
with fitz.open(pdf) as document:
    for number, page in enumerate(document, 1):
        labels = page.search_for('Ketersediaan Sistem Informasi Manajemen')
        summaries = page.search_for('Hasil Penilaian Pilar 3')
        if not labels or 'RISIKO OPERASIONAL INHEREN' not in page.get_text():
            continue
        label = labels[0]
        following = [rect.y0 for rect in summaries if rect.y0 > label.y0]
        summary_top = min(following) if following else page.rect.height
        strokes = [drawing['rect'] for drawing in page.get_drawings()]
        horizontal = [r for r in strokes if r.height < 1.6 and r.width > page.rect.width * .3
                      and label.y1 < r.y0 < summary_top]
        vertical = [r for r in strokes if r.width < 1.6 and r.height > 3]
        boundary = max(r.y0 for r in horizontal) if horizontal else max(r.y1 for r in vertical if r.x0 > page.rect.width * .8)
        letter_edges = [r for r in vertical if label.x0 - 12 < r.x0 < label.x0]
        score_edges = [r for r in vertical if label.x1 < r.x0 < label.x1 + 20]
        # Full-height dividers are clipped cell backgrounds; rasterize so the
        # check covers both native strokes and the continuation fill.
        raster = page.get_pixmap(matrix=fitz.Matrix(3, 3), alpha=False)
        pixels = memoryview(raster.samples)
        def dark_near(x, y):
            return any(max(pixels[(y * raster.width + xx) * 3:(y * raster.width + xx) * 3 + 3]) < 100
                       for xx in range(max(0, round(x * 3) - 3), min(raster.width, round(x * 3) + 4)))
        heading = page.search_for('PERINGKAT')[0]
        header_y = round((heading.y0 + heading.y1) * 1.5)
        runs = []
        for x in range(round((heading.x0 - 15) * 3), round((heading.x0 - 1) * 3)):
            offset = (header_y * raster.width + x) * 3
            if max(pixels[offset:offset + 3]) < 150:
                if runs and runs[-1][-1] == x - 1: runs[-1].append(x)
                else: runs.append([x])
        runs = [run for run in runs if 1 <= len(run) <= 4]
        assert runs, 'Header divider missing'
        score_x = (runs[-1][0] + runs[-1][-1] + 1) / 6
        for name, x in [('letter', label.x0 - 5), ('score', score_x)]:
            gap = longest = 0
            for y in range(round(label.y0 * 3), round(boundary * 3)):
                gap = 0 if dark_near(x, y) else gap + 1
                longest = max(longest, gap)
            assert longest <= 3, f'Page {number}: {name} divider has a gap of {longest / 3:.1f}pt'
        # A previous absolute-border approach crossed the repeated letterhead.
        assert not any(r.y0 < 110 and r.y1 > label.y0 for r in letter_edges + score_edges)
        page.get_pixmap(matrix=fitz.Matrix(1.3, 1.3)).save(pdf.with_name('grid-ops-ti.png'))
        checked += 1
    overlaps = []
    for number, page in enumerate(document, 1):
        horizontal = [drawing['rect'] for drawing in page.get_drawings()
                      if drawing['rect'].height < 1.6 and drawing['rect'].width > 10]
        for x0, y0, x1, y1, word, *_ in page.get_text('words'):
            if y0 < 180 or x0 < page.rect.width * .07 or x1 > page.rect.width * .49:
                continue
            if any(r.x0 <= x0 and r.x1 >= x1 and y0 + .7 < (r.y0 + r.y1) / 2 < y1 - .7
                   for r in horizontal):
                overlaps.append((number, word))
    assert not overlaps, f'Parameter text crosses row borders: {overlaps[:10]}'
assert checked, 'Operational TI continuation fixture missing'
print(f'PASS {checked} actual PDF continuation: dividers reach the recap/page end, no stroke through the letterhead or parameter text')
