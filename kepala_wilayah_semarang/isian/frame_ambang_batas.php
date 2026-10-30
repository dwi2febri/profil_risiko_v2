<?php

if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';
    $tahun = $_POST['tahun'];

    $dibuat_at = date('Y-m-d');
    $dibuat_by = $_SESSION['user_id'];
    $query = simpro_db_query($conn, "SELECT * FROM ambang_batas_kredit WHERE tahun = ? ", [$tahun]);
    $cek_user = mysqli_num_rows($query);
    if ($cek_user > 0) {
        echo '
        <script>$.NotificationApp.send("Gagal","Your awesome message text","Position","Background color","Icon")</script>
        ';
    } else {
        simpro_db_query($conn, "INSERT INTO ambang_batas_kredit(id_ambang_batas_kredit,tahun,dibuat_at,dibuat_by)
        VALUES ('0',?,?,?)", [$tahun, $dibuat_at, $dibuat_by]);

        simpro_db_query($conn, "INSERT INTO ambang_batas_likuiditas(id_ambang_batas_likuiditas,tahun,dibuat_at,dibuat_by)
        VALUES ('0',?,?,?)", [$tahun, $dibuat_at, $dibuat_by]);

        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=frame_ambang");
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

                        <h4 class="page-title">Penetapan Ambang Batas Kredit Dan Likuiditas</h4>
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
                                        <span>MASUKAN TAHUN PENETAPAN AMBANG BATAS</span>
                                    </label>
                                    <div class="mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
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
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat Laporan</center>
                                                </th>
                                                <th>
                                                    <center>Isi Ambang Batas</center>
                                                </th>
                                                <th>
                                                    <center>hapus</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $query = mysqli_query($conn, "SELECT * FROM ambang_batas_kredit
                                            INNER JOIN user ON ambang_batas_kredit.dibuat_by = user.user_id order by id_ambang_batas_kredit desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>

                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>

                                                    <td>
                                                        <center><?= strtoupper($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= strtoupper($data['nama']) ?></center>
                                                    </td>

                                                    <td>
                                                        <center>
                                                            <a href="index.php?page=ambang&idam=<?= $data['id_ambang_batas_kredit'] ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a>

                                                        </center>
                                                    </td>

                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=delete_ambang&idam=<?= $data['id_ambang_batas_kredit'] ?>"><i class=" mdi mdi-delete"></i>hapus</a>
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