// Exercise the real DataTables Excel/PDF/print actions on both report pages.
const assert=require('node:assert/strict');
const fs=require('node:fs');
const path=require('node:path');
const os=require('node:os');
const {spawn,execFileSync}=require('node:child_process');
const root=path.resolve(__dirname,'..'),base='http://127.0.0.1/profil_risiko_v2/';
const output=path.join(root,'.local','risk-export-review');fs.mkdirSync(output,{recursive:true});
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
 const profile=fs.mkdtempSync(path.join(os.tmpdir(),'risk-export-chrome-'));
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
  const cases=[{name:'hasil-kc-all',page:'hasil_lapkc'}, {name:'hasil-kc-ops',page:'hasil_lapkc',view:'operasional',search:'Rembang'}, {name:'rekap-korwil-solo',page:'rekap_cbg',view:'ringkasan',region:'solo'}];
  for(const item of cases){
   await cmd('Page.navigate',{url:base+'admin/'+item.page+'?tahun=2026&periode=2&status_laporan=semua'});
   await waitFor(`window.jQuery && jQuery.fn.dataTable && jQuery.fn.dataTable.isDataTable('#datatable-buttons1') && !!document.querySelector('.buttons-pdf')`);
   await evaluate(`(()=>{const t=jQuery('#datatable-buttons1').DataTable();${item.view?`jQuery('#hasil-risk-view').val(${JSON.stringify(item.view)}).trigger('change');`:''}${item.search?`t.search(${JSON.stringify(item.search)}).draw();`:''}${item.region?`document.querySelector('.hasil-region-tabs [data-region="${item.region}"]').click();`:''}t.order([[1,'desc']]).draw();})()`);
   const expected=await evaluate(`(()=>{const t=jQuery('#datatable-buttons1').DataTable(),cols=t.columns(':visible').indexes().toArray();return {headers:cols.map(c=>t.column(c).header().textContent.trim()),rows:t.rows({search:'applied',order:'applied'}).indexes().toArray().map(r=>cols.map(c=>{const n=t.cell(r,c).node();return {text:n.textContent.trim().replace(/\\s+/g,' '),bg:n.classList.contains('hasil-pillar-cell')?getComputedStyle(n).backgroundColor:null};}))};})()`);
   assert(expected.rows.length>0);if(item.search)assert.equal(expected.rows.length,1);if(item.region)assert.equal(expected.rows.length,7);
   fs.writeFileSync(path.join(output,item.name+'.expected.json'),JSON.stringify(expected,null,2));
   await evaluate(`(()=>{window.__exported=[];function encode(buffer){const bytes=new Uint8Array(buffer);let s='';for(let i=0;i<bytes.length;i+=8192)s+=String.fromCharCode.apply(null,bytes.subarray(i,i+8192));return btoa(s);}const original=JSZip.prototype.generateAsync;JSZip.prototype.generateAsync=function(options){return original.call(this,options).then(async blob=>{if(options.type==='blob')window.__exported.push({type:'xlsx',data:encode(await blob.arrayBuffer())});return blob;});};const create=pdfMake.createPdf.bind(pdfMake);pdfMake.createPdf=function(doc){window.__pdfDocument=doc;const pdf=create(doc);pdf.download=function(){pdf.getBase64(data=>window.__exported.push({type:'pdf',data}));};return pdf;};jQuery('#datatable-buttons1').DataTable().button('.buttons-excel').trigger();})()`);
   await waitFor(`window.__exported.some(x=>x.type==='xlsx')`);
   await evaluate(`void jQuery('#datatable-buttons1').DataTable().button('.buttons-pdf').trigger()`);
   await waitFor(`window.__exported.some(x=>x.type==='pdf')`);
   for(const file of await evaluate('window.__exported'))fs.writeFileSync(path.join(output,item.name+'.'+file.type),Buffer.from(file.data,'base64'));
   const printCheck=await evaluate(`(()=>{const f=document.createElement('iframe');f.style.display='none';document.body.appendChild(f);window.__printFrame=f;window.open=function(){const win=f.contentWindow;win.print=function(){};win.close=function(){};return win;};jQuery('#datatable-buttons1').DataTable().button('.buttons-print').trigger();const doc=f.contentDocument;return {legend:doc.body.textContent.includes('Keterangan warna berdasarkan peringkat'),tables:[...doc.querySelectorAll('table')].map(t=>({headers:[...t.tHead.rows[0].cells].map(c=>c.textContent.trim()),cells:[...t.tBodies[0].rows].map(r=>[...r.cells].map(c=>c.style.backgroundColor||null))})),colourExact:[...doc.querySelectorAll('style')].some(s=>s.textContent.includes('print-color-adjust:exact'))};})()`);
   assert(printCheck.legend&&printCheck.colourExact);
   for(const table of printCheck.tables){assert.equal(table.cells.length,expected.rows.length);table.headers.forEach((header,c)=>{const source=expected.headers.indexOf(header);assert(source>=0);expected.rows.forEach((row,r)=>{if(row[source].bg)assert.equal(table.cells[r][c],row[source].bg,'Print colour differs from web');});});}
   assert(expected.headers.every(header=>printCheck.tables.some(t=>t.headers.includes(header))),'Print lost a visible column');
   console.log('PASS '+item.name+': actual XLSX/PDF/print, visible columns and filtered/sorted rows');
  }
  await send('Browser.close').catch(()=>{});
 } finally {
  if(socket)socket.close();chrome.kill();await delay(300);
  if(path.dirname(path.resolve(profile))===path.resolve(os.tmpdir()))try{fs.rmSync(profile,{recursive:true,force:true,maxRetries:3,retryDelay:200});}catch{}
  await fetch(base+'admin/logout.php',{headers:{Cookie:'PHPSESSID='+cookie}});
 }
})().catch(error=>{console.error(error.stack);process.exitCode=1;});
