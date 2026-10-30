"""Check printed narrative words against the drawn table edges (PyMuPDF).

Run after compact_print_browser_test.cjs, with one or more PDF paths.
Adjacent border segments are joined so cell boundaries aren't false positives.
"""
import collections
import json
import re
import sys

import fitz


def check_pdf(filename):
    issues = []
    checked = 0
    pages = 0
    with fitz.open(filename) as document:
        for index, page in enumerate(document):
            if not re.search(r"RISIKO [A-Z]+ (?:INHEREN|KPMR)", page.get_text()[:260]):
                continue
            vertical = [drawing["rect"] for drawing in page.get_drawings()
                        if drawing["rect"].width < 1.6 and drawing["rect"].height > 3]
            candidates = collections.Counter(round(rect.x1, 1) for rect in vertical
                                             if rect.x1 > page.rect.width * .8)
            if not candidates:
                continue
            edge = candidates.most_common(1)[0][0]
            borders = [rect for rect in vertical if abs(rect.x1 - edge) < 1]
            intervals = []
            for rect in sorted(borders, key=lambda item: item.y0):
                if intervals and rect.y0 <= intervals[-1][1] + 2:
                    intervals[-1][1] = max(intervals[-1][1], rect.y1)
                else:
                    intervals.append([rect.y0, rect.y1])
            top = min(rect.y0 for rect in borders)
            pages += 1
            for x0, y0, x1, y1, word, *_ in page.get_text("words"):
                if x0 < page.rect.width * .6 or y0 < top + 2:
                    continue
                checked += 1
                if x1 > edge + 2 or not any(y0 >= start - 2 and y1 <= end + 2
                                            for start, end in intervals):
                    issues.append({"page": index + 1, "word": word, "y": round(y0, 1)})
    assert checked and pages, "No assessment narrative found: " + filename
    assert not issues, "Narrative outside table: " + json.dumps(issues[:20])
    return {"file": filename, "pages": pages, "words_checked": checked}


if __name__ == "__main__":
    if len(sys.argv) < 2:
        raise SystemExit("Usage: python tests/print_note_bounds_test.py report.pdf [...]")
    print("PASS " + json.dumps([check_pdf(filename) for filename in sys.argv[1:]]))
