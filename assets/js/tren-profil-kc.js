(function () {
    'use strict';
    var table=document.querySelector('.tren-kc-table');if(!table)return;
    var scroll=document.querySelector('.tren-kc-scroll'),top=document.querySelector('.tren-kc-scroll-top');
    var view=document.getElementById('tren-risk-view'),search=document.getElementById('tren-branch-search');
    function size(){
        top.hidden=scroll.scrollWidth<=scroll.clientWidth;
        // Both bars need the same scroll range even when the table has a vertical scrollbar.
        top.firstElementChild.style.width=(scroll.scrollWidth+top.clientWidth-scroll.clientWidth)+'px';
        top.scrollLeft=scroll.scrollLeft;
    }
    // Native scrolling; no animation or delayed requestAnimationFrame loop.
    top.addEventListener('scroll',function(){if(scroll.scrollLeft!==top.scrollLeft)scroll.scrollLeft=top.scrollLeft;},{passive:true});
    scroll.addEventListener('scroll',function(){if(top.scrollLeft!==scroll.scrollLeft)top.scrollLeft=scroll.scrollLeft;},{passive:true});
    view.addEventListener('change',function(){table.querySelectorAll('[data-risk]').forEach(function(cell){cell.hidden=view.value!=='semua'&&cell.dataset.risk!==view.value&&cell.dataset.risk!=='komposit';});size();});
    function filter(){var term=search.value.trim().toLocaleLowerCase('id'),count=0;table.querySelectorAll('tbody tr[data-branch]').forEach(function(row){row.hidden=!row.dataset.branch.toLocaleLowerCase('id').includes(term);if(!row.hidden)count++;});document.getElementById('tren-kc-count').textContent='Menampilkan '+count+' cabang, tanpa pembagian halaman.';}
    search.addEventListener('input',filter);window.addEventListener('resize',size);
    if(window.ResizeObserver)new ResizeObserver(size).observe(scroll);
    filter();size();
})();
