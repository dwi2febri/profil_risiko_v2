(() => {
  'use strict';
  document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('monitoring-app');
    if (!app) return;
    const config = window.MONITORING_CONFIG;
    const $ = id => document.getElementById(id);
    const form = $('mon-filter-form');
    const charts = {};
    const number = new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    const integer = new Intl.NumberFormat('id-ID');
    const precise = value => value === null || value === undefined ? '-' : new Intl.NumberFormat('id-ID', {minimumFractionDigits: 3, maximumFractionDigits: 3}).format(value);
    const esc = value => String(value ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const fmt = value => value === null || value === undefined ? '—' : number.format(value);
    const text = (id, value) => { $(id).textContent = value; };
    const band = value => value === null ? 'mon-band-empty' : value >= 4 ? 'mon-band-4' : value >= 3 ? 'mon-band-3' : value >= 2 ? 'mon-band-2' : 'mon-band-1';
    const delta = value => value === null ? 'Belum ada pembanding' : (value > 0.005 ? '+' : '') + fmt(value);
    const deltaClass = value => value === null || Math.abs(value) < 0.005 ? 'mon-delta-flat' : value > 0 ? 'mon-delta-up' : 'mon-delta-down';
    let data = null, page = 1, trendMetric = 'composite', displayMetric = 'inheren';
    let controller = null, aiController = null, version = 0, opener = null, oldOverflow = '';
    const pageSize = 10;

    function filters() { return Object.fromEntries(new FormData(form)); }
    function errorBox(id, message) { text(id, message); $(id).hidden = !message; }
    function setBusy(busy) {
      app.setAttribute('aria-busy', String(busy));
      $('mon-loading').hidden = !busy;
      $('mon-apply').disabled = busy;
      $('mon-refresh').disabled = busy;
      $('mon-gemini').disabled = busy || !data;
      $('mon-export').disabled = busy || !data;
    }
    async function responseJson(response) {
      let value;
      try { value = await response.json(); } catch (_) { throw new Error('Respons server tidak dapat dibaca. Muat ulang halaman.'); }
      if (!response.ok) throw new Error(value.error || 'Permintaan belum berhasil.');
      return value;
    }
    async function load() {
      if (controller) controller.abort();
      if (aiController) aiController.abort();
      closeDrawer();
      controller = new AbortController();
      const active = ++version;
      setBusy(true); errorBox('mon-error', ''); errorBox('mon-ai-error', '');
      $('mon-gemini').innerHTML = '<i class="mdi mdi-auto-fix" aria-hidden="true"></i> Analisis dengan Gemini';
      try {
        const url = new URL(config.endpoint, location.href);
        Object.entries(filters()).forEach(([key, value]) => url.searchParams.set(key, value));
        const next = await responseJson(await fetch(url, { signal: controller.signal, credentials: 'same-origin', cache: 'no-store' }));
        if (active !== version) return;
        data = next; page = 1;
        $('mon-priority-scope').value = data.filters.priority_scope;
        $('mon-priority-branch').value = String(data.filters.priority_branch);
        syncBranchControls();
        const visibleUrl = new URL(location.href);
        visibleUrl.search = new URLSearchParams({ ...(window.simproRouteConfig ? {} : { page: 'dashboard_monitoring' }), ...filters() }).toString();
        history.replaceState(null, '', visibleUrl);
        renderSummary(); renderRisks(); renderHeatmap(); renderPriorities(); renderQuality(); renderRecommendations();
        await Promise.all([renderTrend(), renderRiskChart(), renderReceipt()]);
      } catch (error) {
        if (error.name === 'AbortError') return;
        if (active !== version) return;
        data = null;
        errorBox('mon-error', error.message);
        ['mon-kpi-score', 'mon-kpi-attention', 'mon-kpi-coverage', 'mon-kpi-region'].forEach(id => text(id, '—'));
        text('mon-profile-label', 'Analisis belum tersedia'); text('mon-period-label', 'Periksa filter dan coba kembali');
        text('mon-updated', 'Pembaruan belum berhasil');
        $('mon-risk-cards').replaceChildren(); $('mon-heatmap').replaceChildren();
        $('mon-priority-body').innerHTML = '<tr><td colspan="5" class="mon-empty">Data belum dapat dimuat.</td></tr>';
        $('mon-recommendations').replaceChildren();
        Object.keys(charts).forEach(key => { charts[key].destroy(); delete charts[key]; });
      } finally { if (active === version) setBusy(false); }
    }

    function renderSummary() {
      const s = data.summary;
      text('mon-profile-label', data.profileName); text('mon-period-label', data.periodLabel);
      text('mon-updated', 'Diperbarui ' + new Date(data.generatedAt).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' }));
      text('mon-kpi-score', fmt(s.score)); text('mon-kpi-score-note', data.primaryPeriod ? `${data.primaryPeriod} · ${s.primaryScored}/${s.primaryReports} nilai tersedia` : 'Belum ada laporan profil pilihan');
      $('mon-score-fill').style.width = (s.score === null ? 0 : Math.min(100, s.score / 5 * 100)) + '%';
      text('mon-kpi-attention', integer.format(s.attention)); text('mon-kpi-high', integer.format(s.high) + ' prioritas tinggi · nilai ≥ 4');
      text('mon-kpi-attention-note', 'Dari ' + integer.format(s.monitoredParameters) + ' kelompok parameter terpantau');
      const coverage = s.expectedBranches ? Math.round(s.completeBranches / s.expectedBranches * 100) : 0;
      text('mon-kpi-coverage', coverage + '%'); text('mon-kpi-coverage-note', `${s.completeBranches} / ${s.expectedBranches} cabang · enam risiko inheren`);
      $('mon-coverage-fill').style.width = coverage + '%';
      const focus = data.regions.filter(r => r.score !== null).sort((a, b) => b.score - a.score)[0];
      text('mon-kpi-region', focus ? focus.name : 'Belum dinilai');
      text('mon-kpi-region-note', focus ? (data.selection.mode === 'branch' ? 'Komposit cabang terpilih ' : 'Rata-rata komposit KC ') + fmt(focus.score) : 'Belum ada indeks komposit KC yang valid');
      text('mon-received', integer.format(s.received)); text('mon-pending', integer.format(s.pending));
      text('mon-receipt-period', data.branchPeriod || 'Belum ada laporan');
      text('mon-region-period', data.branchPeriod || 'Belum ada laporan');
    }
    function renderRisks() {
      const selected = $('mon-risk-filter').value;
      $('mon-risk-cards').innerHTML = data.risks.map(r => {
        const scoped = data.selection.mode !== 'profile';
        const value = r.selectedMetrics[displayMetric];
        const change = r.selectedChanges[displayMetric];
        const comparison = scoped ? r[displayMetric === 'composite' ? 'score' : displayMetric] : r.branchMetrics[displayMetric];
        return `<button type="button" class="mon-risk-card ${selected === r.key ? 'active' : ''}" data-risk="${esc(r.key)}" aria-pressed="${selected === r.key}">
          <span>${esc(r.name)}</span><strong>${fmt(value)}</strong><small>${esc(displayMetric === 'composite' ? 'Komposit' : displayMetric === 'kpmr' ? 'KPMR' : 'Risiko inheren')} &middot; ${esc(data.selection.label)}</small>
          <div class="mon-risk-line"><span>${scoped ? 'Pembanding profil pilihan' : 'Rata-rata KC'}</span><b>${fmt(comparison)}</b></div>
          <small class="${deltaClass(change)}">${esc(delta(change))}${change !== null ? ' · sampel sama' : ''}</small></button>`;
      }).join('');
      $('mon-risk-cards').querySelectorAll('[data-risk]').forEach(button => button.addEventListener('click', () => {
        $('mon-risk-filter').value = $('mon-risk-filter').value === button.dataset.risk ? 'semua' : button.dataset.risk;
        page = 1; renderRisks(); renderPriorities();
        $('mon-priority-body').closest('article').scrollIntoView({ behavior: 'smooth', block: 'start' });
      }));
    }
    function renderHeatmap() {
      const short = ['Kredit', 'Ops', 'Kep', 'Lik', 'Rep', 'Stra'];
      const headers = '<span class="mon-heat-head">Wilayah</span>' + data.risks.map((r, i) => `<span class="mon-heat-head" title="${esc(r.name)}">${short[i]}</span>`).join('');
      $('mon-heatmap').innerHTML = headers + data.regions.map(region => `<button type="button" class="mon-region-name" data-region="${esc(region.key)}">${esc(region.name)}<small>${region.reports} laporan<br>${region.assessed} / ${region.expected} inheren lengkap</small></button>` + region.risks[displayMetric].map((value, i) =>
        `<button type="button" class="mon-heat-cell ${band(value)}" data-region="${esc(region.key)}" data-risk="${esc(data.risks[i].key)}" aria-label="${esc(region.name + ', ' + data.risks[i].name + ', nilai ' + fmt(value))}" title="${esc(data.risks[i].name)} · ${esc(region.name)}: ${fmt(value)}">${fmt(value)}</button>`).join('')).join('');
      $('mon-heatmap').querySelectorAll('[data-region]').forEach(button => button.addEventListener('click', () => {
        $('mon-region').value = button.dataset.region;
        syncBranchControls();
        if (button.dataset.risk) $('mon-risk-filter').value = button.dataset.risk;
        load();
      }));
    }
    const chartBase = () => ({
      chart: { fontFamily: 'inherit', toolbar: { show: false }, animations: { enabled: !matchMedia('(prefers-reduced-motion: reduce)').matches } },
      dataLabels: { enabled: false }, grid: { borderColor: '#edf1f7', strokeDashArray: 4 },
      tooltip: { theme: 'light' }, noData: { text: 'Belum ada nilai pada filter ini', style: { color: '#91a0b4', fontSize: '11px' } },
      legend: { fontSize: '10px', labels: { colors: '#8392a7' }, markers: { width: 7, height: 7, radius: 7 } }
    });
    async function chart(id, options) {
      if (typeof ApexCharts === 'undefined') { $(id).innerHTML = '<div class="mon-chart-empty">Grafik belum termuat. Silakan muat ulang halaman.</div>'; return; }
      if (charts[id]) await charts[id].updateOptions(options, true, false);
      else { charts[id] = new ApexCharts($(id), options); await charts[id].render(); }
    }
    async function renderTrend() {
      const mainName = Number(data.filters.profile) === 3 ? 'Rata-rata KC' : 'Profil pilihan';
      let series = [{ name: mainName, data: data.timeline.map(p => p.primary[trendMetric]) }];
      for (const region of data.regions) {
        series.push({ name: data.selection.mode === 'branch' ? data.selection.label : region.name, data: data.timeline.map(p => p.regions[region.key]?.[trendMetric] ?? null) });
      }
      if (!series.some(s => s.data.some(v => v !== null))) series = [];
      const base = chartBase();
      await chart('mon-trend-chart', { ...base, chart: { ...base.chart, type: 'line', height: 300 }, series,
        colors: ['#284c86', '#139b8b', '#8b7bb7', '#d6a04b', '#65a4d4'], stroke: { width: [3, 2, 2, 2, 2], curve: 'straight' },
        markers: { size: 4, strokeWidth: 2, hover: { size: 6 } }, xaxis: { categories: data.timeline.map(p => p.period), labels: { style: { colors: '#8f9caf', fontSize: '10px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { min: 1, max: 5, tickAmount: 4, labels: { style: { colors: '#99a5b6', fontSize: '10px' }, formatter: v => v.toFixed(0) } },
        tooltip: { shared: true, intersect: false, y: { formatter: (v, info) => {
          const point = data.timeline[info?.dataPointIndex];
          const region = data.regions[(info?.seriesIndex ?? 0) - 1];
          const count = info?.seriesIndex === 0 ? point?.primaryValueCounts[trendMetric] : point?.regionValueCounts[region?.key]?.[trendMetric];
          return fmt(v) + (count === undefined ? '' : ' · ' + count + ' laporan');
        } } }, legend: { ...base.legend, position: 'bottom', horizontalAlign: 'left' } });
    }
    async function renderRiskChart() {
      const primaryValues = data.risks.map(r => r[displayMetric === 'composite' ? 'score' : displayMetric]);
      const branchValues = data.risks.map(r => r.branchMetrics[displayMetric]);
      let series = [{ name: 'Profil pilihan', data: primaryValues }, { name: 'Rata-rata KC', data: branchValues }];
      if (![...primaryValues, ...branchValues].some(v => v !== null)) series = [];
      const base = chartBase();
      await chart('mon-risk-chart', { ...base, chart: { ...base.chart, type: 'bar', height: 300,
        events: { dataPointSelection: (_event, _context, selection) => { const risk = data.risks[selection.dataPointIndex]; if (!risk) return; $('mon-risk-filter').value = risk.key; page = 1; renderRisks(); renderPriorities(); } } },
        series, colors: ['#4369aa', '#a5d9d0'], plotOptions: { bar: { horizontal: true, barHeight: '50%', borderRadius: 3 } },
        xaxis: { categories: data.risks.map(r => r.name), min: 0, max: 5, tickAmount: 5, labels: { style: { colors: '#95a2b5', fontSize: '10px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
        yaxis: { labels: { style: { colors: '#71869f', fontSize: '10px' } } }, tooltip: { y: { formatter: v => fmt(v) } }, legend: { ...base.legend, horizontalAlign: 'left' } });
      text('mon-comparison-note', `Profil: ${data.primaryPeriod || 'belum ada laporan'} · KC: ${data.branchPeriod || 'belum ada laporan'}. Nilai kosong tetap ditampilkan sebagai kosong.`);
    }
    async function renderReceipt() {
      const s = data.summary, base = chartBase();
      await chart('mon-receipt-chart', { ...base, chart: { ...base.chart, type: 'donut', height: 248 },
        series: s.branchReports ? [s.received, s.pending] : [], labels: ['Diterima', 'Belum diterima'], colors: ['#16a38f', '#e7edf5'],
        stroke: { width: 0 }, legend: { show: false }, tooltip: { y: { formatter: v => integer.format(v) + ' laporan' } },
        plotOptions: { pie: { donut: { size: '79%', labels: { show: true, name: { fontSize: '10px', color: '#95a3b5' }, value: { fontSize: '28px', fontWeight: 700, color: '#2d496b' },
          total: { show: true, showAlways: true, label: 'Laporan KC', color: '#9aa7b8', fontSize: '11px', formatter: () => String(s.branchReports) } } } } } });
    }

    function visiblePriorities() {
      if (!data) return [];
      const term = $('mon-search').value.trim().toLocaleLowerCase('id');
      const risk = $('mon-risk-filter').value, severity = $('mon-severity-filter').value;
      return data.priorities.filter(p => (risk === 'semua' || p.risk === risk)
        && (severity === 'semua' || (severity === 'tinggi' ? p.severity === 'tinggi' : p.delta !== null && p.delta > 0.005))
        && (!term || [p.name, p.pillar, p.scopeLabel, p.kind, p.risk].join(' ').toLocaleLowerCase('id').includes(term)));
    }
    function renderPriorities() {
      text('mon-priority-value-title', data.filters.priority_scope === 'cabang' ? 'Nilai cabang' : 'Nilai tertinggi');
      const all = visiblePriorities();
      const last = Math.max(1, Math.ceil(all.length / pageSize));
      page = Math.min(page, last);
      const start = (page - 1) * pageSize, rows = all.slice(start, start + pageSize);
      text('mon-priority-count', integer.format(data.priorities.length));
      $('mon-priority-body').innerHTML = rows.length ? rows.map(p => `<tr>
        <td data-label="Parameter"><strong>${esc(p.name)}</strong><small>${esc(data.options.risks[p.risk])} · ${esc(p.kind)} · ${esc(p.pillar)}</small></td>
        <td data-label="Wilayah / cabang">${esc(p.scopeLabel)}<small>${p.affected} / ${p.coverage} penilaian ≥ 3</small></td>
        <td data-label="${data.filters.priority_scope === 'cabang' ? 'Nilai cabang' : 'Nilai tertinggi'}"><span class="mon-value-badge ${band(p.score)}">${fmt(p.score)}</span><small>${data.filters.priority_scope === 'cabang' ? esc(p.branches[0]?.period || '') : 'Rerata ' + fmt(p.average)}</small></td>
        <td data-label="Perubahan" class="${deltaClass(p.delta)}">${esc(delta(p.delta))}</td>
        <td data-label="Detail"><button type="button" class="mon-detail-btn" data-key="${esc(p.key)}" aria-label="Detail ${esc(p.name)}">↗</button></td></tr>`).join('')
        : '<tr><td colspan="5" class="mon-empty">Tidak ada parameter yang sesuai filter perhatian ini.</td></tr>';
      text('mon-page-info', all.length ? `${start + 1}–${Math.min(start + pageSize, all.length)} dari ${integer.format(all.length)} parameter` : '0 parameter');
      $('mon-prev').disabled = page <= 1; $('mon-next').disabled = page >= last;
      $('mon-priority-body').querySelectorAll('[data-key]').forEach(button => button.addEventListener('click', () => openDrawer(button.dataset.key, button)));
    }
    function renderQuality() {
      const notes = data.quality.length ? data.quality : ['Laporan pada cakupan aktif memiliki data yang dapat digunakan untuk analisis.'];
      $('mon-quality-list').innerHTML = notes.map(note => `<li>${esc(note)}</li>`).join('');
    }
    function renderRecommendations(result = null) {
      const suggestions = result ? result.priorities : data.suggestions;
      text('mon-ai-source', result ? 'Gemini · ' + new Date(result.createdAt).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + (result.cached ? ' · tersimpan' : '') : 'Panduan awal · berbasis indikator');
      $('mon-recommendations').innerHTML = (result ? `<p class="mon-ai-summary">${esc(result.summary)}</p>` : '') +
        (suggestions.length ? suggestions.map((item, i) => `<details class="mon-recommendation" ${i < 2 ? 'open' : ''}><summary><h3>${i + 1}. ${esc(item.title)}</h3></summary>
          <p class="mon-evidence">${esc(item.evidence)}</p><ul>${item.actions.map(action => `<li>${esc(action)}</li>`).join('')}</ul>
          <footer><span>PIC usulan: ${esc(item.owner)}</span><span>${esc(item.timeframe)}</span></footer></details>`).join('')
          : '<p class="mon-ai-summary">Belum ada parameter yang melewati ambang perhatian. Tinjau catatan kualitas data sebelum menarik kesimpulan.</p>') +
        (result && result.data_quality.length ? `<div class="mon-recommendation"><h3>Keterbatasan analisis</h3><ul>${result.data_quality.map(note => `<li>${esc(note)}</li>`).join('')}</ul></div>` : '');
    }
    async function recommend() {
      if (!data) return;
      const active = version;
      aiController = new AbortController();
      errorBox('mon-ai-error', ''); $('mon-gemini').disabled = true;
      $('mon-gemini').textContent = 'Gemini sedang menyusun analisis…';
      try {
        const url = new URL(config.endpoint, location.href); url.searchParams.set('action', 'recommend');
        const result = await responseJson(await fetch(url, { method: 'POST', credentials: 'same-origin', signal: aiController.signal,
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': config.csrf }, body: JSON.stringify(data.filters) }));
        if (active === version) renderRecommendations(result);
      } catch (error) { if (error.name !== 'AbortError' && active === version) errorBox('mon-ai-error', error.message); }
      finally { if (active === version) { $('mon-gemini').disabled = false; $('mon-gemini').innerHTML = '<i class="mdi mdi-auto-fix" aria-hidden="true"></i> Analisis dengan Gemini'; } }
    }
    function openDrawer(key, trigger) {
      const p = data.priorities.find(item => item.key === key); if (!p) return;
      opener = trigger;
      const routes = { kredit: 'kre', likuiditas: 'lik', operasional: 'op', kepatuhan: 'kep', reputasi: 'rep', stratejik: 'stra' };
      const suffix = p.kind === 'KPMR' ? '_kpmr1' : ['kredit', 'likuiditas'].includes(p.risk) ? '_inhern' : '_inhern1';
      const reportLink = (id, label) => `<a href="index.php?page=${routes[p.risk] + suffix}&amp;id=${Number(id)}" target="_blank" rel="noopener">${esc(label)} &#8599;</a>`;
      const source = item => `${item.table}.${item.field}${item.row ? ' - baris #' + item.row : ''}`;
      $('mon-drawer-content').innerHTML = `<h2 id="mon-drawer-title">${esc(p.name)}</h2><p>${esc(p.pillar)}</p><div class="mon-drawer-meta"><span>${esc(data.options.risks[p.risk])} &middot; ${esc(p.kind)}</span><span>${esc(p.scopeLabel)}</span><span>Tertinggi ${fmt(p.score)}</span></div>
        <section class="mon-lineage"><h3>Perubahan berasal dari mana?</h3><p>${p.pairedCount ? `${p.pairedCount} pasangan laporan kantor yang sama: rata-rata ${fmt(p.previous)} &rarr; ${fmt(p.pairedCurrent)}; perubahan ${fmt(p.delta)} poin.` : 'Belum ada laporan pembanding dengan parameter yang sama.'}</p>
        <p>${p.coverage - p.pairedCount} penilaian tanpa pembanding tidak masuk perhitungan perubahan. Nilai tertinggi dan rata-rata seluruh penilaian dapat berbeda dari sampel berpasangan.</p>
        <p>Skor risiko: 1 rendah, 5 tinggi. Kontribusi kantor = (nilai sekarang - sebelumnya) / jumlah pasangan. Rincian subparameter membantu menelusuri skor; bobot dan penyebab operasional perlu diperiksa pada laporan sumber.</p></section>
        <button type="button" class="mon-btn mon-btn-ai" id="mon-explain" ${data.geminiConfigured ? '' : 'disabled'}>Bedah dugaan penyebab dengan Gemini</button>
        <div id="mon-parameter-ai" aria-live="polite"><p>Gemini menerima skor, hierarki subparameter, periode, dan sumber laporan di bawah. Dugaan penyebab perlu dikonfirmasi dengan bukti operasional.</p></div>` +
        [...p.branches].sort((a, b) => Math.abs(b.contribution || 0) - Math.abs(a.contribution || 0) || b.score - a.score).map(branch => `<article class="mon-drawer-report"><h3>${esc(branch.name)}</h3>
          <p>Induk: ${esc(branch.parent)} &middot; ${branch.level === 'sub_parameter' ? 'Subparameter terpilih' : 'Parameter terpilih'}</p>
          <small>${esc(branch.previousPeriod || 'Pembanding tidak tersedia')} &rarr; ${esc(branch.period)}</small>
          <div><span>Sebelum <b>${fmt(branch.previous)}</b> &rarr; sekarang <b>${fmt(branch.score)}</b></span><span>Selisih <b>${fmt(branch.delta)}</b></span></div>
          <p>Kontribusi ke perubahan rata-rata: <b>${precise(branch.contribution)}</b> poin (dibulatkan). ${branch.received ? 'Diterima Korwil &amp; SKMR.' : 'Status penerimaan belum lengkap.'}</p>
          ${reportLink(branch.report, 'Laporan sekarang #' + branch.report)} ${branch.previousReport ? reportLink(branch.previousReport, 'Laporan pembanding #' + branch.previousReport) : ''}
          <details class="mon-breakdown" open><summary>Telusuri parameter dan subparameter (${branch.breakdown.length})</summary>
          ${branch.breakdown.map(item => `<div class="mon-subparameter ${item.selected ? 'mon-selected' : ''}"><h4>${item.level === 'sub_parameter' ? '&#8627; ' : ''}${esc(item.name)}${item.selected ? ' &middot; terpilih' : ''}</h4>
          <p>${fmt(item.previous)} &rarr; ${fmt(item.score)} &middot; selisih ${fmt(item.delta)}</p><small>Sumber sekarang: ${esc(source(item.source))}${item.previousSource ? `<br>Sumber sebelumnya: ${esc(source(item.previousSource))}` : '<br>Nilai pembanding subparameter belum tersedia.'}</small></div>`).join('')}
          ${branch.breakdown.every(item => item.level !== 'sub_parameter') ? '<p>Tidak ada skor subparameter tersimpan yang dapat dipetakan pada induk ini.</p>' : ''}</details></article>`).join('');
      $('mon-explain').addEventListener('click', () => explainParameter(p.key));
      oldOverflow = document.body.style.overflow; document.body.style.overflow = 'hidden';
      $('mon-drawer-overlay').hidden = false; $('mon-drawer-close').focus();
    }
    async function explainParameter(key) {
      const button = $('mon-explain'), box = $('mon-parameter-ai');
      button.disabled = true; button.textContent = 'Gemini menelusuri sumber...';
      try {
        const url = new URL(config.endpoint, location.href); url.searchParams.set('action', 'explain');
        const result = await responseJson(await fetch(url, { method: 'POST', credentials: 'same-origin',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-Token': config.csrf }, body: JSON.stringify({ ...data.filters, parameter_key: key }) }));
        if (!box.isConnected) return;
        box.innerHTML = `<h3>Analisis Gemini &middot; dugaan perlu dikonfirmasi</h3><p>${esc(result.summary)}</p>` + result.priorities.map(item => `<section class="mon-recommendation"><h3>${esc(item.title)}</h3><p><b>Bukti &amp; keterbatasan:</b> ${esc(item.evidence)}</p><ul>${item.actions.map(action => `<li>${esc(action)}</li>`).join('')}</ul><p>Usulan PIC: ${esc(item.owner)} &middot; ${esc(item.timeframe)}</p></section>`).join('') + `<ul>${result.data_quality.map(note => `<li>${esc(note)}</li>`).join('')}</ul>`;
      } catch (error) { if (box.isConnected) box.textContent = error.message; }
      finally { button.disabled = false; button.textContent = 'Bedah dugaan penyebab dengan Gemini'; }
    }
    function closeDrawer() {
      if ($('mon-drawer-overlay').hidden) return;
      $('mon-drawer-overlay').hidden = true; document.body.style.overflow = oldOverflow;
      if (opener && opener.isConnected) opener.focus();
    }
    function exportCsv() {
      const rows = visiblePriorities();
      const cell = value => { const numeric = typeof value === 'number' && Number.isFinite(value); let s = numeric ? String(value).replace('.', ',') : String(value ?? ''); if (!numeric && /^[=+\-@\t\r]/.test(s)) s = "'" + s; return '"' + s.replace(/"/g, '""') + '"'; };
      const contents = [['Parameter', 'Risiko', 'Jenis', 'Wilayah / cabang', 'Nilai tertinggi', 'Rata-rata', 'Perubahan', 'Penilaian perhatian', 'Cakupan'],
        ...rows.map(p => [p.name, data.options.risks[p.risk], p.kind, p.scopeLabel, p.score, p.average, p.delta ?? '', p.affected, p.coverage])].map(row => row.map(cell).join(';')).join('\r\n');
      const url = URL.createObjectURL(new Blob(['\ufeff' + contents], { type: 'text/csv;charset=utf-8' }));
      const a = document.createElement('a'); a.href = url; a.download = 'monitoring-prioritas-risiko.csv'; a.click(); setTimeout(() => URL.revokeObjectURL(url), 1000);
    }
    function syncBranchControls() {
      const region = $('mon-region').value;
      for (const id of ['mon-branch','mon-priority-branch']) {
        const select = $(id);
        [...select.options].forEach(option => {option.disabled = option.value !== '0' && region !== 'semua' && option.dataset.region !== region;});
        if (select.selectedOptions[0]?.disabled) select.value = '0';
      }
      const branch = $('mon-branch').value;
      if (branch !== '0') {
        $('mon-priority-scope').value = 'cabang';
        $('mon-priority-branch').value = branch;
      }
      $('mon-priority-scope').disabled = branch !== '0';
      $('mon-priority-branch').disabled = branch !== '0' || $('mon-priority-scope').value !== 'cabang';
    }
    $('mon-region').addEventListener('change', syncBranchControls);
    $('mon-branch').addEventListener('change', syncBranchControls);
    syncBranchControls();
    form.addEventListener('submit', event => { event.preventDefault(); load(); });
    $('mon-refresh').addEventListener('click', load); $('mon-gemini').addEventListener('click', recommend); $('mon-export').addEventListener('click', exportCsv);
    $('mon-search').addEventListener('input', () => { if (data) { page = 1; renderPriorities(); } });
    $('mon-risk-filter').addEventListener('change', () => { if (data) { page = 1; renderRisks(); renderPriorities(); } });
    $('mon-severity-filter').addEventListener('change', () => { if (data) { page = 1; renderPriorities(); } });
    $('mon-priority-scope').addEventListener('change', () => {
      const perBranch = $('mon-priority-scope').value === 'cabang';
      $('mon-priority-branch').disabled = !perBranch;
      if (!perBranch) $('mon-priority-branch').value = '0';
      load();
    });
    $('mon-priority-branch').addEventListener('change', load);
    $('mon-prev').addEventListener('click', () => { if (data && page > 1) { page--; renderPriorities(); } });
    $('mon-next').addEventListener('click', () => { if (data) { page++; renderPriorities(); } });
    $('mon-trend-segments').querySelectorAll('[data-metric]').forEach(button => button.addEventListener('click', () => {
      trendMetric = button.dataset.metric;
      $('mon-trend-segments').querySelectorAll('button').forEach(b => { const active = b === button; b.classList.toggle('active', active); b.setAttribute('aria-pressed', String(active)); });
      if (data) renderTrend();
    }));
    $('mon-display-metric').addEventListener('change', () => { displayMetric = $('mon-display-metric').value; if (data) { renderRisks(); renderHeatmap(); renderRiskChart(); } });
    $('mon-open-regions').addEventListener('click', () => $('mon-regions-section').scrollIntoView({ behavior: 'smooth', block: 'start' }));
    $('mon-drawer-close').addEventListener('click', closeDrawer);
    $('mon-drawer-overlay').addEventListener('click', event => { if (event.target === $('mon-drawer-overlay')) closeDrawer(); });
    document.addEventListener('keydown', event => {
      if ($('mon-drawer-overlay').hidden) return;
      if (event.key === 'Escape') closeDrawer();
      if (event.key === 'Tab') {
        const nodes = [...$('mon-drawer-overlay').querySelectorAll('button,a[href]')]; const first = nodes[0], last = nodes[nodes.length - 1];
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
      }
    });
    load();
  });
})();
