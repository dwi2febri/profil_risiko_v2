"""Lint every PHP source, sharing the result for byte-identical role copies."""
import argparse
from concurrent.futures import ThreadPoolExecutor
from hashlib import sha256
from pathlib import Path
import subprocess
import sys

parser = argparse.ArgumentParser(description=__doc__)
parser.add_argument("--php", default="php", help="Path to the target PHP executable")
args = parser.parse_args()
root = Path(__file__).resolve().parent.parent
groups = {}
for path in root.rglob("*.php"):
    if ".git" not in path.parts:
        groups.setdefault(sha256(path.read_bytes()).digest(), []).append(path)

def lint(paths):
    result = subprocess.run(
        [args.php, "-d", "error_reporting=32767", "-l", str(paths[0])],
        capture_output=True, text=True, errors="replace", timeout=60,
    )
    output = result.stdout + result.stderr
    return paths, output if result.returncode or "Deprecated:" in output or "Warning:" in output else ""

failures = 0
with ThreadPoolExecutor(max_workers=4) as executor:
    for paths, output in executor.map(lint, groups.values()):
        if output:
            failures += len(paths)
            for path in paths:
                print(f"FAIL: {path.relative_to(root)}")
            print(output.strip())
total = sum(len(paths) for paths in groups.values())
print(f"Checked {total} PHP files ({len(groups)} unique sources); failures: {failures}")
sys.exit(1 if failures else 0)
