<?php
if (empty($id) || $id === null) {
  // Display modal notification on page load
  $displayModal = true;
} else {
  $displayModal = false;
}
?>
<script>
  $(document).ready(function() {
    <?php if ($displayModal) { ?>
      $('#myModal').modal('show');
    <?php } ?>
  });

  window.onclick = null;
  
</script>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Notifikasi</h5>
        <a href="javascript:history.back()"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></a>
      </div>
      <div class="modal-body">
      <h5><center><b>Mohon untuk memilih laporan risiko di (menu dashboard -> laporan profil risiko -> klik (aktif)) terlebih dahulu.</b></center></h5>
      </div>
      <div class="modal-footer">
      <a href="javascript:history.back()"><button type="button" class="btn btn-danger" data-dismiss="modal">Close</button></a>
      </div>
    </div>
  </div>
</div>


<?php
include "../fungsi/fungsi.php";
$id = $_GET['id'];
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));
$dp = $frame['data_pembanding'];

if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';
    $data_pembanding = $_POST['selected_id'];

        simpro_db_query($conn, "UPDATE frame_laporan_profil_risiko SET data_pembanding = ? WHERE id_profil_risiko = ?", [$data_pembanding, $id]);

        echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

        header("Location: index.php?page=pembanding&id=$id");
        exit();
}
?>


<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">




            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Data Pembanding</h4>
                            <p class="text-muted font-14">
                                Pilih data pembanding (profil risiko sebelumnya) untuk mengisi profil risiko saat ini

                            </p>



                            <hr>
                            </hr>










                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Pilih data yang ingin digunakan sebagai pembanding</h4>
                            <button class="btn btn-outline-info btn-rounded" form="my_form" type="submit" name="submit" ><i class="uil-circuit"></i> gunakan</button>
                        </div>
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
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE  frame_laporan_profil_risiko.kantor_cabang = ?AND dibuat_by = ? AND id_profil_risiko NOT IN (?) order by id_profil_risiko desc", [$kode_kantor, $id_user, $id]);
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                    <td class="table-action">
                                                    <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>
                                                        <center>
                                                       
                                                        <input type="radio" form="my_form" id="selected_id"  name="selected_id" value="<?= $data['id_profil_risiko'] ?>" <?php if ($data['id_profil_risiko'] == $frame['data_pembanding']) echo 'checked'; ?>>
                                                        
                                                        </center>
                                                    </form>
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
                                                        <center><?= rupiah($data['modal_inti']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= rupiah($data['total_aset']) ?></center>
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


            
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Profil Risiko Saat ini</h4>
                        </div>
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview1">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
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
                                                    <center>Modal Inti</center>
                                                </th>
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                               
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE  frame_laporan_profil_risiko.kantor_cabang = ? AND dibuat_by = ? AND id_profil_risiko= ?", [$kode_kantor, $id_user, $id]);
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                  
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                   
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= rupiah($data['modal_inti']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= rupiah($data['total_aset']) ?></center>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
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
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="header-title">Profil Risiko Pembanding(periode sebelumnya)</h4>
                        </div>
                        <div class="card-body">

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview1">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
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
                                                    <center>Modal Inti</center>
                                                </th>
                                                <th>
                                                    <center>Total Aset</center>
                                                </th>
                                                
                                                <th>
                                                    <center>Tanggal Dibuat</center>
                                                </th>
                                              
                                        

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require dirname(__DIR__, 2).'/conn/conn.php';
                                            $no = 1;
                                            $kode_kantor = $_SESSION['lokasi_kerja'];
                                            $id_user = $_SESSION['user_id'];
                                            $query = simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
                                            INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
                                            INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
                                            INNER JOIN user_profil_risiko ON frame_laporan_profil_risiko.user = user_profil_risiko.id_user_profil_risiko
                                            INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE  frame_laporan_profil_risiko.kantor_cabang = ? AND dibuat_by = ? AND id_profil_risiko= ?", [$kode_kantor, $id_user, $dp]);
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <center><?= $no++ ?></center>
                                                    </td>
                                                  
                                                    <td>
                                                        <center><?= $data['tahun'] ?></center>
                                                    </td>
                                                  
                                                    <td>
                                                        <center><?= ucwords($data['periode_laporan']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= rupiah($data['modal_inti']) ?></center>
                                                    </td>
                                                    <td>
                                                        <center><?= rupiah($data['total_aset']) ?></center>
                                                    </td>
                                                    
                                                    <td>
                                                        <center><?= ucwords($data['dibuat_at']) ?></center>
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