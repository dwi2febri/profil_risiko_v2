<?php
//pembobotan
$pembobotan = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM bobot_kredit_per_parameter WHERE tahun = ?", [$tahun]));
$bobot1 = $pembobotan['sub_parameter1'];
$bobot2 = $pembobotan['sub_parameter2'];
$bobot3 = $pembobotan['sub_parameter3'];
$bobot4 = $pembobotan['sub_parameter4'];
$bobot5 = $pembobotan['sub_parameter5'];
$bobot6 = $pembobotan['sub_parameter6'];
$bobot7 = $pembobotan['sub_parameter7'];
$bobot8 = $pembobotan['sub_parameter8'];
$bobot2_1 = $pembobotan['sub_parameter2_1'];
$bobot2_2 = $pembobotan['sub_parameter2_2'];
$bobot2_3 = $pembobotan['sub_parameter2_3'];
$bobot2_4 = $pembobotan['sub_parameter2_4'];
$bobot2_5 = $pembobotan['sub_parameter2_5'];
$bobot2_6 = $pembobotan['sub_parameter2_6'];
$bobot2_7 = $pembobotan['sub_parameter2_7'];
$bobot2_8 = $pembobotan['sub_parameter2_8'];
$bobot2_9 = $pembobotan['sub_parameter2_9'];
$bobot2_10 = $pembobotan['sub_parameter2_10'];
$bobot2_11 = $pembobotan['sub_parameter2_11'];
$bobot3_1 = $pembobotan['sub_parameter3_1'];
$bobot3_2 = $pembobotan['sub_parameter3_2'];
$bobot3_3 = $pembobotan['sub_parameter3_3'];
$bobot3_4 = $pembobotan['sub_parameter3_4'];
$bobot3_5 = $pembobotan['sub_parameter3_5'];
$bobot3_6 = $pembobotan['sub_parameter3_6'];
$bobot4_1 = $pembobotan['sub_parameter4_1'];
$bobot4_2 = $pembobotan['sub_parameter4_2'];
$bobot4_3 = $pembobotan['sub_parameter4_3'];
$bobot4_4 = $pembobotan['sub_parameter4_4'];
$bobot5_1 = $pembobotan['sub_parameter5_1'];
$bobot6_1 = $pembobotan['sub_parameter6_1'];
$bobot6_2 = $pembobotan['sub_parameter6_2'];
$bobot6_3 = $pembobotan['sub_parameter6_3'];
$bobot6_4 = $pembobotan['sub_parameter6_4'];
$bobot7_1 = $pembobotan['sub_parameter7_1'];
$bobot7_2 = $pembobotan['sub_parameter7_2'];
$bobot7_3 = $pembobotan['sub_parameter7_3'];
$bobot7_4 = $pembobotan['sub_parameter7_4'];
$bobot7_5 = $pembobotan['sub_parameter7_5'];
$bobot7_6 = $pembobotan['sub_parameter7_6'];
$bobot7_7 = $pembobotan['sub_parameter7_7'];
$bobot7_8 = $pembobotan['sub_parameter7_8'];
$bobot7_9 = $pembobotan['sub_parameter7_9'];
$bobot7_10 = $pembobotan['sub_parameter7_10'];
$bobot7_11 = $pembobotan['sub_parameter7_11'];

//setingan ditetapkan
$set_pil1 = $inheren['inheren_kre_set_pil1'];
$set_pil2 = $inheren['inheren_kre_set_pil2'];
$set_pil3 = $inheren['inheren_kre_set_pil3'];
$set_tingkat_risiko = $inheren['inheren_kre_set_tingkat_risiko'];
?>

<?php


include "../fungsi/fungsi.php";
if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $tahun = $_POST['tahun'];
    $user = $_POST['user'];
    $periode = $_POST['periode'];
    $modal_inti = $_POST['modal_inti'];
    $total_aset = $_POST['total_aset'];
    $keterangan = $_POST['keterangan'];
    

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $dibuat_by2 = $_SESSION['user_id'];

    

    function fetchData($conn, $table, $tahun, $periode, $user = 2, $dibuat_by2 = []) {
        $sql = "SELECT * 
                FROM {$table} AS t
                INNER JOIN frame_laporan_profil_risiko f
                    ON t.id_profil_risiko = f.id_profil_risiko
                WHERE f.tahun = '$tahun' 
                  AND f.periode = '$periode' 
                  AND f.user = $user";
    
        if (!empty($dibuat_by2)) {
            $ids = implode(',', array_map('intval', $dibuat_by2));
            $sql .= " AND f.dibuat_by IN ($ids)";
        }
    
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query error pada tabel $table: " . mysqli_error($conn));
        }
    
        // Kelompokkan hasil berdasarkan dibuat_by
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $by = intval($row['dibuat_by']);
            $rows[$by] = $row;
        }
    
        return $rows; // return array yang diindeks berdasarkan dibuat_by
    }
    
    // Mapping dibuat_by per tabel
    $table_dibuat_by = [
        'inheren_kredit_pilar1'=> [132,142],
        'inheren_kredit_pilar2'=> [132,142],
        'inheren_kredit_pilar3'=> [132,142],
        'inheren_kredit_pilar4'=> [132,142],
        'inheren_kredit_lainnya'=> [132,142],
    
        'inheren_operasional_pilar1'=> [133,134,135],
        'inheren_operasional_pilar2'=> [133,134,135],
        'inheren_operasional_pilar3'=> [133,134,135,143],
        'inheren_operasional_pilar4'=> [133,134,135],
        'inheren_operasional_pilar5'=> [133,134,135],
        'inheren_operasional_lainnya'=> [133,134,135,143],
    
        'ket_inheren_operasional_pilar1'=> [133,134,135],
        'ket_inheren_operasional_pilar2'=> [133,134,135],
        'ket_inheren_operasional_pilar3'=> [133,134,135],
        'ket_inheren_operasional_pilar4'=> [133,134,135],
        'ket_inheren_operasional_pilar5'=> [133,134,135],
        'ket_inheren_operasional_lainnya'=> [133,134,135],
    
        'inheren_kepatuhan_pilar1'=> [135,136,143],
        'inheren_kepatuhan_pilar2'=> [135,136],
        'inheren_kepatuhan_lainnya'=> [135,136],
    
        'inheren_likuiditas_pilar1'=> [132],
        'inheren_likuiditas_pilar2'=> [132],
        'inheren_likuiditas_lainnya'=> [132],
    
        'inheren_reputasi_pilar1'=> [135,136],
        'inheren_reputasi_pilar2'=> [135,136],
        'inheren_reputasi_pilar3'=> [135,136],
        'inheren_reputasi_lainnya'=> [135,136,143],
    
        'inheren_stratejik_pilar1'=> [137],
        'inheren_stratejik_pilar2'=> [137],
        'inheren_stratejik_pilar3'=> [137],
        'inheren_stratejik_lainnya'=> [137],
    
        'ket_inheren_kepatuhan_pilar1'=> [135,136],
        'ket_inheren_kepatuhan_pilar2'=> [135,136],
        'ket_inheren_kepatuhan_lainnya'=> [135,136],
    
        'ket_inheren_reputasi_pilar1'=> [135,136],
        'ket_inheren_reputasi_pilar2'=> [135,136],
        'ket_inheren_reputasi_pilar3'=> [135,136],
        'ket_inheren_reputasi_lainnya'=> [135,136],
    
        'ket_inheren_stratejik_pilar1'=> [137],
        'ket_inheren_stratejik_pilar2'=> [137],
        'ket_inheren_stratejik_pilar3'=> [137],
        'ket_inheren_stratejik_lainnya'=> [137],
    
        'kpmr_kredit_pilar1'=> [132,142],
        'kpmr_kredit_pilar2'=> [132,142],
        'kpmr_kredit_pilar3'=> [132,142],
        'kpmr_kredit_pilar4'=> [143],
    
        'kpmr_operasional_pilar1'=> [133,134,135],
        'kpmr_operasional_pilar2'=> [133,134,135],
        'kpmr_operasional_pilar3'=> [133,134,135],
        'kpmr_operasional_pilar4'=> [143],
    
        'kpmr_kepatuhan_pilar1'=> [135,136],
        'kpmr_kepatuhan_pilar2'=> [135,136],
        'kpmr_kepatuhan_pilar3'=> [135,136],
        'kpmr_kepatuhan_pilar4'=> [143],
    
        'kpmr_likuiditas_pilar1'=> [132],
        'kpmr_likuiditas_pilar2'=> [132],
        'kpmr_likuiditas_pilar3'=> [132],
        'kpmr_likuiditas_pilar4'=> [143],
    
        'kpmr_reputasi_pilar1'=> [135,136],
        'kpmr_reputasi_pilar2'=> [135,136],
        'kpmr_reputasi_pilar3'=> [135,136],
        'kpmr_reputasi_pilar4'=> [143],
    
        'kpmr_stratejik_pilar1'=> [137],
        'kpmr_stratejik_pilar2'=> [137],
        'kpmr_stratejik_pilar3'=> [137],
        'kpmr_stratejik_pilar4'=> [143],
    
        'respon_unit_kerja_kredit_pil1'=> [132,142],
        'respon_unit_kerja_kredit_pil2'=> [132,142],
        'respon_unit_kerja_kredit_pil3'=> [132,142],
        'respon_unit_kerja_kredit_pil4'=> [143],
    
        'respon_unit_kerja_operasional_pil1'=> [133,134,135],
        'respon_unit_kerja_operasional_pil2'=> [133,134,135],
        'respon_unit_kerja_operasional_pil3'=> [133,134,135],
        'respon_unit_kerja_operasional_pil4'=> [143],
    
        'respon_unit_kerja_kepatuhan_pil1'=> [135,136],
        'respon_unit_kerja_kepatuhan_pil2'=> [135,136],
        'respon_unit_kerja_kepatuhan_pil3'=> [135,136],
        'respon_unit_kerja_kepatuhan_pil4'=> [143],
    
        'respon_unit_kerja_likuiditas_pil1'=> [132],
        'respon_unit_kerja_likuiditas_pil2'=> [132],
        'respon_unit_kerja_likuiditas_pil3'=> [132],
        'respon_unit_kerja_likuiditas_pil4'=> [143],
    
        'respon_unit_kerja_reputasi_pil1'=> [135,136],
        'respon_unit_kerja_reputasi_pil2'=> [135,136],
        'respon_unit_kerja_reputasi_pil3'=> [135,136],
        'respon_unit_kerja_reputasi_pil4'=> [143],
    
        'respon_unit_kerja_stratejik_pil1'=> [137],
        'respon_unit_kerja_stratejik_pil2'=> [137],
        'respon_unit_kerja_stratejik_pil3'=> [137],
        'respon_unit_kerja_stratejik_pil4'=> [143],
    
        'keterangan_inheren_kredit'=> [132,142],
        'keterangan_inheren2_operasional'=> [133,134,135],
        'keterangan_inheren2_kepatuhan'=> [135,136],
        'keterangan_inheren_likuiditas'=> [132],
        'keterangan_inheren2_reputasi'=> [135,136],
        'keterangan_inheren2_stratejik'=> [137],
    
        'keterangan_kpmr2_kredit'=> [132,142],
        'keterangan_kpmr2_operasional'=> [133,134,135],
        'keterangan_kpmr2_kepatuhan'=> [135,136],
        'keterangan_kpmr2_likuiditas'=> [132],
        'keterangan_kpmr2_reputasi'=> [135,136],
        'keterangan_kpmr2_stratejik'=> [137]
    ];
    
    // Daftar tabel
    $tables = array_keys($table_dibuat_by);
    
    // Ambil semua data
    $data = [];
    foreach ($tables as $table) {
        $dibuat_by2 = $table_dibuat_by[$table] ?? [];
        $data[$table] = fetchData($conn, $table, $tahun, $periode, 2, $dibuat_by2);
    }
    
    // Cara akses spesifik
    $kredit_pilar1_3 = $data['inheren_kredit_pilar1'][132]['pilar1_3'] ?? 0;
    $kredit_pilar1_4 = $data['inheren_kredit_pilar1'][132]['pilar1_4'] ?? 0;

    // inheren_operasional_pilar1
    $ops_pilar1_1 = $data['inheren_operasional_pilar1'][133]['pilar1_1'] ?? 0;
    $ops_pilar1_2 = $data['inheren_operasional_pilar1'][133]['pilar1_2'] ?? 0;
    $ops_pilar1_2a = $data['inheren_operasional_pilar1'][133]['pilar1_2a'] ?? 0;
    $ops_pilar1_2b = $data['inheren_operasional_pilar1'][133]['pilar1_2b'] ?? 0;
    $ops_pilar1_3 = $data['inheren_operasional_pilar1'][133]['pilar1_3'] ?? 0;
    $ops_pilar1_3a = $data['inheren_operasional_pilar1'][133]['pilar1_3a'] ?? 0;
    $ops_pilar1_3b = $data['inheren_operasional_pilar1'][133]['pilar1_3b'] ?? 0;
    $ops_pilar1_3c = $data['inheren_operasional_pilar1'][133]['pilar1_3c'] ?? 0;
    $ops_pilar1_4 = $data['inheren_operasional_pilar1'][133]['pilar1_4'] ?? 0;
    $ops_pilar1_4a = $data['inheren_operasional_pilar1'][133]['pilar1_4a'] ?? 0;
    $ops_average_pil1_1 = $data['inheren_operasional_pilar1'][133]['average_pil1_1'] ?? 0;
    $ops_average_pil1_2 = $data['inheren_operasional_pilar1'][133]['average_pil1_2'] ?? 0;
    $ops_average_pil1_3 = $data['inheren_operasional_pilar1'][133]['average_pil1_3'] ?? 0;
    $ops_average_pil1_4 = $data['inheren_operasional_pilar1'][133]['average_pil1_4'] ?? 0;
    $ops_min_pil1_1 = $data['inheren_operasional_pilar1'][133]['min_pil1_1'] ?? 0;
    $ops_min_pil1_2 = $data['inheren_operasional_pilar1'][133]['min_pil1_2'] ?? 0;
    $ops_min_pil1_3 = $data['inheren_operasional_pilar1'][133]['min_pil1_3'] ?? 0;
    $ops_min_pil1_4 = $data['inheren_operasional_pilar1'][133]['min_pil1_4'] ?? 0;
    $ops_max_pil1_1 = $data['inheren_operasional_pilar1'][133]['max_pil1_1'] ?? 0;
    $ops_max_pil1_2 = $data['inheren_operasional_pilar1'][133]['max_pil1_2'] ?? 0;
    $ops_max_pil1_3 = $data['inheren_operasional_pilar1'][133]['max_pil1_3'] ?? 0;
    $ops_max_pil1_4 = $data['inheren_operasional_pilar1'][133]['max_pil1_4'] ?? 0;
    $ops_hasil_pil1_par1 = $data['inheren_operasional_pilar1'][133]['hasil_pil1_par1'] ?? 0;
    $ops_hasil_pil1_par2 = $data['inheren_operasional_pilar1'][133]['hasil_pil1_par2'] ?? 0;
    $ops_hasil_pil1_par3 = $data['inheren_operasional_pilar1'][133]['hasil_pil1_par3'] ?? 0;
    $ops_hasil_pil1_par4 = $data['inheren_operasional_pilar1'][133]['hasil_pil1_par4'] ?? 0;
    
    $ket_in_op_pil1_1 = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_1'] ?? '';
    $ket_in_op_pil1_2 = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_2'] ?? '';
    $ket_in_op_pil1_2a = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_2a'] ?? '';
    $ket_in_op_pil1_2b = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_2b'] ?? '';
    $ket_in_op_pil1_3 = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_3'] ?? '';
    $ket_in_op_pil1_3a = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_3a'] ?? '';
    $ket_in_op_pil1_3b = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_3b'] ?? '';
    $ket_in_op_pil1_3c = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_3c'] ?? '';
    $ket_in_op_pil1_4 = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_4'] ?? '';
    $ket_in_op_pil1_4a = $data['ket_inheren_operasional_pilar1'][133]['ket_in_op_pil1_4a'] ?? '';


    $kpmr_ops_pilar1_1a = $data['kpmr_operasional_pilar1'][133]['pilar1_1a'] ?? 0;
    $kpmr_ops_pilar1_1b = $data['kpmr_operasional_pilar1'][133]['pilar1_1b'] ?? 0;
    $kpmr_ops_pilar1_1c = $data['kpmr_operasional_pilar1'][133]['pilar1_1c'] ?? 0;
    $kpmr_ops_pilar1_1d = $data['kpmr_operasional_pilar1'][133]['pilar1_1d'] ?? 0;
    $kpmr_ops_pilar1_1e = $data['kpmr_operasional_pilar1'][133]['pilar1_1e'] ?? 0;
    $kpmr_ops_pil1_total1 = $data['kpmr_operasional_pilar1'][133]['pil1_total1'] ?? 0;
    $kpmr_ops_pil1_peringkat1 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat1'] ?? 0;

    $kpmr_ops_pilar1_2a = $data['kpmr_operasional_pilar1'][133]['pilar1_2a'] ?? 0;
    $kpmr_ops_pilar1_2b = $data['kpmr_operasional_pilar1'][133]['pilar1_2b'] ?? 0;
    $kpmr_ops_pilar1_2c = $data['kpmr_operasional_pilar1'][133]['pilar1_2c'] ?? 0;
    $kpmr_ops_pilar1_2d = $data['kpmr_operasional_pilar1'][133]['pilar1_2d'] ?? 0;
    $kpmr_ops_pilar1_2e = $data['kpmr_operasional_pilar1'][133]['pilar1_2e'] ?? 0;
    $kpmr_ops_pil1_total2 = $data['kpmr_operasional_pilar1'][133]['pil1_total2'] ?? 0;
    $kpmr_ops_pil1_peringkat2 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat2'] ?? 0;

    $kpmr_ops_pilar1_3a = $data['kpmr_operasional_pilar1'][133]['pilar1_3a'] ?? 0;
    $kpmr_ops_pilar1_3b = $data['kpmr_operasional_pilar1'][133]['pilar1_3b'] ?? 0;
    $kpmr_ops_pilar1_3c = $data['kpmr_operasional_pilar1'][133]['pilar1_3c'] ?? 0;
    $kpmr_ops_pil1_total3 = $data['kpmr_operasional_pilar1'][133]['pil1_total3'] ?? 0;
    $kpmr_ops_pil1_peringkat3 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat3'] ?? 0;

    $kpmr_ops_pilar1_4a = $data['kpmr_operasional_pilar1'][133]['pilar1_4a'] ?? 0;
    $kpmr_ops_pilar1_4b = $data['kpmr_operasional_pilar1'][133]['pilar1_4b'] ?? 0;
    $kpmr_ops_pilar1_4c = $data['kpmr_operasional_pilar1'][133]['pilar1_4c'] ?? 0;
    $kpmr_ops_pilar1_4d = $data['kpmr_operasional_pilar1'][133]['pilar1_4d'] ?? 0;
    $kpmr_ops_pilar1_4e = $data['kpmr_operasional_pilar1'][133]['pilar1_4e'] ?? 0;
    $kpmr_ops_pil1_total4 = $data['kpmr_operasional_pilar1'][133]['pil1_total4'] ?? 0;
    $kpmr_ops_pil1_peringkat4 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat4'] ?? 0;

    $kpmr_ops_pilar1_5a = $data['kpmr_operasional_pilar1'][133]['pilar1_5a'] ?? 0;
    $kpmr_ops_pilar1_5b = $data['kpmr_operasional_pilar1'][133]['pilar1_5b'] ?? 0;
    $kpmr_ops_pilar1_5c = $data['kpmr_operasional_pilar1'][133]['pilar1_5c'] ?? 0;
    $kpmr_ops_pilar1_5d = $data['kpmr_operasional_pilar1'][133]['pilar1_5d'] ?? 0;
    $kpmr_ops_pil1_total5 = $data['kpmr_operasional_pilar1'][133]['pil1_total5'] ?? 0;
    $kpmr_ops_pil1_peringkat5 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat5'] ?? 0;

    $kpmr_ops_pilar1_6a = $data['kpmr_operasional_pilar1'][133]['pilar1_6a'] ?? 0;
    $kpmr_ops_pilar1_6b = $data['kpmr_operasional_pilar1'][133]['pilar1_6b'] ?? 0;
    $kpmr_ops_pilar1_6c = $data['kpmr_operasional_pilar1'][133]['pilar1_6c'] ?? 0;
    $kpmr_ops_pil1_total6 = $data['kpmr_operasional_pilar1'][133]['pil1_total6'] ?? 0;
    $kpmr_ops_pil1_peringkat6 = $data['kpmr_operasional_pilar1'][133]['pil1_peringkat6'] ?? 0;

        
        

    // inheren_operasional_pilar2
    $ops_pilar2_1 = $data['inheren_operasional_pilar2'][134]['pilar2_1'] ?? 0;
    $ops_pilar2_1a = $data['inheren_operasional_pilar2'][134]['pilar2_1a'] ?? 0;
    $ops_pilar2_1b = $data['inheren_operasional_pilar2'][134]['pilar2_1b'] ?? 0;
    $ops_pilar2_1c = $data['inheren_operasional_pilar2'][134]['pilar2_1c'] ?? 0;
    $ops_pilar2_1d = $data['inheren_operasional_pilar2'][134]['pilar2_1d'] ?? 0;
    $ops_pilar2_1e = $data['inheren_operasional_pilar2'][134]['pilar2_1e'] ?? 0;
    $ops_pilar2_1f = $data['inheren_operasional_pilar2'][134]['pilar2_1f'] ?? 0;
    $ops_pilar2_1g = $data['inheren_operasional_pilar2'][134]['pilar2_1g'] ?? 0;
    $ops_pilar2_1h = $data['inheren_operasional_pilar2'][134]['pilar2_1h'] ?? 0;
    $ops_pilar2_1i = $data['inheren_operasional_pilar2'][134]['pilar2_1i'] ?? 0;
    $ops_pilar2_1j = $data['inheren_operasional_pilar2'][134]['pilar2_1j'] ?? 0;
    $ops_pilar2_1k = $data['inheren_operasional_pilar2'][134]['pilar2_1k'] ?? 0;
    $ops_pilar2_1l = $data['inheren_operasional_pilar2'][134]['pilar2_1l'] ?? 0;
    $ops_pilar2_1m = $data['inheren_operasional_pilar2'][134]['pilar2_1m'] ?? 0;
    $ops_pilar2_1n = $data['inheren_operasional_pilar2'][134]['pilar2_1n'] ?? 0;
    $ops_pilar2_2 = $data['inheren_operasional_pilar2'][134]['pilar2_2'] ?? 0;
    $ops_average_pil2_1 = $data['inheren_operasional_pilar2'][134]['average_pil2_1'] ?? 0;
    $ops_average_pil2_2 = $data['inheren_operasional_pilar2'][134]['average_pil2_2'] ?? 0;
    $ops_min_pil2_1 = $data['inheren_operasional_pilar2'][134]['min_pil2_1'] ?? 0;
    $ops_min_pil2_2 = $data['inheren_operasional_pilar2'][134]['min_pil2_2'] ?? 0;
    $ops_max_pil2_1 = $data['inheren_operasional_pilar2'][134]['max_pil2_1'] ?? 0;
    $ops_max_pil2_2 = $data['inheren_operasional_pilar2'][134]['max_pil2_2'] ?? 0;
    $ops_hasil_pil2_par1 = $data['inheren_operasional_pilar2'][134]['hasil_pil2_par1'] ?? 0;
    $ops_hasil_pil2_par2 = $data['inheren_operasional_pilar2'][134]['hasil_pil2_par2'] ?? 0;

    $ket_in_op_pil2_1 = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1'] ?? '';
    $ket_in_op_pil2_1a = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1a'] ?? '';
    $ket_in_op_pil2_1b = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1b'] ?? '';
    $ket_in_op_pil2_1c = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1c'] ?? '';
    $ket_in_op_pil2_1d = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1d'] ?? '';
    $ket_in_op_pil2_1e = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1e'] ?? '';
    $ket_in_op_pil2_1f = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1f'] ?? '';
    $ket_in_op_pil2_1g = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1g'] ?? '';
    $ket_in_op_pil2_1h = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1h'] ?? '';
    $ket_in_op_pil2_1i = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1i'] ?? '';
    $ket_in_op_pil2_1j = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1j'] ?? '';
    $ket_in_op_pil2_1k = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1k'] ?? '';
    $ket_in_op_pil2_1l = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1l'] ?? '';
    $ket_in_op_pil2_1m = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1m'] ?? '';
    $ket_in_op_pil2_1n = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_1n'] ?? '';
    $ket_in_op_pil2_2 = $data['ket_inheren_operasional_pilar2'][134]['ket_in_op_pil2_2'] ?? '';

    $kpmr_ops_pilar2_1a = $data['kpmr_operasional_pilar2'][133]['pilar2_1a'] ?? 0;
    $kpmr_ops_pilar2_1b = $data['kpmr_operasional_pilar2'][133]['pilar2_1b'] ?? 0;
    $kpmr_ops_pilar2_1c = $data['kpmr_operasional_pilar2'][133]['pilar2_1c'] ?? 0;
    $kpmr_ops_pilar2_1d = $data['kpmr_operasional_pilar2'][133]['pilar2_1d'] ?? 0;
    $kpmr_ops_pilar2_1e = $data['kpmr_operasional_pilar2'][133]['pilar2_1e'] ?? 0;
    $kpmr_ops_pil2_total1 = $data['kpmr_operasional_pilar2'][133]['pil2_total1'] ?? 0;
    $kpmr_ops_pil2_peringkat1 = $data['kpmr_operasional_pilar2'][133]['pil2_peringkat1'] ?? 0;
    $kpmr_ops_pilar2_2a = $data['kpmr_operasional_pilar2'][133]['pilar2_2a'] ?? 0;
    $kpmr_ops_pilar2_2b = $data['kpmr_operasional_pilar2'][133]['pilar2_2b'] ?? 0;
    $kpmr_ops_pilar2_2c = $data['kpmr_operasional_pilar2'][133]['pilar2_2c'] ?? 0;
    $kpmr_ops_pilar2_2d = $data['kpmr_operasional_pilar2'][133]['pilar2_2d'] ?? 0;
    $kpmr_ops_pilar2_2e = $data['kpmr_operasional_pilar2'][133]['pilar2_2e'] ?? 0;
    $kpmr_ops_pilar2_2f = $data['kpmr_operasional_pilar2'][133]['pilar2_2f'] ?? 0;
    $kpmr_ops_pilar2_2g = $data['kpmr_operasional_pilar2'][133]['pilar2_2g'] ?? 0;
    $kpmr_ops_pilar2_2h = $data['kpmr_operasional_pilar2'][133]['pilar2_2h'] ?? 0;
    $kpmr_ops_pil2_total2 = $data['kpmr_operasional_pilar2'][133]['pil2_total2'] ?? 0;
    $kpmr_ops_pil2_peringkat2 = $data['kpmr_operasional_pilar2'][133]['pil2_peringkat2'] ?? 0;
    $kpmr_ops_pilar2_3a = $data['kpmr_operasional_pilar2'][133]['pilar2_3a'] ?? 0;
    $kpmr_ops_pilar2_3b = $data['kpmr_operasional_pilar2'][133]['pilar2_3b'] ?? 0;
    $kpmr_ops_pilar2_3c = $data['kpmr_operasional_pilar2'][133]['pilar2_3c'] ?? 0;
    $kpmr_ops_pil2_total3 = $data['kpmr_operasional_pilar2'][133]['pil2_total3'] ?? 0;
    $kpmr_ops_pil2_peringkat3 = $data['kpmr_operasional_pilar2'][133]['pil2_peringkat3'] ?? 0;


    // inheren_operasional_pilar3
    $ops_pilar3_1 = $data['inheren_operasional_pilar3'][133]['pilar3_1'] ?? 0;
    $ops_pilar3_1a = $data['inheren_operasional_pilar3'][133]['pilar3_1a'] ?? 0;
    $ops_pilar3_1b = $data['inheren_operasional_pilar3'][133]['pilar3_1b'] ?? 0;
    $ops_pilar3_1c = $data['inheren_operasional_pilar3'][133]['pilar3_1c'] ?? 0;
    $ops_pilar3_1d = $data['inheren_operasional_pilar3'][133]['pilar3_1d'] ?? 0;
    $ops_pilar3_1e = $data['inheren_operasional_pilar3'][133]['pilar3_1e'] ?? 0;
    $ops_pilar3_1f = $data['inheren_operasional_pilar3'][133]['pilar3_1f'] ?? 0;
    $ops_pilar3_1g = $data['inheren_operasional_pilar3'][133]['pilar3_1g'] ?? 0;
    $ops_pilar3_1h = $data['inheren_operasional_pilar3'][133]['pilar3_1h'] ?? 0;
    $ops_pilar3_1i = $data['inheren_operasional_pilar3'][133]['pilar3_1i'] ?? 0;
    $ops_pilar3_1j = $data['inheren_operasional_pilar3'][133]['pilar3_1j'] ?? 0;
    $ops_pilar3_1k = $data['inheren_operasional_pilar3'][133]['pilar3_1k'] ?? 0;
    $ops_pilar3_1l = $data['inheren_operasional_pilar3'][133]['pilar3_1l'] ?? 0;
    $ops_pilar3_1m = $data['inheren_operasional_pilar3'][133]['pilar3_1m'] ?? 0;
    $ops_pilar3_1n = $data['inheren_operasional_pilar3'][133]['pilar3_1n'] ?? 0;
    $ops_pilar3_1o = $data['inheren_operasional_pilar3'][133]['pilar3_1o'] ?? 0;
    $ops_pilar3_1p = $data['inheren_operasional_pilar3'][133]['pilar3_1p'] ?? 0;
    $ops_average_pil3_1 = $data['inheren_operasional_pilar3'][133]['average_pil3_1'] ?? 0;
    $ops_min_pil3_1 = $data['inheren_operasional_pilar3'][133]['min_pil3_1'] ?? 0;
    $ops_max_pil3_1 = $data['inheren_operasional_pilar3'][133]['max_pil3_1'] ?? 0;
    $ops_hasil_pil3_par1 = $data['inheren_operasional_pilar3'][133]['hasil_pil3_par1'] ?? 0;

    $ket_in_op_pil3_1 = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1'] ?? '';
    $ket_in_op_pil3_1a = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1a'] ?? '';
    $ket_in_op_pil3_1b = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1b'] ?? '';
    $ket_in_op_pil3_1c = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1c'] ?? '';
    $ket_in_op_pil3_1d = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1d'] ?? '';
    $ket_in_op_pil3_1e = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1e'] ?? '';
    $ket_in_op_pil3_1f = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1f'] ?? '';
    $ket_in_op_pil3_1g = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1g'] ?? '';
    $ket_in_op_pil3_1h = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1h'] ?? '';
    $ket_in_op_pil3_1i = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1i'] ?? '';
    $ket_in_op_pil3_1j = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1j'] ?? '';
    $ket_in_op_pil3_1k = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1k'] ?? '';
    $ket_in_op_pil3_1l = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1l'] ?? '';
    $ket_in_op_pil3_1m = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1m'] ?? '';
    $ket_in_op_pil3_1n = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1n'] ?? '';
    $ket_in_op_pil3_1o = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1o'] ?? '';
    $ket_in_op_pil3_1p = $data['ket_inheren_operasional_pilar3'][133]['ket_in_op_pil3_1p'] ?? '';


    // inheren_operasional_pilar4
    $ops_pilar4_1 = $data['inheren_operasional_pilar4'][135]['pilar4_1'] ?? 0;
    $ops_pilar4_1a = $data['inheren_operasional_pilar4'][135]['pilar4_1a'] ?? 0;
    $ops_pilar4_1b = $data['inheren_operasional_pilar4'][135]['pilar4_1b'] ?? 0;
    $ops_pilar4_1c = $data['inheren_operasional_pilar4'][135]['pilar4_1c'] ?? 0;
    $ops_pilar4_1d = $data['inheren_operasional_pilar4'][135]['pilar4_1d'] ?? 0;
    $ops_average_pil4_1 = $data['inheren_operasional_pilar4'][135]['average_pil4_1'] ?? 0;
    $ops_min_pil4_1 = $data['inheren_operasional_pilar4'][135]['min_pil4_1'] ?? 0;
    $ops_max_pil4_1 = $data['inheren_operasional_pilar4'][135]['max_pil4_1'] ?? 0;
    $ops_hasil_pil4_par1 = $data['inheren_operasional_pilar4'][135]['hasil_pil4_par1'] ?? 0;

    $ket_in_op_pil4_1 = $data['ket_inheren_operasional_pilar4'][135]['ket_in_op_pil4_1'] ?? '';
    $ket_in_op_pil4_1a = $data['ket_inheren_operasional_pilar4'][135]['ket_in_op_pil4_1a'] ?? '';
    $ket_in_op_pil4_1b = $data['ket_inheren_operasional_pilar4'][135]['ket_in_op_pil4_1b'] ?? '';
    $ket_in_op_pil4_1c = $data['ket_inheren_operasional_pilar4'][135]['ket_in_op_pil4_1c'] ?? '';
    $ket_in_op_pil4_1d = $data['ket_inheren_operasional_pilar4'][135]['ket_in_op_pil4_1d'] ?? '';


    // inheren_operasional_pilar5
    $ops_pilar5_1 = $data['inheren_operasional_pilar5'][133]['pilar5_1'] ?? 0;
    $ops_pilar5_1a = $data['inheren_operasional_pilar5'][133]['pilar5_1a'] ?? 0;
    $ops_pilar5_1b = $data['inheren_operasional_pilar5'][133]['pilar5_1b'] ?? 0;
    $ops_pilar5_1c = $data['inheren_operasional_pilar5'][133]['pilar5_1c'] ?? 0;
    $ops_pilar5_1d = $data['inheren_operasional_pilar5'][133]['pilar5_1d'] ?? 0;
    $ops_pilar5_1e = $data['inheren_operasional_pilar5'][133]['pilar5_1e'] ?? 0;
    $ops_pilar5_1f = $data['inheren_operasional_pilar5'][133]['pilar5_1f'] ?? 0;
    $ops_average_pil5_1 = $data['inheren_operasional_pilar5'][133]['average_pil5_1'] ?? 0;
    $ops_min_pil5_1 = $data['inheren_operasional_pilar5'][133]['min_pil5_1'] ?? 0;
    $ops_max_pil5_1 = $data['inheren_operasional_pilar5'][133]['max_pil5_1'] ?? 0;
    $ops_hasil_pil5_par1 = $data['inheren_operasional_pilar5'][133]['hasil_pil5_par1'] ?? 0;

    $ket_in_op_pil5_1 = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1'] ?? '';
    $ket_in_op_pil5_1a = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1a'] ?? '';
    $ket_in_op_pil5_1b = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1b'] ?? '';
    $ket_in_op_pil5_1c = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1c'] ?? '';
    $ket_in_op_pil5_1d = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1d'] ?? '';
    $ket_in_op_pil5_1e = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1e'] ?? '';
    $ket_in_op_pil5_1f = $data['ket_inheren_operasional_pilar5'][133]['ket_in_op_pil5_1f'] ?? '';


    // inheren_operasional_lainnya (pilar6)
    $ops_pilar6_1a = $data['inheren_operasional_lainnya'][134]['pilar6_1a'] ?? 0;
    $ops_pilar6_1b = $data['inheren_operasional_lainnya'][134]['pilar6_1b'] ?? 0;
    $ops_pilar6_1c = $data['inheren_operasional_lainnya'][133]['pilar6_1c'] ?? 0;
    $ops_pilar6_1d = $data['inheren_operasional_lainnya'][133]['pilar6_1d'] ?? 0;
    $ops_pilar6_1e = $data['inheren_operasional_lainnya'][133]['pilar6_1e'] ?? 0;
    $ops_pilar6_1f = $data['inheren_operasional_lainnya'][133]['pilar6_1f'] ?? 0;
    $ops_average_pil6_1 = $data['inheren_operasional_lainnya'][133]['average_pil6_1'] ?? 0;
    $ops_min_pil6_1 = $data['inheren_operasional_lainnya'][133]['min_pil6_1'] ?? 0;
    $ops_max_pil6_1 = $data['inheren_operasional_lainnya'][133]['max_pil6_1'] ?? 0;
    $ops_hasil_pil6_par1 = $data['inheren_operasional_lainnya'][133]['hasil_pil6_par1'] ?? 0;

    $ket_in_op_pil6_1a = $data['ket_inheren_operasional_pilar6'][134]['ket_in_op_pil6_1a'] ?? '';
    $ket_in_op_pil6_1b = $data['ket_inheren_operasional_pilar6'][134]['ket_in_op_pil6_1b'] ?? '';
    $ket_in_op_pil6_1c = $data['ket_inheren_operasional_pilar6'][133]['ket_in_op_pil6_1c'] ?? '';
    $ket_in_op_pil6_1d = $data['ket_inheren_operasional_pilar6'][133]['ket_in_op_pil6_1d'] ?? '';
    $ket_in_op_pil6_1e = $data['ket_inheren_operasional_pilar6'][133]['ket_in_op_pil6_1e'] ?? '';
    $ket_in_op_pil6_1f = $data['ket_inheren_operasional_pilar6'][133]['ket_in_op_pil6_1f'] ?? '';


    

    //data master kredit
    $pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = ? AND  periode =? AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
    $pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar2 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = ? AND  periode =? AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
    $pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar3 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = ? AND  periode =? AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
    
    //data master likuditas
    $data_lik_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_likuiditas_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = ? AND  periode =? AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
    
    $isian_inheren_kredit_pilar1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_likuiditas_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = ? AND  periode =? AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));

        //master data lik pil1
        $aset_likuid = $data_lik_pil1['aset_likuid'];
        $kas = $data_lik_pil1['kas'];
        $giro_aba = $data_lik_pil1['giro_aba'];
        $tabungan_aba = $data_lik_pil1['tabungan_aba'];
        $total_aset = $data_lik_pil1['total_aset'];
        $kewajiban_lancar = $data_lik_pil1['kewajiban_lancar'];
        $kewajiban_segera = $data_lik_pil1['kewajiban_segera'];
        $tabungan = $data_lik_pil1['tabungan'];
        $deposito = $data_lik_pil1['deposito'];
        $pendanaan_jangka_pendek = $data_lik_pil1['pendanaan_jangka_pendek'];
        $kewajiban_jangka_pendek = $data_lik_pil1['kewajiban_jangka_pendek'];
        $deposito_1bln = $data_lik_pil1['deposito_1bln'];
        $deposito_3bln = $data_lik_pil1['deposito_3bln'];
        $deposito_6bln = $data_lik_pil1['deposito_6bln'];
        $deposito_12bln = $data_lik_pil1['deposito_12bln'];
        $pendanaan_non_inti = $data_lik_pil1['pendanaan_non_inti'];
        $dpk_lbh_2m = $data_lik_pil1['dpk_lbh_2m'];
        $deposito_diatas_cr = $data_lik_pil1['deposito_diatas_cr'];
        $deposito_diatas_lps = $data_lik_pil1['deposito_diatas_lps'];
        $korporasi = $data_lik_pil1['korporasi'];
        $dpk_des_thn_sebelum = $data_lik_pil1['dpk_des_thn_sebelum'];
        $alat_likuid = $data_lik_pil1['alat_likuid'];
        $penempatan_pd_bank_lain = $data_lik_pil1['penempatan_pd_bank_lain'];
        $modal_disetor = $data_lik_pil1['modal_disetor'];
        $kredit_des_thn_sebelum = $data_lik_pil1['kredit_des_thn_sebelum'];
        $pinjaman = $data_lik_pil1['pinjaman'];
        $kredit_kolek_lancar = $data_lik_pil1['kredit_kolek_lancar'];
        $pertumbuhan_kredit = $data_lik_pil1['pertumbuhan_kredit'];
        $dpk_dijamin_lps = $data_lik_pil1['dpk_dijamin_lps'];
        $simpanan_tdk_dijamin_lps = $data_lik_pil1['simpanan_tdk_dijamin_lps'];
        $total_dpk = $data_lik_pil1['total_dpk'];
        $dpk_tdk_dijamin_lps = $data_lik_pil1['dpk_tdk_dijamin_lps'];
        $deposan_tabungan_terbesar25 = $data_lik_pil1['deposan_tabungan_terbesar25'];
        $besar_deposan25 = $data_lik_pil1['besar_deposan25'];
        $besar_penabung25 = $data_lik_pil1['besar_penabung25'];
        $deposito_rs = $data_lik_pil1['deposito_rs'];
        $arus_kas_netto = $data_lik_pil1['arus_kas_netto'];
        $kas_besar_debet = $data_lik_pil1['kas_besar_debet'];
        $kas_besar_kredit = $data_lik_pil1['kas_besar_kredit'];
        $deposito_inti = $data_lik_pil1['deposito_inti'];
        $sisa_jangka_waktu_deposito = $data_lik_pil1['sisa_jangka_waktu_deposito'];
        $kredit_l_dp = $data_lik_pil1['kredit_l_dp'];
        //master data pil 1
        $aba = $pil1['aba'];
        $aset_produktif = $pil1['aset_produktif'];
        $kyd = $pil1['kyd'];
        $noa_kyd = $pil1['noa_kyd'];
        $debitur_inti25 = $pil1['debitur_inti25'];
        $kredit_3sektor_ekonomi_terbesar = $pil1['kredit_3sektor_ekonomi_terbesar'];
        $kredit_spg = $pil1['kredit_spg'];
        $kredit_pbta = $pil1['kredit_pbta'];
        $kredit_jpendek = $pil1['kredit_jpendek'];
        $kredit_jmenengah = $pil1['kredit_jmenengah'];
        $kredit_jpanjang = $pil1['kredit_jpanjang'];
        $kredit_agunan_tb = $pil1['kredit_agunan_tb'];
        $kredit_agunan_kb = $pil1['kredit_agunan_kb'];
        $kredit_agunan_kr2 = $pil1['kredit_agunan_kr2'];
        $kredit_ta = $pil1['kredit_ta'];
        $kredit_kub = $pil1['kredit_kub'];
        $kredit_korporasi = $pil1['kredit_korporasi'];
        $kredit_pep = $pil1['kredit_pep'];
        $kredit_lebih350 = $pil1['kredit_lebih350'];
        $kredit_joglo_mitra = $pil1['kredit_joglo_mitra'];
    
    
    
    //master data pil 2
        $modal_inti = $pil2['modal_inti'];
        $aset_produktif_bermasalah = $pil2['aset_produktif_bermasalah'];
        $total_aset_produktif = $pil2['total_aset_produktif'];
        $kredit_bermasalah = $pil2['kredit_bermasalah'];
        $noa_kredit_bermasalah = $pil2['noa_kredit_bermasalah'];
        $kredit_bermasalah_neto = $pil2['kredit_bermasalah_neto'];
        $saldo_ppap = $pil2['saldo_ppap'];
        $ayda = $pil2['ayda'];
        $kyd = $pil2['kyd'];
        $macet_jatuh_tempo = $pil2['macet_jatuh_tempo'];
        $kkr = $pil2['kkr'];
        $kredit_par4 = $pil2['kredit_par4'];
        $osc_bln_sebelumnya = $pil2['osc_bln_sebelumnya'];
        $osc_2bln_sebelumnya = $pil2['osc_2bln_sebelumnya'];
        $kredit_dp = $pil2['kredit_dp'];
        $noa_fpd_6bln = $pil2['noa_fpd_6bln'];
        $noa_ekspansi_6bln = $pil2['noa_ekspansi_6bln'];
        $nominal_fpd_6bln = $pil2['nominal_fpd_6bln'];
        $plafond_ekspansi_6bln = $pil2['plafond_ekspansi_6bln'];
        $npl_kredit_sd150 = $pil2['npl_kredit_sd150'];
        $kyd_plafon_sd150 = $pil2['kyd_plafon_sd150'];
        $noa_kredit_sd150 = $pil2['noa_kredit_sd150'];
        $npl_kredit_diatas50 = $pil2['npl_kredit_diatas50'];
        $kyd_plafon_diatas50 = $pil2['kyd_plafon_diatas50'];
        $npl_apht = $pil2['npl_apht'];
        $kyd_apht = $pil2['kyd_apht'];
        $npl_skmht = $pil2['npl_skmht'];
        $kyd_skmht = $pil2['kyd_skmht'];
        $npl_agunan_lrd_bakidebet = $pil2['npl_agunan_lrd_bakidebet'];
        $kredit_agunan_lrd_bakidebet = $pil2['kredit_agunan_lrd_bakidebet'];
    
    
    //master data pil 3
        $osc_akhir_tahun_lalu = $pil3['osc_akhir_tahun_lalu'];
        $noa_osc_akhir_tahun_lalu = $pil3['noa_osc_akhir_tahun_lalu'];
        $npl_akhir_tahun_lalu = $pil3['npl_akhir_tahun_lalu'];
        $noa_npl_akhir_tahun_lalu = $pil3['noa_npl_akhir_tahun_lalu'];
        $osc_per_bln_penilaian = $pil3['osc_per_bln_penilaian'];
        $pertumbuhan_rata2_bpr_thn_lalu = $pil3['pertumbuhan_rata2_bpr_thn_lalu'];
        $pertumbuhan_rata2_bpr = $pil3['pertumbuhan_rata2_bpr'];
        $pertumbuhan_kyd_bpr = $pil3['pertumbuhan_kyd_bpr'];
        $rasio_pertumbuhan_rata2_bpr = $pil3['rasio_pertumbuhan_rata2_bpr'];
        $td_pp_l = $pil3['td_pp_l'];
        $td_pp_dp = $pil3['td_pp_dp'];
        $td_pp_kl = $pil3['td_pp_kl'];
        $td_pp_d = $pil3['td_pp_d'];
        $td_pp_m = $pil3['td_pp_m'];
        $td_pp_l_noa = $pil3['td_pp_l_noa'];
        $td_pp_dp_noa = $pil3['td_pp_dp_noa'];
        $td_pp_kl_noa = $pil3['td_pp_kl_noa'];
        $td_pp_d_noa = $pil3['td_pp_d_noa'];
        $td_pp_m_noa = $pil3['td_pp_m_noa'];
        $td_ps_l = $pil3['td_ps_l'];
        $td_ps_dp = $pil3['td_ps_dp'];
        $td_ps_kl = $pil3['td_ps_kl'];
        $td_ps_d = $pil3['td_ps_d'];
        $td_ps_m = $pil3['td_ps_m'];
        $td_ps_l_noa = $pil3['td_ps_l_noa'];
        $td_ps_dp_noa = $pil3['td_ps_dp_noa'];
        $td_ps_kl_noa = $pil3['td_ps_kl_noa'];
        $td_ps_d_noa = $pil3['td_ps_d_noa'];
        $td_ps_m_noa = $pil3['td_ps_m_noa'];
        $d_pp_l = $pil3['d_pp_l'];
        $d_pp_dp = $pil3['d_pp_dp'];
        $d_pp_kl = $pil3['d_pp_kl'];
        $d_pp_d = $pil3['d_pp_d'];
        $d_pp_m = $pil3['d_pp_m'];
        $d_pp_l_noa = $pil3['d_pp_l_noa'];
        $d_pp_dp_noa = $pil3['d_pp_dp_noa'];
        $d_pp_kl_noa = $pil3['d_pp_kl_noa'];
        $d_pp_d_noa = $pil3['d_pp_d_noa'];
        $d_pp_m_noa = $pil3['d_pp_m_noa'];
        $d_ps_l = $pil3['d_ps_l'];
        $d_ps_dp = $pil3['d_ps_dp'];
        $d_ps_kl = $pil3['d_ps_kl'];
        $d_ps_d = $pil3['d_ps_d'];
        $d_ps_m = $pil3['d_ps_m'];
        $d_ps_l_noa = $pil3['d_ps_l_noa'];
        $d_ps_dp_noa = $pil3['d_ps_dp_noa'];
        $d_ps_kl_noa = $pil3['d_ps_kl_noa'];
        $d_ps_d_noa = $pil3['d_ps_d_noa'];
        $d_ps_m_noa = $pil3['d_ps_m_noa'];
        $osc_2bln_sebelumnya = $pil3['osc_2bln_sebelumnya'];
        $noa_2bln_sebelumnya = $pil3['noa_2bln_sebelumnya'];
        $npl_2bln_sebelumnya = $pil3['npl_2bln_sebelumnya'];
        $rasio_2bln_sebelumnya = $pil3['rasio_2bln_sebelumnya'];
        $osc_1bln_sebelumnya = $pil3['osc_1bln_sebelumnya'];
        $noa_1bln_sebelumnya = $pil3['noa_1bln_sebelumnya'];
        $npl_1bln_sebelumnya = $pil3['npl_1bln_sebelumnya'];
        $noa_npl_2bln_sebelumnya = $pil3['noa_npl_2bln_sebelumnya'];
        $rasio_npl_2bln_sebelumnya = $pil3['rasio_npl_2bln_sebelumnya'];
        $rasio_1bln_sebelumnya = $pil3['rasio_1bln_sebelumnya'];
        $osc_bln_penilaian = $pil3['osc_bln_penilaian'];
        $noa_bln_penilaian = $pil3['noa_bln_penilaian'];
        $npl_bln_penilaian = $pil3['npl_bln_penilaian'];
        $rasio_bln_penilaian = $pil3['rasio_bln_penilaian'];
        $aba = $pil3['aba'];
        $aba_tertinggi = $pil3['aba_tertinggi'];
        $aba_bank_umum = $pil3['aba_bank_umum'];
        $aba_bpr = $pil3['aba_bpr'];
        $noa_npl_1bln_sebelumnya = $pil3['noa_npl_1bln_sebelumnya'];
        $rasio_npl_1bln_sebelumnya = $pil3['rasio_npl_1bln_sebelumnya'];
        $noa_npl_bln_penilaian = $pil3['noa_npl_bln_penilaian'];
        $rasio_npl_bln_penilaian = $pil3['rasio_npl_bln_penilaian'];
        

    $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ", [$lokasi_kerja, $tahun, $user, $periode]);
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {
        simpro_db_query($conn, "INSERT INTO frame_laporan_profil_risiko(id_profil_risiko,kantor_cabang,tahun,user,periode,modal_inti,total_aset,keterangan,dibuat_at,dibuat_by)
        VALUES ('0',?,?,?,?,?,?,?,?,?)", [$lokasi_kerja, $tahun, $user, $periode, $modal_inti, $total_aset, $keterangan, $dibuat_at, $dibuat_by]);

        //kre
        simpro_db_query($conn, "
        INSERT INTO master_kredit_pilar1 (
            id_mk_pilar1, id_profil_risiko, dibuat_by, total_aset,
            aba, aset_produktif, kyd, noa_kyd, debitur_inti25,
            kredit_3sektor_ekonomi_terbesar, kredit_spg, kredit_pbta,
            kredit_jpendek, kredit_jmenengah, kredit_jpanjang,
            kredit_agunan_tb, kredit_agunan_kb, kredit_agunan_kr2,
            kredit_ta, kredit_kub, kredit_korporasi, kredit_pep,
            kredit_lebih350, kredit_joglo_mitra
        ) VALUES (
            '0',
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang=? AND tahun=? AND user=? AND periode=?),
            ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?
        )
        ", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $total_aset, $aba, $aset_produktif, $kyd, $noa_kyd, $debitur_inti25, $kredit_3sektor_ekonomi_terbesar, $kredit_spg, $kredit_pbta, $kredit_jpendek, $kredit_jmenengah, $kredit_jpanjang, $kredit_agunan_tb, $kredit_agunan_kb, $kredit_agunan_kr2, $kredit_ta, $kredit_kub, $kredit_korporasi, $kredit_pep, $kredit_lebih350, $kredit_joglo_mitra]);


        simpro_db_query($conn, "
        INSERT INTO master_kredit_pilar2 (
            id_mk_pilar2, id_profil_risiko, dibuat_by, modal_inti,
            aset_produktif_bermasalah, total_aset_produktif, kredit_bermasalah,
            noa_kredit_bermasalah, kredit_bermasalah_neto, saldo_ppap, ayda,
            kyd, macet_jatuh_tempo, kkr, kredit_par4, osc_bln_sebelumnya,
            osc_2bln_sebelumnya, kredit_dp, noa_fpd_6bln, noa_ekspansi_6bln,
            nominal_fpd_6bln, plafond_ekspansi_6bln, npl_kredit_sd150,
            kyd_plafon_sd150, noa_kredit_sd150, npl_kredit_diatas50,
            kyd_plafon_diatas50, npl_apht, kyd_apht, npl_skmht, kyd_skmht,
            npl_agunan_lrd_bakidebet, kredit_agunan_lrd_bakidebet
        ) VALUES (
            '0',
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang=? AND tahun=? AND user=? AND periode=?),
            ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?
        )
        ", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $modal_inti, $aset_produktif_bermasalah, $total_aset_produktif, $kredit_bermasalah, $noa_kredit_bermasalah, $kredit_bermasalah_neto, $saldo_ppap, $ayda, $kyd, $macet_jatuh_tempo, $kkr, $kredit_par4, $osc_bln_sebelumnya, $osc_2bln_sebelumnya, $kredit_dp, $noa_fpd_6bln, $noa_ekspansi_6bln, $nominal_fpd_6bln, $plafond_ekspansi_6bln, $npl_kredit_sd150, $kyd_plafon_sd150, $noa_kredit_sd150, $npl_kredit_diatas50, $kyd_plafon_diatas50, $npl_apht, $kyd_apht, $npl_skmht, $kyd_skmht, $npl_agunan_lrd_bakidebet, $kredit_agunan_lrd_bakidebet]);

        simpro_db_query($conn, "
        INSERT INTO master_kredit_pilar3 (
            id_mk_pilar3, id_profil_risiko, dibuat_by,
            osc_akhir_tahun_lalu, noa_osc_akhir_tahun_lalu, npl_akhir_tahun_lalu,
            noa_npl_akhir_tahun_lalu, osc_per_bln_penilaian, pertumbuhan_rata2_bpr_thn_lalu,
            pertumbuhan_rata2_bpr, pertumbuhan_kyd_bpr, rasio_pertumbuhan_rata2_bpr,
            td_pp_l, td_pp_dp, td_pp_kl, td_pp_d, td_pp_m,
            td_pp_l_noa, td_pp_dp_noa, td_pp_kl_noa, td_pp_d_noa, td_pp_m_noa,
            td_ps_l, td_ps_dp, td_ps_kl, td_ps_d, td_ps_m,
            td_ps_l_noa, td_ps_dp_noa, td_ps_kl_noa, td_ps_d_noa, td_ps_m_noa,
            d_pp_l, d_pp_dp, d_pp_kl, d_pp_d, d_pp_m,
            d_pp_l_noa, d_pp_dp_noa, d_pp_kl_noa, d_pp_d_noa, d_pp_m_noa,
            d_ps_l, d_ps_dp, d_ps_kl, d_ps_d, d_ps_m,
            d_ps_l_noa, d_ps_dp_noa, d_ps_kl_noa, d_ps_d_noa, d_ps_m_noa,
            osc_2bln_sebelumnya, noa_2bln_sebelumnya, npl_2bln_sebelumnya, rasio_2bln_sebelumnya,
            osc_1bln_sebelumnya, noa_1bln_sebelumnya, npl_1bln_sebelumnya,
            noa_npl_2bln_sebelumnya, rasio_npl_2bln_sebelumnya, rasio_1bln_sebelumnya,
            osc_bln_penilaian, noa_bln_penilaian, npl_bln_penilaian, rasio_bln_penilaian,
            aba, aba_tertinggi, aba_bank_umum, aba_bpr,
            noa_npl_1bln_sebelumnya, rasio_npl_1bln_sebelumnya,
            noa_npl_bln_penilaian, rasio_npl_bln_penilaian
        ) VALUES (
            '0',
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang=? AND tahun=? AND user=? AND periode=?),
            ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?,
            ?, ?
        )
        ", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $osc_akhir_tahun_lalu, $noa_osc_akhir_tahun_lalu, $npl_akhir_tahun_lalu, $noa_npl_akhir_tahun_lalu, $osc_per_bln_penilaian, $pertumbuhan_rata2_bpr_thn_lalu, $pertumbuhan_rata2_bpr, $pertumbuhan_kyd_bpr, $rasio_pertumbuhan_rata2_bpr, $td_pp_l, $td_pp_dp, $td_pp_kl, $td_pp_d, $td_pp_m, $td_pp_l_noa, $td_pp_dp_noa, $td_pp_kl_noa, $td_pp_d_noa, $td_pp_m_noa, $td_ps_l, $td_ps_dp, $td_ps_kl, $td_ps_d, $td_ps_m, $td_ps_l_noa, $td_ps_dp_noa, $td_ps_kl_noa, $td_ps_d_noa, $td_ps_m_noa, $d_pp_l, $d_pp_dp, $d_pp_kl, $d_pp_d, $d_pp_m, $d_pp_l_noa, $d_pp_dp_noa, $d_pp_kl_noa, $d_pp_d_noa, $d_pp_m_noa, $d_ps_l, $d_ps_dp, $d_ps_kl, $d_ps_d, $d_ps_m, $d_ps_l_noa, $d_ps_dp_noa, $d_ps_kl_noa, $d_ps_d_noa, $d_ps_m_noa, $osc_2bln_sebelumnya, $noa_2bln_sebelumnya, $npl_2bln_sebelumnya, $rasio_2bln_sebelumnya, $osc_1bln_sebelumnya, $noa_1bln_sebelumnya, $npl_1bln_sebelumnya, $noa_npl_2bln_sebelumnya, $rasio_npl_2bln_sebelumnya, $rasio_1bln_sebelumnya, $osc_bln_penilaian, $noa_bln_penilaian, $npl_bln_penilaian, $rasio_bln_penilaian, $aba, $aba_tertinggi, $aba_bank_umum, $aba_bpr, $noa_npl_1bln_sebelumnya, $rasio_npl_1bln_sebelumnya, $noa_npl_bln_penilaian, $rasio_npl_bln_penilaian]);



        simpro_db_query($conn, "INSERT INTO inheren_kredit_pilar1(id_inheren_kredit_pilar1,id_profil_risiko,dibuat_by,pilar1_3,pilar1_4)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?
        ,?
        ,?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $kredit_pilar1_3, $kredit_pilar1_4]);
        
        simpro_db_query($conn, "INSERT INTO inheren_kredit_pilar2(id_inheren_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO inheren_kredit_pilar3(id_inheren_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO inheren_kredit_pilar4(id_inheren_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_kredit_lainnya(id_inheren_kredit_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO hasil_inheren_kredit(id_hasil_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        

        simpro_db_query($conn, "INSERT INTO kpmr_kredit_pilar1(id_kpmr_kredit_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kredit_pilar2(id_kpmr_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kredit_pilar3(id_kpmr_kredit_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kredit_pilar4(id_kpmr_kredit_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO hasil_kpmr_kredit(id_hasil_kpmr_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil1(id_respon_kredit_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil2(id_respon_kredit_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil3(id_respon_kredit_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil4(id_respon_kredit_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        

        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_kredit(id_kpmr2_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO keterangan_inheren_kredit(id_keterangan_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO keterangan_profil_kredit(id_ket_profil_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        



        //op
        simpro_db_query($conn, "INSERT INTO inheren_operasional_pilar1(id_inheren_operasional_pilar1,id_profil_risiko,dibuat_by,
        pilar1_1,
        pilar1_2,
        pilar1_2a,
        pilar1_2b,
        pilar1_3,
        pilar1_3a,
        pilar1_3b,
        pilar1_3c,
        pilar1_4,
        pilar1_4a,
        average_pil1_1,
        average_pil1_2,
        average_pil1_3,
        average_pil1_4,
        min_pil1_1,
        min_pil1_2,
        min_pil1_3,
        min_pil1_4,
        max_pil1_1,
        max_pil1_2,
        max_pil1_3,
        max_pil1_4,
        hasil_pil1_par1,
        hasil_pil1_par2,
        hasil_pil1_par3,
        hasil_pil1_par4)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar1_1, $ops_pilar1_2, $ops_pilar1_2a, $ops_pilar1_2b, $ops_pilar1_3, $ops_pilar1_3a, $ops_pilar1_3b, $ops_pilar1_3c, $ops_pilar1_4, $ops_pilar1_4a, $ops_average_pil1_1, $ops_average_pil1_2, $ops_average_pil1_3, $ops_average_pil1_4, $ops_min_pil1_1, $ops_min_pil1_2, $ops_min_pil1_3, $ops_min_pil1_4, $ops_max_pil1_1, $ops_max_pil1_2, $ops_max_pil1_3, $ops_max_pil1_4, $ops_hasil_pil1_par1, $ops_hasil_pil1_par2, $ops_hasil_pil1_par3, $ops_hasil_pil1_par4]);
        
        simpro_db_query($conn, "INSERT INTO inheren_operasional_pilar2(id_inheren_operasional_pilar2,id_profil_risiko,dibuat_by,
        pilar2_1,
        pilar2_1a,
        pilar2_1b,
        pilar2_1c,
        pilar2_1d,
        pilar2_1e,
        pilar2_1f,
        pilar2_1g,
        pilar2_1h,
        pilar2_1i,
        pilar2_1j,
        pilar2_1k,
        pilar2_1l,
        pilar2_1m,
        pilar2_1n,
        pilar2_2,
        average_pil2_1,
        average_pil2_2,
        min_pil2_1,
        min_pil2_2,
        max_pil2_1,
        max_pil2_2,
        hasil_pil2_par1,
        hasil_pil2_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar2_1, $ops_pilar2_1a, $ops_pilar2_1b, $ops_pilar2_1c, $ops_pilar2_1d, $ops_pilar2_1e, $ops_pilar2_1f, $ops_pilar2_1g, $ops_pilar2_1h, $ops_pilar2_1i, $ops_pilar2_1j, $ops_pilar2_1k, $ops_pilar2_1l, $ops_pilar2_1m, $ops_pilar2_1n, $ops_pilar2_2, $ops_average_pil2_1, $ops_average_pil2_2, $ops_min_pil2_1, $ops_min_pil2_2, $ops_max_pil2_1, $ops_max_pil2_2, $ops_hasil_pil2_par1, $ops_hasil_pil2_par2]);
        
        simpro_db_query($conn, "INSERT INTO inheren_operasional_pilar3(id_inheren_operasional_pilar3,id_profil_risiko,dibuat_by,
        pilar3_1,
        pilar3_1a,
        pilar3_1b,
        pilar3_1c,
        pilar3_1d,
        pilar3_1e,
        pilar3_1f,
        pilar3_1g,
        pilar3_1h,
        pilar3_1i,
        pilar3_1j,
        pilar3_1k,
        pilar3_1l,
        pilar3_1m,
        pilar3_1n,
        pilar3_1o,
        pilar3_1p,
        average_pil3_1,
        min_pil3_1,
        max_pil3_1,
        hasil_pil3_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar3_1, $ops_pilar3_1a, $ops_pilar3_1b, $ops_pilar3_1c, $ops_pilar3_1d, $ops_pilar3_1e, $ops_pilar3_1f, $ops_pilar3_1g, $ops_pilar3_1h, $ops_pilar3_1i, $ops_pilar3_1j, $ops_pilar3_1k, $ops_pilar3_1l, $ops_pilar3_1m, $ops_pilar3_1n, $ops_pilar3_1o, $ops_pilar3_1p, $ops_average_pil3_1, $ops_min_pil3_1, $ops_max_pil3_1, $ops_hasil_pil3_par1]);
        
        simpro_db_query($conn, "INSERT INTO inheren_operasional_pilar4(id_inheren_operasional_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        average_pil4_1,
        min_pil4_1,
        max_pil4_1,
        hasil_pil4_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar4_1, $ops_pilar4_1a, $ops_pilar4_1b, $ops_pilar4_1c, $ops_pilar4_1d, $ops_average_pil4_1, $ops_min_pil4_1, $ops_max_pil4_1, $ops_hasil_pil4_par1]);
        
        simpro_db_query($conn, "INSERT INTO inheren_operasional_pilar5(id_inheren_operasional_pilar5,id_profil_risiko,dibuat_by,
        pilar5_1,
        pilar5_1a,
        pilar5_1b,
        pilar5_1c,
        pilar5_1d,
        pilar5_1e,
        pilar5_1f,
        average_pil5_1,
        min_pil5_1,
        max_pil5_1,
        hasil_pil5_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar5_1, $ops_pilar5_1a, $ops_pilar5_1b, $ops_pilar5_1c, $ops_pilar5_1d, $ops_pilar5_1e, $ops_pilar5_1f, $ops_average_pil5_1, $ops_min_pil5_1, $ops_max_pil5_1, $ops_hasil_pil5_par1]);

        simpro_db_query($conn, "INSERT INTO inheren_operasional_lainnya(id_inheren_operasional_lainnya,id_profil_risiko,dibuat_by,
        pilar6_1a,
        pilar6_1b,
        pilar6_1c,
        pilar6_1d,
        pilar6_1e,
        pilar6_1f,
        average_pil6_1,
        min_pil6_1,
        max_pil6_1,
        hasil_pil6_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ops_pilar6_1a, $ops_pilar6_1b, $ops_pilar6_1c, $ops_pilar6_1d, $ops_pilar6_1e, $ops_pilar6_1f, $ops_average_pil6_1, $ops_min_pil6_1, $ops_max_pil6_1, $ops_hasil_pil6_par1]);
        
        
        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_pilar1(id_ket_inheren_operasional_pilar1,id_profil_risiko,dibuat_by,
        ket_in_op_pil1_1,
        ket_in_op_pil1_2,
        ket_in_op_pil1_2a,
        ket_in_op_pil1_2b,
        ket_in_op_pil1_3,
        ket_in_op_pil1_3a,
        ket_in_op_pil1_3b,
        ket_in_op_pil1_3c,
        ket_in_op_pil1_4,
        ket_in_op_pil1_4a)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil1_1, $ket_in_op_pil1_2, $ket_in_op_pil1_2a, $ket_in_op_pil1_2b, $ket_in_op_pil1_3, $ket_in_op_pil1_3a, $ket_in_op_pil1_3b, $ket_in_op_pil1_3c, $ket_in_op_pil1_4, $ket_in_op_pil1_4a]);
        
        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_pilar2(id_ket_inheren_operasional_pilar2,id_profil_risiko,dibuat_by,
        ket_in_op_pil2_1,
        ket_in_op_pil2_1a,
        ket_in_op_pil2_1b,
        ket_in_op_pil2_1c,
        ket_in_op_pil2_1d,
        ket_in_op_pil2_1e,
        ket_in_op_pil2_1f,
        ket_in_op_pil2_1g,
        ket_in_op_pil2_1h,
        ket_in_op_pil2_1i,
        ket_in_op_pil2_1j,
        ket_in_op_pil2_1k,
        ket_in_op_pil2_1l,
        ket_in_op_pil2_1m,
        ket_in_op_pil2_1n,
        ket_in_op_pil2_2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil2_1, $ket_in_op_pil2_1a, $ket_in_op_pil2_1b, $ket_in_op_pil2_1c, $ket_in_op_pil2_1d, $ket_in_op_pil2_1e, $ket_in_op_pil2_1f, $ket_in_op_pil2_1g, $ket_in_op_pil2_1h, $ket_in_op_pil2_1i, $ket_in_op_pil2_1j, $ket_in_op_pil2_1k, $ket_in_op_pil2_1l, $ket_in_op_pil2_1m, $ket_in_op_pil2_1n, $ket_in_op_pil2_2]);
        
        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_pilar3(id_ket_inheren_operasional_pilar3,id_profil_risiko,dibuat_by,
        ket_in_op_pil3_1,
        ket_in_op_pil3_1a,
        ket_in_op_pil3_1b,
        ket_in_op_pil3_1c,
        ket_in_op_pil3_1d,
        ket_in_op_pil3_1e,
        ket_in_op_pil3_1f,
        ket_in_op_pil3_1g,
        ket_in_op_pil3_1h,
        ket_in_op_pil3_1i,
        ket_in_op_pil3_1j,
        ket_in_op_pil3_1k,
        ket_in_op_pil3_1l,
        ket_in_op_pil3_1m,
        ket_in_op_pil3_1n,
        ket_in_op_pil3_1o,
        ket_in_op_pil3_1p)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil3_1, $ket_in_op_pil3_1a, $ket_in_op_pil3_1b, $ket_in_op_pil3_1c, $ket_in_op_pil3_1d, $ket_in_op_pil3_1e, $ket_in_op_pil3_1f, $ket_in_op_pil3_1g, $ket_in_op_pil3_1h, $ket_in_op_pil3_1i, $ket_in_op_pil3_1j, $ket_in_op_pil3_1k, $ket_in_op_pil3_1l, $ket_in_op_pil3_1m, $ket_in_op_pil3_1n, $ket_in_op_pil3_1o, $ket_in_op_pil3_1p]);
        
        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_pilar4(id_ket_inheren_operasional_pilar4,id_profil_risiko,dibuat_by,
        ket_in_op_pil4_1,
        ket_in_op_pil4_1a,
        ket_in_op_pil4_1b,
        ket_in_op_pil4_1c,
        ket_in_op_pil4_1d)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil4_1, $ket_in_op_pil4_1a, $ket_in_op_pil4_1b, $ket_in_op_pil4_1c, $ket_in_op_pil4_1d]);
        
        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_pilar5(id_ket_inheren_operasional_pilar5,id_profil_risiko,dibuat_by,
        ket_in_op_pil5_1,
        ket_in_op_pil5_1a,
        ket_in_op_pil5_1b,
        ket_in_op_pil5_1c,
        ket_in_op_pil5_1d,
        ket_in_op_pil5_1e,
        ket_in_op_pil5_1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil5_1, $ket_in_op_pil5_1a, $ket_in_op_pil5_1b, $ket_in_op_pil5_1c, $ket_in_op_pil5_1d, $ket_in_op_pil5_1e, $ket_in_op_pil5_1f]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_operasional_lainnya(id_ket_inheren_operasional_lainnya,id_profil_risiko,dibuat_by,
        ket_in_op_pil6_1a,
        ket_in_op_pil6_1b,
        ket_in_op_pil6_1c,
        ket_in_op_pil6_1d,
        ket_in_op_pil6_1e,
        ket_in_op_pil6_1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $ket_in_op_pil6_1a, $ket_in_op_pil6_1b, $ket_in_op_pil6_1c, $ket_in_op_pil6_1d, $ket_in_op_pil6_1e, $ket_in_op_pil6_1f]);
    

        simpro_db_query($conn, "INSERT INTO kpmr_operasional_pilar1(id_kpmr_operasional_pilar1,id_profil_risiko,dibuat_by,
        pilar1_1a,
        pilar1_1b,
        pilar1_1c,
        pilar1_1d,
        pilar1_1e,
        pil1_total1,
        pil1_peringkat1,
        pilar1_2a,
        pilar1_2b,
        pilar1_2c,
        pilar1_2d,
        pilar1_2e,
        pil1_total2,
        pil1_peringkat2,
        pilar1_3a,
        pilar1_3b,
        pilar1_3c,
        pil1_total3,
        pil1_peringkat3,
        pilar1_4a,
        pilar1_4b,
        pilar1_4c,
        pilar1_4d,
        pilar1_4e,
        pil1_total4,
        pil1_peringkat4,
        pilar1_5a,
        pilar1_5b,
        pilar1_5c,
        pilar1_5d,
        pil1_total5,
        pil1_peringkat5,
        pilar1_6a,
        pilar1_6b,
        pilar1_6c,
        pil1_total6,
        pil1_peringkat6)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $kpmr_ops_pilar1_1a, $kpmr_ops_pilar1_1b, $kpmr_ops_pilar1_1c, $kpmr_ops_pilar1_1d, $kpmr_ops_pilar1_1e, $kpmr_ops_pil1_total1, $kpmr_ops_pil1_peringkat1, $kpmr_ops_pilar1_2a, $kpmr_ops_pilar1_2b, $kpmr_ops_pilar1_2c, $kpmr_ops_pilar1_2d, $kpmr_ops_pilar1_2e, $kpmr_ops_pil1_total2, $kpmr_ops_pil1_peringkat2, $kpmr_ops_pilar1_3a, $kpmr_ops_pilar1_3b, $kpmr_ops_pilar1_3c, $kpmr_ops_pil1_total3, $kpmr_ops_pil1_peringkat3, $kpmr_ops_pilar1_4a, $kpmr_ops_pilar1_4b, $kpmr_ops_pilar1_4c, $kpmr_ops_pilar1_4d, $kpmr_ops_pilar1_4e, $kpmr_ops_pil1_total4, $kpmr_ops_pil1_peringkat4, $kpmr_ops_pilar1_5a, $kpmr_ops_pilar1_5b, $kpmr_ops_pilar1_5c, $kpmr_ops_pilar1_5d, $kpmr_ops_pil1_total5, $kpmr_ops_pil1_peringkat5, $kpmr_ops_pilar1_6a, $kpmr_ops_pilar1_6b, $kpmr_ops_pilar1_6c, $kpmr_ops_pil1_total6, $kpmr_ops_pil1_peringkat6]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_operasional_pilar2(id_kpmr_operasional_pilar2,id_profil_risiko,dibuat_by,
        pilar2_1a,
        pilar2_1b,
        pilar2_1c,
        pilar2_1d,
        pilar2_1e,
        pil2_total1,
        pil2_peringkat1,
        pilar2_2a,
        pilar2_2b,
        pilar2_2c,
        pilar2_2d,
        pilar2_2e,
        pilar2_2f,
        pilar2_2g,
        pilar2_2h,
        pil2_total2,
        pil2_peringkat2,
        pilar2_3a,
        pilar2_3b,
        pilar2_3c,
        pil2_total3,
pil2_peringkat3)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?,
        ?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $kpmr_ops_pilar2_1a, $kpmr_ops_pilar2_1b, $kpmr_ops_pilar2_1c, $kpmr_ops_pilar2_1d, $kpmr_ops_pilar2_1e, $kpmr_ops_pil2_total1, $kpmr_ops_pil2_peringkat1, $kpmr_ops_pilar2_2a, $kpmr_ops_pilar2_2b, $kpmr_ops_pilar2_2c, $kpmr_ops_pilar2_2d, $kpmr_ops_pilar2_2e, $kpmr_ops_pilar2_2f, $kpmr_ops_pilar2_2g, $kpmr_ops_pilar2_2h, $kpmr_ops_pil2_total2, $kpmr_ops_pil2_peringkat2, $kpmr_ops_pilar2_3a, $kpmr_ops_pilar2_3b, $kpmr_ops_pilar2_3c, $kpmr_ops_pil2_total3, $kpmr_ops_pil2_peringkat3]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_operasional_pilar3(id_kpmr_operasional_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_operasional_pilar4(id_kpmr_operasional_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
    
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil1(id_respon_operasional_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil2(id_respon_operasional_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil3(id_respon_operasional_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil4(id_respon_operasional_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        




        simpro_db_query($conn, "INSERT INTO hasil_inheren_operasional(id_hasil_inheren_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO hasil_kpmr_operasional(id_hasil_kpmr_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO keterangan_inheren2_operasional(id_keterangan_inheren2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_operasional(id_kpmr2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_profil_operasional(id_ket_profil_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        


        //kep
        simpro_db_query($conn, "INSERT INTO inheren_kepatuhan_pilar1(id_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_kepatuhan_pilar2(id_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_kepatuhan_lainnya(id_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        simpro_db_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar1(id_ket_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar2(id_ket_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_kepatuhan_lainnya(id_ket_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        simpro_db_query($conn, "INSERT INTO kpmr_kepatuhan_pilar1(id_kpmr_kepatuhan_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kepatuhan_pilar2(id_kpmr_kepatuhan_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kepatuhan_pilar3(id_kpmr_kepatuhan_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_kepatuhan_pilar4(id_kpmr_kepatuhan_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
    

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil1(id_respon_kepatuhan_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil2(id_respon_kepatuhan_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil3(id_respon_kepatuhan_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil4(id_respon_kepatuhan_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        


        simpro_db_query($conn, "INSERT INTO hasil_inheren_kepatuhan(id_hasil_inheren_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO hasil_kpmr_kepatuhan(id_hasil_kpmr_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_inheren2_kepatuhan(id_keterangan_inheren2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_kepatuhan(id_kpmr2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_profil_kepatuhan(id_ket_profil_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        //lik
        simpro_db_query($conn, "
        INSERT INTO master_likuiditas_pilar1 (
            id_ml_pilar1, id_profil_risiko, dibuat_by,
            aset_likuid, kas, giro_aba, tabungan_aba, total_aset,
            kewajiban_lancar, kewajiban_segera, tabungan, deposito, pendanaan_jangka_pendek,
            kewajiban_jangka_pendek, deposito_1bln, deposito_3bln, deposito_6bln, deposito_12bln,
            pendanaan_non_inti, dpk_lbh_2m, deposito_diatas_cr, deposito_diatas_lps, korporasi,
            dpk_des_thn_sebelum, alat_likuid, penempatan_pd_bank_lain, modal_disetor,
            kredit_des_thn_sebelum, pinjaman, kredit_kolek_lancar, pertumbuhan_kredit,
            dpk_dijamin_lps, simpanan_tdk_dijamin_lps, total_dpk, dpk_tdk_dijamin_lps,
            deposan_tabungan_terbesar25, besar_deposan25, besar_penabung25, deposito_rs,
            arus_kas_netto, kas_besar_debet, kas_besar_kredit, deposito_inti,
            sisa_jangka_waktu_deposito, kredit_l_dp
        ) VALUES (
            '0',
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko 
                WHERE kantor_cabang = ? 
                AND tahun = ? 
                AND user = ? 
                AND periode = ?),
            ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?
        )
    ", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by, $aset_likuid, $kas, $giro_aba, $tabungan_aba, $total_aset, $kewajiban_lancar, $kewajiban_segera, $tabungan, $deposito, $pendanaan_jangka_pendek, $kewajiban_jangka_pendek, $deposito_1bln, $deposito_3bln, $deposito_6bln, $deposito_12bln, $pendanaan_non_inti, $dpk_lbh_2m, $deposito_diatas_cr, $deposito_diatas_lps, $korporasi, $dpk_des_thn_sebelum, $alat_likuid, $penempatan_pd_bank_lain, $modal_disetor, $kredit_des_thn_sebelum, $pinjaman, $kredit_kolek_lancar, $pertumbuhan_kredit, $dpk_dijamin_lps, $simpanan_tdk_dijamin_lps, $total_dpk, $dpk_tdk_dijamin_lps, $deposan_tabungan_terbesar25, $besar_deposan25, $besar_penabung25, $deposito_rs, $arus_kas_netto, $kas_besar_debet, $kas_besar_kredit, $deposito_inti, $sisa_jangka_waktu_deposito, $kredit_l_dp]);
    
        simpro_db_query($conn, "INSERT INTO inheren_likuiditas_pilar1(id_inheren_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO inheren_likuiditas_pilar2(id_inheren_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO inheren_likuiditas_lainnya(id_inheren_likuiditas_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO hasil_inheren_likuiditas(id_hasil_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO keterangan_inheren_likuiditas(id_keterangan_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        


       
        simpro_db_query($conn, "INSERT INTO kpmr_likuiditas_pilar1(id_kpmr_likuiditas_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_likuiditas_pilar2(id_kpmr_likuiditas_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_likuiditas_pilar3(id_kpmr_likuiditas_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_likuiditas_pilar4(id_kpmr_likuiditas_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
    

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil1(id_respon_likuiditas_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil2(id_respon_likuiditas_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil3(id_respon_likuiditas_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil4(id_respon_likuiditas_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        


       
        simpro_db_query($conn, "INSERT INTO hasil_kpmr_likuiditas(id_hasil_kpmr_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

      
        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_likuiditas(id_kpmr2_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_profil_likuiditas(id_ket_profil_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);





        //rep
        simpro_db_query($conn, "INSERT INTO inheren_reputasi_pilar1(id_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_reputasi_pilar2(id_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_reputasi_pilar3(id_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_reputasi_lainnya(id_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        simpro_db_query($conn, "INSERT INTO ket_inheren_reputasi_pilar1(id_ket_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_reputasi_pilar2(id_ket_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_reputasi_pilar3(id_ket_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_reputasi_lainnya(id_ket_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);



        simpro_db_query($conn, "INSERT INTO kpmr_reputasi_pilar1(id_kpmr_reputasi_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_reputasi_pilar2(id_kpmr_reputasi_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_reputasi_pilar3(id_kpmr_reputasi_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO kpmr_reputasi_pilar4(id_kpmr_reputasi_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
    

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil1(id_respon_reputasi_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil2(id_respon_reputasi_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil3(id_respon_reputasi_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        
        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil4(id_respon_reputasi_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);
        



        simpro_db_query($conn, "INSERT INTO hasil_inheren_reputasi(id_hasil_inheren_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO hasil_kpmr_reputasi(id_hasil_kpmr_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_inheren2_reputasi(id_keterangan_inheren2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_reputasi(id_kpmr2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_profil_reputasi(id_ket_profil_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);



        //stra
        simpro_db_query($conn, "INSERT INTO inheren_stratejik_pilar1(id_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_stratejik_pilar2(id_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_stratejik_pilar3(id_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO inheren_stratejik_lainnya(id_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        simpro_db_query($conn, "INSERT INTO ket_inheren_stratejik_pilar1(id_ket_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_stratejik_pilar2(id_ket_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_stratejik_pilar3(id_ket_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ket_inheren_stratejik_lainnya(id_ket_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);



        simpro_db_query($conn, "INSERT INTO kpmr_stratejik_pilar1(id_kpmr_stratejik_pilar1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO kpmr_stratejik_pilar2(id_kpmr_stratejik_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO kpmr_stratejik_pilar3(id_kpmr_stratejik_pilar3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO kpmr_stratejik_pilar4(id_kpmr_stratejik_pilar4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);


        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil1(id_respon_stratejik_pil1,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil2(id_respon_stratejik_pil2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil3(id_respon_stratejik_pil3,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil4(id_respon_stratejik_pil4,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO hasil_inheren_stratejik(id_hasil_inheren_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO hasil_kpmr_stratejik(id_hasil_kpmr_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_inheren2_stratejik(id_keterangan_inheren2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_kpmr2_stratejik(id_kpmr2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO keterangan_profil_stratejik(id_ket_profil_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);




        simpro_db_query($conn, "INSERT INTO nilai_profil(id_nilai_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO peringkat_profil(id_peringkat_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun = ? AND user = ? AND periode = ? ),?)", [$lokasi_kerja, $tahun, $user, $periode, $dibuat_by]);

        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=rekap_divisi");
        exit();
    }
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Profil Risiko Divisi</a></li>
                                            <li class="breadcrumb-item active">Rekap Divisi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Profil Risiko Rekap All Divisi</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Profil Risiko Rekap All Divisi</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User

                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal">Tambah Laporan</button>
                            <div id="signup-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-body">

                                            <div class="text-center mt-2 mb-4">

                                                <h4><b>LAPORAN REKAP DIVISI</b></h4>

                                            </div>
                                            <form class="ps-3 pe-3" action="" method="POST" enctype="multipart/form-data">

                                                <div class="mb-3" style="pointer-events: none;">
                                                    <label for="kc" class="form-label">Kantor</label>
                                                    <select class="form-select mb-3" name="lokasi_kerja" id="kc" required="">
                                                        <?php
                                                        require dirname(__DIR__, 2).'/conn/conn.php';
                                                        $kode_kantor = $_SESSION['lokasi_kerja'];
                                                        $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang");
                                                        while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                            <option value="<?= $data['id_cabang'] ?>" <?= $data['id_cabang'] == $kode_kantor ? ' selected' : '' ?>><?= ucwords($data['cabang']) ?></option>
                                                        <?php
                                                        };
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                        <option value=" " selected> </option>
                                                        <option value="2024">2024</option>
                                                        <option value="2025">2025</option>
                                                        <option value="2026">2026</option>
                                                        <option value="2027">2027</option>
                                                        <option value="2028">2028</option>
                                                        <option value="2029">2029</option>
                                                        <option value="2030">2030</option>
                                                        <option value="2031">2031</option>
                                                        <option value="2032">2032</option>
                                                        <option value="2033">2033</option>
                                                        <option value="2034">2034</option>
                                                        <option value="2035">2035</option>
                                                        <option value="2036">2036</option>
                                                        <option value="2037">2037</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3" style="pointer-events: none;">
                                                    <label for="user" class="form-label">Jenis Profil Risiko</label>

                                                    <select class="form-select mb-3" name="user" id="user" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                require dirname(__DIR__, 2).'/conn/conn.php';
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_user_profil_risiko'] ?>" <?= $data['id_user_profil_risiko'] == 5 ? ' selected' : '' ?>><?= ucwords($data['tipe_user']) ?></option>
                                                                <?php
                                                                };
                                                                ?>
                                                    </select>

                                                </div>

                                                

                                                <div class="mb-3">
                                                    <label for="periode" class="form-label">Periode</label>
                                                    <select class="form-select mb-3" name="periode" id="periode" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                require dirname(__DIR__, 2).'/conn/conn.php';
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_periode'] ?>"><?= ucwords($data['periode_laporan']) ?></option>
                                                                <?php
                                                                };
                                                                ?>
                                                    </select>
                                                </div>

                                               
                                                


                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea type="text" name="keterangan" class="form-control" id="keterangan" required=""></textarea>
                                                </div>



                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                </div>

                                            </form>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <hr>
                            </hr>










                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                    <center>Kantor Cabang</center>
                                                </th>
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Jenis Profil Risiko</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>
                                                <th>
                                                    <center>Modal Inti</center>
                                                </th>
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Keterangan</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE frame_laporan_profil_risiko.kantor_cabang = ? AND user =5 order by id_profil_risiko desc", [$kode_kantor]);
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                    <center>
                                                            <a href="index.php?page=rekap_divisi&id=<?= $data['id_profil_risiko'] ?>">
                                                                <i>
                                                                    <input type="checkbox" form="my_form" id="selected_id" name="selected_id"
                                                                        <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled>
                                                                </i>
                                                                aktifkan
                                                            </a>
                                                            |

                                                        <a href="../admin/pembanding/cetak_laporan_final.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank">cetak</a>
                                                        |
                                                        <a href="index.php?page=delete_rekap_divisi&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');">
                                                            <i class="mdi mdi-delete"></i>hapus
                                                        </a>
                                                    </center>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= $data['cabang'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($data['modal_inti']) ?>
                                                    <td>
                                                        Rp. <?= rupiah($data['total_aset']) ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($data['keterangan']) ?>
                                                    </td>

                                                   





                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->

                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>
