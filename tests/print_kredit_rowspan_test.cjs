// NODE_PATH must contain Playwright if it is not installed in this project.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const os = require('node:os');
const { execFileSync } = require('node:child_process');
const { chromium } = require('playwright');
const root = path.resolve(__dirname, '..');
const liquidity = process.argv.includes('--liquidity');
const riskTitle = liquidity ? 'RISIKO LIKUIDITAS INHEREN' : 'RISIKO KREDIT INHEREN';
const sourcePage = liquidity ? 'lik_inhern' : 'kre_inhern';
const roles = ['admin', 'kepala_cabang', 'admin_kc', 'kepala_wilayah_semarang',
  'kepala_wilayah_solo', 'kepala_wilayah_banyumas', 'kepala_wilayah_pekalongan',
  'kadiv_pemasaran', 'kadiv_penyelesaian_kredit', 'kadiv_operasional', 'kadiv_sdm',
  'kadiv_kepatuhan', 'kadiv_sekper', 'kadiv_litbang', 'satker_skai', 'direksi',
  'pic_area_semarang', 'pic_area_solo', 'pic_area_pekalongan', 'pic_area_banyumas'];
function helpers(source) {
  const start = source.indexOf('    function cellHasRealText(');
  const end = source.indexOf('    function normalizeKpmrSkalaHeader(', start);
  assert(start >= 0 && end > start);
  return source.slice(start, end);
}
function fixture() {
  const header = `<thead><tr><th colspan="9">${riskTitle}</th></tr><tr>` +
    ['NO', 'PARAMETER', 'NOMINAL', 'RASIO', 'AMBANG BATAS', 'RUMUS', 'KOREKSI', 'NILAI', 'KETERANGAN'].map(s => `<th>${s}</th>`).join('') + '</tr></thead>';
  const row = (no, label, note) => `<tr><td>${no}</td><td>${label}</td>${'<td>2</td>'.repeat(6)}${note === null ? '' : `<td>${note}</td>`}</tr>`;
  return `<main class="clean-page"><table>${header}<tbody><tr><th colspan="9">PILAR 1</th></tr>` +
    row('1', 'Parameter 1', '<div class="print-field">' + 'Keterangan panjang '.repeat(110) + '</div><span>1881 / 2000</span>') +
    'abcdefg'.split('').map(letter => row('', `${letter}. Subparameter`, null)).join('') +
    row('2', 'Kredit Yang Diberikan', '<div class="print-field">Berdasarkan hasil penilaian, uraian dan rekap parameter 2.</div><span>1375 / 2000</span>') +
    'abcdef'.split('').map(letter => row('', `${letter}. Subparameter kredit`, null)).join('') +
    row('3', 'Parameter dengan keterangan di sub', '') + row('', 'a. Sub A', 'Catatan pada sub') + row('', 'b. Sub B', null) +
    '<tr><th colspan="9">PILAR 2</th></tr>' + row('1', 'Parameter kosong', '') + row('', 'a. Sub kosong', null) +
    '</tbody></table></main>';
}
(async () => {
  const browser = await chromium.launch({ headless: true, executablePath: process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe' });
  try {
    const page = await browser.newPage();
    for (const role of roles) {
      const source = fs.readFileSync(path.join(root, role, 'laporan/cetak_laporan_profil_risiko.php'), 'utf8');
      await page.setContent(fixture());
      await page.addScriptTag({ content: helpers(source) });
      const result = await page.evaluate(() => {
        const root = document.querySelector('main');
        fixKeteranganRowspan(root);
        fixInherenKeteranganWidth(root);
        const table = root.querySelector('table');
        const before = table.outerHTML;
        fixKeteranganRowspan(root);
        const cells = Array.from(table.querySelectorAll('.inheren-keterangan-merged'));
        return { spans: cells.map(c => c.rowSpan), lengths: Array.from(table.tBodies[0].rows).map(r => r.cells.length),
          note: cells[2].textContent, editorCounter: cells[0].textContent.includes('1881 / 2000'), same: before === table.outerHTML };
      });
      assert.deepEqual(result.spans, [8, 7, 3, 2], role);
      assert.deepEqual(result.lengths, [1, 9, 8, 8, 8, 8, 8, 8, 8, 9, 8, 8, 8, 8, 8, 8, 9, 8, 8, 1, 9, 8], role);
      assert.equal(result.note, 'Catatan pada sub', role);
      assert.equal(result.editorCounter, false, role);
      assert(result.same, `Repeated cleanup changed ${role}`);
      // Wide qualitative rows must retain their value columns underneath the rowspan.
      await page.setContent(fixture().replace(/<tbody>[\s\S]*<\/tbody>/, `<tbody>
        <tr><th colspan="9">PILAR 3</th></tr>
        <tr><td>1</td><td>Parameter kualitatif</td>${'<td>2</td>'.repeat(6)}<td>Hasil penilaian kualitatif</td></tr>
        <tr><td></td><td colspan="8">Detail dan nilai kualitatif</td></tr>
        <tr><td></td><td>Kredit yang berasal dari 3 sektor terbesar</td><td>Periode sebelumnya 3</td><td colspan="6"></td></tr>
        <tr><td></td><td>Penyaluran Kredit</td><td>Persentase 2</td><td colspan="2">Nilai 3</td><td colspan="5"></td></tr>
        <tr><td></td><td>a. Subparameter</td>${'<td>2</td>'.repeat(6)}</tr>
        <tr><th colspan="9">Rekapitulasi penilaian pilar</th></tr>
        <tr><th colspan="9">LAINNYA</th></tr>
        <tr><td>1</td><td>Faktor Lainnya</td>${'<td>2</td>'.repeat(6)}<td>Uraian faktor lainnya</td></tr>
        <tr>${'<td></td>'.repeat(9)}</tr>
        <tr><td></td><td>a. Kompetensi AO</td>${'<td>2</td>'.repeat(6)}</tr>
        <tr><td></td><td>b. Kompetensi Analis</td>${'<td>2</td>'.repeat(6)}</tr>
        </tbody>`));
      const qualitative = await page.evaluate(() => {
        fixKeteranganRowspan(document.querySelector('main'));
        const detail = Array.from(document.querySelectorAll('tr')).find(row => row.textContent.includes('Detail dan nilai kualitatif'));
        const sector = Array.from(document.querySelectorAll('tr')).find(row => row.textContent.includes('Kredit yang berasal dari 3 sektor terbesar'));
        const distribution = Array.from(document.querySelectorAll('tr')).find(row => row.textContent.includes('Penyaluran Kredit'));
        return { spans: Array.from(document.querySelectorAll('.inheren-keterangan-merged')).map(cell => cell.rowSpan),
          detailColumns: Array.from(detail.cells).reduce((sum, cell) => sum + cell.colSpan, 0),
          detailText: detail.cells[1].textContent,
          sectorColumns: Array.from(sector.cells).map(cell => cell.colSpan),
          previousValue: sector.cells[2].textContent,
          distributionColumns: Array.from(distribution.cells).reduce((sum, cell) => sum + cell.colSpan, 0),
          distributionValue: distribution.cells[3].textContent };
      });
      assert.deepEqual(qualitative, { spans: [5, 3], detailColumns: 8, detailText: 'Detail dan nilai kualitatif',
        sectorColumns: [1, 1, 1, 1, 1, 1, 1, 1], previousValue: 'Periode sebelumnya 3',
        distributionColumns: 8, distributionValue: 'Nilai 3' }, role);
      for (const title of ['RISIKO KREDIT KPMR']) {
        await page.setContent(fixture().replace(riskTitle, title));
        const untouched = await page.evaluate(() => {
          fixKeteranganRowspan(document.querySelector('main'));
          return { merged: document.querySelectorAll('.inheren-keterangan-merged').length,
            rows: document.querySelector('tbody').rows.length };
        });
        assert.deepEqual(untouched, { merged: 0, rows: 22 }, `${role}: ${title}`);
      }
      console.log(`PASS: ${role}: parameter 1 through g, group boundaries, empty notes, repeated cleanup`);
    }
    if (process.argv.includes('--live')) {
      const php = process.env.PHP84_BINARY || 'php';
      const account = JSON.parse(execFileSync(php, ['-r', "require 'conn/conn.php'; echo json_encode(mysqli_fetch_assoc(mysqli_query($conn, \"SELECT username,password FROM user WHERE tipe='admin' ORDER BY user_id LIMIT 1\")));"], { cwd: root, encoding: 'utf8' }));
      const context = await browser.newContext();
      await context.request.post('http://127.0.0.1/profil_risiko_v2/index.php', { form: account, maxRedirects: 0 });
      // Fetch the authenticated source once so slow local PHP startup does not
      // trigger the print page's six-second fallback timer during this test.
      const creditSource = await context.request.get(`http://127.0.0.1/profil_risiko_v2/admin/index.php?page=${sourcePage}&id=555&mode_print=1&print_pdf=1&clean_print=1`);
      assert.equal(creditSource.status(), 200);
      const live = await context.newPage();
      if (!liquidity) await live.route(`**/admin/index.php?page=${sourcePage}&*`, route => route.fulfill({ response: creditSource }));
      // Keep only the selected risk section to avoid loading unrelated report pages.
      await live.route('**/admin/laporan/cetak_laporan_profil_risiko.php?*', async route => {
        const response = await route.fetch();
        const auditGroups = `
          window.__creditExpectedGroups = [];
          clone.querySelectorAll('table').forEach(table => {
            if (!table.tHead || !table.tHead.textContent.includes(${JSON.stringify(riskTitle)})) return;
            let current = null;
            Array.from(table.tBodies).forEach(body => Array.from(body.rows).forEach(row => {
              const cells = Array.from(row.cells);
              const no = cells[0]?.textContent.trim() || '';
              const cols = cells.reduce((n, cell) => n + cell.colSpan, 0);
              if (!row.textContent.trim()) return;
              if (cols >= 8 && /^\\d+$/.test(no)) {
                current = { no, span: 1 };
                window.__creditExpectedGroups.push(current);
              } else if (current && cols >= 8 && no === '') {
                current.span++;
              } else { current = null; }
            }));
          });
          fixKeteranganRowspan(clone);`;
        const html = (await response.text())
          .replace("const sections = Array.from(document.querySelectorAll('.print-section'));", `const sections = Array.from(document.querySelectorAll('.print-section')).filter(section => /${liquidity ? 'Likuiditas - Inheren' : 'Kredit - Inheren'}/i.test(section.dataset.title)).slice(0, 1);`)
          .replace('fixKeteranganRowspan(clone);', auditGroups);
        await route.fulfill({ response, body: html });
      });
      await live.goto('http://127.0.0.1/profil_risiko_v2/admin/laporan/cetak_laporan_profil_risiko.php?id=555', { waitUntil: 'domcontentloaded' });
      await live.waitForSelector('.section-content table.inheren-keterangan-rowspan', { timeout: 60000 });
      const merged = await live.locator('.section-content table.inheren-keterangan-rowspan').first().evaluate(table => {
        const first = table.querySelector('.inheren-keterangan-merged');
        const rows = Array.from(first.parentElement.parentElement.rows);
        const start = rows.indexOf(first.parentElement);
        const last = rows[start + first.rowSpan - 1];
        return { span: first.rowSpan, lastLabel: last.cells[1].textContent.trim(),
          groupHeight: first.getBoundingClientRect().height, mainHeight: first.parentElement.getBoundingClientRect().height,
          aligned: Math.abs(first.getBoundingClientRect().bottom - last.getBoundingClientRect().bottom) < 2 };
      });
      assert.equal(merged.span, liquidity ? 2 : 8);
      assert(merged.lastLabel.startsWith(liquidity ? 'a.' : 'g.'));
      assert(merged.aligned && merged.mainHeight < merged.groupHeight);
      console.log('PASS: live inheren print', riskTitle, JSON.stringify(merged));
      const allGroups = await live.evaluate(() => ({
        expected: window.__creditExpectedGroups,
        actual: Array.from(document.querySelectorAll('.section-content table.inheren-keterangan-rowspan .inheren-keterangan-merged')).map(cell => ({
          no: cell.parentElement.cells[0].textContent.trim(), span: cell.rowSpan,
        })),
      }));
      assert(allGroups.expected.length > 4, 'Expected all risk pillars to be exercised');
      assert.deepEqual(allGroups.actual, allGroups.expected, 'All live parameters must merge through their last subparameter');
      console.log('PASS: all live parameter groups:', riskTitle, JSON.stringify(allGroups.actual));
      const grid = await live.locator('.section-content table.inheren-keterangan-rowspan').first().evaluate(table => {
        const errors = [];
        Array.from(table.tBodies).forEach(body => {
          const occupied = [];
          Array.from(body.rows).forEach((row, index) => {
            let column = 0;
            Array.from(row.cells).forEach(cell => {
              while ((occupied[column] || 0) > 0) column++;
              for (let j = 0; j < cell.colSpan; j++) occupied[column + j] = cell.rowSpan;
              column += cell.colSpan;
            });
            const count = occupied.filter(span => span > 0).length;
            if (count !== 6) errors.push({ row: index, columns: count,
              label: row.cells[1]?.textContent.trim().slice(0, 70),
              spans: Array.from(row.cells).map(cell => cell.colSpan) });
            for (let j = 0; j < occupied.length; j++) occupied[j] = Math.max(0, (occupied[j] || 0) - 1);
          });
        });
        const sector = Array.from(table.rows).find(row => row.cells[1]?.textContent.includes('Kredit yang berasal dari 3 sektor terbesar'));
        return { errors, sectorColumns: sector ? Array.from(sector.cells).map(cell => cell.colSpan) : null };
      });
      assert.deepEqual(grid.errors, [], 'The entire inheren table must occupy exactly six compact logical columns');
      if (!liquidity) assert.deepEqual(grid.sectorColumns, [1, 1, 1, 1, 1], 'Sector detail grid must retain all value-column borders');
      console.log('PASS: compact six-column grid across all credit rows and sector detail');
      await live.evaluate(title => {
        document.querySelectorAll('.cover,.pernyataan-page').forEach(el => el.remove());
        document.querySelectorAll('.print-section').forEach(el => {
          if (!el.dataset.title.includes(title)) el.remove();
        });
      }, liquidity ? 'Likuiditas - Inheren' : 'Kredit - Inheren');
      await live.emulateMedia({ media: 'print' });
      const output = path.join(os.tmpdir(), liquidity ? 'profil-risiko-liquidity-rowspan.pdf' : 'profil-risiko-credit-rowspan.pdf');
      await live.pdf({ path: output, preferCSSPageSize: true, printBackground: true });
      console.log('PDF preview:', output);
      await context.request.get('http://127.0.0.1/profil_risiko_v2/admin/logout.php', { maxRedirects: 0 });
      await context.close();
    }
  } finally { await browser.close(); }
})().catch(error => { console.error(error); process.exitCode = 1; });
