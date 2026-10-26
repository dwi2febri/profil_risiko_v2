<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../conn/conn.php";
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function is_ajax_request(){
    return (
        (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || isset($_POST['ajax'])
        || isset($_POST['auto_save'])
    );
}

function json_response($ok, $message = '', $extra = []){
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=utf-8');
    }
    echo json_encode(array_merge([
        'ok' => $ok ? true : false,
        'message' => $message
    ], $extra));
    exit;
}

$page_self = 'rep_kpmr1';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$displayModal = ($id <= 0);
$backUrl = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
    ? $_SERVER['HTTP_REFERER']
    : 'index.php?page=dashboard';

function esc($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function q($conn, $sql, $label = 'SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $err = $label . ' ERROR: ' . mysqli_error($conn);
        if (is_ajax_request()) {
            throw new Exception($err . ' | SQL: ' . $sql);
        }
        die(
            '<div style="padding:20px;background:#fff;color:#000;font-family:Arial">' .
            '<h3 style="color:red;margin-bottom:10px;">'.$label.' ERROR</h3>' .
            '<pre style="white-space:pre-wrap;">'.htmlspecialchars(mysqli_error($conn)).'</pre>' .
            '<hr><pre style="white-space:pre-wrap;">'.htmlspecialchars($sql).'</pre>' .
            '</div>'
        );
    }
    return $res;
}

function fetch_one($conn, $sql, $label = 'SQL'){
    $res = q($conn, $sql, $label);
    return mysqli_fetch_assoc($res);
}

function table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function ensure_kpmr_assessment_tables($conn){
    q($conn, "
        CREATE TABLE IF NOT EXISTS assessment_kpmr (
            id_assessment_kpmr INT AUTO_INCREMENT PRIMARY KEY,
            id_profil_risiko INT NOT NULL,
            jenis_risiko VARCHAR(100) NOT NULL,
            total_nilai DECIMAL(10,2) DEFAULT 0,
            tingkat_risiko DECIMAL(10,2) DEFAULT 0,
            peringkat VARCHAR(100) DEFAULT NULL,
            dibuat_by INT DEFAULT 0,
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_assessment_kpmr_1 (id_profil_risiko),
            KEY idx_assessment_kpmr_2 (jenis_risiko)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ", 'CREATE assessment_kpmr');

    q($conn, "
        CREATE TABLE IF NOT EXISTS assessment_kpmr_detail (
            id_detail INT AUTO_INCREMENT PRIMARY KEY,
            id_assessment_kpmr INT NOT NULL,
            ref_tipe VARCHAR(30) NOT NULL,
            ref_id INT NOT NULL,
            parameter_id INT DEFAULT 0,
            sub_parameter_id INT DEFAULT 0,
            nilai INT DEFAULT 0,
            nilai_sebelumnya INT DEFAULT 0,
            keterangan TEXT NULL,
            urutan_pilar INT DEFAULT 0,
            urutan_parameter INT DEFAULT 0,
            urutan_sub INT DEFAULT 0,
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_assessment_kpmr_detail (id_assessment_kpmr, ref_tipe, ref_id),
            KEY idx_assessment_kpmr_detail_1 (parameter_id),
            KEY idx_assessment_kpmr_detail_2 (sub_parameter_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ", 'CREATE assessment_kpmr_detail');
}

function get_peringkat_kpmr($nilai){
    if ($nilai < 1.00) return 'Belum Terisi';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Memadai';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Memadai';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Cukup Memadai';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Kurang Memadai';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Tidak Memadai';
    return 'Belum Terisi';
}

function get_skala_map_kpmr($conn, $ref_tipe, $ref_id, $kpmr_periode_id){
    $map = [];
    $ref_tipe = mysqli_real_escape_string($conn, $ref_tipe);
    $ref_id = (int)$ref_id;
    $kpmr_periode_id = (int)$kpmr_periode_id;

    $q = q($conn, "
        SELECT skala, deskripsi
        FROM kpmr_skala
        WHERE ref_tipe = '$ref_tipe'
          AND ref_id = '$ref_id'
          AND kpmr_periode_id = '$kpmr_periode_id'
        ORDER BY skala ASC
    ", 'LOAD KPMR SKALA');

    while($r = mysqli_fetch_assoc($q)){
        $map[(int)$r['skala']] = $r['deskripsi'];
    }

    return $map;
}

function kpmr_skala_ada($skala){
    if (!is_array($skala)) return false;
    for ($i = 1; $i <= 5; $i++) {
        $v = isset($skala[$i]) ? trim(strip_tags((string)$skala[$i])) : '';
        $v = str_replace(["&nbsp;", "\xc2\xa0"], ' ', $v);
        $v = trim($v);
        if ($v !== '' && $v !== '-' && $v !== '–') {
            return true;
        }
    }
    return false;
}

if ($displayModal) {
?>
<style>
    .oai-idkosong-overlay{
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.48);
        z-index:999999;
        display:flex;
        align-items:center;
        justify-content:center;
        padding:20px;
    }
    .oai-idkosong-modal{
        width:100%;
        max-width:700px;
        background:#fff;
        border-radius:8px;
        box-shadow:0 15px 40px rgba(0,0,0,.30);
        overflow:hidden;
        animation:oaiPop .18s ease-out;
    }
    .oai-idkosong-head{
        display:flex;
        align-items:center;
        justify-content:space-between;
        padding:16px 20px;
        border-bottom:1px solid #e5e7eb;
        font-size:24px;
        font-weight:700;
        color:#374151;
    }
    .oai-idkosong-closex{
        border:0;
        background:transparent;
        font-size:30px;
        line-height:1;
        color:#6b7280;
        cursor:pointer;
    }
    .oai-idkosong-body{
        padding:26px 22px;
        text-align:center;
        font-size:24px;
        line-height:1.65;
        color:#4b5563;
        font-weight:700;
    }
    .oai-idkosong-foot{
        padding:14px 20px;
        border-top:1px solid #e5e7eb;
        text-align:right;
    }
    .oai-idkosong-btn{
        border:0;
        background:#ff5c7c;
        color:#fff;
        padding:10px 22px;
        border-radius:4px;
        font-size:16px;
        cursor:pointer;
    }
    @keyframes oaiPop{
        from{transform:scale(.96);opacity:0;}
        to{transform:scale(1);opacity:1;}
    }
</style>

<div class="oai-idkosong-overlay" id="oaiIdKosongOverlay">
    <div class="oai-idkosong-modal" role="dialog" aria-modal="true" aria-labelledby="oaiIdKosongTitle">
        <div class="oai-idkosong-head">
            <div id="oaiIdKosongTitle">Notifikasi</div>
            <button type="button" class="oai-idkosong-closex" id="oaiIdKosongCloseX">&times;</button>
        </div>
        <div class="oai-idkosong-body">
            Mohon untuk memilih laporan risiko di menu dashboard -> laporan profil risiko -> klik (aktif) terlebih dahulu.
        </div>
        <div class="oai-idkosong-foot">
            <button type="button" class="oai-idkosong-btn" id="oaiIdKosongCloseBtn">Close</button>
        </div>
    </div>
</div>

<script>
(function(){
    function goBackPage(){
        var fallback = <?= json_encode($backUrl) ?>;
        if (document.referrer && document.referrer !== window.location.href) {
            window.location.href = fallback;
        } else if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = fallback;
        }
    }

    var overlay = document.getElementById('oaiIdKosongOverlay');
    var btnX = document.getElementById('oaiIdKosongCloseX');
    var btnClose = document.getElementById('oaiIdKosongCloseBtn');

    btnX.addEventListener('click', goBackPage);
    btnClose.addEventListener('click', goBackPage);

    overlay.addEventListener('click', function(e){
        if (e.target === overlay) goBackPage();
    });

    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') goBackPage();
    });
})();
</script>
<?php
    return;
}

ensure_kpmr_assessment_tables($conn);

if (!table_exists($conn, 'kpmr_pilih_parameter')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_pilih_parameter</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_pilih_parameter_detail')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_pilih_parameter_detail</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_periode')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_periode</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_jenis_risiko')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_jenis_risiko</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_pilar')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_pilar</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_parameter')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_parameter</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_sub_parameter')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_sub_parameter</b> belum ada.</div>');
}
if (!table_exists($conn, 'kpmr_skala')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel <b>kpmr_skala</b> belum ada.</div>');
}

$frame = null;
$assessment = null;
$assessment_id = 0;
$detailExisting = [];
$detailPembanding = [];
$group = [];
$pilihHeader = null;
$checkedParam = [];
$checkedSub = [];
$notif_sukses = false;

$frame = fetch_one($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        c.cabang,
        u.tipe_user
    FROM frame_laporan_profil_risiko f
    LEFT JOIN periode_laporan_profil_risiko p
        ON f.periode = p.id_periode
    LEFT JOIN jenis_cabang c
        ON f.kantor_cabang = c.id_cabang
    LEFT JOIN user_profil_risiko u
        ON f.user = u.id_user_profil_risiko
    WHERE f.id_profil_risiko = '$id'
    LIMIT 1
", 'FRAME');

if (!$frame) {
    die('<div style="padding:20px;background:#fff;color:#000">Frame laporan tidak ditemukan.</div>');
}

$assessment = fetch_one($conn, "
    SELECT *
    FROM assessment_kpmr
    WHERE id_profil_risiko = '$id'
      AND jenis_risiko = 'RISIKO REPUTASI'
    LIMIT 1
", 'READ KPMR ASSESSMENT');

if (!$assessment) {
    q($conn, "
        INSERT INTO assessment_kpmr
        (id_profil_risiko, jenis_risiko, dibuat_by)
        VALUES
        ('$id', 'RISIKO REPUTASI', '".(int)($_SESSION['user_id'] ?? 0)."')
    ", 'CREATE KPMR ASSESSMENT');

    $assessment_id = mysqli_insert_id($conn);

    $assessment = fetch_one($conn, "
        SELECT *
        FROM assessment_kpmr
        WHERE id_assessment_kpmr = '$assessment_id'
        LIMIT 1
    ", 'READ NEW KPMR ASSESSMENT');
}

$assessment_id = (int)$assessment['id_assessment_kpmr'];

$qExist = q($conn, "
    SELECT *
    FROM assessment_kpmr_detail
    WHERE id_assessment_kpmr = '$assessment_id'
", 'READ KPMR DETAIL EXISTING');

while($e = mysqli_fetch_assoc($qExist)){
    $detailExisting[$e['ref_tipe'].'|'.$e['ref_id']] = $e;
}

if (!empty($frame['data_pembanding'])) {
    $dp = (int)$frame['data_pembanding'];

    $pembandingHeader = fetch_one($conn, "
        SELECT *
        FROM assessment_kpmr
        WHERE id_profil_risiko = '$dp'
          AND jenis_risiko = 'RISIKO REPUTASI'
        LIMIT 1
    ", 'READ KPMR PEMBANDING HEADER');

    if ($pembandingHeader) {
        $qPembanding = q($conn, "
            SELECT *
            FROM assessment_kpmr_detail
            WHERE id_assessment_kpmr = '".(int)$pembandingHeader['id_assessment_kpmr']."'
        ", 'READ KPMR PEMBANDING DETAIL');

        while($pb = mysqli_fetch_assoc($qPembanding)){
            $detailPembanding[$pb['ref_tipe'].'|'.$pb['ref_id']] = $pb;
        }
    }
}

$pilihHeader = fetch_one($conn, "
    SELECT kp.*, kper.tahun
    FROM kpmr_pilih_parameter kp
    INNER JOIN kpmr_periode kper
        ON kp.kpmr_periode_id = kper.id
    WHERE kper.tahun = '".$frame['tahun']."'
      AND kp.id_user_profil_risiko = '".$frame['user']."'
    ORDER BY kp.id DESC
    LIMIT 1
", 'READ KPMR PILIH HEADER');

if (!$pilihHeader) {
    die('<div style="padding:20px;background:#fff;color:#000">Checklist parameter KPMR untuk user <b>'.esc($frame['tipe_user']).'</b> tahun <b>'.esc($frame['tahun']).'</b> belum dibuat.</div>');
}

$id_pilih = (int)$pilihHeader['id'];
$periode_master_id = (int)$pilihHeader['kpmr_periode_id'];

require_once __DIR__ . '/../includes/pembanding_parameter.php';
$detailPembanding = admin_pembanding_parameter($conn, $detailPembanding, 'kpmr', 'RISIKO REPUTASI', $periode_master_id);

$qChecklist = q($conn, "
    SELECT ref_tipe, ref_id
    FROM kpmr_pilih_parameter_detail
    WHERE kpmr_pilih_parameter_id = '$id_pilih'
", 'READ KPMR CHECKLIST');

while($ck = mysqli_fetch_assoc($qChecklist)){
    if ($ck['ref_tipe'] === 'parameter') {
        $checkedParam[(int)$ck['ref_id']] = true;
    }
    if ($ck['ref_tipe'] === 'sub_parameter') {
        $checkedSub[(int)$ck['ref_id']] = true;
    }
}

$qData = q($conn, "
    SELECT
        jr.id AS jenis_id,
        jr.nama_risiko,
        p.id AS pilar_id,
        p.nama_pilar,
        p.urutan AS pilar_urutan,
        pm.id AS parameter_id,
        pm.nomor_parameter,
        pm.nama_parameter,
        pm.urutan AS parameter_urutan,
        sp.id AS sub_parameter_id,
        sp.nama_sub_parameter,
        sp.urutan AS sub_urutan
    FROM kpmr_jenis_risiko jr
    INNER JOIN kpmr_pilar p
        ON p.jenis_risiko_id = jr.id
       AND p.kpmr_periode_id = '$periode_master_id'
    INNER JOIN kpmr_parameter pm
        ON pm.pilar_id = p.id
       AND pm.kpmr_periode_id = '$periode_master_id'
    LEFT JOIN kpmr_sub_parameter sp
        ON sp.parameter_id = pm.id
       AND sp.kpmr_periode_id = '$periode_master_id'
    WHERE jr.nama_risiko = 'RISIKO REPUTASI'
      AND jr.kpmr_periode_id = '$periode_master_id'
    ORDER BY p.urutan, pm.urutan, sp.urutan
", 'LOAD KPMR PARAMETER REPUTASI');

while($r = mysqli_fetch_assoc($qData)){
    $pilar_id = (int)$r['pilar_id'];
    $parameter_id = (int)$r['parameter_id'];
    $sub_id = (int)$r['sub_parameter_id'];

    $showParameter = isset($checkedParam[$parameter_id]);
    $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));

    if (!$showParameter && !$showSub) continue;

    if (!isset($group[$pilar_id])) {
        $group[$pilar_id] = [
            'nama_pilar' => $r['nama_pilar'],
            'urutan' => (int)$r['pilar_urutan'],
            'parameters' => []
        ];
    }

    if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
        $group[$pilar_id]['parameters'][$parameter_id] = [
            'nomor_parameter' => $r['nomor_parameter'],
            'nama_parameter' => $r['nama_parameter'],
            'urutan' => (int)$r['parameter_urutan'],
            'show_parameter' => $showParameter,
            'subs' => []
        ];
    } else {
        if ($showParameter) {
            $group[$pilar_id]['parameters'][$parameter_id]['show_parameter'] = true;
        }
    }

    if ($showSub) {
        $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = [
            'nama_sub_parameter' => $r['nama_sub_parameter'],
            'urutan' => (int)$r['sub_urutan']
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ((isset($_POST['submit']) || isset($_POST['auto_save'])) && isset($_POST['nilai']) && is_array($_POST['nilai']))) {
    $isAutoSave = isset($_POST['auto_save']) && is_ajax_request();
    mysqli_begin_transaction($conn);
    try {
        foreach ($_POST['nilai'] as $refKey => $nilai) {
            $nilai = (int)$nilai;
            if ($nilai < 1 || $nilai > 5) $nilai = 0;

            $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan'][$refKey] ?? '');

            $pecah = explode('|', $refKey);
            $ref_tipe = mysqli_real_escape_string($conn, $pecah[0] ?? '');
            $ref_id   = (int)($pecah[1] ?? 0);

            $parameter_id     = !empty($_POST['parameter_id'][$refKey]) ? (int)$_POST['parameter_id'][$refKey] : 0;
            $sub_parameter_id = !empty($_POST['sub_parameter_id'][$refKey]) ? (int)$_POST['sub_parameter_id'][$refKey] : 0;
            $urutan_pilar     = (int)($_POST['urutan_pilar'][$refKey] ?? 0);
            $urutan_parameter = (int)($_POST['urutan_parameter'][$refKey] ?? 0);
            $urutan_sub       = (int)($_POST['urutan_sub'][$refKey] ?? 0);

            $nilai_sebelumnya = 0;
            if (isset($detailPembanding[$refKey])) {
                $nilai_sebelumnya = (int)$detailPembanding[$refKey]['nilai'];
            }

            $cek = q($conn, "
                SELECT id_detail
                FROM assessment_kpmr_detail
                WHERE id_assessment_kpmr = '$assessment_id'
                  AND ref_tipe = '$ref_tipe'
                  AND ref_id = '$ref_id'
                LIMIT 1
            ", 'CHECK DETAIL');

            if (mysqli_num_rows($cek) > 0) {
                q($conn, "
                    UPDATE assessment_kpmr_detail
                    SET
                        nilai = '$nilai',
                        nilai_sebelumnya = '$nilai_sebelumnya',
                        keterangan = '$keterangan',
                        parameter_id = '$parameter_id',
                        sub_parameter_id = '$sub_parameter_id',
                        urutan_pilar = '$urutan_pilar',
                        urutan_parameter = '$urutan_parameter',
                        urutan_sub = '$urutan_sub'
                    WHERE id_assessment_kpmr = '$assessment_id'
                      AND ref_tipe = '$ref_tipe'
                      AND ref_id = '$ref_id'
                ", 'UPDATE DETAIL');
            } else {
                q($conn, "
                    INSERT INTO assessment_kpmr_detail
                    (
                        id_assessment_kpmr,
                        ref_tipe,
                        ref_id,
                        parameter_id,
                        sub_parameter_id,
                        nilai,
                        nilai_sebelumnya,
                        keterangan,
                        urutan_pilar,
                        urutan_parameter,
                        urutan_sub
                    )
                    VALUES
                    (
                        '$assessment_id',
                        '$ref_tipe',
                        '$ref_id',
                        '$parameter_id',
                        '$sub_parameter_id',
                        '$nilai',
                        '$nilai_sebelumnya',
                        '$keterangan',
                        '$urutan_pilar',
                        '$urutan_parameter',
                        '$urutan_sub'
                    )
                ", 'INSERT DETAIL');
            }
        }

        $dHitung = fetch_one($conn, "
            SELECT AVG(nilai) AS rata2
            FROM assessment_kpmr_detail
            WHERE id_assessment_kpmr = '$assessment_id'
        ", 'HITUNG NILAI');

        $tingkat_risiko = round((float)($dHitung['rata2'] ?? 0), 2);
        $peringkat = get_peringkat_kpmr($tingkat_risiko);

        q($conn, "
            UPDATE assessment_kpmr
            SET total_nilai = '$tingkat_risiko',
                tingkat_risiko = '$tingkat_risiko',
                peringkat = '".mysqli_real_escape_string($conn, $peringkat)."'
            WHERE id_assessment_kpmr = '$assessment_id'
        ", 'UPDATE HEADER');

        mysqli_commit($conn);

        if ($isAutoSave) {
            json_response(true, 'Assessment tersimpan otomatis.', [
                'tingkat_risiko' => $tingkat_risiko,
                'peringkat' => $peringkat
            ]);
        }

        echo "<script>window.location='index.php?page=".$page_self."&id=".$id."&saved=1';</script>";
        exit;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        if ($isAutoSave) {
            json_response(false, $e->getMessage());
        }
        die('<div style="padding:20px;background:#fff;color:#000">'.esc($e->getMessage()).'</div>');
    }
}

if (isset($_GET['saved']) && $_GET['saved'] == '1') {
    $notif_sukses = true;
}
?>

<style>
.content-page{overflow-x:hidden !important;}
.content-page .content{overflow-x:hidden !important;}
.content-page .container-fluid{
    padding-left:20px !important;
    padding-right:20px !important;
    padding-top:8px !important;
}
@media (max-width: 991.98px){
    .content-page .container-fluid{
        padding-left:12px !important;
        padding-right:12px !important;
        padding-top:10px !important;
    }
}
.page-title-box{
    padding-top:10px !important;
    margin-top:6px !important;
    margin-bottom:10px !important;
}
.card-op{
    border:0;
    border-radius:8px;
    overflow:hidden;
    margin-bottom:8px;
}
.full-height-card{
    min-height:calc(100dvh - 210px);
    display:flex;
    flex-direction:column;
}
.card-op .card-header{
    font-weight:700;
    padding:14px 16px;
    flex:0 0 auto;
}
.card-op .card-body{
    flex:1 1 auto;
    min-height:0;
    display:flex;
    flex-direction:column;
}
.card-op .card-body form{
    flex:1 1 auto;
    min-height:0;
    display:flex;
    flex-direction:column;
}
.header-flex-op{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}
.header-title-op{
    margin:0;
    font-size:18px;
    font-weight:700;
}
.header-right-badge{
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}
.badge-info-lite{
    display:inline-block;
    background:#e0f2fe;
    color:#0f172a;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
.badge-grey-lite{
    display:inline-block;
    background:#e5e7eb;
    color:#111827;
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}
.table-wrap-op{
    width:100%;
    overflow-x:auto;
    overflow-y:visible;
    border:1px solid #dbe5ef;
    margin-top:0;
    margin-bottom:10px;
    position:relative;
}
.table-wrap-op::-webkit-scrollbar{
    width:10px;
    height:10px;
}
.table-wrap-op::-webkit-scrollbar-thumb{
    background:#c7d2e3;
    border-radius:20px;
}
.tbl-op{
    width:100%;
    min-width:1185px;
    margin-bottom:0;
    table-layout:fixed;
    border-collapse:separate;
    border-spacing:0;
}
.tbl-op thead th{
    background:#69b4e7 !important;
    color:#000 !important;
    text-align:center;
    vertical-align:middle;
    border:1px solid #d8e6f3 !important;
    font-weight:700;
    padding:12px 8px;
}
.tbl-op td{
    vertical-align:top;
    border:1px solid #e3e8ef !important;
    color:#4b5563;
    font-size:13px;
    line-height:1.55;
    background:#fff;
    padding:10px 10px;
}
.tbl-op .row-pilar td{
    background:#58d3dd !important;
    font-weight:700;
    color:#3f4a56;
    font-size:14px;
    padding:10px 12px;
}
.tbl-op .row-parameter td{
    background:#f4f1dd !important;
}
.tbl-op .row-parameter td.param-name{
    font-weight:700;
    color:#505a66;
}
.tbl-op .row-sub td{
    background:#ffffff !important;
}
.tbl-op .row-sub td.param-name{
    padding-left:18px !important;
    color:#5f6b78;
}
.col-no{
    width:36px !important;
    min-width:36px !important;
    max-width:36px !important;
    text-align:center !important;
    padding-left:2px !important;
    padding-right:2px !important;
    white-space:nowrap !important;
}
.tbl-op col.col-no-col{
    width:36px !important;
}
.tbl-op col.col-param-col{
    width:205px !important;
}
.tbl-op col.col-skala-col{
    width:150px !important;
}
.tbl-op col.col-nilai-col{
    width:74px !important;
}
.tbl-op col.col-prev-col{
    width:120px !important;
}
.col-param{
    width:230px !important;
    min-width:230px !important;
}
.col-skala{
    width:140px !important;
    min-width:140px !important;
}
.col-nilai{
    width:64px !important;
    min-width:64px !important;
    max-width:64px !important;
    text-align:center;
    padding-left:4px !important;
    padding-right:4px !important;
}
.col-prev{
    width:100px !important;
    min-width:100px !important;
    max-width:100px !important;
    text-align:center;
}
.select-nilai{
    width:54px;
    min-width:54px;
    margin:0 auto;
}
.ket-box{
    display:block;
    width:100%;
    min-width:0;
    max-width:100%;
    box-sizing:border-box;
    min-height:82px;
    resize:vertical;
    background:#fff;
}

.param-title{
    display:block;
    margin-bottom:6px;
}
.ket-mini-wrap{
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:4px;
    margin-top:5px;
    width:100%;
}
.ket-mini-line{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:3px;
    width:100%;
    white-space:nowrap;
    font-size:11px;
    line-height:1.1;
    font-weight:400 !important;
    color:#111827;
}
.ket-status-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:38px;
    height:17px;
    padding:1px 6px;
    border-radius:999px;
    font-size:10px;
    line-height:1;
    font-weight:600;
    white-space:nowrap;
    border:1px solid transparent;
}
.ket-status-badge.is-filled{
    background:#dcfce7;
    color:#166534;
    border-color:#bbf7d0;
}
.ket-status-badge.is-empty{
    background:#ffe4e6;
    color:#9f1239;
    border-color:#fecdd3;
}
.ket-toggle-btn{
    width:28px;
    height:20px;
    padding:0;
    margin:0;
    border:1px solid #b8c0ce;
    border-radius:7px;
    background:linear-gradient(180deg,#9ca3af,#6b7280);
    color:#fff;
    font-size:12px;
    line-height:18px;
    font-weight:700;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    box-shadow:0 2px 5px rgba(15,23,42,.18);
}
.ket-toggle-btn:hover{
    filter:brightness(.96);
}
.ket-toggle-btn.is-open{
    background:linear-gradient(180deg,#6b7280,#4b5563);
}
.ket-dropdown-row td{
    background:#f8fbff !important;
    padding:10px 12px !important;
}
.ket-panel{
    border:1px solid #dbeafe;
    background:#ffffff;
    border-radius:12px;
    padding:12px;
    box-shadow:0 8px 20px rgba(15,23,42,.06);
}
.ket-panel-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    margin-bottom:8px;
    font-size:13px;
    font-weight:700;
    color:#111827;
}
.ket-panel-close{
    border:0;
    background:#fee2e2;
    color:#991b1b;
    width:24px;
    height:24px;
    border-radius:999px;
    font-size:14px;
    line-height:1;
    cursor:pointer;
}

.mt-save{
    margin-top:8px;
    margin-bottom:0;
    background:#fff;
    padding-top:4px;
    flex:0 0 auto;
}

.auto-save-toast{
    position:fixed;
    right:18px;
    bottom:18px;
    z-index:2000;
    background:#0f172a;
    color:#fff;
    padding:10px 14px;
    border-radius:10px;
    box-shadow:0 10px 25px rgba(0,0,0,.18);
    font-size:13px;
    display:none;
    max-width:420px;
}
.auto-save-toast.show{display:block}
.auto-save-toast.ok{background:#16a34a}
.auto-save-toast.err{background:#dc2626}
.empty-control-cell{background:#fff !important;}
</style>


<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="mb-3">KPMR Reputasi [<?= esc($frame['cabang']); ?> Tahun <?= esc($frame['tahun']); ?> - <?= esc($frame['periode_laporan']); ?>]</h4>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card card-op full-height-card">
                        <div class="card-header bg-info text-white">
                            <div class="header-flex-op">
                                <div class="header-title-op">KPMR Reputasi</div>
                                <div class="header-right-badge">
                                    <?php if ($pilihHeader) { ?>
                                        <span class="badge-info-lite">Checklist Aktif: <?= esc($frame['tipe_user']); ?></span>
                                        <span class="badge-grey-lite">Tahun: <?= esc($frame['tahun']); ?></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php if ($notif_sukses) { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom:12px;">
                                    Assessment KPMR reputasi berhasil disimpan.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>

                            <?php if (empty($group)) { ?>
                                <div class="alert alert-warning">
                                    Data parameter KPMR reputasi tidak ditemukan dari checklist parameter user <b><?= esc($frame['tipe_user']); ?></b> tahun <b><?= esc($frame['tahun']); ?></b>.
                                </div>
                            <?php } else { ?>
                            <form method="post" id="form_assessment">
                                <div class="table-wrap-op" id="tableWrapOp">
                                    <table class="table table-bordered tbl-op">
                                        <colgroup>
                                            <col class="col-no-col">
                                            <col class="col-param-col">
                                            <col class="col-skala-col">
                                            <col class="col-skala-col">
                                            <col class="col-skala-col">
                                            <col class="col-skala-col">
                                            <col class="col-skala-col">
                                            <col class="col-nilai-col">
                                            <col class="col-prev-col">
                                        </colgroup>
                                        <thead>
                                            <tr>
                                                <th colspan="9">KPMR REPUTASI </th>
                                            </tr>
                                            <tr>
                                                <th rowspan="2" class="col-no">NO</th>
                                                <th rowspan="2" class="col-param">PARAMETER</th>
                                                <th colspan="5">SKALA RISIKO</th>
                                                <th rowspan="2" class="col-nilai">PENILAIAN</th>
                                                <th rowspan="2" class="col-prev">PENILAIAN PERIODE<br>SEBELUMNYA</th>
                                            </tr>
                                            <tr>
                                                <th class="col-skala">1</th>
                                                <th class="col-skala">2</th>
                                                <th class="col-skala">3</th>
                                                <th class="col-skala">4</th>
                                                <th class="col-skala">5</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($group as $pilar_id => $pilar){ ?>
                                            <tr class="row-pilar">
                                                <td colspan="9"><?= esc($pilar['nama_pilar']); ?></td>
                                            </tr>

                                            <?php foreach($pilar['parameters'] as $parameter_id => $param){ ?>
                                                <?php
                                                if ($param['show_parameter']) {
                                                    $refKey = 'parameter|'.$parameter_id;
                                                    $old = $detailExisting[$refKey] ?? null;
                                                    $oldPrev = $detailPembanding[$refKey]['nilai'] ?? 0;
                                                    $skala = get_skala_map_kpmr($conn, 'parameter', $parameter_id, $periode_master_id);
                                                ?>
                                                <tr class="row-parameter">
                                                    <td class="col-no"><?= esc($param['nomor_parameter']); ?></td>
                                                    <?php $adaSkala = kpmr_skala_ada($skala); ?>
                                                    <td class="param-name col-param">
                                                        <div class="param-title"><b><?= esc($param['nama_parameter']); ?></b></div>
                                                        <?php if ($adaSkala) { 
                                                            $ketParamIsi = trim((string)($old['keterangan'] ?? '')) !== '';
                                                        ?>
                                                        <div class="ket-mini-wrap">
                                                            <div class="ket-mini-line">Keterangan : <span class="ket-status-badge <?= $ketParamIsi ? 'is-filled' : 'is-empty' ?>" data-ket-badge-for="ket_<?= md5($refKey) ?>"><?= $ketParamIsi ? 'Terisi' : 'Kosong' ?></span></div>
                                                            <button type="button" class="ket-toggle-btn" data-target="ket_panel_<?= md5($refKey) ?>" aria-label="Buka keterangan">▼</button>
                                                        </div>
                                                        <?php } ?>
                                                    </td>
                                                    <?php for($i=1;$i<=5;$i++){ ?>
                                                        <td class="col-skala"><?= $adaSkala ? esc($skala[$i] ?? '') : '' ?></td>
                                                    <?php } ?>
                                                    <?php if ($adaSkala) { ?>
                                                        <td class="col-nilai">
                                                            <select
                                                                name="nilai[<?= esc($refKey) ?>]"
                                                                class="form-control select-nilai auto-ket-trigger"
                                                                data-target="ket_<?= md5($refKey) ?>">
                                                                <option value="">-</option>
                                                                <?php for($i=1;$i<=5;$i++){ ?>
                                                                    <option
                                                                        value="<?= $i ?>"
                                                                        data-desc="<?= esc($skala[$i] ?? '') ?>"
                                                                        <?= ((string)($old['nilai'] ?? '') === (string)$i ? 'selected' : '') ?>>
                                                                        <?= $i ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                            <input type="hidden" name="parameter_id[<?= esc($refKey) ?>]" value="<?= $parameter_id ?>">
                                                            <input type="hidden" name="sub_parameter_id[<?= esc($refKey) ?>]" value="0">
                                                            <input type="hidden" name="urutan_pilar[<?= esc($refKey) ?>]" value="<?= (int)$pilar['urutan'] ?>">
                                                            <input type="hidden" name="urutan_parameter[<?= esc($refKey) ?>]" value="<?= (int)$param['urutan'] ?>">
                                                            <input type="hidden" name="urutan_sub[<?= esc($refKey) ?>]" value="0">
                                                        </td>
                                                        <td class="col-prev"><?= esc($oldPrev) ?></td>
                                                    <?php } else { ?>
                                                        <td class="col-nilai empty-control-cell"></td>
                                                        <td class="col-prev empty-control-cell"></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php if ($adaSkala) { ?>
                                                <tr class="ket-dropdown-row" id="ket_panel_<?= md5($refKey) ?>" style="display:none;">
                                                    <td colspan="9">
                                                        <div class="ket-panel">
                                                            <div class="ket-panel-head">
                                                                <span>Keterangan: <?= esc($param['nama_parameter']); ?></span>
                                                                <button type="button" class="ket-panel-close" data-target="ket_panel_<?= md5($refKey) ?>">×</button>
                                                            </div>
                                                            <textarea
                                                                id="ket_<?= md5($refKey) ?>"
                                                                name="keterangan[<?= esc($refKey) ?>]"
                                                                class="form-control ket-box auto-ket-box"
                                                                data-last-auto=""><?= esc($old['keterangan'] ?? '') ?></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <?php } ?>

                                                <?php if (!empty($param['subs'])) { ?>
                                                    <?php $huruf = 'a'; ?>
                                                    <?php foreach($param['subs'] as $sub_id => $sub){ ?>
                                                        <?php
                                                        $refKeySub = 'sub_parameter|'.$sub_id;
                                                        $oldSub = $detailExisting[$refKeySub] ?? null;
                                                        $oldPrevSub = $detailPembanding[$refKeySub]['nilai'] ?? 0;
                                                        $skalaSub = get_skala_map_kpmr($conn, 'sub_parameter', $sub_id, $periode_master_id);
                                                        ?>
                                                        <tr class="row-sub">
                                                            <td class="col-no"></td>
                                                            <?php $adaSkalaSub = kpmr_skala_ada($skalaSub); ?>
                                                            <td class="param-name col-param">
                                                                <div class="param-title"><?= esc($huruf) ?>. <?= esc($sub['nama_sub_parameter']) ?></div>
                                                                <?php if ($adaSkalaSub) {
                                                                    $ketSubIsi = trim((string)($oldSub['keterangan'] ?? '')) !== '';
                                                                ?>
                                                                <div class="ket-mini-wrap">
                                                                    <div class="ket-mini-line">Keterangan : <span class="ket-status-badge <?= $ketSubIsi ? 'is-filled' : 'is-empty' ?>" data-ket-badge-for="ket_<?= md5($refKeySub) ?>"><?= $ketSubIsi ? 'Terisi' : 'Kosong' ?></span></div>
                                                                    <button type="button" class="ket-toggle-btn" data-target="ket_panel_<?= md5($refKeySub) ?>" aria-label="Buka keterangan">▼</button>
                                                                </div>
                                                                <?php } ?>
                                                            </td>
                                                            <?php for($i=1;$i<=5;$i++){ ?>
                                                                <td class="col-skala"><?= $adaSkalaSub ? esc($skalaSub[$i] ?? '') : '' ?></td>
                                                            <?php } ?>
                                                            <?php if ($adaSkalaSub) { ?>
                                                                <td class="col-nilai">
                                                                    <select
                                                                        name="nilai[<?= esc($refKeySub) ?>]"
                                                                        class="form-control select-nilai auto-ket-trigger"
                                                                        data-target="ket_<?= md5($refKeySub) ?>">
                                                                        <option value="">-</option>
                                                                        <?php for($i=1;$i<=5;$i++){ ?>
                                                                            <option
                                                                                value="<?= $i ?>"
                                                                                data-desc="<?= esc($skalaSub[$i] ?? '') ?>"
                                                                                <?= ((string)($oldSub['nilai'] ?? '') === (string)$i ? 'selected' : '') ?>>
                                                                                <?= $i ?>
                                                                            </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <input type="hidden" name="parameter_id[<?= esc($refKeySub) ?>]" value="<?= $parameter_id ?>">
                                                                    <input type="hidden" name="sub_parameter_id[<?= esc($refKeySub) ?>]" value="<?= $sub_id ?>">
                                                                    <input type="hidden" name="urutan_pilar[<?= esc($refKeySub) ?>]" value="<?= (int)$pilar['urutan'] ?>">
                                                                    <input type="hidden" name="urutan_parameter[<?= esc($refKeySub) ?>]" value="<?= (int)$param['urutan'] ?>">
                                                                    <input type="hidden" name="urutan_sub[<?= esc($refKeySub) ?>]" value="<?= (int)$sub['urutan'] ?>">
                                                                </td>
                                                                <td class="col-prev"><?= esc($oldPrevSub) ?></td>
                                                            <?php } else { ?>
                                                                <td class="col-nilai empty-control-cell"></td>
                                                                <td class="col-prev empty-control-cell"></td>
                                                            <?php } ?>
                                                        </tr>
                                                        <?php if ($adaSkalaSub) { ?>
                                                        <tr class="ket-dropdown-row" id="ket_panel_<?= md5($refKeySub) ?>" style="display:none;">
                                                            <td colspan="9">
                                                                <div class="ket-panel">
                                                                    <div class="ket-panel-head">
                                                                        <span>Keterangan: <?= esc($huruf) ?>. <?= esc($sub['nama_sub_parameter']) ?></span>
                                                                        <button type="button" class="ket-panel-close" data-target="ket_panel_<?= md5($refKeySub) ?>">×</button>
                                                                    </div>
                                                                    <textarea
                                                                        id="ket_<?= md5($refKeySub) ?>"
                                                                        name="keterangan[<?= esc($refKeySub) ?>]"
                                                                        class="form-control ket-box auto-ket-box"
                                                                        data-last-auto=""><?= esc($oldSub['keterangan'] ?? '') ?></textarea>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                        <?php $huruf++; ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form_assessment');
    const selects = document.querySelectorAll('.auto-ket-trigger');
    const textareas = document.querySelectorAll('.auto-ket-box');
    let saveTimer = null;
    let saving = false;
    let pending = false;

    document.querySelectorAll('.ket-toggle-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            var idPanel = this.getAttribute('data-target');
            var panel = document.getElementById(idPanel);
            if (!panel) return;
            var willShow = (panel.style.display === 'none' || panel.style.display === '');
            panel.style.display = willShow ? 'table-row' : 'none';
            this.classList.toggle('is-open', willShow);
        });
    });

    document.querySelectorAll('.ket-panel-close').forEach(function(btn){
        btn.addEventListener('click', function(){
            var idPanel = this.getAttribute('data-target');
            var panel = document.getElementById(idPanel);
            if (!panel) return;
            panel.style.display = 'none';
            document.querySelectorAll('.ket-toggle-btn[data-target="'+idPanel+'"]').forEach(function(toggleBtn){
                toggleBtn.classList.remove('is-open');
            });
        });
    });

    function updateKetBadge(textarea){
        var badge = document.querySelector('[data-ket-badge-for="'+textarea.id+'"]');
        if (!badge) return;
        var filled = (textarea.value || '').trim() !== '';
        badge.textContent = filled ? 'Terisi' : 'Kosong';
        badge.classList.toggle('is-filled', filled);
        badge.classList.toggle('is-empty', !filled);
    }

    function showAutoToast(msg, ok){ return; }

    function applyAutoKeterangan(selectEl, forceFill) {
        const targetId = selectEl.getAttribute('data-target');
        const textarea = document.getElementById(targetId);
        if (!textarea) return;

        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const newDesc = selectedOption ? (selectedOption.getAttribute('data-desc') || '') : '';
        const oldAuto = textarea.getAttribute('data-last-auto') || '';
        const currentVal = textarea.value || '';

        if (currentVal.trim() === '') {
            if (forceFill && newDesc !== '') {
                textarea.value = newDesc;
                textarea.setAttribute('data-last-auto', newDesc);
            } else {
                textarea.value = '';
                textarea.setAttribute('data-last-auto', '');
            }
            updateKetBadge(textarea);
            return;
        }

        if (oldAuto === '' && currentVal.trim() === newDesc.trim()) {
            textarea.setAttribute('data-last-auto', newDesc);
            updateKetBadge(textarea);
            return;
        }

        if (oldAuto !== '' && currentVal === oldAuto) {
            textarea.value = newDesc;
            textarea.setAttribute('data-last-auto', newDesc);
            updateKetBadge(textarea);
            return;
        }

        if (oldAuto !== '' && currentVal.indexOf(oldAuto) === 0) {
            const tambahanUser = currentVal.substring(oldAuto.length);
            textarea.value = newDesc + tambahanUser;
            textarea.setAttribute('data-last-auto', newDesc);
            updateKetBadge(textarea);
            return;
        }
    }

    function submitAutoSave(immediate) {
        if (!form) return;
        if (saveTimer) {
            clearTimeout(saveTimer);
            saveTimer = null;
        }

        const run = function(){
            if (saving) {
                pending = true;
                return;
            }
            saving = true;

            const fd = new FormData(form);
            fd.append('auto_save', '1');
            fd.append('ajax', '1');

            fetch(window.location.href, {
                method: 'POST',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                body: fd
            })
            .then(function(r){ return r.text(); })
            .then(function(text){
                let res;
                try {
                    res = JSON.parse(text);
                } catch (e) {
                    throw new Error('Response bukan JSON');
                }
                showAutoToast(res.message || (res.ok ? 'Assessment tersimpan otomatis.' : 'Gagal menyimpan'), !!res.ok);
            })
            .catch(function(){
                showAutoToast('Gagal menyimpan', false);
            })
            .finally(function(){
                saving = false;
                if (pending) {
                    pending = false;
                    submitAutoSave(true);
                }
            });
        };

        if (immediate) {
            run();
        } else {
            saveTimer = setTimeout(run, 600);
        }
    }

    selects.forEach(function (selectEl) {
        if (selectEl.value !== '') {
            applyAutoKeterangan(selectEl, false);
        }

        selectEl.addEventListener('change', function () {
            applyAutoKeterangan(this, true);
            submitAutoSave(true);
        });
    });

    textareas.forEach(function (textarea) {
        updateKetBadge(textarea);

        textarea.addEventListener('input', function () {
            updateKetBadge(this);
            submitAutoSave(false);
        });

        textarea.addEventListener('blur', function () {
            updateKetBadge(this);
            submitAutoSave(true);
        });
    });
});
</script>
