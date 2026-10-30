<?php
require dirname(__DIR__, 2).'/conn/conn.php';

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>'Januari',
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
$get_data_user = mysqli_fetch_array(simpro_db_query($conn, "SELECT nama FROM user

WHERE user_id = ?", [$id]));

?>


<!--jamu-->
<?php
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);

$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT id_profil_risiko,data_pembanding FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =?", [$tahun, $periode]));


$id_pro = $frame['id_profil_risiko'] ?? 0;
$dp = $frame['data_pembanding'] ?? 0;

//kredit
$kredit1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$kredit2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$kredit3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$kredit4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$kredit5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$kredit6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$kredit7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$kredit8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$kredit9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$kredit10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$kredit11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$kredit12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$kredit13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$kredit14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$kredit15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$kredit16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$kredit17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$kredit18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$kredit19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$kredit20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$kredit21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$kredit22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$kredit23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$kredit24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$kredit25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$kredit26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$kredit27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$kredit28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kredit ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kredit.id_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));

//operasional

$operasional1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$operasional2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$operasional3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$operasional4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$operasional5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$operasional6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$operasional7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$operasional8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$operasional9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$operasional10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$operasional11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$operasional12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$operasional13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$operasional14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$operasional15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$operasional16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$operasional17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$operasional18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$operasional19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$operasional20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$operasional21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$operasional22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$operasional23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$operasional24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$operasional25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$operasional26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$operasional27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$operasional28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_operasional ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_operasional.id_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));

//kepatuhan

$kepatuhan1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$kepatuhan2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$kepatuhan3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$kepatuhan4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$kepatuhan5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$kepatuhan6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$kepatuhan7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$kepatuhan8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$kepatuhan9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$kepatuhan10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$kepatuhan11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$kepatuhan12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$kepatuhan13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$kepatuhan14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$kepatuhan15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$kepatuhan16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$kepatuhan17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$kepatuhan18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$kepatuhan19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$kepatuhan20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$kepatuhan21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$kepatuhan22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$kepatuhan23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$kepatuhan24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$kepatuhan25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$kepatuhan26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$kepatuhan27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$kepatuhan28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_kepatuhan.id_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));

//likuiditas

$likuiditas1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$likuiditas2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$likuiditas3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$likuiditas4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$likuiditas5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$likuiditas6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$likuiditas7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$likuiditas8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$likuiditas9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$likuiditas10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$likuiditas11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$likuiditas12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$likuiditas13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$likuiditas14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$likuiditas15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$likuiditas16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$likuiditas17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$likuiditas18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$likuiditas19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$likuiditas20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$likuiditas21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$likuiditas22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$likuiditas23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$likuiditas24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$likuiditas25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$likuiditas26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$likuiditas27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$likuiditas28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_likuiditas.id_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));

//reputasi

$reputasi1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$reputasi2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$reputasi3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$reputasi4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$reputasi5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$reputasi6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$reputasi7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$reputasi8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$reputasi9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$reputasi10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$reputasi11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$reputasi12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$reputasi13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$reputasi14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$reputasi15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$reputasi16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$reputasi17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$reputasi18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$reputasi19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$reputasi20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$reputasi21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$reputasi22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$reputasi23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$reputasi24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$reputasi25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$reputasi26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$reputasi27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$reputasi28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_reputasi.id_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));

//stratejik

$stratejik1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$stratejik2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$stratejik3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$stratejik4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$stratejik5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$stratejik6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$stratejik7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$stratejik8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$stratejik9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$stratejik10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$stratejik11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$stratejik12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$stratejik13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$stratejik14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$stratejik15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$stratejik16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$stratejik17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$stratejik18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$stratejik19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$stratejik20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$stratejik21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$stratejik22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$stratejik23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$stratejik24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$stratejik25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$stratejik26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$stratejik27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$stratejik28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN hasil_inheren_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = hasil_inheren_stratejik.id_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));



//tingkat_ris

$tingkat_ris1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 1", [$tahun, $periode]));
$tingkat_ris2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 2", [$tahun, $periode]));
$tingkat_ris3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 3", [$tahun, $periode]));
$tingkat_ris4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 4", [$tahun, $periode]));
$tingkat_ris5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 5", [$tahun, $periode]));
$tingkat_ris6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 6", [$tahun, $periode]));
$tingkat_ris7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 7", [$tahun, $periode]));
$tingkat_ris8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 8", [$tahun, $periode]));
$tingkat_ris9 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 9", [$tahun, $periode]));
$tingkat_ris10 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 10", [$tahun, $periode]));
$tingkat_ris11 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 11", [$tahun, $periode]));
$tingkat_ris12 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 12", [$tahun, $periode]));
$tingkat_ris13 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 13", [$tahun, $periode]));
$tingkat_ris14 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 14", [$tahun, $periode]));
$tingkat_ris15 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 15", [$tahun, $periode]));
$tingkat_ris16 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 16", [$tahun, $periode]));
$tingkat_ris17 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 17", [$tahun, $periode]));
$tingkat_ris18 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 18", [$tahun, $periode]));
$tingkat_ris19 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 19", [$tahun, $periode]));
$tingkat_ris20 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 20", [$tahun, $periode]));
$tingkat_ris21 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 21", [$tahun, $periode]));
$tingkat_ris22 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 22", [$tahun, $periode]));
$tingkat_ris23 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 23", [$tahun, $periode]));
$tingkat_ris24 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 24", [$tahun, $periode]));
$tingkat_ris25 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 25", [$tahun, $periode]));
$tingkat_ris26 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 26", [$tahun, $periode]));
$tingkat_ris27 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 27", [$tahun, $periode]));
$tingkat_ris28 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang = 28", [$tahun, $periode]));



$semarang_cnt = mysqli_fetch_array(simpro_db_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(1,2,3,4,5,6,7)", [$tahun, $periode]));
$solo_cnt = mysqli_fetch_array(simpro_db_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(8,9,10,11,12,13,14)", [$tahun, $periode]));
$banyumas_cnt = mysqli_fetch_array(simpro_db_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(15,16,17,18,19,20,21)", [$tahun, $periode]));
$pekalongan_cnt = mysqli_fetch_array(simpro_db_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =? AND user =3 AND status_korwil =1 AND status_skmr =1 AND kantor_cabang IN(22,23,24,25,26,27,28)", [$tahun, $periode]));

if (isset($_POST['submit'])) {
    $kode_kantor = (int)($_POST['kode_kantor'] ?? 0);
    $tahun = (int)($_POST['tahun'] ?? 0);
    $periode = (int)($_POST['periode'] ?? 0);
        header("Location: index.php?page=hasil_lapkc&tahun=$tahun&periode=$periode");
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
                                            <li class="breadcrumb-item active">Hasil laporan KC</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Hasil Laporan Profil Risiko Kantor Cabang</h4>
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
                                                                    require dirname(__DIR__, 2).'/conn/conn.php';
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
                                    <h4 class="header-title mb-4">Laporan Diterima</h4>
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

                        <script>
        $(document).ready(function() {
            var tableOptions = {
                dom: 'Bfrtip',
                buttons: [
                    'copy',
                    'csv',
                    'excel',
                    'pdf',
                    'print'
                ],
                scrollX: true,
                scrollY: '58vh',
                scrollCollapse: true,
                paging: true,
                pageLength: 10,
                autoWidth: false,
                responsive: false,
                columnDefs: [
                    { targets: 0, width: '58px', className: 'kc-col-no text-center' },
                    { targets: 1, width: '80px', className: 'kc-col-kode' },
                    { targets: 2, width: '190px', className: 'kc-col-cabang' },
                    { targets: '_all', className: 'kc-table-cell' }
                ]
            };

            if ($.fn.dataTable && ($.fn.dataTable.FixedColumns || $.fn.DataTable.FixedColumns)) {
                tableOptions.fixedColumns = {
                    leftColumns: 3,
                    left: 3
                };
            }

            var table = $('#datatable-buttons1').DataTable(tableOptions);

            function setStickyOffsets() {
                var firstWidth = $('#datatable-buttons1 thead th').eq(0).outerWidth() || 58;
                var secondWidth = $('#datatable-buttons1 thead th').eq(1).outerWidth() || 80;
                $('.hasil-lapkc-table').css({
                    '--kc-left-2': firstWidth + 'px',
                    '--kc-left-3': (firstWidth + secondWidth) + 'px'
                });
            }

            setStickyOffsets();
            table.on('draw.dt column-sizing.dt responsive-resize.dt', setStickyOffsets);
            $(window).on('resize', setStickyOffsets);
        });
    </script>
    <style>
        .hasil-lapkc-table {
            --kc-left-2: 58px;
            --kc-left-3: 138px;
            width: 100%;
        }

        .hasil-lapkc-table .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 14px;
        }

        .hasil-lapkc-table .dt-buttons .btn,
        .hasil-lapkc-table .dt-buttons button {
            border: 0;
            border-radius: 6px;
            background: #5f6b75;
            color: #fff;
            box-shadow: 0 4px 12px rgba(39, 49, 58, .18);
            font-weight: 600;
            padding: 9px 16px;
        }

        .hasil-lapkc-table .dataTables_filter {
            margin-bottom: 14px;
        }

        .hasil-lapkc-table .dataTables_filter input {
            border: 1px solid #d7dde5;
            border-radius: 6px;
            padding: 8px 12px;
            min-width: 220px;
        }

        .hasil-lapkc-table .dataTables_scroll {
            border: 1px solid #e4e9f0;
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
        }

        .hasil-lapkc-table .dataTables_scrollBody {
            border-bottom: 1px solid #e4e9f0 !important;
            scrollbar-gutter: stable;
        }

        .hasil-lapkc-table table.dataTable {
            width: 100% !important;
            min-width: 3600px;
            border-collapse: separate !important;
            border-spacing: 0;
            margin: 0 !important;
        }

        .hasil-lapkc-table table.dataTable thead th {
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

        .hasil-lapkc-table table.dataTable tbody td {
            border-bottom: 1px solid #edf1f5;
            color: #27313a;
            font-size: 13px;
            padding: 12px 14px;
            white-space: nowrap;
            vertical-align: middle;
            background: #fff;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(odd) td {
            background: #f5f7fb;
        }

        .hasil-lapkc-table table.dataTable tbody tr:hover td {
            background: #eaf2ff;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(1),
        .hasil-lapkc-table table.dataTable td:nth-child(1),
        .hasil-lapkc-table table.dataTable th:nth-child(2),
        .hasil-lapkc-table table.dataTable td:nth-child(2),
        .hasil-lapkc-table table.dataTable th:nth-child(3),
        .hasil-lapkc-table table.dataTable td:nth-child(3) {
            position: sticky;
            z-index: 6;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(1),
        .hasil-lapkc-table table.dataTable td:nth-child(1) {
            left: 0;
            min-width: 58px;
            text-align: center;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(2),
        .hasil-lapkc-table table.dataTable td:nth-child(2) {
            left: var(--kc-left-2);
            min-width: 80px;
        }

        .hasil-lapkc-table table.dataTable th:nth-child(3),
        .hasil-lapkc-table table.dataTable td:nth-child(3) {
            left: var(--kc-left-3);
            min-width: 190px;
            box-shadow: 8px 0 12px -12px rgba(15, 23, 42, .75);
        }

        .hasil-lapkc-table table.dataTable thead th:nth-child(-n+3) {
            z-index: 8;
            background: #e9f0f8;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(odd) td:nth-child(-n+3) {
            background: #eef2f8;
        }

        .hasil-lapkc-table table.dataTable tbody tr:nth-child(even) td:nth-child(-n+3) {
            background: #fff;
        }

        .hasil-lapkc-table table.dataTable tbody tr:hover td:nth-child(-n+3) {
            background: #e2edff;
        }

        .hasil-lapkc-table .dataTables_info,
        .hasil-lapkc-table .dataTables_paginate {
            padding-top: 14px;
        }
    </style>
                        <!-- end row-->

                        <div class="row">
                                                    <div class="card">
                                                        <div class="card-body">
                                                        
                                                            <h4 class="header-title mb-3">Profil Risiko Kantor Cabang</h4>

                                                            <div class="tab-pane show active hasil-lapkc-table" id="buttons-table-preview">
                                                                <table id="datatable-buttons1" class="table table-striped nowrap w-100">
                                                                <thead>
                                                                        <tr>
                                                                            <th><center>No.</center></th>
                                                                            <th>Kode</th>
                                                                            <th>Kantor Cabang</th>
                                                                            <th>Pilar 1 Kredit</th>
                                                                            <th>Pilar 2 Kredit</th>
                                                                            <th>Pilar 3 Kredit</th>
                                                                            <th>Pilar 4 Kredit</th>
                                                                            <th>Lainnya Kredit</th>
                                                                            <th>Risiko Kredit</th>
                                                                            <th>Peringkat Kredit</th>

                                                                            <th>Pilar 1 Ops</th>
                                                                            <th>Pilar 2 Ops</th>
                                                                            <th>Pilar 3 Ops</th>
                                                                            <th>Pilar 4 Ops</th>
                                                                            <th>Lainnya Ops</th>
                                                                            <th>Risiko Operasional</th>
                                                                            <th>Peringkat Operasional</th>

                                                                            <th>Pilar 1 Kep</th>
                                                                            <th>Pilar 2 Kep</th>
                                                                            <th>Lainnya Kep</th>
                                                                            <th>Risiko Kepatuhan</th>
                                                                            <th>Peringkat Kepatuhan</th>

                                                                            <th>Pilar 1 Lik</th>
                                                                            <th>Pilar 2 Lik</th>
                                                                            <th>Lainnya Lik</th>
                                                                            <th>Risiko Likuiditas</th>
                                                                            <th>Peringkat Likuiditas</th>

                                                                            <th>Pilar 1 Rep</th>
                                                                            <th>Pilar 2 Rep</th>
                                                                            <th>Pilar 3 Rep</th>
                                                                            <th>Lainnya Rep</th>
                                                                            <th>Risiko Reputasi</th>
                                                                            <th>Peringkat Reputasi</th>

                                                                            <th>Pilar 1 Stra</th>
                                                                            <th>Pilar 2 Stra</th>
                                                                            <th>Pilar 3 Stra</th>
                                                                            <th>Lainnya Stra</th>
                                                                            <th>Risiko Stratejik</th>
                                                                            <th>Peringkat Stratejik</th>

                                                                            <th>Nilai Risiko</th>
                                                                            <th>Peringkat Komposit</th>
                                                                           
                                                                        </tr>
                                                                    </thead>


                                                                    <tbody>
                                                                        <tr>
                                                                            <td><center>1</center></td>
                                                                            <td>001</td>
                                                                            <td>KC. Utama</td>
                                                                            <td><?= $kredit1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik1['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris1['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris1['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                        <td><center>2</center></td>
                                                                            <td>002</td>
                                                                            <td>KC. Rembang</td>
                                                                            <td><?= $kredit2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik2['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris2['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris2['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>3</center></td>
                                                                            <td>003</td>
                                                                            <td>KC. Pati</td>
                                                                            <td><?= $kredit3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik3['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris3['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris3['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>4</center></td>
                                                                            <td>004</td>
                                                                            <td>KC. Demak</td>
                                                                            <td><?= $kredit4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik4['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris4['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris4['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>5</center></td>
                                                                            <td>005</td>
                                                                            <td>KC. Kendal</td>
                                                                            <td><?= $kredit5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik5['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris5['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris5['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>6</center></td>
                                                                            <td>006</td>
                                                                            <td>KC. Salatiga</td>
                                                                            <td><?= $kredit6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik6['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris6['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris6['ket_total_nilai'] ?? '-' ?></td>

                                                                        </tr>
                                                                        <tr><td><center>7</center></td>
                                                                            <td>007</td>
                                                                            <td>KC.Kab. Semarang</td>
                                                                            <td><?= $kredit7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik7['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris7['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris7['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                          
                                                                        </tr>
                                                                    
                                                                        <tr><td><center>8</center></td>
                                                                            <td>008</td>
                                                                            <td>KC. Wonogiri</td>
                                                                            <td><?= $kredit8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik8['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris8['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris8['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>9</center></td>
                                                                            <td>009</td>
                                                                            <td>KC. Kota Surakarta</td>
                                                                            <td><?= $kredit9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik9['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris9['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris9['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                          
                                                                        </tr>
                                                                        <tr><td><center>10</center></td>
                                                                            <td>010</td>
                                                                            <td>KC. Karanganyar</td>
                                                                            <td><?= $kredit10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik10['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris10['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris10['ket_total_nilai'] ?? '-' ?></td>
                                                                          
                                                                        </tr>
                                                                        <tr><td><center>11</center></td>
                                                                            <td>011</td>
                                                                            <td>KC. Sukoharjo</td>
                                                                            <td><?= $kredit11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik11['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris11['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris11['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>12</center></td>
                                                                            <td>012</td>
                                                                            <td>KC. Sragen</td>
                                                                            <td><?= $kredit12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik12['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris12['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris12['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>13</center></td>
                                                                            <td>013</td>
                                                                            <td>KC. Boyolali</td>
                                                                            <td><?= $kredit13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik13['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris13['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris13['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                          
                                                                        </tr>
                                                                        <tr><td><center>14</center></td>
                                                                            <td>014</td>
                                                                            <td>KC. Magelang</td>
                                                                            <td><?= $kredit14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik14['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris14['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris14['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                    
                                                                        <tr><td><center>15</center></td>
                                                                            <td>015</td>
                                                                            <td>KC. Wonosobo</td>
                                                                            <td><?= $kredit15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik15['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris15['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris15['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>16</center></td>
                                                                            <td>016</td>
                                                                            <td>KC. Purworejo</td>
                                                                            <td><?= $kredit16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik16['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris16['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris16['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>17</center></td>
                                                                            <td>017</td>
                                                                            <td>KC. Kebumen</td>
                                                                            <td><?= $kredit17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik17['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris17['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris17['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>18</center></td>
                                                                            <td>018</td>
                                                                            <td>KC. Banjarnegara</td>
                                                                            <td><?= $kredit18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik18['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris18['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris18['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>19</center></td>
                                                                            <td>019</td>
                                                                            <td>KC. Purbalingga</td>
                                                                            <td><?= $kredit19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik19['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris19['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris19['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>20</center></td>
                                                                            <td>020</td>
                                                                            <td>KC. Banyumas</td>
                                                                            <td><?= $kredit20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik20['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris20['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris20['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>21</center></td>
                                                                            <td>021</td>
                                                                            <td>KC. Cilacap</td>
                                                                            <td><?= $kredit21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik21['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris21['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris21['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                            
                                                                        </tr>
                                                                   
                                                                        <tr><td><center>22</center></td>
                                                                            <td>022</td>
                                                                            <td>KC. Kab. Tegal</td>
                                                                            <td><?= $kredit22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik22['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris22['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris22['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>23</center></td>
                                                                            <td>023</td>
                                                                            <td>KC. Brebes</td>
                                                                            <td><?= $kredit23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik23['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris23['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris23['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>24</center></td>
                                                                            <td>024</td>
                                                                            <td>KC. Kota Tegal</td>
                                                                            <td><?= $kredit24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik24['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris24['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris24['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>25</center></td>
                                                                            <td>025</td>
                                                                            <td>KC. Pemalang</td>
                                                                            <td><?= $kredit25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik25['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris25['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris25['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>26</center></td>
                                                                            <td>026</td>
                                                                            <td>KC. Kota Pekalongan</td>
                                                                            <td><?= $kredit26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik26['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris26['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris26['ket_total_nilai'] ?? '-' ?></td>
                                                                            
                                                                        </tr>
                                                                        <tr><td><center>27</center></td>
                                                                            <td>027</td>
                                                                            <td>KC. Kab. Pekalongan</td>
                                                                            <td><?= $kredit27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik27['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris27['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris27['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                        <tr><td><center>28</center></td>
                                                                            <td>028</td>
                                                                            <td>KC. Batang</td>
                                                                            <td><?= $kredit28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kredit28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['pil5_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['pil6_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $operasional28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $kepatuhan28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $likuiditas28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $reputasi28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['pil1_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['pil2_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['pil3_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['pil4_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['hasil_tingkat_risiko'] ?? '-' ?></td>
                                                                            <td><?= $stratejik28['hasil_peringkat'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris28['total_nilai'] ?? '-' ?></td>
                                                                            <td><?= $tingkat_ris28['ket_total_nilai'] ?? '-' ?></td>
                                                                           
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->

                                                        </div> <!-- end card body-->
                                                    </div> <!-- end card -->
                        </div>
                        <!-- end row-->

                        
                    </div> <!-- container -->



    </div>
    <!-- content -->



</div>










