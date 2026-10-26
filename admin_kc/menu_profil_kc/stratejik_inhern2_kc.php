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
CHAR_LENGTH(ket_pil3) AS l3,
CHAR_LENGTH(ket_pil4) AS l4,
CHAR_LENGTH(ket_inheren) AS l5 FROM keterangan_inheren2_stratejik WHERE id_profil_risiko = '$id'"));

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));

$pembanding_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$dp'"));
$pembanding_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$dp'"));

$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));

$respon1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$respon2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$respon3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$respon4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));

$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_stratejik WHERE id_profil_risiko = '$id'"));

if (isset($_POST['submit'])) {
    include "../conn/conn.php";

    $ket_pil1_1 = $_POST['ket_pil1_1'];
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
   



   mysqli_query($conn, "UPDATE keterangan_inheren2_stratejik SET 
   ket_pil1_1 = '$ket_pil1_1',
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

    header("Location: index.php?page=stra_inhern2&id=$id");
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
            $('#ket_pil3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_pil4').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
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

                        <h4 class="page-title">Risiko stratejik Inheren 2 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 2 Profil Risiko stratejik</h4>

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
                                                    <center><b>RISIKO STRATEJIK INHEREN 2</b></center>
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
                                                    <b>PILAR 1 : Penetapan Strategi Bisnis</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar1 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Penetapan Strategi Bisnis
                                            </th>
                                            <td>
                                           
                                            </td>
                                            <td width="10%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="60" rows="5" readonly><?= $respon1['ket_in_stra_pil1_1'] ?> <?= $respon1['ket_in_stra_pil1_1a'] ?> <?= $respon1['ket_in_stra_pil1_1b'] ?> <?= $respon1['ket_in_stra_pil1_1c'] ?> <?= $respon1['ket_in_stra_pil1_1d'] ?>  <?= $respon1['ket_in_stra_pil1_1e'] ?>  <?= $respon1['ket_in_stra_pil1_1f'] ?></textarea></td>
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
                                            Penetapan Strategi Bisnis
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
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
                                            Evaluasi Posisi Kompetitif di industri
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
                                            Analisa Faktor Eksternal
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
                                            Rencana Keberlangsungan Manajerial
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
                                            Kecukupan Sumber Daya
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
                                                f.
                                            </th>
                                            <th>
                                            Analisa Beban Kerja pada Seluruh Unit Kerja dalam mencapai target
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1e'] ?></center></td>

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
                                            Analisa Potensi Pasar
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1f'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1f'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>





                                        <!--pilar1 parameter3-->

                                    

                                
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis
                                            </th>
                                            <td>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                            
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_pil1" form="my_form" name="ket_pil1" cols="60" rows="5"><?= $ket['ket_pil1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 500</span></td>
                                            <td>
                                            
                                            </td>
                                            <td>
                                            
                                            </td>
                                        </tr>

                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 2 : Penyusunan Rencana Bisnis</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar2 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_1" form="my_form" value="<?= $pil2['hasil_pil2_par1'] ?>" name="total_inheren_pil2_1" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="60" rows="5" readonly><?= $respon2['ket_in_stra_pil2_1'] ?> <?= $respon2['ket_in_stra_pil2_1a'] ?> <?= $respon2['ket_in_stra_pil2_1b'] ?> <?= $respon2['ket_in_stra_pil2_1c'] ?> <?= $respon2['ket_in_stra_pil2_1d'] ?> <?= $respon2['ket_in_stra_pil2_1e'] ?> <?= $respon2['ket_in_stra_pil2_1f'] ?> <?= $respon2['ket_in_stra_pil2_1g'] ?> <?= $respon2['ket_in_stra_pil2_1h'] ?> <?= $respon2['ket_in_stra_pil2_1i'] ?></textarea></td>
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
                                            Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis
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
                                            Perubahan Lingkungan Bisnis
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
                                            Struktur Organisasi dan SDM
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
                                            Pengendalian Internal
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
                                            Analisa Produk Eksisting
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1e'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1e'] ?></center></td>

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
                                            Analisa Layanan Eksisting
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1f'] ?></center></td>

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
                                            Analisa Produk dan Layanan Baru
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1g'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1g'] ?></center></td>

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
                                            Identifikasi Perubahan Lingkungan Bisnis
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1h'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1h'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                    
                                       
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Keunggulan kompetitif BPR dan ancaman dari kompetitor
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="60" rows="5" readonly><?= $respon2['ket_in_stra_pil2_2'] ?> <?= $respon2['ket_in_stra_pil2_2a'] ?> <?= $respon2['ket_in_stra_pil2_2b'] ?>  <?= $respon2['ket_in_stra_pil2_2c'] ?></textarea></td>
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
                                            Keunggulan kompetitif BPR dan ancaman dari kompetitor
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
                                            Kondisi persaingan / kompetitor
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
                                            Preferensi Nasabah
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
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 -  Penyusunan Rencana Bisnis
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
                                            <td colspan="9">
                                                <h4>
                                                    <b>PILAR 3 : Pencapaian Target Bisnis</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar3 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil3_1" form="my_form" value="<?= $pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="60" rows="5" readonly><?= $respon3['ket_in_stra_pil3_1'] ?> <?= $respon3['ket_in_stra_pil3_1a'] ?> <?= $respon3['ket_in_stra_pil3_1b'] ?> <?= $respon3['ket_in_stra_pil3_1c'] ?> <?= $respon3['ket_in_stra_pil3_1d'] ?> <?= $respon3['ket_in_stra_pil3_1e'] ?> <?= $respon3['ket_in_stra_pil3_1f'] ?> <?= $respon3['ket_in_stra_pil3_1g'] ?> <?= $respon3['ket_in_stra_pil3_1h'] ?> <?= $respon3['ket_in_stra_pil3_1i'] ?> <?= $respon3['ket_in_stra_pil3_1j'] ?> <?= $respon3['ket_in_stra_pil3_1k'] ?> <?= $respon3['ket_in_stra_pil3_1l'] ?> <?= $respon3['ket_in_stra_pil3_1m'] ?> <?= $respon3['ket_in_stra_pil3_1n'] ?> <?= $respon3['ket_in_stra_pil3_1o'] ?> <?= $respon3['ket_in_stra_pil3_1p'] ?></textarea></td>
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
                                            Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas
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
                                            Capaian target kuantitatif terhadap 6 parameter kuantitaif
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1a'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
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
                                            Saldo Kredit Bermasalah
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1c'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
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
                                            Laba Sebelum Pajak
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
                                            NIM
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
                                            Komposisi Tabungan Terhadap Dana Pihak Ketiga
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
                                            Komposisi Deposito Terhadap Dana Pihak Ketiga
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
                                            Komposisi Pendapatan Bunga Kontraktual Terhadap Aset Produktif
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
                                            Komposisi Pendapatan Bunga Kontraktual Terhadap Pendapatan
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
                                            Komposisi Biaya Tenaga Kerja terhadap Beban Operasional
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1j'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1j'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                k.
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Aset
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1k'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1k'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                l.
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Kredit
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1l'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1l'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                m.
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Dana
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1m'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1m'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                n.
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Laba
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1n'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1n'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                o.
                                            </th>
                                            <th>
                                            Pertumbuhan Penyaluran pada Sektor Usaha Produktif
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1o'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1o'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                p.
                                            </th>
                                            <th>
                                            Penerimaan Hapus Buku
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1p'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1p'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil3_2" form="my_form" value="<?= $pil3['hasil_pil3_par2'] ?>"  name="total_inheren_pil3_2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_2" form="my_form" name="ket_pil3_2" cols="60" rows="5" readonly><?= $respon3['ket_in_stra_pil3_2'] ?> <?= $respon3['ket_in_stra_pil3_2a'] ?> <?= $respon3['ket_in_stra_pil3_2b'] ?> <?= $respon3['ket_in_stra_pil3_2c'] ?> <?= $respon3['ket_in_stra_pil3_2d'] ?> <?= $respon3['ket_in_stra_pil3_2e'] ?> <?= $respon3['ket_in_stra_pil3_2f'] ?></textarea></td>
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
                                            Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis
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
                                            Capaian target kualitatif
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
                                            Realisasi Pemenuhan Jumlah SDM Terhadap Target RBB
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2b'] ?></center>
                                            </td>
                                            <td  colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2b'] ?></center></td>

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
                                            Realisasi Waktu Pemenuhan SDM
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
                                                e.
                                            </th>
                                            <th>
                                            Realisasi Modul Pelatihan dan Pendidikan Terhadap Target
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
                                               f.
                                            </th>
                                            <th>
                                            Realisasi Pemindahan Jaringan Kantor
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_2f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_2f'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>



                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis
                                            </th>
                                            <td>
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil3" form="my_form" value="<?= $inheren['pil3_tertinggi'] ?>" name="tertinggi_pil3" class="form-control"  readonly="">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil3" form="my_form" value="<?= $inheren['pil3_terendah'] ?>" name="terendah_pil3"  class="form-control"  readonly="">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil3" form="my_form" value="<?= $inheren['pil3_rata_rata'] ?>" name="rata_rata_pil3" class="form-control"  readonly="">
                                            <br></br>
                                            <hr></hr>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" maxlength="500" id="ket_pil3" form="my_form" name="ket_pil3" cols="60" rows="10"><?= $ket['ket_pil3'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length['l3'] ?></span><span> / 500</span></td>
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
                                            <td><textarea class="form-control" id="ket_pil4_1" form="my_form" name="ket_pil4_1" cols="60" rows="5" readonly><?= $respon4['ket_in_stra_pil4_1a'] ?> <?= $respon4['ket_in_stra_pil4_1b'] ?> <?= $respon4['ket_in_stra_pil4_1c'] ?> <?= $respon4['ket_in_stra_pil4_1d'] ?> </textarea></td>
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
                                            Evaluasi Isu Stratejik Akibat Perubahan Lingkungan Bisnis
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
                                            Evaluasi Capaian Target RBB
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
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            <td>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $inheren['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" maxlength="500" id="ket_pil4" form="my_form" name="ket_pil4" cols="60" rows="5"><?= $ket['ket_pil4'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length['l4'] ?></span><span> / 500</span></td>
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

                                            <th style="font-size: 20px;" colspan="9">
                                                <center>REKAP PENILAIAN INHEREN STRATEJIK</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $inheren['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
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
                                        <tr>

                                            <th style="font-size: 20px;" colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Stratejik</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" maxlength="1000" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket['ket_inheren'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length['l5'] ?></span><span> / 1000</span></th>

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