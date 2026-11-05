(function () {
    'use strict';
    var table=document.querySelector('.tren-kc-table');if(!table)return;
    var scroll=document.querySelector('.tren-kc-scroll'),top=document.querySelector('.tren-kc-scroll-top');
    var view=document.getElementById('tren-risk-view'),search=document.getElementById('tren-branch-search');
    var mirrored=new WeakMap(),sizeFrame=0;
    // A programmatic scroll event acknowledges a mirror write. It must never
    // write back to the native scroller currently being dragged or wheeled.
    function mirror(target,left){
        if(Math.abs(target.scrollLeft-left)<1)return;
        target.scrollLeft=left;
        mirrored.set(target,target.scrollLeft); // Save the browser's rounded/clamped result.
    }
    function sync(source,target){
        if(mirrored.has(source)){
            var expected=mirrored.get(source);mirrored.delete(source);
            if(Math.abs(source.scrollLeft-expected)<1)return;
        }
        mirror(target,source.scrollLeft);
    }
    function size(){
        sizeFrame=0;
        top.hidden=scroll.scrollWidth<=scroll.clientWidth;
        // Both bars need the same scroll range even when the table has a vertical scrollbar.
        var width=(scroll.scrollWidth+top.clientWidth-scroll.clientWidth)+'px';
        if(top.firstElementChild.style.width!==width)top.firstElementChild.style.width=width;
        mirror(top,scroll.scrollLeft);
    }
    function scheduleSize(){if(!sizeFrame)sizeFrame=requestAnimationFrame(size);}
    // Scroll positions update immediately; only geometry measurements are coalesced.
    top.addEventListener('scroll',function(){sync(top,scroll);},{passive:true});
    scroll.addEventListener('scroll',function(){sync(scroll,top);},{passive:true});
    [top,scroll].forEach(function(element){
        ['pointerdown','wheel','touchstart','keydown'].forEach(function(event){element.addEventListener(event,function(){mirrored.delete(element);},{passive:true});});
    });
    view.addEventListener('change',function(){table.querySelectorAll('[data-risk]').forEach(function(cell){cell.hidden=view.value!=='semua'&&cell.dataset.risk!==view.value&&cell.dataset.risk!=='komposit';});scheduleSize();});
    function filter(){var term=search.value.trim().toLocaleLowerCase('id'),count=0;table.querySelectorAll('tbody tr[data-branch]').forEach(function(row){row.hidden=!row.dataset.branch.toLocaleLowerCase('id').includes(term);if(!row.hidden)count++;});document.getElementById('tren-kc-count').textContent='Menampilkan '+count+' cabang, tanpa pembagian halaman.';}
    search.addEventListener('input',function(){filter();scheduleSize();});window.addEventListener('resize',scheduleSize);
    if(window.ResizeObserver){var observer=new ResizeObserver(scheduleSize);observer.observe(scroll);observer.observe(table);}
    filter();size();
})();
