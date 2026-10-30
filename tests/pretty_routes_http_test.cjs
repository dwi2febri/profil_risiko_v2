// Exercise every controller alias without credentials; no action handler can run.
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const root = path.resolve(__dirname, '..');
const base = process.env.ROUTE_TEST_BASE || 'http://localhost/profil_risiko_v2/';
const roles = fs.readdirSync(root, {withFileTypes:true}).filter(entry => entry.isDirectory() && fs.existsSync(path.join(root, entry.name, 'laporan/cetak_laporan_profil_risiko.php'))).map(entry => entry.name);
async function loginRedirect(relative) {
    let url = new URL(relative, base), visited = new Set();
    for (let step = 0; step < 6; step++) {
        assert(!visited.has(url.href), 'Redirect loop: ' + relative + ' -> ' + url.href);
        visited.add(url.href);
        const response = await fetch(url, {redirect:'manual', signal:AbortSignal.timeout(15000)});
        await response.body?.cancel();
        assert(response.status >= 300 && response.status < 400, 'Missing controller/auth check: ' + relative + ' status ' + response.status);
        const location = response.headers.get('location');
        assert(location, 'Missing Location: ' + relative);
        url = new URL(location, url);
        if (url.href === new URL('login.php', base).href) return;
    }
    throw new Error('Too many redirects: ' + relative);
}
(async () => {
    const urls = new Set();
    for (const role of roles) {
        const source = fs.readFileSync(path.join(root, role, 'index.php'), 'utf8');
        const pages = new Set([...source.matchAll(/case\s+['"]([a-zA-Z][a-zA-Z0-9_]*)['"]\s*:/g)].map(match => match[1]));
        for (const page of pages) {
            const slug = page === 'menulapawal' ? 'laporan/' : page === 'pembanding' ? 'pembanding/' : page;
            urls.add(role + '/' + slug);
        }
        for (const slug of ['laporan','laporan/','laporan?tab=final','laporan/?tab=final','laporan/556/final','pembanding','pembanding/','index.php?page=menulapawal','index.php?page=pembanding']) urls.add(role + '/' + slug);
    }
    const all = [...urls];
    for (let offset = 0; offset < all.length; offset += 8) await Promise.all(all.slice(offset, offset + 8).map(loginRedirect));
    console.log('PASS ' + all.length + ' controller URLs across ' + roles.length + ' roles: no redirect loops or missing aliases');
})().catch(error => {console.error(error.message); process.exitCode = 1;});
