<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require dirname(__DIR__, 3).'/conn/conn.php';
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$displayModal = ($id <= 0);
$backUrl = (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '')
    ? $_SERVER['HTTP_REFERER']
    : 'index.php?page=dashboard';

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function q($conn, $sql, $label = 'SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        if (is_ajax_request()) {
            json_response(false, $label.' ERROR: '.mysqli_error($conn), ['sql' => $sql]);
        }
        die('<div style="padding:20px;background:#fff;color:#000;font-family:Arial">'.
            '<h3 style="color:red;margin-bottom:10px;">'.esc($label).' ERROR</h3>'.
            '<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>'.
            '<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>'.
            '</div>');
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
function column_exists($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}
function is_ajax_request(){
    return (
        (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || isset($_POST['ajax'])
    );
}
function json_response($ok, $message = '', $extra = []){
    if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['ok' => $ok ? true : false, 'message' => $message], $extra));
    exit;
}
function avg_list($arr){
    $nums = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $nums[] = (float)$v; }
    if (count($nums) === 0) return 0;
    return round(array_sum($nums) / count($nums), 2);
}
function max_list($arr){
    $nums = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $nums[] = (float)$v; }
    return count($nums) ? round(max($nums), 2) : 0;
}
function min_list($arr){
    $nums = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $nums[] = (float)$v; }
    return count($nums) ? round(min($nums), 2) : 0;
}
function concat_kets($arr){
    $out = [];
    foreach((array)$arr as $v){
        $v = trim((string)$v);
        if ($v === '') continue;
        $out[] = $v;
    }
    $out = array_values(array_unique($out));
    return implode("\n", $out);
}
function get_peringkat($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai <= 1.25) return 'Sangat Rendah';
    if ($nilai <= 2.25) return 'Rendah';
    if ($nilai <= 3.25) return 'Sedang';
    if ($nilai <= 4.25) return 'Tinggi';
    if ($nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}
function alphaIndex($i){
    $letters = range('a','z');
    return isset($letters[$i]) ? $letters[$i] : (string)($i + 1);
}
function risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)$riskRow['pembobotan'] === 1) return 'Pembobotan';
    return 'Perskalaan';
}
function display_num($v){ return number_format((float)$v, 2, '.', ''); }
function even_weights_op2($count){
    $result = [];
    $count = (int)$count;
    if ($count <= 0) return $result;
    $base = floor((100 / $count) * 10000) / 10000;
    $sum = 0;
    for($i=0;$i<$count;$i++){
        $result[$i] = $base;
        $sum += $base;
    }
    $result[$count - 1] = round(100 - ($sum - $base), 4);
    return $result;
}

function ensure_dynamic_note_table($conn){
    if (!table_exists($conn, 'inheren2_operasional_catatan_dinamis')) {
        q($conn, "CREATE TABLE inheren2_operasional_catatan_dinamis (
            id_catatan INT AUTO_INCREMENT PRIMARY KEY,
            id_profil_risiko INT NOT NULL,
            scope_type VARCHAR(20) NOT NULL COMMENT 'pilar/risiko',
            scope_ref_id INT NOT NULL DEFAULT 0,
            catatan LONGTEXT NULL,
            metode VARCHAR(20) NULL,
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_scope (id_profil_risiko, scope_type, scope_ref_id),
            KEY idx_profil (id_profil_risiko)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE DYNAMIC NOTE TABLE');
    }
}
function read_dynamic_notes($conn, $id_profil_risiko){
    ensure_dynamic_note_table($conn);
    $map = [];
    $q = q($conn, "SELECT * FROM inheren2_operasional_catatan_dinamis WHERE id_profil_risiko='".(int)$id_profil_risiko."'", 'READ DYNAMIC NOTES');
    while($r = mysqli_fetch_assoc($q)){
        $map[$r['scope_type'].'|'.(int)$r['scope_ref_id']] = $r;
    }
    return $map;
}
function upsert_dynamic_note($conn, $id_profil_risiko, $scope_type, $scope_ref_id, $catatan = null, $metode = null){
    ensure_dynamic_note_table($conn);
    $scope_type = mysqli_real_escape_string($conn, $scope_type);
    $scope_ref_id = (int)$scope_ref_id;
    $exists = fetch_one($conn, "SELECT id_catatan FROM inheren2_operasional_catatan_dinamis WHERE id_profil_risiko='".(int)$id_profil_risiko."' AND scope_type='$scope_type' AND scope_ref_id='$scope_ref_id' LIMIT 1", 'CHECK DYNAMIC NOTE');
    $sets = [];
    if ($catatan !== null) $sets[] = "catatan='".mysqli_real_escape_string($conn, (string)$catatan)."'";
    if ($metode !== null) $sets[] = "metode='".mysqli_real_escape_string($conn, (string)$metode)."'";
    if (empty($sets)) return;
    if ($exists) {
        q($conn, "UPDATE inheren2_operasional_catatan_dinamis SET ".implode(', ', $sets)." WHERE id_catatan='".(int)$exists['id_catatan']."'", 'UPDATE DYNAMIC NOTE');
    } else {
        q($conn, "INSERT INTO inheren2_operasional_catatan_dinamis (id_profil_risiko, scope_type, scope_ref_id, catatan, metode) VALUES ('".(int)$id_profil_risiko."', '$scope_type', '$scope_ref_id', ".($catatan!==null?"'".mysqli_real_escape_string($conn, (string)$catatan)."'":"NULL").", ".($metode!==null?"'".mysqli_real_escape_string($conn, (string)$metode)."'":"NULL").")", 'INSERT DYNAMIC NOTE');
    }
}
function get_assessment_detail_map($conn, $assessment_id){
    $map = [];
    if ((int)$assessment_id <= 0) return $map;
    $q = q($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment_id."'", 'READ DETAIL MAP');
    while($r = mysqli_fetch_assoc($q)){
        $map[$r['ref_tipe'].'|'.$r['ref_id']] = $r;
    }
    return $map;
}
function get_frame_perumusan_row($conn, $frame){
    if (!$frame || !table_exists($conn, 'frame_perumusan')) return null;

    $tahunRaw = (string)($frame['tahun'] ?? '');
    $tahun = mysqli_real_escape_string($conn, $tahunRaw);

    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';

    // FIX: data lama CABANG ada yang kolom triwulan kosong. Jadi CABANG harus menerima CABANG atau kosong.
    $whereKategori = ($kategori === 'CABANG')
        ? "UPPER(COALESCE(triwulan,'')) IN ('CABANG','')"
        : "UPPER(COALESCE(triwulan,'')) IN ('', 'KONSOLIDASI')";

    // 1. Kalau laporan punya id_frame_perumusan, pakai itu dulu. Jangan cari frame lain.
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $direct = fetch_one($conn, "
            SELECT *
            FROM frame_perumusan
            WHERE id_frame_perumusan = '".(int)$frame['id_frame_perumusan']."'
              AND tahun = '$tahun'
            LIMIT 1
        ", 'READ FRAME PERUMUSAN DIRECT FIRST NO TRIWULAN FILTER');
        if ($direct) return $direct;
    }

    // 2. Kalau laporan lama belum punya id_frame_perumusan, pakai frame aktif tahun+user+kategori.
    //    Jangan memilih berdasarkan pembobotan/perskalaan, karena itu membuat mode lama nyangkut.
    $userPerumusan = (int)($frame['user'] ?? 0);
    if ($kategori === 'CABANG') {
        $userCabang = fetch_one($conn, "
            SELECT id_user_profil_risiko
            FROM user_profil_risiko
            WHERE LOWER(tipe_user) LIKE '%kantor cabang%'
            ORDER BY id_user_profil_risiko ASC
            LIMIT 1
        ", 'READ USER CABANG FOR PERUMUSAN');
        if ($userCabang) $userPerumusan = (int)$userCabang['id_user_profil_risiko'];
    }

    $row = fetch_one($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE tahun = '$tahun'
          AND user_id = '$userPerumusan'
          AND $whereKategori
          AND is_aktif = 1
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ", 'READ FRAME PERUMUSAN ACTIVE EXACT FIX');
    if ($row) return $row;

    $row = fetch_one($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE tahun = '$tahun'
          AND user_id = '$userPerumusan'
          AND $whereKategori
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ", 'READ FRAME PERUMUSAN EXACT FIX');
    if ($row) return $row;

    return null;
}
function get_risk_perumusan($conn, $frame_perumusan_id, $nama_risiko, $jenis_risiko_id = 0){
    if ((int)$frame_perumusan_id <= 0 || !table_exists($conn, 'perumusan_inheren')) return null;

    $frameId = (int)$frame_perumusan_id;
    $riskName = mysqli_real_escape_string($conn, strtoupper(trim((string)$nama_risiko)));

    // FIX: jangan ORDER BY pembobotan DESC. Kalau user mengganti ke Perskalaan,
    // row yang sama harus terbaca apa adanya dari frame aktif/dipilih.
    $row = fetch_one($conn, "
        SELECT *
        FROM perumusan_inheren
        WHERE id_frame_perumusan = '$frameId'
          AND UPPER(TRIM(nama_risiko)) = '$riskName'
        ORDER BY id_perumusan_inheren DESC
        LIMIT 1
    ", 'READ PERUMUSAN INHEREN BY CURRENT FRAME');
    if ($row) return $row;

    $jenisId = (int)$jenis_risiko_id;
    if ($jenisId > 0) {
        $row = fetch_one($conn, "
            SELECT *
            FROM perumusan_inheren
            WHERE id_frame_perumusan = '$frameId'
              AND id_jenis_risiko = '$jenisId'
            ORDER BY id_perumusan_inheren DESC
            LIMIT 1
        ", 'READ PERUMUSAN INHEREN BY JENIS ID CURRENT FRAME');
        if ($row) return $row;
    }

    return null;
}

function get_force_operasional_by_setting_tahun($conn, $frame){
    // FIX: fungsi lama sengaja mencari semua frame tahun+kategori dan memprioritaskan pembobotan=1.
    // Itu penyebab ketika setting diganti ke Perskalaan halaman tetap nyangkut Pembobotan.
    // Sekarang tidak dipakai lagi; pembacaan hanya dari frame aktif/dipilih melalui get_frame_perumusan_row().
    return null;
}

function normalize_pilar_key($txt){
    $txt = strtoupper(trim((string)$txt));
    $txt = preg_replace('/\s+/', ' ', $txt);
    $txt = preg_replace('/^PILAR\s*[0-9]+\s*[:|\-]?\s*/', '', $txt);
    return $txt;
}
function get_pilar_perumusan_map($conn, $id_perumusan_inheren){
    $map = ['by_id' => [], 'by_name' => []];
    if ((int)$id_perumusan_inheren <= 0 || !table_exists($conn, 'perumusan_inheren_pilar')) return $map;
    $q = q($conn, "SELECT * FROM perumusan_inheren_pilar WHERE id_perumusan_inheren='".(int)$id_perumusan_inheren."'", 'READ PERUMUSAN PILAR MAP');
    while($r = mysqli_fetch_assoc($q)){
        $map['by_id'][(int)$r['id_pilar']] = $r;
        $map['by_name'][normalize_pilar_key($r['nama_pilar'] ?? '')] = $r;
    }
    return $map;
}
function find_pilar_perumusan($pilarPerumusanMap, $pilar_id, $nama_pilar){
    if (isset($pilarPerumusanMap['by_id'][(int)$pilar_id])) {
        return $pilarPerumusanMap['by_id'][(int)$pilar_id];
    }
    $key = normalize_pilar_key($nama_pilar);
    if (isset($pilarPerumusanMap['by_name'][$key])) {
        return $pilarPerumusanMap['by_name'][$key];
    }
    return null;
}
function merge_legacy_notes_if_any($conn, $id_profil_risiko, &$dynamicMap, $results){
    if (!table_exists($conn, 'keterangan_inheren2_operasional')) return;
    $legacy = fetch_one($conn, "SELECT * FROM keterangan_inheren2_operasional WHERE id_profil_risiko='".(int)$id_profil_risiko."' LIMIT 1", 'READ LEGACY NOTE');
    if (!$legacy) return;
    foreach($results as $r){
        $key = 'pilar|'.(int)$r['pilar_id'];
        if (!isset($dynamicMap[$key])) {
            $field = 'ket_pil'.(int)$r['idx'];
            $val = trim((string)($legacy[$field] ?? ''));
            if ($val !== '') {
                upsert_dynamic_note($conn, $id_profil_risiko, 'pilar', (int)$r['pilar_id'], $val, null);
                $dynamicMap[$key] = ['catatan' => $val, 'metode' => null];
            }
        }
    }
    if (!isset($dynamicMap['risiko|0'])) {
        $val = trim((string)($legacy['ket_inheren'] ?? ''));
        $met = trim((string)($legacy['metode_inheren'] ?? ''));
        if ($val !== '' || $met !== '') {
            upsert_dynamic_note($conn, $id_profil_risiko, 'risiko', 0, $val, $met !== '' ? $met : null);
            $dynamicMap['risiko|0'] = ['catatan' => $val, 'metode' => $met];
        }
    }
}

if ($displayModal) {
?>
<style>
.oai-idkosong-overlay{position:fixed;inset:0;background:rgba(0,0,0,.48);z-index:999999;display:flex;align-items:center;justify-content:center;padding:20px}
.oai-idkosong-modal{width:100%;max-width:700px;background:#fff;border-radius:8px;box-shadow:0 15px 40px rgba(0,0,0,.30);overflow:hidden}
.oai-idkosong-head{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid #e5e7eb;font-size:24px;font-weight:700;color:#374151}
.oai-idkosong-closex{border:0;background:transparent;font-size:30px;line-height:1;color:#6b7280;cursor:pointer;text-decoration:none}
.oai-idkosong-body{padding:26px 22px;text-align:center;font-size:24px;line-height:1.65;color:#4b5563;font-weight:700}
.oai-idkosong-foot{padding:14px 20px;border-top:1px solid #e5e7eb;text-align:right}
.oai-idkosong-btn-link{display:inline-block;border:0;background:#ff5c7c;color:#fff!important;padding:10px 22px;border-radius:4px;font-size:16px;cursor:pointer;text-decoration:none;pointer-events:auto}
</style>
<div class="oai-idkosong-overlay" id="oaiIdKosongOverlay">
    <div class="oai-idkosong-modal" role="dialog" aria-modal="true">
        <div class="oai-idkosong-head">
            <div>Notifikasi</div>
            <a href="<?= esc($backUrl) ?>" class="oai-idkosong-closex-link" id="oaiIdKosongCloseX">&times;</a>
        </div>
        <div class="oai-idkosong-body">Mohon untuk memilih laporan risiko di menu dashboard -> laporan profil risiko -> klik (aktif) terlebih dahulu.</div>
        <div class="oai-idkosong-foot"><a href="<?= esc($backUrl) ?>" class="oai-idkosong-btn-link" id="oaiIdKosongCloseBtn">Close</a></div>
    </div>
</div>
<script>
(function(){
    var overlay = document.getElementById('oaiIdKosongOverlay');
    var backUrl = <?= json_encode($backUrl) ?>;
    function goBackPage(){ window.location.href = backUrl; }
    if (overlay) {
        overlay.addEventListener('click', function(e){ if (e.target === overlay) goBackPage(); });
    }
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') goBackPage(); });
})();
</script>
<?php return; }

if (!table_exists($conn, 'assessment_inheren') || !table_exists($conn, 'assessment_inheren_detail')) {
    die('<div style="padding:20px;background:#fff;color:#000">Tabel assessment_inheren / assessment_inheren_detail belum dibuat.</div>');
}

$frame = fetch_one($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        c.cabang,
        u.tipe_user
    FROM frame_laporan_profil_risiko f
    LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
    LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
    LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
    WHERE f.id_profil_risiko = '$id'
    LIMIT 1
", 'FRAME');

if (!$frame) die('<div style="padding:20px;background:#fff;color:#000">Frame laporan tidak ditemukan.</div>');

$assessment = fetch_one($conn, "
    SELECT *
    FROM assessment_inheren
    WHERE id_profil_risiko = '$id'
      AND jenis_risiko = 'RISIKO OPERASIONAL'
    LIMIT 1
", 'READ ASSESSMENT');

if (!$assessment) {
    q($conn, "
        INSERT INTO assessment_inheren
        (id_profil_risiko, jenis_risiko, dibuat_by)
        VALUES
        ('$id', 'RISIKO OPERASIONAL', '".(int)($_SESSION['user_id'] ?? 0)."')
    ", 'CREATE ASSESSMENT');
    $assessment = fetch_one($conn, "
        SELECT *
        FROM assessment_inheren
        WHERE id_profil_risiko = '$id'
          AND jenis_risiko = 'RISIKO OPERASIONAL'
        LIMIT 1
    ", 'READ NEW ASSESSMENT');
}
$assessment_id = (int)$assessment['id_assessment_inheren'];
$detailExisting = get_assessment_detail_map($conn, $assessment_id);
$detailPembanding = [];

if (!empty($frame['data_pembanding'])) {
    $dp = (int)$frame['data_pembanding'];
    $assessmentPrev = fetch_one($conn, "
        SELECT *
        FROM assessment_inheren
        WHERE id_profil_risiko = '$dp'
          AND jenis_risiko = 'RISIKO OPERASIONAL'
        LIMIT 1
    ", 'READ PREV ASSESSMENT');
    if ($assessmentPrev) $detailPembanding = get_assessment_detail_map($conn, (int)$assessmentPrev['id_assessment_inheren']);
}

$pilihHeader = fetch_one($conn, "
    SELECT pp.*, pi.tahun
    FROM pr_pilih_parameter pp
    INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
    WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
      AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
    ORDER BY pp.id DESC
    LIMIT 1
", 'READ PILIH HEADER');

if (!$pilihHeader) {
    die('<div style="padding:20px;background:#fff;color:#000">Checklist parameter inheren untuk user <b>'.esc($frame['tipe_user']).'</b> tahun <b>'.esc($frame['tahun']).'</b> belum dibuat.</div>');
}

$id_pilih = (int)$pilihHeader['id'];
$periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];

$checkedParam = [];
$checkedSub = [];
$qChecklist = q($conn, "
    SELECT ref_tipe, ref_id
    FROM pr_pilih_parameter_detail
    WHERE pr_pilih_parameter_id = '$id_pilih'
", 'READ CHECKLIST');
while($ck = mysqli_fetch_assoc($qChecklist)){
    if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
    if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
}

$group = [];
$currentJenisRisikoId = 0;
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
    FROM pr_jenis_risiko jr
    INNER JOIN pr_pilar p
        ON p.jenis_risiko_id = jr.id
       AND p.pr_inheren_periode_id = '$periode_master_id'
    INNER JOIN pr_parameter pm
        ON pm.pilar_id = p.id
       AND pm.pr_inheren_periode_id = '$periode_master_id'
    LEFT JOIN pr_sub_parameter sp
        ON sp.parameter_id = pm.id
       AND sp.pr_inheren_periode_id = '$periode_master_id'
    WHERE jr.nama_risiko = 'RISIKO OPERASIONAL'
      AND jr.pr_inheren_periode_id = '$periode_master_id'
    ORDER BY p.urutan, pm.urutan, sp.urutan
", 'LOAD PARAMETER OPERASIONAL');

while($r = mysqli_fetch_assoc($qData)){
    if ($currentJenisRisikoId <= 0) $currentJenisRisikoId = (int)$r['jenis_id'];
    $pilar_id = (int)$r['pilar_id'];
    $parameter_id = (int)$r['parameter_id'];
    $sub_id = (int)$r['sub_parameter_id'];
    $showParameter = isset($checkedParam[$parameter_id]);
    $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
    if (!$showParameter && !$showSub) continue;

    if (!isset($group[$pilar_id])) {
        $group[$pilar_id] = [
            'pilar_id' => $pilar_id,
            'nama_pilar' => $r['nama_pilar'],
            'urutan' => (int)$r['pilar_urutan'],
            'parameters' => []
        ];
    }
    if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
        $group[$pilar_id]['parameters'][$parameter_id] = [
            'parameter_id' => $parameter_id,
            'nomor_parameter' => $r['nomor_parameter'],
            'nama_parameter' => $r['nama_parameter'],
            'urutan' => (int)$r['parameter_urutan'],
            'subs' => []
        ];
    }
    if ($showSub && $sub_id > 0) {
        $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = [
            'sub_parameter_id' => $sub_id,
            'nama_sub_parameter' => $r['nama_sub_parameter'],
            'urutan' => (int)$r['sub_urutan']
        ];
    }
}

$framePerumusan = get_frame_perumusan_row($conn, $frame);
$riskPerumusan = $framePerumusan ? get_risk_perumusan($conn, (int)$framePerumusan['id_frame_perumusan'], 'RISIKO OPERASIONAL', $currentJenisRisikoId) : null;

/* FORCE FINAL: untuk Profil Risiko Cabang/non-SKMR, paksa baca setting Operasional dari tahun+kategori. */
$forcedOperasionalSetting = get_force_operasional_by_setting_tahun($conn, $frame);
if ($forcedOperasionalSetting && (int)$forcedOperasionalSetting['pembobotan'] === 1) {
    $riskPerumusan = $forcedOperasionalSetting;
} elseif (!$riskPerumusan && $forcedOperasionalSetting) {
    $riskPerumusan = $forcedOperasionalSetting;
}

/* Jika mode risiko pembobotan tetapi detail pilar belum ada, buat otomatis dari pilar yang tampil. */
if ($riskPerumusan && (int)$riskPerumusan['pembobotan'] === 1 && table_exists($conn, 'perumusan_inheren_pilar')) {
    $cekDetailBobot = fetch_one($conn, "
        SELECT COUNT(*) AS jml
        FROM perumusan_inheren_pilar
        WHERE id_perumusan_inheren = '".(int)$riskPerumusan['id_perumusan_inheren']."'
    ", 'CEK DETAIL BOBOT OPERASIONAL');

    if ((int)($cekDetailBobot['jml'] ?? 0) <= 0 && count($group) > 0) {
        $weightsAuto = even_weights_op2(count($group));
        $idxAuto = 0;
        foreach($group as $gidPilar => $gpilar){
            $bobotAuto = isset($weightsAuto[$idxAuto]) ? (float)$weightsAuto[$idxAuto] : 0;
            q($conn, "
                INSERT INTO perumusan_inheren_pilar
                (id_perumusan_inheren, id_pilar, nama_pilar, perskalaan_metode, pembobotan)
                VALUES
                (
                    '".(int)$riskPerumusan['id_perumusan_inheren']."',
                    '".(int)$gidPilar."',
                    '".mysqli_real_escape_string($conn, $gpilar['nama_pilar'])."',
                    3,
                    '$bobotAuto'
                )
            ", 'AUTO INSERT BOBOT PILAR OPERASIONAL');
            $idxAuto++;
        }
    }
}

$pilarPerumusanMap = $riskPerumusan ? get_pilar_perumusan_map($conn, (int)$riskPerumusan['id_perumusan_inheren']) : [];

$results = [];
$rekapPilar = [];
$pilarIndex = 0;
$fallbackBobotPilar = even_weights_op2(count($group));
foreach($group as $pilar_id => $pilar){
    $pilarIndex++;
    $parameterRows = [];
    $parameterScores = [];
    $parameterPrevScores = [];

    foreach($pilar['parameters'] as $parameter){
        $paramKey = 'parameter|'.$parameter['parameter_id'];
        $paramCur = $detailExisting[$paramKey] ?? null;
        $paramPrev = $detailPembanding[$paramKey] ?? null;

        $subRows = [];
        $subScores = [];
        $subPrevScores = [];
        $subKets = [];
        $subIdx = 0;
        foreach($parameter['subs'] as $sub){
            $subIdx++;
            $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
            $subCur = $detailExisting[$subKey] ?? null;
            $subPrev = $detailPembanding[$subKey] ?? null;
            $nilaiSub = (float)($subCur['nilai'] ?? 0);
            $nilaiSubPrev = (float)($subPrev['nilai'] ?? 0);
            $ketSub = trim((string)($subCur['keterangan'] ?? ''));
            $subScores[] = $nilaiSub;
            $subPrevScores[] = $nilaiSubPrev;
            if ($ketSub !== '') $subKets[] = $ketSub;
            $subRows[] = ['letter' => alphaIndex($subIdx - 1), 'name' => $sub['nama_sub_parameter'], 'nilai' => $nilaiSub, 'nilai_prev' => $nilaiSubPrev];
        }

        if (count($subRows) > 0) {
            $nilaiParam = avg_list($subScores);
            $nilaiPrevParam = avg_list($subPrevScores);
            $ketParam = concat_kets($subKets);
        } else {
            $nilaiParam = (float)($paramCur['nilai'] ?? 0);
            $nilaiPrevParam = (float)($paramPrev['nilai'] ?? 0);
            $ketParam = trim((string)($paramCur['keterangan'] ?? ''));
        }

        $parameterScores[] = $nilaiParam;
        $parameterPrevScores[] = $nilaiPrevParam;
        $parameterRows[] = [
            'no' => $parameter['nomor_parameter'] !== '' ? $parameter['nomor_parameter'] : count($parameterRows)+1,
            'name' => $parameter['nama_parameter'],
            'nilai' => $nilaiParam,
            'nilai_prev' => $nilaiPrevParam,
            'keterangan' => $ketParam,
            'subs' => $subRows
        ];
    }

    $statMax = max_list($parameterScores);
    $statMin = min_list($parameterScores);
    $statAvg = avg_list($parameterScores);
    $prevMax = max_list($parameterPrevScores);
    $prevMin = min_list($parameterPrevScores);
    $prevAvg = avg_list($parameterPrevScores);

    $perumusanPilar = find_pilar_perumusan($pilarPerumusanMap, $pilar_id, $pilar['nama_pilar']);
    $riskMode = risk_mode_label($riskPerumusan);

    if ($riskMode === 'Pembobotan') {
        $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
        if ($bobot <= 0 && isset($fallbackBobotPilar[$pilarIndex-1])) {
            $bobot = (float)$fallbackBobotPilar[$pilarIndex-1];
        }
        $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        $nilaiPilarPrev = round($prevAvg * ($bobot / 100), 2);
        $modeInfo = ['type' => 'pembobotan', 'avg' => $statAvg, 'avg_prev' => $prevAvg, 'bobot' => $bobot];
    } else {
        $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
        if ($metodePilar === 1) {
            $nilaiPilar = $statMax; $nilaiPilarPrev = $prevMax; $metodeLabel = 'Tertinggi';
        } elseif ($metodePilar === 2) {
            $nilaiPilar = $statMin; $nilaiPilarPrev = $prevMin; $metodeLabel = 'Terendah';
        } else {
            $nilaiPilar = $statAvg; $nilaiPilarPrev = $prevAvg; $metodeLabel = 'Rata-rata';
        }
        $modeInfo = ['type' => 'perskalaan', 'max' => $statMax, 'min' => $statMin, 'avg' => $statAvg, 'max_prev' => $prevMax, 'min_prev' => $prevMin, 'avg_prev' => $prevAvg, 'metode_label' => $metodeLabel];
    }

    $rekapPilar[] = $nilaiPilar;
    $results[] = [
        'idx' => $pilarIndex,
        'pilar_id' => $pilar_id,
        'nama_pilar' => $pilar['nama_pilar'],
        'rows' => $parameterRows,
        'mode' => $modeInfo,
        'nilai_pilar' => $nilaiPilar,
        'nilai_pilar_prev' => $nilaiPilarPrev
    ];
}

$dynamicNoteMap = read_dynamic_notes($conn, $id);
merge_legacy_notes_if_any($conn, $id, $dynamicNoteMap, $results);

$overallMode = risk_mode_label($riskPerumusan);
$overallMax = max_list($rekapPilar);
$overallMin = min_list($rekapPilar);
$overallAvg = avg_list($rekapPilar);
$overallMethod = trim((string)($dynamicNoteMap['risiko|0']['metode'] ?? 'rata_rata'));
if (!in_array($overallMethod, ['tertinggi','terendah','rata_rata'])) $overallMethod = 'rata_rata';
if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
else {
    if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
    elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
    else $overallNilai = $overallAvg;
}
$overallPeringkat = get_peringkat($overallNilai);

if (is_ajax_request() && isset($_POST['action']) && $_POST['action'] === 'autosave_note') {
    $scopeType = trim((string)($_POST['scope_type'] ?? ''));
    $scopeRefId = (int)($_POST['scope_ref_id'] ?? 0);
    $catatan = (string)($_POST['catatan'] ?? '');
    $metode = isset($_POST['metode']) ? trim((string)$_POST['metode']) : null;
    if (!in_array($scopeType, ['pilar','risiko'])) json_response(false, 'Scope tidak valid');
    if ($scopeType === 'pilar' && $scopeRefId <= 0) json_response(false, 'Pilar tidak valid');
    if ($scopeType === 'risiko') {
        $scopeRefId = 0;
        if ($metode !== null && !in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    } else {
        $metode = null;
    }
    upsert_dynamic_note($conn, $id, $scopeType, $scopeRefId, $catatan, $metode);
    json_response(true, 'saved');
}

$directAction = basename(__FILE__).'?id='.(int)$id;
?>
<style>
.op2-shell .card{border-radius:12px;border:0;box-shadow:0 6px 20px rgba(0,0,0,.05)}
.op2-headbar{background:#6772f3;color:#fff;border-radius:12px 12px 0 0;padding:14px 16px;display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap}
.op2-pill{display:inline-block;background:rgba(255,255,255,.92);color:#0f172a;padding:8px 12px;border-radius:999px;font-size:12px;font-weight:600;margin-left:6px}
.tbl-op2{table-layout:fixed;width:100%}
.tbl-op2 thead th{background:#69b4e7;color:#000;text-align:center;vertical-align:middle;font-size:12px}
.tbl-op2 td,.tbl-op2 th{vertical-align:top;font-size:12px;border-color:#d9e0e7!important}
.tbl-op2 .row-pilar > td{background:#58d3dd!important;font-weight:700;color:#2f4858;padding:10px 12px}
.tbl-op2 .row-param > th,
.tbl-op2 .row-param > td{background:#efede8!important}
.tbl-op2 .row-summary > th,
.tbl-op2 .row-summary > td{background:#acdbfb!important}
.card-op2{border-radius:12px}
.ket-box-op2{width:100%;min-height:94px;resize:vertical;background:#fff}
.ket-small-op2{width:100%;min-height:80px;resize:vertical;background:#fff}
.input-mini-op2{min-width:80px;text-align:center}
.sub-col-op2{width:34px;text-align:center}
.center-op2{text-align:center}
.op2-save-indicator{font-size:12px;color:#64748b;font-style:italic;margin-top:8px;display:none}
.op2-save-indicator.show{display:inline-block}
.op2-param-name{font-weight:600;color:#5b6470}
.op2-form-head{margin-bottom:12px;color:#667085;font-size:12px;text-transform:uppercase;font-weight:700}
</style>

<div class="content-page">
<div class="content">
<div class="container-fluid op2-shell">
<div class="row"><div class="col-12"><div class="page-title-box"><h4 class="page-title">Risiko Operasional Inheren 2 [<?= esc($frame['cabang']) ?> Tahun <?= esc($frame['tahun']) ?> - <?= esc($frame['periode_laporan']) ?>]</h4></div></div></div>
<div class="row"><div class="col-12"><div class="card card-op2">
<div class="op2-headbar">
    <div><h4 class="page-title mb-0" style="color:#fff">Risiko Operasional Inheren 2</h4></div>
    <div>
        <span class="op2-pill">Checklist Aktif: <?= esc($frame['tipe_user']) ?></span>
        <span class="op2-pill">Tahun: <?= esc($frame['tahun']) ?></span>
    </div>
</div>
<div class="card-body">
<form action="<?= esc($directAction) ?>" method="POST" id="my_form">
<!-- DEBUG OP2: id_profil=<?= (int)$id ?> | frame_laporan_id_frame_perumusan=<?= esc($frame['id_frame_perumusan'] ?? '') ?> | framePerumusan=<?= esc($framePerumusan['id_frame_perumusan'] ?? '') ?> | riskPerumusan=<?= esc($riskPerumusan['id_perumusan_inheren'] ?? '') ?> | mode=<?= esc($overallMode) ?> | p=<?= esc($riskPerumusan['perskalaan'] ?? '') ?> | b=<?= esc($riskPerumusan['pembobotan'] ?? '') ?> -->
<div class="table-responsive">
<table class="table table-bordered table-centered mb-0 tbl-op2">
<colgroup>
    <col style="width:50px">
    <col style="width:42px">
    <col style="width:31%">
    <col style="width:10%">
    <col style="width:10%">
    <col style="width:26%">
    <col style="width:10%">
    <col style="width:11%">
</colgroup>
<thead class="table-d" bgcolor="#74c7ff">
<tr><th colspan="8"><h4><center><b>RISIKO OPERASIONAL INHEREN 2</b></center></h4></th></tr>
<tr>
<th width="50px" class="no-col-wide" style="white-space:nowrap;min-width:50px;"><center>NO</center></th>
<th class="text-center" width="340px" colspan="2">PARAMETER</th>
<th class="text-center" width="18%" colspan="2">PERINGKAT RISIKO</th>
<th class="text-center" width="28%">KETERANGAN</th>
<th class="text-center" width="18%" colspan="2">PERIODE SEBELUMNYA</th>
</tr>
</thead>
<tbody>
<?php foreach($results as $pilar){
    $dynPilarNote = $dynamicNoteMap['pilar|'.(int)$pilar['pilar_id']]['catatan'] ?? '';
?>
<tr class="row-pilar"><td colspan="8"><b>PILAR <?= (int)$pilar['idx'] ?> : <?= esc($pilar['nama_pilar']) ?></b></td></tr>
<?php foreach($pilar['rows'] as $param){ ?>
<tr class="row-param">
<th><center><?= esc($param['no']) ?></center></th>
<th scope="row" colspan="2"><div class="op2-param-name"><?= esc($param['name']) ?></div></th>
<td></td>
<td width="10%"><center>Nilai</center><input type="number" value="<?= esc(display_num($param['nilai'])) ?>" class="form-control input-mini-op2" readonly></td>
<td><textarea class="form-control ket-box-op2" readonly><?= esc($param['keterangan']) ?></textarea></td>
<td></td>
<td width="10%"><center>Nilai periode sebelumnya</center><input type="number" value="<?= esc(display_num($param['nilai_prev'])) ?>" class="form-control input-mini-op2" readonly></td>
</tr>
<?php foreach($param['subs'] as $sub){ ?>
<tr>
<th></th>
<th class="sub-col-op2"><?= esc($sub['letter']) ?>.</th>
<th><?= esc($sub['name']) ?></th>
<td class="center-op2"><?= esc(display_num($sub['nilai'])) ?></td>
<td colspan="2"></td>
<td class="center-op2"><?= esc(display_num($sub['nilai_prev'])) ?></td>
<td></td>
</tr>
<?php } ?>
<?php } ?>
<tr class="row-summary">
<th scope="row" colspan="4">Hasil Penilaian Pilar <?= (int)$pilar['idx'] ?> - <?= esc($pilar['nama_pilar']) ?></th>
<td>
<?php if ($pilar['mode']['type'] === 'pembobotan') { ?>
<center>Rata-rata Parameter</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['mode']['avg'])) ?>" readonly>
<center>Bobot (%)</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['mode']['bobot'])) ?>" readonly>
<center>Nilai Pilar</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['nilai_pilar'])) ?>" readonly>
<?php } else { ?>
<center>Tertinggi</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['mode']['max'])) ?>" readonly>
<center>Terendah</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['mode']['min'])) ?>" readonly>
<center>Rata-rata</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['mode']['avg'])) ?>" readonly>
<br><hr>
<center>Risiko ditetapkan (<?= esc($pilar['mode']['metode_label']) ?>)</center>
<input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['nilai_pilar'])) ?>" readonly>
<?php } ?>
</td>
<td>
    <textarea class="form-control ket-box-op2 autosave-note" data-scope-type="pilar" data-scope-ref-id="<?= (int)$pilar['pilar_id'] ?>"><?= esc($dynPilarNote) ?></textarea>
    <div class="op2-save-indicator">tersimpan...</div>
</td>
<td></td>
<td></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

<br><hr>

<div class="table-responsive">
<table class="table table-bordered table-centered mb-0 tbl-op2">
<thead class="table-d" bgcolor="#74c7ff"><tr style="color:#050505;"><th colspan="9"><center>REKAP PENILAIAN INHEREN OPERASIONAL</center></th></tr></thead>
<tbody>
<?php foreach($results as $pilar){ ?>
<tr class="row-summary">
<th scope="row" colspan="8">Hasil Penilaian Pilar <?= (int)$pilar['idx'] ?> - <?= esc($pilar['nama_pilar']) ?></th>
<td width="15%"><center>Tingkat risiko</center><input type="number" class="form-control input-mini-op2" value="<?= esc(display_num($pilar['nilai_pilar'])) ?>" readonly></td>
</tr>
<?php } ?>
</tbody>
<tbody>
<?php if ($overallMode === 'Pembobotan') { ?>
<tr class="table" bgcolor="#74c7ff">
<th scope="row" colspan="8">Hasil Penilaian Inheren</th>
<td width="15%">
<center>Metode Risiko</center><input type="text" class="form-control input-mini-op2" value="Pembobotan" readonly>
<center class="mt-2">Total Nilai Bobot</center><input type="number" id="overall_tingkat_risiko" class="form-control input-mini-op2" value="<?= esc(display_num($overallNilai)) ?>" readonly>
<center>Peringkat</center><input type="text" id="overall_peringkat" class="form-control input-mini-op2" value="<?= esc($overallPeringkat) ?>" readonly>
</td>
</tr>
<?php } else { ?>
<tr class="table" bgcolor="#74c7ff">
<th scope="row" colspan="5">Hasil Penilaian Inheren</th>
<td width="8%"><center>Tertinggi</center><input type="number" id="overall_tertinggi" class="form-control input-mini-op2" value="<?= esc(display_num($overallMax)) ?>" readonly></td>
<td width="8%"><center>Terendah</center><input type="number" id="overall_terendah" class="form-control input-mini-op2" value="<?= esc(display_num($overallMin)) ?>" readonly></td>
<td width="8%"><center>Rata-rata</center><input type="number" id="overall_rata_rata" class="form-control input-mini-op2" value="<?= esc(display_num($overallAvg)) ?>" readonly></td>
<td width="15%">
<center>Metode Risiko</center>
<select id="overall_metode_risiko" class="form-control autosave-method" data-scope-type="risiko" data-scope-ref-id="0">
<option value="tertinggi" <?= $overallMethod === 'tertinggi' ? 'selected' : '' ?>>Tertinggi</option>
<option value="terendah" <?= $overallMethod === 'terendah' ? 'selected' : '' ?>>Terendah</option>
<option value="rata_rata" <?= $overallMethod === 'rata_rata' ? 'selected' : '' ?>>Rata-rata</option>
</select>
<center class="mt-2">Tingkat risiko</center><input type="number" id="overall_tingkat_risiko" class="form-control input-mini-op2" value="<?= esc(display_num($overallNilai)) ?>" readonly>
<center>Peringkat</center><input type="text" id="overall_peringkat" class="form-control input-mini-op2" value="<?= esc($overallPeringkat) ?>" readonly>
</td>
</tr>
<?php } ?>
<tr bgcolor="#dfe1ff"><th scope="row" colspan="9">Uraian Untuk Risiko Inheren Operasional</th></tr>
<tr bgcolor="#dfe1ff"><td colspan="9">
    <textarea class="form-control ket-small-op2 autosave-note" data-scope-type="risiko" data-scope-ref-id="0"><?= esc($dynamicNoteMap['risiko|0']['catatan'] ?? '') ?></textarea>
    <div class="op2-save-indicator">tersimpan...</div>
</td></tr>
</tbody>
</table>
</div>
</form>
</div></div></div></div>
</div></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('my_form');
    if (!form) return;

    const endpoint = window.location.href;
    const overallMode = <?= json_encode($overallMode) ?>;
    const overallMax = parseFloat(<?= json_encode(display_num($overallMax)) ?>) || 0;
    const overallMin = parseFloat(<?= json_encode(display_num($overallMin)) ?>) || 0;
    const overallAvg = parseFloat(<?= json_encode(display_num($overallAvg)) ?>) || 0;
    const methodSelect = document.getElementById('overall_metode_risiko');
    const overallRiskInput = document.getElementById('overall_tingkat_risiko');
    const overallRankInput = document.getElementById('overall_peringkat');
    const riskNoteEl = document.querySelector('.autosave-note[data-scope-type="risiko"][data-scope-ref-id="0"]');
    const noteInputs = document.querySelectorAll('.autosave-note');
    let saveTimer = null;
    let saving = false;
    let pending = false;
    let lastPayload = null;

    function getPeringkat(nilai){
        nilai = parseFloat(nilai || 0);
        if (nilai < 1.00) return '';
        if (nilai <= 1.25) return 'Sangat Rendah';
        if (nilai <= 2.25) return 'Rendah';
        if (nilai <= 3.25) return 'Sedang';
        if (nilai <= 4.25) return 'Tinggi';
        if (nilai <= 5.00) return 'Sangat Tinggi';
        return '';
    }

    function updateOverallDisplay(){
        if (overallMode === 'Pembobotan') return;
        if (!methodSelect || !overallRiskInput || !overallRankInput) return;
        let val = overallAvg;
        if (methodSelect.value === 'tertinggi') val = overallMax;
        else if (methodSelect.value === 'terendah') val = overallMin;
        overallRiskInput.value = val.toFixed(2);
        overallRankInput.value = getPeringkat(val);
    }

    function showSavedHint(el){
        if (!el) return;
        let hint = null;
        const parent = el.parentElement;
        if (parent) hint = parent.querySelector('.op2-save-indicator');
        if (!hint && parent && parent.parentElement) hint = parent.parentElement.querySelector('.op2-save-indicator');
        if (!hint) return;
        hint.classList.add('show');
        clearTimeout(hint._t);
        hint._t = setTimeout(function(){
            hint.classList.remove('show');
        }, 1200);
    }

    function buildPayload(sourceEl){
        const payload = {
            scope_type: sourceEl.getAttribute('data-scope-type') || '',
            scope_ref_id: sourceEl.getAttribute('data-scope-ref-id') || '0',
            catatan: sourceEl.value || ''
        };
        if (payload.scope_type === 'risiko' && methodSelect) {
            payload.metode = methodSelect.value || 'rata_rata';
        }
        return payload;
    }

    function parseJsonSafe(text){
        try { return JSON.parse(text); } catch (e) { return null; }
    }

    function submitPayload(payload, sourceEl){
        if (saveTimer) {
            clearTimeout(saveTimer);
            saveTimer = null;
        }
        lastPayload = {payload: payload, sourceEl: sourceEl};

        const run = function(){
            if (saving) {
                pending = true;
                return;
            }
            saving = true;

            const fd = new FormData();
            fd.append('ajax', '1');
            fd.append('action', 'autosave_note');
            Object.keys(payload).forEach(function(k){
                fd.append(k, payload[k]);
            });

            fetch(endpoint, {
                method: 'POST',
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                body: fd,
                credentials: 'same-origin'
            })
            .then(function(r){ return r.text(); })
            .then(function(text){
                const res = parseJsonSafe(text);
                if (res && res.ok) {
                    showSavedHint(sourceEl);
                }
            })
            .catch(function(){})
            .finally(function(){
                saving = false;
                if (pending && lastPayload) {
                    pending = false;
                    const retry = lastPayload;
                    lastPayload = null;
                    submitPayload(retry.payload, retry.sourceEl);
                }
            });
        };

        run();
    }

    function schedulePayload(payload, sourceEl, delay){
        if (saveTimer) clearTimeout(saveTimer);
        lastPayload = {payload: payload, sourceEl: sourceEl};
        saveTimer = setTimeout(function(){
            submitPayload(payload, sourceEl);
        }, delay || 700);
    }

    noteInputs.forEach(function(el){
        el.addEventListener('input', function(){
            schedulePayload(buildPayload(el), el, 700);
        });
        el.addEventListener('change', function(){
            submitPayload(buildPayload(el), el);
        });
        el.addEventListener('blur', function(){
            submitPayload(buildPayload(el), el);
        });
    });

    if (methodSelect) {
        methodSelect.addEventListener('change', function(){
            updateOverallDisplay();
            const source = riskNoteEl || methodSelect;
            const payload = {
                scope_type: 'risiko',
                scope_ref_id: '0',
                metode: methodSelect.value || 'rata_rata',
                catatan: riskNoteEl ? riskNoteEl.value : ''
            };
            submitPayload(payload, source);
        });
    }

    window.addEventListener('beforeunload', function(){
        if (lastPayload && navigator.sendBeacon) {
            const fd = new FormData();
            fd.append('ajax', '1');
            fd.append('action', 'autosave_note');
            Object.keys(lastPayload.payload).forEach(function(k){
                fd.append(k, lastPayload.payload[k]);
            });
            navigator.sendBeacon(endpoint, fd);
        }
    });

    updateOverallDisplay();
});
</script>
