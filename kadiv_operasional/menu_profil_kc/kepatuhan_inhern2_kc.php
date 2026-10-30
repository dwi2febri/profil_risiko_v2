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
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN periode_laporan_profil_risiko ON frame_laporan_profil_risiko.periode = periode_laporan_profil_risiko.id_periode
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang WHERE id_profil_risiko = ?", [$id]));
$dp = $frame['data_pembanding'];


$length = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_pil1) AS l1,
CHAR_LENGTH(ket_pil2) AS l2,
CHAR_LENGTH(ket_pil3) AS l3,
CHAR_LENGTH(ket_inheren) AS l4 FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko = ?", [$id]));

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$dp]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = ?", [$id]));

$respon1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$id]));
$respon2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$id]));
$respon3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$id]));

$ket = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko = ?", [$id]));

if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

    $ket_pil1_1 = $_POST['ket_pil1_1'];
    $ket_pil1_2 = $_POST['ket_pil1_2'];
    $ket_pil1 = $_POST['ket_pil1'];
    $ket_pil2_1 = $_POST['ket_pil2_1'];
    $ket_pil2_2 = $_POST['ket_pil2_2'];
    $ket_pil2_3 = $_POST['ket_pil2_3'];
    $ket_pil2 = $_POST['ket_pil2'];
    $ket_pil3_1 = $_POST['ket_pil3_1'];
    $ket_pil3 = $_POST['ket_pil3'];
   
    $ket_inheren = $_POST['ket_inheren'];
   



    simpro_db_query($conn, "UPDATE keterangan_inheren2_kepatuhan SET 
   ket_pil1_1 = ?,
   ket_pil1_2 = ?,
   ket_pil1 = ?,
   ket_pil2_1 = ?,
   ket_pil2_2 = ?,
   ket_pil2_3 = ?,
   ket_pil2 = ?,
   ket_pil3_1 = ?,
   ket_pil3 = ?,
   ket_inheren = ?
    WHERE id_profil_risiko = ?", [$ket_pil1_1, $ket_pil1_2, $ket_pil1, $ket_pil2_1, $ket_pil2_2, $ket_pil2_3, $ket_pil2, $ket_pil3_1, $ket_pil3, $ket_inheren, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kep_inhern2&id=$id");
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
            $('#ket_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
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

                        <h4 class="page-title">Risiko Kepatuhan Inheren 2 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 2 Profil Risiko Kepatuhan</h4>

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
                                                    <center><b>RISIKO KEPATUHAN INHEREN 2</b></center>
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
                                                    <b>PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar1 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Jenis dan SIgnifikasi Pelanggaran
                                            </th>
                                            <td>
                                           
                                            </td>
                                            <td width="10%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren1" form="my_form" value="<?= $pil1['hasil_pil1_par1'] ?>" name="total_inheren1" class="form-control" readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_1" form="my_form" name="ket_pil1_1" cols="60" rows="5" readonly><?= $respon1['ket_in_kep_pil1_1'] ?> <?= $respon1['ket_in_kep_pil1_1a'] ?> <?= $respon1['ket_in_kep_pil1_1b'] ?> <?= $respon1['ket_in_kep_pil1_1c'] ?> <?= $respon1['ket_in_kep_pil1_1d'] ?> <?= $respon1['ket_in_kep_pil1_1e'] ?> <?= $respon1['ket_in_kep_pil1_1f'] ?> <?= $respon1['ket_in_kep_pil1_1g'] ?></textarea></td>
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
                                            Jenis dan SIgnifikasi Pelanggaran
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
                                            Frekuensi Pelanggaran
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
                                            Frekuensi Pelanggaran Ketentuan Internal dan Prosedur
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1f'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1f'] ?></center></td>

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
                                            Sebaran Jenis Pelanggaran Ketentuan Internal dan Prosedur
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_1g'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_1g'] ?></center></td>

                                            <td>
                                            </td>
                                        </tr>

                                        


                                <!--pilar1 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Signifikasi Tindak Lanjut Atas Temuan Pelanggaran
                                            </b>
                                            <td>
                                            </td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren2" form="my_form" value="<?= $pil1['hasil_pil1_par2'] ?>" name="total_inheren2" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil1_2" form="my_form" name="ket_pil1_2" cols="60" rows="5" readonly><?= $respon1['ket_in_kep_pil1_2'] ?> <?= $respon1['ket_in_kep_pil1_2a'] ?> <?= $respon1['ket_in_kep_pil1_2b'] ?> <?= $respon1['ket_in_kep_pil1_2c'] ?> <?= $respon1['ket_in_kep_pil1_2d'] ?> <?= $respon1['ket_in_kep_pil1_2e'] ?> <?= $respon1['ket_in_kep_pil1_2f'] ?> <?= $respon1['ket_in_kep_pil1_2g'] ?> <?= $respon1['ket_in_kep_pil1_2h'] ?></textarea></td>
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
                                            Signifikasi Tindak Lanjut Atas Temuan Pelanggaran
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
                                            Pengembangan Budaya Patuh Pada Semua Jenjang Organisasi
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
                                            Implementasi Kebijakan dan Prosedur Penerbitan Produk dan/atau Pelaksanaan Aktivitas Baru
                                            </th>
                                            <td>
                                            <center><?= $pil1['pilar1_2c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil1['pilar1_2c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>




                                        

                                        <!--pilar1 parameter3-->

                                    

                                
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 - Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain
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
                                                    <b>PILAR 2 : Faktor Kelemahan Aspek Hukum</b>
                                                </h4>
                                            </td>



                                        </tr>

                                <!--pilar2 parameter1-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Kelemahan Dalam Perikatan
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_1" form="my_form" value="<?= $pil2['hasil_pil2_par1'] ?>" name="total_inheren_pil2_1" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_1" form="my_form" name="ket_pil2_1" cols="60" rows="5" readonly><?= $respon2['ket_in_kep_pil2_1'] ?> <?= $respon2['ket_in_kep_pil2_1a'] ?></textarea></td>
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
                                            Kelemahan Dalam Perikatan
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_1'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_1'] ?></center></td>

                                            <td>
                                            </td>

                                           
                                        </tr>

                                    

                                       
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_2" form="my_form" value="<?= $pil2['hasil_pil2_par2'] ?>" name="total_inheren_pil2_2" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_2" form="my_form" name="ket_pil2_2" cols="60" rows="5" readonly><?= $respon2['ket_in_kep_pil2_2'] ?> <?= $respon2['ket_in_kep_pil2_2a'] ?></textarea></td>
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
                                            Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan
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
                                            Pendampingan Hukum
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_2a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_2a'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                      
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap
                                            </th>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_inheren_pil2_3" form="my_form" value="<?= $pil2['hasil_pil2_par3'] ?>" name="total_inheren_pil2_3" class="form-control"  readonly="">
                                            <td><textarea class="form-control" id="ket_pil2_3" form="my_form" name="ket_pil2_3" cols="60" rows="5" readonly><?= $respon2['ket_in_kep_pil2_3'] ?> <?= $respon2['ket_in_kep_pil2_3a'] ?></textarea></td>
                                            <td></td>
                                            <td width="8%">
                                            <center>Nilai periode sebelumnya</center>
                                            <input type="number" id="total_inheren_pil2_3" form="my_form" value="<?= $pembanding_pil2['hasil_pil2_par3'] ?>" name="total_inheren_pil2_3" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_3'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_3'] ?></center></td>

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
                                            Kerugian Akibat Putusan Pengadilan Berkekuatan Hukum Tetap
                                            </th>
                                            <td>
                                            <center><?= $pil2['pilar2_3a'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil2['pilar2_3a'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 -  Faktor Kelemahan Aspek Hukum
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
                                            <input type="number" id="total_inheren_pil3_1" form="my_form" value="<?= $pil3['hasil_pil3_par1'] ?>"  name="total_inheren_pil3_1" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" id="ket_pil3_1" form="my_form" name="ket_pil3_1" cols="60" rows="5" readonly><?= $respon3['ket_in_kep_pil3_1a'] ?> <?= $respon3['ket_in_kep_pil3_1b'] ?> <?= $respon3['ket_in_kep_pil3_1c'] ?> <?= $respon3['ket_in_kep_pil3_1d'] ?> <?= $respon3['ket_in_kep_pil3_1e'] ?> <?= $respon3['ket_in_kep_pil3_1f'] ?> <?= $respon3['ket_in_kep_pil3_1g'] ?></textarea></td>
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
                                                b.
                                            </th>
                                            <th>
                                            Komitmen Capaian Target RBB
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
                                            Teladan Pucuk Pimpinan	
                                            </th>
                                            <td>
                                            <center><?= $pil3['pilar3_1c'] ?></center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td><center><?= $pembanding_pil3['pilar3_1c'] ?></center></td>

                                            <td>
                                            </td>

                                            
                                        </tr>

  

                                       


                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="4">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            <td>
                                            <center>Risiko ditetapkan</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td><textarea class="form-control" maxlength="500" id="ket_pil3" form="my_form" name="ket_pil3" cols="60" rows="5"><?= $ket['ket_pil3'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length['l3'] ?></span><span> / 500</span></td>
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
                                                <center>REKAP PENILAIAN INHEREN KEPATUHAN</center>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 1 - Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain
                                            </th>
                                            
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $inheren['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Pilar 2 - Faktor Kelemahan Aspek Hukum
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $inheren['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th style="font-size: 18px;" scope="row" colspan="8">
                                            Hasil Penilaian Lainnya
                                            </th>
                                            
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $inheren['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
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
                                                <center>Uraian Untuk Risiko Inheren Kepatuhan</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control" maxlength="1000" id="ket_inheren" form="my_form" name="ket_inheren" cols="60" rows="10"><?= $ket['ket_inheren'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length['l4'] ?></span><span> / 1000</span></th>

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