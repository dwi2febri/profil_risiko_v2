// Node 22+ and a local Chrome installation. --gemini performs one real AI request.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const os = require('node:os');
const { spawn, execFileSync } = require('node:child_process');
const root = path.resolve(__dirname, '..');
const base = 'http://127.0.0.1/profil_risiko_v2/';
const artifacts = path.join(root, '.local/monitoring-review');
const started = Date.now();
fs.mkdirSync(artifacts, { recursive: true });
const delay = ms => new Promise(resolve => setTimeout(resolve, ms));

function login(role) {
  const php = `<?php
require getcwd().'/conn/conn.php';
$role=${JSON.stringify(role)};
$safe=mysqli_real_escape_string($conn,$role);
$account=mysqli_fetch_assoc(mysqli_query($conn,"SELECT username,password FROM user WHERE tipe='$safe' ORDER BY user_id LIMIT 1"));
if(!$account)throw new RuntimeException('Missing local test account');
$file=tempnam(sys_get_temp_dir(),'monitoring-browser-');$c=curl_init('${base}index.php');
curl_setopt_array($c,[CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>http_build_query($account),CURLOPT_RETURNTRANSFER=>true,CURLOPT_COOKIEJAR=>$file,CURLOPT_TIMEOUT=>15]);
curl_exec($c);$status=curl_getinfo($c,CURLINFO_HTTP_CODE);$cookies=curl_getinfo($c,CURLINFO_COOKIELIST);curl_close($c);unset($c);
if($status!==302)throw new RuntimeException('Login failed');
$cookie='';foreach($cookies as $line){$p=explode(chr(9),trim($line));if(count($p)>=7&&$p[5]==='PHPSESSID')$cookie=$p[6];}
unlink($file);echo json_encode(['cookie'=>$cookie]);`;
  const result = JSON.parse(execFileSync('php', [], { cwd: root, input: php, encoding: 'utf8' }));
  assert(result.cookie, 'Test session not created');
  return result.cookie;
}

(async () => {
  assert.equal((await fetch(base + 'admin/monitoring_api.php')).status, 401, 'Unauthenticated API request allowed');
  assert.equal((await fetch(base + '.local/gemini.json')).status, 403, 'Private configuration is accessible over HTTP');
  const nonAdmin = login('admin kc');
  assert.equal((await fetch(base + 'admin/monitoring_api.php', { headers: { Cookie: 'PHPSESSID=' + nonAdmin } })).status, 401, 'Non-admin monitoring access allowed');
  await fetch(base + 'admin_kc/logout.php', { headers: { Cookie: 'PHPSESSID=' + nonAdmin } });
  const cookie = login('admin');
  const headers = { Cookie: 'PHPSESSID=' + cookie };
  assert.equal((await fetch(base + 'admin/monitoring_api.php?start_year=2027&end_year=2025', { headers })).status, 422, 'Invalid range accepted');
  assert.equal((await fetch(base + 'admin/monitoring_api.php?action=recommend', { method: 'POST', headers: { ...headers, 'Content-Type': 'application/json' }, body: '{}' })).status, 403, 'AI request accepted without CSRF token');
  const secret = JSON.parse(fs.readFileSync(path.join(root, '.local/gemini.json'), 'utf8')).api_key;
  const overview = await (await fetch(base + 'admin/monitoring_api.php', { headers })).text();
  assert(!overview.includes(secret), 'Credential exposed by overview API');
  console.log('PASS API authentication, CSRF, range validation and private configuration');

  const profile = fs.mkdtempSync(path.join(os.tmpdir(), 'monitoring-chrome-'));
  const chrome = spawn(process.env.CHROME_PATH || 'C:/Program Files/Google/Chrome/Application/chrome.exe', [
    '--headless', '--disable-gpu', '--no-sandbox', '--disk-cache-size=1', '--media-cache-size=1', '--disable-background-networking', '--disable-component-update', '--no-first-run', '--hide-scrollbars', '--remote-debugging-port=0', '--user-data-dir=' + profile
  ], { windowsHide: true, stdio: 'ignore' });
  let socket;
  try {
    const portFile = path.join(profile, 'DevToolsActivePort');
    for (let i = 0; i < 100 && !fs.existsSync(portFile); i++) await delay(100);
    assert(fs.existsSync(portFile), 'Chrome debugging endpoint unavailable');
    const port = fs.readFileSync(portFile, 'utf8').split('\n')[0];
    const version = await (await fetch(`http://127.0.0.1:${port}/json/version`)).json();
    socket = new WebSocket(version.webSocketDebuggerUrl);
    await new Promise((resolve, reject) => { socket.onopen = resolve; socket.onerror = reject; });
    let seq = 0;
    const pending = new Map(), runtimeErrors = [];
    socket.onmessage = event => {
      const packet = JSON.parse(event.data);
      if (packet.id && pending.has(packet.id)) {
        const p = pending.get(packet.id); clearTimeout(p.timer); pending.delete(packet.id);
        if (packet.error) p.reject(new Error(packet.error.message)); else p.resolve(packet.result);
      }
      if (packet.method === 'Runtime.exceptionThrown') runtimeErrors.push(packet.params.exceptionDetails);
    };
    const send = (method, params = {}, sessionId) => new Promise((resolve, reject) => {
      const id = ++seq, timer = setTimeout(() => { pending.delete(id); reject(new Error('CDP timeout: ' + method)); }, 20000);
      pending.set(id, { resolve, reject, timer }); socket.send(JSON.stringify({ id, method, params, ...(sessionId ? { sessionId } : {}) }));
    });
    const { targetId } = await send('Target.createTarget', { url: 'about:blank' });
    const { sessionId } = await send('Target.attachToTarget', { targetId, flatten: true });
    const cmd = (method, params) => send(method, params, sessionId);
    const evaluate = async expression => {
      const result = await cmd('Runtime.evaluate', { expression, returnByValue: true, awaitPromise: true });
      if (result.exceptionDetails) throw new Error(result.exceptionDetails.exception?.description || result.exceptionDetails.text);
      return result.result.value;
    };
    const waitFor = async (expression, limit = 20000) => {
      const start = Date.now();
      while (Date.now() - start < limit) { if (await evaluate(expression)) return; await delay(200); }
      if(expression.includes('datatable-buttons1')) {
        console.error('Report browser state:',JSON.stringify(await evaluate(`({url:location.href,jquery:!!window.jQuery,datatable:!!(window.jQuery && jQuery.fn.dataTable),rows:document.querySelectorAll('#datatable-buttons1 tbody tr').length,scripts:document.scripts.length,tail:document.body.textContent.slice(-250)})`)));
        console.error('Report script errors:',JSON.stringify(runtimeErrors.map(error=>({url:error.url,line:error.lineNumber,detail:error.exception?.description?.slice(0,350)||error.text}))));
      }
      throw new Error('Browser condition timed out: ' + expression);
    };
    await cmd('Runtime.enable'); await cmd('Page.enable'); await cmd('Network.enable');
    await cmd('Network.setCookie', { name: 'PHPSESSID', value: cookie, domain: '127.0.0.1', path: '/' });
    await cmd('Emulation.setDeviceMetricsOverride', { width: 1800, height: 1150, deviceScaleFactor: 1, mobile: false });
    await send('Browser.setDownloadBehavior', { behavior: 'allow', downloadPath: artifacts });
    await cmd('Page.navigate', { url: base + 'admin/index.php?page=dashboard' });
    await waitFor(`document.querySelector('.leftside-menu') && document.readyState==='complete'`);
    const referenceScale = await evaluate(`({zoom:getComputedStyle(document.body).zoom,sidebar:document.querySelector('.leftside-menu').getBoundingClientRect().width,header:document.querySelector('.navbar-custom').getBoundingClientRect().height})`);
    await cmd('Page.navigate', { url: base + 'admin/index.php?page=pilih_perumusan' });
    await waitFor(`document.readyState==='complete' && location.pathname.endsWith('/pilih_perumusan')`);
    await waitFor(`document.querySelector('a.oai-active-menu[aria-current="page"][href$="/pilih_perumusan"]')`);
    assert(await evaluate(`document.getElementById('sidebarsetting').classList.contains('show') && document.querySelector('a[href="#sidebarsetting"]').classList.contains('oai-open-parent')`), 'Active setting parent not opened');
    assert(await evaluate(`parseFloat(getComputedStyle(document.querySelector('a.oai-active-menu')).borderLeftWidth)===0 && parseFloat(getComputedStyle(document.querySelector('a.oai-active-menu')).borderTopLeftRadius)>=9`), 'Active submenu must have rounded corners without a left accent');
    await evaluate(`window.scrollTo(0,0)`);
    await delay(1200);
    const sidebarShot = await cmd('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifacts, 'sidebar-active.png'), Buffer.from(sidebarShot.data, 'base64'));
    console.log('PASS settings submenu active indicator and expanded parent');
    if (process.argv.includes('--hasil-kc')) {
      await cmd('Page.navigate', {url:base + 'admin/index.php?page=hasil_lapkc&tahun=2026&periode=1&status_laporan=semua'});
      await waitFor(`window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
      const reportState = await evaluate(`(()=>{const t=jQuery('#datatable-buttons1').DataTable();return {rows:t.rows().count(),visible:t.columns(':visible').indexes().toArray(),columnCount:t.columns().count(),scores:Object.fromEntries(t.columns().indexes().toArray().filter(i=>t.column(i).header().dataset.kind==='score').map(i=>[t.column(i).header().dataset.risk,i])),reputation:t.column('[data-risk="reputasi"][data-kind="score"]').data().toArray(),strategy:t.column('[data-risk="stratejik"][data-kind="score"]').data().toArray()};})()`);
      assert.equal(reportState.rows,11, 'Quarter-one branch report count changed');
      const pillarColors = await evaluate(`['blue','green','yellow','orange','red'].map(color=>{const cell=document.querySelector('#datatable-buttons1 tbody td.hasil-pillar-'+color);return cell?{color,bg:getComputedStyle(cell).backgroundColor,label:cell.getAttribute('aria-label')}:null;})`);
      assert(pillarColors.every(Boolean), 'A pillar risk band is missing');
      assert.equal(new Set(pillarColors.map(item=>item.bg)).size,5,'Pillar risk colors are not visually distinct');
      assert(pillarColors.every(item=>item.label && item.bg!=='rgba(0, 0, 0, 0)'), 'Pillar color or accessible rating label missing');
      assert(await evaluate(`[...document.querySelectorAll('#datatable-buttons1 td.hasil-pillar-cell')].every(cell=>getComputedStyle(cell).boxShadow==='none')`), 'Table striping masks pillar colors');

      assert.deepEqual(reportState.visible,Array.from({length:reportState.columnCount},(_,i)=>i), 'Default must show all risk pillars');
      assert(await evaluate(`!jQuery('#datatable-buttons1').DataTable().settings()[0].oFeatures.bPaginate && document.querySelectorAll('#datatable-buttons1 tbody tr').length===11 && !document.querySelector('#datatable-buttons1_paginate')`), 'All branches must be shown without pagination');
      assert(reportState.reputation.every(cell=>cell.includes('hasil-risk-score')) && reportState.strategy.every(cell=>cell.includes('hasil-risk-score')), 'Stored reputation or strategic risk is missing');
      for (const risk of ['reputasi','stratejik','operasional','likuiditas']) {
        await evaluate(`document.getElementById('hasil-risk-view').value=${JSON.stringify(risk)};jQuery('#hasil-risk-view').trigger('change')`);
        assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().column(${reportState.scores[risk]}).visible()`), 'Risk detail not visible: '+risk);
      }
      await evaluate(`document.getElementById('hasil-risk-view').value='semua';jQuery('#hasil-risk-view').trigger('change');window.scrollTo(0,0)`);
      await delay(1200);
      const reportShot = await cmd('Page.captureScreenshot',{format:'png'});
      fs.writeFileSync(path.join(artifacts,'hasil-kc-overview.png'),Buffer.from(reportShot.data,'base64'));
      assert(await evaluate(`document.documentElement.scrollWidth<=innerWidth+1`), 'Results page overflows horizontally');
      await evaluate(`document.querySelector('.hasil-scroll-top').scrollLeft=450`);
      await delay(250);
      const stickyLayout = await evaluate(`(()=>{const cells=[...document.querySelectorAll('#datatable-buttons1 tbody tr:first-child td')].slice(0,3).map(td=>td.getBoundingClientRect()); const head=document.querySelector('.dataTables_scrollHead th').getBoundingClientRect();const body=cells[0];return {scroll:document.querySelector('.dataTables_scrollBody').scrollLeft,gaps:[cells[1].left-cells[0].right,cells[2].left-cells[1].right],headerOffset:Math.abs(head.left-body.left)};})()`);
      assert(stickyLayout.scroll>0 && stickyLayout.gaps.every(g=>Math.abs(g)<2) && stickyLayout.headerOffset<2, 'Frozen columns overlap or header is misaligned: '+JSON.stringify(stickyLayout));
      const scrollSync = await evaluate(`(async()=>{const top=document.querySelector('.hasil-scroll-top'),body=document.querySelector('.hasil-lapkc-table .dataTables_scrollBody'),head=document.querySelector('.hasil-lapkc-table .dataTables_scrollHead');let events=0;const count=()=>events++;top.addEventListener('scroll',count);body.addEventListener('scroll',count);for(let i=1;i<=12;i++){top.scrollLeft=500+i*47;await new Promise(requestAnimationFrame);}await new Promise(r=>setTimeout(r,100));const forward=Math.abs(top.scrollLeft-body.scrollLeft);body.scrollLeft=240;await new Promise(r=>setTimeout(r,100));const reverse=Math.abs(top.scrollLeft-body.scrollLeft);const settled=events;await new Promise(r=>setTimeout(r,150));top.removeEventListener('scroll',count);body.removeEventListener('scroll',count);return {forward,reverse,header:Math.abs(head.scrollLeft-body.scrollLeft),echoes:events-settled,behavior:getComputedStyle(body).scrollBehavior};})()`);
      assert(scrollSync.forward<1.5 && scrollSync.reverse<1.5 && scrollSync.header<1.5 && scrollSync.echoes===0 && scrollSync.behavior==='auto','Horizontal scroll drifts or keeps echoing: '+JSON.stringify(scrollSync));
      console.log('PASS immediate bidirectional horizontal scrolling without event feedback');

      await cmd('Page.navigate',{url:base+'admin/index.php?page=hasil_lapkc&tahun=2026&periode=2&status_laporan=semua'});
      await waitFor(`window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
      assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows().count()===28 && document.querySelectorAll('#datatable-buttons1 tbody tr').length===28 && jQuery('#datatable-buttons1').DataTable().columns(':visible').count()===jQuery('#datatable-buttons1').DataTable().columns().count()`), 'Quarter two must display all 28 branches and selected pillar columns');

      assert(await evaluate(`['operasional','kepatuhan','reputasi','stratejik'].every(risk=>{const cells=[...document.querySelectorAll('#datatable-buttons1 tbody tr[data-report="545"] td[data-kind="dynamic_pillar"][data-risk="'+risk+'"]')];return cells.length>0 && cells.every(cell=>!cell.textContent.includes('\u2013') && cell.textContent.trim()!=='-');})`), 'Completed report 545 still has missing dynamic pillar values');
      await evaluate(`document.getElementById('hasil-risk-view').value='operasional';jQuery('#hasil-risk-view').trigger('change');document.querySelector('.hasil-lapkc-table').scrollIntoView({block:'start'});`);
      await delay(700);
      const pillarScreenshot = await cmd('Page.captureScreenshot',{format:'png'});
      fs.writeFileSync(path.join(artifacts,'hasil-kc-operational-pillars.png'),Buffer.from(pillarScreenshot.data,'base64'));
      console.log('PASS completed report: operational, compliance, reputation and strategic pillars follow selected checklist');
      await cmd('Emulation.setDeviceMetricsOverride',{width:390,height:1050,deviceScaleFactor:1,mobile:true});
      await delay(700);
      assert(await evaluate(`document.documentElement.scrollWidth<=innerWidth+1`), 'Mobile results page overflows horizontally');
      const mobileReportShot = await cmd('Page.captureScreenshot',{format:'png'});
      fs.writeFileSync(path.join(artifacts,'hasil-kc-mobile.png'),Buffer.from(mobileReportShot.data,'base64'));
      await cmd('Emulation.setDeviceMetricsOverride',{width:1800,height:1150,deviceScaleFactor:1,mobile:false});
      console.log('PASS branch results: six risks, real source links, detail filters and desktop/mobile layout');
    }
    if (process.argv.includes('--rekap')) {
      await cmd('Page.navigate',{url:base+'admin/index.php?page=rekap_cbg&tahun=2026&periode=1&status_laporan=semua'});
      await waitFor(`window.rekapAreaData && window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
      const regionalCheck = await evaluate(`(async()=>{const normalize=dom=>[...dom.querySelectorAll('#datatable-buttons1 tbody tr')].map(row=>({report:row.dataset.report,cells:[...row.querySelectorAll('td')].map(td=>td.textContent.trim().replace(/\\s+/g,' '))}));const html=await (await fetch('index.php?page=hasil_lapkc&tahun=2026&periode=1&status_laporan=semua')).text();const expected=normalize(new DOMParser().parseFromString(html,'text/html'));const actual=normalize(document);return {same:JSON.stringify(expected)===JSON.stringify(actual),rows:actual.length,data:{labels:window.rekapAreaData.labels,datasets:window.rekapAreaData.datasets.map(series=>({label:series.label,data:series.data,counts:series.counts}))}};})()`);
      assert(regionalCheck.same && regionalCheck.rows===11,'Regional table differs from branch results for the same reports');
      assert.equal(regionalCheck.data.datasets.length,6,'Regional chart must show six risks');
      assert(regionalCheck.data.datasets.every(series=>series.data[0]===null && series.data[2]===null),'Region without reports became zero risk');
      assert(regionalCheck.data.datasets.every(series=>series.data[1]>=1 && series.data[3]>=1 && series.counts[1]===4 && series.counts[3]===7),'Regional means use wrong count or old data');
      await evaluate(`document.querySelector('.hasil-region-tabs button[data-region="solo"]').click()`);
      assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows({search:'applied'}).count()===4`),'Solo filter must show four available quarter-one reports');
      await evaluate(`window.rekapAreaChart.options.onClick({},[{_index:3}])`);
      assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows({search:'applied'}).count()===7 && document.querySelector('.hasil-region-tabs button[data-region="pekalongan"]').getAttribute('aria-pressed')==='true'`),'Chart click did not select Pekalongan reports');
      await evaluate(`document.querySelector('.hasil-region-tabs button[data-region="semua"]').click();window.scrollTo(0,0)`);
      await delay(700);
      assert(await evaluate(`document.documentElement.scrollWidth<=innerWidth+1`),'Regional page overflows desktop');
      const regionShot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'rekap-korwil-desktop.png'),Buffer.from(regionShot.data,'base64'));
      await cmd('Emulation.setDeviceMetricsOverride',{width:390,height:1050,deviceScaleFactor:1,mobile:true});await delay(700);
      assert(await evaluate(`document.documentElement.scrollWidth<=innerWidth+1`),'Regional page overflows mobile');
      const regionMobile=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'rekap-korwil-mobile.png'),Buffer.from(regionMobile.data,'base64'));
      await cmd('Emulation.setDeviceMetricsOverride',{width:1800,height:1150,deviceScaleFactor:1,mobile:false});
      await cmd('Page.navigate',{url:base+'admin/index.php?page=rekap_cbg&tahun=2026&periode=2&status_laporan=semua'});
      await waitFor(`window.rekapAreaData && window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
      assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows().count()===28 && !document.querySelector('#datatable-buttons1_paginate') && [...document.querySelectorAll('#datatable-buttons1 tr[data-report="545"] td[data-kind="dynamic_pillar"]')].length===16`),'Quarter-two regional recap lost branches or selected pillars');
      await cmd('Page.navigate',{url:base+'admin/index.php?page=rekap_cbg&tahun=2026&periode=2&status_laporan=diterima'});
      await waitFor(`window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
      assert(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows().count()===0 && !document.getElementById('chart1')`),'Receipt filter mixed pending reports or fabricated chart values');
      console.log('PASS regional recap: same branch data and selected pillars, regional averages, chart selection, receipt filtering and desktop/mobile layout');
    }
    await cmd('Page.navigate', { url: base + 'admin/index.php?page=dashboard_monitoring' });
    await waitFor(`document.getElementById('monitoring-app')?.getAttribute('aria-busy')==='false' && document.getElementById('mon-kpi-attention')?.textContent!=='—'`);
    assert(await evaluate(`document.querySelectorAll('#monitoring-app .apexcharts-svg').length===3`), 'Charts did not render');
    assert(await evaluate(`document.querySelectorAll('.mon-risk-card').length===6 && document.querySelectorAll('.mon-region-name').length===4`));
    assert(await evaluate(`document.body.textContent.indexOf('Dashboard Monitoring')<document.body.textContent.indexOf('Dashboard Kantor Pusat')`), 'Monitoring navigation is not first');
    assert(!(await evaluate(`document.documentElement.outerHTML.includes(${JSON.stringify(secret)})`)), 'Credential exposed in HTML');
    const monitoringScale = await evaluate(`({zoom:getComputedStyle(document.body).zoom,sidebar:document.querySelector('.leftside-menu').getBoundingClientRect().width,header:document.querySelector('.navbar-custom').getBoundingClientRect().height})`);
    assert.deepEqual(monitoringScale, referenceScale, 'Monitoring scale, sidebar or header differs from regular dashboard');
    console.log('PASS monitoring matches regular dashboard scale, sidebar and header');
    console.log('PASS desktop dashboard, three charts, six risks and four regions');
    assert(await evaluate(`getComputedStyle(document.querySelector('.mon-hero')).backgroundColor==='rgb(255, 255, 255)' && getComputedStyle(document.querySelector('.mon-hero')).backgroundImage==='none'`),'Monitoring header should be white');
    await evaluate(`document.getElementById('mon-region').value='solo';document.getElementById('mon-region').dispatchEvent(new Event('change'));document.getElementById('mon-filter-form').requestSubmit()`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && location.search.includes('region=solo')`);
    assert(await evaluate(`[...document.querySelectorAll('.mon-risk-card>small:first-of-type')].every(node=>node.textContent.includes('Solo')) && document.querySelector('#mon-branch option[value="1"]').disabled`),'Regional cards or branch options do not follow region');
    await evaluate(`document.getElementById('mon-branch').value='8';document.getElementById('mon-branch').dispatchEvent(new Event('change'));document.getElementById('mon-filter-form').requestSubmit()`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && new URLSearchParams(location.search).get('branch')==='8'`);
    const branchCards = await evaluate(`(async()=>{const payload=await (await fetch('monitoring_api.php?'+location.search.slice(1))).json();const number=new Intl.NumberFormat('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2});return {one:payload.summary.branchReports===1,match:payload.risks.every((r,i)=>document.querySelectorAll('.mon-risk-card>strong')[i].textContent===(r.selectedMetrics.inheren===null?'\u2014':number.format(r.selectedMetrics.inheren))),labels:[...document.querySelectorAll('.mon-risk-card>small:first-of-type')].every(el=>el.textContent.toLowerCase().includes('wonogiri'))};})()`);
    assert(branchCards.one && branchCards.match && branchCards.labels,'Main branch cards do not match selected-branch scores');
    await evaluate(`window.scrollTo(0,0)`);await delay(300);
    const whiteHeader=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'monitoring-white-branch-filter.png'),Buffer.from(whiteHeader.data,'base64'));
    await evaluate(`document.getElementById('mon-branch').value='0';document.getElementById('mon-branch').dispatchEvent(new Event('change'));document.getElementById('mon-region').value='semua';document.getElementById('mon-region').dispatchEvent(new Event('change'));document.getElementById('mon-priority-scope').value='wilayah';document.getElementById('mon-priority-branch').value='0';document.getElementById('mon-filter-form').requestSubmit()`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && document.querySelectorAll('.mon-region-name').length===4`);
    console.log('PASS white header, main branch filter, regional/branch card values and compatible branch options');

    await evaluate(`document.getElementById('mon-priority-scope').value='cabang';document.getElementById('mon-priority-scope').dispatchEvent(new Event('change',{bubbles:true}))`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && document.getElementById('mon-priority-value-title').textContent==='Nilai cabang'`);
    assert(await evaluate(`!document.getElementById('mon-priority-branch').disabled && [...document.querySelectorAll('#mon-priority-body tr td:nth-child(2)')].every(td=>td.textContent.includes('Kc.')||td.textContent.includes('KC.'))`), 'Per-branch priority view does not identify offices');
    await evaluate(`document.getElementById('mon-priority-branch').value='8';document.getElementById('mon-priority-branch').dispatchEvent(new Event('change',{bubbles:true}))`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && location.search.includes('priority_branch=8')`);
    assert(await evaluate(`[...document.querySelectorAll('#mon-priority-body tr td:nth-child(2)')].every(td=>td.textContent.toLowerCase().includes('wonogiri'))`),'Selected branch priorities include another office');
    await evaluate(`const panel=document.querySelector('.mon-priority-panel');window.scrollTo(0,Math.max(0,scrollY+panel.getBoundingClientRect().top-100))`);
    await delay(300);
    const branchShot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'monitoring-per-cabang.png'),Buffer.from(branchShot.data,'base64'));
    await evaluate(`document.querySelector('.mon-detail-btn').click()`);
    assert(await evaluate(`document.querySelectorAll('.mon-drawer-report').length===1 && document.querySelector('.mon-drawer-report h3').textContent.toLowerCase().includes('wonogiri')`),'Branch detail mixed office sources');
    await evaluate(`document.dispatchEvent(new KeyboardEvent('keydown',{key:'Escape',bubbles:true}));document.getElementById('mon-priority-scope').value='wilayah';document.getElementById('mon-priority-scope').dispatchEvent(new Event('change',{bubbles:true}))`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && document.getElementById('mon-priority-value-title').textContent==='Nilai tertinggi'`);
    console.log('PASS regional and individual branch priority views, selected-branch sources and URL filters');


    await evaluate(`document.getElementById('mon-search').value='__tidak_ada_parameter__';document.getElementById('mon-search').dispatchEvent(new Event('input',{bubbles:true}))`);
    assert(await evaluate(`document.getElementById('mon-priority-body').textContent.includes('Tidak ada parameter')`));
    await evaluate(`document.getElementById('mon-search').value='';document.getElementById('mon-search').dispatchEvent(new Event('input',{bubbles:true}));document.getElementById('mon-risk-filter').value='likuiditas';document.getElementById('mon-risk-filter').dispatchEvent(new Event('change',{bubbles:true}))`);
    assert(await evaluate(`[...document.querySelectorAll('#mon-priority-body tr')].every(r=>r.textContent.includes('Likuiditas'))`));
    await evaluate(`document.querySelector('.mon-detail-btn').click()`);
    assert(await evaluate(`!document.getElementById('mon-drawer-overlay').hidden && new RegExp('[/]lik_(inhern|kpmr1)(?:[?]|$)').test(document.querySelector('.mon-drawer-report a').href)`));
    assert(await evaluate(`document.querySelector('.mon-lineage').textContent.includes('pasangan') && document.querySelectorAll('.mon-subparameter').length>0 && document.getElementById('mon-explain')`), 'Detailed source and AI action missing');
    assert(!(await evaluate(`document.querySelector('.mon-lineage').textContent.includes('sekarang ?')`)), 'Broken source math symbols');
    const detailImage = await cmd('Page.captureScreenshot', { format: 'png' });
    fs.writeFileSync(path.join(artifacts, 'parameter-sources.png'), Buffer.from(detailImage.data, 'base64'));
    if (process.argv.includes('--explain')) {
      await evaluate(`document.getElementById('mon-explain').click()`);
      console.log('Waiting for real Gemini subparameter analysis...');
      await waitFor(`!document.getElementById('mon-explain').disabled`, 55000);
      assert(await evaluate(`document.getElementById('mon-parameter-ai').textContent.includes('Analisis Gemini') && document.querySelectorAll('#mon-parameter-ai .mon-recommendation').length>0`), 'Gemini source analysis failed');
      const image = await cmd('Page.captureScreenshot', { format: 'png' });
      fs.writeFileSync(path.join(artifacts, 'parameter-detail.png'), Buffer.from(image.data, 'base64'));
      console.log('PASS real Gemini analysis of source periods, branch contributions and subparameters');
    }
    assert(await evaluate(`document.querySelector('.mon-drawer').scrollWidth <= document.querySelector('.mon-drawer').clientWidth`), 'Source detail overflows horizontally');
    await evaluate(`document.dispatchEvent(new KeyboardEvent('keydown',{key:'Escape',bubbles:true}));document.getElementById('mon-risk-filter').value='semua';document.getElementById('mon-risk-filter').dispatchEvent(new Event('change',{bubbles:true}));document.getElementById('mon-next').click()`);
    assert(await evaluate(`document.getElementById('mon-page-info').textContent.startsWith('11')`));
    await evaluate(`document.getElementById('mon-region').value='solo';document.getElementById('mon-filter-form').requestSubmit()`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && document.querySelectorAll('.mon-region-name').length===1`);
    assert(await evaluate(`document.querySelector('.mon-region-name').textContent.includes('Solo')`));
    await evaluate(`document.getElementById('mon-region').value='semua';document.getElementById('mon-filter-form').requestSubmit()`);
    await waitFor(`document.getElementById('monitoring-app').getAttribute('aria-busy')==='false' && document.querySelectorAll('.mon-region-name').length===4`);
    await evaluate(`document.getElementById('mon-export').click()`);
    let csvFile;
    for (const deadline=Date.now()+10000;Date.now()<deadline && !csvFile;) {
      csvFile=fs.readdirSync(artifacts).filter(name=>name.endsWith('.csv')).map(name=>path.join(artifacts,name)).find(name=>fs.statSync(name).mtimeMs>=started);
      if (!csvFile) await delay(200);
    }
    assert(csvFile, 'New CSV export missing');
    const csv = fs.readFileSync(csvFile, 'utf8');
    assert(!/"'-\d+(?:[.,]\d+)?"/.test(csv), 'Negative numeric delta became spreadsheet text');
    assert(/"\d+,\d+"/.test(csv), 'CSV does not use Indonesian decimal notation');
    console.log('PASS parameter search, risk filter, source drawer, pagination, regional drill-down and CSV export');

    if (process.argv.includes('--gemini')) {
      await evaluate(`document.getElementById('mon-gemini').click()`);
      console.log('Testing real Gemini recommendation…');
      await waitFor(`!document.getElementById('mon-gemini').disabled`, 55000);
      const aiError = await evaluate(`document.getElementById('mon-ai-error').hidden?'':document.getElementById('mon-ai-error').textContent`);
      assert(!aiError, aiError);
      assert(await evaluate(`document.getElementById('mon-ai-source').textContent.startsWith('Gemini') && document.querySelectorAll('details.mon-recommendation').length>0`));
      console.log('PASS real Gemini recommendations rendered');
    }
    for (const [name, width, height] of [['desktop', 1800, 1150], ['tablet', 1024, 1100], ['mobile', 390, 1050]]) {
      await cmd('Emulation.setDeviceMetricsOverride', { width, height, deviceScaleFactor: 1, mobile: width < 600 }); await delay(700);
      await evaluate('window.scrollTo(0,0)'); await delay(200);
      const fit = await evaluate(`({viewport:innerWidth,page:document.documentElement.scrollWidth,app:document.getElementById('monitoring-app').getBoundingClientRect().width,appScroll:document.getElementById('monitoring-app').scrollWidth})`);
      assert(fit.page <= fit.viewport + 1, name + ' horizontal page overflow: ' + JSON.stringify(fit));
      const shot = await cmd('Page.captureScreenshot', { format: 'png', captureBeyondViewport: false });
      fs.writeFileSync(path.join(artifacts, name + '.png'), Buffer.from(shot.data, 'base64'));
      console.log('PASS responsive', name, width + 'px');
    }
    const ownErrors = runtimeErrors.filter(e => JSON.stringify(e).includes('dashboard-monitoring.js'));
    assert.equal(ownErrors.length, 0, 'Monitoring JavaScript runtime errors');
    console.log('Review screenshots:', artifacts);
    await send('Browser.close');
  } finally {
    if (socket) socket.close();
    chrome.kill();
    await delay(500);
    if (path.dirname(path.resolve(profile)) === path.resolve(os.tmpdir()) && path.basename(profile).startsWith('monitoring-chrome-')) {
      try { fs.rmSync(profile, {recursive:true,force:true,maxRetries:3,retryDelay:300}); } catch (_) { /* A browser child may still hold a temporary file. */ }
    }
    await fetch(base + 'admin/logout.php', { headers });
  }
})().catch(error => { console.error(error.message); process.exitCode = 1; });
