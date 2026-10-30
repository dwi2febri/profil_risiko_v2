<?php

include "../fungsi/fungsi.php";

$id = $_GET['id'];

$inheren_kre = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_kredit WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_kre = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_kredit WHERE id_frame_setris_ditetapkan = ?", [$id]));

$inheren_op = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_operasional WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_op = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_operasional WHERE id_frame_setris_ditetapkan = ?", [$id]));

$inheren_kep = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_kepatuhan WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_kep = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_kepatuhan WHERE id_frame_setris_ditetapkan = ?", [$id]));

$inheren_lik = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_likuiditas WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_lik = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_likuiditas WHERE id_frame_setris_ditetapkan = ?", [$id]));

$inheren_rep = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_reputasi WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_rep = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_reputasi WHERE id_frame_setris_ditetapkan = ?", [$id]));

$inheren_stra = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_stratejik WHERE id_frame_setris_ditetapkan = ?", [$id]));
$kpmr_stra = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_stratejik WHERE id_frame_setris_ditetapkan = ?", [$id]));

if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

    //kredit
    $inheren_kre_set_pil1 = $_POST['inheren_kre_set_pil1'];
    $inheren_kre_set_pil2 = $_POST['inheren_kre_set_pil2'];
    $inheren_kre_set_pil3 = $_POST['inheren_kre_set_pil3'];
    $inheren_kre_set_tingkat_risiko = $_POST['inheren_kre_set_tingkat_risiko'];

    $kpmr_kre_set_pil1 = $_POST['kpmr_kre_set_pil1'];
    $kpmr_kre_set_pil2 = $_POST['kpmr_kre_set_pil2'];
    $kpmr_kre_set_pil3 = $_POST['kpmr_kre_set_pil3'];
    $kpmr_kre_set_pil4 = $_POST['kpmr_kre_set_pil4'];
    $kpmr_kre_set_tingkat_risiko = $_POST['kpmr_kre_set_tingkat_risiko'];

    //operasional
    $inheren_op_set_pil1_par2 = $_POST['inheren_op_set_pil1_par2'];
    $inheren_op_set_pil1_par3 = $_POST['inheren_op_set_pil1_par3'];
    $inheren_op_set_pil1_par4 = $_POST['inheren_op_set_pil1_par4'];
    $inheren_op_set_pil1 = $_POST['inheren_op_set_pil1'];
    $inheren_op_set_pil2_par1 = $_POST['inheren_op_set_pil2_par1'];
    $inheren_op_set_pil2 = $_POST['inheren_op_set_pil2'];
    $inheren_op_set_pil3_par1 = $_POST['inheren_op_set_pil3_par1'];
    $inheren_op_set_pil4_par1 = $_POST['inheren_op_set_pil4_par1'];
    $inheren_op_set_pil5_par1 = $_POST['inheren_op_set_pil5_par1'];
    $inheren_op_set_pil6_par1 = $_POST['inheren_op_set_pil6_par1'];
    $inheren_op_set_tingkat_risiko = $_POST['inheren_op_set_tingkat_risiko'];

    $kpmr_op_set_pil1 = $_POST['kpmr_op_set_pil1'];
    $kpmr_op_set_pil2 = $_POST['kpmr_op_set_pil2'];
    $kpmr_op_set_pil3 = $_POST['kpmr_op_set_pil3'];
    $kpmr_op_set_pil4 = $_POST['kpmr_op_set_pil4'];
    $kpmr_op_set_tingkat_risiko = $_POST['kpmr_op_set_tingkat_risiko'];

    //kepatuhan
    $inheren_kep_set_pil1_par1 = $_POST['inheren_kep_set_pil1_par1'];
    $inheren_kep_set_pil1_par2 = $_POST['inheren_kep_set_pil1_par2'];
    $inheren_kep_set_pil1 = $_POST['inheren_kep_set_pil1'];
    $inheren_kep_set_pil2_par1 = $_POST['inheren_kep_set_pil2_par1'];
    $inheren_kep_set_pil2_par2 = $_POST['inheren_kep_set_pil2_par2'];
    $inheren_kep_set_pil2_par3 = $_POST['inheren_kep_set_pil2_par3'];
    $inheren_kep_set_pil2 = $_POST['inheren_kep_set_pil2'];
    $inheren_kep_set_pil3_par1 = $_POST['inheren_kep_set_pil3_par1'];
    $inheren_kep_set_tingkat_risiko = $_POST['inheren_kep_set_tingkat_risiko'];

    $kpmr_kep_set_pil1 = $_POST['kpmr_kep_set_pil1'];
    $kpmr_kep_set_pil2 = $_POST['kpmr_kep_set_pil2'];
    $kpmr_kep_set_pil3 = $_POST['kpmr_kep_set_pil3'];
    $kpmr_kep_set_pil4 = $_POST['kpmr_kep_set_pil4'];
    $kpmr_kep_set_tingkat_risiko = $_POST['kpmr_kep_set_tingkat_risiko'];

    //likuiditas
    $inheren_lik_set_pil1 = $_POST['inheren_lik_set_pil1'];
    $inheren_lik_set_pil2 = $_POST['inheren_lik_set_pil2'];
    $inheren_lik_set_pil3 = $_POST['inheren_lik_set_pil3'];
    $inheren_lik_set_tingkat_risiko = $_POST['inheren_lik_set_tingkat_risiko'];

    $kpmr_lik_set_pil1 = $_POST['kpmr_lik_set_pil1'];
    $kpmr_lik_set_pil2 = $_POST['kpmr_lik_set_pil2'];
    $kpmr_lik_set_pil3 = $_POST['kpmr_lik_set_pil3'];
    $kpmr_lik_set_pil4 = $_POST['kpmr_lik_set_pil4'];
    $kpmr_lik_set_tingkat_risiko = $_POST['kpmr_lik_set_tingkat_risiko'];

    //reputasi
    $inheren_rep_set_pil1_par1 = $_POST['inheren_rep_set_pil1_par1'];
    $inheren_rep_set_pil1_par2 = $_POST['inheren_rep_set_pil1_par2'];
    $inheren_rep_set_pil1 = $_POST['inheren_rep_set_pil1'];
    $inheren_rep_set_pil2_par1 = $_POST['inheren_rep_set_pil2_par1'];
    $inheren_rep_set_pil2_par2 = $_POST['inheren_rep_set_pil2_par2'];
    $inheren_rep_set_pil2 = $_POST['inheren_rep_set_pil2'];
    $inheren_rep_set_pil3_par1 = $_POST['inheren_rep_set_pil3_par1'];
    $inheren_rep_set_pil3_par2 = $_POST['inheren_rep_set_pil3_par2'];
    $inheren_rep_set_pil3 = $_POST['inheren_rep_set_pil3'];
    $inheren_rep_set_pil4_par1 = $_POST['inheren_rep_set_pil4_par1'];
    $inheren_rep_set_tingkat_risiko = $_POST['inheren_rep_set_tingkat_risiko'];

    $kpmr_rep_set_pil1 = $_POST['kpmr_rep_set_pil1'];
    $kpmr_rep_set_pil2 = $_POST['kpmr_rep_set_pil2'];
    $kpmr_rep_set_pil3 = $_POST['kpmr_rep_set_pil3'];
    $kpmr_rep_set_pil4 = $_POST['kpmr_rep_set_pil4'];
    $kpmr_rep_set_tingkat_risiko = $_POST['kpmr_rep_set_tingkat_risiko'];


    //stratejik
    $inheren_stra_set_pil1_par1 = $_POST['inheren_stra_set_pil1_par1'];
    $inheren_stra_set_pil2_par1 = $_POST['inheren_stra_set_pil2_par1'];
    $inheren_stra_set_pil2_par2 = $_POST['inheren_stra_set_pil2_par2'];
    $inheren_stra_set_pil2 = $_POST['inheren_stra_set_pil2'];
    $inheren_stra_set_pil3_par1 = $_POST['inheren_stra_set_pil3_par1'];
    $inheren_stra_set_pil3_par2 = $_POST['inheren_stra_set_pil3_par2'];
    $inheren_stra_set_pil3 = $_POST['inheren_stra_set_pil3'];
    $inheren_stra_set_pil4_par1 = $_POST['inheren_stra_set_pil4_par1'];
    $inheren_stra_set_tingkat_risiko = $_POST['inheren_stra_set_tingkat_risiko'];

    $kpmr_stra_set_pil1 = $_POST['kpmr_stra_set_pil1'];
    $kpmr_stra_set_pil2 = $_POST['kpmr_stra_set_pil2'];
    $kpmr_stra_set_pil3 = $_POST['kpmr_stra_set_pil3'];
    $kpmr_stra_set_pil4 = $_POST['kpmr_stra_set_pil4'];
    $kpmr_stra_set_tingkat_risiko = $_POST['kpmr_stra_set_tingkat_risiko'];



    //sql kre
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_kredit SET 
    inheren_kre_set_pil1 = ?,
    inheren_kre_set_pil2 = ?,
    inheren_kre_set_pil3 = ?,
    inheren_kre_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_kre_set_pil1, $inheren_kre_set_pil2, $inheren_kre_set_pil3, $inheren_kre_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_kredit SET 
    kpmr_kre_set_pil1 = ?,
    kpmr_kre_set_pil2 = ?,
    kpmr_kre_set_pil3 = ?,
    kpmr_kre_set_pil4 = ?,
    kpmr_kre_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_kre_set_pil1, $kpmr_kre_set_pil2, $kpmr_kre_set_pil3, $kpmr_kre_set_pil4, $kpmr_kre_set_tingkat_risiko, $id]);


    //sql op
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_operasional SET 
    inheren_op_set_pil1_par2 = ?,
    inheren_op_set_pil1_par3 = ?,
    inheren_op_set_pil1_par4 = ?,
    inheren_op_set_pil1 = ?,
    inheren_op_set_pil2_par1 = ?,
    inheren_op_set_pil2 = ?,
    inheren_op_set_pil3_par1 = ?,
    inheren_op_set_pil4_par1 = ?,
    inheren_op_set_pil5_par1 = ?,
    inheren_op_set_pil6_par1 = ?,
    inheren_op_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_op_set_pil1_par2, $inheren_op_set_pil1_par3, $inheren_op_set_pil1_par4, $inheren_op_set_pil1, $inheren_op_set_pil2_par1, $inheren_op_set_pil2, $inheren_op_set_pil3_par1, $inheren_op_set_pil4_par1, $inheren_op_set_pil5_par1, $inheren_op_set_pil6_par1, $inheren_op_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_operasional SET 
    kpmr_op_set_pil1 = ?,
    kpmr_op_set_pil2 = ?,
    kpmr_op_set_pil3 = ?,
    kpmr_op_set_pil4 = ?,
    kpmr_op_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_op_set_pil1, $kpmr_op_set_pil2, $kpmr_op_set_pil3, $kpmr_op_set_pil4, $kpmr_op_set_tingkat_risiko, $id]);


    //sql kep
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_kepatuhan SET 
    inheren_kep_set_pil1_par1 = ?,
    inheren_kep_set_pil1_par2 = ?,
    inheren_kep_set_pil1 = ?,
    inheren_kep_set_pil2_par1 = ?,
    inheren_kep_set_pil2_par2 = ?,
    inheren_kep_set_pil2_par3 = ?,
    inheren_kep_set_pil2 = ?,
    inheren_kep_set_pil3_par1 = ?,
    inheren_kep_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_kep_set_pil1_par1, $inheren_kep_set_pil1_par2, $inheren_kep_set_pil1, $inheren_kep_set_pil2_par1, $inheren_kep_set_pil2_par2, $inheren_kep_set_pil2_par3, $inheren_kep_set_pil2, $inheren_kep_set_pil3_par1, $inheren_kep_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_kepatuhan SET 
    kpmr_kep_set_pil1 = ?,
    kpmr_kep_set_pil2 = ?,
    kpmr_kep_set_pil3 = ?,
    kpmr_kep_set_pil4 = ?,
    kpmr_kep_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_kep_set_pil1, $kpmr_kep_set_pil2, $kpmr_kep_set_pil3, $kpmr_kep_set_pil4, $kpmr_kep_set_tingkat_risiko, $id]);

    //sql lik
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_likuiditas SET 
    inheren_lik_set_pil1 = ?,
    inheren_lik_set_pil2 = ?,
    inheren_lik_set_pil3 = ?,
    inheren_lik_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_lik_set_pil1, $inheren_lik_set_pil2, $inheren_lik_set_pil3, $inheren_lik_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_likuiditas SET 
    kpmr_lik_set_pil1 = ?,
    kpmr_lik_set_pil2 = ?,
    kpmr_lik_set_pil3 = ?,
    kpmr_lik_set_pil4 = ?,
    kpmr_lik_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_lik_set_pil1, $kpmr_lik_set_pil2, $kpmr_lik_set_pil3, $kpmr_lik_set_pil4, $kpmr_lik_set_tingkat_risiko, $id]);

    //sql rep
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_reputasi SET 
    inheren_rep_set_pil1_par1 = ?,
    inheren_rep_set_pil1_par2 = ?,
    inheren_rep_set_pil1 = ?,
    inheren_rep_set_pil2_par1 = ?,
    inheren_rep_set_pil2_par2 = ?,
    inheren_rep_set_pil2 = ?,
    inheren_rep_set_pil3_par1 = ?,
    inheren_rep_set_pil3_par2 = ?,
    inheren_rep_set_pil3 = ?,
    inheren_rep_set_pil4_par1 = ?,
    inheren_rep_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_rep_set_pil1_par1, $inheren_rep_set_pil1_par2, $inheren_rep_set_pil1, $inheren_rep_set_pil2_par1, $inheren_rep_set_pil2_par2, $inheren_rep_set_pil2, $inheren_rep_set_pil3_par1, $inheren_rep_set_pil3_par2, $inheren_rep_set_pil3, $inheren_rep_set_pil4_par1, $inheren_rep_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_reputasi SET 
    kpmr_rep_set_pil1 = ?,
    kpmr_rep_set_pil2 = ?,
    kpmr_rep_set_pil3 = ?,
    kpmr_rep_set_pil4 = ?,
    kpmr_rep_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_rep_set_pil1, $kpmr_rep_set_pil2, $kpmr_rep_set_pil3, $kpmr_rep_set_pil4, $kpmr_rep_set_tingkat_risiko, $id]);

    //sql stra
    simpro_db_query($conn, "UPDATE setting_risiko_inheren_stratejik SET 
    inheren_stra_set_pil1_par1 = ?,
    inheren_stra_set_pil2_par1 = ?,
    inheren_stra_set_pil2_par2 = ?,
    inheren_stra_set_pil2 = ?,
    inheren_stra_set_pil3_par1 = ?,
    inheren_stra_set_pil3_par2 = ?,
    inheren_stra_set_pil3 = ?,
    inheren_stra_set_pil4_par1 = ?,
    inheren_stra_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$inheren_stra_set_pil1_par1, $inheren_stra_set_pil2_par1, $inheren_stra_set_pil2_par2, $inheren_stra_set_pil2, $inheren_stra_set_pil3_par1, $inheren_stra_set_pil3_par2, $inheren_stra_set_pil3, $inheren_stra_set_pil4_par1, $inheren_stra_set_tingkat_risiko, $id]);


    simpro_db_query($conn, "UPDATE setting_risiko_kpmr_stratejik SET 
    kpmr_stra_set_pil1 = ?,
    kpmr_stra_set_pil2 = ?,
    kpmr_stra_set_pil3 = ?,
    kpmr_stra_set_pil4 = ?,
    kpmr_stra_set_tingkat_risiko = ?
    WHERE id_frame_setris_ditetapkan = ?", [$kpmr_stra_set_pil1, $kpmr_stra_set_pil2, $kpmr_stra_set_pil3, $kpmr_stra_set_pil4, $kpmr_stra_set_tingkat_risiko, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=set_pentapan&id=$id");
    exit();
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Settingan Ditetapkan Di Setiap Unit Risiko</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->


            <!-- end row -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Penetapan Tingkat Risiko yang Digunakan</h4>
                            <p class="text-muted font-13">
                                Isilah Form dibawah ini untuk menetapkan tingkat risiko yang digunakan (tertinggi/terendah/rata-rata)di setiap parameter dan pilar
                            </p>
                            <hr>
                            </hr>

                            <br></br>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-dark" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>



                            <br></br>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <button class="nav-link active" id="nav-kredit-tab" data-bs-toggle="tab" data-bs-target="#nav-kredit" type="button" role="tab" aria-controls="nav-kredit" aria-selected="true">Kredit</button>
                                <button class="nav-link" id="nav-operasional-tab" data-bs-toggle="tab" data-bs-target="#nav-operasional" type="button" role="tab" aria-controls="nav-operasional" aria-selected="false">Operasional</button>
                                <button class="nav-link" id="nav-kepatuhan-tab" data-bs-toggle="tab" data-bs-target="#nav-kepatuhan" type="button" role="tab" aria-controls="nav-kepatuhan" aria-selected="false">Kepatuhan</button>
                                <button class="nav-link" id="nav-likuiditas-tab" data-bs-toggle="tab" data-bs-target="#nav-likuiditas" type="button" role="tab" aria-controls="nav-likuiditas" aria-selected="false">Likuiditas</button>
                                <button class="nav-link" id="nav-reputasi-tab" data-bs-toggle="tab" data-bs-target="#nav-reputasi" type="button" role="tab" aria-controls="nav-reputasi" aria-selected="false">Reputasi</button>
                                <button class="nav-link" id="nav-stratejik-tab" data-bs-toggle="tab" data-bs-target="#nav-stratejik" type="button" role="tab" aria-controls="nav-stratejik" aria-selected="false">Stratejik</button>
                            </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-kredit" role="tabpanel" aria-labelledby="nav-kredit-tab">

                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                
                                                <div class="card-body">
                                                <h4 class="header-title">Kredit Inheren</h4>



                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko Inhern (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pelanggaran Terhadap Peraturan Perundang-Undangan Dan Kententuan Lain</b></td>
                                                                            <td><select class="form-select" id="inheren_kre_set_pil1" form="my_form" name="inheren_kre_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kre['inheren_kre_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kre['inheren_kre_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kre['inheren_kre_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Faktor Kelemahan Aspek Hukum</b></td>
                                                                            <td><select class="form-select" id="inheren_kre_set_pil2" form="my_form" name="inheren_kre_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kre['inheren_kre_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kre['inheren_kre_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kre['inheren_kre_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Lainnya</b></td>

                                                                            <td><select class="form-select" id="inheren_kre_set_pil3" form="my_form" name="inheren_kre_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kre['inheren_kre_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kre['inheren_kre_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kre['inheren_kre_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_kre_set_tingkat_risiko" form="my_form" name="inheren_kre_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kre['inheren_kre_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kre['inheren_kre_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kre['inheren_kre_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->


                                        </div><!-- end col-->


                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Kredit KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_kre_set_pil1" form="my_form" name="kpmr_kre_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kre['kpmr_kre_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kre['kpmr_kre_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kre['kpmr_kre_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_kre_set_pil2" form="my_form" name="kpmr_kre_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kre['kpmr_kre_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kre['kpmr_kre_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kre['kpmr_kre_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_kre_set_pil3" form="my_form" name="kpmr_kre_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kre['kpmr_kre_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kre['kpmr_kre_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kre['kpmr_kre_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>ilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_kre_set_pil4" form="my_form" name="kpmr_kre_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kre['kpmr_kre_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kre['kpmr_kre_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kre['kpmr_kre_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_kre_set_tingkat_risiko" form="my_form" name="kpmr_kre_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kre['kpmr_kre_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kre['kpmr_kre_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kre['kpmr_kre_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-operasional" role="tabpanel" aria-labelledby="nav-operasional-tab">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                
                                                <div class="card-body">
                                                <h4 class="header-title">Operasional Inheren</h4>



                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko Inhern (Per Pilar & Parameter)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Kompleksitas Bisnis dan Kelembagaan</b></td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil1" form="my_form" name="inheren_op_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Skala usaha dan struktur organisasi</td>
                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Jaringak kantor, rentang kendali dan lokasi kantor cabang</td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil1_par2" form="my_form" name="inheren_op_set_pil1_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil1_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil1_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil1_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Keberagaman produk dan atau jasa</td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil1_par3" form="my_form" name="inheren_op_set_pil1_par3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil1_par3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil1_par3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil1_par3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Tindakan korporasi</td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil1_par4" form="my_form" name="inheren_op_set_pil1_par4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil1_par4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil1_par4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil1_par4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Sumber Daya Manusia (SDM)</b></td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil2" form="my_form" name="inheren_op_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Kecukupan kuantitas dan kualitas SDM</td>
                                                                            <td><select class="form-select" id="inheren_op_set_pil2_par1" form="my_form" name="inheren_op_set_pil2_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil2_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil2_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil2_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Permasalahan operasional karena faktor manusia</td>
                                                                            <td>-</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Penyelenggaraan Teknologi Informasi (TI)</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Penyelenggaraan Teknologi Informasi (TI)</td>

                                                                            <td><select class="form-select" id="inheren_op_set_pil3_par1" form="my_form" name="inheren_op_set_pil3_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil3_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil3_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil3_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Penyimpangan (Fraud)</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Penyimpangan (Fraud)</td>

                                                                            <td><select class="form-select" id="inheren_op_set_pil4_par1" form="my_form" name="inheren_op_set_pil4_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil4_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil4_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil4_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>5</td>
                                                                            <td><b>Pilar 5 | Faktor Eksternal</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Faktor Eksternal</td>

                                                                            <td><select class="form-select" id="inheren_op_set_pil5_par1" form="my_form" name="inheren_op_set_pil5_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil5_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil5_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil5_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>6</td>
                                                                            <td><b>Pilar 6 | Lainnya</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Lainnya</td>

                                                                            <td><select class="form-select" id="inheren_op_set_pil6_par1" form="my_form" name="inheren_op_set_pil6_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_pil6_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_pil6_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_pil6_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_op_set_tingkat_risiko" form="my_form" name="inheren_op_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_op['inheren_op_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_op['inheren_op_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_op['inheren_op_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->


                                        </div><!-- end col-->


                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Operasional KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_op_set_pil1" form="my_form" name="kpmr_op_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_op['kpmr_op_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_op['kpmr_op_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_op['kpmr_op_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_op_set_pil2" form="my_form" name="kpmr_op_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_op['kpmr_op_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_op['kpmr_op_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_op['kpmr_op_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_op_set_pil3" form="my_form" name="kpmr_op_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_op['kpmr_op_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_op['kpmr_op_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_op['kpmr_op_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_op_set_pil4" form="my_form" name="kpmr_op_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_op['kpmr_op_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_op['kpmr_op_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_op['kpmr_op_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_op_set_tingkat_risiko" form="my_form" name="kpmr_op_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_op['kpmr_op_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_op['kpmr_op_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_op['kpmr_op_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-kepatuhan" role="tabpanel" aria-labelledby="nav-kepatuhan-tab">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Kepatuhan Inheren</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko inheren (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pelanggaran Terhadap Peraturan Perundang-undangan dan Ketentuan Lain</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil1" form="my_form" name="inheren_kep_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Jenis, siknifikasi, dan frekuensi pelanggaran yang dilakukan</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil1_par1" form="my_form" name="inheren_kep_set_pil1_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil1_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil1_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil1_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Signifikasi tindak lanjut atas temuan pelanggaran</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil1_par2" form="my_form" name="inheren_kep_set_pil1_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil1_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil1_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil1_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Faktor Kelemahan Aspek Hukum</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil2" form="my_form" name="inheren_kep_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Kelemahan dalam perikatan</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil2_par1" form="my_form" name="inheren_kep_set_pil2_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil2_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil2_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil2_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Litigasi terkait nominal gugatan atau estimasi kerugian yang dialami BPR akibat gugatan</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil2_par2" form="my_form" name="inheren_kep_set_pil2_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil2_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil2_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil2_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Litigasi terkait kerugian yang dialami karena putusan pengadilan berkekuatan hukum tetap</b></td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil2_par3" form="my_form" name="inheren_kep_set_pil2_par3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil2_par3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil2_par3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil2_par3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Lainnya</b></td>
                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Lainnya</td>
                                                                            <td><select class="form-select" id="inheren_kep_set_pil3_par1" form="my_form" name="inheren_kep_set_pil3_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_pil3_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_pil3_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_pil3_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_kep_set_tingkat_risiko" form="my_form" name="inheren_kep_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_kep['inheren_kep_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_kep['inheren_kep_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_kep['inheren_kep_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->

                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Kepatuhan KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_kep_set_pil1" form="my_form" name="kpmr_kep_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kep['kpmr_kep_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kep['kpmr_kep_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kep['kpmr_kep_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_kep_set_pil2" form="my_form" name="kpmr_kep_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kep['kpmr_kep_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kep['kpmr_kep_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kep['kpmr_kep_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_kep_set_pil3" form="my_form" name="kpmr_kep_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kep['kpmr_kep_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kep['kpmr_kep_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kep['kpmr_kep_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_kep_set_pil4" form="my_form" name="kpmr_kep_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kep['kpmr_kep_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kep['kpmr_kep_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kep['kpmr_kep_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_kep_set_tingkat_risiko" form="my_form" name="kpmr_kep_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_kep['kpmr_kep_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_kep['kpmr_kep_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_kep['kpmr_kep_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-likuiditas" role="tabpanel" aria-labelledby="nav-likuiditas-tab">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                
                                                <div class="card-body">
                                                <h4 class="header-title">Likuiditas Inheren</h4>



                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko Inhern (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Komposisi dan Konsentrasi Aset dan Kewajiban</b></td>
                                                                            <td><select class="form-select" id="inheren_lik_set_pil1" form="my_form" name="inheren_lik_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_lik['inheren_lik_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_lik['inheren_lik_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_lik['inheren_lik_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber</b></td>
                                                                            <td><select class="form-select" id="inheren_lik_set_pil2" form="my_form" name="inheren_lik_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_lik['inheren_lik_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_lik['inheren_lik_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_lik['inheren_lik_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Lainnya</b></td>

                                                                            <td><select class="form-select" id="inheren_lik_set_pil3" form="my_form" name="inheren_lik_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_lik['inheren_lik_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_lik['inheren_lik_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_lik['inheren_lik_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_lik_set_tingkat_risiko" form="my_form" name="inheren_lik_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_lik['inheren_lik_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_lik['inheren_lik_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_lik['inheren_lik_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->

                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Likuiditas KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_lik_set_pil1" form="my_form" name="kpmr_lik_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_lik['kpmr_lik_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_lik['kpmr_lik_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_lik['kpmr_lik_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_lik_set_pil2" form="my_form" name="kpmr_lik_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_lik['kpmr_lik_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_lik['kpmr_lik_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_lik['kpmr_lik_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_lik_set_pil3" form="my_form" name="kpmr_lik_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_lik['kpmr_lik_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_lik['kpmr_lik_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_lik['kpmr_lik_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_lik_set_pil4" form="my_form" name="kpmr_lik_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_lik['kpmr_lik_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_lik['kpmr_lik_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_lik['kpmr_lik_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_lik_set_tingkat_risiko" form="my_form" name="kpmr_lik_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_lik['kpmr_lik_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_lik['kpmr_lik_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_lik['kpmr_lik_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-reputasi" role="tabpanel" aria-labelledby="nav-reputasi-tab">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                
                                                <div class="card-body">
                                                <h4 class="header-title">Reputasi Inheren</h4>



                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko Inhern (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengaruh Reputasi Pihak yang Berasosiasi Dengan BPR</b></td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil1" form="my_form" name="inheren_rep_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Kredibilitas BPR dan pihak yang berasosiasi dengan BPR</td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil1_par1" form="my_form" name="inheren_rep_set_pil1_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil1_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil1_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil1_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Signifikasi dan materialitas dampak yang ditimbulkan akibat kejadian reputasi</td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil1_par2" form="my_form" name="inheren_rep_set_pil1_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil1_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil1_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil1_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Frekuensi dan Signifikasi Pengaduan Nasabah</b></td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil2" form="my_form" name="inheren_rep_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Administratsi dan tindak lanjut pengaduan nasabah</td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil2_par1" form="my_form" name="inheren_rep_set_pil2_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil2_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil2_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil2_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Signifikasi dan materialitas pengaduan nasabah</td>
                                                                            <td><select class="form-select" id="inheren_rep_set_pil2_par2" form="my_form" name="inheren_rep_set_pil2_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil2_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil2_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil2_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Pelanggaran Etika Bisnis</b></td>

                                                                            <td><select class="form-select" id="inheren_rep_set_pil3" form="my_form" name="inheren_rep_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Transparansi informasi keuangan</td>

                                                                            <td><select class="form-select" id="inheren_rep_set_pil3_par1" form="my_form" name="inheren_rep_set_pil3_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil3_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil3_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil3_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Transparansi produk dan layanan BPR</td>

                                                                            <td><select class="form-select" id="inheren_rep_set_pil3_par2" form="my_form" name="inheren_rep_set_pil3_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil3_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil3_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil3_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Lainnya</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Faktor Lainnya</b></td>

                                                                            <td><select class="form-select" id="inheren_rep_set_pil4_par1" form="my_form" name="inheren_rep_set_pil4_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_pil4_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_pil4_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_pil4_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_rep_set_tingkat_risiko" form="my_form" name="inheren_rep_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_rep['inheren_rep_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_rep['inheren_rep_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_rep['inheren_rep_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->

                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Reputasi KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_rep_set_pil1" form="my_form" name="kpmr_rep_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_rep['kpmr_rep_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_rep['kpmr_rep_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_rep['kpmr_rep_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_rep_set_pil2" form="my_form" name="kpmr_rep_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_rep['kpmr_rep_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_rep['kpmr_rep_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_rep['kpmr_rep_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_rep_set_pil3" form="my_form" name="kpmr_rep_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_rep['kpmr_rep_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_rep['kpmr_rep_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_rep['kpmr_rep_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_rep_set_pil4" form="my_form" name="kpmr_rep_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_rep['kpmr_rep_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_rep['kpmr_rep_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_rep['kpmr_rep_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_rep_set_tingkat_risiko" form="my_form" name="kpmr_rep_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_rep['kpmr_rep_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_rep['kpmr_rep_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_rep['kpmr_rep_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-stratejik" role="tabpanel" aria-labelledby="nav-stratejik-tab">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="card">
                                                
                                                <div class="card-body">
                                                <h4 class="header-title">Stratejik Inheren</h4>



                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko Inhern (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Penetapan Strategi Bisnis</b></td>
                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Penetapan strategi bisnis</td>
                                                                            <td><select class="form-select" id="inheren_stra_set_pil1_par1" form="my_form" name="inheren_stra_set_pil1_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil1_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil1_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil1_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Penyusunan Rencana Bisnis</b></td>
                                                                            <td><select class="form-select" id="inheren_stra_set_pil2" form="my_form" name="inheren_stra_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis</td>
                                                                            <td><select class="form-select" id="inheren_stra_set_pil2_par1" form="my_form" name="inheren_stra_set_pil2_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil2_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil2_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil2_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Keunggulan kompetitif BPR dan ancaman dari kompetitor</td>
                                                                            <td><select class="form-select" id="inheren_stra_set_pil2_par2" form="my_form" name="inheren_stra_set_pil2_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil2_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil2_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil2_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Pencapaian Target Bisnis</b></td>

                                                                            <td><select class="form-select" id="inheren_stra_set_pil3" form="my_form" name="inheren_stra_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan</td>

                                                                            <td><select class="form-select" id="inheren_stra_set_pil3_par1" form="my_form" name="inheren_stra_set_pil3_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil3_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil3_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil3_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td>Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan</td>

                                                                            <td><select class="form-select" id="inheren_stra_set_pil3_par2" form="my_form" name="inheren_stra_set_pil3_par2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil3_par2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil3_par2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil3_par2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Lainnya</b></td>

                                                                            <td>-</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td><b>Faktor Lainnya</b></td>

                                                                            <td><select class="form-select" id="inheren_stra_set_pil4_par1" form="my_form" name="inheren_stra_set_pil4_par1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_pil4_par1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_pil4_par1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_pil4_par1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="inheren_stra_set_tingkat_risiko" form="my_form" name="inheren_stra_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $inheren_stra['inheren_stra_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $inheren_stra['inheren_stra_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $inheren_stra['inheren_stra_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->

                                        <div class="col-xl-6">
                                            <div class="card">
                                                <div class="card-body">
                                                <h4 class="header-title">Stratejik KPMR</h4>

                                                    </ul> <!-- end nav-->
                                                    <div class="tab-content">
                                                        <div class="tab-pane show active" id="inverse-borderless-preview">
                                                            <div class="table-responsive-sm">
                                                                <table class="table table-centered mb-0">
                                                                    <thead class="table-info">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Risiko KPMR (Per Pilar)</th>
                                                                            <th>Risiko yang Ditetapkan</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="table-secondary">
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td><b>Pilar 1 | Pengawasan Direksi dan Dewan Komisaris</b></td>
                                                                            <td><select class="form-select" id="kpmr_stra_set_pil1" form="my_form" name="kpmr_stra_set_pil1">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_stra['kpmr_stra_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_stra['kpmr_stra_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_stra['kpmr_stra_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td><b>Pilar 2 | Kecukupan Kebijakan, Prosedur dan Limit</b></td>
                                                                            <td><select class="form-select" id="kpmr_stra_set_pil2" form="my_form" name="kpmr_stra_set_pil2">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_stra['kpmr_stra_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_stra['kpmr_stra_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_stra['kpmr_stra_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td><b>Pilar 3 | Kecukupan Proses dan Sistem</b></td>
                                                                            <td><select class="form-select" id="kpmr_stra_set_pil3" form="my_form" name="kpmr_stra_set_pil3">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_stra['kpmr_stra_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_stra['kpmr_stra_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_stra['kpmr_stra_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>4</td>
                                                                            <td><b>Pilar 4 | Sistem Pengendalian yang Menyeluruh</b></td>
                                                                            <td><select class="form-select" id="kpmr_stra_set_pil4" form="my_form" name="kpmr_stra_set_pil4">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_stra['kpmr_stra_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_stra['kpmr_stra_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_stra['kpmr_stra_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>
                                                                        

                                                                        <tr>
                                                                            <td colspan="2"><b>Tingkat Risiko</b></td>

                                                                            <td><select class="form-select" id="kpmr_stra_set_tingkat_risiko" form="my_form" name="kpmr_stra_set_tingkat_risiko">
                                                                                <option selected> </option>
                                                                                <option value="1" <?= $kpmr_stra['kpmr_stra_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                                                <option value="2" <?= $kpmr_stra['kpmr_stra_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                                                <option value="3" <?= $kpmr_stra['kpmr_stra_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                                            </select></td>
                                                                        </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div> <!-- end table-responsive-->
                                                        </div> <!-- end preview-->


                                                    </div> <!-- end tab-content-->

                                                </div> <!-- end card body-->
                                            </div> <!-- end card -->
                                        </div><!-- end col-->
                                    </div>
                                </div>
                            </div>


                           
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>

            <!-- end row -->

           
            <!-- end row -->

        </div>
        <!-- container -->

    </div>
    <!-- content -->



</div>