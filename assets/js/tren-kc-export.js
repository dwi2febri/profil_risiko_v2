/* Export the applied range, visible risks and searched branches; no server writes. */
(function () {
    'use strict';
    var table=document.querySelector('.tren-kc-table'),context=window.trenKCExportContext;if(!table||!context)return;
    var bands={blue:['Sangat rendah','E7F1FF','1746A2'],green:['Rendah','E9F8ED','176534'],yellow:['Sedang','FFF7CC','735400'],orange:['Tinggi','FFF0DC','943C09'],red:['Sangat tinggi','FDE7E7','A61E25']};
    var inherent='Inheren: 1–1,25; >1,25–2,25; >2,25–3,25; >3,25–4,25; >4,25–5.';
    var composite='Komposit: <1,25; 1,25–<2,25; 2,25–<3,25; 3,25–<4,25; ≥4,25.';
    var note='—: nilai belum tersedia. Garis terputus pada periode kosong. Δ = akhir dikurangi awal; nilai turun menunjukkan risiko membaik.';
    var means='Rata-rata wilayah mengikuti filter wilayah; pencarian menyaring cabang saja. Jumlah sampel dapat berubah antarperiode.';
    function text(node){return node.textContent.trim().replace(/\s+/g,' ');}
    function snapshot(){
        var groups=Array.from(table.tHead.rows[0].querySelectorAll('[data-risk]:not([hidden])')).map(function(head){
            var key=head.dataset.risk;return {key:key,name:text(head),periods:Array.from(table.tHead.rows[1].querySelectorAll('[data-risk="'+key+'"]:not(.tren-kc-trend)')).map(function(header){return Array.from(header.childNodes).map(function(node){return node.nodeName==='BR'?' ':node.textContent;}).join('').trim();})};
        });
        var rows=Array.from(table.tBodies[0].rows).filter(function(row){return !row.hidden;}).map(function(row){
            var area=row.classList.contains('tren-kc-area');
            return {area:area,code:area?'':text(row.cells[0]),name:text(row.cells[area?0:1]),groups:groups.map(function(group){
                var cells=Array.from(row.querySelectorAll('td[data-risk="'+group.key+'"]:not(.tren-kc-trend)'));
                var trend=row.querySelector('td.tren-kc-trend[data-risk="'+group.key+'"]');
                return {cells:cells.map(function(cell){var raw=cell.querySelector('a')?text(cell.querySelector('a')):cell.firstChild.textContent.trim();var value=Number(raw.replace(',','.'));return {value:Number.isFinite(value)&&raw!=='—'?value:null,band:Object.keys(bands).find(function(key){return cell.classList.contains('hasil-pillar-'+key);})||null,sample:cell.querySelector('small')?text(cell.querySelector('small')):''};}),delta:trend.querySelector('small')?text(trend.querySelector('small')):'—'};
            })};
        });
        var search=document.getElementById('tren-branch-search').value.trim();
        return {title:'Tren Profil Risiko Kantor Cabang',metadata:context.region+' | '+context.range+' | '+document.getElementById('tren-risk-view').selectedOptions[0].text+(search?' | Pencarian: '+search:''),groups:groups,rows:rows};
    }
    function points(values){return values.map(function(value,index){return value===null?null:[values.length===1?55:5+index*100/(values.length-1),33-(value-1)*7];});}
    function svg(values){
        var positions=points(values),path=[],parts=[];
        function flush(){if(path.length)parts.push('<polyline points="'+path.join(' ')+'" fill="none" stroke="#42668e" stroke-width="1.6"/>');path=[];}
        positions.forEach(function(point){if(point)path.push(point.join(','));else flush();});flush();
        positions.forEach(function(point){if(point)parts.push('<circle cx="'+point[0]+'" cy="'+point[1]+'" r="1.8" fill="#42668e"/>');});
        return '<svg xmlns="http://www.w3.org/2000/svg" width="110" height="38" viewBox="0 0 110 38">'+parts.join('')+'</svg>';
    }
    function png(values){
        var canvas=document.createElement('canvas');canvas.width=220;canvas.height=76;var draw=canvas.getContext('2d');draw.scale(2,2);draw.strokeStyle='#42668e';draw.fillStyle='#42668e';draw.lineWidth=1.6;var active=false;
        draw.beginPath();points(values).forEach(function(point){if(!point){active=false;return;}if(active)draw.lineTo(point[0],point[1]);else draw.moveTo(point[0],point[1]);active=true;});draw.stroke();
        points(values).forEach(function(point){if(point){draw.beginPath();draw.arc(point[0],point[1],1.8,0,Math.PI*2);draw.fill();}});
        return canvas.toDataURL('image/png').split(',')[1];
    }
    function escape(value){return String(value).replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F]/g,'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}
    function col(index){var name='';do{name=String.fromCharCode(65+index%26)+name;index=Math.floor(index/26)-1;}while(index>=0);return name;}
    function cell(column,row,value,style){var address=col(column)+row;if(typeof value==='number')return '<c r="'+address+'" s="'+style+'"><v>'+value+'</v></c>';return '<c r="'+address+'" s="'+style+'" t="inlineStr"><is><t xml:space="preserve">'+escape(value)+'</t></is></c>';}
    function excel(data){
        if(!window.JSZip)throw Error('Library Excel belum tersedia.');
        var zip=new JSZip(),count=2+data.groups.reduce(function(sum,g){return sum+g.periods.length+1;},0),last=col(count-1),merges=[],rows=[],drawings=[],relations=[],images=0;
        var styles=[{fill:0,font:0,format:0,align:'left'},{fill:2,font:1,format:0,align:'center'},{fill:0,font:0,format:2,align:'center'},{fill:0,font:0,format:0,align:'center',vertical:'bottom'},{fill:2,font:1,format:0,align:'left'}],styleCache={};
        Object.keys(bands).forEach(function(key,index){styles.push({fill:index+3,font:index+2,format:2,align:'center'});});
        var samples=[];
        function scoreStyle(score){var base=score.band?5+Object.keys(bands).indexOf(score.band):2;if(!score.sample)return base;var key=base+'|'+score.sample;if(styleCache[key]!==undefined)return styleCache[key];var format=164+samples.indexOf(score.sample);if(format<164){samples.push(score.sample);format=163+samples.length;}var id=styles.length;styles.push(Object.assign({},styles[base],{format:format}));styleCache[key]=id;return id;}
        function line(row,value,style){rows.push('<row r="'+row+'" ht="22" customHeight="1">'+cell(0,row,value,style||0)+'</row>');merges.push('A'+row+':'+last+row);}
        line(1,data.title,4);line(2,data.metadata);line(3,note);line(4,'Keterangan warna berdasarkan peringkat',4);
        Object.keys(bands).forEach(function(key,index){var row=5+index;rows.push('<row r="'+row+'">'+cell(0,row,bands[key][0],5+index)+cell(2,row,index===0?inherent: index===1?composite:'',0)+'</row>');merges.push('A'+row+':B'+row,'C'+row+':'+last+row);});
        line(10,means);
        var first=cell(0,13,'Kode',1)+cell(1,13,'Kantor Cabang',1),second='',offset=2;
        merges.push('A13:A14','B13:B14');
        data.groups.forEach(function(group){first+=cell(offset,13,group.name,1);merges.push(col(offset)+'13:'+col(offset+group.periods.length)+'13');group.periods.forEach(function(period,i){second+=cell(offset+i,14,period,1);});second+=cell(offset+group.periods.length,14,'Tren / Δ awal–akhir',1);offset+=group.periods.length+1;});
        rows.push('<row r="13" ht="25" customHeight="1">'+first+'</row>','<row r="14" ht="30" customHeight="1">'+second+'</row>');
        data.rows.forEach(function(row,index){var number=15+index,content=cell(0,number,row.code,row.area?4:0)+cell(1,number,row.name,row.area?4:0);if(row.area){content=cell(0,number,row.name,4);merges.push('A'+number+':B'+number);}var column=2;
            row.groups.forEach(function(group){group.cells.forEach(function(score){content+=cell(column++,number,score.value===null?'—':score.value,scoreStyle(score));});content+=cell(column,number,group.delta,3);
                var values=group.cells.map(function(score){return score.value;});
                if(values.some(function(value){return value!==null;})){
                    images++;zip.file('xl/media/trend'+images+'.png',png(values),{base64:true});
                    relations.push('<Relationship Id="rId'+images+'" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/image" Target="../media/trend'+images+'.png"/>');
                    drawings.push('<xdr:oneCellAnchor><xdr:from><xdr:col>'+column+'</xdr:col><xdr:colOff>47625</xdr:colOff><xdr:row>'+(number-1)+'</xdr:row><xdr:rowOff>19050</xdr:rowOff></xdr:from><xdr:ext cx="1047750" cy="361950"/><xdr:pic><xdr:nvPicPr><xdr:cNvPr id="'+images+'" name="Tren '+images+'"/><xdr:cNvPicPr/></xdr:nvPicPr><xdr:blipFill><a:blip r:embed="rId'+images+'"/><a:stretch><a:fillRect/></a:stretch></xdr:blipFill><xdr:spPr><a:prstGeom prst="rect"><a:avLst/></a:prstGeom></xdr:spPr></xdr:pic><xdr:clientData/></xdr:oneCellAnchor>');
                }column++;
            });rows.push('<row r="'+number+'" ht="44" customHeight="1">'+content+'</row>');
        });
        var columns='<col min="1" max="1" width="9" customWidth="1"/><col min="2" max="2" width="30" customWidth="1"/>';offset=3;
        data.groups.forEach(function(group){columns+='<col min="'+offset+'" max="'+(offset+group.periods.length-1)+'" width="12" customWidth="1"/><col min="'+(offset+group.periods.length)+'" max="'+(offset+group.periods.length)+'" width="19" customWidth="1"/>';offset+=group.periods.length+1;});
        var sheet='<?xml version="1.0" encoding="UTF-8" standalone="yes"?><worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><dimension ref="A1:'+last+(14+data.rows.length)+'"/><sheetViews><sheetView workbookViewId="0"><pane xSplit="2" ySplit="14" topLeftCell="C15" activePane="bottomRight" state="frozen"/></sheetView></sheetViews><sheetFormatPr defaultRowHeight="18"/><cols>'+columns+'</cols><sheetData>'+rows.join('')+'</sheetData><mergeCells count="'+merges.length+'">'+merges.map(function(ref){return '<mergeCell ref="'+ref+'"/>';}).join('')+'</mergeCells><pageMargins left="0.25" right="0.25" top="0.4" bottom="0.4" header="0.15" footer="0.15"/><pageSetup orientation="landscape" paperSize="8"/>'+(images?'<drawing r:id="rId1"/>':'')+'</worksheet>';
        var fonts='<font><sz val="11"/><name val="Calibri"/><color rgb="FF23364D"/></font><font><b/><sz val="11"/><name val="Calibri"/><color rgb="FF23364D"/></font>'+Object.keys(bands).map(function(key){return '<font><b/><sz val="11"/><name val="Calibri"/><color rgb="FF'+bands[key][2]+'"/></font>';}).join('');
        var fills='<fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>'+['E9F0F8'].concat(Object.keys(bands).map(function(key){return bands[key][1];})).map(function(color){return '<fill><patternFill patternType="solid"><fgColor rgb="FF'+color+'"/><bgColor indexed="64"/></patternFill></fill>';}).join('');
        var formatXml=samples.length?'<numFmts count="'+samples.length+'">'+samples.map(function(sample,index){return '<numFmt numFmtId="'+(164+index)+'" formatCode="'+escape('0.00" ('+sample+')"')+'"/>';}).join('')+'</numFmts>':'';
        var styleXml='<?xml version="1.0" encoding="UTF-8"?><styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'+formatXml+'<fonts count="7">'+fonts+'</fonts><fills count="8">'+fills+'</fills><borders count="1"><border><left style="thin"><color rgb="FFD8E1EB"/></left><right style="thin"><color rgb="FFD8E1EB"/></right><top style="thin"><color rgb="FFD8E1EB"/></top><bottom style="thin"><color rgb="FFD8E1EB"/></bottom><diagonal/></border></borders><cellStyleXfs count="1"><xf numFmtId="0" fontId="0" fillId="0" borderId="0"/></cellStyleXfs><cellXfs count="'+styles.length+'">'+styles.map(function(style){return '<xf numFmtId="'+style.format+'" fontId="'+style.font+'" fillId="'+style.fill+'" borderId="0" xfId="0" applyAlignment="1" applyFill="1" applyFont="1" applyNumberFormat="1"><alignment horizontal="'+style.align+'" vertical="'+(style.vertical||'center')+'" wrapText="1"/></xf>';}).join('')+'</cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>';
        zip.file('xl/styles.xml',styleXml);zip.file('xl/worksheets/sheet1.xml',sheet);
        zip.file('xl/workbook.xml','<?xml version="1.0" encoding="UTF-8"?><workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Tren Profil KC" sheetId="1" r:id="rId1"/></sheets></workbook>');
        zip.file('xl/_rels/workbook.xml.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
        zip.file('_rels/.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
        if(images){zip.file('xl/worksheets/_rels/sheet1.xml.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/drawing" Target="../drawings/drawing1.xml"/></Relationships>');zip.file('xl/drawings/drawing1.xml','<xdr:wsDr xmlns:xdr="http://schemas.openxmlformats.org/drawingml/2006/spreadsheetDrawing" xmlns:a="http://schemas.openxmlformats.org/drawingml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'+drawings.join('')+'</xdr:wsDr>');zip.file('xl/drawings/_rels/drawing1.xml.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'+relations.join('')+'</Relationships>');}
        zip.file('[Content_Types].xml','<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Default Extension="png" ContentType="image/png"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'+(images?'<Override PartName="/xl/drawings/drawing1.xml" ContentType="application/vnd.openxmlformats-officedocument.drawing+xml"/>':'')+'</Types>');
        return zip.generateAsync({type:'blob',mimeType:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',compression:'DEFLATE'});
    }
    function pdf(data){
        var content=[];
        data.groups.forEach(function(group,g){for(var start=0;start<group.periods.length;start+=8){
            var end=Math.min(start+8,group.periods.length),body=[[{text:'Kode',style:'header'},{text:'Kantor Cabang',style:'header'}].concat(group.periods.slice(start,end).map(function(period){return {text:period,style:'header'};}),[{text:'Tren seluruh rentang / Δ',style:'header'}])];
            data.rows.forEach(function(row){var values=row.groups[g],items=[{text:row.code,bold:row.area},{text:row.name,bold:row.area}];
                values.cells.slice(start,end).forEach(function(score){var band=score.band?bands[score.band]:null;items.push({text:[{text:score.value===null?'—':score.value.toFixed(2).replace('.',','),bold:true},...(score.sample?[{text:'\n'+score.sample,fontSize:6,bold:false}]:[])],alignment:'center',fillColor:band?'#'+band[1]:row.area?'#e9f0f8':'#ffffff',color:band?'#'+band[2]:'#23364d'});});
                var scores=values.cells.map(function(score){return score.value;});items.push({stack:[...(scores.some(function(value){return value!==null;})?[{svg:svg(scores),width:70,height:9,alignment:'center'}]:[]),{text:values.delta,fontSize:6,alignment:'center'}]});body.push(items);
            });
            content.push({text:data.title+' — '+group.name,bold:true,fontSize:14,margin:[0,0,0,5],...(content.length?{pageBreak:'before'}:{})},{text:data.metadata,fontSize:8,margin:[0,0,0,6]},{table:{widths:['*','*','*','*','*'],body:[Object.keys(bands).map(function(key){return {text:bands[key][0],fillColor:'#'+bands[key][1],color:'#'+bands[key][2],fontSize:8,margin:[3,3,3,3]};})]},layout:'noBorders'},{text:inherent+'\n'+composite+'\n'+note,fontSize:7,margin:[0,5,0,7]}, {text:'Kolom periode: '+group.periods[start]+' sampai '+group.periods[end-1],fontSize:8,margin:[0,0,0,5]}, {table:{headerRows:1,dontBreakRows:true,widths:[28,120].concat(Array(end-start).fill('*'),[92]),body:body},layout:{hLineWidth:function(){return .4;},vLineWidth:function(){return .4;},hLineColor:function(){return '#d8e1eb';},vLineColor:function(){return '#d8e1eb';},paddingLeft:function(){return 3;},paddingRight:function(){return 3;}}},{text:means,fontSize:7,margin:[0,7,0,0]});
        }});
        return {pageSize:data.rows.length>12?'A3':'A4',pageOrientation:'landscape',pageMargins:[20,20,20,24],defaultStyle:{fontSize:8,color:'#23364d'},styles:{header:{bold:true,fillColor:'#e9f0f8',alignment:'center'}},content:content,footer:function(page,total){return {text:'Halaman '+page+' dari '+total,fontSize:7,alignment:'right',margin:[20,8,20,0]};}};
    }
    function download(blob,filename){var url=URL.createObjectURL(blob),link=document.createElement('a');link.href=url;link.download=filename;document.body.appendChild(link);link.click();link.remove();setTimeout(function(){URL.revokeObjectURL(url);},30000);}
    var buttons=[document.getElementById('tren-export-excel'),document.getElementById('tren-export-pdf')],status=document.getElementById('tren-export-status');
    async function run(kind){buttons.forEach(function(button){button.disabled=true;});status.textContent='Menyiapkan '+kind.toUpperCase()+'…';try{var data=snapshot();if(kind==='excel')download(await excel(data),context.filename+'.xlsx');else{if(!window.pdfMake)throw Error('Library PDF belum tersedia.');await new Promise(function(resolve){pdfMake.createPdf(pdf(data)).getBlob(function(blob){download(blob,context.filename+'.pdf');resolve();});});}status.textContent='File '+kind.toUpperCase()+' siap diunduh.';}catch(error){status.textContent='Ekspor gagal: '+error.message;}finally{buttons.forEach(function(button){button.disabled=false;});}}
    buttons[0].addEventListener('click',function(){run('excel');});buttons[1].addEventListener('click',function(){run('pdf');});
    window.TrenKCExport={snapshot:snapshot,excel:excel,pdf:pdf};
})();
