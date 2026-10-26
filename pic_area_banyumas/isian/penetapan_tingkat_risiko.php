<?php

if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $tahun = $_POST['tahun'];
    $periode = $_POST['periode'];
    $user = $_POST['user'];

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $query = mysqli_query($conn, "SELECT * FROM frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' ");
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {

        mysqli_query($conn, "INSERT INTO frame_setting_risiko_ditetapkan(id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by,dibuat_at)
        VALUES ('0','$tahun','$periode','$user','$dibuat_by','$dibuat_at')");


        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_kredit(id_setting_risiko_inheren_kredit,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_kredit(id_setting_risiko_kpmr_kredit,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        

        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_operasional(id_setting_risiko_inheren_operasional,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_operasional(id_setting_risiko_kpmr_operasional,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        

        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_kepatuhan(id_setting_risiko_inheren_kepatuhan,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_kepatuhan(id_setting_risiko_kpmr_kepatuhan,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        

        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_likuiditas(id_setting_risiko_inheren_likuiditas,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_likuiditas(id_setting_risiko_kpmr_likuiditas,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        

        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_reputasi(id_setting_risiko_inheren_reputasi,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_reputasi(id_setting_risiko_kpmr_reputasi,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        

        mysqli_query($conn, "INSERT INTO setting_risiko_inheren_stratejik(id_setting_risiko_inheren_stratejik,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");

        mysqli_query($conn, "INSERT INTO setting_risiko_kpmr_stratejik(id_setting_risiko_kpmr_stratejik,id_frame_setris_ditetapkan,tahun,periode,user,dibuat_by)
        VALUES ('0',(select id_frame_setris_ditetapkan from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select tahun from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select periode from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select user from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ),(select dibuat_by from frame_setting_risiko_ditetapkan WHERE tahun = '$tahun' AND periode = '$periode' AND user = '$user' AND dibuat_by = '$dibuat_by' AND dibuat_at = '$dibuat_at' ))");
        
        
        
        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=setris");
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

                        <h4 class="page-title">Setting Tingkat Risiko Yang Ditetapkan</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-4">
                                       
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

                                    <div class="col-4">
                                       
                                        <div class="mb-3">
                                            <label for="periode" class="form-label">Masukan periode pelaporan</label>
                                           
                                            <select class="form-select mb-3" name="periode" id="periode" required="">
                                            <option value=" " selected> </option>
                                                        <?php
                                                        include "../conn/conn.php";
                                                        $query_periode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko");
                                                        while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                            <option value="<?= $data['id_periode'] ?>"><?= ucwords($data['periode_laporan']) ?></option>
                                                        <?php
                                                        };
                                                        ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        
                                        <div class="mb-3">
                                            <label for="user" class="form-label">Settingan ditetapkan untuk user :</label>

                                            <select class="form-select mb-3" name="user" id="user" required="">
                                            <option value=" " selected> </option>
                                                        <?php
                                                        include "../conn/conn.php";
                                                        $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko");
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
                                    <table id="row-callback-datatable" class="table dt-responsive nowrap">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>
                                                <th>
                                                    <center>User</center>
                                                </th>
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Isi Setingan</center>
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
                                            $query = mysqli_query($conn, "SELECT * FROM frame_setting_risiko_ditetapkan
                                            INNER JOIN periode_laporan_profil_risiko ON frame_setting_risiko_ditetapkan.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN user_profil_risiko ON frame_setting_risiko_ditetapkan.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_setting_risiko_ditetapkan.dibuat_by = user.user_id");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['periode_laporan'] ?></center>
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
                                                            <a href="index.php?page=set_pentapan&id=<?= $data['id_frame_setris_ditetapkan'] ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a>
                                                        </center>
                                                    </td>

                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=delete_set_dit&id=<?= $data['id_frame_setris_ditetapkan'] ?>"><i class=" mdi mdi-delete"></i>hapus</a>
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