<?php
if (($_SESSION['tipe'] ?? '') !== 'admin') { http_response_code(403); return; }
require_once __DIR__ . '/includes/monitoring_data.php';
mysqli_set_charset($conn, 'utf8mb4');
$monitoringOptions = mon_options($conn);
try { $monitoringFilters = mon_filters($_GET, $monitoringOptions); }
catch (InvalidArgumentException $error) { $monitoringFilters = mon_filters([], $monitoringOptions); }
if (empty($_SESSION['monitoring_csrf'])) $_SESSION['monitoring_csrf'] = bin2hex(random_bytes(32));
$mh = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>
<link rel="stylesheet" href="../assets/css/dashboard-monitoring.css?v=20261028-1">
<div class="content-page"><div class="content"><main class="mon-dashboard" id="monitoring-app" aria-busy="true">
    <section class="mon-hero">
        <div><div class="mon-eyebrow"><span></span> PUSAT KENDALI RISIKO</div>
            <h1>Dashboard Monitoring</h1>
            <p>Pantau pergerakan risiko. Temukan prioritas. Tentukan langkah penanganan.</p>
            <div class="mon-hero-tags"><span id="mon-profile-label">Profil risiko</span><span id="mon-period-label">Memuat periode…</span></div>
        </div>
        <div class="mon-hero-right"><div class="mon-live"><span></span> Data laporan internal</div>
            <span id="mon-updated">Menyiapkan analisis</span>
            <button type="button" class="mon-refresh" id="mon-refresh"><i class="mdi mdi-refresh" aria-hidden="true"></i> Perbarui data</button>
        </div>
    </section>

    <form id="mon-filter-form" class="mon-filter-panel">
        <div class="mon-filter-main">
            <label>Jenis profil risiko<select name="profile" id="mon-profile">
                <?php foreach ($monitoringOptions['profiles'] as $p): ?><option value="<?= (int)$p['id'] ?>" <?= (int)$p['id'] === $monitoringFilters['profile'] ? 'selected' : '' ?>><?= $mh($p['name']) ?><?= (int)$p['reports'] === 0 ? ' · belum ada laporan' : '' ?></option><?php endforeach; ?>
            </select></label>
            <?php foreach (['start' => 'Periode awal', 'end' => 'Periode akhir'] as $side => $label): ?>
            <div class="mon-date-field"><label for="mon-<?= $side ?>-year"><?= $label ?></label><div>
                <select name="<?= $side ?>_year" id="mon-<?= $side ?>-year" aria-label="Tahun <?= $side === 'start' ? 'awal' : 'akhir' ?>">
                    <?php foreach ($monitoringOptions['years'] as $year): ?><option value="<?= $year ?>" <?= $year === $monitoringFilters[$side . '_year'] ? 'selected' : '' ?>><?= $year ?></option><?php endforeach; ?>
                </select>
                <select name="<?= $side ?>_quarter" aria-label="Triwulan <?= $side === 'start' ? 'awal' : 'akhir' ?>">
                    <?php for ($q = 1; $q <= 4; $q++): ?><option value="<?= $q ?>" <?= $q === $monitoringFilters[$side . '_quarter'] ? 'selected' : '' ?>>Triwulan <?= $q ?></option><?php endfor; ?>
                </select>
            </div></div>
            <?php endforeach; ?>
            <button type="submit" class="mon-btn mon-btn-primary" id="mon-apply"><i class="mdi mdi-tune" aria-hidden="true"></i> Terapkan filter</button>
        </div>
        <div class="mon-filter-secondary">
            <label>Wilayah<select name="region" id="mon-region"><option value="semua">Semua wilayah</option><?php foreach ($monitoringOptions['regions'] as $key => $name): ?><option value="<?= $mh($key) ?>" <?= $key === $monitoringFilters['region'] ? 'selected' : '' ?>><?= $mh($name) ?></option><?php endforeach; ?></select></label>
            <label>Cabang<select name="branch" id="mon-branch"><option value="0">Semua cabang</option><?php foreach ($monitoringOptions['branches'] as $branch): ?><option value="<?= (int)$branch['id'] ?>" data-region="<?= mon_region((int)$branch['id']) ?>" <?= (int)$branch['id'] === $monitoringFilters['branch'] ? 'selected' : '' ?>><?= $mh($branch['name']) ?></option><?php endforeach; ?></select></label>
            <label>Penerimaan KC<select name="receipt"><option value="semua" <?= $monitoringFilters['receipt'] === 'semua' ? 'selected' : '' ?>>Semua laporan</option><option value="diterima" <?= $monitoringFilters['receipt'] === 'diterima' ? 'selected' : '' ?>>Diterima Korwil &amp; SKMR</option></select></label>
            <p><i class="mdi mdi-information-outline" aria-hidden="true"></i> Analisis mengikuti laporan tersimpan pada rentang yang dipilih.</p>
        </div>
    </form>
    <div id="mon-error" class="mon-error" role="alert" hidden></div>
    <div id="mon-loading" class="mon-loading" role="status"><span></span> Menyusun data monitoring…</div>

    <section class="mon-kpis" aria-label="Ringkasan monitoring">
        <article class="mon-kpi"><div class="mon-kpi-top"><span>Indeks profil pilihan</span><i class="mdi mdi-chart-box-outline"></i></div><strong id="mon-kpi-score">—</strong><div id="mon-kpi-score-note">Nilai komposit laporan</div><div class="mon-score-track"><span id="mon-score-fill"></span></div></article>
        <article class="mon-kpi"><div class="mon-kpi-top"><span>Parameter perhatian</span><i class="mdi mdi-alert-circle-outline"></i></div><strong id="mon-kpi-attention">—</strong><div id="mon-kpi-attention-note">Kelompok parameter per profil / wilayah</div><span class="mon-kpi-tag" id="mon-kpi-high">Memuat prioritas tinggi</span></article>
        <article class="mon-kpi"><div class="mon-kpi-top"><span>Kelengkapan inheren KC</span><i class="mdi mdi-clipboard-check-outline"></i></div><strong id="mon-kpi-coverage">—</strong><div id="mon-kpi-coverage-note">Enam jenis risiko inheren terisi</div><div class="mon-coverage-track"><span id="mon-coverage-fill"></span></div></article>
        <article class="mon-kpi"><div class="mon-kpi-top"><span>Fokus wilayah</span><i class="mdi mdi-map-marker-radius-outline"></i></div><strong id="mon-kpi-region" class="mon-kpi-word">—</strong><div id="mon-kpi-region-note">Rata-rata nilai komposit KC tertinggi</div><button type="button" class="mon-text-btn" id="mon-open-regions">Lihat peta wilayah <span aria-hidden="true">↗</span></button></article>
    </section>

    <section class="mon-chart-row">
        <article class="mon-panel mon-trend-panel"><div class="mon-panel-heading"><div><span class="mon-section-kicker">PERGERAKAN ANTARPERIODE</span><h2>Tren profil risiko</h2></div><div class="mon-segments" id="mon-trend-segments" aria-label="Jenis nilai grafik"><button type="button" data-metric="composite" class="active" aria-pressed="true">Komposit</button><button type="button" data-metric="inheren" aria-pressed="false">Inheren</button><button type="button" data-metric="kpmr" aria-pressed="false">KPMR</button></div></div>
            <div id="mon-trend-chart" class="mon-chart" aria-label="Grafik tren nilai profil dan rata-rata KC"></div>
            <p class="mon-footnote">Rata-rata KC menggunakan laporan yang tersedia pada setiap periode. Cakupan antarperiode dapat berbeda.</p>
        </article>
        <article class="mon-panel"><div class="mon-panel-heading"><div><span class="mon-section-kicker">STATUS LAPORAN KC</span><h2>Penerimaan laporan</h2></div><span class="mon-small-pill" id="mon-receipt-period">—</span></div>
            <div id="mon-receipt-chart" class="mon-chart mon-donut" aria-label="Diagram laporan diterima dan belum diterima"></div>
            <div class="mon-receipt-stats"><div><span class="mon-dot mon-dot-green"></span>Diterima<strong id="mon-received">—</strong></div><div><span class="mon-dot mon-dot-gray"></span>Belum diterima<strong id="mon-pending">—</strong></div></div>
        </article>
    </section>

    <div class="mon-section-title"><div><span class="mon-section-kicker">ENAM JENIS RISIKO</span><h2>Peta risiko &amp; wilayah</h2></div><label class="mon-inline-label">Nilai yang ditampilkan<select id="mon-display-metric"><option value="inheren">Risiko Inheren</option><option value="kpmr">KPMR</option><option value="composite">Komposit per risiko</option></select></label></div>
    <section id="mon-risk-cards" class="mon-risk-cards" aria-label="Indeks enam jenis risiko"></section>
    <section class="mon-map-row" id="mon-regions-section">
        <article class="mon-panel"><div class="mon-panel-heading"><div><span class="mon-section-kicker">PROFIL PILIHAN VS KANTOR CABANG</span><h2>Perbandingan jenis risiko</h2></div></div><div id="mon-risk-chart" class="mon-chart" aria-label="Grafik perbandingan enam risiko"></div><p class="mon-footnote" id="mon-comparison-note">Nilai kosong tidak diganti dengan nol.</p></article>
        <article class="mon-panel mon-map-panel"><div class="mon-panel-heading"><div><span class="mon-section-kicker">EMPAT KANTOR WILAYAH</span><h2>Sebaran perhatian risiko</h2></div><span class="mon-small-pill" id="mon-region-period">—</span></div>
            <div id="mon-heatmap" class="mon-heatmap" aria-label="Peta nilai risiko per wilayah"></div>
            <div class="mon-legend"><span><i class="mon-band-1"></i>&lt; 2</span><span><i class="mon-band-2"></i>2 – &lt; 3</span><span><i class="mon-band-3"></i>3 – &lt; 4</span><span><i class="mon-band-4"></i>≥ 4</span><span><i class="mon-band-empty"></i>Belum terisi</span></div>
            <p class="mon-footnote">Klik sel untuk memfokuskan wilayah dan risiko. Angka wilayah adalah rata-rata nilai KC yang tersedia, bukan penetapan konsolidasi resmi.</p>
        </article>
    </section>

    <section class="mon-bottom-row">
        <article class="mon-panel mon-priority-panel"><div class="mon-panel-heading"><div><span class="mon-section-kicker">TINDAK LANJUT BERDASARKAN DATA</span><h2>Parameter yang perlu perhatian <span id="mon-priority-count" class="mon-count">0</span></h2></div><button type="button" id="mon-export" class="mon-btn mon-btn-light"><i class="mdi mdi-download-outline"></i> Unduh CSV</button></div>
            <div class="mon-priority-scope-controls">
                <label>Tampilkan parameter<select id="mon-priority-scope" name="priority_scope" form="mon-filter-form">
                    <option value="wilayah" <?= $monitoringFilters['priority_scope'] === 'wilayah' ? 'selected' : '' ?>>Per wilayah</option>
                    <option value="cabang" <?= $monitoringFilters['priority_scope'] === 'cabang' ? 'selected' : '' ?>>Per cabang</option>
                </select></label>
                <label>Pilih cabang<select id="mon-priority-branch" name="priority_branch" form="mon-filter-form" <?= $monitoringFilters['priority_scope'] === 'wilayah' ? 'disabled' : '' ?>>
                    <option value="0">Semua cabang</option>
                    <?php foreach ($monitoringOptions['branches'] as $branch): ?><option value="<?= (int)$branch['id'] ?>" data-region="<?= mon_region((int)$branch['id']) ?>" <?= (int)$branch['id'] === $monitoringFilters['priority_branch'] ? 'selected' : '' ?>><?= $mh($branch['name']) ?></option><?php endforeach; ?>
                </select></label>
            </div>
            <p class="mon-footnote" id="mon-priority-scope-note">Pilihan ini berlaku untuk parameter, detail, CSV, dan rekomendasi. Cabang mengikuti filter wilayah, periode, dan status laporan di atas; grafik ringkasan tetap mengikuti filter utama.</p>
            <div class="mon-table-tools"><label class="mon-search"><i class="mdi mdi-magnify"></i><input id="mon-search" type="search" placeholder="Cari parameter, risiko, wilayah, atau cabang…" aria-label="Cari parameter perhatian"></label><select id="mon-risk-filter" aria-label="Filter jenis risiko"><option value="semua">Semua risiko</option><?php foreach (mon_risks() as $key => $name): ?><option value="<?= $mh($key) ?>"><?= $mh($name) ?></option><?php endforeach; ?></select><select id="mon-severity-filter" aria-label="Filter prioritas"><option value="semua">Semua prioritas</option><option value="tinggi">Prioritas tinggi</option><option value="naik">Nilai meningkat</option></select></div>
            <div class="mon-priority-table-wrap"><table class="mon-priority-table"><thead><tr><th>Parameter / sumber</th><th>Wilayah / cabang</th><th id="mon-priority-value-title">Nilai tertinggi</th><th>Perubahan</th><th>Detail</th></tr></thead><tbody id="mon-priority-body"></tbody></table></div>
            <div class="mon-pagination"><span id="mon-page-info">Memuat parameter…</span><div><button type="button" id="mon-prev" aria-label="Halaman sebelumnya">←</button><button type="button" id="mon-next" aria-label="Halaman berikutnya">→</button></div></div>
            <p class="mon-footnote">Prioritas analisis: nilai ≥ 3 atau kenaikan ≥ 0,25 pada sampel yang sama. Nilai ≥ 4 diberi prioritas tinggi. Skala ini membantu triase; penetapan peringkat mengikuti laporan.</p>
        </article>
        <aside class="mon-panel mon-ai-panel"><div class="mon-ai-heading"><span class="mon-ai-icon"><i class="mdi mdi-auto-fix"></i></span><div><span class="mon-section-kicker">ASISTEN ANALISIS</span><h2>Rekomendasi penanganan</h2></div></div>
            <p class="mon-ai-intro">Susun langkah penanganan berdasarkan parameter perhatian dan cakupan yang dipilih.</p>
            <button type="button" class="mon-btn mon-btn-ai" id="mon-gemini"><i class="mdi mdi-auto-fix"></i> Analisis dengan Gemini</button>
            <p class="mon-ai-disclosure">Gemini menerima ringkasan angka dan parameter pada cakupan aktif. Hasilnya merupakan usulan untuk ditinjau SKMR.</p>
            <div id="mon-ai-error" class="mon-error" role="alert" hidden></div>
            <div class="mon-ai-source" id="mon-ai-source">Panduan awal · berbasis indikator</div>
            <div id="mon-recommendations" aria-live="polite"></div>
        </aside>
    </section>
    <section class="mon-panel mon-quality"><div><i class="mdi mdi-shield-check-outline"></i><h2>Catatan kualitas data</h2></div><ul id="mon-quality-list"><li>Memeriksa cakupan laporan…</li></ul><p>Nilai 0 atau kosong tidak dianggap sebagai penilaian risiko rendah. Data monitoring hanya dibaca, tanpa mengubah nilai atau persetujuan laporan.</p></section>
    <noscript><div class="mon-error">Aktifkan JavaScript untuk memakai grafik dan filter interaktif Dashboard Monitoring.</div></noscript>
</main></div></div>
<div class="mon-drawer-overlay" id="mon-drawer-overlay" hidden><section class="mon-drawer" role="dialog" aria-modal="true" aria-labelledby="mon-drawer-title"><header><span>DETAIL PARAMETER</span><button type="button" id="mon-drawer-close" aria-label="Tutup detail">×</button></header><div id="mon-drawer-content"></div></section></div>
<script>window.MONITORING_CONFIG = <?= json_encode(['endpoint' => 'monitoring_api.php', 'csrf' => $_SESSION['monitoring_csrf']], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<script defer src="../assets/js/dashboard-monitoring.js?v=20261030-01"></script>
