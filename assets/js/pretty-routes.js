(function () {
    'use strict';
    var config = window.simproRouteConfig;
    if (!config) return;
    var base = new URL(config.roleBase, location.origin);
    function page(url) {
        url = new URL(url || location.href, document.baseURI);
        var legacy = url.searchParams.get('page');
        if (legacy) return legacy;
        if (url.origin !== base.origin || !url.pathname.startsWith(base.pathname)) return '';
        var path = url.pathname.slice(base.pathname.length).replace(/\/$/, '');
        if (/^laporan(?:\/\d+(?:\/[\w-]+)?)?$/.test(path)) return 'menulapawal';
        return /^[a-zA-Z][\w]*$/.test(path) ? path : '';
    }
    function clean(value) {
        var url = new URL(value, document.baseURI);
        if (url.origin !== base.origin || url.pathname !== base.pathname + 'index.php') return url;
        var route = url.searchParams.get('page') || '';
        if (route && !/^[a-zA-Z][\w]*$/.test(route)) return url;
        url.searchParams.delete('page');
        url.pathname = base.pathname + route;
        if (route === 'pembanding') url.pathname += '/';
        if (route === 'menulapawal') {
            url.pathname = base.pathname + 'laporan/';
            var id = url.searchParams.get('id'), tab = url.searchParams.get('tab');
            if (id && /^\d+$/.test(id)) {
                url.pathname += id; url.searchParams.delete('id');
                if (tab && /^[\w-]+$/.test(tab)) {url.pathname += '/' + tab; url.searchParams.delete('tab');}
            } else if (id === '') url.searchParams.delete('id');
        }
        return url;
    }
    window.simproRoutePage = page;
    window.simproRouteParams = function () {
        var params = new URLSearchParams(location.search);
        Object.keys(config.params).forEach(function (key) {if (!params.has(key)) params.set(key, config.params[key]);});
        return params;
    };
    function update(root) {
        var links = root.matches && root.matches('a[href]') ? [root] : [];
        links = links.concat(Array.from(root.querySelectorAll ? root.querySelectorAll('a[href]') : []));
        links.forEach(function (link) {
            var value = link.getAttribute('href');
            if (!value || value[0] === '#' || !/index\.php(?:\?|$)/.test(value)) return;
            try {var url = clean(value); if (url.href !== link.href) link.href = url.href;} catch (_) {}
        });
    }
    // POST responses keep their result; only the displayed address is canonicalized.
    if (location.pathname.endsWith('/index.php')) history.replaceState(history.state, '', config.canonical + location.hash);
    document.addEventListener('DOMContentLoaded', function () {
        update(document);
        new MutationObserver(function (changes) {changes.forEach(function (change) {change.addedNodes.forEach(function (node) {if (node.nodeType === 1) update(node);});});}).observe(document.body, {childList:true, subtree:true});
    });
})();
