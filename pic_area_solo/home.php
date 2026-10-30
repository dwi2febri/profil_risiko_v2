<?php include "verif.php"; ?>

<?php
require dirname(__DIR__, 1).'/conn/conn.php';

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

$kode_kantor = (int)($_GET['kode_kantor'] ?? 0);
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);

$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT id_profil_risiko,data_pembanding FROM frame_laporan_profil_risiko WHERE kantor_cabang = ? AND tahun =? AND periode =?", [$kode_kantor, $tahun, $periode]));


$id_pro = $frame['id_profil_risiko'] ?? 0;
$dp = $frame['data_pembanding'] ?? 0;






//tren
$currentYear = date("Y");
$tren1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 8 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 9 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 10 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 11 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 12 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 13 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));
$tren7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 14 AND user =3 AND status_korwil =1 AND status_skmr =1 ORDER BY periode DESC LIMIT 1", [$currentYear]));

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

$tren2_1 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 8 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per1]));
$tren2_2 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 9 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per2]));
$tren2_3 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 10 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per3]));
$tren2_4 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 11 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per4]));
$tren2_5 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 12 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per5]));
$tren2_6 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 13 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per6]));
$tren2_7 = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT * from frame_laporan_profil_risiko INNER JOIN nilai_profil ON frame_laporan_profil_risiko.id_profil_risiko = nilai_profil.id_profil_risiko WHERE  tahun = ? AND kantor_cabang = 14 AND user =3 AND status_korwil =1 AND status_skmr =1 AND periode = ?", [$currentYear, $nilai_per7]));

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








$ket1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = ?", [$id_pro]));
$ket2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = ?", [$id_pro]));
$ket3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$id_pro]));
$ket4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$id_pro]));
$ket5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$id_pro]));
$ket6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$id_pro]));

$pembanding_ket1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = ?", [$dp]));
$pembanding_ket2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = ?", [$dp]));
$pembanding_ket3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$dp]));
$pembanding_ket4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$dp]));
$pembanding_ket5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$dp]));
$pembanding_ket6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$dp]));


$peringkat_ket1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = ?", [$id_pro]));
$peringkat_ket2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = ?", [$id_pro]));
$peringkat_ket3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$id_pro]));
$peringkat_ket4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$id_pro]));
$peringkat_ket5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$id_pro]));
$peringkat_ket6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$id_pro]));

$inheren1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = ?", [$id_pro]));
$inheren2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = ?", [$id_pro]));
$inheren3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = ?", [$id_pro]));
$inheren4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = ?", [$id_pro]));
$inheren5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = ?", [$id_pro]));
$inheren6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = ?", [$id_pro]));

$kpmr1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = ?", [$id_pro]));
$kpmr2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = ?", [$id_pro]));
$kpmr3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = ?", [$id_pro]));
$kpmr4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = ?", [$id_pro]));
$kpmr5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = ?", [$id_pro]));
$kpmr6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = ?", [$id_pro]));


$peringkat_pembanding_ket1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = ?", [$dp]));
$peringkat_pembanding_ket2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = ?", [$dp]));
$peringkat_pembanding_ket3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$dp]));
$peringkat_pembanding_ket4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$dp]));
$peringkat_pembanding_ket5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$dp]));
$peringkat_pembanding_ket6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$dp]));

$pembanding_inheren1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = ?", [$dp]));
$pembanding_inheren2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = ?", [$dp]));
$pembanding_inheren3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = ?", [$dp]));
$pembanding_inheren4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = ?", [$dp]));
$pembanding_inheren5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = ?", [$dp]));
$pembanding_inheren6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = ?", [$dp]));

$pembanding_kpmr1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = ?", [$dp]));
$pembanding_kpmr2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = ?", [$dp]));
$pembanding_kpmr3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = ?", [$dp]));
$pembanding_kpmr4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = ?", [$dp]));
$pembanding_kpmr5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = ?", [$dp]));
$pembanding_kpmr6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = ?", [$dp]));

$ket_nilai = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = ?", [$id_pro]));
$pembanding_ket_nilai = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = ?", [$dp]));


$get_data = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE user =3 AND Kantor_cabang IN(8,9,10,11,12,13,14)"));

$get_data2 = mysqli_fetch_array(mysqli_query($conn, "SELECT COUNT(id_profil_risiko) AS total FROM frame_laporan_profil_risiko WHERE user =3 AND Kantor_cabang IN(8,9,10,11,12,13,14) AND status_korwil = 1 AND status_skmr = 1"));

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
                                    <h4 class="page-title">DASHBOARD SIMPRO (KORWIL-AREA SOLO)</h4>
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
                                                        <p class="text-muted font-15 mb-0">Laporan Profil Risiko</p>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="col-sm-6 col-xl-3">
                                                <div class="card shadow-none m-0 border-start">
                                                    <div class="card-body text-center">
                                                        <i class=" uil-fast-mail" style="font-size: 24px;"></i>
                                                        <h3><span><?= $get_data2['total'] ?? '-' ?></span></h3>
                                                        <p class="text-muted font-15 mb-0">Laporan Diterima Kantor Pusat</p>
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
                                                            <p class="text-muted font-12 mb-0">Tren Risiko Area Solo Raya Tahun <?= $currentYear ?> </br>Periode Sekarang Dibanding Periode Sebelumnya</p>
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
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">  <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="mb-3">
                                                        <label for="kc" class="form-label">Kantor Cabang</label>
                                                        <select class="form-select mb-3" name="kode_kantor" id="kode_kantor" required="">
                                                        <option value=" " selected> </option>
                                                            <?php
                                                            require dirname(__DIR__, 1).'/conn/conn.php';
                                                            $query_cabang = mysqli_query($conn, "SELECT * FROM jenis_cabang WHERE id_cabang IN(8,9,10,11,12,13,14)");
                                                            while ($data = mysqli_fetch_array($query_cabang)) { ?>
                                                                <option value="<?= $data['id_cabang'] ?? '' ?>" <?= $data['id_cabang'] == $kode_kantor ? ' selected' : '' ?>><?= ucwords($data['cabang']) ?></option>
                                                            <?php
                                                            };
                                                            ?>
                                                        </select>
                                                </div>
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
                                                                    require dirname(__DIR__, 1).'/conn/conn.php';
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
                                        
                                        <h4 class="header-title mb-3">Grafik Profil Risiko </h4>

                                        <div class="card-body pb-0">
                                            <canvas style="width:100px; height:43px"  id="chart1"></canvas>
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
                                                                                <center><b><?= $pembanding_ket1['inheren_kredit'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko operasional
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket2['inheren_operasional'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko kepatuhan
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket3['inheren_kepatuhan'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko likuiditas
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket4['inheren_likuiditas'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko reputasi
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket5['inheren_reputasi'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko stratejik
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket6['inheren_stratejik'] ?? '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Dikutip dari laporan sebelumnya
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket_nilai['total_nilai'] ?? '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $pembanding_ket_nilai['ket_total_nilai'] ?? '-' ?></b></center>
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
                                                                                <center><b><?= $ket1['inheren_kredit'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko operasional
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $ket2['inheren_operasional'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko kepatuhan
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $ket3['inheren_kepatuhan'] ?? '-' ?></b></center>
                                                                                </th>
                                                                                
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko likuiditas
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $ket4['inheren_likuiditas'] ?? '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko reputasi
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $ket5['inheren_reputasi'] ?? '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>

                                                                            <tr bgcolor="#edebe8" style="height:  100px;">
                                                                                <th>
                                                                                    Risiko stratejik
                                                                                </th>
                                                                                <th>
                                                                                <center><b><?= $ket6['inheren_stratejik'] ?? '-' ?></b></center>
                                                                                </th>
                                                                               
                                                                            </tr>
                                                                            
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= $ket_nilai['total_nilai'] ?? '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $ket_nilai['ket_total_nilai'] ?? '-' ?></b></center>
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
                                                                            <center><b><?= $pembanding_inheren1['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko operasional
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_inheren2['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kepatuhan
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_inheren3['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko likuiditas
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_inheren4['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko reputasi
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_inheren5['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko stratejik
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $pembanding_inheren6['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>
                                                                        
                                                                            <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Dikutip dari laporan sebelumnya
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= $pembanding_ket_nilai['total_nilai'] ?? '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $pembanding_ket_nilai['ket_total_nilai'] ?? '-' ?></b></center>
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
                                                                            <center><b><?= $inheren1['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko operasional
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $inheren2['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko kepatuhan
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $inheren3['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko likuiditas
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $inheren4['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                            
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko reputasi
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $inheren5['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                           
                                                                        </tr>

                                                                        <tr bgcolor="#edebe8" style="height:  100px;">
                                                                            <th>
                                                                                Risiko stratejik
                                                                            </th>
                                                                            <th>
                                                                            <center><b><?= $inheren6['hasil_peringkat'] ?? '-' ?></b></center>
                                                                            </th>
                                                                          
                                                                        </tr>
                                                                        <tr bgcolor="#edebe8" style="height:  100px; background-color: rgba(71, 162, 190, 0.6); color: black;">
                                                                                <th >
                                                                                Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR
                                                                                </th>
                                                                                
                                                                                <th>
                                                                                <center><b><?= $ket_nilai['total_nilai'] ?? '-' ?></b></center>
                                                                                
                                                                                <center><b><?= $ket_nilai['ket_total_nilai'] ?? '-' ?></b></center>
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
                                                <?php
                                                $triwulan1_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT  keterangan_profil_kredit.inheren_kredit AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_kredit['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                 <?php
                                                $triwulan2_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kredit.inheren_kredit AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_kredit['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                 <?php
                                                $triwulan3_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kredit.inheren_kredit AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_kredit['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                 <?php
                                                $triwulan4_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kredit.inheren_kredit AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kredit ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kredit.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_kredit['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                                <?php
                                                $triwulan1_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_operasional['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan2_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_operasional['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                               <?php
                                                $triwulan3_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_operasional['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan4_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_operasional.inheren_operasional AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_operasional ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_operasional.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_operasional['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                            <?php
                                                $triwulan1_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_kepatuhan['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan2_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_kepatuhan['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan3_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_kepatuhan['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan4_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_kepatuhan.inheren_kepatuhan AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_kepatuhan ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_kepatuhan.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_kepatuhan['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                            <?php
                                                $triwulan1_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_likuiditas['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan2_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_likuiditas['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan3_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_likuiditas['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan4_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_likuiditas.inheren_likuiditas AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_likuiditas ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_likuiditas.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_likuiditas['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                            <?php
                                                $triwulan1_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_reputasi['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan2_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_reputasi['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan3_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_reputasi['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan4_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_reputasi.inheren_reputasi AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_reputasi ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_reputasi.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_reputasi['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                                <?php
                                                $triwulan1_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 1", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan1_stratejik['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan2_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 2", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan2_stratejik['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan3_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 3", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan3_stratejik['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan4_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT keterangan_profil_stratejik.inheren_stratejik AS tingkat_risiko from frame_laporan_profil_risiko INNER JOIN keterangan_profil_stratejik ON frame_laporan_profil_risiko.id_profil_risiko = keterangan_profil_stratejik.id_profil_risiko WHERE tahun = ? AND kantor_cabang = ? AND periode = 4", [$tahun, $kode_kantor]));
                                                echo json_encode($triwulan4_stratejik['tingkat_risiko'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                                <?php
                                                $triwulan1_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT  inheren_kredit from keterangan_profil_kredit WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_kredit['inheren_kredit'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_operasional from keterangan_profil_operasional WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_operasional['inheren_operasional'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_kepatuhan from keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_kepatuhan['inheren_kepatuhan'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_likuiditas from keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_likuiditas['inheren_likuiditas'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_reputasi from keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_reputasi['inheren_reputasi'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_stratejik from keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$dp]));
                                                echo json_encode($triwulan1_stratejik['inheren_stratejik'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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
                                                <?php
                                                $triwulan1_kredit = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT  inheren_kredit from keterangan_profil_kredit WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_kredit['inheren_kredit'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_operasional = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_operasional from keterangan_profil_operasional WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_operasional['inheren_operasional'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_kepatuhan = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_kepatuhan from keterangan_profil_kepatuhan WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_kepatuhan['inheren_kepatuhan'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_likuiditas = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_likuiditas from keterangan_profil_likuiditas WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_likuiditas['inheren_likuiditas'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_reputasi = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_reputasi from keterangan_profil_reputasi WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_reputasi['inheren_reputasi'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>,
                                                <?php
                                                $triwulan1_stratejik = mysqli_fetch_assoc(simpro_db_query($conn, "SELECT inheren_stratejik from keterangan_profil_stratejik WHERE id_profil_risiko = ?", [$id_pro]));
                                                echo json_encode($triwulan1_stratejik['inheren_stratejik'] ?? null, JSON_NUMERIC_CHECK);
                                                ?>
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