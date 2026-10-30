<?php
include "../fungsi/fungsi.php";


$id = $_GET['id'];

$frame_laporan_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));

$tahun = $frame_laporan_kredit['tahun'];

$master_kredit_P1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar1 WHERE id_profil_risiko = ?", [$id]));
$master_kredit_P2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar2 WHERE id_profil_risiko = ?", [$id]));
$master_kredit_P3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));

$ambang_batas_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ambang_batas_kredit WHERE tahun = ?", [$tahun]));
$bobot_kredit = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM master_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));



//penamaan rasio
$apro = $master_kredit_P1['aset_produktif'];
$totas = $master_kredit_P1['total_aset'];
$aba = $master_kredit_P1['aba'];
$kyd = $master_kredit_P1['kyd'];
$kredit_spg = $master_kredit_P1['kredit_spg'];
$kredit_pbta = $master_kredit_P1['kredit_pbta'];
$kredit_jpendek = $master_kredit_P1['kredit_jpendek'];
$kredit_jmenengah = $master_kredit_P1['kredit_jmenengah'];
$kredit_jpanjang = $master_kredit_P1['kredit_jpanjang'];
$noa_kyd = $master_kredit_P1['noa_kyd'];
$kredit_agunan_tb = $master_kredit_P1['kredit_agunan_tb'];
$kredit_agunan_kb = $master_kredit_P1['kredit_agunan_kb'];
$kredit_agunan_kr2 = $master_kredit_P1['kredit_agunan_kr2'];
$kredit_kub = $master_kredit_P1['kredit_kub'];
$kredit_ta = $master_kredit_P1['kredit_ta'];
$kredit_korporasi = $master_kredit_P1['kredit_korporasi'];
$kredit_pep = $master_kredit_P1['kredit_pep'];
$kredit_lebih350 = $master_kredit_P1['kredit_lebih350'];
$debitur_inti25 = $master_kredit_P1['debitur_inti25'];
$kredit_3sektor_ekonomi_terbesar = $master_kredit_P1['kredit_3sektor_ekonomi_terbesar'];

$noa_kredit_sd150 = $master_kredit_P2['noa_kredit_sd150'];

$aba_tinggi = $master_kredit_P3['aba_tertinggi'];




// menghitung rumus
$p1 = round(($apro / $totas) * 100, 2);
$p1a = round(($aba / $totas) * 100, 2);
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










if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';




    //pilar 2



    //pilar 3






    simpro_db_query($conn, "UPDATE master_kredit_pilar1 SET 
   
    WHERE id_profil_risiko = ?", [$id]);



    simpro_db_query($conn, "UPDATE master_kredit_pilar2 SET 
    WHERE id_profil_risiko = ?", [$id]);


    simpro_db_query($conn, "UPDATE master_kredit_pilar3 SET 
   WHERE id_profil_risiko = ?", [$id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=maskre&id=$id");
    exit();
}
?>





<!--Parameter 1 PILAR1--->

<?php


$bobot = 1 / 3;

$ab = $ambang_batas_kredit['ap_per_ta'];
if ($pl <= $ab) {
    $hsl1 = 0;
} else {
    $hsl1 = 1;
}

//par1a
$aba = $ambang_batas_kredit['pbl_per_tap'];
$ab2a = $ambang_batas_kredit['rr_pbl_per_tap'];
$ab3a = $ambang_batas_kredit['rrr_pbl_per_tap'];
$ab4a = $ambang_batas_kredit['rrrr_pbl_per_tap'];
if ($pla <= $aba) {
    $hsl1a = 1;
} else if ($pla > $aba && $pla <= $ab2a) {
    $hsl1a = 2;
} else if ($pla > $ab2a && $pla <= $ab3a) {
    $hsl1a = 3;
} elseif ($pla > $ab3a && $pla <= $ab4a) {
    $hsl1a = 4;
} else {
    $hsl1a = 5;
}


$nilai1a = $hsl1a * $bobot;

//par1b
$abb = $ambang_batas_kredit['apbt_per_pbl'];
$ab2b = $ambang_batas_kredit['rr_apbt_per_pbl'];
$ab3b = $ambang_batas_kredit['rrr_apbt_per_pbl'];
$ab4b = $ambang_batas_kredit['rrrr_apbt_per_pbl'];
if ($p1b <= $abb) {
    $hsl1b = 1;
} else if ($plb > $abb && $plb <= $ab2b) {
    $hsl1b = 2;
} else if ($plb > $ab2b && $plb <= $ab3b) {
    $hsl1b = 3;
} elseif ($plb > $ab3b && $plb <= $ab4b) {
    $hsl1b = 4;
} else {
    $hsl1b = 5;
}


$nilai1b = $hsl1b * $bobot;

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


$nilai1c = $hsl1c * $bobot;

$koreksi = $nilai1a + $nilai1b + $nilai1c;


if ($hsl1 == 0) {
    $nilai = $koreksi;
} else {
    $nilai = ($hsl1 + $koreksi) / 2;
}



?>



<!--Parameter 2 PILAR1--->

<?php


$bobot2 = 1 / 14;

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


$nilai2a = $hsl2a * $bobot2;

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


$nilai2b = $hsl2b * $bobot2;

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


$nilai2c = $hsl2c * $bobot2;



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


$nilai2d = $hsl2d * $bobot2;


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


$nilai2e = $hsl2e * $bobot2;



//par2f
$para2_abf = $ambang_batas_kredit['nkp150_per_nkyd'];
$para2_ab2f = $ambang_batas_kredit['rr_nkp150_per_nkyd'];
$para2_ab3f = $ambang_batas_kredit['rrr_nkp150_per_nkyd'];
$para2_ab4f = $ambang_batas_kredit['rrrr_nkp150_per_nkyd'];
if ($p2f >= $para2_abf) {
    $hsl2f = 1;
} else if ($p2f < $para2_abf && $p2f >= $para2_ab2f) {
    $hsl2f = 2;
} else if ($p2f < $para2_ab2f && $p2f >= $para2_ab3f) {
    $hsl2f = 3;
} elseif ($p2f < $para2_ab3f && $p2f >= $para2_ab4f) {
    $hsl2f = 4;
} else {
    $hsl2f = 5;
}

$nilai2f = $hsl2f * $bobot2;



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

$nilai2g = $hsl2g * $bobot2;


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

$nilai2h = $hsl2h * $bobot2;


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

$nilai2i = $hsl2i * $bobot2;


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

$nilai2j = $hsl2j * $bobot2;



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

$nilai2k = $hsl2k * $bobot2;

//par2l
$para2_abl = $ambang_batas_kredit['kknp_per_tkyd'];
$para2_ab2l = $ambang_batas_kredit['rr_kknp_per_tkyd'];
$para2_ab3l = $ambang_batas_kredit['rrr_kknp_per_tkyd'];
$para2_ab4l = $ambang_batas_kredit['rrrrkknp_per_tkyd'];
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

$nilai2l = $hsl2l * $bobot2;

//par2m
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

$nilai2m = $hsl2m * $bobot2;



//par2n
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

$nilai2n = $hsl2n * $bobot2;


$koreksi2 = $nilai2a + $nilai2b + $nilai2c + $nilai2d + $nilai2e + $nilai2f + $nilai2g + $nilai2h + $nilai2i + $nilai2j
    + $nilai2k + $nilai2l + $nilai2m + $nilai2n;


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



?>


<!--Parameter 1 PILAR2--->

<?php
?>










<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Kredit Inhern</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren Profil Risiko Kredit</h4>

                            <hr>
                            </hr>


                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>

                                </div>
                            </div>



                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-primary">
                                        <tr>

                                            <th colspan="9">
                                                <h4>
                                                    <center><b>RISIKO KREDIT</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center">
                                                PARAMETER
                                            </th>

                                            <th class="text-center">
                                                NOMINAL
                                            </th>
                                            <th class="text-center" width="140px">
                                                RASIO
                                            </th>
                                            <th class="text-center" width="30px">
                                                AMBANG BATAS
                                            </th>
                                            <th class="text-center" width="100px">
                                                RUMUS
                                            </th>
                                            <th class="text-center" width="100px">
                                                KOREKSI
                                            </th>
                                            <th class="text-center" width="100px">
                                                NILAI
                                            </th>
                                            <th class="text-center">
                                                KETERANGAN
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Aset Produktif</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ap_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                a.<center>Penempatan Bank Lain</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['pbl_per_tap'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                b.<center>Aba Pada 1 Bank Tertinggi</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P3['aba_tertinggi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apbt_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai1b, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                c.<center>Aba Pada BPR</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P3['aba_bpr']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['abapb_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1c ?></center>
                                            </td>
                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai1c, 2) ?></center>
                                            </td>

                                        </tr>
















                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Aset Produktif</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kyd_per_ap'] ?></td>

                                            <td>
                                                <center><?= $hsl2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                a.<center>Kredit Skema Potong Gaji</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_spg']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kspg_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                b.<center>Kredit Musiman (Grace Period)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_pbta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['km_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                c.<center>Kredit Jangka Pendek</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jpendek']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kjpen_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                d.<center>Kredit Jangka Menengah</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jmenengah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjm_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                e.<center>Kredit Jangka Panjang</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jpanjang']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjpan_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2e, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                f.<center>NOA Kredit plafon s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>NOA KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P2['noa_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['noa_kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkp150_per_nkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2f, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                g.<center>Kredit Dengan Agunan Tanah dan Bangunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_tb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2g ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kdatdb_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2g ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2g, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                h.<center>Kredit Agunan Kendaraan Bermotor</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kb']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2h ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kak_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2h ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2h, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                i.<center>Kredit Agunan Kendaraan Roda 2</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_agunan_kr2']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2i ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kakr2_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2i ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2i, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                j.<center>OSC Produk KUB</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_kub']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2j ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['opk_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2j ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2j, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                k.<center>Kredit Tanpa Agunan</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_ta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2k ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kta_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2k ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2k, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                l.<center>Kredit Korporasi (Non Perorangan)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_korporasi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2l ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kknp_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2l ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2l, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                m.<center>Kredit PEP</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_pep']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2m ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpep_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2m ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2m, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                n.<center>Kredit plafon > 350jt</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_lebih350']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2n ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kp350_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2n ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2n, 2) ?></center>
                                            </td>

                                        </tr>















                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>25 Debitur Inti</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['debitur_inti25']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p3 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['di25_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl3 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par3" class="form-control" id="koreksippl1_par3" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par3" class="form-control" id="nilaippl1_par3" readonly></center>

                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <label for="example-select" class="form-label">Target pasar</label>
                                                <select class="form-select" id="target_pasar1">
                                                    <option value="2">2 = tidak berubah selama jangka waktu yang sangat lama</option>
                                                    <option value="3">3 = tidak berubah selama jangka waktu yang lama</option>
                                                    <option value="4">4 = tidak berubah selama jangka waktu yang cukup lama</option>
                                                    <option value="5">5 = tidak berubah selama jangka waktu yang singkat</option>
                                                </select>
                                            </th>


                                        </tr>


                                        <script type="text/javascript">
                                            $('#target_pasar1').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par3").val(val);
                                            });
                                        </script>

                                        <script type="text/javascript">
                                            $('#target_pasar1').change(function() {
                                                var val = this.value;

                                                var hsl3 = <?php echo json_encode($hsl3); ?>;

                                                if (hsl3 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl3) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par3").val(nilai);
                                            });
                                        </script>

















                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Kredit Per Sektor Ekonomi</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_3sektor_ekonomi_terbesar']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p4 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kpse_per_tk'] ?></td>

                                            <td>
                                                <center><?= $hsl4 ?></center>
                                            </td>

                                            <td>
                                                <center><input type="number" form="my_form" name="koreksippl1_par4" class="form-control" id="koreksippl1_par4" readonly></center>
                                            </td>
                                            <td>

                                                <center><input type="text" form="my_form" name="nilaippl1_par4" class="form-control" id="nilaippl1_par4" readonly></center>

                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <label for="example-select" class="form-label">Kredit yang berasal dari 3 sektor terbesar</label>
                                                <select class="form-select" id="sektor_terbesar3">
                                                    <option value="2">2 = tidak berubah selama jangka waktu yang sangat lama</option>
                                                    <option value="3">3 = tidak berubah selama jangka waktu yang lama</option>
                                                    <option value="4">4 = tidak berubah selama jangka waktu yang cukup lama</option>
                                                    <option value="5">5 = tidak berubah selama jangka waktu yang singkat</option>
                                                </select>
                                            </th>


                                        </tr>


                                        <script type="text/javascript">
                                            $('#sektor_terbesar3').change(function() {
                                                var val = this.value;
                                                $("#koreksippl1_par4").val(val);
                                            });
                                        </script>

                                        <script type="text/javascript">
                                            $('#sektor_terbesar3').change(function() {
                                                var val = this.value;

                                                var hsl4 = <?php echo json_encode($hsl4); ?>;

                                                if (hsl4 == 0) {
                                                    var nilai = val;
                                                } else {
                                                    var nilai = (parseFloat(hsl4) + parseFloat(val)) / 2;
                                                    nilai = nilai.toFixed(2);
                                                }
                                                $("#nilaippl1_par4").val(nilai);
                                            });
                                        </script>




                                        <tr bgcolor="#FFE9EC">

                                            <th colspan="3">
                                                <center>Rekapitulasi penilaian tingkat risiko untuk pilar 1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Tertinggi</center>
                                                <center><input type="text" form="my_form" name="pilar1_max" class="form-control" id="pilar1_max" readonly></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Terendah</center>
                                                <center><input type="text" form="my_form" name="pilar1_min" class="form-control" id="pilar1_min" readonly></center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Rata-rata</center>
                                                <center><input type="text" form="my_form" name="pilar1_avg" class="form-control" id="pilar1_avg" readonly></center>
                                            </th>
                                            <th colspan="2">
                                                <center>Ditetapkan</center>
                                                <select class="form-select" id="sektor_terbesar3">
                                                    <option value="1">Tertinggi</option>
                                                    <option value="2">Terendah</option>
                                                    <option value="3">Rata-rata</option>
                                                </select>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><input type="text" form="my_form" name="pilar1_dtp" class="form-control" id="pilar1_dtp" readonly></center>
                                            </th>


                                        </tr>




































                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Kualitas Aset</b>
                                                </h4>
                                            </td>



                                        </tr>

                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Aset Produktif Bermasalah</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset Produktif</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P2['aset_produktif_bermasalah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['ap_per_ta'] ?></td>

                                            <td>
                                                <center><?= $hsl1 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                a.<center>Penempatan Bank Lain</center>
                                                <hr>
                                                </hr>
                                                <center>Total Aset</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['total_aset']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['pbl_per_tap'] ?> </td>

                                            <td>
                                                <center><?= $hsl1a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai1a, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                b.<center>Aba Pada 1 Bank Tertinggi</center>
                                                <hr>
                                                </hr>
                                                <center>Penempatan Bank Lain</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P3['aba_tertinggi']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aba']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p1b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['apbt_per_pbl'] ?> </td>

                                            <td>
                                                <center><?= $hsl1b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai1b, 2) ?></center>
                                            </td>

                                        </tr>












                                        <tr bgcolor="#FCFAFA">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center>Kredit Yang Diberikan</center>
                                                <hr>
                                                </hr>
                                                <center>Aset Produktif</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['aset_produktif']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2 ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kyd_per_ap'] ?></td>

                                            <td>
                                                <center><?= $hsl2 ?></center>
                                            </td>

                                            <td>
                                                <center><?= round($koreksi2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2, 2) ?></center>
                                            </td>

                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                a.<center>Kredit Skema Potong Gaji</center>
                                                <hr>
                                                </hr>
                                                <center>Total Kredit</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_spg']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2a ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kspg_per_tk'] ?> </td>

                                            <td>
                                                <center><?= $hsl2a ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2a, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                b.<center>Kredit Musiman (Grace Period)</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_pbta']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2b ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['km_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2b ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2b, 2) ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                c.<center>Kredit Jangka Pendek</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jpendek']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2c ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['kjpen_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2c ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2c, 2) ?></center>
                                            </td>

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                d.<center>Kredit Jangka Menengah</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jmenengah']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2d ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjm_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2d ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2d, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                e.<center>Kredit Jangka Panjang</center>
                                                <hr>
                                                </hr>
                                                <center>Total KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P1['kredit_jpanjang']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2e ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                <= <?= $ambang_batas_kredit['kjpan_per_tkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2e ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2e, 2) ?></center>
                                            </td>

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                f.<center>NOA Kredit plafon s/d 150 juta</center>
                                                <hr>
                                                </hr>
                                                <center>NOA KYD</center>
                                            </th>
                                            <th class="text-nowrap" scope="row">
                                                <center><?= rupiah($master_kredit_P2['noa_kredit_sd150']) ?></center>
                                                <hr>
                                                </hr>
                                                <center><?= rupiah($master_kredit_P1['noa_kyd']) ?></center>
                                            </th>
                                            <td><input type="number" form="my_form" name="aba" value="<?= $p2f ?>" class="form-control" id="rupiah" readonly></td>
                                            <td>
                                                >= <?= $ambang_batas_kredit['nkp150_per_nkyd'] ?> </td>

                                            <td>
                                                <center><?= $hsl2f ?></center>
                                            </td>

                                            <td>
                                                <center>Bobot</center>
                                                <center><?= round($bobot2, 2) ?></center>
                                            </td>
                                            <td>
                                                <center><?= round($nilai2f, 2) ?></center>
                                            </td>

                                        </tr>









                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->































                            <hr>
                            </hr>

                            <br></br>







                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>


            <!-- end row -->


            <!-- end row -->



            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>