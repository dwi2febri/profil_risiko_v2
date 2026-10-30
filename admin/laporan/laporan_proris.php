

<?php
include "../fungsi/fungsi.php";

?>

<script>


    $(document).ready(function() {
        var table = $('#basic-datatable1').DataTable();

        $('#yearFilter, #quarterFilter').on('change', function() {
        var year = $('#yearFilter').val();
        var quarter = $('#quarterFilter').val();
        
        // Logika filter
        table.column(3).search(year).draw(); // Misalnya kolom 0 adalah tahun
        table.column(5).search(quarter).draw(); // Misalnya kolom 1 adalah kuartal
});
    });

</script>


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
                                    <h4 class="page-title">Menu Laporan Profil Risiko Divisi</h4>
                                </div>
                            </div>
                        </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Laporan Profil Risiko Yang Masuk</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh Divisi Kantor Pusat
                            </p>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <h4 class="header-title mb-4">Filter</h4>

                                        <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">  <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                            <div class="row">
                                               
                                                <div class="col-lg-6">
                                                        <label for="yearFilter" class="form-label">Tahun</label>
                                                        <select class="form-select mb-3" name="yearFilter" id="yearFilter" required="">
                                                            <option value=" " selected> </option>
                                                            <option value="2024" >2024</option>
                                                            <option value="2025" >2025</option>
                                                            <option value="2026" >2026</option>
                                                            <option value="2027" >2027</option>
                                                            <option value="2028" >2028</option>
                                                            <option value="2029" >2029</option>
                                                            <option value="2030" >2030</option>
                                                            <option value="2031" >2031</option>
                                                            <option value="2032" >2032</option>
                                                            <option value="2033" >2033</option>
                                                            <option value="2034" >2034</option>
                                                            <option value="2035" >2035</option>
                                                            <option value="2036" >2036</option>
                                                            <option value="2037" >2037</option>
                                                        </select>
                                                </div>
                                                <div class="col-lg-6">
                                                        <label for="quarterFilter" class="form-label">Periode</label>
                                                        <select class="form-select mb-3" name="quarterFilter" id="quarterFilter" required="">
                                                        <option value=" " selected> </option>
                                                            <option value="1" >Triwulan 1</option>
                                                            <option value="2" >Triwulan 2</option>
                                                            <option value="3" >Triwulan 3</option>
                                                            <option value="4" >Triwulan 4</option>
                                                        </select>
                                                </div>
                                                
                                            </div>
                                        </form>
                                        <!-- end row-->

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->

                                                       
                        </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="basic-datatable1" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>
                                                    <center>No</center>
                                                </th>

                                                <th>
                                                    <center>Aksi</center>
                                                </th>
                                                <th>
                                                    <center>Tgl Lock</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Divisi</center>
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
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE user = '2' order by id_profil_risiko desc");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                        <?php
                                                        

                                                        // Menentukan URL berdasarkan kondisi
                                                        if ($data['user_id'] == 132) {
                                                            $url = '../admin/laporan/cetak_pemasaran.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 142) {
                                                            $url = '../admin/laporan/cetak_dpk.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 135) {
                                                            $url = '../admin/laporan/cetak_kepatuhan.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 133) {
                                                            $url = '../admin/laporan/cetak_operasional.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 136) {
                                                            $url = '../admin/laporan/cetak_sekper.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 134) {
                                                            $url = '../admin/laporan/cetak_sdm.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 137) {
                                                            $url = '../admin/laporan/cetak_litbang.php?id=' . $data['id_profil_risiko'];
                                                        } else if ($data['user_id'] == 143) {
                                                            $url = '../admin/laporan/cetak_skai.php?id=' . $data['id_profil_risiko'];
                                                        } else {
                                                            $url = 'index.php?page=laporan_masuk';
                                                        }
                                                        ?>
                                                            <a href="index.php?page=laporan_masuk&id=<?= $data['id_profil_risiko'] ?>"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['id_profil_risiko'] == $id) echo 'checked'; ?> disabled></i> aktifkan</a>
                                                            |
                                                            <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');"><i><input type="checkbox" form="my_form" id="selected_id"  name="selected_id" <?php if ($data['status_skmr'] == 1) echo 'checked'; ?> disabled></i> konfirmasi</a> |
                                                            <a href="<?= $url ?>" target="_blank"> cetak </a>|
                                                            <a href="index.php?page=hps_div&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin menghapus data?');"><i class=" mdi mdi-delete"></i>hapus</a>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <?php if (is_null($data['tgl_lock']) || $data['tgl_lock'] == '0000-00-00'): ?>
                                                                <span>Belum di-lock</span>
                                                            <?php else: ?>
                                                                <?= $data['tgl_lock'] ?>
                                                            <?php endif; ?>
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
                                                        <?php
                                                        $i = $data['modal_inti'];
                                                        if ($i == 0) {
                                                        echo '(Tidak Perlu Mengisi)';
                                                        } else if ($i == null) {
                                                            echo '(Tidak Perlu Mengisi)';
                                                        }
                                                         else {
                                                            echo "Rp." .rupiah($i);
                                                        }
                                                        ?>
                                                    <td>
                                                    <?php
                                                        $ta = $data['total_aset'];
                                                        if ($ta == 0) {
                                                        echo '(Tidak Perlu Mengisi)';
                                                        } else if ($ta == null) {
                                                            echo '(Tidak Perlu Mengisi)';
                                                        }
                                                         else {
                                                            echo "Rp." .rupiah($ta);
                                                        }
                                                        ?>
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