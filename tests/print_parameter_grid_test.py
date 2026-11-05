"""Regression for column dividers ending before the final Operational subparameter.

Run after node tests/compact_print_browser_test.cjs --summaries.
Checks the actual drawn PDF strokes, including the boundary before the recap.
"""
from pathlib import Path

import fitz

pdf = Path(__file__).resolve().parent.parent / '.local/monitoring-review/compact-summaries-print.pdf'
checked = 0
with fitz.open(pdf) as document:
    for number, page in enumerate(document, 1):
        labels = page.search_for('Ketersediaan Sistem Informasi Manajemen')
        summaries = page.search_for('Hasil Penilaian Pilar 3')
        if not labels or not summaries or 'RISIKO OPERASIONAL INHEREN' not in page.get_text():
            continue
        label = labels[0]
        summary_top = min(rect.y0 for rect in summaries if rect.y0 > label.y0)
        strokes = [drawing['rect'] for drawing in page.get_drawings()]
        horizontal = [r for r in strokes if r.height < 1.6 and r.width > page.rect.width * .3
                      and label.y1 < r.y0 < summary_top]
        assert horizontal, 'Recap top border missing'
        boundary = max(r.y0 for r in horizontal)
        vertical = [r for r in strokes if r.width < 1.6 and r.height > 3]
        letter_edges = [r for r in vertical if label.x0 - 12 < r.x0 < label.x0]
        score_edges = [r for r in vertical if label.x1 < r.x0 < label.x1 + 20]
        # Full-height dividers are clipped cell backgrounds; rasterize so the
        # check covers both native strokes and the continuation fill.
        raster = page.get_pixmap(matrix=fitz.Matrix(3, 3), alpha=False)
        pixels = memoryview(raster.samples)
        def dark_near(x, y):
            return any(max(pixels[(y * raster.width + xx) * 3:(y * raster.width + xx) * 3 + 3]) < 100
                       for xx in range(max(0, round(x * 3) - 3), min(raster.width, round(x * 3) + 4)))
        score_x = min(r.x0 for r in score_edges)
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
assert checked, 'Operational TI continuation fixture missing'
print(f'PASS {checked} actual PDF continuation: both dividers reach the recap, with no stroke through the letterhead')
