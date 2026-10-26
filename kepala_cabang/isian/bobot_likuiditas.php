<?php
$id = $_GET['idbobot'];
include "../conn/conn.php";

$bobot_kpmr_likuiditas_per_parameter = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM bobot_likuiditas_per_parameter WHERE id_bobot = '$id'"));


if (isset($_POST['submit'])) {


    //AMbang likuiditas



    $sub_parameter2_1 = $_POST['sub_parameter2_1'];
    $sub_parameter2_2 = $_POST['sub_parameter2_2'];
    $sub_parameter2_3 = $_POST['sub_parameter2_3'];
    $sub_parameter2_4 = $_POST['sub_parameter2_4'];
	$sub_parameter2_5 = $_POST['sub_parameter2_5'];
	$sub_parameter2_6 = $_POST['sub_parameter2_6'];
	$sub_parameter2_7 = $_POST['sub_parameter2_7'];
	$sub_parameter2_8 = $_POST['sub_parameter2_8'];
	$sub_parameter2_9 = $_POST['sub_parameter2_9'];
	$sub_parameter3_1 = $_POST['sub_parameter3_1'];
	$sub_parameter3_2 = $_POST['sub_parameter3_2'];
	$sub_parameter3_3 = $_POST['sub_parameter3_3'];
	$sub_parameter3_4 = $_POST['sub_parameter3_4'];
	$sub_parameter4_1 = $_POST['sub_parameter4_1'];
	$sub_parameter4_2 = $_POST['sub_parameter4_2'];
	$sub_parameter4_3 = $_POST['sub_parameter4_3'];
	$sub_parameter4_4 = $_POST['sub_parameter4_4'];
	$sub_parameter5_1 = $_POST['sub_parameter5_1'];
	$sub_parameter5_2 = $_POST['sub_parameter5_2'];
	$sub_parameter5_3 = $_POST['sub_parameter5_3'];
	$sub_parameter6_1 = $_POST['sub_parameter6_1'];
	$sub_parameter6_2 = $_POST['sub_parameter6_2'];
	$sub_parameter6_3 = $_POST['sub_parameter6_3'];
	$sub_parameter6_4 = $_POST['sub_parameter6_4'];
	$sub_parameter6_5 = $_POST['sub_parameter6_5'];
	$sub_parameter6_6 = $_POST['sub_parameter6_6'];



    mysqli_query($conn, "UPDATE bobot_likuiditas_per_parameter SET
    sub_parameter2_1 = '$sub_parameter2_1',
    sub_parameter2_2 = '$sub_parameter2_2',
    sub_parameter2_3 = '$sub_parameter2_3',
    sub_parameter2_4 = '$sub_parameter2_4',
	sub_parameter2_5 = '$sub_parameter2_5',
	sub_parameter2_6 = '$sub_parameter2_6',
	sub_parameter2_7 = '$sub_parameter2_7',
	sub_parameter2_8 = '$sub_parameter2_8',
	sub_parameter2_9 = '$sub_parameter2_9',
	sub_parameter3_1 = '$sub_parameter3_1',
	sub_parameter3_2 = '$sub_parameter3_2',
	sub_parameter3_3 = '$sub_parameter3_3',
	sub_parameter3_4 = '$sub_parameter3_4',
	sub_parameter4_1 = '$sub_parameter4_1',
	sub_parameter4_2 = '$sub_parameter4_2',
	sub_parameter4_3 = '$sub_parameter4_3',
	sub_parameter4_4 = '$sub_parameter4_4',
	sub_parameter5_1 = '$sub_parameter5_1',
	sub_parameter5_2 = '$sub_parameter5_2',
	sub_parameter5_3 = '$sub_parameter5_3',
	sub_parameter6_1 = '$sub_parameter6_1',
	sub_parameter6_2 = '$sub_parameter6_2',
	sub_parameter6_3 = '$sub_parameter6_3',
	sub_parameter6_4 = '$sub_parameter6_4',
	sub_parameter6_5 = '$sub_parameter6_5',
	sub_parameter6_6 = '$sub_parameter6_6' WHERE id_bobot_likuiditas_per_parameter = '$id'");

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

                        <h4 class="page-title">Tentukan Bobot Likuiditas Inhern Dan KPMR</h4>
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
                                <a href="index.php?page=bobot_kre&idbobot=<?= $id?>"><button type="button" class="btn btn-success">Kredit</button></a>
                   
                                <a href="index.php?page=bobot_lik&idbobot=<?= $id ?>"><button type="button" class="btn btn-danger active">Likuiditas</button></a>

                            </div>
                        </div>
                        </div>
                            <h4 class="header-title">Penetapan Bobot Likuiditas</h4>
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





                                <!--par2-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter2_1, #sub_parameter2_2, #sub_parameter2_3, #sub_parameter2_4, #sub_parameter2_5, #sub_parameter2_6, #sub_parameter2_7, #sub_parameter2_8, #sub_parameter2_9").keyup(function() {
                                            var sub_parameter2_1 = $("#sub_parameter2_1").val();
                                            var sub_parameter2_2 = $("#sub_parameter2_2").val();
                                            var sub_parameter2_3 = $("#sub_parameter2_3").val();
                                            var sub_parameter2_4 = $("#sub_parameter2_4").val();
                                            var sub_parameter2_5 = $("#sub_parameter2_5").val();
                                            var sub_parameter2_6 = $("#sub_parameter2_6").val();
                                            var sub_parameter2_7 = $("#sub_parameter2_7").val();
                                            var sub_parameter2_8 = $("#sub_parameter2_8").val();
                                            var sub_parameter2_9 = $("#sub_parameter2_9").val();

                                            var total = parseFloat(sub_parameter2_1) + parseFloat(sub_parameter2_2) + parseFloat(sub_parameter2_3) + parseFloat(sub_parameter2_4) + parseFloat(sub_parameter2_5) +
                                                parseFloat(sub_parameter2_6) + parseFloat(sub_parameter2_7) + parseFloat(sub_parameter2_8) + parseFloat(sub_parameter2_9);
                                            total = total.toFixed(2);
                                            $("#total2").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan2").click(function() {
                                            var nilai1 = 1 / 9;
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

                                            $("#total2").val(1);

                                        });
                                    });
                                </script>


                                <!--par3-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter3_1, #sub_parameter3_2, #sub_parameter3_3, #sub_parameter3_4").keyup(function() {
                                            var sub_parameter3_1 = $("#sub_parameter3_1").val();
                                            var sub_parameter3_2 = $("#sub_parameter3_2").val();
                                            var sub_parameter3_3 = $("#sub_parameter3_3").val();
                                            var sub_parameter3_4 = $("#sub_parameter3_4").val();

                                            var total = parseFloat(sub_parameter3_1) + parseFloat(sub_parameter3_2) + parseFloat(sub_parameter3_3) + parseFloat(sub_parameter3_4);
                                            total = total.toFixed(2);
                                            $("#total3").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan3").click(function() {
                                            var nilai1 = 1 / 4;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter3_1").val(nilai1);
                                            $("#sub_parameter3_2").val(nilai1);
                                            $("#sub_parameter3_3").val(nilai1);
                                            $("#sub_parameter3_4").val(nilai1);

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
                                        $("#sub_parameter5_1, #sub_parameter5_2, #sub_parameter5_3").keyup(function() {
                                            var sub_parameter5_1 = $("#sub_parameter5_1").val();
                                            var sub_parameter5_2 = $("#sub_parameter5_2").val();
                                            var sub_parameter5_3 = $("#sub_parameter5_3").val();

                                            var total = parseFloat(sub_parameter5_1) + parseFloat(sub_parameter5_2) + parseFloat(sub_parameter5_3);
                                            total = total.toFixed(2);
                                            $("#total5").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan5").click(function() {
                                            var nilai1 = 1 / 3;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter5_1").val(nilai1);
                                            $("#sub_parameter5_2").val(nilai1);
                                            $("#sub_parameter5_3").val(nilai1);

                                            $("#total5").val(1);

                                        });
                                    });
                                </script>

                                <!--par7-->

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#sub_parameter6_1, #sub_parameter6_2, #sub_parameter6_3, #sub_parameter6_4, #sub_parameter6_5, #sub_parameter6_6").keyup(function() {
                                            var sub_parameter6_1 = $("#sub_parameter6_1").val();
                                            var sub_parameter6_2 = $("#sub_parameter6_2").val();
                                            var sub_parameter6_3 = $("#sub_parameter6_3").val();
                                            var sub_parameter6_4 = $("#sub_parameter6_4").val();
                                            var sub_parameter6_5 = $("#sub_parameter6_5").val();
                                            var sub_parameter6_6 = $("#sub_parameter6_6").val();
                                           

                                            var total = parseFloat(sub_parameter6_1) + parseFloat(sub_parameter6_2) + parseFloat(sub_parameter6_3) + parseFloat(sub_parameter6_4) + parseFloat(sub_parameter6_5) +
                                                parseFloat(sub_parameter6_6);
                                            total = total.toFixed(2);
                                            $("#total6").val(total);
                                        });
                                    });
                                </script>

                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#ratakan6").click(function() {
                                            var nilai1 = 1 / 6;
                                            nilai1 = nilai1.toFixed(5);


                                            $("#sub_parameter6_1").val(nilai1);
                                            $("#sub_parameter6_2").val(nilai1);
                                            $("#sub_parameter6_3").val(nilai1);
                                            $("#sub_parameter6_4").val(nilai1);
                                            $("#sub_parameter6_5").val(nilai1);
                                            $("#sub_parameter6_6").val(nilai1);

                                            $("#total6").val(1);

                                        });
                                    });
                                </script>







                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                        <h6 class="header-title"><b>PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">
                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">2</th>
                                                                    <th class=" text-center" width="58%"><center>Aset Likuid <hr></hr> Kewajiban Lancar</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan2">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center>Total Aset Likuid <hr></hr> Pendanaan jangka Pendek</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_1" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_1'] ?>" class="form-control" id="sub_parameter2_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>Aset Likuid <hr></hr> Kewajiban Jangka Pendek</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_2" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_2'] ?>" class="form-control" id="sub_parameter2_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>Arus Kas Netto  <hr></hr>  Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_3" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_3'] ?>" class="form-control" id="sub_parameter2_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>Tabungan  <hr></hr> Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_4" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_4'] ?>" class="form-control" id="sub_parameter2_4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> <center>Deposito Jangka Waktu 3 bln  <hr></hr> Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_5" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_5'] ?>" class="form-control" id="sub_parameter2_5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> <center>Deposito Jangka Waktu 6 bln <hr></hr> Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_6" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_6'] ?>" class="form-control" id="sub_parameter2_6"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>g.</b> <center>Deposito Jangka Waktu 12 bln <hr></hr>Total DPK </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_7" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_7'] ?>" class="form-control" id="sub_parameter2_7"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>h.</b> <center>Modal Disetor <hr></hr>Total DPK </center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_8" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_8'] ?>" class="form-control" id="sub_parameter2_8"></td>
                                                                </tr>

                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>i.</b> <center>Pinjaman<hr></hr>Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter2_9" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter2_9'] ?>" class="form-control" id="sub_parameter2_9"></td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>Total</b></td>

                                                                    <td><input type="number" id="total2" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>

                                                            </tbody>


                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">3</th>
                                                                    <th class=" text-center" width="58%"><center>Kredit Yang Diberikan <hr></hr> Total Dana Pihak Ketiga Bukan Bank</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan3">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center> DPK Yang Dijamin LPS <hr></hr> DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_1" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter3_1'] ?>" class="form-control" id="sub_parameter3_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>Alat Likuid - Kredit Lancar <hr></hr> Dana Pihak Ke 3</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_2" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter3_2'] ?>" class="form-control" id="sub_parameter3_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>Deposito Tenor Sampai Dengan 6 bln  <hr></hr>  Alat Likuid</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_3" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter3_3'] ?>" class="form-control" id="sub_parameter3_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>Pertumbuhan Kredit  <hr></hr> Pertumbuhan Simpanan</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter3_4" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter3_4'] ?>" class="form-control" id="sub_parameter3_4"></td>
                                                                </tr>
                                                                
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total3" class="form-control" placeholder="Total" readonly=""></td>
                                                                </tr>



                                                                <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">5</th>
                                                                    <th class=" text-center" width="58%"><center>Pendanaan Non Inti <hr></hr> Total Pendanaan</center></th>
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan4">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> <center> Pendanaan Non Inti-Alat Likuid <hr></hr> Total Aset-Aset Likuid</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_1" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter4_1'] ?>" class="form-control" id="sub_parameter4_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> <center>Deposito Rate Spesial <hr></hr> Alat Likuid</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_2" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter4_2'] ?>" class="form-control" id="sub_parameter4_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> <center>Aset Likuid  <hr></hr> Pendanaan Non Inti</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_3" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter4_3'] ?>" class="form-control" id="sub_parameter4_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> <center>Deposito Inti (100 Deposan) <hr></hr> Total DPK</center></td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter4_4" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter4_4'] ?>" class="form-control" id="sub_parameter4_4"></td>
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

                                            <h6 class="header-title"><b>PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan</b></h6>
                                            <div class="tab-content">
                                                <div class="tab-pane show active" id="inverse-borderless-preview">
                                                    <div class="table-responsive-sm">
                                                        <table class="table table-bordered table-top mb-5">


                                                            <thead class="table-info">
                                                                <tr>
                                                                    <th class=" text-center" valign="top" width="2%">3</th>
                                                                    <th class=" text-center"><center>Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan</center></th>
                                                                    <th class=" text-center"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan5">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> Sumber Pendanaan Untuk Memenuhi Kebutuhan Likuiditas</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter5_1" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter5_1'] ?>" class="form-control" id="sub_parameter5_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> Identifikasi Terhadap Produk Kredit dan Simpanan</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter5_2" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter5_2'] ?>" class="form-control" id="sub_parameter5_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> Identifikasi Sumber Pendanaan Non Inti</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter5_3" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter5_3'] ?>" class="form-control" id="sub_parameter5_3"></td>
                                                                </tr>
                                                               
                                                               
                                                                
                                                                <tr><td ></td>
                                                                    <td ><b>Total</b></td>

                                                                    <td><input type="number" id="total5" class="form-control" placeholder="Total" readonly=""></td>
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
                                                                    <th class=" text-center" width="40%"><center>Bobot(%) <button class="btn btn-lighten" id="ratakan6">Ratakan</button></center></th>

                                                                </tr>
                                                            </thead>
                                                            <tbody class="table-secondary">
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>a.</b> Penyusunan Profil Maturitas</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_1" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_1'] ?>" class="form-control" id="sub_parameter6_1"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>b.</b> Penyusunan Proyeksi Arus Kas</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_2" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_2'] ?>" class="form-control" id="sub_parameter6_2"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>c.</b> Penyusunan Stress Testing Kemampuan Likuiditas</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_3" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_3'] ?>" class="form-control" id="sub_parameter6_3"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>d.</b> Identifikasi Risk Events yang Mempengaruhi
                                                                    Kemampuan Likuiditas yang Bersumber dari Eksternal</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_4" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_4'] ?>" class="form-control" id="sub_parameter6_4"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>e.</b> Identifikasi dan Evaluasi terhadap Jenis
                                                                    Risiko lain yang meningkatkan risiko likuiditas</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_5" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_5'] ?>" class="form-control" id="sub_parameter6_5"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><b>f.</b> Monitoring Tingkat Suku Bunga Pasar</td>
                                                                    <td><input type="text" form="my_form" name="sub_parameter6_6" value="<?= $bobot_kpmr_likuiditas_per_parameter['sub_parameter6_6'] ?>" class="form-control" id="sub_parameter6_6"></td>
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