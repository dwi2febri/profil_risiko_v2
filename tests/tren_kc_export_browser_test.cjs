// Exercise the real DataTables Excel/PDF/print actions on both report pages.
const assert=require('node:assert/strict');
const fs=require('node:fs');
const path=require('node:path');
const os=require('node:os');
const {spawn,execFileSync}=require('node:child_process');
const root=path.resolve(__dirname,'..'),base='http://127.0.0.1/profil_risiko_v2/';
const output=path.join(root,'.local','tren-kc-export-review');fs.mkdirSync(output,{recursive:true});
const delay=ms=>new Promise(resolve=>setTimeout(resolve,ms));
function login(){
 const code=`<?php
 require getcwd().'/conn/conn.php';
 $account=mysqli_fetch_assoc(simpro_db_query($conn,'SELECT username,password FROM user WHERE tipe=? ORDER BY user_id LIMIT 1',['admin']));
 $c=curl_init('${base}');curl_setopt_array($c,[CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>http_build_query($account),CURLOPT_RETURNTRANSFER=>true,CURLOPT_COOKIEFILE=>'',CURLOPT_TIMEOUT=>20]);curl_exec($c);
 $cookie='';foreach(curl_getinfo($c,CURLINFO_COOKIELIST) as $line){$v=explode(chr(9),$line);if($v[5]==='PHPSESSID')$cookie=$v[6];}echo json_encode(['cookie'=>$cookie]);`;
 return JSON.parse(execFileSync('php',[],{cwd:root,input:code,encoding:'utf8'})).cookie;
}
(async()=>{
 const cookie=login();assert(cookie);
 const profile=fs.mkdtempSync(path.join(os.tmpdir(),'tren-export-chrome-'));
 const chrome=spawn('C:/Program Files/Google/Chrome/Application/chrome.exe',['--headless','--disable-gpu','--no-sandbox','--no-first-run','--disable-background-networking','--disk-cache-size=1','--remote-debugging-port=0','--user-data-dir='+profile],{windowsHide:true,stdio:'ignore'});
 let socket;
 try {
  const portFile=path.join(profile,'DevToolsActivePort');for(let i=0;i<100&&!fs.existsSync(portFile);i++)await delay(100);
  const port=fs.readFileSync(portFile,'utf8').split('\n')[0],version=await(await fetch('http://127.0.0.1:'+port+'/json/version')).json();
  socket=new WebSocket(version.webSocketDebuggerUrl);await new Promise((resolve,reject)=>{socket.onopen=resolve;socket.onerror=reject;});
  let seq=0;const pending=new Map();
  socket.onmessage=event=>{const packet=JSON.parse(event.data);if(pending.has(packet.id)){const p=pending.get(packet.id);clearTimeout(p.timer);pending.delete(packet.id);packet.error?p.reject(Error(packet.error.message)):p.resolve(packet.result);}};
  const send=(method,params={},sessionId)=>new Promise((resolve,reject)=>{const id=++seq,timer=setTimeout(()=>{pending.delete(id);reject(Error('CDP timeout: '+method));},method==='Browser.close'?2000:30000);pending.set(id,{resolve,reject,timer});socket.send(JSON.stringify({id,method,params,...(sessionId?{sessionId}:{})}));});
  const {targetId}=await send('Target.createTarget',{url:'about:blank'}),{sessionId}=await send('Target.attachToTarget',{targetId,flatten:true});
  const cmd=(method,params)=>send(method,params,sessionId);
  const evaluate=async expression=>{const r=await cmd('Runtime.evaluate',{expression,returnByValue:true,awaitPromise:true});if(r.exceptionDetails)throw Error(r.exceptionDetails.exception?.description||r.exceptionDetails.text);return r.result.value;};
  const waitFor=async expression=>{for(let i=0;i<150;i++){if(await evaluate(expression))return;await delay(200);}throw Error('Wait failed: '+expression);};
  await cmd('Page.enable');await cmd('Network.enable');await cmd('Network.setCookie',{name:'PHPSESSID',value:cookie,domain:'127.0.0.1',path:'/'});
  await send('Browser.setDownloadBehavior',{behavior:'deny'});
  const cases=[
   {name:'all',query:'start_year=2026&start_quarter=1&end_year=2026&end_quarter=3&wilayah=semua'},
   {name:'filtered',query:'start_year=2026&start_quarter=1&end_year=2026&end_quarter=3&wilayah=solo',risk:'operasional',search:'Wonogiri'},
   {name:'long',query:'start_year=2024&start_quarter=1&end_year=2026&end_quarter=2&wilayah=solo',risk:'kredit'},
   {name:'empty',query:'start_year=2099&start_quarter=1&end_year=2099&end_quarter=2&wilayah=solo'}
  ];
  for(const item of cases){
   await cmd('Page.navigate',{url:base+'admin/tren_profil_kc?'+item.query});
   await waitFor(`!!window.TrenKCExport`);
   if(item.risk)await evaluate(`document.getElementById('tren-risk-view').value=${JSON.stringify(item.risk)};document.getElementById('tren-risk-view').dispatchEvent(new Event('change'));`);
   if(item.search)await evaluate(`document.getElementById('tren-branch-search').value=${JSON.stringify(item.search)};document.getElementById('tren-branch-search').dispatchEvent(new Event('input'));`);
   const expected=await evaluate('TrenKCExport.snapshot()');
   assert.equal(expected.groups.at(-1).key,'komposit');
   assert.equal(expected.rows.filter(r=>!r.area).length,item.search?1:item.name==='all'?28:7);
   if(item.risk)assert.deepEqual(expected.groups.map(g=>g.key),[item.risk,'komposit']);
   fs.writeFileSync(path.join(output,item.name+'.expected.json'),JSON.stringify(expected,null,2));
   await evaluate(`(()=>{window.__exports=[];const original=URL.createObjectURL.bind(URL);URL.createObjectURL=function(blob){blob.arrayBuffer().then(buffer=>{let text='';const bytes=new Uint8Array(buffer);for(let i=0;i<bytes.length;i+=8192)text+=String.fromCharCode.apply(null,bytes.subarray(i,i+8192));window.__exports.push({kind:blob.type.includes('pdf')?'pdf':'xlsx',data:btoa(text)});});return original(blob);};document.getElementById('tren-export-excel').click();})()`);
   await waitFor(`window.__exports.some(e=>e.kind==='xlsx')||document.getElementById('tren-export-status').textContent.includes('gagal')`);
   assert(!await evaluate(`document.getElementById('tren-export-status').textContent.includes('gagal')`),await evaluate(`document.getElementById('tren-export-status').textContent`));
   await evaluate(`document.getElementById('tren-export-pdf').click()`);
   await waitFor(`window.__exports.some(e=>e.kind==='pdf')||document.getElementById('tren-export-status').textContent.includes('gagal')`);
   assert(!await evaluate(`document.getElementById('tren-export-status').textContent.includes('gagal')`),await evaluate(`document.getElementById('tren-export-status').textContent`));
   for(const file of await evaluate('window.__exports'))fs.writeFileSync(path.join(output,item.name+'.'+file.kind),Buffer.from(file.data,'base64'));
   assert.equal(await evaluate(`document.querySelectorAll('.tren-kc-export-tools button:disabled').length`),0);
   console.log('PASS '+item.name+': real Excel/PDF buttons, visible risks and branches, applied period/region/search and composite last');
  }
  await send('Browser.close').catch(()=>{});
 } finally {
  if(socket)socket.close();chrome.kill();await delay(300);
  if(path.dirname(path.resolve(profile))===path.resolve(os.tmpdir()))try{fs.rmSync(profile,{recursive:true,force:true,maxRetries:3,retryDelay:200});}catch{}
  await fetch(base+'admin/logout.php',{headers:{Cookie:'PHPSESSID='+cookie}});
 }
})().catch(error=>{console.error(error.stack);process.exitCode=1;});
