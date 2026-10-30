// Node 22+ and local Chrome: compact print fixtures across roles and actual PDF preview.
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
  const cookie = login('admin');
  const headers = { Cookie: 'PHPSESSID=' + cookie };

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
      throw new Error('Browser condition timed out: ' + expression);
    };
    await cmd('Runtime.enable'); await cmd('Page.enable'); await cmd('Network.enable');
    await cmd('Network.setCookie', { name: 'PHPSESSID', value: cookie, domain: '127.0.0.1', path: '/' });
    await cmd('Emulation.setDeviceMetricsOverride', { width: 1800, height: 1150, deviceScaleFactor: 1, mobile: false });
    await send('Browser.setDownloadBehavior', { behavior: 'allow', downloadPath: artifacts });

    if(process.argv.includes('--security')) {
      const securityFetch=(url,options={})=>fetch(url,{...options,signal:AbortSignal.timeout(20000)});
      const rootLegacy=await securityFetch(base+'index.php?alert=logout',{redirect:'manual'});assert.equal(rootLegacy.status,302);assert.equal(rootLegacy.headers.get('location'),'/profil_risiko_v2/?alert=logout');
      const expired=await (await securityFetch(base+'login.php')).text();assert(!expired.includes('href="index.php"') && expired.includes('href="./"'),'Expired-login link exposes index.php');
      for(const payload of ["' OR 1=1 -- ","admin' -- ","x'); SELECT SLEEP(2); --"]) {
        const response=await securityFetch(base,{method:'POST',body:new URLSearchParams({username:payload,password:payload}),redirect:'manual'});
        assert.equal(response.status,302);assert.equal(response.headers.get('location'),'/profil_risiko_v2/?alert=gagal','SQL payload bypassed login');
      }
      console.log('PASS root login redirects and SQL payloads');
      const arrayLogin=await securityFetch(base,{method:'POST',body:new URLSearchParams({'username[]':'admin','password[]':'x'}),redirect:'manual'});assert.equal(arrayLogin.status,302);assert.equal(arrayLogin.headers.get('location'),'/profil_risiko_v2/?alert=gagal');
      for(const page of ['kre_inhern','lik_inhern','edit_user']) {
        for(const id of ["1' OR '1'='1",'1 OR 1=1','1 UNION SELECT 1']) {
          const response=await securityFetch(base+'admin/'+page+'?'+new URLSearchParams({id}),{headers});assert.equal(response.status,400,page+' accepted SQL identifier payload');
          const text=await response.text();assert(!/(mysqli|SELECT|SQLSTATE|Fatal error)/.test(text),'SQL detail leaked');
        }
      }
      console.log('PASS authenticated record ID injection rejection');
      const unauth=await securityFetch(base+'admin/user/delete_user.php?id=0',{redirect:'manual'});assert.equal(unauth.status,302,'Unauthenticated database endpoint was not blocked');assert.equal(unauth.headers.get('location'),'/profil_risiko_v2/');
      console.log('PASS unauthenticated direct endpoint protection');
      await cmd('Page.navigate',{url:base+'admin/dashboard'});await waitFor(`document.readyState==='complete' && document.querySelector('.side-nav')`,30000);
      const logout=await securityFetch(base+'admin/logout.php',{headers,redirect:'manual'});assert.equal(logout.status,302);assert.equal(logout.headers.get('location'),'/profil_risiko_v2/?alert=logout');
      const after=await securityFetch(base+'admin/dashboard',{headers,redirect:'manual'});assert.equal(after.status,302,'Logout left session authenticated');
      await cmd('Page.navigate',{url:base+'?alert=logout'});await waitFor(`document.readyState==='complete' && document.querySelector('#formLoginModern')`,20000);
      assert(await evaluate(`!location.pathname.endsWith('index.php') && !location.search.includes('page=')`),'Login index.php visible after logout');
      const shot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'login-clean-url.png'),Buffer.from(shot.data,'base64'));
      console.log('PASS clean login/logout URLs, real authenticated session, session invalidation, injection login/identifier rejection and array-input handling');
      await send('Browser.close');return;
    }
    if(process.argv.includes('--routes')) {
      const go=async url=>{await cmd('Page.navigate',{url:base+url});await waitFor(`document.readyState==='complete' && !!document.querySelector('.side-nav')`,40000);};
      const old=await fetch(base+'admin/index.php?page=menulapawal&id=556&tab=final',{headers,redirect:'manual'});
      assert.equal(old.status,302);assert.equal(old.headers.get('location'),'/profil_risiko_v2/admin/laporan/556/final');
      await go('admin/index.php?page=dashboard');
      assert(await evaluate(`location.pathname.endsWith('/admin/dashboard') && !location.search.includes('page=') && document.querySelector('a.oai-active-menu') && simproRoutePage(document.querySelector('a.oai-active-menu').href)==='dashboard'`),'Clean dashboard route or active sidebar failed');
      assert(await evaluate(`[...document.querySelectorAll('link[rel="stylesheet"][href]')].every(link=>link.disabled || !!link.sheet)`),'Dashboard styles did not load: '+JSON.stringify(await evaluate(`[...document.querySelectorAll('link[rel="stylesheet"][href]')].filter(link=>!link.sheet).map(link=>link.href)`)));
      await go('admin/laporan');
      await waitFor(`location.pathname.endsWith('/admin/laporan/') && simproRoutePage()==='menulapawal' && document.readyState==='complete'`,20000);
      assert(await evaluate(`!!document.querySelector('a.oai-active-menu') && simproRoutePage(document.querySelector('a.oai-active-menu').href)==='menulapawal'`),'Empty report list alias failed');
      await go('admin/pembanding');
      await waitFor(`location.pathname.endsWith('/admin/pembanding/') && simproRoutePage()==='pembanding' && document.readyState==='complete'`,20000);
      await go('admin/laporan/556/final');
      assert(await evaluate(`simproRoutePage()==='menulapawal' && simproRouteParams().get('id')==='556' && simproRouteParams().get('tab')==='final' && document.querySelector('#tab-profil-risiko-final').classList.contains('active')`),'Nested report URL or selected tab failed');
      assert(await evaluate(`[...document.querySelectorAll('script[src]')].every(el=>!el.src.includes('/laporan/556/')) && [...document.images].filter(img=>img.src.includes('/assets/')).every(img=>img.complete && img.naturalWidth>0)`),'Nested URL broke assets');
      const menuUrls=await evaluate(`[...new Set([...document.querySelectorAll('.side-nav a[href]')].filter(a=>{const p=simproRoutePage(a.href);return p && !/(hapus|delete|lock|aktif|actif|konfirm|simpan|update|proses|gabung|generate|cetak)/i.test(p);}).map(a=>a.href))]`);
      for(let i=0;i<menuUrls.length;i+=3) await Promise.all(menuUrls.slice(i,i+3).map(async url=>{const response=await fetch(url,{headers,signal:AbortSignal.timeout(30000)});const html=await response.text();assert.equal(response.status,200,'Menu cannot open: '+url);assert(!/(?:Fatal error|Parse error):/i.test(html),'Menu PHP failure: '+url);}));
      console.log('PASS '+menuUrls.length+' authenticated sidebar view links, including Laporan and Pembanding');
      await go('admin/hasil_lapkc?tahun=2026&periode=2&status_laporan=semua');
      await waitFor(`/utama/i.test(document.body.textContent)`,15000);
      assert(await evaluate(`location.search.includes('tahun=2026') && simproRoutePage(document.querySelector('a.oai-active-menu').href)==='hasil_lapkc' && /utama/i.test(document.body.textContent)`),'Filtered report route failed: '+JSON.stringify(await evaluate(`({url:location.href,active:document.querySelector('a.oai-active-menu')?.href,text:document.body.innerText.slice(-700)})`)));
      const post=await fetch(base+'admin/index.php?page=menulapawal',{method:'POST',headers:{...headers,'Content-Type':'application/x-www-form-urlencoded'},body:'',redirect:'manual'});
      assert.equal(post.status,200,'Legacy POST was redirected or failed');
      const noSession=await fetch(base+'admin/laporan/556/final',{redirect:'manual'});assert.equal(noSession.status,302);assert.equal(noSession.headers.get('location'),'/profil_risiko_v2/login.php');
      const otherCookie=login('admin kc');
      const forbidden=await fetch(base+'admin/laporan/556/final',{headers:{Cookie:'PHPSESSID='+otherCookie},redirect:'manual'});assert.equal(forbidden.status,302);assert.equal(forbidden.headers.get('location'),'/profil_risiko_v2/login.php');
      const shot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'pretty-route-filtered-report.png'),Buffer.from(shot.data,'base64'));
      const routeErrors=runtimeErrors.filter(error=>!/(cdn\.datatables\.net|apexcharts\.min\.js)/.test(error.url||''));
      assert.equal(routeErrors.length,0,'Client error on pretty routes: '+JSON.stringify(routeErrors.map(error=>({url:error.url,text:error.text,line:error.lineNumber,detail:error.exception?.description?.slice(0,500)}))));
      const roles=fs.readdirSync(root,{withFileTypes:true}).filter(entry=>entry.isDirectory() && fs.existsSync(path.join(root,entry.name,'laporan/cetak_laporan_profil_risiko.php'))).map(entry=>entry.name);
      for(let i=0;i<roles.length;i+=4) await Promise.all(roles.slice(i,i+4).map(async role=>{const response=await fetch(base+role+'/dashboard',{redirect:'manual'});assert.equal(response.status,302,role);assert.equal(response.headers.get('location'),'/profil_risiko_v2/login.php',role);}));
      const branchCookie=login('kepala cabang');await cmd('Network.setCookie',{name:'PHPSESSID',value:branchCookie,domain:'127.0.0.1',path:'/'});
      await go('kepala_cabang/laporan/545/cabang');
      await waitFor(`window.simproRouteConfig && simproRouteConfig.roleBase.endsWith('/kepala_cabang/') && document.readyState==='complete'`,20000);
      assert(await evaluate(`simproRoutePage()==='menulapawal' && simproRouteParams().get('id')==='545' && !document.body.textContent.includes('Fatal error')`),'Branch role report route failed');
      await fetch(base+'kepala_cabang/logout.php',{headers:{Cookie:'PHPSESSID='+branchCookie}});
      console.log('PASS clean aliases and login redirects for all 20 roles, including authenticated branch report access');
      console.log('PASS canonical legacy redirects, nested report tabs, active sidebar, assets, filters, POST preservation and access checks');
      await send('Browser.close');return;
    }
    const compactScript=fs.readFileSync(path.join(root,'assets/js/print-risk-compact.js'),'utf8');
    const fixtureSource=fs.readFileSync(path.join(root,'tests/print_kredit_rowspan_test.cjs'),'utf8');
    const fixtureDefinition=fixtureSource.slice(fixtureSource.indexOf('function fixture()'),fixtureSource.indexOf('\n(async ()'));
    const printFiles=fs.readdirSync(root,{withFileTypes:true}).filter(entry=>entry.isDirectory()).map(entry=>path.join(root,entry.name,'laporan/cetak_laporan_profil_risiko.php')).filter(file=>fs.existsSync(file));
    for(const file of printFiles){
      const code=fs.readFileSync(file,'utf8');
      const helpers=code.slice(code.indexOf('    function cellHasRealText('),code.indexOf('    function normalizeKpmrSkalaHeader('));
      for(const risk of ['KREDIT','LIKUIDITAS']){
        const fixture=new Function('riskTitle',fixtureDefinition+';return fixture();')('RISIKO '+risk+' INHEREN');
        const result=await evaluate(`(()=>{document.body.innerHTML=${JSON.stringify(fixture)};${helpers}\n${compactScript}\nconst root=document.querySelector('main');fixKeteranganRowspan(root);fixInherenKeteranganWidth(root);compactRiskPrintColumns(root,'Risiko ${risk} - Inheren');const table=root.querySelector('table');const before=table.outerHTML;compactRiskPrintColumns(root,'Risiko ${risk} - Inheren');const occupied=[];const errors=[];[...table.rows].forEach((row,r)=>{let col=0;[...row.cells].forEach(cell=>{while((occupied[col]||0)>r)col++;for(let j=0;j<cell.colSpan;j++)occupied[col+j]=r+cell.rowSpan;col+=cell.colSpan;});if(occupied.filter(until=>until>r).length!==6)errors.push(r);});return {headers:[...table.tHead.rows[1].cells].map(c=>c.textContent.trim()),spans:[...table.querySelectorAll('.inheren-keterangan-merged')].map(c=>c.rowSpan),numberSpans:[...table.querySelectorAll('.inheren-number-merged')].map(c=>c.rowSpan),numberAlign:[...table.querySelectorAll('.inheren-number-merged')].every(c=>getComputedStyle(c).verticalAlign==='top' && getComputedStyle(c).textAlign==='center'),errors,same:before===table.outerHTML};})()`);
        assert.deepEqual(result.headers,['NO','PARAMETER','NOMINAL','RASIO','NILAI','KETERANGAN'],file);
        assert.deepEqual(result.spans,[8,7,3,2],file);
        assert.deepEqual(result.numberSpans,[8,7,3,2],file);assert(result.numberAlign,file);
        assert.deepEqual(result.errors,[],file);
        assert(result.same,'Compaction is not idempotent: '+file);
      }
    }
    console.log('PASS six-column credit/liquidity print grids and note rowspans for '+printFiles.length+' roles');
    for(const risk of ['Kredit','Likuiditas']){
      const fixture='<main><table><thead><tr><th colspan="9">RISIKO '+risk.toUpperCase()+' INHEREN</th></tr><tr>'+['NO','PARAMETER','NOMINAL','RASIO','AMBANG BATAS','RUMUS','KOREKSI','NILAI','KETERANGAN'].map(x=>'<th>'+x+'</th>').join('')+'</tr></thead><tbody><tr><th colspan="2">Rekapitulasi penilaian tingkat risiko untuk pilar 1</th><th>Tertinggi 4.00</th><th>Terendah 1.00</th><th>Rata-rata 2.00</th><th colspan="2">Nilai diambil</th><th>Risiko ditetapkan <div class="print-field">3.25</div></th><th><div class="print-field">Uraian rekap yang harus tetap utuh.</div></th></tr></tbody></table></main>';
      const recap=await evaluate(`(()=>{document.body.innerHTML=${JSON.stringify(fixture)};const root=document.querySelector('main');compactRiskPrintColumns(root,'Risiko ${risk} - Inheren');const row=root.querySelector('tr[data-compact-recap]');return {spans:[...row.cells].map(c=>c.colSpan),score:row.cells[1].textContent,note:row.cells[2].textContent,label:row.cells[0].textContent,text:row.textContent};})()`);
      assert.deepEqual(recap.spans,[3,2,1]);assert(recap.score.includes('3.25') && recap.note.includes('tetap utuh') && recap.label.includes('pilar 1') && !recap.text.includes('Tertinggi'));
    }
    console.log('PASS credit/liquidity recaps have three cells retaining the set risk and full note');
    const justify=await evaluate(`(()=>{const root=document.querySelector('main');root.insertAdjacentHTML('beforeend','<div class="print-note"><strong>Uraian laporan tambahan.</strong></div><div class="print-field" id="rating-control">3.25</div>');justifyRiskPrintText(root);return {recap:[...root.querySelectorAll('tr[data-compact-recap] > *')].every(el=>getComputedStyle(el).textAlign==='justify' && [...el.querySelectorAll('div,center')].every(child=>getComputedStyle(child).textAlign==='justify')),note:getComputedStyle(root.querySelector('.print-note')).textAlign,rating:root.querySelector('#rating-control').style.textAlign};})()`);
    assert(justify.recap && justify.note==='justify' && justify.rating==='','Narrative/recap justification affected normal rating cells');


    const counterResult=await evaluate(`(()=>{document.body.innerHTML='<main><textarea maxlength="2000">Uraian pertama</textarea><span id="penghitung-karakter1">990</span><span> / 2000</span><div class="print-field">Uraian kedua</div><span>880</span><span> / 1000</span><div class="print-field">Uraian ketiga</div><span>770 / 2000</span><p>Rasio pembanding 990 / 2000 tetap merupakan isi laporan.</p></main>';removePrintCharacterCounts(document.querySelector('main'));return {count:document.querySelectorAll('main span').length,text:document.querySelector('main').textContent,max:document.querySelector('textarea').maxLength};})()`);
    assert.equal(counterResult.count,0,'Editor character counters remain in print');
    assert(counterResult.text.includes('Uraian kedua') && counterResult.text.includes('990 / 2000 tetap merupakan isi laporan.'),'Counter cleanup removed report data');
    assert.equal(counterResult.max,2000,'Input character limit was changed');
    console.log('PASS character counters removed without removing report text or input limits');
    const summaryTitles=['Operasional','Kepatuhan','Reputasi','Stratejik'].map(risk=>'Risiko '+risk+' - Inheren 2').concat(['Kredit','Likuiditas','Operasional','Kepatuhan','Reputasi','Stratejik'].map(risk=>'Risiko '+risk+' - KPMR 2'));
    for(const title of summaryTitles){
      const fixture='<main><table><thead><tr><th colspan="8">'+title+'</th></tr><tr><th>NO</th><th colspan="2">PARAMETER</th><th colspan="2">PERINGKAT RISIKO</th><th>KETERANGAN</th><th colspan="2">RISIKO PERIODE SEBELUMNYA</th></tr></thead><tbody><tr><th colspan="8">PILAR 1</th></tr><tr class="row-param"><th>1</th><th colspan="2">Parameter terpilih</th><td></td><td>4.21</td><td>Uraian tetap tampil</td><td></td><td>9955</td></tr><tr><th></th><th>a.</th><th>Subparameter</th><td>3.21</td><td colspan="2"></td><td>9955</td><td></td></tr><tr><th colspan="4">Hasil Penilaian Pilar 1</th><td>4.21</td><td>Catatan pilar</td><td></td><td>9955</td></tr></tbody></table></main>';
      const result=await evaluate(`(()=>{document.body.innerHTML=${JSON.stringify(fixture)};const root=document.querySelector('main');compactRiskPrintColumns(root,${JSON.stringify(title)});const table=root.querySelector('table');const before=table.outerHTML;compactRiskPrintColumns(root,${JSON.stringify(title)});return {cols:table.querySelector('colgroup').children.length,widths:(()=>{const occupied=[];return [...table.rows].map((row,r)=>{let col=0;[...row.cells].forEach(cell=>{while((occupied[col]||0)>r)col++;for(let j=0;j<cell.colSpan;j++)occupied[col+j]=r+cell.rowSpan;col+=cell.colSpan;});return occupied.filter(until=>until>r).length;});})(),noteSpan:table.querySelector('.kpmr-keterangan-merged')?.rowSpan,old:root.textContent.includes('9955'),note:root.textContent.includes('Uraian tetap tampil'),value:root.textContent.includes('4.21'),same:before===table.outerHTML,headers:table.tHead.textContent,ratingSpan:table.tHead.rows[1].cells[2].colSpan,parameterScore:table.tBodies[0].rows[1].cells[2].textContent,summaryScore:table.tBodies[0].rows[3].cells[1].textContent};})()`);
      const kpmr=/KPMR 2$/.test(title);assert.equal(result.cols,5,title);assert(result.widths.every(width=>width===5),title);assert.equal(result.ratingSpan,1,title);assert(result.parameterScore.includes('4.21') && result.summaryScore.includes('4.21'),'Merged score lost: '+title);if(kpmr){assert.equal(result.noteSpan,2,title);assert(result.parameterScore.includes('4.21') && result.summaryScore.includes('4.21'),'Merged KPMR score lost: '+title);}assert(!result.old && result.note && result.value && result.same && !result.headers.includes('SEBELUMNYA'),title);
    }
    console.log('PASS previous-period columns removed from four Inheren 2 and six KPMR 2 print layouts');

    for(const file of printFiles){
      const code=fs.readFileSync(file,'utf8');
      const inlineHelper=code.slice(code.indexOf('    function restoreInlineKeteranganToRightColumn('),code.indexOf('    function removeDropdownArtifacts('));
      const widthHelper=code.slice(code.indexOf('    function fixKpmrDanInherenLainWidth('),code.indexOf('    function removeFaktorLainnyaEmptyRows('));
      const result=await evaluate(`(()=>{document.body.innerHTML='<main><table><thead><tr><th colspan="8">RISIKO REPUTASI INHEREN 2</th></tr><tr><th>NO</th><th colspan="2">PARAMETER</th><th colspan="2">PERINGKAT RISIKO</th><th>KETERANGAN</th><th colspan="2">PERIODE SEBELUMNYA</th></tr></thead><tbody><tr class="row-pilar"><td colspan="8">PILAR 1</td></tr><tr class="row-param"><th>1</th><th colspan="2">Parameter reputasi</th><td></td><td>1.25</td><td><div class="print-note">Penilaian skala risiko berdasarkan kondisi bank. Keterangan tetap di kanan.</div></td><td></td><td>2.75</td></tr><tr><th></th><th>a.</th><th>Subparameter reputasi</th><td>1.00</td><td colspan="2"></td><td>2.75</td><td></td></tr></tbody></table></main>';${inlineHelper}\n${widthHelper}\nconst root=document.querySelector('main');restoreInlineKeteranganToRightColumn(root);fixKpmrDanInherenLainWidth(root);restoreInlineKeteranganToRightColumn(root);compactRiskPrintColumns(root,'Risiko Reputasi - Inheren 2');const table=root.querySelector('table'),occupied=[],widths=[];[...table.rows].forEach((row,r)=>{let col=0;[...row.cells].forEach(cell=>{while((occupied[col]||0)>r)col++;for(let j=0;j<cell.colSpan;j++)occupied[col+j]=r+cell.rowSpan;col+=cell.colSpan;});widths.push(occupied.filter(until=>until>r).length);});return {widths,columns:table.querySelector('colgroup').children.length,note:table.querySelector('.row-param').lastElementChild.textContent,old:table.textContent.includes('2.75')};})()`);
      assert(result.columns===5 && result.widths.every(n=>n===5) && result.note.includes('Keterangan tetap di kanan.') && !result.old,'Narrative text changed reputation columns: '+file+' '+JSON.stringify(result));
    }
    console.log('PASS reputation notes mentioning skala risiko do not create trailing columns for all '+printFiles.length+' roles');


    await cmd('Page.navigate',{url:base+'admin/index.php?page=dashboard'});
    await waitFor(`document.readyState==='complete' && document.querySelector('.leftside-menu')`);
    let liveHtml;
    for(const report of [555,545]){
      const response=await fetch(base+'admin/laporan/cetak_laporan_profil_risiko.php?id='+report,{headers});
      assert.equal(response.status,200);
      const html=await response.text();
      const titles=[...html.matchAll(/class="print-section"[^>]*data-title="([^"]+)"/g)].map(match=>match[1]);
      assert.equal(titles.length,report===545?12:18,'Wrong live section count for report '+report);
      assert(!titles.some(title=>/Profil (Nilai Konsolidasi|Peringkat)$/i.test(title)),'Removed profile sections still present');
      assert.equal(titles.filter(title=>/KPMR 2$/.test(title)).length,report===545?0:6);
      assert.equal(titles.filter(title=>/Inheren 2$/.test(title)).length,4);
      assert(!titles.some(title=>/(KPMR|Inheren) 1$/.test(title)),'Detailed first assessment still printed');
      if(report===555)liveHtml=html;
    }
    console.log('PASS actual consolidated and branch print sections: Inheren 2 and KPMR 2 selection');
    liveHtml=liveHtml.replace('<head>','<head><base href="'+base+'admin/laporan/cetak_laporan_profil_risiko.php">');
    const reputation=process.argv.includes('--reputation');
    if(reputation) {
      liveHtml=await (await fetch(base+'admin/laporan/cetak_laporan_profil_risiko.php?id=556',{headers})).text();
      liveHtml=liveHtml.replace('<head>','<head><base href="'+base+'admin/laporan/cetak_laporan_profil_risiko.php">');
    }
    const summaries=process.argv.includes('--summaries') || reputation;
    const profiles=process.argv.includes('--profiles');
    const pattern=reputation ? 'Risiko Reputasi - Inheren 2$' : profiles ? '- Profil$' : summaries ? '(?:Inheren 2|KPMR 2)$' : 'Risiko (Kredit|Likuiditas) - Inheren';
    liveHtml=liveHtml.replace("const sections = Array.from(document.querySelectorAll('.print-section'));", "document.querySelectorAll('.print-section').forEach(el=>{if(!new RegExp("+JSON.stringify(pattern)+").test(el.dataset.title))el.remove();});const sections = Array.from(document.querySelectorAll('.print-section'));");
    const tree=await cmd('Page.getFrameTree');
    await cmd('Page.setDocumentContent',{frameId:tree.frameTree.frame.id,html:liveHtml});
    if(profiles) {
      await waitFor(`document.querySelectorAll('.section-content .profile-score-rows').length===12 && !document.querySelector('.section-content.loading')`,60000);
      const profileTables=await evaluate(`[...document.querySelectorAll('.profile-score-rows')].map(table=>({rows:table.tBodies[0].rows.length,values:table.querySelectorAll('.profile-score-values .valrank').length,ranks:table.querySelectorAll('.profile-score-ranks .valrank').length,spans:[...table.querySelectorAll('td[rowspan]')].map(cell=>cell.rowSpan),numbers:[...table.querySelectorAll('.profile-score-values .valrank')].every(cell=>/^\\d+\\.\\d{2}$/.test(cell.textContent.trim())),rank:[...table.querySelectorAll('.profile-score-ranks .valrank')].every(cell=>cell.textContent.trim().length>0)}))`);
      assert(profileTables.length===12 && profileTables.every(table=>table.rows===2 && table.values===3 && table.ranks===3 && JSON.stringify(table.spans)==='[2,2]' && table.numbers && table.rank),'Profile score/rank row layout incorrect: '+JSON.stringify(profileTables));
      await evaluate(`document.querySelector('.print-section').scrollIntoView({block:'start'})`);await delay(250);
      const shot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'profile-score-rows.png'),Buffer.from(shot.data,'base64'));
      await evaluate(`document.querySelectorAll('.cover,.pernyataan-page,.route-note').forEach(el=>el.remove())`);
      const pdf=await cmd('Page.printToPDF',{printBackground:true,preferCSSPageSize:true});fs.writeFileSync(path.join(artifacts,'profile-score-rows.pdf'),Buffer.from(pdf.data,'base64'));
      console.log('PASS all six risk profiles: current and previous scores above grades in separate bordered rows');
      await send('Browser.close');return;
    }
    await waitFor(`document.querySelectorAll('.section-content table[data-compact-risk-print="1"]').length>=${reputation?1:summaries?10:2} && !document.querySelector('.section-content.loading')`,60000);
    if(reputation) {
      const grid=await evaluate(`(()=>{const t=document.querySelector('table[data-compact-inheren-score="1"]');return {title:t.tHead.rows[0].cells[0].colSpan,headers:[...t.tHead.rows[1].cells].map(c=>c.colSpan),pillars:[...t.querySelectorAll('.row-pilar')].map(r=>r.cells[0].colSpan),parameters:t.querySelectorAll('.row-param').length,width:t.getBoundingClientRect().width,headWidth:t.tHead.rows[0].cells[0].getBoundingClientRect().width,html:t.outerHTML};})()`);
      fs.writeFileSync(path.join(artifacts,'reputation-grid.json'),JSON.stringify(grid,null,2));
      const pdf=await cmd('Page.printToPDF',{printBackground:true,preferCSSPageSize:true});fs.writeFileSync(path.join(artifacts,'reputation-print.pdf'),Buffer.from(pdf.data,'base64'));
      await evaluate(`(()=>{const note=document.querySelector('table[data-compact-inheren-score="1"] .kpmr-keterangan-merged');const text=note.textContent.trim();note.replaceChildren();for(let i=0;i<35;i++){const p=document.createElement('p');p.textContent='Uji uraian panjang '+(i+1)+'. '+text;note.appendChild(p);}})()`);
      const longPdf=await cmd('Page.printToPDF',{printBackground:true,preferCSSPageSize:true});fs.writeFileSync(path.join(artifacts,'reputation-long-note-print.pdf'),Buffer.from(longPdf.data,'base64'));
      const pagination=JSON.parse(execFileSync('python',['-c',
        "import fitz,json,sys,re; results=[]\nfor filename in sys.argv[1:]:\n d=fitz.open(filename); texts=[p.get_text() for p in d]; fragments=[t.split('KETERANGAN',1)[1].strip() for t in texts if 'RISIKO REPUTASI INHEREN' in t and 'KETERANGAN' in t]; results.append({'fragments':len(fragments),'empty':sum(len(t)<100 for t in fragments),'markers':len(set(re.findall(r'Uji uraian panjang (\\d+)\\.', ' '.join(texts))))})\nprint(json.dumps(results))",
        path.join(artifacts,'reputation-print.pdf'),path.join(artifacts,'reputation-long-note-print.pdf')],{encoding:'utf8'}));
      assert(pagination.every(p=>p.fragments>0 && p.empty===0),'Reputation PDF contains header-only/empty table fragments: '+JSON.stringify(pagination));
      assert.equal(pagination[1].markers,35,'Long merged reputation narrative was cut off');
      assert(grid.parameters>0,'Reputation parameters missing');
      assert(grid.title===5 && grid.headers.reduce((a,b)=>a+b,0)===5 && grid.pillars.every(n=>n===5),'Reputation print grid has inconsistent columns: '+JSON.stringify({...grid,html:undefined}));
      assert(Math.abs(grid.width-grid.headWidth)<2,'Reputation header does not fill the table');
      console.log('PASS actual reputation print: full-width grid, parameters and all long-note text without header-only/empty PDF pages');
      await send('Browser.close');return;
    }
    const live=await evaluate(`[...document.querySelectorAll('table[data-compact-risk-print="1"]')].map(table=>({headers:[...table.querySelectorAll('thead th')].filter(th=>th.colSpan===1).map(th=>th.textContent.trim().replace(/\\s+/g,' ')),cols:table.querySelector('colgroup').children.length,kpmr:table.dataset.compactKpmrScore==='1',notes:table.querySelectorAll('.inheren-keterangan-merged').length}))`);
    assert(live.every(table=>table.cols===(summaries?5:6) && (summaries || table.notes>0) && !table.headers.some(label=>summaries ? /PERIODE SEBELUMNYA/.test(label) : /^(AMBANG BATAS|RUMUS|KOREKSI)$/.test(label))),'Actual source did not compact correctly: '+JSON.stringify(live));
    if(summaries) {
      const notes=await evaluate(`[...document.querySelectorAll('table[data-compact-kpmr-score="1"]')].map(table=>{const parents=[...table.querySelectorAll('tbody .row-param')];return {parents:parents.length,merged:table.querySelectorAll('.kpmr-keterangan-merged').length,valid:parents.every(row=>{let n=1,next=row.nextElementSibling;while(next && !next.matches('.row-param,.row-pilar,.row-summary') && next.cells.length>=3 && /^[a-z]+[.)]?$/i.test(next.cells[0].textContent.trim())){n++;next=next.nextElementSibling;}return row.querySelector('.kpmr-keterangan-merged')?.rowSpan===n && row.querySelector('.kpmr-number-merged')?.rowSpan===n && getComputedStyle(row.cells[0]).verticalAlign==='top' && getComputedStyle(row.cells[0]).textAlign==='center';})};})`);
      assert.equal(notes.length,6,'Expected six KPMR 2 source tables');
      assert(notes.every(item=>item.parents>0 && item.parents===item.merged && item.valid),'KPMR parameter notes do not span all their subparameters: '+JSON.stringify(notes));
      console.log('PASS all live KPMR 2 parameter numbers and notes span through their final subparameter');
      const inherenNotes=await evaluate(`[...document.querySelectorAll('table[data-compact-inheren-score="1"]')].map(table=>{const parents=[...table.rows].filter(row=>row.cells.length>=3 && /^\\d+[.)]?$/.test(row.cells[0].textContent.trim()));return {parents:parents.length,valid:parents.every(row=>{let n=1,next=row.nextElementSibling;while(next && next.cells.length>=3 && /^[a-z]+[.)]?$/i.test(next.cells[0].textContent.trim())){n++;next=next.nextElementSibling;}return row.querySelector('.kpmr-keterangan-merged')?.rowSpan===n && row.querySelector('.kpmr-number-merged')?.rowSpan===n && getComputedStyle(row.cells[0]).verticalAlign==='top';})};})`);
      assert(inherenNotes.length===4 && inherenNotes.every(table=>table.parents>0 && table.valid),'Inheren 2 notes do not span all subparameters: '+JSON.stringify(inherenNotes));
      console.log('PASS all four Inheren 2 parameter notes span through their final subparameter');
      const centeredScores=await evaluate(`[...document.querySelectorAll('table[data-compact-inheren-score="1"]')].map(table=>{const rows=[...table.rows].filter(row=>row.querySelector('.kpmr-number-merged') || /^[a-z]+[.)]$/i.test(row.cells[0]?.textContent.trim()||''));return {count:rows.length,valid:rows.every(row=>{const cell=row.cells[2];return cell.matches('.inheren-score-centered') && getComputedStyle(cell).textAlign==='center' && getComputedStyle(cell).verticalAlign==='middle' && [...cell.querySelectorAll('*')].every(el=>getComputedStyle(el).textAlign==='center');})};})`);
      assert(centeredScores.length===4 && centeredScores.every(table=>table.count>0 && table.valid),'Inheren 2 scores are not centered: '+JSON.stringify(centeredScores));
      console.log('PASS all four Inheren 2 number rowspans and horizontally/vertically centered parameter scores');


      const summariesAligned=await evaluate(`[...document.querySelectorAll('table[data-compact-risk-score="1"]')].map(table=>{const rows=[...table.querySelectorAll('tr[data-kpmr-pillar-summary="1"]')];return {count:rows.length,valid:rows.every(row=>{const [label,stats,note]=row.cells;return getComputedStyle(label).textAlign==='justify' && getComputedStyle(label).verticalAlign==='top' && getComputedStyle(stats).textAlign==='center' && getComputedStyle(stats).verticalAlign==='top' && [...stats.querySelectorAll('div,center')].every(el=>getComputedStyle(el).textAlign==='center') && getComputedStyle(note).textAlign==='justify' && getComputedStyle(note).verticalAlign==='top' && getComputedStyle(note).fontWeight==='400' && [...stats.querySelectorAll('center')].every(el=>getComputedStyle(el).fontWeight==='700') && [...stats.querySelectorAll('.print-field')].every(el=>getComputedStyle(el).fontWeight==='400');})};})`);
      assert(summariesAligned.length===10 && summariesAligned.every(item=>item.count>0 && item.valid),'KPMR pillar summary alignment incorrect: '+JSON.stringify(summariesAligned));
      console.log('PASS all four Inheren 2 and six KPMR 2 pillar summaries: top-justified headings, top-centered statistics and unchanged notes');
      const parameterAlignments=await evaluate(`({tables:[...document.querySelectorAll('table[data-compact-risk-print="1"]')].map(table=>({count:table.querySelectorAll('.print-parameter-top-left').length,valid:[...table.querySelectorAll('.print-parameter-top-left,.print-parameter-top-left *')].every(el=>getComputedStyle(el).verticalAlign==='top' && getComputedStyle(el).textAlign==='left')})),letters:[...document.querySelectorAll('.print-subletter-top')].every(el=>getComputedStyle(el).verticalAlign==='top')})`);
      assert(parameterAlignments.tables.length===10 && parameterAlignments.tables.every(table=>table.count>0 && table.valid) && parameterAlignments.letters,'Parameter/subparameter alignment incorrect: '+JSON.stringify(parameterAlignments));
      console.log('PASS four Inheren 2 and six KPMR 2 parameter/subparameter texts align top-left; letters align top');


    }
    if(!summaries) assert(live.every(table=>table.headers.includes('RASIO')), 'Ratio column missing from actual credit/liquidity print sources');
    if(!summaries) {
      assert(await evaluate(`[...document.querySelectorAll('.inheren-keterangan-merged')].every(note=>{const number=note.parentElement.cells[0];return number.matches('.inheren-number-merged') && number.rowSpan===note.rowSpan && getComputedStyle(number).verticalAlign==='top' && getComputedStyle(number).textAlign==='center';})`),'Actual inheren parameter numbers are not merged and top-centered');
      console.log('PASS actual credit/liquidity parameter numbers span all subparameters and align top-center');
    }
    const alignments=await evaluate(`({notes:[...document.querySelectorAll('.section-content .print-note,.section-content .inheren-keterangan-merged,.section-content .kpmr-keterangan-merged')].map(el=>getComputedStyle(el).textAlign),recaps:[...document.querySelectorAll('tr[data-compact-recap="1"] > *')].map(el=>getComputedStyle(el).textAlign),vertical:[...document.querySelectorAll('tr[data-compact-recap="1"] > *')].map(el=>getComputedStyle(el).verticalAlign)})`);
    assert(alignments.notes.length>0 && alignments.notes.every(align=>align==='justify') && alignments.recaps.every(align=>align==='justify') && alignments.vertical.every(align=>align==='top'),'Actual print narratives or recap cells are not justified');
    assert(await evaluate(`![...document.querySelectorAll('.section-content')].some(section=>section.textContent.toLowerCase().includes('tersimpan...'))`),'Autosave status leaked into print output');
    const recapFormats=await evaluate(`[...document.querySelectorAll('table[data-recap-formatted="1"]')].map(table=>({rows:[...table.rows].filter(row=>/^Hasil\\s+Penilaian/i.test(row.cells[0]?.textContent.trim()||'')).map(row=>({left:getComputedStyle(row.cells[0]).textAlign==='left',values:[...row.querySelectorAll('.print-field')].every(el=>getComputedStyle(el).fontWeight==='400' && getComputedStyle(el).textAlign==='center'),labels:row.querySelectorAll('center').length>0 && [...row.querySelectorAll('center')].filter(el=>/^(Tertinggi|Terendah|Rata[ -]rata|Tingkat risiko|Peringkat)$/i.test(el.textContent.trim())).every(el=>getComputedStyle(el).fontWeight==='700')})),noSelection:!table.textContent.includes('Nilai diambil') && !table.textContent.includes('Metode Risiko')}))`);
    assert(recapFormats.length>0 && recapFormats.every(table=>table.rows.length>0 && table.noSelection && table.rows.every(row=>row.left && row.values && row.labels)),'Recap alignment/emphasis incorrect: '+JSON.stringify(recapFormats));
    console.log('PASS recap headings left-aligned, labels bold, values normal and selection methods hidden');
    const recapHeights=await evaluate(`[...document.querySelectorAll('table[data-recap-formatted="1"]')].map(table=>{const rows=[...table.rows].filter(row=>/^Hasil Penilaian (?:Pilar|Lainnya)/i.test(row.cells[0]?.textContent.trim()||''));return rows.map(row=>row.getBoundingClientRect().height);})`);
    assert(recapHeights.every(heights=>heights.length>1 && heights[0]<=Math.max(...heights.slice(1))+2),'First recap pillar row is oversized: '+JSON.stringify(recapHeights));
    console.log('PASS first recap pillar row height matches the following pillar rows');

    assert(await evaluate(`[...document.querySelectorAll('.section-content center')].filter(el=>el.textContent.trim()==='Rata-rata').every(el=>getComputedStyle(el).whiteSpace==='nowrap' && el.getClientRects().length===1)`),'Rata-rata label can wrap onto two lines');
    console.log('PASS Rata-rata statistic labels stay on one line');
    assert(await evaluate(`![...document.querySelectorAll('.section-content')].some(root=>/Checklist Aktif|Isian Kertas Kerja/i.test(root.textContent) || [...root.querySelectorAll('h1,h2,h3,h4,h5,h6')].some(el=>!el.closest('table') && /^Risiko /i.test(el.textContent.trim())))`),'Repeated editor headings remain above print tables');
    console.log('PASS repeated risk headings, checklist metadata and worksheet labels removed from print');
    assert(await evaluate(`![...document.querySelectorAll('.section-title,.section-content thead')].some(el=>/KPMR\\s+2\\b/i.test(el.textContent))`),'KPMR 2 still appears in visible print headings');
    console.log('PASS visible section and table headings show KPMR without the suffix 2');
    assert(await evaluate(`![...document.querySelectorAll('.section-title,.section-content thead')].some(el=>/INHEREN\\s+2\\b/i.test(el.textContent)) && [...document.querySelectorAll('.section-title')].every(el=>el.textContent===el.textContent.toUpperCase() && getComputedStyle(el).fontSize==='16px') && [...document.querySelectorAll('table[data-compact-risk-print] > thead > tr:first-child > th:only-child')].every(el=>getComputedStyle(el).fontSize==='15px')`),'Inheren suffix, capitalization or title hierarchy incorrect');
    console.log('PASS Inheren headings omit 2; section titles uppercase and larger than table titles');

    const recapNames=await evaluate(`[...document.querySelectorAll('.print-section')].map(section=>{const risk=(section.dataset.title.match(/Risiko (Kredit|Operasional|Kepatuhan|Likuiditas|Reputasi|Stratejik)/i)||[])[1];return {risk,valid:[...section.querySelectorAll('thead')].every(head=>{const caption=head.rows[0]?.textContent.trim()||'';return !/^REKAP PENILAIAN/i.test(caption)||caption.toUpperCase().endsWith(risk.toUpperCase());})};})`);
    assert(recapNames.every(section=>section.risk && section.valid),'Incorrect risk name in recap header: '+JSON.stringify(recapNames));
    console.log('PASS all recap table captions match their own risk section');
    console.log('PASS print output excludes autosave status');
    console.log('PASS justified narrative and recap text in actual print output');
    assert(await evaluate(`[...document.querySelectorAll('.section-content .print-note-normal,.section-content .print-note-normal *')].every(el=>Number(getComputedStyle(el).fontWeight)===400)`),'Narrative text is still bold');
    console.log('PASS normal-weight narrative text; recap labels and numeric styles retained');
    if(process.argv.includes('--cover')) {
      assert(await evaluate(`document.querySelector('.cover-narrative-text')?.textContent.trim().length>0`),'Saved profile narrative missing from cover');
      await evaluate(`document.querySelectorAll('.print-section,.pernyataan-page,.route-note').forEach(el=>el.remove())`);
      await cmd('Emulation.setDeviceMetricsOverride',{width:950,height:1300,deviceScaleFactor:1,mobile:false});
      await cmd('Emulation.setEmulatedMedia',{media:'print'});
      await evaluate(`window.scrollTo(0,0)`);await delay(250);
      const coverShot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'compact-cover-narrative.png'),Buffer.from(coverShot.data,'base64'));
      const coverPdf=await cmd('Page.printToPDF',{printBackground:true,preferCSSPageSize:true});fs.writeFileSync(path.join(artifacts,'compact-cover-narrative.pdf'),Buffer.from(coverPdf.data,'base64'));
      console.log('PASS saved profile narrative printed directly below the opening risk summary');
      await send('Browser.close');return;
    }
    const grids=await evaluate(`[...document.querySelectorAll('.section-content .clean-page table')].map(table=>({collapsed:getComputedStyle(table).borderCollapse==='collapse',cells:[...table.querySelectorAll('th,td')].every(cell=>{const s=getComputedStyle(cell);return s.boxShadow==='none' && ['Top','Right','Bottom','Left'].every(side=>s['border'+side+'Style']==='none'||s['border'+side+'Width']==='1px');})}))`);
    assert(grids.length>0 && grids.every(grid=>grid.collapsed && grid.cells),'Print table has doubled borders or inconsistent line widths');
    console.log('PASS collapsed single-width print table grids without inset shadows');
    assert(await evaluate(`[...document.querySelectorAll('table[data-compact-risk-print="1"]')].every(table=>{const footer=table.querySelector('tfoot.print-page-grid-footer');return footer && footer.rows[0].cells[0].colSpan===table.querySelector('colgroup').children.length && getComputedStyle(footer).display==='table-footer-group';})`),'Repeating page-cut closing rule missing');
    console.log('PASS repeating page footer closes every compact assessment table');

    await evaluate(`document.querySelectorAll('.cover,.pernyataan-page,.route-note').forEach(el=>el.remove())`);
    await cmd('Emulation.setDeviceMetricsOverride',{width:950,height:1200,deviceScaleFactor:1,mobile:false});
    await cmd('Emulation.setEmulatedMedia',{media:'print'});
    await evaluate(`document.querySelector('.print-section').scrollIntoView({block:'start'})`);await delay(250);
    const credit=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,summaries?'compact-summary-preview.png':'compact-credit-preview.png'),Buffer.from(credit.data,'base64'));
    if(!summaries){
      const recaps=await evaluate(`[...document.querySelectorAll('tr[data-compact-recap="1"]')].map(row=>({spans:[...row.cells].map(c=>c.colSpan),label:row.cells[0].textContent,score:row.cells[1].textContent,note:row.cells[2].textContent}))`);
      assert(recaps.length>=8 && recaps.every(row=>JSON.stringify(row.spans)==='[3,2,1]' && row.label.includes('Rekapitulasi') && /Risiko\s+ditetapkan/i.test(row.score)), 'Actual recap rows did not retain three columns: '+JSON.stringify(recaps.map(row=>({spans:row.spans,score:row.score}))));
      await evaluate(`document.querySelector('tr[data-compact-recap="1"]').scrollIntoView({block:'start'})`);await delay(250);
      const recapShot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'compact-inheren-recap-preview.png'),Buffer.from(recapShot.data,'base64'));
      console.log('PASS all actual credit/liquidity recap rows print in three columns');
      assert(await evaluate(`[...document.querySelectorAll('tr[data-compact-recap="1"]')].every(row=>{const table=row.closest('table');const heads=[...table.querySelectorAll('thead th')];const note=heads.find(c=>c.textContent.trim()==='KETERANGAN');const ratio=heads.find(c=>c.textContent.trim()==='RASIO');const noteRect=row.cells[2].getBoundingClientRect(),headRect=note.getBoundingClientRect();return Math.abs(noteRect.left-headRect.left)<1 && Math.abs(noteRect.width-headRect.width)<1 && Math.abs(row.cells[1].getBoundingClientRect().left-ratio.getBoundingClientRect().left)<1;})`),'Recap columns do not align with ratio/value and Keterangan headers');
      console.log('PASS recap score aligns with ratio/value and recap note matches Keterangan column width');

    }
    if(summaries){
      await evaluate(`document.querySelector('tr[data-kpmr-pillar-summary="1"]').scrollIntoView({block:'start'})`);await delay(250);
      const pillarShot=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,'compact-kpmr-pillar-summary.png'),Buffer.from(pillarShot.data,'base64'));
    }
    await evaluate(`document.querySelectorAll('.print-section')[1].scrollIntoView({block:'start'})`);await delay(250);
    const liquidity=await cmd('Page.captureScreenshot',{format:'png'});fs.writeFileSync(path.join(artifacts,summaries?'compact-kpmr2-preview.png':'compact-liquidity-preview.png'),Buffer.from(liquidity.data,'base64'));
    const pdf=await cmd('Page.printToPDF',{printBackground:true,preferCSSPageSize:true});
    const bytes=Buffer.from(pdf.data,'base64');assert(bytes.subarray(0,5).toString()==='%PDF-');fs.writeFileSync(path.join(artifacts,summaries?'compact-summaries-print.pdf':'compact-risk-print.pdf'),bytes);
    console.log(summaries?'PASS actual Inheren 2/KPMR 2 print sources and PDF without previous-period columns':'PASS actual credit/liquidity print source and PDF preview; nominal, score and merged notes retained');
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
