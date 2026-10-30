<?php
$id = $_GET['idbobot'];
require dirname(__DIR__, 2).'/conn/conn.php';

$bobot_kpmr_kredit_per_parameter = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM bobot_kredit_per_parameter WHERE id_bobot = ?", [$id]));


if (isset($_POST['submit'])) {


    //AMbang kredit



    $sub_parameter1 = $_POST['sub_parameter1'];
    $sub_parameter2 = $_POST['sub_parameter2'];
    $sub_parameter3 = $_POST['sub_parameter3'];
    $sub_parameter4 = $_POST['sub_parameter4'];
    $sub_parameter5 = $_POST['sub_parameter5'];
    $sub_parameter6 = $_POST['sub_parameter6'];
    $sub_parameter7 = $_POST['sub_parameter7'];
    $sub_parameter8 = $_POST['sub_parameter8'];
    $sub_parameter2_1 = $_POST['sub_parameter2_1'];
    $sub_parameter2_2 = $_POST['sub_parameter2_2'];
    $sub_parameter2_3 = $_POST['sub_parameter2_3'];
    $sub_parameter2_4 = $_POST['sub_parameter2_4'];
    $sub_parameter2_5 = $_POST['sub_parameter2_5'];
    $sub_parameter2_6 = $_POST['sub_parameter2_6'];
    $sub_parameter2_7 = $_POST['sub_parameter2_7'];
    $sub_parameter2_8 = $_POST['sub_parameter2_8'];
    $sub_parameter2_9 = $_POST['sub_parameter2_9'];
    $sub_parameter2_10 = $_POST['sub_parameter2_10'];
    $sub_parameter2_11 = $_POST['sub_parameter2_11'];
    $sub_parameter3_1 = $_POST['sub_parameter3_1'];
    $sub_parameter3_2 = $_POST['sub_parameter3_2'];
    $sub_parameter3_3 = $_POST['sub_parameter3_3'];
    $sub_parameter3_4 = $_POST['sub_parameter3_4'];
    $sub_parameter3_5 = $_POST['sub_parameter3_5'];
    $sub_parameter3_6 = $_POST['sub_parameter3_6'];
    $sub_parameter4_1 = $_POST['sub_parameter4_1'];
    $sub_parameter4_2 = $_POST['sub_parameter4_2'];
    $sub_parameter4_3 = $_POST['sub_parameter4_3'];
    $sub_parameter4_4 = $_POST['sub_parameter4_4'];
    $sub_parameter5_1 = $_POST['sub_parameter5_1'];
    $sub_parameter6_1 = $_POST['sub_parameter6_1'];
    $sub_parameter6_2 = $_POST['sub_parameter6_2'];
    $sub_parameter6_3 = $_POST['sub_parameter6_3'];
    $sub_parameter6_4 = $_POST['sub_parameter6_4'];
    $sub_parameter7_1 = $_POST['sub_parameter7_1'];
    $sub_parameter7_2 = $_POST['sub_parameter7_2'];
    $sub_parameter7_3 = $_POST['sub_parameter7_3'];
    $sub_parameter7_4 = $_POST['sub_parameter7_4'];
    $sub_parameter7_5 = $_POST['sub_parameter7_5'];
    $sub_parameter7_6 = $_POST['sub_parameter7_6'];
    $sub_parameter7_7 = $_POST['sub_parameter7_7'];
    $sub_parameter7_8 = $_POST['sub_parameter7_8'];
    $sub_parameter7_9 = $_POST['sub_parameter7_9'];
    $sub_parameter7_10 = $_POST['sub_parameter7_10'];
    $sub_parameter7_11 = $_POST['sub_parameter7_11'];



    simpro_db_query($conn, "UPDATE bobot_kredit_per_parameter SET
    sub_parameter1 = ?,
    sub_parameter2 = ?,
    sub_parameter3 = ?,
    sub_parameter4 = ?,
    sub_parameter5 = ?,
    sub_parameter6 = ?,
    sub_parameter7 = ?,
    sub_parameter8 = ?,
    sub_parameter2_1 = ?,
    sub_parameter2_2 = ?,
    sub_parameter2_3 = ?,
    sub_parameter2_4 = ?,
    sub_parameter2_5 = ?,
    sub_parameter2_6 = ?,
    sub_parameter2_7 = ?,
    sub_parameter2_8 = ?,
    sub_parameter2_9 = ?,
    sub_parameter2_10 = ?,
    sub_parameter2_11 = ?,
    sub_parameter3_1 = ?,
    sub_parameter3_2 = ?,
    sub_parameter3_3 = ?,
    sub_parameter3_4 = ?,
    sub_parameter3_5 = ?,
    sub_parameter3_6 = ?,
    sub_parameter4_1 = ?,
    sub_parameter4_2 = ?,
    sub_parameter4_3 = ?,
    sub_parameter4_4 = ?,
    sub_parameter5_1 = ?,
    sub_parameter6_1 = ?,
    sub_parameter6_2 = ?,
    sub_parameter6_3 = ?,
    sub_parameter6_4 = ?,
    sub_parameter7_1 = ?,
    sub_parameter7_2 = ?,
    sub_parameter7_3 = ?,
    sub_parameter7_4 = ?,
    sub_parameter7_5 = ?,
    sub_parameter7_6 = ?,
    sub_parameter7_7 = ?,
    sub_parameter7_8 = ?,
    sub_parameter7_9 = ?,
    sub_parameter7_10 = ?,
    sub_parameter7_11 = ? WHERE id_bobot_kredit_per_parameter = ?", [$sub_parameter1, $sub_parameter2, $sub_parameter3, $sub_parameter4, $sub_parameter5, $sub_parameter6, $sub_parameter7, $sub_parameter8, $sub_parameter2_1, $sub_parameter2_2, $sub_parameter2_3, $sub_parameter2_4, $sub_parameter2_5, $sub_parameter2_6, $sub_parameter2_7, $sub_parameter2_8, $sub_parameter2_9, $sub_parameter2_10, $sub_parameter2_11, $sub_parameter3_1, $sub_parameter3_2, $sub_parameter3_3, $sub_parameter3_4, $sub_parameter3_5, $sub_parameter3_6, $sub_parameter4_1, $sub_parameter4_2, $sub_parameter4_3, $sub_parameter4_4, $sub_parameter5_1, $sub_parameter6_1, $sub_parameter6_2, $sub_parameter6_3, $sub_parameter6_4, $sub_parameter7_1, $sub_parameter7_2, $sub_parameter7_3, $sub_parameter7_4, $sub_parameter7_5, $sub_parameter7_6, $sub_parameter7_7, $sub_parameter7_8, $sub_parameter7_9, $sub_parameter7_10, $sub_parameter7_11, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=bobot_kre&idbobot=$id");
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

                        <h4 class="page-title">Tentukan Bobot Kredit Inhern Dan KPMR</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            
                        <div class="row">

                        <div class="col-xl-12">
                            <div class="btn-group mb-2">
                                <a href="index.php?page=bobot_kre&idbobot=<?= $id?>"><button type="button" class="btn btn-success active">Kredit</button></a>
                   
                                <a href="index.php?page=bobot_lik&idbobot=<?= $id ?>"><button type="button" class="btn btn-danger">Likuiditas</button></a>

                            </div>
                        </div>

                        </div>
                            <h4 class="header-title">Penetapan Bobot Kredit</h4>
                            <p class="text-muted font-13">
                                Bilangan desimal gunakan . contoh : 0.23
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
                            <div class="row">


                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter1, #sub_parameter2, #sub_parameter3, #sub_parameter4, #sub_parameter5, #sub_parameter6, #sub_parameter7, #sub_parameter8").keyup(function() {
                                            var sub_parameter1 = $("#sub_parameter1").val();
                                            var sub_parameter2 = $("#sub_parameter2").val();
                                            var sub_parameter3 = $("#sub_parameter3").val();
                                            var sub_parameter4 = $("#sub_parameter4").val();
                                            var sub_parameter5 = $("#sub_parameter5").val();
                                            var sub_parameter6 = $("#sub_parameter6").val();
                                            var sub_parameter7 = $("#sub_parameter7").val();
                                            var sub_parameter8 = $("#sub_parameter8").val();

                                            var total = parseFloat(sub_parameter1) + parseFloat(sub_parameter2) + parseFloat(sub_parameter3) + parseFloat(sub_parameter4) + parseFloat(sub_parameter5) +
                                                parseFloat(sub_parameter6) + parseFloat(sub_parameter7) + parseFloat(sub_parameter8);
                                            total = total.toFixed(2);
                                            $("#total").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan").click(function() {
                                            var nilai1 = 1 / 8;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter1").val(nilai1);
                                            $("#sub_parameter2").val(nilai1);
                                            $("#sub_parameter3").val(nilai1);
                                            $("#sub_parameter4").val(nilai1);
                                            $("#sub_parameter5").val(nilai1);
                                            $("#sub_parameter6").val(nilai1);
                                            $("#sub_parameter7").val(nilai1);
                                            $("#sub_parameter8").val(nilai1);

                                            $("#total").val(1);

                                        });
                                    });
                                </script>



                                <!--par2-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter2_1, #sub_parameter2_2, #sub_parameter2_3, #sub_parameter2_4, #sub_parameter2_5, #sub_parameter2_6, #sub_parameter2_7, #sub_parameter2_8, #sub_parameter2_9, #sub_parameter2_10, #sub_parameter2_11").keyup(function() {
                                            var sub_parameter2_1 = $("#sub_parameter2_1").val();
                                            var sub_parameter2_2 = $("#sub_parameter2_2").val();
                                            var sub_parameter2_3 = $("#sub_parameter2_3").val();
                                            var sub_parameter2_4 = $("#sub_parameter2_4").val();
                                            var sub_parameter2_5 = $("#sub_parameter2_5").val();
                                            var sub_parameter2_6 = $("#sub_parameter2_6").val();
                                            var sub_parameter2_7 = $("#sub_parameter2_7").val();
                                            var sub_parameter2_8 = $("#sub_parameter2_8").val();
                                            var sub_parameter2_9 = $("#sub_parameter2_9").val();
                                            var sub_parameter2_10 = $("#sub_parameter2_10").val();
                                            var sub_parameter2_11 = $("#sub_parameter2_11").val();

                                            var total = parseFloat(sub_parameter2_1) + parseFloat(sub_parameter2_2) + parseFloat(sub_parameter2_3) + parseFloat(sub_parameter2_4) + parseFloat(sub_parameter2_5) +
                                                parseFloat(sub_parameter2_6) + parseFloat(sub_parameter2_7) + parseFloat(sub_parameter2_8) + parseFloat(sub_parameter2_9) + parseFloat(sub_parameter2_10) + parseFloat(sub_parameter2_11);
                                            total = total.toFixed(2);
                                            $("#total2").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan2").click(function() {
                                            var nilai1 = 1 / 11;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter2_1").val(nilai1);
                                            $("#sub_parameter2_2").val(nilai1);
                                            $("#sub_parameter2_3").val(nilai1);
                                            $("#sub_parameter2_4").val(nilai1);
                                            $("#sub_parameter2_5").val(nilai1);
                                            $("#sub_parameter2_6").val(nilai1);
                                            $("#sub_parameter2_7").val(nilai1);
                                            $("#sub_parameter2_8").val(nilai1);
                                            $("#sub_parameter2_9").val(nilai1);
                                            $("#sub_parameter2_10").val(nilai1);
                                            $("#sub_parameter2_11").val(nilai1);

                                            $("#total2").val(1);

                                        });
                                    });
                                </script>


                                <!--par3-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter3_1, #sub_parameter3_2, #sub_parameter3_3, #sub_parameter3_4, #sub_parameter3_5, #sub_parameter3_6").keyup(function() {
                                            var sub_parameter3_1 = $("#sub_parameter3_1").val();
                                            var sub_parameter3_2 = $("#sub_parameter3_2").val();
                                            var sub_parameter3_3 = $("#sub_parameter3_3").val();
                                            var sub_parameter3_4 = $("#sub_parameter3_4").val();
                                            var sub_parameter3_5 = $("#sub_parameter3_5").val();
                                            var sub_parameter3_6 = $("#sub_parameter3_6").val();

                                            var total = parseFloat(sub_parameter3_1) + parseFloat(sub_parameter3_2) + parseFloat(sub_parameter3_3) + parseFloat(sub_parameter3_4) + parseFloat(sub_parameter3_5) +
                                                parseFloat(sub_parameter3_6);
                                            total = total.toFixed(2);
                                            $("#total3").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan3").click(function() {
                                            var nilai1 = 1 / 6;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter3_1").val(nilai1);
                                            $("#sub_parameter3_2").val(nilai1);
                                            $("#sub_parameter3_3").val(nilai1);
                                            $("#sub_parameter3_4").val(nilai1);
                                            $("#sub_parameter3_5").val(nilai1);
                                            $("#sub_parameter3_6").val(nilai1);

                                            $("#total3").val(1);

                                        });
                                    });
                                </script>

                                <!--par4-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter4_1, #sub_parameter4_2, #sub_parameter4_3, #sub_parameter4_4").keyup(function() {
                                            var sub_parameter4_1 = $("#sub_parameter4_1").val();
                                            var sub_parameter4_2 = $("#sub_parameter4_2").val();
                                            var sub_parameter4_3 = $("#sub_parameter4_3").val();
                                            var sub_parameter4_4 = $("#sub_parameter4_4").val();

                                            var total = parseFloat(sub_parameter4_1) + parseFloat(sub_parameter4_2) + parseFloat(sub_parameter4_3) + parseFloat(sub_parameter4_4);
                                            total = total.toFixed(2);
                                            $("#total4").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan4").click(function() {
                                            var nilai1 = 1 / 4;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter4_1").val(nilai1);
                                            $("#sub_parameter4_2").val(nilai1);
                                            $("#sub_parameter4_3").val(nilai1);
                                            $("#sub_parameter4_4").val(nilai1);

                                            $("#total4").val(1);

                                        });
                                    });
                                </script>

                                <!--par6-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter6_1, #sub_parameter6_2, #sub_parameter6_3, #sub_parameter6_4").keyup(function() {
                                            var sub_parameter6_1 = $("#sub_parameter6_1").val();
                                            var sub_parameter6_2 = $("#sub_parameter6_2").val();
                                            var sub_parameter6_3 = $("#sub_parameter6_3").val();
                                            var sub_parameter6_4 = $("#sub_parameter6_4").val();

                                            var total = parseFloat(sub_parameter6_1) + parseFloat(sub_parameter6_2) + parseFloat(sub_parameter6_3) + parseFloat(sub_parameter6_4);
                                            total = total.toFixed(2);
                                            $("#total6").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan6").click(function() {
                                            var nilai1 = 1 / 4;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter6_1").val(nilai1);
                                            $("#sub_parameter6_2").val(nilai1);
                                            $("#sub_parameter6_3").val(nilai1);
                                            $("#sub_parameter6_4").val(nilai1);

                                            $("#total6").val(1);

                                        });
                                    });
                                </script>

                                <!--par7-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter7_1, #sub_parameter7_2, #sub_parameter7_3, #sub_parameter7_4, #sub_parameter7_5, #sub_parameter7_6, #sub_parameter7_7, #sub_parameter7_8, #sub_parameter7_9, #sub_parameter7_10, #sub_parameter7_11").keyup(function() {
                                            var sub_parameter7_1 = $("#sub_parameter7_1").val();
                                            var sub_parameter7_2 = $("#sub_parameter7_2").val();
                                            var sub_parameter7_3 = $("#sub_parameter7_3").val();
                                            var sub_parameter7_4 = $("#sub_parameter7_4").val();
                                            var sub_parameter7_5 = $("#sub_parameter7_5").val();
                                            var sub_parameter7_6 = $("#sub_parameter7_6").val();
                                            var sub_parameter7_7 = $("#sub_parameter7_7").val();
                                            var sub_parameter7_8 = $("#sub_parameter7_8").val();
                                            var sub_parameter7_9 = $("#sub_parameter7_9").val();
                                            var sub_parameter7_10 = $("#sub_parameter7_10").val();
                                            var sub_parameter7_11 = $("#sub_parameter7_11").val();

                                            var total = parseFloat(sub_parameter7_1) + parseFloat(sub_parameter7_2) + parseFloat(sub_parameter7_3) + parseFloat(sub_parameter7_4) + parseFloat(sub_parameter7_5) +
                                                parseFloat(sub_parameter7_6) + parseFloat(sub_parameter7_7) + parseFloat(sub_parameter7_8) + parseFloat(sub_parameter7_9) + parseFloat(sub_parameter7_10) + parseFloat(sub_parameter7_11);
                                            total = total.toFixed(2);
                                            $("#total7").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan7").click(function() {
                                            var nilai1 = 1 / 11;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter7_1").val(nilai1);
                                            $("#sub_parameter7_2").val(nilai1);
                                            $("#sub_parameter7_3").val(nilai1);
                                            $("#sub_parameter7_4").val(nilai1);
                                            $("#sub_parameter7_5").val(nilai1);
                                            $("#sub_parameter7_6").val(nilai1);
                                            $("#sub_parameter7_7").val(nilai1);
                                            $("#sub_parameter7_8").val(nilai1);
                                            $("#sub_parameter7_9").val(nilai1);
                                            $("#sub_parameter7_10").val(nilai1);
                                            $("#sub_parameter7_11").val(nilai1);

                                            $("#total7").val(1);

                                        });
                                    });
                                </script>







                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <h6 class="header-title"><b>PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">1</th>
                                                                    <th class=" text-center" width="58%"><center>Aset Produktif <hr></hr> Total Aset</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center>Penempatan Bank Lain <hr></hr> Total Aset</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter1'] ?>" class="form-control" id="sub_parameter1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>Aba Pada 1 Bank Tertinggi <hr></hr> Penempatan Bank Lain</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2'] ?>" class="form-control" id="sub_parameter2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>Aba Pada BPR  <hr></hr>  Penempatan Bank Lain</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3'] ?>" class="form-control" id="sub_parameter3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>NOA Kredit fon s/d 150 juta  <hr></hr> NOA KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter4'] ?>" class="form-control" id="sub_parameter4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> <center>Kredit PEP  <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter5" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter5'] ?>" class="form-control" id="sub_parameter5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> <center>Kredit plafond > 350jt <hr></hr> total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter6'] ?>" class="form-control" id="sub_parameter6"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>g.</b> <center>Saldo PPAP <hr></hr>Total Kredit </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7'] ?>" class="form-control" id="sub_parameter7"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>h.</b> <center>AYDA <hr></hr>KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter8" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter8'] ?>" class="form-control" id="sub_parameter8"></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>Total</b></td>

                                                                    <td><input type="number" id="total" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>


                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">2</th>
                                                                    <th class=" text-center" width="58%"><center>Kredit Yang Diberikan <hr></hr> Aset Produktif</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan2">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center> Kredit Skema Potong Gaji <hr></hr> Total kredit</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_1'] ?>" class="form-control" id="sub_parameter2_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>Kredit Musiman (Grace Period) <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_2'] ?>" class="form-control" id="sub_parameter2_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>Kredit Jangka Pendek  <hr></hr>  Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_3'] ?>" class="form-control" id="sub_parameter2_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>Kredit Jangka Menengah  <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_4'] ?>" class="form-control" id="sub_parameter2_4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> <center>Kredit Jangka Panjang <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_5" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_5'] ?>" class="form-control" id="sub_parameter2_5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> <center>Kredit Dengan Agunan Tanah dan Bangunan <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_6" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_6'] ?>" class="form-control" id="sub_parameter2_6"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>g.</b> <center>Kredit Agunan Kendaraan Bermotor <hr></hr>Total KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_7" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_7'] ?>" class="form-control" id="sub_parameter2_7"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>h.</b> <center>Kredit Agunan Kendaraan Roda 2 <hr></hr>Total KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_8" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_8'] ?>" class="form-control" id="sub_parameter2_8"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>i.</b> <center>OSC Produk KUB <hr></hr>Total KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_9" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_9'] ?>" class="form-control" id="sub_parameter2_9"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>j.</b> <center>Kredit Tanpa Agunan <hr></hr>Total KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_10" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_10'] ?>" class="form-control" id="sub_parameter2_10"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>k.</b> <center>Kredit Korporasi (Non Perorangan) <hr></hr>Total KYD </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_11" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter2_11'] ?>" class="form-control" id="sub_parameter2_11"></td>
                                                                </tr>
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total2" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end table-responsive-->
                                                </div> <!-- end preview-->


                                            </div> <!-- end tab-content-->

                                            <h6 class="header-title"><b>PILAR 2 : Kualitas Aset</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">2</th>
                                                                    <th class=" text-center" width="58%"><center>Kredit Bermasalah Neto <hr></hr> Total Kredit</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan3">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center>NPL Kredit plafond s/d 150 juta <hr></hr> Total KYD plafond s/d 150 jt</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_1'] ?>" class="form-control" id="sub_parameter3_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>NPL Kredit plafond diatas 50 juta <hr></hr> Total KYD plafond diatas 50 juta</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_2'] ?>" class="form-control" id="sub_parameter3_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>NPL Kredit Dengan Perikatan APHT  <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_3'] ?>" class="form-control" id="sub_parameter3_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>NPL Kredit Dengan Perikatan SKMHT <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_4'] ?>" class="form-control" id="sub_parameter3_4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> <center>NPL Nilai Agunan Lebih Rendah Dari Baki Debet <hr></hr> Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_5" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_5'] ?>" class="form-control" id="sub_parameter3_5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> <center>Kredit Macet sudah jatuh tempo <hr></hr> Total KYD</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_6" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter3_6'] ?>" class="form-control" id="sub_parameter3_6"></td>
                                                                </tr>
                                                                
                                                                
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>Total</b></td>

                                                                    <td><input type="number" id="total3" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>


                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">3</th>
                                                                    <th class=" text-center"><center>Kredit Kualitas Rendah <hr></hr> Total Kredit</center></th>
                                                                    <th class=" text-center"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan4">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center> Kredit Par 4 <hr></hr> Total Kredit</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter4_1'] ?>" class="form-control" id="sub_parameter4_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>=Kredit DP (PAR 3 + PAR 4 ) <hr></hr> Total kredit</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter4_2'] ?>" class="form-control" id="sub_parameter4_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>NOA FPD 6 Bulan Terakhir  <hr></hr> NOA Ekspansi 6 Bulan Terakhir</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter4_3'] ?>" class="form-control" id="sub_parameter4_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>Nominal FPD 6 Bulan Terakhir <hr></hr> plafond Ekspansi 6 Bulan Terakhir</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter4_4'] ?>" class="form-control" id="sub_parameter4_4"></td>
                                                                </tr>
                                                               
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total4" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end table-responsive-->
                                                </div> <!-- end preview-->


                                            </div> <!-- end tab-content-->

                                            <h6 class="header-title"><b>PILAR 3 : Strategi Penyediaan Dana</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">1</th>
                                                                    <th  width="58%" valign="top">Strategi penyediaan dana</th> 
                                                                    <th class=" text-center" width="40%">SK Limit<input type="text" form="my_form" name="sub_parameter5_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter5_1'] ?>" class="form-control" id="sub_parameter5_1"></th>

                                                                </tr>
                                                            </thead>

                                                        </table>
                                                    </div> <!-- end table-responsive-->
                                                </div> <!-- end preview-->


                                            </div> <!-- end tab-content-->


                                            <h6 class="header-title"><b>PILAR 4 : Faktor Eksternal</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">


                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">3</th>
                                                                    <th width="58%" valign="top">Faktor Eksternal</th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan6">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> Layanan Digital Kompetitor</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter6_1'] ?>" class="form-control" id="sub_parameter6_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b>  Kejadian luar biasa yang berpengaruh terhadap kinerja Bank</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter6_2'] ?>" class="form-control" id="sub_parameter6_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> Persaingan Layanan antar BPR</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter6_3'] ?>" class="form-control" id="sub_parameter6_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> Regulasi Pemerintah</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter6_4'] ?>" class="form-control" id="sub_parameter6_4"></td>
                                                                </tr>
                                                               
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total6" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end table-responsive-->
                                                </div> <!-- end preview-->


                                            </div> <!-- end tab-content-->

                                            <h6 class="header-title"><b>LAINNYA</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">

                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">1</th>
                                                                    <th class=" text-center" width="58%"><center>Faktor lainnya</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan7">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> Kompetensi AO</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_1" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_1'] ?>" class="form-control" id="sub_parameter7_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> Kompetensi Analis</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_2" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_2'] ?>" class="form-control" id="sub_parameter7_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> Komite Kredit</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_3" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_3'] ?>" class="form-control" id="sub_parameter7_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> Keputusan dan Realisasi Kredit</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_4" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_4'] ?>" class="form-control" id="sub_parameter7_4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> Monitoring Penggunaan Dana Kredit</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_5" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_5'] ?>" class="form-control" id="sub_parameter7_5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> Pengawasan Kredit</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_6" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_6'] ?>" class="form-control" id="sub_parameter7_6"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>g.</b> Kecukupan Jumlah SDM Perkreditan</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_7" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_7'] ?>" class="form-control" id="sub_parameter7_7"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>h.</b> Kompetensi SDM Perkreditan</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_8" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_8'] ?>" class="form-control" id="sub_parameter7_8"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>i.</b> Kelengkapan Ketentuan & Pedoman Perkreditan</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_9" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_9'] ?>" class="form-control" id="sub_parameter7_9"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>j.</b> Ketersediaan Sistem Informasi Manajemen</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_10" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_10'] ?>" class="form-control" id="sub_parameter7_10"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>k.</b> Pengawasan Internal (Risk Taking Unit dan
                                                                    Satuan Kerja Pengendalian) di Bidang Perkreditan</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter7_11" value="<?= $bobot_kpmr_kredit_per_parameter['sub_parameter7_11'] ?>" class="form-control" id="sub_parameter7_11"></td>
                                                                </tr>
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total7" class="form-control" placeholder="Total" readonly=""></td>
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