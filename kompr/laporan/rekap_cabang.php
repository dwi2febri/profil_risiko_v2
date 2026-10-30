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
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);

$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT id_profil_risiko,data_pembanding FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode'"));


$id_pro = $frame['id_profil_risiko'] ?? 0;
$dp = $frame['data_pembanding'] ?? 0;

//kredit
$kredit1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$kredit2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$kredit3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$kredit4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$kredit5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$kredit6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$kredit7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$kredit8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$kredit9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$kredit10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$kredit11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$kredit12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$kredit13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$kredit14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$kredit15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$kredit16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$kredit17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$kredit18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$kredit19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$kredit20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$kredit21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$kredit22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$kredit23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$kredit24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$kredit25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$kredit26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$kredit27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$kredit28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));

//operasional

$operasional1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$operasional2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$operasional3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$operasional4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$operasional5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$operasional6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$operasional7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$operasional8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$operasional9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$operasional10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$operasional11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$operasional12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$operasional13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$operasional14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$operasional15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$operasional16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$operasional17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$operasional18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$operasional19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$operasional20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$operasional21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$operasional22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$operasional23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$operasional24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$operasional25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$operasional26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$operasional27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$operasional28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));

//kepatuhan

$kepatuhan1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$kepatuhan2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$kepatuhan3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$kepatuhan4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$kepatuhan5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$kepatuhan6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$kepatuhan7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$kepatuhan8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$kepatuhan9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$kepatuhan10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$kepatuhan11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$kepatuhan12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$kepatuhan13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$kepatuhan14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$kepatuhan15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$kepatuhan16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$kepatuhan17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$kepatuhan18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$kepatuhan19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$kepatuhan20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$kepatuhan21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$kepatuhan22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$kepatuhan23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$kepatuhan24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$kepatuhan25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$kepatuhan26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$kepatuhan27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$kepatuhan28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));

//likuiditas

$likuiditas1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$likuiditas2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$likuiditas3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$likuiditas4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$likuiditas5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$likuiditas6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$likuiditas7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$likuiditas8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$likuiditas9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$likuiditas10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$likuiditas11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$likuiditas12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$likuiditas13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$likuiditas14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$likuiditas15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$likuiditas16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$likuiditas17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$likuiditas18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$likuiditas19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$likuiditas20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$likuiditas21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$likuiditas22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$likuiditas23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$likuiditas24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$likuiditas25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$likuiditas26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$likuiditas27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$likuiditas28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));

//reputasi

$reputasi1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$reputasi2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$reputasi3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$reputasi4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$reputasi5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$reputasi6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$reputasi7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$reputasi8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$reputasi9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$reputasi10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$reputasi11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$reputasi12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$reputasi13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$reputasi14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$reputasi15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$reputasi16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$reputasi17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$reputasi18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$reputasi19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$reputasi20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$reputasi21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$reputasi22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$reputasi23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$reputasi24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$reputasi25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$reputasi26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$reputasi27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$reputasi28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));


//stratejik

$stratejik1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$stratejik2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$stratejik3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$stratejik4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$stratejik5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$stratejik6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$stratejik7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$stratejik8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$stratejik9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$stratejik10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$stratejik11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$stratejik12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$stratejik13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$stratejik14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$stratejik15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$stratejik16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$stratejik17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$stratejik18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$stratejik19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$stratejik20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$stratejik21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$stratejik22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$stratejik23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$stratejik24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$stratejik25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$stratejik26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$stratejik27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$stratejik28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));




//tingkat_ris

$tingkat_ris1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1"));
$tingkat_ris2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2"));
$tingkat_ris3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3"));
$tingkat_ris4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4"));
$tingkat_ris5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5"));
$tingkat_ris6 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6"));
$tingkat_ris7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7"));
$tingkat_ris8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8"));
$tingkat_ris9 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9"));
$tingkat_ris10 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10"));
$tingkat_ris11 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11"));
$tingkat_ris12 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12"));
$tingkat_ris13 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13"));
$tingkat_ris14 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14"));
$tingkat_ris15 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15"));
$tingkat_ris16 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16"));
$tingkat_ris17 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17"));
$tingkat_ris18 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18"));
$tingkat_ris19 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19"));
$tingkat_ris20 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20"));
$tingkat_ris21 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21"));
$tingkat_ris22 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22"));
$tingkat_ris23 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23"));
$tingkat_ris24 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24"));
$tingkat_ris25 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25"));
$tingkat_ris26 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26"));
$tingkat_ris27 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27"));
$tingkat_ris28 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = '$tahun' AND periode = '$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28"));





$semarang_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(1,2,3,4,5,6,7)"));
$solo_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(8,9,10,11,12,13,14)"));
$banyumas_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(15,16,17,18,19,20,21)"));
$pekalongan_cnt = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun ='$tahun' AND periode ='$periode' AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(22,23,24,25,26,27,28)"));

if (isset($_POST['submit'])) {
    $kode_kantor = (int)($_POST['kode_kantor'] ?? 0);
    $tahun = (int)($_POST['tahun'] ?? 0);
    $periode = (int)($_POST['periode'] ?? 0);
        header("Location: index.php?page=rekap_cbg&tahun=$tahun&periode=$periode");
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
                                    <h4 class="page-title">Rekap Perbandingan Per Korwil</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <!-- end row-->


                        <div class="row">
                            <div class="col-lg-4">
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

                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                    <h4 class="header-title mb-4">Laporan Diterima (pastikan untuk laporan diterima masing-masing 7)</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $semarang_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan area semarang</p>
                                                    </div>
                                            </div>
                
                                            <div class="col-lg-4">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $solo_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan area solo</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $banyumas_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">laporan area banyumas</p>
                                                    </div>
                                            </div>
                
                                            <div class="col-lg-4">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $pekalongan_cnt['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">laporan area pekalongan</p>
                                                    </div>
                                                </div>
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
                                        
                                        <h4 class="header-title mb-4">Grafik Perbandingan Nilai Profil Risiko Per Area</h4>

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
                                                <span class="d-none d-md-block">Area Semarang</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#solo" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Area Solo</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#banyumas" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Area Banyumas</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#pekalongan" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">
                                                <i class="mdi mdi-account-circle d-md-none d-block"></i>
                                                <span class="d-none d-md-block">Area Pekalongan</span>
                                            </a>
                                        </li>
                                    
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="semarang">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Area Semarang</h4>

                                                            <div class="tab-pane show active" id="scroll-horizontal-preview">
                                                                <table id="scroll-horizontal-datatable" class="table w-100 nowrap">
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
                                                                        <tr>
                                                                            <td>001</td>
                                                                            <td>KC. Utama</td>
                                                                            <td><?= $kredit1['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>002</td>
                                                                            <td>KC. Rembang</td>
                                                                            <td><?= $kredit2['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>003</td>
                                                                            <td>KC. Pati</td>
                                                                            <td><?= $kredit3['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>004</td>
                                                                            <td>KC. Demak</td>
                                                                            <td><?= $kredit4['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>005</td>
                                                                            <td>KC. Kendal</td>
                                                                            <td><?= $kredit5['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['inheren_stratejik'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td>006</td>
                                                                            <td>KC. Salatiga</td>
                                                                            <td><?= $kredit6['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['inheren_stratejik'] ?? '-' ?></td>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                            <td>007</td>
                                                                            <td>KC.Kab. Semarang</td>
                                                                            <td><?= $kredit7['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['inheren_stratejik'] ?? '-' ?></td>
                                                                          
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
                                                                        <tr>
                                                                            <td>008</td>
                                                                            <td>KC. Wonogiri</td>
                                                                            <td><?= $kredit8['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>009</td>
                                                                            <td>KC. Kota Surakarta</td>
                                                                            <td><?= $kredit9['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['inheren_stratejik'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td>010</td>
                                                                            <td>KC. Karanganyar</td>
                                                                            <td><?= $kredit10['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['inheren_stratejik'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td>011</td>
                                                                            <td>KC. Sukoharjo</td>
                                                                            <td><?= $kredit11['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>012</td>
                                                                            <td>KC. Sragen</td>
                                                                            <td><?= $kredit12['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>013</td>
                                                                            <td>KC. Boyolali</td>
                                                                            <td><?= $kredit13['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['inheren_stratejik'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td>014</td>
                                                                            <td>KC. Magelang</td>
                                                                            <td><?= $kredit14['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['inheren_stratejik'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="banyumas">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Area Banyumas</h4>

                                                            <div class="tab-pane show active" id="row-callback-preview">
                                                                <table id="row-callback-datatable" class="table dt-responsive nowrap w-100">
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
                                                                        <tr>
                                                                            <td>015</td>
                                                                            <td>KC. Wonosobo</td>
                                                                            <td><?= $kredit15['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>016</td>
                                                                            <td>KC. Purworejo</td>
                                                                            <td><?= $kredit16['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>017</td>
                                                                            <td>KC. Kebumen</td>
                                                                            <td><?= $kredit17['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>018</td>
                                                                            <td>KC. Banjarnegara</td>
                                                                            <td><?= $kredit18['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>019</td>
                                                                            <td>KC. Purbalingga</td>
                                                                            <td><?= $kredit19['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>020</td>
                                                                            <td>KC. Banyumas</td>
                                                                            <td><?= $kredit20['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>021</td>
                                                                            <td>KC. Cilacap</td>
                                                                            <td><?= $kredit21['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                                                </div><!-- end col-->
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="pekalongan">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Area pekalongan</h4>

                                                            <div class="tab-pane show active" id="multi-item-preview">
                                                                <table id="selection-datatable" class="table dt-responsive nowrap w-100">
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
                                                                        <tr>
                                                                            <td>022</td>
                                                                            <td>KC. Kab. Tegal</td>
                                                                            <td><?= $kredit22['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>023</td>
                                                                            <td>KC. Brebes</td>
                                                                            <td><?= $kredit23['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>024</td>
                                                                            <td>KC. Kota Tegal</td>
                                                                            <td><?= $kredit24['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>025</td>
                                                                            <td>KC. Pemalang</td>
                                                                            <td><?= $kredit25['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>026</td>
                                                                            <td>KC. Kota Pekalongan</td>
                                                                            <td><?= $kredit26['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['inheren_stratejik'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr>
                                                                            <td>027</td>
                                                                            <td>KC. Kab. Pekalongan</td>
                                                                            <td><?= $kredit27['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['inheren_stratejik'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td>028</td>
                                                                            <td>KC. Batang</td>
                                                                            <td><?= $kredit28['inheren_kredit'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['inheren_operasional'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['inheren_kepatuhan'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['inheren_likuiditas'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['inheren_reputasi'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['inheren_stratejik'] ?? '-' ?></td>
                                                                          
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
                                                <?php
                                                
                                                $area1_kredit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(keterangan_profil_kredit.inheren_kredit) AS inheren_kredit from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1kre = $area1_kredit['inheren_kredit'] ?? null;
                                                $hasil_area1kre = $area1kre /7;
                                                echo $hasil_area1kre ;
                                                ?>,
                                                 <?php
                                                $area2_kredit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(keterangan_profil_kredit.inheren_kredit) AS inheren_kredit from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2kre = $area2_kredit['inheren_kredit'] ?? null;
                                                $hasil_area2kre = $area2kre /7;
                                                echo $hasil_area2kre ;
                                                ?>,
                                                 <?php
                                                $area3_kredit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(keterangan_profil_kredit.inheren_kredit) AS inheren_kredit from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3kre = $area3_kredit['inheren_kredit'] ?? null;
                                                $hasil_area3kre = $area3kre /7;
                                                echo $hasil_area3kre ;
                                                ?>,
                                                 <?php
                                                $area4_kredit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(keterangan_profil_kredit.inheren_kredit) AS inheren_kredit from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4kre = $area4_kredit['inheren_kredit'] ?? null;
                                                $hasil_area4kre = $area4kre /7;
                                                echo $hasil_area4kre ;
                                                ?>
                                        ],
                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(100, 200, 132, 1)',
                                        lineTension: 0.1,
                                        
                                        

                                },
                                {
                                        label: 'Operasional',
                                        data: [
                                                <?php
                                                $area1_operasional = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS inheren_operasional from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1op = $area1_operasional['inheren_operasional'] ?? null;
                                                $hasil_area1op = $area1op /7;
                                                echo $hasil_area1op ;
                                                ?>,
                                                <?php
                                                $area2_operasional = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS inheren_operasional from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2op = $area2_operasional['inheren_operasional'] ?? null;
                                                $hasil_area2op = $area2op /7;
                                                echo $hasil_area2op ;
                                                ?>,
                                               <?php
                                                $area3_operasional = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS inheren_operasional from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3op = $area3_operasional['inheren_operasional'] ?? null;
                                                $hasil_area3op = $area3op /7;
                                                echo $hasil_area3op ;
                                                ?>,
                                                <?php
                                                $area4_operasional = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS inheren_operasional from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4op = $area4_operasional['inheren_operasional'] ?? null;
                                                $hasil_area4op = $area4op /7;
                                                echo $hasil_area4op ;
                                                ?>
                                                ],

                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(102, 204, 255, 1)',
                                        lineTension: 0.1,
                                },
                                {
                                        label: 'Kepatuhan',
                                        data: [
                                            <?php
                                                $area1_kepatuhan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS inheren_kepatuhan from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1kep = $area1_kepatuhan['inheren_kepatuhan'] ?? null;
                                                $hasil_area1kep = $area1kep /7;
                                                echo $hasil_area1kep ;
                                                ?>,
                                                <?php
                                                $area2_kepatuhan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS inheren_kepatuhan from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2kep = $area2_kepatuhan['inheren_kepatuhan'] ?? null;
                                                $hasil_area2kep = $area2kep /7;
                                                echo $hasil_area2kep ;
                                                ?>,
                                                <?php
                                                $area3_kepatuhan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS inheren_kepatuhan from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3kep = $area3_kepatuhan['inheren_kepatuhan'] ?? null;
                                                $hasil_area3kep = $area3kep /7;
                                                echo $hasil_area3kep ;
                                                ?>,
                                                <?php
                                                $area4_kepatuhan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS inheren_kepatuhan from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4kep = $area4_kepatuhan['inheren_kepatuhan'] ?? null;
                                                $hasil_area4kep = $area4kep /7;
                                                echo $hasil_area4kep ;
                                                ?>
                                        ],

                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(255, 217, 102, 1)',
                                        lineTension: 0.1,
                                },
                                {
                                        label: 'Likuiditas',
                                        data: [
                                            <?php
                                                $area1_likuiditas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS inheren_likuiditas from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1lik = $area1_likuiditas['inheren_likuiditas'] ?? null;
                                                $hasil_area1lik = $area1lik /7;
                                                echo $hasil_area1lik ;
                                                ?>,
                                                <?php
                                                $area2_likuiditas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS inheren_likuiditas from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2lik = $area2_likuiditas['inheren_likuiditas'] ?? null;
                                                $hasil_area2lik = $area2lik /7;
                                                echo $hasil_area2lik ;
                                                ?>,
                                                <?php
                                                $area3_kepatuhan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS inheren_likuiditas from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3lik = $area3_likuiditas['inheren_likuiditas'] ?? null;
                                                $hasil_area3lik = $area3lik /7;
                                                echo $hasil_area3lik ;
                                                ?>,
                                                <?php
                                                $area4_likuiditas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS inheren_likuiditas from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4lik = $area4_likuiditas['inheren_likuiditas'] ?? null;
                                                $hasil_area4lik = $area4lik /7;
                                                echo $hasil_area4lik ;
                                                ?>
                                        ],

                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(255, 51, 0, 1)',
                                        lineTension: 0.1
                                },
                                {
                                        label: 'Reputasi',
                                        data: [
                                            <?php
                                                $area1_reputasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS inheren_reputasi from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1rep = $area1_reputasi['inheren_reputasi'] ?? null;
                                                $hasil_area1rep = $area1rep /7;
                                                echo $hasil_area1rep ;
                                                ?>,
                                                <?php
                                                $area2_reputasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS inheren_reputasi from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2rep = $area2_reputasi['inheren_reputasi'] ?? null;
                                                $hasil_area2rep = $area2rep /7;
                                                echo $hasil_area2rep ;
                                                ?>,
                                                <?php
                                                $area3_reputasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS inheren_reputasi from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3rep = $area3_reputasi['inheren_reputasi'] ?? null;
                                                $hasil_area3rep = $area3rep /7;
                                                echo $hasil_area3rep ;
                                                ?>,
                                                <?php
                                                $area4_reputasi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS inheren_reputasi from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4rep = $area4_reputasi['inheren_reputasi'] ?? null;
                                                $hasil_area4rep = $area4rep /7;
                                                echo $hasil_area4rep ;
                                                ?>
                                        ],

                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(153, 204, 255, 1)',
                                        lineTension: 0.1
                                },
                                {
                                        label: 'Stratejik',
                                        data: [
                                                <?php
                                                $area1_stratejik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS inheren_stratejik from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(1,2,3,4,5,6,7)"));
                                                $area1stra = $area1_stratejik['inheren_stratejik'] ?? null;
                                                $hasil_area1stra = $area1stra /7;
                                                echo $hasil_area1stra ;
                                                ?>,
                                                <?php
                                                $area2_stratejik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS inheren_stratejik from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(8,9,10,11,12,13,14)"));
                                                $area2stra = $area2_stratejik['inheren_stratejik'] ?? null;
                                                $hasil_area2stra = $area2stra /7;
                                                echo $hasil_area2stra ;
                                                ?>,
                                                <?php
                                                $area3_stratejik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS inheren_stratejik from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(15,16,17,18,19,20,21)"));
                                                $area3stra = $area3_stratejik['inheren_stratejik'] ?? null;
                                                $hasil_area3stra = $area3stra /7;
                                                echo $hasil_area3stra ;
                                                ?>,
                                                <?php
                                                $area4_stratejik = mysqli_fetch_assoc(mysqli_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS inheren_stratejik from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = '$tahun' AND periode = '$periode' AND kantor_cabang IN(22,23,24,25,26,27,28)"));
                                                $area4stra = $area4_stratejik['inheren_stratejik'] ?? null;
                                                $hasil_area4stra = $area4stra /7;
                                                echo $hasil_area4stra ;
                                                ?>
                                        ],

                                        type: 'bar',
                                        fill: true,
                                        yAxisID: 'B',
                                        backgroundColor: 'rgba(89, 89, 89, 1)',
                                        lineTension: 0.1
                                }
                        ], //end data sets 
                        labels: ['Area Semarang', 'Area Solo', 'Area Banyumas', 'Area Pekalongan']
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








