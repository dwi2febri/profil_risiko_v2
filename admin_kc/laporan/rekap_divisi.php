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
$kredit1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$kredit2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$kredit3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$kredit4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$kredit5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$kredit6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$kredit7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$kredit8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));

//operasional

$operasional1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$operasional2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$operasional3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$operasional4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$operasional5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$operasional6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$operasional7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$operasional8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));

//kepatuhan

$kepatuhan1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$kepatuhan2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$kepatuhan3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$kepatuhan4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$kepatuhan5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$kepatuhan6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$kepatuhan7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$kepatuhan8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));

//likuiditas

$likuiditas1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$likuiditas2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$likuiditas3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$likuiditas4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$likuiditas5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$likuiditas6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$likuiditas7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$likuiditas8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));

//reputasi

$reputasi1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$reputasi2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$reputasi3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$reputasi4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$reputasi5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$reputasi6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$reputasi7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$reputasi8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));


//stratejik

$stratejik1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$stratejik2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$stratejik3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$stratejik4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$stratejik5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$stratejik6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$stratejik7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$stratejik8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));



//tingkat_ris

$tingkat_ris1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));
$tingkat_ris2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 142", [$tahun, $periode]));
$tingkat_ris3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$tingkat_ris4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$tingkat_ris5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$tingkat_ris6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 137", [$tahun, $periode]));
$tingkat_ris7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$tingkat_ris8 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND periode = ? AND user =2 AND status_skmr =1 AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));





$semarang_cnt = mysqli_fetch_array(simpro_db_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE tahun =? AND periode =? AND user =2 AND status_skmr =1 AND dibuat_by IN(132,142,133,134,136,137,135,143)", [$tahun, $periode]));

if (isset($_POST['submit'])) {
    $kode_kantor = (int)($_POST['kode_kantor'] ?? 0);
    $tahun = (int)($_POST['tahun'] ?? 0);
    $periode = (int)($_POST['periode'] ?? 0);
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

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                    <h4 class="header-title mb-4">Laporan Diterima (pastikan untuk laporan diterima 8)</h4>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                    <div class="card-body text-center">
                                                        <i class="uil-envelope-open" style="font-size: 24px;"></i>
                                                        <h3><span><?= $semarang_cnt['total'] ?? '-' ?></span></h3>
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

                                                            <div class="tab-pane show active" id="buttons-table-preview">
                                                                <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
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
                                                                            <td><center><?= $kredit1['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $likuiditas1['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris1['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris1['ket_total_nilai'] ?? '-' ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>2</center></td>
                                                                            <td>Divisi Penyelesaian Kredit</td>
                                                                            <td><center><?= $kredit2['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris2['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris2['ket_total_nilai'] ?? '-' ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>3</center></td>
                                                                            <td>Divisi Operasional</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional3['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris3['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris3['ket_total_nilai'] ?? '-' ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>4</center></td>
                                                                            <td>Divisi SDM</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional4['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris4['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris4['ket_total_nilai'] ?? '-' ?></center></td>
                                                                           
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>5</center></td>
                                                                            <td>Divisi Sekper</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $kepatuhan5['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $reputasi5['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris5['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris5['ket_total_nilai'] ?? '-' ?></center></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>6</center></td>
                                                                            <td>Divisi Litbang</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $stratejik6['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris6['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris6['ket_total_nilai'] ?? '-' ?></center></td>
                                                                         
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>7</center></td>
                                                                            <td>Satuan Kerja Kepatuhan</td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $operasional7['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $kepatuhan7['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $reputasi7['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center>-</center></td>
                                                                            <td><center><?= $tingkat_ris7['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris7['ket_total_nilai'] ?? '-' ?></center></td>
                                                                          
                                                                        </tr>
                                                                        <tr>
                                                                            <td><center>8</center></td>
                                                                            <td>Satuan Kerja Audit Internal</td>
                                                                            <td><center><?= $kredit8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $operasional8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $kepatuhan8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $likuiditas8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $reputasi8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $stratejik8['tingkat_risiko'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris8['total_nilai'] ?? '-' ?></center></td>
                                                                            <td><center><?= $tingkat_ris8['ket_total_nilai'] ?? '-' ?></center></td>
                                                                          
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
                                        label: 'Tingkat Risiko',
                                        data: [<?= json_encode($tingkat_ris1['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris2['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris3['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris4['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris5['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris6['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris7['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>,
                                        <?= json_encode($tingkat_ris8['total_nilai'] ?? null, JSON_NUMERIC_CHECK) ?>
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








