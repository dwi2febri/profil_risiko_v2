/* Preserve the displayed rating colours and active DataTables filters in exports. */
(function () {
    'use strict';
    var palette = {
        blue: {name:'Sangat rendah', bg:'#e7f1ff', ink:'#1746a2', range:'1 - 1,25'},
        green: {name:'Rendah', bg:'#e9f8ed', ink:'#176534', range:'>1,25 - 2,25'},
        yellow: {name:'Sedang', bg:'#fff7cc', ink:'#735400', range:'>2,25 - 3,25'},
        orange: {name:'Tinggi', bg:'#fff0dc', ink:'#943c09', range:'>3,25 - 4,25'},
        red: {name:'Sangat tinggi', bg:'#fde7e7', ink:'#a61e25', range:'>4,25 - 5'}
    };
    var compositeNote = 'Komposit: sangat rendah <1,25; rendah 1,25-<2,25; sedang 2,25-<3,25; tinggi 3,25-<4,25; sangat tinggi 4,25-5.';
    var inherentNote = 'Pilar/inheren: ' + Object.keys(palette).map(function(key){var band=palette[key];return band.name+' '+band.range;}).join('; ') + '.';
    function snapshot(api) {
        var columns=api.columns(':visible').indexes().toArray();
        return api.rows({search:'applied',order:'applied',selected:null}).indexes().toArray().map(function(row){
            return columns.map(function(column){var node=api.cell(row,column).node();return Object.keys(palette).find(function(key){return node && node.classList.contains('hasil-pillar-'+key);}) || null;});
        });
    }
    function sections(api) {
        var columns=api.columns(':visible').indexes().toArray();if(columns.length<=18)return null;
        var risks=[];columns.forEach(function(column){var risk=api.column(column).header().dataset.risk;if(risk&&risks.indexOf(risk)===-1)risks.push(risk);});
        return risks.map(function(risk){return {name:'Risiko '+risk.charAt(0).toUpperCase()+risk.slice(1),indexes:columns.map(function(column,index){var kind=api.column(column).header().dataset.risk;return !kind||kind===risk?index:-1;}).filter(function(index){return index!==-1;})};});
    }
    function xmlElement(document, name, attributes) {
        var element=document.createElementNS(document.documentElement.namespaceURI,name);
        Object.keys(attributes || {}).forEach(function(key){element.setAttribute(key,attributes[key]);});
        return element;
    }
    function letters(index) {var out='';do {out=String.fromCharCode(65+index%26)+out;index=Math.floor(index/26)-1;}while(index>=0);return out;}
    function excelColours(xlsx, api) {
        var sheet=xlsx.xl.worksheets['sheet1.xml'], styles=xlsx.xl['styles.xml'];
        var fills=styles.getElementsByTagName('fills')[0], fonts=styles.getElementsByTagName('fonts')[0], xfs=styles.getElementsByTagName('cellXfs')[0];
        var cache={}, fillIds={};
        function styleFor(base,key) {
            var token=base+'|'+key;if(cache[token]!==undefined)return cache[token];
            var band=key==='header'?{bg:'#e9f0f8',ink:'#23364d'}:palette[key], xf=xfs.children[Number(base)||0].cloneNode(true);
            if(fillIds[key]===undefined){
                var fill=xmlElement(styles,'fill'), pattern=xmlElement(styles,'patternFill',{patternType:'solid'});
                pattern.appendChild(xmlElement(styles,'fgColor',{rgb:'FF'+band.bg.slice(1).toUpperCase()}));
                pattern.appendChild(xmlElement(styles,'bgColor',{indexed:'64'}));fill.appendChild(pattern);
                fillIds[key]=fills.children.length;fills.appendChild(fill);
            }
            var font=fonts.children[Number(xf.getAttribute('fontId'))||0].cloneNode(true);
            Array.from(font.getElementsByTagName('color')).forEach(function(node){node.remove();});
            font.appendChild(xmlElement(styles,'color',{rgb:'FF'+band.ink.slice(1).toUpperCase()}));
            var fontId=fonts.children.length;fonts.appendChild(font);
            xf.setAttribute('fontId',fontId);xf.setAttribute('fillId',fillIds[key]);xf.setAttribute('applyFill','1');xf.setAttribute('applyFont','1');
            var id=xfs.children.length;xfs.appendChild(xf);cache[token]=id;return id;
        }
        var data=sheet.getElementsByTagName('sheetData')[0], colours=snapshot(api);
        var header=data.children[data.children.length-colours.length-1];
        Array.from(header.children).forEach(function(cell){cell.setAttribute('s',styleFor(cell.getAttribute('s')||'0','header'));});
        var rows=colours.length ? Array.from(data.children).slice(-colours.length) : [];
        rows.forEach(function(row,index){Array.from(row.children).forEach(function(cell){
            var address=cell.getAttribute('r'), column=address.match(/^[A-Z]+/)[0], position=0;
            for(var i=0;i<column.length;i++)position=position*26+column.charCodeAt(i)-64;
            var key=colours[index][position-1];if(key)cell.setAttribute('s',styleFor(cell.getAttribute('s')||'0',key));
        });});
        var width=api.columns(':visible').count(), last=letters(width-1), rowNumber=Number(data.lastElementChild.getAttribute('r'))+2;
        var merges=sheet.getElementsByTagName('mergeCells')[0];
        if(!merges){merges=xmlElement(sheet,'mergeCells');data.after(merges);}
        function line(text,key,range) {
            var row=xmlElement(sheet,'row',{r:rowNumber,ht:'22',customHeight:'1'});
            function cell(column,value){var c=xmlElement(sheet,'c',{r:column+rowNumber,t:'inlineStr'}),is=xmlElement(sheet,'is'),t=xmlElement(sheet,'t');t.textContent=value;is.appendChild(t);c.appendChild(is);row.appendChild(c);return c;}
            var first=cell('A',text);if(key)first.setAttribute('s',styleFor(0,key));
            var span=key?'B':last;
            merges.appendChild(xmlElement(sheet,'mergeCell',{ref:'A'+rowNumber+':'+span+rowNumber}));
            if(range){cell('C',range);merges.appendChild(xmlElement(sheet,'mergeCell',{ref:'C'+rowNumber+':'+last+rowNumber}));}
            data.appendChild(row);rowNumber++;
        }
        line('Keterangan warna berdasarkan peringkat');
        Object.keys(palette).forEach(function(key){line(palette[key].name,key,'Pilar/inheren: '+palette[key].range);});
        line(compositeNote);line('Tanda - / nilai kosong / belum lengkap: tidak diberi warna peringkat.');
        [[fills,'fill'],[fonts,'font'],[xfs,'xf'],[merges,'mergeCell']].forEach(function(pair){pair[0].setAttribute('count',pair[0].getElementsByTagName(pair[1]).length);});
        var dimension=sheet.getElementsByTagName('dimension')[0];if(dimension)dimension.setAttribute('ref','A1:'+last+(rowNumber-1));
        var properties=sheet.getElementsByTagName('sheetPr')[0];
        if(!properties){properties=xmlElement(sheet,'sheetPr');sheet.documentElement.prepend(properties);}
        properties.appendChild(xmlElement(sheet,'pageSetUpPr',{fitToPage:'1'}));
        sheet.documentElement.appendChild(xmlElement(sheet,'pageMargins',{left:'.25',right:'.25',top:'.4',bottom:'.4',header:'.15',footer:'.15'}));
        sheet.documentElement.appendChild(xmlElement(sheet,'pageSetup',{orientation:'landscape',paperSize:width>18?'8':'9',fitToWidth:'1',fitToHeight:'0'}));
    }
    function pdfColours(document, api) {
        var colours=snapshot(api), count=api.columns(':visible').count(), groups=sections(api);
        var tableNode=document.content.find(function(node){return node.table;});
        document.pageOrientation='landscape';document.pageSize=count>18?'A3':'A4';document.pageMargins=[20,20,20,24];
        document.defaultStyle.fontSize=9;
        document.styles.tableHeader={bold:true,fontSize:9,color:'#23364d',fillColor:'#e9f0f8',alignment:'center'};
        document.styles.tableBodyOdd={fillColor:'#f5f7fb'};document.styles.tableBodyEven={fillColor:'#ffffff'};
        tableNode.table.widths=Array.from({length:count},function(_,i){return i===0?18:i===1?30:i===2?85:i===3?65:'*';});
        tableNode.layout={hLineWidth:function(){return .4;},vLineWidth:function(){return .4;},hLineColor:function(){return '#d8e1eb';},vLineColor:function(){return '#d8e1eb';},paddingLeft:function(){return 3;},paddingRight:function(){return 3;}};
        colours.forEach(function(row,r){row.forEach(function(key,c){if(key){var cell=tableNode.table.body[r+1][c];cell.fillColor=palette[key].bg;cell.color=palette[key].ink;cell.bold=true;}});});
        var legend={margin:[0,0,0,5],table:{widths:['*','*','*','*','*'],body:[Object.keys(palette).map(function(key){var band=palette[key];return {text:band.name,fillColor:band.bg,color:band.ink,bold:true,fontSize:8,margin:[4,3,4,3]};})]},layout:'noBorders'};
        var position=document.content.indexOf(tableNode);
        document.content.splice(position,0,{text:'Keterangan warna berdasarkan peringkat',bold:true,fontSize:9,margin:[0,0,0,4]},legend,{text:inherentNote+'\n'+compositeNote+'\nTanda - / kosong / belum lengkap: tidak diberi warna peringkat.',fontSize:7,margin:[0,0,0,10]});
        if(groups){
            var blocks=[], title=document.content.find(function(node){return node.style==='title';}), metadata=document.content.find(function(node){return node.style==='message';});
            groups.forEach(function(group,index){
                blocks.push({text:(index&&title?title.text+' | ':'')+group.name,bold:true,fontSize:12,margin:[0,0,0,8],...(index?{pageBreak:'before'}:{})});
                if(index){
                    if(metadata)blocks.push({text:metadata.text,fontSize:8,margin:[0,0,0,8]});
                    blocks.push(JSON.parse(JSON.stringify(legend)),{text:inherentNote+'\n'+compositeNote,fontSize:7,margin:[0,0,0,10]});
                }
                blocks.push({table:{headerRows:1,widths:group.indexes.map(function(_,i){return i===0?18:i===1?30:i===2?85:i===3?65:'*';}),body:tableNode.table.body.map(function(row){return group.indexes.map(function(c){return Object.assign({},row[c]);});})},layout:tableNode.layout});
            });
            document.content.splice.apply(document.content,[document.content.indexOf(tableNode),1].concat(blocks));
        }
        document.footer=function(page,total){return {text:'Halaman '+page+' dari '+total,alignment:'right',fontSize:8,margin:[20,8,20,0]};};
    }
    function printColours(win, api) {
        var document=win.document, table=document.querySelector('table'), colours=snapshot(api);
        var style=document.createElement('style');
        style.textContent='@page{size:'+(api.columns(':visible').count()>18?'A3':'A4')+' landscape;margin:10mm}html,body{background:#fff!important;color:#1f2933!important}body.dt-print-view{padding:12px!important;font:11px Arial,sans-serif!important}body.dt-print-view h1{font-size:18px!important}body.dt-print-view table{width:100%!important;border-collapse:collapse!important;table-layout:fixed!important;font-size:9px!important}body.dt-print-view th,body.dt-print-view td{border:1px solid #d8e1eb!important;padding:5px!important;white-space:normal!important;overflow-wrap:anywhere;position:static!important;box-shadow:none!important}body.dt-print-view th{background:#e9f0f8!important;color:#23364d!important}body.dt-print-view thead{display:table-header-group}.risk-export-legend{font-size:10px;margin:12px 0}.risk-export-legend span{display:inline-block;padding:5px 9px;margin:4px 6px 4px 0}.risk-export-legend p{margin:4px 0}body.dt-print-view,body.dt-print-view *{-webkit-print-color-adjust:exact!important;print-color-adjust:exact!important}';
        document.head.appendChild(style);
        Array.from(table.tBodies[0].rows).forEach(function(row,r){Array.from(row.cells).forEach(function(cell,c){var key=colours[r]&&colours[r][c];if(key){cell.style.setProperty('background-color',palette[key].bg,'important');cell.style.setProperty('color',palette[key].ink,'important');cell.style.fontWeight='600';}});});
        var legend=document.createElement('div');legend.className='risk-export-legend';
        var heading=document.createElement('strong');heading.textContent='Keterangan warna berdasarkan peringkat';legend.appendChild(heading);legend.appendChild(document.createElement('br'));
        Object.keys(palette).forEach(function(key){var chip=document.createElement('span'),band=palette[key];chip.textContent=band.name;chip.style.backgroundColor=band.bg;chip.style.color=band.ink;legend.appendChild(chip);});
        [inherentNote,compositeNote,'Tanda - / kosong / belum lengkap: tidak diberi warna peringkat.'].forEach(function(text){var p=document.createElement('p');p.textContent=text;legend.appendChild(p);});
        table.before(legend);
        var groups=sections(api);
        if(groups){
            var fragment=document.createDocumentFragment();
            groups.forEach(function(group,index){
                var heading=document.createElement('h2');heading.textContent=(index?document.querySelector('h1').textContent+' | ':'')+group.name;heading.style.fontSize='14px';if(index)heading.style.breakBefore='page';fragment.appendChild(heading);
                if(index)fragment.appendChild(legend.cloneNode(true));
                var part=document.createElement('table');
                var head=part.createTHead().insertRow();group.indexes.forEach(function(c){head.appendChild(table.tHead.rows[0].cells[c].cloneNode(true));});
                var body=part.createTBody();Array.from(table.tBodies[0].rows).forEach(function(row){var copy=body.insertRow();group.indexes.forEach(function(c){copy.appendChild(row.cells[c].cloneNode(true));});});
                fragment.appendChild(part);
            });
            table.replaceWith(fragment);
        }
    }
    window.HasilRiskExport={
        buttons:function(getApi,context){
            function title(){return context.title+' - Triwulan '+context.period+' '+context.year;}
            function summary(){var tab=document.querySelector('.hasil-region-tabs [aria-pressed="true"]'),view=document.getElementById('hasil-risk-view');return (context.status==='diterima'?'Laporan diterima Korwil dan SKMR':'Semua laporan')+' | '+(tab?tab.textContent.trim():'Semua area')+' | '+(view?view.options[view.selectedIndex].text:'Semua risiko dan pilar');}
            var options={columns:':visible',modifier:{search:'applied',order:'applied',selected:null}};
            return [
                {extend:'copy',text:'Salin',exportOptions:options},
                {extend:'csv',text:'CSV',exportOptions:options},
                {extend:'excelHtml5',text:'Excel',title:title,messageTop:summary,messageBottom:null,filename:context.filename,exportOptions:options,customize:function(xlsx){excelColours(xlsx,getApi());}},
                {extend:'pdfHtml5',text:'PDF',title:title,messageTop:summary,filename:context.filename,orientation:'landscape',exportOptions:options,customize:function(document){pdfColours(document,getApi());}},
                {extend:'print',text:'Cetak',title:title,messageTop:summary,exportOptions:options,customize:function(win){printColours(win,getApi());}}
            ];
        }
    };
})();
