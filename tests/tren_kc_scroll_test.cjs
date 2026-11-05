// Exercise the real DataTables Excel/PDF/print actions on both report pages.
const assert=require('node:assert/strict');
const fs=require('node:fs');
const path=require('node:path');
const os=require('node:os');
const {spawn,execFileSync}=require('node:child_process');
const root=path.resolve(__dirname,'..'),base='http://127.0.0.1/profil_risiko_v2/';

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
 const profile=fs.mkdtempSync(path.join(os.tmpdir(),'tren-scroll-chrome-'));
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
  await cmd('Emulation.setDeviceMetricsOverride',{width:1440,height:1000,deviceScaleFactor:1,mobile:false});
  await cmd('Page.navigate',{url:base+'admin/tren_profil_kc?start_year=2026&start_quarter=1&end_year=2026&end_quarter=3&wilayah=solo'});
  await waitFor(`!!window.TrenKCExport&&document.readyState==='complete'&&!document.body.classList.contains('loading')`);
  for(const zoom of [1,.9,1.1,1.25]){
   await evaluate(`document.body.style.zoom='${zoom}';window.__scrollEvents=[];`);await delay(100);
   await evaluate(`(()=>{const a=document.querySelector('.tren-kc-scroll'),b=document.querySelector('.tren-kc-scroll-top');window.__scrollEvents=[];if(!a.dataset.probe){[a,b].forEach((node,i)=>node.addEventListener('scroll',()=>{if(window.__scrollEvents.length<2000)window.__scrollEvents.push({source:i,left:node.scrollLeft});},{passive:true}));a.dataset.probe='1';}})()`);
   for(const source of ['.tren-kc-scroll','.tren-kc-scroll-top']){
    await evaluate(`document.querySelector('${source}').scrollLeft=0`);await delay(100);
    const result=await evaluate(`(async()=>{const node=document.querySelector('${source}'),code=document.querySelector('tbody .tren-code'),branch=document.querySelector('tbody .tren-branch');const anchor=[code.getBoundingClientRect().left,branch.getBoundingClientRect().left];window.__scrollEvents=[];for(let frame=0;frame<24;frame++){node.scrollLeft=(frame+1)*31.37;await new Promise(requestAnimationFrame);}await new Promise(r=>setTimeout(r,180));const events=window.__scrollEvents.slice();const after=[code.getBoundingClientRect().left,branch.getBoundingClientRect().left];return {events,anchor,after,main:document.querySelector('.tren-kc-scroll').scrollLeft,top:document.querySelector('.tren-kc-scroll-top').scrollLeft};})()`);
    const own=result.events.filter(e=>e.source===(source.endsWith('-top')?1:0));
    assert(own.every((event,i)=>i===0||event.left>=own[i-1].left-.1),'Scroll reversed during forward movement: '+JSON.stringify({zoom,source,own}));
    assert(result.events.length<100,'Feedback loop kept firing: '+JSON.stringify({zoom,source,events:result.events.length}));
    assert(Math.abs(result.main-result.top)<2,'Scrollbars desynchronised');
    assert(result.anchor.every((v,i)=>Math.abs(v-result.after[i])<1),'Sticky identity column moved');
    const settled=await evaluate('window.__scrollEvents.length');await delay(150);assert.equal(await evaluate('window.__scrollEvents.length'),settled,'Scrolling keeps oscillating after input stops');
    const backward=await evaluate(`(async()=>{const node=document.querySelector('${source}');window.__scrollEvents=[];for(let frame=0;frame<12;frame++){node.scrollLeft-=31.37;await new Promise(requestAnimationFrame);}await new Promise(r=>setTimeout(r,150));return {events:window.__scrollEvents.slice(),main:document.querySelector('.tren-kc-scroll').scrollLeft,top:document.querySelector('.tren-kc-scroll-top').scrollLeft};})()`);
    const ownBackward=backward.events.filter(e=>e.source===(source.endsWith('-top')?1:0));
    assert(ownBackward.every((event,i)=>i===0||event.left<=ownBackward[i-1].left+.1),'Scroll reversed during backward movement');
    assert(backward.events.length<60&&Math.abs(backward.main-backward.top)<2,'Backward movement caused feedback/desynchronisation');
   }
   await evaluate(`document.querySelector('.tren-kc-scroll-top').scrollLeft=100000`);await delay(150);
   assert(await evaluate(`(()=>{const a=document.querySelector('.tren-kc-scroll'),b=document.querySelector('.tren-kc-scroll-top');return Math.abs(a.scrollLeft-(a.scrollWidth-a.clientWidth))<2&&Math.abs(b.scrollLeft-(b.scrollWidth-b.clientWidth))<2;})()`),'Final columns clipped');
   console.log('PASS CSS zoom '+zoom+': both directions of scrollbar sync, monotonic movement, stable sticky columns and no events after input stops');
  }
  // Model fractional CSS zoom where the proxy scrollbar rounds to whole pixels.
  // Mirrored scroll events must not call the setter of the user's source scroller.
  await evaluate(`document.body.style.zoom='.9'`);await delay(150);
  const rounding=await evaluate(`(async()=>{const source=document.querySelector('.tren-kc-scroll'),proxy=document.querySelector('.tren-kc-scroll-top'),native=Object.getOwnPropertyDescriptor(Element.prototype,'scrollLeft');let sourceWrites=0;Object.defineProperty(source,'scrollLeft',{configurable:true,get(){return native.get.call(this);},set(value){sourceWrites++;native.set.call(this,value);}});Object.defineProperty(proxy,'scrollLeft',{configurable:true,get(){return Math.round(native.get.call(this));},set(value){native.set.call(this,Math.round(value));}});source.scrollLeft=331.37;const initial=source.scrollLeft;sourceWrites=0;await new Promise(r=>setTimeout(r,220));const result={sourceWrites,initial,final:source.scrollLeft,proxy:proxy.scrollLeft};delete source.scrollLeft;delete proxy.scrollLeft;return result;})()`);
  assert.equal(rounding.sourceWrites,0,'Mirror wrote back into active source at fractional zoom: '+JSON.stringify(rounding));
  assert.equal(rounding.final,rounding.initial,'Source position was corrected by its own mirror');
  console.log('PASS fractional rounding: no write-back into active source');
  await evaluate(`document.body.style.zoom='1';document.querySelector('.tren-kc-scroll').scrollIntoView({block:'center'});document.querySelector('.tren-kc-scroll').scrollLeft=0;`);await delay(100);
  const point=await evaluate(`(()=>{const r=document.querySelector('.tren-kc-scroll').getBoundingClientRect();return {x:r.left+r.width*.6,y:Math.max(100,Math.min(innerHeight-60,r.top+100))};})()`);
  for(let i=0;i<6;i++){await cmd('Input.dispatchMouseEvent',{type:'mouseWheel',x:point.x,y:point.y,deltaX:90,deltaY:0});await delay(40);}
  assert(await evaluate(`document.querySelector('.tren-kc-scroll').scrollLeft>200`),'Native horizontal wheel did not move');
  const wheelEnd=await evaluate(`document.querySelector('.tren-kc-scroll').scrollLeft`);
  for(let i=0;i<4;i++){await cmd('Input.dispatchMouseEvent',{type:'mouseWheel',x:point.x,y:point.y,deltaX:-90,deltaY:0});await delay(40);}
  assert(await evaluate(`document.querySelector('.tren-kc-scroll').scrollLeft<${wheelEnd}-100`),'Native reverse wheel did not move');
  // Native wheel is dispatched above. Thumb-drag positions follow the same scroll
  // events; exercise pointer ownership explicitly without depending on OS scrollbar
  // hit testing, which CDP does not reliably expose in headless Windows Chrome.
  const pointerDrag=await evaluate(`(async()=>{const top=document.querySelector('.tren-kc-scroll-top'),main=document.querySelector('.tren-kc-scroll');main.scrollLeft=200;top.dispatchEvent(new PointerEvent('pointerdown',{bubbles:true}));for(let i=1;i<=12;i++){top.scrollLeft=200+i*25.37;await new Promise(requestAnimationFrame);}top.dispatchEvent(new PointerEvent('pointerup',{bubbles:true}));await new Promise(r=>setTimeout(r,150));return {main:main.scrollLeft,top:top.scrollLeft};})()`);
  assert(pointerDrag.main>450&&Math.abs(pointerDrag.main-pointerDrag.top)<2,'Pointer drag positions did not synchronise');
  console.log('PASS native horizontal wheel in both directions and pointer-drag scroll event flow');
  await send('Browser.close').catch(()=>{});
 } finally {
  if(socket)socket.close();chrome.kill();await delay(300);
  if(path.dirname(path.resolve(profile))===path.resolve(os.tmpdir()))try{fs.rmSync(profile,{recursive:true,force:true,maxRetries:3,retryDelay:200});}catch{}
  await fetch(base+'admin/logout.php',{headers:{Cookie:'PHPSESSID='+cookie}});
 }
})().catch(error=>{console.error(error.stack);process.exitCode=1;});
