<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require dirname(__DIR__, 2).'/conn/conn.php';

function esc($str){ return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
function postv($key,$default=''){ return isset($_POST[$key]) ? $_POST[$key] : $default; }
function getv($key,$default=''){ return isset($_GET[$key]) ? $_GET[$key] : $default; }

function is_ajax_request(){
    return (
        (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || isset($_POST['ajax'])
    );
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
            '<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>' .
            '<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>' .
            '</div>'
        );
    }
    return $res;
}

function fetch_one($conn,$sql,$label='SQL'){
    $res = q($conn,$sql,$label);
    return mysqli_fetch_assoc($res);
}

function notif($title, $message, $type = 'success')
{
    $bg = ($type === 'error') ? 'bg-danger' : (($type === 'warning') ? 'bg-warning' : 'bg-success');
    echo "<script>
        if (typeof $.NotificationApp !== 'undefined') {
            $.NotificationApp.send(" . json_encode($title) . ", " . json_encode($message) . ", 'top-right', '" . $bg . "', 'fa fa-bell');
        } else {
            console.log(" . json_encode($title . ' - ' . $message) . ");
        }
    </script>";
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
function redirect_to($url){
    echo "<script>window.location=".json_encode($url).";</script>";
    exit;
}
function build_url($params = []){
    $base = 'index.php?page=pilih_perumusan';
    if (!empty($params)) {
        $base .= '&' . http_build_query($params);
    }
    return $base;
}
function is_divisi_user_name($txt){
    return strpos(strtolower(trim((string)$txt)), 'divisi') !== false;
}
function is_cabang_user_name($txt){
    return strpos(strtolower(trim((string)$txt)), 'kantor cabang') !== false;
}
function even_weights($count){
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
function normalize_kategori($txt){
    $txt = strtoupper(trim((string)$txt));
    return ($txt === 'CABANG') ? 'CABANG' : 'KONSOLIDASI';
}
function kategori_label($kategori){
    return normalize_kategori($kategori) === 'CABANG' ? 'Cabang' : 'Konsolidasi';
}
function frame_kategori($row){
    $triwulan = isset($row['triwulan']) ? trim((string)$row['triwulan']) : '';
    if ($triwulan !== '') return normalize_kategori($triwulan);
    $tipe = isset($row['tipe_user']) ? $row['tipe_user'] : '';
    return is_cabang_user_name($tipe) ? 'CABANG' : 'KONSOLIDASI';
}

$DIVISI_OPTIONS = [
    132 => 'Divisi Pemasaran',
    133 => 'Divisi Operasional',
    134 => 'Divisi SDM',
    135 => 'Satker Kepatuhan',
    136 => 'Sekretaris Perusahaan',
    137 => 'Divisi Litbang',
    140 => 'Divisi Penyelesaian Kredit',
    143 => 'SKAI'
];

function get_divisi_label($id, $options){
    $id = (int)$id;
    return ($id > 0 && isset($options[$id])) ? $options[$id] : '-';
}

function set_modal_flash($title, $message, $type = 'warning'){
    $_SESSION['modal_flash'] = [
        'title' => $title,
        'message' => $message,
        'type' => $type
    ];
}

function get_modal_flash(){
    $data = isset($_SESSION['modal_flash']) ? $_SESSION['modal_flash'] : null;
    if (isset($_SESSION['modal_flash'])) unset($_SESSION['modal_flash']);
    return $data;
}

function modal_class_by_type($type){
    if ($type === 'error') return 'danger';
    if ($type === 'success') return 'success';
    return 'warning';
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

function ensure_perumusan_schema($conn){
    if (!table_exists($conn, 'frame_perumusan')) {
        q($conn, "CREATE TABLE frame_perumusan (
            id_frame_perumusan INT AUTO_INCREMENT PRIMARY KEY,
            tahun VARCHAR(10) NOT NULL,
            triwulan VARCHAR(20) NULL,
            user_id INT NOT NULL,
            id_divisi_tetapan INT NULL,
            metode_perumusan VARCHAR(20) NOT NULL DEFAULT 'perskalaan',
            is_aktif TINYINT(1) DEFAULT 0,
            dibuat_by INT DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE frame_perumusan');
    } else {
        if (!column_exists($conn, 'frame_perumusan', 'triwulan')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN triwulan VARCHAR(20) NULL AFTER tahun", 'ALTER frame_perumusan triwulan');
        }
        if (!column_exists($conn, 'frame_perumusan', 'id_divisi_tetapan')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN id_divisi_tetapan INT NULL AFTER user_id", 'ALTER frame_perumusan id_divisi_tetapan');
        }
        if (!column_exists($conn, 'frame_perumusan', 'metode_perumusan')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN metode_perumusan VARCHAR(20) NOT NULL DEFAULT 'perskalaan' AFTER id_divisi_tetapan", 'ALTER frame_perumusan metode_perumusan');
        }
        if (!column_exists($conn, 'frame_perumusan', 'is_aktif')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN is_aktif TINYINT(1) DEFAULT 0 AFTER metode_perumusan", 'ALTER frame_perumusan is_aktif');
        }
        if (!column_exists($conn, 'frame_perumusan', 'dibuat_by')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN dibuat_by INT DEFAULT 0", 'ALTER frame_perumusan dibuat_by');
        }
        if (!column_exists($conn, 'frame_perumusan', 'dibuat_at')) {
            q($conn, "ALTER TABLE frame_perumusan ADD COLUMN dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP", 'ALTER frame_perumusan dibuat_at');
        }
    }

    if (!table_exists($conn, 'perumusan_inheren')) {
        q($conn, "CREATE TABLE perumusan_inheren (
            id_perumusan_inheren INT AUTO_INCREMENT PRIMARY KEY,
            id_frame_perumusan INT NOT NULL,
            id_jenis_risiko INT NOT NULL,
            nama_risiko VARCHAR(150) NOT NULL,
            perskalaan TINYINT(1) DEFAULT 0,
            pembobotan TINYINT(1) DEFAULT 0,
            dibuat_by INT DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_frame_risiko (id_frame_perumusan, id_jenis_risiko)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE perumusan_inheren');
    }

    if (!table_exists($conn, 'perumusan_kpmr')) {
        q($conn, "CREATE TABLE perumusan_kpmr (
            id_perumusan_kpmr INT AUTO_INCREMENT PRIMARY KEY,
            id_frame_perumusan INT NOT NULL,
            id_jenis_risiko INT NOT NULL,
            nama_risiko VARCHAR(150) NOT NULL,
            perskalaan TINYINT(1) DEFAULT 0,
            pembobotan TINYINT(1) DEFAULT 0,
            dibuat_by INT DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_frame_risiko (id_frame_perumusan, id_jenis_risiko)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE perumusan_kpmr');
    }

    if (!table_exists($conn, 'perumusan_inheren_pilar')) {
        q($conn, "CREATE TABLE perumusan_inheren_pilar (
            id_detail INT AUTO_INCREMENT PRIMARY KEY,
            id_perumusan_inheren INT NOT NULL,
            id_pilar INT NOT NULL,
            nama_pilar VARCHAR(255) NOT NULL,
            perskalaan_metode TINYINT NULL,
            pembobotan DECIMAL(10,4) DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_perumusan_pilar (id_perumusan_inheren, id_pilar)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE perumusan_inheren_pilar');
    }

    if (!table_exists($conn, 'perumusan_kpmr_pilar')) {
        q($conn, "CREATE TABLE perumusan_kpmr_pilar (
            id_detail INT AUTO_INCREMENT PRIMARY KEY,
            id_perumusan_kpmr INT NOT NULL,
            id_pilar INT NOT NULL,
            nama_pilar VARCHAR(255) NOT NULL,
            perskalaan_metode TINYINT NULL,
            pembobotan DECIMAL(10,4) DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_perumusan_pilar (id_perumusan_kpmr, id_pilar)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE perumusan_kpmr_pilar');
    }
}

function get_user_row($conn, $user_id){
    return fetch_one($conn, "SELECT * FROM user_profil_risiko WHERE id_user_profil_risiko='".(int)$user_id."' LIMIT 1", 'GET user');
}

function get_cabang_user_row($conn){
    return fetch_one($conn, "
        SELECT *
        FROM user_profil_risiko
        WHERE LOWER(tipe_user) LIKE '%kantor cabang%'
        ORDER BY id_user_profil_risiko ASC
        LIMIT 1
    ", 'GET user kantor cabang');
}

function get_pr_setting_header($conn, $tahun, $user_id){
    return fetch_one($conn, "
        SELECT pp.*, pi.tahun, pi.jenis_parameter
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, $tahun)."'
          AND pp.id_user_profil_risiko = '".(int)$user_id."'
        ORDER BY pp.id DESC
        LIMIT 1
    ", 'GET PR setting header');
}
function get_kpmr_setting_header($conn, $tahun, $user_id){
    return fetch_one($conn, "
        SELECT kp.*, kper.tahun
        FROM kpmr_pilih_parameter kp
        INNER JOIN kpmr_periode kper ON kp.kpmr_periode_id = kper.id
        WHERE kper.tahun = '".mysqli_real_escape_string($conn, $tahun)."'
          AND kp.id_user_profil_risiko = '".(int)$user_id."'
        ORDER BY kp.id DESC
        LIMIT 1
    ", 'GET KPMR setting header');
}

function get_selected_risiko_inheren($conn, $pr_pilih_id){
    $rows = [];
    $map = [];

    $header = fetch_one($conn, "
        SELECT pp.*, pi.tahun, pi.jenis_parameter
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pp.id = '".(int)$pr_pilih_id."'
        LIMIT 1
    ", 'GET header risiko inheren');

    if (!$header) return $rows;

    $periodeId = (int)$header['pr_inheren_periode_id'];

    $res = q($conn, "
        SELECT DISTINCT jr.id AS id, jr.nama_risiko, jr.urutan
        FROM pr_pilih_parameter_detail d
        LEFT JOIN pr_parameter pm_param
            ON d.ref_tipe='parameter' AND d.ref_id = pm_param.id
        LEFT JOIN pr_sub_parameter sp
            ON d.ref_tipe='sub_parameter' AND d.ref_id = sp.id
        LEFT JOIN pr_parameter pm_sub
            ON sp.parameter_id = pm_sub.id
        INNER JOIN pr_pilar p
            ON p.id = COALESCE(pm_param.pilar_id, pm_sub.pilar_id)
           AND p.pr_inheren_periode_id = '$periodeId'
        INNER JOIN pr_jenis_risiko jr
            ON jr.id = p.jenis_risiko_id
           AND jr.pr_inheren_periode_id = '$periodeId'
        WHERE d.pr_pilih_parameter_id = '".(int)$pr_pilih_id."'
        ORDER BY jr.urutan, jr.id
    ", 'GET risiko inheren selected');
    while($r = mysqli_fetch_assoc($res)){
        $map[(int)$r['id']] = $r;
    }

    // FIX: risiko tetap muncul meskipun detail checklist belum lengkap / ada data detail yang hilang.
    $resAll = q($conn, "
        SELECT DISTINCT jr.id AS id, jr.nama_risiko, jr.urutan
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p
            ON p.jenis_risiko_id = jr.id
           AND p.pr_inheren_periode_id = '$periodeId'
        INNER JOIN pr_parameter pm
            ON pm.pilar_id = p.id
           AND pm.pr_inheren_periode_id = '$periodeId'
        WHERE jr.pr_inheren_periode_id = '$periodeId'
          AND COALESCE(jr.aktif, 'Y') <> 'N'
        ORDER BY jr.urutan, jr.id
    ", 'GET risiko inheren master fallback');
    while($r = mysqli_fetch_assoc($resAll)){
        if (!isset($map[(int)$r['id']])) $map[(int)$r['id']] = $r;
    }

    $rows = array_values($map);
    usort($rows, function($a, $b){
        $ua = isset($a['urutan']) ? (int)$a['urutan'] : 9999;
        $ub = isset($b['urutan']) ? (int)$b['urutan'] : 9999;
        if ($ua === $ub) return ((int)$a['id'] <=> (int)$b['id']);
        return $ua <=> $ub;
    });
    return $rows;
}

function get_selected_risiko_kpmr($conn, $kpmr_pilih_id){
    $rows = [];
    $map = [];

    $header = fetch_one($conn, "
        SELECT kp.*, kper.tahun
        FROM kpmr_pilih_parameter kp
        INNER JOIN kpmr_periode kper ON kp.kpmr_periode_id = kper.id
        WHERE kp.id = '".(int)$kpmr_pilih_id."'
        LIMIT 1
    ", 'GET header risiko kpmr');

    if (!$header) return $rows;

    $periodeId = (int)$header['kpmr_periode_id'];

    $res = q($conn, "
        SELECT DISTINCT jr.id AS id, jr.nama_risiko, jr.urutan
        FROM kpmr_pilih_parameter_detail d
        LEFT JOIN kpmr_parameter pm_param
            ON d.ref_tipe='parameter' AND d.ref_id = pm_param.id
        LEFT JOIN kpmr_sub_parameter sp
            ON d.ref_tipe='sub_parameter' AND d.ref_id = sp.id
        LEFT JOIN kpmr_parameter pm_sub
            ON sp.parameter_id = pm_sub.id
        INNER JOIN kpmr_pilar p
            ON p.id = COALESCE(pm_param.pilar_id, pm_sub.pilar_id)
           AND p.kpmr_periode_id = '$periodeId'
        INNER JOIN kpmr_jenis_risiko jr
            ON jr.id = p.jenis_risiko_id
           AND jr.kpmr_periode_id = '$periodeId'
        WHERE d.kpmr_pilih_parameter_id = '".(int)$kpmr_pilih_id."'
        ORDER BY jr.urutan, jr.id
    ", 'GET risiko kpmr selected');
    while($r = mysqli_fetch_assoc($res)){
        $map[(int)$r['id']] = $r;
    }

    $resAll = q($conn, "
        SELECT DISTINCT jr.id AS id, jr.nama_risiko, jr.urutan
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p
            ON p.jenis_risiko_id = jr.id
           AND p.kpmr_periode_id = '$periodeId'
        INNER JOIN kpmr_parameter pm
            ON pm.pilar_id = p.id
           AND pm.kpmr_periode_id = '$periodeId'
        WHERE jr.kpmr_periode_id = '$periodeId'
          AND COALESCE(jr.aktif, 'Y') <> 'N'
        ORDER BY jr.urutan, jr.id
    ", 'GET risiko kpmr master fallback');
    while($r = mysqli_fetch_assoc($resAll)){
        if (!isset($map[(int)$r['id']])) $map[(int)$r['id']] = $r;
    }

    $rows = array_values($map);
    usort($rows, function($a, $b){
        $ua = isset($a['urutan']) ? (int)$a['urutan'] : 9999;
        $ub = isset($b['urutan']) ? (int)$b['urutan'] : 9999;
        if ($ua === $ub) return ((int)$a['id'] <=> (int)$b['id']);
        return $ua <=> $ub;
    });
    return $rows;
}

function get_selected_pilar_inheren($conn, $pr_pilih_id, $jenis_id){
    $rows = [];
    $header = fetch_one($conn, "
        SELECT pp.*, pi.tahun, pi.jenis_parameter
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pp.id = '".(int)$pr_pilih_id."'
        LIMIT 1
    ", 'GET header pilar inheren');
    if (!$header) return $rows;
    $periodeId = (int)$header['pr_inheren_periode_id'];

    $res = q($conn, "
        SELECT DISTINCT p.id AS id_pilar, p.nama_pilar, p.urutan
        FROM pr_pilih_parameter_detail d
        LEFT JOIN pr_parameter pm_param
            ON d.ref_tipe='parameter' AND d.ref_id = pm_param.id
        LEFT JOIN pr_sub_parameter sp
            ON d.ref_tipe='sub_parameter' AND d.ref_id = sp.id
        LEFT JOIN pr_parameter pm_sub
            ON sp.parameter_id = pm_sub.id
        INNER JOIN pr_pilar p
            ON p.id = COALESCE(pm_param.pilar_id, pm_sub.pilar_id)
           AND p.pr_inheren_periode_id = '$periodeId'
        WHERE d.pr_pilih_parameter_id = '".(int)$pr_pilih_id."'
          AND p.jenis_risiko_id = '".(int)$jenis_id."'
        ORDER BY p.urutan, p.id
    ", 'GET pilar inheren selected');
    while($r = mysqli_fetch_assoc($res)) $rows[] = $r;

    if (empty($rows)) {
        $resAll = q($conn, "
            SELECT DISTINCT p.id AS id_pilar, p.nama_pilar, p.urutan
            FROM pr_pilar p
            INNER JOIN pr_parameter pm
                ON pm.pilar_id = p.id
               AND pm.pr_inheren_periode_id = '$periodeId'
            WHERE p.pr_inheren_periode_id = '$periodeId'
              AND p.jenis_risiko_id = '".(int)$jenis_id."'
              AND COALESCE(p.aktif, 'Y') <> 'N'
            ORDER BY p.urutan, p.id
        ", 'GET pilar inheren master fallback');
        while($r = mysqli_fetch_assoc($resAll)) $rows[] = $r;
    }
    return $rows;
}

function get_selected_pilar_kpmr($conn, $kpmr_pilih_id, $jenis_id){
    $rows = [];
    $header = fetch_one($conn, "
        SELECT kp.*, kper.tahun
        FROM kpmr_pilih_parameter kp
        INNER JOIN kpmr_periode kper ON kp.kpmr_periode_id = kper.id
        WHERE kp.id = '".(int)$kpmr_pilih_id."'
        LIMIT 1
    ", 'GET header pilar kpmr');
    if (!$header) return $rows;
    $periodeId = (int)$header['kpmr_periode_id'];

    $res = q($conn, "
        SELECT DISTINCT p.id AS id_pilar, p.nama_pilar, p.urutan
        FROM kpmr_pilih_parameter_detail d
        LEFT JOIN kpmr_parameter pm_param
            ON d.ref_tipe='parameter' AND d.ref_id = pm_param.id
        LEFT JOIN kpmr_sub_parameter sp
            ON d.ref_tipe='sub_parameter' AND d.ref_id = sp.id
        LEFT JOIN kpmr_parameter pm_sub
            ON sp.parameter_id = pm_sub.id
        INNER JOIN kpmr_pilar p
            ON p.id = COALESCE(pm_param.pilar_id, pm_sub.pilar_id)
           AND p.kpmr_periode_id = '$periodeId'
        WHERE d.kpmr_pilih_parameter_id = '".(int)$kpmr_pilih_id."'
          AND p.jenis_risiko_id = '".(int)$jenis_id."'
        ORDER BY p.urutan, p.id
    ", 'GET pilar kpmr selected');
    while($r = mysqli_fetch_assoc($res)) $rows[] = $r;

    if (empty($rows)) {
        $resAll = q($conn, "
            SELECT DISTINCT p.id AS id_pilar, p.nama_pilar, p.urutan
            FROM kpmr_pilar p
            INNER JOIN kpmr_parameter pm
                ON pm.pilar_id = p.id
               AND pm.kpmr_periode_id = '$periodeId'
            WHERE p.kpmr_periode_id = '$periodeId'
              AND p.jenis_risiko_id = '".(int)$jenis_id."'
              AND COALESCE(p.aktif, 'Y') <> 'N'
            ORDER BY p.urutan, p.id
        ", 'GET pilar kpmr master fallback');
        while($r = mysqli_fetch_assoc($resAll)) $rows[] = $r;
    }
    return $rows;
}


function get_risk_id_by_name($conn, $riskName, $defaultId){
    $riskNameEsc = mysqli_real_escape_string($conn, strtoupper(trim((string)$riskName)));
    $row = fetch_one($conn, "
        SELECT id
        FROM pr_jenis_risiko
        WHERE UPPER(nama_risiko) = '$riskNameEsc'
        ORDER BY id ASC
        LIMIT 1
    ", 'GET risk id by name');
    return $row ? (int)$row['id'] : (int)$defaultId;
}

function get_hardcoded_inheren_risks($conn){
    return [
        'kredit' => [
            'id' => get_risk_id_by_name($conn, 'RISIKO KREDIT', 1),
            'nama_risiko' => 'RISIKO KREDIT',
            'pilars' => [
                1 => 'Pilar 1 | Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit',
                2 => 'Pilar 2 | Kualitas Aset',
                3 => 'Pilar 3 | Strategi Penyediaan Dana',
                4 => 'Pilar 4 | Faktor Eksternal',
                5 => 'Pilar 5 | Lainnya',
            ]
        ],
        'likuiditas' => [
            'id' => get_risk_id_by_name($conn, 'RISIKO LIKUIDITAS', 4),
            'nama_risiko' => 'RISIKO LIKUIDITAS',
            'pilars' => [
                1 => 'Pilar 1 | Komposisi dan Konsentrasi Aset dan Kewajiban',
                2 => 'Pilar 2 | Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber',
                3 => 'Pilar 3 | Lainnya',
            ]
        ],
    ];
}

function find_hardcoded_inheren_risk($hardcodedInheren, $jenisId){
    foreach($hardcodedInheren as $risk){
        if ((int)$risk['id'] === (int)$jenisId) return $risk;
    }
    return null;
}

function sync_default_inheren_pilar_hardcoded($conn, $id_perumusan_inheren, $hardcodedRisk){
    if (!$hardcodedRisk || empty($hardcodedRisk['pilars'])) return;

    // hapus legacy row "Tingkat Risiko" (id_pilar=99) untuk Kredit/Likuiditas hardcode
    q($conn, "
        DELETE FROM perumusan_inheren_pilar
        WHERE id_perumusan_inheren = '".(int)$id_perumusan_inheren."'
          AND id_pilar = 99
    ", 'DELETE legacy inheren pilar 99');

    $pilars = $hardcodedRisk['pilars'];
    $weights = even_weights(count($pilars));

    // ambil existing rows untuk cek apakah ini masih bobot legacy lama
    $existingRows = [];
    $qExisting = q($conn, "
        SELECT id_detail, id_pilar, pembobotan
        FROM perumusan_inheren_pilar
        WHERE id_perumusan_inheren = '".(int)$id_perumusan_inheren."'
        ORDER BY id_pilar ASC
    ", 'LIST existing inheren pilar hardcoded');
    while($r = mysqli_fetch_assoc($qExisting)){
        if ((int)$r['id_pilar'] === 99) continue;
        $existingRows[(int)$r['id_pilar']] = $r;
    }

    $expectedCount = count($pilars);
    $legacyWeight = round(100 / ($expectedCount + 1), 4);
    $legacyCountMatch = (count($existingRows) === $expectedCount);
    $legacyAllSame = true;
    $legacyTotal = 0.0;

    if ($legacyCountMatch) {
        foreach($existingRows as $er){
            $bw = round((float)$er['pembobotan'], 4);
            $legacyTotal += $bw;
            if (abs($bw - $legacyWeight) > 0.0002) {
                $legacyAllSame = false;
                break;
            }
        }
    } else {
        $legacyAllSame = false;
    }

    $shouldRebalanceLegacy = $legacyAllSame && abs(round($legacyTotal, 4) - round($legacyWeight * $expectedCount, 4)) <= 0.001;

    $i = 0;
    foreach($pilars as $idPilar => $namaPilar){
        $cek = isset($existingRows[(int)$idPilar]) ? $existingRows[(int)$idPilar] : null;
        if(!$cek){
            q($conn, "
                INSERT INTO perumusan_inheren_pilar
                (id_perumusan_inheren, id_pilar, nama_pilar, perskalaan_metode, pembobotan)
                VALUES
                (
                    '".(int)$id_perumusan_inheren."',
                    '".(int)$idPilar."',
                    '".mysqli_real_escape_string($conn, $namaPilar)."',
                    1,
                    '".(float)$weights[$i]."'
                )
            ", 'INSERT default inheren pilar hardcoded');
        } else {
            // perbaiki bobot default legacy lama:
            // kredit 5 pilar masih 16.6666 x 5 = 83.3330
            // likuiditas 3 pilar masih 25.0000 x 3 = 75.0000
            if ($shouldRebalanceLegacy) {
                q($conn, "
                    UPDATE perumusan_inheren_pilar
                    SET pembobotan = '".(float)$weights[$i]."',
                        nama_pilar = '".mysqli_real_escape_string($conn, $namaPilar)."'
                    WHERE id_detail = '".(int)$cek['id_detail']."'
                ", 'UPDATE rebalance legacy inheren pilar hardcoded');
            } else {
                q($conn, "
                    UPDATE perumusan_inheren_pilar
                    SET nama_pilar = '".mysqli_real_escape_string($conn, $namaPilar)."'
                    WHERE id_detail = '".(int)$cek['id_detail']."'
                ", 'UPDATE nama inheren pilar hardcoded');
            }
        }
        $i++;
    }
}

function get_or_create_hardcoded_inheren_rows($conn, $id_frame, $dibuat_by, $hardcodedInheren){
    $rows = [];
    foreach($hardcodedInheren as $risk){
        $riskId = (int)$risk['id'];
        $riskName = mysqli_real_escape_string($conn, $risk['nama_risiko']);
        $existing = fetch_one($conn, "
            SELECT *
            FROM perumusan_inheren
            WHERE id_frame_perumusan='".(int)$id_frame."'
              AND id_jenis_risiko='$riskId'
            LIMIT 1
        ", 'CHECK hardcoded perumusan inheren');
        if (!$existing) {
            q($conn, "
                INSERT INTO perumusan_inheren
                (id_frame_perumusan, id_jenis_risiko, nama_risiko, perskalaan, pembobotan, dibuat_by, dibuat_at)
                VALUES
                ('".(int)$id_frame."', '$riskId', '$riskName', '1', '0', '".(int)$dibuat_by."', NOW())
            ", 'INSERT hardcoded perumusan inheren');
            $existing = fetch_one($conn, "
                SELECT *
                FROM perumusan_inheren
                WHERE id_perumusan_inheren='".(int)mysqli_insert_id($conn)."'
                LIMIT 1
            ", 'LOAD inserted hardcoded perumusan inheren');
        }
        sync_default_inheren_pilar_hardcoded($conn, (int)$existing['id_perumusan_inheren'], $risk);
        $rows[] = [
            'id' => $riskId,
            'nama_risiko' => $risk['nama_risiko'],
            'urutan' => 0,
            'existing' => $existing
        ];
    }
    return $rows;
}

function is_hardcoded_inheren_only_risk($hardcodedInheren, $jenisId){
    return find_hardcoded_inheren_risk($hardcodedInheren, $jenisId) ? true : false;
}

function sync_default_inheren_pilar($conn, $id_perumusan_inheren, $pr_pilih_id, $jenis_id){
    global $HARDCODED_INHEREN;
    $hardcodedRisk = find_hardcoded_inheren_risk($HARDCODED_INHEREN, $jenis_id);
    if ($hardcodedRisk) {
        sync_default_inheren_pilar_hardcoded($conn, $id_perumusan_inheren, $hardcodedRisk);
        return;
    }

    $pilars = get_selected_pilar_inheren($conn, $pr_pilih_id, $jenis_id);
    $count = count($pilars);
    $weights = even_weights($count);

    foreach($pilars as $idx => $p){
        $cek = fetch_one($conn, "
            SELECT *
            FROM perumusan_inheren_pilar
            WHERE id_perumusan_inheren = '".(int)$id_perumusan_inheren."'
              AND id_pilar = '".(int)$p['id_pilar']."'
            LIMIT 1
        ", 'CHECK default inheren pilar');
        if(!$cek){
            q($conn, "
                INSERT INTO perumusan_inheren_pilar
                (id_perumusan_inheren, id_pilar, nama_pilar, perskalaan_metode, pembobotan)
                VALUES
                (
                    '".(int)$id_perumusan_inheren."',
                    '".(int)$p['id_pilar']."',
                    '".mysqli_real_escape_string($conn, $p['nama_pilar'])."',
                    1,
                    '".(float)$weights[$idx]."'
                )
            ", 'INSERT default inheren pilar');
        }
    }
}

function sync_default_kpmr_pilar($conn, $id_perumusan_kpmr, $kpmr_pilih_id, $jenis_id){
    $pilars = get_selected_pilar_kpmr($conn, $kpmr_pilih_id, $jenis_id);
    $count = count($pilars);
    $weights = even_weights($count);

    foreach($pilars as $idx => $p){
        $cek = fetch_one($conn, "
            SELECT *
            FROM perumusan_kpmr_pilar
            WHERE id_perumusan_kpmr = '".(int)$id_perumusan_kpmr."'
              AND id_pilar = '".(int)$p['id_pilar']."'
            LIMIT 1
        ", 'CHECK default kpmr pilar');
        if(!$cek){
            q($conn, "
                INSERT INTO perumusan_kpmr_pilar
                (id_perumusan_kpmr, id_pilar, nama_pilar, perskalaan_metode, pembobotan)
                VALUES
                (
                    '".(int)$id_perumusan_kpmr."',
                    '".(int)$p['id_pilar']."',
                    '".mysqli_real_escape_string($conn, $p['nama_pilar'])."',
                    1,
                    '".(float)$weights[$idx]."'
                )
            ", 'INSERT default kpmr pilar');
        }
    }
}

function format_float_local($n){
    return number_format((float)$n, 4, '.', '');
}

function normalize_metode_perumusan($value){
    $value = strtolower(trim((string)$value));
    return ($value === 'pembobotan') ? 'pembobotan' : 'perskalaan';
}

function sync_global_perumusan_rows($conn, $id_frame, $metode, $rows_inheren, $rows_kpmr, $headerInheren, $headerKpmr, $dibuat_by, $today){
    $id_frame = (int)$id_frame;
    $metode = normalize_metode_perumusan($metode);
    $perskalaan = ($metode === 'perskalaan') ? 1 : 0;
    $pembobotan = ($metode === 'pembobotan') ? 1 : 0;

    if (is_array($rows_inheren)) {
        foreach($rows_inheren as $r){
            $rid = (int)($r['id'] ?? 0);
            $nama = (string)($r['nama_risiko'] ?? '');
            if ($rid <= 0 || $nama === '') continue;

            $nm = mysqli_real_escape_string($conn, $nama);
            $nmNorm = mysqli_real_escape_string($conn, strtoupper(trim($nama)));
            $existing = fetch_one($conn, "
                SELECT *
                FROM perumusan_inheren
                WHERE id_frame_perumusan='$id_frame'
                  AND (id_jenis_risiko='$rid' OR UPPER(TRIM(nama_risiko))='$nmNorm')
                ORDER BY id_jenis_risiko='$rid' DESC, id_perumusan_inheren DESC
                LIMIT 1
            ", 'SYNC CHECK perumusan_inheren');

            if ($existing) {
                q($conn, "
                    UPDATE perumusan_inheren
                    SET id_jenis_risiko='$rid',
                        nama_risiko='$nm',
                        perskalaan='$perskalaan',
                        pembobotan='$pembobotan'
                    WHERE id_perumusan_inheren='".(int)$existing['id_perumusan_inheren']."'
                ", 'SYNC UPDATE perumusan_inheren');
                $perId = (int)$existing['id_perumusan_inheren'];
            } else {
                q($conn, "
                    INSERT INTO perumusan_inheren
                    (id_frame_perumusan, id_jenis_risiko, nama_risiko, perskalaan, pembobotan, dibuat_by, dibuat_at)
                    VALUES
                    ('$id_frame', '$rid', '$nm', '$perskalaan', '$pembobotan', '".(int)$dibuat_by."', '".mysqli_real_escape_string($conn, $today)."')
                ", 'SYNC INSERT perumusan_inheren');
                $perId = mysqli_insert_id($conn);
            }

            if ($headerInheren) {
                sync_default_inheren_pilar($conn, $perId, (int)$headerInheren['id'], $rid);
            }
        }
    }

    if (is_array($rows_kpmr)) {
        foreach($rows_kpmr as $r){
            $rid = (int)($r['id'] ?? 0);
            $nama = (string)($r['nama_risiko'] ?? '');
            if ($rid <= 0 || $nama === '') continue;

            $nm = mysqli_real_escape_string($conn, $nama);
            $nmNorm = mysqli_real_escape_string($conn, strtoupper(trim($nama)));
            $existing = fetch_one($conn, "
                SELECT *
                FROM perumusan_kpmr
                WHERE id_frame_perumusan='$id_frame'
                  AND (id_jenis_risiko='$rid' OR UPPER(TRIM(nama_risiko))='$nmNorm')
                ORDER BY id_jenis_risiko='$rid' DESC, id_perumusan_kpmr DESC
                LIMIT 1
            ", 'SYNC CHECK perumusan_kpmr');

            if ($existing) {
                q($conn, "
                    UPDATE perumusan_kpmr
                    SET id_jenis_risiko='$rid',
                        nama_risiko='$nm',
                        perskalaan='$perskalaan',
                        pembobotan='$pembobotan'
                    WHERE id_perumusan_kpmr='".(int)$existing['id_perumusan_kpmr']."'
                ", 'SYNC UPDATE perumusan_kpmr');
                $perId = (int)$existing['id_perumusan_kpmr'];
            } else {
                q($conn, "
                    INSERT INTO perumusan_kpmr
                    (id_frame_perumusan, id_jenis_risiko, nama_risiko, perskalaan, pembobotan, dibuat_by, dibuat_at)
                    VALUES
                    ('$id_frame', '$rid', '$nm', '$perskalaan', '$pembobotan', '".(int)$dibuat_by."', '".mysqli_real_escape_string($conn, $today)."')
                ", 'SYNC INSERT perumusan_kpmr');
                $perId = mysqli_insert_id($conn);
            }

            if ($headerKpmr) {
                sync_default_kpmr_pilar($conn, $perId, (int)$headerKpmr['id'], $rid);
            }
        }
    }
}

ensure_perumusan_schema($conn);
$HARDCODED_INHEREN = get_hardcoded_inheren_risks($conn);

$mode = getv('mode', 'setting');
$jenis = strtolower(getv('jenis', 'inheren'));
if (!in_array($mode, ['setting', 'detail'])) $mode = 'setting';
if (!in_array($jenis, ['inheren', 'kpmr'])) $jenis = 'inheren';
$filter_risk_id = (int)getv('risk_id', 0);

$dibuat_by = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$today = date('Y-m-d H:i:s');

/* =========================
   SIMPAN SETTING AWAL
========================= */
if (isset($_POST['submit_setting'])) {
    $tahun_kategori = trim((string)postv('tahun_kategori'));
    $user_id = (int)postv('user_id');
    $id_divisi_tetapan = (int)postv('id_divisi_tetapan');
    $metode_perumusan = normalize_metode_perumusan(postv('metode_perumusan', 'perskalaan'));

    $parts = explode('|', $tahun_kategori);
    $tahun = isset($parts[0]) ? trim((string)$parts[0]) : '';
    $kategori_perumusan = isset($parts[1]) ? normalize_kategori($parts[1]) : 'KONSOLIDASI';

    if ($tahun === '' || $tahun_kategori === '') {
        notif('Gagal', 'Tahun wajib diisi.', 'error');
    } else {
        if ($kategori_perumusan === 'CABANG') {
            $userRow = get_cabang_user_row($conn);
            if (!$userRow) {
                set_modal_flash('Notifikasi', 'User Profil Risiko Kantor Cabang tidak ditemukan.', 'warning');
                redirect_to(build_url());
            }
            $user_id = (int)$userRow['id_user_profil_risiko'];
            $id_divisi_tetapan = 0;
        } else {
            if ($user_id <= 0) {
                notif('Gagal', 'User wajib diisi.', 'error');
                $userRow = null;
            } else {
                $userRow = get_user_row($conn, $user_id);
                if (!$userRow) {
                    notif('Gagal', 'User tidak ditemukan.', 'error');
                } else {
                    if (!is_divisi_user_name($userRow['tipe_user'] ?? '')) {
                        $id_divisi_tetapan = 0;
                    } elseif ($id_divisi_tetapan <= 0) {
                        notif('Gagal', 'Divisi wajib dipilih untuk user divisi.', 'error');
                        $userRow = null;
                    }
                }
            }
        }

        if (!empty($userRow)) {
            $headerInheren = get_pr_setting_header($conn, $tahun, $user_id);
            $headerKpmr    = get_kpmr_setting_header($conn, $tahun, $user_id);

            if ($id_divisi_tetapan > 0) {
                $whereDiv = "id_divisi_tetapan = '$id_divisi_tetapan'";
            } else {
                $whereDiv = "(id_divisi_tetapan IS NULL OR id_divisi_tetapan = 0)";
            }

            if ($kategori_perumusan === 'KONSOLIDASI') {
                $whereKategori = "(UPPER(COALESCE(triwulan,'')) IN ('', 'KONSOLIDASI'))";
            } else {
                $whereKategori = "UPPER(COALESCE(triwulan,'')) = 'CABANG'";
            }

            $cekFrame = fetch_one($conn, "
                    SELECT *
                    FROM frame_perumusan
                    WHERE tahun = '".mysqli_real_escape_string($conn, $tahun)."'
                      AND user_id = '$user_id'
                      AND $whereDiv
                      AND $whereKategori
                    ORDER BY id_frame_perumusan DESC
                    LIMIT 1
                ", 'CHECK frame_perumusan');

                if ($cekFrame) {
                    q($conn, "
                        UPDATE frame_perumusan
                        SET metode_perumusan = '".mysqli_real_escape_string($conn, $metode_perumusan)."'
                        WHERE id_frame_perumusan = '".(int)$cekFrame['id_frame_perumusan']."'
                    ", 'UPDATE frame metode_perumusan');
                    redirect_to(build_url(['mode' => 'setting', 'id' => (int)$cekFrame['id_frame_perumusan'], 'ok' => 1]));
                } else {
                    mysqli_begin_transaction($conn);
                    try {
                        q($conn, "
                            INSERT INTO frame_perumusan
                            (tahun, triwulan, user_id, id_divisi_tetapan, metode_perumusan, is_aktif, dibuat_by, dibuat_at)
                            VALUES
                            (
                                '".mysqli_real_escape_string($conn, $tahun)."',
                                '".mysqli_real_escape_string($conn, $kategori_perumusan)."',
                                '$user_id',
                                ".($id_divisi_tetapan > 0 ? "'$id_divisi_tetapan'" : "NULL").",
                                '".mysqli_real_escape_string($conn, $metode_perumusan)."',
                                '0',
                                '$dibuat_by',
                                '$today'
                            )
                        ", 'INSERT frame_perumusan');
                        $newId = mysqli_insert_id($conn);
                        mysqli_commit($conn);
                        redirect_to(build_url(['mode' => 'setting', 'id' => $newId, 'ok' => 1]));
                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        notif('Gagal', 'Frame perumusan gagal dibuat.', 'error');
                    }
                }
            }
        }
    }
/* =========================
   SIMPAN CHECKLIST RISIKO
========================= */
if (isset($_POST['submit_risk_choice']) || isset($_POST['auto_submit_risk_choice'])) {
    $isAutoAjax = (isset($_POST['auto_submit_risk_choice']) && is_ajax_request());
    $id_frame = (int)postv('id_frame');
    $frame = fetch_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='$id_frame' LIMIT 1", 'GET frame');

    if (!$frame) {
        if ($isAutoAjax) json_response(false, 'Frame perumusan tidak ditemukan.');
        notif('Gagal', 'Frame perumusan tidak ditemukan.', 'error');
    } else {
        $tahun = $frame['tahun'];
        $user_id = (int)$frame['user_id'];
        $headerInheren = get_pr_setting_header($conn, $tahun, $user_id);
        $headerKpmr    = get_kpmr_setting_header($conn, $tahun, $user_id);

        mysqli_begin_transaction($conn);
        try {
            $inheren_ids = postv('inheren_ids', []);
            $inheren_names = postv('inheren_names', []);
            $inheren_mode = postv('inheren_mode', []);
            if (is_array($inheren_ids)) {
                foreach($inheren_ids as $idx => $rid){
                    $rid = (int)$rid;
                    $nm = mysqli_real_escape_string($conn, $inheren_names[$idx] ?? '');
                    $modeValue = isset($inheren_mode[$rid]) ? trim((string)$inheren_mode[$rid]) : '';
                    $perskalaan = ($modeValue === 'perskalaan') ? 1 : 0;
                    $pembobotan = ($modeValue === 'pembobotan') ? 1 : 0;

                    $nmNorm = mysqli_real_escape_string($conn, strtoupper(trim((string)($inheren_names[$idx] ?? ''))));
                    $existing = fetch_one($conn, "
                        SELECT *
                        FROM perumusan_inheren
                        WHERE id_frame_perumusan='".(int)$id_frame."'
                          AND (
                                id_jenis_risiko='$rid'
                                OR UPPER(TRIM(nama_risiko))='$nmNorm'
                              )
                        ORDER BY id_jenis_risiko='$rid' DESC, id_perumusan_inheren DESC
                        LIMIT 1
                    ", 'CHECK perumusan_inheren');
                    if ($existing) {
                        q($conn, "
                            UPDATE perumusan_inheren
                            SET nama_risiko='$nm',
                                id_jenis_risiko='$rid',
                                perskalaan='$perskalaan',
                                pembobotan='$pembobotan'
                            WHERE id_frame_perumusan='".(int)$id_frame."'
                              AND (
                                    id_jenis_risiko='$rid'
                                    OR UPPER(TRIM(nama_risiko))='$nmNorm'
                                  )
                        ", 'UPDATE perumusan_inheren ALL MATCHING');
                        $existingAfter = fetch_one($conn, "
                            SELECT *
                            FROM perumusan_inheren
                            WHERE id_frame_perumusan='".(int)$id_frame."'
                              AND id_jenis_risiko='$rid'
                            ORDER BY id_perumusan_inheren DESC
                            LIMIT 1
                        ", 'LOAD UPDATED perumusan_inheren');
                        $perId = (int)($existingAfter['id_perumusan_inheren'] ?? $existing['id_perumusan_inheren']);
                    } else {
                        q($conn, "
                            INSERT INTO perumusan_inheren
                            (id_frame_perumusan, id_jenis_risiko, nama_risiko, perskalaan, pembobotan, dibuat_by, dibuat_at)
                            VALUES
                            ('".(int)$id_frame."', '$rid', '$nm', '$perskalaan', '$pembobotan', '$dibuat_by', '$today')
                        ", 'INSERT perumusan_inheren');
                        $perId = mysqli_insert_id($conn);
                    }

                    if ($headerInheren && ($perskalaan == 1 || $pembobotan == 1)) {
                        sync_default_inheren_pilar($conn, $perId, (int)$headerInheren['id'], $rid);
                    }
                }
            }

            $kpmr_ids = postv('kpmr_ids', []);
            $kpmr_names = postv('kpmr_names', []);
            $kpmr_mode = postv('kpmr_mode', []);
            if (is_array($kpmr_ids)) {
                foreach($kpmr_ids as $idx => $rid){
                    $rid = (int)$rid;
                    $nm = mysqli_real_escape_string($conn, $kpmr_names[$idx] ?? '');
                    $modeValue = isset($kpmr_mode[$rid]) ? trim((string)$kpmr_mode[$rid]) : '';
                    $perskalaan = ($modeValue === 'perskalaan') ? 1 : 0;
                    $pembobotan = ($modeValue === 'pembobotan') ? 1 : 0;

                    $nmNorm = mysqli_real_escape_string($conn, strtoupper(trim((string)($kpmr_names[$idx] ?? ''))));
                    $existing = fetch_one($conn, "
                        SELECT *
                        FROM perumusan_kpmr
                        WHERE id_frame_perumusan='".(int)$id_frame."'
                          AND (
                                id_jenis_risiko='$rid'
                                OR UPPER(TRIM(nama_risiko))='$nmNorm'
                              )
                        ORDER BY id_jenis_risiko='$rid' DESC, id_perumusan_kpmr DESC
                        LIMIT 1
                    ", 'CHECK perumusan_kpmr');
                    if ($existing) {
                        q($conn, "
                            UPDATE perumusan_kpmr
                            SET nama_risiko='$nm',
                                id_jenis_risiko='$rid',
                                perskalaan='$perskalaan',
                                pembobotan='$pembobotan'
                            WHERE id_frame_perumusan='".(int)$id_frame."'
                              AND (
                                    id_jenis_risiko='$rid'
                                    OR UPPER(TRIM(nama_risiko))='$nmNorm'
                                  )
                        ", 'UPDATE perumusan_kpmr ALL MATCHING');
                        $existingAfter = fetch_one($conn, "
                            SELECT *
                            FROM perumusan_kpmr
                            WHERE id_frame_perumusan='".(int)$id_frame."'
                              AND id_jenis_risiko='$rid'
                            ORDER BY id_perumusan_kpmr DESC
                            LIMIT 1
                        ", 'LOAD UPDATED perumusan_kpmr');
                        $perId = (int)($existingAfter['id_perumusan_kpmr'] ?? $existing['id_perumusan_kpmr']);
                    } else {
                        q($conn, "
                            INSERT INTO perumusan_kpmr
                            (id_frame_perumusan, id_jenis_risiko, nama_risiko, perskalaan, pembobotan, dibuat_by, dibuat_at)
                            VALUES
                            ('".(int)$id_frame."', '$rid', '$nm', '$perskalaan', '$pembobotan', '$dibuat_by', '$today')
                        ", 'INSERT perumusan_kpmr');
                        $perId = mysqli_insert_id($conn);
                    }

                    if ($headerKpmr && ($perskalaan == 1 || $pembobotan == 1)) {
                        sync_default_kpmr_pilar($conn, $perId, (int)$headerKpmr['id'], $rid);
                    }
                }
            }

            mysqli_commit($conn);
            if ($isAutoAjax) json_response(true, 'Checklist perumusan tersimpan.');
            redirect_to(build_url(['mode' => 'setting', 'id' => $id_frame, 'saved' => 1]));
        } catch (Exception $e) {
            mysqli_rollback($conn);
            if ($isAutoAjax) json_response(false, $e->getMessage());
            notif('Gagal', 'Data perumusan gagal disimpan.', 'error');
        }
    }
}

/* =========================
   SIMPAN DETAIL PER PILAR
========================= */
if (isset($_POST['submit_detail']) || isset($_POST['auto_submit_detail'])) {
    $isAutoAjax = (isset($_POST['auto_submit_detail']) && is_ajax_request());
    $id_frame = (int)postv('id_frame');
    $jenis = strtolower((string)postv('jenis'));
    $frame = fetch_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='$id_frame' LIMIT 1", 'GET frame detail');

    if (!$frame || !in_array($jenis, ['inheren', 'kpmr'])) {
        if ($isAutoAjax) json_response(false, 'Data detail tidak valid.');
        notif('Gagal', 'Data detail tidak valid.', 'error');
    } else {
        mysqli_begin_transaction($conn);
        try {
            $perskalaan_metode = postv('perskalaan_metode', []);
            $pembobotan = postv('pembobotan', []);

            $tableDetail = ($jenis === 'inheren') ? 'perumusan_inheren_pilar' : 'perumusan_kpmr_pilar';
            $all_ids = array_unique(array_merge(
                array_map('intval', array_keys((array)$perskalaan_metode)),
                array_map('intval', array_keys((array)$pembobotan))
            ));

            foreach($all_ids as $id_detail){
                $id_detail = (int)$id_detail;
                $metode = isset($perskalaan_metode[$id_detail]) ? (int)$perskalaan_metode[$id_detail] : 1;
                if (!in_array($metode, [1,2,3])) $metode = 1;
                $bobot = isset($pembobotan[$id_detail]) ? (float)str_replace(',', '.', $pembobotan[$id_detail]) : 0;

                q($conn, "
                    UPDATE {$tableDetail}
                    SET perskalaan_metode = '$metode',
                        pembobotan = '$bobot'
                    WHERE id_detail = '$id_detail'
                ", 'UPDATE detail perumusan');
            }

            mysqli_commit($conn);
            if ($isAutoAjax) json_response(true, 'Isi perumusan tersimpan.');
            redirect_to(build_url(['mode' => 'detail', 'jenis' => $jenis, 'id' => $id_frame, 'saved' => 1]));
        } catch (Exception $e) {
            mysqli_rollback($conn);
            if ($isAutoAjax) json_response(false, $e->getMessage());
            notif('Gagal', 'Detail perumusan gagal disimpan.', 'error');
        }
    }
}

/* =========================
   AKTIF / NONAKTIF FRAME
========================= */
if (getv('aktifkan') != '') {
    $id_aktif = (int)getv('aktifkan');
    $rowAktif = fetch_one($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE id_frame_perumusan='$id_aktif'
        LIMIT 1
    ", 'GET frame aktif');
    if ($rowAktif) {
        $userAktif = (int)$rowAktif['user_id'];
        $tahunAktif = mysqli_real_escape_string($conn, (string)$rowAktif['tahun']);
        $kategoriAktif = normalize_kategori($rowAktif['triwulan'] ?? '');
        $idDivisiAktif = (int)($rowAktif['id_divisi_tetapan'] ?? 0);

        if ($kategoriAktif === 'KONSOLIDASI') {
            $whereKategoriAktif = "(UPPER(COALESCE(triwulan,'')) IN ('', 'KONSOLIDASI'))";
        } else {
            $whereKategoriAktif = "UPPER(COALESCE(triwulan,'')) = 'CABANG'";
        }

        if ($idDivisiAktif > 0) {
            $whereDivisiAktif = "COALESCE(id_divisi_tetapan,0) = '$idDivisiAktif'";
        } else {
            $whereDivisiAktif = "COALESCE(id_divisi_tetapan,0) = 0";
        }

        mysqli_begin_transaction($conn);
        try {
            // Aktif/nonaktif hanya untuk scope yang sama:
            // jenis profil risiko/user + tahun + kategori + divisi.
            // Tahun lain tetap aktif sendiri.
            q($conn, "
                UPDATE frame_perumusan
                SET is_aktif = 0
                WHERE user_id='$userAktif'
                  AND tahun='$tahunAktif'
                  AND $whereKategoriAktif
                  AND $whereDivisiAktif
            ", 'RESET aktif per jenis profil risiko dan tahun');

            q($conn, "UPDATE frame_perumusan SET is_aktif = 1 WHERE id_frame_perumusan='$id_aktif'", 'SET aktif frame');
            mysqli_commit($conn);
            redirect_to(build_url(['mode'=>'setting','id'=>$id_aktif,'active'=>1]));
        } catch (Exception $e) {
            mysqli_rollback($conn);
            notif('Gagal', 'Setting gagal diaktifkan.', 'error');
        }
    }
}

if (getv('nonaktifkan') != '') {
    $id_nonaktif = (int)getv('nonaktifkan');
    q($conn, "UPDATE frame_perumusan SET is_aktif = 0 WHERE id_frame_perumusan='$id_nonaktif'", 'SET nonaktif frame');
    redirect_to(build_url(['mode'=>'setting','id'=>$id_nonaktif,'inactive'=>1]));
}

/* =========================
   HAPUS FRAME
========================= */
if (getv('hapus') != '') {
    $id_hapus = (int)getv('hapus');
    mysqli_begin_transaction($conn);
    try {
        q($conn, "DELETE dip FROM perumusan_inheren_pilar dip
                  INNER JOIN perumusan_inheren pi ON dip.id_perumusan_inheren = pi.id_perumusan_inheren
                  WHERE pi.id_frame_perumusan='$id_hapus'", 'DELETE perumusan_inheren_pilar');
        q($conn, "DELETE dkp FROM perumusan_kpmr_pilar dkp
                  INNER JOIN perumusan_kpmr pk ON dkp.id_perumusan_kpmr = pk.id_perumusan_kpmr
                  WHERE pk.id_frame_perumusan='$id_hapus'", 'DELETE perumusan_kpmr_pilar');
        q($conn, "DELETE FROM perumusan_inheren WHERE id_frame_perumusan='$id_hapus'", 'DELETE perumusan_inheren');
        q($conn, "DELETE FROM perumusan_kpmr WHERE id_frame_perumusan='$id_hapus'", 'DELETE perumusan_kpmr');
        q($conn, "DELETE FROM frame_perumusan WHERE id_frame_perumusan='$id_hapus'", 'DELETE frame_perumusan');
        mysqli_commit($conn);
        redirect_to(build_url(['del' => 1]));
    } catch (Exception $e) {
        mysqli_rollback($conn);
        notif('Gagal', 'Data gagal dihapus.', 'error');
    }
}

/* =========================
   LOAD DATA
========================= */
$rows_inheren = [];
$rows_kpmr = [];
$frame = null;
$headerInheren = null;
$headerKpmr = null;

$id_frame = (int)getv('id');
if ($id_frame > 0) {
    $frame = fetch_one($conn, "
        SELECT f.*, upr.tipe_user
        FROM frame_perumusan f
        LEFT JOIN user_profil_risiko upr ON f.user_id = upr.id_user_profil_risiko
        WHERE f.id_frame_perumusan = '$id_frame'
        LIMIT 1
    ", 'LOAD frame');

    if ($frame) {
        $frame['kategori_perumusan'] = frame_kategori($frame);
        $frame['nama_divisi_tetapan'] = get_divisi_label((int)($frame['id_divisi_tetapan'] ?? 0), $DIVISI_OPTIONS);
        $headerInheren = get_pr_setting_header($conn, $frame['tahun'], (int)$frame['user_id']);
        $headerKpmr = get_kpmr_setting_header($conn, $frame['tahun'], (int)$frame['user_id']);

        $rows_inheren = [];
        if ($headerInheren) {
            $rows_inheren = get_selected_risiko_inheren($conn, (int)$headerInheren['id']);
        }

        $hardcodedRows = get_or_create_hardcoded_inheren_rows($conn, $id_frame, $dibuat_by, $HARDCODED_INHEREN);

        $mapInheren = [];
        foreach($rows_inheren as $tmpRow){
            $tmpRow['urutan'] = isset($tmpRow['urutan']) ? (int)$tmpRow['urutan'] : 9999;
            $mapInheren[(int)$tmpRow['id']] = $tmpRow;
        }
        foreach($hardcodedRows as $tmpRow){
            $rid = (int)$tmpRow['id'];
            if (!isset($mapInheren[$rid])) {
                $tmpRow['urutan'] = 9998;
                $mapInheren[$rid] = $tmpRow;
            }
        }
        $rows_inheren = array_values($mapInheren);
        usort($rows_inheren, function($a, $b){
            $ua = isset($a['urutan']) ? (int)$a['urutan'] : 9999;
            $ub = isset($b['urutan']) ? (int)$b['urutan'] : 9999;
            if ($ua === $ub) return ((int)$a['id'] <=> (int)$b['id']);
            return $ua <=> $ub;
        });

        if ($headerKpmr) {
            $rows_kpmr = get_selected_risiko_kpmr($conn, (int)$headerKpmr['id']);
        }

        $frame['metode_perumusan'] = normalize_metode_perumusan($frame['metode_perumusan'] ?? 'perskalaan');
        sync_global_perumusan_rows($conn, $id_frame, $frame['metode_perumusan'], $rows_inheren, $rows_kpmr, $headerInheren, $headerKpmr, $dibuat_by, $today);

        foreach($rows_inheren as &$r){
            $riskNameLoad = mysqli_real_escape_string($conn, strtoupper(trim((string)$r['nama_risiko'])));
            $existing = fetch_one($conn, "
                SELECT *
                FROM perumusan_inheren
                WHERE id_frame_perumusan='$id_frame'
                  AND (
                        id_jenis_risiko='".(int)$r['id']."'
                        OR UPPER(TRIM(nama_risiko))='$riskNameLoad'
                      )
                ORDER BY id_jenis_risiko='".(int)$r['id']."' DESC, id_perumusan_inheren DESC
                LIMIT 1
            ", 'LOAD perumusan_inheren row');
            $r['existing'] = $existing;
            if ($existing) {
                sync_default_inheren_pilar($conn, (int)$existing['id_perumusan_inheren'], ($headerInheren ? (int)$headerInheren['id'] : 0), (int)$r['id']);
            }
        }
        unset($r);

        foreach($rows_kpmr as &$r){
            $riskNameLoad = mysqli_real_escape_string($conn, strtoupper(trim((string)$r['nama_risiko'])));
            $existing = fetch_one($conn, "
                SELECT *
                FROM perumusan_kpmr
                WHERE id_frame_perumusan='$id_frame'
                  AND (
                        id_jenis_risiko='".(int)$r['id']."'
                        OR UPPER(TRIM(nama_risiko))='$riskNameLoad'
                      )
                ORDER BY id_jenis_risiko='".(int)$r['id']."' DESC, id_perumusan_kpmr DESC
                LIMIT 1
            ", 'LOAD perumusan_kpmr row');
            $r['existing'] = $existing;
            if ($existing && ((int)$existing['perskalaan'] === 1 || (int)$existing['pembobotan'] === 1) && $headerKpmr) {
                sync_default_kpmr_pilar($conn, (int)$existing['id_perumusan_kpmr'], (int)$headerKpmr['id'], (int)$r['id']);
            }
        }
        unset($r);
    }
}

$listFrame = q($conn, "
    SELECT f.*, upr.tipe_user
    FROM frame_perumusan f
    LEFT JOIN user_profil_risiko upr ON f.user_id = upr.id_user_profil_risiko
    ORDER BY CAST(f.tahun AS UNSIGNED) DESC, f.id_frame_perumusan DESC
", 'LIST frame');

$availableYears = [];
$qYear = q($conn, "
    SELECT DISTINCT tahun FROM (
        SELECT pi.tahun AS tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        UNION
        SELECT kp.tahun AS tahun
        FROM kpmr_pilih_parameter kpp
        INNER JOIN kpmr_periode kp ON kpp.kpmr_periode_id = kp.id
    ) x
    ORDER BY CAST(tahun AS UNSIGNED) DESC
", 'GET years');
while($r = mysqli_fetch_assoc($qYear)){
    $availableYears[] = $r['tahun'];
}

$userOptionsRows = [];
$userOptions = q($conn, "SELECT * FROM user_profil_risiko ORDER BY tipe_user ASC", 'LIST users');
while($u = mysqli_fetch_assoc($userOptions)){
    $userOptionsRows[] = $u;
}

$detailBlocks = [];
$modalFlash = get_modal_flash();
if ($mode === 'detail' && $frame) {
    if ($jenis === 'inheren') {
        foreach($rows_inheren as $rr){
            if ($filter_risk_id > 0 && (int)$rr['id'] !== $filter_risk_id) continue;
            $existing = isset($rr['existing']) ? $rr['existing'] : null;
            if (!$existing) continue;
            if ((int)$existing['perskalaan'] !== 1 && (int)$existing['pembobotan'] !== 1) continue;

            $pilars = [];
            $qP = q($conn, "
                SELECT *
                FROM perumusan_inheren_pilar
                WHERE id_perumusan_inheren = '".(int)$existing['id_perumusan_inheren']."'
                ORDER BY id_pilar ASC, id_detail ASC
            ", 'LIST pilar inheren');
            while($p = mysqli_fetch_assoc($qP)){
                $pilars[] = $p;
            }
            $detailBlocks[] = ['header' => $existing, 'pilars' => $pilars];
        }
    } else {
        $res = q($conn, "
            SELECT *
            FROM perumusan_kpmr
            WHERE id_frame_perumusan = '$id_frame'
              AND (perskalaan = 1 OR pembobotan = 1)
              ".($filter_risk_id > 0 ? " AND id_jenis_risiko = '$filter_risk_id' " : "")."
            ORDER BY id_perumusan_kpmr ASC
        ", 'LIST detail kpmr');
        while($r = mysqli_fetch_assoc($res)){
            $pilars = [];
            $qP = q($conn, "
                SELECT *
                FROM perumusan_kpmr_pilar
                WHERE id_perumusan_kpmr = '".(int)$r['id_perumusan_kpmr']."'
                ORDER BY id_detail ASC
            ", 'LIST pilar kpmr');
            while($p = mysqli_fetch_assoc($qP)){
                $pilars[] = $p;
            }
            $detailBlocks[] = ['header' => $r, 'pilars' => $pilars];
        }
    }
}

/* =========================
   NILAI DEFAULT FORM
========================= */
$current_tahun_kategori = '';
$current_user_id = 0;
$current_divisi_tetapan = 0;
$current_metode_perumusan = 'perskalaan';

if ($frame) {
    $current_tahun_kategori = $frame['tahun'].'|'.$frame['kategori_perumusan'];
    $current_user_id = (int)$frame['user_id'];
    $current_divisi_tetapan = (int)($frame['id_divisi_tetapan'] ?? 0);
    $current_metode_perumusan = normalize_metode_perumusan($frame['metode_perumusan'] ?? 'perskalaan');
} else {
    $current_tahun_kategori = (string)postv('tahun_kategori');
    $current_user_id = (int)postv('user_id');
    $current_divisi_tetapan = (int)postv('id_divisi_tetapan');
    $current_metode_perumusan = normalize_metode_perumusan(postv('metode_perumusan', 'perskalaan'));
}
?>
<style>
body{background:#f5f6fa}
.title-soft{font-size:12px;color:#8b96a5;text-transform:uppercase;letter-spacing:.08em;font-weight:700}
.card-clean{border:0;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,.05)}
.table-clean thead th{background:#eef2f7!important;color:#334155;font-weight:700;border-color:#e5e7eb!important}
.table-clean td{vertical-align:middle}
.badge-soft{background:#eef4ff;color:#2563eb;padding:.4rem .65rem;border-radius:999px;font-size:.75rem;font-weight:700}
.info-pill{display:inline-block;padding:.4rem .8rem;border-radius:999px;background:#f1f5f9;color:#0f172a;font-weight:600;margin-right:.35rem;margin-bottom:.35rem}
.status-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:86px;
    padding:.42rem .75rem;
    border-radius:999px;
    font-size:.75rem;
    line-height:1;
    font-weight:800;
    white-space:nowrap;
    border:1px solid transparent;
}
.status-pill.active{
    background:#dcfce7;
    color:#166534;
    border-color:#86efac;
}
.status-pill.inactive{
    background:#ffe4e6;
    color:#be123c;
    border-color:#fecdd3;
}
.perumusan-box{border:1px solid #e5e7eb;border-radius:12px;padding:14px;background:#fff;height:100%}
.perumusan-box h5{margin-bottom:14px}
.small-btn{padding:.28rem .65rem;font-size:.78rem}
.total-red{color:#dc2626;font-weight:800}
.total-ok{color:#16a34a;font-weight:800}
.help-soft{font-size:12px;color:#6b7280}
.per-risk-card{border:1px solid #e5e7eb;border-radius:12px;margin-bottom:16px;overflow:hidden;background:#fff}
.per-risk-head{background:#f8fafc;padding:12px 16px;border-bottom:1px solid #e5e7eb;font-weight:700}
.per-risk-body{padding:0}
.per-risk-table{margin-bottom:0}
.per-risk-table thead th{background:#0f172a!important;color:#fff!important;border-color:#1f2937!important}
.per-risk-table td{vertical-align:middle}
.pilar-row-title{background:#ecfeff!important;font-weight:700}
.w-160{width:160px}
.w-180{width:180px}
.w-120{width:120px}
.w-90{width:90px}
.auto-save-note{font-size:12px;color:#64748b;font-style:italic}
.modal-msg-body{font-size:15px;line-height:1.7;color:#475569}
.cursor-pointer{cursor:pointer}
.auto-save-toast{
    position:fixed;right:18px;bottom:18px;z-index:2000;background:#0f172a;color:#fff;
    padding:10px 14px;border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,.18);font-size:13px;display:none;max-width:420px
}
.auto-save-toast.show{display:block}
.auto-save-toast.ok{background:#16a34a}
.auto-save-toast.err{background:#dc2626}
.lock-note{font-size:12px;color:#64748b;margin-top:6px}
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <?php
            if (isset($_GET['ok'])) notif('Berhasil', 'Frame perumusan siap digunakan.');
            if (isset($_GET['saved'])) {
                if ($mode === 'detail') notif('Berhasil', 'Isi perumusan berhasil disimpan.');
                else notif('Berhasil', 'Pilihan perumusan berhasil disimpan.');
            }
            if (isset($_GET['del'])) notif('Berhasil', 'Data perumusan berhasil dihapus.', 'warning');
            ?>

            <?php if ($modalFlash) { ?>
            <div class="modal fade" id="modalNotifOtomatis" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-<?= esc(modal_class_by_type($modalFlash['type'])) ?> text-white">
                            <h5 class="modal-title"><?= esc($modalFlash['title']) ?></h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body modal-msg-body">
                            <?= esc($modalFlash['message']) ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div id="autoSaveToast" class="auto-save-toast"></div>

            <?php if ($mode === 'setting') { ?>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Setting Perumusan Risiko</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-clean mb-3">
                        <div class="card-body">
                            <form method="POST" id="formSettingPerumusan">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Masukan tahun</label>
                                        <select class="form-select" name="tahun_kategori" id="tahun_kategori" required>
                                            <option value="">-- pilih tahun --</option>
                                            <?php foreach($availableYears as $th){ ?>
                                                <option value="<?= esc($th) ?>|KONSOLIDASI" <?= ($current_tahun_kategori === ($th.'|KONSOLIDASI') ? 'selected' : '') ?>>
                                                    <?= esc($th) ?> - Konsolidasi
                                                </option>
                                                <option value="<?= esc($th) ?>|CABANG" <?= ($current_tahun_kategori === ($th.'|CABANG') ? 'selected' : '') ?>>
                                                    <?= esc($th) ?> - Cabang
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Settingan ditetapkan untuk user :</label>
                                        <select class="form-select" id="user_id_select" required>
                                            <option value="">-- pilih user --</option>
                                            <?php foreach($userOptionsRows as $u){ ?>
                                                <option
                                                    value="<?= (int)$u['id_user_profil_risiko'] ?>"
                                                    data-text="<?= esc(strtolower($u['tipe_user'])) ?>"
                                                    <?= ($current_user_id === (int)$u['id_user_profil_risiko'] ? 'selected' : '') ?>>
                                                    <?= esc($u['tipe_user']) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <input type="hidden" name="user_id" id="user_id_hidden" value="<?= (int)$current_user_id ?>">
                                        <div class="lock-note" id="user_lock_note" style="display:none;">User otomatis dipilih dan dikunci untuk setting Cabang.</div>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Metode perumusan</label>
                                        <select class="form-select" name="metode_perumusan" id="metode_perumusan">
                                            <option value="perskalaan" <?= ($current_metode_perumusan === 'perskalaan' ? 'selected' : '') ?>>Perskalaan</option>
                                            <option value="pembobotan" <?= ($current_metode_perumusan === 'pembobotan' ? 'selected' : '') ?>>Pembobotan</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2" id="divisiWrap" style="display:none;">
                                        <label class="form-label">Pilih divisi</label>
                                        <select class="form-select" name="id_divisi_tetapan" id="id_divisi_tetapan">
                                            <option value="">-- pilih divisi --</option>
                                            <?php foreach($DIVISI_OPTIONS as $divId => $divName){ ?>
                                                <option value="<?= (int)$divId ?>" <?= ($current_divisi_tetapan === (int)$divId ? 'selected' : '') ?>>
                                                    <?= esc($divName) ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-primary" type="submit" name="submit_setting">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($frame) { ?>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card card-clean">
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="title-soft">Frame Perumusan Aktif</div>
                                    <h4 class="mb-1">
                                        Tahun <?= esc($frame['tahun']) ?> - <?= esc(kategori_label($frame['kategori_perumusan'])) ?> - <?= esc($frame['tipe_user']) ?>
                                    </h4>
                                    <div>
                                        <?php if (!empty($frame['nama_divisi_tetapan']) && $frame['nama_divisi_tetapan'] !== '-') { ?>
                                            <span class="info-pill">Divisi: <?= esc($frame['nama_divisi_tetapan']) ?></span>
                                        <?php } ?>
                                        <span class="info-pill">Inheren: <?= (!empty($rows_inheren) ? 'Siap' : 'Belum ada setting parameter') ?></span>
                                        <span class="info-pill">KPMR: <?= $headerKpmr ? 'Siap' : 'Belum ada setting parameter' ?></span>
                                        <span class="info-pill">Metode: <?= esc(ucfirst($current_metode_perumusan)) ?></span>
                                        <span class="status-pill <?= ((int)($frame['is_aktif'] ?? 0)===1?'active':'inactive') ?>"><?= ((int)($frame['is_aktif'] ?? 0)===1?'Aktif':'Tidak Aktif') ?></span>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php $canOpenInheren = !empty($rows_inheren); ?>
                                    <?php $canOpenKpmr = ($headerKpmr && !empty($rows_kpmr)); ?>
                                    <?php if ((int)($frame['is_aktif'] ?? 0) === 1) { ?>
                                        <a href="<?= esc(build_url(['mode'=>'setting','id'=>$id_frame,'nonaktifkan'=>$id_frame])) ?>" class="btn btn-warning btn-sm" onclick="return confirm('Nonaktifkan setting ini?')">Nonaktifkan</a>
                                    <?php } else { ?>
                                        <a href="<?= esc(build_url(['mode'=>'setting','id'=>$id_frame,'aktifkan'=>$id_frame])) ?>" class="btn btn-success btn-sm" onclick="return confirm('Aktifkan setting ini? Setting lain dengan jenis profil risiko dan tahun yang sama akan menjadi nonaktif.')">Aktifkan</a>
                                    <?php } ?>
                                    <?php if ($canOpenInheren) { ?>
                                        <a href="<?= esc(build_url(['mode'=>'detail','jenis'=>'inheren','id'=>$id_frame])) ?>" class="btn btn-outline-primary">Isi Perumusan Inheren</a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-outline-primary open-info-modal" data-title="Notifikasi" data-message="Setting parameter Inheren belum ada atau risiko Inheren belum tersedia.">Isi Perumusan Inheren</button>
                                    <?php } ?>

                                    <?php if ($canOpenKpmr) { ?>
                                        <a href="<?= esc(build_url(['mode'=>'detail','jenis'=>'kpmr','id'=>$id_frame])) ?>" class="btn btn-outline-success">Isi Perumusan KPMR</a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-outline-success open-info-modal" data-title="Notifikasi" data-message="Setting parameter KPMR belum ada atau risiko KPMR dari checklist belum tersedia.">Isi Perumusan KPMR</button>
                                    <?php } ?>
                                </div>
                            </div>

                            <form method="POST" class="mt-3" id="riskChoiceForm">
                                <input type="hidden" name="auto_submit_risk_choice" value="1">
                                <input type="hidden" name="id_frame" value="<?= (int)$id_frame ?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="perumusan-box">
                                            <h5>Perumusan Risiko Inheren</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-clean align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50px;">No</th>
                                                            <th>Risiko</th>
                                                            <th class="text-center" style="width:150px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        if (empty($rows_inheren)) {
                                                            echo '<tr><td colspan="3" class="text-center text-muted">Belum ada risiko inheren dari checklist/master parameter</td></tr>';
                                                        } else {
                                                            foreach($rows_inheren as $r){
                                                                $existing = $r['existing'] ?? null;
                                                                echo '<tr>';
                                                                echo '<td class="text-center">'.($no++).'</td>';
                                                                echo '<td>'.esc($r['nama_risiko']).'
                                                                        <input type="hidden" name="inheren_ids[]" value="'.(int)$r['id'].'">
                                                                        <input type="hidden" name="inheren_names[]" value="'.esc($r['nama_risiko']).'">
                                                                      </td>';
                                                                echo '<td class="text-center">
                                                                        <input type="hidden" name="inheren_mode['.(int)$r['id'].']" value="'.esc($current_metode_perumusan).'">
                                                                        <a href="'.esc(build_url(['mode'=>'detail','jenis'=>'inheren','id'=>$id_frame,'risk_id'=>(int)$r['id']])).'" class="btn btn-sm btn-primary small-btn">Isi Perumusan</a>
                                                                      </td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-2">
                                                <?php $canOpenInherenTable = !empty($rows_inheren); ?>
                                                <?php if ($canOpenInherenTable) { ?>
                                                    <a href="<?= esc(build_url(['mode'=>'detail','jenis'=>'inheren','id'=>$id_frame])) ?>" class="btn btn-sm btn-primary small-btn">Isi Perumusan</a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-sm btn-primary small-btn open-info-modal" data-title="Notifikasi" data-message="Setting parameter Inheren belum ada atau risiko Inheren belum tersedia.">Isi Perumusan</button>
                                                <?php } ?>
                                            </div>
                                            <div class="auto-save-note mt-2">Metode risiko mengikuti dropdown metode perumusan di atas.</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="perumusan-box">
                                            <h5>Perumusan Risiko KPMR</h5>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-clean align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:50px;">No</th>
                                                            <th>Risiko</th>
                                                            <th class="text-center" style="width:150px;">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = 1;
                                                        if (empty($rows_kpmr)) {
                                                            echo '<tr><td colspan="3" class="text-center text-muted">Belum ada risiko KPMR dari checklist parameter</td></tr>';
                                                        } else {
                                                            foreach($rows_kpmr as $r){
                                                                $existing = $r['existing'] ?? null;
                                                                echo '<tr>';
                                                                echo '<td class="text-center">'.($no++).'</td>';
                                                                echo '<td>'.esc($r['nama_risiko']).'
                                                                        <input type="hidden" name="kpmr_ids[]" value="'.(int)$r['id'].'">
                                                                        <input type="hidden" name="kpmr_names[]" value="'.esc($r['nama_risiko']).'">
                                                                      </td>';
                                                                echo '<td class="text-center">
                                                                        <input type="hidden" name="kpmr_mode['.(int)$r['id'].']" value="'.esc($current_metode_perumusan).'">
                                                                        <a href="'.esc(build_url(['mode'=>'detail','jenis'=>'kpmr','id'=>$id_frame,'risk_id'=>(int)$r['id']])).'" class="btn btn-sm btn-success small-btn">Isi Perumusan</a>
                                                                      </td>';
                                                                echo '</tr>';
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="mt-2">
                                                <?php $canOpenKpmrTable = ($headerKpmr && !empty($rows_kpmr)); ?>
                                                <?php if ($canOpenKpmrTable) { ?>
                                                    <a href="<?= esc(build_url(['mode'=>'detail','jenis'=>'kpmr','id'=>$id_frame])) ?>" class="btn btn-sm btn-success small-btn">Isi Perumusan</a>
                                                <?php } else { ?>
                                                    <button type="button" class="btn btn-sm btn-success small-btn open-info-modal" data-title="Notifikasi" data-message="Setting parameter KPMR belum ada atau risiko KPMR dari checklist belum tersedia.">Isi Perumusan</button>
                                                <?php } ?>
                                            </div>
                                            <div class="auto-save-note mt-2">Metode risiko mengikuti dropdown metode perumusan di atas.</div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="row">
                <div class="col-12">
                    <div class="card card-clean">
                        <div class="card-body">
                            <table class="table table-bordered table-clean align-middle">
                                <thead>
                                    <tr>
                                        <th><center>No</center></th>
                                        <th><center>Tahun</center></th>
                                        <th><center>User</center></th>
                                        <th><center>Divisi</center></th>
                                        <th><center>Status</center></th>
                                        <th><center>Tanggal Ditetapkan</center></th>
                                        <th><center>Pembuat</center></th>
                                        <th><center>Aksi</center></th>
                                        <th><center>Isi Setting</center></th>
                                        <th><center>Hapus</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (mysqli_num_rows($listFrame) == 0) {
                                        echo '<tr><td colspan="10" class="text-center text-muted">Belum ada data</td></tr>';
                                    } else {
                                        while ($d = mysqli_fetch_assoc($listFrame)) {
                                            $dKategori = frame_kategori($d);
                                            echo '<tr>';
                                            echo '<td><center>'.$no++.'</center></td>';
                                            echo '<td><center>'.esc($d['tahun']).' - '.esc(kategori_label($dKategori)).'</center></td>';
                                            echo '<td><center>'.esc($d['tipe_user']).'</center></td>';
                                            echo '<td><center>'.esc(get_divisi_label((int)($d['id_divisi_tetapan'] ?? 0), $DIVISI_OPTIONS)).'</center></td>';
                                            echo '<td><center><span class="status-pill '.(((int)($d['is_aktif'] ?? 0)===1)?'active':'inactive').'">'.(((int)($d['is_aktif'] ?? 0)===1)?'Aktif':'Tidak Aktif').'</span></center></td>';
                                            echo '<td><center>'.esc($d['dibuat_at']).'</center></td>'; 
                                            echo '<td><center>SATUAN KERJA MANAJEMEN RISIKO</center></td>';
                                            echo '<td><center>';
                                            if ((int)($d['is_aktif'] ?? 0) === 1) {
                                                echo '<a href="'.esc(build_url(['mode'=>'setting','id'=>(int)$d['id_frame_perumusan'],'nonaktifkan'=>(int)$d['id_frame_perumusan']])).'">nonaktifkan</a>';
                                            } else {
                                                echo '<a href="'.esc(build_url(['mode'=>'setting','id'=>(int)$d['id_frame_perumusan'],'aktifkan'=>(int)$d['id_frame_perumusan']])).'">aktifkan</a>';
                                            }
                                            echo '</center></td>';
                                            echo '<td><center><a class="btn btn-sm btn-primary" href="'.esc(build_url(['mode'=>'setting','id'=>(int)$d['id_frame_perumusan']])).'">Lanjutkan</a></center></td>';
                                            echo '<td><center><a class="btn btn-sm btn-danger" onclick="return confirm(\'Hapus data ini?\')" href="'.esc(build_url(['hapus'=>(int)$d['id_frame_perumusan']])).'">hapus</a></center></td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php } else { ?>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title"><?php echo ($jenis === 'inheren' ? 'Isi Perumusan Inheren Kredit & Likuiditas' : 'Isi Perumusan '.strtoupper($jenis).' Per Pilar'); ?></h4>
                    </div>
                </div>
            </div>

            <?php if (!$frame) { ?>
                <div class="alert alert-warning">Frame perumusan tidak ditemukan.</div>
            <?php } else { ?>
                <div class="card card-clean mb-3">
                    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <span class="info-pill">Tahun: <?= esc($frame['tahun']) ?></span>
                            <span class="info-pill">Kategori: <?= esc(kategori_label($frame['kategori_perumusan'])) ?></span>
                            <span class="info-pill">User: <?= esc($frame['tipe_user']) ?></span>
                        </div>
                        <div>
                            <a href="<?= esc(build_url(['mode'=>'setting','id'=>$id_frame])) ?>" class="btn btn-outline-secondary">Kembali</a>
                        </div>
                    </div>
                </div>

                <?php if (empty($detailBlocks)) { ?>
                    <div class="alert alert-warning">
                        Belum ada risiko <?= esc($jenis) ?> yang dipilih perskalaan/pembobotannya. Kembali ke halaman setting lalu centang dulu.
                    </div>
                <?php } else { ?>
                    <form method="POST" id="detailPerumusanForm">
                        <input type="hidden" name="id_frame" value="<?= (int)$id_frame ?>">
                        <input type="hidden" name="jenis" value="<?= esc($jenis) ?>">
                        <input type="hidden" name="auto_submit_detail" value="1">

                        <?php foreach($detailBlocks as $block){ ?>
                            <?php
                            $hdr = $block['header'];
                            $pilars = $block['pilars'];
                            $totalBobot = 0;
                            foreach($pilars as $p){ $totalBobot += (float)$p['pembobotan']; }
                            $groupId = (int)$hdr[($jenis==='inheren'?'id_perumusan_inheren':'id_perumusan_kpmr')];
                            ?>
                            <div class="per-risk-card">
                                <div class="per-risk-head d-flex justify-content-between align-items-center gap-2">
                                    <div>
                                        <?= esc($hdr['nama_risiko']) ?>
                                        <span class="ms-2 badge bg-light text-dark">Perskalaan: <?= ((int)$hdr['perskalaan']===1?'Ya':'Tidak') ?></span>
                                        <span class="ms-2 badge bg-light text-dark">Pembobotan: <?= ((int)$hdr['pembobotan']===1?'Ya':'Tidak') ?></span>
                                    </div>
                                    <div>
                                        <?php if ((int)$hdr['pembobotan'] === 1) { ?>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary reset-bobot-btn"
                                                    data-group="<?= (int)$groupId ?>">
                                                Reset Bobot
                                            </button>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="per-risk-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered per-risk-table">
                                            <thead>
                                                <tr>
                                                    <th class="w-90">No</th>
                                                    <th>Pilar</th>
                                                    <th class="w-180">Perskalaan</th>
                                                    <th class="w-180">Pembobotan (%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $noP = 1;
                                                foreach($pilars as $p){
                                                    echo '<tr>';
                                                    echo '<td class="text-center">'.($noP++).'</td>';
                                                    echo '<td>'.esc($p['nama_pilar']).'</td>';
                                                    echo '<td>';
                                                    if ((int)$hdr['perskalaan'] === 1) {
                                                        echo '<select class="form-select auto-detail-save" name="perskalaan_metode['.(int)$p['id_detail'].']">';
                                                        echo '<option value="1" '.((int)$p['perskalaan_metode']===1?'selected':'').'>Tertinggi</option>';
                                                        echo '<option value="2" '.((int)$p['perskalaan_metode']===2?'selected':'').'>Terendah</option>';
                                                        echo '<option value="3" '.((int)$p['perskalaan_metode']===3?'selected':'').'>Rata-rata</option>';
                                                        echo '</select>';
                                                    } else {
                                                        echo '<span class="text-muted">-</span>';
                                                        echo '<input type="hidden" name="perskalaan_metode['.(int)$p['id_detail'].']" value="'.(int)$p['perskalaan_metode'].'">';
                                                    }
                                                    echo '</td>';
                                                    echo '<td>';
                                                    if ((int)$hdr['pembobotan'] === 1) {
                                                        echo '<input type="number" step="0.0001" inputmode="decimal" class="form-control bobot-input auto-detail-save bobot-group-'.$groupId.'" name="pembobotan['.(int)$p['id_detail'].']" value="'.esc(format_float_local($p['pembobotan'])).'">';
                                                    } else {
                                                        echo '<span class="text-muted">-</span>';
                                                        echo '<input type="hidden" name="pembobotan['.(int)$p['id_detail'].']" value="'.esc(format_float_local($p['pembobotan'])).'">';
                                                    }
                                                    echo '</td>';
                                                    echo '</tr>';
                                                }
                                                ?>
                                                <tr class="pilar-row-title">
                                                    <td colspan="3" class="text-end">Total Bobot</td>
                                                    <td>
                                                        <span
                                                            class="total-bobot-label <?= ($totalBobot > 100.0000 ? 'total-red':'total-ok') ?>"
                                                            data-group="<?= $groupId ?>">
                                                            <?= esc(format_float_local($totalBobot)) ?>%
                                                        </span>
                                                        <div class="help-soft">Jika lebih dari 100% akan merah.</div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="auto-save-note mt-2">Isi perskalaan dan pembobotan tersimpan otomatis saat diubah.</div>
                    </form>
                <?php } ?>
            <?php } ?>

            <?php } ?>

        </div>
    </div>
</div>

<script>
(function(){
    var tahunKategoriSelect = document.getElementById('tahun_kategori');
    var userSelect = document.getElementById('user_id_select');
    var userHidden = document.getElementById('user_id_hidden');
    var divisiWrap = document.getElementById('divisiWrap');
    var divisiSelect = document.getElementById('id_divisi_tetapan');
    var userLockNote = document.getElementById('user_lock_note');

    function selectedYearKategori(){
        return tahunKategoriSelect ? (tahunKategoriSelect.value || '') : '';
    }

    function currentKategori(){
        var val = selectedYearKategori();
        if (!val) return '';
        var parts = val.split('|');
        return (parts[1] || '').toUpperCase();
    }

    function findCabangOption(){
        if (!userSelect) return null;
        for (var i = 0; i < userSelect.options.length; i++) {
            var opt = userSelect.options[i];
            var txt = (opt.text || '').toLowerCase();
            if (txt.indexOf('kantor cabang') !== -1) {
                return opt;
            }
        }
        return null;
    }

    function syncHiddenUser(){
        if (userSelect && userHidden) {
            userHidden.value = userSelect.value || '';
        }
    }

    function toggleDivisi(){
        if(!userSelect || !divisiWrap) return;
        var kategori = currentKategori();
        if (kategori === 'CABANG') {
            divisiWrap.style.display = 'none';
            if (divisiSelect) divisiSelect.value = '';
            return;
        }

        var txt = userSelect.options[userSelect.selectedIndex] ? userSelect.options[userSelect.selectedIndex].text.toLowerCase() : '';
        if (txt.indexOf('divisi') !== -1) {
            divisiWrap.style.display = '';
        } else {
            divisiWrap.style.display = 'none';
            if(divisiSelect) divisiSelect.value = '';
        }
    }

    function applyKategoriUserLock(){
        if (!tahunKategoriSelect || !userSelect || !userHidden) return;
        var kategori = currentKategori();

        if (kategori === 'CABANG') {
            var cabangOpt = findCabangOption();
            if (cabangOpt) {
                userSelect.value = cabangOpt.value;
                userHidden.value = cabangOpt.value;
            } else {
                userSelect.value = '';
                userHidden.value = '';
            }
            userSelect.setAttribute('disabled', 'disabled');
            if (userLockNote) userLockNote.style.display = '';
            if (divisiWrap) divisiWrap.style.display = 'none';
            if (divisiSelect) divisiSelect.value = '';
        } else {
            userSelect.removeAttribute('disabled');
            syncHiddenUser();
            if (userLockNote) userLockNote.style.display = 'none';
            toggleDivisi();
        }
    }

    if (tahunKategoriSelect) {
        tahunKategoriSelect.addEventListener('change', function(){
            applyKategoriUserLock();
        });
    }

    if (userSelect) {
        userSelect.addEventListener('change', function(){
            syncHiddenUser();
            toggleDivisi();
        });
    }

    applyKategoriUserLock();
    syncHiddenUser();

    function refreshTotals(){
        var labels = document.querySelectorAll('.total-bobot-label');
        labels.forEach(function(label){
            var group = label.getAttribute('data-group');
            var inputs = document.querySelectorAll('.bobot-group-' + group);
            var total = 0;
            inputs.forEach(function(inp){
                var val = parseFloat((inp.value || '0').replace(',', '.'));
                if (!isNaN(val)) total += val;
            });
            total = Math.round(total * 10000) / 10000;
            label.textContent = total.toFixed(4) + '%';
            if (total > 100) {
                label.classList.remove('total-ok');
                label.classList.add('total-red');
            } else {
                label.classList.remove('total-red');
                label.classList.add('total-ok');
            }
        });
    }

    document.querySelectorAll('.bobot-input').forEach(function(inp){
        inp.addEventListener('input', refreshTotals);
    });
    refreshTotals();

    var autoSaveToast = document.getElementById('autoSaveToast');
    if (autoSaveToast) {
        autoSaveToast.style.display = 'none';
    }

    function showAutoToast(msg, ok){
        // notif autosave disembunyikan sesuai permintaan
        return;
    }

    function postFormAjax(formEl, onDone){
        if (!formEl) return;
        var fd = new FormData(formEl);
        fd.append('ajax', '1');

        fetch(window.location.href, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest'},
            body: fd
        })
        .then(function(r){ return r.text(); })
        .then(function(text){
            var res;
            try {
                res = JSON.parse(text);
            } catch (e) {
                // jika response bukan JSON, jangan tampilkan notif merah
                res = {ok:true, silent:true};
            }
            if (typeof onDone === 'function') onDone(res);
        })
        .catch(function(err){
            console.error('Autosave error:', err);
        });
    }

    var riskChoiceForm = document.getElementById('riskChoiceForm');
    document.querySelectorAll('.auto-risk-choice').forEach(function(el){
        el.addEventListener('change', function(){
            postFormAjax(riskChoiceForm);
        });
    });

    var detailForm = document.getElementById('detailPerumusanForm');
    var detailTimer = null;
    function submitDetailFormAjax(){
        postFormAjax(detailForm, function(){ refreshTotals(); });
    }
    function queueDetailAutosave(delay){
        if (detailTimer) clearTimeout(detailTimer);
        detailTimer = setTimeout(submitDetailFormAjax, delay || 350);
    }
    document.querySelectorAll('.auto-detail-save').forEach(function(el){
        el.addEventListener('change', function(){
            queueDetailAutosave(250);
        });
        el.addEventListener('blur', function(){
            queueDetailAutosave(250);
        });
        el.addEventListener('input', function(){
            refreshTotals();
            queueDetailAutosave(500);
        });
    });

    function distributeEvenWeights(inputs){
        var count = inputs.length;
        if (!count) return;
        var base = Math.floor((100 / count) * 10000) / 10000;
        var assigned = 0;
        inputs.forEach(function(inp, idx){
            var val = (idx === count - 1) ? (100 - assigned) : base;
            val = Math.round(val * 10000) / 10000;
            inp.value = val.toFixed(4);
            assigned = Math.round((assigned + val) * 10000) / 10000;
        });
    }

    document.querySelectorAll('.reset-bobot-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            var group = this.getAttribute('data-group');
            var inputs = Array.prototype.slice.call(document.querySelectorAll('.bobot-group-' + group));
            if (!inputs.length) return;
            distributeEvenWeights(inputs);
            refreshTotals();
            queueDetailAutosave(100);
        });
    });

    document.querySelectorAll('.open-info-modal').forEach(function(btn){
        btn.addEventListener('click', function(){
            var title = this.getAttribute('data-title') || 'Notifikasi';
            var message = this.getAttribute('data-message') || '';
            var wrap = document.createElement('div');
            wrap.innerHTML = '' +
                '<div class="modal fade" id="tempInfoModal" tabindex="-1" aria-hidden="true">' +
                '  <div class="modal-dialog modal-dialog-centered">' +
                '    <div class="modal-content">' +
                '      <div class="modal-header bg-warning text-dark">' +
                '        <h5 class="modal-title">' + title + '</h5>' +
                '        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>' +
                '      </div>' +
                '      <div class="modal-body modal-msg-body">' + message + '</div>' +
                '      <div class="modal-footer">' +
                '        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>' +
                '      </div>' +
                '    </div>' +
                '  </div>' +
                '</div>';
            document.body.appendChild(wrap.firstChild);
            var modalEl = document.getElementById('tempInfoModal');
            var modal = new bootstrap.Modal(modalEl);
            modal.show();
            modalEl.addEventListener('hidden.bs.modal', function(){ modalEl.remove(); });
        });
    });

    var autoModal = document.getElementById('modalNotifOtomatis');
    if (autoModal) {
        var bsAutoModal = new bootstrap.Modal(autoModal);
        bsAutoModal.show();
    }
})();
</script>
