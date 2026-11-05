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
        for name, edges in [('letter', letter_edges), ('score', score_edges)]:
            assert any(r.y0 <= label.y0 and abs(r.y1 - boundary) < 1.1 for r in edges), (
                f'Page {number}: {name} divider does not reach the recap boundary')
        assert not any(r.y0 <= label.y0 and r.y1 > boundary + 1.1 for r in letter_edges), (
            'Letter divider extends into the pillar recap')
        # A previous absolute-border approach crossed the repeated letterhead.
        assert not any(r.y0 < 110 and r.y1 > label.y0 for r in letter_edges + score_edges)
        page.get_pixmap(matrix=fitz.Matrix(1.3, 1.3)).save(pdf.with_name('grid-ops-ti.png'))
        checked += 1
assert checked, 'Operational TI continuation fixture missing'
print(f'PASS {checked} actual PDF continuation: both dividers reach the recap, with no stroke through the letterhead')
