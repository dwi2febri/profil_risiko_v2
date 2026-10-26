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
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];


$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$kpmr = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = '$id'"));

$pembanding_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar1 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar2 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar3 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar4 WHERE id_profil_risiko = '$dp'"));

$respon1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko = '$id'"));
$respon2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko = '$id'"));
$respon3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko = '$id'"));
$respon4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko = '$id'"));
$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_operasional WHERE id_profil_risiko = '$id'"));

if (isset($_POST['submit'])) {
    include "../conn/conn.php";

   
    $ket_pil1 = $_POST['ket_pil1'];
    
    $ket_pil2 = $_POST['ket_pil2'];
    
    $ket_pil3 = $_POST['ket_pil3'];
    
    $ket_pil4 = $_POST['ket_pil4'];
    $ket_kpmr = $_POST['ket_kpmr'];
   



    mysqli_query($conn, "UPDATE keterangan_kpmr2_operasional SET 
    
    ket_pil1 = '$ket_pil1',
    
    ket_pil2 = '$ket_pil2',
   
    ket_pil3 = '$ket_pil3',
    
    ket_pil4 = '$ket_pil4',
    ket_kpmr = '$ket_kpmr'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=op_kpmr2&id=$id");
    exit();
}
?>






















<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Operasional KPMR 2 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #215bb8; color: white;">

                            <h4 class="page-title">Risiko Operasional KPMR 2</h4>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko KPMR 2 Profil Risiko Operasional</h4>

                            <hr>
                            </hr>





                            </br>


                            <!-- operasional-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="8">
                                                <h4>
                                                    <center><b>RISIKO OPERASIONAL KPMR 2</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center"  width="340px" colspan="2">
                                                PARAMETER PENILAIAN KPMR
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
                                                    <b>PILAR 1 : Pengawasan Direksi dan Dewan Komisaris</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar1 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko operasional yang disusun oleh Direksi dan melakukan evaluasi secara berkala?
                                            </th>
                                            <td>
                                           
                                            </td>
                                            <td width="10%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr1" form="my_form" value="<?= $pil1['pil1_total1'] ?>" name="total_kpmr1" class="form-control" readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="60" rows="10" readonly><?= $respon1['respon_pil1_1a'] ?> <?= $respon1['respon_pil1_1b'] ?> <?= $respon1['respon_pil1_1c'] ?> <?= $respon1['respon_pil1_1d'] ?> <?= $respon1['respon_pil1_1e'] ?></textarea></td>
                                            <td></td>
                                            <td width="10%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr1" form="my_form" value="<?= $pembanding_pil1['pil1_total1'] ?>" name="total_kpmr1" class="form-control" readonly="">
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                                Apakah ketentuan dan kebijakan manajemen risiko operasional yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP operasional, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)
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
                                                b.
                                            </th>
                                            <th>
                                                Apakah evaluasi ketentuan dan kebijakan manajemen risiko operasional yang disetujui Dewan Komisaris telah dilakukan (Ketentuan operasional yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja
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
                                                c.
                                            </th>
                                            <th>
                                            Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko operasional dalam menjalankan tugas dan fungsinya
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
                                                d.
                                            </th>
                                            <th>
                                            Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko operasional sesuai kebijakan manajemen risiko yang ditetapkan
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1d'] ?></center></td>

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
                                            Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>



                                <!--pilar1 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko  operasional secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr2" form="my_form" value="<?= $pil1['pil1_total2'] ?>" name="total_kpmr2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="60" rows="10" readonly><?= $respon1['respon_pil1_2a'] ?> <?= $respon1['respon_pil1_2b'] ?> <?= $respon1['respon_pil1_2c'] ?> <?= $respon1['respon_pil1_2d'] ?> <?= $respon1['respon_pil1_2e'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr2" form="my_form" value="<?= $pembanding_pil1['pil1_total2'] ?>" name="total_kpmr2" class="form-control"  readonly="">
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko operasional secara tertulis dan dalam forum rapat (terdapat notulen)
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
                                                b.
                                            </th>
                                            <th>
                                            Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko operasional kepada Direksi secara tertulis dan forum rapat
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
                                                c.
                                            </th>
                                            <th>
                                            Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko operasional

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
                                                d.
                                            </th>
                                            <th>
                                            Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko operasional

                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2d'] ?></center></td>

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
                                            Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <!--pilar1 parameter3-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah  Direksi telah menyusun kebijakan Manajemen Risiko operasional, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr3" form="my_form" value="<?= $pil1['pil1_total3'] ?>" name="total_kpmr3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_3" form="my_form" name="ket_pil1_3" cols="60" rows="10" readonly><?= $respon1['respon_pil1_3a'] ?> <?= $respon1['respon_pil1_3b'] ?> <?= $respon1['respon_pil1_3c'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr3" form="my_form" value="<?= $pembanding_pil1['pil1_total3'] ?>" name="total_kpmr3" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko operasional (Pelatihan tentang manajemen risiko operasional yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko operasional)
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_3a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_3a'] ?></center></td>

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
                                            Ketentuan dan kebijakan manajemen risiko operasional yang disetujui Direksi apa saja yang telah ditetapkan (SK Direksi, SOP operasional, SE Direksi)
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_3b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_3b'] ?></center></td>

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
                                            Kapan evaluasi ketentuan dan kebijakan manajemen risiko operasional yang disetujui Direksi dilakukan (Ketentuan operasional yang diterbitkan selama periode penilaian)
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_3c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_3c'] ?></center></td>
                                            <td>
                                            </td>
                                            
                                        </tr>

                                <!--pilar1 parameter4-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah  Direksi telah  memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi  Risiko operasional, dan melakukan komunikasi kebijakan Manajemen Risiko  operasional terhadap seluruh  jenjang organisasi BPR?
                                            </b>
                                            <td></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr4" form="my_form" value="<?= $pil1['pil1_total4'] ?>" name="total_kpmr4" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_4" form="my_form" name="ket_pil1_4" cols="60" rows="10" readonly><?= $respon1['respon_pil1_4a'] ?> <?= $respon1['respon_pil1_4b'] ?> <?= $respon1['respon_pil1_4c'] ?> <?= $respon1['respon_pil1_4d'] ?> <?= $respon1['respon_pil1_4e'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr4" form="my_form" value="<?= $pembanding_pil1['pil1_total4'] ?>" name="total_kpmr4" class="form-control"  readonly="">
                                            </td>
                                           
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_4a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_4a'] ?></center></td>

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
                                            Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluruh unit kerja

                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_4b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_4b'] ?></center></td>

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
                                            Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko operasional kepada seluruh unit kerja
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_4c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_4c'] ?></center></td>

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
                                            Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_4d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_4d'] ?></center></td>

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
                                            Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_4e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_4e'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                <!--pilar1 parameter5-->

                               <tr bgcolor="#edebe8">
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi operasional dan fungsi Manajemen Risiko operasional?
                                            </b>
                                            <td></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr5" form="my_form" value="<?= $pil1['pil1_total5'] ?>" name="total_kpmr5" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_5" form="my_form" name="ket_pil1_5" cols="60" rows="10" readonly><?= $respon1['respon_pil1_5a'] ?> <?= $respon1['respon_pil1_5b'] ?> <?= $respon1['respon_pil1_5c'] ?> <?= $respon1['respon_pil1_5d'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr5" form="my_form" value="<?= $pembanding_pil1['pil1_total5'] ?>" name="total_kpmr5" class="form-control"  readonly="">
                                            </td>
                                           
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja operasional dan melaksanakan tugasnya secara independen
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_5a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_5a'] ?></center></td>

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
                                            Apakah kecukupan organisasi di unit kerja operasional telah didukung dengan kompetensi yang baik
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_5b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_5b'] ?></center></td>

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
                                            Apakah kecukupan organisasi di satuan manajemen risiko operasional telah didukung dengan kompetensi yang baik
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_5c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_5c'] ?></center></td>

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
                                            Apakah proses operasional dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_5d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_5d'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        <!--pilar1 parameter6-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko operasional?
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr6" form="my_form" value="<?= $pil1['pil1_total6'] ?>" name="total_kpmr6" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_6" form="my_form" name="ket_pil1_6" cols="60" rows="10" readonly><?= $respon1['respon_pil1_6a'] ?> <?= $respon1['respon_pil1_6b'] ?> <?= $respon1['respon_pil1_6c'] ?></textarea></td>
                                            <td></td>
                                            <td>
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr6" form="my_form" value="<?= $pembanding_pil1['pil1_total6'] ?>" name="total_kpmr6" class="form-control"  readonly="">
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko operasional, tidak terdapat perangkapan jabatan, independen
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_6a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_6a'] ?></center></td>

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
                                            Apakah pedoman pengelolaan SDM dilakukan review secara berkala
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_6b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_6b'] ?></center></td>

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
                                            Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang operasional 
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_6c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_6c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil1" form="my_form" value="<?= $kpmr['pil1_tertinggi'] ?>" name="tertinggi_pil1" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil1" form="my_form" value="<?= $kpmr['pil1_terendah'] ?>" name="terendah_pil1" class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil1" form="my_form" value="<?= $kpmr['pil1_rata_rata'] ?>" name="rata_rata_pil1" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $kpmr['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
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
                                                    <b>PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar2 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah memiliki kebijakan Manajemen Risiko operasional yang  memadai dan disusun dengan mempertimbang kan  visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_1" form="my_form" value="<?= $pil2['pil2_total1'] ?>" name="total_kpmr_pil2_1" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="60" rows="10" readonly><?= $respon2['respon_pil2_1a'] ?> <?= $respon2['respon_pil2_1b'] ?> <?= $respon2['respon_pil2_1c'] ?> <?= $respon2['respon_pil2_1d'] ?> <?= $respon2['respon_pil2_1e'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil2_1" form="my_form" value="<?= $pembanding_pil2['pil2_total1'] ?>" name="total_kpmr_pil2_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko operasional
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
                                                b.
                                            </th>
                                            <th>
                                            Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko operasional
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
                                                c.
                                            </th>
                                            <th>
                                            Apakah kebijakan manajemen risiko operasional dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi
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
                                                d.
                                            </th>
                                            <th>
                                            Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko operasional memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko operasional, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1d'] ?></center></td>

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
                                            Aplakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <!--pilar2 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR:
Memiliki prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional yang ditetapkan oleh Direksi
Melaksanakan prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional secara konsisten untuk seluruh aktivitas; dan
Melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional secara berkala?
<td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_2" form="my_form" value="<?= $pil2['pil2_total2'] ?>" name="total_kpmr_pil2_2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="60" rows="10" readonly><?= $respon2['respon_pil2_2a'] ?> <?= $respon2['respon_pil2_2b'] ?> <?= $respon2['respon_pil2_2c'] ?> <?= $respon2['respon_pil2_2d'] ?> <?= $respon2['respon_pil2_2e'] ?> <?= $respon2['respon_pil2_2f'] ?> <?= $respon2['respon_pil2_2g'] ?> <?= $respon2['respon_pil2_2h'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil2_2" form="my_form" value="<?= $pembanding_pil2['pil2_total2'] ?>" name="total_kpmr_pil2_2" class="form-control"  readonly="">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko operasional yang ditetapkan dalam SK Direksi
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
                                                b.
                                            </th>
                                            <th>
                                            Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2b'] ?></center></td>

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
                                            Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2c'] ?></center></td>

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
                                            Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2d'] ?></center></td>

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
                                            Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                f.
                                            </th>
                                            <th>
                                            Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi operasional
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2f'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                g.
                                            </th>
                                            <th>
                                            Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2g'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2g'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                h.
                                            </th>
                                            <th>
                                            Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2h'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2h'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <!--pilar2 parameter3-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2">Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko operasional sesuai dengan ketentuan?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_3" form="my_form" value="<?= $pil2['pil2_total3'] ?>" name="total_kpmr_pil2_3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil2_3" form="my_form" name="ket_pil2_3" cols="60" rows="10" readonly><?= $respon2['respon_pil2_3a'] ?> <?= $respon2['respon_pil2_3b'] ?> <?= $respon2['respon_pil2_3c'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil2_3" form="my_form" value="<?= $pembanding_pil2['pil2_total3'] ?>" name="total_kpmr_pil2_3" class="form-control"  readonly="">
                                            </td>
                                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_3a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_3a'] ?></center></td>

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
                                            Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_3b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_3b'] ?></center></td>

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
                                            Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_3c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_3c'] ?></center></td>

                                            <td>
                                            </td>
                                            
                                        </tr>

                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil2" form="my_form" value="<?= $kpmr['pil2_tertinggi'] ?>" name="tertinggi_pil2" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil2" form="my_form" value="<?= $kpmr['pil2_terendah'] ?>" name="terendah_pil2"  class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil2" form="my_form" value="<?= $kpmr['pil2_rata_rata'] ?>" name="rata_rata_pil2" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>

                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $kpmr['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
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
                                                    <b>PILAR 3 : Kecukupan Proses dan Sistem</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar3 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah melaksanakan proses Manajemen Risiko operasional yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko operasional?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_1" form="my_form" value="<?= $pil3['pil3_total1'] ?>"  name="total_kpmr_pil3_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="60" rows="10" readonly><?= $respon3['respon_pil3_1a'] ?> <?= $respon3['respon_pil3_1b'] ?> <?= $respon3['respon_pil3_1c'] ?> <?= $respon3['respon_pil3_1d'] ?> <?= $respon3['respon_pil3_1e'] ?> <?= $respon3['respon_pil3_1f'] ?> <?= $respon3['respon_pil3_1g'] ?> <?= $respon3['respon_pil3_1h'] ?> <?= $respon3['respon_pil3_1i'] ?> <?= $respon3['respon_pil3_1j'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil3_1" form="my_form" value="<?= $pembanding_pil3['pil3_total1'] ?>"  name="total_kpmr_pil3_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah dalam aktvitas operasional seluruh SDM telah berpedoman pada penerapan manajemen risiko operasional
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
                                                b.
                                            </th>
                                            <th>
                                            Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas operasional
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
                                                c.
                                            </th>
                                            <th>
                                            Apakah dalam proses operasional dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1c'] ?></center></td>

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
                                            Apakah dalam proses pengambilan keputusan bidang operasional dilakukan secara pembahasan bersama dan dilakukan secara transparan  
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1d'] ?></center></td>

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
                                            Apakah dalam proses manajamen risiko operasional telah didukung dengan data operasional yang akurat dan informatif
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                f.
                                            </th>
                                            <th>
                                            Apakah dalam proses manajemen risiko operasional telah melakukan analisa karakteristik risiko operasional yang melekat pada produk dan layanan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1f'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                g.
                                            </th>
                                            <th>
                                            Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko operasional telah dilakukan evaluasi
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1g'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1g'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                h.
                                            </th>
                                            <th>
                                            Apakah dalam melakukan pengukuran risiko operasional telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1h'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1h'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                i.
                                            </th>
                                            <th>
                                            Apakah dalam melakukan pemantauan risiko operasional telah dilakukan evaluasi terhadap eksposur risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1i'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1i'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                j.
                                            </th>
                                            <th>
                                            Apabila terdapat perubahan yang material dalam faktor risiko operasional apakah juga dilakukan penyesuaian pelaporan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1j'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1j'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                            <!--pilar3 parameter2-->
                                            <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko operasional serta telah dilaporkan kepada Direksi secara berkala?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_2" form="my_form" value="<?= $pil3['pil3_total2'] ?>" name="total_kpmr_pil3_2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_2" form="my_form" name="ket_pil3_2" cols="60" rows="10" readonly><?= $respon3['respon_pil3_2a'] ?> <?= $respon3['respon_pil3_2b'] ?> <?= $respon3['respon_pil3_2c'] ?> <?= $respon3['respon_pil3_2d'] ?> <?= $respon3['respon_pil3_2e'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil3_2" form="my_form" value="<?= $pembanding_pil3['pil3_total2'] ?>" name="total_kpmr_pil3_2" class="form-control"  readonly="">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya 
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
                                                b.
                                            </th>
                                            <th>
                                            Apakah sistem informasi risiko operasional dapat dan mudah diakses serta laporan yang lengkap 
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2b'] ?></center></td>

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
                                            Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko operasional yang lengkap dan cepat
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2c'] ?></center></td>

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
                                            Apakah sistem informasi yang dimiliki mampu meningkatkan kepatuhan terhadap kebijakan manajemen risiko operasional (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2d'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2d'] ?></center></td>

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
                                            Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2e'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>
                                        
<!--pilar3 parameter3-->
<tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah memiliki kebijakan dan prosedur penyelenggaraan TI ?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_3" form="my_form" value="<?= $pil3['pil3_total3'] ?>" name="total_kpmr_pil3_3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_3" form="my_form" name="ket_pil3_3" cols="60" rows="10" readonly><?= $respon3['respon_pil3_3a'] ?> <?= $respon3['respon_pil3_3b'] ?> <?= $respon3['respon_pil3_3c'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil3_3" form="my_form" value="<?= $pembanding_pil3['pil3_total3'] ?>" name="total_kpmr_pil3_3" class="form-control"  readonly="">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah Kebijakan TI telah disusun dan disetujui oleh Direksi
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_3a'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_3a'] ?></center></td>

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
                                            Apakah Kebijakan TI dilakukan review secara berkala
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_3b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_3b'] ?></center></td>

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
                                            Apakah Kebijakan TI dipahami oleh seluruh pegawai dan dijalankan sesuai ketentuan
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_3c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_3c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>


                                        <!--pilar3 parameter4-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah melakukan langkah mitigasi Risiko terkait kejadian eksternal ?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_4" form="my_form" value="<?= $pil3['pil3_total4'] ?>" name="total_kpmr_pil3_4" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_4" form="my_form" name="ket_pil3_4" cols="60" rows="10" readonly><?= $respon3['respon_pil3_4a'] ?> <?= $respon3['respon_pil3_4b'] ?> <?= $respon3['respon_pil3_4c'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil3_4" form="my_form" value="<?= $pembanding_pil3['pil3_total4'] ?>" name="total_kpmr_pil3_4" class="form-control"  readonly="">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah telah memiliki pedoman pengendalian dan mitigasi risiko operasional penyelenggaraan TI akibat faktor eksternal
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_4a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_4a'] ?></center></td>

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
                                            Apakah kebijakan dan pedoman pengendalian risiko operasional akibat faktor eksternal telah disosialisasikan ke seluruh pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_4b'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_4b'] ?></center></td>

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
                                            Apakah kebijakan dan pedoman tersebut telah dilakukan uji coba penerapnnya dan dilakukan evaluasi secara berkala
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_4c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_4c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>


                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 3 -  Kecukupan Proses dan Sistem
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil3" form="my_form" value="<?= $kpmr['pil3_tertinggi'] ?>" name="tertinggi_pil3" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil3" form="my_form" value="<?= $kpmr['pil3_terendah'] ?>" name="terendah_pil3" class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil3" form="my_form" value="<?= $kpmr['pil3_rata_rata'] ?>" name="rata_rata_pil3" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $kpmr['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3" form="my_form" name="ket_pil3" cols="60" rows="10"><?= $ket['ket_pil3'] ?></textarea>
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>



                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>PILAR 4 : Sistem Pengendalian yang Menyeluruh</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar4 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah SKAI atau PE Audit Internal telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko operasional, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil4_1" form="my_form" value="<?= $pil4['pil4_total1'] ?>" name="total_kpmr_pil4_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="60" rows="10" readonly><?= $respon4['respon_pil4_1a'] ?> <?= $respon4['respon_pil4_1b'] ?> <?= $respon4['respon_pil4_1c'] ?> <?= $respon4['respon_pil4_1d'] ?> <?= $respon4['respon_pil4_1e'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil4_1" form="my_form" value="<?= $pembanding_pil4['pil4_total1'] ?>" name="total_kpmr_pil4_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko operasional di berapa cabang atau unit kerja di bidang manajemen risiko operasional
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
                                            Apakah setiap temuan SKAI dalam penerapan manajemen risiko operasional telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama
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
                                            Apakah SKAI dalam penerapan manajemen risiko operasional telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1c'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1c'] ?></center></td>

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
                                            Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko operasional 
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1d'] ?></center></td>

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
                                            Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko operasional
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1e'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1e'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                                                                <!--pilar4 parameter2-->
                                                                                <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah sistem pengendalian intern terhadap Risiko operasional telah dilaksanakan oleh seluruh jenjang organisasi BPR?
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil4_2" form="my_form" value="<?= $pil4['pil4_total2'] ?>" name="total_kpmr_pil4_2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil4_2" form="my_form" name="ket_pil4_2" cols="60" rows="10" readonly><?= $respon4['respon_pil4_2a'] ?> <?= $respon4['respon_pil4_2b'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_kpmr_pil4_2" form="my_form" value="<?= $a['a'] ?>" name="total_kpmr_pil4_2" class="form-control"  readonly="">
                                            </td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional peroperasionalan
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_2a'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_2a'] ?></center></td>

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
                                            Apakah unit kerja operasional telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_2b'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 4 -  Sistem Pengendalian yang Menyeluruh
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil4" form="my_form" value="<?= $kpmr['pil4_tertinggi'] ?>" name="tertinggi_pil4" class="form-control"  readonly="">
                                            
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil4" form="my_form" value="<?= $kpmr['pil4_terendah'] ?>" name="terendah_pil4" class="form-control"  readonly="">
                                            
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil4" form="my_form" value="<?= $kpmr['pil4_rata_rata'] ?>" name="rata_rata_pil4" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $kpmr['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>

                                            <td><textarea class="form-control" id="ket_pil4" form="my_form" name="ket_pil4" cols="60" rows="10"><?= $ket['ket_pil4'] ?></textarea></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
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
                                                <center>REKAP PENILAIAN KPMR OPERASIONAL</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $kpmr['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $kpmr['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 -  Kecukupan Proses dan Sistem
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $kpmr['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="8">
                                            Hasil Penilaian Pilar 4 -  Sistem Pengendalian yang Menyeluruh
                                            </th>
                                           
                                            <td width="14%">
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $kpmr['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th scope="row" colspan="5">
                                            Hasil Penilaian KPMR
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_kpmr" form="my_form" value="<?= $kpmr['hasil_kpmr_tertinggi'] ?>" name="tertinggi_kpmr" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_kpmr" form="my_form" value="<?= $kpmr['hasil_kpmr_terendah'] ?>" name="terendah_kpmr" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_kpmr" form="my_form" value="<?= $kpmr['hasil_kpmr_rata_rata'] ?>" name="rata_rata_kpmr" class="form-control"  readonly="">
                                            </td>
                                            
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_kpmr" form="my_form" value="<?= $kpmr['hasil_tingkat_risiko'] ?>" name="risiko_kpmr" class="form-control"  readonly="">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr" form="my_form" value="<?= $kpmr['hasil_peringkat'] ?>" name="peringkat_kpmr" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="table-primary">
                                        <tr>

                                            <th colspan="9">
                                                <center>Uraian Untuk KPMR Operasional</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" id="ket_kpmr" form="my_form" name="ket_kpmr" cols="60" rows="10"><?= $ket['ket_kpmr'] ?></textarea>
                                            </th>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>












































                            <hr>
                            </hr>

                            <br></br>



                            <?php if ($frame['kunci_laporan'] != 1): ?>
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