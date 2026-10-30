/* Shared cleanup applies only to cloned print documents. */
/* Chromium underestimates fragmented rowspans. In the print-only copy, each
   parameter group is one ordinary row; its parameter/subparameter grid is nested. */
window.prepareRiskPrintGroups=function(){
    document.querySelectorAll('.clean-page table[data-compact-risk-score="1"]').forEach(function(source){
        if(source.classList.contains('print-group-source'))return;
        var table=source.cloneNode(true);table.removeAttribute('data-compact-risk-print');table.removeAttribute('data-compact-risk-score');table.removeAttribute('data-compact-inheren-score');table.removeAttribute('data-compact-kpmr-score');table.classList.add('print-grouped-assessment');
        table.querySelectorAll('colgroup').forEach(function(group){group.remove();});var group=document.createElement('colgroup');['5%','45%','12%','38%'].forEach(function(width){var col=document.createElement('col');col.style.width=width;group.appendChild(col);});table.prepend(group);
        Array.from(table.tBodies).forEach(function(body){Array.from(body.rows).forEach(function(row){
            var note=row.querySelector(':scope > .kpmr-keterangan-merged');if(!note)return;
            var number=row.cells[0],span=note.rowSpan||1,rows=[row],next=row.nextElementSibling;
            for(var i=1;i<span&&next;i++){rows.push(next);next=next.nextElementSibling;}
            var details=document.createElement('td');details.colSpan=2;details.className='print-group-details';var inner=document.createElement('table');inner.className='print-parameter-grid';inner.innerHTML='<colgroup><col style="width:7.0175%"><col style="width:71.9298%"><col style="width:21.0527%"></colgroup><tbody></tbody>';
            rows.forEach(function(part,index){var line=inner.tBodies[0].insertRow();var cells=Array.from(part.cells);(index===0?cells.slice(1,-1):cells).forEach(function(cell){line.appendChild(cell.cloneNode(true));});});
            details.appendChild(inner);number.rowSpan=1;note.rowSpan=1;row.replaceChildren(number,details,note);rows.slice(1).forEach(function(part){part.remove();});row.classList.add('print-parameter-group');
        });});
        Array.from(table.rows).filter(function(row){return row.closest('table')===table;}).forEach(function(row){Array.from(row.cells).forEach(function(cell){if(cell.colSpan===5)cell.colSpan=4;else if(cell.colSpan===3)cell.colSpan=2;else if(row.parentElement===table.tHead&&cell.colSpan===2)cell.colSpan=1;});});
        source.classList.add('print-group-source');source.after(table);table.style.setProperty('display','table','important');
        table.querySelectorAll('.print-parameter-grid').forEach(function(inner){inner.style.setProperty('height',Math.max(0,Math.ceil(inner.closest('.print-parameter-group').getBoundingClientRect().height)-2)+'px','important');});
    });
};
window.addEventListener('beforeprint',window.prepareRiskPrintGroups);
window.addEventListener('afterprint',function(){document.querySelectorAll('.print-grouped-assessment').forEach(function(table){table.remove();});document.querySelectorAll('.print-group-source').forEach(function(table){table.classList.remove('print-group-source');});});
window.removePrintEditorHeadings = function(root) {
    root.querySelectorAll('h1,h2,h3,h4,h5,h6,.card-header').forEach(function(el) {
        if (!el.closest('table') && !el.querySelector('table') && /^(Risiko\s|Profil\sRisiko|Isian\sKertas\sKerja)/i.test(el.textContent.trim())) el.remove();
    });
    root.querySelectorAll('div,span,small,p,b').forEach(function(el) {
        if (!el.closest('table') && !el.querySelector('table') && /^(Checklist Aktif\s*:|Tahun\s*:\s*\d{4}\s*$)/i.test(el.textContent.trim())) el.remove();
    });
};
window.removePrintSaveIndicators = function(root) {
    if (root) root.querySelectorAll('[class*="save-indicator"],.autosave-status,[data-autosave-status]').forEach(function(el){el.remove();});
};
window.removePrintCharacterCounts = function(root) {
    if (!root) return;
    root.querySelectorAll('[id^="penghitung-karakter"],.char-count,.char-counter,[data-char-count]').forEach(function(el){
        var next=el.nextElementSibling;
        if(next && /^\/\s*\d+$/.test(next.textContent.trim())) next.remove();
        el.remove();
    });
    root.querySelectorAll('textarea[maxlength],.print-field').forEach(function(el){
        var counter=el.nextElementSibling;
        while(counter && counter.tagName==='BR') counter=counter.nextElementSibling;
        if(!counter || !/^(SPAN|SMALL|DIV)$/.test(counter.tagName)) return;
        var text=counter.textContent.trim(), limit=counter.nextElementSibling;
        if(/^\d+$/.test(text) && limit && /^\/\s*\d+$/.test(limit.textContent.trim())) {counter.remove();limit.remove();}
        else if(/^\d+\s*\/\s*\d+$/.test(text)) counter.remove();
    });
};
window.mergeKpmrPrintNotes = function(table) {
    if(table.dataset.kpmrNotesMerged==='1')return;
    function noteAt(row){var col=0,found;Array.from(row.cells).some(function(cell){var w=cell.colSpan||1;if(col<=4&&col+w>4){found={cell:cell,start:col,width:w};return true;}col+=w;});return found;}
    function isSub(row){return !row.matches('.row-param,.row-pilar,.row-summary') && row.cells.length>=3 && !row.cells[0].textContent.trim() && /^[a-z]+[.)]?$/i.test(row.cells[1].textContent.trim());}
    Array.from(table.tBodies).forEach(function(body){var rows=Array.from(body.rows);rows.forEach(function(row,index){
        if(!row.matches('.row-param') && !row.querySelector('.op2-param-name,.kp2-param-name') && !(row.cells.length>=3&&/^\d+[.)]?$/.test(row.cells[0].textContent.trim())))return;
        var note=noteAt(row);if(!note||note.start!==4||note.width!==1)return;
        var subs=[];for(var i=index+1;i<rows.length&&isSub(rows[i]);i++)subs.push(rows[i]);
        subs.forEach(function(sub){var rec=noteAt(sub);if(!rec)return;
            if(rec.start===4&&rec.width===1){
                if(rec.cell.textContent.trim()){var block=document.createElement('div');block.style.marginTop='6px';var label=document.createElement('strong');label.textContent=sub.cells[1].textContent.trim()+' ';block.appendChild(label);while(rec.cell.firstChild)block.appendChild(rec.cell.firstChild);note.cell.appendChild(block);}
                rec.cell.remove();
            }else if(rec.start<4&&rec.start+rec.width===5)rec.cell.colSpan--;
        });
        var number=row.cells[0];if(number&&number.colSpan===1&&/^\d+[.)]?$/.test(number.textContent.trim())){
            subs.forEach(function(sub){sub.cells[0].remove();});number.rowSpan=subs.length+1;number.classList.add('kpmr-number-merged');number.style.setProperty('vertical-align','top','important');number.style.setProperty('text-align','center','important');
        }
        note.cell.rowSpan=subs.length+1;note.cell.classList.add('kpmr-keterangan-merged');note.cell.style.setProperty('vertical-align','top','important');
    });});table.dataset.kpmrNotesMerged='1';
};
window.mergeInherenPrintNumbers = function(table){
    if(table.dataset.inherenNumbersMerged==='1')return;
    table.querySelectorAll('.inheren-keterangan-merged').forEach(function(note){
        var row=note.parentElement,number=row.cells[0];if(!number||number.colSpan!==1||!/^\d+[.)]?$/.test(number.textContent.trim()))return;
        var span=note.rowSpan||1,subs=[],next=row.nextElementSibling;
        if(number.rowSpan===1){for(var i=1;i<span;i++){if(!next||!next.cells[0]||next.cells[0].colSpan!==1||next.cells[0].textContent.trim())return;subs.push(next.cells[0]);next=next.nextElementSibling;}subs.forEach(function(cell){cell.remove();});number.rowSpan=span;}
        number.classList.add('inheren-number-merged');number.style.setProperty('vertical-align','top','important');[number].concat(Array.from(number.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('text-align','center','important');});
    });table.dataset.inherenNumbersMerged='1';
};
window.compactInherenPrintRecaps = function(table){
    if(table.dataset.compactRiskRecaps==='1')return;
    Array.from(table.rows).forEach(function(row){var cells=Array.from(row.cells);if(cells.length<3||!/rekapitulasi\s+penilaian/i.test(cells[0].textContent))return;
        var label=cells[0],note=cells[cells.length-1],score=cells.slice(1,-1).find(function(c){return /^risiko\s+ditetapkan\b/i.test(c.textContent.replace(/\s+/g,' ').trim());});if(!score)return;
        cells.forEach(function(c){if(c!==label&&c!==score&&c!==note)c.remove();});label.colSpan=3;score.colSpan=2;note.colSpan=1;
        [label,score,note].forEach(function(c){c.rowSpan=1;c.removeAttribute('width');c.style.setProperty('width','auto','important');c.style.setProperty('min-width','0','important');c.style.setProperty('max-width','none','important');c.style.setProperty('vertical-align','top','important');});
        row.dataset.compactRecap='1';
    });table.dataset.compactRiskRecaps='1';
};
window.justifyRiskPrintText = function(root){
    var selector='.print-note,.tl-text,.quality-cell,.inheren-keterangan-merged,.kpmr-keterangan-merged';
    var notes=new Set(root.querySelectorAll(selector)),targets=new Set(root.querySelectorAll(selector+',tr[data-compact-recap="1"] > td,tr[data-compact-recap="1"] > th'));
    root.querySelectorAll('tr[data-compact-recap="1"]').forEach(function(row){if(row.cells.length)notes.add(row.cells[row.cells.length-1]);});
    root.querySelectorAll('td[style],th[style]').forEach(function(c){if(/white-space\s*:\s*pre-(wrap|line)/i.test(c.getAttribute('style')||'')){targets.add(c);notes.add(c);}});
    root.querySelectorAll('table').forEach(function(table){var occupied=[],layout=[],columns=new Set();Array.from(table.rows).forEach(function(row,r){var col=0;Array.from(row.cells).forEach(function(c){while((occupied[col]||0)>r)col++;var w=c.colSpan||1,h=c.rowSpan===0?table.rows.length-r:c.rowSpan||1;layout.push({cell:c,start:col,width:w,header:row.parentElement.tagName==='THEAD'});if(c.tagName==='TH'&&c.textContent.trim().toUpperCase()==='KETERANGAN')for(var i=col;i<col+w;i++)columns.add(i);for(var j=col;j<col+w;j++)occupied[j]=r+h;col+=w;});});layout.forEach(function(item){if(item.header)return;for(var i=item.start;i<item.start+item.width;i++)if(!columns.has(i))return;targets.add(item.cell);notes.add(item.cell);});});
    notes.forEach(function(note){targets.add(note);[note].concat(Array.from(note.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('font-weight','400','important');});note.classList.add('print-note-normal');});
    targets.forEach(function(el){[el].concat(Array.from(el.querySelectorAll('div,p,center,span'))).forEach(function(c){c.style.setProperty('text-align','justify','important');c.style.setProperty('text-align-last','left','important');c.style.setProperty('text-justify','inter-word','important');});el.classList.add('print-text-justified');});
};
/* Normalize BR-only fallbacks into labels and values without changing their text. */
function printNormalizeStatisticLines(cell){
    if(cell.querySelector('center'))return;
    var copy=document.createElement('div');copy.innerHTML=cell.innerHTML.replace(/<br\s*\/?\s*>/gi,'\n').replace(/<hr\b[^>]*>/gi,'\n---\n');
    var lines=copy.textContent.split(/\n/).map(function(s){return s.trim();}).filter(Boolean);cell.replaceChildren();
    lines.forEach(function(text){if(text==='---'){cell.appendChild(document.createElement('hr'));return;}
        var heading=/^(Tertinggi|Terendah|Rata[ -]rata|Tingkat risiko|Peringkat|Metode Risiko|Nilai diambil|Total Nilai Bobot|Risiko\s+ditetapkan(?:\s*\(.*\))?|Bobot(?:\s*\(%\))?|Nilai Pilar)$/i.test(text);
        if(cell.lastElementChild&&/^Metode Risiko$/i.test(cell.lastElementChild.textContent))heading=false;
        var block=document.createElement(heading?'center':'div');if(!heading)block.className='print-field';block.textContent=text;cell.appendChild(block);
    });
}
window.alignKpmrPrintPillarSummaries=function(root){
    root.querySelectorAll('table[data-compact-risk-score="1"]').forEach(function(table){Array.from(table.rows).forEach(function(row){
        if(row.cells.length<3||!/^hasil\s+penilaian\s+pilar\b/i.test(row.cells[0].textContent.replace(/\s+/g,' ').trim()))return;
        var label=row.cells[0],stats=row.cells[1];printNormalizeStatisticLines(stats);row.cells[row.cells.length-1].style.setProperty('vertical-align','top','important');
        [label].concat(Array.from(label.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('text-align','justify','important');el.style.setProperty('text-align-last','left','important');el.style.setProperty('vertical-align','top','important');});
        [stats].concat(Array.from(stats.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('text-align','center','important');el.style.setProperty('text-align-last','center','important');el.style.setProperty('vertical-align','top','important');});
        stats.querySelectorAll('center').forEach(function(el){[el].concat(Array.from(el.querySelectorAll('*'))).forEach(function(c){c.style.setProperty('font-weight','700','important');});});
        stats.querySelectorAll('.print-field,.print-field *').forEach(function(el){el.style.setProperty('font-weight','400','important');});row.dataset.kpmrPillarSummary='1';
    });});
};
window.alignRiskPrintParameters=function(root){
    root.querySelectorAll('table[data-compact-risk-print="1"]').forEach(function(table){var title=table.tHead&&table.tHead.rows[0]?table.tHead.rows[0].textContent:'';if(table.dataset.compactKpmrScore!=='1'&&!/(operasional|kepatuhan|reputasi|stratejik|strategik)[\s\S]*inheren\s*2\b/i.test(title))return;
        if(/kepatuhan[\s\S]*inheren/i.test(title))table.querySelectorAll('.kpmr-number-merged').forEach(function(cell){[cell].concat(Array.from(cell.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('font-weight','700','important');});});
        function align(c){if(!c)return;[c].concat(Array.from(c.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('vertical-align','top','important');el.style.setProperty('text-align','left','important');el.style.setProperty('text-align-last','left','important');});c.classList.add('print-parameter-top-left');}
        Array.from(table.rows).forEach(function(row){if(row.matches('.row-param')||(row.cells.length>=3&&/^\d+[.)]?$/.test(row.cells[0].textContent.trim()))){var name=row.querySelector('.op2-param-name,.kp2-param-name');align(name?name.closest('th,td'):row.cells[1]);}
            if(row.matches('.row-param,.row-pilar,.row-summary'))return;var letter=Array.from(row.cells).find(function(c){return c.matches('.sub-col-op2')||/^[a-z]+[.)]$/i.test(c.textContent.trim());});if(!letter)return;[letter].concat(Array.from(letter.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('vertical-align','top','important');});letter.classList.add('print-subletter-top');align(letter.nextElementSibling);
            if(/kepatuhan[\s\S]*inheren/i.test(title) && letter.nextElementSibling){
                [letter,letter.nextElementSibling].concat(Array.from(letter.querySelectorAll('*')),Array.from(letter.nextElementSibling.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('font-weight','700','important');});
            }
        });
    });
};
window.centerInherenPrintScores=function(root){root.querySelectorAll('table[data-compact-inheren-score="1"]').forEach(function(table){Array.from(table.rows).forEach(function(row){var cells=Array.from(row.cells);if(!row.querySelector('.kpmr-number-merged')&&!(cells[0]&&/^[a-z]+[.)]$/i.test(cells[0].textContent.trim())))return;var score=cells[2];if(!score)return;[score].concat(Array.from(score.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('text-align','center','important');el.style.setProperty('text-align-last','center','important');el.style.setProperty('vertical-align','middle','important');});score.classList.add('inheren-score-centered');});});};
window.formatRiskPrintRecaps=function(root){
    root.querySelectorAll('table').forEach(function(table){var title=table.tHead?table.tHead.textContent:'';if(!/REKAP\s+(?:PENILAIAN|NILAI)\s+(?:INHEREN|KPMR)/i.test(title)||table.dataset.recapFormatted==='1')return;
        Array.from(table.rows).forEach(function(row){var label=row.cells[0];if(!label||!/^Hasil\s+Penilaian/i.test(label.textContent.trim()))return;
            label.textContent=label.textContent.replace(/\s+/g,' ').trim();row.removeAttribute('height');row.style.setProperty('height','auto','important');
            Array.from(row.cells).forEach(function(cell){cell.removeAttribute('height');cell.style.setProperty('height','auto','important');cell.style.setProperty('min-height','0','important');cell.style.setProperty('white-space','normal','important');Array.from(cell.childNodes).forEach(function(node){if(node.nodeType===3&&!node.textContent.trim())node.remove();});});
            Array.from(row.cells).slice(1).forEach(function(cell){if(!cell.querySelector('center')&&/^(Tertinggi|Terendah|Rata[ -]rata|Tingkat risiko|Peringkat|Metode Risiko|Nilai diambil)/i.test(cell.textContent.trim()))printNormalizeStatisticLines(cell);});
            Array.from(row.cells).forEach(function(cell){[cell].concat(Array.from(cell.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('font-weight','400','important');el.style.setProperty('text-align','center','important');el.style.setProperty('text-align-last','center','important');});});
            label.style.setProperty('text-align','left','important');label.style.setProperty('text-align-last','left','important');label.style.setProperty('font-weight','700','important');
            Array.from(row.cells).slice(1).forEach(function(cell){Array.from(cell.querySelectorAll('center')).forEach(function(heading){var text=heading.textContent.replace(/\s+/g,' ').trim();
                if(/^Nilai diambil$/i.test(text)){label.colSpan+=cell.colSpan;cell.remove();}
                else if(/^Metode Risiko$/i.test(text)){
                    if(!Array.from(cell.querySelectorAll('center')).some(function(el){return /^(Tingkat risiko|Peringkat|Total Nilai Bobot)$/i.test(el.textContent.trim());})){label.colSpan+=cell.colSpan;cell.remove();return;}
                    var next=heading.nextSibling;while(next&&!(next.nodeType===1&&next.tagName==='CENTER')){var following=next.nextSibling;next.remove();next=following;}heading.remove();
                }else if(/^(Tertinggi|Terendah|Rata[ -]rata|Tingkat risiko|Peringkat|Total Nilai Bobot)$/i.test(text)){[heading].concat(Array.from(heading.querySelectorAll('*'))).forEach(function(el){el.style.setProperty('font-weight','700','important');});}
            });});
        });table.dataset.recapFormatted='1';
    });
};
window.closeRiskPrintPageCuts=function(root){root.querySelectorAll('table[data-compact-risk-print="1"]').forEach(function(table){if(table.tFoot)return;var cols=table.querySelector('colgroup');if(!cols||!cols.children.length)return;var footer=table.createTFoot();footer.className='print-page-grid-footer';footer.setAttribute('aria-hidden','true');footer.insertRow().insertCell().colSpan=cols.children.length;});};
window.normalizeRiskPrintPillarTitles=function(root){
    root.querySelectorAll('tr').forEach(function(row){
        var cell=row.cells[0];if(!cell)return;
        var text=cell.textContent,match=text.match(/^(\s*(?:Hasil\s+Penilaian\s+)?Pilar\s*\d+\s*[:\-\u2013\u2014]\s*)(?:Pilar\s*(?:\d+\s*)?[:\-\u2013\u2014]?\s*)+/i);
        if(!match)return;
        // Delete only the repeated prefix; retain bold markup and other content.
        var start=match[1].length,end=match[0].length,offset=0,walker=document.createTreeWalker(cell,4),node;
        while((node=walker.nextNode())){var length=node.nodeValue.length,from=Math.max(0,start-offset),to=Math.min(length,end-offset);if(to>from)node.nodeValue=node.nodeValue.slice(0,from)+node.nodeValue.slice(to);offset+=length;if(offset>=end)break;}
    });
};
window.compactRiskPrintColumns=function(root,expectedTitle){
    if(!root)return;removePrintEditorHeadings(root);removePrintSaveIndicators(root);removePrintCharacterCounts(root);
    root.querySelectorAll('table').forEach(function(table){
        if(table.dataset.compactRiskPrint==='1')return;var title=expectedTitle||(table.tHead?table.tHead.textContent:'');
        var isCreditLiquidity=/(kredit|likuiditas)[\s\S]*inheren/i.test(title),isSummary=/KPMR\s*2\b/i.test(title)||/(operasional|kepatuhan|reputasi|stratejik|strategik)[\s\S]*inheren\s*2\b/i.test(title);if(!isCreditLiquidity&&!isSummary)return;
        var rows=Array.from(table.rows),occupied=[],layout=[],removed=new Set();rows.forEach(function(row,r){var col=0;Array.from(row.cells).forEach(function(cell){while((occupied[col]||0)>r)col++;var w=cell.colSpan||1,h=cell.rowSpan===0?rows.length-r:cell.rowSpan||1;layout.push({cell:cell,start:col,width:w});var text=cell.textContent.replace(/\s+/g,' ').trim().toUpperCase();if(cell.tagName==='TH'&&((isCreditLiquidity&&/^(AMBANG(?: BATAS)?|RUMUS|KOREK(?:SI)?)$/.test(text))||(isSummary&&/^(?:(?:RISIKO|PENILAIAN|NILAI)\s+)?PERIODE\s+SEBELUMNYA$/.test(text))))for(var i=col;i<col+w;i++)removed.add(i);for(var j=col;j<col+w;j++)occupied[j]=r+h;col+=w;});});
        if(isSummary){var rating=layout.find(function(item){return item.cell.tagName==='TH'&&item.cell.textContent.replace(/\s+/g,' ').trim().toUpperCase()==='PERINGKAT RISIKO'&&item.width===2;});if(rating){var first=rating.start;rows.forEach(function(row){var cells=layout.filter(function(item){return item.cell.parentElement===row;});var left=cells.find(function(item){return item.start<=first&&item.start+item.width>first;}),right=cells.find(function(item){return item.start<=first+1&&item.start+item.width>first+1;});if(!left||!right||left===right||right.start!==first+1||right.width!==1)return;if(left.start===first&&left.width===1){if(left.cell.textContent.trim()&&right.cell.textContent.trim())left.cell.appendChild(document.createElement('br'));while(right.cell.firstChild)left.cell.appendChild(right.cell.firstChild);}else if(left.start<first&&left.start+left.width===first+1){left.width--;right.start=first;}});removed.add(first+1);table.dataset.compactRiskScore='1';if(/KPMR\s*2\b/i.test(title))table.dataset.compactKpmrScore='1';else table.dataset.compactInherenScore='1';}}
        if(!removed.size)return;layout.forEach(function(item){var kept=0;for(var col=item.start;col<item.start+item.width;col++)if(!removed.has(col))kept++;if(!kept)item.cell.remove();else{item.cell.colSpan=kept;item.cell.removeAttribute('width');['width','min-width','max-width'].forEach(function(prop){item.cell.style.removeProperty(prop);});}});
        Array.from(table.children).filter(function(el){return el.tagName==='COLGROUP';}).forEach(function(el){el.remove();});var group=document.createElement('colgroup'),remaining=Math.max.apply(null,layout.map(function(item){return item.start+item.width;}))-removed.size;
        var widths=isCreditLiquidity?['5%','23%','18%','9%','9%','36%']:remaining===5&&table.dataset.compactRiskScore==='1'?['5%','4%','41%','12%','38%']:remaining===6?['5%','4%','31%','10%','10%','40%']:Array.from({length:remaining},function(){return 100/remaining+'%';});widths.forEach(function(width){var col=document.createElement('col');col.style.width=width;group.appendChild(col);});table.insertBefore(group,table.firstChild);
        table.querySelectorAll('.inheren-keterangan-merged').forEach(function(cell){['width','min-width','max-width'].forEach(function(prop){cell.style.setProperty(prop,'36%','important');});});
        if(isCreditLiquidity){compactInherenPrintRecaps(table);mergeInherenPrintNumbers(table);}if(table.dataset.compactRiskScore==='1')mergeKpmrPrintNotes(table);table.dataset.compactRiskPrint='1';
    });
    justifyRiskPrintText(root);alignKpmrPrintPillarSummaries(root);formatRiskPrintRecaps(root);alignRiskPrintParameters(root);centerInherenPrintScores(root);closeRiskPrintPageCuts(root);normalizeRiskPrintPillarTitles(root);
    root.querySelectorAll('thead').forEach(function(header) {
        var walker = document.createTreeWalker(header, 4), node;
        while ((node = walker.nextNode())) node.nodeValue = node.nodeValue.replace(/\b(KPMR|INHEREN)\s+2\b/gi, '$1');
    });
    root.querySelectorAll('center').forEach(function(label){if(!/^rata\s*[- ]\s*rata$/i.test(label.textContent.trim()))return;label.textContent='Rata-rata';label.style.setProperty('white-space','nowrap','important');label.style.setProperty('word-break','normal','important');label.style.setProperty('overflow-wrap','normal','important');});
};
