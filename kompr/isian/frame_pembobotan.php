<?php

if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $tahun = $_POST['tahun'];
    $user = $_POST['user'];

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT * FROM frame_bobot WHERE tahun = '$tahun' AND user ='$user'");
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {

        mysqli_query($conn, "INSERT INTO frame_bobot(id_bobot,tahun,user,dibuat_at,dibuat_by)
        VALUES ('0','$tahun','$user','$dibuat_at','$dibuat_by')");





        mysqli_query($conn, "INSERT INTO bobot_kredit_per_pilar(id_bobot_kredit_per_pilar,id_bobot,tahun,dibuat_at,dibuat_by)
        VALUES ('0',(select id_bobot from frame_bobot WHERE dibuat_by = '$dibuat_by' AND tahun = '$tahun' AND dibuat_at = '$dibuat_at' ),'$tahun','$dibuat_at','$dibuat_by')");

        mysqli_query($conn, "INSERT INTO bobot_kredit_per_parameter(id_bobot_kredit_per_parameter,id_bobot,tahun,dibuat_at,dibuat_by)
        VALUES ('0',(select id_bobot from frame_bobot WHERE dibuat_by = '$dibuat_by' AND tahun = '$tahun' AND dibuat_at = '$dibuat_at' ),'$tahun','$dibuat_at','$dibuat_by')");


   
        mysqli_query($conn, "INSERT INTO bobot_likuiditas_per_pilar(id_bobot_likuiditas_per_pilar,id_bobot,tahun,dibuat_at,dibuat_by)
        VALUES ('0',(select id_bobot from frame_bobot WHERE dibuat_by = '$dibuat_by' AND tahun = '$tahun' AND dibuat_at = '$dibuat_at' ),'$tahun','$dibuat_at','$dibuat_by')");

        mysqli_query($conn, "INSERT INTO bobot_likuiditas_per_parameter(id_bobot_likuiditas_per_parameter,id_bobot,tahun,dibuat_at,dibuat_by)
        VALUES ('0',(select id_bobot from frame_bobot WHERE dibuat_by = '$dibuat_by' AND tahun = '$tahun' AND dibuat_at = '$dibuat_at' ),'$tahun','$dibuat_at','$dibuat_by')");


        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=bobot");
        exit();
    }
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

                        <h4 class="page-title">Penetapan Bobot Faktor</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                    <label class="form-label" for="validationCustom01">
                                        <span>PENETAPAN BOBOT </span>
                                    </label>
                                    <div class="col-6">
                                       
                                        <div class="mb-3">
                                            <label for="tahun" class="form-label">Masukan tahun</label>
                                            <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                <option value=" " selected> </option>
                                                <option value="2024">2024</option>
                                                <option value="2025">2025</option>
                                                <option value="2026">2026</option>
                                                <option value="2027">2027</option>
                                                <option value="2028">2028</option>
                                                <option value="2029">2029</option>
                                                <option value="2030">2030</option>
                                                <option value="2031">2031</option>
                                                <option value="2032">2032</option>
                                                <option value="2033">2033</option>
                                                <option value="2034">2034</option>
                                                <option value="2035">2035</option>
                                                <option value="2036">2036</option>
                                                <option value="2037">2037</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div class="col-6">
                                        
                                        <div class="mb-3">
                                            <label for="user" class="form-label">Settingan ditetapkan untuk user :</label>

                                            <select class="form-select mb-3" name="user" id="user" required="">
                                            <option value=" " selected> </option>
                                                        <?php
                                                        include "../conn/conn.php";
                                                        $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko WHERE id_user_profil_risiko NOT IN (3)");
                                                        while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                            <option value="<?= $data['id_user_profil_risiko'] ?>"><?= ucwords($data['tipe_user']) ?></option>
                                                        <?php
                                                        };
                                                        ?>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-lg-1 ">
                                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                        </div>

                                    </div>
                                </div>
                            </form>




                            <hr>
                            </hr>


                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="row-callback-datatable" class="table dt-responsive w-100 nowrap">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>


                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Settingan Bobot</center>
                                                </th>
                                                <th>
                                                    <center>Tanggal Ditetapkan</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat Laporan</center>
                                                </th>
                                                <th>
                                                    <center>Isi Bobot Faktor</center>
                                                </th>
                                                <th>
                                                    <center>hapus</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $query = mysqli_query($conn, "SELECT * FROM frame_bobot
                                            INNER JOIN user_profil_risiko ON frame_bobot.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_bobot.dibuat_by = user.user_id WHERE user NOT IN (3) order by id_bobot desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= strtoupper($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= strtoupper($data['nama']) ?></center>
                                                    </td>

                                                    <td>
                                                        <center>
                                                            <a href="index.php?page=bobot_kre&idbobot=<?= $data['id_bobot'] ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a>
                                                        </center>
                                                    </td>

                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=delete_bobot&idbobot=<?= $data['id_bobot'] ?>"><i class=" mdi mdi-delete"></i>hapus</a>
                                                        </center>
                                                    </td>






                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

        </div>
        <!-- container -->











    </div>
    <!-- content -->
</div>