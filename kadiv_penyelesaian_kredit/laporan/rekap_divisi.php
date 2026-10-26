<?php
include "../conn/conn.php";

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
$get_data_user = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user

WHERE user_id = '$id'"));

?>


<!--jamu-->
<?php
$tahun = $_GET['tahun'];
$periode = $_GET['periode'];

$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT id_profil_risiko,data_pembanding FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode'"));


$id_pro = $frame['id_profil_risiko'];
$dp = $frame['data_pembanding'];

//kredit
$kredit1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$kredit2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$kredit3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$kredit4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$kredit5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$kredit6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$kredit7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$kredit8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));

//operasional

$operasional1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$operasional2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$operasional3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$operasional4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$operasional5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$operasional6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$operasional7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$operasional8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));

//kepatuhan

$kepatuhan1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$kepatuhan2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$kepatuhan3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$kepatuhan4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$kepatuhan5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$kepatuhan6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$kepatuhan7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$kepatuhan8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));

//likuiditas

$likuiditas1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$likuiditas2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$likuiditas3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$likuiditas4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$likuiditas5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$likuiditas6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$likuiditas7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$likuiditas8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));

//reputasi

$reputasi1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$reputasi2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$reputasi3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$reputasi4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$reputasi5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$reputasi6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$reputasi7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$reputasi8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));


//stratejik

$stratejik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$stratejik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$stratejik3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$stratejik4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$stratejik5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$stratejik6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$stratejik7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$stratejik8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));



//tingkat_ris

$tingkat_ris1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132"));
$tingkat_ris2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142"));
$tingkat_ris3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133"));
$tingkat_ris4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134"));
$tingkat_ris5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136"));
$tingkat_ris6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137"));
$tingkat_ris7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135"));
$tingkat_ris8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143"));





$semarang_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =2 AND status_skmr =1 AND dibuat_by IN(132,142,133,134,136,137,135,143)"));

if (isset($_POST['submit'])) {
    $kode_kantor = $_POST['kode_kantor'];
    $tahun = $_POST['tahun'];
    $periode = $_POST['periode'];
        header("Location: index.php?page=rekap_dvs&tahun=$tahun&periode=$periode");
        exit();
}
?>
<!---->



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
                                            <li class="breadcrumb-item active">Rekap per korwil</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Rekap Per Divisi</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <!-- end row-->


                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">  <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                               
                                                <div class="mb-3">
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
                                                <div class="mb-3">
                                                        <label for="periode" class="form-label">Periode</label>
                                                        <select class="form-select mb-3" name="periode" id="periode" required="">
                                                        <option value=" " selected> </option>
                                                                    <?php
                                                                    include "../conn/conn.php";
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

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                    <h4 class="header-title mb-4">Laporan Diterima (pastikan untuk laporan diterima 8)</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $semarang_cnt['total'] ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan Divisi</p>
                                                        
                                                    </div>
                                                    <p><b>Note.</b> Perhitungan nilai risiko divisi berbeda dengan konsolidasi, nilai pada inheren dihitung berdasarkan nilai per parameter bukan per pilar dan parameter sudah di bagi
                                                                sesuai dengan risiko yang melekat pada divisi tersebut.
                                                            </p>
                                            </div>
                
                                           
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Grafik Nilai Profil Risiko Per Divisi</h4>

                                        <div class="card-body pb-0">
                                            <canvas style="width:100px; height:30px" id="chart1"></canvas>
                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->

                        <div class="row">

                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                                        <li class="nav-item">
                                            <a href="#semarang" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Divisi Kantor Pusat</span>
                                            </a>
                                        </li>
                                        
                                    
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="semarang">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Divisi Kantor Pusat</h4>
                                                            <p>Note. perhitungan nilai risiko divisi berbeda dengan konsolidasi, nilai pada inheren dihitung berdasarkan nilai per parameter bukan per pilar dan parameter sudah di bagi
                                                                sesuai dengan risiko yang melekat pada divisi tersebut.
                                                            </p>

                                                            <style>
                                                                .rekap-divisi-table {
                                                                    --rd-left-2: 64px;
                                                                    width: 100%;
                                                                }

                                                                .rekap-divisi-table .dt-buttons {
                                                                    display: flex;
                                                                    flex-wrap: wrap;
                                                                    gap: 8px;
                                                                    margin-bottom: 14px;
                                                                }

                                                                .rekap-divisi-table .dt-buttons .btn,
                                                                .rekap-divisi-table .dt-buttons button {
                                                                    border: 0;
                                                                    border-radius: 6px;
                                                                    background: #5f6b75;
                                                                    color: #fff;
                                                                    box-shadow: 0 4px 12px rgba(39, 49, 58, .18);
                                                                    font-weight: 600;
                                                                    padding: 9px 16px;
                                                                }

                                                                .rekap-divisi-table .dataTables_filter {
                                                                    margin-bottom: 14px;
                                                                }

                                                                .rekap-divisi-table .dataTables_filter input {
                                                                    border: 1px solid #d7dde5;
                                                                    border-radius: 6px;
                                                                    padding: 8px 12px;
                                                                    min-width: 220px;
                                                                }

                                                                .rekap-divisi-table .dataTables_scroll {
                                                                    border: 1px solid #e4e9f0;
                                                                    border-radius: 8px;
                                                                    overflow: hidden;
                                                                    background: #fff;
                                                                }

                                                                .rekap-divisi-table .dataTables_scrollBody {
                                                                    border-bottom: 1px solid #e4e9f0 !important;
                                                                    scrollbar-gutter: stable;
                                                                }

                                                                .rekap-divisi-table table.dataTable {
                                                                    width: 100% !important;
                                                                    min-width: 1400px;
                                                                    border-collapse: separate !important;
                                                                    border-spacing: 0;
                                                                    margin: 0 !important;
                                                                }

                                                                .rekap-divisi-table table.dataTable thead th {
                                                                    position: sticky;
                                                                    top: 0;
                                                                    z-index: 5;
                                                                    background: #f4f7fb;
                                                                    border-bottom: 1px solid #dce3eb;
                                                                    color: #1f2933;
                                                                    font-size: 13px;
                                                                    font-weight: 700;
                                                                    line-height: 1.2;
                                                                    padding: 13px 14px;
                                                                    white-space: nowrap;
                                                                    vertical-align: middle;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody td {
                                                                    border-bottom: 1px solid #edf1f5;
                                                                    color: #27313a;
                                                                    font-size: 13px;
                                                                    padding: 12px 14px;
                                                                    white-space: nowrap;
                                                                    vertical-align: middle;
                                                                    background: #fff;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody tr:nth-child(odd) td {
                                                                    background: #f5f7fb;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody tr:hover td {
                                                                    background: #eaf2ff;
                                                                }

                                                                .rekap-divisi-table table.dataTable th:nth-child(1),
                                                                .rekap-divisi-table table.dataTable td:nth-child(1),
                                                                .rekap-divisi-table table.dataTable th:nth-child(2),
                                                                .rekap-divisi-table table.dataTable td:nth-child(2) {
                                                                    position: sticky;
                                                                    z-index: 6;
                                                                }

                                                                .rekap-divisi-table table.dataTable th:nth-child(1),
                                                                .rekap-divisi-table table.dataTable td:nth-child(1) {
                                                                    left: 0;
                                                                    min-width: 64px;
                                                                    text-align: center;
                                                                }

                                                                .rekap-divisi-table table.dataTable th:nth-child(2),
                                                                .rekap-divisi-table table.dataTable td:nth-child(2) {
                                                                    left: var(--rd-left-2);
                                                                    min-width: 250px;
                                                                    box-shadow: 8px 0 12px -12px rgba(15, 23, 42, .75);
                                                                }

                                                                .rekap-divisi-table table.dataTable thead th:nth-child(-n+2) {
                                                                    z-index: 8;
                                                                    background: #e9f0f8;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody tr:nth-child(odd) td:nth-child(-n+2) {
                                                                    background: #eef2f8;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody tr:nth-child(even) td:nth-child(-n+2) {
                                                                    background: #fff;
                                                                }

                                                                .rekap-divisi-table table.dataTable tbody tr:hover td:nth-child(-n+2) {
                                                                    background: #e2edff;
                                                                }

                                                                .rekap-divisi-table .dataTables_info,
                                                                .rekap-divisi-table .dataTables_paginate {
                                                                    padding-top: 14px;
                                                                }
                                                            </style>

                                                            <div class="tab-pane show active rekap-divisi-table" id="buttons-table-preview">
                                                                <table id="datatable-buttons-divisi" class="table table-striped nowrap w-100">
                                                                <thead>
                                                                        <tr>
                                                                            <th>No.</th>
                                                                            <th>Divisi</th>
                                                                            <th>Risiko Kredit</th>
                                                                            <th>Risiko Operasional</th>
                                                                            <th>Risiko Kepatuhan</th>
                                                                            <th>Risiko Likuiditas</th>
                                                                            <th>Risiko Reputasi</th>
                                                                            <th>Risiko Stratejik</th>
                                                                            <th>Nilai Risiko</th>
                                                                            <th>Peringkat</th>
                                                                           
                                                                        </tr>
                                                                    </thead>


                                                                    <tbody>
                                                                    <tr>
                                                                            <td><center>1</center></td>
                                                                            <td>Divisi Pemasaran</td>
                                                                            <td><center><?= $kredit1['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $likuiditas1['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris1['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris1['ket_total_nilai'] ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>2</center></td>
                                                                            <td>Divisi Penyelesaian Kredit</td>
                                                                            <td><center><?= $kredit2['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris2['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris2['ket_total_nilai'] ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>3</center></td>
                                                                            <td>Divisi Operasional</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional3['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris3['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris3['ket_total_nilai'] ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>4</center></td>
                                                                            <td>Divisi SDM</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional4['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris4['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris4['ket_total_nilai'] ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>5</center></td>
                                                                            <td>Divisi Sekper</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $kepatuhan5['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $reputasi5['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris5['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris5['ket_total_nilai'] ?></center></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>6</center></td>
                                                                            <td>Divisi Litbang</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $stratejik6['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris6['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris6['ket_total_nilai'] ?></center></td>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>7</center></td>
                                                                            <td>Satuan Kerja Kepatuhan</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional7['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $kepatuhan7['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $reputasi7['tingkat_risiko'] ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris7['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris7['ket_total_nilai'] ?></center></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>8</center></td>
                                                                            <td>Satuan Kerja Audit Internal</td>
                                                                            <td><center><?= $kredit8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $operasional8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $kepatuhan8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $likuiditas8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $reputasi8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $stratejik8['tingkat_risiko'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris8['total_nilai'] ?></center></td>
                                                                            <td><center><?= $tingkat_ris8['ket_total_nilai'] ?></center></td>
                                                                          
                                                                        </tr>
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


<script>
window.addEventListener('load', function () {
    if (!window.jQuery || !$.fn.DataTable) {
        return;
    }

    var tableSelector = '#datatable-buttons-divisi';
    if (!$(tableSelector).length) {
        return;
    }

    if ($.fn.DataTable.isDataTable(tableSelector)) {
        $(tableSelector).DataTable().destroy();
    }

    var table = $(tableSelector).DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy',
            'csv',
            'excel',
            'print'
        ],
        scrollX: true,
        scrollY: '52vh',
        scrollCollapse: true,
        paging: true,
        pageLength: 10,
        autoWidth: false,
        responsive: false,
        columnDefs: [
            { targets: 0, width: '64px', className: 'text-center' },
            { targets: 1, width: '250px' },
            { targets: '_all', className: 'text-center' }
        ],
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            }
        },
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    function setStickyOffsets() {
        var firstWidth = $(tableSelector + ' thead th').eq(0).outerWidth() || 64;
        $('.rekap-divisi-table').css('--rd-left-2', firstWidth + 'px');
    }

    setStickyOffsets();
    table.on('draw.dt column-sizing.dt responsive-resize.dt', setStickyOffsets);
    $(window).on('resize', setStickyOffsets);
});
</script>

<script src="../assets/js/vendor/Chart.bundle.min.js"></script>




<script>
        var mychart = document.getElementById("chart1").getContext("2d");
        // Mixed chart showing sales of goods  
        // over a period of time 
        new Chart(mychart, {
                type: 'bar',
                data: {
                        datasets: [
                                {
                                        label: 'Tingkat Risiko',
                                        data: [<?= $tingkat_ris1['total_nilai'] ?>,
                                        <?= $tingkat_ris2['total_nilai'] ?>,
                                        <?= $tingkat_ris3['total_nilai'] ?>,
                                        <?= $tingkat_ris4['total_nilai'] ?>,
                                        <?= $tingkat_ris5['total_nilai'] ?>,
                                        <?= $tingkat_ris6['total_nilai'] ?>,
                                        <?= $tingkat_ris7['total_nilai'] ?>,
                                        <?= $tingkat_ris8['total_nilai'] ?>
                                        ],
                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: [
                                        'rgba(255, 99, 132, 0.6)',  // Color for January
                                        'rgba(54, 162, 235, 0.6)',   // Color for February
                                        'rgba(255, 206, 86, 0.6)',    // Color for March
                                        'rgba(75, 192, 192, 0.6)',    // Color for April
                                        'rgba(153, 102, 255, 0.6)',   // Color for May
                                        'rgba(255, 159, 64, 0.6)',     // Color for June
                                        'rgba(255, 99, 132, 0.6)',      // Color for July
                                        'rgba(25, 99, 132, 0.6)'      // Color for July
                                    ],
                                        lineTension: 0.1,
                                        
                                        

                                }
                                
                        ], //end data sets 
                        labels: ['Divisi Pemasaran', 'Divisi Penyelesaian Kedit', 'Divisi Operasional', 'Divisi SDM','Divisi Sekper','Divisi Litbang', 'SKK', 'SKAI']
                },
                options: {
                        scales: {
                                yAxes: [{
                                        id: 'B',
                                        type: 'linear',
                                        position: 'left',
                                        ticks: {
                                            beginAtZero: true,
                                            min: 0,
                                            max: 5
                                                
                                                
                                        },
                                }]
                        },
                        legend: {
                                display: false,
                        },
                        tooltips: {
                                callbacks: {
                                        label: tooltipItem => `${tooltipItem.yLabel}: ${tooltipItem.xLabel}`,
                                        title: () => null,
                                }
                        }
                }
        });
</script>








