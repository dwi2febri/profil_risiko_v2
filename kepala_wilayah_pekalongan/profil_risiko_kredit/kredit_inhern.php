<?php
function fmt2($v){
    if ($v === null || $v === '') return '0.00';
    $v = (float)$v;
    if (function_exists('is_nan') && is_nan($v)) return '0.00';
    if (function_exists('is_infinite') && is_infinite($v)) return '0.00';
    return number_format($v, 2, '.', '');
}

function safe_pct_kredit($pembilang, $penyebut){
    $pembilang = (float)$pembilang;
    $penyebut  = (float)$penyebut;

    if ($penyebut == 0) return 0;
    if (function_exists('is_nan') && is_nan($penyebut)) return 0;
    if (function_exists('is_infinite') && is_infinite($penyebut)) return 0;

    $hasil = ($pembilang / $penyebut) * 100;

    if (function_exists('is_nan') && is_nan($hasil)) return 0;
    if (function_exists('is_infinite') && is_infinite($hasil)) return 0;

    return round($hasil, 2);
}

if (!function_exists('hasil_excel_rumus_koreksi_kredit')) {
function hasil_excel_rumus_koreksi_kredit($rumus, $koreksi){
    $rumus = (float)$rumus;

    // Bila koreksi belum dipilih, tampilkan hasil rumus otomatis.
    if ($koreksi === null || $koreksi === '' || !is_numeric($koreksi)) {
        return round($rumus, 2);
    }

    $koreksi = (float)$koreksi;

    // Sama persis dengan Excel:
    // =IF(koreksi < rumus; rumus; (rumus + koreksi) / 2)
    return round($koreksi < $rumus ? $rumus : (($rumus + $koreksi) / 2), 2);
}}
?><?php
if (empty($id) || $id === null) {
  // Display modal notification on page load
  $displayModal = true;
} else {
  $displayModal = false;
}
?>
<script>
  $(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#myModal').modal('show');
    <?php } ?>
  });

  window.onclick = null;
  
</script>



<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Notifikasi</h5>
        <a href="javascript:history.back()"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
      <h5><center><b>Mohon untuk memilih laporan risiko di (menu dashboard -> laporan profil risiko -> klik (aktif)) terlebih dahulu.</b></center></h5>
      </div>
      <div class="modal-footer">
      <a href="javascript:history.back()"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
      </div>
    </div>
  </div>
</div>




<?php
include "../fungsi/fungsi.php";

if (!function_exists('table_exists_local')) {
function table_exists_local($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}}
if (!function_exists('column_exists_local')) {
function column_exists_local($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}}

if (!function_exists('ensure_column_local')) {
function ensure_column_local($conn, $table, $column, $definition){
    if (!table_exists_local($conn, $table)) return;
    if (column_exists_local($conn, $table, $column)) return;
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $sql = "ALTER TABLE `$table` ADD COLUMN `$column` " . $definition;
    must_query_local($conn, $sql, 'ALTER TABLE '.$table.' ADD '.$column);
}}

if (!function_exists('must_query_local')) {
function must_query_local($conn, $sql, $label = 'SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        $msg = $label . ' ERROR: ' . mysqli_error($conn);
        if (
            (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower((string)$_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || isset($_POST['autosave'])
        ) {
            if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => $msg, 'sql' => $sql]);
            exit();
        }
        die('<pre style="white-space:pre-wrap;background:#fff;padding:16px;">'.htmlspecialchars($msg.' | '.$sql, ENT_QUOTES, 'UTF-8').'</pre>');
    }
    return $res;
}}

if (!function_exists('ensure_id_profil_risiko_row_local')) {
function ensure_id_profil_risiko_row_local($conn, $table, $id_profil_risiko){
    if (!table_exists_local($conn, $table)) return;
    if (!column_exists_local($conn, $table, 'id_profil_risiko')) return;
    $id_profil_risiko = (int)$id_profil_risiko;
    $cek = mysqli_query($conn, "SELECT id_profil_risiko FROM `$table` WHERE id_profil_risiko = '$id_profil_risiko' LIMIT 1");
    if ($cek && mysqli_num_rows($cek) > 0) return;
    must_query_local($conn, "INSERT INTO `$table` (id_profil_risiko) VALUES ('$id_profil_risiko')", 'INSERT default row '.$table);
}}

if (!function_exists('esc_post_local')) {
function esc_post_local($conn, $key, $default = ''){
    $val = isset($_POST[$key]) ? $_POST[$key] : $default;
    return mysqli_real_escape_string($conn, (string)$val);
}}




$id = $_GET['id'];
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = ?", [$id]));
$frame_laporan_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT user,tahun,periode,data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));
$jenis_pr = $frame_laporan_kredit['user'];
$tahun = $frame_laporan_kredit['tahun'];
$periode = $frame_laporan_kredit['periode'];
$dp = $frame_laporan_kredit['data_pembanding'];

// pastikan row target autosave selalu ada
ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar1', $id);
ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar2', $id);
ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar3', $id);
ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar4', $id);
ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_lainnya', $id);
ensure_id_profil_risiko_row_local($conn, 'hasil_inheren_kredit', $id);
ensure_id_profil_risiko_row_local($conn, 'keterangan_inheren_kredit', $id);
ensure_column_local($conn, 'inheren_kredit_pilar2', 'pilar2_1', "DECIMAL(10,2) NULL DEFAULT NULL AFTER hasil_pil2_par1");

$report_divisi_tetapan = 0;
if (table_exists_local($conn, 'frame_laporan_profil_risiko') && column_exists_local($conn, 'frame_laporan_profil_risiko', 'id_divisi_tetapan')) {
    $qDiv = simpro_db_query($conn, "SELECT id_divisi_tetapan FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ? LIMIT 1", [$id]);
    if ($qDiv && mysqli_num_rows($qDiv) > 0) {
        $rDiv = mysqli_fetch_assoc($qDiv);
        $report_divisi_tetapan = isset($rDiv['id_divisi_tetapan']) ? (int)$rDiv['id_divisi_tetapan'] : 0;
    }
}



$length = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_pil1_1) AS l1,
CHAR_LENGTH(ket_pil1_2) AS l2,
CHAR_LENGTH(ket_pil1_3) AS l3,
CHAR_LENGTH(ket_pil1_4) AS l4,
CHAR_LENGTH(ket_pil1) AS l5,
CHAR_LENGTH(ket_pil2_1) AS l6,
CHAR_LENGTH(ket_pil2_2) AS l7,
CHAR_LENGTH(ket_pil2_3) AS l8,
CHAR_LENGTH(ket_pil2) AS l9,
CHAR_LENGTH(ket_pil3_1) AS l10,
CHAR_LENGTH(ket_pil3) AS l11,
CHAR_LENGTH(ket_pil4_1) AS l12,
CHAR_LENGTH(ket_pil4) AS l13,
CHAR_LENGTH(ket_pil5_1) AS l14,
CHAR_LENGTH(ket_pil5) AS l15,
CHAR_LENGTH(ket_inheren) AS l16 FROM keterangan_inheren_kredit WHERE id_profil_risiko = ?", [$id]));

$master_kredit_P1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = ?", [$id]));
$master_kredit_P2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar2 WHERE id_profil_risiko = ?", [$id]));
$master_kredit_P3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pilar2_1_selected = (isset($pil2['pilar2_1']) && $pil2['pilar2_1'] !== '' ? (float)$pil2['pilar2_1'] : 0);
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = ?", [$id]));
$pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pilar2_1 = (isset($pembanding_pil2['pilar2_1']) && $pembanding_pil2['pilar2_1'] !== '' ? (float)$pembanding_pil2['pilar2_1'] : 0);
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = ?", [$dp]));

$hasil = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = ?", [$id]));


// ambil setting aktif dari halaman Perumusan Risiko (aktif per user/divisi)
$frame_perumusan_aktif = null;
$perumusan_header = [];
$perumusan_detail_map = [];
$has_setris_active = false;
$setris_mode = 'perskalaan';
$inheren = [];

$where_divisi_perumusan = '';
if ($report_divisi_tetapan > 0 && table_exists_local($conn, 'frame_perumusan') && column_exists_local($conn, 'frame_perumusan', 'id_divisi_tetapan')) {
    $where_divisi_perumusan = " AND COALESCE(id_divisi_tetapan,0) = '".(int)$report_divisi_tetapan."'";
}

if (table_exists_local($conn, 'frame_perumusan') && column_exists_local($conn, 'frame_perumusan', 'is_aktif')) {
    $q_frame_perumusan_aktif = mysqli_query($conn, "
        SELECT *
        FROM frame_perumusan
        WHERE user_id = '$jenis_pr'
          AND is_aktif = '1'
          $where_divisi_perumusan
        ORDER BY id_frame_perumusan DESC
        LIMIT 1
    ");
    if ($q_frame_perumusan_aktif && mysqli_num_rows($q_frame_perumusan_aktif) > 0) {
        $frame_perumusan_aktif = mysqli_fetch_assoc($q_frame_perumusan_aktif);
    }

    // fallback: jika laporan bukan setting divisi spesifik atau kolom divisi belum sinkron
    if (empty($frame_perumusan_aktif)) {
        $q_frame_perumusan_aktif = simpro_db_query($conn, "
            SELECT *
            FROM frame_perumusan
            WHERE user_id = ?
              AND is_aktif = '1'
            ORDER BY id_frame_perumusan DESC
            LIMIT 1
        ", [$jenis_pr]);
        if ($q_frame_perumusan_aktif && mysqli_num_rows($q_frame_perumusan_aktif) > 0) {
            $frame_perumusan_aktif = mysqli_fetch_assoc($q_frame_perumusan_aktif);
        }
    }
}

if (!empty($frame_perumusan_aktif)) {
    $id_frame_perumusan_aktif = (int)$frame_perumusan_aktif['id_frame_perumusan'];

    $q_perumusan_header = simpro_db_query($conn, "
        SELECT *
        FROM perumusan_inheren
        WHERE id_frame_perumusan = ?
          AND (
                UPPER(nama_risiko) = 'RISIKO KREDIT'
             OR UPPER(nama_risiko) = 'KREDIT'
             OR UPPER(nama_risiko) = 'INHEREN KREDIT'
             OR UPPER(nama_risiko) LIKE '%KREDIT%'
          )
        ORDER BY id_perumusan_inheren DESC
        LIMIT 1
    ", [$id_frame_perumusan_aktif]);
    if ($q_perumusan_header && mysqli_num_rows($q_perumusan_header) > 0) {
        $perumusan_header = mysqli_fetch_assoc($q_perumusan_header);

        $q_perumusan_detail = mysqli_query($conn, "
            SELECT *
            FROM perumusan_inheren_pilar
            WHERE id_perumusan_inheren = '".$perumusan_header['id_perumusan_inheren']."'
              AND id_pilar <> 99
            ORDER BY id_pilar ASC
        ");
        while ($r_detail = mysqli_fetch_assoc($q_perumusan_detail)) {
            $perumusan_detail_map[(int)$r_detail['id_pilar']] = $r_detail;
        }

        // cukup dianggap aktif jika header perumusan kredit ketemu
        $has_setris_active = true;
        $setris_mode = ((int)$perumusan_header['pembobotan'] === 1) ? 'pembobotan' : 'perskalaan';

        $inheren['inheren_kre_set_pil1'] = isset($perumusan_detail_map[1]['perskalaan_metode']) ? (int)$perumusan_detail_map[1]['perskalaan_metode'] : 1;
        $inheren['inheren_kre_set_pil2'] = isset($perumusan_detail_map[2]['perskalaan_metode']) ? (int)$perumusan_detail_map[2]['perskalaan_metode'] : 1;
        $inheren['inheren_kre_set_pil3'] = isset($perumusan_detail_map[3]['perskalaan_metode']) ? (int)$perumusan_detail_map[3]['perskalaan_metode'] : 1;
        $inheren['inheren_kre_set_pil4'] = isset($perumusan_detail_map[4]['perskalaan_metode']) ? (int)$perumusan_detail_map[4]['perskalaan_metode'] : 1;
        $inheren['inheren_kre_set_pil5'] = isset($perumusan_detail_map[5]['perskalaan_metode']) ? (int)$perumusan_detail_map[5]['perskalaan_metode'] : 1;

        // tingkat risiko tidak lagi diinput khusus pada setting, default tertinggi
        $inheren['inheren_kre_set_tingkat_risiko'] = 1;
    }
}

$ket_inhern_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren_kredit WHERE id_profil_risiko = ?", [$id]));


$ambang_batas_kredit = mysqli_fetch_array(simpro_db_query($conn, "
    SELECT *
    FROM ambang_batas_kredit
    WHERE user = ?
      AND is_active = '1'
    ORDER BY id_ambang_batas_kredit DESC
    LIMIT 1
", [$jenis_pr]));
$has_ambang_active = is_array($ambang_batas_kredit) && !empty($ambang_batas_kredit);

$bobot_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));

$info_kuantitatif_kredit = [];
$cek_info_kuantitatif_kredit = mysqli_query($conn, "SHOW TABLES LIKE 'info_kuantitatif_inheren'");
if ($cek_info_kuantitatif_kredit && mysqli_num_rows($cek_info_kuantitatif_kredit) > 0) {
    $q_info_kuantitatif_kredit = mysqli_query($conn, "SELECT parameter_key, info_text FROM info_kuantitatif_inheren WHERE risiko='kredit'");
    while ($iq = mysqli_fetch_assoc($q_info_kuantitatif_kredit)) {
        $info_kuantitatif_kredit[$iq['parameter_key']] = $iq['info_text'];
    }
}

function kredit_info_kuantitatif_btn($map, $key){
    $txt = trim((string)($map[$key] ?? ''));
    if ($txt === '') $txt = 'Info kuantitatif untuk parameter ini belum diisi.';
    return '<button type="button" class="info-kuantitatif-btn" data-info="'.htmlspecialchars($txt, ENT_QUOTES, 'UTF-8').'" title="Info kuantitatif"><i class="mdi mdi-information-outline"></i></button>';
}

//pembobotan
function bobot_default_kredit($field){
    $defaults = [
        // Pilar 1 parameter 1 = 7 sub parameter
        'sub_parameter1'  => round(1/7, 2),
        'sub_parameter2'  => round(1/7, 2),
        'sub_parameter3'  => round(1/7, 2),
        'sub_parameter4'  => round(1/7, 2),
        'sub_parameter5'  => round(1/7, 2),
        'sub_parameter6'  => round(1/7, 2),
        'sub_parameter7'  => round(1/7, 2),
        'sub_parameter8'  => round(1/7, 2),

        // Pilar 1 parameter 2 = 11 sub parameter
        'sub_parameter2_1'  => round(1/11, 2),
        'sub_parameter2_2'  => round(1/11, 2),
        'sub_parameter2_3'  => round(1/11, 2),
        'sub_parameter2_4'  => round(1/11, 2),
        'sub_parameter2_5'  => round(1/11, 2),
        'sub_parameter2_6'  => round(1/11, 2),
        'sub_parameter2_7'  => round(1/11, 2),
        'sub_parameter2_8'  => round(1/11, 2),
        'sub_parameter2_9'  => round(1/11, 2),
        'sub_parameter2_10' => round(1/11, 2),
        'sub_parameter2_11' => round(1/11, 2),

        // Pilar 2 parameter 2 = 6 sub parameter
        'sub_parameter3_1' => round(1/6, 2),
        'sub_parameter3_2' => round(1/6, 2),
        'sub_parameter3_3' => round(1/6, 2),
        'sub_parameter3_4' => round(1/6, 2),
        'sub_parameter3_5' => round(1/6, 2),
        'sub_parameter3_6' => round(1/6, 2),

        // Pilar 2 parameter 3 = 4 sub parameter
        'sub_parameter4_1' => round(1/4, 2),
        'sub_parameter4_2' => round(1/4, 2),
        'sub_parameter4_3' => round(1/4, 2),
        'sub_parameter4_4' => round(1/4, 2),

        // Pilar 3 : Strategi Penyediaan Dana (SK Limit)
        'sub_parameter5_1' => 0.50,

        // Pilar 4 = 4 sub parameter
        'sub_parameter6_1' => round(1/4, 2),
        'sub_parameter6_2' => round(1/4, 2),
        'sub_parameter6_3' => round(1/4, 2),
        'sub_parameter6_4' => round(1/4, 2),

        // Lainnya = 2 sub parameter
        'sub_parameter7_1' => round(1/2, 2),
        'sub_parameter7_2' => round(1/2, 2),
    ];
    return isset($defaults[$field]) ? (float)$defaults[$field] : 0;
}

function bobot_value_kredit($row, $field){
    if (is_array($row) && isset($row[$field]) && $row[$field] !== '' && $row[$field] !== null) {
        return (float)$row[$field];
    }
    return bobot_default_kredit($field);
}


// FIX EXCEL: ambil ambang numerik dengan fallback aman.
// Beberapa field ambang lanjutan bisa kosong/0 sehingga hasil turun ke peringkat yang salah.
function ambang_kredit_num($row, $field, $fallback){
    if (is_array($row) && isset($row[$field]) && $row[$field] !== '' && $row[$field] !== null) {
        $v = (float)$row[$field];
        if ($v > 0) return $v;
    }
    return (float)$fallback;
}

function setris_method_label_kredit($metode){
    $metode = (int)$metode;
    if ($metode === 1) return 'Tertinggi';
    if ($metode === 2) return 'Terendah';
    return 'Rata-rata';
}
function setris_pick_value_kredit($mode, $metode, $bobot, $max, $min, $avg){
    $mode = strtolower((string)$mode);
    $max = (float)$max; $min = (float)$min; $avg = (float)$avg; $bobot = (float)$bobot;
    if ($mode === 'pembobotan') {
        return round($avg * ($bobot / 100), 2);
    }
    $metode = (int)$metode;
    if ($metode === 1) return round($max, 2);
    if ($metode === 2) return round($min, 2);
    return round($avg, 2);
}
function setris_display_html_kredit($id, $mode, $metode, $bobot){
    if (strtolower((string)$mode) === 'pembobotan') {
        return '<input type="text" class="form-control" id="'.htmlspecialchars($id, ENT_QUOTES).'" value="Bobot '.number_format((float)$bobot,2,'.','').'%" readonly>';
    }
    $m = (int)$metode;
    $html = '<select class="form-select" id="'.htmlspecialchars($id, ENT_QUOTES).'" disabled>';
    $html .= '<option value="1" '.($m === 1 ? 'selected' : '').'>Tertinggi</option>';
    $html .= '<option value="2" '.($m === 2 ? 'selected' : '').'>Terendah</option>';
    $html .= '<option value="3" '.($m === 3 ? 'selected' : '').'>Rata-rata</option>';
    $html .= '</select>';
    return $html;
}

// ambil setting bobot berdasarkan tahun + user/profil risiko dari id_profil_risiko
$pembobotan = mysqli_fetch_array(simpro_db_query($conn, "
    SELECT bkp.*
    FROM frame_bobot fb
    INNER JOIN bobot_kredit_per_parameter bkp ON fb.id_bobot = bkp.id_bobot
    WHERE fb.user  = ?
      AND fb.is_aktif = '1'
    ORDER BY fb.id_bobot DESC
    LIMIT 1
", [$jenis_pr]));

$has_bobot_active = is_array($pembobotan) && !empty($pembobotan);

if (!$has_bobot_active || !$has_ambang_active || !$has_setris_active) {
?>
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Risiko Kredit Inhern [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #5bf553; color: white;">
                            <h4 class="page-title">Risiko Kredit Inheren</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-warning mb-0">
                                <b>Setting aktif belum lengkap.</b><br>
                                <?php if (!$has_ambang_active && !$has_bobot_active && !$has_setris_active): ?>
                                    Ambang batas, bobot faktor, dan setting tingkat risiko untuk jenis profil risiko ini belum diaktifkan.
                                <?php elseif (!$has_ambang_active && !$has_bobot_active): ?>
                                    Ambang batas dan bobot faktor untuk jenis profil risiko ini belum diaktifkan.
                                <?php elseif (!$has_ambang_active && !$has_setris_active): ?>
                                    Ambang batas dan setting tingkat risiko untuk jenis profil risiko ini belum diaktifkan.
                                <?php elseif (!$has_bobot_active && !$has_setris_active): ?>
                                    Bobot faktor dan setting tingkat risiko untuk jenis profil risiko ini belum diaktifkan.
                                <?php elseif (!$has_ambang_active): ?>
                                    Ambang batas untuk jenis profil risiko ini belum diaktifkan.
                                <?php elseif (!$has_bobot_active): ?>
                                    Bobot faktor untuk jenis profil risiko ini belum diaktifkan.
                                <?php else: ?>
                                    Setting tingkat risiko untuk jenis profil risiko ini belum diaktifkan.
                                <?php endif; ?>
                                <br><br>
                                Silakan aktifkan terlebih dahulu pada menu <b>Penetapan Ambang Batas</b>, <b>Penetapan Bobot Faktor</b>, dan <b>Perumusan Risiko</b>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
<?php
return;
}

$bobot1 = bobot_value_kredit($pembobotan, 'sub_parameter1');
$bobot2 = bobot_value_kredit($pembobotan, 'sub_parameter2');
$bobot3 = bobot_value_kredit($pembobotan, 'sub_parameter3');
$bobot4 = bobot_value_kredit($pembobotan, 'sub_parameter4');
$bobot5 = bobot_value_kredit($pembobotan, 'sub_parameter5');
$bobot6 = bobot_value_kredit($pembobotan, 'sub_parameter6');
$bobot7 = bobot_value_kredit($pembobotan, 'sub_parameter7');
$bobot8 = bobot_value_kredit($pembobotan, 'sub_parameter8');

$bobot2_1 = bobot_value_kredit($pembobotan, 'sub_parameter2_1');
$bobot2_2 = bobot_value_kredit($pembobotan, 'sub_parameter2_2');
$bobot2_3 = bobot_value_kredit($pembobotan, 'sub_parameter2_3');
$bobot2_4 = bobot_value_kredit($pembobotan, 'sub_parameter2_4');
$bobot2_5 = bobot_value_kredit($pembobotan, 'sub_parameter2_5');
$bobot2_6 = bobot_value_kredit($pembobotan, 'sub_parameter2_6');
$bobot2_7 = bobot_value_kredit($pembobotan, 'sub_parameter2_7');
$bobot2_8 = bobot_value_kredit($pembobotan, 'sub_parameter2_8');
$bobot2_9 = bobot_value_kredit($pembobotan, 'sub_parameter2_9');
$bobot2_10 = bobot_value_kredit($pembobotan, 'sub_parameter2_10');
$bobot2_11 = bobot_value_kredit($pembobotan, 'sub_parameter2_11');

$bobot3_1 = bobot_value_kredit($pembobotan, 'sub_parameter3_1');
$bobot3_2 = bobot_value_kredit($pembobotan, 'sub_parameter3_2');
$bobot3_3 = bobot_value_kredit($pembobotan, 'sub_parameter3_3');
$bobot3_4 = bobot_value_kredit($pembobotan, 'sub_parameter3_4');
$bobot3_5 = bobot_value_kredit($pembobotan, 'sub_parameter3_5');
$bobot3_6 = bobot_value_kredit($pembobotan, 'sub_parameter3_6');

$bobot4_1 = bobot_value_kredit($pembobotan, 'sub_parameter4_1');
$bobot4_2 = bobot_value_kredit($pembobotan, 'sub_parameter4_2');
$bobot4_3 = bobot_value_kredit($pembobotan, 'sub_parameter4_3');
$bobot4_4 = bobot_value_kredit($pembobotan, 'sub_parameter4_4');

$bobot5_1 = bobot_value_kredit($pembobotan, 'sub_parameter5_1');

$bobot6_1 = bobot_value_kredit($pembobotan, 'sub_parameter6_1');
$bobot6_2 = bobot_value_kredit($pembobotan, 'sub_parameter6_2');
$bobot6_3 = bobot_value_kredit($pembobotan, 'sub_parameter6_3');
$bobot6_4 = bobot_value_kredit($pembobotan, 'sub_parameter6_4');

$bobot7_1 = bobot_value_kredit($pembobotan, 'sub_parameter7_1');
$bobot7_2 = bobot_value_kredit($pembobotan, 'sub_parameter7_2');
$bobot7_3 = bobot_value_kredit($pembobotan, 'sub_parameter7_3');
$bobot7_4 = bobot_value_kredit($pembobotan, 'sub_parameter7_4');
$bobot7_5 = bobot_value_kredit($pembobotan, 'sub_parameter7_5');
$bobot7_6 = bobot_value_kredit($pembobotan, 'sub_parameter7_6');
$bobot7_7 = bobot_value_kredit($pembobotan, 'sub_parameter7_7');
$bobot7_8 = bobot_value_kredit($pembobotan, 'sub_parameter7_8');
$bobot7_9 = bobot_value_kredit($pembobotan, 'sub_parameter7_9');
$bobot7_10 = bobot_value_kredit($pembobotan, 'sub_parameter7_10');
$bobot7_11 = bobot_value_kredit($pembobotan, 'sub_parameter7_11');

// === FIX: PILAR LAINNYA HANYA SUB PARAMETER A DAN B ===
// Nilai pilar lainnya dihitung hanya dari:
// a. Kompetensi AO
// b. Kompetensi Analis
$hasil_pil5_par1a_ab = round(((isset($pil5['pilar5_1a']) && $pil5['pilar5_1a'] !== '') ? (float)$pil5['pilar5_1a'] : 0) * (float)$bobot7_1, 2);
$hasil_pil5_par1b_ab = round(((isset($pil5['pilar5_1b']) && $pil5['pilar5_1b'] !== '') ? (float)$pil5['pilar5_1b'] : 0) * (float)$bobot7_2, 2);
$pil5_tingkat_risiko_ab = round($hasil_pil5_par1a_ab + $hasil_pil5_par1b_ab, 2);


//setingan ditetapkan dari SETRIS aktif
$set_pil1 = isset($perumusan_detail_map[1]['perskalaan_metode']) ? (int)$perumusan_detail_map[1]['perskalaan_metode'] : 1;
$set_pil2 = isset($perumusan_detail_map[2]['perskalaan_metode']) ? (int)$perumusan_detail_map[2]['perskalaan_metode'] : 1;
$set_pil3 = isset($perumusan_detail_map[3]['perskalaan_metode']) ? (int)$perumusan_detail_map[3]['perskalaan_metode'] : 1;
$set_pil4 = isset($perumusan_detail_map[4]['perskalaan_metode']) ? (int)$perumusan_detail_map[4]['perskalaan_metode'] : 1;
$set_pil5 = isset($perumusan_detail_map[5]['perskalaan_metode']) ? (int)$perumusan_detail_map[5]['perskalaan_metode'] : 1;
// Nilai diambil untuk hasil inheren boleh diedit manual pada halaman ini.
// Prioritas ambil dari hasil_inheren_kredit.hasil_risiko_ditetapkan jika sudah pernah disimpan.
$set_tingkat_risiko_default = isset($inheren['inheren_kre_set_tingkat_risiko']) ? (int)$inheren['inheren_kre_set_tingkat_risiko'] : 1;
$set_tingkat_risiko = (isset($hasil['hasil_risiko_ditetapkan']) && $hasil['hasil_risiko_ditetapkan'] !== '' && (int)$hasil['hasil_risiko_ditetapkan'] > 0)
    ? (int)$hasil['hasil_risiko_ditetapkan']
    : $set_tingkat_risiko_default;

$setris_bobot_pil1 = isset($perumusan_detail_map[1]['pembobotan']) ? (float)$perumusan_detail_map[1]['pembobotan'] : 0;
$setris_bobot_pil2 = isset($perumusan_detail_map[2]['pembobotan']) ? (float)$perumusan_detail_map[2]['pembobotan'] : 0;
$setris_bobot_pil3 = isset($perumusan_detail_map[3]['pembobotan']) ? (float)$perumusan_detail_map[3]['pembobotan'] : 0;
$setris_bobot_pil4 = isset($perumusan_detail_map[4]['pembobotan']) ? (float)$perumusan_detail_map[4]['pembobotan'] : 0;
$setris_bobot_pil5 = isset($perumusan_detail_map[5]['pembobotan']) ? (float)$perumusan_detail_map[5]['pembobotan'] : 0;

$setris_display_pil1 = setris_display_html_kredit('set_pil1', $setris_mode, $set_pil1, $setris_bobot_pil1);
$setris_display_pil2 = setris_display_html_kredit('set_pil2', $setris_mode, $set_pil2, $setris_bobot_pil2);
$setris_display_pil3 = setris_display_html_kredit('set_pil3', $setris_mode, $set_pil3, $setris_bobot_pil3);
// Dropdown nilai diambil hasil inheren dibuat editable, tidak disabled.
if (strtolower((string)$setris_mode) === 'pembobotan') {
    $setris_display_inheren = '<input type="text" class="form-control" id="opsi_inheren" name="opsi_inheren" form="my_form" value="Pembobotan" readonly>';
} else {
    $m_inh = (int)$set_tingkat_risiko;
    $setris_display_inheren  = '<select class="form-select" id="opsi_inheren" name="opsi_inheren" form="my_form">';
    $setris_display_inheren .= '<option value="1" '.($m_inh === 1 ? 'selected' : '').'>Tertinggi</option>';
    $setris_display_inheren .= '<option value="2" '.($m_inh === 2 ? 'selected' : '').'>Terendah</option>';
    $setris_display_inheren .= '<option value="3" '.($m_inh === 3 ? 'selected' : '').'>Rata-rata</option>';
    $setris_display_inheren .= '</select>';
}




//penamaan rasio
$apro = $master_kredit_P1['aset_produktif'];
$totas = $master_kredit_P1['total_aset'];
$aba = $master_kredit_P1['aba'];
$kyd = $master_kredit_P1['kyd'];
$kredit_spg = $master_kredit_P1['kredit_spg'];
$kredit_pbta = $master_kredit_P1['kredit_pbta'];
$kredit_jpendek = $master_kredit_P1['kredit_jpendek'];
$kredit_jmenengah = $master_kredit_P1['kredit_jmenengah'];
$kredit_jpanjang = $master_kredit_P1['kredit_jpanjang'];
$noa_kyd = $master_kredit_P1['noa_kyd'];
$kredit_agunan_tb = $master_kredit_P1['kredit_agunan_tb'];
$kredit_agunan_kb = $master_kredit_P1['kredit_agunan_kb'];
$kredit_agunan_kr2 = $master_kredit_P1['kredit_agunan_kr2'];
$kredit_kub = $master_kredit_P1['kredit_kub'];
$kredit_ta = $master_kredit_P1['kredit_ta'];
$kredit_korporasi = $master_kredit_P1['kredit_korporasi'];
$kredit_pep = $master_kredit_P1['kredit_pep'];
$kredit_lebih350 = $master_kredit_P1['kredit_lebih350'];
$debitur_inti25 = $master_kredit_P1['debitur_inti25'];
$kredit_3sektor_ekonomi_terbesar = $master_kredit_P1['kredit_3sektor_ekonomi_terbesar'];

$noa_kredit_sd150 = $master_kredit_P2['noa_kredit_sd150'];
$aset_produktif_bermasalah = $master_kredit_P2['aset_produktif_bermasalah'];
$saldo_ckpn = isset($master_kredit_P2['saldo_ckpn']) && $master_kredit_P2['saldo_ckpn'] !== '' ? $master_kredit_P2['saldo_ckpn'] : $master_kredit_P2['saldo_ppap'];
$saldo_ppap = $saldo_ckpn;
$ayda = $master_kredit_P2['ayda'];
$kredit_bermasalah_neto = $master_kredit_P2['kredit_bermasalah_neto'];
$npl_kredit_sd150 = $master_kredit_P2['npl_kredit_sd150'];
$kyd_plafon_sd150 = $master_kredit_P2['kyd_plafon_sd150'];
$npl_kredit_diatas50 = $master_kredit_P2['npl_kredit_diatas50'];
$kyd_plafon_diatas50 = $master_kredit_P2['kyd_plafon_diatas50'];
$npl_apht = $master_kredit_P2['npl_apht'];
$npl_skmht = $master_kredit_P2['npl_skmht'];
$npl_agunan_lrd_bakidebet = $master_kredit_P2['npl_agunan_lrd_bakidebet'];
$kredit_agunan_lrd_bakidebet = $master_kredit_P2['kredit_agunan_lrd_bakidebet'];
$macet_jatuh_tempo = $master_kredit_P2['macet_jatuh_tempo'];
$kkr = $master_kredit_P2['kkr'];
$kredit_par4 = $master_kredit_P2['kredit_par4'];
$kredit_dp = $master_kredit_P2['kredit_dp'];
$noa_fpd_6bln = $master_kredit_P2['noa_fpd_6bln'];
$noa_ekspansi_6bln = $master_kredit_P2['noa_ekspansi_6bln'];
$nominal_fpd_6bln = $master_kredit_P2['nominal_fpd_6bln'];
$plafond_ekspansi_6bln = $master_kredit_P2['plafond_ekspansi_6bln'];

$aba_tinggi = $master_kredit_P3['aba_tertinggi'];
$pertumbuhan_kyd_bpr = $master_kredit_P3['pertumbuhan_kyd_bpr'];
$rasio_pertumbuhan_rata2_bpr = $master_kredit_P3['rasio_pertumbuhan_rata2_bpr'];
$td_pp_l = $master_kredit_P3['td_pp_l'];
$td_pp_dp = $master_kredit_P3['td_pp_dp'];
$td_pp_kl = $master_kredit_P3['td_pp_kl'];
$td_pp_d = $master_kredit_P3['td_pp_d'];
$td_pp_m = $master_kredit_P3['td_pp_m'];

$td_ps_l = $master_kredit_P3['td_ps_l'];
$td_ps_dp = $master_kredit_P3['td_ps_dp'];
$td_ps_kl = $master_kredit_P3['td_ps_kl'];
$td_ps_d = $master_kredit_P3['td_ps_d'];
$td_ps_m = $master_kredit_P3['td_ps_m'];


$d_pp_l = $master_kredit_P3['d_pp_l'];
$d_pp_dp = $master_kredit_P3['d_pp_dp'];
$d_pp_kl = $master_kredit_P3['d_pp_kl'];
$d_pp_d = $master_kredit_P3['d_pp_d'];
$d_pp_m = $master_kredit_P3['d_pp_m'];

$d_ps_l = $master_kredit_P3['d_ps_l'];
$d_ps_dp = $master_kredit_P3['d_ps_dp'];
$d_ps_kl = $master_kredit_P3['d_ps_kl'];
$d_ps_d = $master_kredit_P3['d_ps_d'];
$d_ps_m = $master_kredit_P3['d_ps_m'];

$osc_2bln_sebelumnya = $master_kredit_P3['osc_2bln_sebelumnya'];
$noa_2bln_sebelumnya = $master_kredit_P3['noa_2bln_sebelumnya'];

$npl_2bln_sebelumnya = $master_kredit_P3['npl_2bln_sebelumnya'];
$noa_npl_2bln_sebelumnya = $master_kredit_P3['noa_npl_2bln_sebelumnya'];

$osc_1bln_sebelumnya = $master_kredit_P3['osc_1bln_sebelumnya'];
$noa_1bln_sebelumnya = $master_kredit_P3['noa_1bln_sebelumnya'];

$npl_1bln_sebelumnya = $master_kredit_P3['npl_1bln_sebelumnya'];
$noa_npl_1bln_sebelumnya = $master_kredit_P3['noa_npl_1bln_sebelumnya'];


$osc_bln_penilaian = $master_kredit_P3['osc_bln_penilaian'];
$noa_bln_penilaian = $master_kredit_P3['noa_bln_penilaian'];

$npl_bln_penilaian = $master_kredit_P3['npl_bln_penilaian'];
$noa_npl_bln_penilaian = $master_kredit_P3['noa_npl_bln_penilaian'];


$rasio_npl_1bln_sebelumnya = $master_kredit_P3['rasio_npl_1bln_sebelumnya'];
$rasio_npl_bln_penilaian = $master_kredit_P3['rasio_npl_bln_penilaian'];

$aba = $master_kredit_P1['aba'];
$aba_tertinggi = $master_kredit_P3['aba_tertinggi'];
$aba_bank_umum = $master_kredit_P3['aba_bank_umum'];
$aba_bpr = $master_kredit_P3['aba_bpr'];




// menghitung rumus
$p1 = round(($apro / $totas) * 100, 2);
$p1a = round(($aba / $apro) * 100, 2);
$p1b = round(($aba_tinggi / $aba) * 100, 2);
$p1c = round(($aba_bpr / $aba) * 100, 2);

$p2 = round(($kyd / $apro) * 100, 2);
$p2a = round(($kredit_spg / $kyd) * 100, 2);
$p2b = round(($kredit_pbta / $kyd) * 100, 2);
$p2c = round(($kredit_jpendek / $kyd) * 100, 2);
$p2d = round(($kredit_jmenengah / $kyd) * 100, 2);
$p2e = round(($kredit_jpanjang / $kyd) * 100, 2);
$p2f = round(($noa_kredit_sd150 / $noa_kyd) * 100, 2);
$p2g = round(($kredit_agunan_tb / $kyd) * 100, 2);
$p2h = round(($kredit_agunan_kb / $kyd) * 100, 2);
$p2i = round(($kredit_agunan_kr2 / $kyd) * 100, 2);
$p2j = round(($kredit_kub / $kyd) * 100, 2);
$p2k = round(($kredit_ta / $kyd) * 100, 2);
$p2l = round(($kredit_korporasi / $kyd) * 100, 2);
$p2m = round(($kredit_pep / $kyd) * 100, 2);
$p2n = round(($kredit_lebih350 / $kyd) * 100, 2);

$p3 = round(($debitur_inti25 * 100) / $kyd, 2);

$p4 = round(($kredit_3sektor_ekonomi_terbesar * 100) / $kyd, 2);

$pilar2_p1 = round(($aset_produktif_bermasalah / $apro) * 100, 2);
$pilar2_p1a = round(($saldo_ckpn / $kyd) * 100, 2);
$pilar2_p1b = round(($ayda / $kyd) * 100, 2);

$pilar2_p2 = round(($kredit_bermasalah_neto / $kyd) * 100, 2);
$pilar2_p2a = round(($npl_kredit_sd150 / $kyd_plafon_sd150) * 100, 2);
$pilar2_p2b = round(($npl_kredit_diatas50 / $kyd_plafon_diatas50) * 100, 2);
$pilar2_p2c = round(($npl_apht / $kyd) * 100, 2);
$pilar2_p2d = round(($npl_skmht / $kyd) * 100, 2);
$pilar2_p2e = round(($npl_agunan_lrd_bakidebet / $kredit_agunan_lrd_bakidebet) * 100, 2);
$pilar2_p2f = round(($macet_jatuh_tempo / $kyd) * 100, 2);

$pilar2_p3 = round(($kkr / $kyd) * 100, 2);
$pilar2_p3a = round(($kredit_par4 / $kyd) * 100, 2);
$pilar2_p3b = round(($kredit_dp / $kyd) * 100, 2);
$pilar2_p3c = round(($noa_fpd_6bln / $noa_ekspansi_6bln) * 100, 2);
$pilar2_p3d = round(($nominal_fpd_6bln / $plafond_ekspansi_6bln) * 100, 2);




$pilar3_p1 = round($pertumbuhan_kyd_bpr - $rasio_pertumbuhan_rata2_bpr, 2);
if ($pilar3_p1 == 0) {
    $hsl_pil3_par1 = 0;
} else if ($pilar3_p1 < $bobot5_1) {
    $hsl_pil3_par1 = 4;
} else if ($pilar3_p1 < 1) {
    $hsl_pil3_par1 = 3;
} elseif ($pilar3_p1 == $bobot5_1) {
    $hsl_pil3_par1 = 2;
} elseif ($pilar3_p1 > 1) {
    $hsl_pil3_par1 = 1;
} else {
    $hsl_pil3_par1 = null;
}

// Hasil Strategi Penyediaan Dana mengikuti rumus Excel N184:
// =IF(M184<L184;L184;(L184+M184)/2)
// L184 = rumus ($hsl_pil3_par1), M184 = koreksi ($pil3['pilar3_1']).
$koreksi_pil3_par1_awal = (isset($pil3['pilar3_1']) && $pil3['pilar3_1'] !== '' && $pil3['pilar3_1'] !== null)
    ? (float)$pil3['pilar3_1']
    : null;
$nilai_pil3_par1 = hasil_excel_rumus_koreksi_kredit(
    $hsl_pil3_par1,
    $koreksi_pil3_par1_awal
);

$pilar3_p1a_pp = $td_pp_l + $td_pp_dp + $td_pp_kl + $td_pp_d + $td_pp_m;
$pilar3_p1a_ps = $td_ps_l + $td_ps_dp + $td_ps_kl + $td_ps_d + $td_ps_m;

if ($pilar3_p1a_pp < $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 3;
} else if ($pilar3_p1a_pp > $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 3;
} else if ($pilar3_p1a_pp == $pilar3_p1a_ps) {
    $hsl_pil3_par1a = 2;
} else {
    $hsl_pil3_par1a = 2;
}



$pilar3_p1b_pp = $d_pp_l + $d_pp_dp + $d_pp_kl + $d_pp_d + $d_pp_m;
$pilar3_p1b_ps = $d_ps_l + $d_ps_dp + $d_ps_kl + $d_ps_d + $d_ps_m;

if ($pilar3_p1b_pp < $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 3;
} else if ($pilar3_p1b_pp > $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 3;
} else if ($pilar3_p1b_pp == $pilar3_p1b_ps) {
    $hsl_pil3_par1b = 2;
} else {
    $hsl_pil3_par1b = 2;
}


// Pertumbuhan Kredit
// Excel: (periode penilaian - 1 bulan sebelumnya) / 1 bulan sebelumnya * 100
$pilar3_p1c_pertumbuhan_kredit = safe_pct_kredit(
    ($osc_bln_penilaian - $osc_1bln_sebelumnya),
    $osc_1bln_sebelumnya
);

// Pertumbuhan NOA
$pilar3_p1c_pertumbuhan_noa = safe_pct_kredit(
    ($noa_bln_penilaian - $noa_1bln_sebelumnya),
    $noa_1bln_sebelumnya
);

// Pertumbuhan Rasio NPL
$pilar3_p1c_pertumbuhan_rasio_npl = safe_pct_kredit(
    ($rasio_npl_bln_penilaian - $rasio_npl_1bln_sebelumnya),
    $rasio_npl_1bln_sebelumnya
);

// Pertumbuhan NOA NPL
$pilar3_p1c_pertumbuhan_noa_npl = safe_pct_kredit(
    ($noa_npl_bln_penilaian - $noa_npl_1bln_sebelumnya),
    $noa_npl_1bln_sebelumnya
);

if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl < 0) {
    $hsl_pil3_par1c = 1;
} else if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl == 0) {
    $hsl_pil3_par1c = 2;
} else if ($pilar3_p1c_pertumbuhan_kredit > 0 && $pilar3_p1c_pertumbuhan_rasio_npl > 0) {
    $hsl_pil3_par1c = 3;
} else if ($pilar3_p1c_pertumbuhan_kredit < 0 && $pilar3_p1c_pertumbuhan_rasio_npl < 0) {
    $hsl_pil3_par1c = 4;
} else {
    $hsl_pil3_par1c = 5;
}


$pilar3_p1c_pertumbuhan_rasio_npl_tambah5 =  $pilar3_p1c_pertumbuhan_rasio_npl + 5;

if ($pilar3_p1c_pertumbuhan_kredit > $pilar3_p1c_pertumbuhan_rasio_npl) {
    $hsl_pil3_par1c_rumus = 1;
} else if ($pilar3_p1c_pertumbuhan_kredit > $pilar3_p1c_pertumbuhan_rasio_npl_tambah5) {
    $hsl_pil3_par1c_rumus = 3;
} else {
    $hsl_pil3_par1c_rumus = 4;
}

// === FIX EXCEL: hasil c. Pertumbuhan OSC dan NPL ===
// Rumus Excel: =IF(koreksi < rumus; rumus; (rumus + koreksi) / 2)
// Jika koreksi belum dipilih, gunakan hasil otomatis ($hsl_pil3_par1c).
$koreksi_pil3_par1c_awal = (isset($pil3['pilar3_1c']) && $pil3['pilar3_1c'] !== '' && $pil3['pilar3_1c'] !== null)
    ? (float)$pil3['pilar3_1c']
    : (float)$hsl_pil3_par1c;

if ((float)$hsl_pil3_par1c_rumus > (float)$koreksi_pil3_par1c_awal) {
    $nilai_pil3_par1c = round((float)$hsl_pil3_par1c_rumus, 2);
} elseif ((float)$hsl_pil3_par1c_rumus == (float)$koreksi_pil3_par1c_awal) {
    $nilai_pil3_par1c = round((float)$hsl_pil3_par1c_rumus, 2);
} else {
    $nilai_pil3_par1c = round(((float)$hsl_pil3_par1c_rumus + (float)$koreksi_pil3_par1c_awal) / 2, 2);
}









$hsl_pil3_par1d = ($aba_bpr / $aba) * 100;

if ($hsl_pil3_par1d < 10) {
    $hsl_pil3_par1d_rumus = 1;
} else if ($hsl_pil3_par1d < 15) {
    $hsl_pil3_par1d_rumus = 2;
} else if ($hsl_pil3_par1d < 20) {
    $hsl_pil3_par1d_rumus = 3;
} else {
    $hsl_pil3_par1d_rumus = 5;
}

$hsl_pil3_par1e = ($aba_tertinggi / $aba) * 100;

if ($hsl_pil3_par1e <= 30) {
    $hsl_pil3_par1e_rumus = 1;
} else if ($hsl_pil3_par1e <= 40) {
    $hsl_pil3_par1e_rumus = 2;
} else if ($hsl_pil3_par1e < 50) {
    $hsl_pil3_par1e_rumus = 3;
} else {
    $hsl_pil3_par1e_rumus = 4;
}

// ============================================================
// FIX REKAP PILAR 3
// Rekap harus dihitung dari 6 nilai HASIL yang sedang ditampilkan,
// bukan mengambil nilai lama dari hasil_inheren_kredit.
// ============================================================
$pil3_rekap_values = array(
    (float)$nilai_pil3_par1,
    (isset($pil3['hasil_pil3_par1a']) && $pil3['hasil_pil3_par1a'] !== '') ? (float)$pil3['hasil_pil3_par1a'] : (float)$hsl_pil3_par1a,
    (isset($pil3['hasil_pil3_par1b']) && $pil3['hasil_pil3_par1b'] !== '') ? (float)$pil3['hasil_pil3_par1b'] : (float)$hsl_pil3_par1b,
    (float)$nilai_pil3_par1c,
    (isset($pil3['hasil_pil3_par1d']) && $pil3['hasil_pil3_par1d'] !== '') ? (float)$pil3['hasil_pil3_par1d'] : (float)$hsl_pil3_par1d_rumus,
    (isset($pil3['hasil_pil3_par1e']) && $pil3['hasil_pil3_par1e'] !== '') ? (float)$pil3['hasil_pil3_par1e'] : (float)$hsl_pil3_par1e_rumus
);

$pil3_tertinggi_calc = max($pil3_rekap_values);
$pil3_terendah_calc  = min($pil3_rekap_values);
$pil3_rata_rata_calc = round(array_sum($pil3_rekap_values) / count($pil3_rekap_values), 2);

if ($setris_mode === 'pembobotan') {
    $pil3_tingkat_risiko_calc = round($pil3_rata_rata_calc * ((float)$setris_bobot_pil3 / 100), 2);
} elseif ((int)$set_pil3 === 1) {
    $pil3_tingkat_risiko_calc = $pil3_tertinggi_calc;
} elseif ((int)$set_pil3 === 2) {
    $pil3_tingkat_risiko_calc = $pil3_terendah_calc;
} else {
    $pil3_tingkat_risiko_calc = $pil3_rata_rata_calc;
}









$ab = $ambang_batas_kredit['ap_per_ta'];
if ($p1 > $ab) {
    $hsl1 = 3;
} else {
    $hsl1 = 1;
}

//par1a
$aba = $ambang_batas_kredit['pbl_per_tap'];
$ab2a = $ambang_batas_kredit['rr_pbl_per_tap'];
$ab3a = $ambang_batas_kredit['rrr_pbl_per_tap'];
$ab4a = $ambang_batas_kredit['rrrr_pbl_per_tap'];
if ($p1a <= $aba) {
    $hsl1a = 1;
} else if ($p1a > $aba && $p1a <= $ab2a) {
    $hsl1a = 2;
} else if ($p1a > $ab2a && $p1a <= $ab3a) {
    $hsl1a = 3;
} elseif ($p1a > $ab3a && $p1a <= $ab4a) {
    $hsl1a = 4;
} else {
    $hsl1a = 5;
}


$nilai1a = $hsl1a * $bobot1;

//par1b
$abb = $ambang_batas_kredit['apbt_per_pbl'];
$ab2b = $ambang_batas_kredit['rr_apbt_per_pbl'];
$ab3b = $ambang_batas_kredit['rrr_apbt_per_pbl'];
$ab4b = $ambang_batas_kredit['rrrr_apbt_per_pbl'];
if ($p1b <= $abb) {
    $hsl1b = 1;
} else if ($p1b > $abb && $p1b <= $ab2b) {
    $hsl1b = 2;
} else if ($p1b > $ab2b && $p1b <= $ab3b) {
    $hsl1b = 3;
} elseif ($p1b > $ab3b && $p1b <= $ab4b) {
    $hsl1b = 4;
} else {
    $hsl1b = 5;
}


$nilai1b = $hsl1b * $bobot2;

//par1c
$abc = $ambang_batas_kredit['abapb_per_pbl'];
$ab2c = $ambang_batas_kredit['rr_abapb_per_pbl'];
$ab3c = $ambang_batas_kredit['rrr_abapb_per_pbl'];
$ab4c = $ambang_batas_kredit['rrrr_abapb_per_pbl'];
if ($p1c <= $abc) {
    $hsl1c = 1;
} else if ($p1c > $abc && $p1c <= $ab2c) {
    $hsl1c = 2;
} else if ($p1c > $ab2c && $p1c <= $ab3c) {
    $hsl1c = 3;
} elseif ($p1c > $ab3c && $p1c <= $ab4c) {
    $hsl1c = 4;
} else {
    $hsl1c = 5;
}


$nilai1c = $hsl1c * $bobot3;


//par1d
$para1_abd = $ambang_batas_kredit['nkp150_per_nkyd'];
$para1_ab2d = $ambang_batas_kredit['rr_nkp150_per_nkyd'];
$para1_ab3d = $ambang_batas_kredit['rrr_nkp150_per_nkyd'];
$para1_ab4d = $ambang_batas_kredit['rrrr_nkp150_per_nkyd'];
if ($p2f >= $para1_abd) {
    $hsl2f = 1;
} else if ($p2f < $para1_abd && $p2f >= $para1_ab2d) {
    $hsl2f = 2;
} else if ($p2f < $para1_ab2d && $p2f >= $para1_ab3d) {
    $hsl2f = 3;
} elseif ($p2f < $para1_ab3d && $p2f >= $para1_ab4d) {
    $hsl2f = 4;
} else {
    $hsl2f = 5;
}

$nilai2f = $hsl2f * $bobot4;


//par1e
$para2_abm = $ambang_batas_kredit['kpep_per_tkyd'];
$para2_ab2m = $ambang_batas_kredit['rr_kpep_per_tkyd'];
$para2_ab3m = $ambang_batas_kredit['rrr_kpep_per_tkyd'];
$para2_ab4m = $ambang_batas_kredit['rrrr_kpep_per_tkyd'];
if ($p2m <= $para2_abm) {
    $hsl2m = 1;
} else if ($p2m > $para2_abm && $p2m <= $para2_ab2m) {
    $hsl2m = 2;
} else if ($p2m > $para2_ab2m && $p2m <= $para2_ab3m) {
    $hsl2m = 3;
} elseif ($p2m > $para2_ab3m && $p2m <= $para2_ab4m) {
    $hsl2m = 4;
} else {
    $hsl2m = 5;
}

$nilai2m = $hsl2m * $bobot5;



//par1f
$para2_abn = $ambang_batas_kredit['kp350_per_tkyd'];
$para2_ab2n = $ambang_batas_kredit['rr_kp350_per_tkyd'];
$para2_ab3n = $ambang_batas_kredit['rrr_kp350_per_tkyd'];
$para2_ab4n = $ambang_batas_kredit['rrrr_kp350_per_tkyd'];
if ($p2n <= $para2_abn) {
    $hsl2n = 1;
} else if ($p2n > $para2_abn && $p2n <= $para2_ab2n) {
    $hsl2n = 2;
} else if ($p2n > $para2_ab2n && $p2n <= $para2_ab3n) {
    $hsl2n = 3;
} elseif ($p2n > $para2_ab3n && $p2n <= $para2_ab4n) {
    $hsl2n = 4;
} else {
    $hsl2n = 5;
}

$nilai2n = $hsl2n * $bobot6;


//par1g - CKPN (pengganti PPAP)
$ab_pil2_par1a  = isset($ambang_batas_kredit['ckpn_per_tk']) && $ambang_batas_kredit['ckpn_per_tk'] !== '' ? (float)$ambang_batas_kredit['ckpn_per_tk'] : 4.00;
$ab_pil2_par12a = isset($ambang_batas_kredit['rr_ckpn_per_tk']) && $ambang_batas_kredit['rr_ckpn_per_tk'] !== '' ? (float)$ambang_batas_kredit['rr_ckpn_per_tk'] : 8.00;
$ab_pil2_par13a = isset($ambang_batas_kredit['rrr_ckpn_per_tk']) && $ambang_batas_kredit['rrr_ckpn_per_tk'] !== '' ? (float)$ambang_batas_kredit['rrr_ckpn_per_tk'] : 12.00;
$ab_pil2_par14a = isset($ambang_batas_kredit['rrrr_ckpn_per_tk']) && $ambang_batas_kredit['rrrr_ckpn_per_tk'] !== '' ? (float)$ambang_batas_kredit['rrrr_ckpn_per_tk'] : 18.00;
if ($pilar2_p1a <= $ab_pil2_par1a) {
    $hsl_pil2_par1a = 1;
} else if ($pilar2_p1a > $ab_pil2_par1a && $pilar2_p1a <= $ab_pil2_par12a) {
    $hsl_pil2_par1a = 2;
} else if ($pilar2_p1a > $ab_pil2_par12a && $pilar2_p1a <= $ab_pil2_par13a) {
    $hsl_pil2_par1a = 3;
} elseif ($pilar2_p1a > $ab_pil2_par13a && $pilar2_p1a <= $ab_pil2_par14a) {
    $hsl_pil2_par1a = 4;
} else {
    $hsl_pil2_par1a = 5;
}


$nilai_pil2_par1a = $hsl_pil2_par1a * $bobot7;

//par1h
$ab_pil2_par1b = $ambang_batas_kredit['ayda_per_kyd'];
$ab_pil2_par12b = $ambang_batas_kredit['rr_ayda_per_kyd'];
$ab_pil2_par13b = $ambang_batas_kredit['rrr_ayda_per_kyd'];
$ab_pil2_par14b = $ambang_batas_kredit['rrrr_ayda_per_kyd'];
if ($pilar2_p1b <= $ab_pil2_par1b) {
    $hsl_pil2_par1b = 1;
} else if ($pilar2_p1b > $ab_pil2_par1b && $pilar2_p1b <= $ab_pil2_par12b) {
    $hsl_pil2_par1b = 2;
} else if ($pilar2_p1b > $ab_pil2_par12b && $pilar2_p1b <= $ab_pil2_par13b) {
    $hsl_pil2_par1b = 3;
} elseif ($pilar2_p1b > $ab_pil2_par13b && $pilar2_p1b <= $ab_pil2_par14b) {
    $hsl_pil2_par1b = 4;
} else {
    $hsl_pil2_par1b = 5;
}


$nilai_pil2_par1b = $hsl_pil2_par1b * $bobot8;




$koreksi = $nilai1a + $nilai1b + $nilai1c + $nilai2m + $nilai2n + $nilai_pil2_par1a + $nilai_pil2_par1b;


if ($hsl1 == 3) {
    $nilai = $hsl1;
} else {
    $nilai = ($hsl1 + $koreksi) / 2;
}






//pil2




//par2 - Kredit Yang Diberikan / Aset Produktif
// FIX EXCEL: =IF(I40<=K40;1;IF(I40>K40;3;0))
// Jika rasio <= ambang batas maka peringkat 1, jika lebih besar maka peringkat 3.
$para2_ab = $ambang_batas_kredit['kyd_per_ap'];
if ($p2 <= $para2_ab) {
    $hsl2 = 1;
} else if ($p2 > $para2_ab) {
    $hsl2 = 3;
} else {
    $hsl2 = 0;
}

//par2a - Kredit Skema Potong Gaji / Total Kredit
// FIX: disamakan dengan Excel.
// Excel: <= batas1 = 1; <= batas2 = 2; <= batas3 = 3; <= batas4 = 4; > batas4 = 5.
// Jika ambang lanjutan kosong/0, gunakan fallback 22 / 25 / 30 sesuai master Excel.
$para2_aba  = ambang_kredit_num($ambang_batas_kredit, 'kspg_per_tk', 19);
$para2_ab2a = ambang_kredit_num($ambang_batas_kredit, 'rr_kspg_per_tk', 22);
$para2_ab3a = ambang_kredit_num($ambang_batas_kredit, 'rrr_kspg_per_tk', 25);
$para2_ab4a = ambang_kredit_num($ambang_batas_kredit, 'rrrr_kspg_per_tk', 30);

// Guard agar urutan ambang tetap naik. Ini mencegah hasil 20,53 jatuh ke peringkat 3 karena ambang ke-2 kosong/0.
if ($para2_ab2a <= $para2_aba)  $para2_ab2a = 22;
if ($para2_ab3a <= $para2_ab2a) $para2_ab3a = 25;
if ($para2_ab4a <= $para2_ab3a) $para2_ab4a = 30;

if ($p2a <= $para2_aba) {
    $hsl2a = 1;
} else if ($p2a <= $para2_ab2a) {
    $hsl2a = 2;
} else if ($p2a <= $para2_ab3a) {
    $hsl2a = 3;
} elseif ($p2a <= $para2_ab4a) {
    $hsl2a = 4;
} else {
    $hsl2a = 5;
}

$nilai2a = round($hsl2a * $bobot2_1, 2);

//par2b
$para2_abb = $ambang_batas_kredit['km_per_tkyd'];
$para2_ab2b = $ambang_batas_kredit['rr_km_per_tkyd'];
$para2_ab3b = $ambang_batas_kredit['rrr_km_per_tkyd'];
$para2_ab4b = $ambang_batas_kredit['rrrr_km_per_tkyd'];
if ($p2b <= $para2_abb) {
    $hsl2b = 1;
} else if ($p2b > $para2_abb && $p2b <= $para2_ab2b) {
    $hsl2b = 2;
} else if ($p2b > $para2_ab2b && $p2b <= $para2_ab3b) {
    $hsl2b = 3;
} elseif ($p2b > $para2_ab3b && $p2b <= $para2_ab4b) {
    $hsl2b = 4;
} else {
    $hsl2b = 5;
}


$nilai2b = $hsl2b * $bobot2_2;

//par2c
$para2_abc = $ambang_batas_kredit['kjpen_per_tkyd'];
$para2_ab2c = $ambang_batas_kredit['rr_kjpen_per_tkyd'];
$para2_ab3c = $ambang_batas_kredit['rrr_kjpen_per_tkyd'];
$para2_ab4c = $ambang_batas_kredit['rrrr_kjpen_per_tkyd'];
if ($p2c >= $para2_abc) {
    $hsl2c = 1;
} else if ($p2c < $para2_abc && $p2c >= $para2_ab2c) {
    $hsl2c = 2;
} else if ($p2c < $para2_ab2c && $p2c >= $para2_ab3c) {
    $hsl2c = 3;
} elseif ($p2c < $para2_ab3c && $p2c >= $para2_ab4c) {
    $hsl2c = 4;
} else {
    $hsl2c = 5;
}


$nilai2c = $hsl2c * $bobot2_3;



//par2d
$para2_abd = $ambang_batas_kredit['kjm_per_tkyd'];
$para2_ab2d = $ambang_batas_kredit['rr_kjm_per_tkyd'];
$para2_ab3d = $ambang_batas_kredit['rrr_kjm_per_tkyd'];
$para2_ab4d = $ambang_batas_kredit['rrrr_kjm_per_tkyd'];
if ($p2d <= $para2_abd) {
    $hsl2d = 1;
} else if ($p2d > $para2_abd && $p2d <= $para2_ab2d) {
    $hsl2d = 2;
} else if ($p2d > $para2_ab2d && $p2d <= $para2_ab3d) {
    $hsl2d = 3;
} elseif ($p2d > $para2_ab3d && $p2d <= $para2_ab4d) {
    $hsl2d = 4;
} else {
    $hsl2d = 5;
}


$nilai2d = $hsl2d * $bobot2_4;


//par2e
$para2_abe = $ambang_batas_kredit['kjpan_per_tkyd'];
$para2_ab2e = $ambang_batas_kredit['rr_kjpan_per_tkyd'];
$para2_ab3e = $ambang_batas_kredit['rrr_kjpan_per_tkyd'];
$para2_ab4e = $ambang_batas_kredit['rrrr_kjpan_per_tkyd'];
if ($p2e <= $para2_abe) {
    $hsl2e = 1;
} else if ($p2e > $para2_abe && $p2e <= $para2_ab2e) {
    $hsl2e = 2;
} else if ($p2e > $para2_ab2e && $p2e <= $para2_ab3e) {
    $hsl2e = 3;
} elseif ($p2e > $para2_ab3e && $p2e <= $para2_ab4e) {
    $hsl2e = 4;
} else {
    $hsl2e = 5;
}


$nilai2e = $hsl2e * $bobot2_5;







//par2g
$para2_abg = $ambang_batas_kredit['kdatdb_per_tkyd'];
$para2_ab2g = $ambang_batas_kredit['rr_kdatdb_per_tkyd'];
$para2_ab3g = $ambang_batas_kredit['rrr_kdatdb_per_tkyd'];
$para2_ab4g = $ambang_batas_kredit['rrrr_kdatdb_per_tkyd'];
if ($p2g >= $para2_abg) {
    $hsl2g = 1;
} else if ($p2g < $para2_abg && $p2g >= $para2_ab2g) {
    $hsl2g = 2;
} else if ($p2g < $para2_ab2g && $p2g >= $para2_ab3g) {
    $hsl2g = 3;
} elseif ($p2g < $para2_ab3g && $p2g >= $para2_ab4g) {
    $hsl2g = 4;
} else {
    $hsl2g = 5;
}

$nilai2g = $hsl2g * $bobot2_6;


//par2h
$para2_abh = $ambang_batas_kredit['kak_per_tkyd'];
$para2_ab2h = $ambang_batas_kredit['rr_kak_per_tkyd'];
$para2_ab3h = $ambang_batas_kredit['rrr_kak_per_tkyd'];
$para2_ab4h = $ambang_batas_kredit['rrrr_kak_per_tkyd'];
if ($p2h <= $para2_abh) {
    $hsl2h = 1;
} else if ($p2h > $para2_abh && $p2h <= $para2_ab2h) {
    $hsl2h = 2;
} else if ($p2h > $para2_ab2h && $p2h <= $para2_ab3h) {
    $hsl2h = 3;
} elseif ($p2h > $para2_ab3h && $p2h <= $para2_ab4h) {
    $hsl2h = 4;
} else {
    $hsl2h = 5;
}

$nilai2h = $hsl2h * $bobot2_7;


//par2i
$para2_abi = $ambang_batas_kredit['kakr2_per_tkyd'];
$para2_ab2i = $ambang_batas_kredit['rr_kakr2_per_tkyd'];
$para2_ab3i = $ambang_batas_kredit['rrr_kakr2_per_tkyd'];
$para2_ab4i = $ambang_batas_kredit['rrrr_kakr2_per_tkyd'];
if ($p2i <= $para2_abi) {
    $hsl2i = 1;
} else if ($p2i > $para2_abi && $p2i <= $para2_ab2i) {
    $hsl2i = 2;
} else if ($p2i > $para2_ab2i && $p2i <= $para2_ab3i) {
    $hsl2i = 3;
} elseif ($p2i > $para2_ab3i && $p2i <= $para2_ab4i) {
    $hsl2i = 4;
} else {
    $hsl2i = 5;
}

$nilai2i = $hsl2i * $bobot2_8;


//par2j
$para2_abj = $ambang_batas_kredit['opk_per_tkyd'];
$para2_ab2j = $ambang_batas_kredit['rr_opk_per_tkyd'];
$para2_ab3j = $ambang_batas_kredit['rrr_opk_per_tkyd'];
$para2_ab4j = $ambang_batas_kredit['rrrr_opk_per_tkyd'];
if ($p2j <= $para2_abj) {
    $hsl2j = 1;
} else if ($p2j > $para2_abj && $p2j <= $para2_ab2j) {
    $hsl2j = 2;
} else if ($p2j > $para2_ab2j && $p2j <= $para2_ab3j) {
    $hsl2j = 3;
} elseif ($p2j > $para2_ab3j && $p2j <= $para2_ab4j) {
    $hsl2j = 4;
} else {
    $hsl2j = 5;
}

$nilai2j = $hsl2j * $bobot2_9;



//par2k
$para2_abk = $ambang_batas_kredit['kta_per_tkyd'];
$para2_ab2k = $ambang_batas_kredit['rr_kta_per_tkyd'];
$para2_ab3k = $ambang_batas_kredit['rrr_kta_per_tkyd'];
$para2_ab4k = $ambang_batas_kredit['rrrr_kta_per_tkyd'];
if ($p2k <= $para2_abk) {
    $hsl2k = 1;
} else if ($p2k > $para2_abk && $p2k <= $para2_ab2k) {
    $hsl2k = 2;
} else if ($p2k > $para2_ab2k && $p2k <= $para2_ab3k) {
    $hsl2k = 3;
} elseif ($p2k > $para2_ab3k && $p2k <= $para2_ab4k) {
    $hsl2k = 4;
} else {
    $hsl2k = 5;
}

$nilai2k = $hsl2k * $bobot2_10;

//par2l
$para2_abl = $ambang_batas_kredit['kknp_per_tkyd'];
$para2_ab2l = $ambang_batas_kredit['rr_kknp_per_tkyd'];
$para2_ab3l = $ambang_batas_kredit['rrr_kknp_per_tkyd'];
$para2_ab4l = $ambang_batas_kredit['rrrr_kknp_per_tkyd'];
if ($p2l <= $para2_abl) {
    $hsl2l = 1;
} else if ($p2l > $para2_abl && $p2l <= $para2_ab2l) {
    $hsl2l = 2;
} else if ($p2l > $para2_ab2l && $p2l <= $para2_ab3l) {
    $hsl2l = 3;
} elseif ($p2l > $para2_ab3l && $p2l <= $para2_ab4l) {
    $hsl2l = 4;
} else {
    $hsl2l = 5;
}

$nilai2l = $hsl2l * $bobot2_11;



$koreksi2 = $nilai2a + $nilai2b + $nilai2c + $nilai2d + $nilai2e  + $nilai2g + $nilai2h + $nilai2i + $nilai2j
    + $nilai2k + $nilai2l;


// FIX EXCEL: Hasil akhir Kredit Yang Diberikan / Aset Produktif
// Excel N40:
// =IF(M40<L40;L40;IF(L40=0;M40;(M40+L40)/2))
//
// L40 = Rumus   = $hsl2
// M40 = Koreksi = $koreksi2

$rumus2   = (float) $hsl2;
$koreksi2 = round((float) $koreksi2, 2);

if ($koreksi2 < $rumus2) {

    $nilai2 = $rumus2;

} elseif ($rumus2 == 0) {

    $nilai2 = $koreksi2;

} else {

    $nilai2 = ($koreksi2 + $rumus2) / 2;

}

$nilai2 = round($nilai2, 2);






//par 3
$para3_ab = $ambang_batas_kredit['di25_per_tk'];
if ($p3 > $para3_ab) {
    $hsl3 = 0;
} else {
    $hsl3 = 1;
}

//par 4
$para4_ab = $ambang_batas_kredit['kpse_per_tk'];
if ($p4 > $para4_ab) {
    $hsl4 = 0;
} else {
    $hsl4 = 1;
}











//--Parameter 1 PILAR2





$ab_pil2_par1 = $ambang_batas_kredit['apb_per_tap'];
$ab2_pil2_par1 = $ambang_batas_kredit['rr_apb_per_tap'];
$ab3_pil2_par1 = $ambang_batas_kredit['rrr_apb_per_tap'];
$ab4_pil2_par1 = $ambang_batas_kredit['rrrr_apb_per_tap'];


if ($pilar2_p1 == 0) {
    $hsl_pil2_par1 = 0;
} else if ($pilar2_p1 <= $ab_pil2_par1) {
    $hsl_pil2_par1 = 1;
} else if ($pilar2_p1 > $ab_pil2_par1 && $pilar2_p1 <= $ab2_pil2_par1) {
    $hsl_pil2_par1 = 2;
} else if ($pilar2_p1 > $ab2_pil2_par1 && $pilar2_p1 <= $ab3_pil2_par1) {
    $hsl_pil2_par1 = 3;
} elseif ($pilar2_p1 > $ab3_pil2_par1 && $pilar2_p1 <= $ab4_pil2_par1) {
    $hsl_pil2_par1 = 4;
} else {
    $hsl_pil2_par1 = 5;
}


$nilai_pil2_par1 = ($pilar2_1_selected > 0 ? round(($hsl_pil2_par1 + $pilar2_1_selected) / 2, 2) : (float)$hsl_pil2_par1);














//Parameter 2 PILAR2-





$ab_pil2_par2 = $ambang_batas_kredit['kbn_per_tk'];
$ab2_pil2_par2 = $ambang_batas_kredit['rr_kbn_per_tk'];
$ab3_pil2_par2 = $ambang_batas_kredit['rrr_kbn_per_tk'];
$ab4_pil2_par2 = $ambang_batas_kredit['rrrr_kbn_per_tk'];

if ($pilar2_p2 == 0) {
    $hsl_pil2_par2 = 0;
} else if ($pilar2_p2 <= $ab_pil2_par2) {
    $hsl_pil2_par2 = 1;
} else if ($pilar2_p2 > $ab_pil2_par2 && $pilar2_p2 <= $ab2_pil2_par2) {
    $hsl_pil2_par2 = 2;
} else if ($pilar2_p2 > $ab2_pil2_par2 && $pilar2_p2 <= $ab3_pil2_par2) {
    $hsl_pil2_par2 = 3;
} elseif ($pilar2_p2 > $ab3_pil2_par2 && $pilar2_p2 <= $ab4_pil2_par2) {
    $hsl_pil2_par2 = 4;
} else {
    $hsl_pil2_par2 = 5;
}

//par2a
$ab_pil2_par2a = $ambang_batas_kredit['nkp150_per_tkp150'];
$ab_pil2_par22a = $ambang_batas_kredit['rr_nkp150_per_tkp150'];
$ab_pil2_par23a = $ambang_batas_kredit['rrr_nkp150_per_tkp150'];
$ab_pil2_par24a = $ambang_batas_kredit['rrrr_nkp150_per_tkp150'];
if ($pilar2_p2a <= $ab_pil2_par2a) {
    $hsl_pil2_par2a = 1;
} else if ($pilar2_p2a > $ab_pil2_par2a && $pilar2_p2a <= $ab_pil2_par22a) {
    $hsl_pil2_par2a = 2;
} else if ($pilar2_p2a > $ab_pil2_par22a && $pilar2_p2a <= $ab_pil2_par23a) {
    $hsl_pil2_par2a = 3;
} elseif ($pilar2_p2a > $ab_pil2_par23a && $pilar2_p2a <= $ab_pil2_par24a) {
    $hsl_pil2_par2a = 4;
} else {
    $hsl_pil2_par2a = 5;
}


$nilai_pil2_par2a = $hsl_pil2_par2a * $bobot3_1;

//par2b
$ab_pil2_par2b = $ambang_batas_kredit['nkpd50_per_tkpd50'];
$ab_pil2_par22b = $ambang_batas_kredit['rr_nkpd50_per_tkpd50'];
$ab_pil2_par23b = $ambang_batas_kredit['rrr_nkpd50_per_tkpd50'];
$ab_pil2_par24b = $ambang_batas_kredit['rrrr_nkpd50_per_tkpd50'];
if ($pilar2_p2b <= $ab_pil2_par2b) {
    $hsl_pil2_par2b = 1;
} else if ($pilar2_p2b > $ab_pil2_par2b && $pilar2_p2b <= $ab_pil2_par22b) {
    $hsl_pil2_par2b = 2;
} else if ($pilar2_p2b > $ab_pil2_par22b && $pilar2_p2b <= $ab_pil2_par23b) {
    $hsl_pil2_par2b = 3;
} elseif ($pilar2_p2b > $ab_pil2_par23b && $pilar2_p2b <= $ab_pil2_par24b) {
    $hsl_pil2_par2b = 4;
} else {
    $hsl_pil2_par2b = 5;
}


$nilai_pil2_par2b = $hsl_pil2_par2b * $bobot3_2;

//par2c
$ab_pil2_par2c = $ambang_batas_kredit['nkdpapht_prt_tkyd'];
$ab_pil2_par22c = $ambang_batas_kredit['rr_nkdpapht_prt_tkyd'];
$ab_pil2_par23c = $ambang_batas_kredit['rrr_nkdpapht_prt_tkyd'];
$ab_pil2_par24c = $ambang_batas_kredit['rrrr_nkdpapht_prt_tkyd'];
if ($pilar2_p2c <= $ab_pil2_par2c) {
    $hsl_pil2_par2c = 1;
} else if ($pilar2_p2c > $ab_pil2_par2c && $pilar2_p2c <= $ab_pil2_par22c) {
    $hsl_pil2_par2c = 2;
} else if ($pilar2_p2c > $ab_pil2_par22c && $pilar2_p2c <= $ab_pil2_par23c) {
    $hsl_pil2_par2c = 3;
} elseif ($pilar2_p2c > $ab_pil2_par23c && $pilar2_p2c <= $ab_pil2_par24c) {
    $hsl_pil2_par2c = 4;
} else {
    $hsl_pil2_par2c = 5;
}


$nilai_pil2_par2c = $hsl_pil2_par2c * $bobot3_3;




//par2d
$ab_pil2_par2d = $ambang_batas_kredit['nkdpskmht_per_tkyd'];

// Khusus parameter d. NPL Kredit Dengan Perikatan SKMHT / Total KYD
// disamakan dengan template Excel:
// <= ambang batas : 1
// <= 4            : 2
// <= 6            : 3
// <= 8            : 4
// > 8             : 5
if ($pilar2_p2d <= $ab_pil2_par2d) {
    $hsl_pil2_par2d = 1;
} elseif ($pilar2_p2d <= 4) {
    $hsl_pil2_par2d = 2;
} elseif ($pilar2_p2d <= 6) {
    $hsl_pil2_par2d = 3;
} elseif ($pilar2_p2d <= 8) {
    $hsl_pil2_par2d = 4;
} else {
    $hsl_pil2_par2d = 5;
}

$nilai_pil2_par2d = round($hsl_pil2_par2d * $bobot3_4, 2);



//par2e
$ab_pil2_par2e = $ambang_batas_kredit['nalrdbd_per_tknalrdbd'];
$ab_pil2_par22e = $ambang_batas_kredit['rr_nalrdbd_per_tknalrdbd'];
$ab_pil2_par23e = $ambang_batas_kredit['rrr_nalrdbd_per_tknalrdbd'];
$ab_pil2_par24e = $ambang_batas_kredit['rrrr_nalrdbd_per_tknalrdbd'];
if ($pilar2_p2e <= $ab_pil2_par2e) {
    $hsl_pil2_par2e = 1;
} else if ($pilar2_p2e > $ab_pil2_par2e && $pilar2_p2e <= $ab_pil2_par22e) {
    $hsl_pil2_par2e = 2;
} else if ($pilar2_p2e > $ab_pil2_par22e && $pilar2_p2e <= $ab_pil2_par23e) {
    $hsl_pil2_par2e = 3;
} elseif ($pilar2_p2e > $ab_pil2_par23e && $pilar2_p2e <= $ab_pil2_par24e) {
    $hsl_pil2_par2e = 4;
} else {
    $hsl_pil2_par2e = 5;
}


$nilai_pil2_par2e = $hsl_pil2_par2e * $bobot3_5;




//par2f
$ab_pil2_par2f = $ambang_batas_kredit['kmsjt_per_tkyd'];
$ab_pil2_par22f = $ambang_batas_kredit['rr_kmsjt_per_tkyd'];
$ab_pil2_par23f = $ambang_batas_kredit['rrr_kmsjt_per_tkyd'];
$ab_pil2_par24f = $ambang_batas_kredit['rrrr_kmsjt_per_tkyd'];
if ($pilar2_p2f <= $ab_pil2_par2f) {
    $hsl_pil2_par2f = 1;
} else if ($pilar2_p2f > $ab_pil2_par2f && $pilar2_p2f <= $ab_pil2_par22f) {
    $hsl_pil2_par2f = 2;
} else if ($pilar2_p2f > $ab_pil2_par22f && $pilar2_p2f <= $ab_pil2_par23f) {
    $hsl_pil2_par2f = 3;
} elseif ($pilar2_p2f > $ab_pil2_par23f && $pilar2_p2f <= $ab_pil2_par24f) {
    $hsl_pil2_par2f = 4;
} else {
    $hsl_pil2_par2f = 5;
}


$nilai_pil2_par2f = $hsl_pil2_par2f * $bobot3_6;






$koreksi_pil2_par2 = $nilai_pil2_par2a + $nilai_pil2_par2b + $nilai_pil2_par2c + $nilai_pil2_par2d + $nilai_pil2_par2e + $nilai_pil2_par2f;


if ($hsl_pil2_par2 == 0) {
    $nilai_pil2_par2 = $koreksi_pil2_par2;
} else if ($koreksi_pil2_par2 <= $hsl_pil2_par2) {
    $nilai_pil2_par2 = $hsl_pil2_par2;
} else {
    $nilai_pil2_par2 = ($hsl_pil2_par2 + $koreksi_pil2_par2) / 2;
}












//-Parameter 3 PILAR2




$ab_pil2_par3 = $ambang_batas_kredit['kkr_per_tk'];
$ab2_pil2_par3 = $ambang_batas_kredit['rr_kkr_per_tk'];
$ab3_pil2_par3 = $ambang_batas_kredit['rrr_kkr_per_tk'];
$ab4_pil2_par3 = $ambang_batas_kredit['rrrr_kkr_per_tk'];

if ($pilar2_p3 == 0) {
    $hsl_pil2_par3 = 0;
} else if ($pilar2_p3 <= $ab_pil2_par3) {
    $hsl_pil2_par3 = 1;
} else if ($pilar2_p3 > $ab_pil2_par3 && $pilar2_p3 <= $ab2_pil2_par3) {
    $hsl_pil2_par3 = 2;
} else if ($pilar2_p3 > $ab2_pil2_par3 && $pilar2_p3 <= $ab3_pil2_par3) {
    $hsl_pil2_par3 = 3;
} elseif ($pilar2_p3 > $ab3_pil2_par3 && $pilar2_p3 <= $ab4_pil2_par3) {
    $hsl_pil2_par3 = 4;
} else {
    $hsl_pil2_par3 = 5;
}

//par3a
$ab_pil2_par3a = $ambang_batas_kredit['kp4_per_tkyd'];
$ab_pil2_par32a = $ambang_batas_kredit['rr_kp4_per_tkyd'];
$ab_pil2_par33a = $ambang_batas_kredit['rrr_kp4_per_tkyd'];
$ab_pil2_par34a = $ambang_batas_kredit['rrrr_kp4_per_tkyd'];
if ($pilar2_p3a <= $ab_pil2_par3a) {
    $hsl_pil2_par3a = 1;
} else if ($pilar2_p3a > $ab_pil2_par3a && $pilar2_p3a <= $ab_pil2_par32a) {
    $hsl_pil2_par3a = 2;
} else if ($pilar2_p3a > $ab_pil2_par32a && $pilar2_p3a <= $ab_pil2_par33a) {
    $hsl_pil2_par3a = 3;
} elseif ($pilar2_p3a > $ab_pil2_par33a && $pilar2_p3a <= $ab_pil2_par34a) {
    $hsl_pil2_par3a = 4;
} else {
    $hsl_pil2_par3a = 5;
}


$nilai_pil2_par3a = $hsl_pil2_par3a * $bobot4_1;

//par3b
$ab_pil2_par3b = $ambang_batas_kredit['kdp3p4_per_tkyd'];
$ab_pil2_par32b = $ambang_batas_kredit['rr_kdp3p4_per_tkyd'];
$ab_pil2_par33b = $ambang_batas_kredit['rrr_kdp3p4_per_tkyd'];
$ab_pil2_par34b = $ambang_batas_kredit['rrrr_kdp3p4_per_tkyd'];
if ($pilar2_p3b <= $ab_pil2_par3b) {
    $hsl_pil2_par3b = 1;
} else if ($pilar2_p3b > $ab_pil2_par3b && $pilar2_p3b <= $ab_pil2_par32b) {
    $hsl_pil2_par3b = 2;
} else if ($pilar2_p3b > $ab_pil2_par32b && $pilar2_p3b <= $ab_pil2_par33b) {
    $hsl_pil2_par3b = 3;
} elseif ($pilar2_p3b > $ab_pil2_par33b && $pilar2_p3b <= $ab_pil2_par34b) {
    $hsl_pil2_par3b = 4;
} else {
    $hsl_pil2_par3b = 5;
}


$nilai_pil2_par3b = $hsl_pil2_par3b * $bobot4_2;

//par3c
$ab_pil2_par3c = $ambang_batas_kredit['nf6bt_per_ne6bt'];
$ab_pil2_par32c = $ambang_batas_kredit['rr_nf6bt_per_ne6bt'];
$ab_pil2_par33c = $ambang_batas_kredit['rrr_nf6bt_per_ne6bt'];
$ab_pil2_par34c = $ambang_batas_kredit['rrrr_nf6bt_per_ne6bt'];
if ($pilar2_p3c <= $ab_pil2_par3c) {
    $hsl_pil2_par3c = 1;
} else if ($pilar2_p3c > $ab_pil2_par3c && $pilar2_p3c <= $ab_pil2_par32c) {
    $hsl_pil2_par3c = 2;
} else if ($pilar2_p3c > $ab_pil2_par32c && $pilar2_p3c <= $ab_pil2_par33c) {
    $hsl_pil2_par3c = 3;
} elseif ($pilar2_p3c > $ab_pil2_par33c && $pilar2_p3c <= $ab_pil2_par34c) {
    $hsl_pil2_par3c = 4;
} else {
    $hsl_pil2_par3c = 5;
}


$nilai_pil2_par3c = $hsl_pil2_par3c * $bobot4_3;




//par3d
$ab_pil2_par3d = $ambang_batas_kredit['nomf6bt_per_pe6bt'];
$ab_pil2_par32d = $ambang_batas_kredit['rr_nomf6bt_per_pe6bt'];
$ab_pil2_par33d = $ambang_batas_kredit['rrr_nomf6bt_per_pe6bt'];
$ab_pil2_par34d = $ambang_batas_kredit['rrrr_nomf6bt_per_pe6bt'];
if ($pilar2_p3d <= $ab_pil2_par3d) {
    $hsl_pil2_par3d = 1;
} else if ($pilar2_p3d > $ab_pil2_par3d && $pilar2_p3d <= $ab_pil2_par32d) {
    $hsl_pil2_par3d = 2;
} else if ($pilar2_p3d > $ab_pil2_par32d && $pilar2_p3d <= $ab_pil2_par33d) {
    $hsl_pil2_par3d = 3;
} elseif ($pilar2_p3d > $ab_pil2_par33d && $pilar2_p3d <= $ab_pil2_par34d) {
    $hsl_pil2_par3d = 4;
} else {
    $hsl_pil2_par3d = 5;
}


$nilai_pil2_par3d = $hsl_pil2_par3d * $bobot4_4;









$koreksi_pil2_par3 = $nilai_pil2_par3a + $nilai_pil2_par3b + $nilai_pil2_par3c + $nilai_pil2_par3d;


if ($hsl_pil2_par3 == 0) {
    $nilai_pil2_par3 = $koreksi_pil2_par3;
} else if ($koreksi_pil2_par3 < $hsl_pil2_par3) {
    $nilai_pil2_par3 = $hsl_pil2_par3;
} else {
    $nilai_pil2_par3 = ($hsl_pil2_par3 + $koreksi_pil2_par3) / 2;
}


//rumus hasil pilar 2
$hsl_max_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$pil2_tertinggi = max($hsl_max_pil2);

$hsl_min_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$pil2_terendah = min($hsl_min_pil2);

$hsl_avg_pil2 = array($nilai_pil2_par1, $nilai_pil2_par2, $nilai_pil2_par3);
$sum = array_sum($hsl_avg_pil2);
$pil2_rata_rata = $sum / count($hsl_avg_pil2);

if ($set_pil2 == 1) {

    $pil2_tingkat_risiko = $pil2_tertinggi ;
} else if ($set_pil2 == 2) {

    $pil2_tingkat_risiko = $pil2_terendah;
} else if ($set_pil2 == 3) {

    $pil2_tingkat_risiko = $pil2_rata_rata;
} else {
$pil2_tingkat_risiko = 0;
}













function pv($key, $default = ''){
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

if (isset($_POST['submit']) || pv('autosave') == '1') {
    $is_autosave = (pv('autosave') == '1');
    require dirname(__DIR__, 2).'/conn/conn.php';

    ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar1', $id);
    ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar2', $id);
    ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar3', $id);
    ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_pilar4', $id);
    ensure_id_profil_risiko_row_local($conn, 'inheren_kredit_lainnya', $id);
    ensure_id_profil_risiko_row_local($conn, 'hasil_inheren_kredit', $id);
    ensure_id_profil_risiko_row_local($conn, 'keterangan_inheren_kredit', $id);



//p1
    $hasil_pil1_par1 = $nilai;
    $hasil_pil1_par1a = $nilai1a;
    $hasil_pil1_par1b = $nilai1b;
    $hasil_pil1_par1c = $nilai1c;
    $hasil_pil1_par1d = $nilai2m;
    $hasil_pil1_par1e = $nilai2n;
    $hasil_pil1_par1f = $nilai_pil2_par1a;
    $hasil_pil1_par1g = $nilai_pil2_par1b;
    $hasil_pil1_par1h = 0;
    $hasil_pil1_par2 = $nilai2;
    $hasil_pil1_par2a = $nilai2a;
    $hasil_pil1_par2b = $nilai2b;
    $hasil_pil1_par2c = $nilai2c;
    $hasil_pil1_par2d = $nilai2d;
    $hasil_pil1_par2e = $nilai2e;
    $hasil_pil1_par2f = $nilai2g;
    $hasil_pil1_par2g = $nilai2h;
    $hasil_pil1_par2h = $nilai2i;
    $hasil_pil1_par2i = $nilai2j;
    $hasil_pil1_par2j = $nilai2k;
    $hasil_pil1_par2k = $nilai2l;
    $pilar1_3 = pv('target_pasar1');
    $hasil_pil1_par3 = pv('nilaippl1_par3');
    $pilar1_4 = pv('sektor_terbesar3');
    $hasil_pil1_par4 = pv('nilaippl1_par4');

    //p2
    $pilar2_1 = pv('pilar2_1');

    //p3
    $pilar3_1 = pv('penyaluran_kredit');
    $pilar3_1a = pv('penyaluran_kredit2');
    $pilar3_1b = pv('penyaluran_kredit3');
    $pilar3_1c = pv('penyaluran_kredit3_5');
    $pilar3_1d = pv('penyaluran_kredit4');
    $pilar3_1e = pv('penyaluran_kredit5');

    // Hitung ulang di server memakai rumus Excel, agar autosave/submit tidak
    // menyimpan nilai lama atau nilai yang hanya berasal dari DOM browser.
    $hasil_pil3_par1 = fmt2(hasil_excel_rumus_koreksi_kredit(
        $hsl_pil3_par1,
        ($pilar3_1 !== '' && is_numeric($pilar3_1)) ? (float)$pilar3_1 : null
    ));
    $hasil_pil3_par1a = pv('nilaippl3_par1a');
    $hasil_pil3_par1b = pv('nilaippl3_par1b');
    $hasil_pil3_par1c = pv('nilaippl3_par1c');
    $hasil_pil3_par1d = pv('nilaippl3_par1d');
    $hasil_pil3_par1e = pv('nilaippl3_par1e');

    //p4
    $pilar4_1a = pv('pilar4_1a');
    $pilar4_1b = pv('pilar4_1b');
    $pilar4_1c = pv('pilar4_1c');
    $pilar4_1d = pv('pilar4_1d');
    $hasil_pil4_par1 = pv('risiko_pil4');
    $hasil_pil4_par1a = pv('nilaippl4_par1a');
    $hasil_pil4_par1b = pv('nilaippl4_par1b');
    $hasil_pil4_par1c = pv('nilaippl4_par1c');
    $hasil_pil4_par1d = pv('nilaippl4_par1d');
    
    //lainnya - hanya sub parameter A dan B
    $pilar5_1a = pv('pilar5_1a');
    $pilar5_1b = pv('pilar5_1b');
    // Sub parameter C s.d. K tidak digunakan lagi
    $pilar5_1c = '0';
    $pilar5_1d = '0';
    $pilar5_1e = '0';
    $pilar5_1f = '0';
    $pilar5_1g = '0';
    $pilar5_1h = '0';
    $pilar5_1i = '0';
    $pilar5_1j = '0';
    $pilar5_1k = '0';
    $hasil_pil5_par1a = pv('nilaippl5_par1a');
    $hasil_pil5_par1b = pv('nilaippl5_par1b');
    $hasil_pil5_par1 = number_format(((float)$hasil_pil5_par1a + (float)$hasil_pil5_par1b), 2, '.', '');
    $hasil_pil5_par1c = '0';
    $hasil_pil5_par1d = '0';
    $hasil_pil5_par1e = '0';
    $hasil_pil5_par1f = '0';
    $hasil_pil5_par1g = '0';
    $hasil_pil5_par1h = '0';
    $hasil_pil5_par1i = '0';
    $hasil_pil5_par1j = '0';
    $hasil_pil5_par1k = '0';

//hasil
    $pil1_tertinggi = pv('tertinggi_pil1');
    $pil1_terendah = pv('terendah_pil1');
    $pil1_rata_rata = pv('rata_rata_pil1');
    $pil1_risiko_ditetapkan = ($setris_mode === 'pembobotan' ? $setris_bobot_pil1 : $set_pil1);
    $pil1_tingkat_risiko = pv('risiko_pil1');
    $pil2_tertinggi = pv('pilar2_max');
    $pil2_terendah = pv('pilar2_min');
    $pil2_rata_rata = pv('pilar2_avg');
    $pil2_risiko_ditetapkan = ($setris_mode === 'pembobotan' ? $setris_bobot_pil2 : $set_pil2);
    $pil2_tingkat_risiko = pv('pil2_tingkat_risiko');
    // FIX: hitung ulang rekap Pilar 3 dari 6 nilai hasil pada request ini.
    $pil3_post_values = array(
        (float)$hasil_pil3_par1,
        (float)$hasil_pil3_par1a,
        (float)$hasil_pil3_par1b,
        (float)$hasil_pil3_par1c,
        (float)$hasil_pil3_par1d,
        (float)$hasil_pil3_par1e
    );
    $pil3_tertinggi = round(max($pil3_post_values), 2);
    $pil3_terendah  = round(min($pil3_post_values), 2);
    $pil3_rata_rata = round(array_sum($pil3_post_values) / count($pil3_post_values), 2);
    $pil3_risiko_ditetapkan = ($setris_mode === 'pembobotan' ? $setris_bobot_pil3 : $set_pil3);

    if ($setris_mode === 'pembobotan') {
        $pil3_tingkat_risiko = round($pil3_rata_rata * ((float)$setris_bobot_pil3 / 100), 2);
    } elseif ((int)$set_pil3 === 1) {
        $pil3_tingkat_risiko = $pil3_tertinggi;
    } elseif ((int)$set_pil3 === 2) {
        $pil3_tingkat_risiko = $pil3_terendah;
    } else {
        $pil3_tingkat_risiko = $pil3_rata_rata;
    }
    $pil4_tertinggi = pv('tertinggi_pil4');
    $pil4_terendah = pv('terendah_pil4');
    $pil4_rata_rata = pv('rata_rata_pil4');
    $pil4_tingkat_risiko = pv('risiko_pil4');
    $pil5_tertinggi = pv('tertinggi_pil5');
    $pil5_terendah = pv('terendah_pil5');
    $pil5_rata_rata = pv('rata_rata_pil5');
    $pil5_tingkat_risiko = number_format(((float)$hasil_pil5_par1a + (float)$hasil_pil5_par1b), 2, '.', '');
    $hasil_inheren_tertinggi = pv('tertinggi_inheren');
    $hasil_inheren_terendah = pv('terendah_inheren');
    $hasil_inheren_rata_rata = pv('rata_rata_inheren');
    $hasil_risiko_ditetapkan = ($setris_mode === 'pembobotan' ? 0 : (int)pv('opsi_inheren', $set_tingkat_risiko));
    $hasil_tingkat_risiko = pv('risiko_inheren');
    $hasil_peringkat = pv('peringkat_inheren');

    //ket
    $ket_pil1_1 = esc_post_local($conn, 'ket_pil1_1');
    $ket_pil1_2 = esc_post_local($conn, 'ket_pil1_2');
    $ket_pil1_3 = esc_post_local($conn, 'ket_pil1_3');
    $ket_pil1_4 = esc_post_local($conn, 'ket_pil1_4');
    $ket_pil1 = esc_post_local($conn, 'ket_pil1');
    $ket_pil2_1 = esc_post_local($conn, 'ket_pil2_1');
    $ket_pil2_2 = esc_post_local($conn, 'ket_pil2_2');
    $ket_pil2_3 = esc_post_local($conn, 'ket_pil2_3');
    $ket_pil2 = esc_post_local($conn, 'ket_pil2');
    $ket_pil3_1 = esc_post_local($conn, 'ket_pil3_1');
    $ket_pil3 = esc_post_local($conn, 'ket_pil3');
    $ket_pil4_1 = esc_post_local($conn, 'ket_pil4_1');
    $ket_pil4 = esc_post_local($conn, 'ket_pil4');
    $ket_pil5_1 = esc_post_local($conn, 'ket_pil5_1');
    $ket_pil5 = esc_post_local($conn, 'ket_pil5');
    $ket_inheren = esc_post_local($conn, 'ket_inheren');




    must_query_local($conn, "UPDATE inheren_kredit_pilar1 SET 
        hasil_pil1_par1 = '$hasil_pil1_par1',
        hasil_pil1_par1a = '$hasil_pil1_par1a',
        hasil_pil1_par1b = '$hasil_pil1_par1b',
        hasil_pil1_par1c = '$hasil_pil1_par1c',
        hasil_pil1_par1d = '$hasil_pil1_par1d',
        hasil_pil1_par1e = '$hasil_pil1_par1e',
        hasil_pil1_par1f = '$hasil_pil1_par1f',
        hasil_pil1_par1g = '$hasil_pil1_par1g',
        hasil_pil1_par1h = '$hasil_pil1_par1h',
        hasil_pil1_par2 = '$hasil_pil1_par2',
        hasil_pil1_par2a = '$hasil_pil1_par2a',
        hasil_pil1_par2b = '$hasil_pil1_par2b',
        hasil_pil1_par2c = '$hasil_pil1_par2c',
        hasil_pil1_par2d = '$hasil_pil1_par2d',
        hasil_pil1_par2e = '$hasil_pil1_par2e',
        hasil_pil1_par2f = '$hasil_pil1_par2f',
        hasil_pil1_par2g = '$hasil_pil1_par2g',
        hasil_pil1_par2h = '$hasil_pil1_par2h',
        hasil_pil1_par2i = '$hasil_pil1_par2i',
        hasil_pil1_par2j = '$hasil_pil1_par2j',
        hasil_pil1_par2k = '$hasil_pil1_par2k',
        pilar1_3 = '$pilar1_3',
        hasil_pil1_par3 = '$hasil_pil1_par3',
        pilar1_4 = '$pilar1_4',
        hasil_pil1_par4 = '$hasil_pil1_par4'
    WHERE id_profil_risiko = '$id'");



    must_query_local($conn, "UPDATE inheren_kredit_pilar2 SET 
        pilar2_1 = '$pilar2_1',
        hasil_pil2_par1 = '$nilai_pil2_par1',
        hasil_pil2_par2 = '$nilai_pil2_par2',
        hasil_pil2_par2a = '$nilai_pil2_par2a',
        hasil_pil2_par2b = '$nilai_pil2_par2b',
        hasil_pil2_par2c = '$nilai_pil2_par2c',
        hasil_pil2_par2d = '$nilai_pil2_par2d',
        hasil_pil2_par2e = '$nilai_pil2_par2e',
        hasil_pil2_par2f = '$nilai_pil2_par2f',
        hasil_pil2_par3 = '$nilai_pil2_par3',
        hasil_pil2_par3a = '$nilai_pil2_par3a',
        hasil_pil2_par3b = '$nilai_pil2_par3b',
        hasil_pil2_par3c = '$nilai_pil2_par3c',
        hasil_pil2_par3d = '$nilai_pil2_par3d'
    WHERE id_profil_risiko = '$id'");


    must_query_local($conn, "UPDATE inheren_kredit_pilar3 SET 
        pilar3_1 = '$pilar3_1',
        pilar3_1a = '$pilar3_1a',
        pilar3_1b = '$pilar3_1b',
        pilar3_1c = '$pilar3_1c',
        pilar3_1d = '$pilar3_1d',
        pilar3_1e = '$pilar3_1e',
        hasil_pil3_par1 = '$hasil_pil3_par1',
        hasil_pil3_par1a = '$hasil_pil3_par1a',
        hasil_pil3_par1b = '$hasil_pil3_par1b',
        hasil_pil3_par1c = '$hasil_pil3_par1c',
        hasil_pil3_par1d = '$hasil_pil3_par1d',
        hasil_pil3_par1e = '$hasil_pil3_par1e'
    WHERE id_profil_risiko = '$id'");

    must_query_local($conn, "UPDATE inheren_kredit_pilar4 SET 
        pilar4_1a = '$pilar4_1a',
        pilar4_1b = '$pilar4_1b',
        pilar4_1c = '$pilar4_1c',
        pilar4_1d = '$pilar4_1d',
        hasil_pil4_par1 = '$hasil_pil4_par1',
        hasil_pil4_par1a = '$hasil_pil4_par1a',
        hasil_pil4_par1b = '$hasil_pil4_par1b',
        hasil_pil4_par1c = '$hasil_pil4_par1c',
        hasil_pil4_par1d = '$hasil_pil4_par1d'
    WHERE id_profil_risiko = '$id'");


    must_query_local($conn, "UPDATE inheren_kredit_lainnya SET 
        pilar5_1a = '$pilar5_1a',
        pilar5_1b = '$pilar5_1b',
        pilar5_1c = '$pilar5_1c',
        pilar5_1d = '$pilar5_1d',
        pilar5_1e = '$pilar5_1e',
        pilar5_1f = '$pilar5_1f',
        pilar5_1g = '$pilar5_1g',
        pilar5_1h = '$pilar5_1h',
        pilar5_1i = '$pilar5_1i',
        pilar5_1j = '$pilar5_1j',
        pilar5_1k = '$pilar5_1k',
        hasil_pil5_par1 = '$hasil_pil5_par1',
        hasil_pil5_par1a = '$hasil_pil5_par1a',
        hasil_pil5_par1b = '$hasil_pil5_par1b',
        hasil_pil5_par1c = '$hasil_pil5_par1c',
        hasil_pil5_par1d = '$hasil_pil5_par1d',
        hasil_pil5_par1e = '$hasil_pil5_par1e',
        hasil_pil5_par1f = '$hasil_pil5_par1f',
        hasil_pil5_par1g = '$hasil_pil5_par1g',
        hasil_pil5_par1h = '$hasil_pil5_par1h',
        hasil_pil5_par1i = '$hasil_pil5_par1i',
        hasil_pil5_par1j = '$hasil_pil5_par1j',
        hasil_pil5_par1k = '$hasil_pil5_par1k'
    WHERE id_profil_risiko = '$id'");


    must_query_local($conn, "UPDATE hasil_inheren_kredit SET 
        pil1_tertinggi = '$pil1_tertinggi',
        pil1_terendah = '$pil1_terendah',
        pil1_rata_rata = '$pil1_rata_rata',
        pil1_risiko_ditetapkan = '$pil1_risiko_ditetapkan',
        pil1_tingkat_risiko = '$pil1_tingkat_risiko',
        pil2_tertinggi = '$pil2_tertinggi',
        pil2_terendah = '$pil2_terendah',
        pil2_rata_rata = '$pil2_rata_rata',
        pil2_risiko_ditetapkan = '$pil2_risiko_ditetapkan',
        pil2_tingkat_risiko = '$pil2_tingkat_risiko',
        pil3_tertinggi = '$pil3_tertinggi',
        pil3_terendah = '$pil3_terendah',
        pil3_rata_rata = '$pil3_rata_rata',
        pil3_risiko_ditetapkan = '$pil3_risiko_ditetapkan',
        pil3_tingkat_risiko = '$pil3_tingkat_risiko',
        pil4_tertinggi = '$pil4_tertinggi',
        pil4_terendah = '$pil4_terendah',
        pil4_rata_rata = '$pil4_rata_rata',
        pil4_tingkat_risiko = '$pil4_tingkat_risiko',
        pil5_tertinggi = '$pil5_tertinggi',
        pil5_terendah = '$pil5_terendah',
        pil5_rata_rata = '$pil5_rata_rata',
        pil5_tingkat_risiko = '$pil5_tingkat_risiko',
        hasil_inheren_tertinggi = '$hasil_inheren_tertinggi',
        hasil_inheren_terendah = '$hasil_inheren_terendah',
        hasil_inheren_rata_rata = '$hasil_inheren_rata_rata',
        hasil_risiko_ditetapkan = '$hasil_risiko_ditetapkan',
        hasil_tingkat_risiko = '$hasil_tingkat_risiko',
        hasil_peringkat = '$hasil_peringkat'
    WHERE id_profil_risiko = '$id'");


    must_query_local($conn, "UPDATE keterangan_inheren_kredit SET 
        ket_pil1_1 ='$ket_pil1_1',
        ket_pil1_2 ='$ket_pil1_2',
        ket_pil1_3 ='$ket_pil1_3',
        ket_pil1_4 ='$ket_pil1_4',
        ket_pil1 ='$ket_pil1',
        ket_pil2_1 ='$ket_pil2_1',
        ket_pil2_2 ='$ket_pil2_2',
        ket_pil2_3 ='$ket_pil2_3',
        ket_pil2 ='$ket_pil2',
        ket_pil3_1 ='$ket_pil3_1',
        ket_pil3 ='$ket_pil3',
        ket_pil4_1 ='$ket_pil4_1',
        ket_pil4 ='$ket_pil4',
        ket_pil5_1 ='$ket_pil5_1',
        ket_pil5 ='$ket_pil5',
        ket_inheren ='$ket_inheren'
    WHERE id_profil_risiko = '$id'");

    if ($is_autosave) {
        if (!headers_sent()) { header('Content-Type: application/json; charset=utf-8'); }
        echo json_encode(array('success' => true));
        exit();
    }

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kre_inhern&id=$id");
    exit();
}

?>



<style>
.info-kuantitatif-btn{
    width:26px;
    height:26px;
    border:0;
    border-radius:999px;
    background:#eef2ff;
    color:#4f46e5;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-left:6px;
    vertical-align:middle;
    cursor:pointer;
}
.info-kuantitatif-btn:hover{background:#6658dd;color:#fff}
.info-kuantitatif-pop{display:none;position:fixed;inset:0;z-index:100000;background:rgba(15,23,42,.42);align-items:center;justify-content:center;padding:18px}
.info-kuantitatif-pop.show{display:flex}
.info-kuantitatif-card{width:min(560px,94vw);background:#fff;border-radius:12px;box-shadow:0 24px 60px rgba(15,23,42,.24);padding:18px}
.info-kuantitatif-head{display:flex;align-items:center;justify-content:space-between;gap:12px;border-bottom:1px solid #eef0f4;padding-bottom:10px;margin-bottom:12px}
.info-kuantitatif-head h5{margin:0;font-weight:800}
.info-kuantitatif-close{width:32px;height:32px;border:0;border-radius:999px;background:#f3f4f6;color:#334155;font-size:18px}
.info-kuantitatif-text{white-space:pre-wrap;line-height:1.45;color:#334155}
</style>
<div class="info-kuantitatif-pop" id="infoKuantitatifPop" aria-hidden="true">
    <div class="info-kuantitatif-card">
        <div class="info-kuantitatif-head">
            <h5>Info Kuantitatif</h5>
            <button type="button" class="info-kuantitatif-close" id="infoKuantitatifClose" aria-label="Tutup"><i class="mdi mdi-close"></i></button>
        </div>
        <div class="info-kuantitatif-text" id="infoKuantitatifText"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
    var pop = document.getElementById('infoKuantitatifPop');
    var text = document.getElementById('infoKuantitatifText');
    var close = document.getElementById('infoKuantitatifClose');
    document.querySelectorAll('.info-kuantitatif-btn').forEach(function(btn){
        btn.addEventListener('click', function(){
            if(text) text.textContent = this.getAttribute('data-info') || 'Info kuantitatif belum diisi.';
            if(pop) pop.classList.add('show');
        });
    });
    function hide(){ if(pop) pop.classList.remove('show'); }
    if(close) close.addEventListener('click', hide);
    if(pop) pop.addEventListener('click', function(e){ if(e.target === pop) hide(); });
});
</script>
<script>

        $(document).ready(function() {
            $('#ket_pil1_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1_4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter7').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2_3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter8').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter9').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil3_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter10').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter11').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil4_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter12').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter13').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil5_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter14').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil5').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter15').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter16').text(charCount);
            });
        });
</script>








                                    <script type="text/javascript">
                                        $(document).ready(function() {

                                            $('#target_pasar1').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par3").val(val);

                                                var hsl3 = <?php echo json_encode($hsl3); ?>;

                                                if (hsl3 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl3) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par3").val(nilai);
                                            });

                                            
                                            $('#sektor_terbesar3').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par4").val(val);

                                                var hsl4 = <?php echo json_encode($hsl4); ?>;

                                                if (hsl4 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl4) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par4").val(nilai);
                                            });

                                            $("#target_pasar1, #sektor_terbesar3").change(function() {
                                                var pilar1_par1 = <?php echo json_encode((float)$nilai); ?>;
                                                var pilar1_par2 = <?php echo json_encode((float)$nilai2); ?>;
                                                var pilar1_par3 = $("#nilaippl1_par3").val();
                                                var pilar1_par4 = $("#nilaippl1_par4").val();


                                                const max = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4];
                                                const maxValue = Math.max(...max);
                                                tertinggi_pil1 = maxValue.toFixed(2);

                                                $("#tertinggi_pil1").val(tertinggi_pil1);
                                    

                                                const min = [pilar1_par1, pilar1_par2, pilar1_par3, pilar1_par4];
                                                const minValue = Math.min(...min);
                                                terendah_pil1 = minValue.toFixed(2);

                                                $("#terendah_pil1").val(terendah_pil1);

                                                var total_rata_rata = parseFloat(pilar1_par1) + parseFloat(pilar1_par2) + parseFloat(pilar1_par3) + parseFloat(pilar1_par4);
                                                
                                                var rata_rata_pil1 = parseFloat(total_rata_rata) / 4;
                                                rata_rata_pil1 = rata_rata_pil1.toFixed(2);

                                                rr1 = rata_rata_pil1;

                                                $("#rata_rata_pil1").val(rata_rata_pil1);
                                            });

                                            $("#target_pasar1, #sektor_terbesar3").change(function() {
                                                var set_pil3 = <?php echo json_encode((int)$set_pil3); ?>;
                                                if (set_pil3 == 1) {
                                                    var risiko_pil1 = tertinggi_pil1;
                                                } else if (set_pil3 == 2) {
                                                    var risiko_pil1 = terendah_pil1;
                                                } else if (set_pil3 == 3) {
                                                    var risiko_pil1 = rr1;
                                                } else {
                                                    var risiko_pil1 = 0;
                                                }

                                                $("#risiko_pil1").val(risiko_pil1);
                                                $("#hasil_risiko_pil1").val(risiko_pil1);
                                            });


                                            function hitungPilar3Par1SesuaiExcel() {
                                                var rumus = Number(<?php echo json_encode((float)$hsl_pil3_par1); ?>);
                                                var rawKoreksi = String($('#penyaluran_kredit').val() || '').trim();
                                                var koreksi = rawKoreksi === '' ? NaN : Number(rawKoreksi);

                                                // Excel N184:
                                                // =IF(M184<L184;L184;(L184+M184)/2)
                                                var nilai = Number.isFinite(koreksi)
                                                    ? (koreksi < rumus ? rumus : (rumus + koreksi) / 2)
                                                    : rumus;

                                                $('#koreksippl3_par1').val(
                                                    Number.isFinite(koreksi) ? koreksi.toFixed(2) : ''
                                                );
                                                $('#nilaippl3_par1').val(Number(nilai).toFixed(2));
                                            }

                                            $('#penyaluran_kredit').on('change', hitungPilar3Par1SesuaiExcel);

                                            // Koreksi nilai lama dari database saat halaman pertama dibuka.
                                            hitungPilar3Par1SesuaiExcel();

                                            
                                            $('#penyaluran_kredit2').change(function() {
                                              
                                                var val = this.value;
                                                $("#koreksippl3_par1a").val(val);
                                                var koreksippl3_par1a = $("#koreksippl3_par1a").val();
                                                var hsl_pil3_par1a = <?php echo json_encode($hsl_pil3_par1a); ?>;

                                                if (hsl_pil3_par1a > koreksippl3_par1a) {
                                                    var nilai = hsl_pil3_par1a.toFixed(2);
                                                } else if (hsl_pil3_par1a == koreksippl3_par1a) {
                                                    var nilai = hsl_pil3_par1a.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1a) + parseFloat(koreksippl3_par1a)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1a").val(nilai);
                                            });


                                            $('#penyaluran_kredit3').change(function() {
                                              
                                                var val = this.value;
                                                $("#koreksippl3_par1b").val(val);
                                                var koreksippl3_par1b = $("#koreksippl3_par1b").val();
                                                var hsl_pil3_par1b = <?php echo json_encode($hsl_pil3_par1b); ?>;

                                                if (hsl_pil3_par1b > koreksippl3_par1b) {
                                                    var nilai = hsl_pil3_par1b.toFixed(2);
                                                } else if (hsl_pil3_par1b == koreksippl3_par1b) {
                                                    var nilai = hsl_pil3_par1b.toFixed(2);
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1b) + parseFloat(koreksippl3_par1b)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1b").val(nilai);
                                            });

                                            $('#penyaluran_kredit3_5').change(function() {
                                              
                                              var val = this.value;
                                              $("#koreksippl3_par1c").val(val);
                                              var koreksippl3_par1c = $("#koreksippl3_par1c").val();
                                              var hsl_pil3_par1c = <?php echo json_encode($hsl_pil3_par1c_rumus); ?>;

                                              if (hsl_pil3_par1c > koreksippl3_par1c) {
                                                  var nilai = hsl_pil3_par1c.toFixed(2);
                                              } else if (hsl_pil3_par1c == koreksippl3_par1c) {
                                                  var nilai = hsl_pil3_par1c.toFixed(2);
                                              } else {
                                                  var nilai = (parseFloat(hsl_pil3_par1c) + parseFloat(koreksippl3_par1c)) / 2;
                                                  nilai = nilai.toFixed(2);
                                              }
                                              $("#nilaippl3_par1c").val(nilai);
                                          });

                                            $('#penyaluran_kredit4').change(function() {
                                                var val = this.value;
                                                $("#koreksippl3_par1d").val(val);
                                          

                                                var hsl_pil3_par1d_rumus = <?php echo json_encode($hsl_pil3_par1d_rumus); ?>;

                                                if (hsl_pil3_par1d_rumus == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1d_rumus) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1d").val(nilai);
                                            });


                                            $('#penyaluran_kredit5').change(function() {
                                                var val = this.value;
                                                $("#koreksippl3_par1e").val(val);
                                          

                                                var hsl_pil3_par1e_rumus = <?php echo json_encode($hsl_pil3_par1e_rumus); ?>;

                                                if (hsl_pil3_par1e_rumus == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl_pil3_par1e_rumus) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl3_par1e").val(nilai);
                                            });

                                            // FIX REKAP PILAR 3:
                                            // selalu hitung dari 6 nilai hasil yang sedang tampil,
                                            // termasuk saat halaman pertama kali dibuka.
                                            function refreshPilar3Rekap() {
                                                var values = [
                                                    parseFloat($("#nilaippl3_par1").val())  || 0,
                                                    parseFloat($("#nilaippl3_par1a").val()) || 0,
                                                    parseFloat($("#nilaippl3_par1b").val()) || 0,
                                                    parseFloat($("#nilaippl3_par1c").val()) || 0,
                                                    parseFloat($("#nilaippl3_par1d").val()) || 0,
                                                    parseFloat($("#nilaippl3_par1e").val()) || 0
                                                ];

                                                var tertinggi_pil3 = Math.max.apply(null, values);
                                                var terendah_pil3  = Math.min.apply(null, values);
                                                var total_pil3 = values.reduce(function(total, value) {
                                                    return total + value;
                                                }, 0);
                                                var rata_rata_pil3 = total_pil3 / values.length;

                                                $("#tertinggi_pil3").val(tertinggi_pil3.toFixed(2));
                                                $("#terendah_pil3").val(terendah_pil3.toFixed(2));
                                                $("#rata_rata_pil3").val(rata_rata_pil3.toFixed(2));

                                                var setrisModePilar3 = <?php echo json_encode($setris_mode); ?>;
                                                var set_pil3 = <?php echo json_encode((int)$set_pil3); ?>;
                                                var bobot_pil3 = <?php echo json_encode((float)$setris_bobot_pil3); ?>;
                                                var risiko_pil3 = 0;

                                                if (setrisModePilar3 === 'pembobotan') {
                                                    risiko_pil3 = rata_rata_pil3 * (parseFloat(bobot_pil3 || 0) / 100);
                                                } else if (set_pil3 == 1) {
                                                    risiko_pil3 = tertinggi_pil3;
                                                } else if (set_pil3 == 2) {
                                                    risiko_pil3 = terendah_pil3;
                                                } else {
                                                    risiko_pil3 = rata_rata_pil3;
                                                }

                                                $("#risiko_pil3").val(risiko_pil3.toFixed(2));
                                                $("#hasil_risiko_pil3").val(risiko_pil3.toFixed(2));
                                            }

                                            $("#penyaluran_kredit, #penyaluran_kredit2_1, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5")
                                                .on('change input', function() {
                                                    refreshPilar3Rekap();
                                                });

                                            // Jangan menunggu user mengubah dropdown; hitung saat load.
                                            refreshPilar3Rekap();
                                        

                                            $('#pilar4_1a').change(function() {
                                                var pilar4_1a = $("#pilar4_1a").val();

                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                $("#nilaippl4_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar4_1b').change(function() {
                                                var pilar4_1b = $("#pilar4_1b").val();

                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                $("#nilaippl4_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar4_1c').change(function() {
                                                var pilar4_1c = $("#pilar4_1c").val();

                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                $("#nilaippl4_p1c").val(nilai2);
                                            });

                                            $('#pilar4_1d').change(function() {
                                                var pilar4_1d = $("#pilar4_1d").val();

                                                var bobot6_4 = <?php echo json_encode($bobot6_4); ?>;

                                                
                                                var nilai = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl4_par1d").val(nilai);

                                                var nilai2 = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                $("#nilaippl4_p1d").val(nilai2);
                                            });

                                            $("#pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d").change(function() {
                                                var pilar4_1a = $("#pilar4_1a").val();
                                                var pilar4_1b = $("#pilar4_1b").val();
                                                var pilar4_1c = $("#pilar4_1c").val();
                                                var pilar4_1d = $("#pilar4_1d").val();
                                                var bobot6_1 = <?php echo json_encode($bobot6_1); ?>;
                                                var bobot6_2 = <?php echo json_encode($bobot6_2); ?>;
                                                var bobot6_3 = <?php echo json_encode($bobot6_3); ?>;
                                                var bobot6_4 = <?php echo json_encode($bobot6_4); ?>;


                                                var pilar4_par1 = parseFloat(pilar4_1a) * parseFloat(bobot6_1);
                                                pilar4_par1 = pilar4_par1.toFixed(2);

                                                var pilar4_par2 = parseFloat(pilar4_1b) * parseFloat(bobot6_2);
                                                pilar4_par2 = pilar4_par2.toFixed(2);

                                                var pilar4_par3 = parseFloat(pilar4_1c) * parseFloat(bobot6_3);
                                                pilar4_par3 = pilar4_par3.toFixed(2);

                                                var pilar4_par4 = parseFloat(pilar4_1d) * parseFloat(bobot6_4);
                                                pilar4_par4 = pilar4_par4.toFixed(2);



                                                var total_rata_rata = parseFloat(pilar4_par1) + parseFloat(pilar4_par2) + parseFloat(pilar4_par3) + parseFloat(pilar4_par4);
                                            
                                                total_rata_rata = total_rata_rata.toFixed(2);

                                                $("#risiko_pil4").val(total_rata_rata);
                                                $("#hasil_risiko_pil4").val(total_rata_rata);
                                            });


                                        



                                            $('#pilar5_1a').change(function() {
                                                var pilar5_1a = $("#pilar5_1a").val();

                                                var bobot7_1 = <?php echo json_encode($bobot7_1); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1a) * parseFloat(bobot7_1);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1a").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1a) * parseFloat(bobot7_1);
                                                $("#nilaippl5_p1a").val(nilai2);
                                            });

                                            
                                            $('#pilar5_1b').change(function() {
                                                var pilar5_1b = $("#pilar5_1b").val();

                                                var bobot7_2 = <?php echo json_encode($bobot7_2); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1b) * parseFloat(bobot7_2);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1b").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1b) * parseFloat(bobot7_2);
                                                $("#nilaippl5_p1b").val(nilai2);
                                            });
                                            
                                            $('#pilar5_1c').change(function() {
                                                var pilar5_1c = $("#pilar5_1c").val();

                                                var bobot7_3 = <?php echo json_encode($bobot7_3); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1c) * parseFloat(bobot7_3);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1c").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1c) * parseFloat(bobot7_3);
                                                $("#nilaippl5_p1c").val(nilai2);
                                            });

                                            $('#pilar5_1d').change(function() {
                                                var pilar5_1d = $("#pilar5_1d").val();

                                                var bobot7_4 = <?php echo json_encode($bobot7_4); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1d) * parseFloat(bobot7_4);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1d").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1d) * parseFloat(bobot7_4);
                                                $("#nilaippl5_p1d").val(nilai2);
                                            });

                                            $('#pilar5_1e').change(function() {
                                                var pilar5_1e = $("#pilar5_1e").val();

                                                var bobot7_5 = <?php echo json_encode($bobot7_5); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1e) * parseFloat(bobot7_5);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1e").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1e) * parseFloat(bobot7_5);
                                                $("#nilaippl5_p1e").val(nilai2);
                                            });

                                            $('#pilar5_1f').change(function() {
                                                var pilar5_1f = $("#pilar5_1f").val();

                                                var bobot7_6 = <?php echo json_encode($bobot7_6); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1f) * parseFloat(bobot7_6);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1f").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1f) * parseFloat(bobot7_6);
                                                $("#nilaippl5_p1f").val(nilai2);
                                            });


                                            $('#pilar5_1g').change(function() {
                                                var pilar5_1g = $("#pilar5_1g").val();

                                                var bobot7_7 = <?php echo json_encode($bobot7_7); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1g) * parseFloat(bobot7_7);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1g").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1g) * parseFloat(bobot7_7);
                                                $("#nilaippl5_p1g").val(nilai2);
                                            });

                                            $('#pilar5_1h').change(function() {
                                                var pilar5_1h = $("#pilar5_1h").val();

                                                var bobot7_8 = <?php echo json_encode($bobot7_8); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1h) * parseFloat(bobot7_8);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1h").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1h) * parseFloat(bobot7_8);
                                                $("#nilaippl5_p1h").val(nilai2);
                                            });

                                            $('#pilar5_1i').change(function() {
                                                var pilar5_1i = $("#pilar5_1i").val();

                                                var bobot7_9 = <?php echo json_encode($bobot7_9); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1i) * parseFloat(bobot7_9);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1i").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1i) * parseFloat(bobot7_9);
                                                $("#nilaippl5_p1i").val(nilai2);
                                            });

                                            $('#pilar5_1j').change(function() {
                                                var pilar5_1j = $("#pilar5_1j").val();

                                                var bobot7_10 = <?php echo json_encode($bobot7_10); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1j) * parseFloat(bobot7_10);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1j").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1j) * parseFloat(bobot7_10);
                                                $("#nilaippl5_p1j").val(nilai2);
                                            });

                                            $('#pilar5_1k').change(function() {
                                                var pilar5_1k = $("#pilar5_1k").val();

                                                var bobot7_11 = <?php echo json_encode($bobot7_11); ?>;

                                                
                                                var nilai = parseFloat(pilar5_1k) * parseFloat(bobot7_11);
                                                nilai = nilai.toFixed(2);
                                                $("#nilaippl5_par1k").val(nilai);

                                                var nilai2 = parseFloat(pilar5_1k) * parseFloat(bobot7_11);
                                                $("#nilaippl5_p1k").val(nilai2);
                                            });

                                            $("#pilar5_1a, #pilar5_1b").change(function() {
                                                var pilar5_1a = parseFloat($("#pilar5_1a").val()) || 0;
                                                var pilar5_1b = parseFloat($("#pilar5_1b").val()) || 0;

                                                var bobot7_1 = <?php echo json_encode($bobot7_1); ?>;
                                                var bobot7_2 = <?php echo json_encode($bobot7_2); ?>;

                                                var pilar5_par1 = pilar5_1a * parseFloat(bobot7_1);
                                                var pilar5_par2 = pilar5_1b * parseFloat(bobot7_2);

                                                var total_rata_rata = parseFloat(pilar5_par1) + parseFloat(pilar5_par2);
                                                total_rata_rata = total_rata_rata.toFixed(2);

                                                $("#risiko_pil5").val(total_rata_rata);
                                                $("#hasil_risiko_pil5").val(total_rata_rata);
                                            });

                                            



                                    



                                            $("#target_pasar1, #sektor_terbesar3, #penyaluran_kredit, #penyaluran_kredit2_1, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5, #pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d, #pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1i, #pilar5_1j, #pilar5_1k").change(function() {
                                                var val = this.value;
                                                var hsl_risiko_pilar1 = $("#risiko_pil1").val();
                                                var hsl_risiko_pilar2 = <?php echo json_encode($pil2_tingkat_risiko); ?>;
                                                var hsl_risiko_pilar3 = $("#risiko_pil3").val();
                                                var hsl_risiko_pilar4 = $("#risiko_pil4").val();
                                                var hsl_risiko_pilar5 = $("#risiko_pil5").val();

                                                const max = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3, hsl_risiko_pilar4, hsl_risiko_pilar5];
                                                const maxValue = Math.max(...max);
                                                tertinggi_inheren = maxValue.toFixed(2);
                                                $("#tertinggi_inheren").val(tertinggi_inheren);
                                
                                                const min = [hsl_risiko_pilar1, hsl_risiko_pilar2, hsl_risiko_pilar3, hsl_risiko_pilar4, hsl_risiko_pilar5];
                                                const minValue = Math.min(...min);
                                                terendah_inheren = minValue.toFixed(2);
                                                $("#terendah_inheren").val(terendah_inheren);
                                        
                                                var total_rata_rata = parseFloat(hsl_risiko_pilar1) + parseFloat(hsl_risiko_pilar2) + parseFloat(hsl_risiko_pilar3) + parseFloat(hsl_risiko_pilar4) + parseFloat(hsl_risiko_pilar5);
                                                var rata_rata_inheren = parseFloat(total_rata_rata) / 5;
                                                rata_rata_inheren = rata_rata_inheren.toFixed(2);
                                                rr_inheren = rata_rata_inheren;

                                                $("#rata_rata_inheren").val(rata_rata_inheren);
                                            });
                                            $("#target_pasar1, #sektor_terbesar3, #penyaluran_kredit, #penyaluran_kredit2_1, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5, #pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d, #pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1i, #pilar5_1j, #pilar5_1k").change(function() {
                                                var set_tingkat_risiko = parseInt($('#opsi_inheren').val() || <?php echo json_encode($set_tingkat_risiko); ?>, 10);
                                                
                                            
                                                if (set_tingkat_risiko == 1) {
                                                    var risiko_inheren = tertinggi_inheren;
                                                } else if (set_tingkat_risiko == 2) {
                                                    var risiko_inheren = terendah_inheren;
                                                } else if (set_tingkat_risiko == 3) {
                                                    var risiko_inheren = rr_inheren;
                                                } else {
                                                    var risiko_inheren = 0;
                                                }

                                                $("#risiko_inheren").val(risiko_inheren);
                                                nilai_risiko_inheren = risiko_inheren;

                                                if (nilai_risiko_inheren < 1.00) {
                                                    var peringkat_inheren = " ";
                                                } else if (nilai_risiko_inheren >= 1.00 && nilai_risiko_inheren <= 1.25) {
                                                    var peringkat_inheren = "Sangat Rendah";
                                                } else if (nilai_risiko_inheren > 1.25 && nilai_risiko_inheren <= 2.25) {
                                                    var peringkat_inheren = "Rendah";
                                                } else if (nilai_risiko_inheren > 2.25 && nilai_risiko_inheren <= 3.25) {
                                                    var peringkat_inheren = "Sedang";
                                                } else if (nilai_risiko_inheren > 3.25 && nilai_risiko_inheren <= 4.25) {
                                                    var peringkat_inheren = "Tinggi";
                                                } else if (nilai_risiko_inheren > 4.25 && nilai_risiko_inheren <= 5.00) {
                                                    var peringkat_inheren = "Sangat Tinggi";
                                                } else {
                                                    var peringkat_inheren = " ";
                                                }

                                                $("#peringkat_inheren").val(peringkat_inheren);
                                            });

                                        });
                                    </script>


<input type="hidden" form="my_form" name="nilaippl4_p1a"  class="form-control" id="nilaippl4_p1a" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1b"  class="form-control" id="nilaippl4_p1b" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1c"  class="form-control" id="nilaippl4_p1c" readonly>
<input type="hidden" form="my_form" name="nilaippl4_p1d"  class="form-control" id="nilaippl4_p1d" readonly>


<input type="hidden" form="my_form" name="nilaippl5_p1a"  class="form-control" id="nilaippl5_p1a" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1b"  class="form-control" id="nilaippl5_p1b" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1c"  class="form-control" id="nilaippl5_p1c" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1d"  class="form-control" id="nilaippl5_p1d" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1e"  class="form-control" id="nilaippl5_p1e" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1f"  class="form-control" id="nilaippl5_p1f" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1g"  class="form-control" id="nilaippl5_p1g" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1h"  class="form-control" id="nilaippl5_p1h" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1i"  class="form-control" id="nilaippl5_p1i" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1j"  class="form-control" id="nilaippl5_p1j" readonly>
<input type="hidden" form="my_form" name="nilaippl5_p1k"  class="form-control" id="nilaippl5_p1k" readonly>



<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Kredit Inhern [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #5bf553; color: white;">

                            <h4 class="page-title">Risiko Kredit Inheren</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren Profil Risiko Kredit</h4>

                            <hr>
                            </hr>



                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <h4>
                                                    <center><b>RISIKO KREDIT INHEREN</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="2%">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center" width="20%">
                                                PARAMETER
                                            </th>

                                            <th class="text-center" width="10%">
                                                NOMINAL
                                            </th>
                                            <th class="text-center" width="13%">
                                                RASIO
                                            </th>
                                            <th class="text-center" width="10%">
                                                AMBANG BATAS
                                            </th>
                                            <th class="text-center" width="5%">
                                                RUMUS
                                            </th>
                                            <th class="text-center" width="5%">
                                                KOREKSI
                                            </th>
                                            <th class="text-center" width="10%">
                                                NILAI
                                            </th>
                                            <th class="text-center" width="25%">
                                                KETERANGAN
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                <center>Aset Produktif</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p1) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ap_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil1_1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil1_1') ?></td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Penempatan Bank Lain</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p1a) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['pbl_per_tap'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Aba Pada 1 Bank Tertinggi</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P3['aba_tertinggi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p1b) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apbt_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1b, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>Aba Pada BPR</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P3['aba_bpr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p1c) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['abapb_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1c ?></center>
                                            </td>
                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai1c, 2) ?></center>
                                            </td>

                                        </tr>
<tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>Kredit PEP</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_pep']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2m) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpep_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2m ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2m, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>Kredit fon > 350jt</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_lebih350']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2n) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp350_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2n ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2n, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Saldo CKPN</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($saldo_ckpn) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p1a) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= fmt2($ab_pil2_par1a) ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                g.<center>AYDA</center>
                                                <hr>
                                                </hr>
                                                <center>KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['ayda']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p1b) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ayda_per_kyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par1b, 2) ?></center>
                                            </td>

                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kyd_per_ap'] ?></td>

                                            <td>
                                                <center><?= $hsl2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil1_2'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length['l2'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil1_2') ?>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Kredit Skema Potong Gaji</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_spg']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2a) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= fmt2($para2_aba) ?> </td>

                                            <td>
                                                <center><?= $hsl2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Kredit Musiman (Grace Period)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_pbta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2b) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['km_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>Kredit Jangka Pendek</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jpendek']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2c) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kjpen_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>Kredit Jangka Menengah</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jmenengah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2d) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjm_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>Kredit Jangka Panjang</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_jpanjang']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2e) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjpan_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2e, 2) ?></center>
                                            </td>

                                        </tr>


                                    


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Kredit Dengan Agunan Tanah dan Bangunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_tb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2g) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdatdb_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2g ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2g, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                g.<center>Kredit Agunan Kendaraan Bermotor</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2h) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kak_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2h ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_7, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2h, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                h.<center>Kredit Agunan Kendaraan Roda 2</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kr2']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2i) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kakr2_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2i ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_8, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2i, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                i.<center>OSC Produk KUB</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_kub']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2j) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['opk_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2j ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_9, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2j, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                j.<center>Kredit Tanpa Agunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_ta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2k) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kta_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2k ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_10, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2k, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                k.<center>Kredit Korporasi (Non Perorangan)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_korporasi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($p2l) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kknp_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2l ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot2_11, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai2l, 2) ?></center>
                                            </td>
                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th>
                                                <center>25 Debitur Inti</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['debitur_inti25']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p3 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['di25_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl3 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par3" value="<?= $pil1['pilar1_3'] ?>" class="form-control" id="koreksippl1_par3" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="number" form="my_form" name="nilaippl1_par3" value="<?= $pil1['hasil_pil1_par3'] ?>" class="form-control" id="nilaippl1_par3" readonly></center>

                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil1_3" form="my_form" name="ket_pil1_3" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil1_3'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length['l3'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil1_3') ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <label for="example-select" class="form-label">Target pasar</label>
                                                <select class="form-select" form="my_form" name="target_pasar1" id="target_pasar1">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_3'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama > 4 tahun</option>
                                                    <option value="3" <?= $pil1['pilar1_3'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama > 2 - 4 tahun</option>
                                                    <option value="4" <?= $pil1['pilar1_3'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama 2 tahun</option>
                                                    <option value="5" <?= $pil1['pilar1_3'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat < 2 tahun </option>
                                                </select>
                                            </th>
                                            
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_3'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>


                                        </tr>
















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th>
                                                <center>Kredit Per Sektor Ekonomi</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P1['kredit_3sektor_ekonomi_terbesar']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= number_format($p4 ,2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpse_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl4 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par4" value="<?= $pil1['pilar1_4'] ?>" class="form-control" id="koreksippl1_par4" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par4" value="<?= $pil1['hasil_pil1_par4'] ?>" class="form-control" id="nilaippl1_par4" readonly></center>

                                            </td>

                                            <td>
                                            <textarea class="form-control" id="ket_pil1_4" form="my_form" name="ket_pil1_4" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil1_4'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length['l4'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil1_4') ?>
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <label for="example-select" class="form-label">Kredit yang berasal dari 3 sektor terbesar</label>
                                                <select class="form-select" form="my_form" name="sektor_terbesar3" id="sektor_terbesar3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil1['pilar1_4'] == "2" ? "selected" : "" ?>>2 = tidak berubah selama jangka waktu yang sangat lama > 4 tahun</option>
                                                    <option value="3" <?= $pil1['pilar1_4'] == "3" ? "selected" : "" ?>>3 = tidak berubah selama jangka waktu yang lama > 2 - 4 tahun</option>
                                                    <option value="4" <?= $pil1['pilar1_4'] == "4" ? "selected" : "" ?>>4 = tidak berubah selama jangka waktu yang cukup lama 2 tahun</option>
                                                    <option value="5" <?= $pil1['pilar1_4'] == "5" ? "selected" : "" ?>>5 = tidak berubah selama jangka waktu yang singkat < 2 tahun</option>
                                                </select>
                                            </th>
                                            <td>
                                            <center>Periode sebelumnya</br><?= $pembanding_pil1['pilar1_4'] ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>

                                        </tr>





                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 1</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil1" value="<?= $hasil['pil1_tertinggi'] ?>" class="form-control" id="tertinggi_pil1" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil1" value="<?= $hasil['pil1_terendah'] ?>" class="form-control" id="terendah_pil1" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil1" value="<?= $hasil['pil1_rata_rata'] ?>" class="form-control" id="rata_rata_pil1" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <?= $setris_display_pil1 ?>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil1" value="<?= $hasil['pil1_tingkat_risiko'] ?>" class="form-control" id="risiko_pil1" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil1" form="my_form" name="ket_pil1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil1'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length['l5'] ?></span><span> / 2000</span>
                                            </th>


                                        </tr>




































                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Kualitas Aset</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th rowspan="2">
                                                <center>1</center>
                                            </th>
                                            <th>
                                                <center>Aset Produktif Bermasalah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['aset_produktif_bermasalah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p1) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= fmt2($ambang_batas_kredit['apb_per_tap']) ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par1 ?></center>
                                            </td>

                                            <td>
                                                <input type="text" class="form-control" id="koreksipil2_par1" value="<?= ($pilar2_1_selected > 0 ? fmt2($pilar2_1_selected) : '') ?>" readonly>
                                            </td>
                                            <td>
                                                <center><input type="text" class="form-control" id="nilaipil2_par1" value="<?= fmt2($nilai_pil2_par1) ?>" readonly></center>
                                            </td>
                                            <td rowspan="2">
                                            <textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil2_1'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length['l6'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil2_1') ?>
                                            </td>

                                        </tr>
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center></center>
                                            </th>
                                            <th style="vertical-align: top;">
                                                <label for="penyaluran_kredit2_1" class="form-label">Penyaluran kredit:</label>
                                                <select class="form-select" form="my_form" name="pilar2_1" id="penyaluran_kredit2_1">
                                                    <option selected> </option>
                                                    <option value="2" <?= ($pilar2_1_selected == 2.0 ? 'selected' : '') ?>>2 = Terjadi kenaikan OSC dan NPL membaik</option>
                                                    <option value="3" <?= ($pilar2_1_selected == 3.0 ? 'selected' : '') ?>>3 = Terjadi kenaikan OSC dan NPL stagnan</option>
                                                    <option value="4" <?= ($pilar2_1_selected == 4.0 ? 'selected' : '') ?>>4 = Terjadi penurunan OSC dan NPL memburuk</option>
                                                </select>
                                            </th>
                                            <td>
                                                <center>Periode sebelumnya</br><?= ($pembanding_pilar2_1 > 0 ? fmt2($pembanding_pilar2_1) : '') ?></center>
                                            </td>
                                            <td colspan="6">
                                            </td>
                                        </tr>







                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                                <center>Kredit Bermasalah Neto</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_bermasalah_neto']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kbn_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2, 2) ?></center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil2_2'] ?></textarea>
                                            <span id="penghitung-karakter7"><?= $length['l7'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil2_2') ?>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>NPL Kredit plafond s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD plafond s/d 150 jt</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_sd150']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2a) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkp150_per_tkp150'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>NPL Kredit plafond diatas 50 juta</center>
                                                    <hr>
                                                    </hr>
                                                    <center>Total KYD plafond diatas 50 juta</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_kredit_diatas50']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kyd_plafon_diatas50']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2b) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkpd50_per_tkpd50'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>NPL Kredit Dengan Perikatan APHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_apht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2c) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkdpapht_prt_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>NPL Kredit Dengan Perikatan SKMHT</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_skmht']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2d) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nkdpskmht_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e.<center>NPL Nilai Agunan Lebih Rendah Dari Baki Debet</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['npl_agunan_lrd_bakidebet']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['kredit_agunan_lrd_bakidebet']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2e) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nalrdbd_per_tknalrdbd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_5, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2e, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                f.<center>Kredit Macet sudah jatuh tempo</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['macet_jatuh_tempo']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p2f) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kmsjt_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot3_6, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par2f, 2) ?></center>
                                            </td>

                                        </tr>















                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th>
                                                <center>Kredit Kualitas Rendah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kkr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p3) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kkr_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil2_par3 ?></center>
                                            </td>

                                            <td>
                                                <center><?= number_format($koreksi_pil2_par3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3, 2) ?></center>
                                            </td>

                                            <td>
                                            <textarea class="form-control" id="ket_pil2_3" form="my_form" name="ket_pil2_3" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil2_3'] ?></textarea>
                                            <span id="penghitung-karakter8"><?= $length['l8'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil2_3') ?>
                                            </td>
                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a.<center>Kredit Par 4</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_par4']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p3a) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_1, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b.<center>Kredit DP (PAR 3 + PAR 4 )</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['kredit_dp']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p3b) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdp3p4_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3b, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c.<center>NOA FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>NOA Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['noa_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['noa_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p3c) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nf6bt_per_ne6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_3, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d.<center>Nominal FPD 6 Bulan Terakhir</center>
                                                <hr>
                                                </hr>
                                                <center>plafond Ekspansi 6 Bulan Terakhir</center>
                                            </th>
                                            <th>
                                                <center><?= rupiah($master_kredit_P2['nominal_fpd_6bln']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P2['plafond_ekspansi_6bln']) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar2_p3d) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['nomf6bt_per_pe6bt'] ?> </td>

                                            <td>
                                                <center><?= $hsl_pil2_par3d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= number_format($bobot4_4, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= number_format($nilai_pil2_par3d, 2) ?></center>
                                            </td>

                                        </tr>

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 2</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="text" form="my_form" name="pilar2_max" class="form-control" value="<?= number_format($pil2_tertinggi ,2)?>" id="pilar2_max" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="text" form="my_form" name="pilar2_min" class="form-control"  value="<?= number_format($pil2_terendah ,2)?>" id="pilar2_min" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="text" form="my_form" name="pilar2_avg" class="form-control"  value="<?= number_format($pil2_rata_rata ,2)?>" id="pilar2_avg" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <?= $setris_display_pil2 ?>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="text" form="my_form" name="pil2_tingkat_risiko" class="form-control"  value="<?= number_format($pil2_tingkat_risiko ,2) ?>" id="pil2_tingkat_risiko" readonly></center>
                                            </th>

                                            <th>
                                            <textarea class="form-control" id="ket_pil2" form="my_form" name="ket_pil2" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil2'] ?></textarea>
                                            <span id="penghitung-karakter9"><?= $length['l9'] ?></span><span> / 2000</span>
                                            </th>


                                        </tr>














                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 3 : Strategi Penyediaan Dana</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Strategi Penyediaan Dana
                                            </th>
                                            <th>
                                                <center>Kyd - Rata-rata BPR</center>
                                                <center><?= number_format($master_kredit_P3['pertumbuhan_kyd_bpr'] ,2) ?> -
                                                    <?= number_format($master_kredit_P3['rasio_pertumbuhan_rata2_bpr'] ,2) ?></center>
                                            </th>
                                            <td><input type="text" form="my_form" name="aba" value="<?= fmt2($pilar3_p1) ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apb_per_tap'] ?></td>

                                            <td>
                                                <center><?= $hsl_pil3_par1 ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1" value="<?= $koreksi_pil3_par1_awal === null ? '' : fmt2($koreksi_pil3_par1_awal) ?>" class="form-control" id="koreksippl3_par1" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1" value="<?= fmt2($nilai_pil3_par1) ?>" class="form-control" id="nilaippl3_par1" readonly>

                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil3_1'] ?></textarea>
                                            <span id="penghitung-karakter10"><?= $length['l10'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil3_1') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                                <a href="https://www.bi.go.id/SEKDA/33/33-ii07.zip" target="_blank">https://www.bi.go.id/SEKDA/33/33-ii07.zip</a></br>
                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit" id="penyaluran_kredit">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1'] == "2" ? "selected" : "" ?>>2 = seluruhnya disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="3" <?= $pil3['pilar3_1'] == "3" ? "selected" : "" ?>>3 = sebagian besar disalurkan ke sektor ekonomi yang dikuasai</option>
                                                    <option value="4" <?= $pil3['pilar3_1'] == "4" ? "selected" : "" ?>>4 = sebagian kecil atau tidak sama sekali disalurkan ke sektor ekonomi yg dikuasai </option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1'] ?>
                                            </th>
                                            <th>
                                                <center>%<input type="text" form="my_form" name="aba" value="<?= fmt2($pilar3_p1) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>SK limit <<input type="number" form="my_form" name="pil3_par1_limit_persen" value="<?= number_format($bobot5_1, 1) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <th colspan="2">
                                                <center><input type="number" form="my_form" name="pil3_par1_limit_sk" value="<?= $hsl_pil3_par1 ?>" class="form-control" id="pil3_par1_limit_sk" readonly>

                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Pertumbuhan sektor ekonomi yang tidak dikuasai
                                            </th>
                                            <th>
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1a_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1a_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1a ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1a" value="<?= $pil3['pilar3_1a'] ?>" class="form-control" id="koreksippl3_par1a" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1a" value="<?= $pil3['hasil_pil3_par1a'] ?>" class="form-control" id="nilaippl3_par1a" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit2" id="penyaluran_kredit2">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>2 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>3 = Terjadi penurunan OSC pada sektor ekonomi yang tidak dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>4 = Terjadi kenaikan OSC pada sektor ekonomi yang tidak dikuasai dan NPL memburuk </option>

                                                </select>
                                            </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1a'] ?>
                                            </th>

                                            <th colspan="7">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Pertumbuhan sektor ekonomi yang dikuasai
                                            </th>
                                            <th>
                                                <center>Periode Penilaian<input type="text" form="my_form" name="aba" value="<?= rupiah($pilar3_p1b_pp) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Penilaian Sebelumnya<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($pilar3_p1b_ps) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1b ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1b" value="<?= $pil3['pilar3_1b'] ?>" class="form-control" id="koreksippl3_par1b" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1b" value="<?= $pil3['hasil_pil3_par1b'] ?>" class="form-control" id="nilaippl3_par1b" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran Kredit</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3" id="penyaluran_kredit3">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>2 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL membaik</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>3 = Terjadi kenaikan OSC pada sektor ekonomi yang dikuasai dan NPL stagnan</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>4 = Terjadi penurunan OSC pada sektor ekonomi yang dikuasai dan NPL memburuk</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1b'] ?>
                                            </th>

                                            <th colspan="8">

                                            </th>


                                        </tr>


                                       



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c. Pertumbuhan OSC dan NPL
                                            </th>
                                            <th>
                                                <center>Pertumbuhan Kredit<input type="text" form="my_form" name="aba" value="<?= fmt2($pilar3_p1c_pertumbuhan_kredit) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan Noa<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= fmt2($pilar3_p1c_pertumbuhan_noa) ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>
                                                <center>Pertumbuhan Rasio NPL<input type="text" form="my_form" name="aba" value="<?= fmt2($pilar3_p1c_pertumbuhan_rasio_npl) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Pertumbuhan NOA NPL<input type="text" form="my_form" name="pil3_par1c_limit_persen" value="<?= fmt2($pilar3_p1c_pertumbuhan_noa_npl) ?>" class="form-control" id="pil3_par1c_limit_persen" readonly>
                                                </center>


                                            </th>
                                            <td></td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1c_rumus ?></center>
                                            </td>


                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1c" value="<?= ($koreksi_pil3_par1c_awal === null ? '' : fmt2($koreksi_pil3_par1c_awal)) ?>" class="form-control" id="koreksippl3_par1c" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1c" value="<?= fmt2($nilai_pil3_par1c) ?>" class="form-control" id="nilaippl3_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                               
                                                <select class="form-select" form="my_form" name="penyaluran_kredit3_5" id="penyaluran_kredit3_5">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>1 = Pertumbuhan kredit positif dan NPL mengalami perbaikan</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>2 = Pertumbuhan kredit positif dan NPL stagnan</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>3 = Pertumbuhan Kredit positif namun NPL mengalami kenaikan</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>4 = Pertumbuhan kredit negatif dan NPL mengalami perbaikan</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>5 = Pertumbuhan kredit negatif dan NPL mengalami kenaikan</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1c'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d. Penempatan dana antar bank
                                            </th>
                                            <th>
                                                <center>Aba Pada BPR<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_bpr']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= number_format($hsl_pil3_par1d ,2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1d_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1d" value="<?= $pil3['pilar3_1d'] ?>" class="form-control" id="koreksippl3_par1d" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1d" value="<?= $pil3['hasil_pil3_par1d'] ?>" class="form-control" id="nilaippl3_par1d" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Penyaluran dana dalam bentuk penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit4" id="penyaluran_kredit4">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1d'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                e. Konsentrasi Penempatan ABA
                                            </th>
                                            <th>
                                                <center>Aba Pada Bank Teringgi<input type="text" form="my_form" name="aba" value="<?= rupiah($master_kredit_P3['aba_tertinggi']) ?>" class="form-control" id="rupiah" readonly></center>
                                                <center>Total ABA<input type="text" form="my_form" name="pil3_par1_limit_persen" value="<?= rupiah($master_kredit_P1['aba']) ?>" class="form-control" id="pil3_par1_limit_persen" readonly>
                                                </center>
                                            </th>
                                            <td>
                                                <center><input type="text" form="my_form" name="aba" value="<?= round($hsl_pil3_par1e, 2) ?>" class="form-control" id="rupiah" readonly></center>
                                            </td>
                                            <td> </td>

                                            <td>
                                                <center><?= $hsl_pil3_par1e_rumus ?></center>
                                            </td>

                                            <th>
                                                <center><input type="number" form="my_form" name="koreksippl3_par1e" value="<?= $pil3['pilar3_1e'] ?>" class="form-control" id="koreksippl3_par1e" readonly>

                                            </th>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl3_par1e" value="<?= $pil3['hasil_pil3_par1e'] ?>" class="form-control" id="nilaippl3_par1e" readonly>

                                            </th>

                                        </tr>




                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>

                                                <label for="example-select" class="form-label">Konsentrasi penyaluran dana dalam bentuk </br>penempatan ABA</label>
                                                <select class="form-select" form="my_form" name="penyaluran_kredit5" id="penyaluran_kredit5">
                                                    <option selected> </option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>2 = seluruhnya ditempatkan pada Bank Umum</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>3 = Kurang dari 20% ditempatkan pada BPR</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>4 = Lebih dari 20% ditempatkan di BPR</option>

                                                </select>
                                                </br>
                                                Periode Sebelumnya : <?= $pembanding_pil3['pilar3_1e'] ?>
                                            </th>

                                            <th colspan="6">

                                            </th>


                                        </tr>


                                        

                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 3</center>
                                            </th>
                                            <th>
                                                <center>Tertinggi</center>
                                                <center><input type="number" form="my_form" name="tertinggi_pil3" value="<?= fmt2($pil3_tertinggi_calc) ?>" class="form-control" id="tertinggi_pil3" readonly></center>
                                            </th>
                                            <th>
                                                <center>Terendah</center>
                                                <center><input type="number" form="my_form" name="terendah_pil3" value="<?= fmt2($pil3_terendah_calc) ?>" class="form-control" id="terendah_pil3" readonly></center>
                                            </th>
                                            <th>
                                                <center>Rata-rata</center>
                                                <center><input type="number" form="my_form" name="rata_rata_pil3" value="<?= fmt2($pil3_rata_rata_calc) ?>" class="form-control" id="rata_rata_pil3" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Nilai diambil</center>
                                                <?= $setris_display_pil3 ?>
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil3" value="<?= fmt2($pil3_tingkat_risiko_calc) ?>" class="form-control" id="risiko_pil3" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil3" form="my_form" name="ket_pil3" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil3'] ?></textarea>
                                            <span id="penghitung-karakter11"><?= $length['l11'] ?></span><span> / 2000</span>
                                            </th>

                                        </tr>









                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 4 : Faktor Eksternal</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Faktor Eksternal
                                            </th>
                                            <th>
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil4_1'] ?></textarea>
                                            <span id="penghitung-karakter12"><?= $length['l12'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil4_1') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                        
                                            </th>
                                            <th>
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Layanan Digital Kompetitor
                                                <select class="form-select" form="my_form" name="pilar4_1a" id="pilar4_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>1 = Tidak berdampak pada kinerja Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>2 = Berdampak namun loyalitas nasabah masih terjaga</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>3 = Berdampak loyalitas nasabah mulai menurun</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                    

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1a" value="<?= number_format($bobot6_1 ,2) ?>" class="form-control" id="koreksippl4_par1a" readonly>
                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1a" value="<?= $pil4['hasil_pil4_par1a'] ?>" class="form-control" id="nilaippl4_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Kejadian luar biasa yang berpengaruh terhadap</br> kinerja Bank
                                                <select class="form-select" form="my_form" name="pilar4_1b" id="pilar4_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>1 = Tidak terdapat Kejadian Luar Biasa, tidak berdampak pada usaha dan kemampuan debitur</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>2 = Tidak terdapat Kejadian Luar Biasa</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>3 = Terdapat Kejadian Luar Biasa Yang Berpengaruh 1% Terhadap Kinerja Kredit</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>4 = Terdapat Kejadian Luar Biasa Yang Berpengaruh sd 5% Terhadap Kinerja Kredit</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>5 = Terdapat Kejadian Luar Biasa Yang Berpengaruh >5% Terhadap Kinerja Kredit</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1b" value="<?= number_format($bobot6_2 ,2) ?>" class="form-control" id="koreksippl4_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1b" value="<?= $pil4['hasil_pil4_par1b'] ?>" class="form-control" id="nilaippl4_par1b" readonly>

                                            </th>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                c. Persaingan Layanan antar BPR
                                                <select class="form-select" form="my_form" name="pilar4_1c" id="pilar4_1c">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada kinerja dan pelayanan Bank</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada kinerja dan layanan namun menimbulkan keluhan nasabah</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>3 = berdampak pada kenyamanan nasabah yang berakibat nasabah enggan datang ke kantor</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>4 = berdampak pada kenyamanan nasabah yang berakibat putusnya hubungan kerjasama</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>> 5 = berdampak pada kinerja dan layanan Bank yang cukup signifikan</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1c'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1c" value="<?= number_format($bobot6_3 ,2) ?>" class="form-control" id="koreksippl4_par1c" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1c" value="<?= $pil4['hasil_pil4_par1c'] ?>" class="form-control" id="nilaippl4_par1c" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                d. Regulasi Pemerintah
                                                <select class="form-select" form="my_form" name="pilar4_1d" id="pilar4_1d">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil4['pilar4_1d'] == "1" ? "selected" : "" ?>>1 = tidak berdampak pada volume bisnis dan capaian target NOA</option>
                                                    <option value="2" <?= $pil4['pilar4_1d'] == "2" ? "selected" : "" ?>>2 = tidak berdampak pada volume bisnis Bank namun berdampak pada capaian target</option>
                                                    <option value="3" <?= $pil4['pilar4_1d'] == "3" ? "selected" : "" ?>>3 = berdampak pada volume bisnis bank dan tidak terjadi pelepasan NOA existing</option>
                                                    <option value="4" <?= $pil4['pilar4_1d'] == "4" ? "selected" : "" ?>>4 = berdampak pada volume bisnis bank dan terjadi pelepasan NOA existing</option>
                                                    <option value="5" <?= $pil4['pilar4_1d'] == "5" ? "selected" : "" ?>>5 = berdampak pada volume bisnis dan capaian target NOA</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1d'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                            

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl4_par1d" value="<?= number_format($bobot6_4 ,2) ?>" class="form-control" id="koreksippl4_par1d" readonly>

                                            </td>
                                            <th>
                                                <center><input type="text" form="my_form" name="nilaippl4_par1d" value="<?= $pil4['hasil_pil4_par1d'] ?>" class="form-control" id="nilaippl4_par1d" readonly>

                                            </th>

                                        </tr>


                                        <tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 4</center>
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control" id="risiko_pil4" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil4" form="my_form" name="ket_pil4" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil4'] ?></textarea>
                                            <span id="penghitung-karakter13"><?= $length['l13'] ?></span><span> / 2000</span>
                                            </th>

                                        </tr>



    

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                                Faktor Lainnya
                                            </th>
                                            <th>
                                            </th>
                                            <td></td>
                                            <td>
                                            <td>
                                            </td>

                                            <th>
                                             
                                            </th>
                                            <th>
                                               
                                            </th>
                                            <td>
                                            <textarea class="form-control" id="ket_pil5_1" form="my_form" name="ket_pil5_1" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil5_1'] ?></textarea>
                                            <span id="penghitung-karakter14"><?= $length['l14'] ?></span><span> / 2000</span><?= kredit_info_kuantitatif_btn($info_kuantitatif_kredit, 'ket_pil5_1') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                        
                                            </th>
                                            <th>
                                            
                                            </th>
                                            <th colspan="2">
                                               
                                        
                                            </th>
                                            <th colspan="4">

                                            </th>


                                        </tr>





                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                a. Kompetensi AO
                                                <select class="form-select" form="my_form" name="pilar5_1a" id="pilar5_1a">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1a'] == "1" ? "selected" : "" ?>>1 = AO memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1a'] == "2" ? "selected" : "" ?>>2 = AO memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1a'] == "3" ? "selected" : "" ?>>3 = AO memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1a'] == "4" ? "selected" : "" ?>>4 = AO memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1a'] == "5" ? "selected" : "" ?>>5 = AO memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1a'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                         

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1a" value="<?= number_format($bobot7_1 ,2) ?>" class="form-control" id="koreksippl5_par1a" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1a" value="<?= number_format($hasil_pil5_par1a_ab, 2, '.', '') ?>" class="form-control" id="nilaippl5_par1a" readonly>

                                            </th>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                                b. Kompetensi Analis
                                                <select class="form-select" form="my_form" name="pilar5_1b" id="pilar5_1b">
                                                    <option selected> </option>
                                                    <option value="1" <?= $pil5['pilar5_1b'] == "1" ? "selected" : "" ?>>1 = Analis memiliki kompetensi yang Sangat Baik</option>
                                                    <option value="2" <?= $pil5['pilar5_1b'] == "2" ? "selected" : "" ?>>2 = Analis memiliki kompetensi yang Baik</option>
                                                    <option value="3" <?= $pil5['pilar5_1b'] == "3" ? "selected" : "" ?>>3 = Analis memiliki kompetensi yang Cukup Baik</option>
                                                    <option value="4" <?= $pil5['pilar5_1b'] == "4" ? "selected" : "" ?>>4 = Analis memiliki kompetensi yang Kurang Baik</option>
                                                    <option value="5" <?= $pil5['pilar5_1b'] == "5" ? "selected" : "" ?>>5 = Analis memiliki kompetensi yang Sangat Buruk</option>

                                                </select>
                                            </th>
                                            <th>
                                            <center>Periode Sebelumnya</center>
                                            <center><?= $pembanding_pil5['pilar5_1b'] ?></center>
                                            </th>
                                            <td> </td>
                                            <td> </td>

                                           

                                            <td colspan="2">
                                                <center>Bobot<input type="number" form="my_form" name="koreksippl5_par1b" value="<?= number_format($bobot7_2 ,2) ?>" class="form-control" id="koreksippl5_par1b" readonly>

                                            </td>
                                            <th>
                                                <center><input type="number" form="my_form" name="nilaippl5_par1b" value="<?= number_format($hasil_pil5_par1b_ab, 2, '.', '') ?>" class="form-control" id="nilaippl5_par1b" readonly>

                                            </th>

                                        </tr>



                                        
                                        <!-- Sub parameter C s.d. K dihapus sesuai permintaan: hanya A dan B yang digunakan -->

<tr bgcolor="#acdbfb">

                                            <th colspan="2">
                                                <center>Rekapitulasi penilaian tingkat risiko lainnya</center>
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th>
                                                
                                            </th>
                                            <th colspan="2">
                                                
                                            </th>
                                            <th>
                                            <center>Risiko ditetapkan</center>
                                                <center><input type="number" form="my_form" name="risiko_pil5" value="<?= number_format($pil5_tingkat_risiko_ab, 2, '.', '') ?>" class="form-control" id="risiko_pil5" readonly></center>
                                            </th>
                                            
                                            <th>
                                            <textarea class="form-control" id="ket_pil5" form="my_form" name="ket_pil5" cols="40" rows="5" ><?= $ket_inhern_kredit['ket_pil5'] ?></textarea>
                                            <span id="penghitung-karakter15"><?= $length['l15'] ?></span><span> / 2000</span>
                                            </th>

                                        </tr>


                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->

                    <br></br>
                    <br></br>


                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <center>REKAP PENILAIAN INHEREN KREDIT</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil1" form="my_form" value="<?= $hasil['pil1_tingkat_risiko'] ?>" name="hasil_risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Kualitas Aset
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil2" form="my_form" value="<?= number_format($pil2_tingkat_risiko ,2) ?>" name="hasil_risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 - Strategi Penyediaan Dana
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil3" form="my_form" value="<?= $hasil['pil3_tingkat_risiko'] ?>" name="hasil_risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 4 - Faktor Eksternal
                                            </th>
                                           
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil4" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="hasil_risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                           
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="hasil_risiko_pil5" form="my_form" value="<?= number_format($pil5_tingkat_risiko_ab, 2, '.', '') ?>" name="hasil_risiko_pil5" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        
                                    </tbody>
                                    
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Inheren
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_inheren" form="my_form" value="<?= $hasil['hasil_inheren_tertinggi'] ?>" name="tertinggi_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_inheren" form="my_form" value="<?= $hasil['hasil_inheren_terendah'] ?>" name="terendah_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_inheren" form="my_form" value="<?= $hasil['hasil_inheren_rata_rata'] ?>" name="rata_rata_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                                <center>Nilai diambil</center>
                                                <?= $setris_display_inheren ?>
                                            </td>
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_inheren" form="my_form" value="<?= $hasil['hasil_tingkat_risiko'] ?>" name="risiko_inheren" class="form-control"  readonly="">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_inheren" form="my_form" value="<?= $hasil['hasil_peringkat'] ?>" name="peringkat_inheren" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="table-primary">
                                        <tr>

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Kredit</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10" ><?= $ket_inhern_kredit['ket_inheren'] ?></textarea>
                                            <span id="penghitung-karakter16"><?= $length['l16'] ?></span><span> / 2000</span>
                                            </th>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>































                            <hr>
                            </hr>

                            <br></br>





                        

<script>
$(document).ready(function(){
    var setrisMode = <?= json_encode($setris_mode) ?>;
    var headerMethodDefault = <?= json_encode((int)$set_tingkat_risiko) ?>;
    var pilarSetting = {
        1: {method: <?= json_encode((int)$set_pil1) ?>, weight: <?= json_encode((float)$setris_bobot_pil1) ?>},
        2: {method: <?= json_encode((int)$set_pil2) ?>, weight: <?= json_encode((float)$setris_bobot_pil2) ?>},
        3: {method: <?= json_encode((int)$set_pil3) ?>, weight: <?= json_encode((float)$setris_bobot_pil3) ?>},
        4: {method: <?= json_encode((int)$set_pil4) ?>, weight: <?= json_encode((float)$setris_bobot_pil4) ?>},
        5: {method: <?= json_encode((int)$set_pil5) ?>, weight: <?= json_encode((float)$setris_bobot_pil5) ?>}
    };

    function num(v){
        v = parseFloat(v);
        return isNaN(v) ? 0 : v;
    }
    function fmt(v){ return num(v).toFixed(2); }
    function pickPilarValue(max, min, avg, cfg){
        if (setrisMode === 'pembobotan') {
            return num(avg) * (num(cfg.weight) / 100);
        }
        if (parseInt(cfg.method,10) === 1) return num(max);
        if (parseInt(cfg.method,10) === 2) return num(min);
        return num(avg);
    }
    function rankInheren(v){
        v = num(v);
        if (v < 1.00) return ' ';
        if (v <= 1.25) return 'Sangat Rendah';
        if (v <= 2.25) return 'Rendah';
        if (v <= 3.25) return 'Sedang';
        if (v <= 4.25) return 'Tinggi';
        if (v <= 5.00) return 'Sangat Tinggi';
        return ' ';
    }
    function applySetrisToInherenKredit(){
        var p1max = num($('#tertinggi_pil1').val());
        var p1min = num($('#terendah_pil1').val());
        var p1avg = num($('#rata_rata_pil1').val());

        var p2max = num($('#pilar2_max').val());
        var p2min = num($('#pilar2_min').val());
        var p2avg = num($('#pilar2_avg').val());

        var p3max = num($('#tertinggi_pil3').val());
        var p3min = num($('#terendah_pil3').val());
        var p3avg = num($('#rata_rata_pil3').val());

        var p4raw = num($('#hasil_risiko_pil4').val() || $('#risiko_pil4').val());
        var p4max = num($('#tertinggi_pil4').val() || p4raw);
        var p4min = num($('#terendah_pil4').val() || p4raw);
        var p4avg = num($('#rata_rata_pil4').val() || p4raw);

        var p5raw = num($('#hasil_risiko_pil5').val() || $('#risiko_pil5').val());
        var p5max = num($('#tertinggi_pil5').val() || p5raw);
        var p5min = num($('#terendah_pil5').val() || p5raw);
        var p5avg = num($('#rata_rata_pil5').val() || p5raw);

        var pil1 = pickPilarValue(p1max, p1min, p1avg, pilarSetting[1]);
        var pil2 = pickPilarValue(p2max, p2min, p2avg, pilarSetting[2]);
        var pil3 = pickPilarValue(p3max, p3min, p3avg, pilarSetting[3]);
        var pil4 = pickPilarValue(p4max, p4min, p4avg, pilarSetting[4]);
        var pil5 = pickPilarValue(p5max, p5min, p5avg, pilarSetting[5]);

        $('#risiko_pil1, #hasil_risiko_pil1').val(fmt(pil1));
        $('#pil2_tingkat_risiko').val(fmt(pil2));
        $('#risiko_pil3, #hasil_risiko_pil3').val(fmt(pil3));
        $('#risiko_pil4, #hasil_risiko_pil4').val(fmt(pil4));
        $('#risiko_pil5, #hasil_risiko_pil5').val(fmt(pil5));

        var arr = [pil1, pil2, pil3, pil4, pil5];
        var tertinggi = Math.max.apply(null, arr);
        var terendah = Math.min.apply(null, arr);
        var rata = (pil1 + pil2 + pil3 + pil4 + pil5) / 5;
        var risiko = 0;

        if (setrisMode === 'pembobotan') {
            risiko = pil1 + pil2 + pil3 + pil4 + pil5;
        } else {
            var headerMethod = parseInt($('#opsi_inheren').val() || headerMethodDefault, 10);
            if (headerMethod === 1) risiko = tertinggi;
            else if (headerMethod === 2) risiko = terendah;
            else risiko = rata;
        }

        $('#tertinggi_inheren').val(fmt(tertinggi));
        $('#terendah_inheren').val(fmt(terendah));
        $('#rata_rata_inheren').val(fmt(rata));
        $('#risiko_inheren').val(fmt(risiko));
        $('#peringkat_inheren').val(rankInheren(risiko));
    }

    setTimeout(applySetrisToInherenKredit, 50);

    $(document).on('change input',
        '#opsi_inheren, #target_pasar1, #sektor_terbesar3, #penyaluran_kredit, #penyaluran_kredit2_1, #penyaluran_kredit2, #penyaluran_kredit3, #penyaluran_kredit3_5, #penyaluran_kredit4, #penyaluran_kredit5, #pilar4_1a, #pilar4_1b, #pilar4_1c, #pilar4_1d, #pilar5_1a, #pilar5_1b, #pilar5_1c, #pilar5_1d, #pilar5_1e, #pilar5_1f, #pilar5_1g, #pilar5_1h, #pilar5_1i, #pilar5_1j, #pilar5_1k, #tertinggi_pil1, #terendah_pil1, #rata_rata_pil1, #pilar2_max, #pilar2_min, #pilar2_avg, #tertinggi_pil3, #terendah_pil3, #rata_rata_pil3, #tertinggi_pil4, #terendah_pil4, #rata_rata_pil4, #tertinggi_pil5, #terendah_pil5, #rata_rata_pil5',
        function(){
            setTimeout(applySetrisToInherenKredit, 20);
        }
    );
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('my_form');
    if (!form) return;

    var controls = Array.prototype.slice.call(document.querySelectorAll('[form="my_form"]')).filter(function(el){
        if (!el.name) return false;
        if (el.disabled) return false;
        if ((el.type || '').toLowerCase() === 'submit') return false;
        if (el.name === 'submit') return false;
        return true;
    });

    if (!controls.length) return;

    var timer = null;
    var saving = false;

    function buildData() {
        var fd = new FormData();
        fd.append('autosave', '1');

        controls.forEach(function(el){
            if (!el.name) return;

            var tag = (el.tagName || '').toUpperCase();
            var type = (el.type || '').toLowerCase();

            if ((type === 'checkbox' || type === 'radio') && !el.checked) {
                return;
            }

            if (tag === 'SELECT' && el.multiple) {
                Array.prototype.slice.call(el.options).forEach(function(opt){
                    if (opt.selected) fd.append(el.name, opt.value);
                });
            } else {
                fd.append(el.name, el.value == null ? '' : el.value);
            }
        });

        return fd;
    }

    var pendingAgain = false;

    function doSave() {
        if (saving) {
            pendingAgain = true;
            return;
        }
        saving = true;

        fetch(window.location.href, {
            method: 'POST',
            body: buildData(),
            headers: {'X-Requested-With': 'XMLHttpRequest'}
        })
        .then(function(res){ return res.text(); })
        .then(function(txt){
            try {
                var json = JSON.parse(txt);
                if (json && json.success) {
                    console.log('autosave ok');
                } else {
                    console.log('autosave response:', txt);
                }
            } catch (e) {
                console.log('autosave response:', txt);
            }
        })
        .catch(function(err){
            console.error('Autosave error:', err);
        })
        .finally(function(){
            saving = false;
            if (pendingAgain) {
                pendingAgain = false;
                doSave();
            }
        });
    }

    function debounceSave(delay){
        clearTimeout(timer);
        timer = setTimeout(function(){ doSave(); }, delay || 600);
    }

    controls.forEach(function(el){
        var tag = (el.tagName || '').toUpperCase();
        if (tag === 'SELECT') {
            el.addEventListener('change', function(){ debounceSave(150); });
            el.addEventListener('input', function(){ debounceSave(150); });
        } else if (tag === 'TEXTAREA') {
            el.addEventListener('input', function(){ debounceSave(500); });
            el.addEventListener('blur', function(){ debounceSave(150); });
        } else {
            el.addEventListener('input', function(){ debounceSave(500); });
            el.addEventListener('change', function(){ debounceSave(150); });
            el.addEventListener('blur', function(){ debounceSave(150); });
        }
    });

    // sendBeacon dimatikan agar tidak bentrok dengan autosave utama
    window.addEventListener('beforeunload', function(){});

});
</script>

<script>
$(document).ready(function(){
    function hitungPilar1Tambahan(){
        var hsl3 = <?php echo json_encode((float)$hsl3); ?>;
        var hsl4 = <?php echo json_encode((float)$hsl4); ?>;
        var pilar1_par1 = <?php echo json_encode((float)$nilai); ?>;
        var pilar1_par2 = <?php echo json_encode((float)$nilai2); ?>;
        var setPil1 = <?php echo json_encode((int)$set_pil1); ?>;

        var v3 = parseFloat($('#target_pasar1').val() || 0);
        var v4 = parseFloat($('#sektor_terbesar3').val() || 0);

        if (v3 > 0) {
            $('#koreksippl1_par3').val(v3);
            var n3 = (hsl3 == 0) ? v3 : ((parseFloat(hsl3) + v3) / 2);
            $('#nilaippl1_par3').val(parseFloat(n3).toFixed(2));
        }

        if (v4 > 0) {
            $('#koreksippl1_par4').val(v4);
            var n4 = (hsl4 == 0) ? v4 : ((parseFloat(hsl4) + v4) / 2);
            $('#nilaippl1_par4').val(parseFloat(n4).toFixed(2));
        }

        var pp3 = parseFloat($('#nilaippl1_par3').val() || 0);
        var pp4 = parseFloat($('#nilaippl1_par4').val() || 0);

        var arr = [parseFloat(pilar1_par1||0), parseFloat(pilar1_par2||0), parseFloat(pp3||0), parseFloat(pp4||0)];
        var tertinggi = Math.max.apply(null, arr);
        var terendah  = Math.min.apply(null, arr);
        var rata2 = (arr[0] + arr[1] + arr[2] + arr[3]) / 4;

        $('#tertinggi_pil1').val(parseFloat(tertinggi).toFixed(2));
        $('#terendah_pil1').val(parseFloat(terendah).toFixed(2));
        $('#rata_rata_pil1').val(parseFloat(rata2).toFixed(2));

        var risiko = 0;
        if (setPil1 == 1) risiko = tertinggi;
        else if (setPil1 == 2) risiko = terendah;
        else if (setPil1 == 3) risiko = rata2;

        $('#risiko_pil1').val(parseFloat(risiko).toFixed(2));
        $('#hasil_risiko_pil1').val(parseFloat(risiko).toFixed(2));
    }

    $('#target_pasar1, #sektor_terbesar3').on('change', function(){
        hitungPilar1Tambahan();
    });

    function refreshPilar2RekapLangsung(){
        var par1 = parseFloat($('#nilaipil2_par1').val() || 0) || 0;
        var par2 = parseFloat(<?= json_encode((float)$nilai_pil2_par2) ?>) || 0;
        var par3 = parseFloat(<?= json_encode((float)$nilai_pil2_par3) ?>) || 0;
        var arr = [par1, par2, par3];
        var tertinggi = Math.max.apply(null, arr);
        var terendah = Math.min.apply(null, arr);
        var rata = (par1 + par2 + par3) / 3;

        $('#pilar2_max').val(tertinggi.toFixed(2));
        $('#pilar2_min').val(terendah.toFixed(2));
        $('#pilar2_avg').val(rata.toFixed(2));

        var mode = <?= json_encode($setris_mode) ?>;
        var metode = parseInt(<?= json_encode((int)$set_pil2) ?>, 10);
        var bobot = parseFloat(<?= json_encode((float)$setris_bobot_pil2) ?>) || 0;
        var risiko = 0;

        if (mode === 'pembobotan') {
            risiko = rata * (bobot / 100);
        } else if (metode === 1) {
            risiko = tertinggi;
        } else if (metode === 2) {
            risiko = terendah;
        } else {
            risiko = rata;
        }

        $('#pil2_tingkat_risiko').val(risiko.toFixed(2));
        $('#hasil_risiko_pil2').val(risiko.toFixed(2));

        // Trigger agar fungsi rekap inheren utama ikut update langsung.
        $('#pilar2_max, #pilar2_min, #pilar2_avg, #pil2_tingkat_risiko, #hasil_risiko_pil2').trigger('input');
    }

    function hitungPilar2Par1Tambahan(){
        var base = parseFloat(0.0);
        base = parseFloat(<?= json_encode((float)$hsl_pil2_par1) ?>);
        var val = parseFloat($('#penyaluran_kredit2_1').val() || 0);
        $('#koreksipil2_par1').val(val > 0 ? val.toFixed(2) : '');
        var hasil = (val > 0) ? ((base + val) / 2) : base;
        $('#nilaipil2_par1').val(parseFloat(hasil).toFixed(2));
        refreshPilar2RekapLangsung();
    }

    $('#penyaluran_kredit2_1').on('change input', function(){
        hitungPilar2Par1Tambahan();
    });

    hitungPilar1Tambahan();
    hitungPilar2Par1Tambahan();
});
</script>

</div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>


            <!-- end row -->


            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>


