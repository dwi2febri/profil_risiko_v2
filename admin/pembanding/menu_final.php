

<?php
include "../fungsi/fungsi.php";
if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $lokasi_kerja = $_POST['lokasi_kerja'];
    $tahun = $_POST['tahun'];
    $user = $_POST['user'];
    $periode = $_POST['periode'];
    $keterangan = $_POST['keterangan'];
    $modal_inti_form = preg_replace('/[^0-9]/', '', (string)($_POST['modal_inti'] ?? ''));
    $total_aset_form = preg_replace('/[^0-9]/', '', (string)($_POST['total_aset'] ?? ''));
    

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];

    
// ============================
// Fungsi ambil nilai & respon antar user
// ============================
function getMaxValueWithResponUser($conn, $tableNilai, $fieldNilai, $tableRespon, $fieldRespon, $tahun, $periode, $user1 = 1, $user2 = 5) {
    $sql1 = "SELECT n.$fieldNilai AS nilai, r.$fieldRespon AS respon 
             FROM $tableNilai n
             INNER JOIN frame_laporan_profil_risiko f ON n.id_profil_risiko = f.id_profil_risiko
             LEFT JOIN $tableRespon r ON r.id_profil_risiko = f.id_profil_risiko
             WHERE f.tahun = '$tahun' AND f.periode = '$periode' AND f.user = $user1
             LIMIT 1";
    $sql2 = "SELECT n.$fieldNilai AS nilai, r.$fieldRespon AS respon 
             FROM $tableNilai n
             INNER JOIN frame_laporan_profil_risiko f ON n.id_profil_risiko = f.id_profil_risiko
             LEFT JOIN $tableRespon r ON r.id_profil_risiko = f.id_profil_risiko
             WHERE f.tahun = '$tahun' AND f.periode = '$periode' AND f.user = $user2
             LIMIT 1";

    $res1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
    $res2 = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

    $val1 = intval($res1['nilai'] ?? 0);
    $val2 = intval($res2['nilai'] ?? 0);

    if ($val1 >= $val2) {
        return ['nilai' => $val1, 'respon' => $res1['respon'] ?? ''];
    } else {
        return ['nilai' => $val2, 'respon' => $res2['respon'] ?? ''];
    }
}

// ============================
// Fungsi ambil nilai & ket antar user
// ============================
function getMaxInherenWithKetUser($conn, $tableNilai, $fieldNilai, $tableKet, $fieldKet, $tahun, $periode, $user1 = 1, $user2 = 5) {
    $sql1 = "SELECT n.$fieldNilai AS nilai, k.$fieldKet AS ket 
             FROM $tableNilai n
             INNER JOIN frame_laporan_profil_risiko f ON n.id_profil_risiko = f.id_profil_risiko
             LEFT JOIN $tableKet k ON k.id_profil_risiko = f.id_profil_risiko
             WHERE f.tahun = '$tahun' AND f.periode = '$periode' AND f.user = $user1
             LIMIT 1";
    $sql2 = "SELECT n.$fieldNilai AS nilai, k.$fieldKet AS ket 
             FROM $tableNilai n
             INNER JOIN frame_laporan_profil_risiko f ON n.id_profil_risiko = f.id_profil_risiko
             LEFT JOIN $tableKet k ON k.id_profil_risiko = f.id_profil_risiko
             WHERE f.tahun = '$tahun' AND f.periode = '$periode' AND f.user = $user2
             LIMIT 1";

    $res1 = mysqli_fetch_assoc(mysqli_query($conn, $sql1));
    $res2 = mysqli_fetch_assoc(mysqli_query($conn, $sql2));

    $val1 = intval($res1['nilai'] ?? 0);
    $val2 = intval($res2['nilai'] ?? 0);

    if ($val1 >= $val2) {
        return ['nilai' => $val1, 'ket' => $res1['ket'] ?? ''];
    } else {
        return ['nilai' => $val2, 'ket' => $res2['ket'] ?? ''];
    }
}

 
 
// Cara akses spesifik

$result_inheren_kre_pilar1_3 = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar1','pilar1_3','keterangan_inheren_kredit','ket_pil1_3',$tahun,$periode,1,5);
$result_inheren_kre_pilar1_4 = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar1','pilar1_4','keterangan_inheren_kredit','ket_pil1_4',$tahun,$periode,1,5);

$result_inheren_kre_pilar3_1 = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar3_1a = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1a','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar3_1b = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1b','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar3_1c = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1c','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar3_1d = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1d','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar3_1e = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar3','pilar3_1e','keterangan_inheren_kredit','ket_pil3_1',$tahun,$periode,1,5);

$result_inheren_kre_pilar4_1a = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar4','pilar4_1a','keterangan_inheren_kredit','ket_pil4_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar4_1b = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar4','pilar4_1b','keterangan_inheren_kredit','ket_pil4_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar4_1c = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar4','pilar4_1c','keterangan_inheren_kredit','ket_pil4_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar4_1d = getMaxInherenWithKetUser($conn,'inheren_kredit_pilar4','pilar4_1d','keterangan_inheren_kredit','ket_pil4_1',$tahun,$periode,1,5);

$result_inheren_kre_pilar5_1a = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1a','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1b = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1b','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1c = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1c','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1d = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1d','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1e = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1e','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1f = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1f','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1g = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1g','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1h = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1h','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1i = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1i','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1j = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1j','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);
$result_inheren_kre_pilar5_1k = getMaxInherenWithKetUser($conn,'inheren_kredit_lainnya','pilar5_1k','keterangan_inheren_kredit','ket_pil5_1',$tahun,$periode,1,5);

$kredit_pilar1_3 = $result_inheren_kre_pilar1_3['nilai']; 
$kredit_ket_pilar1_3 = $result_inheren_kre_pilar1_3['ket'];
$kredit_pilar1_4 = $result_inheren_kre_pilar1_4['nilai']; 
$kredit_ket_pilar1_4 = $result_inheren_kre_pilar1_4['ket'];

$kredit_pilar3_1 = $result_inheren_kre_pilar3_1['nilai'];
$kredit_pilar3_1a = $result_inheren_kre_pilar3_1a['nilai'];
$kredit_pilar3_1b = $result_inheren_kre_pilar3_1b['nilai'];
$kredit_pilar3_1c = $result_inheren_kre_pilar3_1c['nilai'];
$kredit_pilar3_1d = $result_inheren_kre_pilar3_1d['nilai']; 
$kredit_pilar3_1e = $result_inheren_kre_pilar3_1e['nilai']; 

$kredit_pilar4_1a = $result_inheren_kre_pilar4_1a['nilai'];
$kredit_pilar4_1b = $result_inheren_kre_pilar4_1b['nilai'];
$kredit_pilar4_1c = $result_inheren_kre_pilar4_1c['nilai'];
$kredit_pilar4_1d = $result_inheren_kre_pilar4_1d['nilai'];

$kredit_pilar5_1a = $result_inheren_kre_pilar5_1a['nilai'];
$kredit_pilar5_1b = $result_inheren_kre_pilar5_1b['nilai'];
$kredit_pilar5_1c = $result_inheren_kre_pilar5_1c['nilai'];
$kredit_pilar5_1d = $result_inheren_kre_pilar5_1d['nilai'];
$kredit_pilar5_1e = $result_inheren_kre_pilar5_1e['nilai'];
$kredit_pilar5_1f = $result_inheren_kre_pilar5_1f['nilai'];
$kredit_pilar5_1g = $result_inheren_kre_pilar5_1g['nilai'];
$kredit_pilar5_1h = $result_inheren_kre_pilar5_1h['nilai'];
$kredit_pilar5_1i = $result_inheren_kre_pilar5_1i['nilai'];
$kredit_pilar5_1j = $result_inheren_kre_pilar5_1j['nilai'];
$kredit_pilar5_1k = $result_inheren_kre_pilar5_1k['nilai'];

    $kpmr_kre = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kredit WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_kre_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_1a','respon_unit_kerja_kredit_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_1b','respon_unit_kerja_kredit_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_1c','respon_unit_kerja_kredit_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_1d','respon_unit_kerja_kredit_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_1e','respon_unit_kerja_kredit_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_kre_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_2a','respon_unit_kerja_kredit_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_2b','respon_unit_kerja_kredit_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_2c','respon_unit_kerja_kredit_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_2d','respon_unit_kerja_kredit_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_2e','respon_unit_kerja_kredit_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_kre_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_3a','respon_unit_kerja_kredit_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_3b','respon_unit_kerja_kredit_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_3c','respon_unit_kerja_kredit_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_kre_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_4a','respon_unit_kerja_kredit_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_4b','respon_unit_kerja_kredit_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_4c','respon_unit_kerja_kredit_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_4d','respon_unit_kerja_kredit_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_4e','respon_unit_kerja_kredit_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_kre_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_5a','respon_unit_kerja_kredit_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_5b','respon_unit_kerja_kredit_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_5c','respon_unit_kerja_kredit_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_5d','respon_unit_kerja_kredit_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_kre_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_6a','respon_unit_kerja_kredit_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_6b','respon_unit_kerja_kredit_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar1','pilar1_6c','respon_unit_kerja_kredit_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    

    $result_kpmr_kre_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_1a','respon_unit_kerja_kredit_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_1b','respon_unit_kerja_kredit_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_1c','respon_unit_kerja_kredit_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_1d','respon_unit_kerja_kredit_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_1e','respon_unit_kerja_kredit_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_kre_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2a','respon_unit_kerja_kredit_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2b','respon_unit_kerja_kredit_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2c','respon_unit_kerja_kredit_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2d','respon_unit_kerja_kredit_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2e','respon_unit_kerja_kredit_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2f','respon_unit_kerja_kredit_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2g','respon_unit_kerja_kredit_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_2h','respon_unit_kerja_kredit_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_kre_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_3a','respon_unit_kerja_kredit_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_3b','respon_unit_kerja_kredit_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar2','pilar2_3c','respon_unit_kerja_kredit_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_kre_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1a','respon_unit_kerja_kredit_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1b','respon_unit_kerja_kredit_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1c','respon_unit_kerja_kredit_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1d','respon_unit_kerja_kredit_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1e','respon_unit_kerja_kredit_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1f','respon_unit_kerja_kredit_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1g','respon_unit_kerja_kredit_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1h','respon_unit_kerja_kredit_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1i','respon_unit_kerja_kredit_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_1j','respon_unit_kerja_kredit_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_kre_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_2a','respon_unit_kerja_kredit_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_2b','respon_unit_kerja_kredit_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_2c','respon_unit_kerja_kredit_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_2d','respon_unit_kerja_kredit_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar3','pilar3_2e','respon_unit_kerja_kredit_pil3','respon_pil3_1e',$tahun,$periode,1,5);



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
$kpmr_kre_pilar1_5d);
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



   $result_kpmr_kre_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_1a','respon_unit_kerja_kredit_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_1b','respon_unit_kerja_kredit_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_1c','respon_unit_kerja_kredit_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_1d','respon_unit_kerja_kredit_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_1e','respon_unit_kerja_kredit_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_kre_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_2a','respon_unit_kerja_kredit_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_kre_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_kredit_pilar4','pilar4_2b','respon_unit_kerja_kredit_pil4','respon_pil4_1b',$tahun,$periode,1,5);
   



$kpmr_kre_pilar4_1a = $result_kpmr_kre_pilar4_1a['nilai']; $kpmr_kre_respon_pil4_1a = $result_kpmr_kre_pilar4_1a['respon'];
$kpmr_kre_pilar4_1b = $result_kpmr_kre_pilar4_1b['nilai']; $kpmr_kre_respon_pil4_1b = $result_kpmr_kre_pilar4_1b['respon'];
$kpmr_kre_pilar4_1c = $result_kpmr_kre_pilar4_1c['nilai']; $kpmr_kre_respon_pil4_1c = $result_kpmr_kre_pilar4_1c['respon'];
$kpmr_kre_pilar4_1d = $result_kpmr_kre_pilar4_1d['nilai']; $kpmr_kre_respon_pil4_1d = $result_kpmr_kre_pilar4_1d['respon'];
$kpmr_kre_pilar4_1e = $result_kpmr_kre_pilar4_1e['nilai']; $kpmr_kre_respon_pil4_1e = $result_kpmr_kre_pilar4_1e['respon'];

$kpmr_kre_pilar4_2a = $result_kpmr_kre_pilar4_2a['nilai']; $kpmr_kre_respon_pil4_2a = $result_kpmr_kre_pilar4_2a['respon'];
$kpmr_kre_pilar4_2b = $result_kpmr_kre_pilar4_2b['nilai']; $kpmr_kre_respon_pil4_2b = $result_kpmr_kre_pilar4_2b['respon'];


// --- Pilar 3 Total 1 ---
$kpmr_kre_pil4_total1_average = array($kpmr_kre_pilar4_1a,
$kpmr_kre_pilar4_1b,
$kpmr_kre_pilar4_1c,
$kpmr_kre_pilar4_1d,
$kpmr_kre_pilar4_1e);
$kpmr_kre_pil4_total1_sum = array_sum($kpmr_kre_pil4_total1_average);
$kpmr_kre_pil4_total1 = $kpmr_kre_pil4_total1_sum / count($kpmr_kre_pil4_total1_average);

if ($kpmr_kre_pil4_total1 < 1.00) {
    $kpmr_kre_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kre_pil4_total1 >= 1.00 && $kpmr_kre_pil4_total1 < 1.25) {
    $kpmr_kre_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kre_pil4_total1 >= 1.25 && $kpmr_kre_pil4_total1 < 2.25) {
    $kpmr_kre_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_kre_pil4_total1 >= 2.25 && $kpmr_kre_pil4_total1 < 3.25) {
    $kpmr_kre_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kre_pil4_total1 >= 3.25 && $kpmr_kre_pil4_total1 < 4.25) {
    $kpmr_kre_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kre_pil4_total1 >= 4.25 && $kpmr_kre_pil4_total1 <= 5.00) {
    $kpmr_kre_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kre_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_kre_pilar4_1a = $result_kpmr_kre_pilar4_1a['nilai']; $kpmr_kre_respon_pil4_1a = $result_kpmr_kre_pilar4_1a['respon'];
$kpmr_kre_pilar4_1b = $result_kpmr_kre_pilar4_1b['nilai']; $kpmr_kre_respon_pil4_1b = $result_kpmr_kre_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_kre_pil4_total2_average = array($kpmr_kre_pilar4_1a,
$kpmr_kre_pilar4_1b);
$kpmr_kre_pil4_total2_sum = array_sum($kpmr_kre_pil4_total2_average);
$kpmr_kre_pil4_total2 = $kpmr_kre_pil4_total2_sum / count($kpmr_kre_pil4_total2_average);

if ($kpmr_kre_pil4_total2 < 1.00) {
    $kpmr_kre_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kre_pil4_total2 >= 1.00 && $kpmr_kre_pil4_total2 < 1.25) {
    $kpmr_kre_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kre_pil4_total2 >= 1.25 && $kpmr_kre_pil4_total2 < 2.25) {
    $kpmr_kre_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_kre_pil4_total2 >= 2.25 && $kpmr_kre_pil4_total2 < 3.25) {
    $kpmr_kre_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kre_pil4_total2 >= 3.25 && $kpmr_kre_pil4_total2 < 4.25) {
    $kpmr_kre_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kre_pil4_total2 >= 4.25 && $kpmr_kre_pil4_total2 <= 5.00) {
    $kpmr_kre_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kre_pil4_peringkat2 = "Belum Terisi";
}

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


$result_inheren_lik_pilar1_4       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar1','pilar1_4','keterangan_inheren_likuiditas','ket_pil1_4',$tahun,$periode,1,5);

$result_inheren_lik_hasil_pil2_par1  = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','hasil_pil2_par1','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_pil2_par1a       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','pil2_par1a','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil2_par1a = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','hasil_pil2_par1a','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_pil2_par1b       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','pil2_par1b','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil2_par1b = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','hasil_pil2_par1b','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_pil2_par1c       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','pil2_par1c','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil2_par1c = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','hasil_pil2_par1c','keterangan_inheren_likuiditas','ket_pil2_1',$tahun,$periode,1,5);
$result_inheren_lik_pil2_par2        = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','pil2_par2','keterangan_inheren_likuiditas','ket_pil2_2',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil2_par2  = getMaxInherenWithKetUser($conn,'inheren_likuiditas_pilar2','hasil_pil2_par2','keterangan_inheren_likuiditas','ket_pil2_2',$tahun,$periode,1,5);

$result_inheren_lik_hasil_pil3_par1  = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1a       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1a','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1a = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1a','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1b       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1b','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1b = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1b','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1c       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1c','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1c = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1c','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1d       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1d','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1d = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1d','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1e       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1e','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1e = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1e','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_pil3_par1f       = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','pil3_par1f','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);
$result_inheren_lik_hasil_pil3_par1f = getMaxInherenWithKetUser($conn,'inheren_likuiditas_lainnya','hasil_pil3_par1f','keterangan_inheren_likuiditas','ket_pil3_1',$tahun,$periode,1,5);



$lik_pilar1_4 = $result_inheren_lik_pilar1_4['nilai']; $lik_ket_pilar1_4 = $result_inheren_lik_pilar1_4['ket'];

$lik_hasil_pil2_par1 = $result_inheren_lik_hasil_pil2_par1['nilai']; $lik_ket_hasil_pil2_par1 = $result_inheren_lik_hasil_pil2_par1['ket'];
$lik_pil2_par1a = $result_inheren_lik_pil2_par1a['nilai']; $lik_ket_pil2_par1a = $result_inheren_lik_pil2_par1a['ket'];
$lik_hasil_pil2_par1a = $result_inheren_lik_hasil_pil2_par1a['nilai']; $lik_ket_hasil_pil2_par1a = $result_inheren_lik_hasil_pil2_par1a['ket'];
$lik_pil2_par1b = $result_inheren_lik_pil2_par1b['nilai']; $lik_ket_pil2_par1b = $result_inheren_lik_pil2_par1b['ket'];
$lik_hasil_pil2_par1b = $result_inheren_lik_hasil_pil2_par1b['nilai']; $lik_ket_hasil_pil2_par1b = $result_inheren_lik_hasil_pil2_par1b['ket'];
$lik_pil2_par1c = $result_inheren_lik_pil2_par1c['nilai']; $lik_ket_pil2_par1c = $result_inheren_lik_pil2_par1c['ket'];
$lik_hasil_pil2_par1c = $result_inheren_lik_hasil_pil2_par1c['nilai']; $lik_ket_hasil_pil2_par1c = $result_inheren_lik_hasil_pil2_par1c['ket'];
$lik_pil2_par2 = $result_inheren_lik_pil2_par2['nilai']; $lik_ket_pil2_par2 = $result_inheren_lik_pil2_par2['ket'];
$lik_hasil_pil2_par2 = $result_inheren_lik_hasil_pil2_par2['nilai']; $lik_ket_hasil_pil2_par2 = $result_inheren_lik_hasil_pil2_par2['ket'];

$lik_hasil_pil3_par1 = $result_inheren_lik_hasil_pil3_par1['nilai']; $lik_ket_hasil_pil3_par1 = $result_inheren_lik_hasil_pil3_par1['ket'];
$lik_pil3_par1a = $result_inheren_lik_pil3_par1a['nilai']; $lik_ket_pil3_par1a = $result_inheren_lik_pil3_par1a['ket'];
$lik_hasil_pil3_par1a = $result_inheren_lik_hasil_pil3_par1a['nilai']; $lik_ket_hasil_pil3_par1a = $result_inheren_lik_hasil_pil3_par1a['ket'];
$lik_pil3_par1b = $result_inheren_lik_pil3_par1b['nilai']; $lik_ket_pil3_par1b = $result_inheren_lik_pil3_par1b['ket'];
$lik_hasil_pil3_par1b = $result_inheren_lik_hasil_pil3_par1b['nilai']; $lik_ket_hasil_pil3_par1b = $result_inheren_lik_hasil_pil3_par1b['ket'];
$lik_pil3_par1c = $result_inheren_lik_pil3_par1c['nilai']; $lik_ket_pil3_par1c = $result_inheren_lik_pil3_par1c['ket'];
$lik_hasil_pil3_par1c = $result_inheren_lik_hasil_pil3_par1c['nilai']; $lik_ket_hasil_pil3_par1c = $result_inheren_lik_hasil_pil3_par1c['ket'];
$lik_pil3_par1d = $result_inheren_lik_pil3_par1d['nilai']; $lik_ket_pil3_par1d = $result_inheren_lik_pil3_par1d['ket'];
$lik_hasil_pil3_par1d = $result_inheren_lik_hasil_pil3_par1d['nilai']; $lik_ket_hasil_pil3_par1d = $result_inheren_lik_hasil_pil3_par1d['ket'];
$lik_pil3_par1e = $result_inheren_lik_pil3_par1e['nilai']; $lik_ket_pil3_par1e = $result_inheren_lik_pil3_par1e['ket'];
$lik_hasil_pil3_par1e = $result_inheren_lik_hasil_pil3_par1e['nilai']; $lik_ket_hasil_pil3_par1e = $result_inheren_lik_hasil_pil3_par1e['ket'];
$lik_pil3_par1f = $result_inheren_lik_pil3_par1f['nilai']; $lik_ket_pil3_par1f = $result_inheren_lik_pil3_par1f['ket'];
$lik_hasil_pil3_par1f = $result_inheren_lik_hasil_pil3_par1f['nilai']; $lik_ket_hasil_pil3_par1f = $result_inheren_lik_hasil_pil3_par1f['ket'];




$kpmr_lik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_likuiditas WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_lik_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_1a','respon_unit_kerja_likuiditas_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_1b','respon_unit_kerja_likuiditas_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_1c','respon_unit_kerja_likuiditas_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_1d','respon_unit_kerja_likuiditas_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_1e','respon_unit_kerja_likuiditas_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_lik_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_2a','respon_unit_kerja_likuiditas_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_2b','respon_unit_kerja_likuiditas_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_2c','respon_unit_kerja_likuiditas_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_2d','respon_unit_kerja_likuiditas_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_2e','respon_unit_kerja_likuiditas_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_lik_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_3a','respon_unit_kerja_likuiditas_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_3b','respon_unit_kerja_likuiditas_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_3c','respon_unit_kerja_likuiditas_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_lik_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_4a','respon_unit_kerja_likuiditas_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_4b','respon_unit_kerja_likuiditas_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_4c','respon_unit_kerja_likuiditas_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_4d','respon_unit_kerja_likuiditas_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_4e','respon_unit_kerja_likuiditas_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_lik_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_5a','respon_unit_kerja_likuiditas_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_5b','respon_unit_kerja_likuiditas_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_5c','respon_unit_kerja_likuiditas_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_5d','respon_unit_kerja_likuiditas_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_lik_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_6a','respon_unit_kerja_likuiditas_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_6b','respon_unit_kerja_likuiditas_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar1','pilar1_6c','respon_unit_kerja_likuiditas_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    

    $result_kpmr_lik_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_1a','respon_unit_kerja_likuiditas_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_1b','respon_unit_kerja_likuiditas_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_1c','respon_unit_kerja_likuiditas_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_1d','respon_unit_kerja_likuiditas_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_1e','respon_unit_kerja_likuiditas_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_lik_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2a','respon_unit_kerja_likuiditas_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2b','respon_unit_kerja_likuiditas_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2c','respon_unit_kerja_likuiditas_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2d','respon_unit_kerja_likuiditas_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2e','respon_unit_kerja_likuiditas_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2f','respon_unit_kerja_likuiditas_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2g','respon_unit_kerja_likuiditas_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_2h','respon_unit_kerja_likuiditas_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_lik_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_3a','respon_unit_kerja_likuiditas_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_3b','respon_unit_kerja_likuiditas_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar2','pilar2_3c','respon_unit_kerja_likuiditas_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_lik_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1a','respon_unit_kerja_likuiditas_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1b','respon_unit_kerja_likuiditas_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1c','respon_unit_kerja_likuiditas_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1d','respon_unit_kerja_likuiditas_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1e','respon_unit_kerja_likuiditas_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1f','respon_unit_kerja_likuiditas_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1g','respon_unit_kerja_likuiditas_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1h','respon_unit_kerja_likuiditas_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1i','respon_unit_kerja_likuiditas_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_1j','respon_unit_kerja_likuiditas_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_lik_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_2a','respon_unit_kerja_likuiditas_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_2b','respon_unit_kerja_likuiditas_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_2c','respon_unit_kerja_likuiditas_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_2d','respon_unit_kerja_likuiditas_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar3','pilar3_2e','respon_unit_kerja_likuiditas_pil3','respon_pil3_1e',$tahun,$periode,1,5);



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


    $result_kpmr_lik_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_1a','respon_unit_kerja_likuiditas_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_1b','respon_unit_kerja_likuiditas_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_1c','respon_unit_kerja_likuiditas_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_1d','respon_unit_kerja_likuiditas_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_1e','respon_unit_kerja_likuiditas_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_lik_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_2a','respon_unit_kerja_likuiditas_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_lik_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_likuiditas_pilar4','pilar4_2b','respon_unit_kerja_likuiditas_pil4','respon_pil4_1b',$tahun,$periode,1,5);
   



$kpmr_lik_pilar4_1a = $result_kpmr_lik_pilar4_1a['nilai']; $kpmr_lik_respon_pil4_1a = $result_kpmr_lik_pilar4_1a['respon'];
$kpmr_lik_pilar4_1b = $result_kpmr_lik_pilar4_1b['nilai']; $kpmr_lik_respon_pil4_1b = $result_kpmr_lik_pilar4_1b['respon'];
$kpmr_lik_pilar4_1c = $result_kpmr_lik_pilar4_1c['nilai']; $kpmr_lik_respon_pil4_1c = $result_kpmr_lik_pilar4_1c['respon'];
$kpmr_lik_pilar4_1d = $result_kpmr_lik_pilar4_1d['nilai']; $kpmr_lik_respon_pil4_1d = $result_kpmr_lik_pilar4_1d['respon'];
$kpmr_lik_pilar4_1e = $result_kpmr_lik_pilar4_1e['nilai']; $kpmr_lik_respon_pil4_1e = $result_kpmr_lik_pilar4_1e['respon'];

$kpmr_lik_pilar4_2a = $result_kpmr_lik_pilar4_2a['nilai']; $kpmr_lik_respon_pil4_2a = $result_kpmr_lik_pilar4_2a['respon'];
$kpmr_lik_pilar4_2b = $result_kpmr_lik_pilar4_2b['nilai']; $kpmr_lik_respon_pil4_2b = $result_kpmr_lik_pilar4_2b['respon'];



// --- Pilar 3 Total 1 ---
$kpmr_lik_pil4_total1_average = array($kpmr_lik_pilar4_1a,
$kpmr_lik_pilar4_1b,
$kpmr_lik_pilar4_1c,
$kpmr_lik_pilar4_1d,
$kpmr_lik_pilar4_1e);
$kpmr_lik_pil4_total1_sum = array_sum($kpmr_lik_pil4_total1_average);
$kpmr_lik_pil4_total1 = $kpmr_lik_pil4_total1_sum / count($kpmr_lik_pil4_total1_average);

if ($kpmr_lik_pil4_total1 < 1.00) {
    $kpmr_lik_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_lik_pil4_total1 >= 1.00 && $kpmr_lik_pil4_total1 < 1.25) {
    $kpmr_lik_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_lik_pil4_total1 >= 1.25 && $kpmr_lik_pil4_total1 < 2.25) {
    $kpmr_lik_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_lik_pil4_total1 >= 2.25 && $kpmr_lik_pil4_total1 < 3.25) {
    $kpmr_lik_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_lik_pil4_total1 >= 3.25 && $kpmr_lik_pil4_total1 < 4.25) {
    $kpmr_lik_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_lik_pil4_total1 >= 4.25 && $kpmr_lik_pil4_total1 <= 5.00) {
    $kpmr_lik_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_lik_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_lik_pilar4_1a = $result_kpmr_lik_pilar4_1a['nilai']; $kpmr_lik_respon_pil4_1a = $result_kpmr_lik_pilar4_1a['respon'];
$kpmr_lik_pilar4_1b = $result_kpmr_lik_pilar4_1b['nilai']; $kpmr_lik_respon_pil4_1b = $result_kpmr_lik_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_lik_pil4_total2_average = array($kpmr_lik_pilar4_1a,
$kpmr_lik_pilar4_1b);
$kpmr_lik_pil4_total2_sum = array_sum($kpmr_lik_pil4_total2_average);
$kpmr_lik_pil4_total2 = $kpmr_lik_pil4_total2_sum / count($kpmr_lik_pil4_total2_average);

if ($kpmr_lik_pil4_total2 < 1.00) {
    $kpmr_lik_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_lik_pil4_total2 >= 1.00 && $kpmr_lik_pil4_total2 < 1.25) {
    $kpmr_lik_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_lik_pil4_total2 >= 1.25 && $kpmr_lik_pil4_total2 < 2.25) {
    $kpmr_lik_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_lik_pil4_total2 >= 2.25 && $kpmr_lik_pil4_total2 < 3.25) {
    $kpmr_lik_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_lik_pil4_total2 >= 3.25 && $kpmr_lik_pil4_total2 < 4.25) {
    $kpmr_lik_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_lik_pil4_total2 >= 4.25 && $kpmr_lik_pil4_total2 <= 5.00) {
    $kpmr_lik_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_lik_pil4_peringkat2 = "Belum Terisi";
}

        
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
$result_inheren_ops_pilar1_1  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_1','ket_inheren_operasional_pilar1','ket_in_op_pil1_1',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_2  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_2','ket_inheren_operasional_pilar1','ket_in_op_pil1_2',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_2a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_2a','ket_inheren_operasional_pilar1','ket_in_op_pil1_2a',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_2b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_2b','ket_inheren_operasional_pilar1','ket_in_op_pil1_2b',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_3  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_3','ket_inheren_operasional_pilar1','ket_in_op_pil1_3',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_3a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_3a','ket_inheren_operasional_pilar1','ket_in_op_pil1_3a',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_3b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_3b','ket_inheren_operasional_pilar1','ket_in_op_pil1_3b',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_3c = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_3c','ket_inheren_operasional_pilar1','ket_in_op_pil1_3c',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_4  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_4','ket_inheren_operasional_pilar1','ket_in_op_pil1_4',$tahun,$periode,1,5);
$result_inheren_ops_pilar1_4a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar1','pilar1_4a','ket_inheren_operasional_pilar1','ket_in_op_pil1_4a',$tahun,$periode,1,5);

$ops_pilar1_1  = $result_inheren_ops_pilar1_1['nilai'];  $ket_in_op_pil1_1  = $result_inheren_ops_pilar1_1['ket'];
$ops_pilar1_2  = $result_inheren_ops_pilar1_2['nilai'];  $ket_in_op_pil1_2  = $result_inheren_ops_pilar1_2['ket'];
$ops_pilar1_2a = $result_inheren_ops_pilar1_2a['nilai']; $ket_in_op_pil1_2a = $result_inheren_ops_pilar1_2a['ket'];
$ops_pilar1_2b = $result_inheren_ops_pilar1_2b['nilai']; $ket_in_op_pil1_2b = $result_inheren_ops_pilar1_2b['ket'];
$ops_pilar1_3  = $result_inheren_ops_pilar1_3['nilai'];  $ket_in_op_pil1_3  = $result_inheren_ops_pilar1_3['ket'];
$ops_pilar1_3a = $result_inheren_ops_pilar1_3a['nilai']; $ket_in_op_pil1_3a = $result_inheren_ops_pilar1_3a['ket'];
$ops_pilar1_3b = $result_inheren_ops_pilar1_3b['nilai']; $ket_in_op_pil1_3b = $result_inheren_ops_pilar1_3b['ket'];
$ops_pilar1_3c = $result_inheren_ops_pilar1_3c['nilai']; $ket_in_op_pil1_3c = $result_inheren_ops_pilar1_3c['ket'];
$ops_pilar1_4  = $result_inheren_ops_pilar1_4['nilai'];  $ket_in_op_pil1_4  = $result_inheren_ops_pilar1_4['ket'];
$ops_pilar1_4a = $result_inheren_ops_pilar1_4a['nilai']; $ket_in_op_pil1_4a = $result_inheren_ops_pilar1_4a['ket'];

// inheren_operasional_pilar2

$result_inheren_ops_pilar2_1  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1','ket_inheren_operasional_pilar2','ket_in_op_pil2_1',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1a','ket_inheren_operasional_pilar2','ket_in_op_pil2_1a',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1b','ket_inheren_operasional_pilar2','ket_in_op_pil2_1b',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1c = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1c','ket_inheren_operasional_pilar2','ket_in_op_pil2_1c',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1d = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1d','ket_inheren_operasional_pilar2','ket_in_op_pil2_1d',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1e = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1e','ket_inheren_operasional_pilar2','ket_in_op_pil2_1e',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1f = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1f','ket_inheren_operasional_pilar2','ket_in_op_pil2_1f',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1g = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1g','ket_inheren_operasional_pilar2','ket_in_op_pil2_1g',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1h = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1h','ket_inheren_operasional_pilar2','ket_in_op_pil2_1h',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1i = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1i','ket_inheren_operasional_pilar2','ket_in_op_pil2_1i',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1j = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1j','ket_inheren_operasional_pilar2','ket_in_op_pil2_1j',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1k = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1k','ket_inheren_operasional_pilar2','ket_in_op_pil2_1k',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1l = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1l','ket_inheren_operasional_pilar2','ket_in_op_pil2_1l',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1m = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1m','ket_inheren_operasional_pilar2','ket_in_op_pil2_1m',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_1n = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_1n','ket_inheren_operasional_pilar2','ket_in_op_pil2_1n',$tahun,$periode,1,5);
$result_inheren_ops_pilar2_2  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar2','pilar2_2','ket_inheren_operasional_pilar2','ket_in_op_pil2_2',$tahun,$periode,1,5);

$ops_pilar2_1  = $result_inheren_ops_pilar2_1['nilai'];   $ket_in_op_pil2_1  = $result_inheren_ops_pilar2_1['ket'];
$ops_pilar2_1a = $result_inheren_ops_pilar2_1a['nilai']; $ket_in_op_pil2_1a = $result_inheren_ops_pilar2_1a['ket'];
$ops_pilar2_1b = $result_inheren_ops_pilar2_1b['nilai']; $ket_in_op_pil2_1b = $result_inheren_ops_pilar2_1b['ket'];
$ops_pilar2_1c = $result_inheren_ops_pilar2_1c['nilai']; $ket_in_op_pil2_1c = $result_inheren_ops_pilar2_1c['ket'];
$ops_pilar2_1d = $result_inheren_ops_pilar2_1d['nilai']; $ket_in_op_pil2_1d = $result_inheren_ops_pilar2_1d['ket'];
$ops_pilar2_1e = $result_inheren_ops_pilar2_1e['nilai']; $ket_in_op_pil2_1e = $result_inheren_ops_pilar2_1e['ket'];
$ops_pilar2_1f = $result_inheren_ops_pilar2_1f['nilai']; $ket_in_op_pil2_1f = $result_inheren_ops_pilar2_1f['ket'];
$ops_pilar2_1g = $result_inheren_ops_pilar2_1g['nilai']; $ket_in_op_pil2_1g = $result_inheren_ops_pilar2_1g['ket'];
$ops_pilar2_1h = $result_inheren_ops_pilar2_1h['nilai']; $ket_in_op_pil2_1h = $result_inheren_ops_pilar2_1h['ket'];
$ops_pilar2_1i = $result_inheren_ops_pilar2_1i['nilai']; $ket_in_op_pil2_1i = $result_inheren_ops_pilar2_1i['ket'];
$ops_pilar2_1j = $result_inheren_ops_pilar2_1j['nilai']; $ket_in_op_pil2_1j = $result_inheren_ops_pilar2_1j['ket'];
$ops_pilar2_1k = $result_inheren_ops_pilar2_1k['nilai']; $ket_in_op_pil2_1k = $result_inheren_ops_pilar2_1k['ket'];
$ops_pilar2_1l = $result_inheren_ops_pilar2_1l['nilai']; $ket_in_op_pil2_1l = $result_inheren_ops_pilar2_1l['ket'];
$ops_pilar2_1m = $result_inheren_ops_pilar2_1m['nilai']; $ket_in_op_pil2_1m = $result_inheren_ops_pilar2_1m['ket'];
$ops_pilar2_1n = $result_inheren_ops_pilar2_1n['nilai']; $ket_in_op_pil2_1n = $result_inheren_ops_pilar2_1n['ket'];
$ops_pilar2_2  = $result_inheren_ops_pilar2_2['nilai'];  $ket_in_op_pil2_2  = $result_inheren_ops_pilar2_2['ket'];

    // inheren_operasional_pilar3
$result_inheren_ops_pilar3_1  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1','ket_inheren_operasional_pilar3','ket_in_op_pil3_1',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1a','ket_inheren_operasional_pilar3','ket_in_op_pil3_1a',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1b','ket_inheren_operasional_pilar3','ket_in_op_pil3_1b',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1c = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1c','ket_inheren_operasional_pilar3','ket_in_op_pil3_1c',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1d = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1d','ket_inheren_operasional_pilar3','ket_in_op_pil3_1d',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1e = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1e','ket_inheren_operasional_pilar3','ket_in_op_pil3_1e',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1f = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1f','ket_inheren_operasional_pilar3','ket_in_op_pil3_1f',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1g = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1g','ket_inheren_operasional_pilar3','ket_in_op_pil3_1g',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1h = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1h','ket_inheren_operasional_pilar3','ket_in_op_pil3_1h',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1i = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1i','ket_inheren_operasional_pilar3','ket_in_op_pil3_1i',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1j = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1j','ket_inheren_operasional_pilar3','ket_in_op_pil3_1j',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1k = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1k','ket_inheren_operasional_pilar3','ket_in_op_pil3_1k',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1l = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1l','ket_inheren_operasional_pilar3','ket_in_op_pil3_1l',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1m = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1m','ket_inheren_operasional_pilar3','ket_in_op_pil3_1m',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1n = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1n','ket_inheren_operasional_pilar3','ket_in_op_pil3_1n',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1o = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1o','ket_inheren_operasional_pilar3','ket_in_op_pil3_1o',$tahun,$periode,1,5);
$result_inheren_ops_pilar3_1p = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar3','pilar3_1p','ket_inheren_operasional_pilar3','ket_in_op_pil3_1p',$tahun,$periode,1,5);

$ops_pilar3_1  = $result_inheren_ops_pilar3_1['nilai'];   $ket_in_op_pil3_1  = $result_inheren_ops_pilar3_1['ket'];
$ops_pilar3_1a = $result_inheren_ops_pilar3_1a['nilai']; $ket_in_op_pil3_1a = $result_inheren_ops_pilar3_1a['ket'];
$ops_pilar3_1b = $result_inheren_ops_pilar3_1b['nilai']; $ket_in_op_pil3_1b = $result_inheren_ops_pilar3_1b['ket'];
$ops_pilar3_1c = $result_inheren_ops_pilar3_1c['nilai']; $ket_in_op_pil3_1c = $result_inheren_ops_pilar3_1c['ket'];
$ops_pilar3_1d = $result_inheren_ops_pilar3_1d['nilai']; $ket_in_op_pil3_1d = $result_inheren_ops_pilar3_1d['ket'];
$ops_pilar3_1e = $result_inheren_ops_pilar3_1e['nilai']; $ket_in_op_pil3_1e = $result_inheren_ops_pilar3_1e['ket'];
$ops_pilar3_1f = $result_inheren_ops_pilar3_1f['nilai']; $ket_in_op_pil3_1f = $result_inheren_ops_pilar3_1f['ket'];
$ops_pilar3_1g = $result_inheren_ops_pilar3_1g['nilai']; $ket_in_op_pil3_1g = $result_inheren_ops_pilar3_1g['ket'];
$ops_pilar3_1h = $result_inheren_ops_pilar3_1h['nilai']; $ket_in_op_pil3_1h = $result_inheren_ops_pilar3_1h['ket'];
$ops_pilar3_1i = $result_inheren_ops_pilar3_1i['nilai']; $ket_in_op_pil3_1i = $result_inheren_ops_pilar3_1i['ket'];
$ops_pilar3_1j = $result_inheren_ops_pilar3_1j['nilai']; $ket_in_op_pil3_1j = $result_inheren_ops_pilar3_1j['ket'];
$ops_pilar3_1k = $result_inheren_ops_pilar3_1k['nilai']; $ket_in_op_pil3_1k = $result_inheren_ops_pilar3_1k['ket'];
$ops_pilar3_1l = $result_inheren_ops_pilar3_1l['nilai']; $ket_in_op_pil3_1l = $result_inheren_ops_pilar3_1l['ket'];
$ops_pilar3_1m = $result_inheren_ops_pilar3_1m['nilai']; $ket_in_op_pil3_1m = $result_inheren_ops_pilar3_1m['ket'];
$ops_pilar3_1n = $result_inheren_ops_pilar3_1n['nilai']; $ket_in_op_pil3_1n = $result_inheren_ops_pilar3_1n['ket'];
$ops_pilar3_1o = $result_inheren_ops_pilar3_1o['nilai']; $ket_in_op_pil3_1o = $result_inheren_ops_pilar3_1o['ket'];
$ops_pilar3_1p = $result_inheren_ops_pilar3_1p['nilai']; $ket_in_op_pil3_1p = $result_inheren_ops_pilar3_1p['ket'];


    $kpmr_ops = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_operasional WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_ops_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_1a','respon_unit_kerja_operasional_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_1b','respon_unit_kerja_operasional_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_1c','respon_unit_kerja_operasional_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_1d','respon_unit_kerja_operasional_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_1e','respon_unit_kerja_operasional_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_2a','respon_unit_kerja_operasional_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_2b','respon_unit_kerja_operasional_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_2c','respon_unit_kerja_operasional_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_2d','respon_unit_kerja_operasional_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_2e','respon_unit_kerja_operasional_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_3a','respon_unit_kerja_operasional_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_3b','respon_unit_kerja_operasional_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_3c','respon_unit_kerja_operasional_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_4a','respon_unit_kerja_operasional_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_4b','respon_unit_kerja_operasional_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_4c','respon_unit_kerja_operasional_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_4d','respon_unit_kerja_operasional_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_4e','respon_unit_kerja_operasional_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_5a','respon_unit_kerja_operasional_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_5b','respon_unit_kerja_operasional_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_5c','respon_unit_kerja_operasional_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_5d','respon_unit_kerja_operasional_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_6a','respon_unit_kerja_operasional_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_6b','respon_unit_kerja_operasional_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar1','pilar1_6c','respon_unit_kerja_operasional_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    

    $result_kpmr_ops_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_1a','respon_unit_kerja_operasional_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_1b','respon_unit_kerja_operasional_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_1c','respon_unit_kerja_operasional_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_1d','respon_unit_kerja_operasional_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_1e','respon_unit_kerja_operasional_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_ops_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2a','respon_unit_kerja_operasional_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2b','respon_unit_kerja_operasional_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2c','respon_unit_kerja_operasional_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2d','respon_unit_kerja_operasional_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2e','respon_unit_kerja_operasional_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2f','respon_unit_kerja_operasional_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2g','respon_unit_kerja_operasional_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_2h','respon_unit_kerja_operasional_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_ops_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_3a','respon_unit_kerja_operasional_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_3b','respon_unit_kerja_operasional_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar2','pilar2_3c','respon_unit_kerja_operasional_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_ops_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1a','respon_unit_kerja_operasional_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1b','respon_unit_kerja_operasional_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1c','respon_unit_kerja_operasional_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1d','respon_unit_kerja_operasional_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1e','respon_unit_kerja_operasional_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1f','respon_unit_kerja_operasional_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1g','respon_unit_kerja_operasional_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1h','respon_unit_kerja_operasional_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1i','respon_unit_kerja_operasional_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_1j','respon_unit_kerja_operasional_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_ops_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_2a','respon_unit_kerja_operasional_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_2b','respon_unit_kerja_operasional_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_2c','respon_unit_kerja_operasional_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_2d','respon_unit_kerja_operasional_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_2e','respon_unit_kerja_operasional_pil3','respon_pil3_1e',$tahun,$periode,1,5);

    $result_kpmr_ops_pilar3_3a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_3a','respon_unit_kerja_operasional_pil3','respon_pil3_3a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_3b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_3b','respon_unit_kerja_operasional_pil3','respon_pil3_3b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_3c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_3c','respon_unit_kerja_operasional_pil3','respon_pil3_3c',$tahun,$periode,1,5);
    
    $result_kpmr_ops_pilar3_4a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_4a','respon_unit_kerja_operasional_pil3','respon_pil3_4a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_4b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_4b','respon_unit_kerja_operasional_pil3','respon_pil3_4b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar3_4c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar3','pilar3_4c','respon_unit_kerja_operasional_pil3','respon_pil3_4c',$tahun,$periode,1,5);
    

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
$result_inheren_ops_pilar4_1  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar4','pilar4_1','ket_inheren_operasional_pilar4','ket_in_op_pil4_1',$tahun,$periode,1,5);
$result_inheren_ops_pilar4_1a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar4','pilar4_1a','ket_inheren_operasional_pilar4','ket_in_op_pil4_1a',$tahun,$periode,1,5);
$result_inheren_ops_pilar4_1b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar4','pilar4_1b','ket_inheren_operasional_pilar4','ket_in_op_pil4_1b',$tahun,$periode,1,5);
$result_inheren_ops_pilar4_1c = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar4','pilar4_1c','ket_inheren_operasional_pilar4','ket_in_op_pil4_1c',$tahun,$periode,1,5);
$result_inheren_ops_pilar4_1d = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar4','pilar4_1d','ket_inheren_operasional_pilar4','ket_in_op_pil4_1d',$tahun,$periode,1,5);

$ops_pilar4_1  = $result_inheren_ops_pilar4_1['nilai'];   $ket_in_op_pil4_1  = $result_inheren_ops_pilar4_1['ket'];
$ops_pilar4_1a = $result_inheren_ops_pilar4_1a['nilai']; $ket_in_op_pil4_1a = $result_inheren_ops_pilar4_1a['ket'];
$ops_pilar4_1b = $result_inheren_ops_pilar4_1b['nilai']; $ket_in_op_pil4_1b = $result_inheren_ops_pilar4_1b['ket'];
$ops_pilar4_1c = $result_inheren_ops_pilar4_1c['nilai']; $ket_in_op_pil4_1c = $result_inheren_ops_pilar4_1c['ket'];
$ops_pilar4_1d = $result_inheren_ops_pilar4_1d['nilai']; $ket_in_op_pil4_1d = $result_inheren_ops_pilar4_1d['ket'];


  
    $result_kpmr_ops_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_1a','respon_unit_kerja_operasional_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_1b','respon_unit_kerja_operasional_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_1c','respon_unit_kerja_operasional_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_1d','respon_unit_kerja_operasional_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_1e','respon_unit_kerja_operasional_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_ops_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_2a','respon_unit_kerja_operasional_pil4','respon_pil4_2a',$tahun,$periode,1,5);
    $result_kpmr_ops_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_operasional_pilar4','pilar4_2b','respon_unit_kerja_operasional_pil4','respon_pil4_2b',$tahun,$periode,1,5);
   



$kpmr_ops_pilar4_1a = $result_kpmr_ops_pilar4_1a['nilai']; $kpmr_ops_respon_pil4_1a = $result_kpmr_ops_pilar4_1a['respon'];
$kpmr_ops_pilar4_1b = $result_kpmr_ops_pilar4_1b['nilai']; $kpmr_ops_respon_pil4_1b = $result_kpmr_ops_pilar4_1b['respon'];
$kpmr_ops_pilar4_1c = $result_kpmr_ops_pilar4_1c['nilai']; $kpmr_ops_respon_pil4_1c = $result_kpmr_ops_pilar4_1c['respon'];
$kpmr_ops_pilar4_1d = $result_kpmr_ops_pilar4_1d['nilai']; $kpmr_ops_respon_pil4_1d = $result_kpmr_ops_pilar4_1d['respon'];
$kpmr_ops_pilar4_1e = $result_kpmr_ops_pilar4_1e['nilai']; $kpmr_ops_respon_pil4_1e = $result_kpmr_ops_pilar4_1e['respon'];

$kpmr_ops_pilar4_2a = $result_kpmr_ops_pilar4_2a['nilai']; $kpmr_ops_respon_pil4_2a = $result_kpmr_ops_pilar4_2a['respon'];
$kpmr_ops_pilar4_2b = $result_kpmr_ops_pilar4_2b['nilai']; $kpmr_ops_respon_pil4_2b = $result_kpmr_ops_pilar4_2b['respon'];



// --- Pilar 3 Total 1 ---
$kpmr_ops_pil4_total1_average = array($kpmr_ops_pilar4_1a,
$kpmr_ops_pilar4_1b,
$kpmr_ops_pilar4_1c,
$kpmr_ops_pilar4_1d,
$kpmr_ops_pilar4_1e);
$kpmr_ops_pil4_total1_sum = array_sum($kpmr_ops_pil4_total1_average);
$kpmr_ops_pil4_total1 = $kpmr_ops_pil4_total1_sum / count($kpmr_ops_pil4_total1_average);

if ($kpmr_ops_pil4_total1 < 1.00) {
    $kpmr_ops_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_ops_pil4_total1 >= 1.00 && $kpmr_ops_pil4_total1 < 1.25) {
    $kpmr_ops_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_ops_pil4_total1 >= 1.25 && $kpmr_ops_pil4_total1 < 2.25) {
    $kpmr_ops_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_ops_pil4_total1 >= 2.25 && $kpmr_ops_pil4_total1 < 3.25) {
    $kpmr_ops_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_ops_pil4_total1 >= 3.25 && $kpmr_ops_pil4_total1 < 4.25) {
    $kpmr_ops_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_ops_pil4_total1 >= 4.25 && $kpmr_ops_pil4_total1 <= 5.00) {
    $kpmr_ops_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_ops_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_ops_pilar4_1a = $result_kpmr_ops_pilar4_1a['nilai']; $kpmr_ops_respon_pil4_1a = $result_kpmr_ops_pilar4_1a['respon'];
$kpmr_ops_pilar4_1b = $result_kpmr_ops_pilar4_1b['nilai']; $kpmr_ops_respon_pil4_1b = $result_kpmr_ops_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_ops_pil4_total2_average = array($kpmr_ops_pilar4_1a,
$kpmr_ops_pilar4_1b);
$kpmr_ops_pil4_total2_sum = array_sum($kpmr_ops_pil4_total2_average);
$kpmr_ops_pil4_total2 = $kpmr_ops_pil4_total2_sum / count($kpmr_ops_pil4_total2_average);

if ($kpmr_ops_pil4_total2 < 1.00) {
    $kpmr_ops_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_ops_pil4_total2 >= 1.00 && $kpmr_ops_pil4_total2 < 1.25) {
    $kpmr_ops_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_ops_pil4_total2 >= 1.25 && $kpmr_ops_pil4_total2 < 2.25) {
    $kpmr_ops_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_ops_pil4_total2 >= 2.25 && $kpmr_ops_pil4_total2 < 3.25) {
    $kpmr_ops_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_ops_pil4_total2 >= 3.25 && $kpmr_ops_pil4_total2 < 4.25) {
    $kpmr_ops_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_ops_pil4_total2 >= 4.25 && $kpmr_ops_pil4_total2 <= 5.00) {
    $kpmr_ops_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_ops_pil4_peringkat2 = "Belum Terisi";
}


    // inheren_operasional_pilar5
$result_inheren_ops_pilar5_1  = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1','ket_inheren_operasional_pilar5','ket_in_op_pil5_1',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1a = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1a','ket_inheren_operasional_pilar5','ket_in_op_pil5_1a',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1b = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1b','ket_inheren_operasional_pilar5','ket_in_op_pil5_1b',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1c = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1c','ket_inheren_operasional_pilar5','ket_in_op_pil5_1c',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1d = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1d','ket_inheren_operasional_pilar5','ket_in_op_pil5_1d',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1e = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1e','ket_inheren_operasional_pilar5','ket_in_op_pil5_1e',$tahun,$periode,1,5);
$result_inheren_ops_pilar5_1f = getMaxInherenWithKetUser($conn,'inheren_operasional_pilar5','pilar5_1f','ket_inheren_operasional_pilar5','ket_in_op_pil5_1f',$tahun,$periode,1,5);

$ops_pilar5_1  = $result_inheren_ops_pilar5_1['nilai'];   $ket_in_op_pil5_1  = $result_inheren_ops_pilar5_1['ket'];
$ops_pilar5_1a = $result_inheren_ops_pilar5_1a['nilai']; $ket_in_op_pil5_1a = $result_inheren_ops_pilar5_1a['ket'];
$ops_pilar5_1b = $result_inheren_ops_pilar5_1b['nilai']; $ket_in_op_pil5_1b = $result_inheren_ops_pilar5_1b['ket'];
$ops_pilar5_1c = $result_inheren_ops_pilar5_1c['nilai']; $ket_in_op_pil5_1c = $result_inheren_ops_pilar5_1c['ket'];
$ops_pilar5_1d = $result_inheren_ops_pilar5_1d['nilai']; $ket_in_op_pil5_1d = $result_inheren_ops_pilar5_1d['ket'];
$ops_pilar5_1e = $result_inheren_ops_pilar5_1e['nilai']; $ket_in_op_pil5_1e = $result_inheren_ops_pilar5_1e['ket'];
$ops_pilar5_1f = $result_inheren_ops_pilar5_1f['nilai']; $ket_in_op_pil5_1f = $result_inheren_ops_pilar5_1f['ket'];


    // inheren_operasional_lainnya (pilar6)
$result_inheren_ops_pilar6_1a = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1a','ket_inheren_operasional_lainnya','ket_in_op_pil6_1a',$tahun,$periode,1,5);
$result_inheren_ops_pilar6_1b = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1b','ket_inheren_operasional_lainnya','ket_in_op_pil6_1b',$tahun,$periode,1,5);
$result_inheren_ops_pilar6_1c = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1c','ket_inheren_operasional_lainnya','ket_in_op_pil6_1c',$tahun,$periode,1,5);
$result_inheren_ops_pilar6_1d = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1d','ket_inheren_operasional_lainnya','ket_in_op_pil6_1d',$tahun,$periode,1,5);
$result_inheren_ops_pilar6_1e = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1e','ket_inheren_operasional_lainnya','ket_in_op_pil6_1e',$tahun,$periode,1,5);
$result_inheren_ops_pilar6_1f = getMaxInherenWithKetUser($conn,'inheren_operasional_lainnya','pilar6_1f','ket_inheren_operasional_lainnya','ket_in_op_pil6_1f',$tahun,$periode,1,5);

$ops_pilar6_1a = $result_inheren_ops_pilar6_1a['nilai']; $ket_in_op_pil6_1a = $result_inheren_ops_pilar6_1a['ket'];
$ops_pilar6_1b = $result_inheren_ops_pilar6_1b['nilai']; $ket_in_op_pil6_1b = $result_inheren_ops_pilar6_1b['ket'];
$ops_pilar6_1c = $result_inheren_ops_pilar6_1c['nilai']; $ket_in_op_pil6_1c = $result_inheren_ops_pilar6_1c['ket'];
$ops_pilar6_1d = $result_inheren_ops_pilar6_1d['nilai']; $ket_in_op_pil6_1d = $result_inheren_ops_pilar6_1d['ket'];
$ops_pilar6_1e = $result_inheren_ops_pilar6_1e['nilai']; $ket_in_op_pil6_1e = $result_inheren_ops_pilar6_1e['ket'];
$ops_pilar6_1f = $result_inheren_ops_pilar6_1f['nilai']; $ket_in_op_pil6_1f = $result_inheren_ops_pilar6_1f['ket'];



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

    
    //inheren kepatuhan pilar 1
$result_inheren_kep_pilar1_1  = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1a','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1a',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1b = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1b','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1b',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1c = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1c','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1c',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1d = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1d','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1d',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1e = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1e','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1e',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1f = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1f','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1f',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_1g = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_1g','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_1g',$tahun,$periode,1,5);

$kepatuhan_pilar1_1 = $result_inheren_kep_pilar1_1['nilai']; $ket_in_kep_pil1_1    = $result_inheren_kep_pilar1_1['ket'];
$kepatuhan_pilar1_1a = $result_inheren_kep_pilar1_1a['nilai']; $ket_in_kep_pil1_1a    = $result_inheren_kep_pilar1_1a['ket'];
$kepatuhan_pilar1_1b = $result_inheren_kep_pilar1_1b['nilai']; $ket_in_kep_pil1_1b    = $result_inheren_kep_pilar1_1b['ket'];
$kepatuhan_pilar1_1c = $result_inheren_kep_pilar1_1c['nilai']; $ket_in_kep_pil1_1c    = $result_inheren_kep_pilar1_1c['ket'];
$kepatuhan_pilar1_1d = $result_inheren_kep_pilar1_1d['nilai']; $ket_in_kep_pil1_1d    = $result_inheren_kep_pilar1_1d['ket'];
$kepatuhan_pilar1_1e = $result_inheren_kep_pilar1_1e['nilai']; $ket_in_kep_pil1_1e    = $result_inheren_kep_pilar1_1e['ket'];
$kepatuhan_pilar1_1f = $result_inheren_kep_pilar1_1f['nilai']; $ket_in_kep_pil1_1f    = $result_inheren_kep_pilar1_1f['ket'];
$kepatuhan_pilar1_1g = $result_inheren_kep_pilar1_1g['nilai']; $ket_in_kep_pil1_1g    = $result_inheren_kep_pilar1_1g['ket'];
$kepatuhan_pilar1_1h = $result_inheren_kep_pilar1_1h['nilai']; $ket_in_kep_pil1_1h    = $result_inheren_kep_pilar1_1h['ket'];


$result_inheren_kep_pilar1_2 = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2',$tahun,$periode,1,5);

$result_inheren_kep_pilar1_2a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2a','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2a',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2b = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2b','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2b',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2c = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2c','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2c',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2d = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2d','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2d',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2e = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2e','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2e',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2f = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2f','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2f',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2g = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2g','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2g',$tahun,$periode,1,5);
$result_inheren_kep_pilar1_2h = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar1','pilar1_2h','ket_inheren_kepatuhan_pilar1','ket_in_kep_pil1_2h',$tahun,$periode,1,5);


$kepatuhan_pilar1_2 = $result_inheren_kep_pilar1_2['nilai']; $ket_in_kep_pil1_2    = $result_inheren_kep_pilar1_2['ket'];
$kepatuhan_pilar1_2a = $result_inheren_kep_pilar1_2a['nilai']; $ket_in_kep_pil1_2a    = $result_inheren_kep_pilar1_2a['ket'];
$kepatuhan_pilar1_2b = $result_inheren_kep_pilar1_2b['nilai']; $ket_in_kep_pil1_2b    = $result_inheren_kep_pilar1_2b['ket'];
$kepatuhan_pilar1_2c = $result_inheren_kep_pilar1_2c['nilai']; $ket_in_kep_pil1_2c    = $result_inheren_kep_pilar1_2c['ket'];
$kepatuhan_pilar1_2d = $result_inheren_kep_pilar1_2d['nilai']; $ket_in_kep_pil1_2d    = $result_inheren_kep_pilar1_2d['ket'];
$kepatuhan_pilar1_2e = $result_inheren_kep_pilar1_2e['nilai']; $ket_in_kep_pil1_2e    = $result_inheren_kep_pilar1_2e['ket'];
$kepatuhan_pilar1_2f = $result_inheren_kep_pilar1_2f['nilai']; $ket_in_kep_pil1_2f    = $result_inheren_kep_pilar1_2f['ket'];
$kepatuhan_pilar1_2g = $result_inheren_kep_pilar1_2g['nilai']; $ket_in_kep_pil1_2g    = $result_inheren_kep_pilar1_2g['ket'];
$kepatuhan_pilar1_2h = $result_inheren_kep_pilar1_2h['nilai']; $ket_in_kep_pil1_2h    = $result_inheren_kep_pilar1_2h['ket'];



    //inheren kepatuhan pilar 2
$result_inheren_kep_pilar2_1  = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_1','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_1',$tahun,$periode,1,5);
$result_inheren_kep_pilar2_1a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_1a','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_1a',$tahun,$periode,1,5);
$result_inheren_kep_pilar2_2  = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_2','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_2',$tahun,$periode,1,5);
$result_inheren_kep_pilar2_2a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_2a','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_2a',$tahun,$periode,1,5);
$result_inheren_kep_pilar2_3  = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_3','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_3',$tahun,$periode,1,5);
$result_inheren_kep_pilar2_3a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_pilar2','pilar2_3a','ket_inheren_kepatuhan_pilar2','ket_in_kep_pil2_3a',$tahun,$periode,1,5);

$kepatuhan_pilar2_1  = $result_inheren_kep_pilar2_1['nilai'];   $ket_in_kep_pil2_1  = $result_inheren_kep_pilar2_1['ket'];
$kepatuhan_pilar2_1a = $result_inheren_kep_pilar2_1a['nilai']; $ket_in_kep_pil2_1a = $result_inheren_kep_pilar2_1a['ket'];
$kepatuhan_pilar2_2  = $result_inheren_kep_pilar2_2['nilai'];   $ket_in_kep_pil2_2  = $result_inheren_kep_pilar2_2['ket'];
$kepatuhan_pilar2_2a = $result_inheren_kep_pilar2_2a['nilai']; $ket_in_kep_pil2_2a = $result_inheren_kep_pilar2_2a['ket'];
$kepatuhan_pilar2_3  = $result_inheren_kep_pilar2_3['nilai'];   $ket_in_kep_pil2_3  = $result_inheren_kep_pilar2_3['ket'];
$kepatuhan_pilar2_3a = $result_inheren_kep_pilar2_3a['nilai']; $ket_in_kep_pil2_3a = $result_inheren_kep_pilar2_3a['ket'];

    
    

    //inheren kepatuhan pilar 3
$result_inheren_kep_pilar3_1a = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1a','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1a',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1b = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1b','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1b',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1c = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1c','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1c',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1d = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1d','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1d',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1e = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1e','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1e',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1f = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1f','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1f',$tahun,$periode,1,5);
$result_inheren_kep_pilar3_1g = getMaxInherenWithKetUser($conn,'inheren_kepatuhan_lainnya','pilar3_1g','ket_inheren_kepatuhan_lainnya','ket_in_kep_pil3_1g',$tahun,$periode,1,5);

$kepatuhan_pilar3_1a = $result_inheren_kep_pilar3_1a['nilai']; $ket_in_kep_pil3_1a = $result_inheren_kep_pilar3_1a['ket'];
$kepatuhan_pilar3_1b = $result_inheren_kep_pilar3_1b['nilai']; $ket_in_kep_pil3_1b = $result_inheren_kep_pilar3_1b['ket'];
$kepatuhan_pilar3_1c = $result_inheren_kep_pilar3_1c['nilai']; $ket_in_kep_pil3_1c = $result_inheren_kep_pilar3_1c['ket'];
$kepatuhan_pilar3_1d = $result_inheren_kep_pilar3_1d['nilai']; $ket_in_kep_pil3_1d = $result_inheren_kep_pilar3_1d['ket'];
$kepatuhan_pilar3_1e = $result_inheren_kep_pilar3_1e['nilai']; $ket_in_kep_pil3_1e = $result_inheren_kep_pilar3_1e['ket'];
$kepatuhan_pilar3_1f = $result_inheren_kep_pilar3_1f['nilai']; $ket_in_kep_pil3_1f = $result_inheren_kep_pilar3_1f['ket'];
$kepatuhan_pilar3_1g = $result_inheren_kep_pilar3_1g['nilai']; $ket_in_kep_pil3_1g = $result_inheren_kep_pilar3_1g['ket'];


    $kpmr_kep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_kepatuhan WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_kep_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_1a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_1b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_1c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_1d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_1e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_2a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_2b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_2c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_2d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_2e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_3a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_3b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_3c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_4a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_4b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_4c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_4d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_4e','respon_unit_kerja_kepatuhan_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_5a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_5b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_5c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_5d','respon_unit_kerja_kepatuhan_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_6a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_6b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_6c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    
    $result_kpmr_kep_pilar1_7a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_7a','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_7b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_7b','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar1_7c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar1','pilar1_7c','respon_unit_kerja_kepatuhan_pil1','respon_pil1_7c',$tahun,$periode,1,5);
    

    $result_kpmr_kep_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_1a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_1b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_1c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_1d','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_1e','respon_unit_kerja_kepatuhan_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_kep_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2d','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2e','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2f','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2g','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_2h','respon_unit_kerja_kepatuhan_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_kep_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_3a','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_3b','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar2','pilar2_3c','respon_unit_kerja_kepatuhan_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_kep_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1a','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1b','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1c','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1d','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1e','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1f','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1g','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1h','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1i','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_1j','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_kep_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_2a','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_2b','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_2c','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_2d','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar3','pilar3_2e','respon_unit_kerja_kepatuhan_pil3','respon_pil3_1e',$tahun,$periode,1,5);



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

        $result_kpmr_kep_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_1a','respon_unit_kerja_kepatuhan_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_1b','respon_unit_kerja_kepatuhan_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_1c','respon_unit_kerja_kepatuhan_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_1d','respon_unit_kerja_kepatuhan_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_1e','respon_unit_kerja_kepatuhan_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_kep_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_2a','respon_unit_kerja_kepatuhan_pil4','respon_pil4_2a',$tahun,$periode,1,5);
    $result_kpmr_kep_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_kepatuhan_pilar4','pilar4_2b','respon_unit_kerja_kepatuhan_pil4','respon_pil4_2b',$tahun,$periode,1,5);
   



$kpmr_kep_pilar4_1a = $result_kpmr_kep_pilar4_1a['nilai']; $kpmr_kep_respon_pil4_1a = $result_kpmr_kep_pilar4_1a['respon'];
$kpmr_kep_pilar4_1b = $result_kpmr_kep_pilar4_1b['nilai']; $kpmr_kep_respon_pil4_1b = $result_kpmr_kep_pilar4_1b['respon'];
$kpmr_kep_pilar4_1c = $result_kpmr_kep_pilar4_1c['nilai']; $kpmr_kep_respon_pil4_1c = $result_kpmr_kep_pilar4_1c['respon'];
$kpmr_kep_pilar4_1d = $result_kpmr_kep_pilar4_1d['nilai']; $kpmr_kep_respon_pil4_1d = $result_kpmr_kep_pilar4_1d['respon'];
$kpmr_kep_pilar4_1e = $result_kpmr_kep_pilar4_1e['nilai']; $kpmr_kep_respon_pil4_1e = $result_kpmr_kep_pilar4_1e['respon'];

$kpmr_kep_pilar4_2a = $result_kpmr_kep_pilar4_2a['nilai']; $kpmr_kep_respon_pil4_2a = $result_kpmr_kep_pilar4_2a['respon'];
$kpmr_kep_pilar4_2b = $result_kpmr_kep_pilar4_2b['nilai']; $kpmr_kep_respon_pil4_2b = $result_kpmr_kep_pilar4_2b['respon'];


// --- Pilar 3 Total 1 ---
$kpmr_kep_pil4_total1_average = array($kpmr_kep_pilar4_1a,
$kpmr_kep_pilar4_1b,
$kpmr_kep_pilar4_1c,
$kpmr_kep_pilar4_1d,
$kpmr_kep_pilar4_1e);
$kpmr_kep_pil4_total1_sum = array_sum($kpmr_kep_pil4_total1_average);
$kpmr_kep_pil4_total1 = $kpmr_kep_pil4_total1_sum / count($kpmr_kep_pil4_total1_average);

if ($kpmr_kep_pil4_total1 < 1.00) {
    $kpmr_kep_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_kep_pil4_total1 >= 1.00 && $kpmr_kep_pil4_total1 < 1.25) {
    $kpmr_kep_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_kep_pil4_total1 >= 1.25 && $kpmr_kep_pil4_total1 < 2.25) {
    $kpmr_kep_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_kep_pil4_total1 >= 2.25 && $kpmr_kep_pil4_total1 < 3.25) {
    $kpmr_kep_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_kep_pil4_total1 >= 3.25 && $kpmr_kep_pil4_total1 < 4.25) {
    $kpmr_kep_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_kep_pil4_total1 >= 4.25 && $kpmr_kep_pil4_total1 <= 5.00) {
    $kpmr_kep_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_kep_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_kep_pilar4_1a = $result_kpmr_kep_pilar4_1a['nilai']; $kpmr_kep_respon_pil4_1a = $result_kpmr_kep_pilar4_1a['respon'];
$kpmr_kep_pilar4_1b = $result_kpmr_kep_pilar4_1b['nilai']; $kpmr_kep_respon_pil4_1b = $result_kpmr_kep_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_kep_pil4_total2_average = array($kpmr_kep_pilar4_1a,
$kpmr_kep_pilar4_1b);
$kpmr_kep_pil4_total2_sum = array_sum($kpmr_kep_pil4_total2_average);
$kpmr_kep_pil4_total2 = $kpmr_kep_pil4_total2_sum / count($kpmr_kep_pil4_total2_average);

if ($kpmr_kep_pil4_total2 < 1.00) {
    $kpmr_kep_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_kep_pil4_total2 >= 1.00 && $kpmr_kep_pil4_total2 < 1.25) {
    $kpmr_kep_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_kep_pil4_total2 >= 1.25 && $kpmr_kep_pil4_total2 < 2.25) {
    $kpmr_kep_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_kep_pil4_total2 >= 2.25 && $kpmr_kep_pil4_total2 < 3.25) {
    $kpmr_kep_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_kep_pil4_total2 >= 3.25 && $kpmr_kep_pil4_total2 < 4.25) {
    $kpmr_kep_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_kep_pil4_total2 >= 4.25 && $kpmr_kep_pil4_total2 <= 5.00) {
    $kpmr_kep_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_kep_pil4_peringkat2 = "Belum Terisi";
}


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
$result_inheren_rep_pilar1_1  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_1','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_1',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_1a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_1a','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_1a',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_1b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_1b','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_1b',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_1c = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_1c','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_1c',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_1d = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_1d','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_1d',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_2  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_2','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_2',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_2a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_2a','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_2a',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_2b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_2b','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_2b',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_2c = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_2c','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_2c',$tahun,$periode,1,5);
$result_inheren_rep_pilar1_2d = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar1','pilar1_2d','ket_inheren_reputasi_pilar1','ket_in_rep_pil1_2d',$tahun,$periode,1,5);

$inheren_rep_pilar1_1  = $result_inheren_rep_pilar1_1['nilai'];   $ket_in_rep_pil1_1  = $result_inheren_rep_pilar1_1['ket'];
$inheren_rep_pilar1_1a = $result_inheren_rep_pilar1_1a['nilai']; $ket_in_rep_pil1_1a = $result_inheren_rep_pilar1_1a['ket'];
$inheren_rep_pilar1_1b = $result_inheren_rep_pilar1_1b['nilai']; $ket_in_rep_pil1_1b = $result_inheren_rep_pilar1_1b['ket'];
$inheren_rep_pilar1_1c = $result_inheren_rep_pilar1_1c['nilai']; $ket_in_rep_pil1_1c = $result_inheren_rep_pilar1_1c['ket'];
$inheren_rep_pilar1_1d = $result_inheren_rep_pilar1_1d['nilai']; $ket_in_rep_pil1_1d = $result_inheren_rep_pilar1_1d['ket'];
$inheren_rep_pilar1_2  = $result_inheren_rep_pilar1_2['nilai'];   $ket_in_rep_pil1_2  = $result_inheren_rep_pilar1_2['ket'];
$inheren_rep_pilar1_2a = $result_inheren_rep_pilar1_2a['nilai']; $ket_in_rep_pil1_2a = $result_inheren_rep_pilar1_2a['ket'];
$inheren_rep_pilar1_2b = $result_inheren_rep_pilar1_2b['nilai']; $ket_in_rep_pil1_2b = $result_inheren_rep_pilar1_2b['ket'];
$inheren_rep_pilar1_2c = $result_inheren_rep_pilar1_2c['nilai']; $ket_in_rep_pil1_2c = $result_inheren_rep_pilar1_2c['ket'];
$inheren_rep_pilar1_2d = $result_inheren_rep_pilar1_2d['nilai']; $ket_in_rep_pil1_2d = $result_inheren_rep_pilar1_2d['ket'];


    
    //inheren reputasi 2
$result_inheren_rep_pilar2_1  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_1','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_1',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_1a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_1a','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_1a',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_1b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_1b','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_1b',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_1c = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_1c','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_1c',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_1d = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_1d','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_1d',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_2  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_2','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_2',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_2a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_2a','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_2a',$tahun,$periode,1,5);
$result_inheren_rep_pilar2_2b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar2','pilar2_2b','ket_inheren_reputasi_pilar2','ket_in_rep_pil2_2b',$tahun,$periode,1,5);

$inheren_rep_pilar2_1  = $result_inheren_rep_pilar2_1['nilai'];   $ket_in_rep_pil2_1  = $result_inheren_rep_pilar2_1['ket'];
$inheren_rep_pilar2_1a = $result_inheren_rep_pilar2_1a['nilai']; $ket_in_rep_pil2_1a = $result_inheren_rep_pilar2_1a['ket'];
$inheren_rep_pilar2_1b = $result_inheren_rep_pilar2_1b['nilai']; $ket_in_rep_pil2_1b = $result_inheren_rep_pilar2_1b['ket'];
$inheren_rep_pilar2_1c = $result_inheren_rep_pilar2_1c['nilai']; $ket_in_rep_pil2_1c = $result_inheren_rep_pilar2_1c['ket'];
$inheren_rep_pilar2_1d = $result_inheren_rep_pilar2_1d['nilai']; $ket_in_rep_pil2_1d = $result_inheren_rep_pilar2_1d['ket'];
$inheren_rep_pilar2_2  = $result_inheren_rep_pilar2_2['nilai'];   $ket_in_rep_pil2_2  = $result_inheren_rep_pilar2_2['ket'];
$inheren_rep_pilar2_2a = $result_inheren_rep_pilar2_2a['nilai']; $ket_in_rep_pil2_2a = $result_inheren_rep_pilar2_2a['ket'];
$inheren_rep_pilar2_2b = $result_inheren_rep_pilar2_2b['nilai']; $ket_in_rep_pil2_2b = $result_inheren_rep_pilar2_2b['ket'];





    //inheren reputasi 3
$result_inheren_rep_pilar3_1  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_1','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_1',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_1a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_1a','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_1a',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_1b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_1b','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_1b',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_1c = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_1c','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_1c',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_2  = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_2','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_2',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_2a = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_2a','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_2a',$tahun,$periode,1,5);
$result_inheren_rep_pilar3_2b = getMaxInherenWithKetUser($conn,'inheren_reputasi_pilar3','pilar3_2b','ket_inheren_reputasi_pilar3','ket_in_rep_pil3_2b',$tahun,$periode,1,5);

$inheren_rep_pilar3_1  = $result_inheren_rep_pilar3_1['nilai'];  $ket_in_rep_pil3_1  = $result_inheren_rep_pilar3_1['ket'];
$inheren_rep_pilar3_1a = $result_inheren_rep_pilar3_1a['nilai']; $ket_in_rep_pil3_1a = $result_inheren_rep_pilar3_1a['ket'];
$inheren_rep_pilar3_1b = $result_inheren_rep_pilar3_1b['nilai']; $ket_in_rep_pil3_1b = $result_inheren_rep_pilar3_1b['ket'];
$inheren_rep_pilar3_1c = $result_inheren_rep_pilar3_1c['nilai']; $ket_in_rep_pil3_1c = $result_inheren_rep_pilar3_1c['ket'];
$inheren_rep_pilar3_2  = $result_inheren_rep_pilar3_2['nilai'];   $ket_in_rep_pil3_2  = $result_inheren_rep_pilar3_2['ket'];
$inheren_rep_pilar3_2a = $result_inheren_rep_pilar3_2a['nilai']; $ket_in_rep_pil3_2a = $result_inheren_rep_pilar3_2a['ket'];
$inheren_rep_pilar3_2b = $result_inheren_rep_pilar3_2b['nilai']; $ket_in_rep_pil3_2b = $result_inheren_rep_pilar3_2b['ket'];

$result_inheren_rep_pilar4_1a = getMaxInherenWithKetUser($conn,'inheren_reputasi_lainnya','pilar4_1a','ket_inheren_reputasi_lainnya','ket_in_rep_pil4_1a',$tahun,$periode,1,5);
$result_inheren_rep_pilar4_1b = getMaxInherenWithKetUser($conn,'inheren_reputasi_lainnya','pilar4_1b','ket_inheren_reputasi_lainnya','ket_in_rep_pil4_1b',$tahun,$periode,1,5);
$result_inheren_rep_pilar4_1c = getMaxInherenWithKetUser($conn,'inheren_reputasi_lainnya','pilar4_1c','ket_inheren_reputasi_lainnya','ket_in_rep_pil4_1c',$tahun,$periode,1,5);

$inheren_rep_pilar4_1a = $result_inheren_rep_pilar4_1a['nilai']; $ket_in_rep_pil4_1a = $result_inheren_rep_pilar4_1a['ket'];
$inheren_rep_pilar4_1b = $result_inheren_rep_pilar4_1b['nilai']; $ket_in_rep_pil4_1b = $result_inheren_rep_pilar4_1b['ket'];
$inheren_rep_pilar4_1c = $result_inheren_rep_pilar4_1c['nilai']; $ket_in_rep_pil4_1c = $result_inheren_rep_pilar4_1c['ket'];


    $kpmr_rep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_reputasi WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_rep_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_1a','respon_unit_kerja_reputasi_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_1b','respon_unit_kerja_reputasi_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_1c','respon_unit_kerja_reputasi_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_1d','respon_unit_kerja_reputasi_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_1e','respon_unit_kerja_reputasi_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_rep_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_2a','respon_unit_kerja_reputasi_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_2b','respon_unit_kerja_reputasi_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_2c','respon_unit_kerja_reputasi_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_2d','respon_unit_kerja_reputasi_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_2e','respon_unit_kerja_reputasi_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_rep_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_3a','respon_unit_kerja_reputasi_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_3b','respon_unit_kerja_reputasi_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_3c','respon_unit_kerja_reputasi_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_rep_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_4a','respon_unit_kerja_reputasi_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_4b','respon_unit_kerja_reputasi_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_4c','respon_unit_kerja_reputasi_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_4d','respon_unit_kerja_reputasi_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_4e','respon_unit_kerja_reputasi_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_rep_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_5a','respon_unit_kerja_reputasi_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_5b','respon_unit_kerja_reputasi_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_5c','respon_unit_kerja_reputasi_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_5d','respon_unit_kerja_reputasi_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_rep_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_6a','respon_unit_kerja_reputasi_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_6b','respon_unit_kerja_reputasi_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar1','pilar1_6c','respon_unit_kerja_reputasi_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    

    $result_kpmr_rep_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_1a','respon_unit_kerja_reputasi_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_1b','respon_unit_kerja_reputasi_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_1c','respon_unit_kerja_reputasi_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_1d','respon_unit_kerja_reputasi_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_1e','respon_unit_kerja_reputasi_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_rep_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2a','respon_unit_kerja_reputasi_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2b','respon_unit_kerja_reputasi_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2c','respon_unit_kerja_reputasi_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2d','respon_unit_kerja_reputasi_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2e','respon_unit_kerja_reputasi_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2f','respon_unit_kerja_reputasi_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2g','respon_unit_kerja_reputasi_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_2h','respon_unit_kerja_reputasi_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_rep_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_3a','respon_unit_kerja_reputasi_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_3b','respon_unit_kerja_reputasi_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar2','pilar2_3c','respon_unit_kerja_reputasi_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_rep_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1a','respon_unit_kerja_reputasi_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1b','respon_unit_kerja_reputasi_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1c','respon_unit_kerja_reputasi_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1d','respon_unit_kerja_reputasi_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1e','respon_unit_kerja_reputasi_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1f','respon_unit_kerja_reputasi_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1g','respon_unit_kerja_reputasi_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1h','respon_unit_kerja_reputasi_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1i','respon_unit_kerja_reputasi_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_1j','respon_unit_kerja_reputasi_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_rep_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_2a','respon_unit_kerja_reputasi_pil3','respon_pil3_2a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_2b','respon_unit_kerja_reputasi_pil3','respon_pil3_2b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_2c','respon_unit_kerja_reputasi_pil3','respon_pil3_2c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_2d','respon_unit_kerja_reputasi_pil3','respon_pil3_2d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar3','pilar3_2e','respon_unit_kerja_reputasi_pil3','respon_pil3_2e',$tahun,$periode,1,5);

    $result_kpmr_rep_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_reputasi_lainnya','pilar4_1a','respon_unit_kerja_reputasi_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_reputasi_lainnya','pilar4_1b','respon_unit_kerja_reputasi_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_reputasi_lainnya','pilar4_1c','respon_unit_kerja_reputasi_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    

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
   $result_kpmr_rep_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_1a','respon_unit_kerja_reputasi_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_1b','respon_unit_kerja_reputasi_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_1c','respon_unit_kerja_reputasi_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_1d','respon_unit_kerja_reputasi_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_1e','respon_unit_kerja_reputasi_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_rep_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_2a','respon_unit_kerja_reputasi_pil4','respon_pil4_2a',$tahun,$periode,1,5);
    $result_kpmr_rep_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_reputasi_pilar4','pilar4_2b','respon_unit_kerja_reputasi_pil4','respon_pil4_2b',$tahun,$periode,1,5);
   



$kpmr_rep_pilar4_1a = $result_kpmr_rep_pilar4_1a['nilai']; $kpmr_rep_respon_pil4_1a = $result_kpmr_rep_pilar4_1a['respon'];
$kpmr_rep_pilar4_1b = $result_kpmr_rep_pilar4_1b['nilai']; $kpmr_rep_respon_pil4_1b = $result_kpmr_rep_pilar4_1b['respon'];
$kpmr_rep_pilar4_1c = $result_kpmr_rep_pilar4_1c['nilai']; $kpmr_rep_respon_pil4_1c = $result_kpmr_rep_pilar4_1c['respon'];
$kpmr_rep_pilar4_1d = $result_kpmr_rep_pilar4_1d['nilai']; $kpmr_rep_respon_pil4_1d = $result_kpmr_rep_pilar4_1d['respon'];
$kpmr_rep_pilar4_1e = $result_kpmr_rep_pilar4_1e['nilai']; $kpmr_rep_respon_pil4_1e = $result_kpmr_rep_pilar4_1e['respon'];

$kpmr_rep_pilar4_2a = $result_kpmr_rep_pilar4_2a['nilai']; $kpmr_rep_respon_pil4_2a = $result_kpmr_rep_pilar4_2a['respon'];
$kpmr_rep_pilar4_2b = $result_kpmr_rep_pilar4_2b['nilai']; $kpmr_rep_respon_pil4_2b = $result_kpmr_rep_pilar4_2b['respon'];



// --- Pilar 3 Total 1 ---
$kpmr_rep_pil4_total1_average = array($kpmr_rep_pilar4_1a,
$kpmr_rep_pilar4_1b,
$kpmr_rep_pilar4_1c,
$kpmr_rep_pilar4_1d,
$kpmr_rep_pilar4_1e);
$kpmr_rep_pil4_total1_sum = array_sum($kpmr_rep_pil4_total1_average);
$kpmr_rep_pil4_total1 = $kpmr_rep_pil4_total1_sum / count($kpmr_rep_pil4_total1_average);

if ($kpmr_rep_pil4_total1 < 1.00) {
    $kpmr_rep_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_rep_pil4_total1 >= 1.00 && $kpmr_rep_pil4_total1 < 1.25) {
    $kpmr_rep_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_rep_pil4_total1 >= 1.25 && $kpmr_rep_pil4_total1 < 2.25) {
    $kpmr_rep_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_rep_pil4_total1 >= 2.25 && $kpmr_rep_pil4_total1 < 3.25) {
    $kpmr_rep_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_rep_pil4_total1 >= 3.25 && $kpmr_rep_pil4_total1 < 4.25) {
    $kpmr_rep_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_rep_pil4_total1 >= 4.25 && $kpmr_rep_pil4_total1 <= 5.00) {
    $kpmr_rep_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_rep_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_rep_pilar4_1a = $result_kpmr_rep_pilar4_1a['nilai']; $kpmr_rep_respon_pil4_1a = $result_kpmr_rep_pilar4_1a['respon'];
$kpmr_rep_pilar4_1b = $result_kpmr_rep_pilar4_1b['nilai']; $kpmr_rep_respon_pil4_1b = $result_kpmr_rep_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_rep_pil4_total2_average = array($kpmr_rep_pilar4_1a,
$kpmr_rep_pilar4_1b);
$kpmr_rep_pil4_total2_sum = array_sum($kpmr_rep_pil4_total2_average);
$kpmr_rep_pil4_total2 = $kpmr_rep_pil4_total2_sum / count($kpmr_rep_pil4_total2_average);

if ($kpmr_rep_pil4_total2 < 1.00) {
    $kpmr_rep_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_rep_pil4_total2 >= 1.00 && $kpmr_rep_pil4_total2 < 1.25) {
    $kpmr_rep_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_rep_pil4_total2 >= 1.25 && $kpmr_rep_pil4_total2 < 2.25) {
    $kpmr_rep_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_rep_pil4_total2 >= 2.25 && $kpmr_rep_pil4_total2 < 3.25) {
    $kpmr_rep_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_rep_pil4_total2 >= 3.25 && $kpmr_rep_pil4_total2 < 4.25) {
    $kpmr_rep_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_rep_pil4_total2 >= 4.25 && $kpmr_rep_pil4_total2 <= 5.00) {
    $kpmr_rep_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_rep_pil4_peringkat2 = "Belum Terisi";
}

    
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
$result_inheren_stra_pilar1_1  = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1a = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1a','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1a',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1b = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1b','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1b',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1c = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1c','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1c',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1d = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1d','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1d',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1e = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1e','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1e',$tahun,$periode,1,5);
$result_inheren_stra_pilar1_1f = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar1','pilar1_1f','ket_inheren_stratejik_pilar1','ket_in_stra_pil1_1f',$tahun,$periode,1,5);

$inheren_stra_pilar1_1  = $result_inheren_stra_pilar1_1['nilai'];   $ket_in_stra_pil1_1  = $result_inheren_stra_pilar1_1['ket'];
$inheren_stra_pilar1_1a = $result_inheren_stra_pilar1_1a['nilai']; $ket_in_stra_pil1_1a = $result_inheren_stra_pilar1_1a['ket'];
$inheren_stra_pilar1_1b = $result_inheren_stra_pilar1_1b['nilai']; $ket_in_stra_pil1_1b = $result_inheren_stra_pilar1_1b['ket'];
$inheren_stra_pilar1_1c = $result_inheren_stra_pilar1_1c['nilai']; $ket_in_stra_pil1_1c = $result_inheren_stra_pilar1_1c['ket'];
$inheren_stra_pilar1_1d = $result_inheren_stra_pilar1_1d['nilai']; $ket_in_stra_pil1_1d = $result_inheren_stra_pilar1_1d['ket'];
$inheren_stra_pilar1_1e = $result_inheren_stra_pilar1_1e['nilai']; $ket_in_stra_pil1_1e = $result_inheren_stra_pilar1_1e['ket'];
$inheren_stra_pilar1_1f = $result_inheren_stra_pilar1_1f['nilai']; $ket_in_stra_pil1_1f = $result_inheren_stra_pilar1_1f['ket'];


    
    //inheren Stratejik pilar 2
$result_inheren_stra_pilar2_1  = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1a = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1a','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1a',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1b = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1b','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1b',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1c = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1c','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1c',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1d = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1d','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1d',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1e = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1e','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1e',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1f = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1f','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1f',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1g = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1g','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1g',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1h = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1h','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1h',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_1i = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_1i','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_1i',$tahun,$periode,1,5);

$result_inheren_stra_pilar2_2  = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_2','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_2',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_2a = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_2a','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_2a',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_2b = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_2b','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_2b',$tahun,$periode,1,5);
$result_inheren_stra_pilar2_2c = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar2','pilar2_2c','ket_inheren_stratejik_pilar2','ket_in_stra_pil2_2c',$tahun,$periode,1,5);

$inheren_stra_pilar2_1  = $result_inheren_stra_pilar2_1['nilai'];   $ket_in_stra_pil2_1  = $result_inheren_stra_pilar2_1['ket'];
$inheren_stra_pilar2_1a = $result_inheren_stra_pilar2_1a['nilai']; $ket_in_stra_pil2_1a = $result_inheren_stra_pilar2_1a['ket'];
$inheren_stra_pilar2_1b = $result_inheren_stra_pilar2_1b['nilai']; $ket_in_stra_pil2_1b = $result_inheren_stra_pilar2_1b['ket'];
$inheren_stra_pilar2_1c = $result_inheren_stra_pilar2_1c['nilai']; $ket_in_stra_pil2_1c = $result_inheren_stra_pilar2_1c['ket'];
$inheren_stra_pilar2_1d = $result_inheren_stra_pilar2_1d['nilai']; $ket_in_stra_pil2_1d = $result_inheren_stra_pilar2_1d['ket'];
$inheren_stra_pilar2_1e = $result_inheren_stra_pilar2_1e['nilai']; $ket_in_stra_pil2_1e = $result_inheren_stra_pilar2_1e['ket'];
$inheren_stra_pilar2_1f = $result_inheren_stra_pilar2_1f['nilai']; $ket_in_stra_pil2_1f = $result_inheren_stra_pilar2_1f['ket'];
$inheren_stra_pilar2_1g = $result_inheren_stra_pilar2_1g['nilai']; $ket_in_stra_pil2_1g = $result_inheren_stra_pilar2_1g['ket'];
$inheren_stra_pilar2_1h = $result_inheren_stra_pilar2_1h['nilai']; $ket_in_stra_pil2_1h = $result_inheren_stra_pilar2_1h['ket'];
$inheren_stra_pilar2_1i = $result_inheren_stra_pilar2_1i['nilai']; $ket_in_stra_pil2_1i = $result_inheren_stra_pilar2_1i['ket'];

$inheren_stra_pilar2_2  = $result_inheren_stra_pilar2_2['nilai'];   $ket_in_stra_pil2_2  = $result_inheren_stra_pilar2_2['ket'];
$inheren_stra_pilar2_2a = $result_inheren_stra_pilar2_2a['nilai']; $ket_in_stra_pil2_2a = $result_inheren_stra_pilar2_2a['ket'];
$inheren_stra_pilar2_2b = $result_inheren_stra_pilar2_2b['nilai']; $ket_in_stra_pil2_2b = $result_inheren_stra_pilar2_2b['ket'];
$inheren_stra_pilar2_2c = $result_inheren_stra_pilar2_2c['nilai']; $ket_in_stra_pil2_2c = $result_inheren_stra_pilar2_2c['ket'];


    //inheren Stratejik pilar 3

$result_inheren_stra_pilar3_1  = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1a = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1a','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1a',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1b = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1b','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1b',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1c = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1c','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1c',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1d = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1d','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1d',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1e = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1e','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1e',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1f = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1f','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1f',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1g = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1g','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1g',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1h = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1h','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1h',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1i = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1i','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1i',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1j = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1j','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1j',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1k = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1k','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1k',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1l = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1l','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1l',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1m = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1m','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1m',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1n = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1n','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1n',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1o = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1o','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1o',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_1p = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_1p','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_1p',$tahun,$periode,1,5);

$result_inheren_stra_pilar3_2  = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2a = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2a','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2a',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2b = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2b','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2b',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2c = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2c','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2c',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2d = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2d','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2d',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2e = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2e','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2e',$tahun,$periode,1,5);
$result_inheren_stra_pilar3_2f = getMaxInherenWithKetUser($conn,'inheren_stratejik_pilar3','pilar3_2f','ket_inheren_stratejik_pilar3','ket_in_stra_pil3_2f',$tahun,$periode,1,5);



$inheren_stra_pilar3_1   = $result_inheren_stra_pilar3_1['nilai'];   $ket_in_stra_pil3_1   = $result_inheren_stra_pilar3_1['ket'];
$inheren_stra_pilar3_1a  = $result_inheren_stra_pilar3_1a['nilai'];  $ket_in_stra_pil3_1a  = $result_inheren_stra_pilar3_1a['ket'];
$inheren_stra_pilar3_1b  = $result_inheren_stra_pilar3_1b['nilai'];  $ket_in_stra_pil3_1b  = $result_inheren_stra_pilar3_1b['ket'];
$inheren_stra_pilar3_1c  = $result_inheren_stra_pilar3_1c['nilai'];  $ket_in_stra_pil3_1c  = $result_inheren_stra_pilar3_1c['ket'];
$inheren_stra_pilar3_1d  = $result_inheren_stra_pilar3_1d['nilai'];  $ket_in_stra_pil3_1d  = $result_inheren_stra_pilar3_1d['ket'];
$inheren_stra_pilar3_1e  = $result_inheren_stra_pilar3_1e['nilai'];  $ket_in_stra_pil3_1e  = $result_inheren_stra_pilar3_1e['ket'];
$inheren_stra_pilar3_1f  = $result_inheren_stra_pilar3_1f['nilai'];  $ket_in_stra_pil3_1f  = $result_inheren_stra_pilar3_1f['ket'];
$inheren_stra_pilar3_1g  = $result_inheren_stra_pilar3_1g['nilai'];  $ket_in_stra_pil3_1g  = $result_inheren_stra_pilar3_1g['ket'];
$inheren_stra_pilar3_1h  = $result_inheren_stra_pilar3_1h['nilai'];  $ket_in_stra_pil3_1h  = $result_inheren_stra_pilar3_1h['ket'];
$inheren_stra_pilar3_1i  = $result_inheren_stra_pilar3_1i['nilai'];  $ket_in_stra_pil3_1i  = $result_inheren_stra_pilar3_1i['ket'];
$inheren_stra_pilar3_1j  = $result_inheren_stra_pilar3_1j['nilai'];  $ket_in_stra_pil3_1j  = $result_inheren_stra_pilar3_1j['ket'];
$inheren_stra_pilar3_1k  = $result_inheren_stra_pilar3_1k['nilai'];  $ket_in_stra_pil3_1k  = $result_inheren_stra_pilar3_1k['ket'];
$inheren_stra_pilar3_1l  = $result_inheren_stra_pilar3_1l['nilai'];  $ket_in_stra_pil3_1l  = $result_inheren_stra_pilar3_1l['ket'];
$inheren_stra_pilar3_1m  = $result_inheren_stra_pilar3_1m['nilai'];  $ket_in_stra_pil3_1m  = $result_inheren_stra_pilar3_1m['ket'];
$inheren_stra_pilar3_1n  = $result_inheren_stra_pilar3_1n['nilai'];  $ket_in_stra_pil3_1n  = $result_inheren_stra_pilar3_1n['ket'];
$inheren_stra_pilar3_1o  = $result_inheren_stra_pilar3_1o['nilai'];  $ket_in_stra_pil3_1o  = $result_inheren_stra_pilar3_1o['ket'];
$inheren_stra_pilar3_1p  = $result_inheren_stra_pilar3_1p['nilai'];  $ket_in_stra_pil3_1p  = $result_inheren_stra_pilar3_1p['ket'];

$inheren_stra_pilar3_2   = $result_inheren_stra_pilar3_2['nilai'];   $ket_in_stra_pil3_2   = $result_inheren_stra_pilar3_2['ket'];
$inheren_stra_pilar3_2a  = $result_inheren_stra_pilar3_2a['nilai'];  $ket_in_stra_pil3_2a  = $result_inheren_stra_pilar3_2a['ket'];
$inheren_stra_pilar3_2b  = $result_inheren_stra_pilar3_2b['nilai'];  $ket_in_stra_pil3_2b  = $result_inheren_stra_pilar3_2b['ket'];
$inheren_stra_pilar3_2c  = $result_inheren_stra_pilar3_2c['nilai'];  $ket_in_stra_pil3_2c  = $result_inheren_stra_pilar3_2c['ket'];
$inheren_stra_pilar3_2d  = $result_inheren_stra_pilar3_2d['nilai'];  $ket_in_stra_pil3_2d  = $result_inheren_stra_pilar3_2d['ket'];
$inheren_stra_pilar3_2e  = $result_inheren_stra_pilar3_2e['nilai'];  $ket_in_stra_pil3_2e  = $result_inheren_stra_pilar3_2e['ket'];
$inheren_stra_pilar3_2f  = $result_inheren_stra_pilar3_2f['nilai'];  $ket_in_stra_pil3_2f  = $result_inheren_stra_pilar3_2f['ket'];



    //inheren Stratejik pilar lainnya
$result_inheren_stra_pilar4_1a = getMaxInherenWithKetUser($conn,'inheren_stratejik_lainnya','pilar4_1a','ket_inheren_stratejik_lainnya','ket_in_stra_pil4_1a',$tahun,$periode,1,5);
$result_inheren_stra_pilar4_1b = getMaxInherenWithKetUser($conn,'inheren_stratejik_lainnya','pilar4_1b','ket_inheren_stratejik_lainnya','ket_in_stra_pil4_1b',$tahun,$periode,1,5);
$result_inheren_stra_pilar4_1c = getMaxInherenWithKetUser($conn,'inheren_stratejik_lainnya','pilar4_1c','ket_inheren_stratejik_lainnya','ket_in_stra_pil4_1c',$tahun,$periode,1,5);
$result_inheren_stra_pilar4_1d = getMaxInherenWithKetUser($conn,'inheren_stratejik_lainnya','pilar4_1d','ket_inheren_stratejik_lainnya','ket_in_stra_pil4_1d',$tahun,$periode,1,5);

$inheren_stra_pilar4_1a  = $result_inheren_stra_pilar4_1a['nilai'];  $ket_in_stra_pil4_1a  = $result_inheren_stra_pilar4_1a['ket'];
$inheren_stra_pilar4_1b  = $result_inheren_stra_pilar4_1b['nilai'];  $ket_in_stra_pil4_1b  = $result_inheren_stra_pilar4_1b['ket'];
$inheren_stra_pilar4_1c  = $result_inheren_stra_pilar4_1c['nilai'];  $ket_in_stra_pil4_1c  = $result_inheren_stra_pilar4_1c['ket'];
$inheren_stra_pilar4_1d  = $result_inheren_stra_pilar4_1d['nilai'];  $ket_in_stra_pil4_1d  = $result_inheren_stra_pilar4_1d['ket'];



$kpmr_stra = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_kpmr_stratejik WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

    $result_kpmr_stra_pilar1_1a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_1a','respon_unit_kerja_stratejik_pil1','respon_pil1_1a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_1b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_1b','respon_unit_kerja_stratejik_pil1','respon_pil1_1b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_1c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_1c','respon_unit_kerja_stratejik_pil1','respon_pil1_1c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_1d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_1d','respon_unit_kerja_stratejik_pil1','respon_pil1_1d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_1e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_1e','respon_unit_kerja_stratejik_pil1','respon_pil1_1e',$tahun,$periode,1,5);
    
    $result_kpmr_stra_pilar1_2a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_2a','respon_unit_kerja_stratejik_pil1','respon_pil1_2a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_2b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_2b','respon_unit_kerja_stratejik_pil1','respon_pil1_2b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_2c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_2c','respon_unit_kerja_stratejik_pil1','respon_pil1_2c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_2d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_2d','respon_unit_kerja_stratejik_pil1','respon_pil1_2d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_2e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_2e','respon_unit_kerja_stratejik_pil1','respon_pil1_2e',$tahun,$periode,1,5);
    
    $result_kpmr_stra_pilar1_3a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_3a','respon_unit_kerja_stratejik_pil1','respon_pil1_3a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_3b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_3b','respon_unit_kerja_stratejik_pil1','respon_pil1_3b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_3c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_3c','respon_unit_kerja_stratejik_pil1','respon_pil1_3c',$tahun,$periode,1,5);
    
    $result_kpmr_stra_pilar1_4a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_4a','respon_unit_kerja_stratejik_pil1','respon_pil1_4a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_4b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_4b','respon_unit_kerja_stratejik_pil1','respon_pil1_4b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_4c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_4c','respon_unit_kerja_stratejik_pil1','respon_pil1_4c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_4d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_4d','respon_unit_kerja_stratejik_pil1','respon_pil1_4d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_4e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_4e','respon_unit_kerja_stratejik_pil1','respon_pil1_4e',$tahun,$periode,1,5);
    
    $result_kpmr_stra_pilar1_5a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_5a','respon_unit_kerja_stratejik_pil1','respon_pil1_5a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_5b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_5b','respon_unit_kerja_stratejik_pil1','respon_pil1_5b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_5c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_5c','respon_unit_kerja_stratejik_pil1','respon_pil1_5c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_5d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_5d','respon_unit_kerja_stratejik_pil1','respon_pil1_5d',$tahun,$periode,1,5);
    
    $result_kpmr_stra_pilar1_6a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_6a','respon_unit_kerja_stratejik_pil1','respon_pil1_6a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_6b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_6b','respon_unit_kerja_stratejik_pil1','respon_pil1_6b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar1_6c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar1','pilar1_6c','respon_unit_kerja_stratejik_pil1','respon_pil1_6c',$tahun,$periode,1,5);
    

    $result_kpmr_stra_pilar2_1a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_1a','respon_unit_kerja_stratejik_pil2','respon_pil2_1a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_1b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_1b','respon_unit_kerja_stratejik_pil2','respon_pil2_1b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_1c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_1c','respon_unit_kerja_stratejik_pil2','respon_pil2_1c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_1d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_1d','respon_unit_kerja_stratejik_pil2','respon_pil2_1d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_1e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_1e','respon_unit_kerja_stratejik_pil2','respon_pil2_1e',$tahun,$periode,1,5);

    $result_kpmr_stra_pilar2_2a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2a','respon_unit_kerja_stratejik_pil2','respon_pil2_2a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2b','respon_unit_kerja_stratejik_pil2','respon_pil2_2b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2c','respon_unit_kerja_stratejik_pil2','respon_pil2_2c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2d','respon_unit_kerja_stratejik_pil2','respon_pil2_2d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2e','respon_unit_kerja_stratejik_pil2','respon_pil2_2e',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2f = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2f','respon_unit_kerja_stratejik_pil2','respon_pil2_2f',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2g = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2g','respon_unit_kerja_stratejik_pil2','respon_pil2_2g',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_2h = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_2h','respon_unit_kerja_stratejik_pil2','respon_pil2_2h',$tahun,$periode,1,5);

    $result_kpmr_stra_pilar2_3a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_3a','respon_unit_kerja_stratejik_pil2','respon_pil2_3a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_3b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_3b','respon_unit_kerja_stratejik_pil2','respon_pil2_3b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar2_3c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar2','pilar2_3c','respon_unit_kerja_stratejik_pil2','respon_pil2_3c',$tahun,$periode,1,5);


    $result_kpmr_stra_pilar3_1a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1a','respon_unit_kerja_stratejik_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1b','respon_unit_kerja_stratejik_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1c','respon_unit_kerja_stratejik_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1d','respon_unit_kerja_stratejik_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1e','respon_unit_kerja_stratejik_pil3','respon_pil3_1e',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1f = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1f','respon_unit_kerja_stratejik_pil3','respon_pil3_1f',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1g = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1g','respon_unit_kerja_stratejik_pil3','respon_pil3_1g',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1h = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1h','respon_unit_kerja_stratejik_pil3','respon_pil3_1h',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1i = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1i','respon_unit_kerja_stratejik_pil3','respon_pil3_1i',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_1j = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_1j','respon_unit_kerja_stratejik_pil3','respon_pil3_1j',$tahun,$periode,1,5);

    $result_kpmr_stra_pilar3_2a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_2a','respon_unit_kerja_stratejik_pil3','respon_pil3_1a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_2b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_2b','respon_unit_kerja_stratejik_pil3','respon_pil3_1b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_2c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_2c','respon_unit_kerja_stratejik_pil3','respon_pil3_1c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_2d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_2d','respon_unit_kerja_stratejik_pil3','respon_pil3_1d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar3_2e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar3','pilar3_2e','respon_unit_kerja_stratejik_pil3','respon_pil3_1e',$tahun,$periode,1,5);



    //implemen

$kpmr_stra_pilar1_1a = $result_kpmr_stra_pilar1_1a['nilai']; $kpmr_stra_respon_pil1_1a = $result_kpmr_stra_pilar1_1a['respon'];
$kpmr_stra_pilar1_1b = $result_kpmr_stra_pilar1_1b['nilai']; $kpmr_stra_respon_pil1_1b = $result_kpmr_stra_pilar1_1b['respon'];
$kpmr_stra_pilar1_1c = $result_kpmr_stra_pilar1_1c['nilai']; $kpmr_stra_respon_pil1_1c = $result_kpmr_stra_pilar1_1c['respon'];
$kpmr_stra_pilar1_1d = $result_kpmr_stra_pilar1_1d['nilai']; $kpmr_stra_respon_pil1_1d = $result_kpmr_stra_pilar1_1d['respon'];
$kpmr_stra_pilar1_1e = $result_kpmr_stra_pilar1_1e['nilai']; $kpmr_stra_respon_pil1_1e = $result_kpmr_stra_pilar1_1e['respon'];



$kpmr_stra_pil1_total1_average = array($kpmr_stra_pilar1_1a,
$kpmr_stra_pilar1_1b,
$kpmr_stra_pilar1_1c,
$kpmr_stra_pilar1_1d,
$kpmr_stra_pilar1_1e);
        $kpmr_stra_pil1_total1_sum = array_sum($kpmr_stra_pil1_total1_average);
        $kpmr_stra_pil1_total1 = $kpmr_stra_pil1_total1_sum / count($kpmr_stra_pil1_total1_average);

if ($kpmr_stra_pil1_total1 < 1.00) {
    $kpmr_stra_pil1_peringkat1 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total1 >= 1.00 && $kpmr_stra_pil1_total1 < 1.25) {
    $kpmr_stra_pil1_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total1 >= 1.25 && $kpmr_stra_pil1_total1 < 2.25) {
    $kpmr_stra_pil1_peringkat1 = "Memadai";
} elseif ($kpmr_stra_pil1_total1 >= 2.25 && $kpmr_stra_pil1_total1 < 3.25) {
    $kpmr_stra_pil1_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total1 >= 3.25 && $kpmr_stra_pil1_total1 < 4.25) {
    $kpmr_stra_pil1_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total1 >= 4.25 && $kpmr_stra_pil1_total1 <= 5.00) {
    $kpmr_stra_pil1_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat1 = "Belum Terisi";
}


$kpmr_stra_pilar1_2a = $result_kpmr_stra_pilar1_2a['nilai']; $kpmr_stra_respon_pil1_2a = $result_kpmr_stra_pilar1_2a['respon'];
$kpmr_stra_pilar1_2b = $result_kpmr_stra_pilar1_2b['nilai']; $kpmr_stra_respon_pil1_2b = $result_kpmr_stra_pilar1_2b['respon'];
$kpmr_stra_pilar1_2c = $result_kpmr_stra_pilar1_2c['nilai']; $kpmr_stra_respon_pil1_2c = $result_kpmr_stra_pilar1_2c['respon'];
$kpmr_stra_pilar1_2d = $result_kpmr_stra_pilar1_2d['nilai']; $kpmr_stra_respon_pil1_2d = $result_kpmr_stra_pilar1_2d['respon'];
$kpmr_stra_pilar1_2e = $result_kpmr_stra_pilar1_2e['nilai']; $kpmr_stra_respon_pil1_2e = $result_kpmr_stra_pilar1_2e['respon'];


$kpmr_stra_pil1_total2_average = array($kpmr_stra_pilar1_2a,
$kpmr_stra_pilar1_2b,
$kpmr_stra_pilar1_2c,
$kpmr_stra_pilar1_2d,
$kpmr_stra_pilar1_2e);
$kpmr_stra_pil1_total2_sum = array_sum($kpmr_stra_pil1_total2_average);
$kpmr_stra_pil1_total2 = $kpmr_stra_pil1_total2_sum / count($kpmr_stra_pil1_total2_average);

if ($kpmr_stra_pil1_total2 < 1.00) {
    $kpmr_stra_pil1_peringkat2 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total2 >= 1.00 && $kpmr_stra_pil1_total2 < 1.25) {
    $kpmr_stra_pil1_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total2 >= 1.25 && $kpmr_stra_pil1_total2 < 2.25) {
    $kpmr_stra_pil1_peringkat2 = "Memadai";
} elseif ($kpmr_stra_pil1_total2 >= 2.25 && $kpmr_stra_pil1_total2 < 3.25) {
    $kpmr_stra_pil1_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total2 >= 3.25 && $kpmr_stra_pil1_total2 < 4.25) {
    $kpmr_stra_pil1_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total2 >= 4.25 && $kpmr_stra_pil1_total2 <= 5.00) {
    $kpmr_stra_pil1_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat2 = "Belum Terisi";
}

$kpmr_stra_pilar1_3a = $result_kpmr_stra_pilar1_3a['nilai']; $kpmr_stra_respon_pil1_3a = $result_kpmr_stra_pilar1_3a['respon'];
$kpmr_stra_pilar1_3b = $result_kpmr_stra_pilar1_3b['nilai']; $kpmr_stra_respon_pil1_3b = $result_kpmr_stra_pilar1_3b['respon'];
$kpmr_stra_pilar1_3c = $result_kpmr_stra_pilar1_3c['nilai']; $kpmr_stra_respon_pil1_3c = $result_kpmr_stra_pilar1_3c['respon'];

// --- Total 3 ---
$kpmr_stra_pil1_total3_average = array($kpmr_stra_pilar1_3a,
$kpmr_stra_pilar1_3b,
$kpmr_stra_pilar1_3c);
$kpmr_stra_pil1_total3_sum = array_sum($kpmr_stra_pil1_total3_average);
$kpmr_stra_pil1_total3 = $kpmr_stra_pil1_total3_sum / count($kpmr_stra_pil1_total3_average);

if ($kpmr_stra_pil1_total3 < 1.00) {
    $kpmr_stra_pil1_peringkat3 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total3 >= 1.00 && $kpmr_stra_pil1_total3 < 1.25) {
    $kpmr_stra_pil1_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total3 >= 1.25 && $kpmr_stra_pil1_total3 < 2.25) {
    $kpmr_stra_pil1_peringkat3 = "Memadai";
} elseif ($kpmr_stra_pil1_total3 >= 2.25 && $kpmr_stra_pil1_total3 < 3.25) {
    $kpmr_stra_pil1_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total3 >= 3.25 && $kpmr_stra_pil1_total3 < 4.25) {
    $kpmr_stra_pil1_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total3 >= 4.25 && $kpmr_stra_pil1_total3 <= 5.00) {
    $kpmr_stra_pil1_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat3 = "Belum Terisi";
}

$kpmr_stra_pilar1_4a = $result_kpmr_stra_pilar1_4a['nilai']; $kpmr_stra_respon_pil1_4a = $result_kpmr_stra_pilar1_4a['respon'];
$kpmr_stra_pilar1_4b = $result_kpmr_stra_pilar1_4b['nilai']; $kpmr_stra_respon_pil1_4b = $result_kpmr_stra_pilar1_4b['respon'];
$kpmr_stra_pilar1_4c = $result_kpmr_stra_pilar1_4c['nilai']; $kpmr_stra_respon_pil1_4c = $result_kpmr_stra_pilar1_4c['respon'];
$kpmr_stra_pilar1_4d = $result_kpmr_stra_pilar1_4d['nilai']; $kpmr_stra_respon_pil1_4d = $result_kpmr_stra_pilar1_4d['respon'];
$kpmr_stra_pilar1_4e = $result_kpmr_stra_pilar1_4e['nilai']; $kpmr_stra_respon_pil1_4e = $result_kpmr_stra_pilar1_4e['respon'];


$kpmr_stra_pil1_total4_average = array($kpmr_stra_pilar1_4a,
$kpmr_stra_pilar1_4b,
$kpmr_stra_pilar1_4c,
$kpmr_stra_pilar1_4d,
$kpmr_stra_pilar1_4e);
$kpmr_stra_pil1_total4_sum = array_sum($kpmr_stra_pil1_total4_average);
$kpmr_stra_pil1_total4 = $kpmr_stra_pil1_total4_sum / count($kpmr_stra_pil1_total4_average);

if ($kpmr_stra_pil1_total4 < 1.00) {
    $kpmr_stra_pil1_peringkat4 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total4 >= 1.00 && $kpmr_stra_pil1_total4 < 1.25) {
    $kpmr_stra_pil1_peringkat4 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total4 >= 1.25 && $kpmr_stra_pil1_total4 < 2.25) {
    $kpmr_stra_pil1_peringkat4 = "Memadai";
} elseif ($kpmr_stra_pil1_total4 >= 2.25 && $kpmr_stra_pil1_total4 < 3.25) {
    $kpmr_stra_pil1_peringkat4 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total4 >= 3.25 && $kpmr_stra_pil1_total4 < 4.25) {
    $kpmr_stra_pil1_peringkat4 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total4 >= 4.25 && $kpmr_stra_pil1_total4 <= 5.00) {
    $kpmr_stra_pil1_peringkat4 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat4 = "Belum Terisi";
}

$kpmr_stra_pilar1_5a = $result_kpmr_stra_pilar1_5a['nilai']; $kpmr_stra_respon_pil1_5a = $result_kpmr_stra_pilar1_5a['respon'];
$kpmr_stra_pilar1_5b = $result_kpmr_stra_pilar1_5b['nilai']; $kpmr_stra_respon_pil1_5b = $result_kpmr_stra_pilar1_5b['respon'];
$kpmr_stra_pilar1_5c = $result_kpmr_stra_pilar1_5c['nilai']; $kpmr_stra_respon_pil1_5c = $result_kpmr_stra_pilar1_5c['respon'];
$kpmr_stra_pilar1_5d = $result_kpmr_stra_pilar1_5d['nilai']; $kpmr_stra_respon_pil1_5d = $result_kpmr_stra_pilar1_5d['respon'];

// --- Total 5 ---
$kpmr_stra_pil1_total5_average = array($kpmr_stra_pilar1_5a,
$kpmr_stra_pilar1_5b,
$kpmr_stra_pilar1_5c,
$kpmr_stra_pilar1_5);
$kpmr_stra_pil1_total5_sum = array_sum($kpmr_stra_pil1_total5_average);
$kpmr_stra_pil1_total5 = $kpmr_stra_pil1_total5_sum / count($kpmr_stra_pil1_total5_average);

if ($kpmr_stra_pil1_total5 < 1.00) {
    $kpmr_stra_pil1_peringkat5 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total5 >= 1.00 && $kpmr_stra_pil1_total5 < 1.25) {
    $kpmr_stra_pil1_peringkat5 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total5 >= 1.25 && $kpmr_stra_pil1_total5 < 2.25) {
    $kpmr_stra_pil1_peringkat5 = "Memadai";
} elseif ($kpmr_stra_pil1_total5 >= 2.25 && $kpmr_stra_pil1_total5 < 3.25) {
    $kpmr_stra_pil1_peringkat5 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total5 >= 3.25 && $kpmr_stra_pil1_total5 < 4.25) {
    $kpmr_stra_pil1_peringkat5 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total5 >= 4.25 && $kpmr_stra_pil1_total5 <= 5.00) {
    $kpmr_stra_pil1_peringkat5 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat5 = "Belum Terisi";
}

$kpmr_stra_pilar1_6a = $result_kpmr_stra_pilar1_6a['nilai']; $kpmr_stra_respon_pil1_6a = $result_kpmr_stra_pilar1_6a['respon'];
$kpmr_stra_pilar1_6b = $result_kpmr_stra_pilar1_6b['nilai']; $kpmr_stra_respon_pil1_6b = $result_kpmr_stra_pilar1_6b['respon'];
$kpmr_stra_pilar1_6c = $result_kpmr_stra_pilar1_6c['nilai']; $kpmr_stra_respon_pil1_6c = $result_kpmr_stra_pilar1_6c['respon'];

// --- Total 6 ---
$kpmr_stra_pil1_total6_average = array($kpmr_stra_pilar1_6a,
$kpmr_stra_pilar1_6b,
$kpmr_stra_pilar1_6c);
$kpmr_stra_pil1_total6_sum = array_sum($kpmr_stra_pil1_total6_average);
$kpmr_stra_pil1_total6 = $kpmr_stra_pil1_total6_sum / count($kpmr_stra_pil1_total6_average);

if ($kpmr_stra_pil1_total6 < 1.00) {
    $kpmr_stra_pil1_peringkat6 = "Belum Terisi";
} elseif ($kpmr_stra_pil1_total6 >= 1.00 && $kpmr_stra_pil1_total6 < 1.25) {
    $kpmr_stra_pil1_peringkat6 = "Sangat Memadai";
} elseif ($kpmr_stra_pil1_total6 >= 1.25 && $kpmr_stra_pil1_total6 < 2.25) {
    $kpmr_stra_pil1_peringkat6 = "Memadai";
} elseif ($kpmr_stra_pil1_total6 >= 2.25 && $kpmr_stra_pil1_total6 < 3.25) {
    $kpmr_stra_pil1_peringkat6 = "Cukup Memadai";
} elseif ($kpmr_stra_pil1_total6 >= 3.25 && $kpmr_stra_pil1_total6 < 4.25) {
    $kpmr_stra_pil1_peringkat6 = "Kurang Memadai";
} elseif ($kpmr_stra_pil1_total6 >= 4.25 && $kpmr_stra_pil1_total6 <= 5.00) {
    $kpmr_stra_pil1_peringkat6 = "Tidak Memadai";
} else {
    $kpmr_stra_pil1_peringkat6 = "Belum Terisi";
}


        
$kpmr_stra_pilar2_1a = $result_kpmr_stra_pilar2_1a['nilai']; $kpmr_stra_respon_pil2_1a = $result_kpmr_stra_pilar2_1a['respon'];
$kpmr_stra_pilar2_1b = $result_kpmr_stra_pilar2_1b['nilai']; $kpmr_stra_respon_pil2_1b = $result_kpmr_stra_pilar2_1b['respon'];
$kpmr_stra_pilar2_1c = $result_kpmr_stra_pilar2_1c['nilai']; $kpmr_stra_respon_pil2_1c = $result_kpmr_stra_pilar2_1c['respon'];
$kpmr_stra_pilar2_1d = $result_kpmr_stra_pilar2_1d['nilai']; $kpmr_stra_respon_pil2_1d = $result_kpmr_stra_pilar2_1d['respon'];
$kpmr_stra_pilar2_1e = $result_kpmr_stra_pilar2_1e['nilai']; $kpmr_stra_respon_pil2_1e = $result_kpmr_stra_pilar2_1e['respon'];


// --- Pilar 2 Total 1 ---
$kpmr_stra_pil2_total1_average = array($kpmr_stra_pilar2_1a,
$kpmr_stra_pilar2_1b,
$kpmr_stra_pilar2_1c,
$kpmr_stra_pilar2_1d,
$kpmr_stra_pilar2_1e);
$kpmr_stra_pil2_total1_sum = array_sum($kpmr_stra_pil2_total1_average);
$kpmr_stra_pil2_total1 = $kpmr_stra_pil2_total1_sum / count($kpmr_stra_pil2_total1_average);

if ($kpmr_stra_pil2_total1 < 1.00) {
    $kpmr_stra_pil2_peringkat1 = "Belum Terisi";
} elseif ($kpmr_stra_pil2_total1 >= 1.00 && $kpmr_stra_pil2_total1 < 1.25) {
    $kpmr_stra_pil2_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_stra_pil2_total1 >= 1.25 && $kpmr_stra_pil2_total1 < 2.25) {
    $kpmr_stra_pil2_peringkat1 = "Memadai";
} elseif ($kpmr_stra_pil2_total1 >= 2.25 && $kpmr_stra_pil2_total1 < 3.25) {
    $kpmr_stra_pil2_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_stra_pil2_total1 >= 3.25 && $kpmr_stra_pil2_total1 < 4.25) {
    $kpmr_stra_pil2_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_stra_pil2_total1 >= 4.25 && $kpmr_stra_pil2_total1 <= 5.00) {
    $kpmr_stra_pil2_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_stra_pil2_peringkat1 = "Belum Terisi";
}


$kpmr_stra_pilar2_2a = $result_kpmr_stra_pilar2_2a['nilai']; $kpmr_stra_respon_pil2_2a = $result_kpmr_stra_pilar2_2a['respon'];
$kpmr_stra_pilar2_2b = $result_kpmr_stra_pilar2_2b['nilai']; $kpmr_stra_respon_pil2_2b = $result_kpmr_stra_pilar2_2b['respon'];
$kpmr_stra_pilar2_2c = $result_kpmr_stra_pilar2_2c['nilai']; $kpmr_stra_respon_pil2_2c = $result_kpmr_stra_pilar2_2c['respon'];
$kpmr_stra_pilar2_2d = $result_kpmr_stra_pilar2_2d['nilai']; $kpmr_stra_respon_pil2_2d = $result_kpmr_stra_pilar2_2d['respon'];
$kpmr_stra_pilar2_2e = $result_kpmr_stra_pilar2_2e['nilai']; $kpmr_stra_respon_pil2_2e = $result_kpmr_stra_pilar2_2e['respon'];
$kpmr_stra_pilar2_2f = $result_kpmr_stra_pilar2_2f['nilai']; $kpmr_stra_respon_pil2_2f = $result_kpmr_stra_pilar2_2f['respon'];
$kpmr_stra_pilar2_2g = $result_kpmr_stra_pilar2_2g['nilai']; $kpmr_stra_respon_pil2_2g = $result_kpmr_stra_pilar2_2g['respon'];
$kpmr_stra_pilar2_2h = $result_kpmr_stra_pilar2_2h['nilai']; $kpmr_stra_respon_pil2_2h = $result_kpmr_stra_pilar2_2h['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_stra_pil2_total2_average = array($kpmr_stra_pilar2_2a,
$kpmr_stra_pilar2_2b,
$kpmr_stra_pilar2_2c,
$kpmr_stra_pilar2_2d,
$kpmr_stra_pilar2_2e,
$kpmr_stra_pilar2_2f,
$kpmr_stra_pilar2_2g,
$kpmr_stra_pilar2_2h);
$kpmr_stra_pil2_total2_sum = array_sum($kpmr_stra_pil2_total2_average);
$kpmr_stra_pil2_total2 = $kpmr_stra_pil2_total2_sum / count($kpmr_stra_pil2_total2_average);

if ($kpmr_stra_pil2_total2 < 1.00) {
    $kpmr_stra_pil2_peringkat2 = "Belum Terisi";
} elseif ($kpmr_stra_pil2_total2 >= 1.00 && $kpmr_stra_pil2_total2 < 1.25) {
    $kpmr_stra_pil2_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_stra_pil2_total2 >= 1.25 && $kpmr_stra_pil2_total2 < 2.25) {
    $kpmr_stra_pil2_peringkat2 = "Memadai";
} elseif ($kpmr_stra_pil2_total2 >= 2.25 && $kpmr_stra_pil2_total2 < 3.25) {
    $kpmr_stra_pil2_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_stra_pil2_total2 >= 3.25 && $kpmr_stra_pil2_total2 < 4.25) {
    $kpmr_stra_pil2_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_stra_pil2_total2 >= 4.25 && $kpmr_stra_pil2_total2 <= 5.00) {
    $kpmr_stra_pil2_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_stra_pil2_peringkat2 = "Belum Terisi";
}


$kpmr_stra_pilar2_3a = $result_kpmr_stra_pilar2_3a['nilai']; $kpmr_stra_respon_pil2_3a = $result_kpmr_stra_pilar2_3a['respon'];
$kpmr_stra_pilar2_3b = $result_kpmr_stra_pilar2_3b['nilai']; $kpmr_stra_respon_pil2_3b = $result_kpmr_stra_pilar2_3b['respon'];
$kpmr_stra_pilar2_3c = $result_kpmr_stra_pilar2_3c['nilai']; $kpmr_stra_respon_pil2_3c = $result_kpmr_stra_pilar2_3c['respon'];


// --- Pilar 2 Total 3 ---
$kpmr_stra_pil2_total3_average = array($kpmr_stra_pilar2_3a,
$kpmr_stra_pilar2_3b,
$kpmr_stra_pilar2_3c);
$kpmr_stra_pil2_total3_sum = array_sum($kpmr_stra_pil2_total3_average);
$kpmr_stra_pil2_total3 = $kpmr_stra_pil2_total3_sum / count($kpmr_stra_pil2_total3_average);

if ($kpmr_stra_pil2_total3 < 1.00) {
    $kpmr_stra_pil2_peringkat3 = "Belum Terisi";
} elseif ($kpmr_stra_pil2_total3 >= 1.00 && $kpmr_stra_pil2_total3 < 1.25) {
    $kpmr_stra_pil2_peringkat3 = "Sangat Memadai";
} elseif ($kpmr_stra_pil2_total3 >= 1.25 && $kpmr_stra_pil2_total3 < 2.25) {
    $kpmr_stra_pil2_peringkat3 = "Memadai";
} elseif ($kpmr_stra_pil2_total3 >= 2.25 && $kpmr_stra_pil2_total3 < 3.25) {
    $kpmr_stra_pil2_peringkat3 = "Cukup Memadai";
} elseif ($kpmr_stra_pil2_total3 >= 3.25 && $kpmr_stra_pil2_total3 < 4.25) {
    $kpmr_stra_pil2_peringkat3 = "Kurang Memadai";
} elseif ($kpmr_stra_pil2_total3 >= 4.25 && $kpmr_stra_pil2_total3 <= 5.00) {
    $kpmr_stra_pil2_peringkat3 = "Tidak Memadai";
} else {
    $kpmr_stra_pil2_peringkat3 = "Belum Terisi";
}



$kpmr_stra_pilar3_1a = $result_kpmr_stra_pilar3_1a['nilai']; $kpmr_stra_respon_pil3_1a = $result_kpmr_stra_pilar3_1a['respon'];
$kpmr_stra_pilar3_1b = $result_kpmr_stra_pilar3_1b['nilai']; $kpmr_stra_respon_pil3_1b = $result_kpmr_stra_pilar3_1b['respon'];
$kpmr_stra_pilar3_1c = $result_kpmr_stra_pilar3_1c['nilai']; $kpmr_stra_respon_pil3_1c = $result_kpmr_stra_pilar3_1c['respon'];
$kpmr_stra_pilar3_1d = $result_kpmr_stra_pilar3_1d['nilai']; $kpmr_stra_respon_pil3_1d = $result_kpmr_stra_pilar3_1d['respon'];
$kpmr_stra_pilar3_1e = $result_kpmr_stra_pilar3_1e['nilai']; $kpmr_stra_respon_pil3_1e = $result_kpmr_stra_pilar3_1e['respon'];
$kpmr_stra_pilar3_1f = $result_kpmr_stra_pilar3_1f['nilai']; $kpmr_stra_respon_pil3_1f = $result_kpmr_stra_pilar3_1f['respon'];
$kpmr_stra_pilar3_1g = $result_kpmr_stra_pilar3_1g['nilai']; $kpmr_stra_respon_pil3_1g = $result_kpmr_stra_pilar3_1g['respon'];
$kpmr_stra_pilar3_1h = $result_kpmr_stra_pilar3_1h['nilai']; $kpmr_stra_respon_pil3_1h = $result_kpmr_stra_pilar3_1h['respon'];
$kpmr_stra_pilar3_1i = $result_kpmr_stra_pilar3_1i['nilai']; $kpmr_stra_respon_pil3_1i = $result_kpmr_stra_pilar3_1i['respon'];
$kpmr_stra_pilar3_1j = $result_kpmr_stra_pilar3_1j['nilai']; $kpmr_stra_respon_pil3_1j = $result_kpmr_stra_pilar3_1j['respon'];

// --- Pilar 3 Total 1 ---
$kpmr_stra_pil3_total1_average = array($kpmr_stra_pilar3_1a,
$kpmr_stra_pilar3_1b,
$kpmr_stra_pilar3_1c,
$kpmr_stra_pilar3_1d,
$kpmr_stra_pilar3_1e,
$kpmr_stra_pilar3_1f,
$kpmr_stra_pilar3_1g,
$kpmr_stra_pilar3_1h,
$kpmr_stra_pilar3_1i,
$kpmr_stra_pilar3_1j);
$kpmr_stra_pil3_total1_sum = array_sum($kpmr_stra_pil3_total1_average);
$kpmr_stra_pil3_total1 = $kpmr_stra_pil3_total1_sum / count($kpmr_stra_pil3_total1_average);

if ($kpmr_stra_pil3_total1 < 1.00) {
    $kpmr_stra_pil3_peringkat1 = "Belum Terisi";
} elseif ($kpmr_stra_pil3_total1 >= 1.00 && $kpmr_stra_pil3_total1 < 1.25) {
    $kpmr_stra_pil3_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_stra_pil3_total1 >= 1.25 && $kpmr_stra_pil3_total1 < 2.25) {
    $kpmr_stra_pil3_peringkat1 = "Memadai";
} elseif ($kpmr_stra_pil3_total1 >= 2.25 && $kpmr_stra_pil3_total1 < 3.25) {
    $kpmr_stra_pil3_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_stra_pil3_total1 >= 3.25 && $kpmr_stra_pil3_total1 < 4.25) {
    $kpmr_stra_pil3_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_stra_pil3_total1 >= 4.25 && $kpmr_stra_pil3_total1 <= 5.00) {
    $kpmr_stra_pil3_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_stra_pil3_peringkat1 = "Belum Terisi";
}


$kpmr_stra_pilar3_2a = $result_kpmr_stra_pilar3_2a['nilai']; $kpmr_stra_respon_pil3_2a = $result_kpmr_stra_pilar3_2a['respon'];
$kpmr_stra_pilar3_2b = $result_kpmr_stra_pilar3_2b['nilai']; $kpmr_stra_respon_pil3_2b = $result_kpmr_stra_pilar3_2b['respon'];
$kpmr_stra_pilar3_2c = $result_kpmr_stra_pilar3_2c['nilai']; $kpmr_stra_respon_pil3_2c = $result_kpmr_stra_pilar3_2c['respon'];
$kpmr_stra_pilar3_2d = $result_kpmr_stra_pilar3_2d['nilai']; $kpmr_stra_respon_pil3_2d = $result_kpmr_stra_pilar3_2d['respon'];
$kpmr_stra_pilar3_2e = $result_kpmr_stra_pilar3_2e['nilai']; $kpmr_stra_respon_pil3_2e = $result_kpmr_stra_pilar3_2e['respon'];

// --- Pilar 3 Total 2 ---
$kpmr_stra_pil3_total2_average = array($kpmr_stra_pilar3_2a,
$kpmr_stra_pilar3_2b,
$kpmr_stra_pilar3_2c,
$kpmr_stra_pilar3_2d,
$kpmr_stra_pilar3_2e);
$kpmr_stra_pil3_total2_sum = array_sum($kpmr_stra_pil3_total2_average);
$kpmr_stra_pil3_total2 = $kpmr_stra_pil3_total2_sum / count($kpmr_stra_pil3_total2_average);

if ($kpmr_stra_pil3_total2 < 1.00) {
    $kpmr_stra_pil3_peringkat2 = "Belum Terisi";
} elseif ($kpmr_stra_pil3_total2 >= 1.00 && $kpmr_stra_pil3_total2 < 1.25) {
    $kpmr_stra_pil3_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_stra_pil3_total2 >= 1.25 && $kpmr_stra_pil3_total2 < 2.25) {
    $kpmr_stra_pil3_peringkat2 = "Memadai";
} elseif ($kpmr_stra_pil3_total2 >= 2.25 && $kpmr_stra_pil3_total2 < 3.25) {
    $kpmr_stra_pil3_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_stra_pil3_total2 >= 3.25 && $kpmr_stra_pil3_total2 < 4.25) {
    $kpmr_stra_pil3_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_stra_pil3_total2 >= 4.25 && $kpmr_stra_pil3_total2 <= 5.00) {
    $kpmr_stra_pil3_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_stra_pil3_peringkat2 = "Belum Terisi";
}



    $result_kpmr_stra_pilar4_1a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_1a','respon_unit_kerja_stratejik_pil4','respon_pil4_1a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar4_1b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_1b','respon_unit_kerja_stratejik_pil4','respon_pil4_1b',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar4_1c = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_1c','respon_unit_kerja_stratejik_pil4','respon_pil4_1c',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar4_1d = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_1d','respon_unit_kerja_stratejik_pil4','respon_pil4_1d',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar4_1e = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_1e','respon_unit_kerja_stratejik_pil4','respon_pil4_1e',$tahun,$periode,1,5);

    $result_kpmr_stra_pilar4_2a = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_2a','respon_unit_kerja_stratejik_pil4','respon_pil4_2a',$tahun,$periode,1,5);
    $result_kpmr_stra_pilar4_2b = getMaxValueWithResponUser($conn,'kpmr_stratejik_pilar4','pilar4_2b','respon_unit_kerja_stratejik_pil4','respon_pil4_2b',$tahun,$periode,1,5);
   



$kpmr_stra_pilar4_1a = $result_kpmr_stra_pilar4_1a['nilai']; $kpmr_stra_respon_pil4_1a = $result_kpmr_stra_pilar4_1a['respon'];
$kpmr_stra_pilar4_1b = $result_kpmr_stra_pilar4_1b['nilai']; $kpmr_stra_respon_pil4_1b = $result_kpmr_stra_pilar4_1b['respon'];
$kpmr_stra_pilar4_1c = $result_kpmr_stra_pilar4_1c['nilai']; $kpmr_stra_respon_pil4_1c = $result_kpmr_stra_pilar4_1c['respon'];
$kpmr_stra_pilar4_1d = $result_kpmr_stra_pilar4_1d['nilai']; $kpmr_stra_respon_pil4_1d = $result_kpmr_stra_pilar4_1d['respon'];
$kpmr_stra_pilar4_1e = $result_kpmr_stra_pilar4_1e['nilai']; $kpmr_stra_respon_pil4_1e = $result_kpmr_stra_pilar4_1e['respon'];

$kpmr_stra_pilar4_2a = $result_kpmr_stra_pilar4_2a['nilai']; $kpmr_stra_respon_pil4_2a = $result_kpmr_stra_pilar4_2a['respon'];
$kpmr_stra_pilar4_2b = $result_kpmr_stra_pilar4_2b['nilai']; $kpmr_stra_respon_pil4_2b = $result_kpmr_stra_pilar4_2b['respon'];



// --- Pilar 3 Total 1 ---
$kpmr_stra_pil4_total1_average = array($kpmr_stra_pilar4_1a,
$kpmr_stra_pilar4_1b,
$kpmr_stra_pilar4_1c,
$kpmr_stra_pilar4_1d,
$kpmr_stra_pilar4_1e);
$kpmr_stra_pil4_total1_sum = array_sum($kpmr_stra_pil4_total1_average);
$kpmr_stra_pil4_total1 = $kpmr_stra_pil4_total1_sum / count($kpmr_stra_pil4_total1_average);

if ($kpmr_stra_pil4_total1 < 1.00) {
    $kpmr_stra_pil4_peringkat1 = "Belum Terisi";
} elseif ($kpmr_stra_pil4_total1 >= 1.00 && $kpmr_stra_pil4_total1 < 1.25) {
    $kpmr_stra_pil4_peringkat1 = "Sangat Memadai";
} elseif ($kpmr_stra_pil4_total1 >= 1.25 && $kpmr_stra_pil4_total1 < 2.25) {
    $kpmr_stra_pil4_peringkat1 = "Memadai";
} elseif ($kpmr_stra_pil4_total1 >= 2.25 && $kpmr_stra_pil4_total1 < 3.25) {
    $kpmr_stra_pil4_peringkat1 = "Cukup Memadai";
} elseif ($kpmr_stra_pil4_total1 >= 3.25 && $kpmr_stra_pil4_total1 < 4.25) {
    $kpmr_stra_pil4_peringkat1 = "Kurang Memadai";
} elseif ($kpmr_stra_pil4_total1 >= 4.25 && $kpmr_stra_pil4_total1 <= 5.00) {
    $kpmr_stra_pil4_peringkat1 = "Tidak Memadai";
} else {
    $kpmr_stra_pil4_peringkat1 = "Belum Terisi";
}


$kpmr_stra_pilar4_1a = $result_kpmr_stra_pilar4_1a['nilai']; $kpmr_stra_respon_pil4_1a = $result_kpmr_stra_pilar4_1a['respon'];
$kpmr_stra_pilar4_1b = $result_kpmr_stra_pilar4_1b['nilai']; $kpmr_stra_respon_pil4_1b = $result_kpmr_stra_pilar4_1b['respon'];

// --- Pilar 2 Total 2 ---
$kpmr_stra_pil4_total2_average = array($kpmr_stra_pilar4_1a,
$kpmr_stra_pilar4_1b);
$kpmr_stra_pil4_total2_sum = array_sum($kpmr_stra_pil4_total2_average);
$kpmr_stra_pil4_total2 = $kpmr_stra_pil4_total2_sum / count($kpmr_stra_pil4_total2_average);

if ($kpmr_stra_pil4_total2 < 1.00) {
    $kpmr_stra_pil4_peringkat2 = "Belum Terisi";
} elseif ($kpmr_stra_pil4_total2 >= 1.00 && $kpmr_stra_pil4_total2 < 1.25) {
    $kpmr_stra_pil4_peringkat2 = "Sangat Memadai";
} elseif ($kpmr_stra_pil4_total2 >= 1.25 && $kpmr_stra_pil4_total2 < 2.25) {
    $kpmr_stra_pil4_peringkat2 = "Memadai";
} elseif ($kpmr_stra_pil4_total2 >= 2.25 && $kpmr_stra_pil4_total2 < 3.25) {
    $kpmr_stra_pil4_peringkat2 = "Cukup Memadai";
} elseif ($kpmr_stra_pil4_total2 >= 3.25 && $kpmr_stra_pil4_total2 < 4.25) {
    $kpmr_stra_pil4_peringkat2 = "Kurang Memadai";
} elseif ($kpmr_stra_pil4_total2 >= 4.25 && $kpmr_stra_pil4_total2 <= 5.00) {
    $kpmr_stra_pil4_peringkat2 = "Tidak Memadai";
} else {
    $kpmr_stra_pil4_peringkat2 = "Belum Terisi";
}


        
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
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 1"));
    $pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar2 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 1"));
    $pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 
    INNER JOIN frame_laporan_profil_risiko ON master_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 1"));
    
    //data master likuditas
    $data_lik_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_likuiditas_pilar1
    INNER JOIN frame_laporan_profil_risiko ON master_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
    WHERE tahun = '$tahun' AND  periode ='$periode' AND user = 1"));

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
        $aset_produktif_bermasalah = $pil2['aset_produktif_bermasalah'];
        $total_aset_produktif = $pil2['total_aset_produktif'];
        $kredit_bermasalah = $pil2['kredit_bermasalah'];
        $modal_inti = $pil2['modal_inti'];
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


//////////////////////INI RUMUS///////////////////////////////////////////////


$inheren_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM setting_risiko_inheren_kredit WHERE user = '$user' AND tahun = '$tahun' AND periode = '$periode'"));

$ambang_batas_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ambang_batas_kredit WHERE tahun = '$tahun'"));
$bobot_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

//pembobotan
$pembobotan_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bobot_kredit_per_parameter WHERE tahun = '$tahun'"));
$bobot1 = $pembobotan_kredit['sub_parameter1'];
$bobot2 = $pembobotan_kredit['sub_parameter2'];
$bobot3 = $pembobotan_kredit['sub_parameter3'];
$bobot4 = $pembobotan_kredit['sub_parameter4'];
$bobot5 = $pembobotan_kredit['sub_parameter5'];
$bobot6 = $pembobotan_kredit['sub_parameter6'];
$bobot7 = $pembobotan_kredit['sub_parameter7'];
$bobot8 = $pembobotan_kredit['sub_parameter8'];
$bobot2_1 = $pembobotan_kredit['sub_parameter2_1'];
$bobot2_2 = $pembobotan_kredit['sub_parameter2_2'];
$bobot2_3 = $pembobotan_kredit['sub_parameter2_3'];
$bobot2_4 = $pembobotan_kredit['sub_parameter2_4'];
$bobot2_5 = $pembobotan_kredit['sub_parameter2_5'];
$bobot2_6 = $pembobotan_kredit['sub_parameter2_6'];
$bobot2_7 = $pembobotan_kredit['sub_parameter2_7'];
$bobot2_8 = $pembobotan_kredit['sub_parameter2_8'];
$bobot2_9 = $pembobotan_kredit['sub_parameter2_9'];
$bobot2_10 = $pembobotan_kredit['sub_parameter2_10'];
$bobot2_11 = $pembobotan_kredit['sub_parameter2_11'];
$bobot3_1 = $pembobotan_kredit['sub_parameter3_1'];
$bobot3_2 = $pembobotan_kredit['sub_parameter3_2'];
$bobot3_3 = $pembobotan_kredit['sub_parameter3_3'];
$bobot3_4 = $pembobotan_kredit['sub_parameter3_4'];
$bobot3_5 = $pembobotan_kredit['sub_parameter3_5'];
$bobot3_6 = $pembobotan_kredit['sub_parameter3_6'];
$bobot4_1 = $pembobotan_kredit['sub_parameter4_1'];
$bobot4_2 = $pembobotan_kredit['sub_parameter4_2'];
$bobot4_3 = $pembobotan_kredit['sub_parameter4_3'];
$bobot4_4 = $pembobotan_kredit['sub_parameter4_4'];
$bobot5_1 = $pembobotan_kredit['sub_parameter5_1'];
$bobot6_1 = $pembobotan_kredit['sub_parameter6_1'];
$bobot6_2 = $pembobotan_kredit['sub_parameter6_2'];
$bobot6_3 = $pembobotan_kredit['sub_parameter6_3'];
$bobot6_4 = $pembobotan_kredit['sub_parameter6_4'];
$bobot7_1 = $pembobotan_kredit['sub_parameter7_1'];
$bobot7_2 = $pembobotan_kredit['sub_parameter7_2'];
$bobot7_3 = $pembobotan_kredit['sub_parameter7_3'];
$bobot7_4 = $pembobotan_kredit['sub_parameter7_4'];
$bobot7_5 = $pembobotan_kredit['sub_parameter7_5'];
$bobot7_6 = $pembobotan_kredit['sub_parameter7_6'];
$bobot7_7 = $pembobotan_kredit['sub_parameter7_7'];
$bobot7_8 = $pembobotan_kredit['sub_parameter7_8'];
$bobot7_9 = $pembobotan_kredit['sub_parameter7_9'];
$bobot7_10 = $pembobotan_kredit['sub_parameter7_10'];
$bobot7_11 = $pembobotan_kredit['sub_parameter7_11'];

//setingan ditetapkan
$kredit_pil1_risiko_ditetapkan = $inheren_kredit['inheren_kre_set_pil1'];
$kredit_pil2_risiko_ditetapkan = $inheren_kredit['inheren_kre_set_pil2'];
$kredit_pil3_risiko_ditetapkan = $inheren_kredit['inheren_kre_set_pil3'];
$kredit_set_tingkat_risiko = $inheren_kredit['inheren_kre_set_tingkat_risiko'];

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
$pilar2_p1a = round(($saldo_ppap / $kyd) * 100, 2);
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


$pilar3_p1c_pertumbuhan_kredit = round(($osc_bln_penilaian - $osc_1bln_sebelumnya) / $osc_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_noa = round(($noa_bln_penilaian - $noa_1bln_sebelumnya) / $noa_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_rasio_npl = round(($rasio_npl_bln_penilaian - $rasio_npl_1bln_sebelumnya) / $rasio_npl_bln_penilaian * 100, 2);
$pilar3_p1c_pertumbuhan_noa_npl = round(($noa_npl_bln_penilaian - $noa_npl_1bln_sebelumnya) / $noa_npl_bln_penilaian * 100, 2);

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
} else if ($pilar3_p1c_pertumbuhan_kredit > $pilar3_p1c_pertumbuhan_rasio_npl_tambah) {
    $hsl_pil3_par1c_rumus = 3;
} else {
    $hsl_pil3_par1c_rumus = 4;
}

$nilai_pil3_par1c = round(($hsl_pil3_par1c_rumus + $hsl_pil3_par1c) / 2, 2);









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









$ab = $ambang_batas_kredit['ap_per_ta'];
if ($p1 > $ab) {
    $hsl1 = 3;
} else {
    $hsl1 = 1;
}

//par1a
$aba1 = $ambang_batas_kredit['pbl_per_tap'];
$ab2a = $ambang_batas_kredit['rr_pbl_per_tap'];
$ab3a = $ambang_batas_kredit['rrr_pbl_per_tap'];
$ab4a = $ambang_batas_kredit['rrrr_pbl_per_tap'];
if ($p1a <= $aba1) {
    $hsl1a = 1;
} else if ($p1a > $aba1 && $p1a <= $ab2a) {
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
} else if ($plb > $abc && $plb <= $ab2c) {
    $hsl1c = 2;
} else if ($plb > $ab2c && $plb <= $ab3c) {
    $hsl1c = 3;
} elseif ($plb > $ab3c && $plb <= $ab4c) {
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
$para2_ab4n = $ambang_batas_kredit['rrrr_kp350_per_tkydd'];
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


//par1g
$ab_pil2_par1a = $ambang_batas_kredit['sppap_per_tk'];
$ab_pil2_par12a = $ambang_batas_kredit['rr_sppap_per_tk'];
$ab_pil2_par13a = $ambang_batas_kredit['rrr_sppap_per_tk'];
$ab_pil2_par14a = $ambang_batas_kredit['rrrr_sppap_per_tk'];
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




$koreksi = $nilai1a + $nilai1b + $nilai1c + $nilai2f + $nilai2m + $nilai2n + $nilai_pil2_par1a + $nilai_pil2_par1b;


if ($hsl1 == 3) {
    $nilai = $hsl1;
} else {
    $nilai = ($hsl1 + $koreksi) / 2;
}






//pil2




$para2_ab = $ambang_batas_kredit['kyd_per_ap'];
if ($p2 <= $para2_ab) {
    $hsl2 = 1;
} else {
    $hsl2 = 0;
}

//par2a
$para2_aba = $ambang_batas_kredit['kspg_per_tk'];
$para2_ab2a = $ambang_batas_kredit['rr_kspg_per_tk'];
$para2_ab3a = $ambang_batas_kredit['rrr_kspg_per_tk'];
$para2_ab4a = $ambang_batas_kredit['rrrr_kspg_per_tk'];
if ($p2a <= $para2_aba) {
    $hsl2a = 1;
} else if ($p2a > $para2_aba && $p2a <= $para2_ab2a) {
    $hsl2a = 2;
} else if ($p2a > $para2_ab2a && $p2a <= $para2_ab3a) {
    $hsl2a = 3;
} elseif ($p2a > $para2_ab3a && $p2a <= $para2_ab4a) {
    $hsl2a = 4;
} else {
    $hsl2a = 5;
}


$nilai2a = $hsl2a * $bobot2_1;

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


if ($hsl2 == 0) {
    $nilai2 = $koreksi2;
} else {
    $nilai2 = ($hsl2 + $koreksi2) / 2;
}






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


$nilai_pil2_par1 = $hsl_pil2_par1;














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
$ab_pil2_par22d = $ambang_batas_kredit['rr_nkdpskmht_per_tkyd'];
$ab_pil2_par23d = $ambang_batas_kredit['rrr_nkdpskmht_per_tkyd'];
$ab_pil2_par24d = $ambang_batas_kredit['rrrr_nkdpskmht_per_tkyd'];
if ($pilar2_p2d <= $ab_pil2_par2d) {
    $hsl_pil2_par2d = 1;
} else if ($pilar2_p2d > $ab_pil2_par2d && $pilar2_p2d <= $ab_pil2_par22d) {
    $hsl_pil2_par2d = 2;
} else if ($pilar2_p2d > $ab_pil2_par22d && $pilar2_p2d <= $ab_pil2_par23d) {
    $hsl_pil2_par2d = 3;
} elseif ($pilar2_p2d > $ab_pil2_par23d && $pilar2_p2d <= $ab_pil2_par24d) {
    $hsl_pil2_par2d = 4;
} else {
    $hsl_pil2_par2d = 5;
}


$nilai_pil2_par2d = $hsl_pil2_par2d * $bobot3_4;



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



$pilar1_values = [$nilai, $nilai2, $pilar1_par3, $pilar1_par4];
$tertinggi_pil1 = max($pilar1_values);
$terendah_pil1 = min($pilar1_values);
$rata_rata_pil1 = array_sum($pilar1_values) / count($pilar1_values);



// Tentukan peringkat inheren
if($risiko_pil1 < 1.00){
    $peringkat_inheren = " ";
} elseif($risiko_pil1 <= 1.25){
    $peringkat_inheren = "Sangat Rendah";
} elseif($risiko_pil1 <= 2.25){
    $peringkat_inheren = "Rendah";
} elseif($risiko_pil1 <= 3.25){
    $peringkat_inheren = "Sedang";
} elseif($risiko_pil1 <= 4.25){
    $peringkat_inheren = "Tinggi";
} elseif($risiko_pil1 <= 5.00){
    $peringkat_inheren = "Sangat Tinggi";
} else {
    $peringkat_inheren = " ";
}





// Hitung koreksi & nilai untuk par3
$koreksippl1_par3 = $kredit_pilar1_3;
if ($hsl3 == 0) {
    $nilaippl1_par3 = $kredit_pilar1_3;
} else {
    $nilaippl1_par3 = ($hsl3 + $kredit_pilar1_3) / 2;
}
$nilaippl1_par3 = round($nilaippl1_par3, 2);

// Hitung koreksi & nilai untuk par4
$koreksippl1_par4 = $kredit_pilar1_4;
if ($hsl4 == 0) {
    $nilaippl1_par4 = $kredit_pilar1_4;
} else {
    $nilaippl1_par4 = ($hsl4 + $kredit_pilar1_4) / 2;
}
$nilaippl1_par4 = round($nilaippl1_par4, 2);


// Cari nilai tertinggi, terendah, rata-rata
$values_pil1   = [$nilai, $nilai2, $nilaippl1_par3, $nilaippl1_par4];

$kredit_pil1_tertinggi = round(max($values_pil1), 2);
$kredit_pil1_terendah  = round(min($values_pil1), 2);
$kredit_pil1_rata_rata = round(array_sum($values_pil1) / count($values_pil1), 2);

if ($kredit_pil1_risiko_ditetapkan == 1) {
$kredit_pil1_tingkat_risiko = round(max($values_pil1), 2);
}
else if ($kredit_pil1_risiko_ditetapkan == 2) {
$kredit_pil1_tingkat_risiko  = round(min($values_pil1), 2);
}
else if ($kredit_pil1_risiko_ditetapkan == 3) {
$kredit_pil1_tingkat_risiko = round(array_sum($values_pil1) / count($values_pil1), 2);
}
else {
$kredit_pil1_tingkat_risiko = 0;
}




// --- Hitung nilai par 333333333333 ---


if ($hsl_pil3_par1 > $kredit_pilar3_1) {
    $nilaippl3_par1 = round($hsl_pil3_par1, 2);
} elseif ($hsl_pil3_par1 == $kredit_pilar3_1) {
    $nilaippl3_par1 = round($hsl_pil3_par1, 2);
} else {
    $nilaippl3_par1 = round(($hsl_pil3_par1 + $kredit_pilar3_1) / 2, 2);
}

// --- Hitung nilai par1a ---
if ($hsl_pil3_par1a > $kredit_pilar3_1a) {
    $nilaippl3_par1a = round($hsl_pil3_par1a, 2);
} elseif ($hsl_pil3_par1a == $kredit_pilar3_1a) {
    $nilaippl3_par1a = round($hsl_pil3_par1a, 2);
} else {
    $nilaippl3_par1a = round(($hsl_pil3_par1a + $kredit_pilar3_1a) / 2, 2);
}

// --- Hitung nilai par1b ---
if ($hsl_pil3_par1b > $kredit_pilar3_1b) {
    $nilaippl3_par1b = round($hsl_pil3_par1b, 2);
} elseif ($hsl_pil3_par1b == $kredit_pilar3_1b) {
    $nilaippl3_par1b = round($hsl_pil3_par1b, 2);
} else {
    $nilaippl3_par1b = round(($hsl_pil3_par1b + $kredit_pilar3_1b) / 2, 2);
}

// --- Hitung nilai par1c ---
if ($hsl_pil3_par1c > $kredit_pilar3_1c) {
    $nilaippl3_par1c = round($hsl_pil3_par1c, 2);
} elseif ($hsl_pil3_par1c == $kredit_pilar3_1c) {
    $nilaippl3_par1c = round($hsl_pil3_par1c, 2);
} else {
    $nilaippl3_par1c = round(($hsl_pil3_par1c + $kredit_pilar3_1c) / 2, 2);
}

// --- Hitung nilai par1d ---
if ($hsl_pil3_par1d == 0) {
    $nilaippl3_par1d = $kredit_pilar3_1d;
} else {
    $nilaippl3_par1d = round(($hsl_pil3_par1d + $kredit_pilar3_1d) / 2, 2);
}

// --- Hitung nilai par1e ---
if ($hsl_pil3_par1e == 0) {
    $nilaippl3_par1e = $kredit_pilar3_1e;
} else {
    $nilaippl3_par1e = round(($hsl_pil3_par1e + $kredit_pilar3_1e) / 2, 2);
}

// --- Hitung tertinggi, terendah, rata-rata ---
$values_pil3 = [
    $nilaippl3_par1, 
    $nilaippl3_par1a, 
    $nilaippl3_par1b, 
    $nilaippl3_par1c, 
    $nilaippl3_par1d, 
    $nilaippl3_par1e
];

$tertinggi_pil3 = round(max($values_pil3), 2);
$terendah_pil3  = round(min($values_pil3), 2);
$rata_rata_pil3 = round(array_sum($values_pil3) / count($values_pil3), 2);

// --- Tentukan risiko_pil3 berdasarkan set_pil1 ---
$set_pil1 = isset($set_pil1) ? $set_pil1 : 1; // default 1
if ($set_pil1 == 1) {
    $risiko_pil3 = $tertinggi_pil3;
} elseif ($set_pil1 == 2) {
    $risiko_pil3 = $terendah_pil3;
} elseif ($set_pil1 == 3) {
    $risiko_pil3 = $rata_rata_pil3;
} else {
    $risiko_pil3 = 0;
}

// --- Hitung nilai masing-masing parameter ---
$nilaippl4_par1a = round($kredit_pilar4_1a * $bobot6_1, 2);
$nilaippl4_par1b = round($kredit_pilar4_1b * $bobot6_2, 2);
$nilaippl4_par1c = round($kredit_pilar4_1c * $bobot6_3, 2);
$nilaippl4_par1d = round($kredit_pilar4_1d * $bobot6_4, 2);

// --- Hitung total / risiko pilar 4 ---
$kredit4_total_rata_rata = $nilaippl4_par1a + $nilaippl4_par1b + $nilaippl4_par1c + $nilaippl4_par1d;
$kredit_risiko_pil4     = round($kredit4_total_rata_rata, 2);

// --- Hitung nilai masing-masing parameter ---
$nilaippl5_par1a = round($kredit_pilar5_1a * $bobot7_1, 2);
$nilaippl5_par1b = round($kredit_pilar5_1b * $bobot7_2, 2);
$nilaippl5_par1c = round($kredit_pilar5_1c * $bobot7_3, 2);
$nilaippl5_par1d = round($kredit_pilar5_1d * $bobot7_4,62);
$nilaippl5_par1e = round($kredit_pilar5_1e * $bobot7_5, 2);
$nilaippl5_par1f = round($kredit_pilar5_1f * $bobot7_6, 2);
$nilaippl5_par1g = round($kredit_pilar5_1g * $bobot7_7, 2);
$nilaippl5_par1h = round($kredit_pilar5_1h * $bobot7_8, 2);
$nilaippl5_par1i = round($kredit_pilar5_1i * $bobot7_9, 2);
$nilaippl5_par1j = round($kredit_pilar5_1j * $bobot7_10, 2);
$nilaippl5_par1k = round($kredit_pilar5_1k * $bobot7_11, 2);

// --- Hitung total / risiko pilar 4 ---
$kredit5_total_rata_rata = $nilaippl5_par1a + $nilaippl5_par1b + $nilaippl5_par1c + $nilaippl5_par1d + $nilaippl5_par1e + $nilaippl5_par1f + $nilaippl5_par1g + $nilaippl5_par1h + $nilaippl5_par1i + $nilaippl5_par1j+ $nilaippl5_par1k;
$kredit_risiko_pil5     = round($kredit5_total_rata_rata, 2);




        // Jika pembuatan laporan berasal dari tab Profil Risiko Konsol, gunakan
        // Modal Inti dan Total Aset yang diisi pada form. Menu final lama
        // tetap memakai nilai hasil perhitungan sumber saat field tidak dikirim.
        if ($modal_inti_form !== '') {
            $modal_inti = $modal_inti_form;
        }
        if ($total_aset_form !== '') {
            $total_aset = $total_aset_form;
        }

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
    
            $hasil_pil1_par1 = $nilai;
            $hasil_pil1_par1a = $nilai1a;
            $hasil_pil1_par1b = $nilai1b;
            $hasil_pil1_par1c = $nilai1c;
            $hasil_pil1_par1d = $nilai2f;
            $hasil_pil1_par1e = $nilai2m;
            $hasil_pil1_par1f = $nilai2n;
            $hasil_pil1_par1g = $nilai_pil2_par1a;
            $hasil_pil1_par1h = $nilai_pil2_par1b;
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
    
    
            mysqli_query($conn, "INSERT INTO inheren_kredit_pilar1(id_inheren_kredit_pilar1,id_profil_risiko,dibuat_by,
            hasil_pil1_par1,
            hasil_pil1_par1a,
            hasil_pil1_par1b,
            hasil_pil1_par1c,
            hasil_pil1_par1d,
            hasil_pil1_par1e,
            hasil_pil1_par1f,
            hasil_pil1_par1g,
            hasil_pil1_par1h,
            hasil_pil1_par2,
            hasil_pil1_par2a,
            hasil_pil1_par2b,
            hasil_pil1_par2c,
            hasil_pil1_par2d,
            hasil_pil1_par2e,
            hasil_pil1_par2f,
            hasil_pil1_par2g,
            hasil_pil1_par2h,
            hasil_pil1_par2i,
            hasil_pil1_par2j,
            hasil_pil1_par2k,
            hasil_pil1_par3,
            hasil_pil1_par4,
            pilar1_3,
            pilar1_4)
            VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
            '$hasil_pil1_par1',
            '$hasil_pil1_par1a',
            '$hasil_pil1_par1b',
            '$hasil_pil1_par1c',
            '$hasil_pil1_par1d',
            '$hasil_pil1_par1e',
            '$hasil_pil1_par1f',
            '$hasil_pil1_par1g',
            '$hasil_pil1_par1h',
            '$hasil_pil1_par2',
            '$hasil_pil1_par2a',
            '$hasil_pil1_par2b',
            '$hasil_pil1_par2c',
            '$hasil_pil1_par2d',
            '$hasil_pil1_par2e',
            '$hasil_pil1_par2f',
            '$hasil_pil1_par2g',
            '$hasil_pil1_par2h',
            '$hasil_pil1_par2i',
            '$hasil_pil1_par2j',
            '$hasil_pil1_par2k',
            '$nilaippl1_par3',
            '$nilaippl1_par4',
            '$kredit_pilar1_3',
            '$kredit_pilar1_4')");
            
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
            '$nilaippl3_par1',
            '$nilaippl3_par1a',
            '$nilaippl3_par1b',
            '$nilaippl3_par1c',
            '$nilaippl3_par1d',
            '$nilaippl3_par1e')");
            
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
            '$kredit_risiko_pil4',
            '$nilaippl4_par1a',
            '$nilaippl4_par1b',
            '$nilaippl4_par1c',
            '$nilaippl4_par1d')");
    
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
            hasil_pil5_par1e,
            hasil_pil5_par1f,
            hasil_pil5_par1g,
            hasil_pil5_par1h,
            hasil_pil5_par1i,
            hasil_pil5_par1j,
            hasil_pil5_par1k)
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
            '$nilaippl5_par1a',
            '$nilaippl5_par1b',
            '$nilaippl5_par1c',
            '$nilaippl5_par1d',
            '$nilaippl5_par1e',
            '$nilaippl5_par1f',
            '$nilaippl5_par1g',
            '$nilaippl5_par1h',
            '$nilaippl5_par1i',
            '$nilaippl5_par1j',
            '$nilaippl5_par1k')");
            
            mysqli_query($conn, "INSERT INTO hasil_inheren_kredit(id_hasil_inheren_kredit,id_profil_risiko,dibuat_by,
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
            pil4_tingkat_risiko,
            pil5_tertinggi,
            pil5_terendah,
            pil5_rata_rata,
            pil5_tingkat_risiko,
            hasil_inheren_tertinggi,
            hasil_inheren_terendah,
            hasil_inheren_rata_rata,
            hasil_risiko_ditetapkan,
            hasil_tingkat_risiko,
            hasil_peringkat)
            VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
            '$kredit_pil1_tertinggi',
        '$kredit_pil1_terendah',
        '$kredit_pil1_rata_rata',
        '$kredit_pil1_risiko_ditetapkan',
        '$kredit_pil1_tingkat_risiko',
        '$kredit_pil2_tertinggi',
        '$kredit_pil2_terendah',
        '$kredit_pil2_rata_rata',
        '$kredit_pil2_risiko_ditetapkan',
        '$kredit_pil2_tingkat_risiko',
        '$kredit_pil3_tertinggi',
        '$kredit_pil3_terendah',
        '$kredit_pil3_rata_rata',
        '$kredit_pil3_risiko_ditetapkan',
        '$kredit_pil3_tingkat_risiko',
        '$kredit_pil4_tertinggi',
        '$kredit_pil4_terendah',
        '$kredit_pil4_rata_rata',
        '$kredit_pil4_tingkat_risiko',
        '$kredit_pil5_tertinggi',
        '$kredit_pil5_terendah',
        '$kredit_pil5_rata_rata',
        '$kredit_pil5_tingkat_risiko',
        '$kredit_hasil_inheren_tertinggi',
        '$kredit_hasil_inheren_terendah',
        '$kredit_hasil_inheren_rata_rata',
        '$kredit_hasil_risiko_ditetapkan',
        '$kredit_hasil_tingkat_risiko',
        '$kredit_hasil_peringkat')");
            
    
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
            '$kepatuhan_pilar1_1',
            '$kepatuhan_pilar1_1a',
            '$kepatuhan_pilar1_1b',
            '$kepatuhan_pilar1_1c',
            '$kepatuhan_pilar1_1d',
            '$kepatuhan_pilar1_1e',
            '$kepatuhan_pilar1_1f',
            '$kepatuhan_pilar1_1g',
            '$kepatuhan_pilar1_2',
            '$kepatuhan_pilar1_2a',
            '$kepatuhan_pilar1_2b',
            '$kepatuhan_pilar1_2c',
            '$kepatuhan_pilar1_2d',
            '$kepatuhan_pilar1_2e',
            '$kepatuhan_pilar1_2f',
            '$kepatuhan_pilar1_2g',
            '$kepatuhan_pilar1_2h',
            '$kepatuhan_average_pil1_1',
            '$kepatuhan_average_pil1_2',
            '$kepatuhan_min_pil1_1',
            '$kepatuhan_min_pil1_2',
            '$kepatuhan_max_pil1_1',
            '$kepatuhan_max_pil1_2',
            '$kepatuhan_hasil_pil1_par1',
            '$kepatuhan_hasil_pil1_par2')");
    
            mysqli_query($conn, "INSERT INTO inheren_kepatuhan_pilar2(id_inheren_kepatuhan_pilar2,id_profil_risiko,dibuat_by,
            pilar2_1,
            pilar2_1a,
            pilar2_2,
            pilar2_2a,
            pilar2_3,
            pilar2_3a)
            VALUES ('0',(select id_profil_risiko from frame_laporan_profil_risiko WHERE kantor_cabang = '$lokasi_kerja' AND tahun = '$tahun' AND user = '$user' AND periode = '$periode' ),'$dibuat_by',
            '$kepatuhan_pilar2_1',
            '$kepatuhan_pilar2_1a',
            '$kepatuhan_pilar2_2',
            '$kepatuhan_pilar2_2a',
            '$kepatuhan_pilar2_3',
            '$kepatuhan_pilar2_3a')");
    
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
            '$kepatuhan_pilar3_1a',
            '$kepatuhan_pilar3_1b',
            '$kepatuhan_pilar3_1c',
            '$kepatuhan_pilar3_1d',
            '$kepatuhan_pilar3_1e',
            '$kepatuhan_pilar3_1f',
            '$kepatuhan_pilar3_1g',
            '$kepatuhan_average_pil3_1',
            '$kepatuhan_min_pil3_1',
            '$kepatuhan_max_pil3_1',
            '$kepatuhan_hasil_pil3_par1')");
    
    
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
    
            $redirectTarget = (isset($_POST['redirect_to']) && $_POST['redirect_to'] === 'menulapawal_final')
                ? 'index.php?page=menulapawal&tab=final#tab-profil-risiko-final'
                : 'index.php?page=menu_final';
            header("Location: " . $redirectTarget);
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Buat laporan</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Profil Risiko Konsolidasi Final</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Profil Risiko Final Konsolidasi</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User

                            </p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signup-modal">Tambah Laporan</button>
                            <div id="signup-modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                        <div class="modal-body">

                                            <div class="text-center mt-2 mb-4">

                                                <h4><b>LAPORAN FINAL</b></h4>

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

                                                <div class="mb-3">
                                                    <label for="user" class="form-label">Jenis Profil Risiko</label>

                                                    <select class="form-select mb-3" name="user" id="user" required="">
                                                    <option value=" " selected> </option>
                                                                <?php
                                                                include "../conn/conn.php";
                                                                $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko WHERE id_user_profil_risiko IN (4,6)");
                                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                    <option value="<?= $data['id_user_profil_risiko'] ?>"><?= ucwords($data['tipe_user']) ?></option>
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
                                                    <center>Tgl Lock</center>
                                                </th>
                                                <th>
                                                    <center>Kunci Laporan</center>
                                                </th>
                                                <th>
                                                    <center>Laporan Full</center>
                                                </th>
                                                <th>
                                                    <center>upload pdf</center>
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
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE frame_laporan_profil_risiko.kantor_cabang = '$kode_kantor' AND user IN (4,6) order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                    <center>
                                                            <a href="index.php?page=menu_final&id=<?= $data['id_profil_risiko'] ?>">
                                                                <i>
                                                                    <input type="checkbox" form="my_form" id="selected_id" name="selected_id"
                                                                        <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled>
                                                                </i>
                                                                aktifkan
                                                            </a>
                                                            |

                                                        <a href="../admin/pembanding/cetak_laporan_final.php?id=<?= $data['id_profil_risiko'] ?>" target="_blank">cetak</a>
                                                        |
                                                        <a href="index.php?page=delete_final&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');">
                                                            <i class="mdi mdi-delete"></i>hapus
                                                        </a>
                                                    </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <?php if (is_null($data['tgl_lock']) || $data['tgl_lock'] == '0000-00-00'): ?>
                                                                <span>Belum di-lock</span>
                                                            <?php else: ?>
                                                                <?= $data['tgl_lock'] ?>
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a href="index.php?page=lock&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin lock data?');"> lock</a>
                                                            |
                                                            <a href="index.php?page=unlock&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin unlock data');"> unlock</a>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center><a href="#" class="open-modal" data-id="<?= $data['id_profil_risiko'] ?>">cetak full</a></center>
                                                    </td>
                                                    <td>
                                                    <center>
                                                        <?php
                                                        // Cek apakah item_id ada di tabel files
                                                        $itemId = $data['id_profil_risiko'];
                                                        $checkQuery = mysqli_query($conn, "SELECT 1 FROM files WHERE item_id = '$itemId' LIMIT 1");
                                                        if (mysqli_num_rows($checkQuery) > 0) {
                                                            echo '<span class="text-success">Sudah Upload</span>';
                                                        } else {
                                                            echo '<a href="#" class="open-modal2" data-id="' . $itemId . '">Upload PDF</a>';
                                                        }
                                                        ?>
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

<script>
  $(document).ready(function () {
    $('.open-modal').on('click', function (e) {
      e.preventDefault();
      var itemId = $(this).data('id');
      $('#item-id').text(itemId); // Tampilkan ID

      // AJAX ke get_filename.php
      $.post('pembanding/get_filename.php', { item_id: itemId }, function (response) {
        try {
          const data = JSON.parse(response);
          if (data.success) {
            const filePath = '../file/' + data.filename;
            $('#pdf-frame').attr('src', filePath);
            window.currentPdfUrl = filePath; // untuk downloadWithWatermark
            window.currentPdfName = data.filename; // untuk nama file asli
            $('#myModal').modal('show');
          } else {
            alert('File tidak ditemukan untuk item_id ' + itemId);
          }
        } catch (e) {
          alert('Gagal memuat file.');
        }
      });
    });
  });
</script>
<script>
    $('.open-modal2').on('click', function(e) {
    e.preventDefault();
    var itemId = $(this).data('id');
    $('#item-id-display').text(itemId);
    $('#item-id-hidden').val(itemId); // ← sekarang pasti yang input
    $('#myModal2').modal('show');
    });
</script>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-full" role="document"> <!-- Gunakan modal-xl + custom class -->
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center mt-2 mb-4">
          <h4><b>Cetak Laporan Profil Risiko & TKS ID: <span id="item-id"></span></b></h4>
        </div>

        <?php
        include "../conn/conn.php";
        session_start(); // Pastikan session dimulai
        $user_id = $_SESSION['user_id'];
        $data_profile = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'"));
        $jabatan = $data_profile['jabatan'];
        ?>
        <iframe id="pdf-frame"></iframe>
        <br><br>
        <button onclick="downloadWithWatermark()" class="btn btn-primary">Download</button>

        <!-- Tambahkan PDF-lib dari CDN -->
        <script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>

        <script>
        const jabatan = <?= json_encode($jabatan) ?>;

        function downloadWithWatermark() {
        const url = window.currentPdfUrl;
        if (!url) return alert("File belum dimuat.");

        fetch(url)
            .then(res => res.arrayBuffer())
            .then(async existingPdfBytes => {
            const { PDFDocument, rgb } = PDFLib;
            const pdfDoc = await PDFDocument.load(existingPdfBytes);

            const pages = pdfDoc.getPages();
            const dateText = `Diunduh pada: ${new Date().toLocaleDateString('id-ID')} ${new Date().toLocaleTimeString('id-ID')}`;
            const jabatanText = `Diunduh oleh: ${jabatan}`;

            for (const page of pages) {
                page.drawText(dateText, { x: 50, y: 30, size: 10, color: rgb(0.2, 0.2, 0.2) });
                page.drawText(jabatanText, { x: 50, y: 20, size: 10, color: rgb(0.2, 0.2, 0.2) });
            }

            const pdfBytes = await pdfDoc.save();
            const blob = new Blob([pdfBytes], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            const originalName = window.currentPdfName || 'file-watermarked.pdf';
            link.download = originalName.replace('.pdf', '-watermarked.pdf');
            link.click();
            });
        }
        </script>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-full" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center mt-2 mb-4">
          <h4><b>Upload PDF untuk ID: <span id="item-id-display"></span></b></h4>
        </div>
        
        <form id="uploadForm" action="pembanding/upload.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="item_id" id="item-id-hidden" value=""> <!-- ← harus ada dan tidak kosong -->
          <div class="form-group">
            <label for="pdfFile">Pilih File PDF:</label>
            <input type="file" name="pdfFile" class="form-control" accept=".pdf" required>
          </div>
          <button type="submit" class="btn btn-success mt-3">Upload</button>
        </form>

      </div>
    </div>
  </div>
</div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>
