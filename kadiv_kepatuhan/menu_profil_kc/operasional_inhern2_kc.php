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


$length = mysqli_fetch_array(mysqli_query($conn, "SELECT 
CHAR_LENGTH(ket_pil1) AS l1,
CHAR_LENGTH(ket_pil2) AS l2,
CHAR_LENGTH(ket_pil4) AS l3,
CHAR_LENGTH(ket_pil5) AS l4,
CHAR_LENGTH(ket_pil6) AS l5,
CHAR_LENGTH(ket_inheren) AS l6 FROM keterangan_inheren2_operasional WHERE id_profil_risiko = '$id'"));

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$pil6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));
$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));

$pembanding_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$dp'"));

$respon1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$respon2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$respon3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$respon4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$respon5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$respon6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));
$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_operasional WHERE id_profil_risiko = '$id'"));

if (isset($_POST['submit'])) {
    include "../conn/conn.php";

    $ket_pil1_1 = $_POST['ket_pil1_1'];
    $ket_pil1_2 = $_POST['ket_pil1_2'];
    $ket_pil1_3 = $_POST['ket_pil1_3'];
    $ket_pil1_4 = $_POST['ket_pil1_4'];
    $ket_pil1 = $_POST['ket_pil1'];
    $ket_pil2_1 = $_POST['ket_pil2_1'];
    $ket_pil2_2 = $_POST['ket_pil2_2'];
    $ket_pil2 = $_POST['ket_pil2'];
    $ket_pil3_1 = $_POST['ket_pil3_1'];
    $ket_pil3 = $_POST['ket_pil3'];
    $ket_pil4_1 = $_POST['ket_pil4_1'];
    $ket_pil4 = $_POST['ket_pil4'];
    $ket_pil5_1 = $_POST['ket_pil5_1'];
    $ket_pil5 = $_POST['ket_pil5'];
    $ket_pil6_1 = $_POST['ket_pil6_1'];
    $ket_pil6 = $_POST['ket_pil6'];
    $ket_inheren = $_POST['ket_inheren'];
   



    mysqli_query($conn, "UPDATE keterangan_inheren2_operasional SET 
   ket_pil1_1 = '$ket_pil1_1',
   ket_pil1_2 = '$ket_pil1_2',
   ket_pil1_3 = '$ket_pil1_3',
   ket_pil1_4 = '$ket_pil1_4',
   ket_pil1 = '$ket_pil1',
   ket_pil2_1 = '$ket_pil2_1',
   ket_pil2_2 = '$ket_pil2_2',
   ket_pil2 = '$ket_pil2',
   ket_pil3_1 = '$ket_pil3_1',
   ket_pil3 = '$ket_pil3',
   ket_pil4_1 = '$ket_pil4_1',
   ket_pil4 = '$ket_pil4',
   ket_pil5_1 = '$ket_pil5_1',
   ket_pil5 = '$ket_pil5',
   ket_pil6_1 = '$ket_pil6_1',
   ket_pil6 = '$ket_pil6',
   ket_inheren = '$ket_inheren'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=op_inhern2&id=$id");
    exit();
}
?>


<script>


        $(document).ready(function() {
            $('#ket_pil1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
      
        $(document).ready(function() {
            $('#ket_pil4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil5').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil6').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
</script>



















<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Operasional Inheren 2 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 2 Profil Risiko Operasional</h4>

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
                                                    <center><b>RISIKO OPERASIONAL INHEREN 2</b></center>
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
                                                PERIODE SEBELUMNYA
                                            </th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>PILAR 1 : Kompleksitas Bisnis dan Kelembagaan</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar1 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Skala Usaha dan Struktur Organisasi
                                            </th>
                                            <td>
                                           
                                            </td>
                                            <td width="10%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="60" rows="5" readonly><?= $respon1['ket_in_op_pil1_1'] ?></textarea></td>
                                            <td></td>
                                            <td width="10%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pembanding_pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                            
                                           

                                        </tr>

                                       


                                <!--pilar1 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Jaringan  Kantor, rentang Kendali dan Lokasi Kantor Cabang
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren2" form="my_form" value="<?= $pil1['hasil_pil1_par2'] ?>" name="total_inheren2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="60" rows="5" readonly><?= $respon1['ket_in_op_pil1_2'] ?> <?= $respon1['ket_in_op_pil1_2a'] ?> <?= $respon1['ket_in_op_pil1_2b'] ?></textarea></td>
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
                                            Jaringan  Kantor, rentang Kendali dan Lokasi Kantor Cabang
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center><?= $pembanding_pil1['pilar1_2'] ?></center>
                                            </td>
                                            
                                            <td></td>


                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                b.
                                            </th>
                                            <th>
                                            Rentang Kendali dan Lokasi Kantor Cabang
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
                                            Jangkauan dan Ruang Kendali Kantor
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center><?= $pembanding_pil1['pilar1_2b'] ?></center>
                                            </td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        

                                        <!--pilar1 parameter3-->

                                       

                                
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan
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
                                            <textarea class="form-control" maxlength="500" id="ket_pil1" form="my_form" name="ket_pil1" cols="60" rows="10"><?= $ket['ket_pil1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 500</span></td>
                                            
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Sumber Daya Manusia</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar2 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Kecukupan Kuantitas dan Kualitas SDM
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_1" form="my_form" value="<?= $pil2['hasil_pil2_par1'] ?>" name="total_inheren_pil2_1" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="60" rows="5" readonly><?= $respon2['ket_in_op_pil2_1'] ?> <?= $respon2['ket_in_op_pil2_1a'] ?> <?= $respon2['ket_in_op_pil2_1b'] ?> <?= $respon2['ket_in_op_pil2_1c'] ?> <?= $respon2['ket_in_op_pil2_1d'] ?> <?= $respon2['ket_in_op_pil2_1e'] ?> <?= $respon2['ket_in_op_pil2_1f'] ?> <?= $respon2['ket_in_op_pil2_1g'] ?> <?= $respon2['ket_in_op_pil2_1h'] ?> <?= $respon2['ket_in_op_pil2_1i'] ?> <?= $respon2['ket_in_op_pil2_1j'] ?> <?= $respon2['ket_in_op_pil2_1k'] ?> <?= $respon2['ket_in_op_pil2_1l'] ?> <?= $respon2['ket_in_op_pil2_1m'] ?> <?= $respon2['ket_in_op_pil2_1n'] ?></textarea></td>
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
                                            Kecukupan Kuantitas dan Kualitas SDM
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
                                            Kecukupan Pegawai
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
                                            Kecukupan Jumlah SDM
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
                                            Kompetensi SDM
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
                                            Tingkat Turn Over Pegawai Diluar Pensiun dan Pemberhentian Tidak Dengan Hormat
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1d'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                f.
                                            </th>
                                            <th>
                                            Pegawai yang Mendekati Usia Pensiun (usia 50 tahun ke atas)
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1e'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                g.
                                            </th>
                                            <th>
                                            Keseimbangan beban kerja
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1f'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                h.
                                            </th>
                                            <th>
                                            Perbandingan NOA Kredit Terhadap Jumlah SDM di Bidang Kredit
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1g'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1g'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                i.
                                            </th>
                                            <th>
                                            Analisa Beban Kerja Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1h'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1h'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                j.
                                            </th>
                                            <th>
                                            Pengukuran Kinerja Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1i'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1i'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                k.
                                            </th>
                                            <th>
                                            Mengembangkan Budaya Organisasi yang sadar risiko dan mengelola risiko
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1j'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1j'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                l.
                                            </th>
                                            <th>
                                            Rotasi Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1k'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1k'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                m.
                                            </th>
                                            <th>
                                            Rotasi Pejabat Eksekutif
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1l'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1l'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                n.
                                            </th>
                                            <th>
                                            Kualitas Pelatihan Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1m'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1m'] ?></center></td>

                                            <td>
                                            </td>

                                            <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                o.
                                            </th>
                                            <th>
                                            Evaluasi Kualitas Pendidikan dan Pelatihan
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1n'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1n'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Permasalahan Operasional Karena Faktor Manusia (Human Error)
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="60" rows="5" readonly><?= $respon2['ket_in_op_pil2_2'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pembanding_pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                      

                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 -  Sumber Daya Manusia
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
                                            
                                            <td><textarea class="form-control" maxlength="500" id="ket_pil2" form="my_form" name="ket_pil2" cols="60" rows="10"><?= $ket['ket_pil2'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length['l2'] ?></span><span> / 500</span></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>

                                        
                                        

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>PILAR 3 : Penyimpangan (Fraud)</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar4 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Penyimpangan (Fraud)
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil4_1" form="my_form" value="<?= $pil4['hasil_pil4_par1'] ?>" name="total_inheren_pil4_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="60" rows="5" readonly><?= $respon4['ket_in_op_pil4_1'] ?> <?= $respon4['ket_in_op_pil4_1a'] ?> <?= $respon4['ket_in_op_pil4_1b'] ?> <?= $respon4['ket_in_op_pil4_1c'] ?> <?= $respon4['ket_in_op_pil4_1d'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil4_1" form="my_form" value="<?= $pembanding_pil4['hasil_pil4_par1'] ?>" name="total_inheren_pil4_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Penyimpangan (Fraud)
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1'] ?></center></td>

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
                                            Frekuensi Penyimpangan	
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
                                                c.
                                            </th>
                                            <th>
                                            Jenis Penyimpangan Pada Pelaksanaan Kegiatan Operasional	
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
                                                d.
                                            </th>
                                            <th>
                                            Sebaran Penyimpangan / Fraud
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1c'] ?></center></td>

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
                                            Jenis Tindakan Fraud
                                            </th>
                                            <td>
                                            <center><?= $pil4['pilar4_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil4['pilar4_1d'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                                                                <!--pilar4 parameter2-->
                                                                                <tr bgcolor="#edebe8">
                                            
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 3 - Penyimpangan (Fraud)
                                            </th>
                                            <td>
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $inheren['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>

                                            <td><textarea class="form-control" maxlength="500" id="ket_pil4" form="my_form" name="ket_pil4" cols="60" rows="5"><?= $ket['ket_pil4'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length['l3'] ?></span><span> / 500</span></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>








                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>PILAR 4 : Faktor Eksternal</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar5 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Faktor Eksternal
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil5_1" form="my_form" value="<?= $pil5['hasil_pil5_par1'] ?>" name="total_inheren_pil5_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil5_1" form="my_form" name="ket_pil5_1" cols="60" rows="5" readonly><?= $respon5['ket_in_op_pil5_1'] ?> <?= $respon5['ket_in_op_pil5_1a'] ?> <?= $respon5['ket_in_op_pil5_1b'] ?> <?= $respon5['ket_in_op_pil5_1c'] ?> <?= $respon5['ket_in_op_pil5_1d'] ?> <?= $respon5['ket_in_op_pil5_1e'] ?> <?= $respon5['ket_in_op_pil5_1f'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil5_1" form="my_form" value="<?= $pembanding_pil5['hasil_pil5_par1'] ?>" name="total_inheren_pil5_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Faktor Eksternal
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1'] ?></center></td>

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
                                            Kebijakan Pemerintah
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1a'] ?></center></td>

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
                                            Sarana Prasarana
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1b'] ?></center></td>

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
                                            Standard Layanan
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1c'] ?></center></td>

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
                                            Keamanan Jaringan Kantor
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1d'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1d'] ?></center></td>

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
                                            Gangguan Akibat Faktor Eksternal
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1e'] ?></center></td>

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
                                            Regulasi Pemerintah atau Peraturan Perundang-undangan yang Berdampak pada Risiko Operasional
                                            </th>
                                            <td>
                                            <center><?= $pil5['pilar5_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil5['pilar5_1f'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>

                                                                                <!--pilar4 parameter2-->
                                                                                <tr bgcolor="#edebe8">
                                            
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 4 - Faktor Eksternal
                                            </th>
                                            <td>
                                            
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil5" form="my_form" value="<?= $inheren['pil5_tingkat_risiko'] ?>" name="risiko_pil5" class="form-control"  readonly="">
                                            </td>

                                            <td><textarea class="form-control" maxlength="500" id="ket_pil5" form="my_form" name="ket_pil5" cols="60" rows="5"><?= $ket['ket_pil5'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length['l4'] ?></span><span> / 500</span></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>



                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="8">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar6 parameter1-->

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
                                            <input type="number" id="total_inheren_pil6_1" form="my_form" value="<?= $pil6['hasil_pil6_par1'] ?>" name="total_inheren_pil6_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil6_1" form="my_form" name="ket_pil6_1" cols="60" rows="5" readonly><?= $respon6['ket_in_op_pil6_1a'] ?> <?= $respon6['ket_in_op_pil6_1b'] ?> <?= $respon6['ket_in_op_pil6_1c'] ?> <?= $respon6['ket_in_op_pil6_1d'] ?> <?= $respon6['ket_in_op_pil6_1e'] ?> <?= $respon6['ket_in_op_pil6_1f'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil6_1" form="my_form" value="<?= $pembanding_pil6['hasil_pil6_par1'] ?>" name="total_inheren_pil6_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>
                                        
                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Kesehatan Pegawai
                                            </th>
                                            <td>
                                            <center><?= $pil6['pilar6_1a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil6['pilar6_1a'] ?></center></td>

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
                                            Keselamatan Kerja
                                            </th>
                                            <td>
                                            <center><?= $pil6['pilar6_1b'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil6['pilar6_1b'] ?></center></td>

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
                                            Jumlah Pengaduan Nasabah 
                                            </th>
                                            <td>
                                            <center><?= $pil6['pilar6_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil6['pilar6_1c'] ?></center></td>

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
                                            Pengawasan Internal
                                            </th>
                                            <td>
                                            <center><?= $pil6['pilar6_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil6['pilar6_1e'] ?></center></td>

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
                                            Kejadian Luar Biasa yang Berpengaruh Terhadap Kegiatan Layanan	
                                            </th>
                                            <td>
                                            <center><?= $pil6['pilar6_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil6['pilar6_1f'] ?></center></td>

                                            <td>
                                            </td>

                            
                                        </tr>


                                                                                <!--pilar4 parameter2-->
                                                                                <tr bgcolor="#edebe8">
                                            
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            <td>
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil6" form="my_form" value="<?= $inheren['pil6_tingkat_risiko'] ?>" name="risiko_pil6" class="form-control"  readonly="">
                                            </td>

                                            <td><textarea class="form-control" maxlength="500" id="ket_pil6" form="my_form" name="ket_pil6" cols="60" rows="5"><?= $ket['ket_pil6'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length['l5'] ?></span><span> / 500</span></td>
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

                                            <th style="font-size: 20px;" colspan="9">
                                                <center>REKAP PENILAIAN INHEREN OPERASIONAL</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Sumber Daya Manusia
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $inheren['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                       
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 - Penyimpangan (Fraud)
                                            </th>
                                           
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $inheren['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 4 - Faktor Eksternal
                                            </th>
                                           
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil5" form="my_form" value="<?= $inheren['pil5_tingkat_risiko'] ?>" name="risiko_pil5" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                           
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil6" form="my_form" value="<?= $inheren['pil6_tingkat_risiko'] ?>" name="risiko_pil6" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th style="font-size: 18px;" scope="row" colspan="5">
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
                                        <tr style="font-size: 20px;">

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Operasional</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" maxlength="1000" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket['ket_inheren'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length['l6'] ?></span><span> / 1000</span>
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