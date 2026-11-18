<?php // Shared spacing for user cards: follow the actual application header height. ?>
<style>
@media screen{.content-page.simpro-user-page{padding-top:var(--simpro-user-top,130px)!important;}}
</style>
<script>
(function(){
    function alignUserCards(){
        const page=document.querySelector('.content-page.simpro-user-page');
        const header=document.querySelector('.navbar-custom');
        if(!page||!header)return;
        const zoom=parseFloat(getComputedStyle(document.body).zoom)||1;
        const top=page.getBoundingClientRect().top+window.scrollY;
        const bottom=header.getBoundingClientRect().bottom;
        page.style.setProperty('--simpro-user-top',Math.max(0,(bottom+16-top)/zoom)+'px');
    }
    if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',alignUserCards);
    else alignUserCards();
    window.addEventListener('load',alignUserCards);
    window.addEventListener('resize',alignUserCards);
    if(document.fonts)document.fonts.ready.then(alignUserCards);
    document.addEventListener('DOMContentLoaded',function(){
        const header=document.querySelector('.navbar-custom');
        if(header&&window.ResizeObserver)new ResizeObserver(alignUserCards).observe(header);
    });
})();
</script>
