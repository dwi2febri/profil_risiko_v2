
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../conn/conn.php";
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['idbobot']) ? (int)$_GET['idbobot'] : 0;
if ($id <= 0) {
    die('idbobot tidak valid');
}

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function q($conn, $sql, $label='SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die('<div style="padding:20px;background:#fff;color:#000;font-family:Arial">'
            .'<h3 style="color:red;margin-bottom:10px;">'.esc($label).' ERROR</h3>'
            .'<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>'
            .'<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>'
            .'</div>');
    }
    return $res;
}
function fetch_one($conn, $sql, $label='SQL'){
    $res = q($conn, $sql, $label);
    return mysqli_fetch_assoc($res);
}
function decimal5($n){
    return number_format((float)$n, 5, '.', '');
}
function numval_post($arr, $key){
    return isset($arr[$key]) ? (float)str_replace(',', '.', (string)$arr[$key]) : 0;
}
function json_ok($ok=true, $msg=''){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok'=>$ok,'msg'=>$msg]);
    exit;
}

function column_exists($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}


$frame = fetch_one($conn, "SELECT fb.*, upr.tipe_user FROM frame_bobot fb
    LEFT JOIN user_profil_risiko upr ON fb.user = upr.id_user_profil_risiko
    WHERE fb.id_bobot='$id' LIMIT 1", 'GET FRAME');
if (!$frame) die('Frame bobot tidak ditemukan.');

if (isset($_GET['action']) && $_GET['action'] === 'aktifkan') {
    $userAktif = (int)$frame['user'];
    q($conn, "UPDATE frame_bobot SET is_aktif='0' WHERE user='$userAktif'", 'NONAKTIFKAN SEMUA PER USER');
    q($conn, "UPDATE frame_bobot SET is_aktif='1' WHERE id_bobot='$id'", 'AKTIFKAN frame_bobot');
    header("Location: index.php?page=bobot_tabs&idbobot=".$id."&ok=aktif");
    exit;
}
if (isset($_GET['action']) && $_GET['action'] === 'nonaktifkan') {
    q($conn, "UPDATE frame_bobot SET is_aktif='0' WHERE id_bobot='$id'", 'NONAKTIFKAN frame_bobot');
    header("Location: index.php?page=bobot_tabs&idbobot=".$id."&ok=nonaktif");
    exit;
}

function kredit_groups(){
    return [
        'k1' => [
            'title' => 'PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit',
            'parameter' => 'Aset Produktif / Total Aset',
            'count' => 7,
            'fields' => [
                'sub_parameter1' => 'a. Penempatan Bank Lain / Total Aset',
                'sub_parameter2' => 'b. Aba Pada 1 Bank Tertinggi / Penempatan Bank Lain',
                'sub_parameter3' => 'c. Aba Pada BPR / Penempatan Bank Lain',
                'sub_parameter5' => 'd. Kredit PEP / Total KYD',
                'sub_parameter6' => 'e. Kredit plafond > 350jt / Total KYD',
                'sub_parameter7' => 'f. Saldo CKPN / Total Kredit',
                'sub_parameter8' => 'g. AYDA / KYD',
            ]
        ],
        'k2' => [
            'title' => 'PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit',
            'parameter' => 'Kredit Yang Diberikan / Aset Produktif',
            'count' => 11,
            'fields' => [
                'sub_parameter2_1' => 'a. Kredit Skema Potong Gaji / Total Kredit',
                'sub_parameter2_2' => 'b. Kredit Musiman (Grace Period) / Total KYD',
                'sub_parameter2_3' => 'c. Kredit Jangka Pendek / Total KYD',
                'sub_parameter2_4' => 'd. Kredit Jangka Menengah / Total KYD',
                'sub_parameter2_5' => 'e. Kredit Jangka Panjang / Total KYD',
                'sub_parameter2_6' => 'f. Kredit Dengan Agunan Tanah dan Bangunan / Total KYD',
                'sub_parameter2_7' => 'g. Kredit Agunan Kendaraan Bermotor / Total KYD',
                'sub_parameter2_8' => 'h. Kredit Agunan Kendaraan Roda 2 / Total KYD',
                'sub_parameter2_9' => 'i. OSC Produk KUB / Total KYD',
                'sub_parameter2_10' => 'j. Kredit Tanpa Agunan / Total KYD',
                'sub_parameter2_11' => 'k. Kredit Korporasi (Non Perorangan) / Total KYD',
            ]
        ],
        'k3' => [
            'title' => 'PILAR 2 : Kualitas Aset',
            'parameter' => 'Kredit Bermasalah Neto / Total Kredit',
            'count' => 6,
            'fields' => [
                'sub_parameter3_1' => 'a. NPL Kredit plafond s/d 150 juta / Total KYD plafond s/d 150 jt',
                'sub_parameter3_2' => 'b. NPL Kredit plafond diatas 50 juta / Total KYD plafond diatas 50 juta',
                'sub_parameter3_3' => 'c. NPL Kredit Dengan Perikatan APHT / Total KYD',
                'sub_parameter3_4' => 'd. NPL Kredit Dengan Perikatan SKMHT / Total KYD',
                'sub_parameter3_5' => 'e. NPL Nilai Agunan Lebih Rendah Dari Baki Debet / Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet',
                'sub_parameter3_6' => 'f. Kredit Macet sudah jatuh tempo / Total KYD',
            ]
        ],
        'k4' => [
            'title' => 'PILAR 2 : Kualitas Aset',
            'parameter' => 'Kredit Kualitas Rendah / Total Kredit',
            'count' => 4,
            'fields' => [
                'sub_parameter4_1' => 'a. Kredit PAR 4 / Total Kredit',
                'sub_parameter4_2' => 'b. Kredit DP (PAR 3 + PAR 4) / Total Kredit',
                'sub_parameter4_3' => 'c. NOA FPD 6 Bulan Terakhir / NOA Ekspansi 6 Bulan Terakhir',
                'sub_parameter4_4' => 'd. Nominal FPD 6 Bulan Terakhir / Plafond Ekspansi 6 Bulan Terakhir',
            ]
        ],
        'k5' => [
            'title' => 'PILAR 3 : Strategi Penyediaan Dana',
            'parameter' => 'Strategi Penyediaan Dana (SK Limit)',
            'count' => 2,
            'fields' => [
                'sub_parameter5_1' => 'a. SK Limit'
            ]
        ],
        'k6' => [
            'title' => 'PILAR 4 : Faktor Eksternal',
            'parameter' => 'Faktor Eksternal',
            'count' => 4,
            'fields' => [
                'sub_parameter6_1' => 'a. Layanan Digital Kompetitor',
                'sub_parameter6_2' => 'b. Kejadian luar biasa yang berpengaruh terhadap kinerja Bank',
                'sub_parameter6_3' => 'c. Persaingan Layanan antar BPR',
                'sub_parameter6_4' => 'd. Regulasi Pemerintah',
            ]
        ],
        'k7' => [
            'title' => 'LAINNYA',
            'parameter' => 'Faktor Lainnya',
            'count' => 2,
            'fields' => [
                'sub_parameter7_1' => 'a. Kompetensi AO',
                'sub_parameter7_2' => 'b. Kompetensi Analis',
            ]
        ],
    ];
}

function likuiditas_groups(){
    return [
        'l1' => [
            'title' => 'PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban',
            'parameter' => 'Aset Likuid / Kewajiban Lancar',
            'count' => 9,
            'fields' => [
                'sub_parameter2_1' => 'a. Total Aset Likuid / Pendanaan Jangka Pendek',
                'sub_parameter2_2' => 'b. Aset Likuid / Kewajiban Jangka Pendek',
                'sub_parameter2_3' => 'c. Arus Kas Netto / Total DPK',
                'sub_parameter2_4' => 'd. Tabungan / Total DPK',
                'sub_parameter2_5' => 'e. Deposito Jangka Waktu 3 bln / Total DPK',
                'sub_parameter2_6' => 'f. Deposito Jangka Waktu 6 bln / Total DPK',
                'sub_parameter2_7' => 'g. Deposito Jangka Waktu 12 bln / Total DPK',
                'sub_parameter2_8' => 'h. Modal Disetor / Total DPK',
                'sub_parameter2_9' => 'i. Pinjaman / Total DPK',
            ]
        ],
        'l2' => [
            'title' => 'PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban',
            'parameter' => 'Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank',
            'count' => 3,
            'fields' => [
                'sub_parameter3_1' => 'a. DPK Yang Dijamin LPS / DPK',
                'sub_parameter3_2' => 'b. Alat Likuid - Kredit Lancar / Dana Pihak Ke 3',
                'sub_parameter3_4' => 'c. Pertumbuhan Kredit / Pertumbuhan Simpanan',
            ]
        ],
        'l3' => [
            'title' => 'PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban',
            'parameter' => 'Pendanaan Non Inti / Total Pendanaan',
            'count' => 4,
            'fields' => [
                'sub_parameter4_1' => 'a. Pendanaan Non Inti - Alat Likuid / Total Aset - Aset Likuid',
                'sub_parameter4_2' => 'b. Deposito Rate Spesial / Alat Likuid',
                'sub_parameter4_3' => 'c. Aset Likuid / Pendanaan Non Inti',
                'sub_parameter4_4' => 'd. Deposito Inti (100 Deposan) / Total DPK',
            ]
        ],
        'l4' => [
            'title' => 'PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan',
            'parameter' => 'Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan',
            'count' => 3,
            'fields' => [
                'sub_parameter5_1' => 'a. Sumber Pendanaan Untuk Memenuhi Kebutuhan Likuiditas',
                'sub_parameter5_2' => 'b. Identifikasi Terhadap Produk Kredit dan Simpanan',
                'sub_parameter5_3' => 'c. Identifikasi Sumber Pendanaan Non Inti',
            ]
        ],
        'l5' => [
            'title' => 'LAINNYA',
            'parameter' => 'Faktor Lainnya',
            'count' => 3,
            'fields' => [
                'sub_parameter6_1' => 'a. Penyusunan Profil Maturitas',
                'sub_parameter6_2' => 'b. Penyusunan Proyeksi Arus Kas',
                'sub_parameter6_3' => 'c. Penyusunan Stress Testing Kemampuan Likuiditas',
            ]
        ],
    ];
}

function default_map_from_groups($groups){
    $map = [];
    foreach($groups as $grp){
        $count = max(1, (int)$grp['count']);
        foreach(array_keys($grp['fields']) as $field){
            $map[$field] = decimal5(1/$count);
        }
    }

    if (isset($map['sub_parameter5_1'])) {
        $map['sub_parameter5_1'] = decimal5(0.5);
    }

    return $map;
}

function ensure_detail_row($conn, $table, $pk, $id_bobot, $tahun, $dibuat_by){
    $row = fetch_one($conn, "SELECT * FROM `$table` WHERE id_bobot='".(int)$id_bobot."' LIMIT 1", "GET $table");
    if ($row) return $row;
    q($conn, "INSERT INTO `$table`(`$pk`, id_bobot, tahun, dibuat_at, dibuat_by)
        VALUES ('0','".(int)$id_bobot."','".(int)$tahun."', '".date('Y-m-d')."', '".(int)$dibuat_by."')", "INSERT $table");
    return fetch_one($conn, "SELECT * FROM `$table` WHERE id_bobot='".(int)$id_bobot."' LIMIT 1", "GET2 $table");
}

$kreditGroups = kredit_groups();
$likGroups = likuiditas_groups();

// FIX CABANG: khusus user id 3 (Profil Risiko Kantor Cabang),
// parameter h. Modal Disetor / Total DPK tidak ditampilkan dan tidak ikut total bobot.
// User lain tetap memakai struktur lengkap.
$isProfilRisikoCabang = ((int)($frame['user'] ?? 0) === 3);
if ($isProfilRisikoCabang && isset($likGroups['l1']['fields']['sub_parameter2_8'])) {
    unset($likGroups['l1']['fields']['sub_parameter2_8']);
    $likGroups['l1']['count'] = count($likGroups['l1']['fields']);
}

if (!column_exists($conn, 'bobot_kredit_per_parameter', 'sub_parameter5_1')) {
    q($conn, "ALTER TABLE bobot_kredit_per_parameter ADD COLUMN sub_parameter5_1 DECIMAL(10,5) NULL DEFAULT NULL AFTER sub_parameter4_4", 'ALTER sub_parameter5_1');
}

$bobotKredit = ensure_detail_row($conn, 'bobot_kredit_per_parameter', 'id_bobot_kredit_per_parameter', $id, (int)$frame['tahun'], (int)$frame['dibuat_by']);
$bobotLik = ensure_detail_row($conn, 'bobot_likuiditas_per_parameter', 'id_bobot_likuiditas_per_parameter', $id, (int)$frame['tahun'], (int)$frame['dibuat_by']);

$defaultKredit = default_map_from_groups($kreditGroups);
$defaultLik = default_map_from_groups($likGroups);

foreach ($defaultKredit as $f => $v){
    if (!isset($bobotKredit[$f]) || trim((string)$bobotKredit[$f]) === '' || trim((string)$bobotKredit[$f]) === '0' || trim((string)$bobotKredit[$f]) === '0.00' || trim((string)$bobotKredit[$f]) === '0.00000'){
        $bobotKredit[$f] = $v;
    }
}
foreach ($defaultLik as $f => $v){
    if (!isset($bobotLik[$f]) || trim((string)$bobotLik[$f]) === '' || trim((string)$bobotLik[$f]) === '0' || trim((string)$bobotLik[$f]) === '0.00' || trim((string)$bobotLik[$f]) === '0.00000'){
        $bobotLik[$f] = $v;
    }
}

// FIX CABANG: jika setting lama masih memakai 9 bobot @0.11111 termasuk Modal Disetor,
// otomatis ubah menjadi 8 bobot @0.12500 dan nol-kan sub_parameter2_8.
// Ini hanya dijalankan ketika pola lama terdeteksi, supaya custom bobot yang sudah benar tidak ditimpa.
if ($isProfilRisikoCabang) {
    $visibleL1Fields = array_keys($likGroups['l1']['fields']);
    $sumVisibleL1 = 0;
    foreach ($visibleL1Fields as $vf) {
        $sumVisibleL1 += (float)($bobotLik[$vf] ?? 0);
    }
    $hiddenModalDisetor = (float)($bobotLik['sub_parameter2_8'] ?? 0);
    $totalOldL1 = $sumVisibleL1 + $hiddenModalDisetor;

    if ($hiddenModalDisetor > 0.00001 && abs($totalOldL1 - 1) <= 0.01 && abs($sumVisibleL1 - 1) > 0.01) {
        foreach ($visibleL1Fields as $vf) {
            $bobotLik[$vf] = decimal5(1 / max(1, count($visibleL1Fields)));
        }
        $bobotLik['sub_parameter2_8'] = decimal5(0);
        $setsCabangL1 = [];
        foreach ($visibleL1Fields as $vf) {
            $setsCabangL1[] = "`$vf`='".mysqli_real_escape_string($conn, $bobotLik[$vf])."'";
        }
        $setsCabangL1[] = "`sub_parameter2_8`='0.00000'";
        q($conn, "UPDATE bobot_likuiditas_per_parameter SET ".implode(', ', $setsCabangL1)." WHERE id_bobot='$id'", 'FIX DEFAULT LIK CABANG TANPA MODAL DISETOR');
    }
}

// simpan default ke database jika record masih kosong/null
$needSaveKredit = [];
foreach ($defaultKredit as $f => $v){
    if (!isset($bobotKredit[$f]) || trim((string)$bobotKredit[$f]) === '' || strtoupper(trim((string)$bobotKredit[$f])) === 'NULL'){
        $needSaveKredit[] = "`$f`='".mysqli_real_escape_string($conn, $bobotKredit[$f])."'";
    }
}
if (!empty($needSaveKredit)) {
    q($conn, "UPDATE bobot_kredit_per_parameter SET ".implode(', ', $needSaveKredit)." WHERE id_bobot='$id'", 'INIT DEFAULT KREDIT');
}

$needSaveLik = [];
foreach ($defaultLik as $f => $v){
    if (!isset($bobotLik[$f]) || trim((string)$bobotLik[$f]) === '' || strtoupper(trim((string)$bobotLik[$f])) === 'NULL'){
        $needSaveLik[] = "`$f`='".mysqli_real_escape_string($conn, $bobotLik[$f])."'";
    }
}
if (!empty($needSaveLik)) {
    q($conn, "UPDATE bobot_likuiditas_per_parameter SET ".implode(', ', $needSaveLik)." WHERE id_bobot='$id'", 'INIT DEFAULT LIK');
}

if (isset($_POST['autosave']) && $_POST['autosave'] == '1') {
    $jenis = isset($_POST['jenis']) ? trim((string)$_POST['jenis']) : '';
    if ($jenis === 'kredit') {
        $sets = [];
        foreach ($defaultKredit as $field => $def){
            if (isset($_POST[$field])) {
                $val = decimal5(numval_post($_POST, $field));
                $sets[] = "`$field`='".mysqli_real_escape_string($conn, $val)."'";
            }
        }
        if (!empty($sets)) {
            q($conn, "UPDATE bobot_kredit_per_parameter SET ".implode(', ', $sets)." WHERE id_bobot='$id'", 'UPDATE AUTOSAVE KREDIT');
        }
        json_ok(true, 'Bobot kredit tersimpan.');
    }

    if ($jenis === 'likuiditas') {
        $sets = [];
        foreach ($defaultLik as $field => $def){
            if (isset($_POST[$field])) {
                $val = decimal5(numval_post($_POST, $field));
                $sets[] = "`$field`='".mysqli_real_escape_string($conn, $val)."'";
            }
        }

        // FIX CABANG: field Modal Disetor disembunyikan, jadi pastikan nilainya 0 di database.
        if ($isProfilRisikoCabang) {
            $sets[] = "`sub_parameter2_8`='0.00000'";
        }

        if (!empty($sets)) {
            q($conn, "UPDATE bobot_likuiditas_per_parameter SET ".implode(', ', $sets)." WHERE id_bobot='$id'", 'UPDATE AUTOSAVE LIKUIDITAS');
        }
        json_ok(true, 'Bobot likuiditas tersimpan.');
    }

    json_ok(false, 'Jenis autosave tidak dikenal.');
}

function total_group($row, $fields){
    $t = 0;
    foreach(array_keys($fields) as $f){
        $t += (float)($row[$f] ?? 0);
    }
    return $t;
}
?>
<style>
.bobot-nav .nav-link{font-weight:600}
.bobot-group-card{border:1px solid #dee2e6;border-radius:.4rem;margin-bottom:1rem}
.bobot-group-card .card-header{background:#0f172a;color:#fff;font-weight:700}
.bobot-group-card .table th,.bobot-group-card .table td{vertical-align:middle}
.bobot-parameter-title{font-weight:600;color:#334155}
.bobot-total-box{font-weight:700}
.bobot-total-box.is-over{background:#dc3545!important;color:#fff!important}
.small-note{font-size:12px;color:#6c757d}
.save-indicator{font-size:12px;color:#0d6efd;display:none}
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Tentukan Bobot Kredit dan Likuiditas Inheren dan KPMR</h4>
                    </div>
                </div>
            </div>

            <form id="formKredit" onsubmit="return false;"></form>
            <form id="formLikuiditas" onsubmit="return false;"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <a href="index.php?page=bobot" class="btn btn-secondary btn-sm">← Kembali</a>
                                    <?php if ((int)$frame['is_aktif'] === 1): ?>
                                        <span class="badge bg-success">Aktif</span>
                                        <a href="index.php?page=bobot_tabs&idbobot=<?= (int)$id ?>&action=nonaktifkan" class="btn btn-danger btn-sm" onclick="return confirm('Nonaktifkan setting bobot ini?')">Nonaktifkan</a>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                        <a href="index.php?page=bobot_tabs&idbobot=<?= (int)$id ?>&action=aktifkan" class="btn btn-success btn-sm" onclick="return confirm('Aktifkan setting bobot ini?')">Aktifkan</a>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <span class="badge bg-primary">Tahun: <?= esc($frame['tahun']) ?></span>
                                    <span class="badge bg-info text-dark"><?= esc($frame['tipe_user']) ?></span>
                                </div>
                            </div>

                            <ul class="nav nav-tabs bobot-nav mb-3" id="bobotTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="kredit-tab" data-bs-toggle="tab" data-bs-target="#tab-kredit" type="button" role="tab">Kredit</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="likuiditas-tab" data-bs-toggle="tab" data-bs-target="#tab-likuiditas" type="button" role="tab">Likuiditas</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-kredit" role="tabpanel">
                                    <h4 class="header-title">Penetapan Bobot Kredit</h4>
                                    <p class="text-muted font-13">Bilangan desimal gunakan . contoh : 0.23</p>
                                    <div class="save-indicator" id="saveIndicatorKredit">Menyimpan...</div>

                                    <?php foreach($kreditGroups as $groupKey => $grp): ?>
                                        <div class="bobot-group-card">
                                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <span><?= esc($grp['title']) ?></span>
                                                <?php if ($groupKey === 'k5'): ?>
                                                <button type="button" class="btn btn-sm btn-light ratakan-btn" data-target-form="formKredit" data-group="<?= esc($groupKey) ?>" data-auto-value="0.50000">Auto</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-light ratakan-btn" data-target-form="formKredit" data-group="<?= esc($groupKey) ?>">Ratakan</button>
                                            <?php endif; ?>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive-sm">
                                                    <table class="table table-bordered table-top mb-0">
                                                        <thead class="table-info">
                                                            <tr>
                                                                <th width="65%"><?= esc($grp['parameter']) ?></th>
                                                                <th width="20%" class="text-center">Bobot</th>
                                                                <th width="15%" class="text-center">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-secondary">
                                                            <?php foreach($grp['fields'] as $field => $label): ?>
                                                                <tr>
                                                                    <td><?= esc($label) ?></td>
                                                                    <td>
                                                                        <input type="number" step="0.00001" min="0" form="formKredit" name="<?= esc($field) ?>"
                                                                               value="<?= esc($bobotKredit[$field] ?? $defaultKredit[$field]) ?>"
                                                                               class="form-control form-control-sm bobot-input"
                                                                               data-form="formKredit" data-group="<?= esc($groupKey) ?>">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            <tr>
                                                                <td><b>Total</b></td>
                                                                <td colspan="2">
                                                                    <input type="text" readonly class="form-control form-control-sm bobot-total-box"
                                                                           id="total_<?= esc($groupKey) ?>" value="<?= number_format(total_group($bobotKredit, $grp['fields']), 5, '.', '') ?>">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="tab-pane fade" id="tab-likuiditas" role="tabpanel">
                                    <h4 class="header-title">Penetapan Bobot Likuiditas</h4>
                                    <p class="text-muted font-13">Bilangan desimal gunakan . contoh : 0.23</p>
                                    <div class="save-indicator" id="saveIndicatorLikuiditas">Menyimpan...</div>

                                    <?php foreach($likGroups as $groupKey => $grp): ?>
                                        <div class="bobot-group-card">
                                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                                <span><?= esc($grp['title']) ?></span>
                                                <button type="button" class="btn btn-sm btn-light ratakan-btn" data-target-form="formLikuiditas" data-group="<?= esc($groupKey) ?>">Ratakan</button>
                                            </div>
                                            <div class="card-body p-0">
                                                <div class="table-responsive-sm">
                                                    <table class="table table-bordered table-top mb-0">
                                                        <thead class="table-info">
                                                            <tr>
                                                                <th width="65%"><?= esc($grp['parameter']) ?></th>
                                                                <th width="20%" class="text-center">Bobot</th>
                                                                <th width="15%" class="text-center">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-secondary">
                                                            <?php foreach($grp['fields'] as $field => $label): ?>
                                                                <tr>
                                                                    <td><?= esc($label) ?></td>
                                                                    <td>
                                                                        <input type="number" step="0.00001" min="0" form="formLikuiditas" name="<?= esc($field) ?>"
                                                                               value="<?= esc($bobotLik[$field] ?? $defaultLik[$field]) ?>"
                                                                               class="form-control form-control-sm bobot-input"
                                                                               data-form="formLikuiditas" data-group="<?= esc($groupKey) ?>">
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            <tr>
                                                                <td><b>Total</b></td>
                                                                <td colspan="2">
                                                                    <input type="text" readonly class="form-control form-control-sm bobot-total-box"
                                                                           id="total_<?= esc($groupKey) ?>" value="<?= number_format(total_group($bobotLik, $grp['fields']), 5, '.', '') ?>">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <p class="small-note mt-2 mb-0">Auto save aktif. Nilai tersimpan otomatis saat diubah.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>

<script>
(function(){
    const groupCounts = {
        kredit: {
            k1: 7, k2: 11, k3: 6, k4: 4, k5: 1, k6: 4, k7: 2
        },
        likuiditas: {
            l1: <?= (int)$likGroups['l1']['count'] ?>, l2: 3, l3: 4, l4: 3, l5: 3
        }
    };

    function updateGroupTotal(group){
        const inputs = document.querySelectorAll('.bobot-input[data-group="'+group+'"]');
        const totalEl = document.getElementById('total_' + group);
        if (!totalEl) return;
        let total = 0;
        inputs.forEach(function(el){
            const v = parseFloat(el.value || 0);
            if (!isNaN(v)) total += v;
        });
        totalEl.value = total.toFixed(5);
        totalEl.classList.toggle('is-over', total > 1.00001);
    }

    function updateAllTotals(){
        document.querySelectorAll('.bobot-total-box').forEach(function(el){
            const group = el.id.replace('total_', '');
            updateGroupTotal(group);
        });
    }

    function doAutosave(formId){
        const form = document.getElementById(formId);
        if (!form) return;
        const jenis = formId === 'formKredit' ? 'kredit' : 'likuiditas';
        const saveIndicator = document.getElementById(jenis === 'kredit' ? 'saveIndicatorKredit' : 'saveIndicatorLikuiditas');
        const fd = new FormData();
        fd.append('autosave', '1');
        fd.append('jenis', jenis);
        document.querySelectorAll('[form="'+formId+'"][name]').forEach(function(el){
            fd.append(el.name, el.value || '');
        });
        if (saveIndicator) saveIndicator.style.display = 'block';
        fetch(window.location.href, {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function(r){ return r.json(); })
          .then(function(){})
          .catch(function(err){ console.error(err); })
          .finally(function(){
              if (saveIndicator) {
                  saveIndicator.style.display = 'none';
              }
          });
    }

    let timers = {};
    document.querySelectorAll('.bobot-input').forEach(function(el){
        const group = el.dataset.group;
        const formId = el.dataset.form;

        el.addEventListener('input', function(){
            updateGroupTotal(group);
            clearTimeout(timers[formId]);
            timers[formId] = setTimeout(function(){ doAutosave(formId); }, 500);
        });

        el.addEventListener('change', function(){
            updateGroupTotal(group);
            doAutosave(formId);
        });

        el.addEventListener('blur', function(){
            updateGroupTotal(group);
            doAutosave(formId);
        });
    });

    document.querySelectorAll('.ratakan-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            const formId = btn.dataset.targetForm;
            const jenis = formId === 'formKredit' ? 'kredit' : 'likuiditas';
            const group = btn.dataset.group;
            const autoValue = btn.dataset.autoValue || '';
            const count = groupCounts[jenis][group] || 1;
            const val = autoValue !== '' ? autoValue : (1 / count).toFixed(5);
            document.querySelectorAll('.bobot-input[data-group="'+group+'"][data-form="'+formId+'"]').forEach(function(el){
                el.value = val;
            });
            updateGroupTotal(group);
            doAutosave(formId);
        });
    });

    updateAllTotals();

    const tabButtons = document.querySelectorAll('#bobotTab button[data-bs-toggle="tab"]');
    tabButtons.forEach(function(btn){
        btn.addEventListener('shown.bs.tab', function(){
            localStorage.setItem('activeBobotTab', btn.getAttribute('data-bs-target'));
        });
    });
    const activeTab = localStorage.getItem('activeBobotTab');
    if (activeTab) {
        const triggerEl = document.querySelector('#bobotTab button[data-bs-target="' + activeTab + '"]');
        if (triggerEl && typeof bootstrap !== 'undefined') {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
        }
    }
})();
</script>
