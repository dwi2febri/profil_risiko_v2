<?php
require dirname(__DIR__, 2).'/conn/conn.php';

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

$id = $_SESSION['user_id'];
$get_data_user = mysqli_fetch_array(simpro_db_query($conn, "SELECT nama FROM user

WHERE user_id = ?", [$id]));

?>


<!--jamu-->
<?php
$tahun = $_GET['tahun'];
$periode = $_GET['periode'];

if (isset($_POST['submit'])) {
    $kode_kantor = $_POST['kode_kantor'];
    $tahun = $_POST['tahun'];
    $periode = $_POST['periode'];
        header("Location: index.php?page=rekap_persen&tahun=$tahun&periode=$periode");
        exit();
}


//PEMASARAN
$inheren_kredit1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1a IS NOT NULL AND TRIM(hasil_pil1_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1b IS NOT NULL AND TRIM(hasil_pil1_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1c IS NOT NULL AND TRIM(hasil_pil1_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1d IS NOT NULL AND TRIM(hasil_pil1_par1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1e IS NOT NULL AND TRIM(hasil_pil1_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1f IS NOT NULL AND TRIM(hasil_pil1_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1g IS NOT NULL AND TRIM(hasil_pil1_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1h IS NOT NULL AND TRIM(hasil_pil1_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2j IS NOT NULL AND TRIM(hasil_pil1_par2j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2k IS NOT NULL AND TRIM(hasil_pil1_par2k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar1 = $inheren_kredit1['jumlah'];


$inheren_kredit2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2a IS NOT NULL AND TRIM(hasil_pil2_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2b IS NOT NULL AND TRIM(hasil_pil2_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2c IS NOT NULL AND TRIM(hasil_pil2_par2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2d IS NOT NULL AND TRIM(hasil_pil2_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2e IS NOT NULL AND TRIM(hasil_pil2_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2f IS NOT NULL AND TRIM(hasil_pil2_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3 IS NOT NULL AND TRIM(hasil_pil2_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3a IS NOT NULL AND TRIM(hasil_pil2_par3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3b IS NOT NULL AND TRIM(hasil_pil2_par3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3c IS NOT NULL AND TRIM(hasil_pil2_par3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3d IS NOT NULL AND TRIM(hasil_pil2_par3d) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_kredit_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar2 = $inheren_kredit2['jumlah'];

$inheren_kredit3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_pilar3 = $inheren_kredit3['jumlah'];

$inheren_kredit4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar4.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1 IS NOT NULL AND TRIM(hasil_pil4_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1a IS NOT NULL AND TRIM(hasil_pil4_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1b IS NOT NULL AND TRIM(hasil_pil4_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1c IS NOT NULL AND TRIM(hasil_pil4_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1d IS NOT NULL AND TRIM(hasil_pil4_par1d) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar4 = $inheren_kredit4['jumlah'];



$inheren_kredit_lainnya = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1g IS NOT NULL AND TRIM(pilar5_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1h IS NOT NULL AND TRIM(pilar5_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1i IS NOT NULL AND TRIM(pilar5_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1j IS NOT NULL AND TRIM(pilar5_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1k IS NOT NULL AND TRIM(pilar5_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1 IS NOT NULL AND TRIM(hasil_pil5_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1a IS NOT NULL AND TRIM(hasil_pil5_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1b IS NOT NULL AND TRIM(hasil_pil5_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1c IS NOT NULL AND TRIM(hasil_pil5_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1d IS NOT NULL AND TRIM(hasil_pil5_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1e IS NOT NULL AND TRIM(hasil_pil5_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1f IS NOT NULL AND TRIM(hasil_pil5_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1g IS NOT NULL AND TRIM(hasil_pil5_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1h IS NOT NULL AND TRIM(hasil_pil5_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1i IS NOT NULL AND TRIM(hasil_pil5_par1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1j IS NOT NULL AND TRIM(hasil_pil5_par1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1k IS NOT NULL AND TRIM(hasil_pil5_par1k) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_pilarl = $inheren_kredit_lainnya['jumlah'];

$keterangan_inheren_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren_kredit.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_ket = $keterangan_inheren_kredit['jumlah'];




//kpmr kredit
$kpmr_kredit_pilar1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar1 = $kpmr_kredit_pilar1['jumlah'];


$kpmr_kredit_pilar2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	 kpmr_kredit_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar2 = $kpmr_kredit_pilar2['jumlah'];

$kpmr_kredit_pilar3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar3 = $kpmr_kredit_pilar3['jumlah'];

$kpmr_kredit_pilar4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar4 = $kpmr_kredit_pilar4['jumlah'];

$respon_unit_kerja_kredit_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru1 = $respon_unit_kerja_kredit_pil1['jumlah'];

$respon_unit_kerja_kredit_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru2 = $respon_unit_kerja_kredit_pil2['jumlah'];

$respon_unit_kerja_kredit_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru3 = $respon_unit_kerja_kredit_pil3['jumlah'];

$respon_unit_kerja_kredit_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru4 = $respon_unit_kerja_kredit_pil4['jumlah'];

$keterangan_kpmr2_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ket = $keterangan_kpmr2_kredit['jumlah'];


//profil kredit
$keterangan_profil_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kre = $keterangan_profil_kredit['jumlah'];








//inheren likuiditas
$inheren_likuiditas1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_likuiditas_pilar1.id_profil_risiko,
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par3a IS NOT NULL AND TRIM(hasil_pil1_par3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par3b IS NOT NULL AND TRIM(hasil_pil1_par3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par3c IS NOT NULL AND TRIM(hasil_pil1_par3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par3d IS NOT NULL AND TRIM(hasil_pil1_par3d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par5 IS NOT NULL AND TRIM(hasil_pil1_par5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par5a IS NOT NULL AND TRIM(hasil_pil1_par5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par5b IS NOT NULL AND TRIM(hasil_pil1_par5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par5c IS NOT NULL AND TRIM(hasil_pil1_par5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_likuiditas_pilar1.hasil_pil1_par5d IS NOT NULL AND TRIM(hasil_pil1_par5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_likuiditas_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ilik_pilar1 = $inheren_likuiditas1['jumlah'];


$inheren_likuiditas2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_likuiditas_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_likuiditas_pilar2.hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_pilar2.pil2_par1a IS NOT NULL AND TRIM(pil2_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_pilar2.hasil_pil2_par1a IS NOT NULL AND TRIM(hasil_pil2_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_pilar2.pil2_par1b IS NOT NULL AND TRIM(pil2_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_pilar2.hasil_pil2_par1b IS NOT NULL AND TRIM(hasil_pil2_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_pilar2.pil2_par1c IS NOT NULL AND TRIM(pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_pilar2.hasil_pil2_par1c IS NOT NULL AND TRIM(hasil_pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_pilar2.pil2_par2 IS NOT NULL AND TRIM(pil2_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_pilar2.hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_likuiditas_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ilik_pilar2 = $inheren_likuiditas2['jumlah'];

$inheren_likuiditas_lainnya = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_likuiditas_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1a IS NOT NULL AND TRIM(pil3_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1b IS NOT NULL AND TRIM(pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1c IS NOT NULL AND TRIM(pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1d IS NOT NULL AND TRIM(pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1e IS NOT NULL AND TRIM(pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.pil3_par1f IS NOT NULL AND TRIM(pil3_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_likuiditas_lainnya.hasil_pil3_par1f IS NOT NULL AND TRIM(hasil_pil3_par1f) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_likuiditas_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ilik_pilarl = $inheren_likuiditas_lainnya['jumlah'];



$keterangan_inheren_likuiditas = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren_likuiditas.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_likuiditas.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_likuiditas 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ilik_ket = $keterangan_inheren_likuiditas['jumlah'];




//kpmr likuiditas
$kpmr_likuiditas_pilar1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar1 = $kpmr_likuiditas_pilar1['jumlah'];


$kpmr_likuiditas_pilar2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar2 = $kpmr_likuiditas_pilar2['jumlah'];

$kpmr_likuiditas_pilar3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar3 = $kpmr_likuiditas_pilar3['jumlah'];

$kpmr_likuiditas_pilar4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar4 = $kpmr_likuiditas_pilar4['jumlah'];

$respon_unit_kerja_likuiditas_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru1 = $respon_unit_kerja_likuiditas_pil1['jumlah'];

$respon_unit_kerja_likuiditas_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru2 = $respon_unit_kerja_likuiditas_pil2['jumlah'];

$respon_unit_kerja_likuiditas_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru3 = $respon_unit_kerja_likuiditas_pil3['jumlah'];

$respon_unit_kerja_likuiditas_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru4 = $respon_unit_kerja_likuiditas_pil4['jumlah'];

$keterangan_kpmr2_likuiditas = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_likuiditas.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_likuiditas 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ket = $keterangan_kpmr2_likuiditas['jumlah'];



//profil likuiditas
$keterangan_profil_likuiditas = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_likuiditas.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_likuiditas 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_lik = $keterangan_profil_likuiditas['jumlah'];


//profil nilai
$nilai_profil = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian = $nilai_profil['jumlah'];



//profil peringkat
$peringkat_profil = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 132 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian = $peringkat_profil['jumlah'];



$persen_pemasaran = round((($ik_pilar1 + $ik_pilar2 + $ik_pilar3 + $ik_pilar4 + $ik_pilarl + $ik_ket + $kk_pilar1 + $kk_pilar2 + $kk_pilar3 + $kk_pilar4 + $kk_ru1 + $kk_ru2 + $kk_ru3 + $kk_ru4 + $kk_ket + $ket_pronil_kre + $ilik_pilar1 + $ilik_pilar2 + $ilik_pilarl + $ilik_ket + $klik_pilar1 + $klik_pilar2 + $klik_pilar3 + $klik_pilar4 + $klik_ru1 + $klik_ru2 + $klik_ru3 + $klik_ru4 + $klik_ket + $ket_pronil_lik + $profil_nilai_uraian + $profil_peringkat_uraian) / 447) * 100);




//DPK
$inheren_kredit1_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1a IS NOT NULL AND TRIM(hasil_pil1_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1b IS NOT NULL AND TRIM(hasil_pil1_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1c IS NOT NULL AND TRIM(hasil_pil1_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1d IS NOT NULL AND TRIM(hasil_pil1_par1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1e IS NOT NULL AND TRIM(hasil_pil1_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1f IS NOT NULL AND TRIM(hasil_pil1_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1g IS NOT NULL AND TRIM(hasil_pil1_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par1h IS NOT NULL AND TRIM(hasil_pil1_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2j IS NOT NULL AND TRIM(hasil_pil1_par2j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par2k IS NOT NULL AND TRIM(hasil_pil1_par2k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar1.hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar1_dpk = $inheren_kredit1_dpk['jumlah'];


$inheren_kredit2_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2a IS NOT NULL AND TRIM(hasil_pil2_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2b IS NOT NULL AND TRIM(hasil_pil2_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2c IS NOT NULL AND TRIM(hasil_pil2_par2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2d IS NOT NULL AND TRIM(hasil_pil2_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2e IS NOT NULL AND TRIM(hasil_pil2_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par2f IS NOT NULL AND TRIM(hasil_pil2_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3 IS NOT NULL AND TRIM(hasil_pil2_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3a IS NOT NULL AND TRIM(hasil_pil2_par3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3b IS NOT NULL AND TRIM(hasil_pil2_par3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3c IS NOT NULL AND TRIM(hasil_pil2_par3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar2.hasil_pil2_par3d IS NOT NULL AND TRIM(hasil_pil2_par3d) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_kredit_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar2_dpk = $inheren_kredit2_dpk['jumlah'];

$inheren_kredit3_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar3.hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_pilar3_dpk = $inheren_kredit3_dpk['jumlah'];

$inheren_kredit4_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_pilar4.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1 IS NOT NULL AND TRIM(hasil_pil4_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1a IS NOT NULL AND TRIM(hasil_pil4_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1b IS NOT NULL AND TRIM(hasil_pil4_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1c IS NOT NULL AND TRIM(hasil_pil4_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_pilar4.hasil_pil4_par1d IS NOT NULL AND TRIM(hasil_pil4_par1d) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2 ", [$tahun, $periode]));
$ik_pilar4_dpk = $inheren_kredit4_dpk['jumlah'];



$inheren_kredit_lainnya_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kredit_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1g IS NOT NULL AND TRIM(pilar5_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1h IS NOT NULL AND TRIM(pilar5_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1i IS NOT NULL AND TRIM(pilar5_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1j IS NOT NULL AND TRIM(pilar5_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.pilar5_1k IS NOT NULL AND TRIM(pilar5_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1 IS NOT NULL AND TRIM(hasil_pil5_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1a IS NOT NULL AND TRIM(hasil_pil5_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1b IS NOT NULL AND TRIM(hasil_pil5_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1c IS NOT NULL AND TRIM(hasil_pil5_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1d IS NOT NULL AND TRIM(hasil_pil5_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1e IS NOT NULL AND TRIM(hasil_pil5_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1f IS NOT NULL AND TRIM(hasil_pil5_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1g IS NOT NULL AND TRIM(hasil_pil5_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1h IS NOT NULL AND TRIM(hasil_pil5_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1i IS NOT NULL AND TRIM(hasil_pil5_par1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1j IS NOT NULL AND TRIM(hasil_pil5_par1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kredit_lainnya.hasil_pil5_par1k IS NOT NULL AND TRIM(hasil_pil5_par1k) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_kredit_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_pilarl_dpk = $inheren_kredit_lainnya_dpk['jumlah'];

$keterangan_inheren_kredit_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren_kredit.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren_kredit.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ik_ket_dpk = $keterangan_inheren_kredit_dpk['jumlah'];









//kpmr kredit
$kpmr_kredit_pilar1_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar1_dpk = $kpmr_kredit_pilar1_dpk['jumlah'];


$kpmr_kredit_pilar2_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	 kpmr_kredit_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar2_dpk = $kpmr_kredit_pilar2_dpk['jumlah'];

$kpmr_kredit_pilar3_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar3_dpk = $kpmr_kredit_pilar3_dpk['jumlah'];

$kpmr_kredit_pilar4_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar4_dpk = $kpmr_kredit_pilar4_dpk['jumlah'];

$respon_unit_kerja_kredit_pil1_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru1_dpk = $respon_unit_kerja_kredit_pil1_dpk['jumlah'];

$respon_unit_kerja_kredit_pil2_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru2_dpk = $respon_unit_kerja_kredit_pil2_dpk['jumlah'];

$respon_unit_kerja_kredit_pil3_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru3_dpk = $respon_unit_kerja_kredit_pil3_dpk['jumlah'];

$respon_unit_kerja_kredit_pil4_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru4_dpk = $respon_unit_kerja_kredit_pil4_dpk['jumlah'];

$keterangan_kpmr2_kredit_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ket_dpk = $keterangan_kpmr2_kredit_dpk['jumlah'];


//profil kredit
$keterangan_profil_kredit_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kre_dpk = $keterangan_profil_kredit_dpk['jumlah'];



//profil nilai
$nilai_profil_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_dpk = $nilai_profil_dpk['jumlah'];



//profil peringkat
$peringkat_profil_dpk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 142 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_dpk = $peringkat_profil_dpk['jumlah'];

$persen_dpk = round((($ik_pilar1_dpk + $ik_pilar2_dpk + $ik_pilar3_dpk + $ik_pilar4_dpk + $ik_pilarl_dpk + $ik_ket_dpk + $kk_pilar1_dpk + $kk_pilar2_dpk + $kk_pilar3_dpk + $kk_pilar4_dpk + $kk_ru1_dpk + $kk_ru2_dpk + $kk_ru3_dpk + $kk_ru4_dpk + $kk_ket_dpk + $ket_pronil_kre_dpk + $profil_nilai_uraian_dpk + $profil_peringkat_uraian_dpk) / 238) * 100);



//OPS
$inheren_operasional1_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar1_ops = $inheren_operasional1_ops['jumlah'];


$inheren_operasional2_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1j IS NOT NULL AND TRIM(pilar2_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1k IS NOT NULL AND TRIM(pilar2_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1l IS NOT NULL AND TRIM(pilar2_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1m IS NOT NULL AND TRIM(pilar2_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1n IS NOT NULL AND TRIM(pilar2_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar2_ops = $inheren_operasional2_ops['jumlah'];

$inheren_operasional3_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar3_ops = $inheren_operasional3_ops['jumlah'];

$inheren_operasional4_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1 IS NOT NULL AND TRIM(pilar4_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar4_ops = $inheren_operasional4_ops['jumlah'];



$inheren_operasional5_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar5.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1 IS NOT NULL AND TRIM(pilar5_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar5 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar5_ops = $inheren_operasional5_ops['jumlah'];

$inheren_operasional_lainnya_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_lainnya.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1a IS NOT NULL AND TRIM(pilar6_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1b IS NOT NULL AND TRIM(pilar6_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1c IS NOT NULL AND TRIM(pilar6_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1d IS NOT NULL AND TRIM(pilar6_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1e IS NOT NULL AND TRIM(pilar6_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1f IS NOT NULL AND TRIM(pilar6_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilarl_ops = $inheren_operasional_lainnya_ops['jumlah'];

$keterangan_inheren2_operasional_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_operasional.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6_1 IS NOT NULL AND TRIM(ket_pil6_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6 IS NOT NULL AND TRIM(ket_pil6) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_ket_ops = $keterangan_inheren2_operasional_ops['jumlah'];





//kpmr operasional
$kpmr_operasional_pilar1_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar1_ops = $kpmr_operasional_pilar1_ops['jumlah'];


$kpmr_operasional_pilar2_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar2_ops = $kpmr_operasional_pilar2_ops['jumlah'];

$kpmr_operasional_pilar3_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar3.kpmr_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3a IS NOT NULL AND TRIM(pilar3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3b IS NOT NULL AND TRIM(pilar3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3c IS NOT NULL AND TRIM(pilar3_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total3 IS NOT NULL AND TRIM(pil3_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat3 IS NOT NULL AND TRIM(pil3_peringkat3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4a IS NOT NULL AND TRIM(pilar3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4b IS NOT NULL AND TRIM(pilar3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4c IS NOT NULL AND TRIM(pilar3_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total4 IS NOT NULL AND TRIM(pil3_total4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat4 IS NOT NULL AND TRIM(pil3_peringkat4) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM kpmr_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar3_ops = $kpmr_operasional_pilar3_ops['jumlah'];

$kpmr_operasional_pilar4_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar4_ops = $kpmr_operasional_pilar4_ops['jumlah'];

$respon_unit_kerja_operasional_pil1_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru1_ops = $respon_unit_kerja_operasional_pil1_ops['jumlah'];

$respon_unit_kerja_operasional_pil2_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru2_ops = $respon_unit_kerja_operasional_pil2_ops['jumlah'];

$respon_unit_kerja_operasional_pil3_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3a IS NOT NULL AND TRIM(respon_pil3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3b IS NOT NULL AND TRIM(respon_pil3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3c IS NOT NULL AND TRIM(respon_pil3_3c) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4a IS NOT NULL AND TRIM(respon_pil3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4b IS NOT NULL AND TRIM(respon_pil3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4c IS NOT NULL AND TRIM(respon_pil3_4c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru3_ops = $respon_unit_kerja_operasional_pil3_ops['jumlah'];

$respon_unit_kerja_operasional_pil4_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru4_ops = $respon_unit_kerja_operasional_pil4_ops['jumlah'];

$keterangan_kpmr2_operasional_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_operasional.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_3 IS NOT NULL AND TRIM(ket_pil3_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_4 IS NOT NULL AND TRIM(ket_pil3_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ket_ops = $keterangan_kpmr2_operasional_ops['jumlah'];

$kpmr_operasional = round((($ko_pilar1_ops + $ko_pilar2_ops + $ko_pilar3_ops + $ko_pilar4_ops + $ko_ru1_ops + $ko_ru2_ops + $ko_ru3_ops + $ko_ru4_ops + $ko_ket_ops) / 163) * 100);


//profil operasional
$keterangan_profil_operasional_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_op_ops = $keterangan_profil_operasional_ops['jumlah'];


//profil nilai
$nilai_profil_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_ops = $nilai_profil_ops['jumlah'];



//profil peringkat
$peringkat_profil_ops = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 133 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_ops = $peringkat_profil_ops['jumlah'];


$persen_operasional = round((($io_pilar1_ops + $io_pilar2_ops + $io_pilar3_ops + $io_pilar4_ops + $io_pilar5_ops + $io_pilarl_ops + $io_ket_ops + $ko_pilar1_ops + $ko_pilar2_ops + $ko_pilar3_ops + $ko_pilar4_ops + $ko_ru1_ops + $ko_ru2_ops + $ko_ru3_ops + $ko_ru4_ops + $ko_ket_ops + $ket_pronil_op_ops + $profil_nilai_uraian_ops + $profil_peringkat_uraian_ops) / 205) * 100);




//SDM
$inheren_operasional1_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar1_sdm = $inheren_operasional1_sdm['jumlah'];


$inheren_operasional2_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1j IS NOT NULL AND TRIM(pilar2_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1k IS NOT NULL AND TRIM(pilar2_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1l IS NOT NULL AND TRIM(pilar2_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1m IS NOT NULL AND TRIM(pilar2_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1n IS NOT NULL AND TRIM(pilar2_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar2_sdm = $inheren_operasional2_sdm['jumlah'];

$inheren_operasional3_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar3_sdm = $inheren_operasional3_sdm['jumlah'];

$inheren_operasional4_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1 IS NOT NULL AND TRIM(pilar4_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar4_sdm = $inheren_operasional4_sdm['jumlah'];



$inheren_operasional5_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar5.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1 IS NOT NULL AND TRIM(pilar5_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar5 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar5_sdm = $inheren_operasional5_sdm['jumlah'];

$inheren_operasional_lainnya_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_lainnya.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1a IS NOT NULL AND TRIM(pilar6_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1b IS NOT NULL AND TRIM(pilar6_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1c IS NOT NULL AND TRIM(pilar6_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1d IS NOT NULL AND TRIM(pilar6_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1e IS NOT NULL AND TRIM(pilar6_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1f IS NOT NULL AND TRIM(pilar6_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilarl_sdm = $inheren_operasional_lainnya_sdm['jumlah'];

$keterangan_inheren2_operasional_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_operasional.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6_1 IS NOT NULL AND TRIM(ket_pil6_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6 IS NOT NULL AND TRIM(ket_pil6) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_ket_sdm = $keterangan_inheren2_operasional_sdm['jumlah'];





//kpmr operasional
$kpmr_operasional_pilar1_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar1_sdm = $kpmr_operasional_pilar1_sdm['jumlah'];


$kpmr_operasional_pilar2_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar2_sdm = $kpmr_operasional_pilar2_sdm['jumlah'];

$kpmr_operasional_pilar3_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar3.kpmr_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3a IS NOT NULL AND TRIM(pilar3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3b IS NOT NULL AND TRIM(pilar3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3c IS NOT NULL AND TRIM(pilar3_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total3 IS NOT NULL AND TRIM(pil3_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat3 IS NOT NULL AND TRIM(pil3_peringkat3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4a IS NOT NULL AND TRIM(pilar3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4b IS NOT NULL AND TRIM(pilar3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4c IS NOT NULL AND TRIM(pilar3_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total4 IS NOT NULL AND TRIM(pil3_total4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat4 IS NOT NULL AND TRIM(pil3_peringkat4) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM kpmr_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar3_sdm = $kpmr_operasional_pilar3_sdm['jumlah'];

$kpmr_operasional_pilar4_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar4_sdm = $kpmr_operasional_pilar4_sdm['jumlah'];

$respon_unit_kerja_operasional_pil1_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru1_sdm = $respon_unit_kerja_operasional_pil1_sdm['jumlah'];

$respon_unit_kerja_operasional_pil2_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru2_sdm = $respon_unit_kerja_operasional_pil2_sdm['jumlah'];

$respon_unit_kerja_operasional_pil3_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3a IS NOT NULL AND TRIM(respon_pil3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3b IS NOT NULL AND TRIM(respon_pil3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3c IS NOT NULL AND TRIM(respon_pil3_3c) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4a IS NOT NULL AND TRIM(respon_pil3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4b IS NOT NULL AND TRIM(respon_pil3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4c IS NOT NULL AND TRIM(respon_pil3_4c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru3_sdm = $respon_unit_kerja_operasional_pil3_sdm['jumlah'];

$respon_unit_kerja_operasional_pil4_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru4_sdm = $respon_unit_kerja_operasional_pil4_sdm['jumlah'];

$keterangan_kpmr2_operasional_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_operasional.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_3 IS NOT NULL AND TRIM(ket_pil3_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_4 IS NOT NULL AND TRIM(ket_pil3_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ket_sdm = $keterangan_kpmr2_operasional_sdm['jumlah'];

$kpmr_operasional = round((($ko_pilar1_sdm + $ko_pilar2_sdm + $ko_pilar3_sdm + $ko_pilar4_sdm + $ko_ru1_sdm + $ko_ru2_sdm + $ko_ru3_sdm + $ko_ru4_sdm + $ko_ket_sdm) / 163) * 100);


//profil operasional
$keterangan_profil_operasional_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_op_sdm = $keterangan_profil_operasional_sdm['jumlah'];



//profil nilai
$nilai_profil_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_sdm = $nilai_profil_sdm['jumlah'];



//profil peringkat
$peringkat_profil_sdm = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 134 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_sdm = $peringkat_profil_sdm['jumlah'];


$persen_sdm = round((($io_pilar1_sdm + $io_pilar2_sdm + $io_pilar3_sdm + $io_pilar4_sdm + $io_pilar5_sdm + $io_pilarl_sdm + $io_ket_sdm + $ko_pilar1_sdm + $ko_pilar2_sdm + $ko_pilar3_sdm + $ko_pilar4_sdm + $ko_ru1_sdm + $ko_ru2_sdm + $ko_ru3_sdm + $ko_ru4_sdm + $ko_ket_sdm + $ket_pronil_op_sdm + $profil_nilai_uraian_sdm + $profil_peringkat_uraian_sdm) / 202) * 100);





//SEKPER
$inheren_kepatuhan1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1g IS NOT NULL AND TRIM(pilar1_1g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2f IS NOT NULL AND TRIM(pilar1_2f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2g IS NOT NULL AND TRIM(pilar1_2g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2h IS NOT NULL AND TRIM(pilar1_2h) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM inheren_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar1_sekper = $inheren_kepatuhan1_sekper['jumlah'];


$inheren_kepatuhan2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3 IS NOT NULL AND TRIM(pilar2_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar2_sekper = $inheren_kepatuhan2_sekper['jumlah'];

$inheren_kepatuhan_lainnya_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kepatuhan_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilarl_sekper = $inheren_kepatuhan_lainnya_sekper['jumlah'];


$keterangan_inheren2_kepatuhan_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_kepatuhan.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_ket_sekper = $keterangan_inheren2_kepatuhan_sekper['jumlah'];




//kpmr kepatuhan
$kpmr_kepatuhan_pilar1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7a IS NOT NULL AND TRIM(pilar1_7a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7b IS NOT NULL AND TRIM(pilar1_7b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7c IS NOT NULL AND TRIM(pilar1_7c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total7 IS NOT NULL AND TRIM(pil1_total7) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat7 IS NOT NULL AND TRIM(pil1_peringkat7) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar1_sekper = $kpmr_kepatuhan_pilar1_sekper['jumlah'];


$kpmr_kepatuhan_pilar2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar2_sekper = $kpmr_kepatuhan_pilar2_sekper['jumlah'];

$kpmr_kepatuhan_pilar3_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar3_sekper = $kpmr_kepatuhan_pilar3_sekper['jumlah'];

$kpmr_kepatuhan_pilar4_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar4_sekper = $kpmr_kepatuhan_pilar4_sekper['jumlah'];

$respon_unit_kerja_kepatuhan_pil1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7a IS NOT NULL AND TRIM(respon_pil1_7a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7b IS NOT NULL AND TRIM(respon_pil1_7b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7c IS NOT NULL AND TRIM(respon_pil1_7c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru1_sekper = $respon_unit_kerja_kepatuhan_pil1_sekper['jumlah'];

$respon_unit_kerja_kepatuhan_pil2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru2_sekper = $respon_unit_kerja_kepatuhan_pil2_sekper['jumlah'];

$respon_unit_kerja_kepatuhan_pil3_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru3_sekper = $respon_unit_kerja_kepatuhan_pil3_sekper['jumlah'];

$respon_unit_kerja_kepatuhan_pil4_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru4_sekper = $respon_unit_kerja_kepatuhan_pil4_sekper['jumlah'];

$keterangan_kpmr2_kepatuhan_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_7 IS NOT NULL AND TRIM(ket_pil1_7) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ket_sekper = $keterangan_kpmr2_kepatuhan_sekper['jumlah'];


//profil kepatuhan
$keterangan_profil_kepatuhan_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kep_sekper = $keterangan_profil_kepatuhan_sekper['jumlah'];






//inheren reputasi
$inheren_reputasi1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar1_sekper = $inheren_reputasi1_sekper['jumlah'];


$inheren_reputasi2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar2_sekper = $inheren_reputasi2_sekper['jumlah'];

$inheren_reputasi3_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar3_sekper = $inheren_reputasi3_sekper['jumlah'];


$inheren_reputasi_lainnya_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilarl_sekper = $inheren_reputasi_lainnya_sekper['jumlah'];


$keterangan_inheren2_reputasi_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_reputasi.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_ket_sekper = $keterangan_inheren2_reputasi_sekper['jumlah'];




//kpmr reputasi
$kpmr_reputasi_pilar1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar1_sekper = $kpmr_reputasi_pilar1_sekper['jumlah'];


$kpmr_reputasi_pilar2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar2_sekper = $kpmr_reputasi_pilar2_sekper['jumlah'];

$kpmr_reputasi_pilar3_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar3_sekper = $kpmr_reputasi_pilar3_sekper['jumlah'];

$kpmr_reputasi_pilar4_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar4_sekper = $kpmr_reputasi_pilar4_sekper['jumlah'];

$respon_unit_kerja_reputasi_pil1_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru1_sekper = $respon_unit_kerja_reputasi_pil1_sekper['jumlah'];

$respon_unit_kerja_reputasi_pil2_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru2_sekper = $respon_unit_kerja_reputasi_pil2_sekper['jumlah'];

$respon_unit_kerja_reputasi_pil3_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru3_sekper = $respon_unit_kerja_reputasi_pil3_sekper['jumlah'];

$respon_unit_kerja_reputasi_pil4_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru4_sekper = $respon_unit_kerja_reputasi_pil4_sekper['jumlah'];

$keterangan_kpmr2_reputasi_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ket_sekper = $keterangan_kpmr2_reputasi_sekper['jumlah'];



//profil reputasi
$keterangan_profil_reputasi_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_rep_sekper = $keterangan_profil_reputasi_sekper['jumlah'];


//profil nilai
$nilai_profil_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_sekper = $nilai_profil_sekper['jumlah'];



//profil peringkat
$peringkat_profil_sekper = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 136 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_sekper = $peringkat_profil_sekper['jumlah'];



$persen_sekper = round((($ikep_pilar1_sekper + $ikep_pilar2_sekper + $ikep_pilarl_sekper + $ikep_ket_sekper + $kkep_pilar1_sekper + $kkep_pilar2_sekper + $kkep_pilar3_sekper + $kkep_pilar4_sekper + $kkep_ru1_sekper + $kkep_ru2_sekper + $kkep_ru3_sekper + $kkep_ru4_sekper + $kkep_ket_sekper + $ket_pronil_kep_sekper + $irep_pilar1_sekper + $irep_pilar2_sekper + $irep_pilar3_sekper + $irep_pilarl_sekper + $irep_ket_sekper + $krep_pilar1_sekper + $krep_pilar2_sekper + $krep_pilar3_sekper + $krep_pilar4_sekper + $krep_ru1_sekper + $krep_ru2_sekper + $krep_ru3_sekper + $krep_ru4_sekper + $krep_ket_sekper + $ket_pronil_rep_sekper + $profil_nilai_uraian_sekper + $profil_peringkat_uraian_sekper) / 376) * 100);





//SKK
$inheren_operasional1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar1_skk = $inheren_operasional1_skk['jumlah'];


$inheren_operasional2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1j IS NOT NULL AND TRIM(pilar2_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1k IS NOT NULL AND TRIM(pilar2_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1l IS NOT NULL AND TRIM(pilar2_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1m IS NOT NULL AND TRIM(pilar2_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1n IS NOT NULL AND TRIM(pilar2_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar2_skk = $inheren_operasional2_skk['jumlah'];

$inheren_operasional3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar3_skk = $inheren_operasional3_skk['jumlah'];

$inheren_operasional4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1 IS NOT NULL AND TRIM(pilar4_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar4_skk = $inheren_operasional4_skk['jumlah'];



$inheren_operasional5_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar5.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1 IS NOT NULL AND TRIM(pilar5_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar5 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar5_skk = $inheren_operasional5_skk['jumlah'];

$inheren_operasional_lainnya_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_lainnya.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1a IS NOT NULL AND TRIM(pilar6_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1b IS NOT NULL AND TRIM(pilar6_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1c IS NOT NULL AND TRIM(pilar6_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1d IS NOT NULL AND TRIM(pilar6_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1e IS NOT NULL AND TRIM(pilar6_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1f IS NOT NULL AND TRIM(pilar6_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilarl_skk = $inheren_operasional_lainnya_skk['jumlah'];

$keterangan_inheren2_operasional_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_operasional.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6_1 IS NOT NULL AND TRIM(ket_pil6_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6 IS NOT NULL AND TRIM(ket_pil6) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_ket_skk = $keterangan_inheren2_operasional_skk['jumlah'];





//kpmr operasional
$kpmr_operasional_pilar1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar1_skk = $kpmr_operasional_pilar1_skk['jumlah'];


$kpmr_operasional_pilar2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar2_skk = $kpmr_operasional_pilar2_skk['jumlah'];

$kpmr_operasional_pilar3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar3.kpmr_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3a IS NOT NULL AND TRIM(pilar3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3b IS NOT NULL AND TRIM(pilar3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3c IS NOT NULL AND TRIM(pilar3_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total3 IS NOT NULL AND TRIM(pil3_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat3 IS NOT NULL AND TRIM(pil3_peringkat3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4a IS NOT NULL AND TRIM(pilar3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4b IS NOT NULL AND TRIM(pilar3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4c IS NOT NULL AND TRIM(pilar3_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total4 IS NOT NULL AND TRIM(pil3_total4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat4 IS NOT NULL AND TRIM(pil3_peringkat4) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM kpmr_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar3_skk = $kpmr_operasional_pilar3_skk['jumlah'];

$kpmr_operasional_pilar4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar4_skk = $kpmr_operasional_pilar4_skk['jumlah'];

$respon_unit_kerja_operasional_pil1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru1_skk = $respon_unit_kerja_operasional_pil1_skk['jumlah'];

$respon_unit_kerja_operasional_pil2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru2_skk = $respon_unit_kerja_operasional_pil2_skk['jumlah'];

$respon_unit_kerja_operasional_pil3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3a IS NOT NULL AND TRIM(respon_pil3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3b IS NOT NULL AND TRIM(respon_pil3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3c IS NOT NULL AND TRIM(respon_pil3_3c) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4a IS NOT NULL AND TRIM(respon_pil3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4b IS NOT NULL AND TRIM(respon_pil3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4c IS NOT NULL AND TRIM(respon_pil3_4c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru3_skk = $respon_unit_kerja_operasional_pil3_skk['jumlah'];

$respon_unit_kerja_operasional_pil4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru4_skk = $respon_unit_kerja_operasional_pil4_skk['jumlah'];

$keterangan_kpmr2_operasional_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_operasional.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_3 IS NOT NULL AND TRIM(ket_pil3_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_4 IS NOT NULL AND TRIM(ket_pil3_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ket_skk = $keterangan_kpmr2_operasional_skk['jumlah'];

$kpmr_operasional = round((($ko_pilar1_skk + $ko_pilar2_skk + $ko_pilar3_skk + $ko_pilar4_skk + $ko_ru1_skk + $ko_ru2_skk + $ko_ru3_skk + $ko_ru4_skk + $ko_ket_skk) / 163) * 100);


//profil operasional
$keterangan_profil_operasional_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_op_skk = $keterangan_profil_operasional_skk['jumlah'];



$inheren_kepatuhan1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1g IS NOT NULL AND TRIM(pilar1_1g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2f IS NOT NULL AND TRIM(pilar1_2f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2g IS NOT NULL AND TRIM(pilar1_2g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2h IS NOT NULL AND TRIM(pilar1_2h) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM inheren_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar1_skk = $inheren_kepatuhan1_skk['jumlah'];


$inheren_kepatuhan2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3 IS NOT NULL AND TRIM(pilar2_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar2_skk = $inheren_kepatuhan2_skk['jumlah'];

$inheren_kepatuhan_lainnya_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kepatuhan_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilarl_skk = $inheren_kepatuhan_lainnya_skk['jumlah'];


$keterangan_inheren2_kepatuhan_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_kepatuhan.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_ket_skk = $keterangan_inheren2_kepatuhan_skk['jumlah'];




//kpmr kepatuhan
$kpmr_kepatuhan_pilar1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7a IS NOT NULL AND TRIM(pilar1_7a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7b IS NOT NULL AND TRIM(pilar1_7b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7c IS NOT NULL AND TRIM(pilar1_7c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total7 IS NOT NULL AND TRIM(pil1_total7) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat7 IS NOT NULL AND TRIM(pil1_peringkat7) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar1_skk = $kpmr_kepatuhan_pilar1_skk['jumlah'];


$kpmr_kepatuhan_pilar2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar2_skk = $kpmr_kepatuhan_pilar2_skk['jumlah'];

$kpmr_kepatuhan_pilar3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar3_skk = $kpmr_kepatuhan_pilar3_skk['jumlah'];

$kpmr_kepatuhan_pilar4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar4_skk = $kpmr_kepatuhan_pilar4_skk['jumlah'];

$respon_unit_kerja_kepatuhan_pil1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7a IS NOT NULL AND TRIM(respon_pil1_7a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7b IS NOT NULL AND TRIM(respon_pil1_7b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7c IS NOT NULL AND TRIM(respon_pil1_7c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru1_skk = $respon_unit_kerja_kepatuhan_pil1_skk['jumlah'];

$respon_unit_kerja_kepatuhan_pil2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru2_skk = $respon_unit_kerja_kepatuhan_pil2_skk['jumlah'];

$respon_unit_kerja_kepatuhan_pil3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru3_skk = $respon_unit_kerja_kepatuhan_pil3_skk['jumlah'];

$respon_unit_kerja_kepatuhan_pil4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru4_skk = $respon_unit_kerja_kepatuhan_pil4_skk['jumlah'];

$keterangan_kpmr2_kepatuhan_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_7 IS NOT NULL AND TRIM(ket_pil1_7) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ket_skk = $keterangan_kpmr2_kepatuhan_skk['jumlah'];


//profil kepatuhan
$keterangan_profil_kepatuhan_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kep_skk = $keterangan_profil_kepatuhan_skk['jumlah'];






//inheren reputasi
$inheren_reputasi1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar1_skk = $inheren_reputasi1_skk['jumlah'];


$inheren_reputasi2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar2_skk = $inheren_reputasi2_skk['jumlah'];

$inheren_reputasi3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar3_skk = $inheren_reputasi3_skk['jumlah'];


$inheren_reputasi_lainnya_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilarl_skk = $inheren_reputasi_lainnya_skk['jumlah'];


$keterangan_inheren2_reputasi_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_reputasi.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_ket_skk = $keterangan_inheren2_reputasi_skk['jumlah'];




//kpmr reputasi
$kpmr_reputasi_pilar1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar1_skk = $kpmr_reputasi_pilar1_skk['jumlah'];


$kpmr_reputasi_pilar2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar2_skk = $kpmr_reputasi_pilar2_skk['jumlah'];

$kpmr_reputasi_pilar3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar3_skk = $kpmr_reputasi_pilar3_skk['jumlah'];

$kpmr_reputasi_pilar4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar4_skk = $kpmr_reputasi_pilar4_skk['jumlah'];

$respon_unit_kerja_reputasi_pil1_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru1_skk = $respon_unit_kerja_reputasi_pil1_skk['jumlah'];

$respon_unit_kerja_reputasi_pil2_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru2_skk = $respon_unit_kerja_reputasi_pil2_skk['jumlah'];

$respon_unit_kerja_reputasi_pil3_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru3_skk = $respon_unit_kerja_reputasi_pil3_skk['jumlah'];

$respon_unit_kerja_reputasi_pil4_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru4_skk = $respon_unit_kerja_reputasi_pil4_skk['jumlah'];

$keterangan_kpmr2_reputasi_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ket_skk = $keterangan_kpmr2_reputasi_skk['jumlah'];



//profil reputasi
$keterangan_profil_reputasi_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_rep_skk = $keterangan_profil_reputasi_skk['jumlah'];




//profil nilai
$nilai_profil_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_skk = $nilai_profil_skk['jumlah'];



//profil peringkat
$peringkat_profil_skk = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 135 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_skk = $peringkat_profil_skk['jumlah'];


$persen_kepatuhan = round((($io_pilar1_skk + $io_pilar2_skk + $io_pilar3_skk + $io_pilar4_skk + $io_pilar5_skk + $io_pilarl_skk + $io_ket_skk + $ko_pilar1_skk + $ko_pilar2_skk + $ko_pilar3_skk + $ko_pilar4_skk + $ko_ru1_skk + $ko_ru2_skk + $ko_ru3_skk + $ko_ru4_skk + $ko_ket_skk + $ket_pronil_op_skk + $ikep_pilar1_skk + $ikep_pilar2_skk + $ikep_pilarl_skk + $ikep_ket_skk + $kkep_pilar1_skk + $kkep_pilar2_skk + $kkep_pilar3_skk + $kkep_pilar4_skk + $kkep_ru1_skk + $kkep_ru2_skk + $kkep_ru3_skk + $kkep_ru4_skk + $kkep_ket_skk + $ket_pronil_kep_skk + $irep_pilar1_skk + $irep_pilar2_skk + $irep_pilar3_skk + $irep_pilarl_skk + $irep_ket_skk + $krep_pilar1_skk + $krep_pilar2_skk + $krep_pilar3_skk + $krep_pilar4_skk + $krep_ru1_skk + $krep_ru2_skk + $krep_ru3_skk + $krep_ru4_skk + $krep_ket_skk + $ket_pronil_rep_skk + $profil_nilai_uraian_skk + $profil_peringkat_uraian_skk) / 573) * 100);



//LITBANG
$inheren_stratejik1_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_stratejik_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar1.pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_pilar1  
INNER JOIN frame_laporan_profil_risiko ON inheren_stratejik_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$istra_pilar1_lit = $inheren_stratejik1_lit['jumlah'];


$inheren_stratejik2_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_stratejik_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_stratejik_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_stratejik_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$istra_pilar2_lit = $inheren_stratejik2_lit['jumlah'];

$inheren_stratejik3_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_stratejik_pilar3.id_profil_risiko,
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_stratejik_pilar3.pilar3_2f IS NOT NULL AND TRIM(pilar3_2f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_pilar3  
INNER JOIN frame_laporan_profil_risiko ON inheren_stratejik_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$istra_pilar3_lit = $inheren_stratejik3_lit['jumlah'];


$inheren_stratejik_lainnya_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_stratejik_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_stratejik_lainnya.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_stratejik_lainnya.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_lainnya.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_stratejik_lainnya.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_stratejik_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$istra_pilarl_lit = $inheren_stratejik_lainnya_lit['jumlah'];


$keterangan_inheren2_stratejik_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_stratejik.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_stratejik.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_stratejik  
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$istra_ket_lit = $keterangan_inheren2_stratejik_lit['jumlah'];




//kpmr stratejik
$kpmr_stratejik_pilar1_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar1_lit = $kpmr_stratejik_pilar1_lit['jumlah'];


$kpmr_stratejik_pilar2_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar2_lit = $kpmr_stratejik_pilar2_lit['jumlah'];

$kpmr_stratejik_pilar3_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar3_lit = $kpmr_stratejik_pilar3_lit['jumlah'];

$kpmr_stratejik_pilar4_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar4_lit = $kpmr_stratejik_pilar4_lit['jumlah'];

$respon_unit_kerja_stratejik_pil1_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru1_lit = $respon_unit_kerja_stratejik_pil1_lit['jumlah'];

$respon_unit_kerja_stratejik_pil2_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru2_lit = $respon_unit_kerja_stratejik_pil2_lit['jumlah'];

$respon_unit_kerja_stratejik_pil3_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru3_lit = $respon_unit_kerja_stratejik_pil3_lit['jumlah'];

$respon_unit_kerja_stratejik_pil4_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil4 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru4_lit = $respon_unit_kerja_stratejik_pil4_lit['jumlah'];

$keterangan_kpmr2_stratejik_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_stratejik.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_stratejik 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ket_lit = $keterangan_kpmr2_stratejik_lit['jumlah'];



//profil stratejik
$keterangan_profil_stratejik_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_stratejik.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_stratejik 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_stra_lit = $keterangan_profil_stratejik_lit['jumlah'];






//profil nilai
$nilai_profil_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_lit = $nilai_profil_lit['jumlah'];



//profil peringkat
$peringkat_profil_lit = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 137 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_lit = $peringkat_profil_lit['jumlah'];



$persen_litbang = round((($istra_pilar1_lit + $istra_pilar2_lit + $istra_pilar3_lit + $istra_pilarl_lit + $istra_ket_lit + $kstra_pilar1_lit + $kstra_pilar2_lit + $kstra_pilar3_lit + $kstra_pilar4_lit + $kstra_ru1_lit + $kstra_ru2_lit + $kstra_ru3_lit + $kstra_ru4_lit + $kstra_ket_lit + $ket_pronil_stra_lit + $profil_nilai_uraian_lit + $profil_peringkat_uraian_lit) / 205) * 100);






//SKAI



//kpmr kredit
$kpmr_kredit_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kredit_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar1_skai = $kpmr_kredit_pilar1_skai['jumlah'];


$kpmr_kredit_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	 kpmr_kredit_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar2_skai = $kpmr_kredit_pilar2_skai['jumlah'];

$kpmr_kredit_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar3_skai = $kpmr_kredit_pilar3_skai['jumlah'];

$kpmr_kredit_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kredit_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kredit_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kredit_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_pilar4_skai = $kpmr_kredit_pilar4_skai['jumlah'];

$respon_unit_kerja_kredit_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru1_skai = $respon_unit_kerja_kredit_pil1_skai['jumlah'];

$respon_unit_kerja_kredit_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru2_skai = $respon_unit_kerja_kredit_pil2_skai['jumlah'];

$respon_unit_kerja_kredit_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru3_skai = $respon_unit_kerja_kredit_pil3_skai['jumlah'];

$respon_unit_kerja_kredit_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kredit_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kredit_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kredit_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ru4_skai = $respon_unit_kerja_kredit_pil4_skai['jumlah'];

$keterangan_kpmr2_kredit_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kredit.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kk_ket_skai = $keterangan_kpmr2_kredit_skai['jumlah'];


//profil kredit
$keterangan_profil_kredit_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kredit.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kredit.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kredit 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kre_skai = $keterangan_profil_kredit_skai['jumlah'];






//kpmr likuiditas
$kpmr_likuiditas_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_likuiditas_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar1_skai = $kpmr_likuiditas_pilar1_skai['jumlah'];


$kpmr_likuiditas_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar2_skai = $kpmr_likuiditas_pilar2_skai['jumlah'];

$kpmr_likuiditas_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar3_skai = $kpmr_likuiditas_pilar3_skai['jumlah'];

$kpmr_likuiditas_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_likuiditas_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_likuiditas_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_likuiditas_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_pilar4_skai = $kpmr_likuiditas_pilar4_skai['jumlah'];

$respon_unit_kerja_likuiditas_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru1_skai = $respon_unit_kerja_likuiditas_pil1_skai['jumlah'];

$respon_unit_kerja_likuiditas_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru2_skai = $respon_unit_kerja_likuiditas_pil2_skai['jumlah'];

$respon_unit_kerja_likuiditas_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru3_skai = $respon_unit_kerja_likuiditas_pil3_skai['jumlah'];

$respon_unit_kerja_likuiditas_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_likuiditas_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_likuiditas_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_likuiditas_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ru4_skai = $respon_unit_kerja_likuiditas_pil4_skai['jumlah'];

$keterangan_kpmr2_likuiditas_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_likuiditas.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_likuiditas.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_likuiditas 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$klik_ket_skai = $keterangan_kpmr2_likuiditas_skai['jumlah'];



//profil likuiditas
$keterangan_profil_likuiditas_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_likuiditas.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_likuiditas.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_likuiditas 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_lik_skai = $keterangan_profil_likuiditas_skai['jumlah'];





$inheren_operasional1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar1_skai = $inheren_operasional1_skai['jumlah'];


$inheren_operasional2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1j IS NOT NULL AND TRIM(pilar2_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1k IS NOT NULL AND TRIM(pilar2_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1l IS NOT NULL AND TRIM(pilar2_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1m IS NOT NULL AND TRIM(pilar2_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_1n IS NOT NULL AND TRIM(pilar2_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar2_skai = $inheren_operasional2_skai['jumlah'];

$inheren_operasional3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar3.id_profil_risiko,
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_operasional_pilar3.pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar3_skai = $inheren_operasional3_skai['jumlah'];

$inheren_operasional4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1 IS NOT NULL AND TRIM(pilar4_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar4_skai = $inheren_operasional4_skai['jumlah'];



$inheren_operasional5_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_pilar5.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1 IS NOT NULL AND TRIM(pilar5_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_pilar5.pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar5 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilar5_skai = $inheren_operasional5_skai['jumlah'];

$inheren_operasional_lainnya_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_operasional_lainnya.id_profil_risiko,
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1a IS NOT NULL AND TRIM(pilar6_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1b IS NOT NULL AND TRIM(pilar6_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1c IS NOT NULL AND TRIM(pilar6_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1d IS NOT NULL AND TRIM(pilar6_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1e IS NOT NULL AND TRIM(pilar6_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_operasional_lainnya.pilar6_1f IS NOT NULL AND TRIM(pilar6_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_pilarl_skai = $inheren_operasional_lainnya_skai['jumlah'];

$keterangan_inheren2_operasional_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_operasional.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6_1 IS NOT NULL AND TRIM(ket_pil6_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_pil6 IS NOT NULL AND TRIM(ket_pil6) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_operasional.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$io_ket_skai = $keterangan_inheren2_operasional_skai['jumlah'];





//kpmr operasional
$kpmr_operasional_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_operasional_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar1_skai = $kpmr_operasional_pilar1_skai['jumlah'];


$kpmr_operasional_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar2_skai = $kpmr_operasional_pilar2_skai['jumlah'];

$kpmr_operasional_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar3.kpmr_operasional_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3a IS NOT NULL AND TRIM(pilar3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3b IS NOT NULL AND TRIM(pilar3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_3c IS NOT NULL AND TRIM(pilar3_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total3 IS NOT NULL AND TRIM(pil3_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat3 IS NOT NULL AND TRIM(pil3_peringkat3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4a IS NOT NULL AND TRIM(pilar3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4b IS NOT NULL AND TRIM(pilar3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pilar3_4c IS NOT NULL AND TRIM(pilar3_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_total4 IS NOT NULL AND TRIM(pil3_total4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar3.pil3_peringkat4 IS NOT NULL AND TRIM(pil3_peringkat4) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM kpmr_operasional_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar3_skai = $kpmr_operasional_pilar3_skai['jumlah'];

$kpmr_operasional_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_operasional_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_operasional_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_pilar4_skai = $kpmr_operasional_pilar4_skai['jumlah'];

$respon_unit_kerja_operasional_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru1_skai = $respon_unit_kerja_operasional_pil1_skai['jumlah'];

$respon_unit_kerja_operasional_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru2_skai = $respon_unit_kerja_operasional_pil2_skai['jumlah'];

$respon_unit_kerja_operasional_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3a IS NOT NULL AND TRIM(respon_pil3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3b IS NOT NULL AND TRIM(respon_pil3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_3c IS NOT NULL AND TRIM(respon_pil3_3c) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4a IS NOT NULL AND TRIM(respon_pil3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4b IS NOT NULL AND TRIM(respon_pil3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil3.respon_pil3_4c IS NOT NULL AND TRIM(respon_pil3_4c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru3_skai = $respon_unit_kerja_operasional_pil3_skai['jumlah'];

$respon_unit_kerja_operasional_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_operasional_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_operasional_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_operasional_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ru4_skai = $respon_unit_kerja_operasional_pil4_skai['jumlah'];

$keterangan_kpmr2_operasional_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_operasional.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_3 IS NOT NULL AND TRIM(ket_pil3_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3_4 IS NOT NULL AND TRIM(ket_pil3_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_operasional.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ko_ket_skai = $keterangan_kpmr2_operasional_skai['jumlah'];

$kpmr_operasional = round((($ko_pilar1_skai + $ko_pilar2_skai + $ko_pilar3_skai + $ko_pilar4_skai + $ko_ru1_skai + $ko_ru2_skai + $ko_ru3_skai + $ko_ru4_skai + $ko_ket_skai) / 163) * 100);


//profil operasional
$keterangan_profil_operasional_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_operasional.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_operasional 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_op_skai = $keterangan_profil_operasional_skai['jumlah'];



$inheren_kepatuhan1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_1g IS NOT NULL AND TRIM(pilar1_1g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2f IS NOT NULL AND TRIM(pilar1_2f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2g IS NOT NULL AND TRIM(pilar1_2g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar1.pilar1_2h IS NOT NULL AND TRIM(pilar1_2h) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM inheren_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar1_skai = $inheren_kepatuhan1_skai['jumlah'];


$inheren_kepatuhan2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3 IS NOT NULL AND TRIM(pilar2_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilar2_skai = $inheren_kepatuhan2_skai['jumlah'];

$inheren_kepatuhan_lainnya_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_kepatuhan_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_kepatuhan_lainnya.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kepatuhan_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_kepatuhan_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_pilarl_skai = $inheren_kepatuhan_lainnya_skai['jumlah'];


$keterangan_inheren2_kepatuhan_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_kepatuhan.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_kepatuhan.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ikep_ket_skai = $keterangan_inheren2_kepatuhan_skai['jumlah'];




//kpmr kepatuhan
$kpmr_kepatuhan_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7a IS NOT NULL AND TRIM(pilar1_7a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7b IS NOT NULL AND TRIM(pilar1_7b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pilar1_7c IS NOT NULL AND TRIM(pilar1_7c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_total7 IS NOT NULL AND TRIM(pil1_total7) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_kepatuhan_pilar1.pil1_peringkat7 IS NOT NULL AND TRIM(pil1_peringkat7) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar1_skai = $kpmr_kepatuhan_pilar1_skai['jumlah'];


$kpmr_kepatuhan_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar2_skai = $kpmr_kepatuhan_pilar2_skai['jumlah'];

$kpmr_kepatuhan_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar3_skai = $kpmr_kepatuhan_pilar3_skai['jumlah'];

$kpmr_kepatuhan_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_kepatuhan_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_kepatuhan_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_kepatuhan_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_pilar4_skai = $kpmr_kepatuhan_pilar4_skai['jumlah'];

$respon_unit_kerja_kepatuhan_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7a IS NOT NULL AND TRIM(respon_pil1_7a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7b IS NOT NULL AND TRIM(respon_pil1_7b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil1.respon_pil1_7c IS NOT NULL AND TRIM(respon_pil1_7c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru1_skai = $respon_unit_kerja_kepatuhan_pil1_skai['jumlah'];

$respon_unit_kerja_kepatuhan_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru2_skai = $respon_unit_kerja_kepatuhan_pil2_skai['jumlah'];

$respon_unit_kerja_kepatuhan_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru3_skai = $respon_unit_kerja_kepatuhan_pil3_skai['jumlah'];

$respon_unit_kerja_kepatuhan_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_kepatuhan_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_kepatuhan_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_kepatuhan_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ru4_skai = $respon_unit_kerja_kepatuhan_pil4_skai['jumlah'];

$keterangan_kpmr2_kepatuhan_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1_7 IS NOT NULL AND TRIM(ket_pil1_7) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_kepatuhan.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kkep_ket_skai = $keterangan_kpmr2_kepatuhan_skai['jumlah'];


//profil kepatuhan
$keterangan_profil_kepatuhan_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_kepatuhan.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_kepatuhan.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kepatuhan 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_kep_skai = $keterangan_profil_kepatuhan_skai['jumlah'];






//inheren reputasi
$inheren_reputasi1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar1.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar1_skai = $inheren_reputasi1_skai['jumlah'];


$inheren_reputasi2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar2.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar2_skai = $inheren_reputasi2_skai['jumlah'];

$inheren_reputasi3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN inheren_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilar3_skai = $inheren_reputasi3_skai['jumlah'];


$inheren_reputasi_lainnya_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	inheren_reputasi_lainnya.id_profil_risiko,
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN inheren_reputasi_lainnya.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_lainnya 
INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_pilarl_skai = $inheren_reputasi_lainnya_skai['jumlah'];


$keterangan_inheren2_reputasi_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_inheren2_reputasi.id_profil_risiko,
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN keterangan_inheren2_reputasi.ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$irep_ket_skai = $keterangan_inheren2_reputasi_skai['jumlah'];




//kpmr reputasi
$kpmr_reputasi_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_reputasi_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar1_skai = $kpmr_reputasi_pilar1_skai['jumlah'];


$kpmr_reputasi_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar2_skai = $kpmr_reputasi_pilar2_skai['jumlah'];

$kpmr_reputasi_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar3_skai = $kpmr_reputasi_pilar3_skai['jumlah'];

$kpmr_reputasi_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_reputasi_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_reputasi_pilar4.pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_reputasi_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_pilar4_skai = $kpmr_reputasi_pilar4_skai['jumlah'];

$respon_unit_kerja_reputasi_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru1_skai = $respon_unit_kerja_reputasi_pil1_skai['jumlah'];

$respon_unit_kerja_reputasi_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru2_skai = $respon_unit_kerja_reputasi_pil2_skai['jumlah'];

$respon_unit_kerja_reputasi_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru3_skai = $respon_unit_kerja_reputasi_pil3_skai['jumlah'];

$respon_unit_kerja_reputasi_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_reputasi_pil4.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_reputasi_pil4.respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil4 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_reputasi_pil4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ru4_skai = $respon_unit_kerja_reputasi_pil4_skai['jumlah'];

$keterangan_kpmr2_reputasi_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_reputasi.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$krep_ket_skai = $keterangan_kpmr2_reputasi_skai['jumlah'];



//profil reputasi
$keterangan_profil_reputasi_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_reputasi.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_reputasi.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_reputasi 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_rep_skai = $keterangan_profil_reputasi_skai['jumlah'];



















//kpmr stratejik
$kpmr_stratejik_pilar1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar1.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN kpmr_stratejik_pilar1.pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar1 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar1_skai = $kpmr_stratejik_pilar1_skai['jumlah'];


$kpmr_stratejik_pilar2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar2.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar2.pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar2 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar2_skai = $kpmr_stratejik_pilar2_skai['jumlah'];

$kpmr_stratejik_pilar3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar3.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar3.pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar3 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar3_skai = $kpmr_stratejik_pilar3_skai['jumlah'];

$kpmr_stratejik_pilar4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	kpmr_stratejik_pilar4.id_profil_risiko,
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN kpmr_stratejik_pilar4.pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar4.pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN kpmr_stratejik_pilar4.pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar4 
INNER JOIN frame_laporan_profil_risiko ON kpmr_stratejik_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_pilar4_skai = $kpmr_stratejik_pilar4_skai['jumlah'];

$respon_unit_kerja_stratejik_pil1_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil1.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil1.respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil1 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru1_skai = $respon_unit_kerja_stratejik_pil1_skai['jumlah'];

$respon_unit_kerja_stratejik_pil2_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil2.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil2.respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil2 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru2_skai = $respon_unit_kerja_stratejik_pil2_skai['jumlah'];

$respon_unit_kerja_stratejik_pil3_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	respon_unit_kerja_stratejik_pil3.id_profil_risiko,
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_unit_kerja_stratejik_pil3.respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil3 
INNER JOIN frame_laporan_profil_risiko ON respon_unit_kerja_stratejik_pil3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru3_skai = $respon_unit_kerja_stratejik_pil3_skai['jumlah'];

$respon_unit_kerja_stratejik_pil4_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	MIN(id_profil_risiko) AS id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil4 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ru4_skai = $respon_unit_kerja_stratejik_pil4_skai['jumlah'];

$keterangan_kpmr2_stratejik_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_kpmr2_stratejik.id_profil_risiko,
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_kpmr2_stratejik.ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_stratejik 
INNER JOIN frame_laporan_profil_risiko ON keterangan_kpmr2_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$kstra_ket_skai = $keterangan_kpmr2_stratejik_skai['jumlah'];



//profil stratejik
$keterangan_profil_stratejik_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	keterangan_profil_stratejik.id_profil_risiko,
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN keterangan_profil_stratejik.ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_stratejik 
INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$ket_pronil_stra_skai = $keterangan_profil_stratejik_skai['jumlah'];






//profil nilai
$nilai_profil_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	nilai_profil.id_profil_risiko,
    SUM(CASE WHEN nilai_profil.ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil 
INNER JOIN frame_laporan_profil_risiko ON nilai_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_nilai_uraian_skai = $nilai_profil_skai['jumlah'];



//profil peringkat
$peringkat_profil_skai = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
  	peringkat_profil.id_profil_risiko,
    SUM(CASE WHEN peringkat_profil.ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil 
INNER JOIN frame_laporan_profil_risiko ON peringkat_profil.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko
WHERE frame_laporan_profil_risiko.dibuat_by = 143 AND frame_laporan_profil_risiko.tahun =? AND frame_laporan_profil_risiko.periode =? AND frame_laporan_profil_risiko.user = 2", [$tahun, $periode]));
$profil_peringkat_uraian_skai = $peringkat_profil_skai['jumlah'];





$persen_skai = round((($kk_pilar1_skai + $kk_pilar2_skai + $kk_pilar3_skai + $kk_pilar4_skai + $kk_ru1_skai + $kk_ru2_skai + $kk_ru3_skai + $kk_ru4_skai + $kk_ket_skai + $ket_pronil_kre_skai + $klik_pilar1_skai + $klik_pilar2_skai + $klik_pilar3_skai + $klik_pilar4_skai + $klik_ru1_skai + $klik_ru2_skai + $klik_ru3_skai + $klik_ru4_skai + $klik_ket_skai + $ket_pronil_lik_skai + $io_pilar1_skai + $io_pilar2_skai + $io_pilar3_skai + $io_pilar4_skai + $io_pilar5_skai + $io_pilarl_skai + $io_ket_skai + $ko_pilar1_skai + $ko_pilar2_skai + $ko_pilar3_skai + $ko_pilar4_skai + $ko_ru1_skai + $ko_ru2_skai + $ko_ru3_skai + $ko_ru4_skai + $ko_ket_skai + $ket_pronil_op_skai + $ikep_pilar1_skai + $ikep_pilar2_skai + $ikep_pilarl_skai + $ikep_ket_skai + $kkep_pilar1_skai + $kkep_pilar2_skai + $kkep_pilar3_skai + $kkep_pilar4_skai + $kkep_ru1_skai + $kkep_ru2_skai + $kkep_ru3_skai + $kkep_ru4_skai + $kkep_ket_skai + $ket_pronil_kep_skai + $irep_pilar1_skai + $irep_pilar2_skai + $irep_pilar3_skai + $irep_pilarl_skai + $irep_ket_skai + $krep_pilar1_skai + $krep_pilar2_skai + $krep_pilar3_skai + $krep_pilar4_skai + $krep_ru1_skai + $krep_ru2_skai + $krep_ru3_skai + $krep_ru4_skai + $krep_ket_skai + $ket_pronil_rep_skai + $kstra_pilar1_skai + $kstra_pilar2_skai + $kstra_pilar3_skai + $kstra_pilar4_skai + $kstra_ru1_skai + $kstra_ru2_skai + $kstra_ru3_skai + $kstra_ru4_skai + $kstra_ket_skai + $ket_pronil_stra_skai + $profil_nilai_uraian_skai + $profil_peringkat_uraian_skai) / 640) * 100);




?>
<!---->


¯¯¯
<?php error_reporting(E_ALL ^ E_NOTICE); ?>
<div class="content-page">
    <div class="content">


                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Rekap Persentase Pengeraan</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Rekap Pengerjaan</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <!-- end row-->


                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">  <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                               
                                                <div class="col-lg-6">
                                                        <label for="tahun" class="form-label">Tahun</label>
                                                        <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                            <option value=" " selected> </option>
                                                            <option value="2024" <?= 2024 == $tahun ? ' selected' : '' ?>>2024</option>
                                                            <option value="2025" <?= 2025 == $tahun ? ' selected' : '' ?>>2025</option>
                                                            <option value="2026" <?= 2026 == $tahun ? ' selected' : '' ?>>2026</option>
                                                            <option value="2027" <?= 2027 == $tahun ? ' selected' : '' ?>>2027</option>
                                                            <option value="2028" <?= 2028 == $tahun ? ' selected' : '' ?>>2028</option>
                                                            <option value="2029" <?= 2029 == $tahun ? ' selected' : '' ?>>2029</option>
                                                            <option value="2030" <?= 2030 == $tahun ? ' selected' : '' ?>>2030</option>
                                                            <option value="2031" <?= 2031 == $tahun ? ' selected' : '' ?>>2031</option>
                                                            <option value="2032" <?= 2032 == $tahun ? ' selected' : '' ?>>2032</option>
                                                            <option value="2033" <?= 2033 == $tahun ? ' selected' : '' ?>>2033</option>
                                                            <option value="2034" <?= 2034 == $tahun ? ' selected' : '' ?>>2034</option>
                                                            <option value="2035" <?= 2035 == $tahun ? ' selected' : '' ?>>2035</option>
                                                            <option value="2036" <?= 2036 == $tahun ? ' selected' : '' ?>>2036</option>
                                                            <option value="2037" <?= 2037 == $tahun ? ' selected' : '' ?>>2037</option>
                                                        </select>
                                                </div>
                                                <div class="col-lg-6">
                                                        <label for="periode" class="form-label">Periode</label>
                                                        <select class="form-select mb-3" name="periode" id="periode" required="">
                                                        <option value=" " selected> </option>
                                                                    <?php
                                                                    require dirname(__DIR__, 2).'/conn/conn.php';
                                                                    $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                                    while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                                        <option value="<?= $data['id_periode'] ?>" <?= $data['id_periode'] == $periode ? ' selected' : '' ?>><?= ucwords($data['periode_laporan']) ?></option>
                                                                    <?php
                                                                    };
                                                                    ?>
                                                        </select>
                                                </div>
                                                <div class="mb-3 text-center">
                                                        <button class="btn btn-primary" type="submit" name="submit">Cari</button>
                                                </div>

                                            </div>
                                        </form>
                                        <!-- end row-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                        </div>
                        <!-- end row-->


                        <!-- end row-->

                        <div class="row">

                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                        <li class="nav-item">
                                            <a href="#semarang" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Divisi</span>
                                            </a>
                                        </li>
                                         <!--
                                        <li class="nav-item">
                                            <a href="#solo" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Kantor cabang</span>
                                            </a>
                                        </li>-->
                                        
                                    
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="semarang">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Divisi <?= $ilik_pilar1 ?></h4>

                                                            <div class="tab-pane show active" id="scroll-horizontal-preview">
                                                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
                                                                <thead>
                                                                        <tr>
                                                                            <th width="10%">No</th>
                                                                            <th width="20%">Divisi</th>
                                                                            <th width="70%">Progress Pengerjaan</th>
                                                                            
                                                                           
                                                                        </tr>
                                                                    </thead>


                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>Divisi Pemasaran</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_pemasaran ?>%"><?= $persen_pemasaran ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>Divisi Penyelesaian Kredit</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_dpk ?>%"><?= $persen_dpk ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>Divisi Operasional</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_operasional ?>%"><?= $persen_operasional ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td>Divisi SDM</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_sdm ?>%"><?= $persen_sdm ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>5</td>
                                                                            <td>Divisi Sekper</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_sekper ?>%"><?= $persen_sekper ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>6</td>
                                                                            <td>Divisi Litbang</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_litbang ?>%"><?= $persen_litbang ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>7</td>
                                                                            <td>Satuan Kerja Kepatuhan</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_kepatuhan ?>%"><?= $persen_kepatuhan ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>8</td>
                                                                            <td>Satuan Kerja Audit Internal</td>
                                                                            <td>
                                                                            <div class="progress">
                                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $persen_skai ?>%"><?= $persen_skai ?> %</div>
                                                                            </div>
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="solo">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Area Solo</h4>

                                                            <div class="tab-pane show active" id="basic-datatable-preview">
                                                                <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                                <thead>
                                                                        <tr>
                                                                            <th>Kode</th>
                                                                            <th>Kantor Cabang</th>
                                                                            <th>Risiko Kredit</th>
                                                                            <th>Risiko Operasional</th>
                                                                            <th>Risiko Kepatuhan</th>
                                                                            <th>Risiko Likuiditas</th>
                                                                            <th>Risiko Reputasi</th>
                                                                            <th>Risiko Stratejik</th>
                                                                           
                                                                        </tr>
                                                                    </thead>


                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>
                            </div>

                                
                        </div>
                        <!-- end row-->

                        
                    </div> <!-- container -->



    </div>
    <!-- content -->



</div>


<script src="../assets/js/vendor/Chart.bundle.min.js"></script>










