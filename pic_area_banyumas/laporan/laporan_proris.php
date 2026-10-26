

<?php
include "../fungsi/fungsi.php";

?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                            <li class="breadcrumb-item active">Laporan Masuk</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Menu Laporan Profil Risiko</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Laporan Profil Risiko Yang Masuk</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User
                            </p>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                    <center>Kantor Cabang</center>
                                                </th>
                                                <th>
                                                    <center>Tahun</center>
                                                </th>
                                                <th>
                                                    <center>Jenis Profil Risiko</center>
                                                </th>
                                                <th>
                                                    <center>Periode</center>
                                                </th>
                                                <th>
                                                    <center>Modal Inti</center>
                                                </th>
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                                <th>
                                                    <center>Pembuat</center>
                                                </th>
                                                <th>
                                                    <center>Keterangan</center>
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include "../conn/conn.php";
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user.tipe = 'kepala cabang' AND user = '3' AND kantor_cabang IN(15,16,17,18,19,20,21) order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=laporan_masuk&id=<?= $data['id_profil_risiko'] ?>"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled></i> aktifkan</a>
                                                            |
                                                            <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['status_korwil'] == 1) echo 'checked'; ?> disabled></i> konfirmasi</a>
                                                        </center>
                                                    </td>


                                                    <td>
                                                        <center><?= $data['cabang'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= $data['tipe_user'] ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                    <td>
                                                        Rp. <?= rupiah($data['modal_inti']) ?>
                                                    <td>
                                                        Rp. <?= rupiah($data['total_aset']) ?>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= ucwords($data['nama']) ?></center>
                                                    </td>
                                                    <td>
                                                        <?= ucwords($data['keterangan']) ?>
                                                    </td>

                                                   





                                                </tr>
                                            <?php
                                            };
                                            ?>
                                        </tbody>
                                    </table>
                                </div> <!-- end preview-->


                            </div> <!-- end tab-content-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container -->

    </div>
    <!-- content -->
</div>