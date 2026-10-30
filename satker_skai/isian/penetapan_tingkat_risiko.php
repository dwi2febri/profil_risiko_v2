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

$DIVISI_OPTIONS = [
    132 => 'Divisi Pemasaran',
    133 => 'Divisi Operasional',
    134 => 'Divisi SDM',
    135 => 'Satker Kepatuhan',
    136 => 'Sekretaris Perusahaan',
    137 => 'Divisi Litbang',
    140 => 'Divisi Penyelesaian Kredit',
    143 => 'SKAI',
];

function is_divisi_user_name($txt){
    return strpos(strtolower(trim((string)$txt)), 'divisi') !== false;
}
function get_divisi_label_setris($id, $options){
    $id = (int)$id;
    return ($id > 0 && isset($options[$id])) ? $options[$id] : '-';
}

function is_ajax_request(){
    return (
        (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
        || isset($_POST['ajax'])
    );
}

function q($conn, $sql, $label='SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $err = $label.' ERROR: '.mysqli_error($conn);
        if (is_ajax_request()) {
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok'=>false,'message'=>$err,'sql'=>$sql]);
            exit;
        }
        die('<div style="padding:20px;background:#fff;color:#000;font-family:Arial">'
            .'<h3 style="color:red;margin-bottom:10px;">'.$label.' ERROR</h3>'
            .'<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>'
            .'<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>'
            .'</div>');
    }
    return $res;
}

function fetch_one($conn,$sql,$label='SQL'){
    $res = q($conn,$sql,$label);
    return mysqli_fetch_assoc($res);
}

function json_response($ok, $message = '', $extra = []){
    if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array_merge(['ok'=>$ok ? true : false, 'message'=>$message], $extra));
    exit;
}

function notif($title, $message, $type = 'success'){
    $bg = ($type === 'error') ? 'bg-danger' : (($type === 'warning') ? 'bg-warning' : 'bg-success');
    echo "<script>
        if (typeof $.NotificationApp !== 'undefined') {
            $.NotificationApp.send(" . json_encode($title) . ", " . json_encode($message) . ", 'top-right', '" . $bg . "', 'fa fa-bell');
        }
    </script>";
}

function build_url($params = []){
    $currentPage = isset($_GET['page']) && $_GET['page'] !== '' ? $_GET['page'] : 'setris';
    $base = 'index.php?page=' . urlencode($currentPage);
    if (!empty($params)) $base .= '&' . http_build_query($params);
    return $base;
}

function redirect_to($url){
    header('Location: '.$url);
    exit;
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

function ensure_setris_schema($conn){
    if (!table_exists($conn, 'frame_setting_risiko_ditetapkan')) {
        q($conn, "CREATE TABLE frame_setting_risiko_ditetapkan (
            id_frame_setris_ditetapkan INT AUTO_INCREMENT PRIMARY KEY,
            tahun VARCHAR(10) NOT NULL,
            periode INT DEFAULT 0,
            `user` INT NOT NULL,
            id_divisi_tetapan INT NULL,
            is_aktif TINYINT(1) NOT NULL DEFAULT 0,
            dibuat_by INT DEFAULT 0,
            dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE frame_setting_risiko_ditetapkan');
    } else {
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'tahun')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN tahun VARCHAR(10) NOT NULL AFTER id_frame_setris_ditetapkan", 'ALTER frame tahun');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'periode')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN periode INT DEFAULT 0 AFTER tahun", 'ALTER frame periode');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'user')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN `user` INT NOT NULL AFTER periode", 'ALTER frame user');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'id_divisi_tetapan')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN id_divisi_tetapan INT NULL AFTER `user`", 'ALTER frame id_divisi_tetapan');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'is_aktif')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN is_aktif TINYINT(1) NOT NULL DEFAULT 0 AFTER id_divisi_tetapan", 'ALTER frame is_aktif');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'dibuat_by')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN dibuat_by INT DEFAULT 0 AFTER is_aktif", 'ALTER frame dibuat_by');
        }
        if (!column_exists($conn, 'frame_setting_risiko_ditetapkan', 'dibuat_at')) {
            q($conn, "ALTER TABLE frame_setting_risiko_ditetapkan ADD COLUMN dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER dibuat_by", 'ALTER frame dibuat_at');
        }
    }

    $headerTables = [
        'setting_risiko_inheren_kredit' => 'id_setting_risiko_inheren_kredit',
        'setting_risiko_inheren_likuiditas' => 'id_setting_risiko_inheren_likuiditas',
    ];

    foreach($headerTables as $table => $pk){
        if (!table_exists($conn, $table)) {
            q($conn, "CREATE TABLE `$table` (
                `$pk` INT AUTO_INCREMENT PRIMARY KEY,
                id_frame_setris_ditetapkan INT NOT NULL,
                tahun VARCHAR(10) NOT NULL,
                periode INT DEFAULT 0,
                `user` INT NOT NULL,
                perskalaan TINYINT(1) DEFAULT 1,
                pembobotan TINYINT(1) DEFAULT 0,
                metode_tingkat_risiko TINYINT(1) DEFAULT 1,
                dibuat_by INT DEFAULT 0,
                dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE '.$table);
        } else {
            if (!column_exists($conn, $table, 'perskalaan')) {
                q($conn, "ALTER TABLE `$table` ADD COLUMN perskalaan TINYINT(1) DEFAULT 1 AFTER `user`", 'ALTER '.$table.' perskalaan');
            }
            if (!column_exists($conn, $table, 'pembobotan')) {
                q($conn, "ALTER TABLE `$table` ADD COLUMN pembobotan TINYINT(1) DEFAULT 0 AFTER perskalaan", 'ALTER '.$table.' pembobotan');
            }
            if (!column_exists($conn, $table, 'metode_tingkat_risiko')) {
                q($conn, "ALTER TABLE `$table` ADD COLUMN metode_tingkat_risiko TINYINT(1) DEFAULT 1 AFTER pembobotan", 'ALTER '.$table.' metode_tingkat_risiko');
            }
            if (!column_exists($conn, $table, 'dibuat_at')) {
                q($conn, "ALTER TABLE `$table` ADD COLUMN dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP AFTER dibuat_by", 'ALTER '.$table.' dibuat_at');
            }
        }
    }

    $detailTables = [
        'setting_risiko_inheren_kredit_pilar' => 'id_detail',
        'setting_risiko_inheren_likuiditas_pilar' => 'id_detail',
    ];

    foreach($detailTables as $table => $pk){
        if (!table_exists($conn, $table)) {
            q($conn, "CREATE TABLE `$table` (
                `$pk` INT AUTO_INCREMENT PRIMARY KEY,
                id_header INT NOT NULL,
                id_pilar INT NOT NULL,
                nama_pilar VARCHAR(255) NOT NULL,
                perskalaan_metode TINYINT NULL,
                pembobotan DECIMAL(10,4) DEFAULT 0,
                dibuat_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY uniq_header_pilar (id_header, id_pilar)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", 'CREATE '.$table);
        }
    }
}

function get_available_years($conn){
    $years = [];
    $res = q($conn, "
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
    while($r = mysqli_fetch_assoc($res)){
        $years[] = $r['tahun'];
    }
    return $years;
}

function get_user_options($conn){
    $rows = [];
    $res = q($conn, "SELECT * FROM user_profil_risiko ORDER BY tipe_user ASC", 'LIST users');
    while($r = mysqli_fetch_assoc($res)){
        $rows[] = $r;
    }
    return $rows;
}

function setris_map(){
    return [
        'ik' => [
            'title' => 'Inheren Kredit',
            'header_table' => 'setting_risiko_inheren_kredit',
            'header_pk' => 'id_setting_risiko_inheren_kredit',
            'detail_table' => 'setting_risiko_inheren_kredit_pilar',
            'color' => 'primary',
        ],
        'il' => [
            'title' => 'Inheren Likuiditas',
            'header_table' => 'setting_risiko_inheren_likuiditas',
            'header_pk' => 'id_setting_risiko_inheren_likuiditas',
            'detail_table' => 'setting_risiko_inheren_likuiditas_pilar',
            'color' => 'info',
        ],
    ];
}

function hardcoded_pilars($groupKey){
    $map = [
        'ik' => [
            ['id_pilar'=>1, 'nama_pilar'=>'Pilar 1 | Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit'],
            ['id_pilar'=>2, 'nama_pilar'=>'Pilar 2 | Kualitas Aset'],
            ['id_pilar'=>3, 'nama_pilar'=>'Pilar 3 | Strategi Penyediaan Dana'],
            ['id_pilar'=>4, 'nama_pilar'=>'Pilar 4 | Faktor Eksternal'],
            ['id_pilar'=>5, 'nama_pilar'=>'Pilar 5 | Lainnya'],
        ],
        'il' => [
            ['id_pilar'=>1, 'nama_pilar'=>'Pilar 1 | Komposisi dan Konsentrasi Aset dan Kewajiban'],
            ['id_pilar'=>2, 'nama_pilar'=>'Pilar 2 | Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber'],
            ['id_pilar'=>3, 'nama_pilar'=>'Pilar 3 | Lainnya'],
        ],
    ];
    return isset($map[$groupKey]) ? $map[$groupKey] : [];
}

function ensure_header_rows($conn, $frame_id, $tahun, $user, $dibuat_by){
    $map = setris_map();
    foreach($map as $conf){
        $table = $conf['header_table'];
        $pk = $conf['header_pk'];
        $cek = fetch_one($conn, "SELECT * FROM `$table` WHERE id_frame_setris_ditetapkan='".(int)$frame_id."' LIMIT 1", 'CHECK '.$table);
        if (!$cek){
            q($conn, "
                INSERT INTO `$table`
                (`$pk`, id_frame_setris_ditetapkan, tahun, periode, `user`, perskalaan, pembobotan, metode_tingkat_risiko, dibuat_by, dibuat_at)
                VALUES
                ('0','".(int)$frame_id."','".mysqli_real_escape_string($conn,$tahun)."','0','".(int)$user."','1','0','1','".(int)$dibuat_by."',NOW())
            ", 'INSERT '.$table);
        }
    }
}

function get_header_row_by_group($conn, $groupKey, $frame_id){
    $map = setris_map();
    if (!isset($map[$groupKey])) return null;
    $conf = $map[$groupKey];
    return fetch_one($conn, "SELECT * FROM `{$conf['header_table']}` WHERE id_frame_setris_ditetapkan='".(int)$frame_id."' LIMIT 1", 'GET header '.$groupKey);
}

function sync_detail_rows($conn, $groupKey, $headerRow){
    if (!$headerRow) return;
    $map = setris_map();
    if (!isset($map[$groupKey])) return;
    $conf = $map[$groupKey];
    $headerId = (int)$headerRow[$conf['header_pk']];
    $detailTable = $conf['detail_table'];
    $pilarRows = hardcoded_pilars($groupKey);
    $weights = [];
    $count = count($pilarRows);
    if ($count > 0) {
        $even = floor((100 / $count) * 10000) / 10000;
        $sum = 0;
        for($i=0;$i<$count;$i++){
            $weights[$i] = $even;
            $sum += $even;
        }
        $weights[$count - 1] = round(100 - ($sum - $even), 4);
    }

    foreach($pilarRows as $idx => $p){
        $cek = fetch_one($conn, "
            SELECT *
            FROM `$detailTable`
            WHERE id_header = '$headerId'
              AND id_pilar = '".(int)$p['id_pilar']."'
            LIMIT 1
        ", 'CHECK detail '.$detailTable);
        if (!$cek){
            q($conn, "
                INSERT INTO `$detailTable`
                (id_header, id_pilar, nama_pilar, perskalaan_metode, pembobotan)
                VALUES
                (
                    '$headerId',
                    '".(int)$p['id_pilar']."',
                    '".mysqli_real_escape_string($conn, $p['nama_pilar'])."',
                    1,
                    '".(float)($weights[$idx] ?? 0)."'
                )
            ", 'INSERT detail '.$detailTable);
        }
    }
}

function format_float_local($n){
    return number_format((float)$n, 4, '.', '');
}

ensure_setris_schema($conn);
$setrisMap = setris_map();
$dibuat_by = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$selected_tahun = trim((string)postv('tahun', getv('selected_tahun', '')));
$selected_user = (int)postv('user', getv('selected_user', 0));
$selected_divisi = (int)postv('id_divisi_tetapan', getv('selected_divisi', 0));
$mode = getv('mode', 'setting');
$group = getv('group', '');
if (!in_array($mode, ['setting','detail'])) $mode = 'setting';

if (isset($_POST['submit_setting'])) {
    $tahun = trim((string)postv('tahun'));
    $user = (int)postv('user');
    $id_divisi_tetapan = (int)postv('id_divisi_tetapan');

    if ($tahun === '' || $user <= 0) {
        notif('Gagal', 'Tahun dan jenis profil risiko wajib diisi.', 'error');
    } else {
        $userRow = fetch_one($conn, "SELECT * FROM user_profil_risiko WHERE id_user_profil_risiko='$user' LIMIT 1", 'GET user setris');
        if (!$userRow) {
            notif('Gagal', 'Jenis profil risiko tidak ditemukan.', 'error');
        } else {
            if (!is_divisi_user_name($userRow['tipe_user'] ?? '')) {
                $id_divisi_tetapan = 0;
            } elseif ($id_divisi_tetapan <= 0) {
                notif('Gagal', 'Divisi wajib dipilih untuk Profil Risiko Divisi.', 'error');
                $userRow = null;
            }

            if ($userRow) {
                $whereDiv = $id_divisi_tetapan > 0
                    ? "id_divisi_tetapan = '$id_divisi_tetapan'"
                    : "(id_divisi_tetapan IS NULL OR id_divisi_tetapan = 0)";

                $cek = fetch_one($conn, "
                    SELECT *
                    FROM frame_setting_risiko_ditetapkan
                    WHERE tahun = '".mysqli_real_escape_string($conn, $tahun)."'
                      AND `user` = '$user'
                      AND $whereDiv
                    ORDER BY id_frame_setris_ditetapkan DESC
                    LIMIT 1
                ", 'CHECK frame');

                if ($cek) {
                    redirect_to(build_url(['id'=>$cek['id_frame_setris_ditetapkan']]));
                } else {
                    mysqli_begin_transaction($conn);
                    try {
                        q($conn, "
                            INSERT INTO frame_setting_risiko_ditetapkan
                            (tahun, periode, `user`, id_divisi_tetapan, is_aktif, dibuat_by, dibuat_at)
                            VALUES
                            ('".mysqli_real_escape_string($conn,$tahun)."','0','$user',".($id_divisi_tetapan > 0 ? "'$id_divisi_tetapan'" : "NULL").",'0','$dibuat_by',NOW())
                        ", 'INSERT frame');
                        $newId = mysqli_insert_id($conn);
                        ensure_header_rows($conn, $newId, $tahun, $user, $dibuat_by);
                        foreach(array_keys($setrisMap) as $g){
                            $hdr = get_header_row_by_group($conn, $g, $newId);
                            sync_detail_rows($conn, $g, $hdr);
                        }
                        mysqli_commit($conn);
                        redirect_to(build_url(['id'=>$newId,'ok'=>1]));
                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        notif('Gagal', 'Frame setting gagal dibuat.', 'error');
                    }
                }
            }
        }
    }
}

if (getv('aktifkan','') !== '') {
    $id_aktif = (int)getv('aktifkan');
    $frameAktif = fetch_one($conn, "SELECT * FROM frame_setting_risiko_ditetapkan WHERE id_frame_setris_ditetapkan='$id_aktif' LIMIT 1", 'GET frame aktif');
    if ($frameAktif) {
        mysqli_begin_transaction($conn);
        try {
            $uid = (int)$frameAktif['user'];
            $div = (int)($frameAktif['id_divisi_tetapan'] ?? 0);
            if ($div > 0) {
                q($conn, "UPDATE frame_setting_risiko_ditetapkan SET is_aktif='0' WHERE `user`='$uid' AND id_divisi_tetapan='$div'", 'RESET aktif setris divisi');
            } else {
                q($conn, "UPDATE frame_setting_risiko_ditetapkan SET is_aktif='0' WHERE `user`='$uid' AND (id_divisi_tetapan IS NULL OR id_divisi_tetapan=0)", 'RESET aktif setris');
            }
            q($conn, "UPDATE frame_setting_risiko_ditetapkan SET is_aktif='1' WHERE id_frame_setris_ditetapkan='$id_aktif'", 'SET aktif setris');
            mysqli_commit($conn);
            redirect_to(build_url(['id'=>$id_aktif,'aktif'=>1]));
        } catch (Exception $e) {
            mysqli_rollback($conn);
            notif('Gagal', 'Status aktif gagal diubah.', 'error');
        }
    }
}

if (getv('nonaktifkan','') !== '') {
    $id_non = (int)getv('nonaktifkan');
    q($conn, "UPDATE frame_setting_risiko_ditetapkan SET is_aktif='0' WHERE id_frame_setris_ditetapkan='$id_non'", 'NONAKTIF setris');
    redirect_to(build_url(['id'=>$id_non,'nonaktif'=>1]));
}

if (isset($_POST['auto_submit_risk_choice'])) {
    $id_frame = (int)postv('id_frame');
    $frame = fetch_one($conn, "SELECT * FROM frame_setting_risiko_ditetapkan WHERE id_frame_setris_ditetapkan='$id_frame' LIMIT 1", 'GET frame');
    if (!$frame) json_response(false, 'Frame setting tidak ditemukan.');

    $modeMap = postv('mode_map', []);

    mysqli_begin_transaction($conn);
    try {
        foreach($setrisMap as $g => $conf){
            $headerRow = get_header_row_by_group($conn, $g, $id_frame);
            if (!$headerRow) continue;
            $choice = isset($modeMap[$g]) ? trim((string)$modeMap[$g]) : '';
            $perskalaan = ($choice === 'perskalaan') ? 1 : 0;
            $pembobotan = ($choice === 'pembobotan') ? 1 : 0;
            q($conn, "
                UPDATE `{$conf['header_table']}`
                SET perskalaan = '$perskalaan',
                    pembobotan = '$pembobotan'
                WHERE `{$conf['header_pk']}` = '".(int)$headerRow[$conf['header_pk']]."'
            ", 'UPDATE '.$conf['header_table']);
            sync_detail_rows($conn, $g, $headerRow);
        }
        mysqli_commit($conn);
        json_response(true, 'Checklist setting berhasil disimpan.');
    } catch (Exception $e){
        mysqli_rollback($conn);
        json_response(false, $e->getMessage());
    }
}

if (isset($_POST['auto_submit_detail'])) {
    $id_frame = (int)postv('id_frame');
    $group = trim((string)postv('group'));
    if (!isset($setrisMap[$group])) json_response(false, 'Group setting tidak valid.');
    $conf = $setrisMap[$group];

    $headerRow = get_header_row_by_group($conn, $group, $id_frame);
    if (!$headerRow) json_response(false, 'Header setting tidak ditemukan.');

    $detailTable = $conf['detail_table'];
    $perskalaan_metode = postv('perskalaan_metode', []);
    $pembobotan = postv('pembobotan', []);
    $metode_tingkat_risiko = (int)postv('metode_tingkat_risiko', 1);
    if (!in_array($metode_tingkat_risiko, [1,2,3])) $metode_tingkat_risiko = 1;

    mysqli_begin_transaction($conn);
    try {
        foreach($perskalaan_metode as $id_detail => $metode){
            $id_detail = (int)$id_detail;
            $metode = (int)$metode;
            if (!in_array($metode, [1,2,3])) $metode = 1;
            $bobot = isset($pembobotan[$id_detail]) ? (float)str_replace(',', '.', $pembobotan[$id_detail]) : 0;
            q($conn, "
                UPDATE `$detailTable`
                SET perskalaan_metode = '$metode',
                    pembobotan = '$bobot'
                WHERE id_detail = '$id_detail'
            ", 'UPDATE '.$detailTable);
        }
        q($conn, "
            UPDATE `{$conf['header_table']}`
            SET metode_tingkat_risiko = '$metode_tingkat_risiko'
            WHERE `{$conf['header_pk']}` = '".(int)$headerRow[$conf['header_pk']]."'
        ", 'UPDATE header metode');
        mysqli_commit($conn);
        json_response(true, 'Detail setting berhasil disimpan.');
    } catch (Exception $e){
        mysqli_rollback($conn);
        json_response(false, $e->getMessage());
    }
}

if (getv('hapus') != '') {
    $id_hapus = (int)getv('hapus');
    mysqli_begin_transaction($conn);
    try {
        foreach($setrisMap as $conf){
            $headerRow = fetch_one($conn, "SELECT * FROM `{$conf['header_table']}` WHERE id_frame_setris_ditetapkan='$id_hapus' LIMIT 1", 'GET header delete');
            if ($headerRow){
                $headerId = (int)$headerRow[$conf['header_pk']];
                q($conn, "DELETE FROM `{$conf['detail_table']}` WHERE id_header='$headerId'", 'DELETE '.$conf['detail_table']);
            }
            q($conn, "DELETE FROM `{$conf['header_table']}` WHERE id_frame_setris_ditetapkan='$id_hapus'", 'DELETE '.$conf['header_table']);
        }
        q($conn, "DELETE FROM frame_setting_risiko_ditetapkan WHERE id_frame_setris_ditetapkan='$id_hapus'", 'DELETE frame');
        mysqli_commit($conn);
        redirect_to(build_url(['del'=>1]));
    } catch (Exception $e) {
        mysqli_rollback($conn);
        notif('Gagal', 'Data setting gagal dihapus.', 'error');
    }
}

$availableYears = get_available_years($conn);
$userRows = get_user_options($conn);

$id_frame = (int)getv('id');
$frame = null;
$cards = [];
$detailBlock = null;

if ($id_frame > 0){
    $frame = fetch_one($conn, "
        SELECT f.*, upr.tipe_user, u.nama
        FROM frame_setting_risiko_ditetapkan f
        LEFT JOIN user_profil_risiko upr ON f.`user` = upr.id_user_profil_risiko
        LEFT JOIN user u ON f.dibuat_by = u.user_id
        WHERE f.id_frame_setris_ditetapkan = '$id_frame'
        LIMIT 1
    ", 'LOAD frame');
    if ($frame){
        foreach($setrisMap as $g => $conf){
            $headerRow = get_header_row_by_group($conn, $g, $id_frame);
            if ($headerRow) sync_detail_rows($conn, $g, $headerRow);
            $headerRow = get_header_row_by_group($conn, $g, $id_frame);
            $cards[$g] = [
                'conf' => $conf,
                'header' => $headerRow,
                'pilars' => hardcoded_pilars($g),
            ];
        }

        if ($mode === 'detail' && isset($setrisMap[$group])) {
            $conf = $setrisMap[$group];
            $headerRow = get_header_row_by_group($conn, $group, $id_frame);
            if ($headerRow) {
                sync_detail_rows($conn, $group, $headerRow);
                $detailRows = [];
                $res = q($conn, "
                    SELECT *
                    FROM `{$conf['detail_table']}`
                    WHERE id_header = '".(int)$headerRow[$conf['header_pk']]."'
                    ORDER BY id_pilar ASC
                ", 'LIST detail');
                while($r = mysqli_fetch_assoc($res)) $detailRows[] = $r;
                $detailBlock = [
                    'conf' => $conf,
                    'header' => $headerRow,
                    'rows' => $detailRows,
                ];
            }
        }
    }
}

$listRows = [];
$listRes = q($conn, "
    SELECT f.*, upr.tipe_user, u.nama
    FROM frame_setting_risiko_ditetapkan f
    LEFT JOIN user_profil_risiko upr ON f.`user` = upr.id_user_profil_risiko
    LEFT JOIN user u ON f.dibuat_by = u.user_id
    ORDER BY CAST(f.tahun AS UNSIGNED) DESC, upr.tipe_user ASC, f.id_divisi_tetapan ASC, f.id_frame_setris_ditetapkan DESC
", 'LIST frame');
while($lr = mysqli_fetch_assoc($listRes)){
    $lr['nama_divisi_tetapan'] = get_divisi_label_setris((int)($lr['id_divisi_tetapan'] ?? 0), $DIVISI_OPTIONS);
    $listRows[] = $lr;
}
if (empty($listRows) && !empty($frame)) {
    $listRows[] = $frame;
}
?>
<style>
body{background:#f5f6fa}
.card-clean{border:0;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,.05)}
.table-clean thead th{background:#eef2f7!important;color:#334155;font-weight:700;border-color:#e5e7eb!important}
.table-clean td{vertical-align:middle}
.perumusan-box{border:1px solid #e5e7eb;border-radius:12px;padding:14px;background:#fff;height:100%}
.info-pill{display:inline-block;padding:.4rem .8rem;border-radius:999px;background:#f1f5f9;color:#0f172a;font-weight:600;margin-right:.35rem;margin-bottom:.35rem}
.auto-save-note{font-size:12px;color:#64748b;font-style:italic}
.per-risk-card{border:1px solid #e5e7eb;border-radius:12px;margin-bottom:16px;overflow:hidden;background:#fff}
.per-risk-head{padding:12px 16px;border-bottom:1px solid #e5e7eb;font-weight:700}
.per-risk-table{margin-bottom:0}
.per-risk-table thead th{background:#d9f0f7!important;color:#334155!important;border-color:#d0e7ef!important}
.pilar-row-title{background:#ecfeff!important;font-weight:700}
.total-red{color:#dc2626;font-weight:800}
.total-ok{color:#16a34a;font-weight:800}
.auto-save-toast{position:fixed;right:18px;bottom:18px;z-index:2000;background:#0f172a;color:#fff;padding:10px 14px;border-radius:10px;box-shadow:0 10px 25px rgba(0,0,0,.18);font-size:13px;display:none;max-width:420px}
.auto-save-toast.show{display:block}
.auto-save-toast.ok{background:#16a34a}
.auto-save-toast.err{background:#dc2626}
.status-pill{display:inline-block;padding:.3rem .7rem;border-radius:999px;font-weight:700;font-size:12px}
.status-pill.active{background:#dcfce7;color:#166534}
.status-pill.inactive{background:#fee2e2;color:#991b1b}
</style>

<div class="content-page"><div class="content"><div class="container-fluid">
<?php
if (isset($_GET['ok'])) notif('Berhasil', 'Setting siap digunakan.');
if (isset($_GET['del'])) notif('Berhasil', 'Data setting berhasil dihapus.', 'warning');
if (isset($_GET['aktif'])) notif('Berhasil', 'Status setting diaktifkan.');
if (isset($_GET['nonaktif'])) notif('Berhasil', 'Status setting dinonaktifkan.', 'warning');
?>
<div id="autoSaveToast" class="auto-save-toast"></div>

<?php if ($mode === 'setting') { ?>
<div class="row"><div class="col-12"><div class="page-title-box"><h4 class="page-title">Setting Tingkat Risiko Yang Ditetapkan</h4></div></div></div>

<div class="row"><div class="col-12"><div class="card card-clean mb-3"><div class="card-body">
<form method="POST">
    <div class="row">
        <div class="col-md-4">
            <label class="form-label">Masukan tahun</label>
            <select class="form-select" name="tahun" required>
                <option value="">-- pilih tahun --</option>
                <?php foreach($availableYears as $th){ ?>
                    <option value="<?= esc($th) ?>" <?= ($selected_tahun === (string)$th ? 'selected' : '') ?>><?= esc($th) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Settingan ditetapkan untuk user :</label>
            <select class="form-select" name="user" id="user_setris" required>
                <option value="">-- pilih user --</option>
                <?php foreach($userRows as $u){ ?>
                    <option value="<?= (int)$u['id_user_profil_risiko'] ?>" <?= ($selected_user === (int)$u['id_user_profil_risiko'] ? 'selected' : '') ?>><?= esc($u['tipe_user']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-4" id="divisiWrapSetris" style="display:none;">
            <label class="form-label">Pilih divisi</label>
            <select class="form-select" name="id_divisi_tetapan" id="id_divisi_tetapan">
                <option value="">-- pilih divisi --</option>
                <?php foreach($DIVISI_OPTIONS as $divId => $divNama){ ?>
                    <option value="<?= (int)$divId ?>" <?= ($selected_divisi === (int)$divId ? 'selected' : '') ?>><?= esc($divNama) ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="mt-3"><button class="btn btn-primary" type="submit" name="submit_setting">Submit</button></div>
</form>
</div></div></div></div>

<?php if ($frame) { ?>
<div class="row mb-3"><div class="col-12"><div class="card card-clean"><div class="card-body">
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div>
        <div style="font-size:12px;color:#8b96a5;text-transform:uppercase;font-weight:700;">Frame Setting Aktif</div>
        <h4 class="mb-1">Tahun <?= esc($frame['tahun']) ?> - <?= esc($frame['tipe_user']) ?></h4>
        <div>
            <?php if (!empty($frame['nama_divisi_tetapan']) && $frame['nama_divisi_tetapan'] !== '-') { ?>
                <span class="info-pill">Divisi: <?= esc($frame['nama_divisi_tetapan']) ?></span>
            <?php } ?>
            <span class="info-pill">Inheren Kredit: Siap</span>
            <span class="info-pill">Inheren Likuiditas: Siap</span>
            <span class="status-pill <?= ((int)$frame['is_aktif']===1?'active':'inactive') ?>"><?= ((int)$frame['is_aktif']===1?'Aktif':'Tidak Aktif') ?></span>
        </div>
    </div>
    <div>
        <?php if ((int)$frame['is_aktif']===1) { ?>
            <a href="<?= esc(build_url(['id'=>$id_frame,'nonaktifkan'=>$id_frame])) ?>" class="btn btn-warning btn-sm" onclick="return confirm('Nonaktifkan setting ini?')">Nonaktifkan</a>
        <?php } else { ?>
            <a href="<?= esc(build_url(['id'=>$id_frame,'aktifkan'=>$id_frame])) ?>" class="btn btn-success btn-sm" onclick="return confirm('Aktifkan setting ini? Setting aktif lain untuk user yang sama akan otomatis nonaktif.')">Aktifkan</a>
        <?php } ?>
    </div>
</div>

<form method="POST" class="mt-3" id="riskChoiceForm">
    <input type="hidden" name="auto_submit_risk_choice" value="1">
    <input type="hidden" name="id_frame" value="<?= (int)$id_frame ?>">

    <div class="row">
        <?php foreach($cards as $g => $card){ $existing = $card['header']; $selectedMode = ((int)($existing['perskalaan'] ?? 0)===1) ? 'perskalaan' : ((((int)($existing['pembobotan'] ?? 0)===1) ? 'pembobotan' : '')); ?>
        <div class="col-md-6 mb-3">
            <div class="perumusan-box">
                <h5><?= esc($card['conf']['title']) ?></h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-clean align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Jenis Risiko</th>
                                <th class="text-center">Perskalaan</th>
                                <th class="text-center">Pembobotan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td><?= esc($card['conf']['title']) ?></td>
                                <td class="text-center"><input class="auto-risk-choice" type="radio" name="mode_map[<?= esc($g) ?>]" value="perskalaan" <?= ($selectedMode==='perskalaan'?'checked':'') ?>></td>
                                <td class="text-center"><input class="auto-risk-choice" type="radio" name="mode_map[<?= esc($g) ?>]" value="pembobotan" <?= ($selectedMode==='pembobotan'?'checked':'') ?>></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <a href="<?= esc(build_url(['mode'=>'detail','group'=>$g,'id'=>$id_frame])) ?>" class="btn btn-sm btn-primary">Isi Setting</a>
                </div>
                <div class="auto-save-note mt-2">Checklist tersimpan otomatis saat dipilih.</div>
            </div>
        </div>
        <?php } ?>
    </div>
</form>
</div></div></div></div>
<?php } ?>

<div class="row"><div class="col-12"><div class="card card-clean"><div class="card-body"><div class="tab-content"><div class="tab-pane show active">
<table id="row-callback-datatable" class="table dt-responsive w-100 nowrap">
    <thead class="table-secondary">
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
            <th><center>hapus</center></th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($listRows)) { ?>
        <tr>
            <td colspan="10" class="text-center text-muted">Belum ada data setting.</td>
        </tr>
        <?php } else { $no=1; foreach($listRows as $row){ ?>
        <tr>
            <td><center><?= $no++ ?></center></td>
            <td><center><?= esc($row['tahun']) ?></center></td>
            <td><center><?= esc($row['tipe_user']) ?></center></td>
            <td><center><?= esc($row['nama_divisi_tetapan'] ?? '-') ?></center></td>
            <td><center><span class="status-pill <?= ((int)$row['is_aktif']===1?'active':'inactive') ?>"><?= ((int)$row['is_aktif']===1?'Aktif':'Tidak Aktif') ?></span></center></td>
            <td><center><?= esc($row['dibuat_at']) ?></center></td>
            <td><center><?= strtoupper((string)$row['nama']) ?></center></td>
            <td><center>
                <?php if ((int)$row['is_aktif']===1) { ?>
                    <a href="<?= esc(build_url(['nonaktifkan'=>$row['id_frame_setris_ditetapkan']])) ?>">nonaktifkan</a>
                <?php } else { ?>
                    <a href="<?= esc(build_url(['aktifkan'=>$row['id_frame_setris_ditetapkan']])) ?>">aktifkan</a>
                <?php } ?>
            </center></td>
            <td><center><a href="<?= esc(build_url(['id'=>$row['id_frame_setris_ditetapkan']])) ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a></center></td>
            <td class="table-action"><center><a href="<?= esc(build_url(['hapus'=>$row['id_frame_setris_ditetapkan']])) ?>" onclick="return confirm('Yakin hapus setting ini?')"><i class="mdi mdi-delete"></i>hapus</a></center></td>
        </tr>
        <?php }} ?>
    </tbody>
</table>
</div></div></div></div></div></div>

<?php } else { ?>
<div class="row"><div class="col-12"><div class="page-title-box"><h4 class="page-title">Setting Tingkat Risiko Yang Ditetapkan - <?= esc($detailBlock ? $detailBlock['conf']['title'] : '') ?></h4></div></div></div>

<div class="row mb-3"><div class="col-12"><div class="card card-clean"><div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div><a href="<?= esc(build_url(['id'=>$id_frame])) ?>" class="btn btn-secondary btn-sm">← Kembali</a></div>
    <div>
        <?php if ($frame) { ?>
            <span class="badge bg-light text-dark">Tahun: <?= esc($frame['tahun']) ?></span>
            <span class="badge bg-info text-dark"><?= esc($frame['tipe_user']) ?></span>
            <span class="status-pill <?= ((int)$frame['is_aktif']===1?'active':'inactive') ?>"><?= ((int)$frame['is_aktif']===1?'Aktif':'Tidak Aktif') ?></span>
        <?php } ?>
    </div>
</div></div></div></div>

<?php if (!$detailBlock) { ?>
    <div class="alert alert-warning">Detail setting tidak ditemukan.</div>
<?php } else { 
    $header = $detailBlock['header'];
    $isPerskalaan = ((int)$header['perskalaan'] === 1);
    ?>
    <div class="per-risk-card">
        <div class="per-risk-head bg-<?= esc($detailBlock['conf']['color']) ?> text-white"><?= esc($detailBlock['conf']['title']) ?></div>
        <div class="per-risk-body">
            <form method="POST" id="detailSetrisForm">
                <input type="hidden" name="auto_submit_detail" value="1">
                <input type="hidden" name="id_frame" value="<?= (int)$id_frame ?>">
                <input type="hidden" name="group" value="<?= esc($group) ?>">

                <div class="table-responsive">
                    <table class="table table-bordered table-clean per-risk-table">
                        <thead>
                            <tr>
                                <th style="width:50px;">No</th>
                                <th>Risiko Inhern (Per Pilar)</th>
                                <th class="text-center" style="width:220px;">Risiko yang Ditetapkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach($detailBlock['rows'] as $row){
                                echo '<tr>';
                                echo '<td class="text-center">'.($no++).'</td>';
                                echo '<td>'.esc($row['nama_pilar']).'</td>';

                                if ($isPerskalaan) {
                                    echo '<td class="text-center">';
                                    echo '<select class="form-select auto-detail-save w-100" name="perskalaan_metode['.(int)$row['id_detail'].']">';
                                    echo '<option value="1" '.((int)$row['perskalaan_metode']===1?'selected':'').'>Tertinggi</option>';
                                    echo '<option value="2" '.((int)$row['perskalaan_metode']===2?'selected':'').'>Terendah</option>';
                                    echo '<option value="3" '.((int)$row['perskalaan_metode']===3?'selected':'').'>Rata-rata</option>';
                                    echo '</select>';
                                    echo '<input type="hidden" name="pembobotan['.(int)$row['id_detail'].']" value="'.esc(format_float_local($row['pembobotan'])).'">';
                                    echo '</td>';
                                } else {
                                    echo '<td>';
                                    echo '<input type="hidden" name="perskalaan_metode['.(int)$row['id_detail'].']" value="'.(int)$row['perskalaan_metode'].'">';
                                    echo '<input type="number" step="0.0001" class="form-control auto-detail-save bobot-input" name="pembobotan['.(int)$row['id_detail'].']" value="'.esc(format_float_local($row['pembobotan'])).'">';
                                    echo '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                            <tr class="pilar-row-title">
                                <td colspan="2"><b>Tingkat Risiko</b></td>
                                <td>
                                    <?php if ($isPerskalaan) { ?>
                                        <select class="form-select auto-detail-save" name="metode_tingkat_risiko">
                                            <option value="1" <?= ((int)$header['metode_tingkat_risiko']===1?'selected':'') ?>>Tertinggi</option>
                                            <option value="2" <?= ((int)$header['metode_tingkat_risiko']===2?'selected':'') ?>>Terendah</option>
                                            <option value="3" <?= ((int)$header['metode_tingkat_risiko']===3?'selected':'') ?>>Rata-rata</option>
                                        </select>
                                    <?php } else { ?>
                                        <span class="text-muted">Menggunakan pembobotan</span>
                                        <input type="hidden" name="metode_tingkat_risiko" value="<?= (int)$header['metode_tingkat_risiko'] ?>">
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php if (!$isPerskalaan) { ?>
                            <tr class="pilar-row-title">
                                <td colspan="2" class="text-end"><b>Total Bobot</b></td>
                                <td>
                                    <?php
                                    $sum = 0;
                                    foreach($detailBlock['rows'] as $row){ $sum += (float)$row['pembobotan']; }
                                    $cls = ($sum > 100.0001) ? 'total-red' : 'total-ok';
                                    ?>
                                    <span id="totalBobotBox" class="<?= $cls ?>"><?= number_format($sum, 4, '.', '') ?>%</span>
                                    <span class="ms-2 text-muted" style="font-size:12px;">Jika lebih dari 100 akan merah.</span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-3 auto-save-note">Perubahan tersimpan otomatis saat diubah.</div>
            </form>
        </div>
    </div>
<?php } ?>
<?php } ?>

</div></div></div>

<script>
(function(){
    function toast(msg, ok){
        var el = document.getElementById('autoSaveToast');
        if (!el) return;
        el.textContent = msg || '';
        el.className = 'auto-save-toast show ' + (ok ? 'ok' : 'err');
        clearTimeout(el._timer);
        el._timer = setTimeout(function(){ el.className = 'auto-save-toast'; }, 1800);
    }

    function postFormAjax(form){
        if (!form) return;
        var fd = new FormData(form);
        fd.append('ajax', '1');
        fetch(window.location.href, {
            method: 'POST',
            body: fd,
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function(r){ return r.json(); })
          .then(function(res){
              if (res.ok) {
                  toast(res.message || 'Tersimpan', true);
              } else {
                  toast(res.message || 'Gagal menyimpan', false);
              }
          }).catch(function(err){
              toast(res.message || 'Tersimpan', true);
              console.error(err);
          });
    }

    var userSetris = document.getElementById('user_setris');
    var divisiWrapSetris = document.getElementById('divisiWrapSetris');
    var divisiSelectSetris = document.getElementById('id_divisi_tetapan');

    function toggleDivisiSetris() {
        if (!userSetris || !divisiWrapSetris) return;
        var txt = '';
        if (userSetris.selectedIndex >= 0) {
            txt = (userSetris.options[userSetris.selectedIndex].text || '').toLowerCase();
        }
        if (txt.indexOf('divisi') !== -1) {
            divisiWrapSetris.style.display = '';
        } else {
            divisiWrapSetris.style.display = 'none';
            if (divisiSelectSetris) divisiSelectSetris.value = '';
        }
    }

    if (userSetris) {
        userSetris.addEventListener('change', toggleDivisiSetris);
        toggleDivisiSetris();
    }

    var riskChoiceForm = document.getElementById('riskChoiceForm');
    if (riskChoiceForm) {
        document.querySelectorAll('.auto-risk-choice').forEach(function(el){
            el.addEventListener('change', function(){ postFormAjax(riskChoiceForm); });
        });
    }

    var detailForm = document.getElementById('detailSetrisForm');
    var timer = null;

    function refreshTotal(){
        var box = document.getElementById('totalBobotBox');
        if (!box) return;
        var total = 0;
        document.querySelectorAll('#detailSetrisForm .bobot-input').forEach(function(el){ total += parseFloat(el.value || 0); });
        box.textContent = total.toFixed(4) + '%';
        box.className = (total > 100.0001 ? 'total-red' : 'total-ok');
    }

    if (detailForm) {
        document.querySelectorAll('.auto-detail-save').forEach(function(el){
            el.addEventListener('change', function(){
                refreshTotal();
                if (timer) clearTimeout(timer);
                timer = setTimeout(function(){ postFormAjax(detailForm); }, 250);
            });
            el.addEventListener('input', function(){
                refreshTotal();
                if (timer) clearTimeout(timer);
                timer = setTimeout(function(){ postFormAjax(detailForm); }, 350);
            });
        });
        refreshTotal();
    }
})();
</script>
