<?php
//pembobotan
$pembobotan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bobot_kredit_per_parameter WHERE tahun = '$tahun'"));
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
    include "../conn/conn.php";
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
    
        'inheren_kepatuhan_pilar1'=> [135,143],
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
        'ket_inheren_reputasi_lainnya'=> [135,136,143],
    
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
    
        'kpmr_kepatuhan_pilar1'=> [135,136,143],
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

    // ============================
    // Fungsi ambil nilai & respon
    // ============================
    function getMaxValueWithRespon($data, $tableNilai, $fieldNilai, $tableRespon, $fieldRespon, $dibuat_by_list = []) {
        $maxValue = 0;
        $bestRespon = '';
        foreach ($dibuat_by_list as $by) {
            $val = $data[$tableNilai][$by][$fieldNilai] ?? 0;
            if ($val > $maxValue) {
                $maxValue = $val;
                $bestRespon = $data[$tableRespon][$by][$fieldRespon] ?? '';
            }
        }
        return ['nilai' => $maxValue, 'respon' => $bestRespon];
    }

// ============================
// Fungsi khusus untuk Inheren
// ============================
function getMaxInherenWithKet($data, $tableNilai, $fieldNilai, $tableKet, $fieldKet, $dibuat_by_list = []) {
    $maxValue = 0;
    $bestKet = '';
    foreach ($dibuat_by_list as $by) {
        $val = $data[$tableNilai][$by][$fieldNilai] ?? 0;
        if ($val > $maxValue) {
            $maxValue = $val;
            $bestKet = $data[$tableKet][$by][$fieldKet] ?? '';
        }
    }
    return ['nilai' => $maxValue, 'ket' => $bestKet];
}
    // ============================
    // Pemanggilan semua pilar
    // ============================
    
    // Cara akses spesifik
    $kredit_pilar1_3 = $data['inheren_kredit_pilar1'][132]['pilar1_3'] ?? 0;
    $kredit_pilar1_4 = $data['inheren_kredit_pilar1'][132]['pilar1_4'] ?? 0;

    $kredit_pilar3_1         = $data['inheren_kredit_pilar3'][132]['pilar3_1'] ?? 0;
    $kredit_pilar3_1a        = $data['inheren_kredit_pilar3'][132]['pilar3_1a'] ?? 0;
    $kredit_pilar3_1b        = $data['inheren_kredit_pilar3'][132]['pilar3_1b'] ?? 0;
    $kredit_pilar3_1c        = $data['inheren_kredit_pilar3'][132]['pilar3_1c'] ?? 0;
    $kredit_pilar3_1d        = $data['inheren_kredit_pilar3'][132]['pilar3_1d'] ?? 0;
    $kredit_pilar3_1e        = $data['inheren_kredit_pilar3'][132]['pilar3_1e'] ?? 0;
    $kredit_hasil_pil3_par1  = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1'] ?? 0;
    $kredit_hasil_pil3_par1a = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1a'] ?? 0;
    $kredit_hasil_pil3_par1b = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1b'] ?? 0;
    $kredit_hasil_pil3_par1c = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1c'] ?? 0;
    $kredit_hasil_pil3_par1d = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1d'] ?? 0;
    $kredit_hasil_pil3_par1e = $data['inheren_kredit_pilar3'][132]['hasil_pil3_par1e'] ?? 0;

    $kredit_pilar4_1a       = $data['inheren_kredit_pilar4'][132]['pilar4_1a'] ?? 0;
    $kredit_pilar4_1b       = $data['inheren_kredit_pilar4'][132]['pilar4_1b'] ?? 0;
    $kredit_pilar4_1c       = $data['inheren_kredit_pilar4'][132]['pilar4_1c'] ?? 0;
    $kredit_pilar4_1d       = $data['inheren_kredit_pilar4'][132]['pilar4_1d'] ?? 0;
    $kredit_hasil_pil4_par1  = $data['inheren_kredit_pilar4'][132]['hasil_pil4_par1'] ?? 0;
    $kredit_hasil_pil4_par1a = $data['inheren_kredit_pilar4'][132]['hasil_pil4_par1a'] ?? 0;
    $kredit_hasil_pil4_par1b = $data['inheren_kredit_pilar4'][132]['hasil_pil4_par1b'] ?? 0;
    $kredit_hasil_pil4_par1c = $data['inheren_kredit_pilar4'][132]['hasil_pil4_par1c'] ?? 0;
    $kredit_hasil_pil4_par1d = $data['inheren_kredit_pilar4'][132]['hasil_pil4_par1d'] ?? 0;

    $kredit_pilar5_1a       = $data['inheren_kredit_lainnya'][132]['pilar5_1a'] ?? 0;
    $kredit_pilar5_1b       = $data['inheren_kredit_lainnya'][132]['pilar5_1b'] ?? 0;
    $kredit_pilar5_1c       = $data['inheren_kredit_lainnya'][132]['pilar5_1c'] ?? 0;
    $kredit_pilar5_1d       = $data['inheren_kredit_lainnya'][132]['pilar5_1d'] ?? 0;
    $kredit_pilar5_1e       = $data['inheren_kredit_lainnya'][132]['pilar5_1e'] ?? 0;
    $kredit_pilar5_1f       = $data['inheren_kredit_lainnya'][132]['pilar5_1f'] ?? 0;
    $kredit_pilar5_1g       = $data['inheren_kredit_lainnya'][132]['pilar5_1g'] ?? 0;
    $kredit_pilar5_1h       = $data['inheren_kredit_lainnya'][132]['pilar5_1h'] ?? 0;
    $kredit_pilar5_1i       = $data['inheren_kredit_lainnya'][132]['pilar5_1i'] ?? 0;
    $kredit_pilar5_1j       = $data['inheren_kredit_lainnya'][132]['pilar5_1j'] ?? 0;
    $kredit_pilar5_1k       = $data['inheren_kredit_lainnya'][132]['pilar5_1k'] ?? 0;
    $kredit_hasil_pil5_par1  = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1'] ?? 0;
    $kredit_hasil_pil5_par1a = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1a'] ?? 0;
    $kredit_hasil_pil5_par1b = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1b'] ?? 0;
    $kredit_hasil_pil5_par1c = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1c'] ?? 0;
    $kredit_hasil_pil5_par1d = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1d'] ?? 0;
    $kredit_hasil_pil5_par1e = $data['inheren_kredit_lainnya'][132]['hasil_pil5_par1e'] ?? 0;

    $kre_ket_pil1_1   = $data['keterangan_inheren_kredit'][132]['ket_pil1_1'] ?? '';
    $kre_ket_pil1_2   = $data['keterangan_inheren_kredit'][132]['ket_pil1_2'] ?? '';
    $kre_ket_pil1_3   = $data['keterangan_inheren_kredit'][132]['ket_pil1_3'] ?? '';
    $kre_ket_pil1_4   = $data['keterangan_inheren_kredit'][132]['ket_pil1_4'] ?? '';
    $kre_ket_pil1     = $data['keterangan_inheren_kredit'][132]['ket_pil1'] ?? '';
    $kre_ket_pil2_1   = $data['keterangan_inheren_kredit'][142]['ket_pil2_1'] ?? '';
    $kre_ket_pil2_2   = $data['keterangan_inheren_kredit'][142]['ket_pil2_2'] ?? '';
    $kre_ket_pil2_3   = $data['keterangan_inheren_kredit'][142]['ket_pil2_3'] ?? '';
    $kre_ket_pil2     = $data['keterangan_inheren_kredit'][132]['ket_pil2'] ?? '';
    $kre_ket_pil3_1   = $data['keterangan_inheren_kredit'][132]['ket_pil3_1'] ?? '';
    $kre_ket_pil3     = $data['keterangan_inheren_kredit'][132]['ket_pil3'] ?? '';
    $kre_ket_pil4_1   = $data['keterangan_inheren_kredit'][132]['ket_pil4_1'] ?? '';
    $kre_ket_pil4     = $data['keterangan_inheren_kredit'][132]['ket_pil4'] ?? '';
    $kre_ket_pil5_1   = $data['keterangan_inheren_kredit'][132]['ket_pil5_1'] ?? '';
    $kre_ket_pil5     = $data['keterangan_inheren_kredit'][132]['ket_pil5'] ?? '';
    $kre_ket_inheren  = $data['keterangan_inheren_kredit'][132]['ket_inheren'] ?? '';

    $kpmr_kre = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kredit WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_kre_pilar1_1a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_1a','respon_unit_kerja_kredit_pil1','respon_pil1_1a',[132,142]);
    $result_kpmr_kre_pilar1_1b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_1b','respon_unit_kerja_kredit_pil1','respon_pil1_1b',[132,142]);
    $result_kpmr_kre_pilar1_1c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_1c','respon_unit_kerja_kredit_pil1','respon_pil1_1c',[132,142]);
    $result_kpmr_kre_pilar1_1d = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_1d','respon_unit_kerja_kredit_pil1','respon_pil1_1d',[132,142]);
    $result_kpmr_kre_pilar1_1e = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_1e','respon_unit_kerja_kredit_pil1','respon_pil1_1e',[132,142]);
    
    $result_kpmr_kre_pilar1_2a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_2a','respon_unit_kerja_kredit_pil1','respon_pil1_2a',[132,142]);
    $result_kpmr_kre_pilar1_2b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_2b','respon_unit_kerja_kredit_pil1','respon_pil1_2b',[132,142]);
    $result_kpmr_kre_pilar1_2c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_2c','respon_unit_kerja_kredit_pil1','respon_pil1_2c',[132,142]);
    $result_kpmr_kre_pilar1_2d = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_2d','respon_unit_kerja_kredit_pil1','respon_pil1_2d',[132,142]);
    $result_kpmr_kre_pilar1_2e = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_2e','respon_unit_kerja_kredit_pil1','respon_pil1_2e',[132,142]);
    
    $result_kpmr_kre_pilar1_3a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_3a','respon_unit_kerja_kredit_pil1','respon_pil1_3a',[132,142]);
    $result_kpmr_kre_pilar1_3b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_3b','respon_unit_kerja_kredit_pil1','respon_pil1_3b',[132,142]);
    $result_kpmr_kre_pilar1_3c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_3c','respon_unit_kerja_kredit_pil1','respon_pil1_3c',[132,142]);
    
    $result_kpmr_kre_pilar1_4a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_4a','respon_unit_kerja_kredit_pil1','respon_pil1_4a',[132,142]);
    $result_kpmr_kre_pilar1_4b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_4b','respon_unit_kerja_kredit_pil1','respon_pil1_4b',[132,142]);
    $result_kpmr_kre_pilar1_4c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_4c','respon_unit_kerja_kredit_pil1','respon_pil1_4c',[132,142]);
    $result_kpmr_kre_pilar1_4d = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_4d','respon_unit_kerja_kredit_pil1','respon_pil1_4d',[132,142]);
    $result_kpmr_kre_pilar1_4e = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_4e','respon_unit_kerja_kredit_pil1','respon_pil1_4e',[132,142]);
    
    $result_kpmr_kre_pilar1_5a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_5a','respon_unit_kerja_kredit_pil1','respon_pil1_5a',[132,142]);
    $result_kpmr_kre_pilar1_5b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_5b','respon_unit_kerja_kredit_pil1','respon_pil1_5b',[132,142]);
    $result_kpmr_kre_pilar1_5c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_5c','respon_unit_kerja_kredit_pil1','respon_pil1_5c',[132,142]);
    $result_kpmr_kre_pilar1_5d = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_5d','respon_unit_kerja_kredit_pil1','respon_pil1_5d',[132,142]);
    
    $result_kpmr_kre_pilar1_6a = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_6a','respon_unit_kerja_kredit_pil1','respon_pil1_6a',[132,142]);
    $result_kpmr_kre_pilar1_6b = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_6b','respon_unit_kerja_kredit_pil1','respon_pil1_6b',[132,142]);
    $result_kpmr_kre_pilar1_6c = getMaxValueWithRespon($data,'kpmr_kredit_pilar1','pilar1_6c','respon_unit_kerja_kredit_pil1','respon_pil1_6c',[132,142]);
    

    $result_kpmr_kre_pilar2_1a = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_1a','respon_unit_kerja_kredit_pil2','respon_pil2_1a',[132,142]);
    $result_kpmr_kre_pilar2_1b = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_1b','respon_unit_kerja_kredit_pil2','respon_pil2_1b',[132,142]);
    $result_kpmr_kre_pilar2_1c = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_1c','respon_unit_kerja_kredit_pil2','respon_pil2_1c',[132,142]);
    $result_kpmr_kre_pilar2_1d = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_1d','respon_unit_kerja_kredit_pil2','respon_pil2_1d',[132,142]);
    $result_kpmr_kre_pilar2_1e = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_1e','respon_unit_kerja_kredit_pil2','respon_pil2_1e',[132,142]);

    $result_kpmr_kre_pilar2_2a = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2a','respon_unit_kerja_kredit_pil2','respon_pil2_2a',[132,142]);
    $result_kpmr_kre_pilar2_2b = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2b','respon_unit_kerja_kredit_pil2','respon_pil2_2b',[132,142]);
    $result_kpmr_kre_pilar2_2c = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2c','respon_unit_kerja_kredit_pil2','respon_pil2_2c',[132,142]);
    $result_kpmr_kre_pilar2_2d = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2d','respon_unit_kerja_kredit_pil2','respon_pil2_2d',[132,142]);
    $result_kpmr_kre_pilar2_2e = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2e','respon_unit_kerja_kredit_pil2','respon_pil2_2e',[132,142]);
    $result_kpmr_kre_pilar2_2f = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2f','respon_unit_kerja_kredit_pil2','respon_pil2_2f',[132,142]);
    $result_kpmr_kre_pilar2_2g = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2g','respon_unit_kerja_kredit_pil2','respon_pil2_2g',[132,142]);
    $result_kpmr_kre_pilar2_2h = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_2h','respon_unit_kerja_kredit_pil2','respon_pil2_2h',[132,142]);

    $result_kpmr_kre_pilar2_3a = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_3a','respon_unit_kerja_kredit_pil2','respon_pil2_3a',[132,142]);
    $result_kpmr_kre_pilar2_3b = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_3b','respon_unit_kerja_kredit_pil2','respon_pil2_3b',[132,142]);
    $result_kpmr_kre_pilar2_3c = getMaxValueWithRespon($data,'kpmr_kredit_pilar2','pilar2_3c','respon_unit_kerja_kredit_pil2','respon_pil2_3c',[132,142]);


    $result_kpmr_kre_pilar3_1a = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1a','respon_unit_kerja_kredit_pil3','respon_pil3_1a',[132,142]);
    $result_kpmr_kre_pilar3_1b = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1b','respon_unit_kerja_kredit_pil3','respon_pil3_1b',[132,142]);
    $result_kpmr_kre_pilar3_1c = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1c','respon_unit_kerja_kredit_pil3','respon_pil3_1c',[132,142]);
    $result_kpmr_kre_pilar3_1d = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1d','respon_unit_kerja_kredit_pil3','respon_pil3_1d',[132,142]);
    $result_kpmr_kre_pilar3_1e = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1e','respon_unit_kerja_kredit_pil3','respon_pil3_1e',[132,142]);
    $result_kpmr_kre_pilar3_1f = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1f','respon_unit_kerja_kredit_pil3','respon_pil3_1f',[132,142]);
    $result_kpmr_kre_pilar3_1g = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1g','respon_unit_kerja_kredit_pil3','respon_pil3_1g',[132,142]);
    $result_kpmr_kre_pilar3_1h = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1h','respon_unit_kerja_kredit_pil3','respon_pil3_1h',[132,142]);
    $result_kpmr_kre_pilar3_1i = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1i','respon_unit_kerja_kredit_pil3','respon_pil3_1i',[132,142]);
    $result_kpmr_kre_pilar3_1j = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_1j','respon_unit_kerja_kredit_pil3','respon_pil3_1j',[132,142]);

    $result_kpmr_kre_pilar3_2a = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_2a','respon_unit_kerja_kredit_pil3','respon_pil3_1a',[132,142]);
    $result_kpmr_kre_pilar3_2b = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_2b','respon_unit_kerja_kredit_pil3','respon_pil3_1b',[132,142]);
    $result_kpmr_kre_pilar3_2c = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_2c','respon_unit_kerja_kredit_pil3','respon_pil3_1c',[132,142]);
    $result_kpmr_kre_pilar3_2d = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_2d','respon_unit_kerja_kredit_pil3','respon_pil3_1d',[132,142]);
    $result_kpmr_kre_pilar3_2e = getMaxValueWithRespon($data,'kpmr_kredit_pilar3','pilar3_2e','respon_unit_kerja_kredit_pil3','respon_pil3_1e',[132,142]);



    //implemen

$kpmr_kre_pilar1_1a = $result_kpmr_kre_pilar1_1a['nilai']; $kpmr_kre_respon_pil1_1a = $result_kpmr_kre_pilar1_1a['respon'];
$kpmr_kre_pilar1_1b = $result_kpmr_kre_pilar1_1b['nilai']; $kpmr_kre_respon_pil1_1b = $result_kpmr_kre_pilar1_1b['respon'];
$kpmr_kre_pilar1_1c = $result_kpmr_kre_pilar1_1c['nilai']; $kpmr_kre_respon_pil1_1c = $result_kpmr_kre_pilar1_1c['respon'];
$kpmr_kre_pilar1_1d = $result_kpmr_kre_pilar1_1d['nilai']; $kpmr_kre_respon_pil1_1d = $result_kpmr_kre_pilar1_1d['respon'];
$kpmr_kre_pilar1_1e = $result_kpmr_kre_pilar1_1e['nilai']; $kpmr_kre_respon_pil1_1e = $result_kpmr_kre_pilar1_1e['respon'];



$kpmr_kre_pil1_total1_average = array($kpmr_kre_pilar1_1a,
$kpmr_kre_pilar1_1b,
$kpmr_kre_pilar1_1c,
$kpmr_kre_pilar1_1d,
$kpmr_kre_pilar1_1e);
        $kpmr_kre_pil1_total1_sum = array_sum($kpmr_kre_pil1_total1_average);
        $kpmr_kre_pil1_total1 = $kpmr_kre_pil1_total1_sum / count($kpmr_kre_pil1_total1_average);

if ($kpmr_kre_pil1_total1 < 1.00) {
    $kpmr_kre_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total1 >= 1.00 && $kpmr_kre_pil1_total1 < 1.25) {
    $kpmr_kre_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total1 >= 1.25 && $kpmr_kre_pil1_total1 < 2.25) {
    $kpmr_kre_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_kre_pil1_total1 >= 2.25 && $kpmr_kre_pil1_total1 < 3.25) {
    $kpmr_kre_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total1 >= 3.25 && $kpmr_kre_pil1_total1 < 4.25) {
    $kpmr_kre_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total1 >= 4.25 && $kpmr_kre_pil1_total1 <= 5.00) {
    $kpmr_kre_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_kre_pilar1_2a = $result_kpmr_kre_pilar1_2a['nilai']; $kpmr_kre_respon_pil1_2a = $result_kpmr_kre_pilar1_2a['respon'];
$kpmr_kre_pilar1_2b = $result_kpmr_kre_pilar1_2b['nilai']; $kpmr_kre_respon_pil1_2b = $result_kpmr_kre_pilar1_2b['respon'];
$kpmr_kre_pilar1_2c = $result_kpmr_kre_pilar1_2c['nilai']; $kpmr_kre_respon_pil1_2c = $result_kpmr_kre_pilar1_2c['respon'];
$kpmr_kre_pilar1_2d = $result_kpmr_kre_pilar1_2d['nilai']; $kpmr_kre_respon_pil1_2d = $result_kpmr_kre_pilar1_2d['respon'];
$kpmr_kre_pilar1_2e = $result_kpmr_kre_pilar1_2e['nilai']; $kpmr_kre_respon_pil1_2e = $result_kpmr_kre_pilar1_2e['respon'];


$kpmr_kre_pil1_total2_average = array($kpmr_kre_pilar1_2a,
$kpmr_kre_pilar1_2b,
$kpmr_kre_pilar1_2c,
$kpmr_kre_pilar1_2d,
$kpmr_kre_pilar1_2e);
$kpmr_kre_pil1_total2_sum = array_sum($kpmr_kre_pil1_total2_average);
$kpmr_kre_pil1_total2 = $kpmr_kre_pil1_total2_sum / count($kpmr_kre_pil1_total2_average);

if ($kpmr_kre_pil1_total2 < 1.00) {
    $kpmr_kre_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total2 >= 1.00 && $kpmr_kre_pil1_total2 < 1.25) {
    $kpmr_kre_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total2 >= 1.25 && $kpmr_kre_pil1_total2 < 2.25) {
    $kpmr_kre_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_kre_pil1_total2 >= 2.25 && $kpmr_kre_pil1_total2 < 3.25) {
    $kpmr_kre_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total2 >= 3.25 && $kpmr_kre_pil1_total2 < 4.25) {
    $kpmr_kre_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total2 >= 4.25 && $kpmr_kre_pil1_total2 <= 5.00) {
    $kpmr_kre_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_kre_pilar1_3a = $result_kpmr_kre_pilar1_3a['nilai']; $kpmr_kre_respon_pil1_3a = $result_kpmr_kre_pilar1_3a['respon'];
$kpmr_kre_pilar1_3b = $result_kpmr_kre_pilar1_3b['nilai']; $kpmr_kre_respon_pil1_3b = $result_kpmr_kre_pilar1_3b['respon'];
$kpmr_kre_pilar1_3c = $result_kpmr_kre_pilar1_3c['nilai']; $kpmr_kre_respon_pil1_3c = $result_kpmr_kre_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_kre_pil1_total3_average = array($kpmr_kre_pilar1_3a,
$kpmr_kre_pilar1_3b,
$kpmr_kre_pilar1_3c);
$kpmr_kre_pil1_total3_sum = array_sum($kpmr_kre_pil1_total3_average);
$kpmr_kre_pil1_total3 = $kpmr_kre_pil1_total3_sum / count($kpmr_kre_pil1_total3_average);

if ($kpmr_kre_pil1_total3 < 1.00) {
    $kpmr_kre_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total3 >= 1.00 && $kpmr_kre_pil1_total3 < 1.25) {
    $kpmr_kre_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total3 >= 1.25 && $kpmr_kre_pil1_total3 < 2.25) {
    $kpmr_kre_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_kre_pil1_total3 >= 2.25 && $kpmr_kre_pil1_total3 < 3.25) {
    $kpmr_kre_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total3 >= 3.25 && $kpmr_kre_pil1_total3 < 4.25) {
    $kpmr_kre_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total3 >= 4.25 && $kpmr_kre_pil1_total3 <= 5.00) {
    $kpmr_kre_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_kre_pilar1_4a = $result_kpmr_kre_pilar1_4a['nilai']; $kpmr_kre_respon_pil1_4a = $result_kpmr_kre_pilar1_4a['respon'];
$kpmr_kre_pilar1_4b = $result_kpmr_kre_pilar1_4b['nilai']; $kpmr_kre_respon_pil1_4b = $result_kpmr_kre_pilar1_4b['respon'];
$kpmr_kre_pilar1_4c = $result_kpmr_kre_pilar1_4c['nilai']; $kpmr_kre_respon_pil1_4c = $result_kpmr_kre_pilar1_4c['respon'];
$kpmr_kre_pilar1_4d = $result_kpmr_kre_pilar1_4d['nilai']; $kpmr_kre_respon_pil1_4d = $result_kpmr_kre_pilar1_4d['respon'];
$kpmr_kre_pilar1_4e = $result_kpmr_kre_pilar1_4e['nilai']; $kpmr_kre_respon_pil1_4e = $result_kpmr_kre_pilar1_4e['respon'];


$kpmr_kre_pil1_total4_average = array($kpmr_kre_pilar1_4a,
$kpmr_kre_pilar1_4b,
$kpmr_kre_pilar1_4c,
$kpmr_kre_pilar1_4d,
$kpmr_kre_pilar1_4e);
$kpmr_kre_pil1_total4_sum = array_sum($kpmr_kre_pil1_total4_average);
$kpmr_kre_pil1_total4 = $kpmr_kre_pil1_total4_sum / count($kpmr_kre_pil1_total4_average);

if ($kpmr_kre_pil1_total4 < 1.00) {
    $kpmr_kre_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total4 >= 1.00 && $kpmr_kre_pil1_total4 < 1.25) {
    $kpmr_kre_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total4 >= 1.25 && $kpmr_kre_pil1_total4 < 2.25) {
    $kpmr_kre_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_kre_pil1_total4 >= 2.25 && $kpmr_kre_pil1_total4 < 3.25) {
    $kpmr_kre_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total4 >= 3.25 && $kpmr_kre_pil1_total4 < 4.25) {
    $kpmr_kre_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total4 >= 4.25 && $kpmr_kre_pil1_total4 <= 5.00) {
    $kpmr_kre_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_kre_pilar1_5a = $result_kpmr_kre_pilar1_5a['nilai']; $kpmr_kre_respon_pil1_5a = $result_kpmr_kre_pilar1_5a['respon'];
$kpmr_kre_pilar1_5b = $result_kpmr_kre_pilar1_5b['nilai']; $kpmr_kre_respon_pil1_5b = $result_kpmr_kre_pilar1_5b['respon'];
$kpmr_kre_pilar1_5c = $result_kpmr_kre_pilar1_5c['nilai']; $kpmr_kre_respon_pil1_5c = $result_kpmr_kre_pilar1_5c['respon'];
$kpmr_kre_pilar1_5d = $result_kpmr_kre_pilar1_5d['nilai']; $kpmr_kre_respon_pil1_5d = $result_kpmr_kre_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_kre_pil1_total5_average = array($kpmr_kre_pilar1_5a,
$kpmr_kre_pilar1_5b,
$kpmr_kre_pilar1_5c,
$kpmr_kre_pilar1_5);
$kpmr_kre_pil1_total5_sum = array_sum($kpmr_kre_pil1_total5_average);
$kpmr_kre_pil1_total5 = $kpmr_kre_pil1_total5_sum / count($kpmr_kre_pil1_total5_average);

if ($kpmr_kre_pil1_total5 < 1.00) {
    $kpmr_kre_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total5 >= 1.00 && $kpmr_kre_pil1_total5 < 1.25) {
    $kpmr_kre_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total5 >= 1.25 && $kpmr_kre_pil1_total5 < 2.25) {
    $kpmr_kre_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_kre_pil1_total5 >= 2.25 && $kpmr_kre_pil1_total5 < 3.25) {
    $kpmr_kre_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total5 >= 3.25 && $kpmr_kre_pil1_total5 < 4.25) {
    $kpmr_kre_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total5 >= 4.25 && $kpmr_kre_pil1_total5 <= 5.00) {
    $kpmr_kre_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_kre_pilar1_6a = $result_kpmr_kre_pilar1_6a['nilai']; $kpmr_kre_respon_pil1_6a = $result_kpmr_kre_pilar1_6a['respon'];
$kpmr_kre_pilar1_6b = $result_kpmr_kre_pilar1_6b['nilai']; $kpmr_kre_respon_pil1_6b = $result_kpmr_kre_pilar1_6b['respon'];
$kpmr_kre_pilar1_6c = $result_kpmr_kre_pilar1_6c['nilai']; $kpmr_kre_respon_pil1_6c = $result_kpmr_kre_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_kre_pil1_total6_average = array($kpmr_kre_pilar1_6a,
$kpmr_kre_pilar1_6b,
$kpmr_kre_pilar1_6c);
$kpmr_kre_pil1_total6_sum = array_sum($kpmr_kre_pil1_total6_average);
$kpmr_kre_pil1_total6 = $kpmr_kre_pil1_total6_sum / count($kpmr_kre_pil1_total6_average);

if ($kpmr_kre_pil1_total6 < 1.00) {
    $kpmr_kre_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_kre_pil1_total6 >= 1.00 && $kpmr_kre_pil1_total6 < 1.25) {
    $kpmr_kre_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_kre_pil1_total6 >= 1.25 && $kpmr_kre_pil1_total6 < 2.25) {
    $kpmr_kre_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_kre_pil1_total6 >= 2.25 && $kpmr_kre_pil1_total6 < 3.25) {
    $kpmr_kre_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_kre_pil1_total6 >= 3.25 && $kpmr_kre_pil1_total6 < 4.25) {
    $kpmr_kre_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_kre_pil1_total6 >= 4.25 && $kpmr_kre_pil1_total6 <= 5.00) {
    $kpmr_kre_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_kre_pil1_peringkat6 = "Belum Terisi";
}


        
$kpmr_kre_pilar2_1a = $result_kpmr_kre_pilar2_1a['nilai']; $kpmr_kre_respon_pil2_1a = $result_kpmr_kre_pilar2_1a['respon'];
$kpmr_kre_pilar2_1b = $result_kpmr_kre_pilar2_1b['nilai']; $kpmr_kre_respon_pil2_1b = $result_kpmr_kre_pilar2_1b['respon'];
$kpmr_kre_pilar2_1c = $result_kpmr_kre_pilar2_1c['nilai']; $kpmr_kre_respon_pil2_1c = $result_kpmr_kre_pilar2_1c['respon'];
$kpmr_kre_pilar2_1d = $result_kpmr_kre_pilar2_1d['nilai']; $kpmr_kre_respon_pil2_1d = $result_kpmr_kre_pilar2_1d['respon'];
$kpmr_kre_pilar2_1e = $result_kpmr_kre_pilar2_1e['nilai']; $kpmr_kre_respon_pil2_1e = $result_kpmr_kre_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_kre_pil2_total1_average = array($kpmr_kre_pilar2_1a,
$kpmr_kre_pilar2_1b,
$kpmr_kre_pilar2_1c,
$kpmr_kre_pilar2_1d,
$kpmr_kre_pilar2_1e);
$kpmr_kre_pil2_total1_sum = array_sum($kpmr_kre_pil2_total1_average);
$kpmr_kre_pil2_total1 = $kpmr_kre_pil2_total1_sum / count($kpmr_kre_pil2_total1_average);

if ($kpmr_kre_pil2_total1 < 1.00) {
    $kpmr_kre_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kre_pil2_total1 >= 1.00 && $kpmr_kre_pil2_total1 < 1.25) {
    $kpmr_kre_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kre_pil2_total1 >= 1.25 && $kpmr_kre_pil2_total1 < 2.25) {
    $kpmr_kre_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_kre_pil2_total1 >= 2.25 && $kpmr_kre_pil2_total1 < 3.25) {
    $kpmr_kre_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kre_pil2_total1 >= 3.25 && $kpmr_kre_pil2_total1 < 4.25) {
    $kpmr_kre_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kre_pil2_total1 >= 4.25 && $kpmr_kre_pil2_total1 <= 5.00) {
    $kpmr_kre_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kre_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_kre_pilar2_2a = $result_kpmr_kre_pilar2_2a['nilai']; $kpmr_kre_respon_pil2_2a = $result_kpmr_kre_pilar2_2a['respon'];
$kpmr_kre_pilar2_2b = $result_kpmr_kre_pilar2_2b['nilai']; $kpmr_kre_respon_pil2_2b = $result_kpmr_kre_pilar2_2b['respon'];
$kpmr_kre_pilar2_2c = $result_kpmr_kre_pilar2_2c['nilai']; $kpmr_kre_respon_pil2_2c = $result_kpmr_kre_pilar2_2c['respon'];
$kpmr_kre_pilar2_2d = $result_kpmr_kre_pilar2_2d['nilai']; $kpmr_kre_respon_pil2_2d = $result_kpmr_kre_pilar2_2d['respon'];
$kpmr_kre_pilar2_2e = $result_kpmr_kre_pilar2_2e['nilai']; $kpmr_kre_respon_pil2_2e = $result_kpmr_kre_pilar2_2e['respon'];
$kpmr_kre_pilar2_2f = $result_kpmr_kre_pilar2_2f['nilai']; $kpmr_kre_respon_pil2_2f = $result_kpmr_kre_pilar2_2f['respon'];
$kpmr_kre_pilar2_2g = $result_kpmr_kre_pilar2_2g['nilai']; $kpmr_kre_respon_pil2_2g = $result_kpmr_kre_pilar2_2g['respon'];
$kpmr_kre_pilar2_2h = $result_kpmr_kre_pilar2_2h['nilai']; $kpmr_kre_respon_pil2_2h = $result_kpmr_kre_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_kre_pil2_total2_average = array($kpmr_kre_pilar2_2a,
$kpmr_kre_pilar2_2b,
$kpmr_kre_pilar2_2c,
$kpmr_kre_pilar2_2d,
$kpmr_kre_pilar2_2e,
$kpmr_kre_pilar2_2f,
$kpmr_kre_pilar2_2g,
$kpmr_kre_pilar2_2h);
$kpmr_kre_pil2_total2_sum = array_sum($kpmr_kre_pil2_total2_average);
$kpmr_kre_pil2_total2 = $kpmr_kre_pil2_total2_sum / count($kpmr_kre_pil2_total2_average);

if ($kpmr_kre_pil2_total2 < 1.00) {
    $kpmr_kre_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kre_pil2_total2 >= 1.00 && $kpmr_kre_pil2_total2 < 1.25) {
    $kpmr_kre_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kre_pil2_total2 >= 1.25 && $kpmr_kre_pil2_total2 < 2.25) {
    $kpmr_kre_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_kre_pil2_total2 >= 2.25 && $kpmr_kre_pil2_total2 < 3.25) {
    $kpmr_kre_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kre_pil2_total2 >= 3.25 && $kpmr_kre_pil2_total2 < 4.25) {
    $kpmr_kre_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kre_pil2_total2 >= 4.25 && $kpmr_kre_pil2_total2 <= 5.00) {
    $kpmr_kre_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kre_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_kre_pilar2_3a = $result_kpmr_kre_pilar2_3a['nilai']; $kpmr_kre_respon_pil2_3a = $result_kpmr_kre_pilar2_3a['respon'];
$kpmr_kre_pilar2_3b = $result_kpmr_kre_pilar2_3b['nilai']; $kpmr_kre_respon_pil2_3b = $result_kpmr_kre_pilar2_3b['respon'];
$kpmr_kre_pilar2_3c = $result_kpmr_kre_pilar2_3c['nilai']; $kpmr_kre_respon_pil2_3c = $result_kpmr_kre_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_kre_pil2_total3_average = array($kpmr_kre_pilar2_3a,
$kpmr_kre_pilar2_3b,
$kpmr_kre_pilar2_3c);
$kpmr_kre_pil2_total3_sum = array_sum($kpmr_kre_pil2_total3_average);
$kpmr_kre_pil2_total3 = $kpmr_kre_pil2_total3_sum / count($kpmr_kre_pil2_total3_average);

if ($kpmr_kre_pil2_total3 < 1.00) {
    $kpmr_kre_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_kre_pil2_total3 >= 1.00 && $kpmr_kre_pil2_total3 < 1.25) {
    $kpmr_kre_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_kre_pil2_total3 >= 1.25 && $kpmr_kre_pil2_total3 < 2.25) {
    $kpmr_kre_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_kre_pil2_total3 >= 2.25 && $kpmr_kre_pil2_total3 < 3.25) {
    $kpmr_kre_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_kre_pil2_total3 >= 3.25 && $kpmr_kre_pil2_total3 < 4.25) {
    $kpmr_kre_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_kre_pil2_total3 >= 4.25 && $kpmr_kre_pil2_total3 <= 5.00) {
    $kpmr_kre_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_kre_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_kre_pilar3_1a = $result_kpmr_kre_pilar3_1a['nilai']; $kpmr_kre_respon_pil3_1a = $result_kpmr_kre_pilar3_1a['respon'];
$kpmr_kre_pilar3_1b = $result_kpmr_kre_pilar3_1b['nilai']; $kpmr_kre_respon_pil3_1b = $result_kpmr_kre_pilar3_1b['respon'];
$kpmr_kre_pilar3_1c = $result_kpmr_kre_pilar3_1c['nilai']; $kpmr_kre_respon_pil3_1c = $result_kpmr_kre_pilar3_1c['respon'];
$kpmr_kre_pilar3_1d = $result_kpmr_kre_pilar3_1d['nilai']; $kpmr_kre_respon_pil3_1d = $result_kpmr_kre_pilar3_1d['respon'];
$kpmr_kre_pilar3_1e = $result_kpmr_kre_pilar3_1e['nilai']; $kpmr_kre_respon_pil3_1e = $result_kpmr_kre_pilar3_1e['respon'];
$kpmr_kre_pilar3_1f = $result_kpmr_kre_pilar3_1f['nilai']; $kpmr_kre_respon_pil3_1f = $result_kpmr_kre_pilar3_1f['respon'];
$kpmr_kre_pilar3_1g = $result_kpmr_kre_pilar3_1g['nilai']; $kpmr_kre_respon_pil3_1g = $result_kpmr_kre_pilar3_1g['respon'];
$kpmr_kre_pilar3_1h = $result_kpmr_kre_pilar3_1h['nilai']; $kpmr_kre_respon_pil3_1h = $result_kpmr_kre_pilar3_1h['respon'];
$kpmr_kre_pilar3_1i = $result_kpmr_kre_pilar3_1i['nilai']; $kpmr_kre_respon_pil3_1i = $result_kpmr_kre_pilar3_1i['respon'];
$kpmr_kre_pilar3_1j = $result_kpmr_kre_pilar3_1j['nilai']; $kpmr_kre_respon_pil3_1j = $result_kpmr_kre_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_kre_pil3_total1_average = array($kpmr_kre_pilar3_1a,
$kpmr_kre_pilar3_1b,
$kpmr_kre_pilar3_1c,
$kpmr_kre_pilar3_1d,
$kpmr_kre_pilar3_1e,
$kpmr_kre_pilar3_1f,
$kpmr_kre_pilar3_1g,
$kpmr_kre_pilar3_1h,
$kpmr_kre_pilar3_1i,
$kpmr_kre_pilar3_1j);
$kpmr_kre_pil3_total1_sum = array_sum($kpmr_kre_pil3_total1_average);
$kpmr_kre_pil3_total1 = $kpmr_kre_pil3_total1_sum / count($kpmr_kre_pil3_total1_average);

if ($kpmr_kre_pil3_total1 < 1.00) {
    $kpmr_kre_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kre_pil3_total1 >= 1.00 && $kpmr_kre_pil3_total1 < 1.25) {
    $kpmr_kre_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kre_pil3_total1 >= 1.25 && $kpmr_kre_pil3_total1 < 2.25) {
    $kpmr_kre_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_kre_pil3_total1 >= 2.25 && $kpmr_kre_pil3_total1 < 3.25) {
    $kpmr_kre_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kre_pil3_total1 >= 3.25 && $kpmr_kre_pil3_total1 < 4.25) {
    $kpmr_kre_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kre_pil3_total1 >= 4.25 && $kpmr_kre_pil3_total1 <= 5.00) {
    $kpmr_kre_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kre_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_kre_pilar3_2a = $result_kpmr_kre_pilar3_2a['nilai']; $kpmr_kre_respon_pil3_2a = $result_kpmr_kre_pilar3_2a['respon'];
$kpmr_kre_pilar3_2b = $result_kpmr_kre_pilar3_2b['nilai']; $kpmr_kre_respon_pil3_2b = $result_kpmr_kre_pilar3_2b['respon'];
$kpmr_kre_pilar3_2c = $result_kpmr_kre_pilar3_2c['nilai']; $kpmr_kre_respon_pil3_2c = $result_kpmr_kre_pilar3_2c['respon'];
$kpmr_kre_pilar3_2d = $result_kpmr_kre_pilar3_2d['nilai']; $kpmr_kre_respon_pil3_2d = $result_kpmr_kre_pilar3_2d['respon'];
$kpmr_kre_pilar3_2e = $result_kpmr_kre_pilar3_2e['nilai']; $kpmr_kre_respon_pil3_2e = $result_kpmr_kre_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_kre_pil3_total2_average = array($kpmr_kre_pilar3_2a,
$kpmr_kre_pilar3_2b,
$kpmr_kre_pilar3_2c,
$kpmr_kre_pilar3_2d,
$kpmr_kre_pilar3_2e);
$kpmr_kre_pil3_total2_sum = array_sum($kpmr_kre_pil3_total2_average);
$kpmr_kre_pil3_total2 = $kpmr_kre_pil3_total2_sum / count($kpmr_kre_pil3_total2_average);

if ($kpmr_kre_pil3_total2 < 1.00) {
    $kpmr_kre_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kre_pil3_total2 >= 1.00 && $kpmr_kre_pil3_total2 < 1.25) {
    $kpmr_kre_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kre_pil3_total2 >= 1.25 && $kpmr_kre_pil3_total2 < 2.25) {
    $kpmr_kre_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_kre_pil3_total2 >= 2.25 && $kpmr_kre_pil3_total2 < 3.25) {
    $kpmr_kre_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kre_pil3_total2 >= 3.25 && $kpmr_kre_pil3_total2 < 4.25) {
    $kpmr_kre_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kre_pil3_total2 >= 4.25 && $kpmr_kre_pil3_total2 <= 5.00) {
    $kpmr_kre_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kre_pil3_peringkat2 = "Belum Terisi";
}



    $kpmr_kre_pilar4_1a = $data['kpmr_kredit_pilar4'][143]['pilar4_1a'] ?? 0;
    $kpmr_kre_pilar4_1b = $data['kpmr_kredit_pilar4'][143]['pilar4_1b'] ?? 0;
    $kpmr_kre_pilar4_1c = $data['kpmr_kredit_pilar4'][143]['pilar4_1c'] ?? 0;
    $kpmr_kre_pilar4_1d = $data['kpmr_kredit_pilar4'][143]['pilar4_1d'] ?? 0;
    $kpmr_kre_pilar4_1e = $data['kpmr_kredit_pilar4'][143]['pilar4_1e'] ?? 0;
    $kpmr_kre_pil4_total1 = $data['kpmr_kredit_pilar4'][143]['pil4_total1'] ?? 0;
    $kpmr_kre_pil4_peringkat1 = $data['kpmr_kredit_pilar4'][143]['pil4_peringkat1'] ?? 0;
    $kpmr_kre_pilar4_2a = $data['kpmr_kredit_pilar4'][143]['pilar4_2a'] ?? 0;
    $kpmr_kre_pilar4_2b = $data['kpmr_kredit_pilar4'][143]['pilar4_2b'] ?? 0;
    $kpmr_kre_pil4_total2 = $data['kpmr_kredit_pilar4'][143]['pil4_total2'] ?? 0;
    $kpmr_kre_pil4_peringkat2 = $data['kpmr_kredit_pilar4'][143]['pil4_peringkat2'] ?? 0;

    $kpmr_kre_respon_pil4_1a = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_1a'] ?? 0;
    $kpmr_kre_respon_pil4_1b = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_1b'] ?? 0;
    $kpmr_kre_respon_pil4_1c = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_1c'] ?? 0;
    $kpmr_kre_respon_pil4_1d = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_1d'] ?? 0;
    $kpmr_kre_respon_pil4_1e = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_1e'] ?? 0;
    $kpmr_kre_respon_pil4_2a = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_2a'] ?? 0;
    $kpmr_kre_respon_pil4_2b = $data['respon_unit_kerja_kredit_pil4'][143]['respon_pil4_2b'] ?? 0;

//rumus KPMR kre
//setingan ditetapkan
$kpmr_kre = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kredit WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_kre_pil1 = $kpmr_kre['kpmr_kre_set_pil1'];
$set_kre_pil2 = $kpmr_kre['kpmr_kre_set_pil2'];
$set_kre_pil3 = $kpmr_kre['kpmr_kre_set_pil3'];
$set_kre_pil4 = $kpmr_kre['kpmr_kre_set_pil4'];
$set_kre_hsl = $kpmr_kre['kpmr_kre_set_tingkat_risiko'];



    if ($set_kre_pil1 == 1) {
        $numbers = array($kpmr_kre_pil1_total1 , $kpmr_kre_pil1_total2, $kpmr_kre_pil1_total3, $kpmr_kre_pil1_total4, $kpmr_kre_pil1_total5, $kpmr_kre_pil1_total6);
        $kpmr_kre_pil1_maxValue = max($numbers);
        $kpmr_kre_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil1_average = $sum / count($numbers);
        $kpmr_kre_pil1_tingkat_risiko = $kpmr_kre_pil1_maxValue ;
    } else if ($set_kre_pil1 == 2) {
        $numbers = array($kpmr_kre_pil1_total1 , $kpmr_kre_pil1_total2, $kpmr_kre_pil1_total3, $kpmr_kre_pil1_total4, $kpmr_kre_pil1_total5, $kpmr_kre_pil1_total6);
        $kpmr_kre_pil1_maxValue = max($numbers);
        $kpmr_kre_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil1_average = $sum / count($numbers);

        $kpmr_kre_pil1_tingkat_risiko = $kpmr_kre_pil1_minValue;
    } else if ($set_kre_pil1 == 3) {
        $numbers = array($kpmr_kre_pil1_total1 , $kpmr_kre_pil1_total2, $kpmr_kre_pil1_total3, $kpmr_kre_pil1_total4, $kpmr_kre_pil1_total5, $kpmr_kre_pil1_total6);
        $kpmr_kre_pil1_maxValue = max($numbers);
        $kpmr_kre_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil1_average = $sum / count($numbers);

        $kpmr_kre_pil1_tingkat_risiko = $kpmr_kre_pil1_average;
    } else {
       $kpmr_kre_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_kre_pil2 == 1) {
        $numbers = array($kpmr_kre_pil2_total1 , $kpmr_kre_pil2_total2, $kpmr_kre_pil2_total3);
        $kpmr_kre_pil2_maxValue = max($numbers);
        $kpmr_kre_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil2_average = $sum / count($numbers);

        $kpmr_kre_pil2_tingkat_risiko = $kpmr_kre_pil2_maxValue ;
    } else if ($set_kre_pil2 == 2) {
        $numbers = array($kpmr_kre_pil2_total1 , $kpmr_kre_pil2_total2, $kpmr_kre_pil2_total3);
        $kpmr_kre_pil2_maxValue = max($numbers);
        $kpmr_kre_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_kre_pil2_minValue;
    } else if ($set_kre_pil2 == 3) {
        $numbers = array($kpmr_kre_pil2_total1 , $kpmr_kre_pil2_total2, $kpmr_kre_pil2_total3);
        $kpmr_kre_pil2_maxValue = max($numbers);
        $kpmr_kre_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil2_average = $sum / count($numbers);

        $kpmr_kre_pil2_tingkat_risiko = $kpmr_kre_pil2_average;
    } else {
       $kpmr_kre_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_kre_pil3 == 1) {
        $numbers = array($kpmr_kre_pil3_total1 , $kpmr_kre_pil3_total2);
        $kpmr_kre_pil3_maxValue = max($numbers);
        $kpmr_kre_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil3_average = $sum / count($numbers);

        $kpmr_kre_pil3_tingkat_risiko = $kpmr_kre_pil3_maxValue ;
    } else if ($set_kre_pil3 == 2) {
        $numbers = array($kpmr_kre_pil3_total1 , $kpmr_kre_pil3_total2);
        $kpmr_kre_pil3_maxValue = max($numbers);
        $kpmr_kre_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil3_average = $sum / count($numbers);

        $kpmr_kre_pil3_tingkat_risiko = $kpmr_kre_pil3_minValue;
    } else if ($set_kre_pil3 == 3) {
        $numbers = array($kpmr_kre_pil3_total1 , $kpmr_kre_pil3_total2);
        $kpmr_kre_pil3_maxValue = max($numbers);
        $kpmr_kre_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil3_average = $sum / count($numbers);

        $kpmr_kre_pil3_tingkat_risiko = $kpmr_kre_pil3_average;
    } else {
       $kpmr_kre_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_kre_pil4 == 1) {
        $numbers = array($kpmr_kre_pil4_total1 , $kpmr_kre_pil4_total2);
        $kpmr_kre_pil4_maxValue = max($numbers);
        $kpmr_kre_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil4_average = $sum / count($numbers);

        $kpmr_kre_pil4_tingkat_risiko = $kpmr_kre_pil4_maxValue ;
    } else if ($set_kre_pil4 == 2) {
        $numbers = array($kpmr_kre_pil4_total1 , $kpmr_kre_pil4_total2);
        $kpmr_kre_pil4_maxValue = max($numbers);
        $kpmr_kre_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil4_average = $sum / count($numbers);

        $kpmr_kre_pil4_tingkat_risiko = $kpmr_kre_pil4_minValue;
    } else if ($set_kre_pil4 == 3) {
        $numbers = array($kpmr_kre_pil4_total1 , $kpmr_kre_pil4_total2);
        $kpmr_kre_pil4_maxValue = max($numbers);
        $kpmr_kre_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kre_pil4_average = $sum / count($numbers);

        $kpmr_kre_pil4_tingkat_risiko = $kpmr_kre_pil4_average;
    } else {
    $kpmr_kre_pil4_tingkat_risiko = 0;
    }



//likuiditas pil 1
$lik_pilar1_4 = $data['inheren_likuiditas_pilar1'][132]['pilar1_4'] ?? 0;
//likuiditas pil 2
$lik_hasil_pil2_par1   = $data['inheren_likuiditas_pilar2'][132]['hasil_pil2_par1'] ?? 0;
$lik_pil2_par1a        = $data['inheren_likuiditas_pilar2'][132]['pil2_par1a'] ?? 0;
$lik_hasil_pil2_par1a  = $data['inheren_likuiditas_pilar2'][132]['hasil_pil2_par1a'] ?? 0;
$lik_pil2_par1b        = $data['inheren_likuiditas_pilar2'][132]['pil2_par1b'] ?? 0;
$lik_hasil_pil2_par1b  = $data['inheren_likuiditas_pilar2'][132]['hasil_pil2_par1b'] ?? 0;
$lik_pil2_par1c        = $data['inheren_likuiditas_pilar2'][132]['pil2_par1c'] ?? 0;
$lik_hasil_pil2_par1c  = $data['inheren_likuiditas_pilar2'][132]['hasil_pil2_par1c'] ?? 0;
$lik_pil2_par2         = $data['inheren_likuiditas_pilar2'][132]['pil2_par2'] ?? 0;
$lik_hasil_pil2_par2   = $data['inheren_likuiditas_pilar2'][132]['hasil_pil2_par2'] ?? 0;
//likuiditas pil lainnya
$lik_hasil_pil3_par1   = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1'] ?? 0;
$lik_pil3_par1a        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1a'] ?? 0;
$lik_hasil_pil3_par1a  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1a'] ?? 0;
$lik_pil3_par1b        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1b'] ?? 0;
$lik_hasil_pil3_par1b  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1b'] ?? 0;
$lik_pil3_par1c        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1c'] ?? 0;
$lik_hasil_pil3_par1c  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1c'] ?? 0;
$lik_pil3_par1d        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1d'] ?? 0;
$lik_hasil_pil3_par1d  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1d'] ?? 0;
$lik_pil3_par1e        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1e'] ?? 0;
$lik_hasil_pil3_par1e  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1e'] ?? 0;
$lik_pil3_par1f        = $data['inheren_likuiditas_lainnya'][132]['pil3_par1f'] ?? 0;
$lik_hasil_pil3_par1f  = $data['inheren_likuiditas_lainnya'][132]['hasil_pil3_par1f'] ?? 0;

//ket lik
$lik_ket_pil1_1  = $data['keterangan_inheren_likuiditas'][132]['ket_pil1_1'] ?? '';
$lik_ket_pil1_2  = $data['keterangan_inheren_likuiditas'][132]['ket_pil1_2'] ?? '';
$lik_ket_pil1_3  = $data['keterangan_inheren_likuiditas'][132]['ket_pil1_3'] ?? '';
$lik_ket_pil1_4  = $data['keterangan_inheren_likuiditas'][132]['ket_pil1_4'] ?? '';
$lik_ket_pil1_5  = $data['keterangan_inheren_likuiditas'][132]['ket_pil1_5'] ?? '';
$lik_ket_pil1    = $data['keterangan_inheren_likuiditas'][132]['ket_pil1'] ?? '';
$lik_ket_pil2_1  = $data['keterangan_inheren_likuiditas'][132]['ket_pil2_1'] ?? '';
$lik_ket_pil2_2  = $data['keterangan_inheren_likuiditas'][132]['ket_pil2_2'] ?? '';
$lik_ket_pil2    = $data['keterangan_inheren_likuiditas'][132]['ket_pil2'] ?? '';
$lik_ket_pil3_1  = $data['keterangan_inheren_likuiditas'][132]['ket_pil3_1'] ?? '';
$lik_ket_pil3    = $data['keterangan_inheren_likuiditas'][132]['ket_pil3'] ?? '';
$lik_ket_inheren = $data['keterangan_inheren_likuiditas'][132]['ket_inheren'] ?? '';

$kpmr_lik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_likuiditas WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_lik_pilar1_1a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_1a','respon_unit_kerja_likuiditas_pil1','respon_pil1_1a',[132,142]);
    $result_kpmr_lik_pilar1_1b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_1b','respon_unit_kerja_likuiditas_pil1','respon_pil1_1b',[132,142]);
    $result_kpmr_lik_pilar1_1c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_1c','respon_unit_kerja_likuiditas_pil1','respon_pil1_1c',[132,142]);
    $result_kpmr_lik_pilar1_1d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_1d','respon_unit_kerja_likuiditas_pil1','respon_pil1_1d',[132,142]);
    $result_kpmr_lik_pilar1_1e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_1e','respon_unit_kerja_likuiditas_pil1','respon_pil1_1e',[132,142]);
    
    $result_kpmr_lik_pilar1_2a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_2a','respon_unit_kerja_likuiditas_pil1','respon_pil1_2a',[132,142]);
    $result_kpmr_lik_pilar1_2b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_2b','respon_unit_kerja_likuiditas_pil1','respon_pil1_2b',[132,142]);
    $result_kpmr_lik_pilar1_2c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_2c','respon_unit_kerja_likuiditas_pil1','respon_pil1_2c',[132,142]);
    $result_kpmr_lik_pilar1_2d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_2d','respon_unit_kerja_likuiditas_pil1','respon_pil1_2d',[132,142]);
    $result_kpmr_lik_pilar1_2e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_2e','respon_unit_kerja_likuiditas_pil1','respon_pil1_2e',[132,142]);
    
    $result_kpmr_lik_pilar1_3a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_3a','respon_unit_kerja_likuiditas_pil1','respon_pil1_3a',[132,142]);
    $result_kpmr_lik_pilar1_3b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_3b','respon_unit_kerja_likuiditas_pil1','respon_pil1_3b',[132,142]);
    $result_kpmr_lik_pilar1_3c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_3c','respon_unit_kerja_likuiditas_pil1','respon_pil1_3c',[132,142]);
    
    $result_kpmr_lik_pilar1_4a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_4a','respon_unit_kerja_likuiditas_pil1','respon_pil1_4a',[132,142]);
    $result_kpmr_lik_pilar1_4b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_4b','respon_unit_kerja_likuiditas_pil1','respon_pil1_4b',[132,142]);
    $result_kpmr_lik_pilar1_4c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_4c','respon_unit_kerja_likuiditas_pil1','respon_pil1_4c',[132,142]);
    $result_kpmr_lik_pilar1_4d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_4d','respon_unit_kerja_likuiditas_pil1','respon_pil1_4d',[132,142]);
    $result_kpmr_lik_pilar1_4e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_4e','respon_unit_kerja_likuiditas_pil1','respon_pil1_4e',[132,142]);
    
    $result_kpmr_lik_pilar1_5a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_5a','respon_unit_kerja_likuiditas_pil1','respon_pil1_5a',[132,142]);
    $result_kpmr_lik_pilar1_5b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_5b','respon_unit_kerja_likuiditas_pil1','respon_pil1_5b',[132,142]);
    $result_kpmr_lik_pilar1_5c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_5c','respon_unit_kerja_likuiditas_pil1','respon_pil1_5c',[132,142]);
    $result_kpmr_lik_pilar1_5d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_5d','respon_unit_kerja_likuiditas_pil1','respon_pil1_5d',[132,142]);
    
    $result_kpmr_lik_pilar1_6a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_6a','respon_unit_kerja_likuiditas_pil1','respon_pil1_6a',[132,142]);
    $result_kpmr_lik_pilar1_6b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_6b','respon_unit_kerja_likuiditas_pil1','respon_pil1_6b',[132,142]);
    $result_kpmr_lik_pilar1_6c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar1','pilar1_6c','respon_unit_kerja_likuiditas_pil1','respon_pil1_6c',[132,142]);
    

    $result_kpmr_lik_pilar2_1a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_1a','respon_unit_kerja_likuiditas_pil2','respon_pil2_1a',[132,142]);
    $result_kpmr_lik_pilar2_1b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_1b','respon_unit_kerja_likuiditas_pil2','respon_pil2_1b',[132,142]);
    $result_kpmr_lik_pilar2_1c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_1c','respon_unit_kerja_likuiditas_pil2','respon_pil2_1c',[132,142]);
    $result_kpmr_lik_pilar2_1d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_1d','respon_unit_kerja_likuiditas_pil2','respon_pil2_1d',[132,142]);
    $result_kpmr_lik_pilar2_1e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_1e','respon_unit_kerja_likuiditas_pil2','respon_pil2_1e',[132,142]);

    $result_kpmr_lik_pilar2_2a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2a','respon_unit_kerja_likuiditas_pil2','respon_pil2_2a',[132,142]);
    $result_kpmr_lik_pilar2_2b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2b','respon_unit_kerja_likuiditas_pil2','respon_pil2_2b',[132,142]);
    $result_kpmr_lik_pilar2_2c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2c','respon_unit_kerja_likuiditas_pil2','respon_pil2_2c',[132,142]);
    $result_kpmr_lik_pilar2_2d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2d','respon_unit_kerja_likuiditas_pil2','respon_pil2_2d',[132,142]);
    $result_kpmr_lik_pilar2_2e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2e','respon_unit_kerja_likuiditas_pil2','respon_pil2_2e',[132,142]);
    $result_kpmr_lik_pilar2_2f = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2f','respon_unit_kerja_likuiditas_pil2','respon_pil2_2f',[132,142]);
    $result_kpmr_lik_pilar2_2g = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2g','respon_unit_kerja_likuiditas_pil2','respon_pil2_2g',[132,142]);
    $result_kpmr_lik_pilar2_2h = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_2h','respon_unit_kerja_likuiditas_pil2','respon_pil2_2h',[132,142]);

    $result_kpmr_lik_pilar2_3a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_3a','respon_unit_kerja_likuiditas_pil2','respon_pil2_3a',[132,142]);
    $result_kpmr_lik_pilar2_3b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_3b','respon_unit_kerja_likuiditas_pil2','respon_pil2_3b',[132,142]);
    $result_kpmr_lik_pilar2_3c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar2','pilar2_3c','respon_unit_kerja_likuiditas_pil2','respon_pil2_3c',[132,142]);


    $result_kpmr_lik_pilar3_1a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1a','respon_unit_kerja_likuiditas_pil3','respon_pil3_1a',[132,142]);
    $result_kpmr_lik_pilar3_1b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1b','respon_unit_kerja_likuiditas_pil3','respon_pil3_1b',[132,142]);
    $result_kpmr_lik_pilar3_1c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1c','respon_unit_kerja_likuiditas_pil3','respon_pil3_1c',[132,142]);
    $result_kpmr_lik_pilar3_1d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1d','respon_unit_kerja_likuiditas_pil3','respon_pil3_1d',[132,142]);
    $result_kpmr_lik_pilar3_1e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1e','respon_unit_kerja_likuiditas_pil3','respon_pil3_1e',[132,142]);
    $result_kpmr_lik_pilar3_1f = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1f','respon_unit_kerja_likuiditas_pil3','respon_pil3_1f',[132,142]);
    $result_kpmr_lik_pilar3_1g = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1g','respon_unit_kerja_likuiditas_pil3','respon_pil3_1g',[132,142]);
    $result_kpmr_lik_pilar3_1h = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1h','respon_unit_kerja_likuiditas_pil3','respon_pil3_1h',[132,142]);
    $result_kpmr_lik_pilar3_1i = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1i','respon_unit_kerja_likuiditas_pil3','respon_pil3_1i',[132,142]);
    $result_kpmr_lik_pilar3_1j = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_1j','respon_unit_kerja_likuiditas_pil3','respon_pil3_1j',[132,142]);

    $result_kpmr_lik_pilar3_2a = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_2a','respon_unit_kerja_likuiditas_pil3','respon_pil3_1a',[132,142]);
    $result_kpmr_lik_pilar3_2b = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_2b','respon_unit_kerja_likuiditas_pil3','respon_pil3_1b',[132,142]);
    $result_kpmr_lik_pilar3_2c = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_2c','respon_unit_kerja_likuiditas_pil3','respon_pil3_1c',[132,142]);
    $result_kpmr_lik_pilar3_2d = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_2d','respon_unit_kerja_likuiditas_pil3','respon_pil3_1d',[132,142]);
    $result_kpmr_lik_pilar3_2e = getMaxValueWithRespon($data,'kpmr_likuiditas_pilar3','pilar3_2e','respon_unit_kerja_likuiditas_pil3','respon_pil3_1e',[132,142]);



    //implemen

$kpmr_lik_pilar1_1a = $result_kpmr_lik_pilar1_1a['nilai']; $kpmr_lik_respon_pil1_1a = $result_kpmr_lik_pilar1_1a['respon'];
$kpmr_lik_pilar1_1b = $result_kpmr_lik_pilar1_1b['nilai']; $kpmr_lik_respon_pil1_1b = $result_kpmr_lik_pilar1_1b['respon'];
$kpmr_lik_pilar1_1c = $result_kpmr_lik_pilar1_1c['nilai']; $kpmr_lik_respon_pil1_1c = $result_kpmr_lik_pilar1_1c['respon'];
$kpmr_lik_pilar1_1d = $result_kpmr_lik_pilar1_1d['nilai']; $kpmr_lik_respon_pil1_1d = $result_kpmr_lik_pilar1_1d['respon'];
$kpmr_lik_pilar1_1e = $result_kpmr_lik_pilar1_1e['nilai']; $kpmr_lik_respon_pil1_1e = $result_kpmr_lik_pilar1_1e['respon'];



$kpmr_lik_pil1_total1_average = array($kpmr_lik_pilar1_1a,
$kpmr_lik_pilar1_1b,
$kpmr_lik_pilar1_1c,
$kpmr_lik_pilar1_1d,
$kpmr_lik_pilar1_1e);
        $kpmr_lik_pil1_total1_sum = array_sum($kpmr_lik_pil1_total1_average);
        $kpmr_lik_pil1_total1 = $kpmr_lik_pil1_total1_sum / count($kpmr_lik_pil1_total1_average);

if ($kpmr_lik_pil1_total1 < 1.00) {
    $kpmr_lik_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total1 >= 1.00 && $kpmr_lik_pil1_total1 < 1.25) {
    $kpmr_lik_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total1 >= 1.25 && $kpmr_lik_pil1_total1 < 2.25) {
    $kpmr_lik_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_lik_pil1_total1 >= 2.25 && $kpmr_lik_pil1_total1 < 3.25) {
    $kpmr_lik_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total1 >= 3.25 && $kpmr_lik_pil1_total1 < 4.25) {
    $kpmr_lik_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total1 >= 4.25 && $kpmr_lik_pil1_total1 <= 5.00) {
    $kpmr_lik_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_lik_pilar1_2a = $result_kpmr_lik_pilar1_2a['nilai']; $kpmr_lik_respon_pil1_2a = $result_kpmr_lik_pilar1_2a['respon'];
$kpmr_lik_pilar1_2b = $result_kpmr_lik_pilar1_2b['nilai']; $kpmr_lik_respon_pil1_2b = $result_kpmr_lik_pilar1_2b['respon'];
$kpmr_lik_pilar1_2c = $result_kpmr_lik_pilar1_2c['nilai']; $kpmr_lik_respon_pil1_2c = $result_kpmr_lik_pilar1_2c['respon'];
$kpmr_lik_pilar1_2d = $result_kpmr_lik_pilar1_2d['nilai']; $kpmr_lik_respon_pil1_2d = $result_kpmr_lik_pilar1_2d['respon'];
$kpmr_lik_pilar1_2e = $result_kpmr_lik_pilar1_2e['nilai']; $kpmr_lik_respon_pil1_2e = $result_kpmr_lik_pilar1_2e['respon'];


$kpmr_lik_pil1_total2_average = array($kpmr_lik_pilar1_2a,
$kpmr_lik_pilar1_2b,
$kpmr_lik_pilar1_2c,
$kpmr_lik_pilar1_2d,
$kpmr_lik_pilar1_2e);
$kpmr_lik_pil1_total2_sum = array_sum($kpmr_lik_pil1_total2_average);
$kpmr_lik_pil1_total2 = $kpmr_lik_pil1_total2_sum / count($kpmr_lik_pil1_total2_average);

if ($kpmr_lik_pil1_total2 < 1.00) {
    $kpmr_lik_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total2 >= 1.00 && $kpmr_lik_pil1_total2 < 1.25) {
    $kpmr_lik_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total2 >= 1.25 && $kpmr_lik_pil1_total2 < 2.25) {
    $kpmr_lik_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_lik_pil1_total2 >= 2.25 && $kpmr_lik_pil1_total2 < 3.25) {
    $kpmr_lik_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total2 >= 3.25 && $kpmr_lik_pil1_total2 < 4.25) {
    $kpmr_lik_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total2 >= 4.25 && $kpmr_lik_pil1_total2 <= 5.00) {
    $kpmr_lik_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_lik_pilar1_3a = $result_kpmr_lik_pilar1_3a['nilai']; $kpmr_lik_respon_pil1_3a = $result_kpmr_lik_pilar1_3a['respon'];
$kpmr_lik_pilar1_3b = $result_kpmr_lik_pilar1_3b['nilai']; $kpmr_lik_respon_pil1_3b = $result_kpmr_lik_pilar1_3b['respon'];
$kpmr_lik_pilar1_3c = $result_kpmr_lik_pilar1_3c['nilai']; $kpmr_lik_respon_pil1_3c = $result_kpmr_lik_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_lik_pil1_total3_average = array($kpmr_lik_pilar1_3a,
$kpmr_lik_pilar1_3b,
$kpmr_lik_pilar1_3c);
$kpmr_lik_pil1_total3_sum = array_sum($kpmr_lik_pil1_total3_average);
$kpmr_lik_pil1_total3 = $kpmr_lik_pil1_total3_sum / count($kpmr_lik_pil1_total3_average);

if ($kpmr_lik_pil1_total3 < 1.00) {
    $kpmr_lik_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total3 >= 1.00 && $kpmr_lik_pil1_total3 < 1.25) {
    $kpmr_lik_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total3 >= 1.25 && $kpmr_lik_pil1_total3 < 2.25) {
    $kpmr_lik_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_lik_pil1_total3 >= 2.25 && $kpmr_lik_pil1_total3 < 3.25) {
    $kpmr_lik_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total3 >= 3.25 && $kpmr_lik_pil1_total3 < 4.25) {
    $kpmr_lik_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total3 >= 4.25 && $kpmr_lik_pil1_total3 <= 5.00) {
    $kpmr_lik_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_lik_pilar1_4a = $result_kpmr_lik_pilar1_4a['nilai']; $kpmr_lik_respon_pil1_4a = $result_kpmr_lik_pilar1_4a['respon'];
$kpmr_lik_pilar1_4b = $result_kpmr_lik_pilar1_4b['nilai']; $kpmr_lik_respon_pil1_4b = $result_kpmr_lik_pilar1_4b['respon'];
$kpmr_lik_pilar1_4c = $result_kpmr_lik_pilar1_4c['nilai']; $kpmr_lik_respon_pil1_4c = $result_kpmr_lik_pilar1_4c['respon'];
$kpmr_lik_pilar1_4d = $result_kpmr_lik_pilar1_4d['nilai']; $kpmr_lik_respon_pil1_4d = $result_kpmr_lik_pilar1_4d['respon'];
$kpmr_lik_pilar1_4e = $result_kpmr_lik_pilar1_4e['nilai']; $kpmr_lik_respon_pil1_4e = $result_kpmr_lik_pilar1_4e['respon'];


$kpmr_lik_pil1_total4_average = array($kpmr_lik_pilar1_4a,
$kpmr_lik_pilar1_4b,
$kpmr_lik_pilar1_4c,
$kpmr_lik_pilar1_4d,
$kpmr_lik_pilar1_4e);
$kpmr_lik_pil1_total4_sum = array_sum($kpmr_lik_pil1_total4_average);
$kpmr_lik_pil1_total4 = $kpmr_lik_pil1_total4_sum / count($kpmr_lik_pil1_total4_average);

if ($kpmr_lik_pil1_total4 < 1.00) {
    $kpmr_lik_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total4 >= 1.00 && $kpmr_lik_pil1_total4 < 1.25) {
    $kpmr_lik_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total4 >= 1.25 && $kpmr_lik_pil1_total4 < 2.25) {
    $kpmr_lik_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_lik_pil1_total4 >= 2.25 && $kpmr_lik_pil1_total4 < 3.25) {
    $kpmr_lik_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total4 >= 3.25 && $kpmr_lik_pil1_total4 < 4.25) {
    $kpmr_lik_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total4 >= 4.25 && $kpmr_lik_pil1_total4 <= 5.00) {
    $kpmr_lik_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_lik_pilar1_5a = $result_kpmr_lik_pilar1_5a['nilai']; $kpmr_lik_respon_pil1_5a = $result_kpmr_lik_pilar1_5a['respon'];
$kpmr_lik_pilar1_5b = $result_kpmr_lik_pilar1_5b['nilai']; $kpmr_lik_respon_pil1_5b = $result_kpmr_lik_pilar1_5b['respon'];
$kpmr_lik_pilar1_5c = $result_kpmr_lik_pilar1_5c['nilai']; $kpmr_lik_respon_pil1_5c = $result_kpmr_lik_pilar1_5c['respon'];
$kpmr_lik_pilar1_5d = $result_kpmr_lik_pilar1_5d['nilai']; $kpmr_lik_respon_pil1_5d = $result_kpmr_lik_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_lik_pil1_total5_average = array($kpmr_lik_pilar1_5a,
$kpmr_lik_pilar1_5b,
$kpmr_lik_pilar1_5c,
$kpmr_lik_pilar1_5);
$kpmr_lik_pil1_total5_sum = array_sum($kpmr_lik_pil1_total5_average);
$kpmr_lik_pil1_total5 = $kpmr_lik_pil1_total5_sum / count($kpmr_lik_pil1_total5_average);

if ($kpmr_lik_pil1_total5 < 1.00) {
    $kpmr_lik_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total5 >= 1.00 && $kpmr_lik_pil1_total5 < 1.25) {
    $kpmr_lik_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total5 >= 1.25 && $kpmr_lik_pil1_total5 < 2.25) {
    $kpmr_lik_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_lik_pil1_total5 >= 2.25 && $kpmr_lik_pil1_total5 < 3.25) {
    $kpmr_lik_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total5 >= 3.25 && $kpmr_lik_pil1_total5 < 4.25) {
    $kpmr_lik_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total5 >= 4.25 && $kpmr_lik_pil1_total5 <= 5.00) {
    $kpmr_lik_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_lik_pilar1_6a = $result_kpmr_lik_pilar1_6a['nilai']; $kpmr_lik_respon_pil1_6a = $result_kpmr_lik_pilar1_6a['respon'];
$kpmr_lik_pilar1_6b = $result_kpmr_lik_pilar1_6b['nilai']; $kpmr_lik_respon_pil1_6b = $result_kpmr_lik_pilar1_6b['respon'];
$kpmr_lik_pilar1_6c = $result_kpmr_lik_pilar1_6c['nilai']; $kpmr_lik_respon_pil1_6c = $result_kpmr_lik_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_lik_pil1_total6_average = array($kpmr_lik_pilar1_6a,
$kpmr_lik_pilar1_6b,
$kpmr_lik_pilar1_6c);
$kpmr_lik_pil1_total6_sum = array_sum($kpmr_lik_pil1_total6_average);
$kpmr_lik_pil1_total6 = $kpmr_lik_pil1_total6_sum / count($kpmr_lik_pil1_total6_average);

if ($kpmr_lik_pil1_total6 < 1.00) {
    $kpmr_lik_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_lik_pil1_total6 >= 1.00 && $kpmr_lik_pil1_total6 < 1.25) {
    $kpmr_lik_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_lik_pil1_total6 >= 1.25 && $kpmr_lik_pil1_total6 < 2.25) {
    $kpmr_lik_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_lik_pil1_total6 >= 2.25 && $kpmr_lik_pil1_total6 < 3.25) {
    $kpmr_lik_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_lik_pil1_total6 >= 3.25 && $kpmr_lik_pil1_total6 < 4.25) {
    $kpmr_lik_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_lik_pil1_total6 >= 4.25 && $kpmr_lik_pil1_total6 <= 5.00) {
    $kpmr_lik_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_lik_pil1_peringkat6 = "Belum Terisi";
}


        
$kpmr_lik_pilar2_1a = $result_kpmr_lik_pilar2_1a['nilai']; $kpmr_lik_respon_pil2_1a = $result_kpmr_lik_pilar2_1a['respon'];
$kpmr_lik_pilar2_1b = $result_kpmr_lik_pilar2_1b['nilai']; $kpmr_lik_respon_pil2_1b = $result_kpmr_lik_pilar2_1b['respon'];
$kpmr_lik_pilar2_1c = $result_kpmr_lik_pilar2_1c['nilai']; $kpmr_lik_respon_pil2_1c = $result_kpmr_lik_pilar2_1c['respon'];
$kpmr_lik_pilar2_1d = $result_kpmr_lik_pilar2_1d['nilai']; $kpmr_lik_respon_pil2_1d = $result_kpmr_lik_pilar2_1d['respon'];
$kpmr_lik_pilar2_1e = $result_kpmr_lik_pilar2_1e['nilai']; $kpmr_lik_respon_pil2_1e = $result_kpmr_lik_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_lik_pil2_total1_average = array($kpmr_lik_pilar2_1a,
$kpmr_lik_pilar2_1b,
$kpmr_lik_pilar2_1c,
$kpmr_lik_pilar2_1d,
$kpmr_lik_pilar2_1e);
$kpmr_lik_pil2_total1_sum = array_sum($kpmr_lik_pil2_total1_average);
$kpmr_lik_pil2_total1 = $kpmr_lik_pil2_total1_sum / count($kpmr_lik_pil2_total1_average);

if ($kpmr_lik_pil2_total1 < 1.00) {
    $kpmr_lik_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_lik_pil2_total1 >= 1.00 && $kpmr_lik_pil2_total1 < 1.25) {
    $kpmr_lik_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_lik_pil2_total1 >= 1.25 && $kpmr_lik_pil2_total1 < 2.25) {
    $kpmr_lik_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_lik_pil2_total1 >= 2.25 && $kpmr_lik_pil2_total1 < 3.25) {
    $kpmr_lik_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_lik_pil2_total1 >= 3.25 && $kpmr_lik_pil2_total1 < 4.25) {
    $kpmr_lik_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_lik_pil2_total1 >= 4.25 && $kpmr_lik_pil2_total1 <= 5.00) {
    $kpmr_lik_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_lik_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_lik_pilar2_2a = $result_kpmr_lik_pilar2_2a['nilai']; $kpmr_lik_respon_pil2_2a = $result_kpmr_lik_pilar2_2a['respon'];
$kpmr_lik_pilar2_2b = $result_kpmr_lik_pilar2_2b['nilai']; $kpmr_lik_respon_pil2_2b = $result_kpmr_lik_pilar2_2b['respon'];
$kpmr_lik_pilar2_2c = $result_kpmr_lik_pilar2_2c['nilai']; $kpmr_lik_respon_pil2_2c = $result_kpmr_lik_pilar2_2c['respon'];
$kpmr_lik_pilar2_2d = $result_kpmr_lik_pilar2_2d['nilai']; $kpmr_lik_respon_pil2_2d = $result_kpmr_lik_pilar2_2d['respon'];
$kpmr_lik_pilar2_2e = $result_kpmr_lik_pilar2_2e['nilai']; $kpmr_lik_respon_pil2_2e = $result_kpmr_lik_pilar2_2e['respon'];
$kpmr_lik_pilar2_2f = $result_kpmr_lik_pilar2_2f['nilai']; $kpmr_lik_respon_pil2_2f = $result_kpmr_lik_pilar2_2f['respon'];
$kpmr_lik_pilar2_2g = $result_kpmr_lik_pilar2_2g['nilai']; $kpmr_lik_respon_pil2_2g = $result_kpmr_lik_pilar2_2g['respon'];
$kpmr_lik_pilar2_2h = $result_kpmr_lik_pilar2_2h['nilai']; $kpmr_lik_respon_pil2_2h = $result_kpmr_lik_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_lik_pil2_total2_average = array($kpmr_lik_pilar2_2a,
$kpmr_lik_pilar2_2b,
$kpmr_lik_pilar2_2c,
$kpmr_lik_pilar2_2d,
$kpmr_lik_pilar2_2e,
$kpmr_lik_pilar2_2f,
$kpmr_lik_pilar2_2g,
$kpmr_lik_pilar2_2h);
$kpmr_lik_pil2_total2_sum = array_sum($kpmr_lik_pil2_total2_average);
$kpmr_lik_pil2_total2 = $kpmr_lik_pil2_total2_sum / count($kpmr_lik_pil2_total2_average);

if ($kpmr_lik_pil2_total2 < 1.00) {
    $kpmr_lik_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_lik_pil2_total2 >= 1.00 && $kpmr_lik_pil2_total2 < 1.25) {
    $kpmr_lik_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_lik_pil2_total2 >= 1.25 && $kpmr_lik_pil2_total2 < 2.25) {
    $kpmr_lik_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_lik_pil2_total2 >= 2.25 && $kpmr_lik_pil2_total2 < 3.25) {
    $kpmr_lik_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_lik_pil2_total2 >= 3.25 && $kpmr_lik_pil2_total2 < 4.25) {
    $kpmr_lik_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_lik_pil2_total2 >= 4.25 && $kpmr_lik_pil2_total2 <= 5.00) {
    $kpmr_lik_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_lik_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_lik_pilar2_3a = $result_kpmr_lik_pilar2_3a['nilai']; $kpmr_lik_respon_pil2_3a = $result_kpmr_lik_pilar2_3a['respon'];
$kpmr_lik_pilar2_3b = $result_kpmr_lik_pilar2_3b['nilai']; $kpmr_lik_respon_pil2_3b = $result_kpmr_lik_pilar2_3b['respon'];
$kpmr_lik_pilar2_3c = $result_kpmr_lik_pilar2_3c['nilai']; $kpmr_lik_respon_pil2_3c = $result_kpmr_lik_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_lik_pil2_total3_average = array($kpmr_lik_pilar2_3a,
$kpmr_lik_pilar2_3b,
$kpmr_lik_pilar2_3c);
$kpmr_lik_pil2_total3_sum = array_sum($kpmr_lik_pil2_total3_average);
$kpmr_lik_pil2_total3 = $kpmr_lik_pil2_total3_sum / count($kpmr_lik_pil2_total3_average);

if ($kpmr_lik_pil2_total3 < 1.00) {
    $kpmr_lik_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_lik_pil2_total3 >= 1.00 && $kpmr_lik_pil2_total3 < 1.25) {
    $kpmr_lik_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_lik_pil2_total3 >= 1.25 && $kpmr_lik_pil2_total3 < 2.25) {
    $kpmr_lik_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_lik_pil2_total3 >= 2.25 && $kpmr_lik_pil2_total3 < 3.25) {
    $kpmr_lik_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_lik_pil2_total3 >= 3.25 && $kpmr_lik_pil2_total3 < 4.25) {
    $kpmr_lik_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_lik_pil2_total3 >= 4.25 && $kpmr_lik_pil2_total3 <= 5.00) {
    $kpmr_lik_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_lik_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_lik_pilar3_1a = $result_kpmr_lik_pilar3_1a['nilai']; $kpmr_lik_respon_pil3_1a = $result_kpmr_lik_pilar3_1a['respon'];
$kpmr_lik_pilar3_1b = $result_kpmr_lik_pilar3_1b['nilai']; $kpmr_lik_respon_pil3_1b = $result_kpmr_lik_pilar3_1b['respon'];
$kpmr_lik_pilar3_1c = $result_kpmr_lik_pilar3_1c['nilai']; $kpmr_lik_respon_pil3_1c = $result_kpmr_lik_pilar3_1c['respon'];
$kpmr_lik_pilar3_1d = $result_kpmr_lik_pilar3_1d['nilai']; $kpmr_lik_respon_pil3_1d = $result_kpmr_lik_pilar3_1d['respon'];
$kpmr_lik_pilar3_1e = $result_kpmr_lik_pilar3_1e['nilai']; $kpmr_lik_respon_pil3_1e = $result_kpmr_lik_pilar3_1e['respon'];
$kpmr_lik_pilar3_1f = $result_kpmr_lik_pilar3_1f['nilai']; $kpmr_lik_respon_pil3_1f = $result_kpmr_lik_pilar3_1f['respon'];
$kpmr_lik_pilar3_1g = $result_kpmr_lik_pilar3_1g['nilai']; $kpmr_lik_respon_pil3_1g = $result_kpmr_lik_pilar3_1g['respon'];
$kpmr_lik_pilar3_1h = $result_kpmr_lik_pilar3_1h['nilai']; $kpmr_lik_respon_pil3_1h = $result_kpmr_lik_pilar3_1h['respon'];
$kpmr_lik_pilar3_1i = $result_kpmr_lik_pilar3_1i['nilai']; $kpmr_lik_respon_pil3_1i = $result_kpmr_lik_pilar3_1i['respon'];
$kpmr_lik_pilar3_1j = $result_kpmr_lik_pilar3_1j['nilai']; $kpmr_lik_respon_pil3_1j = $result_kpmr_lik_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_lik_pil3_total1_average = array($kpmr_lik_pilar3_1a,
$kpmr_lik_pilar3_1b,
$kpmr_lik_pilar3_1c,
$kpmr_lik_pilar3_1d,
$kpmr_lik_pilar3_1e,
$kpmr_lik_pilar3_1f,
$kpmr_lik_pilar3_1g,
$kpmr_lik_pilar3_1h,
$kpmr_lik_pilar3_1i,
$kpmr_lik_pilar3_1j);
$kpmr_lik_pil3_total1_sum = array_sum($kpmr_lik_pil3_total1_average);
$kpmr_lik_pil3_total1 = $kpmr_lik_pil3_total1_sum / count($kpmr_lik_pil3_total1_average);

if ($kpmr_lik_pil3_total1 < 1.00) {
    $kpmr_lik_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_lik_pil3_total1 >= 1.00 && $kpmr_lik_pil3_total1 < 1.25) {
    $kpmr_lik_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_lik_pil3_total1 >= 1.25 && $kpmr_lik_pil3_total1 < 2.25) {
    $kpmr_lik_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_lik_pil3_total1 >= 2.25 && $kpmr_lik_pil3_total1 < 3.25) {
    $kpmr_lik_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_lik_pil3_total1 >= 3.25 && $kpmr_lik_pil3_total1 < 4.25) {
    $kpmr_lik_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_lik_pil3_total1 >= 4.25 && $kpmr_lik_pil3_total1 <= 5.00) {
    $kpmr_lik_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_lik_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_lik_pilar3_2a = $result_kpmr_lik_pilar3_2a['nilai']; $kpmr_lik_respon_pil3_2a = $result_kpmr_lik_pilar3_2a['respon'];
$kpmr_lik_pilar3_2b = $result_kpmr_lik_pilar3_2b['nilai']; $kpmr_lik_respon_pil3_2b = $result_kpmr_lik_pilar3_2b['respon'];
$kpmr_lik_pilar3_2c = $result_kpmr_lik_pilar3_2c['nilai']; $kpmr_lik_respon_pil3_2c = $result_kpmr_lik_pilar3_2c['respon'];
$kpmr_lik_pilar3_2d = $result_kpmr_lik_pilar3_2d['nilai']; $kpmr_lik_respon_pil3_2d = $result_kpmr_lik_pilar3_2d['respon'];
$kpmr_lik_pilar3_2e = $result_kpmr_lik_pilar3_2e['nilai']; $kpmr_lik_respon_pil3_2e = $result_kpmr_lik_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_lik_pil3_total2_average = array($kpmr_lik_pilar3_2a,
$kpmr_lik_pilar3_2b,
$kpmr_lik_pilar3_2c,
$kpmr_lik_pilar3_2d,
$kpmr_lik_pilar3_2e);
$kpmr_lik_pil3_total2_sum = array_sum($kpmr_lik_pil3_total2_average);
$kpmr_lik_pil3_total2 = $kpmr_lik_pil3_total2_sum / count($kpmr_lik_pil3_total2_average);

if ($kpmr_lik_pil3_total2 < 1.00) {
    $kpmr_lik_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_lik_pil3_total2 >= 1.00 && $kpmr_lik_pil3_total2 < 1.25) {
    $kpmr_lik_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_lik_pil3_total2 >= 1.25 && $kpmr_lik_pil3_total2 < 2.25) {
    $kpmr_lik_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_lik_pil3_total2 >= 2.25 && $kpmr_lik_pil3_total2 < 3.25) {
    $kpmr_lik_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_lik_pil3_total2 >= 3.25 && $kpmr_lik_pil3_total2 < 4.25) {
    $kpmr_lik_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_lik_pil3_total2 >= 4.25 && $kpmr_lik_pil3_total2 <= 5.00) {
    $kpmr_lik_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_lik_pil3_peringkat2 = "Belum Terisi";
}



$kpmr_lik_pilar4_1a = $data['kpmr_likuiditas_pilar4'][143]['pilar4_1a'] ?? 0;
$kpmr_lik_pilar4_1b = $data['kpmr_likuiditas_pilar4'][143]['pilar4_1b'] ?? 0;
$kpmr_lik_pilar4_1c = $data['kpmr_likuiditas_pilar4'][143]['pilar4_1c'] ?? 0;
$kpmr_lik_pilar4_1d = $data['kpmr_likuiditas_pilar4'][143]['pilar4_1d'] ?? 0;
$kpmr_lik_pilar4_1e = $data['kpmr_likuiditas_pilar4'][143]['pilar4_1e'] ?? 0;
$kpmr_lik_pil4_total1 = $data['kpmr_likuiditas_pilar4'][143]['pil4_total1'] ?? 0;
$kpmr_lik_pil4_peringkat1 = $data['kpmr_likuiditas_pilar4'][143]['pil4_peringkat1'] ?? 0;
$kpmr_lik_pilar4_2a = $data['kpmr_likuiditas_pilar4'][143]['pilar4_2a'] ?? 0;
$kpmr_lik_pilar4_2b = $data['kpmr_likuiditas_pilar4'][143]['pilar4_2b'] ?? 0;
$kpmr_lik_pil4_total2 = $data['kpmr_likuiditas_pilar4'][143]['pil4_total2'] ?? 0;
$kpmr_lik_pil4_peringkat2 = $data['kpmr_likuiditas_pilar4'][143]['pil4_peringkat2'] ?? 0;

$kpmr_lik_respon_pil4_1a = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_1a'] ?? 0;
$kpmr_lik_respon_pil4_1b = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_1b'] ?? 0;
$kpmr_lik_respon_pil4_1c = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_1c'] ?? 0;
$kpmr_lik_respon_pil4_1d = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_1d'] ?? 0;
$kpmr_lik_respon_pil4_1e = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_1e'] ?? 0;
$kpmr_lik_respon_pil4_2a = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_2a'] ?? 0;
$kpmr_lik_respon_pil4_2b = $data['respon_unit_kerja_likuiditas_pil4'][143]['respon_pil4_2b'] ?? 0;

        
//rumus KPMR lik
//setingan ditetapkan
$kpmr_lik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_likuiditas WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_lik_pil1 = $kpmr_lik['kpmr_lik_set_pil1'];
$set_lik_pil2 = $kpmr_lik['kpmr_lik_set_pil2'];
$set_lik_pil3 = $kpmr_lik['kpmr_lik_set_pil3'];
$set_lik_pil4 = $kpmr_lik['kpmr_lik_set_pil4'];
$set_lik_hsl = $kpmr_lik['kpmr_lik_set_tingkat_risiko'];



    if ($set_lik_pil1 == 1) {
        $numbers = array($kpmr_lik_pil1_total1 , $kpmr_lik_pil1_total2, $kpmr_lik_pil1_total3, $kpmr_lik_pil1_total4, $kpmr_lik_pil1_total5, $kpmr_lik_pil1_total6);
        $kpmr_lik_pil1_maxValue = max($numbers);
        $kpmr_lik_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil1_average = $sum / count($numbers);
        $kpmr_lik_pil1_tingkat_risiko = $kpmr_lik_pil1_maxValue ;
    } else if ($set_lik_pil1 == 2) {
        $numbers = array($kpmr_lik_pil1_total1 , $kpmr_lik_pil1_total2, $kpmr_lik_pil1_total3, $kpmr_lik_pil1_total4, $kpmr_lik_pil1_total5, $kpmr_lik_pil1_total6);
        $kpmr_lik_pil1_maxValue = max($numbers);
        $kpmr_lik_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil1_average = $sum / count($numbers);

        $kpmr_lik_pil1_tingkat_risiko = $kpmr_lik_pil1_minValue;
    } else if ($set_lik_pil1 == 3) {
        $numbers = array($kpmr_lik_pil1_total1 , $kpmr_lik_pil1_total2, $kpmr_lik_pil1_total3, $kpmr_lik_pil1_total4, $kpmr_lik_pil1_total5, $kpmr_lik_pil1_total6);
        $kpmr_lik_pil1_maxValue = max($numbers);
        $kpmr_lik_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil1_average = $sum / count($numbers);

        $kpmr_lik_pil1_tingkat_risiko = $kpmr_lik_pil1_average;
    } else {
       $kpmr_lik_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_lik_pil2 == 1) {
        $numbers = array($kpmr_lik_pil2_total1 , $kpmr_lik_pil2_total2, $kpmr_lik_pil2_total3);
        $kpmr_lik_pil2_maxValue = max($numbers);
        $kpmr_lik_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil2_average = $sum / count($numbers);

        $kpmr_lik_pil2_tingkat_risiko = $kpmr_lik_pil2_maxValue ;
    } else if ($set_lik_pil2 == 2) {
        $numbers = array($kpmr_lik_pil2_total1 , $kpmr_lik_pil2_total2, $kpmr_lik_pil2_total3);
        $kpmr_lik_pil2_maxValue = max($numbers);
        $kpmr_lik_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_lik_pil2_minValue;
    } else if ($set_lik_pil2 == 3) {
        $numbers = array($kpmr_lik_pil2_total1 , $kpmr_lik_pil2_total2, $kpmr_lik_pil2_total3);
        $kpmr_lik_pil2_maxValue = max($numbers);
        $kpmr_lik_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil2_average = $sum / count($numbers);

        $kpmr_lik_pil2_tingkat_risiko = $kpmr_lik_pil2_average;
    } else {
       $kpmr_lik_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_lik_pil3 == 1) {
        $numbers = array($kpmr_lik_pil3_total1 , $kpmr_lik_pil3_total2);
        $kpmr_lik_pil3_maxValue = max($numbers);
        $kpmr_lik_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil3_average = $sum / count($numbers);

        $kpmr_lik_pil3_tingkat_risiko = $kpmr_lik_pil3_maxValue ;
    } else if ($set_lik_pil3 == 2) {
        $numbers = array($kpmr_lik_pil3_total1 , $kpmr_lik_pil3_total2);
        $kpmr_lik_pil3_maxValue = max($numbers);
        $kpmr_lik_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil3_average = $sum / count($numbers);

        $kpmr_lik_pil3_tingkat_risiko = $kpmr_lik_pil3_minValue;
    } else if ($set_lik_pil3 == 3) {
        $numbers = array($kpmr_lik_pil3_total1 , $kpmr_lik_pil3_total2);
        $kpmr_lik_pil3_maxValue = max($numbers);
        $kpmr_lik_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil3_average = $sum / count($numbers);

        $kpmr_lik_pil3_tingkat_risiko = $kpmr_lik_pil3_average;
    } else {
       $kpmr_lik_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_lik_pil4 == 1) {
        $numbers = array($kpmr_lik_pil4_total1 , $kpmr_lik_pil4_total2);
        $kpmr_lik_pil4_maxValue = max($numbers);
        $kpmr_lik_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil4_average = $sum / count($numbers);

        $kpmr_lik_pil4_tingkat_risiko = $kpmr_lik_pil4_maxValue ;
    } else if ($set_lik_pil4 == 2) {
        $numbers = array($kpmr_lik_pil4_total1 , $kpmr_lik_pil4_total2);
        $kpmr_lik_pil4_maxValue = max($numbers);
        $kpmr_lik_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil4_average = $sum / count($numbers);

        $kpmr_lik_pil4_tingkat_risiko = $kpmr_lik_pil4_minValue;
    } else if ($set_lik_pil4 == 3) {
        $numbers = array($kpmr_lik_pil4_total1 , $kpmr_lik_pil4_total2);
        $kpmr_lik_pil4_maxValue = max($numbers);
        $kpmr_lik_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_lik_pil4_average = $sum / count($numbers);

        $kpmr_lik_pil4_tingkat_risiko = $kpmr_lik_pil4_average;
    } else {
    $kpmr_lik_pil4_tingkat_risiko = 0;
    }

        

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



    $kpmr_ops = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_operasional WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_ops_pilar1_1a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_1a','respon_unit_kerja_operasional_pil1','respon_pil1_1a',[133,134,135]);
    $result_kpmr_ops_pilar1_1b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_1b','respon_unit_kerja_operasional_pil1','respon_pil1_1b',[133,134,135]);
    $result_kpmr_ops_pilar1_1c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_1c','respon_unit_kerja_operasional_pil1','respon_pil1_1c',[133,134,135]);
    $result_kpmr_ops_pilar1_1d = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_1d','respon_unit_kerja_operasional_pil1','respon_pil1_1d',[133,134,135]);
    $result_kpmr_ops_pilar1_1e = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_1e','respon_unit_kerja_operasional_pil1','respon_pil1_1e',[133,134,135]);
    
    $result_kpmr_ops_pilar1_2a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_2a','respon_unit_kerja_operasional_pil1','respon_pil1_2a',[133,134,135]);
    $result_kpmr_ops_pilar1_2b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_2b','respon_unit_kerja_operasional_pil1','respon_pil1_2b',[133,134,135]);
    $result_kpmr_ops_pilar1_2c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_2c','respon_unit_kerja_operasional_pil1','respon_pil1_2c',[133,134,135]);
    $result_kpmr_ops_pilar1_2d = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_2d','respon_unit_kerja_operasional_pil1','respon_pil1_2d',[133,134,135]);
    $result_kpmr_ops_pilar1_2e = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_2e','respon_unit_kerja_operasional_pil1','respon_pil1_2e',[133,134,135]);
    
    $result_kpmr_ops_pilar1_3a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_3a','respon_unit_kerja_operasional_pil1','respon_pil1_3a',[133,134,135]);
    $result_kpmr_ops_pilar1_3b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_3b','respon_unit_kerja_operasional_pil1','respon_pil1_3b',[133,134,135]);
    $result_kpmr_ops_pilar1_3c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_3c','respon_unit_kerja_operasional_pil1','respon_pil1_3c',[133,134,135]);
    
    $result_kpmr_ops_pilar1_4a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_4a','respon_unit_kerja_operasional_pil1','respon_pil1_4a',[133,134,135]);
    $result_kpmr_ops_pilar1_4b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_4b','respon_unit_kerja_operasional_pil1','respon_pil1_4b',[133,134,135]);
    $result_kpmr_ops_pilar1_4c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_4c','respon_unit_kerja_operasional_pil1','respon_pil1_4c',[133,134,135]);
    $result_kpmr_ops_pilar1_4d = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_4d','respon_unit_kerja_operasional_pil1','respon_pil1_4d',[133,134,135]);
    $result_kpmr_ops_pilar1_4e = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_4e','respon_unit_kerja_operasional_pil1','respon_pil1_4e',[133,134,135]);
    
    $result_kpmr_ops_pilar1_5a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_5a','respon_unit_kerja_operasional_pil1','respon_pil1_5a',[133,134,135]);
    $result_kpmr_ops_pilar1_5b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_5b','respon_unit_kerja_operasional_pil1','respon_pil1_5b',[133,134,135]);
    $result_kpmr_ops_pilar1_5c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_5c','respon_unit_kerja_operasional_pil1','respon_pil1_5c',[133,134,135]);
    $result_kpmr_ops_pilar1_5d = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_5d','respon_unit_kerja_operasional_pil1','respon_pil1_5d',[133,134,135]);
    
    $result_kpmr_ops_pilar1_6a = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_6a','respon_unit_kerja_operasional_pil1','respon_pil1_6a',[133,134,135]);
    $result_kpmr_ops_pilar1_6b = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_6b','respon_unit_kerja_operasional_pil1','respon_pil1_6b',[133,134,135]);
    $result_kpmr_ops_pilar1_6c = getMaxValueWithRespon($data,'kpmr_operasional_pilar1','pilar1_6c','respon_unit_kerja_operasional_pil1','respon_pil1_6c',[133,134,135]);
    

    $result_kpmr_ops_pilar2_1a = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_1a','respon_unit_kerja_operasional_pil2','respon_pil2_1a',[133,134,135]);
    $result_kpmr_ops_pilar2_1b = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_1b','respon_unit_kerja_operasional_pil2','respon_pil2_1b',[133,134,135]);
    $result_kpmr_ops_pilar2_1c = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_1c','respon_unit_kerja_operasional_pil2','respon_pil2_1c',[133,134,135]);
    $result_kpmr_ops_pilar2_1d = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_1d','respon_unit_kerja_operasional_pil2','respon_pil2_1d',[133,134,135]);
    $result_kpmr_ops_pilar2_1e = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_1e','respon_unit_kerja_operasional_pil2','respon_pil2_1e',[133,134,135]);

    $result_kpmr_ops_pilar2_2a = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2a','respon_unit_kerja_operasional_pil2','respon_pil2_2a',[133,134,135]);
    $result_kpmr_ops_pilar2_2b = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2b','respon_unit_kerja_operasional_pil2','respon_pil2_2b',[133,134,135]);
    $result_kpmr_ops_pilar2_2c = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2c','respon_unit_kerja_operasional_pil2','respon_pil2_2c',[133,134,135]);
    $result_kpmr_ops_pilar2_2d = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2d','respon_unit_kerja_operasional_pil2','respon_pil2_2d',[133,134,135]);
    $result_kpmr_ops_pilar2_2e = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2e','respon_unit_kerja_operasional_pil2','respon_pil2_2e',[133,134,135]);
    $result_kpmr_ops_pilar2_2f = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2f','respon_unit_kerja_operasional_pil2','respon_pil2_2f',[133,134,135]);
    $result_kpmr_ops_pilar2_2g = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2g','respon_unit_kerja_operasional_pil2','respon_pil2_2g',[133,134,135]);
    $result_kpmr_ops_pilar2_2h = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_2h','respon_unit_kerja_operasional_pil2','respon_pil2_2h',[133,134,135]);

    $result_kpmr_ops_pilar2_3a = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_3a','respon_unit_kerja_operasional_pil2','respon_pil2_3a',[133,134,135]);
    $result_kpmr_ops_pilar2_3b = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_3b','respon_unit_kerja_operasional_pil2','respon_pil2_3b',[133,134,135]);
    $result_kpmr_ops_pilar2_3c = getMaxValueWithRespon($data,'kpmr_operasional_pilar2','pilar2_3c','respon_unit_kerja_operasional_pil2','respon_pil2_3c',[133,134,135]);


    $result_kpmr_ops_pilar3_1a = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1a','respon_unit_kerja_operasional_pil3','respon_pil3_1a',[133,134,135]);
    $result_kpmr_ops_pilar3_1b = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1b','respon_unit_kerja_operasional_pil3','respon_pil3_1b',[133,134,135]);
    $result_kpmr_ops_pilar3_1c = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1c','respon_unit_kerja_operasional_pil3','respon_pil3_1c',[133,134,135]);
    $result_kpmr_ops_pilar3_1d = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1d','respon_unit_kerja_operasional_pil3','respon_pil3_1d',[133,134,135]);
    $result_kpmr_ops_pilar3_1e = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1e','respon_unit_kerja_operasional_pil3','respon_pil3_1e',[133,134,135]);
    $result_kpmr_ops_pilar3_1f = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1f','respon_unit_kerja_operasional_pil3','respon_pil3_1f',[133,134,135]);
    $result_kpmr_ops_pilar3_1g = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1g','respon_unit_kerja_operasional_pil3','respon_pil3_1g',[133,134,135]);
    $result_kpmr_ops_pilar3_1h = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1h','respon_unit_kerja_operasional_pil3','respon_pil3_1h',[133,134,135]);
    $result_kpmr_ops_pilar3_1i = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1i','respon_unit_kerja_operasional_pil3','respon_pil3_1i',[133,134,135]);
    $result_kpmr_ops_pilar3_1j = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_1j','respon_unit_kerja_operasional_pil3','respon_pil3_1j',[133,134,135]);

    $result_kpmr_ops_pilar3_2a = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_2a','respon_unit_kerja_operasional_pil3','respon_pil3_1a',[133,134,135]);
    $result_kpmr_ops_pilar3_2b = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_2b','respon_unit_kerja_operasional_pil3','respon_pil3_1b',[133,134,135]);
    $result_kpmr_ops_pilar3_2c = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_2c','respon_unit_kerja_operasional_pil3','respon_pil3_1c',[133,134,135]);
    $result_kpmr_ops_pilar3_2d = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_2d','respon_unit_kerja_operasional_pil3','respon_pil3_1d',[133,134,135]);
    $result_kpmr_ops_pilar3_2e = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_2e','respon_unit_kerja_operasional_pil3','respon_pil3_1e',[133,134,135]);

    $result_kpmr_ops_pilar3_3a = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_3a','respon_unit_kerja_operasional_pil3','respon_pil3_3a',[133,134,135]);
    $result_kpmr_ops_pilar3_3b = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_3b','respon_unit_kerja_operasional_pil3','respon_pil3_3b',[133,134,135]);
    $result_kpmr_ops_pilar3_3c = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_3c','respon_unit_kerja_operasional_pil3','respon_pil3_3c',[133,134,135]);
    
    $result_kpmr_ops_pilar3_4a = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_4a','respon_unit_kerja_operasional_pil3','respon_pil3_4a',[133,134,135]);
    $result_kpmr_ops_pilar3_4b = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_4b','respon_unit_kerja_operasional_pil3','respon_pil3_4b',[133,134,135]);
    $result_kpmr_ops_pilar3_4c = getMaxValueWithRespon($data,'kpmr_operasional_pilar3','pilar3_4c','respon_unit_kerja_operasional_pil3','respon_pil3_4c',[133,134,135]);
    

    //implemen

$kpmr_ops_pilar1_1a = $result_kpmr_ops_pilar1_1a['nilai']; $kpmr_ops_respon_pil1_1a = $result_kpmr_ops_pilar1_1a['respon'];
$kpmr_ops_pilar1_1b = $result_kpmr_ops_pilar1_1b['nilai']; $kpmr_ops_respon_pil1_1b = $result_kpmr_ops_pilar1_1b['respon'];
$kpmr_ops_pilar1_1c = $result_kpmr_ops_pilar1_1c['nilai']; $kpmr_ops_respon_pil1_1c = $result_kpmr_ops_pilar1_1c['respon'];
$kpmr_ops_pilar1_1d = $result_kpmr_ops_pilar1_1d['nilai']; $kpmr_ops_respon_pil1_1d = $result_kpmr_ops_pilar1_1d['respon'];
$kpmr_ops_pilar1_1e = $result_kpmr_ops_pilar1_1e['nilai']; $kpmr_ops_respon_pil1_1e = $result_kpmr_ops_pilar1_1e['respon'];



$kpmr_ops_pil1_total1_average = array($kpmr_ops_pilar1_1a,
$kpmr_ops_pilar1_1b,
$kpmr_ops_pilar1_1c,
$kpmr_ops_pilar1_1d,
$kpmr_ops_pilar1_1e);
        $kpmr_ops_pil1_total1_sum = array_sum($kpmr_ops_pil1_total1_average);
        $kpmr_ops_pil1_total1 = $kpmr_ops_pil1_total1_sum / count($kpmr_ops_pil1_total1_average);

if ($kpmr_ops_pil1_total1 < 1.00) {
    $kpmr_ops_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total1 >= 1.00 && $kpmr_ops_pil1_total1 < 1.25) {
    $kpmr_ops_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total1 >= 1.25 && $kpmr_ops_pil1_total1 < 2.25) {
    $kpmr_ops_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_ops_pil1_total1 >= 2.25 && $kpmr_ops_pil1_total1 < 3.25) {
    $kpmr_ops_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total1 >= 3.25 && $kpmr_ops_pil1_total1 < 4.25) {
    $kpmr_ops_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total1 >= 4.25 && $kpmr_ops_pil1_total1 <= 5.00) {
    $kpmr_ops_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_ops_pilar1_2a = $result_kpmr_ops_pilar1_2a['nilai']; $kpmr_ops_respon_pil1_2a = $result_kpmr_ops_pilar1_2a['respon'];
$kpmr_ops_pilar1_2b = $result_kpmr_ops_pilar1_2b['nilai']; $kpmr_ops_respon_pil1_2b = $result_kpmr_ops_pilar1_2b['respon'];
$kpmr_ops_pilar1_2c = $result_kpmr_ops_pilar1_2c['nilai']; $kpmr_ops_respon_pil1_2c = $result_kpmr_ops_pilar1_2c['respon'];
$kpmr_ops_pilar1_2d = $result_kpmr_ops_pilar1_2d['nilai']; $kpmr_ops_respon_pil1_2d = $result_kpmr_ops_pilar1_2d['respon'];
$kpmr_ops_pilar1_2e = $result_kpmr_ops_pilar1_2e['nilai']; $kpmr_ops_respon_pil1_2e = $result_kpmr_ops_pilar1_2e['respon'];


$kpmr_ops_pil1_total2_average = array($kpmr_ops_pilar1_2a,
$kpmr_ops_pilar1_2b,
$kpmr_ops_pilar1_2c,
$kpmr_ops_pilar1_2d,
$kpmr_ops_pilar1_2e);
$kpmr_ops_pil1_total2_sum = array_sum($kpmr_ops_pil1_total2_average);
$kpmr_ops_pil1_total2 = $kpmr_ops_pil1_total2_sum / count($kpmr_ops_pil1_total2_average);

if ($kpmr_ops_pil1_total2 < 1.00) {
    $kpmr_ops_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total2 >= 1.00 && $kpmr_ops_pil1_total2 < 1.25) {
    $kpmr_ops_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total2 >= 1.25 && $kpmr_ops_pil1_total2 < 2.25) {
    $kpmr_ops_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_ops_pil1_total2 >= 2.25 && $kpmr_ops_pil1_total2 < 3.25) {
    $kpmr_ops_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total2 >= 3.25 && $kpmr_ops_pil1_total2 < 4.25) {
    $kpmr_ops_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total2 >= 4.25 && $kpmr_ops_pil1_total2 <= 5.00) {
    $kpmr_ops_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_ops_pilar1_3a = $result_kpmr_ops_pilar1_3a['nilai']; $kpmr_ops_respon_pil1_3a = $result_kpmr_ops_pilar1_3a['respon'];
$kpmr_ops_pilar1_3b = $result_kpmr_ops_pilar1_3b['nilai']; $kpmr_ops_respon_pil1_3b = $result_kpmr_ops_pilar1_3b['respon'];
$kpmr_ops_pilar1_3c = $result_kpmr_ops_pilar1_3c['nilai']; $kpmr_ops_respon_pil1_3c = $result_kpmr_ops_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_ops_pil1_total3_average = array($kpmr_ops_pilar1_3a,
$kpmr_ops_pilar1_3b,
$kpmr_ops_pilar1_3c);
$kpmr_ops_pil1_total3_sum = array_sum($kpmr_ops_pil1_total3_average);
$kpmr_ops_pil1_total3 = $kpmr_ops_pil1_total3_sum / count($kpmr_ops_pil1_total3_average);

if ($kpmr_ops_pil1_total3 < 1.00) {
    $kpmr_ops_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total3 >= 1.00 && $kpmr_ops_pil1_total3 < 1.25) {
    $kpmr_ops_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total3 >= 1.25 && $kpmr_ops_pil1_total3 < 2.25) {
    $kpmr_ops_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_ops_pil1_total3 >= 2.25 && $kpmr_ops_pil1_total3 < 3.25) {
    $kpmr_ops_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total3 >= 3.25 && $kpmr_ops_pil1_total3 < 4.25) {
    $kpmr_ops_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total3 >= 4.25 && $kpmr_ops_pil1_total3 <= 5.00) {
    $kpmr_ops_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_ops_pilar1_4a = $result_kpmr_ops_pilar1_4a['nilai']; $kpmr_ops_respon_pil1_4a = $result_kpmr_ops_pilar1_4a['respon'];
$kpmr_ops_pilar1_4b = $result_kpmr_ops_pilar1_4b['nilai']; $kpmr_ops_respon_pil1_4b = $result_kpmr_ops_pilar1_4b['respon'];
$kpmr_ops_pilar1_4c = $result_kpmr_ops_pilar1_4c['nilai']; $kpmr_ops_respon_pil1_4c = $result_kpmr_ops_pilar1_4c['respon'];
$kpmr_ops_pilar1_4d = $result_kpmr_ops_pilar1_4d['nilai']; $kpmr_ops_respon_pil1_4d = $result_kpmr_ops_pilar1_4d['respon'];
$kpmr_ops_pilar1_4e = $result_kpmr_ops_pilar1_4e['nilai']; $kpmr_ops_respon_pil1_4e = $result_kpmr_ops_pilar1_4e['respon'];


$kpmr_ops_pil1_total4_average = array($kpmr_ops_pilar1_4a,
$kpmr_ops_pilar1_4b,
$kpmr_ops_pilar1_4c,
$kpmr_ops_pilar1_4d,
$kpmr_ops_pilar1_4e);
$kpmr_ops_pil1_total4_sum = array_sum($kpmr_ops_pil1_total4_average);
$kpmr_ops_pil1_total4 = $kpmr_ops_pil1_total4_sum / count($kpmr_ops_pil1_total4_average);

if ($kpmr_ops_pil1_total4 < 1.00) {
    $kpmr_ops_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total4 >= 1.00 && $kpmr_ops_pil1_total4 < 1.25) {
    $kpmr_ops_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total4 >= 1.25 && $kpmr_ops_pil1_total4 < 2.25) {
    $kpmr_ops_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_ops_pil1_total4 >= 2.25 && $kpmr_ops_pil1_total4 < 3.25) {
    $kpmr_ops_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total4 >= 3.25 && $kpmr_ops_pil1_total4 < 4.25) {
    $kpmr_ops_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total4 >= 4.25 && $kpmr_ops_pil1_total4 <= 5.00) {
    $kpmr_ops_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_ops_pilar1_5a = $result_kpmr_ops_pilar1_5a['nilai']; $kpmr_ops_respon_pil1_5a = $result_kpmr_ops_pilar1_5a['respon'];
$kpmr_ops_pilar1_5b = $result_kpmr_ops_pilar1_5b['nilai']; $kpmr_ops_respon_pil1_5b = $result_kpmr_ops_pilar1_5b['respon'];
$kpmr_ops_pilar1_5c = $result_kpmr_ops_pilar1_5c['nilai']; $kpmr_ops_respon_pil1_5c = $result_kpmr_ops_pilar1_5c['respon'];
$kpmr_ops_pilar1_5d = $result_kpmr_ops_pilar1_5d['nilai']; $kpmr_ops_respon_pil1_5d = $result_kpmr_ops_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_ops_pil1_total5_average = array($kpmr_ops_pilar1_5a,
$kpmr_ops_pilar1_5b,
$kpmr_ops_pilar1_5c,
$kpmr_ops_pilar1_5);
$kpmr_ops_pil1_total5_sum = array_sum($kpmr_ops_pil1_total5_average);
$kpmr_ops_pil1_total5 = $kpmr_ops_pil1_total5_sum / count($kpmr_ops_pil1_total5_average);

if ($kpmr_ops_pil1_total5 < 1.00) {
    $kpmr_ops_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total5 >= 1.00 && $kpmr_ops_pil1_total5 < 1.25) {
    $kpmr_ops_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total5 >= 1.25 && $kpmr_ops_pil1_total5 < 2.25) {
    $kpmr_ops_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_ops_pil1_total5 >= 2.25 && $kpmr_ops_pil1_total5 < 3.25) {
    $kpmr_ops_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total5 >= 3.25 && $kpmr_ops_pil1_total5 < 4.25) {
    $kpmr_ops_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total5 >= 4.25 && $kpmr_ops_pil1_total5 <= 5.00) {
    $kpmr_ops_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_ops_pilar1_6a = $result_kpmr_ops_pilar1_6a['nilai']; $kpmr_ops_respon_pil1_6a = $result_kpmr_ops_pilar1_6a['respon'];
$kpmr_ops_pilar1_6b = $result_kpmr_ops_pilar1_6b['nilai']; $kpmr_ops_respon_pil1_6b = $result_kpmr_ops_pilar1_6b['respon'];
$kpmr_ops_pilar1_6c = $result_kpmr_ops_pilar1_6c['nilai']; $kpmr_ops_respon_pil1_6c = $result_kpmr_ops_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_ops_pil1_total6_average = array($kpmr_ops_pilar1_6a,
$kpmr_ops_pilar1_6b,
$kpmr_ops_pilar1_6c);
$kpmr_ops_pil1_total6_sum = array_sum($kpmr_ops_pil1_total6_average);
$kpmr_ops_pil1_total6 = $kpmr_ops_pil1_total6_sum / count($kpmr_ops_pil1_total6_average);

if ($kpmr_ops_pil1_total6 < 1.00) {
    $kpmr_ops_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_ops_pil1_total6 >= 1.00 && $kpmr_ops_pil1_total6 < 1.25) {
    $kpmr_ops_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_ops_pil1_total6 >= 1.25 && $kpmr_ops_pil1_total6 < 2.25) {
    $kpmr_ops_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_ops_pil1_total6 >= 2.25 && $kpmr_ops_pil1_total6 < 3.25) {
    $kpmr_ops_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_ops_pil1_total6 >= 3.25 && $kpmr_ops_pil1_total6 < 4.25) {
    $kpmr_ops_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_ops_pil1_total6 >= 4.25 && $kpmr_ops_pil1_total6 <= 5.00) {
    $kpmr_ops_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_ops_pil1_peringkat6 = "Belum Terisi";
}


        
$kpmr_ops_pilar2_1a = $result_kpmr_ops_pilar2_1a['nilai']; $kpmr_ops_respon_pil2_1a = $result_kpmr_ops_pilar2_1a['respon'];
$kpmr_ops_pilar2_1b = $result_kpmr_ops_pilar2_1b['nilai']; $kpmr_ops_respon_pil2_1b = $result_kpmr_ops_pilar2_1b['respon'];
$kpmr_ops_pilar2_1c = $result_kpmr_ops_pilar2_1c['nilai']; $kpmr_ops_respon_pil2_1c = $result_kpmr_ops_pilar2_1c['respon'];
$kpmr_ops_pilar2_1d = $result_kpmr_ops_pilar2_1d['nilai']; $kpmr_ops_respon_pil2_1d = $result_kpmr_ops_pilar2_1d['respon'];
$kpmr_ops_pilar2_1e = $result_kpmr_ops_pilar2_1e['nilai']; $kpmr_ops_respon_pil2_1e = $result_kpmr_ops_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_ops_pil2_total1_average = array($kpmr_ops_pilar2_1a,
$kpmr_ops_pilar2_1b,
$kpmr_ops_pilar2_1c,
$kpmr_ops_pilar2_1d,
$kpmr_ops_pilar2_1e);
$kpmr_ops_pil2_total1_sum = array_sum($kpmr_ops_pil2_total1_average);
$kpmr_ops_pil2_total1 = $kpmr_ops_pil2_total1_sum / count($kpmr_ops_pil2_total1_average);

if ($kpmr_ops_pil2_total1 < 1.00) {
    $kpmr_ops_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_ops_pil2_total1 >= 1.00 && $kpmr_ops_pil2_total1 < 1.25) {
    $kpmr_ops_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_ops_pil2_total1 >= 1.25 && $kpmr_ops_pil2_total1 < 2.25) {
    $kpmr_ops_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_ops_pil2_total1 >= 2.25 && $kpmr_ops_pil2_total1 < 3.25) {
    $kpmr_ops_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_ops_pil2_total1 >= 3.25 && $kpmr_ops_pil2_total1 < 4.25) {
    $kpmr_ops_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_ops_pil2_total1 >= 4.25 && $kpmr_ops_pil2_total1 <= 5.00) {
    $kpmr_ops_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_ops_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_ops_pilar2_2a = $result_kpmr_ops_pilar2_2a['nilai']; $kpmr_ops_respon_pil2_2a = $result_kpmr_ops_pilar2_2a['respon'];
$kpmr_ops_pilar2_2b = $result_kpmr_ops_pilar2_2b['nilai']; $kpmr_ops_respon_pil2_2b = $result_kpmr_ops_pilar2_2b['respon'];
$kpmr_ops_pilar2_2c = $result_kpmr_ops_pilar2_2c['nilai']; $kpmr_ops_respon_pil2_2c = $result_kpmr_ops_pilar2_2c['respon'];
$kpmr_ops_pilar2_2d = $result_kpmr_ops_pilar2_2d['nilai']; $kpmr_ops_respon_pil2_2d = $result_kpmr_ops_pilar2_2d['respon'];
$kpmr_ops_pilar2_2e = $result_kpmr_ops_pilar2_2e['nilai']; $kpmr_ops_respon_pil2_2e = $result_kpmr_ops_pilar2_2e['respon'];
$kpmr_ops_pilar2_2f = $result_kpmr_ops_pilar2_2f['nilai']; $kpmr_ops_respon_pil2_2f = $result_kpmr_ops_pilar2_2f['respon'];
$kpmr_ops_pilar2_2g = $result_kpmr_ops_pilar2_2g['nilai']; $kpmr_ops_respon_pil2_2g = $result_kpmr_ops_pilar2_2g['respon'];
$kpmr_ops_pilar2_2h = $result_kpmr_ops_pilar2_2h['nilai']; $kpmr_ops_respon_pil2_2h = $result_kpmr_ops_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_ops_pil2_total2_average = array($kpmr_ops_pilar2_2a,
$kpmr_ops_pilar2_2b,
$kpmr_ops_pilar2_2c,
$kpmr_ops_pilar2_2d,
$kpmr_ops_pilar2_2e,
$kpmr_ops_pilar2_2f,
$kpmr_ops_pilar2_2g,
$kpmr_ops_pilar2_2h);
$kpmr_ops_pil2_total2_sum = array_sum($kpmr_ops_pil2_total2_average);
$kpmr_ops_pil2_total2 = $kpmr_ops_pil2_total2_sum / count($kpmr_ops_pil2_total2_average);

if ($kpmr_ops_pil2_total2 < 1.00) {
    $kpmr_ops_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_ops_pil2_total2 >= 1.00 && $kpmr_ops_pil2_total2 < 1.25) {
    $kpmr_ops_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_ops_pil2_total2 >= 1.25 && $kpmr_ops_pil2_total2 < 2.25) {
    $kpmr_ops_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_ops_pil2_total2 >= 2.25 && $kpmr_ops_pil2_total2 < 3.25) {
    $kpmr_ops_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_ops_pil2_total2 >= 3.25 && $kpmr_ops_pil2_total2 < 4.25) {
    $kpmr_ops_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_ops_pil2_total2 >= 4.25 && $kpmr_ops_pil2_total2 <= 5.00) {
    $kpmr_ops_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_ops_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_ops_pilar2_3a = $result_kpmr_ops_pilar2_3a['nilai']; $kpmr_ops_respon_pil2_3a = $result_kpmr_ops_pilar2_3a['respon'];
$kpmr_ops_pilar2_3b = $result_kpmr_ops_pilar2_3b['nilai']; $kpmr_ops_respon_pil2_3b = $result_kpmr_ops_pilar2_3b['respon'];
$kpmr_ops_pilar2_3c = $result_kpmr_ops_pilar2_3c['nilai']; $kpmr_ops_respon_pil2_3c = $result_kpmr_ops_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_ops_pil2_total3_average = array($kpmr_ops_pilar2_3a,
$kpmr_ops_pilar2_3b,
$kpmr_ops_pilar2_3c);
$kpmr_ops_pil2_total3_sum = array_sum($kpmr_ops_pil2_total3_average);
$kpmr_ops_pil2_total3 = $kpmr_ops_pil2_total3_sum / count($kpmr_ops_pil2_total3_average);

if ($kpmr_ops_pil2_total3 < 1.00) {
    $kpmr_ops_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_ops_pil2_total3 >= 1.00 && $kpmr_ops_pil2_total3 < 1.25) {
    $kpmr_ops_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_ops_pil2_total3 >= 1.25 && $kpmr_ops_pil2_total3 < 2.25) {
    $kpmr_ops_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_ops_pil2_total3 >= 2.25 && $kpmr_ops_pil2_total3 < 3.25) {
    $kpmr_ops_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_ops_pil2_total3 >= 3.25 && $kpmr_ops_pil2_total3 < 4.25) {
    $kpmr_ops_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_ops_pil2_total3 >= 4.25 && $kpmr_ops_pil2_total3 <= 5.00) {
    $kpmr_ops_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_ops_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_ops_pilar3_1a = $result_kpmr_ops_pilar3_1a['nilai']; $kpmr_ops_respon_pil3_1a = $result_kpmr_ops_pilar3_1a['respon'];
$kpmr_ops_pilar3_1b = $result_kpmr_ops_pilar3_1b['nilai']; $kpmr_ops_respon_pil3_1b = $result_kpmr_ops_pilar3_1b['respon'];
$kpmr_ops_pilar3_1c = $result_kpmr_ops_pilar3_1c['nilai']; $kpmr_ops_respon_pil3_1c = $result_kpmr_ops_pilar3_1c['respon'];
$kpmr_ops_pilar3_1d = $result_kpmr_ops_pilar3_1d['nilai']; $kpmr_ops_respon_pil3_1d = $result_kpmr_ops_pilar3_1d['respon'];
$kpmr_ops_pilar3_1e = $result_kpmr_ops_pilar3_1e['nilai']; $kpmr_ops_respon_pil3_1e = $result_kpmr_ops_pilar3_1e['respon'];
$kpmr_ops_pilar3_1f = $result_kpmr_ops_pilar3_1f['nilai']; $kpmr_ops_respon_pil3_1f = $result_kpmr_ops_pilar3_1f['respon'];
$kpmr_ops_pilar3_1g = $result_kpmr_ops_pilar3_1g['nilai']; $kpmr_ops_respon_pil3_1g = $result_kpmr_ops_pilar3_1g['respon'];
$kpmr_ops_pilar3_1h = $result_kpmr_ops_pilar3_1h['nilai']; $kpmr_ops_respon_pil3_1h = $result_kpmr_ops_pilar3_1h['respon'];
$kpmr_ops_pilar3_1i = $result_kpmr_ops_pilar3_1i['nilai']; $kpmr_ops_respon_pil3_1i = $result_kpmr_ops_pilar3_1i['respon'];
$kpmr_ops_pilar3_1j = $result_kpmr_ops_pilar3_1j['nilai']; $kpmr_ops_respon_pil3_1j = $result_kpmr_ops_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_ops_pil3_total1_average = array($kpmr_ops_pilar3_1a,
$kpmr_ops_pilar3_1b,
$kpmr_ops_pilar3_1c,
$kpmr_ops_pilar3_1d,
$kpmr_ops_pilar3_1e,
$kpmr_ops_pilar3_1f,
$kpmr_ops_pilar3_1g,
$kpmr_ops_pilar3_1h,
$kpmr_ops_pilar3_1i,
$kpmr_ops_pilar3_1j);
$kpmr_ops_pil3_total1_sum = array_sum($kpmr_ops_pil3_total1_average);
$kpmr_ops_pil3_total1 = $kpmr_ops_pil3_total1_sum / count($kpmr_ops_pil3_total1_average);

if ($kpmr_ops_pil3_total1 < 1.00) {
    $kpmr_ops_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_ops_pil3_total1 >= 1.00 && $kpmr_ops_pil3_total1 < 1.25) {
    $kpmr_ops_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_ops_pil3_total1 >= 1.25 && $kpmr_ops_pil3_total1 < 2.25) {
    $kpmr_ops_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_ops_pil3_total1 >= 2.25 && $kpmr_ops_pil3_total1 < 3.25) {
    $kpmr_ops_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_ops_pil3_total1 >= 3.25 && $kpmr_ops_pil3_total1 < 4.25) {
    $kpmr_ops_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_ops_pil3_total1 >= 4.25 && $kpmr_ops_pil3_total1 <= 5.00) {
    $kpmr_ops_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_ops_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_ops_pilar3_2a = $result_kpmr_ops_pilar3_2a['nilai']; $kpmr_ops_respon_pil3_2a = $result_kpmr_ops_pilar3_2a['respon'];
$kpmr_ops_pilar3_2b = $result_kpmr_ops_pilar3_2b['nilai']; $kpmr_ops_respon_pil3_2b = $result_kpmr_ops_pilar3_2b['respon'];
$kpmr_ops_pilar3_2c = $result_kpmr_ops_pilar3_2c['nilai']; $kpmr_ops_respon_pil3_2c = $result_kpmr_ops_pilar3_2c['respon'];
$kpmr_ops_pilar3_2d = $result_kpmr_ops_pilar3_2d['nilai']; $kpmr_ops_respon_pil3_2d = $result_kpmr_ops_pilar3_2d['respon'];
$kpmr_ops_pilar3_2e = $result_kpmr_ops_pilar3_2e['nilai']; $kpmr_ops_respon_pil3_2e = $result_kpmr_ops_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_ops_pil3_total2_average = array($kpmr_ops_pilar3_2a,
$kpmr_ops_pilar3_2b,
$kpmr_ops_pilar3_2c,
$kpmr_ops_pilar3_2d,
$kpmr_ops_pilar3_2e);
$kpmr_ops_pil3_total2_sum = array_sum($kpmr_ops_pil3_total2_average);
$kpmr_ops_pil3_total2 = $kpmr_ops_pil3_total2_sum / count($kpmr_ops_pil3_total2_average);

if ($kpmr_ops_pil3_total2 < 1.00) {
    $kpmr_ops_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_ops_pil3_total2 >= 1.00 && $kpmr_ops_pil3_total2 < 1.25) {
    $kpmr_ops_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_ops_pil3_total2 >= 1.25 && $kpmr_ops_pil3_total2 < 2.25) {
    $kpmr_ops_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_ops_pil3_total2 >= 2.25 && $kpmr_ops_pil3_total2 < 3.25) {
    $kpmr_ops_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_ops_pil3_total2 >= 3.25 && $kpmr_ops_pil3_total2 < 4.25) {
    $kpmr_ops_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_ops_pil3_total2 >= 4.25 && $kpmr_ops_pil3_total2 <= 5.00) {
    $kpmr_ops_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_ops_pil3_peringkat2 = "Belum Terisi";
}

$kpmr_ops_pilar3_3a = $result_kpmr_ops_pilar3_3a['nilai']; $kpmr_ops_respon_pil3_3a = $result_kpmr_ops_pilar3_3a['respon'];
$kpmr_ops_pilar3_3b = $result_kpmr_ops_pilar3_3b['nilai']; $kpmr_ops_respon_pil3_3b = $result_kpmr_ops_pilar3_3b['respon'];
$kpmr_ops_pilar3_3c = $result_kpmr_ops_pilar3_3c['nilai']; $kpmr_ops_respon_pil3_3c = $result_kpmr_ops_pilar3_3c['respon'];

// --- Pilar 3 Total 3 ---
$kpmr_ops_pil3_total3_average = array($kpmr_ops_pilar3_3a,
$kpmr_ops_pilar3_3b,
$kpmr_ops_pilar3_3c);
$kpmr_ops_pil3_total3_sum = array_sum($kpmr_ops_pil3_total3_average);
$kpmr_ops_pil3_total3 = $kpmr_ops_pil3_total3_sum / count($kpmr_ops_pil3_total3_average);

if ($kpmr_ops_pil3_total3 < 1.00) {
    $kpmr_ops_pil3_peringkat3 = "Belum Terisi";
} elseif ($kpmr_ops_pil3_total3 >= 1.00 && $kpmr_ops_pil3_total3 < 1.25) {
    $kpmr_ops_pil3_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_ops_pil3_total3 >= 1.25 && $kpmr_ops_pil3_total3 < 2.25) {
    $kpmr_ops_pil3_peringkat3 = "Memadai";
} elseif ($kpmr_ops_pil3_total3 >= 2.25 && $kpmr_ops_pil3_total3 < 3.25) {
    $kpmr_ops_pil3_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_ops_pil3_total3 >= 3.25 && $kpmr_ops_pil3_total3 < 4.25) {
    $kpmr_ops_pil3_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_ops_pil3_total3 >= 4.25 && $kpmr_ops_pil3_total3 <= 5.00) {
    $kpmr_ops_pil3_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_ops_pil3_peringkat3 = "Belum Terisi";
}

$kpmr_ops_pilar3_4a = $result_kpmr_ops_pilar3_4a['nilai']; $kpmr_ops_respon_pil3_4a = $result_kpmr_ops_pilar3_4a['respon'];
$kpmr_ops_pilar3_4b = $result_kpmr_ops_pilar3_4b['nilai']; $kpmr_ops_respon_pil3_4b = $result_kpmr_ops_pilar3_4b['respon'];
$kpmr_ops_pilar3_4c = $result_kpmr_ops_pilar3_4c['nilai']; $kpmr_ops_respon_pil3_4c = $result_kpmr_ops_pilar3_4c['respon'];

// --- Pilar 3 Total 4 ---
$kpmr_ops_pil3_total4_average = array($kpmr_ops_pilar3_4a,
$kpmr_ops_pilar3_4b,
$kpmr_ops_pilar3_4c);
$kpmr_ops_pil3_total4_sum = array_sum($kpmr_ops_pil3_total4_average);
$kpmr_ops_pil3_total4 = $kpmr_ops_pil3_total4_sum / count($kpmr_ops_pil3_total4_average);

if ($kpmr_ops_pil3_total4 < 1.00) {
    $kpmr_ops_pil3_peringkat4 = "Belum Terisi";
} elseif ($kpmr_ops_pil3_total4 >= 1.00 && $kpmr_ops_pil3_total4 < 1.25) {
    $kpmr_ops_pil3_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_ops_pil3_total4 >= 1.25 && $kpmr_ops_pil3_total4 < 2.25) {
    $kpmr_ops_pil3_peringkat4 = "Memadai";
} elseif ($kpmr_ops_pil3_total4 >= 2.25 && $kpmr_ops_pil3_total4 < 3.25) {
    $kpmr_ops_pil3_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_ops_pil3_total4 >= 3.25 && $kpmr_ops_pil3_total4 < 4.25) {
    $kpmr_ops_pil3_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_ops_pil3_total4 >= 4.25 && $kpmr_ops_pil3_total4 <= 5.00) {
    $kpmr_ops_pil3_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_ops_pil3_peringkat4 = "Belum Terisi";
}



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

    $kpmr_ops_pilar4_1a = $data['kpmr_operasional_pilar4'][143]['pilar4_1a'] ?? 0;
    $kpmr_ops_pilar4_1b = $data['kpmr_operasional_pilar4'][143]['pilar4_1b'] ?? 0;
    $kpmr_ops_pilar4_1c = $data['kpmr_operasional_pilar4'][143]['pilar4_1c'] ?? 0;
    $kpmr_ops_pilar4_1d = $data['kpmr_operasional_pilar4'][143]['pilar4_1d'] ?? 0;
    $kpmr_ops_pilar4_1e = $data['kpmr_operasional_pilar4'][143]['pilar4_1e'] ?? 0;
    $kpmr_ops_pil4_total1 = $data['kpmr_operasional_pilar4'][143]['pil4_total1'] ?? 0;
    $kpmr_ops_pil4_peringkat1 = $data['kpmr_operasional_pilar4'][143]['pil4_peringkat1'] ?? 0;
    $kpmr_ops_pilar4_2a = $data['kpmr_operasional_pilar4'][143]['pilar4_2a'] ?? 0;
    $kpmr_ops_pilar4_2b = $data['kpmr_operasional_pilar4'][143]['pilar4_2b'] ?? 0;
    $kpmr_ops_pil4_total2 = $data['kpmr_operasional_pilar4'][143]['pil4_total2'] ?? 0;
    $kpmr_ops_pil4_peringkat2 = $data['kpmr_operasional_pilar4'][143]['pil4_peringkat2'] ?? 0;

    $kpmr_ops_respon_pil4_1a = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_1a'] ?? 0;
    $kpmr_ops_respon_pil4_1b = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_1b'] ?? 0;
    $kpmr_ops_respon_pil4_1c = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_1c'] ?? 0;
    $kpmr_ops_respon_pil4_1d = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_1d'] ?? 0;
    $kpmr_ops_respon_pil4_1e = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_1e'] ?? 0;
    $kpmr_ops_respon_pil4_2a = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_2a'] ?? 0;
    $kpmr_ops_respon_pil4_2b = $data['respon_unit_kerja_operasional_pil4'][143]['respon_pil4_2b'] ?? 0;


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

    $ket_in_op_pil6_1a = $data['ket_inheren_operasional_lainnya'][134]['ket_in_op_pil6_1a'] ?? '';
    $ket_in_op_pil6_1b = $data['ket_inheren_operasional_lainnya'][134]['ket_in_op_pil6_1b'] ?? '';
    $ket_in_op_pil6_1c = $data['ket_inheren_operasional_lainnya'][133]['ket_in_op_pil6_1c'] ?? '';
    $ket_in_op_pil6_1d = $data['ket_inheren_operasional_lainnya'][133]['ket_in_op_pil6_1d'] ?? '';
    $ket_in_op_pil6_1e = $data['ket_inheren_operasional_lainnya'][133]['ket_in_op_pil6_1e'] ?? '';
    $ket_in_op_pil6_1f = $data['ket_inheren_operasional_lainnya'][133]['ket_in_op_pil6_1f'] ?? '';


//rumus KPMR OPS
//setingan ditetapkan
$kpmr_ops = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_operasional WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_ops_pil1 = $kpmr_ops['kpmr_op_set_pil1'];
$set_ops_pil2 = $kpmr_ops['kpmr_op_set_pil2'];
$set_ops_pil3 = $kpmr_ops['kpmr_op_set_pil3'];
$set_ops_pil4 = $kpmr_ops['kpmr_op_set_pil4'];
$set_ops_hsl = $kpmr_ops['kpmr_op_set_tingkat_risiko'];



    if ($set_ops_pil1 == 1) {
        $numbers = array($kpmr_ops_pil1_total1 , $kpmr_ops_pil1_total2, $kpmr_ops_pil1_total3, $kpmr_ops_pil1_total4, $kpmr_ops_pil1_total5, $kpmr_ops_pil1_total6);
        $kpmr_ops_pil1_maxValue = max($numbers);
        $kpmr_ops_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil1_average = $sum / count($numbers);
        $kpmr_ops_pil1_tingkat_risiko = $kpmr_ops_pil1_maxValue ;
    } else if ($set_ops_pil1 == 2) {
        $numbers = array($kpmr_ops_pil1_total1 , $kpmr_ops_pil1_total2, $kpmr_ops_pil1_total3, $kpmr_ops_pil1_total4, $kpmr_ops_pil1_total5, $kpmr_ops_pil1_total6);
        $kpmr_ops_pil1_maxValue = max($numbers);
        $kpmr_ops_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil1_average = $sum / count($numbers);

        $kpmr_ops_pil1_tingkat_risiko = $kpmr_ops_pil1_minValue;
    } else if ($set_ops_pil1 == 3) {
        $numbers = array($kpmr_ops_pil1_total1 , $kpmr_ops_pil1_total2, $kpmr_ops_pil1_total3, $kpmr_ops_pil1_total4, $kpmr_ops_pil1_total5, $kpmr_ops_pil1_total6);
        $kpmr_ops_pil1_maxValue = max($numbers);
        $kpmr_ops_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil1_average = $sum / count($numbers);

        $kpmr_ops_pil1_tingkat_risiko = $kpmr_ops_pil1_average;
    } else {
       $kpmr_ops_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_ops_pil2 == 1) {
        $numbers = array($kpmr_ops_pil2_total1 , $kpmr_ops_pil2_total2, $kpmr_ops_pil2_total3);
        $kpmr_ops_pil2_maxValue = max($numbers);
        $kpmr_ops_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil2_average = $sum / count($numbers);

        $kpmr_ops_pil2_tingkat_risiko = $kpmr_ops_pil2_maxValue ;
    } else if ($set_ops_pil2 == 2) {
        $numbers = array($kpmr_ops_pil2_total1 , $kpmr_ops_pil2_total2, $kpmr_ops_pil2_total3);
        $kpmr_ops_pil2_maxValue = max($numbers);
        $kpmr_ops_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_ops_pil2_minValue;
    } else if ($set_ops_pil2 == 3) {
        $numbers = array($kpmr_ops_pil2_total1 , $kpmr_ops_pil2_total2, $kpmr_ops_pil2_total3);
        $kpmr_ops_pil2_maxValue = max($numbers);
        $kpmr_ops_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil2_average = $sum / count($numbers);

        $kpmr_ops_pil2_tingkat_risiko = $kpmr_ops_pil2_average;
    } else {
       $kpmr_ops_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_ops_pil3 == 1) {
        $numbers = array($kpmr_ops_pil3_total1 , $kpmr_ops_pil3_total2, $kpmr_ops_pil3_total3, $kpmr_ops_pil3_total4);
        $kpmr_ops_pil3_maxValue = max($numbers);
        $kpmr_ops_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil3_average = $sum / count($numbers);

        $kpmr_ops_pil3_tingkat_risiko = $kpmr_ops_pil3_maxValue ;
    } else if ($set_ops_pil3 == 2) {
        $numbers = array($kpmr_ops_pil3_total1 , $kpmr_ops_pil3_total2, $kpmr_ops_pil3_total3, $kpmr_ops_pil3_total4);
        $kpmr_ops_pil3_maxValue = max($numbers);
        $kpmr_ops_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil3_average = $sum / count($numbers);

        $kpmr_ops_pil3_tingkat_risiko = $kpmr_ops_pil3_minValue;
    } else if ($set_ops_pil3 == 3) {
        $numbers = array($kpmr_ops_pil3_total1 , $kpmr_ops_pil3_total2, $kpmr_ops_pil3_total3, $kpmr_ops_pil3_total4);
        $kpmr_ops_pil3_maxValue = max($numbers);
        $kpmr_ops_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil3_average = $sum / count($numbers);

        $kpmr_ops_pil3_tingkat_risiko = $kpmr_ops_pil3_average;
    } else {
       $kpmr_ops_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_ops_pil4 == 1) {
        $numbers = array($kpmr_ops_pil4_total1 , $kpmr_ops_pil4_total2);
        $kpmr_ops_pil4_maxValue = max($numbers);
        $kpmr_ops_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil4_average = $sum / count($numbers);

        $kpmr_ops_pil4_tingkat_risiko = $kpmr_ops_pil4_maxValue ;
    } else if ($set_ops_pil4 == 2) {
        $numbers = array($kpmr_ops_pil4_total1 , $kpmr_ops_pil4_total2);
        $kpmr_ops_pil4_maxValue = max($numbers);
        $kpmr_ops_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil4_average = $sum / count($numbers);

        $kpmr_ops_pil4_tingkat_risiko = $kpmr_ops_pil4_minValue;
    } else if ($set_ops_pil4 == 3) {
        $numbers = array($kpmr_ops_pil4_total1 , $kpmr_ops_pil4_total2);
        $kpmr_ops_pil4_maxValue = max($numbers);
        $kpmr_ops_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_ops_pil4_average = $sum / count($numbers);

        $kpmr_ops_pil4_tingkat_risiko = $kpmr_ops_pil4_average;
    } else {
    $kpmr_ops_pil4_tingkat_risiko = 0;
    }

    $result_inheren_kep_pilar1_2 = getMaxInherenWithKet(
        $data,
        'inheren_kepatuhan_pilar1','pilar1_2',
        'ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2',
        [135,143]
    );
    $inheren_kep_pilar1_2 = $result_inheren_kep_pilar1_2['nilai'];
    $ket_in_kep_pil1_2    = $result_inheren_kep_pilar1_2['ket'];

    //inheren kepatuhan pilar 1
    $inheren_kep_pilar1_1 = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1'] ?? 0;
    $inheren_kep_pilar1_1a = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1a'] ?? 0;
    $inheren_kep_pilar1_1b = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1b'] ?? 0;
    $inheren_kep_pilar1_1c = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1c'] ?? 0;
    $inheren_kep_pilar1_1d = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1d'] ?? 0;
    $inheren_kep_pilar1_1e = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1e'] ?? 0;
    $inheren_kep_pilar1_1f = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1f'] ?? 0;
    $inheren_kep_pilar1_1g = $data['inheren_kepatuhan_pilar1'][135]['pilar1_1g'] ?? 0;
    
    $inheren_kep_pilar1_2a = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2a'] ?? 0;
    $inheren_kep_pilar1_2b = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2b'] ?? 0;
    $inheren_kep_pilar1_2c = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2c'] ?? 0;
    $inheren_kep_pilar1_2d = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2d'] ?? 0;
    $inheren_kep_pilar1_2e = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2e'] ?? 0;
    $inheren_kep_pilar1_2f = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2f'] ?? 0;
    $inheren_kep_pilar1_2g = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2g'] ?? 0;
    $inheren_kep_pilar1_2h = $data['inheren_kepatuhan_pilar1'][135]['pilar1_2h'] ?? 0;
    $inheren_kep_average_pil1_1 = $data['inheren_kepatuhan_pilar1'][135]['average_pil1_1'] ?? 0;
    $inheren_kep_average_pil1_2 = $data['inheren_kepatuhan_pilar1'][135]['average_pil1_2'] ?? 0;
    $inheren_kep_min_pil1_1 = $data['inheren_kepatuhan_pilar1'][135]['min_pil1_1'] ?? 0;
    $inheren_kep_min_pil1_2 = $data['inheren_kepatuhan_pilar1'][135]['min_pil1_2'] ?? 0;
    $inheren_kep_max_pil1_1 = $data['inheren_kepatuhan_pilar1'][135]['max_pil1_1'] ?? 0;
    $inheren_kep_max_pil1_2 = $data['inheren_kepatuhan_pilar1'][135]['max_pil1_2'] ?? 0;
    $inheren_kep_hasil_pil1_par1 = $data['inheren_kepatuhan_pilar1'][135]['hasil_pil1_par1'] ?? 0;
    $inheren_kep_hasil_pil1_par2 = $data['inheren_kepatuhan_pilar1'][135]['hasil_pil1_par2'] ?? 0;

    $ket_in_kep_pil1_1  = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1']  ?? 0;
    $ket_in_kep_pil1_1a = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1a'] ?? 0;
    $ket_in_kep_pil1_1b = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1b'] ?? 0;
    $ket_in_kep_pil1_1c = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1c'] ?? 0;
    $ket_in_kep_pil1_1d = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1d'] ?? 0;
    $ket_in_kep_pil1_1e = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1e'] ?? 0;
    $ket_in_kep_pil1_1f = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1f'] ?? 0;
    $ket_in_kep_pil1_1g = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_1g'] ?? 0;
    
    $ket_in_kep_pil1_2a = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2a'] ?? 0;
    $ket_in_kep_pil1_2b = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2b'] ?? 0;
    $ket_in_kep_pil1_2c = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2c'] ?? 0;
    $ket_in_kep_pil1_2d = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2d'] ?? 0;
    $ket_in_kep_pil1_2e = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2e'] ?? 0;
    $ket_in_kep_pil1_2f = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2f'] ?? 0;
    $ket_in_kep_pil1_2g = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2g'] ?? 0;
    $ket_in_kep_pil1_2h = $data['ket_inheren_kepatuhan_pilar1'][135]['ket_in_kep_pil1_2h'] ?? 0;

    


    //inheren kepatuhan pilar 2
    $inheren_kep_pilar2_1 = $data['inheren_kepatuhan_pilar2'][136]['pilar2_1'] ?? 0;
    $inheren_kep_pilar2_1a = $data['inheren_kepatuhan_pilar2'][136]['pilar2_1a'] ?? 0;
    $inheren_kep_pilar2_2 = $data['inheren_kepatuhan_pilar2'][136]['pilar2_2'] ?? 0;
    $inheren_kep_pilar2_2a = $data['inheren_kepatuhan_pilar2'][136]['pilar2_2a'] ?? 0;
    $inheren_kep_pilar2_3 = $data['inheren_kepatuhan_pilar2'][136]['pilar2_3'] ?? 0;
    $inheren_kep_pilar2_3a = $data['inheren_kepatuhan_pilar2'][136]['pilar2_3a'] ?? 0;
    $inheren_kep_average_pil2_1 = $data['inheren_kepatuhan_pilar2'][136]['average_pil2_1'] ?? 0;
    $inheren_kep_average_pil2_2 = $data['inheren_kepatuhan_pilar2'][136]['average_pil2_2'] ?? 0;
    $inheren_kep_average_pil2_3 = $data['inheren_kepatuhan_pilar2'][136]['average_pil2_3'] ?? 0;
    $inheren_kep_min_pil2_1 = $data['inheren_kepatuhan_pilar2'][136]['min_pil2_1'] ?? 0;
    $inheren_kep_min_pil2_2 = $data['inheren_kepatuhan_pilar2'][136]['min_pil2_2'] ?? 0;
    $inheren_kep_min_pil2_3 = $data['inheren_kepatuhan_pilar2'][136]['min_pil2_3'] ?? 0;
    $inheren_kep_max_pil2_1 = $data['inheren_kepatuhan_pilar2'][136]['max_pil2_1'] ?? 0;
    $inheren_kep_max_pil2_2 = $data['inheren_kepatuhan_pilar2'][136]['max_pil2_2'] ?? 0;
    $inheren_kep_max_pil2_3 = $data['inheren_kepatuhan_pilar2'][136]['max_pil2_3'] ?? 0;
    $inheren_kep_hasil_pil2_par1 = $data['inheren_kepatuhan_pilar2'][136]['hasil_pil2_par1'] ?? 0;
    $inheren_kep_hasil_pil2_par2 = $data['inheren_kepatuhan_pilar2'][136]['hasil_pil2_par2'] ?? 0;
    $inheren_kep_hasil_pil2_par3 = $data['inheren_kepatuhan_pilar2'][136]['hasil_pil2_par3'] ?? 0;

    $ket_in_kep_pil2_1  = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_1']  ?? 0;
    $ket_in_kep_pil2_1a = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_1a'] ?? 0;
    $ket_in_kep_pil2_2  = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_2']  ?? 0;
    $ket_in_kep_pil2_2a = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_2a'] ?? 0;
    $ket_in_kep_pil2_3  = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_3']  ?? 0;
    $ket_in_kep_pil2_3a = $data['ket_inheren_kepatuhan_pilar2'][136]['ket_in_kep_pil2_3a'] ?? 0;

    
    

    //inheren kepatuhan pilar 3
    $inheren_kep_pilar3_1a = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1a'] ?? 0;
    $inheren_kep_pilar3_1b = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1b'] ?? 0;
    $inheren_kep_pilar3_1c = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1c'] ?? 0;
    $inheren_kep_pilar3_1d = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1d'] ?? 0;
    $inheren_kep_pilar3_1e = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1e'] ?? 0;
    $inheren_kep_pilar3_1f = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1f'] ?? 0;
    $inheren_kep_pilar3_1g = $data['inheren_kepatuhan_lainnya'][135]['pilar3_1g'] ?? 0;
    $inheren_kep_average_pil3_1 = $data['inheren_kepatuhan_lainnya'][135]['average_pil3_1'] ?? 0;
    $inheren_kep_min_pil3_1 = $data['inheren_kepatuhan_lainnya'][135]['min_pil3_1'] ?? 0;
    $inheren_kep_max_pil3_1 = $data['inheren_kepatuhan_lainnya'][135]['max_pil3_1'] ?? 0;
    $inheren_kep_hasil_pil3_par1 = $data['inheren_kepatuhan_lainnya'][135]['hasil_pil3_par1'] ?? 0;

    $ket_in_kep_pil3_1a = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1a'] ?? 0;
    $ket_in_kep_pil3_1b = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1b'] ?? 0;
    $ket_in_kep_pil3_1c = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1c'] ?? 0;
    $ket_in_kep_pil3_1d = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1d'] ?? 0;
    $ket_in_kep_pil3_1e = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1e'] ?? 0;
    $ket_in_kep_pil3_1f = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1f'] ?? 0;
    $ket_in_kep_pil3_1g = $data['ket_inheren_kepatuhan_lainnya'][135]['ket_in_kep_pil3_1g'] ?? 0;

    $kpmr_kep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kepatuhan WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_kep_pilar1_1a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_1a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1a',[135,136]);
    $result_kpmr_kep_pilar1_1b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_1b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1b',[135,136]);
    $result_kpmr_kep_pilar1_1c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_1c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1c',[135,136]);
    $result_kpmr_kep_pilar1_1d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_1d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1d',[135,136]);
    $result_kpmr_kep_pilar1_1e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_1e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1e',[135,136]);
    
    $result_kpmr_kep_pilar1_2a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_2a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2a',[135,136]);
    $result_kpmr_kep_pilar1_2b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_2b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2b',[135,136]);
    $result_kpmr_kep_pilar1_2c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_2c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2c',[135,136]);
    $result_kpmr_kep_pilar1_2d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_2d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2d',[135,136]);
    $result_kpmr_kep_pilar1_2e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_2e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2e',[135,136]);
    
    $result_kpmr_kep_pilar1_3a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_3a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3a',[135,136]);
    $result_kpmr_kep_pilar1_3b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_3b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3b',[135,136]);
    $result_kpmr_kep_pilar1_3c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_3c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3c',[135,136]);
    
    $result_kpmr_kep_pilar1_4a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_4a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4a',[135,136]);
    $result_kpmr_kep_pilar1_4b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_4b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4b',[135,136]);
    $result_kpmr_kep_pilar1_4c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_4c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4c',[135,136]);
    $result_kpmr_kep_pilar1_4d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_4d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4d',[135,136]);
    $result_kpmr_kep_pilar1_4e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_4e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4e',[135,136]);
    
    $result_kpmr_kep_pilar1_5a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_5a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5a',[135,136]);
    $result_kpmr_kep_pilar1_5b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_5b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5b',[135,136]);
    $result_kpmr_kep_pilar1_5c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_5c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5c',[135,136]);
    $result_kpmr_kep_pilar1_5d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_5d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5d',[135,136]);
    
    $result_kpmr_kep_pilar1_6a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_6a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6a',[135,136]);
    $result_kpmr_kep_pilar1_6b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_6b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6b',[135,136]);
    $result_kpmr_kep_pilar1_6c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_6c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6c',[135,136]);
    
    $result_kpmr_kep_pilar1_7a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_7a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7a',[135,136]);
    $result_kpmr_kep_pilar1_7b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_7b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7b',[135,136]);
    $result_kpmr_kep_pilar1_7c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar1','pilar1_7c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7c',[135,136]);
    

    $result_kpmr_kep_pilar2_1a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_1a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1a',[135,136]);
    $result_kpmr_kep_pilar2_1b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_1b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1b',[135,136]);
    $result_kpmr_kep_pilar2_1c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_1c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1c',[135,136]);
    $result_kpmr_kep_pilar2_1d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_1d','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1d',[135,136]);
    $result_kpmr_kep_pilar2_1e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_1e','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1e',[135,136]);

    $result_kpmr_kep_pilar2_2a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2a',[135,136]);
    $result_kpmr_kep_pilar2_2b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2b',[135,136]);
    $result_kpmr_kep_pilar2_2c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2c',[135,136]);
    $result_kpmr_kep_pilar2_2d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2d','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2d',[135,136]);
    $result_kpmr_kep_pilar2_2e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2e','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2e',[135,136]);
    $result_kpmr_kep_pilar2_2f = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2f','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2f',[135,136]);
    $result_kpmr_kep_pilar2_2g = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2g','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2g',[135,136]);
    $result_kpmr_kep_pilar2_2h = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_2h','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2h',[135,136]);

    $result_kpmr_kep_pilar2_3a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_3a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3a',[135,136]);
    $result_kpmr_kep_pilar2_3b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_3b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3b',[135,136]);
    $result_kpmr_kep_pilar2_3c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar2','pilar2_3c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3c',[135,136]);


    $result_kpmr_kep_pilar3_1a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1a','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1a',[135,136]);
    $result_kpmr_kep_pilar3_1b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1b','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1b',[135,136]);
    $result_kpmr_kep_pilar3_1c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1c','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1c',[135,136]);
    $result_kpmr_kep_pilar3_1d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1d','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1d',[135,136]);
    $result_kpmr_kep_pilar3_1e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1e','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1e',[135,136]);
    $result_kpmr_kep_pilar3_1f = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1f','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1f',[135,136]);
    $result_kpmr_kep_pilar3_1g = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1g','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1g',[135,136]);
    $result_kpmr_kep_pilar3_1h = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1h','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1h',[135,136]);
    $result_kpmr_kep_pilar3_1i = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1i','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1i',[135,136]);
    $result_kpmr_kep_pilar3_1j = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_1j','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1j',[135,136]);

    $result_kpmr_kep_pilar3_2a = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_2a','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1a',[135,136]);
    $result_kpmr_kep_pilar3_2b = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_2b','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1b',[135,136]);
    $result_kpmr_kep_pilar3_2c = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_2c','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1c',[135,136]);
    $result_kpmr_kep_pilar3_2d = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_2d','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1d',[135,136]);
    $result_kpmr_kep_pilar3_2e = getMaxValueWithRespon($data,'kpmr_kepatuhan_pilar3','pilar3_2e','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1e',[135,136]);



    //implemen

$kpmr_kep_pilar1_1a = $result_kpmr_kep_pilar1_1a['nilai']; $kpmr_kep_respon_pil1_1a = $result_kpmr_kep_pilar1_1a['respon'];
$kpmr_kep_pilar1_1b = $result_kpmr_kep_pilar1_1b['nilai']; $kpmr_kep_respon_pil1_1b = $result_kpmr_kep_pilar1_1b['respon'];
$kpmr_kep_pilar1_1c = $result_kpmr_kep_pilar1_1c['nilai']; $kpmr_kep_respon_pil1_1c = $result_kpmr_kep_pilar1_1c['respon'];
$kpmr_kep_pilar1_1d = $result_kpmr_kep_pilar1_1d['nilai']; $kpmr_kep_respon_pil1_1d = $result_kpmr_kep_pilar1_1d['respon'];
$kpmr_kep_pilar1_1e = $result_kpmr_kep_pilar1_1e['nilai']; $kpmr_kep_respon_pil1_1e = $result_kpmr_kep_pilar1_1e['respon'];



$kpmr_kep_pil1_total1_average = array($kpmr_kep_pilar1_1a,
$kpmr_kep_pilar1_1b,
$kpmr_kep_pilar1_1c,
$kpmr_kep_pilar1_1d,
$kpmr_kep_pilar1_1e);
        $kpmr_kep_pil1_total1_sum = array_sum($kpmr_kep_pil1_total1_average);
        $kpmr_kep_pil1_total1 = $kpmr_kep_pil1_total1_sum / count($kpmr_kep_pil1_total1_average);

if ($kpmr_kep_pil1_total1 < 1.00) {
    $kpmr_kep_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total1 >= 1.00 && $kpmr_kep_pil1_total1 < 1.25) {
    $kpmr_kep_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total1 >= 1.25 && $kpmr_kep_pil1_total1 < 2.25) {
    $kpmr_kep_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_kep_pil1_total1 >= 2.25 && $kpmr_kep_pil1_total1 < 3.25) {
    $kpmr_kep_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total1 >= 3.25 && $kpmr_kep_pil1_total1 < 4.25) {
    $kpmr_kep_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total1 >= 4.25 && $kpmr_kep_pil1_total1 <= 5.00) {
    $kpmr_kep_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_kep_pilar1_2a = $result_kpmr_kep_pilar1_2a['nilai']; $kpmr_kep_respon_pil1_2a = $result_kpmr_kep_pilar1_2a['respon'];
$kpmr_kep_pilar1_2b = $result_kpmr_kep_pilar1_2b['nilai']; $kpmr_kep_respon_pil1_2b = $result_kpmr_kep_pilar1_2b['respon'];
$kpmr_kep_pilar1_2c = $result_kpmr_kep_pilar1_2c['nilai']; $kpmr_kep_respon_pil1_2c = $result_kpmr_kep_pilar1_2c['respon'];
$kpmr_kep_pilar1_2d = $result_kpmr_kep_pilar1_2d['nilai']; $kpmr_kep_respon_pil1_2d = $result_kpmr_kep_pilar1_2d['respon'];
$kpmr_kep_pilar1_2e = $result_kpmr_kep_pilar1_2e['nilai']; $kpmr_kep_respon_pil1_2e = $result_kpmr_kep_pilar1_2e['respon'];


$kpmr_kep_pil1_total2_average = array($kpmr_kep_pilar1_2a,
$kpmr_kep_pilar1_2b,
$kpmr_kep_pilar1_2c,
$kpmr_kep_pilar1_2d,
$kpmr_kep_pilar1_2e);
$kpmr_kep_pil1_total2_sum = array_sum($kpmr_kep_pil1_total2_average);
$kpmr_kep_pil1_total2 = $kpmr_kep_pil1_total2_sum / count($kpmr_kep_pil1_total2_average);

if ($kpmr_kep_pil1_total2 < 1.00) {
    $kpmr_kep_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total2 >= 1.00 && $kpmr_kep_pil1_total2 < 1.25) {
    $kpmr_kep_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total2 >= 1.25 && $kpmr_kep_pil1_total2 < 2.25) {
    $kpmr_kep_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_kep_pil1_total2 >= 2.25 && $kpmr_kep_pil1_total2 < 3.25) {
    $kpmr_kep_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total2 >= 3.25 && $kpmr_kep_pil1_total2 < 4.25) {
    $kpmr_kep_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total2 >= 4.25 && $kpmr_kep_pil1_total2 <= 5.00) {
    $kpmr_kep_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_kep_pilar1_3a = $result_kpmr_kep_pilar1_3a['nilai']; $kpmr_kep_respon_pil1_3a = $result_kpmr_kep_pilar1_3a['respon'];
$kpmr_kep_pilar1_3b = $result_kpmr_kep_pilar1_3b['nilai']; $kpmr_kep_respon_pil1_3b = $result_kpmr_kep_pilar1_3b['respon'];
$kpmr_kep_pilar1_3c = $result_kpmr_kep_pilar1_3c['nilai']; $kpmr_kep_respon_pil1_3c = $result_kpmr_kep_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_kep_pil1_total3_average = array($kpmr_kep_pilar1_3a,
$kpmr_kep_pilar1_3b,
$kpmr_kep_pilar1_3c);
$kpmr_kep_pil1_total3_sum = array_sum($kpmr_kep_pil1_total3_average);
$kpmr_kep_pil1_total3 = $kpmr_kep_pil1_total3_sum / count($kpmr_kep_pil1_total3_average);

if ($kpmr_kep_pil1_total3 < 1.00) {
    $kpmr_kep_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total3 >= 1.00 && $kpmr_kep_pil1_total3 < 1.25) {
    $kpmr_kep_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total3 >= 1.25 && $kpmr_kep_pil1_total3 < 2.25) {
    $kpmr_kep_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_kep_pil1_total3 >= 2.25 && $kpmr_kep_pil1_total3 < 3.25) {
    $kpmr_kep_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total3 >= 3.25 && $kpmr_kep_pil1_total3 < 4.25) {
    $kpmr_kep_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total3 >= 4.25 && $kpmr_kep_pil1_total3 <= 5.00) {
    $kpmr_kep_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_kep_pilar1_4a = $result_kpmr_kep_pilar1_4a['nilai']; $kpmr_kep_respon_pil1_4a = $result_kpmr_kep_pilar1_4a['respon'];
$kpmr_kep_pilar1_4b = $result_kpmr_kep_pilar1_4b['nilai']; $kpmr_kep_respon_pil1_4b = $result_kpmr_kep_pilar1_4b['respon'];
$kpmr_kep_pilar1_4c = $result_kpmr_kep_pilar1_4c['nilai']; $kpmr_kep_respon_pil1_4c = $result_kpmr_kep_pilar1_4c['respon'];
$kpmr_kep_pilar1_4d = $result_kpmr_kep_pilar1_4d['nilai']; $kpmr_kep_respon_pil1_4d = $result_kpmr_kep_pilar1_4d['respon'];
$kpmr_kep_pilar1_4e = $result_kpmr_kep_pilar1_4e['nilai']; $kpmr_kep_respon_pil1_4e = $result_kpmr_kep_pilar1_4e['respon'];


$kpmr_kep_pil1_total4_average = array($kpmr_kep_pilar1_4a,
$kpmr_kep_pilar1_4b,
$kpmr_kep_pilar1_4c,
$kpmr_kep_pilar1_4d,
$kpmr_kep_pilar1_4e);
$kpmr_kep_pil1_total4_sum = array_sum($kpmr_kep_pil1_total4_average);
$kpmr_kep_pil1_total4 = $kpmr_kep_pil1_total4_sum / count($kpmr_kep_pil1_total4_average);

if ($kpmr_kep_pil1_total4 < 1.00) {
    $kpmr_kep_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total4 >= 1.00 && $kpmr_kep_pil1_total4 < 1.25) {
    $kpmr_kep_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total4 >= 1.25 && $kpmr_kep_pil1_total4 < 2.25) {
    $kpmr_kep_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_kep_pil1_total4 >= 2.25 && $kpmr_kep_pil1_total4 < 3.25) {
    $kpmr_kep_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total4 >= 3.25 && $kpmr_kep_pil1_total4 < 4.25) {
    $kpmr_kep_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total4 >= 4.25 && $kpmr_kep_pil1_total4 <= 5.00) {
    $kpmr_kep_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_kep_pilar1_5a = $result_kpmr_kep_pilar1_5a['nilai']; $kpmr_kep_respon_pil1_5a = $result_kpmr_kep_pilar1_5a['respon'];
$kpmr_kep_pilar1_5b = $result_kpmr_kep_pilar1_5b['nilai']; $kpmr_kep_respon_pil1_5b = $result_kpmr_kep_pilar1_5b['respon'];
$kpmr_kep_pilar1_5c = $result_kpmr_kep_pilar1_5c['nilai']; $kpmr_kep_respon_pil1_5c = $result_kpmr_kep_pilar1_5c['respon'];
$kpmr_kep_pilar1_5d = $result_kpmr_kep_pilar1_5d['nilai']; $kpmr_kep_respon_pil1_5d = $result_kpmr_kep_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_kep_pil1_total5_average = array($kpmr_kep_pilar1_5a,
$kpmr_kep_pilar1_5b,
$kpmr_kep_pilar1_5c,
$kpmr_kep_pilar1_5);
$kpmr_kep_pil1_total5_sum = array_sum($kpmr_kep_pil1_total5_average);
$kpmr_kep_pil1_total5 = $kpmr_kep_pil1_total5_sum / count($kpmr_kep_pil1_total5_average);

if ($kpmr_kep_pil1_total5 < 1.00) {
    $kpmr_kep_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total5 >= 1.00 && $kpmr_kep_pil1_total5 < 1.25) {
    $kpmr_kep_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total5 >= 1.25 && $kpmr_kep_pil1_total5 < 2.25) {
    $kpmr_kep_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_kep_pil1_total5 >= 2.25 && $kpmr_kep_pil1_total5 < 3.25) {
    $kpmr_kep_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total5 >= 3.25 && $kpmr_kep_pil1_total5 < 4.25) {
    $kpmr_kep_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total5 >= 4.25 && $kpmr_kep_pil1_total5 <= 5.00) {
    $kpmr_kep_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_kep_pilar1_6a = $result_kpmr_kep_pilar1_6a['nilai']; $kpmr_kep_respon_pil1_6a = $result_kpmr_kep_pilar1_6a['respon'];
$kpmr_kep_pilar1_6b = $result_kpmr_kep_pilar1_6b['nilai']; $kpmr_kep_respon_pil1_6b = $result_kpmr_kep_pilar1_6b['respon'];
$kpmr_kep_pilar1_6c = $result_kpmr_kep_pilar1_6c['nilai']; $kpmr_kep_respon_pil1_6c = $result_kpmr_kep_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_kep_pil1_total6_average = array($kpmr_kep_pilar1_6a,
$kpmr_kep_pilar1_6b,
$kpmr_kep_pilar1_6c);
$kpmr_kep_pil1_total6_sum = array_sum($kpmr_kep_pil1_total6_average);
$kpmr_kep_pil1_total6 = $kpmr_kep_pil1_total6_sum / count($kpmr_kep_pil1_total6_average);

if ($kpmr_kep_pil1_total6 < 1.00) {
    $kpmr_kep_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total6 >= 1.00 && $kpmr_kep_pil1_total6 < 1.25) {
    $kpmr_kep_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total6 >= 1.25 && $kpmr_kep_pil1_total6 < 2.25) {
    $kpmr_kep_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_kep_pil1_total6 >= 2.25 && $kpmr_kep_pil1_total6 < 3.25) {
    $kpmr_kep_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total6 >= 3.25 && $kpmr_kep_pil1_total6 < 4.25) {
    $kpmr_kep_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total6 >= 4.25 && $kpmr_kep_pil1_total6 <= 5.00) {
    $kpmr_kep_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat6 = "Belum Terisi";
}

$kpmr_kep_pilar1_7a = $result_kpmr_kep_pilar1_7a['nilai']; $kpmr_kep_respon_pil1_7a = $result_kpmr_kep_pilar1_7a['respon'];
$kpmr_kep_pilar1_7b = $result_kpmr_kep_pilar1_7b['nilai']; $kpmr_kep_respon_pil1_7b = $result_kpmr_kep_pilar1_7b['respon'];
$kpmr_kep_pilar1_7c = $result_kpmr_kep_pilar1_7c['nilai']; $kpmr_kep_respon_pil1_7c = $result_kpmr_kep_pilar1_7c['respon'];

// --- Total 7 ---
$kpmr_kep_pil1_total7_average = array($kpmr_kep_pilar1_7a,
$kpmr_kep_pilar1_7b,
$kpmr_kep_pilar1_7c);
$kpmr_kep_pil1_total7_sum = array_sum($kpmr_kep_pil1_total7_average);
$kpmr_kep_pil1_total7 = $kpmr_kep_pil1_total7_sum / count($kpmr_kep_pil1_total7_average);

if ($kpmr_kep_pil1_total7 < 1.00) {
    $kpmr_kep_pil1_peringkat7 = "Belum Terisi";
} elseif ($kpmr_kep_pil1_total7 >= 1.00 && $kpmr_kep_pil1_total7 < 1.25) {
    $kpmr_kep_pil1_peringkat7 = "Sangat Memadai";
} elseif ($kpmr_kep_pil1_total7 >= 1.25 && $kpmr_kep_pil1_total7 < 2.25) {
    $kpmr_kep_pil1_peringkat7 = "Memadai";
} elseif ($kpmr_kep_pil1_total7 >= 2.25 && $kpmr_kep_pil1_total7 < 3.25) {
    $kpmr_kep_pil1_peringkat7 = "Cukup Memadai";
} elseif ($kpmr_kep_pil1_total7 >= 3.25 && $kpmr_kep_pil1_total7 < 4.25) {
    $kpmr_kep_pil1_peringkat7 = "Kurang Memadai";
} elseif ($kpmr_kep_pil1_total7 >= 4.25 && $kpmr_kep_pil1_total7 <= 5.00) {
    $kpmr_kep_pil1_peringkat7 = "Tidak Memadai";
} else {
    $kpmr_kep_pil1_peringkat7 = "Belum Terisi";
}


        
$kpmr_kep_pilar2_1a = $result_kpmr_kep_pilar2_1a['nilai']; $kpmr_kep_respon_pil2_1a = $result_kpmr_kep_pilar2_1a['respon'];
$kpmr_kep_pilar2_1b = $result_kpmr_kep_pilar2_1b['nilai']; $kpmr_kep_respon_pil2_1b = $result_kpmr_kep_pilar2_1b['respon'];
$kpmr_kep_pilar2_1c = $result_kpmr_kep_pilar2_1c['nilai']; $kpmr_kep_respon_pil2_1c = $result_kpmr_kep_pilar2_1c['respon'];
$kpmr_kep_pilar2_1d = $result_kpmr_kep_pilar2_1d['nilai']; $kpmr_kep_respon_pil2_1d = $result_kpmr_kep_pilar2_1d['respon'];
$kpmr_kep_pilar2_1e = $result_kpmr_kep_pilar2_1e['nilai']; $kpmr_kep_respon_pil2_1e = $result_kpmr_kep_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_kep_pil2_total1_average = array($kpmr_kep_pilar2_1a,
$kpmr_kep_pilar2_1b,
$kpmr_kep_pilar2_1c,
$kpmr_kep_pilar2_1d,
$kpmr_kep_pilar2_1e);
$kpmr_kep_pil2_total1_sum = array_sum($kpmr_kep_pil2_total1_average);
$kpmr_kep_pil2_total1 = $kpmr_kep_pil2_total1_sum / count($kpmr_kep_pil2_total1_average);

if ($kpmr_kep_pil2_total1 < 1.00) {
    $kpmr_kep_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kep_pil2_total1 >= 1.00 && $kpmr_kep_pil2_total1 < 1.25) {
    $kpmr_kep_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kep_pil2_total1 >= 1.25 && $kpmr_kep_pil2_total1 < 2.25) {
    $kpmr_kep_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_kep_pil2_total1 >= 2.25 && $kpmr_kep_pil2_total1 < 3.25) {
    $kpmr_kep_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kep_pil2_total1 >= 3.25 && $kpmr_kep_pil2_total1 < 4.25) {
    $kpmr_kep_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kep_pil2_total1 >= 4.25 && $kpmr_kep_pil2_total1 <= 5.00) {
    $kpmr_kep_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kep_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_kep_pilar2_2a = $result_kpmr_kep_pilar2_2a['nilai']; $kpmr_kep_respon_pil2_2a = $result_kpmr_kep_pilar2_2a['respon'];
$kpmr_kep_pilar2_2b = $result_kpmr_kep_pilar2_2b['nilai']; $kpmr_kep_respon_pil2_2b = $result_kpmr_kep_pilar2_2b['respon'];
$kpmr_kep_pilar2_2c = $result_kpmr_kep_pilar2_2c['nilai']; $kpmr_kep_respon_pil2_2c = $result_kpmr_kep_pilar2_2c['respon'];
$kpmr_kep_pilar2_2d = $result_kpmr_kep_pilar2_2d['nilai']; $kpmr_kep_respon_pil2_2d = $result_kpmr_kep_pilar2_2d['respon'];
$kpmr_kep_pilar2_2e = $result_kpmr_kep_pilar2_2e['nilai']; $kpmr_kep_respon_pil2_2e = $result_kpmr_kep_pilar2_2e['respon'];
$kpmr_kep_pilar2_2f = $result_kpmr_kep_pilar2_2f['nilai']; $kpmr_kep_respon_pil2_2f = $result_kpmr_kep_pilar2_2f['respon'];
$kpmr_kep_pilar2_2g = $result_kpmr_kep_pilar2_2g['nilai']; $kpmr_kep_respon_pil2_2g = $result_kpmr_kep_pilar2_2g['respon'];
$kpmr_kep_pilar2_2h = $result_kpmr_kep_pilar2_2h['nilai']; $kpmr_kep_respon_pil2_2h = $result_kpmr_kep_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_kep_pil2_total2_average = array($kpmr_kep_pilar2_2a,
$kpmr_kep_pilar2_2b,
$kpmr_kep_pilar2_2c,
$kpmr_kep_pilar2_2d,
$kpmr_kep_pilar2_2e,
$kpmr_kep_pilar2_2f,
$kpmr_kep_pilar2_2g,
$kpmr_kep_pilar2_2h);
$kpmr_kep_pil2_total2_sum = array_sum($kpmr_kep_pil2_total2_average);
$kpmr_kep_pil2_total2 = $kpmr_kep_pil2_total2_sum / count($kpmr_kep_pil2_total2_average);

if ($kpmr_kep_pil2_total2 < 1.00) {
    $kpmr_kep_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kep_pil2_total2 >= 1.00 && $kpmr_kep_pil2_total2 < 1.25) {
    $kpmr_kep_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kep_pil2_total2 >= 1.25 && $kpmr_kep_pil2_total2 < 2.25) {
    $kpmr_kep_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_kep_pil2_total2 >= 2.25 && $kpmr_kep_pil2_total2 < 3.25) {
    $kpmr_kep_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kep_pil2_total2 >= 3.25 && $kpmr_kep_pil2_total2 < 4.25) {
    $kpmr_kep_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kep_pil2_total2 >= 4.25 && $kpmr_kep_pil2_total2 <= 5.00) {
    $kpmr_kep_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kep_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_kep_pilar2_3a = $result_kpmr_kep_pilar2_3a['nilai']; $kpmr_kep_respon_pil2_3a = $result_kpmr_kep_pilar2_3a['respon'];
$kpmr_kep_pilar2_3b = $result_kpmr_kep_pilar2_3b['nilai']; $kpmr_kep_respon_pil2_3b = $result_kpmr_kep_pilar2_3b['respon'];
$kpmr_kep_pilar2_3c = $result_kpmr_kep_pilar2_3c['nilai']; $kpmr_kep_respon_pil2_3c = $result_kpmr_kep_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_kep_pil2_total3_average = array($kpmr_kep_pilar2_3a,
$kpmr_kep_pilar2_3b,
$kpmr_kep_pilar2_3c);
$kpmr_kep_pil2_total3_sum = array_sum($kpmr_kep_pil2_total3_average);
$kpmr_kep_pil2_total3 = $kpmr_kep_pil2_total3_sum / count($kpmr_kep_pil2_total3_average);

if ($kpmr_kep_pil2_total3 < 1.00) {
    $kpmr_kep_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_kep_pil2_total3 >= 1.00 && $kpmr_kep_pil2_total3 < 1.25) {
    $kpmr_kep_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_kep_pil2_total3 >= 1.25 && $kpmr_kep_pil2_total3 < 2.25) {
    $kpmr_kep_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_kep_pil2_total3 >= 2.25 && $kpmr_kep_pil2_total3 < 3.25) {
    $kpmr_kep_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_kep_pil2_total3 >= 3.25 && $kpmr_kep_pil2_total3 < 4.25) {
    $kpmr_kep_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_kep_pil2_total3 >= 4.25 && $kpmr_kep_pil2_total3 <= 5.00) {
    $kpmr_kep_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_kep_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_kep_pilar3_1a = $result_kpmr_kep_pilar3_1a['nilai']; $kpmr_kep_respon_pil3_1a = $result_kpmr_kep_pilar3_1a['respon'];
$kpmr_kep_pilar3_1b = $result_kpmr_kep_pilar3_1b['nilai']; $kpmr_kep_respon_pil3_1b = $result_kpmr_kep_pilar3_1b['respon'];
$kpmr_kep_pilar3_1c = $result_kpmr_kep_pilar3_1c['nilai']; $kpmr_kep_respon_pil3_1c = $result_kpmr_kep_pilar3_1c['respon'];
$kpmr_kep_pilar3_1d = $result_kpmr_kep_pilar3_1d['nilai']; $kpmr_kep_respon_pil3_1d = $result_kpmr_kep_pilar3_1d['respon'];
$kpmr_kep_pilar3_1e = $result_kpmr_kep_pilar3_1e['nilai']; $kpmr_kep_respon_pil3_1e = $result_kpmr_kep_pilar3_1e['respon'];
$kpmr_kep_pilar3_1f = $result_kpmr_kep_pilar3_1f['nilai']; $kpmr_kep_respon_pil3_1f = $result_kpmr_kep_pilar3_1f['respon'];
$kpmr_kep_pilar3_1g = $result_kpmr_kep_pilar3_1g['nilai']; $kpmr_kep_respon_pil3_1g = $result_kpmr_kep_pilar3_1g['respon'];
$kpmr_kep_pilar3_1h = $result_kpmr_kep_pilar3_1h['nilai']; $kpmr_kep_respon_pil3_1h = $result_kpmr_kep_pilar3_1h['respon'];
$kpmr_kep_pilar3_1i = $result_kpmr_kep_pilar3_1i['nilai']; $kpmr_kep_respon_pil3_1i = $result_kpmr_kep_pilar3_1i['respon'];
$kpmr_kep_pilar3_1j = $result_kpmr_kep_pilar3_1j['nilai']; $kpmr_kep_respon_pil3_1j = $result_kpmr_kep_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_kep_pil3_total1_average = array($kpmr_kep_pilar3_1a,
$kpmr_kep_pilar3_1b,
$kpmr_kep_pilar3_1c,
$kpmr_kep_pilar3_1d,
$kpmr_kep_pilar3_1e,
$kpmr_kep_pilar3_1f,
$kpmr_kep_pilar3_1g,
$kpmr_kep_pilar3_1h,
$kpmr_kep_pilar3_1i,
$kpmr_kep_pilar3_1j);
$kpmr_kep_pil3_total1_sum = array_sum($kpmr_kep_pil3_total1_average);
$kpmr_kep_pil3_total1 = $kpmr_kep_pil3_total1_sum / count($kpmr_kep_pil3_total1_average);

if ($kpmr_kep_pil3_total1 < 1.00) {
    $kpmr_kep_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kep_pil3_total1 >= 1.00 && $kpmr_kep_pil3_total1 < 1.25) {
    $kpmr_kep_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kep_pil3_total1 >= 1.25 && $kpmr_kep_pil3_total1 < 2.25) {
    $kpmr_kep_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_kep_pil3_total1 >= 2.25 && $kpmr_kep_pil3_total1 < 3.25) {
    $kpmr_kep_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kep_pil3_total1 >= 3.25 && $kpmr_kep_pil3_total1 < 4.25) {
    $kpmr_kep_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kep_pil3_total1 >= 4.25 && $kpmr_kep_pil3_total1 <= 5.00) {
    $kpmr_kep_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kep_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_kep_pilar3_2a = $result_kpmr_kep_pilar3_2a['nilai']; $kpmr_kep_respon_pil3_2a = $result_kpmr_kep_pilar3_2a['respon'];
$kpmr_kep_pilar3_2b = $result_kpmr_kep_pilar3_2b['nilai']; $kpmr_kep_respon_pil3_2b = $result_kpmr_kep_pilar3_2b['respon'];
$kpmr_kep_pilar3_2c = $result_kpmr_kep_pilar3_2c['nilai']; $kpmr_kep_respon_pil3_2c = $result_kpmr_kep_pilar3_2c['respon'];
$kpmr_kep_pilar3_2d = $result_kpmr_kep_pilar3_2d['nilai']; $kpmr_kep_respon_pil3_2d = $result_kpmr_kep_pilar3_2d['respon'];
$kpmr_kep_pilar3_2e = $result_kpmr_kep_pilar3_2e['nilai']; $kpmr_kep_respon_pil3_2e = $result_kpmr_kep_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_kep_pil3_total2_average = array($kpmr_kep_pilar3_2a,
$kpmr_kep_pilar3_2b,
$kpmr_kep_pilar3_2c,
$kpmr_kep_pilar3_2d,
$kpmr_kep_pilar3_2e);
$kpmr_kep_pil3_total2_sum = array_sum($kpmr_kep_pil3_total2_average);
$kpmr_kep_pil3_total2 = $kpmr_kep_pil3_total2_sum / count($kpmr_kep_pil3_total2_average);

if ($kpmr_kep_pil3_total2 < 1.00) {
    $kpmr_kep_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kep_pil3_total2 >= 1.00 && $kpmr_kep_pil3_total2 < 1.25) {
    $kpmr_kep_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kep_pil3_total2 >= 1.25 && $kpmr_kep_pil3_total2 < 2.25) {
    $kpmr_kep_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_kep_pil3_total2 >= 2.25 && $kpmr_kep_pil3_total2 < 3.25) {
    $kpmr_kep_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kep_pil3_total2 >= 3.25 && $kpmr_kep_pil3_total2 < 4.25) {
    $kpmr_kep_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kep_pil3_total2 >= 4.25 && $kpmr_kep_pil3_total2 <= 5.00) {
    $kpmr_kep_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kep_pil3_peringkat2 = "Belum Terisi";
}

    $kpmr_kep_pilar4_1a = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_1a'] ?? 0;
    $kpmr_kep_pilar4_1b = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_1b'] ?? 0;
    $kpmr_kep_pilar4_1c = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_1c'] ?? 0;
    $kpmr_kep_pilar4_1d = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_1d'] ?? 0;
    $kpmr_kep_pilar4_1e = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_1e'] ?? 0;
    $kpmr_kep_pil4_total1 = $data['kpmr_kepatuhan_pilar4'][143]['pil4_total1'] ?? 0;
    $kpmr_kep_pil4_peringkat1 = $data['kpmr_kepatuhan_pilar4'][143]['pil4_peringkat1'] ?? 0;
    $kpmr_kep_pilar4_2a = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_2a'] ?? 0;
    $kpmr_kep_pilar4_2b = $data['kpmr_kepatuhan_pilar4'][143]['pilar4_2b'] ?? 0;
    $kpmr_kep_pil4_total2 = $data['kpmr_kepatuhan_pilar4'][143]['pil4_total2'] ?? 0;
    $kpmr_kep_pil4_peringkat2 = $data['kpmr_kepatuhan_pilar4'][143]['pil4_peringkat2'] ?? 0;

    $kpmr_kep_respon_pil4_1a = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_1a'] ?? 0;
    $kpmr_kep_respon_pil4_1b = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_1b'] ?? 0;
    $kpmr_kep_respon_pil4_1c = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_1c'] ?? 0;
    $kpmr_kep_respon_pil4_1d = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_1d'] ?? 0;
    $kpmr_kep_respon_pil4_1e = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_1e'] ?? 0;
    $kpmr_kep_respon_pil4_2a = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_2a'] ?? 0;
    $kpmr_kep_respon_pil4_2b = $data['respon_unit_kerja_kepatuhan_pil4'][143]['respon_pil4_2b'] ?? 0;


//rumus KPMR kep
//setingan ditetapkan
$kpmr_kep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kepatuhan WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_kep_pil1 = $kpmr_kep['kpmr_kep_set_pil1'];
$set_kep_pil2 = $kpmr_kep['kpmr_kep_set_pil2'];
$set_kep_pil3 = $kpmr_kep['kpmr_kep_set_pil3'];
$set_kep_pil4 = $kpmr_kep['kpmr_kep_set_pil4'];
$set_kep_hsl = $kpmr_kep['kpmr_kep_set_tingkat_risiko'];



    if ($set_kep_pil1 == 1) {
        $numbers = array($kpmr_kep_pil1_total1 , $kpmr_kep_pil1_total2, $kpmr_kep_pil1_total3, $kpmr_kep_pil1_total4, $kpmr_kep_pil1_total5, $kpmr_kep_pil1_total6, $kpmr_kep_pil1_total7);
        $kpmr_kep_pil1_maxValue = max($numbers);
        $kpmr_kep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil1_average = $sum / count($numbers);
        $kpmr_kep_pil1_tingkat_risiko = $kpmr_kep_pil1_maxValue ;
    } else if ($set_kep_pil1 == 2) {
        $numbers = array($kpmr_kep_pil1_total1 , $kpmr_kep_pil1_total2, $kpmr_kep_pil1_total3, $kpmr_kep_pil1_total4, $kpmr_kep_pil1_total5, $kpmr_kep_pil1_total6, $kpmr_kep_pil1_total7);
        $kpmr_kep_pil1_maxValue = max($numbers);
        $kpmr_kep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil1_average = $sum / count($numbers);

        $kpmr_kep_pil1_tingkat_risiko = $kpmr_kep_pil1_minValue;
    } else if ($set_kep_pil1 == 3) {
        $numbers = array($kpmr_kep_pil1_total1 , $kpmr_kep_pil1_total2, $kpmr_kep_pil1_total3, $kpmr_kep_pil1_total4, $kpmr_kep_pil1_total5, $kpmr_kep_pil1_total6, $kpmr_kep_pil1_total7);
        $kpmr_kep_pil1_maxValue = max($numbers);
        $kpmr_kep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil1_average = $sum / count($numbers);

        $kpmr_kep_pil1_tingkat_risiko = $kpmr_kep_pil1_average;
    } else {
       $kpmr_kep_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_kep_pil2 == 1) {
        $numbers = array($kpmr_kep_pil2_total1 , $kpmr_kep_pil2_total2, $kpmr_kep_pil2_total3);
        $kpmr_kep_pil2_maxValue = max($numbers);
        $kpmr_kep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil2_average = $sum / count($numbers);

        $kpmr_kep_pil2_tingkat_risiko = $kpmr_kep_pil2_maxValue ;
    } else if ($set_kep_pil2 == 2) {
        $numbers = array($kpmr_kep_pil2_total1 , $kpmr_kep_pil2_total2, $kpmr_kep_pil2_total3);
        $kpmr_kep_pil2_maxValue = max($numbers);
        $kpmr_kep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_kep_pil2_minValue;
    } else if ($set_kep_pil2 == 3) {
        $numbers = array($kpmr_kep_pil2_total1 , $kpmr_kep_pil2_total2, $kpmr_kep_pil2_total3);
        $kpmr_kep_pil2_maxValue = max($numbers);
        $kpmr_kep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil2_average = $sum / count($numbers);

        $kpmr_kep_pil2_tingkat_risiko = $kpmr_kep_pil2_average;
    } else {
       $kpmr_kep_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_kep_pil3 == 1) {
        $numbers = array($kpmr_kep_pil3_total1 , $kpmr_kep_pil3_total2);
        $kpmr_kep_pil3_maxValue = max($numbers);
        $kpmr_kep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil3_average = $sum / count($numbers);

        $kpmr_kep_pil3_tingkat_risiko = $kpmr_kep_pil3_maxValue ;
    } else if ($set_kep_pil3 == 2) {
        $numbers = array($kpmr_kep_pil3_total1 , $kpmr_kep_pil3_total2);
        $kpmr_kep_pil3_maxValue = max($numbers);
        $kpmr_kep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil3_average = $sum / count($numbers);

        $kpmr_kep_pil3_tingkat_risiko = $kpmr_kep_pil3_minValue;
    } else if ($set_kep_pil3 == 3) {
        $numbers = array($kpmr_kep_pil3_total1 , $kpmr_kep_pil3_total2);
        $kpmr_kep_pil3_maxValue = max($numbers);
        $kpmr_kep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil3_average = $sum / count($numbers);

        $kpmr_kep_pil3_tingkat_risiko = $kpmr_kep_pil3_average;
    } else {
       $kpmr_kep_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_kep_pil4 == 1) {
        $numbers = array($kpmr_kep_pil4_total1 , $kpmr_kep_pil4_total2);
        $kpmr_kep_pil4_maxValue = max($numbers);
        $kpmr_kep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil4_average = $sum / count($numbers);

        $kpmr_kep_pil4_tingkat_risiko = $kpmr_kep_pil4_maxValue ;
    } else if ($set_kep_pil4 == 2) {
        $numbers = array($kpmr_kep_pil4_total1 , $kpmr_kep_pil4_total2);
        $kpmr_kep_pil4_maxValue = max($numbers);
        $kpmr_kep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil4_average = $sum / count($numbers);

        $kpmr_kep_pil4_tingkat_risiko = $kpmr_kep_pil4_minValue;
    } else if ($set_kep_pil4 == 3) {
        $numbers = array($kpmr_kep_pil4_total1 , $kpmr_kep_pil4_total2);
        $kpmr_kep_pil4_maxValue = max($numbers);
        $kpmr_kep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_kep_pil4_average = $sum / count($numbers);

        $kpmr_kep_pil4_tingkat_risiko = $kpmr_kep_pil4_average;
    } else {
    $kpmr_kep_pil4_tingkat_risiko = 0;
    }


    //inheren reputasi 1
    $inheren_rep_pilar1_1 = $data['inheren_reputasi_pilar1'][136]['pilar1_1'] ?? 0;
    $inheren_rep_pilar1_1a = $data['inheren_reputasi_pilar1'][136]['pilar1_1a'] ?? 0;
    $inheren_rep_pilar1_1b = $data['inheren_reputasi_pilar1'][136]['pilar1_1b'] ?? 0;
    $inheren_rep_pilar1_1c = $data['inheren_reputasi_pilar1'][136]['pilar1_1c'] ?? 0;
    $inheren_rep_pilar1_1d = $data['inheren_reputasi_pilar1'][136]['pilar1_1d'] ?? 0;
    $inheren_rep_pilar1_2 = $data['inheren_reputasi_pilar1'][136]['pilar1_2'] ?? 0;
    $inheren_rep_pilar1_2a = $data['inheren_reputasi_pilar1'][136]['pilar1_2a'] ?? 0;
    $inheren_rep_pilar1_2b = $data['inheren_reputasi_pilar1'][136]['pilar1_2b'] ?? 0;
    $inheren_rep_pilar1_2c = $data['inheren_reputasi_pilar1'][136]['pilar1_2c'] ?? 0;
    $inheren_rep_pilar1_2d = $data['inheren_reputasi_pilar1'][136]['pilar1_2d'] ?? 0;
    $inheren_rep_average_pil1_1 = $data['inheren_reputasi_pilar1'][136]['average_pil1_1'] ?? 0;
    $inheren_rep_average_pil1_2 = $data['inheren_reputasi_pilar1'][136]['average_pil1_2'] ?? 0;
    $inheren_rep_min_pil1_1 = $data['inheren_reputasi_pilar1'][136]['min_pil1_1'] ?? 0;
    $inheren_rep_min_pil1_2 = $data['inheren_reputasi_pilar1'][136]['min_pil1_2'] ?? 0;
    $inheren_rep_max_pil1_1 = $data['inheren_reputasi_pilar1'][136]['max_pil1_1'] ?? 0;
    $inheren_rep_max_pil1_2 = $data['inheren_reputasi_pilar1'][136]['max_pil1_2'] ?? 0;
    $inheren_rep_hasil_pil1_par1 = $data['inheren_reputasi_pilar1'][136]['hasil_pil1_par1'] ?? 0;
    $inheren_rep_hasil_pil1_par2 = $data['inheren_reputasi_pilar1'][136]['hasil_pil1_par2'] ?? 0;

    $ket_in_rep_pil1_1  = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_1'] ?? '';
    $ket_in_rep_pil1_1a = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_1a'] ?? '';
    $ket_in_rep_pil1_1b = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_1b'] ?? '';
    $ket_in_rep_pil1_1c = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_1c'] ?? '';
    $ket_in_rep_pil1_1d = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_1d'] ?? '';
    $ket_in_rep_pil1_2  = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_2'] ?? '';
    $ket_in_rep_pil1_2a = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_2a'] ?? '';
    $ket_in_rep_pil1_2b = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_2b'] ?? '';
    $ket_in_rep_pil1_2c = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_2c'] ?? '';
    $ket_in_rep_pil1_2d = $data['ket_inheren_reputasi_pilar1'][136]['ket_in_rep_pil1_2d'] ?? '';


    
    //inheren reputasi 2
    $inheren_rep_pilar2_1 = $data['inheren_reputasi_pilar2'][135]['pilar2_1'] ?? 0;
    $inheren_rep_pilar2_1a = $data['inheren_reputasi_pilar2'][135]['pilar2_1a'] ?? 0;
    $inheren_rep_pilar2_1b = $data['inheren_reputasi_pilar2'][135]['pilar2_1b'] ?? 0;
    $inheren_rep_pilar2_1c = $data['inheren_reputasi_pilar2'][135]['pilar2_1c'] ?? 0;
    $inheren_rep_pilar2_1d = $data['inheren_reputasi_pilar2'][135]['pilar2_1d'] ?? 0;
    $inheren_rep_pilar2_2 = $data['inheren_reputasi_pilar2'][135]['pilar2_2'] ?? 0;
    $inheren_rep_pilar2_2a = $data['inheren_reputasi_pilar2'][135]['pilar2_2a'] ?? 0;
    $inheren_rep_pilar2_2b = $data['inheren_reputasi_pilar2'][135]['pilar2_2b'] ?? 0;
    $inheren_rep_average_pil2_1 = $data['inheren_reputasi_pilar2'][135]['average_pil2_1'] ?? 0;
    $inheren_rep_average_pil2_2 = $data['inheren_reputasi_pilar2'][135]['average_pil2_2'] ?? 0;
    $inheren_rep_min_pil2_1 = $data['inheren_reputasi_pilar2'][135]['min_pil2_1'] ?? 0;
    $inheren_rep_min_pil2_2 = $data['inheren_reputasi_pilar2'][135]['min_pil2_2'] ?? 0;
    $inheren_rep_max_pil2_1 = $data['inheren_reputasi_pilar2'][135]['max_pil2_1'] ?? 0;
    $inheren_rep_max_pil2_2 = $data['inheren_reputasi_pilar2'][135]['max_pil2_2'] ?? 0;
    $inheren_rep_hasil_pil2_par1 = $data['inheren_reputasi_pilar2'][135]['hasil_pil2_par1'] ?? 0;
    $inheren_rep_hasil_pil2_par2 = $data['inheren_reputasi_pilar2'][135]['hasil_pil2_par2'] ?? 0;   

    $ket_in_rep_pil2_1  = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_1'] ?? '';
    $ket_in_rep_pil2_1a = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_1a'] ?? '';
    $ket_in_rep_pil2_1b = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_1b'] ?? '';
    $ket_in_rep_pil2_1c = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_1c'] ?? '';
    $ket_in_rep_pil2_1d = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_1d'] ?? '';
    $ket_in_rep_pil2_2  = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_2'] ?? '';
    $ket_in_rep_pil2_2a = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_2a'] ?? '';
    $ket_in_rep_pil2_2b = $data['ket_inheren_reputasi_pilar2'][135]['ket_in_rep_pil2_2b'] ?? '';



    //inheren reputasi 3
    $inheren_rep_pilar3_1 = $data['inheren_reputasi_pilar3'][136]['pilar3_1'] ?? 0;
    $inheren_rep_pilar3_1a = $data['inheren_reputasi_pilar3'][136]['pilar3_1a'] ?? 0;
    $inheren_rep_pilar3_1b = $data['inheren_reputasi_pilar3'][136]['pilar3_1b'] ?? 0;
    $inheren_rep_pilar3_1c = $data['inheren_reputasi_pilar3'][136]['pilar3_1c'] ?? 0;
    $inheren_rep_pilar3_2 = $data['inheren_reputasi_pilar3'][136]['pilar3_2'] ?? 0;
    $inheren_rep_pilar3_2a = $data['inheren_reputasi_pilar3'][136]['pilar3_2a'] ?? 0;
    $inheren_rep_pilar3_2b = $data['inheren_reputasi_pilar3'][136]['pilar3_2b'] ?? 0;
    $inheren_rep_average_pil3_1 = $data['inheren_reputasi_pilar3'][136]['average_pil3_1'] ?? 0;
    $inheren_rep_average_pil3_2 = $data['inheren_reputasi_pilar3'][136]['average_pil3_2'] ?? 0;
    $inheren_rep_min_pil3_1 = $data['inheren_reputasi_pilar3'][136]['min_pil3_1'] ?? 0;
    $inheren_rep_min_pil3_2 = $data['inheren_reputasi_pilar3'][136]['min_pil3_2'] ?? 0;
    $inheren_rep_max_pil3_1 = $data['inheren_reputasi_pilar3'][136]['max_pil3_1'] ?? 0;
    $inheren_rep_max_pil3_2 = $data['inheren_reputasi_pilar3'][136]['max_pil3_2'] ?? 0;
    $inheren_rep_hasil_pil3_par1 = $data['inheren_reputasi_pilar3'][136]['hasil_pil3_par1'] ?? 0;
    $inheren_rep_hasil_pil3_par2 = $data['inheren_reputasi_pilar3'][136]['hasil_pil3_par2'] ?? 0;

    $ket_in_rep_pil3_1  = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_1'] ?? '';
    $ket_in_rep_pil3_1a = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_1a'] ?? '';
    $ket_in_rep_pil3_1b = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_1b'] ?? '';
    $ket_in_rep_pil3_1c = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_1c'] ?? '';
    $ket_in_rep_pil3_2  = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_2'] ?? '';
    $ket_in_rep_pil3_2a = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_2a'] ?? '';
    $ket_in_rep_pil3_2b = $data['ket_inheren_reputasi_pilar3'][136]['ket_in_rep_pil3_2b'] ?? '';

    $kpmr_rep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_reputasi WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_rep_pilar1_1a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_1a','respon_unit_kerja_reputasi_pil1','respon_pil1_1a',[135,136]);
    $result_kpmr_rep_pilar1_1b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_1b','respon_unit_kerja_reputasi_pil1','respon_pil1_1b',[135,136]);
    $result_kpmr_rep_pilar1_1c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_1c','respon_unit_kerja_reputasi_pil1','respon_pil1_1c',[135,136]);
    $result_kpmr_rep_pilar1_1d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_1d','respon_unit_kerja_reputasi_pil1','respon_pil1_1d',[135,136]);
    $result_kpmr_rep_pilar1_1e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_1e','respon_unit_kerja_reputasi_pil1','respon_pil1_1e',[135,136]);
    
    $result_kpmr_rep_pilar1_2a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_2a','respon_unit_kerja_reputasi_pil1','respon_pil1_2a',[135,136]);
    $result_kpmr_rep_pilar1_2b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_2b','respon_unit_kerja_reputasi_pil1','respon_pil1_2b',[135,136]);
    $result_kpmr_rep_pilar1_2c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_2c','respon_unit_kerja_reputasi_pil1','respon_pil1_2c',[135,136]);
    $result_kpmr_rep_pilar1_2d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_2d','respon_unit_kerja_reputasi_pil1','respon_pil1_2d',[135,136]);
    $result_kpmr_rep_pilar1_2e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_2e','respon_unit_kerja_reputasi_pil1','respon_pil1_2e',[135,136]);
    
    $result_kpmr_rep_pilar1_3a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_3a','respon_unit_kerja_reputasi_pil1','respon_pil1_3a',[135,136]);
    $result_kpmr_rep_pilar1_3b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_3b','respon_unit_kerja_reputasi_pil1','respon_pil1_3b',[135,136]);
    $result_kpmr_rep_pilar1_3c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_3c','respon_unit_kerja_reputasi_pil1','respon_pil1_3c',[135,136]);
    
    $result_kpmr_rep_pilar1_4a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_4a','respon_unit_kerja_reputasi_pil1','respon_pil1_4a',[135,136]);
    $result_kpmr_rep_pilar1_4b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_4b','respon_unit_kerja_reputasi_pil1','respon_pil1_4b',[135,136]);
    $result_kpmr_rep_pilar1_4c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_4c','respon_unit_kerja_reputasi_pil1','respon_pil1_4c',[135,136]);
    $result_kpmr_rep_pilar1_4d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_4d','respon_unit_kerja_reputasi_pil1','respon_pil1_4d',[135,136]);
    $result_kpmr_rep_pilar1_4e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_4e','respon_unit_kerja_reputasi_pil1','respon_pil1_4e',[135,136]);
    
    $result_kpmr_rep_pilar1_5a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_5a','respon_unit_kerja_reputasi_pil1','respon_pil1_5a',[135,136]);
    $result_kpmr_rep_pilar1_5b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_5b','respon_unit_kerja_reputasi_pil1','respon_pil1_5b',[135,136]);
    $result_kpmr_rep_pilar1_5c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_5c','respon_unit_kerja_reputasi_pil1','respon_pil1_5c',[135,136]);
    $result_kpmr_rep_pilar1_5d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_5d','respon_unit_kerja_reputasi_pil1','respon_pil1_5d',[135,136]);
    
    $result_kpmr_rep_pilar1_6a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_6a','respon_unit_kerja_reputasi_pil1','respon_pil1_6a',[135,136]);
    $result_kpmr_rep_pilar1_6b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_6b','respon_unit_kerja_reputasi_pil1','respon_pil1_6b',[135,136]);
    $result_kpmr_rep_pilar1_6c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar1','pilar1_6c','respon_unit_kerja_reputasi_pil1','respon_pil1_6c',[135,136]);
    

    $result_kpmr_rep_pilar2_1a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_1a','respon_unit_kerja_reputasi_pil2','respon_pil2_1a',[135,136]);
    $result_kpmr_rep_pilar2_1b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_1b','respon_unit_kerja_reputasi_pil2','respon_pil2_1b',[135,136]);
    $result_kpmr_rep_pilar2_1c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_1c','respon_unit_kerja_reputasi_pil2','respon_pil2_1c',[135,136]);
    $result_kpmr_rep_pilar2_1d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_1d','respon_unit_kerja_reputasi_pil2','respon_pil2_1d',[135,136]);
    $result_kpmr_rep_pilar2_1e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_1e','respon_unit_kerja_reputasi_pil2','respon_pil2_1e',[135,136]);

    $result_kpmr_rep_pilar2_2a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2a','respon_unit_kerja_reputasi_pil2','respon_pil2_2a',[135,136]);
    $result_kpmr_rep_pilar2_2b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2b','respon_unit_kerja_reputasi_pil2','respon_pil2_2b',[135,136]);
    $result_kpmr_rep_pilar2_2c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2c','respon_unit_kerja_reputasi_pil2','respon_pil2_2c',[135,136]);
    $result_kpmr_rep_pilar2_2d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2d','respon_unit_kerja_reputasi_pil2','respon_pil2_2d',[135,136]);
    $result_kpmr_rep_pilar2_2e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2e','respon_unit_kerja_reputasi_pil2','respon_pil2_2e',[135,136]);
    $result_kpmr_rep_pilar2_2f = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2f','respon_unit_kerja_reputasi_pil2','respon_pil2_2f',[135,136]);
    $result_kpmr_rep_pilar2_2g = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2g','respon_unit_kerja_reputasi_pil2','respon_pil2_2g',[135,136]);
    $result_kpmr_rep_pilar2_2h = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_2h','respon_unit_kerja_reputasi_pil2','respon_pil2_2h',[135,136]);

    $result_kpmr_rep_pilar2_3a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_3a','respon_unit_kerja_reputasi_pil2','respon_pil2_3a',[135,136]);
    $result_kpmr_rep_pilar2_3b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_3b','respon_unit_kerja_reputasi_pil2','respon_pil2_3b',[135,136]);
    $result_kpmr_rep_pilar2_3c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar2','pilar2_3c','respon_unit_kerja_reputasi_pil2','respon_pil2_3c',[135,136]);


    $result_kpmr_rep_pilar3_1a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1a','respon_unit_kerja_reputasi_pil3','respon_pil3_1a',[135,136]);
    $result_kpmr_rep_pilar3_1b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1b','respon_unit_kerja_reputasi_pil3','respon_pil3_1b',[135,136]);
    $result_kpmr_rep_pilar3_1c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1c','respon_unit_kerja_reputasi_pil3','respon_pil3_1c',[135,136]);
    $result_kpmr_rep_pilar3_1d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1d','respon_unit_kerja_reputasi_pil3','respon_pil3_1d',[135,136]);
    $result_kpmr_rep_pilar3_1e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1e','respon_unit_kerja_reputasi_pil3','respon_pil3_1e',[135,136]);
    $result_kpmr_rep_pilar3_1f = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1f','respon_unit_kerja_reputasi_pil3','respon_pil3_1f',[135,136]);
    $result_kpmr_rep_pilar3_1g = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1g','respon_unit_kerja_reputasi_pil3','respon_pil3_1g',[135,136]);
    $result_kpmr_rep_pilar3_1h = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1h','respon_unit_kerja_reputasi_pil3','respon_pil3_1h',[135,136]);
    $result_kpmr_rep_pilar3_1i = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1i','respon_unit_kerja_reputasi_pil3','respon_pil3_1i',[135,136]);
    $result_kpmr_rep_pilar3_1j = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_1j','respon_unit_kerja_reputasi_pil3','respon_pil3_1j',[135,136]);

    $result_kpmr_rep_pilar3_2a = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_2a','respon_unit_kerja_reputasi_pil3','respon_pil3_1a',[135,136]);
    $result_kpmr_rep_pilar3_2b = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_2b','respon_unit_kerja_reputasi_pil3','respon_pil3_1b',[135,136]);
    $result_kpmr_rep_pilar3_2c = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_2c','respon_unit_kerja_reputasi_pil3','respon_pil3_1c',[135,136]);
    $result_kpmr_rep_pilar3_2d = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_2d','respon_unit_kerja_reputasi_pil3','respon_pil3_1d',[135,136]);
    $result_kpmr_rep_pilar3_2e = getMaxValueWithRespon($data,'kpmr_reputasi_pilar3','pilar3_2e','respon_unit_kerja_reputasi_pil3','respon_pil3_1e',[135,136]);



    //implemen

$kpmr_rep_pilar1_1a = $result_kpmr_rep_pilar1_1a['nilai']; $kpmr_rep_respon_pil1_1a = $result_kpmr_rep_pilar1_1a['respon'];
$kpmr_rep_pilar1_1b = $result_kpmr_rep_pilar1_1b['nilai']; $kpmr_rep_respon_pil1_1b = $result_kpmr_rep_pilar1_1b['respon'];
$kpmr_rep_pilar1_1c = $result_kpmr_rep_pilar1_1c['nilai']; $kpmr_rep_respon_pil1_1c = $result_kpmr_rep_pilar1_1c['respon'];
$kpmr_rep_pilar1_1d = $result_kpmr_rep_pilar1_1d['nilai']; $kpmr_rep_respon_pil1_1d = $result_kpmr_rep_pilar1_1d['respon'];
$kpmr_rep_pilar1_1e = $result_kpmr_rep_pilar1_1e['nilai']; $kpmr_rep_respon_pil1_1e = $result_kpmr_rep_pilar1_1e['respon'];



$kpmr_rep_pil1_total1_average = array($kpmr_rep_pilar1_1a,
$kpmr_rep_pilar1_1b,
$kpmr_rep_pilar1_1c,
$kpmr_rep_pilar1_1d,
$kpmr_rep_pilar1_1e);
        $kpmr_rep_pil1_total1_sum = array_sum($kpmr_rep_pil1_total1_average);
        $kpmr_rep_pil1_total1 = $kpmr_rep_pil1_total1_sum / count($kpmr_rep_pil1_total1_average);

if ($kpmr_rep_pil1_total1 < 1.00) {
    $kpmr_rep_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total1 >= 1.00 && $kpmr_rep_pil1_total1 < 1.25) {
    $kpmr_rep_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total1 >= 1.25 && $kpmr_rep_pil1_total1 < 2.25) {
    $kpmr_rep_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_rep_pil1_total1 >= 2.25 && $kpmr_rep_pil1_total1 < 3.25) {
    $kpmr_rep_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total1 >= 3.25 && $kpmr_rep_pil1_total1 < 4.25) {
    $kpmr_rep_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total1 >= 4.25 && $kpmr_rep_pil1_total1 <= 5.00) {
    $kpmr_rep_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_rep_pilar1_2a = $result_kpmr_rep_pilar1_2a['nilai']; $kpmr_rep_respon_pil1_2a = $result_kpmr_rep_pilar1_2a['respon'];
$kpmr_rep_pilar1_2b = $result_kpmr_rep_pilar1_2b['nilai']; $kpmr_rep_respon_pil1_2b = $result_kpmr_rep_pilar1_2b['respon'];
$kpmr_rep_pilar1_2c = $result_kpmr_rep_pilar1_2c['nilai']; $kpmr_rep_respon_pil1_2c = $result_kpmr_rep_pilar1_2c['respon'];
$kpmr_rep_pilar1_2d = $result_kpmr_rep_pilar1_2d['nilai']; $kpmr_rep_respon_pil1_2d = $result_kpmr_rep_pilar1_2d['respon'];
$kpmr_rep_pilar1_2e = $result_kpmr_rep_pilar1_2e['nilai']; $kpmr_rep_respon_pil1_2e = $result_kpmr_rep_pilar1_2e['respon'];


$kpmr_rep_pil1_total2_average = array($kpmr_rep_pilar1_2a,
$kpmr_rep_pilar1_2b,
$kpmr_rep_pilar1_2c,
$kpmr_rep_pilar1_2d,
$kpmr_rep_pilar1_2e);
$kpmr_rep_pil1_total2_sum = array_sum($kpmr_rep_pil1_total2_average);
$kpmr_rep_pil1_total2 = $kpmr_rep_pil1_total2_sum / count($kpmr_rep_pil1_total2_average);

if ($kpmr_rep_pil1_total2 < 1.00) {
    $kpmr_rep_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total2 >= 1.00 && $kpmr_rep_pil1_total2 < 1.25) {
    $kpmr_rep_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total2 >= 1.25 && $kpmr_rep_pil1_total2 < 2.25) {
    $kpmr_rep_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_rep_pil1_total2 >= 2.25 && $kpmr_rep_pil1_total2 < 3.25) {
    $kpmr_rep_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total2 >= 3.25 && $kpmr_rep_pil1_total2 < 4.25) {
    $kpmr_rep_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total2 >= 4.25 && $kpmr_rep_pil1_total2 <= 5.00) {
    $kpmr_rep_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_rep_pilar1_3a = $result_kpmr_rep_pilar1_3a['nilai']; $kpmr_rep_respon_pil1_3a = $result_kpmr_rep_pilar1_3a['respon'];
$kpmr_rep_pilar1_3b = $result_kpmr_rep_pilar1_3b['nilai']; $kpmr_rep_respon_pil1_3b = $result_kpmr_rep_pilar1_3b['respon'];
$kpmr_rep_pilar1_3c = $result_kpmr_rep_pilar1_3c['nilai']; $kpmr_rep_respon_pil1_3c = $result_kpmr_rep_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_rep_pil1_total3_average = array($kpmr_rep_pilar1_3a,
$kpmr_rep_pilar1_3b,
$kpmr_rep_pilar1_3c);
$kpmr_rep_pil1_total3_sum = array_sum($kpmr_rep_pil1_total3_average);
$kpmr_rep_pil1_total3 = $kpmr_rep_pil1_total3_sum / count($kpmr_rep_pil1_total3_average);

if ($kpmr_rep_pil1_total3 < 1.00) {
    $kpmr_rep_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total3 >= 1.00 && $kpmr_rep_pil1_total3 < 1.25) {
    $kpmr_rep_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total3 >= 1.25 && $kpmr_rep_pil1_total3 < 2.25) {
    $kpmr_rep_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_rep_pil1_total3 >= 2.25 && $kpmr_rep_pil1_total3 < 3.25) {
    $kpmr_rep_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total3 >= 3.25 && $kpmr_rep_pil1_total3 < 4.25) {
    $kpmr_rep_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total3 >= 4.25 && $kpmr_rep_pil1_total3 <= 5.00) {
    $kpmr_rep_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_rep_pilar1_4a = $result_kpmr_rep_pilar1_4a['nilai']; $kpmr_rep_respon_pil1_4a = $result_kpmr_rep_pilar1_4a['respon'];
$kpmr_rep_pilar1_4b = $result_kpmr_rep_pilar1_4b['nilai']; $kpmr_rep_respon_pil1_4b = $result_kpmr_rep_pilar1_4b['respon'];
$kpmr_rep_pilar1_4c = $result_kpmr_rep_pilar1_4c['nilai']; $kpmr_rep_respon_pil1_4c = $result_kpmr_rep_pilar1_4c['respon'];
$kpmr_rep_pilar1_4d = $result_kpmr_rep_pilar1_4d['nilai']; $kpmr_rep_respon_pil1_4d = $result_kpmr_rep_pilar1_4d['respon'];
$kpmr_rep_pilar1_4e = $result_kpmr_rep_pilar1_4e['nilai']; $kpmr_rep_respon_pil1_4e = $result_kpmr_rep_pilar1_4e['respon'];


$kpmr_rep_pil1_total4_average = array($kpmr_rep_pilar1_4a,
$kpmr_rep_pilar1_4b,
$kpmr_rep_pilar1_4c,
$kpmr_rep_pilar1_4d,
$kpmr_rep_pilar1_4e);
$kpmr_rep_pil1_total4_sum = array_sum($kpmr_rep_pil1_total4_average);
$kpmr_rep_pil1_total4 = $kpmr_rep_pil1_total4_sum / count($kpmr_rep_pil1_total4_average);

if ($kpmr_rep_pil1_total4 < 1.00) {
    $kpmr_rep_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total4 >= 1.00 && $kpmr_rep_pil1_total4 < 1.25) {
    $kpmr_rep_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total4 >= 1.25 && $kpmr_rep_pil1_total4 < 2.25) {
    $kpmr_rep_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_rep_pil1_total4 >= 2.25 && $kpmr_rep_pil1_total4 < 3.25) {
    $kpmr_rep_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total4 >= 3.25 && $kpmr_rep_pil1_total4 < 4.25) {
    $kpmr_rep_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total4 >= 4.25 && $kpmr_rep_pil1_total4 <= 5.00) {
    $kpmr_rep_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_rep_pilar1_5a = $result_kpmr_rep_pilar1_5a['nilai']; $kpmr_rep_respon_pil1_5a = $result_kpmr_rep_pilar1_5a['respon'];
$kpmr_rep_pilar1_5b = $result_kpmr_rep_pilar1_5b['nilai']; $kpmr_rep_respon_pil1_5b = $result_kpmr_rep_pilar1_5b['respon'];
$kpmr_rep_pilar1_5c = $result_kpmr_rep_pilar1_5c['nilai']; $kpmr_rep_respon_pil1_5c = $result_kpmr_rep_pilar1_5c['respon'];
$kpmr_rep_pilar1_5d = $result_kpmr_rep_pilar1_5d['nilai']; $kpmr_rep_respon_pil1_5d = $result_kpmr_rep_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_rep_pil1_total5_average = array($kpmr_rep_pilar1_5a,
$kpmr_rep_pilar1_5b,
$kpmr_rep_pilar1_5c,
$kpmr_rep_pilar1_5);
$kpmr_rep_pil1_total5_sum = array_sum($kpmr_rep_pil1_total5_average);
$kpmr_rep_pil1_total5 = $kpmr_rep_pil1_total5_sum / count($kpmr_rep_pil1_total5_average);

if ($kpmr_rep_pil1_total5 < 1.00) {
    $kpmr_rep_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total5 >= 1.00 && $kpmr_rep_pil1_total5 < 1.25) {
    $kpmr_rep_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total5 >= 1.25 && $kpmr_rep_pil1_total5 < 2.25) {
    $kpmr_rep_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_rep_pil1_total5 >= 2.25 && $kpmr_rep_pil1_total5 < 3.25) {
    $kpmr_rep_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total5 >= 3.25 && $kpmr_rep_pil1_total5 < 4.25) {
    $kpmr_rep_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total5 >= 4.25 && $kpmr_rep_pil1_total5 <= 5.00) {
    $kpmr_rep_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_rep_pilar1_6a = $result_kpmr_rep_pilar1_6a['nilai']; $kpmr_rep_respon_pil1_6a = $result_kpmr_rep_pilar1_6a['respon'];
$kpmr_rep_pilar1_6b = $result_kpmr_rep_pilar1_6b['nilai']; $kpmr_rep_respon_pil1_6b = $result_kpmr_rep_pilar1_6b['respon'];
$kpmr_rep_pilar1_6c = $result_kpmr_rep_pilar1_6c['nilai']; $kpmr_rep_respon_pil1_6c = $result_kpmr_rep_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_rep_pil1_total6_average = array($kpmr_rep_pilar1_6a,
$kpmr_rep_pilar1_6b,
$kpmr_rep_pilar1_6c);
$kpmr_rep_pil1_total6_sum = array_sum($kpmr_rep_pil1_total6_average);
$kpmr_rep_pil1_total6 = $kpmr_rep_pil1_total6_sum / count($kpmr_rep_pil1_total6_average);

if ($kpmr_rep_pil1_total6 < 1.00) {
    $kpmr_rep_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_rep_pil1_total6 >= 1.00 && $kpmr_rep_pil1_total6 < 1.25) {
    $kpmr_rep_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_rep_pil1_total6 >= 1.25 && $kpmr_rep_pil1_total6 < 2.25) {
    $kpmr_rep_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_rep_pil1_total6 >= 2.25 && $kpmr_rep_pil1_total6 < 3.25) {
    $kpmr_rep_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_rep_pil1_total6 >= 3.25 && $kpmr_rep_pil1_total6 < 4.25) {
    $kpmr_rep_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_rep_pil1_total6 >= 4.25 && $kpmr_rep_pil1_total6 <= 5.00) {
    $kpmr_rep_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_rep_pil1_peringkat6 = "Belum Terisi";
}


        
$kpmr_rep_pilar2_1a = $result_kpmr_rep_pilar2_1a['nilai']; $kpmr_rep_respon_pil2_1a = $result_kpmr_rep_pilar2_1a['respon'];
$kpmr_rep_pilar2_1b = $result_kpmr_rep_pilar2_1b['nilai']; $kpmr_rep_respon_pil2_1b = $result_kpmr_rep_pilar2_1b['respon'];
$kpmr_rep_pilar2_1c = $result_kpmr_rep_pilar2_1c['nilai']; $kpmr_rep_respon_pil2_1c = $result_kpmr_rep_pilar2_1c['respon'];
$kpmr_rep_pilar2_1d = $result_kpmr_rep_pilar2_1d['nilai']; $kpmr_rep_respon_pil2_1d = $result_kpmr_rep_pilar2_1d['respon'];
$kpmr_rep_pilar2_1e = $result_kpmr_rep_pilar2_1e['nilai']; $kpmr_rep_respon_pil2_1e = $result_kpmr_rep_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_rep_pil2_total1_average = array($kpmr_rep_pilar2_1a,
$kpmr_rep_pilar2_1b,
$kpmr_rep_pilar2_1c,
$kpmr_rep_pilar2_1d,
$kpmr_rep_pilar2_1e);
$kpmr_rep_pil2_total1_sum = array_sum($kpmr_rep_pil2_total1_average);
$kpmr_rep_pil2_total1 = $kpmr_rep_pil2_total1_sum / count($kpmr_rep_pil2_total1_average);

if ($kpmr_rep_pil2_total1 < 1.00) {
    $kpmr_rep_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_rep_pil2_total1 >= 1.00 && $kpmr_rep_pil2_total1 < 1.25) {
    $kpmr_rep_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_rep_pil2_total1 >= 1.25 && $kpmr_rep_pil2_total1 < 2.25) {
    $kpmr_rep_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_rep_pil2_total1 >= 2.25 && $kpmr_rep_pil2_total1 < 3.25) {
    $kpmr_rep_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_rep_pil2_total1 >= 3.25 && $kpmr_rep_pil2_total1 < 4.25) {
    $kpmr_rep_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_rep_pil2_total1 >= 4.25 && $kpmr_rep_pil2_total1 <= 5.00) {
    $kpmr_rep_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_rep_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_rep_pilar2_2a = $result_kpmr_rep_pilar2_2a['nilai']; $kpmr_rep_respon_pil2_2a = $result_kpmr_rep_pilar2_2a['respon'];
$kpmr_rep_pilar2_2b = $result_kpmr_rep_pilar2_2b['nilai']; $kpmr_rep_respon_pil2_2b = $result_kpmr_rep_pilar2_2b['respon'];
$kpmr_rep_pilar2_2c = $result_kpmr_rep_pilar2_2c['nilai']; $kpmr_rep_respon_pil2_2c = $result_kpmr_rep_pilar2_2c['respon'];
$kpmr_rep_pilar2_2d = $result_kpmr_rep_pilar2_2d['nilai']; $kpmr_rep_respon_pil2_2d = $result_kpmr_rep_pilar2_2d['respon'];
$kpmr_rep_pilar2_2e = $result_kpmr_rep_pilar2_2e['nilai']; $kpmr_rep_respon_pil2_2e = $result_kpmr_rep_pilar2_2e['respon'];
$kpmr_rep_pilar2_2f = $result_kpmr_rep_pilar2_2f['nilai']; $kpmr_rep_respon_pil2_2f = $result_kpmr_rep_pilar2_2f['respon'];
$kpmr_rep_pilar2_2g = $result_kpmr_rep_pilar2_2g['nilai']; $kpmr_rep_respon_pil2_2g = $result_kpmr_rep_pilar2_2g['respon'];
$kpmr_rep_pilar2_2h = $result_kpmr_rep_pilar2_2h['nilai']; $kpmr_rep_respon_pil2_2h = $result_kpmr_rep_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_rep_pil2_total2_average = array($kpmr_rep_pilar2_2a,
$kpmr_rep_pilar2_2b,
$kpmr_rep_pilar2_2c,
$kpmr_rep_pilar2_2d,
$kpmr_rep_pilar2_2e,
$kpmr_rep_pilar2_2f,
$kpmr_rep_pilar2_2g,
$kpmr_rep_pilar2_2h);
$kpmr_rep_pil2_total2_sum = array_sum($kpmr_rep_pil2_total2_average);
$kpmr_rep_pil2_total2 = $kpmr_rep_pil2_total2_sum / count($kpmr_rep_pil2_total2_average);

if ($kpmr_rep_pil2_total2 < 1.00) {
    $kpmr_rep_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_rep_pil2_total2 >= 1.00 && $kpmr_rep_pil2_total2 < 1.25) {
    $kpmr_rep_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_rep_pil2_total2 >= 1.25 && $kpmr_rep_pil2_total2 < 2.25) {
    $kpmr_rep_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_rep_pil2_total2 >= 2.25 && $kpmr_rep_pil2_total2 < 3.25) {
    $kpmr_rep_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_rep_pil2_total2 >= 3.25 && $kpmr_rep_pil2_total2 < 4.25) {
    $kpmr_rep_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_rep_pil2_total2 >= 4.25 && $kpmr_rep_pil2_total2 <= 5.00) {
    $kpmr_rep_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_rep_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_rep_pilar2_3a = $result_kpmr_rep_pilar2_3a['nilai']; $kpmr_rep_respon_pil2_3a = $result_kpmr_rep_pilar2_3a['respon'];
$kpmr_rep_pilar2_3b = $result_kpmr_rep_pilar2_3b['nilai']; $kpmr_rep_respon_pil2_3b = $result_kpmr_rep_pilar2_3b['respon'];
$kpmr_rep_pilar2_3c = $result_kpmr_rep_pilar2_3c['nilai']; $kpmr_rep_respon_pil2_3c = $result_kpmr_rep_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_rep_pil2_total3_average = array($kpmr_rep_pilar2_3a,
$kpmr_rep_pilar2_3b,
$kpmr_rep_pilar2_3c);
$kpmr_rep_pil2_total3_sum = array_sum($kpmr_rep_pil2_total3_average);
$kpmr_rep_pil2_total3 = $kpmr_rep_pil2_total3_sum / count($kpmr_rep_pil2_total3_average);

if ($kpmr_rep_pil2_total3 < 1.00) {
    $kpmr_rep_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_rep_pil2_total3 >= 1.00 && $kpmr_rep_pil2_total3 < 1.25) {
    $kpmr_rep_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_rep_pil2_total3 >= 1.25 && $kpmr_rep_pil2_total3 < 2.25) {
    $kpmr_rep_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_rep_pil2_total3 >= 2.25 && $kpmr_rep_pil2_total3 < 3.25) {
    $kpmr_rep_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_rep_pil2_total3 >= 3.25 && $kpmr_rep_pil2_total3 < 4.25) {
    $kpmr_rep_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_rep_pil2_total3 >= 4.25 && $kpmr_rep_pil2_total3 <= 5.00) {
    $kpmr_rep_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_rep_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_rep_pilar3_1a = $result_kpmr_rep_pilar3_1a['nilai']; $kpmr_rep_respon_pil3_1a = $result_kpmr_rep_pilar3_1a['respon'];
$kpmr_rep_pilar3_1b = $result_kpmr_rep_pilar3_1b['nilai']; $kpmr_rep_respon_pil3_1b = $result_kpmr_rep_pilar3_1b['respon'];
$kpmr_rep_pilar3_1c = $result_kpmr_rep_pilar3_1c['nilai']; $kpmr_rep_respon_pil3_1c = $result_kpmr_rep_pilar3_1c['respon'];
$kpmr_rep_pilar3_1d = $result_kpmr_rep_pilar3_1d['nilai']; $kpmr_rep_respon_pil3_1d = $result_kpmr_rep_pilar3_1d['respon'];
$kpmr_rep_pilar3_1e = $result_kpmr_rep_pilar3_1e['nilai']; $kpmr_rep_respon_pil3_1e = $result_kpmr_rep_pilar3_1e['respon'];
$kpmr_rep_pilar3_1f = $result_kpmr_rep_pilar3_1f['nilai']; $kpmr_rep_respon_pil3_1f = $result_kpmr_rep_pilar3_1f['respon'];
$kpmr_rep_pilar3_1g = $result_kpmr_rep_pilar3_1g['nilai']; $kpmr_rep_respon_pil3_1g = $result_kpmr_rep_pilar3_1g['respon'];
$kpmr_rep_pilar3_1h = $result_kpmr_rep_pilar3_1h['nilai']; $kpmr_rep_respon_pil3_1h = $result_kpmr_rep_pilar3_1h['respon'];
$kpmr_rep_pilar3_1i = $result_kpmr_rep_pilar3_1i['nilai']; $kpmr_rep_respon_pil3_1i = $result_kpmr_rep_pilar3_1i['respon'];
$kpmr_rep_pilar3_1j = $result_kpmr_rep_pilar3_1j['nilai']; $kpmr_rep_respon_pil3_1j = $result_kpmr_rep_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_rep_pil3_total1_average = array($kpmr_rep_pilar3_1a,
$kpmr_rep_pilar3_1b,
$kpmr_rep_pilar3_1c,
$kpmr_rep_pilar3_1d,
$kpmr_rep_pilar3_1e,
$kpmr_rep_pilar3_1f,
$kpmr_rep_pilar3_1g,
$kpmr_rep_pilar3_1h,
$kpmr_rep_pilar3_1i,
$kpmr_rep_pilar3_1j);
$kpmr_rep_pil3_total1_sum = array_sum($kpmr_rep_pil3_total1_average);
$kpmr_rep_pil3_total1 = $kpmr_rep_pil3_total1_sum / count($kpmr_rep_pil3_total1_average);

if ($kpmr_rep_pil3_total1 < 1.00) {
    $kpmr_rep_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_rep_pil3_total1 >= 1.00 && $kpmr_rep_pil3_total1 < 1.25) {
    $kpmr_rep_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_rep_pil3_total1 >= 1.25 && $kpmr_rep_pil3_total1 < 2.25) {
    $kpmr_rep_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_rep_pil3_total1 >= 2.25 && $kpmr_rep_pil3_total1 < 3.25) {
    $kpmr_rep_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_rep_pil3_total1 >= 3.25 && $kpmr_rep_pil3_total1 < 4.25) {
    $kpmr_rep_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_rep_pil3_total1 >= 4.25 && $kpmr_rep_pil3_total1 <= 5.00) {
    $kpmr_rep_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_rep_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_rep_pilar3_2a = $result_kpmr_rep_pilar3_2a['nilai']; $kpmr_rep_respon_pil3_2a = $result_kpmr_rep_pilar3_2a['respon'];
$kpmr_rep_pilar3_2b = $result_kpmr_rep_pilar3_2b['nilai']; $kpmr_rep_respon_pil3_2b = $result_kpmr_rep_pilar3_2b['respon'];
$kpmr_rep_pilar3_2c = $result_kpmr_rep_pilar3_2c['nilai']; $kpmr_rep_respon_pil3_2c = $result_kpmr_rep_pilar3_2c['respon'];
$kpmr_rep_pilar3_2d = $result_kpmr_rep_pilar3_2d['nilai']; $kpmr_rep_respon_pil3_2d = $result_kpmr_rep_pilar3_2d['respon'];
$kpmr_rep_pilar3_2e = $result_kpmr_rep_pilar3_2e['nilai']; $kpmr_rep_respon_pil3_2e = $result_kpmr_rep_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_rep_pil3_total2_average = array($kpmr_rep_pilar3_2a,
$kpmr_rep_pilar3_2b,
$kpmr_rep_pilar3_2c,
$kpmr_rep_pilar3_2d,
$kpmr_rep_pilar3_2e);
$kpmr_rep_pil3_total2_sum = array_sum($kpmr_rep_pil3_total2_average);
$kpmr_rep_pil3_total2 = $kpmr_rep_pil3_total2_sum / count($kpmr_rep_pil3_total2_average);

if ($kpmr_rep_pil3_total2 < 1.00) {
    $kpmr_rep_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_rep_pil3_total2 >= 1.00 && $kpmr_rep_pil3_total2 < 1.25) {
    $kpmr_rep_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_rep_pil3_total2 >= 1.25 && $kpmr_rep_pil3_total2 < 2.25) {
    $kpmr_rep_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_rep_pil3_total2 >= 2.25 && $kpmr_rep_pil3_total2 < 3.25) {
    $kpmr_rep_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_rep_pil3_total2 >= 3.25 && $kpmr_rep_pil3_total2 < 4.25) {
    $kpmr_rep_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_rep_pil3_total2 >= 4.25 && $kpmr_rep_pil3_total2 <= 5.00) {
    $kpmr_rep_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_rep_pil3_peringkat2 = "Belum Terisi";
}
   

    //inheren reputasi lainnya
    $inheren_rep_pilar4_1a = $data['inheren_reputasi_lainnya'][143]['pilar4_1a'] ?? 0;
    $inheren_rep_pilar4_1b = $data['inheren_reputasi_lainnya'][136]['pilar4_1b'] ?? 0;
    $inheren_rep_pilar4_1c = $data['inheren_reputasi_lainnya'][136]['pilar4_1c'] ?? 0;
    $inheren_rep_average_pil4_1 = $data['inheren_reputasi_lainnya'][136]['average_pil4_1'] ?? 0;
    $inheren_rep_min_pil4_1 = $data['inheren_reputasi_lainnya'][136]['min_pil4_1'] ?? 0;
    $inheren_rep_max_pil4_1 = $data['inheren_reputasi_lainnya'][136]['max_pil4_1'] ?? 0;
    $inheren_rep_hasil_pil4_par1 = $data['inheren_reputasi_lainnya'][136]['hasil_pil4_par1'] ?? 0;

    $ket_in_rep_pil4_1a = $data['ket_inheren_reputasi_lainnya'][143]['ket_in_rep_pil4_1a'] ?? '';
    $ket_in_rep_pil4_1b = $data['ket_inheren_reputasi_lainnya'][136]['ket_in_rep_pil4_1b'] ?? '';
    $ket_in_rep_pil4_1c = $data['ket_inheren_reputasi_lainnya'][136]['ket_in_rep_pil4_1c'] ?? '';


    $kpmr_rep_pilar4_1a = $data['kpmr_reputasi_pilar4'][143]['pilar4_1a'] ?? 0;
    $kpmr_rep_pilar4_1b = $data['kpmr_reputasi_pilar4'][143]['pilar4_1b'] ?? 0;
    $kpmr_rep_pilar4_1c = $data['kpmr_reputasi_pilar4'][143]['pilar4_1c'] ?? 0;
    $kpmr_rep_pilar4_1d = $data['kpmr_reputasi_pilar4'][143]['pilar4_1d'] ?? 0;
    $kpmr_rep_pilar4_1e = $data['kpmr_reputasi_pilar4'][143]['pilar4_1e'] ?? 0;
    $kpmr_rep_pil4_total1 = $data['kpmr_reputasi_pilar4'][143]['pil4_total1'] ?? 0;
    $kpmr_rep_pil4_peringkat1 = $data['kpmr_reputasi_pilar4'][143]['pil4_peringkat1'] ?? 0;
    $kpmr_rep_pilar4_2a = $data['kpmr_reputasi_pilar4'][143]['pilar4_2a'] ?? 0;
    $kpmr_rep_pilar4_2b = $data['kpmr_reputasi_pilar4'][143]['pilar4_2b'] ?? 0;
    $kpmr_rep_pil4_total2 = $data['kpmr_reputasi_pilar4'][143]['pil4_total2'] ?? 0;
    $kpmr_rep_pil4_peringkat2 = $data['kpmr_reputasi_pilar4'][143]['pil4_peringkat2'] ?? 0;

    $kpmr_rep_respon_pil4_1a = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_1a'] ?? 0;
    $kpmr_rep_respon_pil4_1b = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_1b'] ?? 0;
    $kpmr_rep_respon_pil4_1c = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_1c'] ?? 0;
    $kpmr_rep_respon_pil4_1d = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_1d'] ?? 0;
    $kpmr_rep_respon_pil4_1e = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_1e'] ?? 0;
    $kpmr_rep_respon_pil4_2a = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_2a'] ?? 0;
    $kpmr_rep_respon_pil4_2b = $data['respon_unit_kerja_reputasi_pil4'][143]['respon_pil4_2b'] ?? 0;

    
//rumus KPMR rep
//setingan ditetapkan
$kpmr_rep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_reputasi WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_rep_pil1 = $kpmr_rep['kpmr_rep_set_pil1'];
$set_rep_pil2 = $kpmr_rep['kpmr_rep_set_pil2'];
$set_rep_pil3 = $kpmr_rep['kpmr_rep_set_pil3'];
$set_rep_pil4 = $kpmr_rep['kpmr_rep_set_pil4'];
$set_rep_hsl = $kpmr_rep['kpmr_rep_set_tingkat_risiko'];



    if ($set_rep_pil1 == 1) {
        $numbers = array($kpmr_rep_pil1_total1 , $kpmr_rep_pil1_total2, $kpmr_rep_pil1_total3, $kpmr_rep_pil1_total4, $kpmr_rep_pil1_total5, $kpmr_rep_pil1_total6);
        $kpmr_rep_pil1_maxValue = max($numbers);
        $kpmr_rep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil1_average = $sum / count($numbers);
        $kpmr_rep_pil1_tingkat_risiko = $kpmr_rep_pil1_maxValue ;
    } else if ($set_rep_pil1 == 2) {
        $numbers = array($kpmr_rep_pil1_total1 , $kpmr_rep_pil1_total2, $kpmr_rep_pil1_total3, $kpmr_rep_pil1_total4, $kpmr_rep_pil1_total5, $kpmr_rep_pil1_total6);
        $kpmr_rep_pil1_maxValue = max($numbers);
        $kpmr_rep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil1_average = $sum / count($numbers);

        $kpmr_rep_pil1_tingkat_risiko = $kpmr_rep_pil1_minValue;
    } else if ($set_rep_pil1 == 3) {
        $numbers = array($kpmr_rep_pil1_total1 , $kpmr_rep_pil1_total2, $kpmr_rep_pil1_total3, $kpmr_rep_pil1_total4, $kpmr_rep_pil1_total5, $kpmr_rep_pil1_total6);
        $kpmr_rep_pil1_maxValue = max($numbers);
        $kpmr_rep_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil1_average = $sum / count($numbers);

        $kpmr_rep_pil1_tingkat_risiko = $kpmr_rep_pil1_average;
    } else {
       $kpmr_rep_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_rep_pil2 == 1) {
        $numbers = array($kpmr_rep_pil2_total1 , $kpmr_rep_pil2_total2, $kpmr_rep_pil2_total3);
        $kpmr_rep_pil2_maxValue = max($numbers);
        $kpmr_rep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil2_average = $sum / count($numbers);

        $kpmr_rep_pil2_tingkat_risiko = $kpmr_rep_pil2_maxValue ;
    } else if ($set_rep_pil2 == 2) {
        $numbers = array($kpmr_rep_pil2_total1 , $kpmr_rep_pil2_total2, $kpmr_rep_pil2_total3);
        $kpmr_rep_pil2_maxValue = max($numbers);
        $kpmr_rep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_rep_pil2_minValue;
    } else if ($set_rep_pil2 == 3) {
        $numbers = array($kpmr_rep_pil2_total1 , $kpmr_rep_pil2_total2, $kpmr_rep_pil2_total3);
        $kpmr_rep_pil2_maxValue = max($numbers);
        $kpmr_rep_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil2_average = $sum / count($numbers);

        $kpmr_rep_pil2_tingkat_risiko = $kpmr_rep_pil2_average;
    } else {
       $kpmr_rep_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_rep_pil3 == 1) {
        $numbers = array($kpmr_rep_pil3_total1 , $kpmr_rep_pil3_total2);
        $kpmr_rep_pil3_maxValue = max($numbers);
        $kpmr_rep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil3_average = $sum / count($numbers);

        $kpmr_rep_pil3_tingkat_risiko = $kpmr_rep_pil3_maxValue ;
    } else if ($set_rep_pil3 == 2) {
        $numbers = array($kpmr_rep_pil3_total1 , $kpmr_rep_pil3_total2);
        $kpmr_rep_pil3_maxValue = max($numbers);
        $kpmr_rep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil3_average = $sum / count($numbers);

        $kpmr_rep_pil3_tingkat_risiko = $kpmr_rep_pil3_minValue;
    } else if ($set_rep_pil3 == 3) {
        $numbers = array($kpmr_rep_pil3_total1 , $kpmr_rep_pil3_total2);
        $kpmr_rep_pil3_maxValue = max($numbers);
        $kpmr_rep_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil3_average = $sum / count($numbers);

        $kpmr_rep_pil3_tingkat_risiko = $kpmr_rep_pil3_average;
    } else {
       $kpmr_rep_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_rep_pil4 == 1) {
        $numbers = array($kpmr_rep_pil4_total1 , $kpmr_rep_pil4_total2);
        $kpmr_rep_pil4_maxValue = max($numbers);
        $kpmr_rep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil4_average = $sum / count($numbers);

        $kpmr_rep_pil4_tingkat_risiko = $kpmr_rep_pil4_maxValue ;
    } else if ($set_rep_pil4 == 2) {
        $numbers = array($kpmr_rep_pil4_total1 , $kpmr_rep_pil4_total2);
        $kpmr_rep_pil4_maxValue = max($numbers);
        $kpmr_rep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil4_average = $sum / count($numbers);

        $kpmr_rep_pil4_tingkat_risiko = $kpmr_rep_pil4_minValue;
    } else if ($set_rep_pil4 == 3) {
        $numbers = array($kpmr_rep_pil4_total1 , $kpmr_rep_pil4_total2);
        $kpmr_rep_pil4_maxValue = max($numbers);
        $kpmr_rep_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_rep_pil4_average = $sum / count($numbers);

        $kpmr_rep_pil4_tingkat_risiko = $kpmr_rep_pil4_average;
    } else {
    $kpmr_rep_pil4_tingkat_risiko = 0;
    }


    //inheren Stratejik pilar 1
    $inheren_stra_pilar1_1  = $data['inheren_stratejik_pilar1'][137]['pilar1_1'] ?? 0;
    $inheren_stra_pilar1_1a = $data['inheren_stratejik_pilar1'][137]['pilar1_1a'] ?? 0;
    $inheren_stra_pilar1_1b = $data['inheren_stratejik_pilar1'][137]['pilar1_1b'] ?? 0;
    $inheren_stra_pilar1_1c = $data['inheren_stratejik_pilar1'][137]['pilar1_1c'] ?? 0;
    $inheren_stra_pilar1_1d = $data['inheren_stratejik_pilar1'][137]['pilar1_1d'] ?? 0;
    $inheren_stra_pilar1_1e = $data['inheren_stratejik_pilar1'][137]['pilar1_1e'] ?? 0;
    $inheren_stra_pilar1_1f = $data['inheren_stratejik_pilar1'][137]['pilar1_1f'] ?? 0;
    $inheren_stra_average_pil1_1 = $data['inheren_stratejik_pilar1'][137]['average_pil1_1'] ?? 0;
    $inheren_stra_min_pil1_1     = $data['inheren_stratejik_pilar1'][137]['min_pil1_1'] ?? 0;
    $inheren_stra_max_pil1_1     = $data['inheren_stratejik_pilar1'][137]['max_pil1_1'] ?? 0;
    $inheren_stra_hasil_pil1_par1= $data['inheren_stratejik_pilar1'][137]['hasil_pil1_par1'] ?? 0;

    $ket_in_stra_pil1_1  = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1']  ?? 0;
    $ket_in_stra_pil1_1a = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1a'] ?? 0;
    $ket_in_stra_pil1_1b = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1b'] ?? 0;
    $ket_in_stra_pil1_1c = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1c'] ?? 0;
    $ket_in_stra_pil1_1d = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1d'] ?? 0;
    $ket_in_stra_pil1_1e = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1e'] ?? 0;
    $ket_in_stra_pil1_1f = $data['ket_inheren_stratejik_pilar1'][137]['ket_in_stra_pil1_1f'] ?? 0;

    $kpmr_stra_pilar1_1a = $data['kpmr_stratejik_pilar1'][137]['pilar1_1a'] ?? 0;
    $kpmr_stra_pilar1_1b = $data['kpmr_stratejik_pilar1'][137]['pilar1_1b'] ?? 0;
    $kpmr_stra_pilar1_1c = $data['kpmr_stratejik_pilar1'][137]['pilar1_1c'] ?? 0;
    $kpmr_stra_pilar1_1d = $data['kpmr_stratejik_pilar1'][137]['pilar1_1d'] ?? 0;
    $kpmr_stra_pilar1_1e = $data['kpmr_stratejik_pilar1'][137]['pilar1_1e'] ?? 0;
    $kpmr_stra_pil1_total1 = $data['kpmr_stratejik_pilar1'][137]['pil1_total1'] ?? 0;
    $kpmr_stra_pil1_peringkat1 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat1'] ?? 0;
    $kpmr_stra_pilar1_2a = $data['kpmr_stratejik_pilar1'][137]['pilar1_2a'] ?? 0;
    $kpmr_stra_pilar1_2b = $data['kpmr_stratejik_pilar1'][137]['pilar1_2b'] ?? 0;
    $kpmr_stra_pilar1_2c = $data['kpmr_stratejik_pilar1'][137]['pilar1_2c'] ?? 0;
    $kpmr_stra_pilar1_2d = $data['kpmr_stratejik_pilar1'][137]['pilar1_2d'] ?? 0;
    $kpmr_stra_pilar1_2e = $data['kpmr_stratejik_pilar1'][137]['pilar1_2e'] ?? 0;
    $kpmr_stra_pil1_total2 = $data['kpmr_stratejik_pilar1'][137]['pil1_total2'] ?? 0;
    $kpmr_stra_pil1_peringkat2 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat2'] ?? 0;
    $kpmr_stra_pilar1_3a = $data['kpmr_stratejik_pilar1'][137]['pilar1_3a'] ?? 0;
    $kpmr_stra_pilar1_3b = $data['kpmr_stratejik_pilar1'][137]['pilar1_3b'] ?? 0;
    $kpmr_stra_pilar1_3c = $data['kpmr_stratejik_pilar1'][137]['pilar1_3c'] ?? 0;
    $kpmr_stra_pil1_total3 = $data['kpmr_stratejik_pilar1'][137]['pil1_total3'] ?? 0;
    $kpmr_stra_pil1_peringkat3 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat3'] ?? 0;
    $kpmr_stra_pilar1_4a = $data['kpmr_stratejik_pilar1'][137]['pilar1_4a'] ?? 0;
    $kpmr_stra_pilar1_4b = $data['kpmr_stratejik_pilar1'][137]['pilar1_4b'] ?? 0;
    $kpmr_stra_pilar1_4c = $data['kpmr_stratejik_pilar1'][137]['pilar1_4c'] ?? 0;
    $kpmr_stra_pilar1_4d = $data['kpmr_stratejik_pilar1'][137]['pilar1_4d'] ?? 0;
    $kpmr_stra_pilar1_4e = $data['kpmr_stratejik_pilar1'][137]['pilar1_4e'] ?? 0;
    $kpmr_stra_pil1_total4 = $data['kpmr_stratejik_pilar1'][137]['pil1_total4'] ?? 0;
    $kpmr_stra_pil1_peringkat4 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat4'] ?? 0;
    $kpmr_stra_pilar1_5a = $data['kpmr_stratejik_pilar1'][137]['pilar1_5a'] ?? 0;
    $kpmr_stra_pilar1_5b = $data['kpmr_stratejik_pilar1'][137]['pilar1_5b'] ?? 0;
    $kpmr_stra_pilar1_5c = $data['kpmr_stratejik_pilar1'][137]['pilar1_5c'] ?? 0;
    $kpmr_stra_pilar1_5d = $data['kpmr_stratejik_pilar1'][137]['pilar1_5d'] ?? 0;
    $kpmr_stra_pil1_total5 = $data['kpmr_stratejik_pilar1'][137]['pil1_total5'] ?? 0;
    $kpmr_stra_pil1_peringkat5 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat5'] ?? 0;
    $kpmr_stra_pilar1_6a = $data['kpmr_stratejik_pilar1'][137]['pilar1_6a'] ?? 0;
    $kpmr_stra_pilar1_6b = $data['kpmr_stratejik_pilar1'][137]['pilar1_6b'] ?? 0;
    $kpmr_stra_pilar1_6c = $data['kpmr_stratejik_pilar1'][137]['pilar1_6c'] ?? 0;
    $kpmr_stra_pil1_total6 = $data['kpmr_stratejik_pilar1'][137]['pil1_total6'] ?? 0;
    $kpmr_stra_pil1_peringkat6 = $data['kpmr_stratejik_pilar1'][137]['pil1_peringkat6'] ?? 0;
    
        $kpmr_stra_respon_pil1_1a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_1a'] ?? 0;
        $kpmr_stra_respon_pil1_1b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_1b'] ?? 0;
        $kpmr_stra_respon_pil1_1c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_1c'] ?? 0;
        $kpmr_stra_respon_pil1_1d = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_1d'] ?? 0;
        $kpmr_stra_respon_pil1_1e = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_1e'] ?? 0;
        $kpmr_stra_respon_pil1_2a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_2a'] ?? 0;
        $kpmr_stra_respon_pil1_2b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_2b'] ?? 0;
        $kpmr_stra_respon_pil1_2c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_2c'] ?? 0;
        $kpmr_stra_respon_pil1_2d = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_2d'] ?? 0;
        $kpmr_stra_respon_pil1_2e = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_2e'] ?? 0;
        $kpmr_stra_respon_pil1_3a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_3a'] ?? 0;
        $kpmr_stra_respon_pil1_3b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_3b'] ?? 0;
        $kpmr_stra_respon_pil1_3c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_3c'] ?? 0;
        $kpmr_stra_respon_pil1_4a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_4a'] ?? 0;
        $kpmr_stra_respon_pil1_4b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_4b'] ?? 0;
        $kpmr_stra_respon_pil1_4c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_4c'] ?? 0;
        $kpmr_stra_respon_pil1_4d = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_4d'] ?? 0;
        $kpmr_stra_respon_pil1_4e = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_4e'] ?? 0;
        $kpmr_stra_respon_pil1_5a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_5a'] ?? 0;
        $kpmr_stra_respon_pil1_5b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_5b'] ?? 0;
        $kpmr_stra_respon_pil1_5c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_5c'] ?? 0;
        $kpmr_stra_respon_pil1_5d = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_5d'] ?? 0;
        $kpmr_stra_respon_pil1_6a = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_6a'] ?? 0;
        $kpmr_stra_respon_pil1_6b = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_6b'] ?? 0;
        $kpmr_stra_respon_pil1_6c = $data['respon_unit_kerja_stratejik_pil1'][137]['respon_pil1_6c'] ?? 0;
        

    
    //inheren Stratejik pilar 2
    $inheren_stra_pilar2_1  = $data['inheren_stratejik_pilar2'][137]['pilar2_1'] ?? 0;
    $inheren_stra_pilar2_1a = $data['inheren_stratejik_pilar2'][137]['pilar2_1a'] ?? 0;
    $inheren_stra_pilar2_1b = $data['inheren_stratejik_pilar2'][137]['pilar2_1b'] ?? 0;
    $inheren_stra_pilar2_1c = $data['inheren_stratejik_pilar2'][137]['pilar2_1c'] ?? 0;
    $inheren_stra_pilar2_1d = $data['inheren_stratejik_pilar2'][137]['pilar2_1d'] ?? 0;
    $inheren_stra_pilar2_1e = $data['inheren_stratejik_pilar2'][137]['pilar2_1e'] ?? 0;
    $inheren_stra_pilar2_1f = $data['inheren_stratejik_pilar2'][137]['pilar2_1f'] ?? 0;
    $inheren_stra_pilar2_1g = $data['inheren_stratejik_pilar2'][137]['pilar2_1g'] ?? 0;
    $inheren_stra_pilar2_1h = $data['inheren_stratejik_pilar2'][137]['pilar2_1h'] ?? 0;
    $inheren_stra_pilar2_1i = $data['inheren_stratejik_pilar2'][137]['pilar2_1i'] ?? 0;

    $inheren_stra_pilar2_2  = $data['inheren_stratejik_pilar2'][137]['pilar2_2'] ?? 0;
    $inheren_stra_pilar2_2a = $data['inheren_stratejik_pilar2'][137]['pilar2_2a'] ?? 0;
    $inheren_stra_pilar2_2b = $data['inheren_stratejik_pilar2'][137]['pilar2_2b'] ?? 0;
    $inheren_stra_pilar2_2c = $data['inheren_stratejik_pilar2'][137]['pilar2_2c'] ?? 0;

    $inheren_stra_average_pil2_1 = $data['inheren_stratejik_pilar2'][137]['average_pil2_1'] ?? 0;
    $inheren_stra_average_pil2_2 = $data['inheren_stratejik_pilar2'][137]['average_pil2_2'] ?? 0;
    $inheren_stra_min_pil2_1     = $data['inheren_stratejik_pilar2'][137]['min_pil2_1'] ?? 0;
    $inheren_stra_min_pil2_2     = $data['inheren_stratejik_pilar2'][137]['min_pil2_2'] ?? 0;
    $inheren_stra_max_pil2_1     = $data['inheren_stratejik_pilar2'][137]['max_pil2_1'] ?? 0;
    $inheren_stra_max_pil2_2     = $data['inheren_stratejik_pilar2'][137]['max_pil2_2'] ?? 0;
    $inheren_stra_hasil_pil2_par1= $data['inheren_stratejik_pilar2'][137]['hasil_pil2_par1'] ?? 0;
    $inheren_stra_hasil_pil2_par2= $data['inheren_stratejik_pilar2'][137]['hasil_pil2_par2'] ?? 0;

    $ket_in_stra_pil2_1  = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1']  ?? 0;
    $ket_in_stra_pil2_1a = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1a'] ?? 0;
    $ket_in_stra_pil2_1b = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1b'] ?? 0;
    $ket_in_stra_pil2_1c = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1c'] ?? 0;
    $ket_in_stra_pil2_1d = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1d'] ?? 0;
    $ket_in_stra_pil2_1e = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1e'] ?? 0;
    $ket_in_stra_pil2_1f = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1f'] ?? 0;
    $ket_in_stra_pil2_1g = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1g'] ?? 0;
    $ket_in_stra_pil2_1h = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1h'] ?? 0;
    $ket_in_stra_pil2_1i = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_1i'] ?? 0;

    $ket_in_stra_pil2_2  = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_2']  ?? 0;
    $ket_in_stra_pil2_2a = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_2a'] ?? 0;
    $ket_in_stra_pil2_2b = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_2b'] ?? 0;
    $ket_in_stra_pil2_2c = $data['ket_inheren_stratejik_pilar2'][137]['ket_in_stra_pil2_2c'] ?? 0;


        $kpmr_stra_pilar2_1a = $data['kpmr_stratejik_pilar2'][137]['pilar2_1a'] ?? 0;
    $kpmr_stra_pilar2_1b = $data['kpmr_stratejik_pilar2'][137]['pilar2_1b'] ?? 0;
    $kpmr_stra_pilar2_1c = $data['kpmr_stratejik_pilar2'][137]['pilar2_1c'] ?? 0;
    $kpmr_stra_pilar2_1d = $data['kpmr_stratejik_pilar2'][137]['pilar2_1d'] ?? 0;
    $kpmr_stra_pilar2_1e = $data['kpmr_stratejik_pilar2'][137]['pilar2_1e'] ?? 0;
    $kpmr_stra_pil2_total1 = $data['kpmr_stratejik_pilar2'][137]['pil2_total1'] ?? 0;
    $kpmr_stra_pil2_peringkat1 = $data['kpmr_stratejik_pilar2'][137]['pil2_peringkat1'] ?? 0;
    $kpmr_stra_pilar2_2a = $data['kpmr_stratejik_pilar2'][137]['pilar2_2a'] ?? 0;
    $kpmr_stra_pilar2_2b = $data['kpmr_stratejik_pilar2'][137]['pilar2_2b'] ?? 0;
    $kpmr_stra_pilar2_2c = $data['kpmr_stratejik_pilar2'][137]['pilar2_2c'] ?? 0;
    $kpmr_stra_pilar2_2d = $data['kpmr_stratejik_pilar2'][137]['pilar2_2d'] ?? 0;
    $kpmr_stra_pilar2_2e = $data['kpmr_stratejik_pilar2'][137]['pilar2_2e'] ?? 0;
    $kpmr_stra_pilar2_2f = $data['kpmr_stratejik_pilar2'][137]['pilar2_2f'] ?? 0;
    $kpmr_stra_pilar2_2g = $data['kpmr_stratejik_pilar2'][137]['pilar2_2g'] ?? 0;
    $kpmr_stra_pilar2_2h = $data['kpmr_stratejik_pilar2'][137]['pilar2_2h'] ?? 0;
    $kpmr_stra_pil2_total2 = $data['kpmr_stratejik_pilar2'][137]['pil2_total2'] ?? 0;
    $kpmr_stra_pil2_peringkat2 = $data['kpmr_stratejik_pilar2'][137]['pil2_peringkat2'] ?? 0;
    $kpmr_stra_pilar2_3a = $data['kpmr_stratejik_pilar2'][137]['pilar2_3a'] ?? 0;
    $kpmr_stra_pilar2_3b = $data['kpmr_stratejik_pilar2'][137]['pilar2_3b'] ?? 0;
    $kpmr_stra_pilar2_3c = $data['kpmr_stratejik_pilar2'][137]['pilar2_3c'] ?? 0;
    $kpmr_stra_pil2_total3 = $data['kpmr_stratejik_pilar2'][137]['pil2_total3'] ?? 0;
    $kpmr_stra_pil2_peringkat3 = $data['kpmr_stratejik_pilar2'][137]['pil2_peringkat3'] ?? 0;

    $kpmr_stra_respon_pil2_1a = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_1a'] ?? 0;
    $kpmr_stra_respon_pil2_1b = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_1b'] ?? 0;
    $kpmr_stra_respon_pil2_1c = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_1c'] ?? 0;
    $kpmr_stra_respon_pil2_1d = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_1d'] ?? 0;
    $kpmr_stra_respon_pil2_1e = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_1e'] ?? 0;
    $kpmr_stra_respon_pil2_2a = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2a'] ?? 0;
    $kpmr_stra_respon_pil2_2b = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2b'] ?? 0;
    $kpmr_stra_respon_pil2_2c = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2c'] ?? 0;
    $kpmr_stra_respon_pil2_2d = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2d'] ?? 0;
    $kpmr_stra_respon_pil2_2e = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2e'] ?? 0;
    $kpmr_stra_respon_pil2_2f = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2f'] ?? 0;
    $kpmr_stra_respon_pil2_2g = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2g'] ?? 0;
    $kpmr_stra_respon_pil2_2h = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_2h'] ?? 0;
    $kpmr_stra_respon_pil2_3a = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_3a'] ?? 0;
    $kpmr_stra_respon_pil2_3b = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_3b'] ?? 0;
    $kpmr_stra_respon_pil2_3c = $data['respon_unit_kerja_stratejik_pil2'][137]['respon_pil2_3c'] ?? 0;



    //inheren Stratejik pilar 3
    $inheren_stra_pilar3_1  = $data['inheren_stratejik_pilar3'][137]['pilar3_1'] ?? 0;
    $inheren_stra_pilar3_1a = $data['inheren_stratejik_pilar3'][137]['pilar3_1a'] ?? 0;
    $inheren_stra_pilar3_1b = $data['inheren_stratejik_pilar3'][137]['pilar3_1b'] ?? 0;
    $inheren_stra_pilar3_1c = $data['inheren_stratejik_pilar3'][137]['pilar3_1c'] ?? 0;
    $inheren_stra_pilar3_1d = $data['inheren_stratejik_pilar3'][137]['pilar3_1d'] ?? 0;
    $inheren_stra_pilar3_1e = $data['inheren_stratejik_pilar3'][137]['pilar3_1e'] ?? 0;
    $inheren_stra_pilar3_1f = $data['inheren_stratejik_pilar3'][137]['pilar3_1f'] ?? 0;
    $inheren_stra_pilar3_1g = $data['inheren_stratejik_pilar3'][137]['pilar3_1g'] ?? 0;
    $inheren_stra_pilar3_1h = $data['inheren_stratejik_pilar3'][137]['pilar3_1h'] ?? 0;
    $inheren_stra_pilar3_1i = $data['inheren_stratejik_pilar3'][137]['pilar3_1i'] ?? 0;
    $inheren_stra_pilar3_1j = $data['inheren_stratejik_pilar3'][137]['pilar3_1j'] ?? 0;
    $inheren_stra_pilar3_1k = $data['inheren_stratejik_pilar3'][137]['pilar3_1k'] ?? 0;
    $inheren_stra_pilar3_1l = $data['inheren_stratejik_pilar3'][137]['pilar3_1l'] ?? 0;
    $inheren_stra_pilar3_1m = $data['inheren_stratejik_pilar3'][137]['pilar3_1m'] ?? 0;
    $inheren_stra_pilar3_1n = $data['inheren_stratejik_pilar3'][137]['pilar3_1n'] ?? 0;
    $inheren_stra_pilar3_1o = $data['inheren_stratejik_pilar3'][137]['pilar3_1o'] ?? 0;
    $inheren_stra_pilar3_1p = $data['inheren_stratejik_pilar3'][137]['pilar3_1p'] ?? 0;

    $inheren_stra_pilar3_2  = $data['inheren_stratejik_pilar3'][137]['pilar3_2'] ?? 0;
    $inheren_stra_pilar3_2a = $data['inheren_stratejik_pilar3'][137]['pilar3_2a'] ?? 0;
    $inheren_stra_pilar3_2b = $data['inheren_stratejik_pilar3'][137]['pilar3_2b'] ?? 0;
    $inheren_stra_pilar3_2c = $data['inheren_stratejik_pilar3'][137]['pilar3_2c'] ?? 0;
    $inheren_stra_pilar3_2d = $data['inheren_stratejik_pilar3'][137]['pilar3_2d'] ?? 0;
    $inheren_stra_pilar3_2e = $data['inheren_stratejik_pilar3'][137]['pilar3_2e'] ?? 0;
    $inheren_stra_pilar3_2f = $data['inheren_stratejik_pilar3'][137]['pilar3_2f'] ?? 0;

    $inheren_stra_average_pil3_1 = $data['inheren_stratejik_pilar3'][137]['average_pil3_1'] ?? 0;
    $inheren_stra_average_pil3_2 = $data['inheren_stratejik_pilar3'][137]['average_pil3_2'] ?? 0;
    $inheren_stra_min_pil3_1     = $data['inheren_stratejik_pilar3'][137]['min_pil3_1'] ?? 0;
    $inheren_stra_min_pil3_2     = $data['inheren_stratejik_pilar3'][137]['min_pil3_2'] ?? 0;
    $inheren_stra_max_pil3_1     = $data['inheren_stratejik_pilar3'][137]['max_pil3_1'] ?? 0;
    $inheren_stra_max_pil3_2     = $data['inheren_stratejik_pilar3'][137]['max_pil3_2'] ?? 0;
    $inheren_stra_hasil_pil3_par1= $data['inheren_stratejik_pilar3'][137]['hasil_pil3_par1'] ?? 0;
    $inheren_stra_hasil_pil3_par2= $data['inheren_stratejik_pilar3'][137]['hasil_pil3_par2'] ?? 0;

    $ket_in_stra_pil3_1  = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1']  ?? 0;
    $ket_in_stra_pil3_1a = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1a'] ?? 0;
    $ket_in_stra_pil3_1b = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1b'] ?? 0;
    $ket_in_stra_pil3_1c = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1c'] ?? 0;
    $ket_in_stra_pil3_1d = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1d'] ?? 0;
    $ket_in_stra_pil3_1e = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1e'] ?? 0;
    $ket_in_stra_pil3_1f = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1f'] ?? 0;
    $ket_in_stra_pil3_1g = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1g'] ?? 0;
    $ket_in_stra_pil3_1h = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1h'] ?? 0;
    $ket_in_stra_pil3_1i = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1i'] ?? 0;
    $ket_in_stra_pil3_1j = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1j'] ?? 0;
    $ket_in_stra_pil3_1k = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1k'] ?? 0;
    $ket_in_stra_pil3_1l = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1l'] ?? 0;
    $ket_in_stra_pil3_1m = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1m'] ?? 0;
    $ket_in_stra_pil3_1n = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1n'] ?? 0;
    $ket_in_stra_pil3_1o = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1o'] ?? 0;
    $ket_in_stra_pil3_1p = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_1p'] ?? 0;

    $ket_in_stra_pil3_2  = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2']  ?? 0;
    $ket_in_stra_pil3_2a = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2a'] ?? 0;
    $ket_in_stra_pil3_2b = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2b'] ?? 0;
    $ket_in_stra_pil3_2c = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2c'] ?? 0;
    $ket_in_stra_pil3_2d = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2d'] ?? 0;
    $ket_in_stra_pil3_2e = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2e'] ?? 0;
    $ket_in_stra_pil3_2f = $data['ket_inheren_stratejik_pilar3'][137]['ket_in_stra_pil3_2f'] ?? 0;

        $kpmr_stra_pilar3_1a = $data['kpmr_stratejik_pilar3'][137]['pilar3_1a'] ?? 0;
    $kpmr_stra_pilar3_1b = $data['kpmr_stratejik_pilar3'][137]['pilar3_1b'] ?? 0;
    $kpmr_stra_pilar3_1c = $data['kpmr_stratejik_pilar3'][137]['pilar3_1c'] ?? 0;
    $kpmr_stra_pilar3_1d = $data['kpmr_stratejik_pilar3'][137]['pilar3_1d'] ?? 0;
    $kpmr_stra_pilar3_1e = $data['kpmr_stratejik_pilar3'][137]['pilar3_1e'] ?? 0;
    $kpmr_stra_pilar3_1f = $data['kpmr_stratejik_pilar3'][137]['pilar3_1f'] ?? 0;
    $kpmr_stra_pilar3_1g = $data['kpmr_stratejik_pilar3'][137]['pilar3_1g'] ?? 0;
    $kpmr_stra_pilar3_1h = $data['kpmr_stratejik_pilar3'][137]['pilar3_1h'] ?? 0;
    $kpmr_stra_pilar3_1i = $data['kpmr_stratejik_pilar3'][137]['pilar3_1i'] ?? 0;
    $kpmr_stra_pilar3_1j = $data['kpmr_stratejik_pilar3'][137]['pilar3_1j'] ?? 0;
    $kpmr_stra_pil3_total1 = $data['kpmr_stratejik_pilar3'][137]['pil3_total1'] ?? 0;
    $kpmr_stra_pil3_peringkat1 = $data['kpmr_stratejik_pilar3'][137]['pil3_peringkat1'] ?? 0;
    $kpmr_stra_pilar3_2a = $data['kpmr_stratejik_pilar3'][137]['pilar3_2a'] ?? 0;
    $kpmr_stra_pilar3_2b = $data['kpmr_stratejik_pilar3'][137]['pilar3_2b'] ?? 0;
    $kpmr_stra_pilar3_2c = $data['kpmr_stratejik_pilar3'][137]['pilar3_2c'] ?? 0;
    $kpmr_stra_pilar3_2d = $data['kpmr_stratejik_pilar3'][137]['pilar3_2d'] ?? 0;
    $kpmr_stra_pilar3_2e = $data['kpmr_stratejik_pilar3'][137]['pilar3_2e'] ?? 0;
    $kpmr_stra_pil3_total2 = $data['kpmr_stratejik_pilar3'][137]['pil3_total2'] ?? 0;
    $kpmr_stra_pil3_peringkat2 = $data['kpmr_stratejik_pilar3'][137]['pil3_peringkat2'] ?? 0;
    
    $kpmr_stra_respon_pil3_1a = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1a'] ?? 0;
    $kpmr_stra_respon_pil3_1b = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1b'] ?? 0;
    $kpmr_stra_respon_pil3_1c = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1c'] ?? 0;
    $kpmr_stra_respon_pil3_1d = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1d'] ?? 0;
    $kpmr_stra_respon_pil3_1e = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1e'] ?? 0;
    $kpmr_stra_respon_pil3_1f = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1f'] ?? 0;
    $kpmr_stra_respon_pil3_1g = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1g'] ?? 0;
    $kpmr_stra_respon_pil3_1h = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1h'] ?? 0;
    $kpmr_stra_respon_pil3_1i = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1i'] ?? 0;
    $kpmr_stra_respon_pil3_1j = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_1j'] ?? 0;
    $kpmr_stra_respon_pil3_2a = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_2a'] ?? 0;
    $kpmr_stra_respon_pil3_2b = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_2b'] ?? 0;
    $kpmr_stra_respon_pil3_2c = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_2c'] ?? 0;
    $kpmr_stra_respon_pil3_2d = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_2d'] ?? 0;
    $kpmr_stra_respon_pil3_2e = $data['respon_unit_kerja_stratejik_pil3'][137]['respon_pil3_2e'] ?? 0;
    


    //inheren Stratejik pilar lainnya
    $inheren_stra_pilar4_1a = $data['inheren_stratejik_lainnya'][137]['pilar4_1a'] ?? 0;
    $inheren_stra_pilar4_1b = $data['inheren_stratejik_lainnya'][137]['pilar4_1b'] ?? 0;
    $inheren_stra_pilar4_1c = $data['inheren_stratejik_lainnya'][137]['pilar4_1c'] ?? 0;
    $inheren_stra_pilar4_1d = $data['inheren_stratejik_lainnya'][137]['pilar4_1d'] ?? 0;

    $inheren_stra_average_pil4_1 = $data['inheren_stratejik_lainnya'][137]['average_pil4_1'] ?? 0;
    $inheren_stra_min_pil4_1     = $data['inheren_stratejik_lainnya'][137]['min_pil4_1'] ?? 0;
    $inheren_stra_max_pil4_1     = $data['inheren_stratejik_lainnya'][137]['max_pil4_1'] ?? 0;
    $inheren_stra_hasil_pil4_par1= $data['inheren_stratejik_lainnya'][137]['hasil_pil4_par1'] ?? 0;

    $ket_in_stra_pil4_1a = $data['ket_inheren_stratejik_lainnya'][137]['ket_in_stra_pil4_1a'] ?? 0;
    $ket_in_stra_pil4_1b = $data['ket_inheren_stratejik_lainnya'][137]['ket_in_stra_pil4_1b'] ?? 0;
    $ket_in_stra_pil4_1c = $data['ket_inheren_stratejik_lainnya'][137]['ket_in_stra_pil4_1c'] ?? 0;
    $ket_in_stra_pil4_1d = $data['ket_inheren_stratejik_lainnya'][137]['ket_in_stra_pil4_1d'] ?? 0;

        $kpmr_stra_pilar4_1a = $data['kpmr_stratejik_pilar4'][143]['pilar4_1a'] ?? 0;
    $kpmr_stra_pilar4_1b = $data['kpmr_stratejik_pilar4'][143]['pilar4_1b'] ?? 0;
    $kpmr_stra_pilar4_1c = $data['kpmr_stratejik_pilar4'][143]['pilar4_1c'] ?? 0;
    $kpmr_stra_pilar4_1d = $data['kpmr_stratejik_pilar4'][143]['pilar4_1d'] ?? 0;
    $kpmr_stra_pilar4_1e = $data['kpmr_stratejik_pilar4'][143]['pilar4_1e'] ?? 0;
    $kpmr_stra_pil4_total1 = $data['kpmr_stratejik_pilar4'][143]['pil4_total1'] ?? 0;
    $kpmr_stra_pil4_peringkat1 = $data['kpmr_stratejik_pilar4'][143]['pil4_peringkat1'] ?? 0;
    $kpmr_stra_pilar4_2a = $data['kpmr_stratejik_pilar4'][143]['pilar4_2a'] ?? 0;
    $kpmr_stra_pilar4_2b = $data['kpmr_stratejik_pilar4'][143]['pilar4_2b'] ?? 0;
    $kpmr_stra_pil4_total2 = $data['kpmr_stratejik_pilar4'][143]['pil4_total2'] ?? 0;
    $kpmr_stra_pil4_peringkat2 = $data['kpmr_stratejik_pilar4'][143]['pil4_peringkat2'] ?? 0;

    $kpmr_stra_respon_pil4_1a = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_1a'] ?? 0;
    $kpmr_stra_respon_pil4_1b = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_1b'] ?? 0;
    $kpmr_stra_respon_pil4_1c = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_1c'] ?? 0;
    $kpmr_stra_respon_pil4_1d = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_1d'] ?? 0;
    $kpmr_stra_respon_pil4_1e = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_1e'] ?? 0;
    $kpmr_stra_respon_pil4_2a = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_2a'] ?? 0;
    $kpmr_stra_respon_pil4_2b = $data['respon_unit_kerja_stratejik_pil4'][143]['respon_pil4_2b'] ?? 0;


//rumus KPMR stra
//setingan ditetapkan
$kpmr_stra = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_stratejik WHERE user = 2 AND tahun = '$tahun' AND periode = '$periode'"));
$set_stra_pil1 = $kpmr_stra['kpmr_stra_set_pil1'];
$set_stra_pil2 = $kpmr_stra['kpmr_stra_set_pil2'];
$set_stra_pil3 = $kpmr_stra['kpmr_stra_set_pil3'];
$set_stra_pil4 = $kpmr_stra['kpmr_stra_set_pil4'];
$set_stra_hsl = $kpmr_stra['kpmr_stra_set_tingkat_risiko'];



    if ($set_stra_pil1 == 1) {
        $numbers = array($kpmr_stra_pil1_total1 , $kpmr_stra_pil1_total2, $kpmr_stra_pil1_total3, $kpmr_stra_pil1_total4, $kpmr_stra_pil1_total5, $kpmr_stra_pil1_total6);
        $kpmr_stra_pil1_maxValue = max($numbers);
        $kpmr_stra_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil1_average = $sum / count($numbers);
        $kpmr_stra_pil1_tingkat_risiko = $kpmr_stra_pil1_maxValue ;
    } else if ($set_stra_pil1 == 2) {
        $numbers = array($kpmr_stra_pil1_total1 , $kpmr_stra_pil1_total2, $kpmr_stra_pil1_total3, $kpmr_stra_pil1_total4, $kpmr_stra_pil1_total5, $kpmr_stra_pil1_total6);
        $kpmr_stra_pil1_maxValue = max($numbers);
        $kpmr_stra_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil1_average = $sum / count($numbers);

        $kpmr_stra_pil1_tingkat_risiko = $kpmr_stra_pil1_minValue;
    } else if ($set_stra_pil1 == 3) {
        $numbers = array($kpmr_stra_pil1_total1 , $kpmr_stra_pil1_total2, $kpmr_stra_pil1_total3, $kpmr_stra_pil1_total4, $kpmr_stra_pil1_total5, $kpmr_stra_pil1_total6);
        $kpmr_stra_pil1_maxValue = max($numbers);
        $kpmr_stra_pil1_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil1_average = $sum / count($numbers);

        $kpmr_stra_pil1_tingkat_risiko = $kpmr_stra_pil1_average;
    } else {
       $kpmr_stra_pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_stra_pil2 == 1) {
        $numbers = array($kpmr_stra_pil2_total1 , $kpmr_stra_pil2_total2, $kpmr_stra_pil2_total3);
        $kpmr_stra_pil2_maxValue = max($numbers);
        $kpmr_stra_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil2_average = $sum / count($numbers);

        $kpmr_stra_pil2_tingkat_risiko = $kpmr_stra_pil2_maxValue ;
    } else if ($set_stra_pil2 == 2) {
        $numbers = array($kpmr_stra_pil2_total1 , $kpmr_stra_pil2_total2, $kpmr_stra_pil2_total3);
        $kpmr_stra_pil2_maxValue = max($numbers);
        $kpmr_stra_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil2_average = $sum / count($numbers);

        $pil2_tingkat_risiko = $kpmr_stra_pil2_minValue;
    } else if ($set_stra_pil2 == 3) {
        $numbers = array($kpmr_stra_pil2_total1 , $kpmr_stra_pil2_total2, $kpmr_stra_pil2_total3);
        $kpmr_stra_pil2_maxValue = max($numbers);
        $kpmr_stra_pil2_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil2_average = $sum / count($numbers);

        $kpmr_stra_pil2_tingkat_risiko = $kpmr_stra_pil2_average;
    } else {
       $kpmr_stra_pil2_tingkat_risiko = 0;
    }



    //rumus hasil pilar 3
    if ($set_stra_pil3 == 1) {
        $numbers = array($kpmr_stra_pil3_total1 , $kpmr_stra_pil3_total2);
        $kpmr_stra_pil3_maxValue = max($numbers);
        $kpmr_stra_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil3_average = $sum / count($numbers);

        $kpmr_stra_pil3_tingkat_risiko = $kpmr_stra_pil3_maxValue ;
    } else if ($set_stra_pil3 == 2) {
        $numbers = array($kpmr_stra_pil3_total1 , $kpmr_stra_pil3_total2);
        $kpmr_stra_pil3_maxValue = max($numbers);
        $kpmr_stra_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil3_average = $sum / count($numbers);

        $kpmr_stra_pil3_tingkat_risiko = $kpmr_stra_pil3_minValue;
    } else if ($set_stra_pil3 == 3) {
        $numbers = array($kpmr_stra_pil3_total1 , $kpmr_stra_pil3_total2);
        $kpmr_stra_pil3_maxValue = max($numbers);
        $kpmr_stra_pil3_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil3_average = $sum / count($numbers);

        $kpmr_stra_pil3_tingkat_risiko = $kpmr_stra_pil3_average;
    } else {
       $kpmr_stra_pil3_tingkat_risiko = 0;
    }



    //rumus hasil pilar 4
    if ($set_stra_pil4 == 1) {
        $numbers = array($kpmr_stra_pil4_total1 , $kpmr_stra_pil4_total2);
        $kpmr_stra_pil4_maxValue = max($numbers);
        $kpmr_stra_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil4_average = $sum / count($numbers);

        $kpmr_stra_pil4_tingkat_risiko = $kpmr_stra_pil4_maxValue ;
    } else if ($set_stra_pil4 == 2) {
        $numbers = array($kpmr_stra_pil4_total1 , $kpmr_stra_pil4_total2);
        $kpmr_stra_pil4_maxValue = max($numbers);
        $kpmr_stra_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil4_average = $sum / count($numbers);

        $kpmr_stra_pil4_tingkat_risiko = $kpmr_stra_pil4_minValue;
    } else if ($set_stra_pil4 == 3) {
        $numbers = array($kpmr_stra_pil4_total1 , $kpmr_stra_pil4_total2);
        $kpmr_stra_pil4_maxValue = max($numbers);
        $kpmr_stra_pil4_minValue = min($numbers);
        $sum = array_sum($numbers);
        $kpmr_stra_pil4_average = $sum / count($numbers);

        $kpmr_stra_pil4_tingkat_risiko = $kpmr_stra_pil4_average;
    } else {
    $kpmr_stra_pil4_tingkat_risiko = 0;
    }


    //data master kredit
    $pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132"));
    $pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar2 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132"));
    $pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132"));
    
    //data master likuditas
    $data_lik_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_likuiditas_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132"));
    
    $isian_inheren_kredit_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_likuiditas_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 2 AND frame_laporan_profil_risiko.dibuat_by = 132"));

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
        

    $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ");
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {
        mysqli_query($conn, "INSERT INTO frame_laporan_profil_risiko(id_profil_risiko,kantor_cabang,tahun,user,periode,modal_inti,total_aset,keterangan,dibuat_at,dibuat_by)
        VALUES ('0','$lokasi_kerja','$tahun','$user','$periode','$modal_inti','$total_aset','$keterangan','$dibuat_at','$dibuat_by')");

        //kre
        mysqli_query($conn, "
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
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang='$lokasi_kerja' AND tahun='$tahun' AND user='$user' AND periode='$periode'),
            '$dibuat_by', '$total_aset',
            '$aba', '$aset_produktif', '$kyd', '$noa_kyd', '$debitur_inti25',
            '$kredit_3sektor_ekonomi_terbesar', '$kredit_spg', '$kredit_pbta',
            '$kredit_jpendek', '$kredit_jmenengah', '$kredit_jpanjang',
            '$kredit_agunan_tb', '$kredit_agunan_kb', '$kredit_agunan_kr2',
            '$kredit_ta', '$kredit_kub', '$kredit_korporasi', '$kredit_pep',
            '$kredit_lebih350', '$kredit_joglo_mitra'
        )
        ");


        mysqli_query($conn, "
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
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang='$lokasi_kerja' AND tahun='$tahun' AND user='$user' AND periode='$periode'),
            '$dibuat_by', '$modal_inti',
            '$aset_produktif_bermasalah', '$total_aset_produktif', '$kredit_bermasalah',
            '$noa_kredit_bermasalah', '$kredit_bermasalah_neto', '$saldo_ppap', '$ayda',
            '$kyd', '$macet_jatuh_tempo', '$kkr', '$kredit_par4', '$osc_bln_sebelumnya',
            '$osc_2bln_sebelumnya', '$kredit_dp', '$noa_fpd_6bln', '$noa_ekspansi_6bln',
            '$nominal_fpd_6bln', '$plafond_ekspansi_6bln', '$npl_kredit_sd150',
            '$kyd_plafon_sd150', '$noa_kredit_sd150', '$npl_kredit_diatas50',
            '$kyd_plafon_diatas50', '$npl_apht', '$kyd_apht', '$npl_skmht', '$kyd_skmht',
            '$npl_agunan_lrd_bakidebet', '$kredit_agunan_lrd_bakidebet'
        )
        ");

        mysqli_query($conn, "
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
            (SELECT id_profil_risiko FROM frame_laporan_profil_risiko WHERE kantor_cabang='$lokasi_kerja' AND tahun='$tahun' AND user='$user' AND periode='$periode'),
            '$dibuat_by',
            '$osc_akhir_tahun_lalu', '$noa_osc_akhir_tahun_lalu', '$npl_akhir_tahun_lalu',
            '$noa_npl_akhir_tahun_lalu', '$osc_per_bln_penilaian', '$pertumbuhan_rata2_bpr_thn_lalu',
            '$pertumbuhan_rata2_bpr', '$pertumbuhan_kyd_bpr', '$rasio_pertumbuhan_rata2_bpr',
            '$td_pp_l', '$td_pp_dp', '$td_pp_kl', '$td_pp_d', '$td_pp_m',
            '$td_pp_l_noa', '$td_pp_dp_noa', '$td_pp_kl_noa', '$td_pp_d_noa', '$td_pp_m_noa',
            '$td_ps_l', '$td_ps_dp', '$td_ps_kl', '$td_ps_d', '$td_ps_m',
            '$td_ps_l_noa', '$td_ps_dp_noa', '$td_ps_kl_noa', '$td_ps_d_noa', '$td_ps_m_noa',
            '$d_pp_l', '$d_pp_dp', '$d_pp_kl', '$d_pp_d', '$d_pp_m',
            '$d_pp_l_noa', '$d_pp_dp_noa', '$d_pp_kl_noa', '$d_pp_d_noa', '$d_pp_m_noa',
            '$d_ps_l', '$d_ps_dp', '$d_ps_kl', '$d_ps_d', '$d_ps_m',
            '$d_ps_l_noa', '$d_ps_dp_noa', '$d_ps_kl_noa', '$d_ps_d_noa', '$d_ps_m_noa',
            '$osc_2bln_sebelumnya', '$noa_2bln_sebelumnya', '$npl_2bln_sebelumnya', '$rasio_2bln_sebelumnya',
            '$osc_1bln_sebelumnya', '$noa_1bln_sebelumnya', '$npl_1bln_sebelumnya',
            '$noa_npl_2bln_sebelumnya', '$rasio_npl_2bln_sebelumnya', '$rasio_1bln_sebelumnya',
            '$osc_bln_penilaian', '$noa_bln_penilaian', '$npl_bln_penilaian', '$rasio_bln_penilaian',
            '$aba', '$aba_tertinggi', '$aba_bank_umum', '$aba_bpr',
            '$noa_npl_1bln_sebelumnya', '$rasio_npl_1bln_sebelumnya',
            '$noa_npl_bln_penilaian', '$rasio_npl_bln_penilaian'
        )
        ");



        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar1(id_inheren_kredit_pilar1,id_profil_risiko,dibuat_by,pilar1_3,pilar1_4)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by'
        ,'$kredit_pilar1_3'
        ,'$kredit_pilar1_4')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar2(id_inheren_kredit_pilar2,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar3(id_inheren_kredit_pilar3,id_profil_risiko,dibuat_by,
        pilar3_1,
        pilar3_1a,
        pilar3_1b,
        pilar3_1c,
        pilar3_1d,
        pilar3_1e,
        hasil_pil3_par1,
        hasil_pil3_par1a,
        hasil_pil3_par1b,
        hasil_pil3_par1c,
        hasil_pil3_par1d,
        hasil_pil3_par1e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kredit_pilar3_1',
        '$kredit_pilar3_1a',
        '$kredit_pilar3_1b',
        '$kredit_pilar3_1c',
        '$kredit_pilar3_1d',
        '$kredit_pilar3_1e',
        '$kredit_hasil_pil3_par1',
        '$kredit_hasil_pil3_par1a',
        '$kredit_hasil_pil3_par1b',
        '$kredit_hasil_pil3_par1c',
        '$kredit_hasil_pil3_par1d',
        '$kredit_hasil_pil3_par1e')");
        
        mysqli_query($conn, "INSERT INTO inheren_kredit_pilar4(id_inheren_kredit_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        hasil_pil4_par1,
        hasil_pil4_par1a,
        hasil_pil4_par1b,
        hasil_pil4_par1c,
        hasil_pil4_par1d)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kredit_pilar4_1a',
        '$kredit_pilar4_1b',
        '$kredit_pilar4_1c',
        '$kredit_pilar4_1d',
        '$kredit_hasil_pil4_par1',
        '$kredit_hasil_pil4_par1a',
        '$kredit_hasil_pil4_par1b',
        '$kredit_hasil_pil4_par1c',
        '$kredit_hasil_pil4_par1d')");

        mysqli_query($conn, "INSERT INTO inheren_kredit_lainnya(id_inheren_kredit_lainnya,id_profil_risiko,dibuat_by,
        pilar5_1a,
        pilar5_1b,
        pilar5_1c,
        pilar5_1d,
        pilar5_1e,
        pilar5_1f,
        pilar5_1g,
        pilar5_1h,
        pilar5_1i,
        pilar5_1j,
        pilar5_1k,
        hasil_pil5_par1,
        hasil_pil5_par1a,
        hasil_pil5_par1b,
        hasil_pil5_par1c,
        hasil_pil5_par1d,
        hasil_pil5_par1e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kredit_pilar5_1a',
        '$kredit_pilar5_1b',
        '$kredit_pilar5_1c',
        '$kredit_pilar5_1d',
        '$kredit_pilar5_1e',
        '$kredit_pilar5_1f',
        '$kredit_pilar5_1g',
        '$kredit_pilar5_1h',
        '$kredit_pilar5_1i',
        '$kredit_pilar5_1j',
        '$kredit_pilar5_1k',
        '$kredit_hasil_pil5_par1',
        '$kredit_hasil_pil5_par1a',
        '$kredit_hasil_pil5_par1b',
        '$kredit_hasil_pil5_par1c',
        '$kredit_hasil_pil5_par1d',
        '$kredit_hasil_pil5_par1e')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_kredit(id_hasil_inheren_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        

        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar1(id_kpmr_kredit_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_pilar1_1a',
        '$kpmr_kre_pilar1_1b',
        '$kpmr_kre_pilar1_1c',
        '$kpmr_kre_pilar1_1d',
        '$kpmr_kre_pilar1_1e',
        '$kpmr_kre_pil1_total1',
        '$kpmr_kre_pil1_peringkat1',
        '$kpmr_kre_pilar1_2a',
        '$kpmr_kre_pilar1_2b',
        '$kpmr_kre_pilar1_2c',
        '$kpmr_kre_pilar1_2d',
        '$kpmr_kre_pilar1_2e',
        '$kpmr_kre_pil1_total2',
        '$kpmr_kre_pil1_peringkat2',
        '$kpmr_kre_pilar1_3a',
        '$kpmr_kre_pilar1_3b',
        '$kpmr_kre_pilar1_3c',
        '$kpmr_kre_pil1_total3',
        '$kpmr_kre_pil1_peringkat3',
        '$kpmr_kre_pilar1_4a',
        '$kpmr_kre_pilar1_4b',
        '$kpmr_kre_pilar1_4c',
        '$kpmr_kre_pilar1_4d',
        '$kpmr_kre_pilar1_4e',
        '$kpmr_kre_pil1_total4',
        '$kpmr_kre_pil1_peringkat4',
        '$kpmr_kre_pilar1_5a',
        '$kpmr_kre_pilar1_5b',
        '$kpmr_kre_pilar1_5c',
        '$kpmr_kre_pilar1_5d',
        '$kpmr_kre_pil1_total5',
        '$kpmr_kre_pil1_peringkat5',
        '$kpmr_kre_pilar1_6a',
        '$kpmr_kre_pilar1_6b',
        '$kpmr_kre_pilar1_6c',
        '$kpmr_kre_pil1_total6',
        '$kpmr_kre_pil1_peringkat6')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar2(id_kpmr_kredit_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_pilar2_1a',
        '$kpmr_kre_pilar2_1b',
        '$kpmr_kre_pilar2_1c',
        '$kpmr_kre_pilar2_1d',
        '$kpmr_kre_pilar2_1e',
        '$kpmr_kre_pil2_total1',
        '$kpmr_kre_pil2_peringkat1',
        '$kpmr_kre_pilar2_2a',
        '$kpmr_kre_pilar2_2b',
        '$kpmr_kre_pilar2_2c',
        '$kpmr_kre_pilar2_2d',
        '$kpmr_kre_pilar2_2e',
        '$kpmr_kre_pilar2_2f',
        '$kpmr_kre_pilar2_2g',
        '$kpmr_kre_pilar2_2h',
        '$kpmr_kre_pil2_total2',
        '$kpmr_kre_pil2_peringkat2',
        '$kpmr_kre_pilar2_3a',
        '$kpmr_kre_pilar2_3b',
        '$kpmr_kre_pilar2_3c',
        '$kpmr_kre_pil2_total3',
        '$kpmr_kre_pil2_peringkat3')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar3(id_kpmr_kredit_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_pilar3_1a',
        '$kpmr_kre_pilar3_1b',
        '$kpmr_kre_pilar3_1c',
        '$kpmr_kre_pilar3_1d',
        '$kpmr_kre_pilar3_1e',
        '$kpmr_kre_pilar3_1f',
        '$kpmr_kre_pilar3_1g',
        '$kpmr_kre_pilar3_1h',
        '$kpmr_kre_pilar3_1i',
        '$kpmr_kre_pilar3_1j',
        '$kpmr_kre_pil3_total1',
        '$kpmr_kre_pil3_peringkat1',
        '$kpmr_kre_pilar3_2a',
        '$kpmr_kre_pilar3_2b',
        '$kpmr_kre_pilar3_2c',
        '$kpmr_kre_pilar3_2d',
        '$kpmr_kre_pilar3_2e',
        '$kpmr_kre_pil3_total2',
        '$kpmr_kre_pil3_peringkat2')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kredit_pilar4(id_kpmr_kredit_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_pilar4_1a',
        '$kpmr_kre_pilar4_1b',
        '$kpmr_kre_pilar4_1c',
        '$kpmr_kre_pilar4_1d',
        '$kpmr_kre_pilar4_1e',
        '$kpmr_kre_pil4_total1',
        '$kpmr_kre_pil4_peringkat1',
        '$kpmr_kre_pilar4_2a',
        '$kpmr_kre_pilar4_2b',
        '$kpmr_kre_pil4_total2',
        '$kpmr_kre_pil4_peringkat2')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_kredit(id_hasil_kpmr_kredit,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_pil1_maxValue',
        '$kpmr_kre_pil1_minValue',
        '$kpmr_kre_pil1_average',
        '$set_kre_pil1',
        '$kpmr_kre_pil1_tingkat_risiko',
        '$kpmr_kre_pil2_maxValue',
        '$kpmr_kre_pil2_minValue',
        '$kpmr_kre_pil2_average',
        '$set_kre_pil2',
        '$kpmr_kre_pil2_tingkat_risiko',
        '$kpmr_kre_pil3_maxValue',
        '$kpmr_kre_pil3_minValue',
        '$kpmr_kre_pil3_average',
        '$set_kre_pil3',
        '$kpmr_kre_pil3_tingkat_risiko',
        '$kpmr_kre_pil4_maxValue',
        '$kpmr_kre_pil4_minValue',
        '$kpmr_kre_pil4_average',
        '$set_kre_pil4',
        '$kpmr_kre_pil4_tingkat_risiko')");
        

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil1(id_respon_kredit_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_respon_pil1_1a',
        '$kpmr_kre_respon_pil1_1b',
        '$kpmr_kre_respon_pil1_1c',
        '$kpmr_kre_respon_pil1_1d',
        '$kpmr_kre_respon_pil1_1e',
        '$kpmr_kre_respon_pil1_2a',
        '$kpmr_kre_respon_pil1_2b',
        '$kpmr_kre_respon_pil1_2c',
        '$kpmr_kre_respon_pil1_2d',
        '$kpmr_kre_respon_pil1_2e',
        '$kpmr_kre_respon_pil1_3a',
        '$kpmr_kre_respon_pil1_3b',
        '$kpmr_kre_respon_pil1_3c',
        '$kpmr_kre_respon_pil1_4a',
        '$kpmr_kre_respon_pil1_4b',
        '$kpmr_kre_respon_pil1_4c',
        '$kpmr_kre_respon_pil1_4d',
        '$kpmr_kre_respon_pil1_4e',
        '$kpmr_kre_respon_pil1_5a',
        '$kpmr_kre_respon_pil1_5b',
        '$kpmr_kre_respon_pil1_5c',
        '$kpmr_kre_respon_pil1_5d',
        '$kpmr_kre_respon_pil1_6a',
        '$kpmr_kre_respon_pil1_6b',
        '$kpmr_kre_respon_pil1_6c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil2(id_respon_kredit_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_respon_pil2_1a',
        '$kpmr_kre_respon_pil2_1b',
        '$kpmr_kre_respon_pil2_1c',
        '$kpmr_kre_respon_pil2_1d',
        '$kpmr_kre_respon_pil2_1e',
        '$kpmr_kre_respon_pil2_2a',
        '$kpmr_kre_respon_pil2_2b',
        '$kpmr_kre_respon_pil2_2c',
        '$kpmr_kre_respon_pil2_2d',
        '$kpmr_kre_respon_pil2_2e',
        '$kpmr_kre_respon_pil2_2f',
        '$kpmr_kre_respon_pil2_2g',
        '$kpmr_kre_respon_pil2_2h',
        '$kpmr_kre_respon_pil2_3a',
        '$kpmr_kre_respon_pil2_3b',
        '$kpmr_kre_respon_pil2_3c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil3(id_respon_kredit_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_respon_pil3_1a',
        '$kpmr_kre_respon_pil3_1b',
        '$kpmr_kre_respon_pil3_1c',
        '$kpmr_kre_respon_pil3_1d',
        '$kpmr_kre_respon_pil3_1e',
        '$kpmr_kre_respon_pil3_1f',
        '$kpmr_kre_respon_pil3_1g',
        '$kpmr_kre_respon_pil3_1h',
        '$kpmr_kre_respon_pil3_1i',
        '$kpmr_kre_respon_pil3_1j',
        '$kpmr_kre_respon_pil3_2a',
        '$kpmr_kre_respon_pil3_2b',
        '$kpmr_kre_respon_pil3_2c',
        '$kpmr_kre_respon_pil3_2d',
        '$kpmr_kre_respon_pil3_2e')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kredit_pil4(id_respon_kredit_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kre_respon_pil4_1a',
        '$kpmr_kre_respon_pil4_1b',
        '$kpmr_kre_respon_pil4_1c',
        '$kpmr_kre_respon_pil4_1d',
        '$kpmr_kre_respon_pil4_1e',
        '$kpmr_kre_respon_pil4_2a',
        '$kpmr_kre_respon_pil4_2b')");
        

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kredit(id_kpmr2_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_kredit(id_keterangan_inheren_kredit,id_profil_risiko,dibuat_by,
        ket_pil1_1,
        ket_pil1_2,
        ket_pil1_3,
        ket_pil1_4,
        ket_pil1,
        ket_pil2_1,
        ket_pil2_2,
        ket_pil2_3,
        ket_pil2,
        ket_pil3_1,
        ket_pil3,
        ket_pil4_1,
        ket_pil4,
        ket_pil5_1,
        ket_pil5)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kre_ket_pil1_1',
        '$kre_ket_pil1_2',
        '$kre_ket_pil1_3',
        '$kre_ket_pil1_4',
        '$kre_ket_pil1',
        '$kre_ket_pil2_1',
        '$kre_ket_pil2_2',
        '$kre_ket_pil2_3',
        '$kre_ket_pil2',
        '$kre_ket_pil3_1',
        '$kre_ket_pil3',
        '$kre_ket_pil4_1',
        '$kre_ket_pil4',
        '$kre_ket_pil5_1',
        '$kre_ket_pil5')");
        
        mysqli_query($conn, "INSERT INTO keterangan_profil_kredit(id_ket_profil_kredit,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        



        //op
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar1(id_inheren_operasional_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar1_1',
        '$ops_pilar1_2',
        '$ops_pilar1_2a',
        '$ops_pilar1_2b',
        '$ops_pilar1_3',
        '$ops_pilar1_3a',
        '$ops_pilar1_3b',
        '$ops_pilar1_3c',
        '$ops_pilar1_4',
        '$ops_pilar1_4a',
        '$ops_average_pil1_1',
        '$ops_average_pil1_2',
        '$ops_average_pil1_3',
        '$ops_average_pil1_4',
        '$ops_min_pil1_1',
        '$ops_min_pil1_2',
        '$ops_min_pil1_3',
        '$ops_min_pil1_4',
        '$ops_max_pil1_1',
        '$ops_max_pil1_2',
        '$ops_max_pil1_3',
        '$ops_max_pil1_4',
        '$ops_hasil_pil1_par1',
        '$ops_hasil_pil1_par2',
        '$ops_hasil_pil1_par3',
        '$ops_hasil_pil1_par4')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar2(id_inheren_operasional_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar2_1',
        '$ops_pilar2_1a',
        '$ops_pilar2_1b',
        '$ops_pilar2_1c',
        '$ops_pilar2_1d',
        '$ops_pilar2_1e',
        '$ops_pilar2_1f',
        '$ops_pilar2_1g',
        '$ops_pilar2_1h',
        '$ops_pilar2_1i',
        '$ops_pilar2_1j',
        '$ops_pilar2_1k',
        '$ops_pilar2_1l',
        '$ops_pilar2_1m',
        '$ops_pilar2_1n',
        '$ops_pilar2_2',
        '$ops_average_pil2_1',
        '$ops_average_pil2_2',
        '$ops_min_pil2_1',
        '$ops_min_pil2_2',
        '$ops_max_pil2_1',
        '$ops_max_pil2_2',
        '$ops_hasil_pil2_par1',
        '$ops_hasil_pil2_par2')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar3(id_inheren_operasional_pilar3,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar3_1',
        '$ops_pilar3_1a',
        '$ops_pilar3_1b',
        '$ops_pilar3_1c',
        '$ops_pilar3_1d',
        '$ops_pilar3_1e',
        '$ops_pilar3_1f',
        '$ops_pilar3_1g',
        '$ops_pilar3_1h',
        '$ops_pilar3_1i',
        '$ops_pilar3_1j',
        '$ops_pilar3_1k',
        '$ops_pilar3_1l',
        '$ops_pilar3_1m',
        '$ops_pilar3_1n',
        '$ops_pilar3_1o',
        '$ops_pilar3_1p',
        '$ops_average_pil3_1',
        '$ops_min_pil3_1',
        '$ops_max_pil3_1',
        '$ops_hasil_pil3_par1')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar4(id_inheren_operasional_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        average_pil4_1,
        min_pil4_1,
        max_pil4_1,
        hasil_pil4_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar4_1',
        '$ops_pilar4_1a',
        '$ops_pilar4_1b',
        '$ops_pilar4_1c',
        '$ops_pilar4_1d',
        '$ops_average_pil4_1',
        '$ops_min_pil4_1',
        '$ops_max_pil4_1',
        '$ops_hasil_pil4_par1')");
        
        mysqli_query($conn, "INSERT INTO inheren_operasional_pilar5(id_inheren_operasional_pilar5,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar5_1',
        '$ops_pilar5_1a',
        '$ops_pilar5_1b',
        '$ops_pilar5_1c',
        '$ops_pilar5_1d',
        '$ops_pilar5_1e',
        '$ops_pilar5_1f',
        '$ops_average_pil5_1',
        '$ops_min_pil5_1',
        '$ops_max_pil5_1',
        '$ops_hasil_pil5_par1')");

        mysqli_query($conn, "INSERT INTO inheren_operasional_lainnya(id_inheren_operasional_lainnya,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ops_pilar6_1a',
        '$ops_pilar6_1b',
        '$ops_pilar6_1c',
        '$ops_pilar6_1d',
        '$ops_pilar6_1e',
        '$ops_pilar6_1f',
        '$ops_average_pil6_1',
        '$ops_min_pil6_1',
        '$ops_max_pil6_1',
        '$ops_hasil_pil6_par1')");
        
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar1(id_ket_inheren_operasional_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil1_1',
        '$ket_in_op_pil1_2',
        '$ket_in_op_pil1_2a',
        '$ket_in_op_pil1_2b',
        '$ket_in_op_pil1_3',
        '$ket_in_op_pil1_3a',
        '$ket_in_op_pil1_3b',
        '$ket_in_op_pil1_3c',
        '$ket_in_op_pil1_4',
        '$ket_in_op_pil1_4a')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar2(id_ket_inheren_operasional_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil2_1',
        '$ket_in_op_pil2_1a',
        '$ket_in_op_pil2_1b',
        '$ket_in_op_pil2_1c',
        '$ket_in_op_pil2_1d',
        '$ket_in_op_pil2_1e',
        '$ket_in_op_pil2_1f',
        '$ket_in_op_pil2_1g',
        '$ket_in_op_pil2_1h',
        '$ket_in_op_pil2_1i',
        '$ket_in_op_pil2_1j',
        '$ket_in_op_pil2_1k',
        '$ket_in_op_pil2_1l',
        '$ket_in_op_pil2_1m',
        '$ket_in_op_pil2_1n',
        '$ket_in_op_pil2_2')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar3(id_ket_inheren_operasional_pilar3,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil3_1',
        '$ket_in_op_pil3_1a',
        '$ket_in_op_pil3_1b',
        '$ket_in_op_pil3_1c',
        '$ket_in_op_pil3_1d',
        '$ket_in_op_pil3_1e',
        '$ket_in_op_pil3_1f',
        '$ket_in_op_pil3_1g',
        '$ket_in_op_pil3_1h',
        '$ket_in_op_pil3_1i',
        '$ket_in_op_pil3_1j',
        '$ket_in_op_pil3_1k',
        '$ket_in_op_pil3_1l',
        '$ket_in_op_pil3_1m',
        '$ket_in_op_pil3_1n',
        '$ket_in_op_pil3_1o',
        '$ket_in_op_pil3_1p')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar4(id_ket_inheren_operasional_pilar4,id_profil_risiko,dibuat_by,
        ket_in_op_pil4_1,
        ket_in_op_pil4_1a,
        ket_in_op_pil4_1b,
        ket_in_op_pil4_1c,
        ket_in_op_pil4_1d)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil4_1',
        '$ket_in_op_pil4_1a',
        '$ket_in_op_pil4_1b',
        '$ket_in_op_pil4_1c',
        '$ket_in_op_pil4_1d')");
        
        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_pilar5(id_ket_inheren_operasional_pilar5,id_profil_risiko,dibuat_by,
        ket_in_op_pil5_1,
        ket_in_op_pil5_1a,
        ket_in_op_pil5_1b,
        ket_in_op_pil5_1c,
        ket_in_op_pil5_1d,
        ket_in_op_pil5_1e,
        ket_in_op_pil5_1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil5_1',
        '$ket_in_op_pil5_1a',
        '$ket_in_op_pil5_1b',
        '$ket_in_op_pil5_1c',
        '$ket_in_op_pil5_1d',
        '$ket_in_op_pil5_1e',
        '$ket_in_op_pil5_1f')");

        mysqli_query($conn, "INSERT INTO ket_inheren_operasional_lainnya(id_ket_inheren_operasional_lainnya,id_profil_risiko,dibuat_by,
        ket_in_op_pil6_1a,
        ket_in_op_pil6_1b,
        ket_in_op_pil6_1c,
        ket_in_op_pil6_1d,
        ket_in_op_pil6_1e,
        ket_in_op_pil6_1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_op_pil6_1a',
        '$ket_in_op_pil6_1b',
        '$ket_in_op_pil6_1c',
        '$ket_in_op_pil6_1d',
        '$ket_in_op_pil6_1e',
        '$ket_in_op_pil6_1f')");
    

        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar1(id_kpmr_operasional_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_pilar1_1a',
        '$kpmr_ops_pilar1_1b',
        '$kpmr_ops_pilar1_1c',
        '$kpmr_ops_pilar1_1d',
        '$kpmr_ops_pilar1_1e',
        '$kpmr_ops_pil1_total1',
        '$kpmr_ops_pil1_peringkat1',
        '$kpmr_ops_pilar1_2a',
        '$kpmr_ops_pilar1_2b',
        '$kpmr_ops_pilar1_2c',
        '$kpmr_ops_pilar1_2d',
        '$kpmr_ops_pilar1_2e',
        '$kpmr_ops_pil1_total2',
        '$kpmr_ops_pil1_peringkat2',
        '$kpmr_ops_pilar1_3a',
        '$kpmr_ops_pilar1_3b',
        '$kpmr_ops_pilar1_3c',
        '$kpmr_ops_pil1_total3',
        '$kpmr_ops_pil1_peringkat3',
        '$kpmr_ops_pilar1_4a',
        '$kpmr_ops_pilar1_4b',
        '$kpmr_ops_pilar1_4c',
        '$kpmr_ops_pilar1_4d',
        '$kpmr_ops_pilar1_4e',
        '$kpmr_ops_pil1_total4',
        '$kpmr_ops_pil1_peringkat4',
        '$kpmr_ops_pilar1_5a',
        '$kpmr_ops_pilar1_5b',
        '$kpmr_ops_pilar1_5c',
        '$kpmr_ops_pilar1_5d',
        '$kpmr_ops_pil1_total5',
        '$kpmr_ops_pil1_peringkat5',
        '$kpmr_ops_pilar1_6a',
        '$kpmr_ops_pilar1_6b',
        '$kpmr_ops_pilar1_6c',
        '$kpmr_ops_pil1_total6',
        '$kpmr_ops_pil1_peringkat6')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar2(id_kpmr_operasional_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_pilar2_1a',
        '$kpmr_ops_pilar2_1b',
        '$kpmr_ops_pilar2_1c',
        '$kpmr_ops_pilar2_1d',
        '$kpmr_ops_pilar2_1e',
        '$kpmr_ops_pil2_total1',
        '$kpmr_ops_pil2_peringkat1',
        '$kpmr_ops_pilar2_2a',
        '$kpmr_ops_pilar2_2b',
        '$kpmr_ops_pilar2_2c',
        '$kpmr_ops_pilar2_2d',
        '$kpmr_ops_pilar2_2e',
        '$kpmr_ops_pilar2_2f',
        '$kpmr_ops_pilar2_2g',
        '$kpmr_ops_pilar2_2h',
        '$kpmr_ops_pil2_total2',
        '$kpmr_ops_pil2_peringkat2',
        '$kpmr_ops_pilar2_3a',
        '$kpmr_ops_pilar2_3b',
        '$kpmr_ops_pilar2_3c',
        '$kpmr_ops_pil2_total3',
        '$kpmr_ops_pil2_peringkat3')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar3(id_kpmr_operasional_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2,
        pilar3_3a,
        pilar3_3b,
        pilar3_3c,
        pil3_total3,
        pil3_peringkat3,
        pilar3_4a,
        pilar3_4b,
        pilar3_4c,
        pil3_total4,
        pil3_peringkat4)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_pilar3_1a',
        '$kpmr_ops_pilar3_1b',
        '$kpmr_ops_pilar3_1c',
        '$kpmr_ops_pilar3_1d',
        '$kpmr_ops_pilar3_1e',
        '$kpmr_ops_pilar3_1f',
        '$kpmr_ops_pilar3_1g',
        '$kpmr_ops_pilar3_1h',
        '$kpmr_ops_pilar3_1i',
        '$kpmr_ops_pilar3_1j',
        '$kpmr_ops_pil3_total1',
        '$kpmr_ops_pil3_peringkat1',
        '$kpmr_ops_pilar3_2a',
        '$kpmr_ops_pilar3_2b',
        '$kpmr_ops_pilar3_2c',
        '$kpmr_ops_pilar3_2d',
        '$kpmr_ops_pilar3_2e',
        '$kpmr_ops_pil3_total2',
        '$kpmr_ops_pil3_peringkat2',
        '$kpmr_ops_pilar3_3a',
        '$kpmr_ops_pilar3_3b',
        '$kpmr_ops_pilar3_3c',
        '$kpmr_ops_pil3_total3',
        '$kpmr_ops_pil3_peringkat3',
        '$kpmr_ops_pilar3_4a',
        '$kpmr_ops_pilar3_4b',
        '$kpmr_ops_pilar3_4c',
        '$kpmr_ops_pil3_total4',
        '$kpmr_ops_pil3_peringkat4')");
        
        mysqli_query($conn, "INSERT INTO kpmr_operasional_pilar4(id_kpmr_operasional_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_pilar4_1a',
        '$kpmr_ops_pilar4_1b',
        '$kpmr_ops_pilar4_1c',
        '$kpmr_ops_pilar4_1d',
        '$kpmr_ops_pilar4_1e',
        '$kpmr_ops_pil4_total1',
        '$kpmr_ops_pil4_peringkat1',
        '$kpmr_ops_pilar4_2a',
        '$kpmr_ops_pilar4_2b',
        '$kpmr_ops_pil4_total2',
        '$kpmr_ops_pil4_peringkat2'
        )");
    
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil1(id_respon_operasional_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_respon_pil1_1a',
        '$kpmr_ops_respon_pil1_1b',
        '$kpmr_ops_respon_pil1_1c',
        '$kpmr_ops_respon_pil1_1d',
        '$kpmr_ops_respon_pil1_1e',
        '$kpmr_ops_respon_pil1_2a',
        '$kpmr_ops_respon_pil1_2b',
        '$kpmr_ops_respon_pil1_2c',
        '$kpmr_ops_respon_pil1_2d',
        '$kpmr_ops_respon_pil1_2e',
        '$kpmr_ops_respon_pil1_3a',
        '$kpmr_ops_respon_pil1_3b',
        '$kpmr_ops_respon_pil1_3c',
        '$kpmr_ops_respon_pil1_4a',
        '$kpmr_ops_respon_pil1_4b',
        '$kpmr_ops_respon_pil1_4c',
        '$kpmr_ops_respon_pil1_4d',
        '$kpmr_ops_respon_pil1_4e',
        '$kpmr_ops_respon_pil1_5a',
        '$kpmr_ops_respon_pil1_5b',
        '$kpmr_ops_respon_pil1_5c',
        '$kpmr_ops_respon_pil1_5d',
        '$kpmr_ops_respon_pil1_6a',
        '$kpmr_ops_respon_pil1_6b',
        '$kpmr_ops_respon_pil1_6c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil2(id_respon_operasional_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_respon_pil2_1a',
        '$kpmr_ops_respon_pil2_1b',
        '$kpmr_ops_respon_pil2_1c',
        '$kpmr_ops_respon_pil2_1d',
        '$kpmr_ops_respon_pil2_1e',
        '$kpmr_ops_respon_pil2_2a',
        '$kpmr_ops_respon_pil2_2b',
        '$kpmr_ops_respon_pil2_2c',
        '$kpmr_ops_respon_pil2_2d',
        '$kpmr_ops_respon_pil2_2e',
        '$kpmr_ops_respon_pil2_2f',
        '$kpmr_ops_respon_pil2_2g',
        '$kpmr_ops_respon_pil2_2h',
        '$kpmr_ops_respon_pil2_3a',
        '$kpmr_ops_respon_pil2_3b',
        '$kpmr_ops_respon_pil2_3c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil3(id_respon_operasional_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e,
        respon_pil3_3a,
        respon_pil3_3b,
        respon_pil3_3c,
        respon_pil3_4a,
        respon_pil3_4b,
        respon_pil3_4c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_respon_pil3_1a',
        '$kpmr_ops_respon_pil3_1b',
        '$kpmr_ops_respon_pil3_1c',
        '$kpmr_ops_respon_pil3_1d',
        '$kpmr_ops_respon_pil3_1e',
        '$kpmr_ops_respon_pil3_1f',
        '$kpmr_ops_respon_pil3_1g',
        '$kpmr_ops_respon_pil3_1h',
        '$kpmr_ops_respon_pil3_1i',
        '$kpmr_ops_respon_pil3_1j',
        '$kpmr_ops_respon_pil3_2a',
        '$kpmr_ops_respon_pil3_2b',
        '$kpmr_ops_respon_pil3_2c',
        '$kpmr_ops_respon_pil3_2d',
        '$kpmr_ops_respon_pil3_2e',
        '$kpmr_ops_respon_pil3_3a',
        '$kpmr_ops_respon_pil3_3b',
        '$kpmr_ops_respon_pil3_3c',
        '$kpmr_ops_respon_pil3_4a',
        '$kpmr_ops_respon_pil3_4b',
        '$kpmr_ops_respon_pil3_4c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_operasional_pil4(id_respon_operasional_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_respon_pil4_1a',
        '$kpmr_ops_respon_pil4_1b',
        '$kpmr_ops_respon_pil4_1c',
        '$kpmr_ops_respon_pil4_1d',
        '$kpmr_ops_respon_pil4_1e',
        '$kpmr_ops_respon_pil4_2a',
        '$kpmr_ops_respon_pil4_2b')");
                




        mysqli_query($conn, "INSERT INTO hasil_inheren_operasional(id_hasil_inheren_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO hasil_kpmr_operasional(id_hasil_kpmr_operasional,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_ops_pil1_maxValue',
        '$kpmr_ops_pil1_minValue',
        '$kpmr_ops_pil1_average',
        '$set_ops_pil1',
        '$kpmr_ops_pil1_tingkat_risiko',
        '$kpmr_ops_pil2_maxValue',
        '$kpmr_ops_pil2_minValue',
        '$kpmr_ops_pil2_average',
        '$set_ops_pil2',
        '$kpmr_ops_pil2_tingkat_risiko',
        '$kpmr_ops_pil3_maxValue',
        '$kpmr_ops_pil3_minValue',
        '$kpmr_ops_pil3_average',
        '$set_ops_pil3',
        '$kpmr_ops_pil3_tingkat_risiko',
        '$kpmr_ops_pil4_maxValue',
        '$kpmr_ops_pil4_minValue',
        '$kpmr_ops_pil4_average',
        '$set_ops_pil4',
        '$kpmr_ops_pil4_tingkat_risiko')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren2_operasional(id_keterangan_inheren2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_operasional(id_kpmr2_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_operasional(id_ket_profil_operasional,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        


        //kep
        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar1(id_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by,
        pilar1_1,
        pilar1_1a,
        pilar1_1b,
        pilar1_1c,
        pilar1_1d,
        pilar1_1e,
        pilar1_1f,
        pilar1_1g,
        pilar1_2,
        pilar1_2a,
        pilar1_2b,
        pilar1_2c,
        pilar1_2d,
        pilar1_2e,
        pilar1_2f,
        pilar1_2g,
        pilar1_2h,
        average_pil1_1,
        average_pil1_2,
        min_pil1_1,
        min_pil1_2,
        max_pil1_1,
        max_pil1_2,
        hasil_pil1_par1,
        hasil_pil1_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_kep_pilar1_1',
        '$inheren_kep_pilar1_1a',
        '$inheren_kep_pilar1_1b',
        '$inheren_kep_pilar1_1c',
        '$inheren_kep_pilar1_1d',
        '$inheren_kep_pilar1_1e',
        '$inheren_kep_pilar1_1f',
        '$inheren_kep_pilar1_1g',
        '$inheren_kep_pilar1_2',
        '$inheren_kep_pilar1_2a',
        '$inheren_kep_pilar1_2b',
        '$inheren_kep_pilar1_2c',
        '$inheren_kep_pilar1_2d',
        '$inheren_kep_pilar1_2e',
        '$inheren_kep_pilar1_2f',
        '$inheren_kep_pilar1_2g',
        '$inheren_kep_pilar1_2h',
        '$inheren_kep_average_pil1_1',
        '$inheren_kep_average_pil1_2',
        '$inheren_kep_min_pil1_1',
        '$inheren_kep_min_pil1_2',
        '$inheren_kep_max_pil1_1',
        '$inheren_kep_max_pil1_2',
        '$inheren_kep_hasil_pil1_par1',
        '$inheren_kep_hasil_pil1_par2')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar2(id_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by,
        pilar2_1,
        pilar2_1a,
        pilar2_2,
        pilar2_2a,
        pilar2_3,
        pilar2_3a)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_kep_pilar2_1',
        '$inheren_kep_pilar2_1a',
        '$inheren_kep_pilar2_2',
        '$inheren_kep_pilar2_2a',
        '$inheren_kep_pilar2_3',
        '$inheren_kep_pilar2_3a')");

        mysqli_query($conn, "INSERT INTO inheren_kepatuhan_lainnya(id_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by,
        pilar3_1a,
        pilar3_1b,
        pilar3_1c,
        pilar3_1d,
        pilar3_1e,
        pilar3_1f,
        pilar3_1g,
        average_pil3_1,
        min_pil3_1,
        max_pil3_1,
        hasil_pil3_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_kep_pilar3_1a',
        '$inheren_kep_pilar3_1b',
        '$inheren_kep_pilar3_1c',
        '$inheren_kep_pilar3_1d',
        '$inheren_kep_pilar3_1e',
        '$inheren_kep_pilar3_1f',
        '$inheren_kep_pilar3_1g',
        '$inheren_kep_average_pil3_1',
        '$inheren_kep_min_pil3_1',
        '$inheren_kep_max_pil3_1',
        '$inheren_kep_hasil_pil3_par1')");


        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar1(id_ket_inheren_kepatuhan_pilar1,id_profil_risiko,dibuat_by,
        ket_in_kep_pil1_1,
        ket_in_kep_pil1_1a,
        ket_in_kep_pil1_1b,
        ket_in_kep_pil1_1c,
        ket_in_kep_pil1_1d,
        ket_in_kep_pil1_1e,
        ket_in_kep_pil1_1f,
        ket_in_kep_pil1_1g,
        ket_in_kep_pil1_2,
        ket_in_kep_pil1_2a,
        ket_in_kep_pil1_2b,
        ket_in_kep_pil1_2c,
        ket_in_kep_pil1_2d,
        ket_in_kep_pil1_2e,
        ket_in_kep_pil1_2f,
        ket_in_kep_pil1_2g,
        ket_in_kep_pil1_2h)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_kep_pil1_1',
        '$ket_in_kep_pil1_1a',
        '$ket_in_kep_pil1_1b',
        '$ket_in_kep_pil1_1c',
        '$ket_in_kep_pil1_1d',
        '$ket_in_kep_pil1_1e',
        '$ket_in_kep_pil1_1f',
        '$ket_in_kep_pil1_1g',
        '$ket_in_kep_pil1_2',
        '$ket_in_kep_pil1_2a',
        '$ket_in_kep_pil1_2b',
        '$ket_in_kep_pil1_2c',
        '$ket_in_kep_pil1_2d',
        '$ket_in_kep_pil1_2e',
        '$ket_in_kep_pil1_2f',
        '$ket_in_kep_pil1_2g',
        '$ket_in_kep_pil1_2h')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_pilar2(id_ket_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by,
        ket_in_kep_pil2_1,
        ket_in_kep_pil2_1a,
        ket_in_kep_pil2_2,
        ket_in_kep_pil2_2a,
        ket_in_kep_pil2_3,
        ket_in_kep_pil2_3a)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_kep_pil2_1',
        '$ket_in_kep_pil2_1a',
        '$ket_in_kep_pil2_2',
        '$ket_in_kep_pil2_2a',
        '$ket_in_kep_pil2_3',
        '$ket_in_kep_pil2_3a')");

        mysqli_query($conn, "INSERT INTO ket_inheren_kepatuhan_lainnya(id_ket_inheren_kepatuhan_lainnya,id_profil_risiko,dibuat_by,
        ket_in_kep_pil3_1a,
        ket_in_kep_pil3_1b,
        ket_in_kep_pil3_1c,
        ket_in_kep_pil3_1d,
        ket_in_kep_pil3_1e,
        ket_in_kep_pil3_1f,
        ket_in_kep_pil3_1g)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_kep_pil3_1a',
        '$ket_in_kep_pil3_1b',
        '$ket_in_kep_pil3_1c',
        '$ket_in_kep_pil3_1d',
        '$ket_in_kep_pil3_1e',
        '$ket_in_kep_pil3_1f',
        '$ket_in_kep_pil3_1g')");


        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar1(id_kpmr_kepatuhan_pilar1,id_profil_risiko,dibuat_by,
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
        pil1_peringkat6,
        pilar1_7a,
        pilar1_7b,
        pilar1_7c,
        pil1_total7,
        pil1_peringkat7)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_pilar1_1a',
        '$kpmr_kep_pilar1_1b',
        '$kpmr_kep_pilar1_1c',
        '$kpmr_kep_pilar1_1d',
        '$kpmr_kep_pilar1_1e',
        '$kpmr_kep_pil1_total1',
        '$kpmr_kep_pil1_peringkat1',
        '$kpmr_kep_pilar1_2a',
        '$kpmr_kep_pilar1_2b',
        '$kpmr_kep_pilar1_2c',
        '$kpmr_kep_pilar1_2d',
        '$kpmr_kep_pilar1_2e',
        '$kpmr_kep_pil1_total2',
        '$kpmr_kep_pil1_peringkat2',
        '$kpmr_kep_pilar1_3a',
        '$kpmr_kep_pilar1_3b',
        '$kpmr_kep_pilar1_3c',
        '$kpmr_kep_pil1_total3',
        '$kpmr_kep_pil1_peringkat3',
        '$kpmr_kep_pilar1_4a',
        '$kpmr_kep_pilar1_4b',
        '$kpmr_kep_pilar1_4c',
        '$kpmr_kep_pilar1_4d',
        '$kpmr_kep_pilar1_4e',
        '$kpmr_kep_pil1_total4',
        '$kpmr_kep_pil1_peringkat4',
        '$kpmr_kep_pilar1_5a',
        '$kpmr_kep_pilar1_5b',
        '$kpmr_kep_pilar1_5c',
        '$kpmr_kep_pilar1_5d',
        '$kpmr_kep_pil1_total5',
        '$kpmr_kep_pil1_peringkat5',
        '$kpmr_kep_pilar1_6a',
        '$kpmr_kep_pilar1_6b',
        '$kpmr_kep_pilar1_6c',
        '$kpmr_kep_pil1_total6',
        '$kpmr_kep_pil1_peringkat6',
        '$kpmr_kep_pilar1_7a',
        '$kpmr_kep_pilar1_7b',
        '$kpmr_kep_pilar1_7c',
        '$kpmr_kep_pil1_total7',
        '$kpmr_kep_pil1_peringkat7')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar2(id_kpmr_kepatuhan_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_pilar2_1a',
        '$kpmr_kep_pilar2_1b',
        '$kpmr_kep_pilar2_1c',
        '$kpmr_kep_pilar2_1d',
        '$kpmr_kep_pilar2_1e',
        '$kpmr_kep_pil2_total1',
        '$kpmr_kep_pil2_peringkat1',
        '$kpmr_kep_pilar2_2a',
        '$kpmr_kep_pilar2_2b',
        '$kpmr_kep_pilar2_2c',
        '$kpmr_kep_pilar2_2d',
        '$kpmr_kep_pilar2_2e',
        '$kpmr_kep_pilar2_2f',
        '$kpmr_kep_pilar2_2g',
        '$kpmr_kep_pilar2_2h',
        '$kpmr_kep_pil2_total2',
        '$kpmr_kep_pil2_peringkat2',
        '$kpmr_kep_pilar2_3a',
        '$kpmr_kep_pilar2_3b',
        '$kpmr_kep_pilar2_3c',
        '$kpmr_kep_pil2_total3',
        '$kpmr_kep_pil2_peringkat3')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar3(id_kpmr_kepatuhan_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_pilar3_1a',
        '$kpmr_kep_pilar3_1b',
        '$kpmr_kep_pilar3_1c',
        '$kpmr_kep_pilar3_1d',
        '$kpmr_kep_pilar3_1e',
        '$kpmr_kep_pilar3_1f',
        '$kpmr_kep_pilar3_1g',
        '$kpmr_kep_pilar3_1h',
        '$kpmr_kep_pilar3_1i',
        '$kpmr_kep_pilar3_1j',
        '$kpmr_kep_pil3_total1',
        '$kpmr_kep_pil3_peringkat1',
        '$kpmr_kep_pilar3_2a',
        '$kpmr_kep_pilar3_2b',
        '$kpmr_kep_pilar3_2c',
        '$kpmr_kep_pilar3_2d',
        '$kpmr_kep_pilar3_2e',
        '$kpmr_kep_pil3_total2',
        '$kpmr_kep_pil3_peringkat2')");
        
        mysqli_query($conn, "INSERT INTO kpmr_kepatuhan_pilar4(id_kpmr_kepatuhan_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_pilar4_1a',
        '$kpmr_kep_pilar4_1b',
        '$kpmr_kep_pilar4_1c',
        '$kpmr_kep_pilar4_1d',
        '$kpmr_kep_pilar4_1e',
        '$kpmr_kep_pil4_total1',
        '$kpmr_kep_pil4_peringkat1',
        '$kpmr_kep_pilar4_2a',
        '$kpmr_kep_pilar4_2b',
        '$kpmr_kep_pil4_total2',
        '$kpmr_kep_pil4_peringkat2')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil1(id_respon_kepatuhan_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c,
        respon_pil1_7a,
        respon_pil1_7b,
        respon_pil1_7c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_respon_pil1_1a',
        '$kpmr_kep_respon_pil1_1b',
        '$kpmr_kep_respon_pil1_1c',
        '$kpmr_kep_respon_pil1_1d',
        '$kpmr_kep_respon_pil1_1e',
        '$kpmr_kep_respon_pil1_2a',
        '$kpmr_kep_respon_pil1_2b',
        '$kpmr_kep_respon_pil1_2c',
        '$kpmr_kep_respon_pil1_2d',
        '$kpmr_kep_respon_pil1_2e',
        '$kpmr_kep_respon_pil1_3a',
        '$kpmr_kep_respon_pil1_3b',
        '$kpmr_kep_respon_pil1_3c',
        '$kpmr_kep_respon_pil1_4a',
        '$kpmr_kep_respon_pil1_4b',
        '$kpmr_kep_respon_pil1_4c',
        '$kpmr_kep_respon_pil1_4d',
        '$kpmr_kep_respon_pil1_4e',
        '$kpmr_kep_respon_pil1_5a',
        '$kpmr_kep_respon_pil1_5b',
        '$kpmr_kep_respon_pil1_5c',
        '$kpmr_kep_respon_pil1_5d',
        '$kpmr_kep_respon_pil1_6a',
        '$kpmr_kep_respon_pil1_6b',
        '$kpmr_kep_respon_pil1_6c',
        '$kpmr_kep_respon_pil1_7a',
        '$kpmr_kep_respon_pil1_7b',
        '$kpmr_kep_respon_pil1_7c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil2(id_respon_kepatuhan_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_respon_pil2_1a',
        '$kpmr_kep_respon_pil2_1b',
        '$kpmr_kep_respon_pil2_1c',
        '$kpmr_kep_respon_pil2_1d',
        '$kpmr_kep_respon_pil2_1e',
        '$kpmr_kep_respon_pil2_2a',
        '$kpmr_kep_respon_pil2_2b',
        '$kpmr_kep_respon_pil2_2c',
        '$kpmr_kep_respon_pil2_2d',
        '$kpmr_kep_respon_pil2_2e',
        '$kpmr_kep_respon_pil2_2f',
        '$kpmr_kep_respon_pil2_2g',
        '$kpmr_kep_respon_pil2_2h',
        '$kpmr_kep_respon_pil2_3a',
        '$kpmr_kep_respon_pil2_3b',
        '$kpmr_kep_respon_pil2_3c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil3(id_respon_kepatuhan_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_respon_pil3_1a',
        '$kpmr_kep_respon_pil3_1b',
        '$kpmr_kep_respon_pil3_1c',
        '$kpmr_kep_respon_pil3_1d',
        '$kpmr_kep_respon_pil3_1e',
        '$kpmr_kep_respon_pil3_1f',
        '$kpmr_kep_respon_pil3_1g',
        '$kpmr_kep_respon_pil3_1h',
        '$kpmr_kep_respon_pil3_1i',
        '$kpmr_kep_respon_pil3_1j',
        '$kpmr_kep_respon_pil3_2a',
        '$kpmr_kep_respon_pil3_2b',
        '$kpmr_kep_respon_pil3_2c',
        '$kpmr_kep_respon_pil3_2d',
        '$kpmr_kep_respon_pil3_2e')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_kepatuhan_pil4(id_respon_kepatuhan_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_respon_pil4_1a',
        '$kpmr_kep_respon_pil4_1b',
        '$kpmr_kep_respon_pil4_1c',
        '$kpmr_kep_respon_pil4_1d',
        '$kpmr_kep_respon_pil4_1e',
        '$kpmr_kep_respon_pil4_2a',
        '$kpmr_kep_respon_pil4_2b')");
        


        mysqli_query($conn, "INSERT INTO hasil_inheren_kepatuhan(id_hasil_inheren_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_kepatuhan(id_hasil_kpmr_kepatuhan,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_kep_pil1_maxValue',
        '$kpmr_kep_pil1_minValue',
        '$kpmr_kep_pil1_average',
        '$set_kep_pil1',
        '$kpmr_kep_pil1_tingkat_risiko',
        '$kpmr_kep_pil2_maxValue',
        '$kpmr_kep_pil2_minValue',
        '$kpmr_kep_pil2_average',
        '$set_kep_pil2',
        '$kpmr_kep_pil2_tingkat_risiko',
        '$kpmr_kep_pil3_maxValue',
        '$kpmr_kep_pil3_minValue',
        '$kpmr_kep_pil3_average',
        '$set_kep_pil3',
        '$kpmr_kep_pil3_tingkat_risiko',
        '$kpmr_kep_pil4_maxValue',
        '$kpmr_kep_pil4_minValue',
        '$kpmr_kep_pil4_average',
        '$set_kep_pil4',
        '$kpmr_kep_pil4_tingkat_risiko')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_kepatuhan(id_keterangan_inheren2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_kepatuhan(id_kpmr2_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_kepatuhan(id_ket_profil_kepatuhan,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");


        //lik
        mysqli_query($conn, "
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
                WHERE kantor_cabang = '$lokasi_kerja' 
                AND tahun = '$tahun' 
                AND user = '$user' 
                AND periode = '$periode'),
            '$dibuat_by',
            '$aset_likuid', '$kas', '$giro_aba', '$tabungan_aba', '$total_aset',
            '$kewajiban_lancar', '$kewajiban_segera', '$tabungan', '$deposito', '$pendanaan_jangka_pendek',
            '$kewajiban_jangka_pendek', '$deposito_1bln', '$deposito_3bln', '$deposito_6bln', '$deposito_12bln',
            '$pendanaan_non_inti', '$dpk_lbh_2m', '$deposito_diatas_cr', '$deposito_diatas_lps', '$korporasi',
            '$dpk_des_thn_sebelum', '$alat_likuid', '$penempatan_pd_bank_lain', '$modal_disetor',
            '$kredit_des_thn_sebelum', '$pinjaman', '$kredit_kolek_lancar', '$pertumbuhan_kredit',
            '$dpk_dijamin_lps', '$simpanan_tdk_dijamin_lps', '$total_dpk', '$dpk_tdk_dijamin_lps',
            '$deposan_tabungan_terbesar25', '$besar_deposan25', '$besar_penabung25', '$deposito_rs',
            '$arus_kas_netto', '$kas_besar_debet', '$kas_besar_kredit', '$deposito_inti',
            '$sisa_jangka_waktu_deposito', '$kredit_l_dp'
        )
    ");
    
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar1(id_inheren_likuiditas_pilar1,id_profil_risiko,dibuat_by,
        pilar1_4)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$lik_pilar1_4')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_pilar2(id_inheren_likuiditas_pilar2,id_profil_risiko,dibuat_by,
        hasil_pil2_par1,
        pil2_par1a,
        hasil_pil2_par1a,
        pil2_par1b,
        hasil_pil2_par1b,
        pil2_par1c,
        hasil_pil2_par1c,
        pil2_par2,
        hasil_pil2_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$lik_hasil_pil2_par1',
        '$lik_pil2_par1a',
        '$lik_hasil_pil2_par1a',
        '$lik_pil2_par1b',
        '$lik_hasil_pil2_par1b',
        '$lik_pil2_par1c',
        '$lik_hasil_pil2_par1c',
        '$lik_pil2_par2',
        '$lik_hasil_pil2_par2')");
        
        mysqli_query($conn, "INSERT INTO inheren_likuiditas_lainnya(id_inheren_likuiditas_lainnya,id_profil_risiko,dibuat_by,
        hasil_pil3_par1,
        pil3_par1a,
        hasil_pil3_par1a,
        pil3_par1b,
        hasil_pil3_par1b,
        pil3_par1c,
        hasil_pil3_par1c,
        pil3_par1d,
        hasil_pil3_par1d,
        pil3_par1e,
        hasil_pil3_par1e,
        pil3_par1f,
        hasil_pil3_par1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$lik_hasil_pil3_par1',
        '$lik_pil3_par1a',
        '$lik_hasil_pil3_par1a',
        '$lik_pil3_par1b',
        '$lik_hasil_pil3_par1b',
        '$lik_pil3_par1c',
        '$lik_hasil_pil3_par1c',
        '$lik_pil3_par1d',
        '$lik_hasil_pil3_par1d',
        '$lik_pil3_par1e',
        '$lik_hasil_pil3_par1e',
        '$lik_pil3_par1f',
        '$lik_hasil_pil3_par1f')");
        
        mysqli_query($conn, "INSERT INTO hasil_inheren_likuiditas(id_hasil_inheren_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");
        
        mysqli_query($conn, "INSERT INTO keterangan_inheren_likuiditas(id_keterangan_inheren_likuiditas,id_profil_risiko,dibuat_by,
        ket_pil1_1,
        ket_pil1_2,
        ket_pil1_3,
        ket_pil1_4,
        ket_pil1_5,
        ket_pil1,
        ket_pil2_1,
        ket_pil2_2,
        ket_pil2,
        ket_pil3_1,
        ket_pil3)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$lik_ket_pil1_1',
        '$lik_ket_pil1_2',
        '$lik_ket_pil1_3',
        '$lik_ket_pil1_4',
        '$lik_ket_pil1_5',
        '$lik_ket_pil1',
        '$lik_ket_pil2_1',
        '$lik_ket_pil2_2',
        '$lik_ket_pil2',
        '$lik_ket_pil3_1',
        '$lik_ket_pil3')");
        


       
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar1(id_kpmr_likuiditas_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_pilar1_1a',
        '$kpmr_lik_pilar1_1b',
        '$kpmr_lik_pilar1_1c',
        '$kpmr_lik_pilar1_1d',
        '$kpmr_lik_pilar1_1e',
        '$kpmr_lik_pil1_total1',
        '$kpmr_lik_pil1_peringkat1',
        '$kpmr_lik_pilar1_2a',
        '$kpmr_lik_pilar1_2b',
        '$kpmr_lik_pilar1_2c',
        '$kpmr_lik_pilar1_2d',
        '$kpmr_lik_pilar1_2e',
        '$kpmr_lik_pil1_total2',
        '$kpmr_lik_pil1_peringkat2',
        '$kpmr_lik_pilar1_3a',
        '$kpmr_lik_pilar1_3b',
        '$kpmr_lik_pilar1_3c',
        '$kpmr_lik_pil1_total3',
        '$kpmr_lik_pil1_peringkat3',
        '$kpmr_lik_pilar1_4a',
        '$kpmr_lik_pilar1_4b',
        '$kpmr_lik_pilar1_4c',
        '$kpmr_lik_pilar1_4d',
        '$kpmr_lik_pilar1_4e',
        '$kpmr_lik_pil1_total4',
        '$kpmr_lik_pil1_peringkat4',
        '$kpmr_lik_pilar1_5a',
        '$kpmr_lik_pilar1_5b',
        '$kpmr_lik_pilar1_5c',
        '$kpmr_lik_pilar1_5d',
        '$kpmr_lik_pil1_total5',
        '$kpmr_lik_pil1_peringkat5',
        '$kpmr_lik_pilar1_6a',
        '$kpmr_lik_pilar1_6b',
        '$kpmr_lik_pilar1_6c',
        '$kpmr_lik_pil1_total6',
        '$kpmr_lik_pil1_peringkat6')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar2(id_kpmr_likuiditas_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_pilar2_1a',
        '$kpmr_lik_pilar2_1b',
        '$kpmr_lik_pilar2_1c',
        '$kpmr_lik_pilar2_1d',
        '$kpmr_lik_pilar2_1e',
        '$kpmr_lik_pil2_total1',
        '$kpmr_lik_pil2_peringkat1',
        '$kpmr_lik_pilar2_2a',
        '$kpmr_lik_pilar2_2b',
        '$kpmr_lik_pilar2_2c',
        '$kpmr_lik_pilar2_2d',
        '$kpmr_lik_pilar2_2e',
        '$kpmr_lik_pilar2_2f',
        '$kpmr_lik_pilar2_2g',
        '$kpmr_lik_pilar2_2h',
        '$kpmr_lik_pil2_total2',
        '$kpmr_lik_pil2_peringkat2',
        '$kpmr_lik_pilar2_3a',
        '$kpmr_lik_pilar2_3b',
        '$kpmr_lik_pilar2_3c',
        '$kpmr_lik_pil2_total3',
        '$kpmr_lik_pil2_peringkat3')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar3(id_kpmr_likuiditas_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_pilar3_1a',
        '$kpmr_lik_pilar3_1b',
        '$kpmr_lik_pilar3_1c',
        '$kpmr_lik_pilar3_1d',
        '$kpmr_lik_pilar3_1e',
        '$kpmr_lik_pilar3_1f',
        '$kpmr_lik_pilar3_1g',
        '$kpmr_lik_pilar3_1h',
        '$kpmr_lik_pilar3_1i',
        '$kpmr_lik_pilar3_1j',
        '$kpmr_lik_pil3_total1',
        '$kpmr_lik_pil3_peringkat1',
        '$kpmr_lik_pilar3_2a',
        '$kpmr_lik_pilar3_2b',
        '$kpmr_lik_pilar3_2c',
        '$kpmr_lik_pilar3_2d',
        '$kpmr_lik_pilar3_2e',
        '$kpmr_lik_pil3_total2',
        '$kpmr_lik_pil3_peringkat2')");
        
        mysqli_query($conn, "INSERT INTO kpmr_likuiditas_pilar4(id_kpmr_likuiditas_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_pilar4_1a',
        '$kpmr_lik_pilar4_1b',
        '$kpmr_lik_pilar4_1c',
        '$kpmr_lik_pilar4_1d',
        '$kpmr_lik_pilar4_1e',
        '$kpmr_lik_pil4_total1',
        '$kpmr_lik_pil4_peringkat1',
        '$kpmr_lik_pilar4_2a',
        '$kpmr_lik_pilar4_2b',
        '$kpmr_lik_pil4_total2',
        '$kpmr_lik_pil4_peringkat2')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil1(id_respon_likuiditas_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_respon_pil1_1a',
        '$kpmr_lik_respon_pil1_1b',
        '$kpmr_lik_respon_pil1_1c',
        '$kpmr_lik_respon_pil1_1d',
        '$kpmr_lik_respon_pil1_1e',
        '$kpmr_lik_respon_pil1_2a',
        '$kpmr_lik_respon_pil1_2b',
        '$kpmr_lik_respon_pil1_2c',
        '$kpmr_lik_respon_pil1_2d',
        '$kpmr_lik_respon_pil1_2e',
        '$kpmr_lik_respon_pil1_3a',
        '$kpmr_lik_respon_pil1_3b',
        '$kpmr_lik_respon_pil1_3c',
        '$kpmr_lik_respon_pil1_4a',
        '$kpmr_lik_respon_pil1_4b',
        '$kpmr_lik_respon_pil1_4c',
        '$kpmr_lik_respon_pil1_4d',
        '$kpmr_lik_respon_pil1_4e',
        '$kpmr_lik_respon_pil1_5a',
        '$kpmr_lik_respon_pil1_5b',
        '$kpmr_lik_respon_pil1_5c',
        '$kpmr_lik_respon_pil1_5d',
        '$kpmr_lik_respon_pil1_6a',
        '$kpmr_lik_respon_pil1_6b',
        '$kpmr_lik_respon_pil1_6c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil2(id_respon_likuiditas_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_respon_pil2_1a',
        '$kpmr_lik_respon_pil2_1b',
        '$kpmr_lik_respon_pil2_1c',
        '$kpmr_lik_respon_pil2_1d',
        '$kpmr_lik_respon_pil2_1e',
        '$kpmr_lik_respon_pil2_2a',
        '$kpmr_lik_respon_pil2_2b',
        '$kpmr_lik_respon_pil2_2c',
        '$kpmr_lik_respon_pil2_2d',
        '$kpmr_lik_respon_pil2_2e',
        '$kpmr_lik_respon_pil2_2f',
        '$kpmr_lik_respon_pil2_2g',
        '$kpmr_lik_respon_pil2_2h',
        '$kpmr_lik_respon_pil2_3a',
        '$kpmr_lik_respon_pil2_3b',
        '$kpmr_lik_respon_pil2_3c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil3(id_respon_likuiditas_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_respon_pil3_1a',
        '$kpmr_lik_respon_pil3_1b',
        '$kpmr_lik_respon_pil3_1c',
        '$kpmr_lik_respon_pil3_1d',
        '$kpmr_lik_respon_pil3_1e',
        '$kpmr_lik_respon_pil3_1f',
        '$kpmr_lik_respon_pil3_1g',
        '$kpmr_lik_respon_pil3_1h',
        '$kpmr_lik_respon_pil3_1i',
        '$kpmr_lik_respon_pil3_1j',
        '$kpmr_lik_respon_pil3_2a',
        '$kpmr_lik_respon_pil3_2b',
        '$kpmr_lik_respon_pil3_2c',
        '$kpmr_lik_respon_pil3_2d',
        '$kpmr_lik_respon_pil3_2e')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_likuiditas_pil4(id_respon_likuiditas_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_respon_pil4_1a',
        '$kpmr_lik_respon_pil4_1b',
        '$kpmr_lik_respon_pil4_1c',
        '$kpmr_lik_respon_pil4_1d',
        '$kpmr_lik_respon_pil4_1e',
        '$kpmr_lik_respon_pil4_2a',
        '$kpmr_lik_respon_pil4_2b')");




       
        mysqli_query($conn, "INSERT INTO hasil_kpmr_likuiditas(id_hasil_kpmr_likuiditas,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_lik_pil1_maxValue',
        '$kpmr_lik_pil1_minValue',
        '$kpmr_lik_pil1_average',
        '$set_lik_pil1',
        '$kpmr_lik_pil1_tingkat_risiko',
        '$kpmr_lik_pil2_maxValue',
        '$kpmr_lik_pil2_minValue',
        '$kpmr_lik_pil2_average',
        '$set_lik_pil2',
        '$kpmr_lik_pil2_tingkat_risiko',
        '$kpmr_lik_pil3_maxValue',
        '$kpmr_lik_pil3_minValue',
        '$kpmr_lik_pil3_average',
        '$set_lik_pil3',
        '$kpmr_lik_pil3_tingkat_risiko',
        '$kpmr_lik_pil4_maxValue',
        '$kpmr_lik_pil4_minValue',
        '$kpmr_lik_pil4_average',
        '$set_lik_pil4',
        '$kpmr_lik_pil4_tingkat_risiko')");

      
        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_likuiditas(id_kpmr2_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_likuiditas(id_ket_profil_likuiditas,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");





        //rep
        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar1(id_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by,
        pilar1_1,
        pilar1_1a,
        pilar1_1b,
        pilar1_1c,
        pilar1_1d,
        pilar1_2,
        pilar1_2a,
        pilar1_2b,
        pilar1_2c,
        pilar1_2d,
        average_pil1_1,
        average_pil1_2,
        min_pil1_1,
        min_pil1_2,
        max_pil1_1,
        max_pil1_2,
        hasil_pil1_par1,
        hasil_pil1_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_rep_pilar1_1',
        '$inheren_rep_pilar1_1a',
        '$inheren_rep_pilar1_1b',
        '$inheren_rep_pilar1_1c',
        '$inheren_rep_pilar1_1d',
        '$inheren_rep_pilar1_2',
        '$inheren_rep_pilar1_2a',
        '$inheren_rep_pilar1_2b',
        '$inheren_rep_pilar1_2c',
        '$inheren_rep_pilar1_2d',
        '$inheren_rep_average_pil1_1',
        '$inheren_rep_average_pil1_2',
        '$inheren_rep_min_pil1_1',
        '$inheren_rep_min_pil1_2',
        '$inheren_rep_max_pil1_1',
        '$inheren_rep_max_pil1_2',
        '$inheren_rep_hasil_pil1_par1',
        '$inheren_rep_hasil_pil1_par2')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar2(id_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by,
        pilar2_1,
        pilar2_1a,
        pilar2_1b,
        pilar2_1c,
        pilar2_1d,
        pilar2_2,
        pilar2_2a,
        pilar2_2b,
        average_pil2_1,
        average_pil2_2,
        min_pil2_1,
        min_pil2_2,
        max_pil2_1,
        max_pil2_2,
        hasil_pil2_par1,
        hasil_pil2_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_rep_pilar2_1',
        '$inheren_rep_pilar2_1a',
        '$inheren_rep_pilar2_1b',
        '$inheren_rep_pilar2_1c',
        '$inheren_rep_pilar2_1d',
        '$inheren_rep_pilar2_2',
        '$inheren_rep_pilar2_2a',
        '$inheren_rep_pilar2_2b',
        '$inheren_rep_average_pil2_1',
        '$inheren_rep_average_pil2_2',
        '$inheren_rep_min_pil2_1',
        '$inheren_rep_min_pil2_2',
        '$inheren_rep_max_pil2_1',
        '$inheren_rep_max_pil2_2',
        '$inheren_rep_hasil_pil2_par1',
        '$inheren_rep_hasil_pil2_par2')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_pilar3(id_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by,
        pilar3_1,
        pilar3_1a,
        pilar3_1b,
        pilar3_1c,
        pilar3_2,
        pilar3_2a,
        pilar3_2b,
        average_pil3_1,
        average_pil3_2,
        min_pil3_1,
        min_pil3_2,
        max_pil3_1,
        max_pil3_2,
        hasil_pil3_par1,
        hasil_pil3_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_rep_pilar3_1',
        '$inheren_rep_pilar3_1a',
        '$inheren_rep_pilar3_1b',
        '$inheren_rep_pilar3_1c',
        '$inheren_rep_pilar3_2',
        '$inheren_rep_pilar3_2a',
        '$inheren_rep_pilar3_2b',
        '$inheren_rep_average_pil3_1',
        '$inheren_rep_average_pil3_2',
        '$inheren_rep_min_pil3_1',
        '$inheren_rep_min_pil3_2',
        '$inheren_rep_max_pil3_1',
        '$inheren_rep_max_pil3_2',
        '$inheren_rep_hasil_pil3_par1',
        '$inheren_rep_hasil_pil3_par2')");

        mysqli_query($conn, "INSERT INTO inheren_reputasi_lainnya(id_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        average_pil4_1,
        min_pil4_1,
        max_pil4_1,
        hasil_pil4_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_rep_pilar4_1a',
        '$inheren_rep_pilar4_1b',
        '$inheren_rep_pilar4_1c',
        '$inheren_rep_average_pil4_1',
        '$inheren_rep_min_pil4_1',
        '$inheren_rep_max_pil4_1',
        '$inheren_rep_hasil_pil4_par1')");


        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar1(id_ket_inheren_reputasi_pilar1,id_profil_risiko,dibuat_by,
        ket_in_rep_pil1_1,
        ket_in_rep_pil1_1a,
        ket_in_rep_pil1_1b,
        ket_in_rep_pil1_1c,
        ket_in_rep_pil1_1d,
        ket_in_rep_pil1_2,
        ket_in_rep_pil1_2a,
        ket_in_rep_pil1_2b,
        ket_in_rep_pil1_2c,
        ket_in_rep_pil1_2d)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_rep_pil1_1',
        '$ket_in_rep_pil1_1a',
        '$ket_in_rep_pil1_1b',
        '$ket_in_rep_pil1_1c',
        '$ket_in_rep_pil1_1d',
        '$ket_in_rep_pil1_2',
        '$ket_in_rep_pil1_2a',
        '$ket_in_rep_pil1_2b',
        '$ket_in_rep_pil1_2c',
        '$ket_in_rep_pil1_2d')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar2(id_ket_inheren_reputasi_pilar2,id_profil_risiko,dibuat_by,
        ket_in_rep_pil2_1,
        ket_in_rep_pil2_1a,
        ket_in_rep_pil2_1b,
        ket_in_rep_pil2_1c,
        ket_in_rep_pil2_1d,
        ket_in_rep_pil2_2,
        ket_in_rep_pil2_2a,
        ket_in_rep_pil2_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_rep_pil2_1',
        '$ket_in_rep_pil2_1a',
        '$ket_in_rep_pil2_1b',
        '$ket_in_rep_pil2_1c',
        '$ket_in_rep_pil2_1d',
        '$ket_in_rep_pil2_2',
        '$ket_in_rep_pil2_2a',
        '$ket_in_rep_pil2_2b')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_pilar3(id_ket_inheren_reputasi_pilar3,id_profil_risiko,dibuat_by,
        ket_in_rep_pil3_1,
        ket_in_rep_pil3_1a,
        ket_in_rep_pil3_1b,
        ket_in_rep_pil3_1c,
        ket_in_rep_pil3_2,
        ket_in_rep_pil3_2a,
        ket_in_rep_pil3_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_rep_pil3_1',
        '$ket_in_rep_pil3_1a',
        '$ket_in_rep_pil3_1b',
        '$ket_in_rep_pil3_1c',
        '$ket_in_rep_pil3_2',
        '$ket_in_rep_pil3_2a',
        '$ket_in_rep_pil3_2b')");

        mysqli_query($conn, "INSERT INTO ket_inheren_reputasi_lainnya(id_ket_inheren_reputasi_lainnya,id_profil_risiko,dibuat_by,
        ket_in_rep_pil4_1a,
        ket_in_rep_pil4_1b,
        ket_in_rep_pil4_1c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_rep_pil4_1a',
        '$ket_in_rep_pil4_1b',
        '$ket_in_rep_pil4_1c')");



        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar1(id_kpmr_reputasi_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_pilar1_1a',
        '$kpmr_rep_pilar1_1b',
        '$kpmr_rep_pilar1_1c',
        '$kpmr_rep_pilar1_1d',
        '$kpmr_rep_pilar1_1e',
        '$kpmr_rep_pil1_total1',
        '$kpmr_rep_pil1_peringkat1',
        '$kpmr_rep_pilar1_2a',
        '$kpmr_rep_pilar1_2b',
        '$kpmr_rep_pilar1_2c',
        '$kpmr_rep_pilar1_2d',
        '$kpmr_rep_pilar1_2e',
        '$kpmr_rep_pil1_total2',
        '$kpmr_rep_pil1_peringkat2',
        '$kpmr_rep_pilar1_3a',
        '$kpmr_rep_pilar1_3b',
        '$kpmr_rep_pilar1_3c',
        '$kpmr_rep_pil1_total3',
        '$kpmr_rep_pil1_peringkat3',
        '$kpmr_rep_pilar1_4a',
        '$kpmr_rep_pilar1_4b',
        '$kpmr_rep_pilar1_4c',
        '$kpmr_rep_pilar1_4d',
        '$kpmr_rep_pilar1_4e',
        '$kpmr_rep_pil1_total4',
        '$kpmr_rep_pil1_peringkat4',
        '$kpmr_rep_pilar1_5a',
        '$kpmr_rep_pilar1_5b',
        '$kpmr_rep_pilar1_5c',
        '$kpmr_rep_pilar1_5d',
        '$kpmr_rep_pil1_total5',
        '$kpmr_rep_pil1_peringkat5',
        '$kpmr_rep_pilar1_6a',
        '$kpmr_rep_pilar1_6b',
        '$kpmr_rep_pilar1_6c',
        '$kpmr_rep_pil1_total6',
        '$kpmr_rep_pil1_peringkat6')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar2(id_kpmr_reputasi_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_pilar2_1a',
        '$kpmr_rep_pilar2_1b',
        '$kpmr_rep_pilar2_1c',
        '$kpmr_rep_pilar2_1d',
        '$kpmr_rep_pilar2_1e',
        '$kpmr_rep_pil2_total1',
        '$kpmr_rep_pil2_peringkat1',
        '$kpmr_rep_pilar2_2a',
        '$kpmr_rep_pilar2_2b',
        '$kpmr_rep_pilar2_2c',
        '$kpmr_rep_pilar2_2d',
        '$kpmr_rep_pilar2_2e',
        '$kpmr_rep_pilar2_2f',
        '$kpmr_rep_pilar2_2g',
        '$kpmr_rep_pilar2_2h',
        '$kpmr_rep_pil2_total2',
        '$kpmr_rep_pil2_peringkat2',
        '$kpmr_rep_pilar2_3a',
        '$kpmr_rep_pilar2_3b',
        '$kpmr_rep_pilar2_3c',
        '$kpmr_rep_pil2_total3',
        '$kpmr_rep_pil2_peringkat3')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar3(id_kpmr_reputasi_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_pilar3_1a',
        '$kpmr_rep_pilar3_1b',
        '$kpmr_rep_pilar3_1c',
        '$kpmr_rep_pilar3_1d',
        '$kpmr_rep_pilar3_1e',
        '$kpmr_rep_pilar3_1f',
        '$kpmr_rep_pilar3_1g',
        '$kpmr_rep_pilar3_1h',
        '$kpmr_rep_pilar3_1i',
        '$kpmr_rep_pilar3_1j',
        '$kpmr_rep_pil3_total1',
        '$kpmr_rep_pil3_peringkat1',
        '$kpmr_rep_pilar3_2a',
        '$kpmr_rep_pilar3_2b',
        '$kpmr_rep_pilar3_2c',
        '$kpmr_rep_pilar3_2d',
        '$kpmr_rep_pilar3_2e',
        '$kpmr_rep_pil3_total2',
        '$kpmr_rep_pil3_peringkat2')");
        
        mysqli_query($conn, "INSERT INTO kpmr_reputasi_pilar4(id_kpmr_reputasi_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_pilar4_1a',
        '$kpmr_rep_pilar4_1b',
        '$kpmr_rep_pilar4_1c',
        '$kpmr_rep_pilar4_1d',
        '$kpmr_rep_pilar4_1e',
        '$kpmr_rep_pil4_total1',
        '$kpmr_rep_pil4_peringkat1',
        '$kpmr_rep_pilar4_2a',
        '$kpmr_rep_pilar4_2b',
        '$kpmr_rep_pil4_total2',
        '$kpmr_rep_pil4_peringkat2')");
    

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil1(id_respon_reputasi_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_respon_pil1_1a',
        '$kpmr_rep_respon_pil1_1b',
        '$kpmr_rep_respon_pil1_1c',
        '$kpmr_rep_respon_pil1_1d',
        '$kpmr_rep_respon_pil1_1e',
        '$kpmr_rep_respon_pil1_2a',
        '$kpmr_rep_respon_pil1_2b',
        '$kpmr_rep_respon_pil1_2c',
        '$kpmr_rep_respon_pil1_2d',
        '$kpmr_rep_respon_pil1_2e',
        '$kpmr_rep_respon_pil1_3a',
        '$kpmr_rep_respon_pil1_3b',
        '$kpmr_rep_respon_pil1_3c',
        '$kpmr_rep_respon_pil1_4a',
        '$kpmr_rep_respon_pil1_4b',
        '$kpmr_rep_respon_pil1_4c',
        '$kpmr_rep_respon_pil1_4d',
        '$kpmr_rep_respon_pil1_4e',
        '$kpmr_rep_respon_pil1_5a',
        '$kpmr_rep_respon_pil1_5b',
        '$kpmr_rep_respon_pil1_5c',
        '$kpmr_rep_respon_pil1_5d',
        '$kpmr_rep_respon_pil1_6a',
        '$kpmr_rep_respon_pil1_6b',
        '$kpmr_rep_respon_pil1_6c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil2(id_respon_reputasi_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_respon_pil2_1a',
        '$kpmr_rep_respon_pil2_1b',
        '$kpmr_rep_respon_pil2_1c',
        '$kpmr_rep_respon_pil2_1d',
        '$kpmr_rep_respon_pil2_1e',
        '$kpmr_rep_respon_pil2_2a',
        '$kpmr_rep_respon_pil2_2b',
        '$kpmr_rep_respon_pil2_2c',
        '$kpmr_rep_respon_pil2_2d',
        '$kpmr_rep_respon_pil2_2e',
        '$kpmr_rep_respon_pil2_2f',
        '$kpmr_rep_respon_pil2_2g',
        '$kpmr_rep_respon_pil2_2h',
        '$kpmr_rep_respon_pil2_3a',
        '$kpmr_rep_respon_pil2_3b',
        '$kpmr_rep_respon_pil2_3c')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil3(id_respon_reputasi_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_respon_pil3_1a',
        '$kpmr_rep_respon_pil3_1b',
        '$kpmr_rep_respon_pil3_1c',
        '$kpmr_rep_respon_pil3_1d',
        '$kpmr_rep_respon_pil3_1e',
        '$kpmr_rep_respon_pil3_1f',
        '$kpmr_rep_respon_pil3_1g',
        '$kpmr_rep_respon_pil3_1h',
        '$kpmr_rep_respon_pil3_1i',
        '$kpmr_rep_respon_pil3_1j',
        '$kpmr_rep_respon_pil3_2a',
        '$kpmr_rep_respon_pil3_2b',
        '$kpmr_rep_respon_pil3_2c',
        '$kpmr_rep_respon_pil3_2d',
        '$kpmr_rep_respon_pil3_2e')");
        
        mysqli_query($conn, "INSERT INTO respon_unit_kerja_reputasi_pil4(id_respon_reputasi_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_respon_pil4_1a',
        '$kpmr_rep_respon_pil4_1b',
        '$kpmr_rep_respon_pil4_1c',
        '$kpmr_rep_respon_pil4_1d',
        '$kpmr_rep_respon_pil4_1e',
        '$kpmr_rep_respon_pil4_2a',
        '$kpmr_rep_respon_pil4_2b')");
        



        mysqli_query($conn, "INSERT INTO hasil_inheren_reputasi(id_hasil_inheren_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_reputasi(id_hasil_kpmr_reputasi,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_rep_pil1_maxValue',
        '$kpmr_rep_pil1_minValue',
        '$kpmr_rep_pil1_average',
        '$set_rep_pil1',
        '$kpmr_rep_pil1_tingkat_risiko',
        '$kpmr_rep_pil2_maxValue',
        '$kpmr_rep_pil2_minValue',
        '$kpmr_rep_pil2_average',
        '$set_rep_pil2',
        '$kpmr_rep_pil2_tingkat_risiko',
        '$kpmr_rep_pil3_maxValue',
        '$kpmr_rep_pil3_minValue',
        '$kpmr_rep_pil3_average',
        '$set_rep_pil3',
        '$kpmr_rep_pil3_tingkat_risiko',
        '$kpmr_rep_pil4_maxValue',
        '$kpmr_rep_pil4_minValue',
        '$kpmr_rep_pil4_average',
        '$set_rep_pil4',
        '$kpmr_rep_pil4_tingkat_risiko')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_reputasi(id_keterangan_inheren2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_reputasi(id_kpmr2_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_reputasi(id_ket_profil_reputasi,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");



        //stra
        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar1(id_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by,
        pilar1_1,
        pilar1_1a,
        pilar1_1b,
        pilar1_1c,
        pilar1_1d,
        pilar1_1e,
        pilar1_1f,
        average_pil1_1,
        min_pil1_1,
        max_pil1_1,
        hasil_pil1_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_stra_pilar1_1',
        '$inheren_stra_pilar1_1a',
        '$inheren_stra_pilar1_1b',
        '$inheren_stra_pilar1_1c',
        '$inheren_stra_pilar1_1d',
        '$inheren_stra_pilar1_1e',
        '$inheren_stra_pilar1_1f',
        '$inheren_stra_average_pil1_1',
        '$inheren_stra_min_pil1_1',
        '$inheren_stra_max_pil1_1',
        '$inheren_stra_hasil_pil1_par1')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar2(id_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by,
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
        pilar2_2,
        pilar2_2a,
        pilar2_2b,
        pilar2_2c,
        average_pil2_1,
        average_pil2_2,
        min_pil2_1,
        min_pil2_2,
        max_pil2_1,
        max_pil2_2,
        hasil_pil2_par1,
        hasil_pil2_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_stra_pilar2_1',
        '$inheren_stra_pilar2_1a',
        '$inheren_stra_pilar2_1b',
        '$inheren_stra_pilar2_1c',
        '$inheren_stra_pilar2_1d',
        '$inheren_stra_pilar2_1e',
        '$inheren_stra_pilar2_1f',
        '$inheren_stra_pilar2_1g',
        '$inheren_stra_pilar2_1h',
        '$inheren_stra_pilar2_1i',
        '$inheren_stra_pilar2_2',
        '$inheren_stra_pilar2_2a',
        '$inheren_stra_pilar2_2b',
        '$inheren_stra_pilar2_2c',
        '$inheren_stra_average_pil2_1',
        '$inheren_stra_average_pil2_2',
        '$inheren_stra_min_pil2_1',
        '$inheren_stra_min_pil2_2',
        '$inheren_stra_max_pil2_1',
        '$inheren_stra_max_pil2_2',
        '$inheren_stra_hasil_pil2_par1',
        '$inheren_stra_hasil_pil2_par2')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_pilar3(id_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by,
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
        pilar3_2,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pilar3_2f,
        average_pil3_1,
        average_pil3_2,
        min_pil3_1,
        min_pil3_2,
        max_pil3_1,
        max_pil3_2,
        hasil_pil3_par1,
        hasil_pil3_par2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_stra_pilar3_1',
        '$inheren_stra_pilar3_1a',
        '$inheren_stra_pilar3_1b',
        '$inheren_stra_pilar3_1c',
        '$inheren_stra_pilar3_1d',
        '$inheren_stra_pilar3_1e',
        '$inheren_stra_pilar3_1f',
        '$inheren_stra_pilar3_1g',
        '$inheren_stra_pilar3_1h',
        '$inheren_stra_pilar3_1i',
        '$inheren_stra_pilar3_1j',
        '$inheren_stra_pilar3_1k',
        '$inheren_stra_pilar3_1l',
        '$inheren_stra_pilar3_1m',
        '$inheren_stra_pilar3_1n',
        '$inheren_stra_pilar3_1o',
        '$inheren_stra_pilar3_1p',
        '$inheren_stra_pilar3_2',
        '$inheren_stra_pilar3_2a',
        '$inheren_stra_pilar3_2b',
        '$inheren_stra_pilar3_2c',
        '$inheren_stra_pilar3_2d',
        '$inheren_stra_pilar3_2e',
        '$inheren_stra_pilar3_2f',
        '$inheren_stra_average_pil3_1',
        '$inheren_stra_average_pil3_2',
        '$inheren_stra_min_pil3_1',
        '$inheren_stra_min_pil3_2',
        '$inheren_stra_max_pil3_1',
        '$inheren_stra_max_pil3_2',
        '$inheren_stra_hasil_pil3_par1',
        '$inheren_stra_hasil_pil3_par2')");

        mysqli_query($conn, "INSERT INTO inheren_stratejik_lainnya(id_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        average_pil4_1,
        min_pil4_1,
        max_pil4_1,
        hasil_pil4_par1)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$inheren_stra_pilar4_1a',
        '$inheren_stra_pilar4_1b',
        '$inheren_stra_pilar4_1c',
        '$inheren_stra_pilar4_1d',
        '$inheren_stra_average_pil4_1',
        '$inheren_stra_min_pil4_1',
        '$inheren_stra_max_pil4_1',
        '$inheren_stra_hasil_pil4_par1')");


        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar1(id_ket_inheren_stratejik_pilar1,id_profil_risiko,dibuat_by,
        ket_in_stra_pil1_1,
        ket_in_stra_pil1_1a,
        ket_in_stra_pil1_1b,
        ket_in_stra_pil1_1c,
        ket_in_stra_pil1_1d,
        ket_in_stra_pil1_1e,
        ket_in_stra_pil1_1f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_stra_pil1_1',
        '$ket_in_stra_pil1_1a',
        '$ket_in_stra_pil1_1b',
        '$ket_in_stra_pil1_1c',
        '$ket_in_stra_pil1_1d',
        '$ket_in_stra_pil1_1e',
        '$ket_in_stra_pil1_1f')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar2(id_ket_inheren_stratejik_pilar2,id_profil_risiko,dibuat_by,
        ket_in_stra_pil2_1,
        ket_in_stra_pil2_1a,
        ket_in_stra_pil2_1b,
        ket_in_stra_pil2_1c,
        ket_in_stra_pil2_1d,
        ket_in_stra_pil2_1e,
        ket_in_stra_pil2_1f,
        ket_in_stra_pil2_1g,
        ket_in_stra_pil2_1h,
        ket_in_stra_pil2_1i,
        ket_in_stra_pil2_2,
        ket_in_stra_pil2_2a,
        ket_in_stra_pil2_2b,
        ket_in_stra_pil2_2c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_stra_pil2_1',
        '$ket_in_stra_pil2_1a',
        '$ket_in_stra_pil2_1b',
        '$ket_in_stra_pil2_1c',
        '$ket_in_stra_pil2_1d',
        '$ket_in_stra_pil2_1e',
        '$ket_in_stra_pil2_1f',
        '$ket_in_stra_pil2_1g',
        '$ket_in_stra_pil2_1h',
        '$ket_in_stra_pil2_1i',
        '$ket_in_stra_pil2_2',
        '$ket_in_stra_pil2_2a',
        '$ket_in_stra_pil2_2b',
        '$ket_in_stra_pil2_2c')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_pilar3(id_ket_inheren_stratejik_pilar3,id_profil_risiko,dibuat_by,
        ket_in_stra_pil3_1,
        ket_in_stra_pil3_1a,
        ket_in_stra_pil3_1b,
        ket_in_stra_pil3_1c,
        ket_in_stra_pil3_1d,
        ket_in_stra_pil3_1e,
        ket_in_stra_pil3_1f,
        ket_in_stra_pil3_1g,
        ket_in_stra_pil3_1h,
        ket_in_stra_pil3_1i,
        ket_in_stra_pil3_1j,
        ket_in_stra_pil3_1k,
        ket_in_stra_pil3_1l,
        ket_in_stra_pil3_1m,
        ket_in_stra_pil3_1n,
        ket_in_stra_pil3_1o,
        ket_in_stra_pil3_1p,
        ket_in_stra_pil3_2,
        ket_in_stra_pil3_2a,
        ket_in_stra_pil3_2b,
        ket_in_stra_pil3_2c,
        ket_in_stra_pil3_2d,
        ket_in_stra_pil3_2e,
        ket_in_stra_pil3_2f)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_stra_pil3_1',
        '$ket_in_stra_pil3_1a',
        '$ket_in_stra_pil3_1b',
        '$ket_in_stra_pil3_1c',
        '$ket_in_stra_pil3_1d',
        '$ket_in_stra_pil3_1e',
        '$ket_in_stra_pil3_1f',
        '$ket_in_stra_pil3_1g',
        '$ket_in_stra_pil3_1h',
        '$ket_in_stra_pil3_1i',
        '$ket_in_stra_pil3_1j',
        '$ket_in_stra_pil3_1k',
        '$ket_in_stra_pil3_1l',
        '$ket_in_stra_pil3_1m',
        '$ket_in_stra_pil3_1n',
        '$ket_in_stra_pil3_1o',
        '$ket_in_stra_pil3_1p',
        '$ket_in_stra_pil3_2',
        '$ket_in_stra_pil3_2a',
        '$ket_in_stra_pil3_2b',
        '$ket_in_stra_pil3_2c',
        '$ket_in_stra_pil3_2d',
        '$ket_in_stra_pil3_2e',
        '$ket_in_stra_pil3_2f')");

        mysqli_query($conn, "INSERT INTO ket_inheren_stratejik_lainnya(id_ket_inheren_stratejik_lainnya,id_profil_risiko,dibuat_by,
        ket_in_stra_pil4_1a,
        ket_in_stra_pil4_1b,
        ket_in_stra_pil4_1c,
        ket_in_stra_pil4_1d)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$ket_in_stra_pil4_1a',
        '$ket_in_stra_pil4_1b',
        '$ket_in_stra_pil4_1c',
        '$ket_in_stra_pil4_1d')");



        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar1(id_kpmr_stratejik_pilar1,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_pilar1_1a',
        '$kpmr_stra_pilar1_1b',
        '$kpmr_stra_pilar1_1c',
        '$kpmr_stra_pilar1_1d',
        '$kpmr_stra_pilar1_1e',
        '$kpmr_stra_pil1_total1',
        '$kpmr_stra_pil1_peringkat1',
        '$kpmr_stra_pilar1_2a',
        '$kpmr_stra_pilar1_2b',
        '$kpmr_stra_pilar1_2c',
        '$kpmr_stra_pilar1_2d',
        '$kpmr_stra_pilar1_2e',
        '$kpmr_stra_pil1_total2',
        '$kpmr_stra_pil1_peringkat2',
        '$kpmr_stra_pilar1_3a',
        '$kpmr_stra_pilar1_3b',
        '$kpmr_stra_pilar1_3c',
        '$kpmr_stra_pil1_total3',
        '$kpmr_stra_pil1_peringkat3',
        '$kpmr_stra_pilar1_4a',
        '$kpmr_stra_pilar1_4b',
        '$kpmr_stra_pilar1_4c',
        '$kpmr_stra_pilar1_4d',
        '$kpmr_stra_pilar1_4e',
        '$kpmr_stra_pil1_total4',
        '$kpmr_stra_pil1_peringkat4',
        '$kpmr_stra_pilar1_5a',
        '$kpmr_stra_pilar1_5b',
        '$kpmr_stra_pilar1_5c',
        '$kpmr_stra_pilar1_5d',
        '$kpmr_stra_pil1_total5',
        '$kpmr_stra_pil1_peringkat5',
        '$kpmr_stra_pilar1_6a',
        '$kpmr_stra_pilar1_6b',
        '$kpmr_stra_pilar1_6c',
        '$kpmr_stra_pil1_total6',
        '$kpmr_stra_pil1_peringkat6')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar2(id_kpmr_stratejik_pilar2,id_profil_risiko,dibuat_by,
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
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_pilar2_1a',
        '$kpmr_stra_pilar2_1b',
        '$kpmr_stra_pilar2_1c',
        '$kpmr_stra_pilar2_1d',
        '$kpmr_stra_pilar2_1e',
        '$kpmr_stra_pil2_total1',
        '$kpmr_stra_pil2_peringkat1',
        '$kpmr_stra_pilar2_2a',
        '$kpmr_stra_pilar2_2b',
        '$kpmr_stra_pilar2_2c',
        '$kpmr_stra_pilar2_2d',
        '$kpmr_stra_pilar2_2e',
        '$kpmr_stra_pilar2_2f',
        '$kpmr_stra_pilar2_2g',
        '$kpmr_stra_pilar2_2h',
        '$kpmr_stra_pil2_total2',
        '$kpmr_stra_pil2_peringkat2',
        '$kpmr_stra_pilar2_3a',
        '$kpmr_stra_pilar2_3b',
        '$kpmr_stra_pilar2_3c',
        '$kpmr_stra_pil2_total3',
        '$kpmr_stra_pil2_peringkat3')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar3(id_kpmr_stratejik_pilar3,id_profil_risiko,dibuat_by,
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
        pil3_total1,
        pil3_peringkat1,
        pilar3_2a,
        pilar3_2b,
        pilar3_2c,
        pilar3_2d,
        pilar3_2e,
        pil3_total2,
        pil3_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_pilar3_1a',
        '$kpmr_stra_pilar3_1b',
        '$kpmr_stra_pilar3_1c',
        '$kpmr_stra_pilar3_1d',
        '$kpmr_stra_pilar3_1e',
        '$kpmr_stra_pilar3_1f',
        '$kpmr_stra_pilar3_1g',
        '$kpmr_stra_pilar3_1h',
        '$kpmr_stra_pilar3_1i',
        '$kpmr_stra_pilar3_1j',
        '$kpmr_stra_pil3_total1',
        '$kpmr_stra_pil3_peringkat1',
        '$kpmr_stra_pilar3_2a',
        '$kpmr_stra_pilar3_2b',
        '$kpmr_stra_pilar3_2c',
        '$kpmr_stra_pilar3_2d',
        '$kpmr_stra_pilar3_2e',
        '$kpmr_stra_pil3_total2',
        '$kpmr_stra_pil3_peringkat2')");

        mysqli_query($conn, "INSERT INTO kpmr_stratejik_pilar4(id_kpmr_stratejik_pilar4,id_profil_risiko,dibuat_by,
        pilar4_1a,
        pilar4_1b,
        pilar4_1c,
        pilar4_1d,
        pilar4_1e,
        pil4_total1,
        pil4_peringkat1,
        pilar4_2a,
        pilar4_2b,
        pil4_total2,
        pil4_peringkat2)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_pilar4_1a',
        '$kpmr_stra_pilar4_1b',
        '$kpmr_stra_pilar4_1c',
        '$kpmr_stra_pilar4_1d',
        '$kpmr_stra_pilar4_1e',
        '$kpmr_stra_pil4_total1',
        '$kpmr_stra_pil4_peringkat1',
        '$kpmr_stra_pilar4_2a',
        '$kpmr_stra_pilar4_2b',
        '$kpmr_stra_pil4_total2',
        '$kpmr_stra_pil4_peringkat2')");


        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil1(id_respon_stratejik_pil1,id_profil_risiko,dibuat_by,
        respon_pil1_1a,
        respon_pil1_1b,
        respon_pil1_1c,
        respon_pil1_1d,
        respon_pil1_1e,
        respon_pil1_2a,
        respon_pil1_2b,
        respon_pil1_2c,
        respon_pil1_2d,
        respon_pil1_2e,
        respon_pil1_3a,
        respon_pil1_3b,
        respon_pil1_3c,
        respon_pil1_4a,
        respon_pil1_4b,
        respon_pil1_4c,
        respon_pil1_4d,
        respon_pil1_4e,
        respon_pil1_5a,
        respon_pil1_5b,
        respon_pil1_5c,
        respon_pil1_5d,
        respon_pil1_6a,
        respon_pil1_6b,
        respon_pil1_6c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_respon_pil1_1a',
        '$kpmr_stra_respon_pil1_1b',
        '$kpmr_stra_respon_pil1_1c',
        '$kpmr_stra_respon_pil1_1d',
        '$kpmr_stra_respon_pil1_1e',
        '$kpmr_stra_respon_pil1_2a',
        '$kpmr_stra_respon_pil1_2b',
        '$kpmr_stra_respon_pil1_2c',
        '$kpmr_stra_respon_pil1_2d',
        '$kpmr_stra_respon_pil1_2e',
        '$kpmr_stra_respon_pil1_3a',
        '$kpmr_stra_respon_pil1_3b',
        '$kpmr_stra_respon_pil1_3c',
        '$kpmr_stra_respon_pil1_4a',
        '$kpmr_stra_respon_pil1_4b',
        '$kpmr_stra_respon_pil1_4c',
        '$kpmr_stra_respon_pil1_4d',
        '$kpmr_stra_respon_pil1_4e',
        '$kpmr_stra_respon_pil1_5a',
        '$kpmr_stra_respon_pil1_5b',
        '$kpmr_stra_respon_pil1_5c',
        '$kpmr_stra_respon_pil1_5d',
        '$kpmr_stra_respon_pil1_6a',
        '$kpmr_stra_respon_pil1_6b',
        '$kpmr_stra_respon_pil1_6c')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil2(id_respon_stratejik_pil2,id_profil_risiko,dibuat_by,
        respon_pil2_1a,
        respon_pil2_1b,
        respon_pil2_1c,
        respon_pil2_1d,
        respon_pil2_1e,
        respon_pil2_2a,
        respon_pil2_2b,
        respon_pil2_2c,
        respon_pil2_2d,
        respon_pil2_2e,
        respon_pil2_2f,
        respon_pil2_2g,
        respon_pil2_2h,
        respon_pil2_3a,
        respon_pil2_3b,
        respon_pil2_3c)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_respon_pil2_1a',
        '$kpmr_stra_respon_pil2_1b',
        '$kpmr_stra_respon_pil2_1c',
        '$kpmr_stra_respon_pil2_1d',
        '$kpmr_stra_respon_pil2_1e',
        '$kpmr_stra_respon_pil2_2a',
        '$kpmr_stra_respon_pil2_2b',
        '$kpmr_stra_respon_pil2_2c',
        '$kpmr_stra_respon_pil2_2d',
        '$kpmr_stra_respon_pil2_2e',
        '$kpmr_stra_respon_pil2_2f',
        '$kpmr_stra_respon_pil2_2g',
        '$kpmr_stra_respon_pil2_2h',
        '$kpmr_stra_respon_pil2_3a',
        '$kpmr_stra_respon_pil2_3b',
        '$kpmr_stra_respon_pil2_3c')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil3(id_respon_stratejik_pil3,id_profil_risiko,dibuat_by,
        respon_pil3_1a,
        respon_pil3_1b,
        respon_pil3_1c,
        respon_pil3_1d,
        respon_pil3_1e,
        respon_pil3_1f,
        respon_pil3_1g,
        respon_pil3_1h,
        respon_pil3_1i,
        respon_pil3_1j,
        respon_pil3_2a,
        respon_pil3_2b,
        respon_pil3_2c,
        respon_pil3_2d,
        respon_pil3_2e)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_respon_pil3_1a',
        '$kpmr_stra_respon_pil3_1b',
        '$kpmr_stra_respon_pil3_1c',
        '$kpmr_stra_respon_pil3_1d',
        '$kpmr_stra_respon_pil3_1e',
        '$kpmr_stra_respon_pil3_1f',
        '$kpmr_stra_respon_pil3_1g',
        '$kpmr_stra_respon_pil3_1h',
        '$kpmr_stra_respon_pil3_1i',
        '$kpmr_stra_respon_pil3_1j',
        '$kpmr_stra_respon_pil3_2a',
        '$kpmr_stra_respon_pil3_2b',
        '$kpmr_stra_respon_pil3_2c',
        '$kpmr_stra_respon_pil3_2d',
        '$kpmr_stra_respon_pil3_2e')");

        mysqli_query($conn, "INSERT INTO respon_unit_kerja_stratejik_pil4(id_respon_stratejik_pil4,id_profil_risiko,dibuat_by,
        respon_pil4_1a,
        respon_pil4_1b,
        respon_pil4_1c,
        respon_pil4_1d,
        respon_pil4_1e,
        respon_pil4_2a,
        respon_pil4_2b)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_respon_pil4_1a',
        '$kpmr_stra_respon_pil4_1b',
        '$kpmr_stra_respon_pil4_1c',
        '$kpmr_stra_respon_pil4_1d',
        '$kpmr_stra_respon_pil4_1e',
        '$kpmr_stra_respon_pil4_2a',
        '$kpmr_stra_respon_pil4_2b')");

        mysqli_query($conn, "INSERT INTO hasil_inheren_stratejik(id_hasil_inheren_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO hasil_kpmr_stratejik(id_hasil_kpmr_stratejik,id_profil_risiko,dibuat_by,
        pil1_tertinggi,
        pil1_terendah,
        pil1_rata_rata,
        pil1_risiko_ditetapkan,
        pil1_tingkat_risiko,
        pil2_tertinggi,
        pil2_terendah,
        pil2_rata_rata,
        pil2_risiko_ditetapkan,
        pil2_tingkat_risiko,
        pil3_tertinggi,
        pil3_terendah,
        pil3_rata_rata,
        pil3_risiko_ditetapkan,
        pil3_tingkat_risiko,
        pil4_tertinggi,
        pil4_terendah,
        pil4_rata_rata,
        pil4_risiko_ditetapkan,
        pil4_tingkat_risiko)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
        '$kpmr_stra_pil1_maxValue',
        '$kpmr_stra_pil1_minValue',
        '$kpmr_stra_pil1_average',
        '$set_stra_pil1',
        '$kpmr_stra_pil1_tingkat_risiko',
        '$kpmr_stra_pil2_maxValue',
        '$kpmr_stra_pil2_minValue',
        '$kpmr_stra_pil2_average',
        '$set_stra_pil2',
        '$kpmr_stra_pil2_tingkat_risiko',
        '$kpmr_stra_pil3_maxValue',
        '$kpmr_stra_pil3_minValue',
        '$kpmr_stra_pil3_average',
        '$set_stra_pil3',
        '$kpmr_stra_pil3_tingkat_risiko',
        '$kpmr_stra_pil4_maxValue',
        '$kpmr_stra_pil4_minValue',
        '$kpmr_stra_pil4_average',
        '$set_stra_pil4',
        '$kpmr_stra_pil4_tingkat_risiko')");

        mysqli_query($conn, "INSERT INTO keterangan_inheren2_stratejik(id_keterangan_inheren2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_kpmr2_stratejik(id_kpmr2_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO keterangan_profil_stratejik(id_ket_profil_stratejik,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");




        mysqli_query($conn, "INSERT INTO nilai_profil(id_nilai_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

        mysqli_query($conn, "INSERT INTO peringkat_profil(id_peringkat_profil,id_profil_risiko,dibuat_by)
        VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by')");

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
                                                        include "../conn/conn.php";
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
                                                                include "../conn/conn.php";
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
                                                                include "../conn/conn.php";
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
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE frame_laporan_profil_risiko.kantor_cabang = '$kode_kantor' AND user =5 order by id_profil_risiko desc");
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
