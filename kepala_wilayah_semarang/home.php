<?php include "verif.php"; ?>
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

$id = $_SESSION['user_id'] ?? null;
$get_data_user = mysqli_fetch_array(mysqli_query($conn, "SELECT nama FROM user

WHERE user_id = '$id'"));

?>


<!--jamu-->
<?php

$kode_kantor = (int)($_GET['kode_kantor'] ?? 0);
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);
$periode_sebelum = $periode-1;
if ($periode == 1) {
    $prevtriwulan = 4;
    $prevtahun = $tahun - 1;
} else {
    $prevtriwulan = $periode - 1;
    $prevtahun = $tahun;
}
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT id_profil_risiko,data_pembanding FROM frame_laporan_profil_risiko WHERE kantor_cabang = '$kode_kantor' AND tahun ='$tahun' AND periode ='$periode'"));


$id_pro = $frame['id_profil_risiko'] ?? 0;
$dp = $frame['data_pembanding'] ?? 0;




//tren
$currentYear = date("Y");
$tren1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 1 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 2 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 3 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 4 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 5 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 6 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));
$tren7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 7 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1"));

$perper1 = $tren1['periode'] ?? null;
$perper2 = $tren2['periode'] ?? null;
$perper3 = $tren3['periode'] ?? null;
$perper4 = $tren4['periode'] ?? null;
$perper5 = $tren5['periode'] ?? null;
$perper6 = $tren6['periode'] ?? null;
$perper7 = $tren7['periode'] ?? null;

$nilai_per1 = $perper1 - 1;
$nilai_per2 = $perper2 - 1;
$nilai_per3 = $perper3 - 1;
$nilai_per4 = $perper4 - 1;
$nilai_per5 = $perper5 - 1;
$nilai_per6 = $perper6 - 1;
$nilai_per7 = $perper7 - 1;

$tren2_1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 1 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per1'"));
$tren2_2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 2 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per2'"));
$tren2_3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 3 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per3'"));
$tren2_4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 4 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per4'"));
$tren2_5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 5 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per5'"));
$tren2_6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 6 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per6'"));
$tren2_7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$currentYear' AND kantor_cabang = 7 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = '$nilai_per7'"));

$tr1 = $tren1['total_nilai'] ?? null;
$tr2 = $tren2['total_nilai'] ?? null;
$tr3 = $tren3['total_nilai'] ?? null;
$tr4 = $tren4['total_nilai'] ?? null;
$tr5 = $tren5['total_nilai'] ?? null;
$tr6 = $tren6['total_nilai'] ?? null;
$tr7 = $tren7['total_nilai'] ?? null;



$tr2_1 = $tren2_1['total_nilai'] ?? null;
$tr2_2 = $tren2_2['total_nilai'] ?? null;
$tr2_3 = $tren2_3['total_nilai'] ?? null;
$tr2_4 = $tren2_4['total_nilai'] ?? null;
$tr2_5 = $tren2_5['total_nilai'] ?? null;
$tr2_6 = $tren2_6['total_nilai'] ?? null;
$tr2_7 = $tren2_7['total_nilai'] ?? null;

$nilai_tr1 = ($tr1+$tr2+$tr3+$tr4+$tr5+$tr6+$tr7)/7;
$nilai_tr2 = ($tr2_1+$tr2_2+$tr2_3+$tr2_4+$tr2_5+$tr2_6+$tr2_7)/7;





$ket1_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));
$ket2_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));
$ket3_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));
$ket4_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));
$ket5_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));
$ket6_tw1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =1"));

$ket1_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));
$ket2_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));
$ket3_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));
$ket4_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));
$ket5_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));
$ket6_tw2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =2"));

$ket1_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));
$ket2_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));
$ket3_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));
$ket4_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));
$ket5_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));
$ket6_tw3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =3"));

$ket1_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));
$ket2_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));
$ket3_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));
$ket4_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));
$ket5_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));
$ket6_tw4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode =4"));



$ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));
$ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));
$ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));
$ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));
$ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));
$ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$tahun' AND frame_laporan_profil_risiko.periode ='$periode'"));

$pembanding_ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_kredit_p FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));
$pembanding_ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_operasional_p FROM keterangan_profil_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));
$pembanding_ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_kepatuhan_p FROM keterangan_profil_kepatuhan INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kepatuhan.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));
$pembanding_ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_likuiditas_p FROM keterangan_profil_likuiditas INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_likuiditas.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));
$pembanding_ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_reputasi_p FROM keterangan_profil_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));
$pembanding_ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_stratejik_p FROM keterangan_profil_stratejik INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_stratejik.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE frame_laporan_profil_risiko.kantor_cabang IN (1,2,3,4,5,6,7) AND frame_laporan_profil_risiko.tahun ='$prevtahun' AND frame_laporan_profil_risiko.periode ='$prevtriwulan'"));

$rata_kredit = $ket1['rata_kredit'] ?? null;
$rata_operasional = $ket2['rata_operasional'] ?? null;
$rata_kepatuhan = $ket3['rata_kepatuhan'] ?? null;
$rata_likuiditas = $ket4['rata_likuiditas'] ?? null;
$rata_reputasi = $ket5['rata_reputasi'] ?? null;
$rata_stratejik = $ket6['rata_stratejik'] ?? null;



if ($rata_kredit < 1.00) {
    $ket_rata_kredit = " ";
} else if ($rata_kredit >= 1.00 && $rata_kredit < 1.25) {
    $ket_rata_kredit = "Sangat Rendah";
} else if ($rata_kredit >= 1.25 && $rata_kredit < 2.25) {
    $ket_rata_kredit = "Rendah";
} else if ($rata_kredit >= 2.25 && $rata_kredit < 3.25) {
    $ket_rata_kredit = "Sedang";
} else if ($rata_kredit >= 3.25 && $rata_kredit < 4.25) {
    $ket_rata_kredit = "Tinggi";
} else if ($rata_kredit >= 4.25 && $rata_kredit <= 5.00) {
    $ket_rata_kredit = "Sangat Tinggi";
} else {
    $ket_rata_kredit = " ";
}

//hasil peringkat
if ($rata_operasional < 1.00) {
    $ket_rata_operasional = " ";
} else if ($rata_operasional >= 1.00 && $rata_operasional < 1.25) {
    $ket_rata_operasional = "Sangat Rendah";
} else if ($rata_operasional >= 1.25 && $rata_operasional < 2.25) {
    $ket_rata_operasional = "Rendah";
} else if ($rata_operasional >= 2.25 && $rata_operasional < 3.25) {
    $ket_rata_operasional = "Sedang";
} else if ($rata_operasional >= 3.25 && $rata_operasional < 4.25) {
    $ket_rata_operasional = "Tinggi";
} else if ($rata_operasional >= 4.25 && $rata_operasional <= 5.00) {
    $ket_rata_operasional = "Sangat Tinggi";
} else {
    $ket_rata_operasional = " ";
}

//hasil peringkat
if ($rata_kepatuhan < 1.00) {
    $ket_rata_kepatuhan = " ";
} else if ($rata_kepatuhan >= 1.00 && $rata_kepatuhan < 1.25) {
    $ket_rata_kepatuhan = "Sangat Rendah";
} else if ($rata_kepatuhan >= 1.25 && $rata_kepatuhan < 2.25) {
    $ket_rata_kepatuhan = "Rendah";
} else if ($rata_kepatuhan >= 2.25 && $rata_kepatuhan < 3.25) {
    $ket_rata_kepatuhan = "Sedang";
} else if ($rata_kepatuhan >= 3.25 && $rata_kepatuhan < 4.25) {
    $ket_rata_kepatuhan = "Tinggi";
} else if ($rata_kepatuhan >= 4.25 && $rata_kepatuhan <= 5.00) {
    $ket_rata_kepatuhan = "Sangat Tinggi";
} else {
    $ket_rata_kepatuhan = " ";
}

//hasil peringkat
if ($rata_likuiditas < 1.00) {
    $ket_rata_likuiditas = " ";
} else if ($rata_likuiditas >= 1.00 && $rata_likuiditas < 1.25) {
    $ket_rata_likuiditas = "Sangat Rendah";
} else if ($rata_likuiditas >= 1.25 && $rata_likuiditas < 2.25) {
    $ket_rata_likuiditas = "Rendah";
} else if ($rata_likuiditas >= 2.25 && $rata_likuiditas < 3.25) {
    $ket_rata_likuiditas = "Sedang";
} else if ($rata_likuiditas >= 3.25 && $rata_likuiditas < 4.25) {
    $ket_rata_likuiditas = "Tinggi";
} else if ($rata_likuiditas >= 4.25 && $rata_likuiditas <= 5.00) {
    $ket_rata_likuiditas = "Sangat Tinggi";
} else {
    $ket_rata_likuiditas = " ";
}

//hasil peringkat
if ($rata_reputasi < 1.00) {
    $ket_rata_reputasi = " ";
} else if ($rata_reputasi >= 1.00 && $rata_reputasi < 1.25) {
    $ket_rata_reputasi = "Sangat Rendah";
} else if ($rata_reputasi >= 1.25 && $rata_reputasi < 2.25) {
    $ket_rata_reputasi = "Rendah";
} else if ($rata_reputasi >= 2.25 && $rata_reputasi < 3.25) {
    $ket_rata_reputasi = "Sedang";
} else if ($rata_reputasi >= 3.25 && $rata_reputasi < 4.25) {
    $ket_rata_reputasi = "Tinggi";
} else if ($rata_reputasi >= 4.25 && $rata_reputasi <= 5.00) {
    $ket_rata_reputasi = "Sangat Tinggi";
} else {
    $ket_rata_reputasi = " ";
}

//hasil peringkat
if ($rata_stratejik < 1.00) {
    $ket_rata_stratejik = " ";
} else if ($rata_stratejik >= 1.00 && $rata_stratejik < 1.25) {
    $ket_rata_stratejik = "Sangat Rendah";
} else if ($rata_stratejik >= 1.25 && $rata_stratejik < 2.25) {
    $ket_rata_stratejik = "Rendah";
} else if ($rata_stratejik >= 2.25 && $rata_stratejik < 3.25) {
    $ket_rata_stratejik = "Sedang";
} else if ($rata_stratejik >= 3.25 && $rata_stratejik < 4.25) {
    $ket_rata_stratejik = "Tinggi";
} else if ($rata_stratejik >= 4.25 && $rata_stratejik <= 5.00) {
    $ket_rata_stratejik = "Sangat Tinggi";
} else {
    $ket_rata_stratejik = " ";
}



$pembanding_rata_kredit = $pembanding_ket1['rata_kredit_p'] ?? null;
$pembanding_rata_operasional = $pembanding_ket2['rata_operasional_p'] ?? null;
$pembanding_rata_kepatuhan = $pembanding_ket3['rata_kepatuhan_p'] ?? null;
$pembanding_rata_likuiditas = $pembanding_ket4['rata_likuiditas_p'] ?? null;
$pembanding_rata_reputasi = $pembanding_ket5['rata_reputasi_p'] ?? null;
$pembanding_rata_stratejik = $pembanding_ket6['rata_stratejik_p'] ?? null;



if ($pembanding_rata_kredit < 1.00) {
    $pembanding_ket_rata_kredit = " ";
} else if ($pembanding_rata_kredit >= 1.00 && $pembanding_rata_kredit < 1.25) {
    $pembanding_ket_rata_kredit = "Sangat Rendah";
} else if ($pembanding_rata_kredit >= 1.25 && $pembanding_rata_kredit < 2.25) {
    $pembanding_ket_rata_kredit = "Rendah";
} else if ($pembanding_rata_kredit >= 2.25 && $pembanding_rata_kredit < 3.25) {
    $pembanding_ket_rata_kredit = "Sedang";
} else if ($pembanding_rata_kredit >= 3.25 && $pembanding_rata_kredit < 4.25) {
    $pembanding_ket_rata_kredit = "Tinggi";
} else if ($pembanding_rata_kredit >= 4.25 && $pembanding_rata_kredit <= 5.00) {
    $pembanding_ket_rata_kredit = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_kredit = " ";
}

//hasil peringkat
if ($pembanding_rata_operasional < 1.00) {
    $pembanding_ket_rata_operasional = " ";
} else if ($pembanding_rata_operasional >= 1.00 && $pembanding_rata_operasional < 1.25) {
    $pembanding_ket_rata_operasional = "Sangat Rendah";
} else if ($pembanding_rata_operasional >= 1.25 && $pembanding_rata_operasional < 2.25) {
    $pembanding_ket_rata_operasional = "Rendah";
} else if ($pembanding_rata_operasional >= 2.25 && $pembanding_rata_operasional < 3.25) {
    $pembanding_ket_rata_operasional = "Sedang";
} else if ($pembanding_rata_operasional >= 3.25 && $pembanding_rata_operasional < 4.25) {
    $pembanding_ket_rata_operasional = "Tinggi";
} else if ($pembanding_rata_operasional >= 4.25 && $pembanding_rata_operasional <= 5.00) {
    $pembanding_ket_rata_operasional = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_operasional = " ";
}

//hasil peringkat
if ($pembanding_rata_kepatuhan < 1.00) {
    $pembanding_ket_rata_kepatuhan = " ";
} else if ($pembanding_rata_kepatuhan >= 1.00 && $pembanding_rata_kepatuhan < 1.25) {
    $pembanding_ket_rata_kepatuhan = "Sangat Rendah";
} else if ($pembanding_rata_kepatuhan >= 1.25 && $pembanding_rata_kepatuhan < 2.25) {
    $pembanding_ket_rata_kepatuhan = "Rendah";
} else if ($pembanding_rata_kepatuhan >= 2.25 && $pembanding_rata_kepatuhan < 3.25) {
    $pembanding_ket_rata_kepatuhan = "Sedang";
} else if ($pembanding_rata_kepatuhan >= 3.25 && $pembanding_rata_kepatuhan < 4.25) {
    $pembanding_ket_rata_kepatuhan = "Tinggi";
} else if ($pembanding_rata_kepatuhan >= 4.25 && $pembanding_rata_kepatuhan <= 5.00) {
    $pembanding_ket_rata_kepatuhan = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_kepatuhan = " ";
}

//hasil peringkat
if ($pembanding_rata_likuiditas < 1.00) {
    $pembanding_ket_rata_likuiditas = " ";
} else if ($pembanding_rata_likuiditas >= 1.00 && $pembanding_rata_likuiditas < 1.25) {
    $pembanding_ket_rata_likuiditas = "Sangat Rendah";
} else if ($pembanding_rata_likuiditas >= 1.25 && $pembanding_rata_likuiditas < 2.25) {
    $pembanding_ket_rata_likuiditas = "Rendah";
} else if ($pembanding_rata_likuiditas >= 2.25 && $pembanding_rata_likuiditas < 3.25) {
    $pembanding_ket_rata_likuiditas = "Sedang";
} else if ($pembanding_rata_likuiditas >= 3.25 && $pembanding_rata_likuiditas < 4.25) {
    $pembanding_ket_rata_likuiditas = "Tinggi";
} else if ($pembanding_rata_likuiditas >= 4.25 && $pembanding_rata_likuiditas <= 5.00) {
    $pembanding_ket_rata_likuiditas = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_likuiditas = " ";
}

//hasil peringkat
if ($pembanding_rata_reputasi < 1.00) {
    $pembanding_ket_rata_reputasi = " ";
} else if ($pembanding_rata_reputasi >= 1.00 && $pembanding_rata_reputasi < 1.25) {
    $pembanding_ket_rata_reputasi = "Sangat Rendah";
} else if ($pembanding_rata_reputasi >= 1.25 && $pembanding_rata_reputasi < 2.25) {
    $pembanding_ket_rata_reputasi = "Rendah";
} else if ($pembanding_rata_reputasi >= 2.25 && $pembanding_rata_reputasi < 3.25) {
    $pembanding_ket_rata_reputasi = "Sedang";
} else if ($pembanding_rata_reputasi >= 3.25 && $pembanding_rata_reputasi < 4.25) {
    $pembanding_ket_rata_reputasi = "Tinggi";
} else if ($pembanding_rata_reputasi >= 4.25 && $pembanding_rata_reputasi <= 5.00) {
    $pembanding_ket_rata_reputasi = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_reputasi = " ";
}

//hasil peringkat
if ($pembanding_rata_stratejik < 1.00) {
    $pembanding_ket_rata_stratejik = " ";
} else if ($pembanding_rata_stratejik >= 1.00 && $pembanding_rata_stratejik < 1.25) {
    $pembanding_ket_rata_stratejik = "Sangat Rendah";
} else if ($pembanding_rata_stratejik >= 1.25 && $pembanding_rata_stratejik < 2.25) {
    $pembanding_ket_rata_stratejik = "Rendah";
} else if ($pembanding_rata_stratejik >= 2.25 && $pembanding_rata_stratejik < 3.25) {
    $pembanding_ket_rata_stratejik = "Sedang";
} else if ($pembanding_rata_stratejik >= 3.25 && $pembanding_rata_stratejik < 4.25) {
    $pembanding_ket_rata_stratejik = "Tinggi";
} else if ($pembanding_rata_stratejik >= 4.25 && $pembanding_rata_stratejik <= 5.00) {
    $pembanding_ket_rata_stratejik = "Sangat Tinggi";
} else {
    $pembanding_ket_rata_stratejik = " ";
}


//penilaian bpr
$nil1 = $ket1['rata_kredit'] ?? null;
$nil2 = $ket2['rata_operasional'] ?? null;
$nil3 = $ket3['rata_kepatuhan'] ?? null;
$nil4 = $ket4['rata_likuiditas'] ?? null;
$nil5 = $ket5['rata_reputasi'] ?? null;
$nil6 = $ket6['rata_stratejik'] ?? null;





$hsl1 = ($nil1*30)/100;
$hsl2 = ($nil2*30)/100;
$hsl3 = ($nil3*20)/100;
$hsl4 = ($nil4*10)/100;
$hsl5 = ($nil5*5)/100;
$hsl6 = ($nil6*5)/100;

$total_nilai = $hsl1+$hsl2+$hsl3+$hsl4+$hsl5+$hsl6;

//hasil peringkat
if ($total_nilai < 1.00) {
    $ket_total_nilai = " ";
} else if ($total_nilai >= 1.00 && $total_nilai < 1.25) {
    $ket_total_nilai = "Sangat Rendah";
} else if ($total_nilai >= 1.25 && $total_nilai < 2.25) {
    $ket_total_nilai = "Rendah";
} else if ($total_nilai >= 2.25 && $total_nilai < 3.25) {
    $ket_total_nilai = "Sedang";
} else if ($total_nilai >= 3.25 && $total_nilai < 4.25) {
    $ket_total_nilai = "Tinggi";
} else if ($total_nilai >= 4.25 && $total_nilai <= 5.00) {
    $ket_total_nilai = "Sangat Tinggi";
} else {
    $ket_total_nilai = " ";
}


//penilaian bpr
$pembanding_nil1 = $pembanding_ket1['rata_kredit_p'] ?? null;
$pembanding_nil2 = $pembanding_ket2['rata_operasional_p'] ?? null;
$pembanding_nil3 = $pembanding_ket3['rata_kepatuhan_p'] ?? null;
$pembanding_nil4 = $pembanding_ket4['rata_likuiditas_p'] ?? null;
$pembanding_nil5 = $pembanding_ket5['rata_reputasi_p'] ?? null;
$pembanding_nil6 = $pembanding_ket6['rata_stratejik_p'] ?? null;

$pembanding_hsl1 = ($pembanding_nil1*30)/100;
$pembanding_hsl2 = ($pembanding_nil2*30)/100;
$pembanding_hsl3 = ($pembanding_nil3*20)/100;
$pembanding_hsl4 = ($pembanding_nil4*10)/100;
$pembanding_hsl5 = ($pembanding_nil5*5)/100;
$pembanding_hsl6 = ($pembanding_nil6*5)/100;

$pembanding_total_nilai = $pembanding_hsl1+$pembanding_hsl2+$pembanding_hsl3+$pembanding_hsl4+$pembanding_hsl5+$pembanding_hsl6;


//hasil peringkat
if ($pembanding_total_nilai < 1.00) {
    $pembanding_ket_pembanding_total_nilai = " ";
} else if ($pembanding_total_nilai >= 1.00 && $pembanding_total_nilai < 1.25) {
    $pembanding_ket_pembanding_total_nilai = "Sangat Rendah";
} else if ($pembanding_total_nilai >= 1.25 && $pembanding_total_nilai < 2.25) {
    $pembanding_ket_pembanding_total_nilai = "Rendah";
} else if ($pembanding_total_nilai >= 2.25 && $pembanding_total_nilai < 3.25) {
    $pembanding_ket_pembanding_total_nilai = "Sedang";
} else if ($pembanding_total_nilai >= 3.25 && $pembanding_total_nilai < 4.25) {
    $pembanding_ket_pembanding_total_nilai = "Tinggi";
} else if ($pembanding_total_nilai >= 4.25 && $pembanding_total_nilai <= 5.00) {
    $pembanding_ket_pembanding_total_nilai = "Sangat Tinggi";
} else {
    $pembanding_ket_pembanding_total_nilai = " ";
}

//tren per risiko
$tren1_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_tren_kredit1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_kre = $periode - 1;
if ($nilai_per_kre == 0) {
    $yy_kre = $tahun-1;
    $tren2_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_tren_kredit2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$yy_kre' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_kre = $tren2_kre['rata_tren_kredit2'] ?? null;
}  else {
    $tren2_kre = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kredit) AS rata_tren_kredit2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_kre'"));
    $tr2_kre = $tren2_kre['rata_tren_kredit2'] ?? null;
}

$tr1_kre = $tren1_kre['rata_tren_kredit1'] ?? null;




$tren1_op = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_tren_operasional1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_op = $periode - 1;
if ($nilai_per_op == 0) {
    $yy_op = $tahun-1;
    $tren2_op = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_tren_operasional2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$yy_op' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_op = $tren2_op['rata_tren_operasional2'] ?? null;
}  else {
    $tren2_op = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_operasional) AS rata_tren_operasional2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_op'"));
    $tr2_op = $tren2_op['rata_tren_operasional2'] ?? null;
}
$tr1_op = $tren1_op['rata_tren_operasional1'] ?? null;



$tren1_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_tren_kepatuhan1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_kep = $periode - 1;
if ($nilai_per_kep == 0) {
    $yy_kep = $tahun-1;
    $tren2_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_tren_kepatuhan2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$yy_kep' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_kep = $tren2_kep['rata_tren_kepatuhan2'] ?? null;
}  else {
    $tren2_kep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_kepatuhan) AS rata_tren_kepatuhan2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_kep'"));
    $tr2_kep = $tren2_kep['rata_tren_kepatuhan2'] ?? null;
}
$tr1_kep = $tren1_kep['rata_tren_kepatuhan1'] ?? null;



$tren1_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_tren_likuiditas1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_lik = $periode - 1;
if ($nilai_per_lik == 0) {
    $yy_lik = $tahun-1;
    $tren2_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_tren_likuiditas2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$yy_lik' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_lik = $tren2_lik['rata_tren_likuiditas2'] ?? null;
}  else {
    $tren2_lik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_likuiditas) AS rata_tren_likuiditas2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_lik'"));
    $tr2_lik = $tren2_lik['rata_tren_likuiditas2'] ?? null;
}
$tr1_lik = $tren1_lik['rata_tren_likuiditas1'] ?? null;


$tren1_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_tren_reputasi1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_rep = $periode - 1;
if ($nilai_per_rep == 0) {
    $yy_rep = $tahun-1;
    $tren2_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_tren_reputasi2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$yy_rep' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_rep = $tren2_rep['rata_tren_reputasi2'] ?? null;
}  else {
    $tren2_rep = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_reputasi) AS rata_tren_reputasi2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_rep'"));
    $tr2_rep = $tren2_rep['rata_tren_reputasi2'] ?? null;
}
$tr1_rep = $tren1_rep['rata_tren_reputasi1'] ?? null;



$tren1_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_tren_stratejik1 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode ='$periode'"));

$nilai_per_stra = $periode - 1;
if ($nilai_per_stra == 0) {
    $yy_stra = $tahun-1;
    $tren2_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_tren_stratejik2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$yy_stra' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = 4"));
    $tr2_stra = $tren2_stra['rata_tren_stratejik2'] ?? null;
}  else {
    $tren2_stra = mysqli_fetch_assoc(mysqli_query($conn, "SELECT AVG(inheren_stratejik) AS rata_tren_stratejik2 from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND kantor_cabang IN (1,2,3,4,5,6,7) AND user =3 AND periode = '$nilai_per_stra'"));
    $tr2_stra = $tren2_stra['rata_tren_stratejik2'] ?? null;
}
$tr1_stra = $tren1_stra['rata_tren_stratejik1'] ?? null;

$get_data = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE user =3 AND Kantor_cabang IN(1,2,3,4,5,6,7)"));
$get_data2 = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE user =3 AND Kantor_cabang IN(1,2,3,4,5,6,7) AND status_korwil = 1"));
$ket_nilai = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$id_pro'"));
$pembanding_ket_nilai = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$dp'"));

if (isset($_POST['submit'])) {
    $kode_kantor = (int)($_POST['kode_kantor'] ?? 0);
    $tahun = (int)($_POST['tahun'] ?? 0);
    $periode = (int)($_POST['periode'] ?? 0);
        header("Location: index.php?page=dashboard&kode_kantor=$kode_kantor&tahun=$tahun&periode=$periode");
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
                                            <li class="breadcrumb-item active">Rekap</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">DASHBOARD SIMPRO (PROFIL RISIKO KORWIL SEMARANG)</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card widget-inline">
                                    <div class="card-body p-0">
                                        <div class="row g-0">
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card shadow-none m-0">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-download" style="font-size: 24px;"></i>
                                                        <h3><span><?= $get_data['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan Masuk</p>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class=" uil-fast-mail" style="font-size: 24px;"></i>
                                                        <h3><span><?= $get_data2['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan Diteruskan Ke Kantor Pusat</p>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-building" style="font-size: 24px;"></i>
                                                        <h3><span>7</span></h3>
                                                        <p class="text-muted font-15 mb-0">Kantor Cabang</p>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-analysis" style="font-size: 24px;"></i>
                                                        <h3>
                                                            
                                                        
                                                            <?php 
                                                            if ($nilai_tr1 == null) {
                                                                echo '<span>-</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                            } else if ($nilai_tr1 == null && $nilai_tr2 == null) {
                                                                echo '<span>-</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                            } else if ($nilai_tr1 < $nilai_tr2) {
                                                                echo '<span>Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                            } else if ($nilai_tr1 > $nilai_tr2) {
                                                                echo '<span>Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                            } else if ($nilai_tr1 == $nilai_tr2) {
                                                                echo '<span>Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                            } else {
                                                                echo '<span>-</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                            }
                                                            
                                                            
                                                            ?>
                                                            </h3>
                                                            <p class="text-muted font-12 mb-0">Tren Risiko Area Semarang Tahun <?= $currentYear ?> </br>Periode Sekarang Dibanding Periode Sebelumnya</p>
                                                    </div>
                                                </div>
                                            </div>
                
                                        </div> <!-- end row -->
                                    </div>
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row-->


                        <div class="row">
                            <div class="col-lg-3">
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
                                                                        <option value="<?= $data['id_periode'] ?? '' ?>" <?= $data['id_periode'] == $periode ? ' selected' : '' ?>><?= ucwords($data['periode_laporan']) ?></option>
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

                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-3">Grafik Profil Risiko </h4>

                                        <div class="card-body pb-0">
                                            <canvas style="width:100px; height:43px"  id="chart1"></canvas>
                                        </div>
                                        
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                            <div class="col-lg-2">
                                <div class="card">
                                    <div class="card-body">
                                        
                                    <h5 ><b>Risiko Kredit</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_kre == null && $tr2_kre == null || $tr1_kre == 0 && $tr2_kre == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_kre == null || $tr1_kre == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_kre == null || $tr2_kre == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_kre < $tr2_kre) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_kre > $tr2_kre) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_kre == $tr2_kre) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>
                                                    <hr></hr>
                                    <h5 ><b>Risiko Operasional</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_op == null && $tr2_op == null || $tr1_op == 0 && $tr2_op == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_op == null || $tr1_op == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_op == null || $tr2_op == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_op < $tr2_op) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_op > $tr2_op) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_op == $tr2_op) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>
                                                    <hr></hr>
                                    <h5 ><b>Risiko Kepatuhan</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_kep == null && $tr2_kep == null || $tr1_kep == 0 && $tr2_kep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_kep == null || $tr1_kep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_kep == null || $tr2_kep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_kep < $tr2_kep) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_kep > $tr2_kep) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_kep == $tr2_kep) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>
                                                    <hr></hr>
                                    <h5 ><b>Risiko Likuiditas</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_lik == null && $tr2_lik == null || $tr1_lik == 0 && $tr2_lik == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_lik == null || $tr1_lik == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_lik == null || $tr2_lik == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_lik < $tr2_lik) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_lik > $tr2_lik) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_lik == $tr2_lik) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>
                                                    <hr></hr>
                                    <h5 ><b>Risiko Reputasi</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_rep == null && $tr2_rep == null || $tr1_rep == 0 && $tr2_rep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_rep == null || $tr1_rep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_rep == null || $tr2_rep == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_rep < $tr2_rep) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_rep > $tr2_rep) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_rep == $tr2_rep) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>
                                                    <hr></hr>
                                    <h5 ><b>Risiko Stratejik</b></h5>
                                    <h5><center>
                                                        <?php 
                                                        if ($tr1_stra == null && $tr2_stra == null || $tr1_stra == 0 && $tr2_stra == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_stra == null || $tr1_stra == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr2_stra == null || $tr2_stra == 0) {
                                                            echo '<span>-</span> </i>';
                                                        } else if ($tr1_stra < $tr2_stra) {
                                                            echo '<span class="badge badge-success-lighten rounded-pill">Tren Membaik</span> <i class="mdi mdi-arrow-down text-success"></i>';
                                                        } else if ($tr1_stra > $tr2_stra) {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tren Memburuk</span> <i class="mdi mdi-arrow-up text-danger"></i>';
                                                        } else if ($tr1_stra == $tr2_stra) {
                                                            echo '<span class="badge badge-warning-lighten rounded-pill">Tren Stay</span> <i class="mdi mdi-arrow-right text-warning"></i>';
                                                        } else {
                                                            echo '<span>-</span> </i>';
                                                        }
                                                        
                                                        
                                                        ?>
                                                        </center>
                                    </h5>

                                    </div> <!-- end card body-->
                                    
                                </div> <!-- end card -->
                                

                            </div><!-- end col-->
                        </div>
                        <!-- end row-->


                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Grafik Perbandingan Profil Risiko Saat Ini Dengan Periode Sebelumnya</h4>

                                        <div class="card-body pb-0">
                                            <canvas style="width:100px; height:30px" id="chart2"></canvas>
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
                                            <a href="#nilai" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                                                <i class="mdi mdi-home-variant d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Profil Nilai</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#peringkat" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Profil Perigkat</span>
                                            </a>
                                        </li>
                                    
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="nilai">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color: rgba(25, 100, 132, 0.6); color: white;">
                                                            <h4 class="header-title mb-3">Profil Risiko Periode Sebelumnya</h4>
                                                        </div>
                                                        <div class="card-body">
                                                        
                                                            
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-centered table-hover mb-0">
                                                                    <tbody  style="font-size: 20px;">
                                                                        <tr style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                            <td >
                                                                            <span><b>Jenis Risiko</b></span>
                                                                            </td>
                                                                            <td>
                                                                                <span><b>Risiko Inheren</b></span>
                                                                            </td>
                                                                            
                                                                        
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko kredit
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket1['rata_kredit_p']) ? number_format((float)$pembanding_ket1['rata_kredit_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko operasional
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket2['rata_operasional_p']) ? number_format((float)$pembanding_ket2['rata_operasional_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko kepatuhan
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket3['rata_kepatuhan_p']) ? number_format((float)$pembanding_ket3['rata_kepatuhan_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko likuiditas
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket4['rata_likuiditas_p']) ? number_format((float)$pembanding_ket4['rata_likuiditas_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko reputasi
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket5['rata_reputasi_p']) ? number_format((float)$pembanding_ket5['rata_reputasi_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko stratejik
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_ket6['rata_stratejik_p']) ? number_format((float)$pembanding_ket6['rata_stratejik_p'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Dikutip dari laporan sebelumnya
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_total_nilai) ? number_format((float)$pembanding_total_nilai, 2) : '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $pembanding_ket_pembanding_total_nilai ?></b></center>
                                                                                </th>
                                                                            </tr>

                                                                    
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->

                                                <div class="col-xl-6">
                                                    <div class="card">
                                                        <div class="card-header" style="background-color: rgba(100, 200, 132, 0.8); color: white;">
                                                            <h4 class="header-title mb-3">Profil Risiko Saat Ini (yang dipilih) </h4>
                                                        </div>
                                                        <div class="card-body">
                                                        
                                                            
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-centered table-hover mb-0">
                                                                    <tbody style="font-size: 20px;">
                                                                        <tr style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                            <td>
                                                                            <span><b>Jenis Risiko</b></span>
                                                                            </td>
                                                                            <td>
                                                                                <span><b>Risiko Inheren</b></span>
                                                                            </td>
                                                                          
                                                                        </tr>
                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th >
                                                                                    Risiko kredit
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket1['rata_kredit']) ? number_format((float)$ket1['rata_kredit'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko operasional
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket2['rata_operasional']) ? number_format((float)$ket2['rata_operasional'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko kepatuhan
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket3['rata_kepatuhan']) ? number_format((float)$ket3['rata_kepatuhan'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko likuiditas
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket4['rata_likuiditas']) ? number_format((float)$ket4['rata_likuiditas'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko reputasi
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket5['rata_reputasi']) ? number_format((float)$ket5['rata_reputasi'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko stratejik
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= isset($ket6['rata_stratejik']) ? number_format((float)$ket6['rata_stratejik'], 2) : '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>
                                                                            
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= isset($total_nilai) ? number_format((float)$total_nilai, 2) : '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $ket_total_nilai ?></b></center>
                                                                                </th>
                                                                            </tr>

                                                                    
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="peringkat">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="card">
                                                    <div class="card-header" style="background-color: rgba(25, 100, 132, 0.6); color: white;">
                                                            <h4 class="header-title mb-3">Profil Risiko Periode Sebelumnya</h4>
                                                        </div>
                                                        <div class="card-body">
                                                        

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-centered table-hover mb-0">
                                                                    <tbody style="font-size: 20px;">
                                                                        <tr style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                            <td>
                                                                            <span><b>Jenis Risiko</b></span>
                                                                            </td>
                                                                            <td>
                                                                                <span><b>Risiko Inheren</b></span>
                                                                            </td>
                                                                            
                                                                        
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kredit
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_kredit ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko operasional
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_operasional ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kepatuhan
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_kepatuhan ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko likuiditas
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_likuiditas ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko reputasi
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_reputasi ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko stratejik
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_ket_rata_stratejik ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>
                                                                        
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Dikutip dari laporan sebelumnya
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= isset($pembanding_total_nilai) ? number_format((float)$pembanding_total_nilai, 2) : '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $pembanding_ket_pembanding_total_nilai ?></b></center>
                                                                                </th>
                                                                            </tr>

                                                                    
                                                                        
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->

                                                <div class="col-xl-6">
                                                    <div class="card">
                                                    <div class="card-header" style="background-color: rgba(100, 200, 132, 0.8); color: white;">
                                                            <h4 class="header-title mb-3">Profil Risiko Saat Ini (yang dipilih) </h4>
                                                        </div>
                                                        
                                                        <div class="card-body">
                                                            

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-centered table-hover mb-0">
                                                                    <tbody style="font-size: 20px;">
                                                                        <tr style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                            <td>
                                                                            <span><b>Jenis Risiko</b></span>
                                                                            </td>
                                                                            <td>
                                                                                <span><b>Risiko Inheren</b></span>
                                                                            </td>
                                                                           
                                                                        </tr>
                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kredit
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_kredit ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko operasional
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_operasional ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kepatuhan
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_kepatuhan ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko likuiditas
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_likuiditas ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko reputasi
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_reputasi ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko stratejik
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $ket_rata_stratejik ?></b></center>
                                                                            </th>
                                                                          
                                                                        </tr>
                                                                        <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= isset($total_nilai) ? number_format((float)$total_nilai, 2) : '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $ket_total_nilai ?></b></center>
                                                                                </th>
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
                                        label: 'Kredit',
                                        data: [
                                                <?= json_encode(isset($ket1_tw1['rata_kredit']) ? round((float)$ket1_tw1['rata_kredit'], 2) : null) ?>,
                                                <?= json_encode(isset($ket1_tw2['rata_kredit']) ? round((float)$ket1_tw2['rata_kredit'], 2) : null) ?>,
                                                <?= json_encode(isset($ket1_tw3['rata_kredit']) ? round((float)$ket1_tw3['rata_kredit'], 2) : null) ?>,
                                                <?= json_encode(isset($ket1_tw4['rata_kredit']) ? round((float)$ket1_tw4['rata_kredit'], 2) : null) ?>
                                        ],
                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(100, 200, 132, 1)',
                                        lineTension: 0.1,
                                        
                                        

                                },
                                {
                                        label: 'Operasional',
                                        data: [
                                                <?= json_encode(isset($ket2_tw1['rata_operasional']) ? round((float)$ket2_tw1['rata_operasional'], 2) : null) ?>,
                                                <?= json_encode(isset($ket2_tw2['rata_operasional']) ? round((float)$ket2_tw2['rata_operasional'], 2) : null) ?>,
                                                <?= json_encode(isset($ket2_tw3['rata_operasional']) ? round((float)$ket2_tw3['rata_operasional'], 2) : null) ?>,
                                                <?= json_encode(isset($ket2_tw4['rata_operasional']) ? round((float)$ket2_tw4['rata_operasional'], 2) : null) ?>
                                                ],

                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(102, 204, 255, 1)',
                                        lineTension: 0.1,
                                },
                                {
                                        label: 'Kepatuhan',
                                        data: [
                                                <?= json_encode(isset($ket3_tw1['rata_kepatuhan']) ? round((float)$ket3_tw1['rata_kepatuhan'], 2) : null) ?>,
                                                <?= json_encode(isset($ket3_tw2['rata_kepatuhan']) ? round((float)$ket3_tw2['rata_kepatuhan'], 2) : null) ?>,
                                                <?= json_encode(isset($ket3_tw3['rata_kepatuhan']) ? round((float)$ket3_tw3['rata_kepatuhan'], 2) : null) ?>,
                                                <?= json_encode(isset($ket3_tw4['rata_kepatuhan']) ? round((float)$ket3_tw4['rata_kepatuhan'], 2) : null) ?>
                                        ],

                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(255, 217, 102, 1)',
                                        lineTension: 0.1,
                                },
                                {
                                        label: 'Likuiditas',
                                        data: [
                                                <?= json_encode(isset($ket4_tw1['rata_likuiditas']) ? round((float)$ket4_tw1['rata_likuiditas'], 2) : null) ?>,
                                                <?= json_encode(isset($ket4_tw2['rata_likuiditas']) ? round((float)$ket4_tw2['rata_likuiditas'], 2) : null) ?>,
                                                <?= json_encode(isset($ket4_tw3['rata_likuiditas']) ? round((float)$ket4_tw3['rata_likuiditas'], 2) : null) ?>,
                                                <?= json_encode(isset($ket4_tw4['rata_likuiditas']) ? round((float)$ket4_tw4['rata_likuiditas'], 2) : null) ?>
                                        ],

                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(255, 51, 0, 1)',
                                        lineTension: 0.1
                                },
                                {
                                        label: 'Reputasi',
                                        data: [
                                                <?= json_encode(isset($ket5_tw1['rata_reputasi']) ? round((float)$ket5_tw1['rata_reputasi'], 2) : null) ?>,
                                                <?= json_encode(isset($ket5_tw2['rata_reputasi']) ? round((float)$ket5_tw2['rata_reputasi'], 2) : null) ?>,
                                                <?= json_encode(isset($ket5_tw3['rata_reputasi']) ? round((float)$ket5_tw3['rata_reputasi'], 2) : null) ?>,
                                                <?= json_encode(isset($ket5_tw4['rata_reputasi']) ? round((float)$ket5_tw4['rata_reputasi'], 2) : null) ?>
                                        ],

                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(153, 204, 255, 1)',
                                        lineTension: 0.1
                                },
                                {
                                        label: 'Stratejik',
                                        data: [
                                                <?= json_encode(isset($ket6_tw1['rata_stratejik']) ? round((float)$ket6_tw1['rata_stratejik'], 2) : null) ?>,
                                                <?= json_encode(isset($ket6_tw2['rata_stratejik']) ? round((float)$ket6_tw2['rata_stratejik'], 2) : null) ?>,
                                                <?= json_encode(isset($ket6_tw3['rata_stratejik']) ? round((float)$ket6_tw3['rata_stratejik'], 2) : null) ?>,
                                                <?= json_encode(isset($ket6_tw4['rata_stratejik']) ? round((float)$ket6_tw4['rata_stratejik'], 2) : null) ?>
                                        ],

                                        type: 'line',
                                        fill: false,
                                        yAxisID: 'B',
                                        borderColor: 'rgba(89, 89, 89, 1)',
                                        lineTension: 0.1
                                }
                        ], //end data sets 
                        labels: ['Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4']
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
                                                
                                                
                                        }
                                }]
                        }
                }
        });
</script>









<script>
        var mychart = document.getElementById("chart2").getContext("2d");
        // Mixed chart showing sales of goods  
        // over a period of time 
        new Chart(mychart, {
                type: 'bar',
                data: {
                        datasets: [
                                {
                                        label: 'Periode Sebelumnya',
                                        data: [
                                                <?= json_encode(isset($pembanding_ket1['rata_kredit_p']) ? round((float)$pembanding_ket1['rata_kredit_p'], 2) : null) ?>,
                                                <?= json_encode(isset($pembanding_ket2['rata_operasional_p']) ? round((float)$pembanding_ket2['rata_operasional_p'], 2) : null) ?>,
                                                <?= json_encode(isset($pembanding_ket3['rata_kepatuhan_p']) ? round((float)$pembanding_ket3['rata_kepatuhan_p'], 2) : null) ?>,
                                                <?= json_encode(isset($pembanding_ket4['rata_likuiditas_p']) ? round((float)$pembanding_ket4['rata_likuiditas_p'], 2) : null) ?>,
                                                <?= json_encode(isset($pembanding_ket5['rata_reputasi_p']) ? round((float)$pembanding_ket5['rata_reputasi_p'], 2) : null) ?>,
                                                <?= json_encode(isset($pembanding_ket6['rata_stratejik_p']) ? round((float)$pembanding_ket6['rata_stratejik_p'], 2) : null) ?>
                                        ],
                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'A',
                                        backgroundColor: 'rgba(25, 100, 132, 0.6)',
                                        borderWidth: 2
                                        
                                        

                                },
                                {
                                        label: 'Profil Risiko Saat Ini (yang dipilih)',
                                        data: [
                                                <?= json_encode(isset($ket1['rata_kredit']) ? round((float)$ket1['rata_kredit'], 2) : null) ?>,
                                                <?= json_encode(isset($ket2['rata_operasional']) ? round((float)$ket2['rata_operasional'], 2) : null) ?>,
                                                <?= json_encode(isset($ket3['rata_kepatuhan']) ? round((float)$ket3['rata_kepatuhan'], 2) : null) ?>,
                                                <?= json_encode(isset($ket4['rata_likuiditas']) ? round((float)$ket4['rata_likuiditas'], 2) : null) ?>,
                                                <?= json_encode(isset($ket5['rata_reputasi']) ? round((float)$ket5['rata_reputasi'], 2) : null) ?>,
                                                <?= json_encode(isset($ket6['rata_stratejik']) ? round((float)$ket6['rata_stratejik'], 2) : null) ?>
                                        ],
                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'A',
                                        backgroundColor: 'rgba(100, 200, 132, 0.6)',
                                        borderWidth: 2
                                        
                                        

                                }
                        ], //end data sets 
                        labels: ['Kredit', 'Operasional', 'Kepatuhan', 'Likuiditas', 'Reputasi', 'Stratejik']
                },
                options: {
                        scales: {
                                yAxes: [ {
                                        id: 'A',
                                        type: 'linear',
                                        position: 'left',
                                        ticks: {
                                            beginAtZero: true,
                                            min: 0,
                                            max: 5
                                                
                                        }
                                }]
                        }
                }
        });
</script>