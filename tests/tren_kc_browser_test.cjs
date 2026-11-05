// Real authenticated routes, filters, scores, missing periods and viewport checks.
const assert=require('node:assert/strict'),fs=require('node:fs'),path=require('node:path'),os=require('node:os');
const {spawn,execFileSync}=require('node:child_process');
const root=path.resolve(__dirname,'..'),base='http://127.0.0.1/profil_risiko_v2/';
const delay=ms=>new Promise(r=>setTimeout(r,ms));
function php(code){return JSON.parse(execFileSync('php',[],{cwd:root,input:'<?php '+code,encoding:'utf8'}));}
(async()=>{
 const cookie=php(`require getcwd().'/conn/conn.php';$a=mysqli_fetch_assoc(simpro_db_query($conn,'SELECT username,password FROM user WHERE tipe=? ORDER BY user_id LIMIT 1',['admin']));$c=curl_init('${base}');curl_setopt_array($c,[CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>http_build_query($a),CURLOPT_RETURNTRANSFER=>true,CURLOPT_COOKIEFILE=>'',CURLOPT_TIMEOUT=>20]);curl_exec($c);$cookie='';foreach(curl_getinfo($c,CURLINFO_COOKIELIST) as $line){$v=explode(chr(9),$line);if($v[5]==='PHPSESSID')$cookie=$v[6];}echo json_encode($cookie);`);
 assert(cookie);
 const expected=php(`require getcwd().'/conn/conn.php';require getcwd().'/admin/includes/tren_profil_kc_data.php';echo json_encode(tren_kc_load($conn,tren_kc_periods(2025,4,2026,2),1,28),JSON_FORCE_OBJECT);`);
 const profile=fs.mkdtempSync(path.join(os.tmpdir(),'tren-kc-chrome-'));
 const chrome=spawn('C:/Program Files/Google/Chrome/Application/chrome.exe',['--headless','--disable-gpu','--no-sandbox','--no-first-run','--disable-background-networking','--disk-cache-size=1','--remote-debugging-port=0','--user-data-dir='+profile],{windowsHide:true,stdio:'ignore'});
 let socket;
 try {
  const portFile=path.join(profile,'DevToolsActivePort');for(let i=0;i<100&&!fs.existsSync(portFile);i++)await delay(100);
  const port=fs.readFileSync(portFile,'utf8').split('\n')[0],version=await(await fetch('http://127.0.0.1:'+port+'/json/version')).json();
  socket=new WebSocket(version.webSocketDebuggerUrl);await new Promise((resolve,reject)=>{socket.onopen=resolve;socket.onerror=reject;});
  let seq=0;const pending=new Map();
  socket.onmessage=event=>{const p=JSON.parse(event.data);if(pending.has(p.id)){const c=pending.get(p.id);clearTimeout(c.timer);pending.delete(p.id);p.error?c.reject(Error(p.error.message)):c.resolve(p.result);}};
  const send=(method,params={},sessionId)=>new Promise((resolve,reject)=>{const id=++seq,timer=setTimeout(()=>{pending.delete(id);reject(Error('CDP timeout: '+method));},method==='Browser.close'?2000:30000);pending.set(id,{resolve,reject,timer});socket.send(JSON.stringify({id,method,params,...(sessionId?{sessionId}:{})}));});
  const {targetId}=await send('Target.createTarget',{url:'about:blank'}),{sessionId}=await send('Target.attachToTarget',{targetId,flatten:true});
  const cmd=(method,params)=>send(method,params,sessionId);
  const evaluate=async expression=>{const r=await cmd('Runtime.evaluate',{expression,returnByValue:true,awaitPromise:true});if(r.exceptionDetails)throw Error(r.exceptionDetails.exception?.description||r.exceptionDetails.text);return r.result.value;};
  const waitFor=async expression=>{for(let i=0;i<150;i++){if(await evaluate(expression))return;await delay(200);}throw Error('Wait failed: '+expression);};
  await cmd('Page.enable');await cmd('Network.enable');await cmd('Network.setCookie',{name:'PHPSESSID',value:cookie,domain:'127.0.0.1',path:'/'});
  await cmd('Emulation.setDeviceMetricsOverride',{width:1440,height:1000,deviceScaleFactor:1,mobile:false});
  const url=base+'admin/tren_profil_kc?start_year=2025&start_quarter=4&end_year=2026&end_quarter=2&wilayah=semua';
  await cmd('Page.navigate',{url});await waitFor(`document.querySelector('#tren-kc-count')?.textContent.includes('28 cabang')`);
  await waitFor(`!!document.querySelector('.side-nav a.oai-active-menu[href*="tren_profil_kc"]')`);
  const values=await evaluate(`(()=>{const t=document.querySelector('.tren-kc-table');return {groups:[...t.tHead.rows[0].querySelectorAll('[data-risk]')].map(c=>c.dataset.risk),rows:[...t.querySelectorAll('tr[data-branch]')].map(r=>({branch:Number(r.cells[0].textContent),values:[...r.querySelectorAll('td[data-risk]:not(.tren-kc-trend)')].map(c=>c.textContent.trim())})),summaries:t.querySelectorAll('[data-region-summary]').length,active:!!document.querySelector('.side-nav a.oai-active-menu[href*="tren_profil_kc"]'),overflow:document.documentElement.scrollWidth>innerWidth};})()`);
  assert.deepEqual(values.groups,['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik','komposit']);assert.equal(values.rows.length,28);assert.equal(values.summaries,4);assert(values.active);assert(!values.overflow,'Page must not overflow horizontally');
  for(const row of values.rows){let index=0;for(const risk of values.groups)for(const key of ['2025-4','2026-1','2026-2']){const score=expected[row.branch]?.[key]?.values[risk];const text=score==null?'—':Number(score).toFixed(2).replace('.',',');assert.equal(row.values[index++],text,`${row.branch} ${risk} ${key}`);}}
  await evaluate(`document.getElementById('tren-risk-view').value='operasional';document.getElementById('tren-risk-view').dispatchEvent(new Event('change'));document.getElementById('tren-branch-search').value='Rembang';document.getElementById('tren-branch-search').dispatchEvent(new Event('input'));`);
  assert.equal(await evaluate(`document.querySelectorAll('tbody tr[data-branch]:not([hidden])').length`),1);
  assert.deepEqual(await evaluate(`[...document.querySelector('.tren-kc-table').tHead.rows[0].querySelectorAll('[data-risk]:not([hidden])')].map(c=>c.dataset.risk)`),['operasional','komposit']);
  // Submit the real GET form and ensure all selected range values survive canonical routing.
  await evaluate(`document.getElementById('tren-region').value='solo';document.querySelector('.tren-kc-filter').requestSubmit();`);
  await waitFor(`location.search.includes('wilayah=solo')&&document.querySelector('#tren-kc-count')?.textContent.includes('7 cabang')`);
  assert.equal(await evaluate(`document.querySelectorAll('tr[data-branch]').length`),7);
  assert.equal(await evaluate(`document.getElementById('tren-start-quarter').value`),'4');
  const means=await evaluate(`[...document.querySelector('[data-region-summary="solo"]').querySelectorAll('td[data-risk]:not(.tren-kc-trend)')].map(c=>c.firstChild.textContent.trim())`);
  let meanIndex=0;for(const risk of values.groups)for(const key of ['2025-4','2026-1','2026-2']){const samples=Array.from({length:7},(_,i)=>expected[i+8]?.[key]?.values[risk]).filter(v=>v!=null);const average=samples.length?(samples.reduce((a,b)=>a+b,0)/samples.length).toFixed(2).replace('.',','):'—';assert.equal(means[meanIndex++],average,'Regional average must exclude missing scores');}
  const out=path.join(root,'.local','tren-kc-review');fs.mkdirSync(out,{recursive:true});
  const image=await cmd('Page.captureScreenshot',{format:'png',captureBeyondViewport:false});fs.writeFileSync(path.join(out,'desktop.png'),Buffer.from(image.data,'base64'));
  await evaluate(`document.querySelector('.tren-kc-scroll').scrollLeft=100000;`);await delay(150);
  const right=await cmd('Page.captureScreenshot',{format:'png',captureBeyondViewport:false});fs.writeFileSync(path.join(out,'composite.png'),Buffer.from(right.data,'base64'));
  const bounds=await evaluate(`(()=>{const c=document.querySelector('.tren-kc-table thead tr:first-child [data-risk="komposit"]').getBoundingClientRect(),s=document.querySelector('.tren-kc-scroll').getBoundingClientRect(),b=document.querySelector('.tren-kc-table .tren-branch').getBoundingClientRect();return {right:c.right,edge:s.right,left:c.left,branchRight:b.right};})()`);
  assert(bounds.right<=bounds.edge+2&&bounds.left>=bounds.branchRight,'Composite must be visible at right edge: '+JSON.stringify(bounds));
  assert(await evaluate(`(()=>{const s=document.querySelector('.tren-kc-scroll');return Math.abs(s.scrollLeft-(s.scrollWidth-s.clientWidth))<2;})()`),'Linked scrollbars must reach the actual final column');
  await cmd('Emulation.setDeviceMetricsOverride',{width:390,height:844,deviceScaleFactor:1,mobile:true});
  await delay(300);assert(!await evaluate(`document.documentElement.scrollWidth>innerWidth`),'Mobile page overflow');
  const mobile=await cmd('Page.captureScreenshot',{format:'png',captureBeyondViewport:false});fs.writeFileSync(path.join(out,'mobile.png'),Buffer.from(mobile.data,'base64'));
  await cmd('Page.navigate',{url:base+'admin/tren_profil_kc?start_year=2099&start_quarter=1&end_year=2099&end_quarter=2&wilayah=solo'});
  await waitFor(`document.querySelector('.tren-kc-table')&&document.querySelector('#tren-kc-count')?.textContent.includes('7 cabang')`);
  assert.equal(await evaluate(`document.querySelectorAll('.tren-kc-table td a').length`),0,'No invented scores for empty periods');
  await cmd('Page.navigate',{url:base+'admin/tren_profil_kc?start_year=2026&start_quarter=4&end_year=2026&end_quarter=1'});
  await waitFor(`document.querySelector('[role="alert"]')`);assert(!await evaluate(`!!document.querySelector('.tren-kc-table')`));
  const reports=[];
  for(const page of ['hasil_lapkc','rekap_cbg']){
   await cmd('Page.navigate',{url:base+'admin/'+page+'?tahun=2026&periode=3&status_laporan=semua'});
   await waitFor(`window.jQuery&&jQuery.fn.dataTable&&jQuery.fn.dataTable.isDataTable('#datatable-buttons1')`);
   reports.push(await evaluate(`jQuery('#datatable-buttons1').DataTable().rows({order:'index'}).nodes().toArray().map(row=>({branch:Number(row.cells[1].textContent),scores:[...row.querySelectorAll('td[data-kind="score"]')].map(c=>c.textContent.trim())})).sort((a,b)=>a.branch-b.branch)`));
  }
  assert.deepEqual(reports[0],reports[1],'KC results and regional recap must display identical scores');
  await cmd('Page.navigate',{url:base+'admin/tren_profil_kc?start_year=2026&start_quarter=3&end_year=2026&end_quarter=3&wilayah=semua'});
  await waitFor(`document.querySelector('#tren-kc-count')?.textContent.includes('28 cabang')`);
  const trend=await evaluate(`[...document.querySelectorAll('tr[data-branch]')].map(row=>({branch:Number(row.cells[0].textContent),scores:[...row.querySelectorAll('td[data-risk]:not(.tren-kc-trend)')].slice(0,6).map(c=>c.textContent.trim().replace(',','.').replace('—','–'))}))`);
  assert.deepEqual(trend,reports[0],'Trend and both recap pages must display identical six risk scores for the same period');
  assert.equal(reports[0].find(r=>r.branch===8).scores[5],'4.07','Wonogiri strategic must match profile, not stale 4.22');
  console.log('PASS: real route and GET filters, all 28 branches, 7-branch region, all period scores, composite rightmost, menu active, risk/search filters, missing/invalid range and mobile width');
  console.log('PASS: all six risks agree across KC results, regional recap and KC trend; Wonogiri TW 3 strategic is 4.07');
  await send('Browser.close').catch(()=>{});
 } finally {
  if(socket)socket.close();chrome.kill();await delay(300);
  if(path.dirname(path.resolve(profile))===path.resolve(os.tmpdir()))try{fs.rmSync(profile,{recursive:true,force:true,maxRetries:3,retryDelay:200});}catch{}
  await fetch(base+'admin/logout.php',{headers:{Cookie:'PHPSESSID='+cookie}});
 }
})().catch(e=>{console.error(e.stack);process.exitCode=1;});
