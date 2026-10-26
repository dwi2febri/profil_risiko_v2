<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../conn/conn.php";
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) { session_start(); }

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$displayModal = ($id <= 0);

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function dbq($conn, $sql, $label='SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die('<div style="padding:20px;background:#fff;color:#000;font-family:Arial"><h3 style="color:red">'.esc($label).' ERROR</h3><pre>'.esc(mysqli_error($conn)).'</pre><hr><pre>'.esc($sql).'</pre></div>');
    }
    return $res;
}
function dbone($conn, $sql, $label='SQL'){
    $res = dbq($conn, $sql, $label);
    return mysqli_fetch_assoc($res) ?: [];
}
function table_exists2($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}
function col_exists2($conn, $table, $column){
    if (!table_exists2($conn, $table)) return false;
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}
function ensure_row2($conn, $table, $id){
    if (!table_exists2($conn, $table) || !col_exists2($conn, $table, 'id_profil_risiko')) return;
    $id = (int)$id;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM `$table` WHERE id_profil_risiko='$id' LIMIT 1");
    if (!$cek || mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO `$table` (id_profil_risiko) VALUES ('$id')");
    }
}
function update_dynamic2($conn, $table, $id, $data){
    if (!table_exists2($conn, $table)) return;
    ensure_row2($conn, $table, $id);
    $sets = [];
    foreach ($data as $col => $val) {
        if (!col_exists2($conn, $table, $col)) continue;
        $sets[] = "`$col`='".mysqli_real_escape_string($conn, (string)$val)."'";
    }
    if (!$sets) return;
    dbq($conn, "UPDATE `$table` SET ".implode(',', $sets)." WHERE id_profil_risiko='".(int)$id."'", "UPDATE $table");
}
function nilai_label($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}
function kpmr_label($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Memadai';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Memadai';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Cukup Memadai';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Kurang Memadai';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function kualitas_mr_matrix_ojk($inherenRank, $kpmrRank){
    // Matriks Penetapan Tingkat Risiko OJK:
    // baris = Risiko Inheren, kolom = Tingkat Kualitas Manajemen Risiko / KPMR.
    // Dipakai untuk seluruh profil risiko dan profil nilai komposit.
    $m = [
        'Sangat Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Cukup Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Kurang Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Tidak Memadai' => 'Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',

        'Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Rendah|Memadai' => 'Risiko Rendah',
        'Rendah|Cukup Memadai' => 'Risiko Rendah',
        'Rendah|Kurang Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Rendah|Tidak Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',

        'Sedang|Sangat Memadai' => 'Risiko Rendah',
        'Sedang|Memadai' => 'Risiko Rendah',
        'Sedang|Cukup Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Sedang|Kurang Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sedang|Tidak Memadai' => 'Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',

        'Tinggi|Sangat Memadai' => 'Risiko Rendah',
        'Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Kurang Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Tidak Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',

        'Sangat Tinggi|Sangat Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sangat Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Kurang Memadai' => 'Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Tidak Memadai' => 'Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam)',
    ];
    $key = trim((string)$inherenRank) . '|' . trim((string)$kpmrRank);
    return isset($m[$key]) ? $m[$key] : '';
}

function n2($v){ return number_format((float)$v, 2, '.', ''); }
function get_active_bobot($conn, $tahun_frame, $user_profil = 0){
    $default = [
        'kredit' => 30.00,
        'operasional' => 30.00,
        'kepatuhan' => 20.00,
        'likuiditas' => 10.00,
        'reputasi' => 5.00,
        'stratejik' => 5.00,
    ];

    $info = [
        'tahun' => $tahun_frame,
        'aktif' => false,
        'total' => 100.00,
        'bobot' => $default,
        'id_setting' => 0,
        'user' => (int)$user_profil,
        'source' => 'default'
    ];

    if (!table_exists2($conn, 'setting_bobot_profil_risiko') || !table_exists2($conn, 'setting_bobot_profil_risiko_detail')) {
        return $info;
    }

    $tahun = mysqli_real_escape_string($conn, (string)$tahun_frame);
    $userProfil = (int)$user_profil;

    // FIX: Profil Nilai harus memakai bobot sesuai settingan user profil risiko yang sedang dibuka.
    // Sebelumnya query hanya mengambil setting aktif global, sehingga untuk user=3 (Profil Risiko Kantor Cabang)
    // bisa salah mengambil bobot milik SKMR/user lain.
    $userCol = '';
    foreach (['user','user_id','id_user_profil_risiko','id_user'] as $c) {
        if (col_exists2($conn, 'setting_bobot_profil_risiko', $c)) { $userCol = $c; break; }
    }

    $aktifCol = '';
    foreach (['is_aktif','is_active','aktif'] as $c) {
        if (col_exists2($conn, 'setting_bobot_profil_risiko', $c)) { $aktifCol = $c; break; }
    }

    $idCol = 'id_setting';
    if (!col_exists2($conn, 'setting_bobot_profil_risiko', $idCol)) {
        foreach (['id','id_bobot_profil','id_frame_bobot_profil'] as $c) {
            if (col_exists2($conn, 'setting_bobot_profil_risiko', $c)) { $idCol = $c; break; }
        }
    }

    $order = "ORDER BY `$idCol` DESC LIMIT 1";
    $head = [];

    // 1) Prioritas utama: tahun + user yang sama + aktif.
    if ($userCol !== '' && $userProfil > 0 && $aktifCol !== '') {
        $head = dbone($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$userCol` = '$userProfil'
              AND `$aktifCol` = '1'
            $order
        ", 'READ BOBOT AKTIF TAHUN USER');
    }

    // 2) Fallback: tahun + user yang sama, walaupun belum aktif.
    if (!$head && $userCol !== '' && $userProfil > 0) {
        $head = dbone($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$userCol` = '$userProfil'
            $order
        ", 'READ BOBOT TAHUN USER');
    }

    // 3) Fallback lama: aktif global pada tahun yang sama.
    if (!$head && $aktifCol !== '') {
        $head = dbone($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
              AND `$aktifCol` = '1'
            $order
        ", 'READ BOBOT AKTIF TAHUN GLOBAL');
    }

    // 4) Fallback lama: setting tahun terakhir.
    if (!$head) {
        $head = dbone($conn, "
            SELECT *
            FROM setting_bobot_profil_risiko
            WHERE tahun = '$tahun'
            $order
        ", 'READ BOBOT TAHUN GLOBAL');
    }

    if (!$head) return $info;

    $idSetting = (int)($head[$idCol] ?? 0);
    if ($idSetting <= 0) return $info;

    $map = $default;

    $detailFk = 'id_setting';
    if (!col_exists2($conn, 'setting_bobot_profil_risiko_detail', $detailFk)) {
        foreach (['setting_id','id_bobot_profil','id_frame_bobot_profil'] as $c) {
            if (col_exists2($conn, 'setting_bobot_profil_risiko_detail', $c)) { $detailFk = $c; break; }
        }
    }

    $jenisCol = 'jenis_risiko';
    foreach (['jenis_risiko','nama_risiko','risiko'] as $c) {
        if (col_exists2($conn, 'setting_bobot_profil_risiko_detail', $c)) { $jenisCol = $c; break; }
    }

    $bobotCol = 'bobot';
    foreach (['bobot','bobot_penetapan','bobot_penetapan_persen','bobot_persen','nilai_bobot'] as $c) {
        if (col_exists2($conn, 'setting_bobot_profil_risiko_detail', $c)) { $bobotCol = $c; break; }
    }

    $q = dbq($conn, "
        SELECT *
        FROM setting_bobot_profil_risiko_detail
        WHERE `$detailFk` = '$idSetting'
        ORDER BY ".(col_exists2($conn, 'setting_bobot_profil_risiko_detail', 'urutan') ? 'urutan ASC,' : '')." id_detail ASC
    ", 'READ DETAIL BOBOT PROFIL USER');

    while($r = mysqli_fetch_assoc($q)){
        $nama = strtolower(trim((string)($r[$jenisCol] ?? '')));
        $key = '';
        if (strpos($nama, 'kredit') !== false) $key = 'kredit';
        elseif (strpos($nama, 'operasional') !== false) $key = 'operasional';
        elseif (strpos($nama, 'kepatuhan') !== false) $key = 'kepatuhan';
        elseif (strpos($nama, 'likuiditas') !== false) $key = 'likuiditas';
        elseif (strpos($nama, 'reputasi') !== false) $key = 'reputasi';
        elseif (strpos($nama, 'stratejik') !== false || strpos($nama, 'strategik') !== false) $key = 'stratejik';
        if ($key !== '') $map[$key] = (float)str_replace(',', '.', (string)($r[$bobotCol] ?? 0));
    }

    $info['tahun'] = $head['tahun'] ?? $tahun_frame;
    $info['aktif'] = ($aktifCol !== '' && (int)($head[$aktifCol] ?? 0) === 1);
    $info['total'] = array_sum($map);
    $info['bobot'] = $map;
    $info['id_setting'] = $idSetting;
    $info['user'] = ($userCol !== '') ? (int)($head[$userCol] ?? 0) : 0;
    $info['source'] = 'setting_bobot_profil_risiko';
    return $info;
}

function get_row_safe($conn, $table, $id){
    if (!table_exists2($conn, $table)) return [];
    return dbone($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1", "READ $table");
}

function prof_pick_result_from_row($row, $jenis='inheren'){
    $out = ['nilai'=>0.00, 'peringkat'=>''];
    if (!$row || !is_array($row)) return $out;

    $nilaiKeys = [
        'hasil_tingkat_risiko','tingkat_risiko','hasil_kpmr','hasil_penilaian_kpmr',
        'nilai_kpmr','total_nilai','hasil_rata_rata','rata_rata','nilai','hasil'
    ];
    foreach($nilaiKeys as $k){
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $v = (float)str_replace(',', '.', (string)$row[$k]);
            if ($v > 0) { $out['nilai'] = round($v, 2); break; }
            if ($out['nilai'] == 0) $out['nilai'] = round($v, 2);
        }
    }

    $rankKeys = ['hasil_peringkat','peringkat','predikat','hasil_predikat','ket_tingkat_risiko'];
    foreach($rankKeys as $k){
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $out['peringkat'] = trim((string)$row[$k]);
            break;
        }
    }

    if ($out['peringkat'] === '') {
        $out['peringkat'] = ($jenis === 'kpmr') ? kpmr_label($out['nilai']) : nilai_label($out['nilai']);
    }

    return $out;
}

function prof_read_result_direct($conn, $id, $riskKey, $table, $jenis='inheren'){
    $id = (int)$id;
    $best = ['nilai'=>0.00, 'peringkat'=>''];
    if ($id <= 0) return $best;

    // Sumber utama: tabel hasil_* yang di-update langsung oleh halaman Inheren/KPMR masing-masing risiko.
    if (table_exists2($conn, $table)) {
        $row = dbone($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='$id' LIMIT 1", "READ $table");
        $p = prof_pick_result_from_row($row, $jenis);
        if ((float)$p['nilai'] > 0 || trim((string)$p['peringkat']) !== '') return $p;
    }

    // Fallback model dinamis: assessment_inheren / assessment_kpmr.
    $assessmentTable = ($jenis === 'kpmr') ? 'assessment_kpmr' : 'assessment_inheren';
    if (table_exists2($conn, $assessmentTable)) {
        $like = mysqli_real_escape_string($conn, $riskKey);
        $row = dbone($conn, "
            SELECT * FROM `$assessmentTable`
            WHERE id_profil_risiko='$id'
              AND LOWER(COALESCE(jenis_risiko,'')) LIKE '%$like%'
            ORDER BY updated_at DESC, created_at DESC
            LIMIT 1
        ", "READ $assessmentTable");
        $p = prof_pick_result_from_row($row, $jenis);
        if ((float)$p['nilai'] > 0 || trim((string)$p['peringkat']) !== '') return $p;
    }

    return $best;
}

function prof_matrix_value($riskKey, $inherenRank, $kpmrRank){
    $inherenRank = trim((string)$inherenRank);
    $kpmrRank = trim((string)$kpmrRank);

    // Kredit & Likuiditas memakai matrix lama yang sama.
    $matrix_kredit_likuiditas = [
        'Sangat Rendah' => ['Sangat Memadai'=>1.00,'Memadai'=>1.10,'Cukup Memadai'=>1.15,'Kurang Memadai'=>1.20,'Tidak Memadai'=>1.25],
        'Rendah' => ['Sangat Memadai'=>1.05,'Memadai'=>1.68,'Cukup Memadai'=>1.96,'Kurang Memadai'=>2.11,'Tidak Memadai'=>2.25],
        'Sedang' => ['Sangat Memadai'=>1.39,'Memadai'=>1.82,'Cukup Memadai'=>2.92,'Kurang Memadai'=>3.08,'Tidak Memadai'=>3.25],
        'Tinggi' => ['Sangat Memadai'=>1.54,'Memadai'=>2.58,'Cukup Memadai'=>3.50,'Kurang Memadai'=>4.00,'Tidak Memadai'=>4.25],
        'Sangat Tinggi' => ['Sangat Memadai'=>2.42,'Memadai'=>2.75,'Cukup Memadai'=>3.75,'Kurang Memadai'=>4.63,'Tidak Memadai'=>5.00],
    ];

    // Operasional, Kepatuhan, Reputasi, Stratejik mengikuti halaman profil masing-masing.
    $matrix_lain = [
        'Sangat Rendah' => ['Sangat Memadai'=>1.00,'Memadai'=>1.10,'Cukup Memadai'=>1.15,'Kurang Memadai'=>1.20,'Tidak Memadai'=>1.25],
        'Rendah' => ['Sangat Memadai'=>1.05,'Memadai'=>1.72,'Cukup Memadai'=>1.85,'Kurang Memadai'=>1.92,'Tidak Memadai'=>2.25],
        'Sedang' => ['Sangat Memadai'=>1.58,'Memadai'=>1.78,'Cukup Memadai'=>3.00,'Kurang Memadai'=>2.67,'Tidak Memadai'=>3.25],
        'Tinggi' => ['Sangat Memadai'=>1.65,'Memadai'=>2.58,'Cukup Memadai'=>3.50,'Kurang Memadai'=>4.00,'Tidak Memadai'=>4.25],
        'Sangat Tinggi' => ['Sangat Memadai'=>2.50,'Memadai'=>2.75,'Cukup Memadai'=>3.75,'Kurang Memadai'=>4.63,'Tidak Memadai'=>5.00],
    ];

    $m = in_array($riskKey, ['kredit','likuiditas'], true) ? $matrix_kredit_likuiditas : $matrix_lain;
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function prof_lookup_kualitas($conn, $riskKey, $tingkatLabel, $existing=''){
    $existing = trim((string)$existing);
    if ($existing !== '') return $existing;

    $tingkatLabel = trim((string)$tingkatLabel);
    if ($tingkatLabel === '') return '';

    $tables = [
        "matrik_ojk_".$riskKey,
        "matrik_ojk_".$riskKey."1"
    ];

    foreach($tables as $tb){
        if (!table_exists2($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatLabel);
        $row = dbone($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko='$label' LIMIT 1", "READ $tb");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') return trim((string)$row['definisi_tingkat_risiko']);
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') return trim((string)$row['tingkat_risiko']);
        }
    }
    return $tingkatLabel;
}

function prof_sync_keterangan_row($conn, $table, $id, $kolInheren, $kolKpmr, $nilaiInheren, $nilaiKpmr, $nilaiTingkat, $peringkatTingkat, $kualitas){
    if ((int)$id <= 0 || !table_exists2($conn, $table)) return;
    ensure_row2($conn, $table, $id);

    $data = [
        $kolInheren => n2($nilaiInheren),
        $kolKpmr => n2($nilaiKpmr),
        'tingkat_risiko' => n2($nilaiTingkat),
        'peringkat_tingkat_risiko' => $peringkatTingkat,
        'tingkat_kualitas_mr' => $kualitas,
    ];
    update_dynamic2($conn, $table, $id, $data);
}


/* ===== SOURCE COMPUTE FUNCTIONS: kredit ===== */
function kre_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}

function kre_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function kre_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function kre_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function kre_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function kre_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function kre_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function kre_matrix_kredit_value($inherenRank, $kpmrRank){
    // Matrix profil risiko kredit mengikuti file kredit lama
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.68,
            'Cukup Memadai' => 1.96,
            'Kurang Memadai' => 2.11,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.39,
            'Memadai' => 1.82,
            'Cukup Memadai' => 2.92,
            'Kurang Memadai' => 3.08,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.54,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.42,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function kre_lookup_kualitas_mr_kredit($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_kredit', 'matrik_ojk_kredit1'];
    foreach ($tables as $tb) {
        if (!kre_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = kre_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function kre_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && kre_table_exists($conn, $dynamicTable)) {
        $row = kre_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && kre_table_exists($conn, $legacyTable)) {
        $row = kre_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}

function kre_read_uraian_inheren_kredit_langsung($conn, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';

    // PRIORITAS UTAMA: ambil langsung dari halaman Uraian Risiko Inheren Kredit
    // tabel lama: keterangan_inheren_kredit.ket_inheren
    if (kre_table_exists($conn, 'keterangan_inheren_kredit')) {
        $row = kre_db_one($conn, "SELECT ket_inheren FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['ket_inheren'] ?? '')) !== '') {
            return trim((string)$row['ket_inheren']);
        }
    }

    // Fallback jika suatu saat memakai form Inheren 2 dinamis
    if (kre_table_exists($conn, 'inheren2_kredit_catatan_dinamis')) {
        $row = kre_db_one($conn, "SELECT catatan FROM inheren2_kredit_catatan_dinamis WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }

    if (kre_table_exists($conn, 'keterangan_inheren2_kredit')) {
        $row = kre_db_one($conn, "SELECT ket_inheren FROM keterangan_inheren2_kredit WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['ket_inheren'] ?? '')) !== '') {
            return trim((string)$row['ket_inheren']);
        }
    }

    return '';
}

function kre_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !kre_table_exists($conn, $table)) return $out;
    $row = kre_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? kre_label_kpmr($nilai) : kre_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function kre_find_frame_perumusan($conn, $frame){
    if (!$frame || !kre_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = kre_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return kre_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function kre_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function kre_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !kre_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function kre_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !kre_table_exists($conn, $table)) return 'rata_rata';
    $row = kre_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function kre_compute_inheren2_kredit($conn, $id){
    $fallback = kre_fallback_result($conn, 'hasil_inheren_kredit', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!kre_table_exists($conn, $tb)) return $fallback; }

    $frame = kre_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = kre_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KREDIT' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = kre_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = kre_table_exists($conn, 'pr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KREDIT'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = kre_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && kre_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = kre_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KREDIT') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? kre_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? kre_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = kre_max($parameterScores);
        $statMin = kre_min($parameterScores);
        $statAvg = kre_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = kre_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = kre_risk_mode_label($riskPerumusan);
    $overallMax = kre_max($rekapPilar);
    $overallMin = kre_min($rekapPilar);
    $overallAvg = kre_avg($rekapPilar);
    $overallMethod = kre_dynamic_method($conn, 'inheren2_kredit_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kre_label_inheren($overallNilai)];
}

function kre_compute_kpmr2_kredit($conn, $id){
    $fallback = kre_fallback_result($conn, 'hasil_kpmr_kredit', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!kre_table_exists($conn, $tb)) return $fallback; }

    $frame = kre_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = kre_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KREDIT' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = kre_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = kre_table_exists($conn, 'kpmr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KREDIT'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = kre_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && kre_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = kre_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KREDIT') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? kre_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? kre_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = kre_max($parameterScores);
        $statMin = kre_min($parameterScores);
        $statAvg = kre_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = kre_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = kre_risk_mode_label($riskPerumusan);
    $overallMax = kre_max($rekapPilar);
    $overallMin = kre_min($rekapPilar);
    $overallAvg = kre_avg($rekapPilar);
    $overallMethod = kre_dynamic_method($conn, 'kpmr2_kredit_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kre_label_kpmr($overallNilai)];
}

/* ===== SOURCE COMPUTE FUNCTIONS: operasional ===== */
function opr_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}

function opr_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function opr_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function opr_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function opr_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function opr_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function opr_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function opr_matrix_operasional_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.72,
            'Cukup Memadai' => 1.85,
            'Kurang Memadai' => 1.92,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.58,
            'Memadai' => 1.78,
            'Cukup Memadai' => 3.00,
            'Kurang Memadai' => 2.67,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.65,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.50,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function opr_lookup_kualitas_mr_operasional($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_operasional', 'matrik_ojk_operasional1'];
    foreach ($tables as $tb) {
        if (!opr_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = opr_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function opr_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && opr_table_exists($conn, $dynamicTable)) {
        $row = opr_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && opr_table_exists($conn, $legacyTable)) {
        $row = opr_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}

function opr_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !opr_table_exists($conn, $table)) return $out;
    $row = opr_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? opr_label_kpmr($nilai) : opr_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function opr_find_frame_perumusan($conn, $frame){
    if (!$frame || !opr_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = opr_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return opr_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function opr_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function opr_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !opr_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function opr_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !opr_table_exists($conn, $table)) return 'rata_rata';
    $row = opr_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function opr_compute_inheren2_operasional($conn, $id){
    $fallback = opr_fallback_result($conn, 'hasil_inheren_operasional', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!opr_table_exists($conn, $tb)) return $fallback; }

    $frame = opr_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = opr_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO OPERASIONAL' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = opr_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = opr_table_exists($conn, 'pr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO OPERASIONAL'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = opr_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && opr_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = opr_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO OPERASIONAL') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? opr_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? opr_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = opr_max($parameterScores);
        $statMin = opr_min($parameterScores);
        $statAvg = opr_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = opr_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = opr_risk_mode_label($riskPerumusan);
    $overallMax = opr_max($rekapPilar);
    $overallMin = opr_min($rekapPilar);
    $overallAvg = opr_avg($rekapPilar);
    $overallMethod = opr_dynamic_method($conn, 'inheren2_operasional_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => opr_label_inheren($overallNilai)];
}

function opr_compute_kpmr2_operasional($conn, $id){
    $fallback = opr_fallback_result($conn, 'hasil_kpmr_operasional', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!opr_table_exists($conn, $tb)) return $fallback; }

    $frame = opr_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = opr_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO OPERASIONAL' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = opr_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = opr_table_exists($conn, 'kpmr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO OPERASIONAL'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = opr_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && opr_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = opr_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO OPERASIONAL') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? opr_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? opr_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = opr_max($parameterScores);
        $statMin = opr_min($parameterScores);
        $statAvg = opr_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = opr_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = opr_risk_mode_label($riskPerumusan);
    $overallMax = opr_max($rekapPilar);
    $overallMin = opr_min($rekapPilar);
    $overallAvg = opr_avg($rekapPilar);
    $overallMethod = opr_dynamic_method($conn, 'kpmr2_operasional_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => opr_label_kpmr($overallNilai)];
}

/* ===== SOURCE COMPUTE FUNCTIONS: kepatuhan ===== */
function kep_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}

function kep_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function kep_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function kep_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function kep_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function kep_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function kep_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function kep_matrix_kepatuhan_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.72,
            'Cukup Memadai' => 1.85,
            'Kurang Memadai' => 1.92,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.58,
            'Memadai' => 1.78,
            'Cukup Memadai' => 3.00,
            'Kurang Memadai' => 2.67,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.65,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.50,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function kep_lookup_kualitas_mr_kepatuhan($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_kepatuhan', 'matrik_ojk_kepatuhan1'];
    foreach ($tables as $tb) {
        if (!kep_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = kep_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function kep_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && kep_table_exists($conn, $dynamicTable)) {
        $row = kep_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && kep_table_exists($conn, $legacyTable)) {
        $row = kep_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}

function kep_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !kep_table_exists($conn, $table)) return $out;
    $row = kep_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? kep_label_kpmr($nilai) : kep_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function kep_find_frame_perumusan($conn, $frame){
    if (!$frame || !kep_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = kep_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return kep_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function kep_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function kep_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !kep_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function kep_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !kep_table_exists($conn, $table)) return 'rata_rata';
    $row = kep_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function kep_compute_inheren2_kepatuhan($conn, $id){
    $fallback = kep_fallback_result($conn, 'hasil_inheren_kepatuhan', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!kep_table_exists($conn, $tb)) return $fallback; }

    $frame = kep_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = kep_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KEPATUHAN' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = kep_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = kep_table_exists($conn, 'pr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KEPATUHAN'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = kep_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && kep_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = kep_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KEPATUHAN') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? kep_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? kep_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = kep_max($parameterScores);
        $statMin = kep_min($parameterScores);
        $statAvg = kep_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = kep_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = kep_risk_mode_label($riskPerumusan);
    $overallMax = kep_max($rekapPilar);
    $overallMin = kep_min($rekapPilar);
    $overallAvg = kep_avg($rekapPilar);
    $overallMethod = kep_dynamic_method($conn, 'inheren2_kepatuhan_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kep_label_inheren($overallNilai)];
}

function kep_compute_kpmr2_kepatuhan($conn, $id){
    $fallback = kep_fallback_result($conn, 'hasil_kpmr_kepatuhan', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!kep_table_exists($conn, $tb)) return $fallback; }

    $frame = kep_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = kep_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO KEPATUHAN' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = kep_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = kep_table_exists($conn, 'kpmr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO KEPATUHAN'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = kep_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && kep_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = kep_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO KEPATUHAN') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? kep_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? kep_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = kep_max($parameterScores);
        $statMin = kep_min($parameterScores);
        $statAvg = kep_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = kep_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = kep_risk_mode_label($riskPerumusan);
    $overallMax = kep_max($rekapPilar);
    $overallMin = kep_min($rekapPilar);
    $overallAvg = kep_avg($rekapPilar);
    $overallMethod = kep_dynamic_method($conn, 'kpmr2_kepatuhan_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => kep_label_kpmr($overallNilai)];
}

/* ===== SOURCE COMPUTE FUNCTIONS: likuiditas ===== */
function lik_safe($v){
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function lik_db_one($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}

function lik_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function lik_ensure_ket_row($conn, $id){
    $id = (int)$id;
    if ($id <= 0) return;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id' LIMIT 1");
    if (!$cek || mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO keterangan_profil_likuiditas (id_profil_risiko) VALUES ('$id')");
    }
}

function lik_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function lik_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Memadai';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Memadai';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Cukup Memadai';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Kurang Memadai';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function lik_col_exists($conn, $table, $column){
    if (!lik_table_exists($conn, $table)) return false;
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}

function lik_pick_result($row, $jenis = 'inheren'){
    $nilaiKeys = [
        'hasil_tingkat_risiko', 'tingkat_risiko', 'hasil_kpmr', 'hasil_penilaian_kpmr',
        'nilai_kpmr', 'total_nilai', 'hasil_rata_rata', 'rata_rata', 'nilai'
    ];
    $rankKeys = ['hasil_peringkat', 'peringkat', 'predikat', 'hasil_predikat', 'ket_tingkat_risiko'];

    $nilai = 0;
    foreach ($nilaiKeys as $k) {
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $nilai = (float)str_replace(',', '.', (string)$row[$k]);
            if ($nilai > 0) break;
        }
    }

    $rank = '';
    foreach ($rankKeys as $k) {
        if (isset($row[$k]) && trim((string)$row[$k]) !== '') {
            $rank = trim((string)$row[$k]);
            break;
        }
    }
    if ($rank === '') {
        $rank = ($jenis === 'kpmr') ? lik_label_kpmr($nilai) : lik_label_inheren($nilai);
    }

    return [
        'hasil_tingkat_risiko' => round((float)$nilai, 2),
        'hasil_peringkat' => $rank
    ];
}

function lik_result_from_tables($conn, $id, $tables, $jenis = 'inheren'){
    $id = (int)$id;
    $best = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => ''];
    if ($id <= 0) return $best;

    foreach ((array)$tables as $table) {
        if (!lik_table_exists($conn, $table)) continue;
        $row = lik_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko = '$id' LIMIT 1");
        if (!$row) continue;
        $picked = lik_pick_result($row, $jenis);
        if ((float)$picked['hasil_tingkat_risiko'] > 0 || trim((string)$picked['hasil_peringkat']) !== '') {
            // Jika ketemu hasil yang bernilai, langsung pakai. Ini mengatasi hasil KPMR yang tersimpan di tabel lama/alternatif.
            if ((float)$picked['hasil_tingkat_risiko'] > 0) return $picked;
            $best = $picked;
        }
    }
    return $best;
}

function lik_read_uraian_multi($conn, $id, $sources){
    $id = (int)$id;
    if ($id <= 0) return '';
    foreach ((array)$sources as $src) {
        $table = $src[0] ?? '';
        $field = $src[1] ?? '';
        $where = $src[2] ?? '';
        if ($table === '' || $field === '' || !lik_table_exists($conn, $table) || !lik_col_exists($conn, $table, $field)) continue;
        $fieldSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        $extraWhere = trim((string)$where);
        $sql = "SELECT `$fieldSafe` AS uraian FROM `$table` WHERE id_profil_risiko = '$id'";
        if ($extraWhere !== '') $sql .= " AND $extraWhere";
        $sql .= " LIMIT 1";
        $row = lik_db_one($conn, $sql);
        $txt = trim((string)($row['uraian'] ?? ''));
        if ($txt !== '') return $txt;
    }
    return '';
}

function lik_matrix_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.68,
            'Cukup Memadai' => 1.96,
            'Kurang Memadai' => 2.11,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.39,
            'Memadai' => 1.82,
            'Cukup Memadai' => 2.92,
            'Kurang Memadai' => 3.08,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.54,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.42,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function lik_kualitas_mr($i, $k){
    $m = [
        'Sangat Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Cukup Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Kurang Memadai' => 'Risiko Sangat Rendah',
        'Sangat Rendah|Tidak Memadai' => 'Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',

        'Rendah|Sangat Memadai' => 'Risiko Sangat Rendah',
        'Rendah|Memadai' => 'Risiko Rendah',
        'Rendah|Cukup Memadai' => 'Risiko Rendah',
        'Rendah|Kurang Memadai' => 'Risiko rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Rendah|Tidak Memadai' => 'Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',

        'Sedang|Sangat Memadai' => 'Risiko Rendah',
        'Sedang|Memadai' => 'Risiko Rendah',
        'Sedang|Cukup Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)',
        'Sedang|Kurang Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sedang|Tidak Memadai' => 'Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',

        'Tinggi|Sangat Memadai' => 'Risiko Rendah',
        'Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Kurang Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)',
        'Tinggi|Tidak Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',

        'Sangat Tinggi|Sangat Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)',
        'Sangat Tinggi|Memadai' => 'Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Cukup Memadai' => 'Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Kurang Memadai' => 'Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)',
        'Sangat Tinggi|Tidak Memadai' => 'Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam)',
    ];
    $key = trim((string)$i).'|'.trim((string)$k);
    return $m[$key] ?? '';
}

function lik_read_uraian($conn, $table, $field, $id){
    $id = (int)$id;
    if ($id <= 0 || !lik_table_exists($conn, $table)) return '';
    $fieldSafe = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
    $row = lik_db_one($conn, "SELECT `$fieldSafe` AS uraian FROM `$table` WHERE id_profil_risiko = '$id' LIMIT 1");
    return trim((string)($row['uraian'] ?? ''));
}

function lik_num_avg($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(array_sum($nums) / count($nums), 2) : 0;
}

function lik_num_max($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(max($nums), 2) : 0;
}

function lik_num_min($arr){
    $nums = [];
    foreach ((array)$arr as $v) {
        if ($v === '' || $v === null) continue;
        $nums[] = (float)$v;
    }
    return count($nums) ? round(min($nums), 2) : 0;
}

function lik_risk_mode_label($riskRow){
    if (!$riskRow || empty($riskRow)) return 'Perskalaan';
    return ((int)($riskRow['pembobotan'] ?? 0) === 1) ? 'Pembobotan' : 'Perskalaan';
}

function lik_find_frame_perumusan($conn, $frame){
    if (!$frame || !lik_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = lik_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan = '".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }

    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';

    return lik_db_one($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''))."'
          AND user_id = '".(int)($frame['user'] ?? 0)."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function lik_pilar_perumusan_map($conn, $id_perumusan_kpmr){
    $map = [];
    if ((int)$id_perumusan_kpmr <= 0 || !lik_table_exists($conn, 'perumusan_kpmr_pilar')) return $map;
    $q = mysqli_query($conn, "SELECT * FROM perumusan_kpmr_pilar WHERE id_perumusan_kpmr = '".(int)$id_perumusan_kpmr."'");
    if ($q) {
        while ($r = mysqli_fetch_assoc($q)) {
            $map[(int)$r['id_pilar']] = $r;
        }
    }
    return $map;
}

function lik_dynamic_method_kpmr($conn, $id){
    $id = (int)$id;
    $metode = 'rata_rata';
    if ($id > 0 && lik_table_exists($conn, 'kpmr2_likuiditas_catatan_dinamis')) {
        $row = lik_db_one($conn, "SELECT metode FROM kpmr2_likuiditas_catatan_dinamis WHERE id_profil_risiko = '$id' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['metode'] ?? '')) !== '') $metode = trim((string)$row['metode']);
    }
    return in_array($metode, ['tertinggi','terendah','rata_rata']) ? $metode : 'rata_rata';
}

function lik_compute_kpmr2_likuiditas($conn, $id){
    $fallback = lik_result_from_tables($conn, $id, [
        'hasil_kpmr_likuiditas',
        'hasil_kpmr2_likuiditas',
        'hasil_kpmr_lik'
    ], 'kpmr');

    $id = (int)$id;
    if ($id <= 0) return $fallback;

    $needed = [
        'frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail',
        'kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode',
        'kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'
    ];
    foreach ($needed as $tb) {
        if (!lik_table_exists($conn, $tb)) return $fallback;
    }

    $frame = lik_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '$id'
        LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = lik_db_one($conn, "
        SELECT *
        FROM assessment_kpmr
        WHERE id_profil_risiko = '$id'
          AND UPPER(jenis_risiko) = 'RISIKO LIKUIDITAS'
        LIMIT 1
    ");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr = '".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while ($r = mysqli_fetch_assoc($dq)) {
            $detailMap[$r['ref_tipe'].'|'.(int)$r['ref_id']] = $r;
        }
    }

    $pilihHeader = lik_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''))."'
          AND pp.id_user_profil_risiko = '".(int)($frame['user'] ?? 0)."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = [];
    $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id = '".(int)$pilihHeader['id']."'");
    if ($cq) {
        while ($ck = mysqli_fetch_assoc($cq)) {
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = lik_table_exists($conn, 'kpmr_sub_parameter');
    $group = [];
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id'
        ".($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id'" : "")."
        WHERE UPPER(jr.nama_risiko) = 'RISIKO LIKUIDITAS'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;

    while ($r = mysqli_fetch_assoc($q)) {
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;

        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id, 'urutan'=>(int)$r['pilar_urutan'], 'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }

    if (empty($group)) return $fallback;

    $framePerumusan = lik_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && lik_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = lik_db_one($conn, "
            SELECT *
            FROM perumusan_kpmr
            WHERE id_frame_perumusan = '".(int)$framePerumusan['id_frame_perumusan']."'
              AND UPPER(nama_risiko) = 'RISIKO LIKUIDITAS'
            LIMIT 1
        ");
    }
    $pilarPerumusanMap = $riskPerumusan ? lik_pilar_perumusan_map($conn, (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $overallMode = lik_risk_mode_label($riskPerumusan);

    $rekapPilar = [];
    foreach ($group as $pilar_id => $pilar) {
        $parameterScores = [];
        foreach ($pilar['parameters'] as $parameter_id => $parameter) {
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = $detailMap[$paramKey] ?? null;
            $subScores = [];
            foreach ($parameter['subs'] as $sub) {
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = $detailMap[$subKey] ?? null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? lik_num_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }

        $statMax = lik_num_max($parameterScores);
        $statMin = lik_num_min($parameterScores);
        $statAvg = lik_num_avg($parameterScores);
        $perumusanPilar = $pilarPerumusanMap[$pilar_id] ?? null;

        if ($overallMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMax = lik_num_max($rekapPilar);
    $overallMin = lik_num_min($rekapPilar);
    $overallAvg = lik_num_avg($rekapPilar);
    if ($overallMode === 'Pembobotan') {
        $overallNilai = round(array_sum($rekapPilar), 2);
    } else {
        $overallMethod = lik_dynamic_method_kpmr($conn, $id);
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }

    if ((float)$overallNilai <= 0 && (float)$fallback['hasil_tingkat_risiko'] > 0) return $fallback;
    return [
        'hasil_tingkat_risiko' => round((float)$overallNilai, 2),
        'hasil_peringkat' => lik_label_kpmr($overallNilai)
    ];
}

/* ===== SOURCE COMPUTE FUNCTIONS: reputasi ===== */
function rep_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}

function rep_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function rep_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function rep_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function rep_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function rep_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function rep_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function rep_matrix_reputasi_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.72,
            'Cukup Memadai' => 1.85,
            'Kurang Memadai' => 1.92,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.58,
            'Memadai' => 1.78,
            'Cukup Memadai' => 3.00,
            'Kurang Memadai' => 2.67,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.65,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.50,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function rep_lookup_kualitas_mr_reputasi($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_reputasi', 'matrik_ojk_reputasi1'];
    foreach ($tables as $tb) {
        if (!rep_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = rep_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function rep_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && rep_table_exists($conn, $dynamicTable)) {
        $row = rep_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && rep_table_exists($conn, $legacyTable)) {
        $row = rep_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}

function rep_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !rep_table_exists($conn, $table)) return $out;
    $row = rep_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? rep_label_kpmr($nilai) : rep_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function rep_find_frame_perumusan($conn, $frame){
    if (!$frame || !rep_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = rep_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return rep_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function rep_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function rep_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !rep_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function rep_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !rep_table_exists($conn, $table)) return 'rata_rata';
    $row = rep_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function rep_compute_inheren2_reputasi($conn, $id){
    $fallback = rep_fallback_result($conn, 'hasil_inheren_reputasi', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!rep_table_exists($conn, $tb)) return $fallback; }

    $frame = rep_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = rep_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO REPUTASI' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = rep_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = rep_table_exists($conn, 'pr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO REPUTASI'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = rep_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && rep_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = rep_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO REPUTASI') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? rep_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? rep_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = rep_max($parameterScores);
        $statMin = rep_min($parameterScores);
        $statAvg = rep_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = rep_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = rep_risk_mode_label($riskPerumusan);
    $overallMax = rep_max($rekapPilar);
    $overallMin = rep_min($rekapPilar);
    $overallAvg = rep_avg($rekapPilar);
    $overallMethod = rep_dynamic_method($conn, 'inheren2_reputasi_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => rep_label_inheren($overallNilai)];
}

function rep_compute_kpmr2_reputasi($conn, $id){
    $fallback = rep_fallback_result($conn, 'hasil_kpmr_reputasi', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!rep_table_exists($conn, $tb)) return $fallback; }

    $frame = rep_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = rep_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO REPUTASI' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = rep_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = rep_table_exists($conn, 'kpmr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO REPUTASI'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = rep_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && rep_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = rep_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO REPUTASI') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? rep_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? rep_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = rep_max($parameterScores);
        $statMin = rep_min($parameterScores);
        $statAvg = rep_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = rep_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = rep_risk_mode_label($riskPerumusan);
    $overallMax = rep_max($rekapPilar);
    $overallMin = rep_min($rekapPilar);
    $overallAvg = rep_avg($rekapPilar);
    $overallMethod = rep_dynamic_method($conn, 'kpmr2_reputasi_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => rep_label_kpmr($overallNilai)];
}

/* ===== SOURCE COMPUTE FUNCTIONS: stratejik ===== */
function str_db_one($conn, $sql){
    $res = mysqli_query($conn, $sql);
    if (!$res) return null;
    return mysqli_fetch_assoc($res);
}

function str_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function str_avg($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(array_sum($n)/count($n), 2) : 0;
}

function str_max($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(max($n), 2) : 0;
}

function str_min($arr){
    $n = [];
    foreach((array)$arr as $v){ if ($v === '' || $v === null) continue; $n[] = (float)$v; }
    return count($n) ? round(min($n), 2) : 0;
}

function str_label_inheren($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai >= 1.00 && $nilai < 1.25) return 'Sangat Rendah';
    if ($nilai >= 1.25 && $nilai < 2.25) return 'Rendah';
    if ($nilai >= 2.25 && $nilai < 3.25) return 'Sedang';
    if ($nilai >= 3.25 && $nilai < 4.25) return 'Tinggi';
    if ($nilai >= 4.25 && $nilai <= 5.00) return 'Sangat Tinggi';
    return '';
}

function str_label_kpmr($nilai){
    $nilai = (float)$nilai;
    if ($nilai < 1.00) return '';
    if ($nilai < 1.25) return 'Sangat Memadai';
    if ($nilai < 2.25) return 'Memadai';
    if ($nilai < 3.25) return 'Cukup Memadai';
    if ($nilai < 4.25) return 'Kurang Memadai';
    if ($nilai <= 5.00) return 'Tidak Memadai';
    return '';
}

function str_matrix_stratejik_value($inherenRank, $kpmrRank){
    $m = [
        'Sangat Rendah' => [
            'Sangat Memadai' => 1.00,
            'Memadai' => 1.10,
            'Cukup Memadai' => 1.15,
            'Kurang Memadai' => 1.20,
            'Tidak Memadai' => 1.25,
        ],
        'Rendah' => [
            'Sangat Memadai' => 1.05,
            'Memadai' => 1.72,
            'Cukup Memadai' => 1.85,
            'Kurang Memadai' => 1.92,
            'Tidak Memadai' => 2.25,
        ],
        'Sedang' => [
            'Sangat Memadai' => 1.58,
            'Memadai' => 1.78,
            'Cukup Memadai' => 3.00,
            'Kurang Memadai' => 2.67,
            'Tidak Memadai' => 3.25,
        ],
        'Tinggi' => [
            'Sangat Memadai' => 1.65,
            'Memadai' => 2.58,
            'Cukup Memadai' => 3.50,
            'Kurang Memadai' => 4.00,
            'Tidak Memadai' => 4.25,
        ],
        'Sangat Tinggi' => [
            'Sangat Memadai' => 2.50,
            'Memadai' => 2.75,
            'Cukup Memadai' => 3.75,
            'Kurang Memadai' => 4.63,
            'Tidak Memadai' => 5.00,
        ],
    ];
    return isset($m[$inherenRank][$kpmrRank]) ? (float)$m[$inherenRank][$kpmrRank] : 0.00;
}

function str_lookup_kualitas_mr_stratejik($conn, $tingkatRisikoLabel){
    $tingkatRisikoLabel = trim((string)$tingkatRisikoLabel);
    if ($tingkatRisikoLabel === '') return '';
    $tables = ['matrik_ojk_stratejik', 'matrik_ojk_stratejik1'];
    foreach ($tables as $tb) {
        if (!str_table_exists($conn, $tb)) continue;
        $label = mysqli_real_escape_string($conn, $tingkatRisikoLabel);
        $row = str_db_one($conn, "SELECT * FROM `$tb` WHERE tingkat_risiko = '$label' LIMIT 1");
        if ($row) {
            if (isset($row['definisi_tingkat_risiko']) && trim((string)$row['definisi_tingkat_risiko']) !== '') {
                return trim((string)$row['definisi_tingkat_risiko']);
            }
            if (isset($row['tingkat_risiko']) && trim((string)$row['tingkat_risiko']) !== '') {
                return trim((string)$row['tingkat_risiko']);
            }
        }
    }
    return $tingkatRisikoLabel;
}

function str_read_source_uraian($conn, $dynamicTable, $legacyTable, $legacyField, $idProfil){
    $idProfil = (int)$idProfil;
    if ($idProfil <= 0) return '';
    if ($dynamicTable !== '' && str_table_exists($conn, $dynamicTable)) {
        $row = str_db_one($conn, "SELECT catatan FROM `$dynamicTable` WHERE id_profil_risiko = '$idProfil' AND scope_type = 'risiko' AND scope_ref_id = 0 LIMIT 1");
        if ($row && trim((string)($row['catatan'] ?? '')) !== '') {
            return trim((string)$row['catatan']);
        }
    }
    if ($legacyTable !== '' && str_table_exists($conn, $legacyTable)) {
        $row = str_db_one($conn, "SELECT `$legacyField` AS uraian FROM `$legacyTable` WHERE id_profil_risiko = '$idProfil' LIMIT 1");
        if ($row && trim((string)($row['uraian'] ?? '')) !== '') {
            return trim((string)$row['uraian']);
        }
    }
    return '';
}

function str_fallback_result($conn, $table, $id, $jenis = 'inheren'){
    $emptyRank = ($jenis === 'kpmr') ? '' : '';
    $out = ['hasil_tingkat_risiko' => 0, 'hasil_peringkat' => $emptyRank];
    if ((int)$id <= 0 || !str_table_exists($conn, $table)) return $out;
    $row = str_db_one($conn, "SELECT * FROM `$table` WHERE id_profil_risiko='".(int)$id."' LIMIT 1");
    if (!$row) return $out;
    $nilai = 0;
    if (isset($row['hasil_tingkat_risiko'])) $nilai = (float)$row['hasil_tingkat_risiko'];
    elseif (isset($row['tingkat_risiko'])) $nilai = (float)$row['tingkat_risiko'];
    elseif (isset($row['total_nilai'])) $nilai = (float)$row['total_nilai'];
    $rank = '';
    if (isset($row['hasil_peringkat']) && trim((string)$row['hasil_peringkat']) !== '') $rank = trim((string)$row['hasil_peringkat']);
    elseif (isset($row['peringkat']) && trim((string)$row['peringkat']) !== '') $rank = trim((string)$row['peringkat']);
    else $rank = ($jenis === 'kpmr') ? str_label_kpmr($nilai) : str_label_inheren($nilai);
    return ['hasil_tingkat_risiko' => round($nilai, 2), 'hasil_peringkat' => $rank];
}

function str_find_frame_perumusan($conn, $frame){
    if (!$frame || !str_table_exists($conn, 'frame_perumusan')) return null;
    if (isset($frame['id_frame_perumusan']) && (int)$frame['id_frame_perumusan'] > 0) {
        $row = str_db_one($conn, "SELECT * FROM frame_perumusan WHERE id_frame_perumusan='".(int)$frame['id_frame_perumusan']."' LIMIT 1");
        if ($row) return $row;
    }
    $kategori = 'KONSOLIDASI';
    $namaCabang = strtolower(trim((string)($frame['cabang'] ?? '')));
    $tipeUser = strtolower(trim((string)($frame['tipe_user'] ?? '')));
    if ($namaCabang !== '' && $namaCabang !== 'kantor pusat') $kategori = 'CABANG';
    if (strpos($tipeUser, 'kantor cabang') !== false) $kategori = 'CABANG';
    return str_db_one($conn, "
        SELECT * FROM frame_perumusan
        WHERE tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND user_id = '".(int)$frame['user']."'
          AND (
                UPPER(COALESCE(triwulan,'')) = '".mysqli_real_escape_string($conn, $kategori)."'
                OR (UPPER(COALESCE(triwulan,'')) = '' AND '".$kategori."' = 'KONSOLIDASI')
              )
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
}

function str_risk_mode_label($riskRow){
    if (!$riskRow) return 'Perskalaan';
    if ((int)($riskRow['pembobotan'] ?? 0) === 1) return 'Pembobotan';
    return 'Perskalaan';
}

function str_pilar_perumusan_map($conn, $table, $fk, $id){
    $map = [];
    if ((int)$id <= 0 || !str_table_exists($conn, $table)) return $map;
    $q = mysqli_query($conn, "SELECT * FROM `$table` WHERE `$fk`='".(int)$id."'");
    if ($q) {
        while($r = mysqli_fetch_assoc($q)){ $map[(int)$r['id_pilar']] = $r; }
    }
    return $map;
}

function str_dynamic_method($conn, $table, $id){
    if ((int)$id <= 0 || !str_table_exists($conn, $table)) return 'rata_rata';
    $row = str_db_one($conn, "SELECT metode FROM `$table` WHERE id_profil_risiko='".(int)$id."' AND scope_type='risiko' AND scope_ref_id='0' LIMIT 1");
    $metode = trim((string)($row['metode'] ?? 'rata_rata'));
    if (!in_array($metode, ['tertinggi','terendah','rata_rata'])) $metode = 'rata_rata';
    return $metode;
}

function str_compute_inheren2_stratejik($conn, $id){
    $fallback = str_fallback_result($conn, 'hasil_inheren_stratejik', $id, 'inheren');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_inheren','assessment_inheren_detail','pr_pilih_parameter','pr_pilih_parameter_detail','pr_inheren_periode','pr_jenis_risiko','pr_pilar','pr_parameter'];
    foreach($needed as $tb){ if (!str_table_exists($conn, $tb)) return $fallback; }

    $frame = str_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = str_db_one($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO STRATEJIK' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren='".(int)$assessment['id_assessment_inheren']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = str_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode pi ON pp.pr_inheren_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['pr_inheren_periode_id'];
    $hasSub = str_table_exists($conn, 'pr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM pr_jenis_risiko jr
        INNER JOIN pr_pilar p ON p.jenis_risiko_id = jr.id AND p.pr_inheren_periode_id = '$periode_master_id'
        INNER JOIN pr_parameter pm ON pm.pilar_id = p.id AND pm.pr_inheren_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN pr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.pr_inheren_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO STRATEJIK'
          AND jr.pr_inheren_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = str_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && str_table_exists($conn, 'perumusan_inheren')) {
        $riskPerumusan = str_db_one($conn, "SELECT * FROM perumusan_inheren WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO STRATEJIK') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? str_pilar_perumusan_map($conn, 'perumusan_inheren_pilar', 'id_perumusan_inheren', (int)$riskPerumusan['id_perumusan_inheren']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? str_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = str_max($parameterScores);
        $statMin = str_min($parameterScores);
        $statAvg = str_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = str_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = str_risk_mode_label($riskPerumusan);
    $overallMax = str_max($rekapPilar);
    $overallMin = str_min($rekapPilar);
    $overallAvg = str_avg($rekapPilar);
    $overallMethod = str_dynamic_method($conn, 'inheren2_stratejik_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => str_label_inheren($overallNilai)];
}

function str_compute_kpmr2_stratejik($conn, $id){
    $fallback = str_fallback_result($conn, 'hasil_kpmr_stratejik', $id, 'kpmr');
    if ((int)$id <= 0) return $fallback;
    $needed = ['frame_laporan_profil_risiko','assessment_kpmr','assessment_kpmr_detail','kpmr_pilih_parameter','kpmr_pilih_parameter_detail','kpmr_periode','kpmr_jenis_risiko','kpmr_pilar','kpmr_parameter'];
    foreach($needed as $tb){ if (!str_table_exists($conn, $tb)) return $fallback; }

    $frame = str_db_one($conn, "
        SELECT f.*, p.periode_laporan, c.cabang, u.tipe_user
        FROM frame_laporan_profil_risiko f
        LEFT JOIN periode_laporan_profil_risiko p ON f.periode = p.id_periode
        LEFT JOIN jenis_cabang c ON f.kantor_cabang = c.id_cabang
        LEFT JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
        WHERE f.id_profil_risiko = '".(int)$id."' LIMIT 1
    ");
    if (!$frame) return $fallback;

    $assessment = str_db_one($conn, "SELECT * FROM assessment_kpmr WHERE id_profil_risiko='".(int)$id."' AND jenis_risiko='RISIKO STRATEJIK' LIMIT 1");
    if (!$assessment) return $fallback;

    $detailMap = [];
    $dq = mysqli_query($conn, "SELECT * FROM assessment_kpmr_detail WHERE id_assessment_kpmr='".(int)$assessment['id_assessment_kpmr']."'");
    if ($dq) {
        while($r = mysqli_fetch_assoc($dq)){ $detailMap[$r['ref_tipe'].'|'.$r['ref_id']] = $r; }
    }

    $pilihHeader = str_db_one($conn, "
        SELECT pp.*, pi.tahun
        FROM kpmr_pilih_parameter pp
        INNER JOIN kpmr_periode pi ON pp.kpmr_periode_id = pi.id
        WHERE pi.tahun = '".mysqli_real_escape_string($conn, (string)$frame['tahun'])."'
          AND pp.id_user_profil_risiko = '".(int)$frame['user']."'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilihHeader) return $fallback;

    $checkedParam = []; $checkedSub = [];
    $cq = mysqli_query($conn, "SELECT ref_tipe, ref_id FROM kpmr_pilih_parameter_detail WHERE kpmr_pilih_parameter_id='".(int)$pilihHeader['id']."'");
    if ($cq) {
        while($ck = mysqli_fetch_assoc($cq)){
            if ($ck['ref_tipe'] === 'parameter') $checkedParam[(int)$ck['ref_id']] = true;
            if ($ck['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$ck['ref_id']] = true;
        }
    }

    $group = [];
    $periode_master_id = (int)$pilihHeader['kpmr_periode_id'];
    $hasSub = str_table_exists($conn, 'kpmr_sub_parameter');
    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan".
            ($hasSub ? ", sp.id AS sub_parameter_id, sp.nama_sub_parameter, sp.urutan AS sub_urutan" : ", 0 AS sub_parameter_id, '' AS nama_sub_parameter, 0 AS sub_urutan")."
        FROM kpmr_jenis_risiko jr
        INNER JOIN kpmr_pilar p ON p.jenis_risiko_id = jr.id AND p.kpmr_periode_id = '$periode_master_id'
        INNER JOIN kpmr_parameter pm ON pm.pilar_id = p.id AND pm.kpmr_periode_id = '$periode_master_id' ".
        ($hasSub ? "LEFT JOIN kpmr_sub_parameter sp ON sp.parameter_id = pm.id AND sp.kpmr_periode_id = '$periode_master_id' " : "")."
        WHERE jr.nama_risiko = 'RISIKO STRATEJIK'
          AND jr.kpmr_periode_id = '$periode_master_id'
        ORDER BY p.urutan, pm.urutan, ".($hasSub ? "sp.urutan" : "pm.id")."
    ";
    $q = mysqli_query($conn, $sql);
    if (!$q) return $fallback;
    while($r = mysqli_fetch_assoc($q)){
        $pilar_id = (int)$r['pilar_id'];
        $parameter_id = (int)$r['parameter_id'];
        $sub_id = (int)$r['sub_parameter_id'];
        $showParameter = isset($checkedParam[$parameter_id]);
        $showSub = ($sub_id > 0 && isset($checkedSub[$sub_id]));
        if (!$showParameter && !$showSub) continue;
        if (!isset($group[$pilar_id])) {
            $group[$pilar_id] = ['pilar_id'=>$pilar_id,'urutan'=>(int)$r['pilar_urutan'],'parameters'=>[]];
        }
        if (!isset($group[$pilar_id]['parameters'][$parameter_id])) {
            $group[$pilar_id]['parameters'][$parameter_id] = ['subs'=>[]];
        }
        if ($showSub && $sub_id > 0) {
            $group[$pilar_id]['parameters'][$parameter_id]['subs'][$sub_id] = ['sub_parameter_id'=>$sub_id];
        }
    }
    if (empty($group)) return $fallback;

    $framePerumusan = str_find_frame_perumusan($conn, $frame);
    $riskPerumusan = null;
    if ($framePerumusan && str_table_exists($conn, 'perumusan_kpmr')) {
        $riskPerumusan = str_db_one($conn, "SELECT * FROM perumusan_kpmr WHERE id_frame_perumusan='".(int)$framePerumusan['id_frame_perumusan']."' AND UPPER(nama_risiko)=UPPER('RISIKO STRATEJIK') LIMIT 1");
    }
    $pilarPerumusanMap = $riskPerumusan ? str_pilar_perumusan_map($conn, 'perumusan_kpmr_pilar', 'id_perumusan_kpmr', (int)$riskPerumusan['id_perumusan_kpmr']) : [];
    $rekapPilar = [];

    foreach($group as $pilar_id => $pilar){
        $parameterScores = [];
        foreach($pilar['parameters'] as $parameter_id => $parameter){
            $paramKey = 'parameter|'.$parameter_id;
            $paramCur = isset($detailMap[$paramKey]) ? $detailMap[$paramKey] : null;
            $subScores = [];
            foreach($parameter['subs'] as $sub){
                $subKey = 'sub_parameter|'.$sub['sub_parameter_id'];
                $subCur = isset($detailMap[$subKey]) ? $detailMap[$subKey] : null;
                $subScores[] = (float)($subCur['nilai'] ?? 0);
            }
            $nilaiParam = count($parameter['subs']) > 0 ? str_avg($subScores) : (float)($paramCur['nilai'] ?? 0);
            $parameterScores[] = $nilaiParam;
        }
        $statMax = str_max($parameterScores);
        $statMin = str_min($parameterScores);
        $statAvg = str_avg($parameterScores);
        $perumusanPilar = isset($pilarPerumusanMap[$pilar_id]) ? $pilarPerumusanMap[$pilar_id] : null;
        $riskMode = str_risk_mode_label($riskPerumusan);
        if ($riskMode === 'Pembobotan') {
            $bobot = (float)($perumusanPilar['pembobotan'] ?? 0);
            $nilaiPilar = round($statAvg * ($bobot / 100), 2);
        } else {
            $metodePilar = (int)($perumusanPilar['perskalaan_metode'] ?? 3);
            if ($metodePilar === 1) $nilaiPilar = $statMax;
            elseif ($metodePilar === 2) $nilaiPilar = $statMin;
            else $nilaiPilar = $statAvg;
        }
        $rekapPilar[] = $nilaiPilar;
    }

    $overallMode = str_risk_mode_label($riskPerumusan);
    $overallMax = str_max($rekapPilar);
    $overallMin = str_min($rekapPilar);
    $overallAvg = str_avg($rekapPilar);
    $overallMethod = str_dynamic_method($conn, 'kpmr2_stratejik_catatan_dinamis', $id);
    if ($overallMode === 'Pembobotan') $overallNilai = round(array_sum($rekapPilar), 2);
    else {
        if ($overallMethod === 'tertinggi') $overallNilai = $overallMax;
        elseif ($overallMethod === 'terendah') $overallNilai = $overallMin;
        else $overallNilai = $overallAvg;
    }
    return ['hasil_tingkat_risiko' => round((float)$overallNilai, 2), 'hasil_peringkat' => str_label_kpmr($overallNilai)];
}

/* =========================================================
   KOMPOSIT FIX: ambil nilai langsung dari rumus halaman profil risiko
   masing-masing, bukan dari tabel keterangan_profil_* yang bisa masih lama.
   ========================================================= */
function komposit_compute_single_risk_live($conn, $id, $riskKey){
    $id = (int)$id;
    $zero = [
        'nilai_inheren' => 0.00,
        'nilai_kpmr' => 0.00,
        'nilai_tingkat' => 0.00,
        'peringkat_inheren' => '',
        'peringkat_kpmr' => '',
        'peringkat_tingkat' => '',
        'kualitas' => '',
    ];
    if ($id <= 0) return $zero;

    $inheren = ['hasil_tingkat_risiko'=>0, 'hasil_peringkat'=>''];
    $kpmr    = ['hasil_tingkat_risiko'=>0, 'hasil_peringkat'=>''];
    $tingkat = 0.00;
    $peringkatTingkat = '';
    $kualitas = '';

    if ($riskKey === 'kredit') {
        $inheren = kre_compute_inheren2_kredit($conn, $id);
        $kpmr    = kre_compute_kpmr2_kredit($conn, $id);
        $tingkat = kre_matrix_kredit_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = kre_label_inheren($tingkat);
        $kualitas = kre_lookup_kualitas_mr_kredit($conn, $peringkatTingkat);
    } elseif ($riskKey === 'operasional') {
        $inheren = opr_compute_inheren2_operasional($conn, $id);
        $kpmr    = opr_compute_kpmr2_operasional($conn, $id);
        $tingkat = opr_matrix_operasional_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = opr_label_inheren($tingkat);
        $kualitas = opr_lookup_kualitas_mr_operasional($conn, $peringkatTingkat);
    } elseif ($riskKey === 'kepatuhan') {
        $inheren = kep_compute_inheren2_kepatuhan($conn, $id);
        $kpmr    = kep_compute_kpmr2_kepatuhan($conn, $id);
        $tingkat = kep_matrix_kepatuhan_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = kep_label_inheren($tingkat);
        $kualitas = kep_lookup_kualitas_mr_kepatuhan($conn, $peringkatTingkat);
    } elseif ($riskKey === 'likuiditas') {
        $inheren = lik_result_from_tables($conn, $id, ['hasil_inheren_likuiditas'], 'inheren');
        $kpmr    = lik_compute_kpmr2_likuiditas($conn, $id);
        $tingkat = lik_matrix_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = lik_label_inheren($tingkat);
        $kualitas = lik_kualitas_mr($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
    } elseif ($riskKey === 'reputasi') {
        $inheren = rep_compute_inheren2_reputasi($conn, $id);
        $kpmr    = rep_compute_kpmr2_reputasi($conn, $id);
        $tingkat = rep_matrix_reputasi_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = rep_label_inheren($tingkat);
        $kualitas = rep_lookup_kualitas_mr_reputasi($conn, $peringkatTingkat);
    } elseif ($riskKey === 'stratejik') {
        $inheren = str_compute_inheren2_stratejik($conn, $id);
        $kpmr    = str_compute_kpmr2_stratejik($conn, $id);
        $tingkat = str_matrix_stratejik_value($inheren['hasil_peringkat'] ?? '', $kpmr['hasil_peringkat'] ?? '');
        $peringkatTingkat = str_label_inheren($tingkat);
        $kualitas = str_lookup_kualitas_mr_stratejik($conn, $peringkatTingkat);
    }

    $nilaiInheren = round((float)($inheren['hasil_tingkat_risiko'] ?? 0), 2);
    $nilaiKpmr    = round((float)($kpmr['hasil_tingkat_risiko'] ?? 0), 2);
    $nilaiTingkat = round((float)$tingkat, 2);
    $peringkatInheren = trim((string)($inheren['hasil_peringkat'] ?? ''));
    $peringkatKpmr    = trim((string)($kpmr['hasil_peringkat'] ?? ''));
    if ($peringkatInheren === '') $peringkatInheren = nilai_label($nilaiInheren);
    if ($peringkatKpmr === '') $peringkatKpmr = kpmr_label($nilaiKpmr);
    if ($peringkatTingkat === '') $peringkatTingkat = nilai_label($nilaiTingkat);

    // FIX: Tingkat Kualitas Manajemen Risiko harus berdasarkan matriks OJK
    // Risiko Inheren x KPMR, bukan hanya lookup berdasarkan peringkat tingkat risiko.
    $kualitasMatrix = kualitas_mr_matrix_ojk($peringkatInheren, $peringkatKpmr);
    if ($kualitasMatrix !== '') {
        $kualitas = $kualitasMatrix;
    }

    return [
        'nilai_inheren' => $nilaiInheren,
        'nilai_kpmr' => $nilaiKpmr,
        'nilai_tingkat' => $nilaiTingkat,
        'peringkat_inheren' => $peringkatInheren,
        'peringkat_kpmr' => $peringkatKpmr,
        'peringkat_tingkat' => $peringkatTingkat,
        'kualitas' => (string)$kualitas,
    ];
}


function build_risiko_rows_payload($rows){
    $out = [];
    foreach($rows as $key => $r){
        $out[$key] = [
            'nilai_inheren' => n2($r['nilai_inheren']),
            'nilai_kpmr' => n2($r['nilai_kpmr']),
            'nilai_tingkat' => n2($r['nilai_tingkat']),
            'peringkat_inheren' => (string)$r['peringkat_inheren'],
            'peringkat_kpmr' => (string)$r['peringkat_kpmr'],
            'peringkat_tingkat' => (string)$r['peringkat_tingkat'],
            'kualitas' => (string)$r['kualitas'],
        ];
    }
    return $out;
}


function build_risiko_rows($conn, $id){
    $defs = [
        'kredit' => 'Risiko kredit',
        'operasional' => 'Risiko operasional',
        'kepatuhan' => 'Risiko kepatuhan',
        'likuiditas' => 'Risiko likuiditas',
        'reputasi' => 'Risiko reputasi',
        'stratejik' => 'Risiko stratejik',
    ];

    $rows = [];
    foreach($defs as $key => $label){
        $r = komposit_compute_single_risk_live($conn, $id, $key);
        $r['label'] = $label;
        $rows[$key] = $r;
    }
    return $rows;
}

function hitung_total_bobot($rows, $bobot){
    $total = 0;
    foreach($bobot as $key => $b){
        $nilai = isset($rows[$key]['nilai_tingkat']) ? (float)$rows[$key]['nilai_tingkat'] : 0;
        $total += ($nilai * ((float)$b)) / 100;
    }
    return round($total, 2);
}
function hitung_total_bobot_inheren($rows, $bobot){
    $total = 0;
    foreach($bobot as $key => $b){
        $nilai = isset($rows[$key]['nilai_inheren']) ? (float)$rows[$key]['nilai_inheren'] : 0;
        $total += ($nilai * ((float)$b)) / 100;
    }
    return round($total, 2);
}
function quality_box($txt){
    $txt = trim((string)$txt);
    if ($txt === '') {
        return '<button type="button" class="btn btn-sm btn-outline-secondary quality-toggle" disabled title="Kosong"><span aria-hidden="true">&#128065;</span></button><div class="quality-scroll quality-hidden"><b></b></div>';
    }
    return '<button type="button" class="btn btn-sm btn-outline-primary quality-toggle" title="Tampilkan"><span aria-hidden="true">&#128065;</span></button><div class="quality-scroll quality-hidden"><b>'.esc($txt).'</b></div>';
}
function render_rows($rows, $bobot, $mode='nilai', $onlyInheren=false){
    $html = '';
    foreach($rows as $key => $r){
        $html .= '<tr class="matched-row risk-row" data-risk="'.esc($key).'" bgcolor="#edebe8">';
        $html .= '<th class="risk-name">'.esc($r['label']).'</th>';

        // Khusus Profil Risiko Kantor Cabang: Profil Nilai hanya menampilkan Inheren saja
        // baik di tab Nilai maupun tab Peringkat.
        if ($onlyInheren) {
            if ($mode === 'nilai') {
                $html .= '<td class="risk-val" data-field="nilai_inheren"><b>'.n2($r['nilai_inheren']).'</b></td>';
            } else {
                $html .= '<td class="risk-val" data-field="peringkat_inheren"><b>'.esc($r['peringkat_inheren']).'</b></td>';
            }
            $html .= '</tr>';
            continue;
        }

        if ($mode === 'nilai') {
            $html .= '<td class="risk-val" data-field="nilai_inheren"><b>'.n2($r['nilai_inheren']).'</b></td>';
            $html .= '<td class="risk-val" data-field="nilai_kpmr"><b>'.n2($r['nilai_kpmr']).'</b></td>';
            $html .= '<td class="risk-val" data-field="nilai_tingkat"><b>'.n2($r['nilai_tingkat']).'</b></td>';
        } else {
            $html .= '<td class="risk-val" data-field="peringkat_inheren"><b>'.esc($r['peringkat_inheren']).'</b></td>';
            $html .= '<td class="risk-val" data-field="peringkat_kpmr"><b>'.esc($r['peringkat_kpmr']).'</b></td>';
            $html .= '<td class="risk-val" data-field="peringkat_tingkat"><b>'.esc($r['peringkat_tingkat']).'</b></td>';
        }
        $html .= '<td data-field="kualitas">'.quality_box($r['kualitas']).'</td>';
        $html .= '</tr>';
    }
    return $html;
}

if ($displayModal) {
?>
<script>$(document).ready(function(){ $('#myModal').modal('show'); });</script>
<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"><div class="modal-content">
    <div class="modal-header"><h5 class="modal-title">Notifikasi</h5><a href="javascript:history.back()"><button type="button" class="btn-close"></button></a></div>
    <div class="modal-body"><h5><center><b>Mohon untuk memilih laporan risiko di (menu dashboard -> laporan profil risiko -> klik (aktif)) terlebih dahulu.</b></center></h5></div>
    <div class="modal-footer"><a href="javascript:history.back()"><button type="button" class="btn btn-danger">Close</button></a></div>
  </div></div>
</div>
<?php return; }

$frame = dbone($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
WHERE id_profil_risiko = '$id' LIMIT 1", 'READ FRAME');
$dp = (int)($frame['data_pembanding'] ?? 0);
$frame_pem = $dp > 0 ? dbone($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
WHERE id_profil_risiko = '$dp' LIMIT 1", 'READ FRAME PEMBANDING') : [];

$isProfilCabang = ((int)($frame['user'] ?? 0) === 3 || stripos((string)($frame['tipe_user'] ?? ''), 'kantor cabang') !== false);

$bobotInfo = get_active_bobot($conn, $frame['tahun'] ?? date('Y'), (int)($frame['user'] ?? 0));
$bobot = $bobotInfo['bobot'];
$rows = build_risiko_rows($conn, $id);
$rowsPembanding = build_risiko_rows($conn, $dp);

$total_nilai = hitung_total_bobot($rows, $bobot);
$ket_total_nilai = nilai_label($total_nilai);
$pembanding_total_nilai = hitung_total_bobot($rowsPembanding, $bobot);
$pembanding_ket_total_nilai = nilai_label($pembanding_total_nilai);

// Untuk Profil Risiko Kantor Cabang, Profil Nilai/Profil Peringkat hanya memakai nilai inheren.
if ($isProfilCabang) {
    $total_nilai = hitung_total_bobot_inheren($rows, $bobot);
    $ket_total_nilai = nilai_label($total_nilai);
    $pembanding_total_nilai = hitung_total_bobot_inheren($rowsPembanding, $bobot);
    $pembanding_ket_total_nilai = nilai_label($pembanding_total_nilai);
}

if (isset($_GET['refresh_profil_rows']) && $_GET['refresh_profil_rows'] == '1') {
    if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'ok' => true,
        'rows' => build_risiko_rows_payload($rows),
        'rowsPembanding' => build_risiko_rows_payload($rowsPembanding),
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => (string)$ket_total_nilai,
        'pembanding_total_nilai' => n2($pembanding_total_nilai),
        'pembanding_ket_total_nilai' => (string)$pembanding_ket_total_nilai
    ]);
    exit();
}


ensure_row2($conn, 'nilai_profil', $id);
ensure_row2($conn, 'peringkat_profil', $id);
$ketNilai = get_row_safe($conn, 'nilai_profil', $id);
$ketPeringkat = get_row_safe($conn, 'peringkat_profil', $id);

// Simpan nilai hitungan otomatis ke tabel agar halaman lain tetap membaca nilai terbaru.
update_dynamic2($conn, 'nilai_profil', $id, [
    'total_nilai' => n2($total_nilai),
    'ket_total_nilai' => $ket_total_nilai,
]);
update_dynamic2($conn, 'peringkat_profil', $id, [
    'total_nilai' => n2($total_nilai),
    'ket_total_nilai' => $ket_total_nilai,
]);


if (isset($_POST['autosave_profil_tabs']) && $_POST['autosave_profil_tabs'] == '1') {
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=utf-8');
    }

    $ket_nilai_risiko = $_POST['ket_nilai_risiko'] ?? '';
    $ket_peringkat_risiko = $_POST['ket_peringkat_risiko'] ?? '';

    update_dynamic2($conn, 'nilai_profil', $id, [
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => $ket_total_nilai,
        'ket_nilai_risiko' => $ket_nilai_risiko,
    ]);

    update_dynamic2($conn, 'peringkat_profil', $id, [
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => $ket_total_nilai,
        'ket_peringkat_risiko' => $ket_peringkat_risiko,
    ]);

    echo json_encode([
        'ok' => true,
        'message' => 'Autosave berhasil',
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => (string)$ket_total_nilai
    ]);
    exit();
}

if (isset($_POST['submit'])) {
    $ket_nilai_risiko = $_POST['ket_nilai_risiko'] ?? '';
    $ket_peringkat_risiko = $_POST['ket_peringkat_risiko'] ?? '';
    update_dynamic2($conn, 'nilai_profil', $id, [
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => $ket_total_nilai,
        'ket_nilai_risiko' => $ket_nilai_risiko,
    ]);
    update_dynamic2($conn, 'peringkat_profil', $id, [
        'total_nilai' => n2($total_nilai),
        'ket_total_nilai' => $ket_total_nilai,
        'ket_peringkat_risiko' => $ket_peringkat_risiko,
    ]);
    header("Location: index.php?page=nilpro&id=$id");
    exit();
}
?>

<style>
/* Tampilan dikembalikan seperti layout lama: 2 kolom kiri-kanan, warna tetap sama */
.profile-tabs-wrap .nav-tabs{
    border-bottom:1px solid #dee2e6;
    margin-bottom:12px;
}
.profile-tabs-wrap .nav-tabs .nav-link{
    font-weight:600;
    color:#5b6b7c;
    padding:7px 18px;
    background:#f8f9fa;
    border:1px solid #dee2e6;
}
.profile-tabs-wrap .nav-tabs .nav-link.active{
    color:#536de6;
    background:#fff;
    border-bottom-color:#fff;
}
.tbl-profile-risk{
    width:100%;
    font-size:15px;
    table-layout:fixed;
}
.tbl-profile-risk th,
.tbl-profile-risk td{
    vertical-align:middle!important;
    border-color:#e4e8ee!important;
}
.tbl-profile-risk thead th{
    text-align:center;
    font-weight:700;
}
.profil-blue-head{
    background:#74c7ff!important;
    color:#050505!important;
    font-size:15px;
    font-weight:700;
    text-align:center;
}
.risk-name{
    font-size:20px!important;
    font-weight:700!important;
    color:#5b6777;
    text-align:left;
    padding:14px 12px!important;
}
.risk-val{
    text-align:center;
    font-size:18px!important;
    font-weight:700;
    color:#5b6777;
}
.quality-toggle{
    display:block;
    margin:0 auto;
    font-size:12px;
    padding:4px 10px;
    white-space:nowrap;
}
.quality-scroll{
    max-height:145px;
    overflow-y:auto;
    overflow-x:hidden;
    text-align:left;
    padding:8px 10px;
    line-height:1.45;
    white-space:normal;
    font-size:13px;
    background:#f8f9fa;
    border-radius:4px;
    margin-top:6px;
}
.quality-scroll.quality-hidden{display:none;}
.quality-scroll::-webkit-scrollbar{width:12px;}
.quality-scroll::-webkit-scrollbar-track{background:#f1f1f1;border-radius:8px;}
.quality-scroll::-webkit-scrollbar-thumb{background:#8b8b8b;border-radius:8px;}
.total-row-current th,
.total-row-current td{
    background:#00e6e6!important;
    font-size:14px!important;
    font-weight:700!important;
    text-align:center;
    height:70px;
}
.total-row-pem th,
.total-row-pem td{
    background:#ffc266!important;
    font-size:14px!important;
    font-weight:700!important;
    text-align:center;
    height:70px;
}
.uraian-head{
    background:#ffb3b3!important;
    color:#4a4a4a!important;
    font-weight:700;
    text-align:center;
}
.form-note{
    min-height:160px;
    resize:vertical;
    background:#fff;
}

.profile-pair{
    align-items:stretch;
}
.profile-pair > [class*="col-"]{
    display:flex;
}
.profile-pair > [class*="col-"] > .card{
    width:100%;
    height:100%;
}
.profile-pair .table-responsive{
    height:100%;
}
.profile-pair table{
    height:100%;
}
.profile-pair .matched-row > th,
.profile-pair .matched-row > td{
    height:inherit;
}
.autosave-status{
    display:none;
    margin-left:10px;
    font-size:12px;
    color:#6c757d;
    font-style:italic;
}
.autosave-status.show{
    display:inline-block;
}

@media print{
    .left-side-menu,.navbar-custom,.button-menu-mobile,.btn,.nav-tabs{display:none!important;}
    .content-page{margin-left:0!important;padding:0!important;}
    .tab-pane{display:block!important;opacity:1!important;}
    .quality-scroll{max-height:90px;overflow:hidden;}
    .card{box-shadow:none!important;border:0!important;}
}
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid profile-tabs-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Profil Nilai Komposit [<?= esc($frame['cabang'] ?? '') ?> Tahun <?= esc($frame['tahun'] ?? '') ?> - <?= esc($frame['periode_laporan'] ?? '') ?>]</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Penilaian Profil Risiko</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">HASIL NILAI PROFIL RISIKO</h4>
                            <hr>

                            <ul class="nav nav-tabs" id="profileRiskTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="nilai-tab" data-bs-toggle="tab" data-bs-target="#tab-nilai" type="button" role="tab">Nilai</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="peringkat-tab" data-bs-toggle="tab" data-bs-target="#tab-peringkat" type="button" role="tab">Peringkat</button>
                                </li>
                            </ul>

                            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

                            <div class="tab-content pt-2">
                                <!-- TAB NILAI -->
                                <div class="tab-pane fade show active" id="tab-nilai" role="tabpanel">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead class="table-d" bgcolor="#74c7ff">
                                                <tr style="color:#050505;">
                                                    <th class="profil-blue-head" colspan="<?= $isProfilCabang ? 2 : 9 ?>"><center>PROFIL NILAI</center></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="row profile-pair">
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-centered mb-0 tbl-profile-risk tbl-current">
                                                        <thead bgcolor="#00e6e6">
                                                            <tr>
                                                                <th colspan="<?= $isProfilCabang ? 2 : 5 ?>"><center><b>Penilaian Profil Risiko<br>(<?= esc($frame['tipe_user'] ?? '') ?> <?= esc($frame['cabang'] ?? '') ?> Tahun <?= esc($frame['tahun'] ?? '') ?> - <?= esc($frame['periode_laporan'] ?? '') ?>)</b></center></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Jenis Risiko</center></th>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Tingkat Risiko Inheren</center></th>
                                                                <?php if (!$isProfilCabang) { ?>
                                                                <th width="20%"><center>Tingkat KPMR</center></th>
                                                                <th width="20%"><center>Tingkat Risiko</center></th>
                                                                <th width="40%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?= render_rows($rows, $bobot, 'nilai', $isProfilCabang) ?>
                                                            <?php if ($isProfilCabang) { ?>
                                                            <tr class="total-row-current matched-row">
                                                                <th><center>Peringkat Risiko Inheren ditetapkan berdasarkan pertimbangan BPR</center></th>
                                                                <td><center><?= n2($total_nilai) ?><br><b><?= esc($ket_total_nilai) ?></b></center></td>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <tr class="total-row-current matched-row">
                                                                <th colspan="3"><center>Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR</center></th>
                                                                <td><center><?= n2($total_nilai) ?></center></td>
                                                                <td><center><?= esc($ket_total_nilai) ?></center></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-centered mb-0 tbl-profile-risk tbl-pembanding">
                                                        <thead bgcolor="#ffc266">
                                                            <tr>
                                                                <th colspan="<?= $isProfilCabang ? 2 : 5 ?>"><center><b>Pembanding<br>(<?= esc($frame_pem['tipe_user'] ?? '') ?> <?= esc($frame_pem['cabang'] ?? '') ?> Tahun <?= esc($frame_pem['tahun'] ?? '') ?> - <?= esc($frame_pem['periode_laporan'] ?? '') ?>)</b></center></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Jenis Risiko</center></th>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Tingkat Risiko Inheren</center></th>
                                                                <?php if (!$isProfilCabang) { ?>
                                                                <th width="20%"><center>Tingkat KPMR</center></th>
                                                                <th width="20%"><center>Tingkat Risiko</center></th>
                                                                <th width="20%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?= render_rows($rowsPembanding, $bobot, 'nilai', $isProfilCabang) ?>
                                                            <?php if ($isProfilCabang) { ?>
                                                            <tr class="total-row-pem matched-row">
                                                                <th><center>Dikutip dari laporan sebelumnya</center></th>
                                                                <td><center><?= n2($pembanding_total_nilai) ?><br><b><?= esc($pembanding_ket_total_nilai) ?></b></center></td>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <tr class="total-row-pem matched-row">
                                                                <th colspan="3"><center>Dikutip dari laporan sebelumnya</center></th>
                                                                <td><center><?= n2($pembanding_total_nilai) ?></center></td>
                                                                <td><center><?= esc($pembanding_ket_total_nilai) ?></center></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br><hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead bgcolor="#ffb3b3">
                                                <tr><th class="uraian-head"><center>Uraian</center></th></tr>
                                            </thead>
                                            <tbody bgcolor="#edebe8">
                                                <tr>
                                                    <td>
                                                        <textarea class="form-control form-note autosave-note-tabs" form="my_form" name="ket_nilai_risiko" cols="60" rows="8" <?= (($frame['kunci_laporan'] ?? 0) == 1 ? 'readonly' : '') ?>><?= esc($ketNilai['ket_nilai_risiko'] ?? '') ?></textarea>
                                                        <span class="autosave-status" id="autosaveStatusNilai">tersimpan...</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- TAB PERINGKAT -->
                                <div class="tab-pane fade" id="tab-peringkat" role="tabpanel">
                                    <div class="table-responsive mb-3">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead class="table-d" bgcolor="#74c7ff">
                                                <tr style="color:#050505;">
                                                    <th class="profil-blue-head" colspan="<?= $isProfilCabang ? 2 : 9 ?>"><center>PROFIL PERINGKAT</center></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>

                                    <div class="row profile-pair">
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-centered mb-0 tbl-profile-risk tbl-current">
                                                        <thead bgcolor="#00e6e6">
                                                            <tr>
                                                                <th colspan="<?= $isProfilCabang ? 2 : 5 ?>"><center><b>Penilaian Profil Risiko<br>(<?= esc($frame['tipe_user'] ?? '') ?> <?= esc($frame['cabang'] ?? '') ?> Tahun <?= esc($frame['tahun'] ?? '') ?> - <?= esc($frame['periode_laporan'] ?? '') ?>)</b></center></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Jenis Risiko</center></th>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Tingkat Risiko Inheren</center></th>
                                                                <?php if (!$isProfilCabang) { ?>
                                                                <th width="20%"><center>Tingkat KPMR</center></th>
                                                                <th width="20%"><center>Tingkat Risiko</center></th>
                                                                <th width="40%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?= render_rows($rows, $bobot, 'peringkat', $isProfilCabang) ?>
                                                            <?php if ($isProfilCabang) { ?>
                                                            <tr class="total-row-current matched-row">
                                                                <th><center>Peringkat Risiko Inheren ditetapkan berdasarkan pertimbangan BPR</center></th>
                                                                <td><center><?= n2($total_nilai) ?><br><b><?= esc($ket_total_nilai) ?></b></center></td>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <tr class="total-row-current matched-row">
                                                                <th colspan="3"><center>Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR</center></th>
                                                                <td><center><?= n2($total_nilai) ?></center></td>
                                                                <td><center><?= esc($ket_total_nilai) ?></center></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="card">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-centered mb-0 tbl-profile-risk tbl-pembanding">
                                                        <thead bgcolor="#ffc266">
                                                            <tr>
                                                                <th colspan="<?= $isProfilCabang ? 2 : 5 ?>"><center><b>Pembanding<br>(<?= esc($frame_pem['tipe_user'] ?? '') ?> <?= esc($frame_pem['cabang'] ?? '') ?> Tahun <?= esc($frame_pem['tahun'] ?? '') ?> - <?= esc($frame_pem['periode_laporan'] ?? '') ?>)</b></center></th>
                                                            </tr>
                                                            <tr>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Jenis Risiko</center></th>
                                                                <th width="<?= $isProfilCabang ? '50%' : '20%' ?>"><center>Tingkat Risiko Inheren</center></th>
                                                                <?php if (!$isProfilCabang) { ?>
                                                                <th width="20%"><center>Tingkat KPMR</center></th>
                                                                <th width="20%"><center>Tingkat Risiko</center></th>
                                                                <th width="20%"><center>Tingkat Kualitas Manajemen Risiko</center></th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?= render_rows($rowsPembanding, $bobot, 'peringkat', $isProfilCabang) ?>
                                                            <?php if ($isProfilCabang) { ?>
                                                            <tr class="total-row-pem matched-row">
                                                                <th><center>Dikutip dari laporan sebelumnya</center></th>
                                                                <td><center><?= n2($pembanding_total_nilai) ?><br><b><?= esc($pembanding_ket_total_nilai) ?></b></center></td>
                                                            </tr>
                                                            <?php } else { ?>
                                                            <tr class="total-row-pem matched-row">
                                                                <th colspan="3"><center>Dikutip dari laporan sebelumnya</center></th>
                                                                <td><center><?= n2($pembanding_total_nilai) ?></center></td>
                                                                <td><center><?= esc($pembanding_ket_total_nilai) ?></center></td>
                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br><hr>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead bgcolor="#ffb3b3">
                                                <tr><th class="uraian-head"><center>Uraian</center></th></tr>
                                            </thead>
                                            <tbody bgcolor="#edebe8">
                                                <tr>
                                                    <td>
                                                        <textarea class="form-control form-note autosave-note-tabs" form="my_form" name="ket_peringkat_risiko" cols="60" rows="8" <?= (($frame['kunci_laporan'] ?? 0) == 1 ? 'readonly' : '') ?>><?= esc($ketPeringkat['ket_peringkat_risiko'] ?? '') ?></textarea>
                                                        <span class="autosave-status" id="autosaveStatusPeringkat">tersimpan...</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <!-- Tombol Simpan dihapus karena uraian sudah autosave -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script>
(function(){
    function matchTableHeights(scope){
        var panes = scope ? [scope] : Array.prototype.slice.call(document.querySelectorAll('.tab-pane'));
        panes.forEach(function(pane){
            var left = pane.querySelector('table.tbl-current');
            var right = pane.querySelector('table.tbl-pembanding');
            if (!left || !right) return;

            var lRows = Array.prototype.slice.call(left.querySelectorAll('tbody tr.matched-row'));
            var rRows = Array.prototype.slice.call(right.querySelectorAll('tbody tr.matched-row'));
            var len = Math.min(lRows.length, rRows.length);

            lRows.forEach(function(r){ r.style.height = ''; });
            rRows.forEach(function(r){ r.style.height = ''; });

            for (var i = 0; i < len; i++) {
                var h = Math.max(lRows[i].offsetHeight, rRows[i].offsetHeight);
                lRows[i].style.height = h + 'px';
                rRows[i].style.height = h + 'px';
            }
        });
    }

    function showStatus(el){
        if (!el) return;
        el.classList.add('show');
        clearTimeout(el._hideTimer);
        el._hideTimer = setTimeout(function(){ el.classList.remove('show'); }, 1400);
    }

    var fields = Array.prototype.slice.call(document.querySelectorAll('.autosave-note-tabs')).filter(function(el){
        return !el.hasAttribute('readonly');
    });

    var saveTimer = null;
    var isSaving = false;
    var pending = false;
    var lastPayload = payload();

    function payload(){
        return fields.map(function(el){
            return el.name + '=' + encodeURIComponent(el.value || '');
        }).join('&');
    }

    function buildFormData(){
        var fd = new FormData();
        fd.append('autosave_profil_tabs', '1');
        fields.forEach(function(el){
            fd.append(el.name, el.value || '');
        });
        return fd;
    }

    function doSave(force, changedField){
        var current = payload();
        if (!force && current === lastPayload) return;
        if (isSaving) { pending = true; return; }

        isSaving = true;
        pending = false;

        fetch(window.location.href, {
            method: 'POST',
            body: buildFormData(),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        }).then(function(r){ return r.text(); })
        .then(function(txt){
            try {
                var res = JSON.parse(txt);
                if (res && res.ok) {
                    lastPayload = payload();
                    if (changedField && changedField.name === 'ket_nilai_risiko') showStatus(document.getElementById('autosaveStatusNilai'));
                    if (changedField && changedField.name === 'ket_peringkat_risiko') showStatus(document.getElementById('autosaveStatusPeringkat'));
                } else {
                    console.error('Autosave gagal:', res && res.message ? res.message : txt);
                }
            } catch(e) {
                console.error('Autosave response invalid:', txt);
            }
        }).catch(function(err){
            console.error('Autosave error:', err);
        }).finally(function(){
            isSaving = false;
            if (pending) {
                clearTimeout(saveTimer);
                saveTimer = setTimeout(function(){ doSave(true, changedField); }, 300);
            }
        });
    }

    fields.forEach(function(el){
        el.addEventListener('input', function(){
            var field = el;
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function(){ doSave(false, field); }, 700);
        });
        el.addEventListener('change', function(){ doSave(true, el); });
        el.addEventListener('blur', function(){ doSave(true, el); });
        el.addEventListener('paste', function(){
            var field = el;
            clearTimeout(saveTimer);
            saveTimer = setTimeout(function(){ doSave(false, field); }, 700);
        });
    });

    window.addEventListener('beforeunload', function(){
        clearTimeout(saveTimer);
        if (payload() === lastPayload) return;
        if (navigator.sendBeacon) {
            navigator.sendBeacon(window.location.href, buildFormData());
        }
    });


    document.querySelectorAll('.quality-toggle').forEach(function(btn){
        btn.addEventListener('click', function(){
            var box = btn.nextElementSibling;
            if (!box) return;
            var hidden = box.classList.contains('quality-hidden');
            if (hidden) {
                box.classList.remove('quality-hidden');
                btn.innerHTML = '&#128065;'; btn.title = 'Sembunyikan';
            } else {
                box.classList.add('quality-hidden');
                btn.innerHTML = '&#128065;'; btn.title = 'Tampilkan';
            }
            setTimeout(function(){ matchTableHeights(); }, 50);
        });
    });

    window.addEventListener('load', function(){ setTimeout(function(){ matchTableHeights(); }, 200); });
    window.addEventListener('resize', function(){ setTimeout(function(){ matchTableHeights(); }, 150); });

    document.querySelectorAll('[data-bs-toggle="tab"]').forEach(function(btn){
        btn.addEventListener('shown.bs.tab', function(e){
            var target = document.querySelector(e.target.getAttribute('data-bs-target'));
            setTimeout(function(){ matchTableHeights(target); }, 120);
        });
    });

    setTimeout(function(){ matchTableHeights(); }, 500);

    function escapeHtml(s){
        return String(s == null ? '' : s)
            .replace(/&/g,'&amp;')
            .replace(/</g,'&lt;')
            .replace(/>/g,'&gt;')
            .replace(/"/g,'&quot;')
            .replace(/'/g,'&#039;');
    }

    function setCell(tableClass, risk, field, value){
        document.querySelectorAll(tableClass + ' tr.risk-row[data-risk="'+risk+'"] [data-field="'+field+'"]').forEach(function(td){
            if (field === 'kualitas') return;
            td.innerHTML = '<b>' + escapeHtml(value) + '</b>';
        });
    }

    function updateQuality(tableClass, risk, value){
        document.querySelectorAll(tableClass + ' tr.risk-row[data-risk="'+risk+'"] [data-field="kualitas"]').forEach(function(td){
            var hasText = String(value || '').trim() !== '';
            var btnClass = hasText ? 'btn-outline-primary' : 'btn-outline-secondary';
            var disabled = hasText ? '' : ' disabled';
            var currentOpen = td.querySelector('.quality-scroll') && !td.querySelector('.quality-scroll').classList.contains('quality-hidden');
            td.innerHTML =
                '<button type="button" class="btn btn-sm '+btnClass+' quality-toggle live-quality-toggle" title="'+(hasText ? 'Tampilkan' : 'Kosong')+'"'+disabled+'><span aria-hidden="true">&#128065;</span></button>' +
                '<div class="quality-scroll '+(currentOpen ? '' : 'quality-hidden')+'"><b>'+escapeHtml(value || '')+'</b></div>';
        });
    }

    function bindLiveQualityButtons(){
        document.querySelectorAll('.live-quality-toggle').forEach(function(btn){
            if (btn._bound) return;
            btn._bound = true;
            btn.addEventListener('click', function(){
                var box = btn.nextElementSibling;
                if (!box) return;
                box.classList.toggle('quality-hidden');
                btn.title = box.classList.contains('quality-hidden') ? 'Tampilkan' : 'Sembunyikan';
                setTimeout(function(){ matchTableHeights(); }, 50);
            });
        });
    }

    function refreshProfilRows(){
        var url = new URL(window.location.href);
        url.searchParams.set('refresh_profil_rows', '1');
        fetch(url.toString(), {headers:{'X-Requested-With':'XMLHttpRequest'}})
        .then(function(r){ return r.json(); })
        .then(function(res){
            if (!res || !res.ok) return;
            Object.keys(res.rows || {}).forEach(function(risk){
                var row = res.rows[risk] || {};
                setCell('.tbl-current', risk, 'nilai_inheren', row.nilai_inheren);
                setCell('.tbl-current', risk, 'nilai_kpmr', row.nilai_kpmr);
                setCell('.tbl-current', risk, 'nilai_tingkat', row.nilai_tingkat);
                setCell('.tbl-current', risk, 'peringkat_inheren', row.peringkat_inheren);
                setCell('.tbl-current', risk, 'peringkat_kpmr', row.peringkat_kpmr);
                setCell('.tbl-current', risk, 'peringkat_tingkat', row.peringkat_tingkat);
                updateQuality('.tbl-current', risk, row.kualitas);
            });
            Object.keys(res.rowsPembanding || {}).forEach(function(risk){
                var row = res.rowsPembanding[risk] || {};
                setCell('.tbl-pembanding', risk, 'nilai_inheren', row.nilai_inheren);
                setCell('.tbl-pembanding', risk, 'nilai_kpmr', row.nilai_kpmr);
                setCell('.tbl-pembanding', risk, 'nilai_tingkat', row.nilai_tingkat);
                setCell('.tbl-pembanding', risk, 'peringkat_inheren', row.peringkat_inheren);
                setCell('.tbl-pembanding', risk, 'peringkat_kpmr', row.peringkat_kpmr);
                setCell('.tbl-pembanding', risk, 'peringkat_tingkat', row.peringkat_tingkat);
                updateQuality('.tbl-pembanding', risk, row.kualitas);
            });
            document.querySelectorAll('.total-row-current td:nth-last-child(2), .total-row-current td:first-of-type').forEach(function(el){ el.innerHTML = '<center>'+escapeHtml(res.total_nilai)+'</center>'; });
            document.querySelectorAll('.total-row-current td:last-child').forEach(function(el){ el.innerHTML = '<center>'+escapeHtml(res.ket_total_nilai)+'</center>'; });
            document.querySelectorAll('.total-row-pem td:nth-last-child(2), .total-row-pem td:first-of-type').forEach(function(el){ el.innerHTML = '<center>'+escapeHtml(res.pembanding_total_nilai)+'</center>'; });
            document.querySelectorAll('.total-row-pem td:last-child').forEach(function(el){ el.innerHTML = '<center>'+escapeHtml(res.pembanding_ket_total_nilai)+'</center>'; });
            bindLiveQualityButtons();
            setTimeout(function(){ matchTableHeights(); }, 50);
        }).catch(function(e){});
    }

    bindLiveQualityButtons();
    setInterval(refreshProfilRows, 3000);

})();
</script>

