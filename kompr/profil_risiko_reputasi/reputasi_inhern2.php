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
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = '$id'"));

$dp = $frame['data_pembanding'];

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$pembanding_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$dp'"));

$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));

$respon1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$respon2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$respon3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$respon4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_reputasi WHERE id_profil_risiko = '$id'"));

if (isset($_POST['submit'])) {
    include "../conn/conn.php";

    $ket_pil1_1 = $_POST['ket_pil1_1'];
    $ket_pil1_2 = $_POST['ket_pil1_2'];
    $ket_pil1 = $_POST['ket_pil1'];
    $ket_pil2_1 = $_POST['ket_pil2_1'];
    $ket_pil2_2 = $_POST['ket_pil2_2'];
    $ket_pil2 = $_POST['ket_pil2'];
    $ket_pil3_1 = $_POST['ket_pil3_1'];
    $ket_pil3_2 = $_POST['ket_pil3_2'];
    $ket_pil3 = $_POST['ket_pil3'];
    $ket_pil4_1 = $_POST['ket_pil4_1'];
    $ket_pil4 = $_POST['ket_pil4'];
   
    $ket_inheren = $_POST['ket_inheren'];
   



    mysqli_query($conn, "UPDATE keterangan_inheren2_reputasi SET 
   ket_pil1_1 = '$ket_pil1_1',
   ket_pil1_2 = '$ket_pil1_2',
   ket_pil1 = '$ket_pil1',
   ket_pil2_1 = '$ket_pil2_1',
   ket_pil2_2 = '$ket_pil2_2',
   ket_pil2 = '$ket_pil2',
   ket_pil3_1 = '$ket_pil3_1',
   ket_pil3_2 = '$ket_pil3_2',
   ket_pil3 = '$ket_pil3',
   ket_pil4_1 = '$ket_pil4_1',
   ket_pil4 = '$ket_pil4',
   ket_inheren = '$ket_inheren'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=rep_inhern2&id=$id");
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

                        <h4 class="page-title">Risiko Reputasi Inheren 2</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 2 Profil Risiko reputasi</h4>

                            <hr>
                            </hr>


           



                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="8">
                                                <h4>
                                                    <center><b>RISIKO REPUTASI INHEREN 2</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center"  width="340px" colspan="2">
                                                PARAMETER 
                                            </th>
                                            <th class="text-center" width="18%"colspan="2">
                                               PERINGKAT RISIKO
                                            </th>
                                            <th class="text-center" width="28%">
                                                KETERANGAN
                                            </th>
                                            <th class="text-center" width="18%"  colspan="2">
                                                RISIKO PERIODE SEBELUMNYA
                                            </th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>PILAR 1 : Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar1 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR
                                            </th>
                                            <td>
                                           
                                            </td>
                                            <td width="10%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="60" rows="10" readonly><?= $respon1['ket_in_rep_pil1_1'] ?> <?= $respon1['ket_in_rep_pil1_1a'] ?> <?= $respon1['ket_in_rep_pil1_1b'] ?> <?= $respon1['ket_in_rep_pil1_1c'] ?> <?= $respon1['ket_in_rep_pil1_1d'] ?></textarea></td>
                                            <td></td>
                                            <td width="10%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pembanding_pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                        </tr>

                                        <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Pemberitaan Negatif Terhadap Perusahaan Terkait
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1a'] ?></center></td>
                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Kerjasama Dengan Mitra Bisnis
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                d.
                                            </th>
                                            <th>
                                            Penyediaan Media untuk Menjaring Kejadian Terkait Risiko Reputasi
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                e.
                                            </th>
                                            <th>
                                            Penunjukan PIC untuk Pemantauan Terhadap Informasi yang Meningkatkan Eksposure Risiko Reputas
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1d'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>



                                <!--pilar1 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren2" form="my_form" value="<?= $pil1['hasil_pil1_par2'] ?>" name="total_inheren2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="60" rows="10" readonly><?= $respon1['ket_in_rep_pil1_2'] ?> <?= $respon1['ket_in_rep_pil1_2a'] ?> <?= $respon1['ket_in_rep_pil1_2b'] ?> <?= $respon1['ket_in_rep_pil1_2c'] ?> <?= $respon1['ket_in_rep_pil1_2d'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren2" form="my_form" value="<?= $pembanding_pil1['hasil_pil1_par2'] ?>" name="total_inheren2" class="form-control"  readonly="">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Jenis Dan Variasi Pemberitaan
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2a'] ?></center></td>
                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Jangkauan Dan Kredibilitas Media Massa
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                d.
                                            </th>
                                            <th>
                                            Jumlah Kejadian Terkait dengan Risiko Reputasi pada Periode Penilaian
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                e.
                                            </th>
                                            <th>
                                            Jumlah Pemberitaan Negatif (Regional Jawa Tengah) pada Media Massa Cetak dan Elektronik
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2d'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>



                                        <!--pilar1 parameter3-->

                                    

                                
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 - Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil1" form="my_form" value="<?= $inheren['pil1_tertinggi'] ?>" name="tertinggi_pil1" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil1" form="my_form" value="<?= $inheren['pil1_terendah'] ?>" name="terendah_pil1" class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil1" form="my_form" value="<?= $inheren['pil1_rata_rata'] ?>" name="rata_rata_pil1" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                            
                                            <td>
                                            <textarea class="form-control" id="ket_pil1" form="my_form" name="ket_pil1" cols="60" rows="10"><?= $ket['ket_pil1'] ?></textarea></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Frekuensi Dan Signifikansi Pengaduan Nasabah</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar2 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Administrasi Dan Tindak Lanjut Pengaduan Nasabah
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_1" form="my_form" value="<?= $pil2['hasil_pil2_par1'] ?>" name="total_inheren_pil2_1" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="60" rows="10" readonly><?= $respon2['ket_in_rep_pil2_1'] ?> <?= $respon2['ket_in_rep_pil2_1a'] ?> <?= $respon2['ket_in_rep_pil2_1b'] ?> <?= $respon2['ket_in_rep_pil2_1c'] ?> <?= $respon2['ket_in_rep_pil2_1d'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil2_1" form="my_form" value="<?= $pembanding_pil2['hasil_pil2_par1'] ?>" name="total_inheren_pil2_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Administrasi Dan Tindak Lanjut Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Metode Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1a'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Hasil Analisa Informasi pada Media atau Jejaring Sosial
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                d.
                                            </th>
                                            <th>
                                            Informasi dari Lembaga Perlindungan Konsumen dan Konsumen
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                e.
                                            </th>
                                            <th>
                                            Prosedur Layanan Pengaduan Konsumen Tertulis
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1d'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                       
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Signifikansi Dan Materialitas Pengaduan nasabah
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="60" rows="10" readonly><?= $respon2['ket_in_rep_pil2_2'] ?> <?= $respon2['ket_in_rep_pil2_2a'] ?> <?= $respon2['ket_in_rep_pil2_2b'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pembanding_pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Signifikansi Dan Materialitas Pengaduan nasabah
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Jenis Aduan Nasabah
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2a'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Jumlah Pengaduan Nasabah yang Dapat Diselesaikan
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 -  Frekuensi Dan Signifikansi Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil2" form="my_form" value="<?= $inheren['pil2_tertinggi'] ?>" name="tertinggi_pil2" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil2" form="my_form" value="<?= $inheren['pil2_terendah'] ?>" name="terendah_pil2"  class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil2" form="my_form" value="<?= $inheren['pil2_rata_rata'] ?>" name="rata_rata_pil2" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>

                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $inheren['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                            
                                            <td><textarea class="form-control" id="ket_pil2" form="my_form" name="ket_pil2" cols="60" rows="10"><?= $ket['ket_pil2'] ?></textarea></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>

                                        
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 3 : Pelanggaran Etika Bisnis</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar3 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Transparansi Informasi Keuangan
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil3_1" form="my_form" value="<?= $pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="60" rows="10" readonly><?= $respon3['ket_in_rep_pil3_1'] ?> <?= $respon3['ket_in_rep_pil3_1a'] ?> <?= $respon3['ket_in_rep_pil3_1b'] ?> <?= $respon3['ket_in_rep_pil3_1c'] ?> </textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil3_1" form="my_form" value="<?= $pembanding_pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Transparansi Informasi Keuangan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Transparansi Data Dokumen Dan Informasi Terhadap Laporan Keuangan Dan Non Keuangan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1a'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Transparansi Rekrutmen Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                d.
                                            </th>
                                            <th>
                                            Pemutusan Hubungan Kerja
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1c'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>


                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Transparansi Produk Dan Layanan BPR
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil3_2" form="my_form" value="<?= $pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_2" form="my_form" name="ket_pil3_2" cols="60" rows="10" readonly><?= $respon3['ket_in_rep_pil3_2'] ?> <?= $respon3['ket_in_rep_pil3_2a'] ?> <?= $respon3['ket_in_rep_pil3_2b'] ?> </textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil3_2" form="my_form" value="<?= $pembanding_pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_2" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Transparansi Produk Dan Layanan BPR
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Kegiatan Pemasaran
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2a'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Transparansi Fasilitas Produk Dan Layanan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2b'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                       


                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 3 - Pelanggaran Etika Bisnis
                                            </th>
                                            <td>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3" form="my_form" name="ket_pil3" cols="60" rows="10"><?= $ket['ket_pil3'] ?></textarea>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>


                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <!--pilar3 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Lainnya
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil4_1" form="my_form" value="<?= $pil4['hasil_pil4_par1'] ?>"  name="total_inheren_pil4_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="60" rows="10" readonly><?= $respon4['ket_in_rep_pil4_1a'] ?> <?= $respon4['ket_in_rep_pil4_1b'] ?> <?= $respon4['ket_in_rep_pil4_1c'] ?> </textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil4_1" form="my_form" value="<?= $pembanding_pil4['hasil_pil4_par1'] ?>"  name="total_inheren_pil4_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Laporan Pemeriksaan SKAI
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1a'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Laporan Hasil Monitoring Satuan Kerja Kepatuhan
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                c.
                                            </th>
                                            <th>
                                            Pemberitaan Positif Tentang Kinerja dan Kegiatan Bank
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1c'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            <td>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $inheren['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil4" form="my_form" name="ket_pil4" cols="60" rows="10"><?= $ket['ket_pil4'] ?></textarea>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>

                                       
                                    </tbody>


                                </table>
                            </div> <!-- end table-responsive-->

                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <center>REKAP PENILAIAN INHEREN REPUTASI</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Frekuensi Dan Signifikansi Pengaduan Nasabah
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $inheren['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 - Pelanggaran Etika Bisnis
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $inheren['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    


                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th scope="row" colspan="5">
                                            Hasil Penilaian Inheren
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_inheren" form="my_form" value="<?= $inheren['hasil_inheren_tertinggi'] ?>" name="tertinggi_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_inheren" form="my_form" value="<?= $inheren['hasil_inheren_terendah'] ?>" name="terendah_inheren" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_inheren" form="my_form" value="<?= $inheren['hasil_inheren_rata_rata'] ?>" name="rata_rata_inheren" class="form-control"  readonly="">
                                            </td>
                                            
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_inheren" form="my_form" value="<?= $inheren['hasil_tingkat_risiko'] ?>" name="risiko_inheren" class="form-control"  readonly="">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_inheren" form="my_form" value="<?= $inheren['hasil_peringkat'] ?>" name="peringkat_inheren" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="table-primary">
                                        <tr>

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Reputasi</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket['ket_inheren'] ?></textarea>
                                            </th>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>












































                            <hr>
                            </hr>

                            <br></br>



                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>
                                </div>

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