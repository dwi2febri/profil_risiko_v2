(function () {
    'use strict';
    var sections=Array.from(document.querySelectorAll('.risk-recap-section')),context=window.riskRecapContext;if(!sections.length||!context)return;
    var view=document.getElementById('risk-recap-view'),search=document.getElementById('risk-recap-search');
    var bands={blue:['Sangat rendah','E7F1FF','1746A2'],green:['Rendah','E9F8ED','176534'],yellow:['Sedang','FFF7CC','735400'],orange:['Tinggi','FFF0DC','943C09'],red:['Sangat tinggi','FDE7E7','A61E25']};
    var headerColour='CFE2F3';
    var note='Nilai seri ditampilkan seluruhnya. Parameter utama bersubparameter memakai rata-rata subparameter terpilih. —: nilai belum tersedia.';
    var legendNote='Inheren: 1–1,25; >1,25–2,25; >2,25–3,25; >3,25–4,25; >4,25–5. Pilar berbobot menunjukkan kontribusi.';
    function filter(){var term=search.value.trim().toLocaleLowerCase('id'),count=0;sections.forEach(function(section,index){section.hidden=view.value!=='semua'&&section.dataset.recapRisk!==view.value;section.querySelectorAll('tr[data-branch]').forEach(function(row){row.hidden=!row.dataset.branch.toLocaleLowerCase('id').includes(term);if(index===0&&!row.hidden)count++;});});document.getElementById('risk-recap-count').textContent='Menampilkan '+count+' cabang per risiko, tanpa pembagian halaman. Rata-rata tetap mengikuti filter wilayah.';}
    view.addEventListener('change',filter);search.addEventListener('input',filter);filter();
    function snapshot(){
        return {reportTitle:context.reportTitle,periodTitle:context.periodTitle,metadata:context.metadata+' | '+view.selectedOptions[0].text+(search.value.trim()?' | Pencarian: '+search.value.trim():''),sections:sections.filter(function(section){return !section.hidden;}).map(function(section){
            var table=section.querySelector('table'),headers=Array.from(table.tHead.querySelectorAll('[data-export-column]')).sort(function(a,b){return Number(a.dataset.exportColumn)-Number(b.dataset.exportColumn);}).map(function(cell){return cell.dataset.exportLabel;});
            return {name:section.dataset.riskName,number:Number(section.dataset.riskNumber),key:section.dataset.recapRisk,headers:headers,rows:Array.from(table.tBodies[0].rows).filter(function(row){return !row.hidden;}).map(function(row){
                var average=row.classList.contains('risk-recap-average'),cells=[];
                if(average)cells.push({text:'',value:null,band:null});
                Array.from(row.cells).forEach(function(cell,index){var sample=cell.querySelector('small'),first=Array.from(cell.childNodes).filter(function(n){return n.nodeName!=='SMALL';}).map(function(n){return n.nodeName==='BR'?'\n':n.textContent;}).join('').trim();var numeric=(!average&&index>=2&&index<row.cells.length-3)||(average&&index>=1&&index<row.cells.length-3);var value=Number(first.replace(',','.'));cells.push({text:first,value:numeric&&Number.isFinite(value)&&first!=='—'?value:null,band:Object.keys(bands).find(function(key){return cell.classList.contains('hasil-pillar-'+key);})||null,sample:sample?sample.textContent.trim():''});});
                return {average:average,cells:cells};
            })};
        })};
    }
    function esc(value){return String(value).replace(/[\u0000-\u0008\u000B\u000C\u000E-\u001F]/g,'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}
    function col(index){var out='';do{out=String.fromCharCode(65+index%26)+out;index=Math.floor(index/26)-1;}while(index>=0);return out;}
    function cell(c,r,value,style){return '<c r="'+col(c)+r+'" s="'+style+'"'+(typeof value==='number'?'><v>'+value+'</v>':' t="inlineStr"><is><t xml:space="preserve">'+esc(value)+'</t></is>')+'</c>';}
    function excel(data){
        if(!window.JSZip)throw Error('Library Excel belum tersedia.');
        var zip=new JSZip(),maxP=Math.max.apply(null,data.sections.map(function(section){return section.headers.length-6;})),highest=4+maxP,last=highest+1;
        var grid={},heights={},merges=[],breaks=[],styleList=[],fontList=[],fillList=[null,null],styleCache={},fontCache={},fillCache={};
        var widths=[8,30].concat(Array(maxP).fill(11.5),[13,20,43,65]);
        function style(bg,ink,bold,align,numeric,border,size){
            var spec={bg:bg,ink:ink,bold:!!bold,align:align||'center',numeric:!!numeric,border:border===undefined?1:border,size:size||10},key=JSON.stringify(spec);
            if(styleCache[key]!==undefined)return styleCache[key];
            var fontKey=JSON.stringify([ink,!!bold,spec.size]);if(fontCache[fontKey]===undefined){fontCache[fontKey]=fontList.length;fontList.push({ink:ink,bold:!!bold,size:spec.size});}
            var fill=0;if(bg){if(fillCache[bg]===undefined){fillCache[bg]=fillList.length;fillList.push(bg);}fill=fillCache[bg];}
            spec.font=fontCache[fontKey];spec.fill=fill;styleCache[key]=styleList.length;styleList.push(spec);return styleCache[key];
        }
        function put(c,r,value,id){if(!grid[r])grid[r]={};grid[r][c]=cell(c,r,value,id);}
        function merge(c0,r0,c1,r1){if(c0!==c1||r0!==r1)merges.push(col(c0)+r0+':'+col(c1)+r1);}
        function span(c0,c1,r,value,id){for(var c=c0;c<=c1;c++)put(c,r,c===c0?value:'',id);merge(c0,r,c1,r);}
        var titleStyle=style(null,'000000',true,'left',false,0,11),textStyle=style(null,'000000',false,'left',false,0,10);
        span(0,last,1,data.reportTitle||'REKAP HASIL PENILAIAN PER RISIKO INHEREN KANTOR CABANG',titleStyle);
        span(0,last,2,'PT BPR BKK JATENG (PERSERODA)',titleStyle);span(0,last,3,data.periodTitle||data.metadata,titleStyle);span(0,last,4,data.metadata,textStyle);
        heights[1]=20;heights[2]=18;heights[3]=18;heights[4]=18;
        var row=5;
        data.sections.forEach(function(section,index){
            if(index)breaks.push(row-1);
            span(0,last,row,section.number+'. '+section.name.toUpperCase(),titleStyle);heights[row]=21;row++;
            var p=section.headers.length-6,score=2+p,rank=3+p,top=4+p,head=row,colour=headerColour;
            var themed=style(colour,'000000',true,'center',false,2),identity=themed;
            for(var r=head;r<head+3;r++){
                put(0,r,r===head?'Kode\nCabang':'',identity);put(1,r,r===head?'Nama Cabang':'',identity);
                for(var c=2;c<=rank;c++)put(c,r,'',themed);
                for(var c=top;c<=highest;c++)put(c,r,r===head&&c===top?'Pilar Tertinggi':'',themed);
                put(last,r,r===head?'Parameter Tertinggi di Pilar Tersebut':'',themed);
                heights[r]=r===head+2?27:18;
            }
            put(2,head,section.name,themed);merge(2,head,rank,head);put(2,head+1,'Inheren',themed);merge(2,head+1,score,head+1);
            put(rank,head+1,'Peringkat',themed);merge(rank,head+1,rank,head+2);
            merge(0,head,0,head+2);merge(1,head,1,head+2);merge(top,head,highest,head+2);merge(last,head,last,head+2);
            for(var c=2;c<=score;c++)put(c,head+2,section.headers[c],themed);
            row=head+3;
            section.rows.forEach(function(record){
                var height=18;
                function dataCell(c0,c1,item,id){span(c0,c1,row,item.value!==null?item.value:item.text,id);var capacity=widths.slice(c0,c1+1).reduce(function(a,b){return a+b;},0)*.9;var lines=item.text.split('\n').reduce(function(n,line){return n+Math.max(1,Math.ceil(line.length/capacity));},0);height=Math.max(height,lines*12+5);}
                if(record.average){span(0,1,row,record.cells[1].text,identity);}else{
                    dataCell(0,0,record.cells[0],style('C6E0B4','000000',false,'center',false));dataCell(1,1,record.cells[1],style('C6E0B4','000000',false,'left',false));
                }
                for(var c=2;c<=rank;c++){
                    var item=record.cells[c],id=record.average?style(colour,'000000',true,'center',item.value!==null,2):style(null,'000000',false,'center',item.value!==null);
                    dataCell(c,c,item,id);
                }
                var descriptionStyle=record.average?themed:style(null,'000000',false,'left',false);
                dataCell(top,highest,record.cells[section.headers.length-2],descriptionStyle);dataCell(last,last,record.cells[section.headers.length-1],descriptionStyle);
                heights[row]=Math.min(409,Math.max(record.average?20:18,height));row++;
            });
            row+=2;
        });
        span(0,last,row,note+' Rata-rata tetap mengikuti wilayah; pencarian hanya menyaring cabang.',style(null,'000000',false,'left',false,0,9));heights[row]=28;
        var rows=Object.keys(grid).map(Number).sort(function(a,b){return a-b;}).map(function(r){return '<row r="'+r+'" ht="'+(heights[r]||18)+'" customHeight="1">'+Object.keys(grid[r]).map(Number).sort(function(a,b){return a-b;}).map(function(c){return grid[r][c];}).join('')+'</row>';});
        var sheet='<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><sheetPr><pageSetUpPr fitToPage="1"/></sheetPr><dimension ref="A1:'+col(last)+row+'"/><sheetViews><sheetView workbookViewId="0" showGridLines="0"><pane xSplit="2" topLeftCell="C1" activePane="topRight" state="frozen"/></sheetView></sheetViews><sheetFormatPr defaultRowHeight="18"/><cols>'+widths.map(function(width,c){return '<col min="'+(c+1)+'" max="'+(c+1)+'" width="'+width+'" customWidth="1"/>';}).join('')+'</cols><sheetData>'+rows.join('')+'</sheetData><mergeCells count="'+merges.length+'">'+merges.map(function(ref){return '<mergeCell ref="'+ref+'"/>';}).join('')+'</mergeCells><pageMargins left="0.25" right="0.25" top="0.4" bottom="0.4" header="0.15" footer="0.15"/><pageSetup orientation="landscape" paperSize="8" fitToWidth="1" fitToHeight="0"/>'+(breaks.length?'<rowBreaks count="'+breaks.length+'" manualBreakCount="'+breaks.length+'">'+breaks.map(function(r){return '<brk id="'+r+'" max="16383" man="1"/>';}).join('')+'</rowBreaks>':'')+'</worksheet>';
        zip.file('xl/worksheets/sheet1.xml',sheet);
        var fonts=fontList.map(function(font){return '<font>'+(font.bold?'<b/>':'')+'<sz val="'+font.size+'"/><name val="Arial"/><color rgb="FF'+font.ink+'"/></font>';}).join('');
        var fills='<fill><patternFill patternType="none"/></fill><fill><patternFill patternType="gray125"/></fill>'+fillList.slice(2).map(function(colour){return '<fill><patternFill patternType="solid"><fgColor rgb="FF'+colour+'"/><bgColor indexed="64"/></patternFill></fill>';}).join('');
        function border(colour){return '<border>'+['left','right','top','bottom'].map(function(side){return '<'+side+' style="thin"><color rgb="FF'+colour+'"/></'+side+'>';}).join('')+'<diagonal/></border>';}
        zip.file('xl/styles.xml','<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main"><fonts count="'+fontList.length+'">'+fonts+'</fonts><fills count="'+fillList.length+'">'+fills+'</fills><borders count="3"><border><left/><right/><top/><bottom/><diagonal/></border>'+border('B7B7B7')+border('FFFFFF')+'</borders><cellStyleXfs count="1"><xf fontId="0" fillId="0" borderId="0" numFmtId="0"/></cellStyleXfs><cellXfs count="'+styleList.length+'">'+styleList.map(function(item){return '<xf fontId="'+item.font+'" fillId="'+item.fill+'" borderId="'+item.border+'" numFmtId="'+(item.numeric?2:0)+'" xfId="0" applyAlignment="1" applyFont="1" applyFill="1" applyBorder="1" applyNumberFormat="1"><alignment horizontal="'+item.align+'" vertical="'+(item.border===2?'center':'top')+'" wrapText="1"/></xf>';}).join('')+'</cellXfs><cellStyles count="1"><cellStyle name="Normal" xfId="0" builtinId="0"/></cellStyles></styleSheet>');
        zip.file('xl/workbook.xml','<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships"><sheets><sheet name="Rekap per Risiko KC" sheetId="1" r:id="rId1"/></sheets><definedNames><definedName name="_xlnm.Print_Titles" localSheetId="0">\'Rekap per Risiko KC\'!$1:$4</definedName></definedNames></workbook>');
        zip.file('xl/_rels/workbook.xml.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/><Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/></Relationships>');
        zip.file('_rels/.rels','<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships"><Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/></Relationships>');
        zip.file('[Content_Types].xml','<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types"><Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/><Default Extension="xml" ContentType="application/xml"/><Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/><Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/><Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/></Types>');
        return zip.generateAsync({type:'blob',mimeType:'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',compression:'DEFLATE'});
    }
    function pdf(data){return {pageSize:'A3',pageOrientation:'landscape',pageMargins:[20,20,20,24],defaultStyle:{fontSize:8,color:'#000000'},content:data.sections.map(function(section,index){
        var length=section.headers.length,heading={colSpan:length,stack:[{text:'Rekap Penilaian Inheren KC — '+section.name,bold:true,fontSize:14,margin:[0,0,0,5]},{text:data.metadata,fontSize:8,margin:[0,0,0,5]},{table:{widths:['*','*','*','*','*'],body:[Object.keys(bands).map(function(key){return {text:bands[key][0],fillColor:'#'+bands[key][1],color:'#000000',fontSize:8,margin:[3,3,3,3]};})]},layout:'noBorders'},{text:legendNote+'\n'+note,fontSize:7,margin:[0,5,0,7]}]};
        var body=[[heading].concat(Array.from({length:length-1},function(){return {};})),section.headers.map(function(header){return {text:header,bold:true,fillColor:'#'+headerColour,alignment:'center'};})];
        section.rows.forEach(function(row){body.push(row.cells.map(function(cell,c){var band=cell.band?bands[cell.band]:null;return {text:cell.text+(cell.sample?'\n'+cell.sample:''),alignment:c===1||c>=length-2?'left':'center',bold:!!band||row.average,fillColor:row.average?'#'+headerColour:'#ffffff',color:'#000000'};}));});
        return {...(index?{pageBreak:'before'}:{}),table:{headerRows:2,dontBreakRows:true,widths:section.headers.map(function(_,c){return c===0?28:c===1?95:c===length-1?255:c===length-2?170:c===length-3?65:'*';}),body:body},layout:{hLineWidth:function(){return .4;},vLineWidth:function(){return .4;},hLineColor:function(){return '#d8e1eb';},vLineColor:function(){return '#d8e1eb';},paddingLeft:function(){return 4;},paddingRight:function(){return 4;},paddingTop:function(){return 4;},paddingBottom:function(){return 4;}}};
    }),footer:function(page,total){return {text:'Halaman '+page+' dari '+total,fontSize:7,alignment:'right',margin:[20,8,20,0]};}};}
    function download(blob,extension){var url=URL.createObjectURL(blob),link=document.createElement('a');link.href=url;link.download=context.filename+'.'+extension;document.body.appendChild(link);link.click();link.remove();setTimeout(function(){URL.revokeObjectURL(url);},30000);}
    var buttons=[document.getElementById('risk-recap-excel'),document.getElementById('risk-recap-pdf')],status=document.getElementById('risk-recap-export-status');
    async function run(kind){buttons.forEach(function(button){button.disabled=true;});status.textContent='Menyiapkan '+kind.toUpperCase()+'…';try{var data=snapshot();if(kind==='excel')download(await excel(data),'xlsx');else await new Promise(function(resolve){pdfMake.createPdf(pdf(data)).getBlob(function(blob){download(blob,'pdf');resolve();});});status.textContent='File siap diunduh.';}catch(error){status.textContent='Ekspor gagal: '+error.message;}finally{buttons.forEach(function(button){button.disabled=false;});}}
    buttons[0].addEventListener('click',function(){run('excel');});buttons[1].addEventListener('click',function(){run('pdf');});window.RiskRecapExport={snapshot:snapshot,excel:excel,pdf:pdf};
})();
