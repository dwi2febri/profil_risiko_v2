<?php
$id = $_GET['idbobot'];
require dirname(__DIR__, 2).'/conn/conn.php';

$bobot_inhern_kepatuhan_per_pilar = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM bobot_kepatuhan_per_pilar WHERE id_bobot = ?", [$id]));
$bobot_kpmr_kepatuhan_per_parameter = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM bobot_kepatuhan_per_parameter WHERE id_bobot = ?", [$id]));


if (isset($_POST['submit'])) {


    //AMbang kredit


    $pilar1 = $_POST['pilar1'];
    $pilar2 = $_POST['pilar2'];
    $lainnya = $_POST['lainnya'];



    $parameter1 = $_POST['parameter1'];
    $parameter2 = $_POST['parameter2'];
    $parameter3 = $_POST['parameter3'];
    $parameter4 = $_POST['parameter4'];
    $parameter5 = $_POST['parameter5'];
    $parameter6 = $_POST['parameter6'];
    $parameter7 = $_POST['parameter7'];
    $parameter8 = $_POST['parameter8'];
    $parameter9 = $_POST['parameter9'];
    $parameter10 = $_POST['parameter10'];
    $parameter11 = $_POST['parameter11'];
    $parameter12 = $_POST['parameter12'];
    $parameter13 = $_POST['parameter13'];
    $parameter14 = $_POST['parameter14'];




    simpro_db_query($conn, "UPDATE bobot_kepatuhan_per_pilar SET 
    pilar1 = ?,
    pilar2 = ?,
    lainnya = ? WHERE id_bobot_kepatuhan_per_pilar = ?", [$pilar1, $pilar2, $lainnya, $id]);





    simpro_db_query($conn, "UPDATE bobot_kepatuhan_per_parameter SET
    parameter1 = ?,
    parameter2 = ?,
    parameter3 = ?,
    parameter4 = ?,
    parameter5 = ?,
    parameter6 = ?,
    parameter7 = ?,
    parameter8 = ?,
    parameter9 = ?,
    parameter10 = ?,
    parameter11 = ?,
    parameter12 = ?,
    parameter13 = ?,
    parameter14 = ?
    WHERE id_bobot_kepatuhan_per_parameter = ?", [$parameter1, $parameter2, $parameter3, $parameter4, $parameter5, $parameter6, $parameter7, $parameter8, $parameter9, $parameter10, $parameter11, $parameter12, $parameter13, $parameter14, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=bobot_lik&idbobot=$id");
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

                        <h4 class="page-title">Tentukan Bobot Kepatuhan Inhern Dan KPMR</h4>
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
                                    <button type="button" class="btn btn-success">Kredit</button>
                                    <button type="button" class="btn btn-primary">Operasional</button>
                                    <button type="button" class="btn btn-warning active">Kepatuhan</button>
                                    <button type="button" class="btn btn-danger">Likuiditas</button>
                                    <button type="button" class="btn btn-info">Reputasi</button>
                                    <button type="button" class="btn btn-secondary">Stratejik</button>
                                </div>
                            </div>
                        </div>
                            <h4 class="header-title">Penetapan Bobot Kepatuhan</h4>
                            <p class="text-muted font-13">
                                Isilah Form dibawah ini untuk menetapkan bobot
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
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">




                                            <div class="tab-content">
                                                <button class="btn btn-lighten" id="ratakan1">Ratakan</button>
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-centered mb-0">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Bobot Faktor Risiko Inhern (Per Pilar)</th>
                                                                    <th>Bobot(%)</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Pelanggaran Terhadap Peraturan Perundang-Undangan Dan Kententuan Lain</td>
                                                                    <td><input type="text" form="my_form" name="pilar1" value="<?= $bobot_inhern_kepatuhan_per_pilar['pilar1'] ?>" class="form-control" id="pilar1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Faktor Kelemahan Aspek Hukum</td>

                                                                    <td><input type="text" form="my_form" name="pilar2" value="<?= $bobot_inhern_kepatuhan_per_pilar['pilar2'] ?>" class="form-control" id="pilar2"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Lainnya</td>

                                                                    <td><input type="text" form="my_form" name="lainnya" value="<?= $bobot_inhern_kepatuhan_per_pilar['lainnya'] ?>" class="form-control" id="lainnya"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2"><b>Total</b></td>

                                                                    <td><input type="number" id="total" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div> <!-- end table-responsive-->
                                                </div> <!-- end preview-->


                                            </div> <!-- end tab-content-->

                                        </div> <!-- end card body-->
                                    </div> <!-- end card -->


                                </div><!-- end col-->
                                <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#pilar1, #pilar2, #lainnya").keyup(function() {
                                            var pilar1 = $("#pilar1").val();
                                            var pilar2 = $("#pilar2").val();
                                            var lainnya = $("#lainnya").val();

                                            var total = parseFloat(pilar1) + parseFloat(pilar2) + parseFloat(lainnya);
                                            total = total.toFixed(2);
                                            $("#total").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan1").click(function() {



                                            $("#pilar1").val(33.33);
                                            $("#pilar2").val(33.33);
                                            $("#lainnya").val(33.34);
                                            $("#total").val(100);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#parameter1, #parameter2, #parameter3, #parameter4, #parameter5, #parameter6, #parameter7, #parameter8, #parameter9, #parameter10, #parameter11, #parameter12, #parameter13, #parameter14").keyup(function() {
                                            var parameter1 = $("#parameter1").val();
                                            var parameter2 = $("#parameter2").val();
                                            var parameter3 = $("#parameter3").val();
                                            var parameter4 = $("#parameter4").val();
                                            var parameter5 = $("#parameter5").val();
                                            var parameter6 = $("#parameter6").val();
                                            var parameter7 = $("#parameter7").val();
                                            var parameter8 = $("#parameter8").val();
                                            var parameter9 = $("#parameter9").val();
                                            var parameter10 = $("#parameter10").val();
                                            var parameter11 = $("#parameter11").val();
                                            var parameter12 = $("#parameter12").val();
                                            var parameter13 = $("#parameter13").val();
                                            var parameter14 = $("#parameter14").val();

                                            var total = parseFloat(parameter1) + parseFloat(parameter2) + parseFloat(parameter3) + parseFloat(parameter4) + parseFloat(parameter5) +
                                                parseFloat(parameter6) + parseFloat(parameter7) + parseFloat(parameter8) + parseFloat(parameter9) + parseFloat(parameter10) + parseFloat(parameter11) +
                                                parseFloat(parameter12) + parseFloat(parameter13) + parseFloat(parameter14);
                                            total = total.toFixed(2);
                                            $("#total2").val(total);
                                        });
                                    });
                                </script>



                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan2").click(function() {



                                            $("#parameter1").val(7.14);
                                            $("#parameter2").val(7.14);
                                            $("#parameter3").val(7.14);
                                            $("#parameter4").val(7.14);
                                            $("#parameter5").val(7.14);
                                            $("#parameter6").val(7.14);
                                            $("#parameter7").val(7.14);
                                            $("#parameter8").val(7.14);
                                            $("#parameter9").val(7.14);
                                            $("#parameter10").val(7.14);
                                            $("#parameter11").val(7.14);
                                            $("#parameter12").val(7.14);
                                            $("#parameter13").val(7.14);
                                            $("#parameter14").val(7.18);

                                            $("#total2").val(100);

                                        });
                                    });
                                </script>









                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-body">


                                            </ul> <!-- end nav-->
                                            <div class="tab-content">
                                                <button class="btn btn-lighten" id="ratakan2">Ratakan</button>
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-centered mb-0">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th>Bobot Faktor Risiko Inhern (Per Parameter)</th>
                                                                    <th>Bobot(%)</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td>1</td>
                                                                    <td>Parameter 1</td>
                                                                    <td><input type="text" form="my_form" name="parameter1" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter1'] ?>" class="form-control" id="parameter1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2</td>
                                                                    <td>Parameter 2</td>
                                                                    <td><input type="text" form="my_form" name="parameter2" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter2'] ?>" class="form-control" id="parameter2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>3</td>
                                                                    <td>Parameter 3</td>
                                                                    <td><input type="text" form="my_form" name="parameter3" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter3'] ?>" class="form-control" id="parameter3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>4</td>
                                                                    <td>Parameter 4</td>
                                                                    <td><input type="text" form="my_form" name="parameter4" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter4'] ?>" class="form-control" id="parameter4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>5</td>
                                                                    <td>Parameter 5</td>
                                                                    <td><input type="text" form="my_form" name="parameter5" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter5'] ?>" class="form-control" id="parameter5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>6</td>
                                                                    <td>Parameter 6</td>
                                                                    <td><input type="text" form="my_form" name="parameter6" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter6'] ?>" class="form-control" id="parameter6"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>7</td>
                                                                    <td>Parameter 7</td>
                                                                    <td><input type="text" form="my_form" name="parameter7" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter7'] ?>" class="form-control" id="parameter7"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>8</td>
                                                                    <td>Parameter 8</td>
                                                                    <td><input type="text" form="my_form" name="parameter8" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter8'] ?>" class="form-control" id="parameter8"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>9</td>
                                                                    <td>Parameter 9</td>
                                                                    <td><input type="text" form="my_form" name="parameter9" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter9'] ?>" class="form-control" id="parameter9"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>10</td>
                                                                    <td>Parameter 10</td>
                                                                    <td><input type="text" form="my_form" name="parameter10" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter10'] ?>" class="form-control" id="parameter10"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>11</td>
                                                                    <td>Parameter 11</td>
                                                                    <td><input type="text" form="my_form" name="parameter11" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter11'] ?>" class="form-control" id="parameter11"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>12</td>
                                                                    <td>Parameter 12</td>
                                                                    <td><input type="text" form="my_form" name="parameter12" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter12'] ?>" class="form-control" id="parameter12"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>13</td>
                                                                    <td>Parameter 13</td>
                                                                    <td><input type="text" form="my_form" name="parameter13" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter13'] ?>" class="form-control" id="parameter13"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>14</td>
                                                                    <td>Parameter 14</td>
                                                                    <td><input type="text" form="my_form" name="parameter14" value="<?= $bobot_kpmr_kepatuhan_per_parameter['parameter14'] ?>" class="form-control" id="parameter14"></td>
                                                                </tr>


                                                                <tr>
                                                                    <td colspan="2"><b>Total</b></td>

                                                                    <td><input type="number" id="total2" class="form-control" placeholder="Total" readonly=""></td>
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