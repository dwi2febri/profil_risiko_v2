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
$jenis_pr = $frame['user'];
$tahun = $frame['tahun'];
$periode = $frame['periode'];
$dp = $frame['data_pembanding'];


$length1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_rep_pil1_1) AS l1,
CHAR_LENGTH(ket_in_rep_pil1_1a) AS l2,
CHAR_LENGTH(ket_in_rep_pil1_1b) AS l3,
CHAR_LENGTH(ket_in_rep_pil1_2) AS l4,
CHAR_LENGTH(ket_in_rep_pil1_2a) AS l5,
CHAR_LENGTH(ket_in_rep_pil1_2b) AS l6,
CHAR_LENGTH(ket_in_rep_pil1_2c) AS l7,
CHAR_LENGTH(ket_in_rep_pil1_2d) AS l8 FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$id]));

$length2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_rep_pil2_1) AS l9,
CHAR_LENGTH(ket_in_rep_pil2_1a) AS l10,
CHAR_LENGTH(ket_in_rep_pil2_1b) AS l11,
CHAR_LENGTH(ket_in_rep_pil2_1c) AS l12,
CHAR_LENGTH(ket_in_rep_pil2_2) AS l13,
CHAR_LENGTH(ket_in_rep_pil2_2a) AS l14,
CHAR_LENGTH(ket_in_rep_pil2_2b) AS l15 FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$id]));

$length3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_rep_pil3_2a) AS l16,
CHAR_LENGTH(ket_in_rep_pil3_2b) AS l17 FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$id]));

$length4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_rep_pil4_1a) AS l18,
CHAR_LENGTH(ket_in_rep_pil4_1b) AS l19,
CHAR_LENGTH(ket_in_rep_pil4_1c) AS l20 FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$id]));



$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$dp]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_reputasi WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$id]));
$ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$id]));
$ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$id]));
$ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$id]));

//setingan ditetapkan
$set_pil1_par1 = $inheren['inheren_rep_set_pil1_par1'];
$set_pil1_par2 = $inheren['inheren_rep_set_pil1_par2'];
$set_pil1 = $inheren['inheren_rep_set_pil1'];
$set_pil2_par1 = $inheren['inheren_rep_set_pil2_par1'];
$set_pil2_par2 = $inheren['inheren_rep_set_pil2_par2'];
$set_pil2 = $inheren['inheren_rep_set_pil2'];
$set_pil3_par1 = $inheren['inheren_rep_set_pil3_par1'];
$set_pil3_par2 = $inheren['inheren_rep_set_pil3_par2'];
$set_pil3 = $inheren['inheren_rep_set_pil3'];
$set_pil4_par1 = $inheren['inheren_rep_set_pil4_par1'];
$set_tingkat_risiko = $inheren['inheren_rep_set_tingkat_risiko'];


if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

        //pilar 1
        $pilar1_1 = $_POST['pilar1_1'];
        $pilar1_1a = $_POST['pilar1_1a'];
        $pilar1_1b = $_POST['pilar1_1b'];
        $pilar1_1c = $_POST['pilar1_1c'];
        $pilar1_1d = $_POST['pilar1_1d'];

        $pilar1_2 = $_POST['pilar1_2'];
        $pilar1_2a = $_POST['pilar1_2a'];
        $pilar1_2b = $_POST['pilar1_2b'];
        $pilar1_2c = $_POST['pilar1_2c'];
        $pilar1_2d = $_POST['pilar1_2d'];
        
        

        //pilar 1 1
        $hsl_max_pil1_1 = array($pilar1_1, $pilar1_1a);
        $max_pil1_1 = max($hsl_max_pil1_1);
    
        $hsl_min_pil1_1 = array($pilar1_1, $pilar1_1a);
        $min_pil1_1 = min($hsl_min_pil1_1);
    
        $hsl_avg_pil1_1 = array($pilar1_1, $pilar1_1a);
        $sum_pil1_1 = array_sum($hsl_avg_pil1_1);
        $average_pil1_1 = $sum_pil1_1 / count($hsl_avg_pil1_1);

        if ($set_pil1_par1 == 1) {

            $hasil_pil1_par1 = $max_pil1_1;
        } else if ($set_pil1_par1 == 2) {
    
            $hasil_pil1_par1 = $min_pil1_1;
        } else if ($set_pil1_par1 == 3) {
    
            $hasil_pil1_par1 = $average_pil1_1;
        } else {
        $hasil_pil1_par1 = 0;
        }



        //pilar 1 2
        $hsl_max_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d);
        $max_pil1_2 = max($hsl_max_pil1_2);
    
        $hsl_min_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d);
        $min_pil1_2 = min($hsl_min_pil1_2);
    
        $hsl_avg_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d);
        $sum_pil1_2 = array_sum($hsl_avg_pil1_2);
        $average_pil1_2 = $sum_pil1_2 / count($hsl_avg_pil1_2);

        if ($set_pil1_par2 == 1) {

            $hasil_pil1_par2 = $max_pil1_2;
        } else if ($set_pil1_par2 == 2) {
    
            $hasil_pil1_par2 = $min_pil1_2;
        } else if ($set_pil1_par2 == 3) {
    
            $hasil_pil1_par2 = $average_pil1_2;
        } else {
        $hasil_pil1_par2 = 0;
        }

       


        //HASIL PILAR 1
        $hsl_max_pilar1= array($hasil_pil1_par1, $hasil_pil1_par2);
        $pil1_tertinggi = max($hsl_max_pilar1);
    
        $hsl_min_pilar1 = array($hasil_pil1_par1, $hasil_pil1_par2);
        $pil1_terendah = min($hsl_min_pilar1);
    
        $hsl_avg_pilar1 = array($hasil_pil1_par1, $hasil_pil1_par2);
        $sum_pil1 = array_sum($hsl_avg_pilar1);
        $pil1_rata_rata = $sum_pil1 / count($hsl_avg_pilar1);

        if ($set_pil1 == 1) {

            $pil1_tingkat_risiko = $pil1_tertinggi;

        } else if ($set_pil1 == 2) {
    
            $pil1_tingkat_risiko = $pil1_terendah;
        } else if ($set_pil1 == 3) {
    
            $pil1_tingkat_risiko = $pil1_rata_rata;
        } else {
        $pil1_tingkat_risiko = 0;
        }

        $ket_in_rep_pil1_1 = $_POST['ket_in_rep_pil1_1'];
        $ket_in_rep_pil1_1a = $_POST['ket_in_rep_pil1_1a'];
        $ket_in_rep_pil1_1b = $_POST['ket_in_rep_pil1_1b'];
        $ket_in_rep_pil1_1c = $_POST['ket_in_rep_pil1_1c'];
        $ket_in_rep_pil1_1d = $_POST['ket_in_rep_pil1_1d'];

        $ket_in_rep_pil1_2 = $_POST['ket_in_rep_pil1_2'];
        $ket_in_rep_pil1_2a = $_POST['ket_in_rep_pil1_2a'];
        $ket_in_rep_pil1_2b = $_POST['ket_in_rep_pil1_2b'];
        $ket_in_rep_pil1_2c = $_POST['ket_in_rep_pil1_2c'];
        $ket_in_rep_pil1_2d = $_POST['ket_in_rep_pil1_2d'];





        //pilar 2
        $pilar2_1 = $_POST['pilar2_1'];
        $pilar2_1a = $_POST['pilar2_1a'];
        $pilar2_1b = $_POST['pilar2_1b'];
        $pilar2_1c = $_POST['pilar2_1c'];
        $pilar2_1d = $_POST['pilar2_1d'];
        $pilar2_2 = $_POST['pilar2_2'];
        $pilar2_2a = $_POST['pilar2_2a'];
        $pilar2_2b = $_POST['pilar2_2b'];
        $pilar2_2c = $_POST['pilar2_2c'];
        $pilar2_2d = $_POST['pilar2_2d'];
        


        //pilar 2 1
        $hsl_max_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c);
        $max_pil2_1 = max($hsl_max_pil2_1);
    
        $hsl_min_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c);
        $min_pil2_1 = min($hsl_min_pil2_1);
    
        $hsl_avg_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c);
        $sum_pil2_1 = array_sum($hsl_avg_pil2_1);
        $average_pil2_1 = $sum_pil2_1 / count($hsl_avg_pil2_1);


        if ($set_pil2_par1 == 1) {

            $hasil_pil2_par1 = $max_pil2_1;
        } else if ($set_pil2_par1 == 2) {
    
            $hasil_pil2_par1 = $min_pil2_1;
        } else if ($set_pil2_par1 == 3) {
    
            $hasil_pil2_par1 = $average_pil2_1;
        } else {
        $hasil_pil2_par1 = 0;
        }

        

        //pilar 2 2
        $hsl_max_pil2_2 = array($pilar2_2, $pilar2_2a, $pilar2_2b);
        $max_pil2_2 = max($hsl_max_pil2_2);
    
        $hsl_min_pil2_2 = array($pilar2_2, $pilar2_2a, $pilar2_2b);
        $min_pil2_2 = min($hsl_min_pil2_2);
    
        $hsl_avg_pil2_2 = array($pilar2_2, $pilar2_2a, $pilar2_2b);
        $sum_pil2_2 = array_sum($hsl_avg_pil2_2);
        $average_pil2_2 = $sum_pil2_2 / count($hsl_avg_pil2_2);


        if ($set_pil2_par2 == 1) {

            $hasil_pil2_par2 = $max_pil2_2;
        } else if ($set_pil2_par2 == 2) {
    
            $hasil_pil2_par2 = $min_pil2_2;
        } else if ($set_pil2_par2 == 3) {
    
            $hasil_pil2_par2 = $average_pil2_2;
        } else {
        $hasil_pil2_par2 = 0;
        }


        


        //HASIL PILAR 2
        $hsl_max_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2);
        $pil2_tertinggi = max($hsl_max_pilar2);

        $hsl_min_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2);
        $pil2_terendah = min($hsl_min_pilar2);

        $hsl_avg_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2);
        $sum_pil2 = array_sum($hsl_avg_pilar2);
        $pil2_rata_rata = $sum_pil2 / count($hsl_avg_pilar2);

        if ($set_pil2 == 1) {

            $pil2_tingkat_risiko = $pil2_tertinggi;

        } else if ($set_pil2 == 2) {

            $pil2_tingkat_risiko = $pil2_terendah;
        } else if ($set_pil2 == 3) {

            $pil2_tingkat_risiko = $pil2_rata_rata;
        } else {
        $pil2_tingkat_risiko = 0;
        }





        $ket_in_rep_pil2_1 = $_POST['ket_in_rep_pil2_1'];
        $ket_in_rep_pil2_1a = $_POST['ket_in_rep_pil2_1a'];
        $ket_in_rep_pil2_1b = $_POST['ket_in_rep_pil2_1b'];
        $ket_in_rep_pil2_1c = $_POST['ket_in_rep_pil2_1c'];
        $ket_in_rep_pil2_1d = $_POST['ket_in_rep_pil2_1d'];
        
        $ket_in_rep_pil2_2 = $_POST['ket_in_rep_pil2_2'];
        $ket_in_rep_pil2_2a = $_POST['ket_in_rep_pil2_2a'];
        $ket_in_rep_pil2_2b = $_POST['ket_in_rep_pil2_2b'];



        //pilar 3
        $pilar3_1 = $_POST['pilar3_1'];
        $pilar3_1a = $_POST['pilar3_1a'];
        $pilar3_1b = $_POST['pilar3_1b'];
        $pilar3_1c = $_POST['pilar3_1c'];

        $pilar3_2 = $_POST['pilar3_2'];
        $pilar3_2a = $_POST['pilar3_2a'];
        $pilar3_2b = $_POST['pilar3_2b'];
       

        //pilar 3 1
 



        //pilar 3 2
        $hsl_max_pil3_2 = array($pilar3_2a,$pilar3_2b);
        $max_pil3_2 = max($hsl_max_pil3_2);

        $hsl_min_pil3_2 = array($pilar3_2a,$pilar3_2b);
        $min_pil3_2 = min($hsl_min_pil3_2);

        $hsl_avg_pil3_2 = array($pilar3_2a,$pilar3_2b);
        $sum_pil3_2 = array_sum($hsl_avg_pil3_2);
        $average_pil3_2 = $sum_pil3_2 / count($hsl_avg_pil3_2);

        if ($set_pil3_par2 == 1) {

            $hasil_pil3_par2 = $max_pil3_2;
        } else if ($set_pil3_par2 == 2) {

            $hasil_pil3_par2 = $min_pil3_2;
        } else if ($set_pil3_par2 == 3) {

            $hasil_pil3_par2 = $average_pil3_2;
        } else {
        $hasil_pil3_par2 = 0;
        }


        //HASIL PILAR 3
        $pil3_tertinggi = $max_pil3_2;

        $pil3_terendah = $min_pil3_2;

        
        $pil3_rata_rata = $average_pil3_2;

        if ($set_pil3 == 1) {

            $pil3_tingkat_risiko = $pil3_tertinggi;

        } else if ($set_pil3 == 2) {

            $pil3_tingkat_risiko = $pil3_terendah;
        } else if ($set_pil3 == 3) {

            $pil3_tingkat_risiko = $pil3_rata_rata;
        } else {
        $pil3_tingkat_risiko = 0;
        }


        $ket_in_rep_pil3_1 = $_POST['ket_in_rep_pil3_1'];
        $ket_in_rep_pil3_1a = $_POST['ket_in_rep_pil3_1a'];
        $ket_in_rep_pil3_1b = $_POST['ket_in_rep_pil3_1b'];
        $ket_in_rep_pil3_1c = $_POST['ket_in_rep_pil3_1c'];

        $ket_in_rep_pil3_2 = $_POST['ket_in_rep_pil3_2'];
        $ket_in_rep_pil3_2a = $_POST['ket_in_rep_pil3_2a'];
        $ket_in_rep_pil3_2b = $_POST['ket_in_rep_pil3_2b'];
        


        //pilar 4
        $pilar4_1a = $_POST['pilar4_1a'];
        $pilar4_1b = $_POST['pilar4_1b'];
        $pilar4_1c = $_POST['pilar4_1c'];


        //pilar 4 1
        $hsl_max_pil4_1 = array($pilar4_1a, $pilar4_1b, $pilar4_1c);
        $max_pil4_1 = max($hsl_max_pil4_1);

        $hsl_min_pil4_1 = array($pilar4_1a, $pilar4_1b, $pilar4_1c);
        $min_pil4_1 = min($hsl_min_pil4_1);

        $hsl_avg_pil4_1 = array($pilar4_1a, $pilar4_1b, $pilar4_1c);
        $sum_pil4_1 = array_sum($hsl_avg_pil4_1);
        $average_pil4_1 = $sum_pil4_1 / count($hsl_avg_pil4_1);

        if ($set_pil4_par1 == 1) {

            $hasil_pil4_par1 = $max_pil4_1;
        } else if ($set_pil4_par1 == 2) {

            $hasil_pil4_par1 = $min_pil4_1;
        } else if ($set_pil4_par1 == 3) {

            $hasil_pil4_par1 = $average_pil4_1;
        } else {
        $hasil_pil4_par1 = 0;
        }



        $ket_in_rep_pil4_1a = $_POST['ket_in_rep_pil4_1a'];
        $ket_in_rep_pil4_1b = $_POST['ket_in_rep_pil4_1b'];
        $ket_in_rep_pil4_1c = $_POST['ket_in_rep_pil4_1c'];

      



        //HASIL INHEREN
        $hsl_max_inheren= array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
        $hasil_inheren_tertinggi = max($hsl_max_inheren);
    
        $hsl_min_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
        $hasil_inheren_terendah = min($hsl_min_inheren);
    
        $hsl_avg_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
        $sum_inheren = array_sum($hsl_avg_inheren);
        $hasil_inheren_rata_rata = $sum_inheren / count($hsl_avg_inheren);

        if ($set_tingkat_risiko == 1) {

            $hasil_tingkat_risiko = $hasil_inheren_tertinggi;

        } else if ($set_tingkat_risiko == 2) {
    
            $hasil_tingkat_risiko = $hasil_inheren_terendah;
        } else if ($set_tingkat_risiko == 3) {
    
            $hasil_tingkat_risiko = $hasil_inheren_rata_rata;
        } else {
        $hasil_tingkat_risiko = 0;
        }

        //hasil peringkat
            if ($hasil_tingkat_risiko < 1.00) {
                $hasil_peringkat = " ";
        } else if ($hasil_tingkat_risiko >= 1.00 && $hasil_tingkat_risiko <= 1.25) {
                $hasil_peringkat = "Sangat Rendah";
        } else if ($hasil_tingkat_risiko > 1.25 && $hasil_tingkat_risiko <= 2.25) {
                $hasil_peringkat = "Rendah";
        } else if ($hasil_tingkat_risiko > 2.25 && $hasil_tingkat_risiko <= 3.25) {
                $hasil_peringkat = "Sedang";
        } else if ($hasil_tingkat_risiko > 3.25 && $hasil_tingkat_risiko <= 4.25) {
                $hasil_peringkat = "Tinggi";
        } else if ($hasil_tingkat_risiko > 4.25 && $hasil_tingkat_risiko <= 5.00) {
                $hasil_peringkat = "Sangat Tinggi";
        } else {
                $hasil_peringkat = " ";
        }



    simpro_db_query($conn, "UPDATE inheren_reputasi_pilar1 SET 
        pilar1_1 = ?,
        pilar1_1a = ?,
        pilar1_1b = ?,
        pilar1_1c = ?,
        pilar1_1d = ?,
        pilar1_2 = ?,
        pilar1_2a = ?,
        pilar1_2b = ?,
        pilar1_2c = ?,
        pilar1_2d = ?,
        average_pil1_1 = ?,
        average_pil1_2 = ?,
        min_pil1_1 = ?,
        min_pil1_2 = ?,
        max_pil1_1 = ?,
        max_pil1_2 = ?,
        hasil_pil1_par1 = ?,
        hasil_pil1_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d, $average_pil1_1, $average_pil1_2, $min_pil1_1, $min_pil1_2, $max_pil1_1, $max_pil1_2, $hasil_pil1_par1, $hasil_pil1_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_reputasi_pilar2 SET 
        pilar2_1 = ?,
        pilar2_1a = ?,
        pilar2_1b = ?,
        pilar2_1c = ?,
        pilar2_1d = ?,
        pilar2_2 = ?,
        pilar2_2a = ?,
        pilar2_2b = ?,
        average_pil2_1 = ?,
        average_pil2_2 = ?,
        min_pil2_1 = ?,
        min_pil2_2 = ?,
        max_pil2_1 = ?,
        max_pil2_2 = ?,
        hasil_pil2_par1 = ?,
        hasil_pil2_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_2, $pilar2_2a, $pilar2_2b, $average_pil2_1, $average_pil2_2, $min_pil2_1, $min_pil2_2, $max_pil2_1, $max_pil2_2, $hasil_pil2_par1, $hasil_pil2_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_reputasi_pilar3 SET 
        pilar3_1 = ?,
        pilar3_1a = ?,
        pilar3_1b = ?,
        pilar3_1c = ?,
        pilar3_2 = ?,
        pilar3_2a = ?,
        pilar3_2b = ?,
        average_pil3_1 = ?,
        average_pil3_2 = ?,
        min_pil3_1 = ?,
        min_pil3_2 = ?,
        max_pil3_1 = ?,
        max_pil3_2 = ?,
        hasil_pil3_par1 = ?,
        hasil_pil3_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_2, $pilar3_2a, $pilar3_2b, $average_pil3_1, $average_pil3_2, $min_pil3_1, $min_pil3_2, $max_pil3_1, $max_pil3_2, $hasil_pil3_par1, $hasil_pil3_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_reputasi_lainnya SET 
        pilar4_1a = ?,
        pilar4_1b = ?,
        pilar4_1c = ?,
        average_pil4_1 = ?,
        min_pil4_1 = ?,
        max_pil4_1 = ?,
        hasil_pil4_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar4_1a, $pilar4_1b, $pilar4_1c, $average_pil4_1, $min_pil4_1, $max_pil4_1, $hasil_pil4_par1, $id]);

   




    simpro_db_query($conn, "UPDATE hasil_inheren_reputasi SET 
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
        hasil_inheren_tertinggi = ?,
        hasil_inheren_terendah = ?,
        hasil_inheren_rata_rata = ?,
        hasil_risiko_ditetapkan = ?,
        hasil_tingkat_risiko = ?,
        hasil_peringkat = ?
    WHERE id_profil_risiko = ?", [$pil1_tertinggi, $pil1_terendah, $pil1_rata_rata, $set_pil1, $pil1_tingkat_risiko, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $set_pil2, $pil2_tingkat_risiko, $max_pil3_1, $min_pil3_1, $average_pil3_1, $set_pil3, $pil3_tingkat_risiko, $max_pil4_1, $min_pil4_1, $average_pil4_1, $set_pil4_par1, $hasil_pil4_par1, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata, $set_tingkat_risiko, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

    //kalimat

    simpro_db_query($conn, "UPDATE ket_inheren_reputasi_pilar1 SET 
        ket_in_rep_pil1_1 = ?,
        ket_in_rep_pil1_1a = ?,
        ket_in_rep_pil1_1b = ?,
        ket_in_rep_pil1_1c = ?,
        ket_in_rep_pil1_1d = ?,
        ket_in_rep_pil1_2 = ?,
        ket_in_rep_pil1_2a = ?,
        ket_in_rep_pil1_2b = ?,
        ket_in_rep_pil1_2c = ?,
        ket_in_rep_pil1_2d = ?
    WHERE id_profil_risiko = ?", [$ket_in_rep_pil1_1, $ket_in_rep_pil1_1a, $ket_in_rep_pil1_1b, $ket_in_rep_pil1_1c, $ket_in_rep_pil1_1d, $ket_in_rep_pil1_2, $ket_in_rep_pil1_2a, $ket_in_rep_pil1_2b, $ket_in_rep_pil1_2c, $ket_in_rep_pil1_2d, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_reputasi_pilar2 SET 
        ket_in_rep_pil2_1 = ?,
        ket_in_rep_pil2_1a = ?,
        ket_in_rep_pil2_1b = ?,
        ket_in_rep_pil2_1c = ?,
        ket_in_rep_pil2_1d = ?,
        ket_in_rep_pil2_2 = ?,
        ket_in_rep_pil2_2a = ?,
        ket_in_rep_pil2_2b = ?
    WHERE id_profil_risiko = ?", [$ket_in_rep_pil2_1, $ket_in_rep_pil2_1a, $ket_in_rep_pil2_1b, $ket_in_rep_pil2_1c, $ket_in_rep_pil2_1d, $ket_in_rep_pil2_2, $ket_in_rep_pil2_2a, $ket_in_rep_pil2_2b, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_reputasi_pilar3 SET 
        ket_in_rep_pil3_1 = ?,
        ket_in_rep_pil3_1a = ?,
        ket_in_rep_pil3_1b = ?,
        ket_in_rep_pil3_1c = ?,
        ket_in_rep_pil3_2 = ?,
        ket_in_rep_pil3_2a = ?,
        ket_in_rep_pil3_2b = ?
    WHERE id_profil_risiko = ?", [$ket_in_rep_pil3_1, $ket_in_rep_pil3_1a, $ket_in_rep_pil3_1b, $ket_in_rep_pil3_1c, $ket_in_rep_pil3_2, $ket_in_rep_pil3_2a, $ket_in_rep_pil3_2b, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_reputasi_lainnya SET 
        ket_in_rep_pil4_1a = ?,
        ket_in_rep_pil4_1b = ?,
        ket_in_rep_pil4_1c = ?
    WHERE id_profil_risiko = ?", [$ket_in_rep_pil4_1a, $ket_in_rep_pil4_1b, $ket_in_rep_pil4_1c, $id]);



    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=rep_inhern1&id=$id");
    exit();
}
?>






<script>
        $(document).ready(function() {
            $('#ket_in_rep_pil1_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_2c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter7').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil1_2d').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter8').text(charCount);
            });
        });




        $(document).ready(function() {
            $('#ket_in_rep_pil2_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter9').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter10').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter11').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter12').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter13').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter14').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil2_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter15').text(charCount);
            });
        });




        $(document).ready(function() {
            $('#ket_in_rep_pil3_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter16').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil3_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter17').text(charCount);
            });
        });



        $(document).ready(function() {
            $('#ket_in_rep_pil4_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter18').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil4_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter19').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_rep_pil4_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter20').text(charCount);
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

                        <h4 class="page-title">Risiko reputasi Inheren 1 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 1 Profil Risiko reputasi</h4>

                            <hr>
                            </hr>


                        

           



                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-top mb-0" >
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="10">
                                                <h4>
                                                    <center><b>RISIKO REPUTASI INHEREN 1</b></center>
                                                </h4>
                                            </th>

                                        </tr>
                                        <tr style="color: #050505;">
                                            <th width="5%" rowspan="2">
                                                <center>NO</center>
                                            </th>
                                            <th class=" text-center" width="10%" rowspan="2">
                                                PARAMETER
                                            </th>

                                            <th class="text-center" width="50%" colspan="5">
                                                SKALA RISIKO
                                            </th>
                                            <th class="text-center" width="5%" rowspan="2">
                                                PENILAIAN
                                            </th>
                                            <th class="text-center" width="12%"rowspan="2">
                                                PENILAIAN PERIODE SEBELUMNYA
                                            </th>
                                            <th class="text-center" width="20%"  rowspan="2">
                                                KETERANGAN
                                            </th>
                                        </tr>
                                        <tr style="color: #050505;">
                                            
                                            <th class="text-center" width="10%">
                                                1
                                            </th>
                                            <th class="text-center" width="10%">
                                                2
                                            </th>
                                            <th class="text-center" width="10%">
                                                3
                                            </th>
                                            <th class="text-center" width="10%">
                                                4
                                            </th>
                                            <th class="text-center" width="10%">
                                                5
                                            </th>
                                           
                                        </tr>

                                    </thead>
                                    <tbody>
<!--pilar1-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 1 : Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat pemberitaan negatif mengenai BPR termasuk anggota Direksi dan Dewan Komisaris, pemegang saham, dan perusahaan terkait BPR, di media massa (cetak dan elektronik) dan media lainnya yang dapat diakses oleh masyarakat. , namun  skala pengaruhnya tidak material
                                            dan dapat dimitigasi dengan baik.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat pemberitaan negatif mengenai BPR termasuk anggota   Direksi dan    Dewan Komisaris, pemegang saham, dan perusahaan terkait BPR, di media massa
                                            (cetak dan elektronik) dan media lainnya yang dapat diakses oleh masyarakat, namun  skala pengaruhnya tidak material
                                            dan dapat dimitigasi dengan baik.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat pemberitaan negatif mengenai BPR termasuk anggota   Direksi dan    Dewan Komisaris, pemegang saham, dan perusahaan terkait  BPR, di media massa
                                            (cetak dan elektronik) dan media lainnya yang dapat diakses oleh masyarakat, dengan  skala pengaruh cukup material terhadap kinerja BPR namun masih dapat dikendalikan.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat pemberitaan negatif mengenai BPR termasuk anggota   Direksi dan    Dewan Komisaris, pemegang saham,      dan perusahaan terkait  BPR, di media     massa
                                            (cetak dan elektronik) dan media lainnya yang dapat diakses oleh masyarakat, dengan skala pengaruh  yang material terhadap kinerja BPR   dan memerlukan perhatian khusus.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat pemberitaan negatif mengenai BPR termasuk anggota   Direksi dan    Dewan Komisaris, pemegang saham,      dan perusahaan terkait  BPR, di media     massa
                                            (cetak dan elektronik) dan media lainnya yang dapat diakses oleh masyarakat, dengan    skala pengaruh   yang sangat  material terhadap kinerja BPR, sehingga memerlukan tindak   lanjut dengan segera.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1" form="my_form" name="pilar1_1">
                                                    <option <?= $pil1['pilar1_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_1" form="my_form" name="ket_in_rep_pil1_1" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length1['l1'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                            Pemberitaan Negatif Terhadap Perusahaan Terkait
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat pemberitaan negatif terhadap BPR dan atauatau perusahaan lain yang memiliki keterkaitan dengan Bank pada media massa dan media lainnya
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat pemberitaan negatif terhadap BPR dan atauatau perusahaan lain yang memiliki keterkaitan dengan Bank pada media massa dan media lainnya, namun pemberitaan tersebut tidak dapat diakses oleh seluruh lapisan masyarakat dan skala pengaruhnya tidak material dan dapat dimitigasi 
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat pemberitaan negatif terhadap BPR dan atauatau perusahaan lain yang memiliki keterkaitan dengan Bank pada media massa dan media lainnya, namun pemberitaan tersebut hanya dapat diakses oleh lapisan masyarakat tertentu dan skala pengaruhnya tidak material terhadap reputasi Bank
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat pemberitaan negatif terhadap BPR dan atauatau perusahaan lain yang memiliki keterkaitan dengan Bank pada media massa dan media lainnya, dan pemberitaan tersebut  dapat diakses oleh semua lapisan masyarakat tertentu dan memiliki skala pengaruh cukup material terhadap reputasi Bank.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat pemberitaan negatif terhadap BPR dan atau perusahaan lain yang memiliki keterkaitan dengan Bank pada media massa dan media lainnya, dan pemberitaan tersebut  dapat diakses oleh semua lapisan masyarakat tertentu dan memiliki skala pengaruh sangat material terhadap reputasi Bank.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1a" form="my_form" name="pilar1_1a">
                                                    <option <?= $pil1['pilar1_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_1a" form="my_form" name="ket_in_rep_pil1_1a" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1a'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length1['l2'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>







                                        

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat kejadian reputasi.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat kejadian reputasi dengan frekuensi yang rendah; namun tidak berpengaruh pada reputasi BPR.
                                            </td>
                                            <td>
                                            <b>(3)</b> • Terdapat kejadian reputasi dengan frekuensi yang rendah; dan </b>
                                            • berpengaruh cukup  material pada 
                                            reputasi BPR relatif terhadap ukuran  dan skala usaha BPR atau
                                            Terdapat kejadian reputasi dengan frekuensi cukup tinggi, namun tidak berpengaruh pada reputasi BPR.
                                            </td>
                                            <td>
                                            <b>(4)</b> </br>• Terdapat kejadian reputasi dengan frekuensi yang cukup tinggi; dan </b>
                                            • berpengaruh material pada </b>
                                            reputasi BPR relatif terhadap ukuran  dan skala usaha BPR. atau </b>
                                            • terdapat kejadian reputasi dengan frekuensi yang sangat tinggi; namun </b>
                                            • tidak seluruhnya berpengaruh material  pada reputasi   BPR relatif terhadap ukuran    dan skala usaha
                                            BPR.
                                            </td>
                                            <td>
                                            <b>(5)</b> </br>• Terdapat kejadian reputasi dengan frekuensi yang sangat tinggi; dan </br>
                                            • berpengaruh sangat material pada
                                            reputasi  BPR relatif terhadap ukuran   dan skala usaha BPR.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_2" form="my_form" name="pilar1_2">
                                                    <option <?= $pil1['pilar1_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_2'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_2" form="my_form" name="ket_in_rep_pil1_2" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length1['l4'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jenis Dan Variasi Pemberitaan
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat pemberitaan negatif melalui media massa
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat satu jenis pemberitaan negatif melalui media massa dan pemberitaan hanya dilakukan oleh satu media massa 
                                            Pemberitaan negatif oleh media massa tersebut hanya dapat diakses oleh kalangan tertentu dan tidak berpengaruh terhadap  reputasi Perusahaan
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat beberapa jenis pemberitaan negatif melalui media massa  dan pemberitaan dilakukan oleh beberapa media massa 
                                            Pemberitaan negatif oleh media massa tersebut  dapat diakses oleh semua kalangan namun tidak berpengaruh terhadap  reputasi Perusahaan
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat beberapa jenis pemberitaan negatif melalui media massa  dan pemberitaan dilakukan oleh beberapa media massa 
                                            Pemberitaan negatif oleh media massa tersebut  dapat diakses oleh semua kalangan namun tidak berpengaruh signifikan terhadap reputasi Perusahaan
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat beberapa jenis pemberitaan negatif melalui media massa  dan pemberitaan dilakukan oleh beberapa media massa
                                            Pemberitaan negatif oleh media massa tersebut  dapat diakses oleh semua kalangan dan berpengaruh signifikan terhadap  reputasi Perusahaan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_2a" form="my_form" name="pilar1_2a">
                                                    <option <?= $pil1['pilar1_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_2a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_2a" form="my_form" name="ket_in_rep_pil1_2a" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2a'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length1['l5'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jangkauan Dan Kredibilitas Media Massa
                                            </th>
                                            <td>
                                            <b>(1)</b> Jangkauan pemberitaan dari Media massa bersifat lokal dan Media massa yang memberitakan tidak memiliki kredibilitas yang baik 
                                            </td>
                                            <td>
                                            <b>(2)</b> Jangkauan pemberitaan dari Media massa bersifat lokal dan Media massa yang memberitakan  memiliki kredibilitas yang kurang baik 
                                            </td>
                                            <td>
                                            <b>(3)</b> Jangkauan pemberitaan dari Media massa bersifat regional  dan Media massa yang memberitakan  memiliki kredibilitas yang cukup baik 
                                            </td>
                                            <td>
                                            <b>(4)</b> Jangkauan pemberitaan dari Media massa bersifat regional  dan Media massa yang memberitakan  memiliki kredibilitas yang baik 
                                            </td>
                                            <td>
                                            <b>(5)</b> Jangkauan pemberitaan dari Media massa bersifat nasional  dan Media massa yang memberitakan  memiliki kredibilitas yang  baik 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_2b" form="my_form" name="pilar1_2b">
                                                    <option <?= $pil1['pilar1_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_2b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_2b" form="my_form" name="ket_in_rep_pil1_2b" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2b'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length1['l6'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jumlah Kejadian Terkait dengan Risiko Reputasi pada Periode Penilaian
                                            </th>
                                            <td>
                                            <b>(1)</b> < 3 (tiga) Kejadian pada Media Pemberitaan Lokal
                                            </td>
                                            <td>
                                            <b>(2)</b> 3 (tiga) Kejadian pada Media Pemberitaan Lokal
                                            </td>
                                            <td>
                                            <b>(3)</b> 5 (lima) Kejadian pada Media Pemberitaan Lokal
                                            </td>
                                            <td>
                                            <b>(4)</b> 6 (enam) Kejadian pada Media Pemberitaan Lokal
                                            </td>
                                            <td>
                                            <b>(5)</b> > 6 (enam) Kejadian pada Media Pemberitaan Lokal
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_2c" form="my_form" name="pilar1_2c">
                                                    <option <?= $pil1['pilar1_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_2c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_2c" form="my_form" name="ket_in_rep_pil1_2c" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2c'] ?></textarea>
                                            <span id="penghitung-karakter7"><?= $length1['l7'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jumlah Pemberitaan Negatif (Regional Jawa Tengah) pada Media Massa Cetak dan Elektronik  
                                            </th>
                                            <td>
                                            <b>(1)</b> < 2 (Dua) Pemberitaan
                                            </td>
                                            <td>
                                            <b>(2)</b> 2 (Dua) Pemberitaan
                                            </td>
                                            <td>
                                            <b>(3)</b> 4 (Empat) Pemberitaan hari Kerja Setelah Tanggal Pengaduan
                                            </td>
                                            <td>
                                            <b>(4)</b> 6 (Enam) Pemberitaan
                                            </td>
                                            <td>
                                            <b>(5)</b> > 6 (Enam) Pemberitaan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_2d" form="my_form" name="pilar1_2d">
                                                    <option <?= $pil1['pilar1_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_2d'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil1_2d" form="my_form" name="ket_in_rep_pil1_2d" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2d'] ?></textarea>
                                            <span id="penghitung-karakter8"><?= $length1['l8'] ?></span><span> / 500</span></td>
                                        </tr>


<!--pilar2-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 2 : Frekuensi Dan Signifikansi Pelanggaran</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Administrasi Dan Tindak Lanjut Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> </br>• Pengaduan nasabah diadministrasi kan dengan
                                            tertib  dan informatif (ada, lengkap, rutin); danatauatau
                                            </br>
                                            • Seluruh pengaduan telah diselesaikan

                                            </td>
                                            <td>
                                            <b>(2)</b> </br>• Pengaduan nasabah diadministrasi kan dengan cukup  tertib dan informatif (sebagian besar   ada, sebagian besar lengkap, sebagian besar rutin); dan atau
                                            </br>• Sebagian besar pengaduan telah diselesaikan.
                                            </td>
                                            <td>
                                            <b>(3)</b> </br>• Pengaduan nasabah diadministrasi kan dengan cukup  tertib dan informatif (sebagian besar   ada, sebagian besar lengkap, sebagian besar rutin); dan atau
                                            </br>• Sebagian kecil pengaduan telah diselesaikan.
                                            </td>
                                            <td>
                                            <b>(4)</b> </br>• Pengaduan nasabah diadministrasi kan   dengan kurang  tertib dan informatif (sebagian kecil ada, sebagian kecil  lengkap, sebagian  kecil rutin); dan atau
                                            </br>• Sebagian kecil pengaduan telah diselesaikan.
                                            </td>
                                            <td>
                                            <b>(5)</b> </br>• Tidak terdapat administrasi mengenai pengaduan nasabah danatauatau seluruhnya tidak diselesaikan.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1" form="my_form" name="pilar2_1">
                                                    <option <?= $pil2['pilar2_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_1" form="my_form" name="ket_in_rep_pil2_1" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1'] ?></textarea>
                                            <span id="penghitung-karakter9"><?= $length2['l9'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Metode Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Nasabah menyampaikan pengaduan langsung kepada Bank dan dapat segera diberikan pemahaman dan upaya penyelesaian
                                            </td>
                                            <td>
                                            <b>(2)</b> Nasabah menyampaikan pengaduan melalui media massa yang dapat diakses oleh masyarakat, namun dapat segera diselesaikan dengan peberian jawaban danatauatau informasi menggunakan metode dan media yang sama
                                            </td>
                                            <td>
                                            <b>(3)</b> Nasabah menyampaikan pengaduan melalui media massa yang dapat diakses oleh masyarakat, namun dapat segera diselesaikan dengan peberian jawaban danatauatau informasi menggunakan metode dan media yang sama
                                            </td>
                                            <td>
                                            <b>(4)</b> Nasabah menyampaikan pengaduan melalui kuasa kepada pihak ketiga (LSMatauLBH) , namun pihak yang diberi kuasa masih dapat diajak berkomunikasi dengan baik untuk menyelesaian aduan.
                                            </td>
                                            <td>
                                            <b>(5)</b> Nasabah menyampaikan pengaduan melalui kuasa kepada pihak ketiga (LSMatauLBH) , namun pihak yang diberi kuasa tidak dapat diajak berkomunikasi dengan baik untuk menyelesaian aduan, sehingga dampak terhadap reputasi Bank cukup tinggi.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1a" form="my_form" name="pilar2_1a">
                                                    <option <?= $pil2['pilar2_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_1a" form="my_form" name="ket_in_rep_pil2_1a" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1a'] ?></textarea>
                                            <span id="penghitung-karakter10"><?= $length2['l10'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Hasil Analisa Informasi pada Media atau Jejaring Sosial 
                                            </th>
                                            <td>
                                            <b>(1)</b> < 3 (Tiga) bulan Dilakukan Analisa
                                            </td>
                                            <td>
                                            <b>(2)</b> 3 (Tiga) bulan Dilakukan Analisa
                                            </td>
                                            <td>
                                            <b>(3)</b> 6 (Enam) bulan Dilakukan Analisa
                                            </td>
                                            <td>
                                            <b>(4)</b> > 6 (enam) bulan Dilakukan Analisa
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Dilakukan Analisa
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1b" form="my_form" name="pilar2_1b">
                                                    <option <?= $pil2['pilar2_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_1b" form="my_form" name="ket_in_rep_pil2_1b" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1b'] ?></textarea>
                                            <span id="penghitung-karakter11"><?= $length2['l11'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Informasi dari Lembaga Perlindungan Konsumen dan Konsumen
                                            </th>
                                            <td>
                                            <b>(1)</b> < 10 (Sepuluh) Informasi
                                            </td>
                                            <td>
                                            <b>(2)</b> 10 (Sepuluh) Informasi
                                            </td>
                                            <td>
                                            <b>(3)</b> 15 (Limabelas) Informasi
                                            </td>
                                            <td>
                                            <b>(4)</b> 20 (Dua Puluh) Informasi
                                            </td>
                                            <td>
                                            <b>(5)</b> > 25 (Dua Puluh) Informasi
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1c" form="my_form" name="pilar2_1c">
                                                    <option <?= $pil2['pilar2_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_1c" form="my_form" name="ket_in_rep_pil2_1c" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1c'] ?></textarea>
                                            <span id="penghitung-karakter12"><?= $length2['l12'] ?></span><span> / 500</span></td>
                                        </tr>



                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Signifikansi Dan Materialitas Pengaduan nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Frekuensi pengaduan nasabah sangat minimal  dan sangat tidak material.
                                            </td>
                                            <td>
                                            <b>(2)</b> Frekuensi pengaduan nasabah minimal dan tidak material.
                                            </td>
                                            <td>
                                            <b>(3)</b> Frekuensi pengaduan nasabah cukup tinggi dan cukup material.
                                            </td>
                                            <td>
                                            <b>(4)</b> Frekuensi pengaduan nasabah tinggi dan material.
                                            </td>
                                            <td>
                                            <b>(5)</b> Frekuensi pengaduan nasabah  sangat tinggi   serta sangat material danatauatau disebabkan Penyimpangan ketentuan perbankan.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_2" form="my_form" name="pilar2_2">
                                                    <option <?= $pil2['pilar2_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_2'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_2" form="my_form" name="ket_in_rep_pil2_2" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2'] ?></textarea>
                                            <span id="penghitung-karakter13"><?= $length2['l13'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jenis Aduan Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Jenis  pengaduan nasabah minimal  dan sangat tidak material.
                                            </td>
                                            <td>
                                            <b>(2)</b> Jenis  pengaduan nasabah lebih dari 1 jenis, namun masing - masing jenis pengaduan tidak material.
                                            </td>
                                            <td>
                                            <b>(3)</b> Pengaduan nasabah terdiri dari beberapa jenis dan diantaranya terdapat jenis pengaduan yang material.
                                            </td>
                                            <td>
                                            <b>(4)</b> Pengaduan nasabah terdiri banyak jenis dan diantaranya terdapat jenis pengaduan yang material.
                                            </td>
                                            <td>
                                            <b>(5)</b> Pengaduan nasabah terdiri banyak jenis dan material.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_2a" form="my_form" name="pilar2_2a">
                                                    <option <?= $pil2['pilar2_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_2a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_2a" form="my_form" name="ket_in_rep_pil2_2a" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2a'] ?></textarea>
                                            <span id="penghitung-karakter14"><?= $length2['l14'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Jumlah Pengaduan Nasabah yang Dapat Diselesaikan 
                                            </th>
                                            <td>
                                            <b>(1)</b> Seluruh Pengaduan Dapat Diselesaikan 
                                            </td>
                                            <td>
                                            <b>(2)</b> < 10% Pengaduan Belum Dapat Diselesaikan
                                            </td>
                                            <td>
                                            <b>(3)</b> 10% Pengaduan Belum Dapat Diselesaikan
                                            </td>
                                            <td>
                                            <b>(4)</b> 15% Pengaduan Belum Dapat Diselesaikan
                                            </td>
                                            <td>
                                            <b>(5)</b> > 15% Pengaduan Belum Dapat Diselesaikan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_2b" form="my_form" name="pilar2_2b">
                                                    <option <?= $pil2['pilar2_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_2b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil2_2b" form="my_form" name="ket_in_rep_pil2_2b" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2b'] ?></textarea>
                                            <span id="penghitung-karakter15"><?= $length2['l15'] ?></span><span> / 500</span></td>
                                        </tr>

                                        
<!--pilar 3-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 3 : Pelanggaran Etika Bisnis</b>
                                                </h4>
                                            </td>
                                        </tr>








                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kegiatan Pemasaran
                                            </th>
                                            <td>
                                            <b>(1)</b> Dalam melakukan kegiatan pemasaran, Bank menyampaikan penjelasan keunggulan produk dan layanan Bank serta potensi risikonya  dengan cara - cara yang sehat 
                                            </td>
                                            <td>
                                            <b>(2)</b> Dalam melakukan kegiatan pemasaran, Bank menyampaikan produk dan layanan Bank dengan memberikan menjelaskan keunggulan  produk dan layanan dengan cara - cara yang sehat
                                            </td>
                                            <td>
                                            <b>(3)</b> Dalam melakukan kegiatan pemasaran, Bank menyampaikan produk dan layanan Bank dengan memberikan menjelaskan keunggulan  produk dan layanan dimaksud dengan membandingkan produk dan layanan Bank pesaing 
                                            </td>
                                            <td>
                                            <b>(4)</b> Dalam melakukan kegiatan pemasaran, Bank menyampaikan produk dan layanan Bank dengan memberikan menjelaskan keunggulan  produk dan layanan dimaksud dengan menyampaikan informasi bahwa produk dan layanan Bank pesaing lebih buruk 
                                            </td>
                                            <td>
                                            <b>(5)</b> Dalam melakukan kegiatan pemasaran, Bank menyampaikan produk dan layanan Bank dengan memberikan menjelaskan keunggulan  produk dan layanan dimaksud dengan menyampaikan informasi bahwa produk dan layanan Bank pesaing lebih buruk serta menjelek- jelekkan kredibilitas bank pesaing
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2a" form="my_form" name="pilar3_2a">
                                                    <option <?= $pil3['pilar3_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil3_2a" form="my_form" name="ket_in_rep_pil3_2a" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_2a'] ?></textarea>
                                            <span id="penghitung-karakter16"><?= $length3['l16'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Transparansi Fasilitas Produk Dan Layanan
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memberikan penjelasan secara detail dan transparan apabila nasabah akan mengakhiri penggunaan fasilitas produk dan layanan yang disediakan Bank dengan membuka layanan informasi terhadap keluhan nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memberikan penjelasan secara detail dan transparan apabila nasabah akan mengakhiri penggunaan fasilitas produk dan layanan yang disediakan Bank 
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memberikan penjelasan apabila nasabah akan mengakhiri penggunaan fasilitas produk dan layanan yang disediakan Bank secara jelas
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank kurang memberikan penjelasan apabila nasabah akan mengakhiri penggunaan fasilitas produk dan layanan yang disediakan Bank 
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak memberikan penjelasan apabila nasabah akan mengakhiri penggunaan fasilitas produk dan layanan yang disediakan Bank 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2b" form="my_form" name="pilar3_2b">
                                                    <option <?= $pil3['pilar3_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil3_2b" form="my_form" name="ket_in_rep_pil3_2b" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_2b'] ?></textarea>
                                            <span id="penghitung-karakter17"><?= $length3['l17'] ?></span><span> / 500</span></td>
                                        </tr>




                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>LAINNYA</b>
                                                </h4>
                                            </td>
                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Laporan Pemeriksaan SKAI
                                            </th>
                                            <td>
                                            <b>(1)</b> < 5% dari Hasil Laporan Pemeriksaan SKAI Terdapat Temuan Eksposur Risiko Reputasi
                                            </td>
                                            <td>
                                            <b>(2)</b> 5% dari Hasil Laporan Pemeriksaan SKAI Terdapat Temuan Eksposur Risiko Reputasi
                                            </td>
                                            <td>
                                            <b>(3)</b> 7,5% dari Hasil Laporan Pemeriksaan SKAI Terdapat Temuan Eksposur Risiko Reputasi
                                            </td>
                                            <td>
                                            <b>(4)</b> 10% dari Hasil Laporan Pemeriksaan SKAI Terdapat Temuan Eksposur Risiko Reputasi
                                            </td>
                                            <td>
                                            <b>(5)</b> > 10% dari Hasil Laporan Pemeriksaan SKAI Terdapat Temuan Eksposur Risiko Reputasi
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar4_1a" form="my_form" name="pilar4_1a">
                                                    <option <?= $pil4['pilar4_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil4_1a" form="my_form" name="ket_in_rep_pil4_1a" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1a'] ?></textarea>
                                            <span id="penghitung-karakter18"><?= $length4['l18'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Laporan Hasil Monitoring Satuan Kerja Kepatuhan
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat < 10 (Sepuluh) Kejadian Eksposure Risiko Reputasi pada Hasil Monitoring Satuan Kerja Kepatuhan
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat 10 (Sepuluh) Kejadian Eksposure Risiko Reputasi pada Hasil Monitoring Satuan Kerja Kepatuhan
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat 15 (Limabelas) Kejadian Eksposure Risiko Reputasi pada Hasil Monitoring Satuan Kerja Kepatuhan
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat 20 (Duapuluh) Kejadian Eksposure Risiko Reputasi pada Hasil Monitoring Satuan Kerja Kepatuhan
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat > 20 (Duapuluh) Kejadian Eksposure Risiko Reputasi pada Hasil Monitoring Satuan Kerja Kepatuhan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar4_1b" form="my_form" name="pilar4_1b">
                                                    <option <?= $pil4['pilar4_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil4_1b" form="my_form" name="ket_in_rep_pil4_1b" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1b'] ?></textarea>
                                            <span id="penghitung-karakter19"><?= $length4['l19'] ?></span><span> / 500</span></td>
                                        </tr>
                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pemberitaan Positif Tentang Kinerja dan Kegiatan Bank  
                                            </th>
                                            <td>
                                            <b>(1)</b> > 10 (Sepuluh) Pemberitaan 
                                            </td>
                                            <td>
                                            <b>(2)</b> 10 (Sepuluh) Pemberitaan 
                                            </td>
                                            <td>
                                            <b>(3)</b> 8 (Delapan) Pemberitaan
                                            </td>
                                            <td>
                                            <b>(4)</b> 5 (Lima) Pemberitaan
                                            </td>
                                            <td>
                                            <b>(5)</b> < 5 (Lima) Pemberitaan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar4_1c" form="my_form" name="pilar4_1c">
                                                    <option <?= $pil4['pilar4_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil4['pilar4_1c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_rep_pil4_1c" form="my_form" name="ket_in_rep_pil4_1c" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1c'] ?></textarea>
                                            <span id="penghitung-karakter20"><?= $length4['l20'] ?></span><span> / 500</span></td>
                                        </tr>



                                    </tbody>


                                </table>
                            </div> <!-- end table-responsive-->



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