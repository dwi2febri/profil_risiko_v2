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
$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT user,tahun,periode FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ?", [$id]));
$jenis_pr = $frame['user'];
$tahun = $frame['tahun'];
$periode = $frame['periode'];

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_operasional_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_operasional_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_operasional_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_operasional_pilar4 WHERE id_profil_risiko = ?", [$id]));

$kpmr = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_kpmr_operasional WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$hasil = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = ?", [$id]));

$respon1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko = ?", [$id]));
$respon2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko = ?", [$id]));
$respon3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko = ?", [$id]));
$respon4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko = ?", [$id]));

//setingan ditetapkan
$set_pil1 = $kpmr['kpmr_op_set_pil1'];
$set_pil2 = $kpmr['kpmr_op_set_pil2'];
$set_pil3 = $kpmr['kpmr_op_set_pil3'];
$set_pil4 = $kpmr['kpmr_op_set_pil4'];
$set_hsl = $kpmr['kpmr_op_set_tingkat_risiko'];


if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

        //pilar 1
    $pilar1_1a = $_POST['kpmr1a'];
    $pilar1_1b = $_POST['kpmr1b'];
    $pilar1_1c = $_POST['kpmr1c'];
    $pilar1_1d = $_POST['kpmr1d'];
    $pilar1_1e = $_POST['kpmr1e'];

    $pil1_total1 = $_POST['total_kpmr1'];
    $pil1_peringkat1 = $_POST['peringkat_kpmr1'];

    $pilar1_2a = $_POST['kpmr2a'];
    $pilar1_2b = $_POST['kpmr2b'];
    $pilar1_2c = $_POST['kpmr2c'];
    $pilar1_2d = $_POST['kpmr2d'];
    $pilar1_2e = $_POST['kpmr2e'];

    $pil1_total2 = $_POST['total_kpmr2'];
    $pil1_peringkat2 = $_POST['peringkat_kpmr2'];

    $pilar1_3a = $_POST['kpmr3a'];
    $pilar1_3b = $_POST['kpmr3b'];
    $pilar1_3c = $_POST['kpmr3c'];

    $pil1_total3 = $_POST['total_kpmr3'];
    $pil1_peringkat3 = $_POST['peringkat_kpmr3'];

    $pilar1_4a = $_POST['kpmr4a'];
    $pilar1_4b = $_POST['kpmr4b'];
    $pilar1_4c = $_POST['kpmr4c'];
    $pilar1_4d = $_POST['kpmr4d'];
    $pilar1_4e = $_POST['kpmr4e'];

    $pil1_total4 = $_POST['total_kpmr4'];
    $pil1_peringkat4 = $_POST['peringkat_kpmr4'];

    $pilar1_5a = $_POST['kpmr5a'];
    $pilar1_5b = $_POST['kpmr5b'];
    $pilar1_5c = $_POST['kpmr5c'];
    $pilar1_5d = $_POST['kpmr5d'];

    $pil1_total5 = $_POST['total_kpmr5'];
    $pil1_peringkat5 = $_POST['peringkat_kpmr5'];

    $pilar1_6a = $_POST['kpmr6a'];
    $pilar1_6b = $_POST['kpmr6b'];
    $pilar1_6c = $_POST['kpmr6c'];

    $pil1_total6 = $_POST['total_kpmr6'];
    $pil1_peringkat6 = $_POST['peringkat_kpmr6'];


    //pilar 2

    $pilar2_1a = $_POST['kpmr_pil2_1a'];
    $pilar2_1b = $_POST['kpmr_pil2_1b'];
    $pilar2_1c = $_POST['kpmr_pil2_1c'];
    $pilar2_1d = $_POST['kpmr_pil2_1d'];
    $pilar2_1e = $_POST['kpmr_pil2_1e'];

    $pil2_total1 = $_POST['total_kpmr_pil2_1'];
    $pil2_peringkat1 = $_POST['peringkat_kpmr_pil2_1'];

    $pilar2_2a = $_POST['kpmr_pil2_2a'];
    $pilar2_2b = $_POST['kpmr_pil2_2b'];
    $pilar2_2c = $_POST['kpmr_pil2_2c'];
    $pilar2_2d = $_POST['kpmr_pil2_2d'];
    $pilar2_2e = $_POST['kpmr_pil2_2e'];
    $pilar2_2f = $_POST['kpmr_pil2_2f'];
    $pilar2_2g = $_POST['kpmr_pil2_2g'];
    $pilar2_2h = $_POST['kpmr_pil2_2h'];

    $pil2_total2 = $_POST['total_kpmr_pil2_2'];
    $pil2_peringkat2 = $_POST['peringkat_kpmr_pil2_2'];

    $pilar2_3a = $_POST['kpmr_pil2_3a'];
    $pilar2_3b = $_POST['kpmr_pil2_3b'];
    $pilar2_3c = $_POST['kpmr_pil2_3c'];

    $pil2_total3 = $_POST['total_kpmr_pil2_3'];
    $pil2_peringkat3 = $_POST['peringkat_kpmr_pil2_3'];

    //pilar 3
    $pilar3_1a = $_POST['kpmr_pil3_1a'];
    $pilar3_1b = $_POST['kpmr_pil3_1b'];
    $pilar3_1c = $_POST['kpmr_pil3_1c'];
    $pilar3_1d = $_POST['kpmr_pil3_1d'];
    $pilar3_1e = $_POST['kpmr_pil3_1e'];
    $pilar3_1f = $_POST['kpmr_pil3_1f'];
    $pilar3_1g = $_POST['kpmr_pil3_1g'];
    $pilar3_1h = $_POST['kpmr_pil3_1h'];
    $pilar3_1i = $_POST['kpmr_pil3_1i'];
    $pilar3_1j = $_POST['kpmr_pil3_1j'];

    $pil3_total1 = $_POST['total_kpmr_pil3_1'];
    $pil3_peringkat1 = $_POST['peringkat_kpmr_pil3_1'];

    $pilar3_2a = $_POST['kpmr_pil3_2a'];
    $pilar3_2b = $_POST['kpmr_pil3_2b'];
    $pilar3_2c = $_POST['kpmr_pil3_2c'];
    $pilar3_2d = $_POST['kpmr_pil3_2d'];
    $pilar3_2e = $_POST['kpmr_pil3_2e'];

    $pil3_total2 = $_POST['total_kpmr_pil3_2'];
    $pil3_peringkat2 = $_POST['peringkat_kpmr_pil3_2'];

    $pilar3_3a = $_POST['kpmr_pil3_3a'];
    $pilar3_3b = $_POST['kpmr_pil3_3b'];
    $pilar3_3c = $_POST['kpmr_pil3_3c'];

    $pil3_total3 = $_POST['total_kpmr_pil3_3'];
    $pil3_peringkat3 = $_POST['peringkat_kpmr_pil3_3'];

    $pilar3_4a = $_POST['kpmr_pil3_4a'];
    $pilar3_4b = $_POST['kpmr_pil3_4b'];
    $pilar3_4c = $_POST['kpmr_pil3_4c'];

    $pil3_total4 = $_POST['total_kpmr_pil3_4'];
    $pil3_peringkat4 = $_POST['peringkat_kpmr_pil3_4'];

    //pilar 4
    $pilar4_1a = $_POST['kpmr_pil4_1a'];
    $pilar4_1b = $_POST['kpmr_pil4_1b'];
    $pilar4_1c = $_POST['kpmr_pil4_1c'];
    $pilar4_1d = $_POST['kpmr_pil4_1d'];
    $pilar4_1e = $_POST['kpmr_pil4_1e'];

    $pil4_total1 = $_POST['total_kpmr_pil4_1'];
    $pil4_peringkat1 = $_POST['peringkat_kpmr_pil4_1'];

    $pilar4_2a = $_POST['kpmr_pil4_2a'];
    $pilar4_2b = $_POST['kpmr_pil4_2b'];

    $pil4_total2 = $_POST['total_kpmr_pil4_2'];
    $pil4_peringkat2 = $_POST['peringkat_kpmr_pil4_2'];

    //Hasil KPMR
    $pil1_tertinggi = $_POST['tertinggi_pil1'];
    $pil1_terendah = $_POST['terendah_pil1'];
    $pil1_rata_rata = $_POST['rata_rata_pil1'];
    $pil1_risiko_ditetapkan	= $_POST['opsi_pil1'];
    $pil1_tingkat_risiko = $_POST['risiko_pil1'];

    $pil2_tertinggi = $_POST['tertinggi_pil2'];
    $pil2_terendah = $_POST['terendah_pil2'];
    $pil2_rata_rata = $_POST['rata_rata_pil2'];
    $pil2_risiko_ditetapkan	= $_POST['opsi_pil2'];
    $pil2_tingkat_risiko = $_POST['risiko_pil2'];

    $pil3_tertinggi = $_POST['tertinggi_pil3'];
    $pil3_terendah = $_POST['terendah_pil3'];
    $pil3_rata_rata = $_POST['rata_rata_pil3'];
    $pil3_risiko_ditetapkan	= $_POST['opsi_pil3'];
    $pil3_tingkat_risiko = $_POST['risiko_pil3'];

    $pil4_tertinggi = $_POST['tertinggi_pil4'];
    $pil4_terendah = $_POST['terendah_pil4'];
    $pil4_rata_rata = $_POST['rata_rata_pil4'];
    $pil4_risiko_ditetapkan	= $_POST['opsi_pil4'];
    $pil4_tingkat_risiko = $_POST['risiko_pil4'];

    $hasil_kpmr_tertinggi = $_POST['tertinggi_kpmr'];
    $hasil_kpmr_terendah = $_POST['terendah_kpmr'];
    $hasil_kpmr_rata_rata = $_POST['rata_rata_kpmr'];
    $hasil_risiko_ditetapkan = $_POST['opsi_kpmr'];
    $hasil_tingkat_risiko = $_POST['risiko_kpmr'];
    $hasil_peringkat = $_POST['peringkat_kpmr'];

    //respon unit kerja
    $respon_pil1_1a = $_POST['respon_pil1_1a'];
    $respon_pil1_1b = $_POST['respon_pil1_1b'];
    $respon_pil1_1c = $_POST['respon_pil1_1c'];
    $respon_pil1_1d = $_POST['respon_pil1_1d'];
    $respon_pil1_1e = $_POST['respon_pil1_1e'];
    $respon_pil1_2a = $_POST['respon_pil1_2a'];
    $respon_pil1_2b = $_POST['respon_pil1_2b'];
    $respon_pil1_2c = $_POST['respon_pil1_2c'];
    $respon_pil1_2d = $_POST['respon_pil1_2d'];
    $respon_pil1_2e = $_POST['respon_pil1_2e'];
    $respon_pil1_3a = $_POST['respon_pil1_3a'];
    $respon_pil1_3b = $_POST['respon_pil1_3b'];
    $respon_pil1_3c = $_POST['respon_pil1_3c'];
    $respon_pil1_4a = $_POST['respon_pil1_4a'];
    $respon_pil1_4b = $_POST['respon_pil1_4b'];
    $respon_pil1_4c = $_POST['respon_pil1_4c'];
    $respon_pil1_4d = $_POST['respon_pil1_4d'];
    $respon_pil1_4e = $_POST['respon_pil1_4e'];
    $respon_pil1_5a = $_POST['respon_pil1_5a'];
    $respon_pil1_5b = $_POST['respon_pil1_5b'];
    $respon_pil1_5c = $_POST['respon_pil1_5c'];
    $respon_pil1_5d = $_POST['respon_pil1_5d'];
    $respon_pil1_6a = $_POST['respon_pil1_6a'];
    $respon_pil1_6b = $_POST['respon_pil1_6b'];
    $respon_pil1_6c = $_POST['respon_pil1_6c'];

    $respon_pil2_1a = $_POST['respon_pil2_1a'];
    $respon_pil2_1b = $_POST['respon_pil2_1b'];
    $respon_pil2_1c = $_POST['respon_pil2_1c'];
    $respon_pil2_1d = $_POST['respon_pil2_1d'];
    $respon_pil2_1e = $_POST['respon_pil2_1e'];
    $respon_pil2_2a = $_POST['respon_pil2_2a'];
    $respon_pil2_2b = $_POST['respon_pil2_2b'];
    $respon_pil2_2c = $_POST['respon_pil2_2c'];
    $respon_pil2_2d = $_POST['respon_pil2_2d'];
    $respon_pil2_2e = $_POST['respon_pil2_2e'];
    $respon_pil2_2f = $_POST['respon_pil2_2f'];
    $respon_pil2_2g = $_POST['respon_pil2_2g'];
    $respon_pil2_2h = $_POST['respon_pil2_2h'];
    $respon_pil2_3a = $_POST['respon_pil2_3a'];
    $respon_pil2_3b = $_POST['respon_pil2_3b'];
    $respon_pil2_3c = $_POST['respon_pil2_3c'];

    $respon_pil3_1a = $_POST['respon_pil3_1a'];
    $respon_pil3_1b = $_POST['respon_pil3_1b'];
    $respon_pil3_1c = $_POST['respon_pil3_1c'];
    $respon_pil3_1d = $_POST['respon_pil3_1d'];
    $respon_pil3_1e = $_POST['respon_pil3_1e'];
    $respon_pil3_1f = $_POST['respon_pil3_1f'];
    $respon_pil3_1g = $_POST['respon_pil3_1g'];
    $respon_pil3_1h = $_POST['respon_pil3_1h'];
    $respon_pil3_1i = $_POST['respon_pil3_1i'];
    $respon_pil3_1j = $_POST['respon_pil3_1j'];
    $respon_pil3_2a = $_POST['respon_pil3_2a'];
    $respon_pil3_2b = $_POST['respon_pil3_2b'];
    $respon_pil3_2c = $_POST['respon_pil3_2c'];
    $respon_pil3_2d = $_POST['respon_pil3_2d'];
    $respon_pil3_2e = $_POST['respon_pil3_2e'];
    $respon_pil3_3a = $_POST['respon_pil3_3a'];
    $respon_pil3_3b = $_POST['respon_pil3_3b'];
    $respon_pil3_3c = $_POST['respon_pil3_3c'];
    $respon_pil3_4a = $_POST['respon_pil3_4a'];
    $respon_pil3_4b = $_POST['respon_pil3_4b'];
    $respon_pil3_4c = $_POST['respon_pil3_4c'];

    $respon_pil4_1a = $_POST['respon_pil4_1a'];
    $respon_pil4_1b = $_POST['respon_pil4_1b'];
    $respon_pil4_1c = $_POST['respon_pil4_1c'];
    $respon_pil4_1d = $_POST['respon_pil4_1d'];
    $respon_pil4_1e = $_POST['respon_pil4_1e'];
    $respon_pil4_2a = $_POST['respon_pil4_2a'];
    $respon_pil4_2b = $_POST['respon_pil4_2b'];



    //rumus hasil pilar 1


    if ($set_pil1 == 1) {
        $numbers = array($pil1_total1 , $pil1_total2, $pil1_total3, $pil1_total4, $pil1_total5, $pil1_total6);
        $maxValue = max($numbers);

        $pil1_tingkat_risiko = $maxValue ;
    } else if ($set_pil1 == 2) {
        $numbers = array($pil1_total1 , $pil1_total2, $pil1_total3, $pil1_total4, $pil1_total5, $pil1_total6);
        $minValue = min($numbers);

        $pil1_tingkat_risiko = $minValue;
    } else if ($set_pil1 == 3) {
        $numbers = array($pil1_total1 , $pil1_total2, $pil1_total3, $pil1_total4, $pil1_total5, $pil1_total6);
        $sum = array_sum($numbers);
        $average = $sum / count($numbers);

        $pil1_tingkat_risiko = $average;
    } else {
       $pil1_tingkat_risiko = 0;
    }


    //rumus hasil pilar 2
    if ($set_pil2 == 1) {
        $numbers = array($pil2_total1 , $pil2_total2, $pil2_total3);
        $maxValue = max($numbers);

        $pil2_tingkat_risiko = $maxValue ;
    } else if ($set_pil2 == 2) {
        $numbers = array($pil2_total1 , $pil2_total2, $pil2_total3);
        $minValue = min($numbers);

        $pil2_tingkat_risiko = $minValue;
    } else if ($set_pil2 == 3) {
        $numbers = array($pil2_total1 , $pil2_total2, $pil2_total3);
        $sum = array_sum($numbers);
        $average = $sum / count($numbers);

        $pil2_tingkat_risiko = $average;
    } else {
       $pil2_tingkat_risiko = 0;
    }

    //rumus hasil pilar 3
    if ($set_pil3 == 1) {
        $numbers = array($pil3_total1 , $pil3_total2, $pil3_total3, $pil3_total4);
        $maxValue = max($numbers);

        $pil3_tingkat_risiko = $maxValue ;
    } else if ($set_pil3 == 2) {
        $numbers = array($pil3_total1 , $pil3_total2, $pil3_total3, $pil3_total4);
        $minValue = min($numbers);

        $pil3_tingkat_risiko = $minValue;
    } else if ($set_pil3 == 3) {
        $numbers = array($pil3_total1 , $pil3_total2, $pil3_total3, $pil3_total4);
        $sum = array_sum($numbers);
        $average = $sum / count($numbers);

        $pil3_tingkat_risiko = $average;
    } else {
       $pil3_tingkat_risiko = 0;
    }


    //rumus hasil pilar 4
    if ($set_pil4 == 1) {
        $numbers = array($pil4_total1 , $pil4_total2);
        $maxValue = max($numbers);

        $pil4_tingkat_risiko = $maxValue ;
    } else if ($set_pil4 == 2) {
        $numbers = array($pil4_total1 , $pil4_total2);
        $minValue = min($numbers);

        $pil4_tingkat_risiko = $minValue;
    } else if ($set_pil4 == 3) {
        $numbers = array($pil4_total1 , $pil4_total2);
        $sum = array_sum($numbers);
        $average = $sum / count($numbers);

        $pil4_tingkat_risiko = $average;
    } else {
    $pil4_tingkat_risiko = 0;
    }


    //rumus hasil 
    $hsl_max_numbers = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $pil4_tingkat_risiko);
    $hasil_kpmr_tertinggi = max($hsl_max_numbers);

    $hsl_min_numbers = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $pil4_tingkat_risiko);
    $hasil_kpmr_terendah = min($hsl_min_numbers);

    $hsl_avg_numbers = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $pil4_tingkat_risiko);
    $sum = array_sum($hsl_avg_numbers);
    $hasil_kpmr_rata_rata = $sum / count($hsl_avg_numbers);

    if ($set_hsl == 1) {

        $hasil_tingkat_risiko = $hasil_kpmr_tertinggi ;
    } else if ($set_hsl == 2) {

        $hasil_tingkat_risiko = $hasil_kpmr_terendah;
    } else if ($set_hsl == 3) {

        $hasil_tingkat_risiko = $hasil_kpmr_rata_rata;
    } else {
    $hasil_tingkat_risiko = 0;
    }

    //hasil peringkat
    if ($hasil_tingkat_risiko < 1.00) {
        $hasil_peringkat = "Belum Terisi";
   } else if ($hasil_tingkat_risiko >= 1.00 && $hasil_tingkat_risiko <= 1.25) {
        $hasil_peringkat = "Sangat Memadai";
   } else if ($hasil_tingkat_risiko > 1.25 && $hasil_tingkat_risiko <= 2.25) {
        $hasil_peringkat = "Memadai";
   } else if ($hasil_tingkat_risiko > 2.25 && $hasil_tingkat_risiko <= 3.25) {
        $hasil_peringkat = "Cukup Memadai";
   } else if ($hasil_tingkat_risiko > 3.25 && $hasil_tingkat_risiko <= 4.25) {
        $hasil_peringkat = "Kurang Memadai";
   } else if ($hasil_tingkat_risiko > 4.25 && $hasil_tingkat_risiko <= 5.00) {
        $hasil_peringkat = "Tidak Memadai";
   } else {
        $hasil_peringkat = "Belum Terisi";
   }



    simpro_db_query($conn, "UPDATE kpmr_operasional_pilar1 SET 
    pilar1_1a = ?,
    pilar1_1b = ?,
    pilar1_1c = ?,
    pilar1_1d = ?,
    pilar1_1e = ?,
    pil1_total1 = ?,
    pil1_peringkat1 = ?,
    pilar1_2a = ?,
    pilar1_2b = ?,
    pilar1_2c = ?,
    pilar1_2d = ?,
    pilar1_2e = ?,
    pil1_total2 = ?,
    pil1_peringkat2 = ?,
    pilar1_3a = ?,
    pilar1_3b = ?,
    pilar1_3c = ?,
    pil1_total3 = ?,
    pil1_peringkat3 = ?,
    pilar1_4a = ?,
    pilar1_4b = ?,
    pilar1_4c = ?,
    pilar1_4d = ?,
    pilar1_4e = ?,
    pil1_total4 = ?,
    pil1_peringkat4 = ?,
    pilar1_5a = ?,
    pilar1_5b = ?,
    pilar1_5c = ?,
    pilar1_5d = ?,
    pil1_total5 = ?,
    pil1_peringkat5 = ?,
    pilar1_6a = ?,
    pilar1_6b = ?,
    pilar1_6c = ?,
    pil1_total6 = ?,
    pil1_peringkat6 = ?
    WHERE id_profil_risiko = ?", [$pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pil1_total1, $pil1_peringkat1, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d, $pilar1_2e, $pil1_total2, $pil1_peringkat2, $pilar1_3a, $pilar1_3b, $pilar1_3c, $pil1_total3, $pil1_peringkat3, $pilar1_4a, $pilar1_4b, $pilar1_4c, $pilar1_4d, $pilar1_4e, $pil1_total4, $pil1_peringkat4, $pilar1_5a, $pilar1_5b, $pilar1_5c, $pilar1_5d, $pil1_total5, $pil1_peringkat5, $pilar1_6a, $pilar1_6b, $pilar1_6c, $pil1_total6, $pil1_peringkat6, $id]);


    simpro_db_query($conn, "UPDATE kpmr_operasional_pilar2 SET 
    pilar2_1a = ?,
    pilar2_1b = ?,
    pilar2_1c = ?,
    pilar2_1d = ?,
    pilar2_1e = ?,
    pil2_total1 = ?,
    pil2_peringkat1 = ?,
    pilar2_2a = ?,
    pilar2_2b = ?,
    pilar2_2c = ?,
    pilar2_2d = ?,
    pilar2_2e = ?,
    pilar2_2f = ?,
    pilar2_2g = ?,
    pilar2_2h = ?,
    pil2_total2 = ?,
    pil2_peringkat2 = ?,
    pilar2_3a = ?,
    pilar2_3b = ?,
    pilar2_3c = ?,
    pil2_total3 = ?,
    pil2_peringkat3 = ?
    WHERE id_profil_risiko = ?", [$pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pil2_total1, $pil2_peringkat1, $pilar2_2a, $pilar2_2b, $pilar2_2c, $pilar2_2d, $pilar2_2e, $pilar2_2f, $pilar2_2g, $pilar2_2h, $pil2_total2, $pil2_peringkat2, $pilar2_3a, $pilar2_3b, $pilar2_3c, $pil2_total3, $pil2_peringkat3, $id]);


    simpro_db_query($conn, "UPDATE kpmr_operasional_pilar3 SET 
    pilar3_1a = ?,
    pilar3_1b = ?,
    pilar3_1c = ?,
    pilar3_1d = ?,
    pilar3_1e = ?,
    pilar3_1f = ?,
    pilar3_1g = ?,
    pilar3_1h = ?,
    pilar3_1i = ?,
    pilar3_1j = ?,
    pil3_total1 = ?,
    pil3_peringkat1 = ?,
    pilar3_2a = ?,
    pilar3_2b = ?,
    pilar3_2c = ?,
    pilar3_2d = ?,
    pilar3_2e = ?,
    pil3_total2 = ?,
    pil3_peringkat2 = ?,
    pilar3_3a = ?,
    pilar3_3b = ?,
    pilar3_3c = ?,
    pil3_total3 = ?,
    pil3_peringkat3 = ?,
    pilar3_4a = ?,
    pilar3_4b = ?,
    pilar3_4c = ?,
    pil3_total4 = ?,
    pil3_peringkat4 = ?
   WHERE id_profil_risiko = ?", [$pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pil3_total1, $pil3_peringkat1, $pilar3_2a, $pilar3_2b, $pilar3_2c, $pilar3_2d, $pilar3_2e, $pil3_total2, $pil3_peringkat2, $pilar3_3a, $pilar3_3b, $pilar3_3c, $pil3_total3, $pil3_peringkat3, $pilar3_4a, $pilar3_4b, $pilar3_4c, $pil3_total4, $pil3_peringkat4, $id]);


    simpro_db_query($conn, "UPDATE kpmr_operasional_pilar4 SET 
    pilar4_1a = ?,
    pilar4_1b = ?,
    pilar4_1c = ?,
    pilar4_1d = ?,
    pilar4_1e = ?,
    pil4_total1 = ?,
    pil4_peringkat1 = ?,
    pilar4_2a = ?,
    pilar4_2b = ?,
    pil4_total2 = ?,
    pil4_peringkat2 = ?
    WHERE id_profil_risiko = ?", [$pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d, $pilar4_1e, $pil4_total1, $pil4_peringkat1, $pilar4_2a, $pilar4_2b, $pil4_total2, $pil4_peringkat2, $id]);

    simpro_db_query($conn, "UPDATE hasil_kpmr_operasional SET 
    pil1_tertinggi = ?,
    pil1_terendah = ?,
    pil1_rata_rata = ?,
    pil1_risiko_ditetapkan = ?,
    pil1_tingkat_risiko = ?,
    pil2_tertinggi = ?,
    pil2_terendah = ?,
    pil2_rata_rata = ?,
    pil2_risiko_ditetapkan = ?,
    pil2_tingkat_risiko = ?,
    pil3_tertinggi = ?,
    pil3_terendah = ?,
    pil3_rata_rata = ?,
    pil3_risiko_ditetapkan = ?,
    pil3_tingkat_risiko = ?,
    pil4_tertinggi = ?,
    pil4_terendah = ?,
    pil4_rata_rata = ?,
    pil4_risiko_ditetapkan = ?,
    pil4_tingkat_risiko = ?,
    hasil_kpmr_tertinggi = ?,
    hasil_kpmr_terendah = ?,
    hasil_kpmr_rata_rata = ?,
    hasil_risiko_ditetapkan = ?,
    hasil_tingkat_risiko = ?,
    hasil_peringkat = ?
    WHERE id_profil_risiko = ?", [$pil1_tertinggi, $pil1_terendah, $pil1_rata_rata, $pil1_risiko_ditetapkan, $pil1_tingkat_risiko, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $pil2_risiko_ditetapkan, $pil2_tingkat_risiko, $pil3_tertinggi, $pil3_terendah, $pil3_rata_rata, $pil3_risiko_ditetapkan, $pil3_tingkat_risiko, $pil4_tertinggi, $pil4_terendah, $pil4_rata_rata, $pil4_risiko_ditetapkan, $pil4_tingkat_risiko, $hasil_kpmr_tertinggi, $hasil_kpmr_terendah, $hasil_kpmr_rata_rata, $hasil_risiko_ditetapkan, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

//sql respon unit kerja
    simpro_db_query($conn, "UPDATE respon_unit_kerja_operasional_pil1 SET 
    respon_pil1_1a = ?,
    respon_pil1_1b = ?,
    respon_pil1_1c = ?,
    respon_pil1_1d = ?,
    respon_pil1_1e = ?,
    respon_pil1_2a = ?,
    respon_pil1_2b = ?,
    respon_pil1_2c = ?,
    respon_pil1_2d = ?,
    respon_pil1_2e = ?,
    respon_pil1_3a = ?,
    respon_pil1_3b = ?,
    respon_pil1_3c = ?,
    respon_pil1_4a = ?,
    respon_pil1_4b = ?,
    respon_pil1_4c = ?,
    respon_pil1_4d = ?,
    respon_pil1_4e = ?,
    respon_pil1_5a = ?,
    respon_pil1_5b = ?,
    respon_pil1_5c = ?,
    respon_pil1_5d = ?,
    respon_pil1_6a = ?,
    respon_pil1_6b = ?,
    respon_pil1_6c = ?
    WHERE id_profil_risiko = ?", [$respon_pil1_1a, $respon_pil1_1b, $respon_pil1_1c, $respon_pil1_1d, $respon_pil1_1e, $respon_pil1_2a, $respon_pil1_2b, $respon_pil1_2c, $respon_pil1_2d, $respon_pil1_2e, $respon_pil1_3a, $respon_pil1_3b, $respon_pil1_3c, $respon_pil1_4a, $respon_pil1_4b, $respon_pil1_4c, $respon_pil1_4d, $respon_pil1_4e, $respon_pil1_5a, $respon_pil1_5b, $respon_pil1_5c, $respon_pil1_5d, $respon_pil1_6a, $respon_pil1_6b, $respon_pil1_6c, $id]);

    simpro_db_query($conn, "UPDATE respon_unit_kerja_operasional_pil2 SET 
    respon_pil2_1a = ?,
    respon_pil2_1b = ?,
    respon_pil2_1c = ?,
    respon_pil2_1d = ?,
    respon_pil2_1e = ?,
    respon_pil2_2a = ?,
    respon_pil2_2b = ?,
    respon_pil2_2c = ?,
    respon_pil2_2d = ?,
    respon_pil2_2e = ?,
    respon_pil2_2f = ?,
    respon_pil2_2g = ?,
    respon_pil2_2h = ?,
    respon_pil2_3a = ?,
    respon_pil2_3b = ?,
    respon_pil2_3c = ?
    WHERE id_profil_risiko = ?", [$respon_pil2_1a, $respon_pil2_1b, $respon_pil2_1c, $respon_pil2_1d, $respon_pil2_1e, $respon_pil2_2a, $respon_pil2_2b, $respon_pil2_2c, $respon_pil2_2d, $respon_pil2_2e, $respon_pil2_2f, $respon_pil2_2g, $respon_pil2_2h, $respon_pil2_3a, $respon_pil2_3b, $respon_pil2_3c, $id]);

    simpro_db_query($conn, "UPDATE respon_unit_kerja_operasional_pil3 SET 
    respon_pil3_1a = ?,
    respon_pil3_1b = ?,
    respon_pil3_1c = ?,
    respon_pil3_1d = ?,
    respon_pil3_1e = ?,
    respon_pil3_1f = ?,
    respon_pil3_1g = ?,
    respon_pil3_1h = ?,
    respon_pil3_1i = ?,
    respon_pil3_1j = ?,
    respon_pil3_2a = ?,
    respon_pil3_2b = ?,
    respon_pil3_2c = ?,
    respon_pil3_2d = ?,
    respon_pil3_2e = ?,
    respon_pil3_3a = ?,
    respon_pil3_3b = ?,
    respon_pil3_3c = ?,
    respon_pil3_4a = ?,
    respon_pil3_4b = ?,
    respon_pil3_4c = ?
    WHERE id_profil_risiko = ?", [$respon_pil3_1a, $respon_pil3_1b, $respon_pil3_1c, $respon_pil3_1d, $respon_pil3_1e, $respon_pil3_1f, $respon_pil3_1g, $respon_pil3_1h, $respon_pil3_1i, $respon_pil3_1j, $respon_pil3_2a, $respon_pil3_2b, $respon_pil3_2c, $respon_pil3_2d, $respon_pil3_2e, $respon_pil3_3a, $respon_pil3_3b, $respon_pil3_3c, $respon_pil3_4a, $respon_pil3_4b, $respon_pil3_4c, $id]);

    simpro_db_query($conn, "UPDATE respon_unit_kerja_operasional_pil4 SET 
    respon_pil4_1a = ?,
    respon_pil4_1b = ?,
    respon_pil4_1c = ?,
    respon_pil4_1d = ?,
    respon_pil4_1e = ?,
    respon_pil4_2a = ?,
    respon_pil4_2b = ?
    WHERE id_profil_risiko = ?", [$respon_pil4_1a, $respon_pil4_1b, $respon_pil4_1c, $respon_pil4_1d, $respon_pil4_1e, $respon_pil4_2a, $respon_pil4_2b, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=op_kpmr1&id=$id");
    exit();
}
?>








<script type="text/javascript">

    //PILAR 1------------------------------------------------------------------
                                    $(document).ready(function() {
                                        $("#kpmr1a, #kpmr1b, #kpmr1c, #kpmr1d, #kpmr1e").change(function() {
                                            var kpmr1a = $("#kpmr1a").val();
                                            var kpmr1b = $("#kpmr1b").val();
                                            var kpmr1c = $("#kpmr1c").val();
                                            var kpmr1d = $("#kpmr1d").val();
                                            var kpmr1e = $("#kpmr1e").val();
                                            

                                            var total = parseFloat(kpmr1a) + parseFloat(kpmr1b) + parseFloat(kpmr1c) + parseFloat(kpmr1d) + parseFloat(kpmr1e);
                                            var total_kpmr1 = parseFloat(total) / 5;
                                            total_kpmr1 = total_kpmr1.toFixed(2);
                                            $("#total_kpmr1").val(total_kpmr1);

                                            if (total_kpmr1 < 1.00) {
                                                var peringkat_kpmr1 = "Belum Terisi";
                                            } else if (total_kpmr1 >= 1.00 && total_kpmr1 < 1.25) {
                                                var peringkat_kpmr1 = "Sangat Memadai";
                                            } else if (total_kpmr1 >= 1.25 && total_kpmr1 < 2.25) {
                                                var peringkat_kpmr1 = "Memadai";
                                            } else if (total_kpmr1 >= 2.25 && total_kpmr1 < 3.25) {
                                                var peringkat_kpmr1 = "Cukup Memadai";
                                            } else if (total_kpmr1 >= 3.25 && total_kpmr1 < 4.25) {
                                                var peringkat_kpmr1 = "Kurang Memadai";
                                            } else if (total_kpmr1 >= 4.25 && total_kpmr1 <= 5.00) {
                                                var peringkat_kpmr1 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr1 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr1").val(peringkat_kpmr1);
                                        });
                                    
                                        $("#kpmr2a, #kpmr2b, #kpmr2c, #kpmr2d, #kpmr2e").change(function() {
                                            var kpmr2a = $("#kpmr2a").val();
                                            var kpmr2b = $("#kpmr2b").val();
                                            var kpmr2c = $("#kpmr2c").val();
                                            var kpmr2d = $("#kpmr2d").val();
                                            var kpmr2e = $("#kpmr2e").val();
                                            

                                            var total = parseFloat(kpmr2a) + parseFloat(kpmr2b) + parseFloat(kpmr2c) + parseFloat(kpmr2d) + parseFloat(kpmr2e);
                                            var total_kpmr2 = parseFloat(total) / 5;
                                            total_kpmr2 = total_kpmr2.toFixed(2);
                                            $("#total_kpmr2").val(total_kpmr2);

                                            if (total_kpmr2 < 1.00) {
                                                var peringkat_kpmr2 = "Belum Terisi";
                                            } else if (total_kpmr2 >= 1.00 && total_kpmr2 < 1.25) {
                                                var peringkat_kpmr2 = "Sangat Memadai";
                                            } else if (total_kpmr2 >= 1.25 && total_kpmr2 < 2.25) {
                                                var peringkat_kpmr2 = "Memadai";
                                            } else if (total_kpmr2 >= 2.25 && total_kpmr2 < 3.25) {
                                                var peringkat_kpmr2 = "Cukup Memadai";
                                            } else if (total_kpmr2 >= 3.25 && total_kpmr2 < 4.25) {
                                                var peringkat_kpmr2 = "Kurang Memadai";
                                            } else if (total_kpmr2 >= 4.25 && total_kpmr2 <= 5.00) {
                                                var peringkat_kpmr2 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr2 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr2").val(peringkat_kpmr2);
                                        });
                                    
                                        $("#kpmr3a, #kpmr3b, #kpmr3c").change(function() {
                                            var kpmr3a = $("#kpmr3a").val();
                                            var kpmr3b = $("#kpmr3b").val();
                                            var kpmr3c = $("#kpmr3c").val();
                                            

                                            var total = parseFloat(kpmr3a) + parseFloat(kpmr3b) + parseFloat(kpmr3c);
                                            var total_kpmr3 = parseFloat(total) / 3;
                                            total_kpmr3 = total_kpmr3.toFixed(2);
                                            $("#total_kpmr3").val(total_kpmr3);

                                            if (total_kpmr3 < 1.00) {
                                                var peringkat_kpmr3 = "Belum Terisi";
                                            } else if (total_kpmr3 >= 1.00 && total_kpmr3 < 1.25) {
                                                var peringkat_kpmr3 = "Sangat Memadai";
                                            } else if (total_kpmr3 >= 1.25 && total_kpmr3 < 2.25) {
                                                var peringkat_kpmr3 = "Memadai";
                                            } else if (total_kpmr3 >= 2.25 && total_kpmr3 < 3.25) {
                                                var peringkat_kpmr3 = "Cukup Memadai";
                                            } else if (total_kpmr3 >= 3.25 && total_kpmr3 < 4.25) {
                                                var peringkat_kpmr3 = "Kurang Memadai";
                                            } else if (total_kpmr3 >= 4.25 && total_kpmr3 <= 5.00) {
                                                var peringkat_kpmr3 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr3 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr3").val(peringkat_kpmr3);
                                        });
                                    
                                        $("#kpmr4a, #kpmr4b, #kpmr4c, #kpmr4d, #kpmr4e").change(function() {
                                            var kpmr4a = $("#kpmr4a").val();
                                            var kpmr4b = $("#kpmr4b").val();
                                            var kpmr4c = $("#kpmr4c").val();
                                            var kpmr4d = $("#kpmr4d").val();
                                            var kpmr4e = $("#kpmr4e").val();
                                            

                                            var total = parseFloat(kpmr4a) + parseFloat(kpmr4b) + parseFloat(kpmr4c) + parseFloat(kpmr4d) + parseFloat(kpmr4e);
                                            var total_kpmr4 = parseFloat(total) / 5;
                                            total_kpmr4 = total_kpmr4.toFixed(2);
                                            $("#total_kpmr4").val(total_kpmr4);

                                            if (total_kpmr4 < 1.00) {
                                                var peringkat_kpmr4 = "Belum Terisi";
                                            } else if (total_kpmr4 >= 1.00 && total_kpmr4 < 1.25) {
                                                var peringkat_kpmr4 = "Sangat Memadai";
                                            } else if (total_kpmr4 >= 1.25 && total_kpmr4 < 2.25) {
                                                var peringkat_kpmr4 = "Memadai";
                                            } else if (total_kpmr4 >= 2.25 && total_kpmr4 < 3.25) {
                                                var peringkat_kpmr4 = "Cukup Memadai";
                                            } else if (total_kpmr4 >= 3.25 && total_kpmr4 < 4.25) {
                                                var peringkat_kpmr4 = "Kurang Memadai";
                                            } else if (total_kpmr4 >= 4.25 && total_kpmr4 <= 5.00) {
                                                var peringkat_kpmr4 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr4 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr4").val(peringkat_kpmr4);
                                        });
                                    
                                        $("#kpmr5a, #kpmr5b, #kpmr5c, #kpmr5d").change(function() {
                                            var kpmr5a = $("#kpmr5a").val();
                                            var kpmr5b = $("#kpmr5b").val();
                                            var kpmr5c = $("#kpmr5c").val();
                                            var kpmr5d = $("#kpmr5d").val();
                                            

                                            var total = parseFloat(kpmr5a) + parseFloat(kpmr5b) + parseFloat(kpmr5c) + parseFloat(kpmr5d);
                                            var total_kpmr5 = parseFloat(total) / 4;
                                            total_kpmr5 = total_kpmr5.toFixed(2);
                                            $("#total_kpmr5").val(total_kpmr5);

                                            if (total_kpmr5 < 1.00) {
                                                var peringkat_kpmr5 = "Belum Terisi";
                                            } else if (total_kpmr5 >= 1.00 && total_kpmr5 < 1.25) {
                                                var peringkat_kpmr5 = "Sangat Memadai";
                                            } else if (total_kpmr5 >= 1.25 && total_kpmr5 < 2.25) {
                                                var peringkat_kpmr5 = "Memadai";
                                            } else if (total_kpmr5 >= 2.25 && total_kpmr5 < 3.25) {
                                                var peringkat_kpmr5 = "Cukup Memadai";
                                            } else if (total_kpmr5 >= 3.25 && total_kpmr5 < 4.25) {
                                                var peringkat_kpmr5 = "Kurang Memadai";
                                            } else if (total_kpmr5 >= 4.25 && total_kpmr5 <= 5.00) {
                                                var peringkat_kpmr5 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr5 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr5").val(peringkat_kpmr5);
                                        });
                                    
                                        $("#kpmr6a, #kpmr6b, #kpmr6c").change(function() {
                                            var kpmr6a = $("#kpmr6a").val();
                                            var kpmr6b = $("#kpmr6b").val();
                                            var kpmr6c = $("#kpmr6c").val();
                                            

                                            var total = parseFloat(kpmr6a) + parseFloat(kpmr6b) + parseFloat(kpmr6c);
                                            var total_kpmr6 = parseFloat(total) / 3;
                                            total_kpmr6 = total_kpmr6.toFixed(2);
                                            $("#total_kpmr6").val(total_kpmr6);

                                            if (total_kpmr6 < 1.00) {
                                                var peringkat_kpmr6 = "Belum Terisi";
                                            } else if (total_kpmr6 >= 1.00 && total_kpmr6 < 1.25) {
                                                var peringkat_kpmr6 = "Sangat Memadai";
                                            } else if (total_kpmr6 >= 1.25 && total_kpmr6 < 2.25) {
                                                var peringkat_kpmr6 = "Memadai";
                                            } else if (total_kpmr6 >= 2.25 && total_kpmr6 < 3.25) {
                                                var peringkat_kpmr6 = "Cukup Memadai";
                                            } else if (total_kpmr6 >= 3.25 && total_kpmr6 < 4.25) {
                                                var peringkat_kpmr6 = "Kurang Memadai";
                                            } else if (total_kpmr6 >= 4.25 && total_kpmr6 <= 5.00) {
                                                var peringkat_kpmr6 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr6 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr6").val(peringkat_kpmr6);
                                        });
                                    
                                        $("#kpmr1a, #kpmr1b, #kpmr1c, #kpmr1d, #kpmr1e, #kpmr2a, #kpmr2b, #kpmr2c, #kpmr2d, #kpmr2e, #kpmr3a, #kpmr3b, #kpmr3c, #kpmr4a, #kpmr4b, #kpmr4c, #kpmr4d, #kpmr4e, #kpmr5a, #kpmr5b, #kpmr5c, #kpmr5d, #kpmr6a, #kpmr6b, #kpmr6c").change(function() {
                                            var kpmr1a = $("#kpmr1a").val();
                                            var kpmr1b = $("#kpmr1b").val();
                                            var kpmr1c = $("#kpmr1c").val();
                                            var kpmr1d = $("#kpmr1d").val();
                                            var kpmr1e = $("#kpmr1e").val();

                                            var kpmr2a = $("#kpmr2a").val();
                                            var kpmr2b = $("#kpmr2b").val();
                                            var kpmr2c = $("#kpmr2c").val();
                                            var kpmr2d = $("#kpmr2d").val();
                                            var kpmr2e = $("#kpmr2e").val();

                                            var kpmr3a = $("#kpmr3a").val();
                                            var kpmr3b = $("#kpmr3b").val();
                                            var kpmr3c = $("#kpmr3c").val();

                                            var kpmr4a = $("#kpmr4a").val();
                                            var kpmr4b = $("#kpmr4b").val();
                                            var kpmr4c = $("#kpmr4c").val();
                                            var kpmr4d = $("#kpmr4d").val();
                                            var kpmr4e = $("#kpmr4e").val();

                                            var kpmr5a = $("#kpmr5a").val();
                                            var kpmr5b = $("#kpmr5b").val();
                                            var kpmr5c = $("#kpmr5c").val();
                                            var kpmr5d = $("#kpmr5d").val();

                                            var kpmr6a = $("#kpmr6a").val();
                                            var kpmr6b = $("#kpmr6b").val();
                                            var kpmr6c = $("#kpmr6c").val();

                                            var total = parseFloat(kpmr1a) + parseFloat(kpmr1b) + parseFloat(kpmr1c) + parseFloat(kpmr1d) + parseFloat(kpmr1e);
                                            var total_kpmr1 = parseFloat(total) / 5;
                                            total_kpmr1 = total_kpmr1.toFixed(2);

                                            var total = parseFloat(kpmr2a) + parseFloat(kpmr2b) + parseFloat(kpmr2c) + parseFloat(kpmr2d) + parseFloat(kpmr2e);
                                            var total_kpmr2 = parseFloat(total) / 5;
                                            total_kpmr2 = total_kpmr2.toFixed(2);

                                            var total = parseFloat(kpmr3a) + parseFloat(kpmr3b) + parseFloat(kpmr3c);
                                            var total_kpmr3 = parseFloat(total) / 3;
                                            total_kpmr3 = total_kpmr3.toFixed(2);

                                            var total = parseFloat(kpmr4a) + parseFloat(kpmr4b) + parseFloat(kpmr4c) + parseFloat(kpmr4d) + parseFloat(kpmr4e);
                                            var total_kpmr4 = parseFloat(total) / 5;
                                            total_kpmr4 = total_kpmr4.toFixed(2);

                                            var total = parseFloat(kpmr5a) + parseFloat(kpmr5b) + parseFloat(kpmr5c) + parseFloat(kpmr5d);
                                            var total_kpmr5 = parseFloat(total) / 4;
                                            total_kpmr5 = total_kpmr5.toFixed(2);

                                            var total = parseFloat(kpmr6a) + parseFloat(kpmr6b) + parseFloat(kpmr6c);
                                            var total_kpmr6 = parseFloat(total) / 3;
                                            total_kpmr6 = total_kpmr6.toFixed(2);


                                            const max = [total_kpmr1, total_kpmr2, total_kpmr3, total_kpmr4, total_kpmr5, total_kpmr6];
                                            const maxValue = Math.max(...max);
                                            tertinggi_pil1 = maxValue.toFixed(2);

                                            $("#tertinggi_pil1").val(tertinggi_pil1);
                                    

                                            const min = [total_kpmr1, total_kpmr2, total_kpmr3, total_kpmr4, total_kpmr5, total_kpmr6]
                                            const minValue = Math.min(...min);
                                            terendah_pil1 = minValue.toFixed(2);

                                            $("#terendah_pil1").val(terendah_pil1);

                                            var total_rata_rata = parseFloat(total_kpmr1) + parseFloat(total_kpmr2) + parseFloat(total_kpmr3) + parseFloat(total_kpmr4) + parseFloat(total_kpmr5) + parseFloat(total_kpmr6);
                                            
                                            var rata_rata_pil1 = parseFloat(total_rata_rata) / 6;
                                            rata_rata_pil1 = rata_rata_pil1.toFixed(2);

                                            rr1 = rata_rata_pil1;

                                            $("#rata_rata_pil1").val(rata_rata_pil1);
                                        });
                                        $("#kpmr1a, #kpmr1b, #kpmr1c, #kpmr1d, #kpmr1e, #kpmr2a, #kpmr2b, #kpmr2c, #kpmr2d, #kpmr2e, #kpmr3a, #kpmr3b, #kpmr3c, #kpmr4a, #kpmr4b, #kpmr4c, #kpmr4d, #kpmr4e, #kpmr5a, #kpmr5b, #kpmr5c, #kpmr5d, #kpmr6a, #kpmr6b, #kpmr6c, #opsi_pil1").change(function() {
                                            var opsi_pil1 = $("#opsi_pil1").val();
                                           
                                            if (opsi_pil1 == 1) {
                                                var risiko_pil1 = tertinggi_pil1;
                                            } else if (opsi_pil1 == 2) {
                                                var risiko_pil1 = terendah_pil1;
                                            } else if (opsi_pil1 == 3) {
                                                var risiko_pil1 = rr1;
                                            } else {
                                                var risiko_pil1 = 0;
                                            }

                                            $("#risiko_pil1").val(risiko_pil1);
                                            risiko_pilar1 = risiko_pil1;
                                        });
                                    







    //PILAR 2------------------------------------------------------------------
                                        $("#kpmr_pil2_1a, #kpmr_pil2_1b, #kpmr_pil2_1c, #kpmr_pil2_1d, #kpmr_pil2_1e").change(function() {
                                            var kpmr_pil2_1a = $("#kpmr_pil2_1a").val();
                                            var kpmr_pil2_1b = $("#kpmr_pil2_1b").val();
                                            var kpmr_pil2_1c = $("#kpmr_pil2_1c").val();
                                            var kpmr_pil2_1d = $("#kpmr_pil2_1d").val();
                                            var kpmr_pil2_1e = $("#kpmr_pil2_1e").val();
                                            

                                            var total = parseFloat(kpmr_pil2_1a) + parseFloat(kpmr_pil2_1b) + parseFloat(kpmr_pil2_1c) + parseFloat(kpmr_pil2_1d) + parseFloat(kpmr_pil2_1e);
                                            var total_kpmr_pil2_1 = parseFloat(total) / 5;
                                            total_kpmr_pil2_1 = total_kpmr_pil2_1.toFixed(2);
                                            $("#total_kpmr_pil2_1").val(total_kpmr_pil2_1);

                                            if (total_kpmr_pil2_1 < 1.00) {
                                                var peringkat_kpmr_pil2_1 = "Belum Terisi";
                                            } else if (total_kpmr_pil2_1 >= 1.00 && total_kpmr_pil2_1 < 1.25) {
                                                var peringkat_kpmr_pil2_1 = "Sangat Memadai";
                                            } else if (total_kpmr_pil2_1 >= 1.25 && total_kpmr_pil2_1 < 2.25) {
                                                var peringkat_kpmr_pil2_1 = "Memadai";
                                            } else if (total_kpmr_pil2_1 >= 2.25 && total_kpmr_pil2_1 < 3.25) {
                                                var peringkat_kpmr_pil2_1 = "Cukup Memadai";
                                            } else if (total_kpmr_pil2_1 >= 3.25 && total_kpmr_pil2_1 < 4.25) {
                                                var peringkat_kpmr_pil2_1 = "Kurang Memadai";
                                            } else if (total_kpmr_pil2_1 >= 4.25 && total_kpmr_pil2_1 <= 5.00) {
                                                var peringkat_kpmr_pil2_1 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil2_1 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil2_1").val(peringkat_kpmr_pil2_1);
                                        });
                                    
                                        $("#kpmr_pil2_2a, #kpmr_pil2_2b, #kpmr_pil2_2c, #kpmr_pil2_2d, #kpmr_pil2_2e, #kpmr_pil2_2f, #kpmr_pil2_2g, #kpmr_pil2_2h").change(function() {
                                            var kpmr_pil2_2a = $("#kpmr_pil2_2a").val();
                                            var kpmr_pil2_2b = $("#kpmr_pil2_2b").val();
                                            var kpmr_pil2_2c = $("#kpmr_pil2_2c").val();
                                            var kpmr_pil2_2d = $("#kpmr_pil2_2d").val();
                                            var kpmr_pil2_2e = $("#kpmr_pil2_2e").val();
                                            var kpmr_pil2_2f = $("#kpmr_pil2_2f").val();
                                            var kpmr_pil2_2g = $("#kpmr_pil2_2g").val();
                                            var kpmr_pil2_2h = $("#kpmr_pil2_2h").val();
                                            

                                            var total = parseFloat(kpmr_pil2_2a) + parseFloat(kpmr_pil2_2b) + parseFloat(kpmr_pil2_2c) + parseFloat(kpmr_pil2_2d) + parseFloat(kpmr_pil2_2e) + parseFloat(kpmr_pil2_2f) + parseFloat(kpmr_pil2_2g) + parseFloat(kpmr_pil2_2h);
                                            var total_kpmr_pil2_2 = parseFloat(total) / 8;
                                            total_kpmr_pil2_2 = total_kpmr_pil2_2.toFixed(2);
                                            $("#total_kpmr_pil2_2").val(total_kpmr_pil2_2);

                                            if (total_kpmr_pil2_2 < 1.00) {
                                                var peringkat_kpmr_pil2_2 = "Belum Terisi";
                                            } else if (total_kpmr_pil2_2 >= 1.00 && total_kpmr_pil2_2 < 1.25) {
                                                var peringkat_kpmr_pil2_2 = "Sangat Memadai";
                                            } else if (total_kpmr_pil2_2 >= 1.25 && total_kpmr_pil2_2 < 2.25) {
                                                var peringkat_kpmr_pil2_2 = "Memadai";
                                            } else if (total_kpmr_pil2_2 >= 2.25 && total_kpmr_pil2_2 < 3.25) {
                                                var peringkat_kpmr_pil2_2 = "Cukup Memadai";
                                            } else if (total_kpmr_pil2_2 >= 3.25 && total_kpmr_pil2_2 < 4.25) {
                                                var peringkat_kpmr_pil2_2 = "Kurang Memadai";
                                            } else if (total_kpmr_pil2_2 >= 4.25 && total_kpmr_pil2_2 <= 5.00) {
                                                var peringkat_kpmr_pil2_2 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil2_2 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil2_2").val(peringkat_kpmr_pil2_2);
                                        });
                                    
                                        $("#kpmr_pil2_3a, #kpmr_pil2_3b, #kpmr_pil2_3c").change(function() {
                                            var kpmr_pil2_3a = $("#kpmr_pil2_3a").val();
                                            var kpmr_pil2_3b = $("#kpmr_pil2_3b").val();
                                            var kpmr_pil2_3c = $("#kpmr_pil2_3c").val();
                                            
                                            

                                            var total = parseFloat(kpmr_pil2_3a) + parseFloat(kpmr_pil2_3b) + parseFloat(kpmr_pil2_3c);
                                            var total_kpmr_pil2_3 = parseFloat(total) / 3;
                                            total_kpmr_pil2_3 = total_kpmr_pil2_3.toFixed(2);
                                            $("#total_kpmr_pil2_3").val(total_kpmr_pil2_3);

                                            if (total_kpmr_pil2_3 < 1.00) {
                                                var peringkat_kpmr_pil2_3 = "Belum Terisi";
                                            } else if (total_kpmr_pil2_3 >= 1.00 && total_kpmr_pil2_3 < 1.25) {
                                                var peringkat_kpmr_pil2_3 = "Sangat Memadai";
                                            } else if (total_kpmr_pil2_3 >= 1.25 && total_kpmr_pil2_3 < 2.25) {
                                                var peringkat_kpmr_pil2_3 = "Memadai";
                                            } else if (total_kpmr_pil2_3 >= 2.25 && total_kpmr_pil2_3 < 3.25) {
                                                var peringkat_kpmr_pil2_3 = "Cukup Memadai";
                                            } else if (total_kpmr_pil2_3 >= 3.25 && total_kpmr_pil2_3 < 4.25) {
                                                var peringkat_kpmr_pil2_3 = "Kurang Memadai";
                                            } else if (total_kpmr_pil2_3 >= 4.25 && total_kpmr_pil2_3 <= 5.00) {
                                                var peringkat_kpmr_pil2_3 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil2_3 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil2_3").val(peringkat_kpmr_pil2_3);
                                        });
                                    
                                        $("#kpmr_pil2_1a, #kpmr_pil2_1b, #kpmr_pil2_1c, #kpmr_pil2_1d, #kpmr_pil2_1e, #kpmr_pil2_2a, #kpmr_pil2_2b, #kpmr_pil2_2c, #kpmr_pil2_2d, #kpmr_pil2_2e, #kpmr_pil2_2f, #kpmr_pil2_2g, #kpmr_pil2_2h, #kpmr_pil2_3a, #kpmr_pil2_3b, #kpmr_pil2_3c").change(function() {

                                            var kpmr_pil2_1a = $("#kpmr_pil2_1a").val();
                                            var kpmr_pil2_1b = $("#kpmr_pil2_1b").val();
                                            var kpmr_pil2_1c = $("#kpmr_pil2_1c").val();
                                            var kpmr_pil2_1d = $("#kpmr_pil2_1d").val();
                                            var kpmr_pil2_1e = $("#kpmr_pil2_1e").val();

                                            var kpmr_pil2_2a = $("#kpmr_pil2_2a").val();
                                            var kpmr_pil2_2b = $("#kpmr_pil2_2b").val();
                                            var kpmr_pil2_2c = $("#kpmr_pil2_2c").val();
                                            var kpmr_pil2_2d = $("#kpmr_pil2_2d").val();
                                            var kpmr_pil2_2e = $("#kpmr_pil2_2e").val();
                                            var kpmr_pil2_2f = $("#kpmr_pil2_2f").val();
                                            var kpmr_pil2_2g = $("#kpmr_pil2_2g").val();
                                            var kpmr_pil2_2h = $("#kpmr_pil2_2h").val();

                                            var kpmr_pil2_3a = $("#kpmr_pil2_3a").val();
                                            var kpmr_pil2_3b = $("#kpmr_pil2_3b").val();
                                            var kpmr_pil2_3c = $("#kpmr_pil2_3c").val();
                                            
                                            var total = parseFloat(kpmr_pil2_1a) + parseFloat(kpmr_pil2_1b) + parseFloat(kpmr_pil2_1c) + parseFloat(kpmr_pil2_1d) + parseFloat(kpmr_pil2_1e);
                                            var total_kpmr_pil2_1 = parseFloat(total) / 5;
                                            total_kpmr_pil2_1 = total_kpmr_pil2_1.toFixed(2);

                                            var total = parseFloat(kpmr_pil2_2a) + parseFloat(kpmr_pil2_2b) + parseFloat(kpmr_pil2_2c) + parseFloat(kpmr_pil2_2d) + parseFloat(kpmr_pil2_2e) + parseFloat(kpmr_pil2_2f) + parseFloat(kpmr_pil2_2g) + parseFloat(kpmr_pil2_2h);
                                            var total_kpmr_pil2_2 = parseFloat(total) / 8;
                                            total_kpmr_pil2_2 = total_kpmr_pil2_2.toFixed(2);                                            

                                            var total = parseFloat(kpmr_pil2_3a) + parseFloat(kpmr_pil2_3b) + parseFloat(kpmr_pil2_3c);
                                            var total_kpmr_pil2_3 = parseFloat(total) / 3;
                                            total_kpmr_pil2_3 = total_kpmr_pil2_3.toFixed(2);


                                            const max = [total_kpmr_pil2_1, total_kpmr_pil2_2, total_kpmr_pil2_3];
                                            const maxValue = Math.max(...max);
                                            tertinggi_pil2 = maxValue.toFixed(2);

                                            $("#tertinggi_pil2").val(tertinggi_pil2);
                                    

                                            const min = [total_kpmr_pil2_1, total_kpmr_pil2_2, total_kpmr_pil2_3];
                                            const minValue = Math.min(...min);
                                            terendah_pil2 = minValue.toFixed(2);

                                            $("#terendah_pil2").val(terendah_pil2);

                                            var total_rata_rata = parseFloat(total_kpmr_pil2_1) + parseFloat(total_kpmr_pil2_2) + parseFloat(total_kpmr_pil2_3);
                                            
                                            var rata_rata_pil2 = parseFloat(total_rata_rata) / 3;
                                            rata_rata_pil2 = rata_rata_pil2.toFixed(2);

                                            rr2 = rata_rata_pil2;

                                            $("#rata_rata_pil2").val(rata_rata_pil2);
                                        });
                                        $("#kpmr_pil2_1a, #kpmr_pil2_1b, #kpmr_pil2_1c, #kpmr_pil2_1d, #kpmr_pil2_1e, #kpmr_pil2_2a, #kpmr_pil2_2b, #kpmr_pil2_2c, #kpmr_pil2_2d, #kpmr_pil2_2e, #kpmr_pil2_2f, #kpmr_pil2_2g, #kpmr_pil2_2h, #kpmr_pil2_3a, #kpmr_pil2_3b, #kpmr_pil2_3c, #opsi_pil2").change(function() {
                                            var opsi_pil2 = $("#opsi_pil2").val();
                                           
                                            if (opsi_pil2 == 1) {
                                                var risiko_pil2 = tertinggi_pil2;
                                            } else if (opsi_pil2 == 2) {
                                                var risiko_pil2 = terendah_pil2;
                                            } else if (opsi_pil2 == 3) {
                                                var risiko_pil2 = rr2;
                                            } else {
                                                var risiko_pil2 = 0;
                                            }

                                            $("#risiko_pil2").val(risiko_pil2);
                                            risiko_pilar2 = risiko_pil2;
                                        });
                                    






    //PILAR 3------------------------------------------------------------------
                                        $("#kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j").change(function() {
                                            var kpmr_pil3_1a = $("#kpmr_pil3_1a").val();
                                            var kpmr_pil3_1b = $("#kpmr_pil3_1b").val();
                                            var kpmr_pil3_1c = $("#kpmr_pil3_1c").val();
                                            var kpmr_pil3_1d = $("#kpmr_pil3_1d").val();
                                            var kpmr_pil3_1e = $("#kpmr_pil3_1e").val();
                                            var kpmr_pil3_1f = $("#kpmr_pil3_1f").val();
                                            var kpmr_pil3_1g = $("#kpmr_pil3_1g").val();
                                            var kpmr_pil3_1h = $("#kpmr_pil3_1h").val();
                                            var kpmr_pil3_1i = $("#kpmr_pil3_1i").val();
                                            var kpmr_pil3_1j = $("#kpmr_pil3_1j").val();
                                            

                                            var total = parseFloat(kpmr_pil3_1a) + parseFloat(kpmr_pil3_1b) + parseFloat(kpmr_pil3_1c) + parseFloat(kpmr_pil3_1d) + parseFloat(kpmr_pil3_1e) + parseFloat(kpmr_pil3_1f) + parseFloat(kpmr_pil3_1g) + parseFloat(kpmr_pil3_1h) + parseFloat(kpmr_pil3_1i) + parseFloat(kpmr_pil3_1j);
                                            var total_kpmr_pil3_1 = parseFloat(total) / 10;
                                            total_kpmr_pil3_1 = total_kpmr_pil3_1.toFixed(2);
                                            $("#total_kpmr_pil3_1").val(total_kpmr_pil3_1);

                                            if (total_kpmr_pil3_1 < 1.00) {
                                                var peringkat_kpmr_pil3_1 = "Belum Terisi";
                                            } else if (total_kpmr_pil3_1 >= 1.00 && total_kpmr_pil3_1 < 1.25) {
                                                var peringkat_kpmr_pil3_1 = "Sangat Memadai";
                                            } else if (total_kpmr_pil3_1 >= 1.25 && total_kpmr_pil3_1 < 2.25) {
                                                var peringkat_kpmr_pil3_1 = "Memadai";
                                            } else if (total_kpmr_pil3_1 >= 2.25 && total_kpmr_pil3_1 < 3.25) {
                                                var peringkat_kpmr_pil3_1 = "Cukup Memadai";
                                            } else if (total_kpmr_pil3_1 >= 3.25 && total_kpmr_pil3_1 < 4.25) {
                                                var peringkat_kpmr_pil3_1 = "Kurang Memadai";
                                            } else if (total_kpmr_pil3_1 >= 4.25 && total_kpmr_pil3_1 <= 5.00) {
                                                var peringkat_kpmr_pil3_1 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil3_1 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil3_1").val(peringkat_kpmr_pil3_1);
                                        });
                                    
                                        $("#kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e").change(function() {
                                            
                                            var kpmr_pil3_2a = $("#kpmr_pil3_2a").val();
                                            var kpmr_pil3_2b = $("#kpmr_pil3_2b").val();
                                            var kpmr_pil3_2c = $("#kpmr_pil3_2c").val();
                                            var kpmr_pil3_2d = $("#kpmr_pil3_2d").val();
                                            var kpmr_pil3_2e = $("#kpmr_pil3_2e").val();
                                            

                                            var total = parseFloat(kpmr_pil3_2a) + parseFloat(kpmr_pil3_2b) + parseFloat(kpmr_pil3_2c) + parseFloat(kpmr_pil3_2d) + parseFloat(kpmr_pil3_2e);
                                            var total_kpmr_pil3_2 = parseFloat(total) / 5;
                                            total_kpmr_pil3_2 = total_kpmr_pil3_2.toFixed(2);
                                            $("#total_kpmr_pil3_2").val(total_kpmr_pil3_2);

                                            if (total_kpmr_pil3_2 < 1.00) {
                                                var peringkat_kpmr_pil3_2 = "Belum Terisi";
                                            } else if (total_kpmr_pil3_2 >= 1.00 && total_kpmr_pil3_2 < 1.25) {
                                                var peringkat_kpmr_pil3_2 = "Sangat Memadai";
                                            } else if (total_kpmr_pil3_2 >= 1.25 && total_kpmr_pil3_2 < 2.25) {
                                                var peringkat_kpmr_pil3_2 = "Memadai";
                                            } else if (total_kpmr_pil3_2 >= 2.25 && total_kpmr_pil3_2 < 3.25) {
                                                var peringkat_kpmr_pil3_2 = "Cukup Memadai";
                                            } else if (total_kpmr_pil3_2 >= 3.25 && total_kpmr_pil3_2 < 4.25) {
                                                var peringkat_kpmr_pil3_2 = "Kurang Memadai";
                                            } else if (total_kpmr_pil3_2 >= 4.25 && total_kpmr_pil3_2 <= 5.00) {
                                                var peringkat_kpmr_pil3_2 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil3_2 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil3_2").val(peringkat_kpmr_pil3_2);
                                        });


                                        $("#kpmr_pil3_3a, #kpmr_pil3_3b, #kpmr_pil3_3c").change(function() {
                                            
                                            var kpmr_pil3_3a = $("#kpmr_pil3_3a").val();
                                            var kpmr_pil3_3b = $("#kpmr_pil3_3b").val();
                                            var kpmr_pil3_3c = $("#kpmr_pil3_3c").val();
                                            

                                            var total = parseFloat(kpmr_pil3_3a) + parseFloat(kpmr_pil3_3b) + parseFloat(kpmr_pil3_3c);
                                            var total_kpmr_pil3_3 = parseFloat(total) / 3;
                                            total_kpmr_pil3_3 = total_kpmr_pil3_3.toFixed(2);
                                            $("#total_kpmr_pil3_3").val(total_kpmr_pil3_3);

                                            if (total_kpmr_pil3_3 < 1.00) {
                                                var peringkat_kpmr_pil3_3 = "Belum Terisi";
                                            } else if (total_kpmr_pil3_3 >= 1.00 && total_kpmr_pil3_3 < 1.25) {
                                                var peringkat_kpmr_pil3_3 = "Sangat Memadai";
                                            } else if (total_kpmr_pil3_3 >= 1.25 && total_kpmr_pil3_3 < 2.25) {
                                                var peringkat_kpmr_pil3_3 = "Memadai";
                                            } else if (total_kpmr_pil3_3 >= 2.25 && total_kpmr_pil3_3 < 3.25) {
                                                var peringkat_kpmr_pil3_3 = "Cukup Memadai";
                                            } else if (total_kpmr_pil3_3 >= 3.25 && total_kpmr_pil3_3 < 4.25) {
                                                var peringkat_kpmr_pil3_3 = "Kurang Memadai";
                                            } else if (total_kpmr_pil3_3 >= 4.25 && total_kpmr_pil3_3 <= 5.00) {
                                                var peringkat_kpmr_pil3_3 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil3_3 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil3_3").val(peringkat_kpmr_pil3_3);
                                        });


                                        $("#kpmr_pil3_4a, #kpmr_pil3_4b, #kpmr_pil3_4c").change(function() {
                                            
                                            var kpmr_pil3_4a = $("#kpmr_pil3_4a").val();
                                            var kpmr_pil3_4b = $("#kpmr_pil3_4b").val();
                                            var kpmr_pil3_4c = $("#kpmr_pil3_4c").val();
                                            

                                            var total = parseFloat(kpmr_pil3_4a) + parseFloat(kpmr_pil3_4b) + parseFloat(kpmr_pil3_4c);
                                            var total_kpmr_pil3_4 = parseFloat(total) / 3;
                                            total_kpmr_pil3_4 = total_kpmr_pil3_4.toFixed(2);
                                            $("#total_kpmr_pil3_4").val(total_kpmr_pil3_4);

                                            if (total_kpmr_pil3_4 < 1.00) {
                                                var peringkat_kpmr_pil3_4 = "Belum Terisi";
                                            } else if (total_kpmr_pil3_4 >= 1.00 && total_kpmr_pil3_4 < 1.25) {
                                                var peringkat_kpmr_pil3_4 = "Sangat Memadai";
                                            } else if (total_kpmr_pil3_4 >= 1.25 && total_kpmr_pil3_4 < 2.25) {
                                                var peringkat_kpmr_pil3_4 = "Memadai";
                                            } else if (total_kpmr_pil3_4 >= 2.25 && total_kpmr_pil3_4 < 3.25) {
                                                var peringkat_kpmr_pil3_4 = "Cukup Memadai";
                                            } else if (total_kpmr_pil3_4 >= 3.25 && total_kpmr_pil3_4 < 4.25) {
                                                var peringkat_kpmr_pil3_4 = "Kurang Memadai";
                                            } else if (total_kpmr_pil3_4 >= 4.25 && total_kpmr_pil3_4 <= 5.00) {
                                                var peringkat_kpmr_pil3_4 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil3_4 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil3_4").val(peringkat_kpmr_pil3_4);
                                        });
                                    
                                        $("#kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e, #kpmr_pil3_3a, #kpmr_pil3_3b, #kpmr_pil3_3c, #kpmr_pil3_4a, #kpmr_pil3_4b, #kpmr_pil3_4c").change(function() {
                                            
                                            var kpmr_pil3_1a = $("#kpmr_pil3_1a").val();
                                            var kpmr_pil3_1b = $("#kpmr_pil3_1b").val();
                                            var kpmr_pil3_1c = $("#kpmr_pil3_1c").val();
                                            var kpmr_pil3_1d = $("#kpmr_pil3_1d").val();
                                            var kpmr_pil3_1e = $("#kpmr_pil3_1e").val();
                                            var kpmr_pil3_1f = $("#kpmr_pil3_1f").val();
                                            var kpmr_pil3_1g = $("#kpmr_pil3_1g").val();
                                            var kpmr_pil3_1h = $("#kpmr_pil3_1h").val();
                                            var kpmr_pil3_1i = $("#kpmr_pil3_1i").val();
                                            var kpmr_pil3_1j = $("#kpmr_pil3_1j").val();

                                            var kpmr_pil3_2a = $("#kpmr_pil3_2a").val();
                                            var kpmr_pil3_2b = $("#kpmr_pil3_2b").val();
                                            var kpmr_pil3_2c = $("#kpmr_pil3_2c").val();
                                            var kpmr_pil3_2d = $("#kpmr_pil3_2d").val();
                                            var kpmr_pil3_2e = $("#kpmr_pil3_2e").val();

                                            var kpmr_pil3_3a = $("#kpmr_pil3_3a").val();
                                            var kpmr_pil3_3b = $("#kpmr_pil3_3b").val();
                                            var kpmr_pil3_3c = $("#kpmr_pil3_3c").val();

                                            var kpmr_pil3_4a = $("#kpmr_pil3_4a").val();
                                            var kpmr_pil3_4b = $("#kpmr_pil3_4b").val();
                                            var kpmr_pil3_4c = $("#kpmr_pil3_4c").val();
                                            

                                            var total = parseFloat(kpmr_pil3_1a) + parseFloat(kpmr_pil3_1b) + parseFloat(kpmr_pil3_1c) + parseFloat(kpmr_pil3_1d) + parseFloat(kpmr_pil3_1e) + parseFloat(kpmr_pil3_1f) + parseFloat(kpmr_pil3_1g) + parseFloat(kpmr_pil3_1h) + parseFloat(kpmr_pil3_1i) + parseFloat(kpmr_pil3_1j);
                                            var total_kpmr_pil3_1 = parseFloat(total) / 10;
                                            total_kpmr_pil3_1 = total_kpmr_pil3_1.toFixed(2);

                                            var total = parseFloat(kpmr_pil3_2a) + parseFloat(kpmr_pil3_2b) + parseFloat(kpmr_pil3_2c) + parseFloat(kpmr_pil3_2d) + parseFloat(kpmr_pil3_2e);
                                            var total_kpmr_pil3_2 = parseFloat(total) / 5;
                                            total_kpmr_pil3_2 = total_kpmr_pil3_2.toFixed(2);

                                            var total = parseFloat(kpmr_pil3_3a) + parseFloat(kpmr_pil3_3b) + parseFloat(kpmr_pil3_3c);
                                            var total_kpmr_pil3_3 = parseFloat(total) / 3;
                                            total_kpmr_pil3_3 = total_kpmr_pil3_3.toFixed(2);

                                            var total = parseFloat(kpmr_pil3_4a) + parseFloat(kpmr_pil3_4b) + parseFloat(kpmr_pil3_4c);
                                            var total_kpmr_pil3_4 = parseFloat(total) / 3;
                                            total_kpmr_pil3_4 = total_kpmr_pil3_4.toFixed(2);

                                            const max = [total_kpmr_pil3_1, total_kpmr_pil3_2, total_kpmr_pil3_3, total_kpmr_pil3_4];
                                            const maxValue = Math.max(...max);
                                            tertinggi_pil3 = maxValue.toFixed(2);

                                            $("#tertinggi_pil3").val(tertinggi_pil3);
                                    

                                            const min = [total_kpmr_pil3_1, total_kpmr_pil3_2, total_kpmr_pil3_3, total_kpmr_pil3_4];
                                            const minValue = Math.min(...min);
                                            terendah_pil3 = minValue.toFixed(2);

                                            $("#terendah_pil3").val(terendah_pil3);

                                            var total_rata_rata = parseFloat(total_kpmr_pil3_1) + parseFloat(total_kpmr_pil3_2) + parseFloat(total_kpmr_pil3_3) + parseFloat(total_kpmr_pil3_4) ;
                                            
                                            var rata_rata_pil3 = parseFloat(total_rata_rata) / 4;
                                            rata_rata_pil3 = rata_rata_pil3.toFixed(2);

                                            rr3 = rata_rata_pil3;

                                            $("#rata_rata_pil3").val(rata_rata_pil3);

                                        });
                                        $("#kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e, #kpmr_pil3_3a, #kpmr_pil3_3b, #kpmr_pil3_3c, #kpmr_pil3_4a, #kpmr_pil3_4b, #kpmr_pil3_4c, #opsi_pil3").change(function() {
                                            var opsi_pil3 = $("#opsi_pil3").val();
                                           
                                            if (opsi_pil3 == 1) {
                                                var risiko_pil3 = tertinggi_pil3;
                                            } else if (opsi_pil3 == 2) {
                                                var risiko_pil3 = terendah_pil3;
                                            } else if (opsi_pil3 == 3) {
                                                var risiko_pil3 = rr3;
                                            } else {
                                                var risiko_pil3 = 0;
                                            }

                                            $("#risiko_pil3").val(risiko_pil3);
                                            risiko_pilar3 = risiko_pil3;
                                        });
                                    


    //PILAR 4------------------------------------------------------------------
                                        $("#kpmr_pil4_1a, #kpmr_pil4_1b, #kpmr_pil4_1c, #kpmr_pil4_1d, #kpmr_pil4_1e").change(function() {
                                            var kpmr_pil4_1a = $("#kpmr_pil4_1a").val();
                                            var kpmr_pil4_1b = $("#kpmr_pil4_1b").val();
                                            var kpmr_pil4_1c = $("#kpmr_pil4_1c").val();
                                            var kpmr_pil4_1d = $("#kpmr_pil4_1d").val();
                                            var kpmr_pil4_1e = $("#kpmr_pil4_1e").val();
                                            

                                            var total = parseFloat(kpmr_pil4_1a) + parseFloat(kpmr_pil4_1b) + parseFloat(kpmr_pil4_1c) + parseFloat(kpmr_pil4_1d) + parseFloat(kpmr_pil4_1e);
                                            var total_kpmr_pil4_1 = parseFloat(total) / 5;
                                            var total_kpmr_pil4_1 = total_kpmr_pil4_1.toFixed(2);
                                            $("#total_kpmr_pil4_1").val(total_kpmr_pil4_1);

                                            if (total_kpmr_pil4_1 < 1.00) {
                                                var peringkat_kpmr_pil4_1 = "Belum Terisi";
                                            } else if (total_kpmr_pil4_1 >= 1.00 && total_kpmr_pil4_1 < 1.25) {
                                                var peringkat_kpmr_pil4_1 = "Sangat Memadai";
                                            } else if (total_kpmr_pil4_1 >= 1.25 && total_kpmr_pil4_1 < 2.25) {
                                                var peringkat_kpmr_pil4_1 = "Memadai";
                                            } else if (total_kpmr_pil4_1 >= 2.25 && total_kpmr_pil4_1 < 3.25) {
                                                var peringkat_kpmr_pil4_1 = "Cukup Memadai";
                                            } else if (total_kpmr_pil4_1 >= 3.25 && total_kpmr_pil4_1 < 4.25) {
                                                var peringkat_kpmr_pil4_1 = "Kurang Memadai";
                                            } else if (total_kpmr_pil4_1 >= 4.25 && total_kpmr_pil4_1 <= 5.00) {
                                                var peringkat_kpmr_pil4_1 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil4_1 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil4_1").val(peringkat_kpmr_pil4_1);
                                        });
                                 
                                        $("#kpmr_pil4_2a, #kpmr_pil4_2b").change(function() {
                                            var kpmr_pil4_2a = $("#kpmr_pil4_2a").val();
                                            var kpmr_pil4_2b = $("#kpmr_pil4_2b").val();
                                           

                                            var total = parseFloat(kpmr_pil4_2a) + parseFloat(kpmr_pil4_2b);
                                            var total_kpmr_pil4_2 = parseFloat(total) / 2;
                                            var total_kpmr_pil4_2 = total_kpmr_pil4_2.toFixed(2);
                                            $("#total_kpmr_pil4_2").val(total_kpmr_pil4_2);

                                            if (total_kpmr_pil4_2 < 1.00) {
                                                var peringkat_kpmr_pil4_2 = "Belum Terisi";
                                            } else if (total_kpmr_pil4_2 >= 1.00 && total_kpmr_pil4_2 < 1.25) {
                                                var peringkat_kpmr_pil4_2 = "Sangat Memadai";
                                            } else if (total_kpmr_pil4_2 >= 1.25 && total_kpmr_pil4_2 < 2.25) {
                                                var peringkat_kpmr_pil4_2 = "Memadai";
                                            } else if (total_kpmr_pil4_2 >= 2.25 && total_kpmr_pil4_2 < 3.25) {
                                                var peringkat_kpmr_pil4_2 = "Cukup Memadai";
                                            } else if (total_kpmr_pil4_2 >= 3.25 && total_kpmr_pil4_2 < 4.25) {
                                                var peringkat_kpmr_pil4_2 = "Kurang Memadai";
                                            } else if (total_kpmr_pil4_2 >= 4.25 && total_kpmr_pil4_2 <= 5.00) {
                                                var peringkat_kpmr_pil4_2 = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr_pil4_2 = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr_pil4_2").val(peringkat_kpmr_pil4_2);
                                        });
                                    
                                        $("#kpmr_pil4_1a, #kpmr_pil4_1b, #kpmr_pil4_1c, #kpmr_pil4_1d, #kpmr_pil4_1e, #kpmr_pil4_2a, #kpmr_pil4_2b").change(function() {
                                            
                                            var kpmr_pil4_1a = $("#kpmr_pil4_1a").val();
                                            var kpmr_pil4_1b = $("#kpmr_pil4_1b").val();
                                            var kpmr_pil4_1c = $("#kpmr_pil4_1c").val();
                                            var kpmr_pil4_1d = $("#kpmr_pil4_1d").val();
                                            var kpmr_pil4_1e = $("#kpmr_pil4_1e").val();

                                            var kpmr_pil4_2a = $("#kpmr_pil4_2a").val();
                                            var kpmr_pil4_2b = $("#kpmr_pil4_2b").val();

                                            
                                            

                                            var total = parseFloat(kpmr_pil4_1a) + parseFloat(kpmr_pil4_1b) + parseFloat(kpmr_pil4_1c) + parseFloat(kpmr_pil4_1d) + parseFloat(kpmr_pil4_1e);
                                            var total_kpmr_pil4_1 = parseFloat(total) / 5;
                                            var total_kpmr_pil4_1 = total_kpmr_pil4_1.toFixed(2);


                                            var total = parseFloat(kpmr_pil4_2a) + parseFloat(kpmr_pil4_2b);
                                            var total_kpmr_pil4_2 = parseFloat(total) / 2;
                                            var total_kpmr_pil4_2 = total_kpmr_pil4_2.toFixed(2);

                                            const max = [total_kpmr_pil4_1, total_kpmr_pil4_2];
                                            const maxValue = Math.max(...max);
                                            tertinggi_pil4 = maxValue.toFixed(2);

                                            $("#tertinggi_pil4").val(tertinggi_pil4);
                                       


                                            const min = [total_kpmr_pil4_1, total_kpmr_pil4_2];
                                            const minValue = Math.min(...min);
                                            terendah_pil4 = minValue.toFixed(2);

                                            $("#terendah_pil4").val(terendah_pil4);
                                      


                                            var total_rata_rata = parseFloat(total_kpmr_pil4_1) + parseFloat(total_kpmr_pil4_2);
                                            
                                            var rata_rata_pil4 = parseFloat(total_rata_rata) / 2;
                                            rata_rata_pil4 = rata_rata_pil4.toFixed(2);

                                            rr4 = rata_rata_pil4;

                                            $("#rata_rata_pil4").val(rata_rata_pil4);
                                        });
                                        $("#kpmr_pil4_1a, #kpmr_pil4_1b, #kpmr_pil4_1c, #kpmr_pil4_1d, #kpmr_pil4_1e, #kpmr_pil4_2a, #kpmr_pil4_2b, #opsi_pil4").change(function() {
                                            var opsi_pil4 = $("#opsi_pil4").val();
                                           
                                            if (opsi_pil4 == 1) {
                                                var risiko_pil4 = tertinggi_pil4;
                                            } else if (opsi_pil4 == 2) {
                                                var risiko_pil4 = terendah_pil4;
                                            } else if (opsi_pil4 == 3) {
                                                var risiko_pil4 = rr4;
                                            } else {
                                                var risiko_pil4 = 0;
                                            }

                                            $("#risiko_pil4").val(risiko_pil4);
                                            risiko_pilar4 = risiko_pil4;
                                        });





    //HASIL KPMR------------------------------------------------------------------
                                        $("#kpmr1a, #kpmr1b, #kpmr1c, #kpmr1d, #kpmr1e, #kpmr2a, #kpmr2b, #kpmr2c, #kpmr2d, #kpmr2e, #kpmr3a, #kpmr3b, #kpmr3c, #kpmr4a, #kpmr4b, #kpmr4c, #kpmr4d, #kpmr4e, #kpmr5a, #kpmr5b, #kpmr5c, #kpmr5d, #kpmr6a, #kpmr6b, #kpmr6c, #opsi_pil1, #kpmr_pil2_1a, #kpmr_pil2_1b, #kpmr_pil2_1c, #kpmr_pil2_1d, #kpmr_pil2_1e, #kpmr_pil2_2a, #kpmr_pil2_2b, #kpmr_pil2_2c, #kpmr_pil2_2d, #kpmr_pil2_2e, #kpmr_pil2_2f, #kpmr_pil2_2g, #kpmr_pil2_2h, #kpmr_pil2_3a, #kpmr_pil2_3b, #kpmr_pil2_3c, #opsi_pil2, #kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e, #opsi_pil3, #kpmr_pil4_1a, #kpmr_pil4_1b, #kpmr_pil4_1c, #kpmr_pil4_1d, #kpmr_pil4_1e, #kpmr_pil4_2a, #kpmr_pil4_2b, #opsi_pil4").change(function() {
                                            

                                            const max = [risiko_pilar1, risiko_pilar2, risiko_pilar3, risiko_pilar4];
                                            const maxValue = Math.max(...max);
                                            tertinggi_kpmr = maxValue.toFixed(2);
                                            $("#tertinggi_kpmr").val(tertinggi_kpmr);
                             
                                            const min = [risiko_pilar1, risiko_pilar2, risiko_pilar3, risiko_pilar4];
                                            const minValue = Math.min(...min);
                                            terendah_kpmr = minValue.toFixed(2);
                                            $("#terendah_kpmr").val(terendah_kpmr);
                                      
                                            var total_rata_rata = parseFloat(risiko_pilar1) + parseFloat(risiko_pilar2) + parseFloat(risiko_pilar3) + parseFloat(risiko_pilar4);
                                            var rata_rata_kpmr = parseFloat(total_rata_rata) / 4;
                                            rata_rata_kpmr = rata_rata_kpmr.toFixed(2);
                                            rr_kpmr = rata_rata_kpmr;

                                            $("#rata_rata_kpmr").val(rata_rata_kpmr);
                                        });
                                        $("#kpmr1a, #kpmr1b, #kpmr1c, #kpmr1d, #kpmr1e, #kpmr2a, #kpmr2b, #kpmr2c, #kpmr2d, #kpmr2e, #kpmr3a, #kpmr3b, #kpmr3c, #kpmr4a, #kpmr4b, #kpmr4c, #kpmr4d, #kpmr4e, #kpmr5a, #kpmr5b, #kpmr5c, #kpmr5d, #kpmr6a, #kpmr6b, #kpmr6c, #opsi_pil1, #kpmr_pil2_1a, #kpmr_pil2_1b, #kpmr_pil2_1c, #kpmr_pil2_1d, #kpmr_pil2_1e, #kpmr_pil2_2a, #kpmr_pil2_2b, #kpmr_pil2_2c, #kpmr_pil2_2d, #kpmr_pil2_2e, #kpmr_pil2_2f, #kpmr_pil2_2g, #kpmr_pil2_2h, #kpmr_pil2_3a, #kpmr_pil2_3b, #kpmr_pil2_3c, #opsi_pil2, #kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e, #opsi_pil3, #kpmr_pil4_1a, #kpmr_pil4_1b, #kpmr_pil4_1c, #kpmr_pil4_1d, #kpmr_pil4_1e, #kpmr_pil4_2a, #kpmr_pil4_2b, #opsi_pil4, #opsi_kpmr").change(function() {
                                            var opsi_kpmr = $("#opsi_kpmr").val();
                                           
                                            if (opsi_kpmr == 1) {
                                                var risiko_kpmr = tertinggi_kpmr;
                                            } else if (opsi_kpmr == 2) {
                                                var risiko_kpmr = terendah_kpmr;
                                            } else if (opsi_kpmr == 3) {
                                                var risiko_kpmr = rr_kpmr;
                                            } else {
                                                var risiko_kpmr = 0;
                                            }

                                            $("#risiko_kpmr").val(risiko_kpmr);
                                            nilai_risiko_kpmr = risiko_kpmr;

                                            if (nilai_risiko_kpmr < 1.00) {
                                                var peringkat_kpmr = "Belum Terisi";
                                            } else if (nilai_risiko_kpmr >= 1.00 && nilai_risiko_kpmr < 1.25) {
                                                var peringkat_kpmr = "Sangat Memadai";
                                            } else if (nilai_risiko_kpmr >= 1.25 && nilai_risiko_kpmr < 2.25) {
                                                var peringkat_kpmr = "Memadai";
                                            } else if (nilai_risiko_kpmr >= 2.25 && nilai_risiko_kpmr < 3.25) {
                                                var peringkat_kpmr = "Cukup Memadai";
                                            } else if (nilai_risiko_kpmr >= 3.25 && nilai_risiko_kpmr < 4.25) {
                                                var peringkat_kpmr = "Kurang Memadai";
                                            } else if (nilai_risiko_kpmr >= 4.25 && nilai_risiko_kpmr <= 5.00) {
                                                var peringkat_kpmr = "Tidak Memadai";
                                            } else {
                                                var peringkat_kpmr = "Belum Terisi";
                                            }

                                            $("#peringkat_kpmr").val(peringkat_kpmr);
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

                        <h4 class="page-title">Risiko operasional KPMR 1</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko KPMR 1 Profil Risiko operasional</h4>

                            <hr>
                            </hr>


                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>

           



                            </br>


                            <!-- operasional-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table" bgcolor="#74c7ff">
                                        <tr>

                                            <th colspan="8">
                                                <h4>
                                                    <center><b>RISIKO OPERASIONAL KPMR</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr>
                                            <th width="30px">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center"  width="340px" colspan="2">
                                                PARAMETER PENILAIAN KPMR
                                            </th>

                                            <th class="text-center" width="20px">
                                                UNIT KERJA
                                            </th>
                                            <th class="text-center" width="26%">
                                                RESPON UNIT KERJA
                                            </th>
                                            <th class="text-center" width="15%">
                                                PENILAIAN SUB PARAMETER
                                            </th>
                                            <th class="text-center" width="26%"  colspan="2">
                                                PENILAIAN KPMR
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
                                            <center>Pusat</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="5%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr1" form="my_form" value="<?= $pil1['pil1_total1'] ?>" name="total_kpmr1" class="form-control" readonly="">
                                            </td>
                                            <td width="13%">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr1" form="my_form" value="<?= $pil1['pil1_peringkat1'] ?>" name="peringkat_kpmr1" class="form-control" readonly="">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td width="18%"><textarea class="form-control" id="respon_pil1_1a" form="my_form" name="respon_pil1_1a" cols="35" rows="5"><?= $respon1['respon_pil1_1a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr1a" form="my_form" name="kpmr1a">
                                                    <option <?= $pil1['pilar1_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_1a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_1a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_1a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_1a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_1b" form="my_form" name="respon_pil1_1b" cols="35" rows="5"><?= $respon1['respon_pil1_1b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr1b" form="my_form" name="kpmr1b">
                                                    <option <?= $pil1['pilar1_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_1b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_1b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_1b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_1b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_1c" form="my_form" name="respon_pil1_1c" cols="35" rows="5"><?= $respon1['respon_pil1_1c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr1c" form="my_form" name="kpmr1c">
                                                    <option <?= $pil1['pilar1_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_1c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_1c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_1c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_1c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_1d" form="my_form" name="respon_pil1_1d" cols="35" rows="5"><?= $respon1['respon_pil1_1d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr1d" form="my_form" name="kpmr1d">
                                                    <option <?= $pil1['pilar1_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_1d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_1d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_1d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_1d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_1e" form="my_form" name="respon_pil1_1e" cols="35" rows="5"><?= $respon1['respon_pil1_1e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr1e" form="my_form" name="kpmr1e">
                                                    <option <?= $pil1['pilar1_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_1e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_1e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_1e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_1e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>



                                <!--pilar1 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko  operasional secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?
                                            </b><td>
                                            <center>Pusat</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr2" form="my_form" value="<?= $pil1['pil1_total2'] ?>" name="total_kpmr2" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr2" form="my_form" value="<?= $pil1['pil1_peringkat2'] ?>" name="peringkat_kpmr2" class="form-control"  readonly="">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_2a" form="my_form" name="respon_pil1_2a" cols="35" rows="5"><?= $respon1['respon_pil1_2a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr2a" form="my_form" name="kpmr2a">
                                                    <option <?= $pil1['pilar1_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_2a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_2a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_2a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_2a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_2b" form="my_form" name="respon_pil1_2b" cols="35" rows="5"><?= $respon1['respon_pil1_2b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr2b" form="my_form" name="kpmr2b">
                                                    <option <?= $pil1['pilar1_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_2c" form="my_form" name="respon_pil1_2c" cols="35" rows="5"><?= $respon1['respon_pil1_2c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr2c" form="my_form" name="kpmr2c">
                                                    <option <?= $pil1['pilar1_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_2c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_2c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_2c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_2c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_2d" form="my_form" name="respon_pil1_2d" cols="35" rows="5"><?= $respon1['respon_pil1_2d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr2d" form="my_form" name="kpmr2d">
                                                    <option <?= $pil1['pilar1_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_2d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_2d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_2d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_2d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_2e" form="my_form" name="respon_pil1_2e" cols="35" rows="5"><?= $respon1['respon_pil1_2e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr2e" form="my_form" name="kpmr2e">
                                                    <option <?= $pil1['pilar1_2e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_2e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_2e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_2e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_2e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>

                                        <!--pilar1 parameter3-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah  Direksi telah menyusun kebijakan Manajemen Risiko operasional, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?
                                            </b><td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr3" form="my_form" value="<?= $pil1['pil1_total3'] ?>" name="total_kpmr3" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr3" form="my_form" value="<?= $pil1['pil1_peringkat3'] ?>" name="peringkat_kpmr3" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_3a" form="my_form" name="respon_pil1_3a" cols="35" rows="5"><?= $respon1['respon_pil1_3a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr3a" form="my_form" name="kpmr3a">
                                                    <option <?= $pil1['pilar1_3a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_3a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_3a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_3a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_3a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_3b" form="my_form" name="respon_pil1_3b" cols="35" rows="5"><?= $respon1['respon_pil1_3b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr3b" form="my_form" name="kpmr3b">
                                                    <option <?= $pil1['pilar1_3b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_3b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_3b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_3b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_3b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_3c" form="my_form" name="respon_pil1_3c" cols="35" rows="5"><?= $respon1['respon_pil1_3c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr3c" form="my_form" name="kpmr3c">
                                                    <option <?= $pil1['pilar1_3c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_3c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_3c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_3c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_3c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>
                                            
                                        </tr>

                                <!--pilar1 parameter4-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah  Direksi telah  memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi  Risiko Operasional, dan melakukan komunikasi kebijakan Manajemen Risiko  operasional terhadap seluruh  jenjang organisasi BPR?
                                            </b><td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr4" form="my_form" value="<?= $pil1['pil1_total4'] ?>" name="total_kpmr4" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr4" form="my_form" value="<?= $pil1['pil1_peringkat4'] ?>" name="peringkat_kpmr4" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_4a" form="my_form" name="respon_pil1_4a" cols="35" rows="5"><?= $respon1['respon_pil1_4a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr4a" form="my_form" name="kpmr4a">
                                                    <option <?= $pil1['pilar1_4a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_4a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_4a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_4a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_4a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_4b" form="my_form" name="respon_pil1_4b" cols="35" rows="5"><?= $respon1['respon_pil1_4b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr4b" form="my_form" name="kpmr4b">
                                                    <option <?= $pil1['pilar1_4b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_4b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_4b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_4b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_4b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_4c" form="my_form" name="respon_pil1_4c" cols="35" rows="5"><?= $respon1['respon_pil1_4c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr4c" form="my_form" name="kpmr4c">
                                                    <option <?= $pil1['pilar1_4c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_4c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_4c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_4c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_4c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_4d" form="my_form" name="respon_pil1_4d" cols="35" rows="5"><?= $respon1['respon_pil1_4d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr4d" form="my_form" name="kpmr4d">
                                                    <option <?= $pil1['pilar1_4d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_4d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_4d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_4d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_4d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_4e" form="my_form" name="respon_pil1_4e" cols="35" rows="5"><?= $respon1['respon_pil1_4e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr4e" form="my_form" name="kpmr4e">
                                                    <option <?= $pil1['pilar1_4e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_4e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_4e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_4e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_4e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                                            
                                        </tr>

                                <!--pilar1 parameter5-->

                               <tr bgcolor="#edebe8">
                                            <th>
                                                <center>5</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi operasional dan  fungsi Manajemen Risiko Operasional ?	
                                            </b><td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr5" form="my_form" value="<?= $pil1['pil1_total5'] ?>" name="total_kpmr5" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr5" form="my_form" value="<?= $pil1['pil1_peringkat5'] ?>" name="peringkat_kpmr5" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_5a" form="my_form" name="respon_pil1_5a" cols="35" rows="5"><?= $respon1['respon_pil1_5a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr5a" form="my_form" name="kpmr5a">
                                                    <option <?= $pil1['pilar1_5a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_5a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_5a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_5a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_5a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_5a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_5b" form="my_form" name="respon_pil1_5b" cols="35" rows="5"><?= $respon1['respon_pil1_5b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr5b" form="my_form" name="kpmr5b">
                                                    <option <?= $pil1['pilar1_5b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_5b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_5b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_5b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_5b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_5b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_5c" form="my_form" name="respon_pil1_5c" cols="35" rows="5"><?= $respon1['respon_pil1_5c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr5c" form="my_form" name="kpmr5c">
                                                    <option <?= $pil1['pilar1_5c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_5c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_5c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_5c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_5c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_5c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_5d" form="my_form" name="respon_pil1_5d" cols="35" rows="5"><?= $respon1['respon_pil1_5d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr5d" form="my_form" name="kpmr5d">
                                                    <option <?= $pil1['pilar1_5d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_5d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_5d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_5d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_5d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_5d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
                                            </td>
                                        </tr>

                                        <!--pilar1 parameter5-->

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>6</center>
                                            </th>
                                            <th scope="row" colspan="2"><b>
                                            Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko Operasional?
                                            </b><td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td>
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr6" form="my_form" value="<?= $pil1['pil1_total6'] ?>" name="total_kpmr6" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr6" form="my_form" value="<?= $pil1['pil1_peringkat6'] ?>" name="peringkat_kpmr6" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_6a" form="my_form" name="respon_pil1_6a" cols="35" rows="5"><?= $respon1['respon_pil1_6a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr6a" form="my_form" name="kpmr6a">
                                                    <option <?= $pil1['pilar1_6a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_6a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_6a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_6a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_6a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_6a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_6b" form="my_form" name="respon_pil1_6b" cols="35" rows="5"><?= $respon1['respon_pil1_6b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr6b" form="my_form" name="kpmr6b">
                                                    <option <?= $pil1['pilar1_6b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_6b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_6b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_6b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_6b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_6b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil1_6c" form="my_form" name="respon_pil1_6c" cols="35" rows="5"><?= $respon1['respon_pil1_6c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr6c" form="my_form" name="kpmr6c">
                                                    <option <?= $pil1['pilar1_6c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_6c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil1['pilar1_6c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil1['pilar1_6c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil1['pilar1_6c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil1['pilar1_6c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            Apakah BPR telah memiliki kebijakan Manajemen Risiko Operasional yang  memadai dan disusun dengan mempertimbangkan  visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_1" form="my_form" value="<?= $pil2['pil2_total1'] ?>" name="total_kpmr_pil2_1" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil2_1" form="my_form" value="<?= $pil2['pil2_peringkat1'] ?>" name="peringkat_kpmr_pil2_1" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_1a" form="my_form" name="respon_pil2_1a" cols="35" rows="5"><?= $respon2['respon_pil2_1a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_1a" form="my_form" name="kpmr_pil2_1a">
                                                    <option <?= $pil2['pilar2_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_1a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_1a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_1a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_1a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_1b" form="my_form" name="respon_pil2_1b" cols="35" rows="5"><?= $respon2['respon_pil2_1b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_1b" form="my_form" name="kpmr_pil2_1b">
                                                    <option <?= $pil2['pilar2_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_1b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_1b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_1b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_1b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_1c" form="my_form" name="respon_pil2_1c" cols="35" rows="5"><?= $respon2['respon_pil2_1c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_1c" form="my_form" name="kpmr_pil2_1c">
                                                    <option <?= $pil2['pilar2_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_1c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_1c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_1c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_1c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_1d" form="my_form" name="respon_pil2_1d" cols="35" rows="5"><?= $respon2['respon_pil2_1d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_1d" form="my_form" name="kpmr_pil2_1d">
                                                    <option <?= $pil2['pilar2_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_1d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_1d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_1d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_1d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>


                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_1e" form="my_form" name="respon_pil2_1e" cols="35" rows="5"><?= $respon2['respon_pil2_1e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_1e" form="my_form" name="kpmr_pil2_1e">
                                                    <option <?= $pil2['pilar2_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_1e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_1e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_1e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_1e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>


                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>

                                        <!--pilar2 parameter2-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            "Apakah BPR:
1. memiliki prosedur Manajemen Risiko  Operasional dan penetapan limit Risiko operasional yang ditetapkan oleh Direksi  ?
2. melaksanakan prosedur Manajemen Risiko Operasional dan penetapan limit Risiko operasional  secara konsisten untuk seluruh aktivitas ?  Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko Operasional dan penetapan limit Risiko operasional secara berkala?"	

                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_2" form="my_form" value="<?= $pil2['pil2_total2'] ?>" name="total_kpmr_pil2_2" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil2_2" form="my_form" value="<?= $pil2['pil2_peringkat2'] ?>" name="peringkat_kpmr_pil2_2" class="form-control"  readonly="">
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>
                                            Apakah Unit Kerja telah memahami penertapan limit dan toleransi risiko operasional yang ditetapkan dalam SK Direksi
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2a" form="my_form" name="respon_pil2_2a" cols="35" rows="5"><?= $respon2['respon_pil2_2a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2a" form="my_form" name="kpmr_pil2_2a">
                                                    <option <?= $pil2['pilar2_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>


                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2b" form="my_form" name="respon_pil2_2b" cols="35" rows="5"><?= $respon2['respon_pil2_2b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2b" form="my_form" name="kpmr_pil2_2b">
                                                    <option <?= $pil2['pilar2_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2c" form="my_form" name="respon_pil2_2c" cols="35" rows="5"><?= $respon2['respon_pil2_2c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2c" form="my_form" name="kpmr_pil2_2c">
                                                    <option <?= $pil2['pilar2_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2d" form="my_form" name="respon_pil2_2d" cols="35" rows="5"><?= $respon2['respon_pil2_2d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2d" form="my_form" name="kpmr_pil2_2d">
                                                    <option <?= $pil2['pilar2_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2e" form="my_form" name="respon_pil2_2e" cols="35" rows="5"><?= $respon2['respon_pil2_2e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2e" form="my_form" name="kpmr_pil2_2e">
                                                    <option <?= $pil2['pilar2_2e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2f" form="my_form" name="respon_pil2_2f" cols="35" rows="5"><?= $respon2['respon_pil2_2f'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2f" form="my_form" name="kpmr_pil2_2f">
                                                    <option <?= $pil2['pilar2_2f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2f'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2f'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2f'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2f'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2f'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2g" form="my_form" name="respon_pil2_2g" cols="35" rows="5"><?= $respon2['respon_pil2_2g'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2g" form="my_form" name="kpmr_pil2_2g">
                                                    <option <?= $pil2['pilar2_2g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2g'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2g'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2g'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2g'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2g'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_2h" form="my_form" name="respon_pil2_2h" cols="35" rows="5"><?= $respon2['respon_pil2_2h'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_2h" form="my_form" name="kpmr_pil2_2h">
                                                    <option <?= $pil2['pilar2_2h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2h'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_2h'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_2h'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_2h'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_2h'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>

                                        <!--pilar2 parameter3-->
                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2">Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan.atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko operasional sesuai dengan ketentuan?
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil2_3" form="my_form" value="<?= $pil2['pil2_total3'] ?>" name="total_kpmr_pil2_3" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil2_3" form="my_form" value="<?= $pil2['pil2_peringkat3'] ?>" name="peringkat_kpmr_pil2_3" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_3a" form="my_form" name="respon_pil2_3a" cols="35" rows="5"><?= $respon2['respon_pil2_3a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_3a" form="my_form" name="kpmr_pil2_3a">
                                                    <option <?= $pil2['pilar2_3a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_3a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_3a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_3a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_3a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_3a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_3b" form="my_form" name="respon_pil2_3b" cols="35" rows="5"><?= $respon2['respon_pil2_3b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_3b" form="my_form" name="kpmr_pil2_3b">
                                                    <option <?= $pil2['pilar2_3b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_3b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_3b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_3b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_3b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_3b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil2_3c" form="my_form" name="respon_pil2_3c" cols="35" rows="5"><?= $respon2['respon_pil2_3c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil2_3c" form="my_form" name="kpmr_pil2_3c">
                                                    <option <?= $pil2['pilar2_3c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_3c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil2['pilar2_3c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil2['pilar2_3c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil2['pilar2_3c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil2['pilar2_3c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            Apakah BPR telah melaksanakan proses Manajemen Risiko Operasional yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko operasional ?	
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_1" form="my_form" value="<?= $pil3['pil3_total1'] ?>"  name="total_kpmr_pil3_1" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil3_1" form="my_form" value="<?= $pil3['pil3_peringkat1'] ?>"  name="peringkat_kpmr_pil3_1" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1a" form="my_form" name="respon_pil3_1a" cols="35" rows="5"><?= $respon3['respon_pil3_1a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1a" form="my_form" name="kpmr_pil3_1a">
                                                    <option <?= $pil3['pilar3_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1b" form="my_form" name="respon_pil3_1b" cols="35" rows="5"><?= $respon3['respon_pil3_1b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1b" form="my_form" name="kpmr_pil3_1b">
                                                    <option <?= $pil3['pilar3_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1c" form="my_form" name="respon_pil3_1c" cols="35" rows="5"><?= $respon3['respon_pil3_1c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1c" form="my_form" name="kpmr_pil3_1c">
                                                    <option <?= $pil3['pilar3_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1d" form="my_form" name="respon_pil3_1d" cols="35" rows="5"><?= $respon3['respon_pil3_1d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1d" form="my_form" name="kpmr_pil3_1d">
                                                    <option <?= $pil3['pilar3_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1e" form="my_form" name="respon_pil3_1e" cols="35" rows="5"><?= $respon3['respon_pil3_1e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1e" form="my_form" name="kpmr_pil3_1e">
                                                    <option <?= $pil3['pilar3_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1f" form="my_form" name="respon_pil3_1f" cols="35" rows="5"><?= $respon3['respon_pil3_1f'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1f" form="my_form" name="kpmr_pil3_1f">
                                                    <option <?= $pil3['pilar3_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1f'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1f'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1f'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1f'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1f'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                g.
                                            </th>
                                            <th>
                                            Apakah kesesuaian asumsi, data, dan prosedur yang digunakaa untuk mengukur risiko operasional telah dilakukan evaluasi
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1g" form="my_form" name="respon_pil3_1g" cols="35" rows="5"><?= $respon3['respon_pil3_1g'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1g" form="my_form" name="kpmr_pil3_1g">
                                                    <option <?= $pil3['pilar3_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1g'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1g'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1g'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1g'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1g'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1h" form="my_form" name="respon_pil3_1h" cols="35" rows="5"><?= $respon3['respon_pil3_1h'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1h" form="my_form" name="kpmr_pil3_1h">
                                                    <option <?= $pil3['pilar3_1h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1h'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1h'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1h'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1h'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1h'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1i" form="my_form" name="respon_pil3_1i" cols="35" rows="5"><?= $respon3['respon_pil3_1i'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1i" form="my_form" name="kpmr_pil3_1i">
                                                    <option <?= $pil3['pilar3_1i'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1i'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1i'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1i'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1i'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1i'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                j.
                                            </th>
                                            <th>
                                            Apabila terdapat perubahan yang material dalam faktor risiko operasional apakah juga dilakukan penyesuian pelaporan
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_1j" form="my_form" name="respon_pil3_1j" cols="35" rows="5"><?= $respon3['respon_pil3_1j'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_1j" form="my_form" name="kpmr_pil3_1j">
                                                    <option <?= $pil3['pilar3_1j'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1j'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_1j'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_1j'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_1j'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_1j'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_2" form="my_form" value="<?= $pil3['pil3_total2'] ?>" name="total_kpmr_pil3_2" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil3_2" form="my_form" value="<?= $pil3['pil3_peringkat2'] ?>" name="peringkat_kpmr_pil3_2" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_2a" form="my_form" name="respon_pil3_2a" cols="35" rows="5"><?= $respon3['respon_pil3_2a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_2a" form="my_form" name="kpmr_pil3_2a">
                                                    <option <?= $pil3['pilar3_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_2a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_2a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_2a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_2a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_2b" form="my_form" name="respon_pil3_2b" cols="35" rows="5"><?= $respon3['respon_pil3_2b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_2b" form="my_form" name="kpmr_pil3_2b">
                                                    <option <?= $pil3['pilar3_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_2c" form="my_form" name="respon_pil3_2c" cols="35" rows="5"><?= $respon3['respon_pil3_2c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_2c" form="my_form" name="kpmr_pil3_2c">
                                                    <option <?= $pil3['pilar3_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_2c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_2c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_2c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_2c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_2d" form="my_form" name="respon_pil3_2d" cols="35" rows="5"><?= $respon3['respon_pil3_2d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_2d" form="my_form" name="kpmr_pil3_2d">
                                                    <option <?= $pil3['pilar3_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_2d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_2d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_2d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_2d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_2e" form="my_form" name="respon_pil3_2e" cols="35" rows="5"><?= $respon3['respon_pil3_2e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_2e" form="my_form" name="kpmr_pil3_2e">
                                                    <option <?= $pil3['pilar3_2e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_2e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_2e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_2e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_2e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                            
                                        </tr>



                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah memiliki kebijakan dan prosedur penyelenggaraan TI ?
                                            </th>
                                            <td>
                                            <center>Pusat</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_3" form="my_form" value="<?= $pil3['pil3_total3'] ?>" name="total_kpmr_pil3_3" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil3_3" form="my_form" value="<?= $pil3['pil3_peringkat3'] ?>" name="peringkat_kpmr_pil3_3" class="form-control"  readonly="">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_3a" form="my_form" name="respon_pil3_3a" cols="35" rows="5"><?= $respon3['respon_pil3_3a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_3a" form="my_form" name="kpmr_pil3_3a">
                                                    <option <?= $pil3['pilar3_3a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_3a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_3a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_3a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_3a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_3a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_3b" form="my_form" name="respon_pil3_3b" cols="35" rows="5"><?= $respon3['respon_pil3_3b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_3b" form="my_form" name="kpmr_pil3_3b">
                                                    <option <?= $pil3['pilar3_3b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_3b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_3b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_3b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_3b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_3b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_3c" form="my_form" name="respon_pil3_3c" cols="35" rows="5"><?= $respon3['respon_pil3_3c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_3c" form="my_form" name="kpmr_pil3_3c">
                                                    <option <?= $pil3['pilar3_3c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_3c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_3c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_3c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_3c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_3c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>4</center>
                                            </th>
                                            <th scope="row" colspan="2">
                                            Apakah BPR telah melakukan langkah mitigasi Risiko terkait kejadian eksternal ?
                                            </th>
                                            <td>
                                            <center>Pusat</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil3_4" form="my_form" value="<?= $pil3['pil3_total4'] ?>" name="total_kpmr_pil3_4" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil3_4" form="my_form" value="<?= $pil3['pil3_peringkat4'] ?>" name="peringkat_kpmr_pil3_4" class="form-control"  readonly="">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_4a" form="my_form" name="respon_pil3_4a" cols="35" rows="5"><?= $respon3['respon_pil3_4a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_4a" form="my_form" name="kpmr_pil3_4a">
                                                    <option <?= $pil3['pilar3_4a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_4a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_4a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_4a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_4a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_4a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_4b" form="my_form" name="respon_pil3_4b" cols="35" rows="5"><?= $respon3['respon_pil3_4b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_4b" form="my_form" name="kpmr_pil3_4b">
                                                    <option <?= $pil3['pilar3_4b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_4b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_4b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_4b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_4b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_4b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil3_4c" form="my_form" name="respon_pil3_4c" cols="35" rows="5"><?= $respon3['respon_pil3_4c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil3_4c" form="my_form" name="kpmr_pil3_4c">
                                                    <option <?= $pil3['pilar3_4c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_4c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil3['pilar3_4c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil3['pilar3_4c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil3['pilar3_4c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil3['pilar3_4c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
                                            </td>
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
                                            Apakah SKAI atau PE Audit Internal telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko operasional, menyampaikan laporan hasil audit  intern, dan  memastikan tindaklanjut atas temuan pemeriksaan?	

                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil4_1" form="my_form" value="<?= $pil4['pil4_total1'] ?>" name="total_kpmr_pil4_1" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil4_1" form="my_form" value="<?= $pil4['pil4_peringkat1'] ?>" name="peringkat_kpmr_pil4_1" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko operasional di berapa cabang atau unit kerja di bidang manajemen risiko peroperasionalan
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_1a" form="my_form" name="respon_pil4_1a" cols="35" rows="5"><?= $respon4['respon_pil4_1a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_1a" form="my_form" name="kpmr_pil4_1a">
                                                    <option <?= $pil4['pilar4_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_1b" form="my_form" name="respon_pil4_1b" cols="35" rows="5"><?= $respon4['respon_pil4_1b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_1b" form="my_form" name="kpmr_pil4_1b">
                                                    <option <?= $pil4['pilar4_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_1c" form="my_form" name="respon_pil4_1c" cols="35" rows="5"><?= $respon4['respon_pil4_1c'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_1c" form="my_form" name="kpmr_pil4_1c">
                                                    <option <?= $pil4['pilar4_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_1d" form="my_form" name="respon_pil4_1d" cols="35" rows="5"><?= $respon4['respon_pil4_1d'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_1d" form="my_form" name="kpmr_pil4_1d">
                                                    <option <?= $pil4['pilar4_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1d'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_1d'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_1d'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_1d'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_1d'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_1e" form="my_form" name="respon_pil4_1e" cols="35" rows="5"><?= $respon4['respon_pil4_1e'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_1e" form="my_form" name="kpmr_pil4_1e">
                                                    <option <?= $pil4['pilar4_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1e'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_1e'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_1e'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_1e'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_1e'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td colspan="2"></td>
                                            <td width="8%">
                                            <center>Nilai</center>
                                            <input type="number" id="total_kpmr_pil4_2" form="my_form" value="<?= $pil4['pil4_total2'] ?>" name="total_kpmr_pil4_2" class="form-control"  readonly="">
                                            </td>
                                            <td>
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr_pil4_2" form="my_form" value="<?= $pil4['pil4_peringkat2'] ?>" name="peringkat_kpmr_pil4_2" class="form-control"  readonly="">
                                            </td>
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th width="1px">
                                                a.
                                            </th>
                                            <th>Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional operasional
                                            </th>
                                            <td>
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_2a" form="my_form" name="respon_pil4_2a" cols="35" rows="5"><?= $respon4['respon_pil4_2a'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_2a" form="my_form" name="kpmr_pil4_2a">
                                                    <option <?= $pil4['pilar4_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_2a'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_2a'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_2a'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_2a'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_2a'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>

                                                </select></td>

                                            <td  colspan="2">
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
                                            <center>Pusat Dan Cabang</center>
                                            </td>
                                            <td><textarea class="form-control" id="respon_pil4_2b" form="my_form" name="respon_pil4_2b" cols="35" rows="5"><?= $respon4['respon_pil4_2b'] ?></textarea></td>
                                            <td> <select class="form-select" id="kpmr_pil4_2b" form="my_form" name="kpmr_pil4_2b">
                                                    <option <?= $pil4['pilar4_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_2b'] == "1" ? "selected" : "" ?>>Sangat Memadai</option>
                                                    <option value="2" <?= $pil4['pilar4_2b'] == "2" ? "selected" : "" ?>>Memadai</option>
                                                    <option value="3" <?= $pil4['pilar4_2b'] == "3" ? "selected" : "" ?>>Cukup Memadai</option>
                                                    <option value="4" <?= $pil4['pilar4_2b'] == "4" ? "selected" : "" ?>>Kurang Memadai</option>
                                                    <option value="5" <?= $pil4['pilar4_2b'] == "5" ? "selected" : "" ?>>Tidak Memadai</option>
                                                </select></td>

                                            <td  colspan="2">
                                            </td>

                                            
                                        </tr>

                                        



                                    </tbody>


                                </table>
                            </div> <!-- end table-responsive-->









                                <br>
                                </br>
                                <h4>* jangan lupa untuk selalu menyimpan laporan untuk melihat hasil penilaian KPMR , jika mengupdate laporan jangan lupa untuk menyimpan laporan terlebih dahulu agar hasil penilaian KPMR terupdate juga</h4>

                                
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table" bgcolor="#74c7ff">
                                        <tr>

                                            <th colspan="9">
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris
                                            </th>
                                            <td width="10%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil1" form="my_form" value="<?= $hasil['pil1_tertinggi'] ?>" name="tertinggi_pil1" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil1" form="my_form" value="<?= $hasil['pil1_terendah'] ?>" name="terendah_pil1" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil1" form="my_form" value="<?= $hasil['pil1_rata_rata'] ?>" name="rata_rata_pil1" class="form-control"  readonly="">
                                            </td>
                                            <td width="14%">
                                            <center>Risiko ditetapkan</center>    
                                            <select class="form-select" id="opsi_pil1" form="my_form" name="opsi_pil1" style="pointer-events: none;">
                                                    <option selected> </option>
                                                    <option value="1" <?= $kpmr['kpmr_op_set_pil1'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $kpmr['kpmr_op_set_pil1'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $kpmr['kpmr_op_set_pil1'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select></td>
                                            <td width="10%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil1" form="my_form" value="<?= $hasil['pil1_tingkat_risiko'] ?>" name="risiko_pil1" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil2" form="my_form" value="<?= $hasil['pil2_tertinggi'] ?>" name="tertinggi_pil2" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil2" form="my_form" value="<?= $hasil['pil2_terendah'] ?>" name="terendah_pil2"  class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil2" form="my_form" value="<?= $hasil['pil2_rata_rata'] ?>" name="rata_rata_pil2" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Risiko ditetapkan</center>
                                            <select class="form-select" id="opsi_pil2" form="my_form" name="opsi_pil2" style="pointer-events: none;">
                                                    <option selected> </option>
                                                    <option value="1" <?= $kpmr['kpmr_op_set_pil2'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $kpmr['kpmr_op_set_pil2'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $kpmr['kpmr_op_set_pil2'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select></td>
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil2" form="my_form" value="<?= $hasil['pil2_tingkat_risiko'] ?>" name="risiko_pil2" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 3 -  Kecukupan Proses dan Sistem
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil3" form="my_form" value="<?= $hasil['pil3_tertinggi'] ?>" name="tertinggi_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil3" form="my_form" value="<?= $hasil['pil3_terendah'] ?>" name="terendah_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil3" form="my_form" value="<?= $hasil['pil3_rata_rata'] ?>" name="rata_rata_pil3" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Risiko ditetapkan</center>    
                                            <select class="form-select" id="opsi_pil3" form="my_form" name="opsi_pil3" style="pointer-events: none;">
                                                    <option selected> </option>
                                                    <option value="1" <?= $kpmr['kpmr_op_set_pil3'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $kpmr['kpmr_op_set_pil3'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $kpmr['kpmr_op_set_pil3'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select></td>
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil3" form="my_form" value="<?= $hasil['pil3_tingkat_risiko'] ?>" name="risiko_pil3" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                        <tr bgcolor="#acdbfb">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian Pilar 4 -  Sistem Pengendalian yang Menyeluruh
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_pil4" form="my_form" value="<?= $hasil['pil4_tertinggi'] ?>" name="tertinggi_pil4" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_pil4" form="my_form" value="<?= $hasil['pil4_terendah'] ?>" name="terendah_pil4" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_pil4" form="my_form" value="<?= $hasil['pil4_rata_rata'] ?>" name="rata_rata_pil4" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Risiko ditetapkan</center>    
                                            <select class="form-select" id="opsi_pil4" form="my_form" name="opsi_pil4" style="pointer-events: none;">
                                                    <option selected> </option>
                                                    <option value="1" <?= $kpmr['kpmr_op_set_pil4'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $kpmr['kpmr_op_set_pil4'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $kpmr['kpmr_op_set_pil4'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select></td>
                                            <td width="14%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_pil4" form="my_form" value="<?= $hasil['pil4_tingkat_risiko'] ?>" name="risiko_pil4" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <thead class="table" bgcolor="#74c7ff">
                                        <tr>

                                            <th colspan="9">
                                                <center>REKAP PENILAIAN KPMR OPERASIONAL</center>
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table" bgcolor="#74c7ff">
                                            <th scope="row" colspan="4">
                                            Hasil Penilaian KPMR
                                            </th>
                                            <td width="8%">
                                            <center>Tertinggi</center>
                                            <input type="number" id="tertinggi_kpmr" form="my_form" value="<?= $hasil['hasil_kpmr_tertinggi'] ?>" name="tertinggi_kpmr" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Terendah</center>
                                            <input type="number" id="terendah_kpmr" form="my_form" value="<?= $hasil['hasil_kpmr_terendah'] ?>" name="terendah_kpmr" class="form-control"  readonly="">
                                            </td>
                                            <td width="8%">
                                            <center>Rata-rata</center>
                                            <input type="number" id="rata_rata_kpmr" form="my_form" value="<?= $hasil['hasil_kpmr_rata_rata'] ?>" name="rata_rata_kpmr" class="form-control"  readonly="">
                                            </td>
                                            <td width="10%">
                                            <center>Risiko ditetapkan</center>    
                                            <select class="form-select" id="opsi_kpmr" form="my_form" name="opsi_kpmr" style="pointer-events: none;">
                                                    <option selected> </option>
                                                    <option value="1" <?= $kpmr['kpmr_op_set_tingkat_risiko'] == "1" ? "selected" : "" ?>>Tertiggi</option>
                                                    <option value="2" <?= $kpmr['kpmr_op_set_tingkat_risiko'] == "2" ? "selected" : "" ?>>Terendah</option>
                                                    <option value="3" <?= $kpmr['kpmr_op_set_tingkat_risiko'] == "3" ? "selected" : "" ?>>Rata-rata</option>
                                                </select></td>
                                            <td width="15%">
                                            <center>Tingkat risiko</center>
                                            <input type="number" id="risiko_kpmr" form="my_form" value="<?= $hasil['hasil_tingkat_risiko'] ?>" name="risiko_kpmr" class="form-control"  readonly="">
                                            <center>Peringkat</center>
                                            <input type="text" id="peringkat_kpmr" form="my_form" value="<?= $hasil['hasil_peringkat'] ?>" name="peringkat_kpmr" class="form-control"  readonly="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>































                            <hr>
                            </hr>

                            <br></br>







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