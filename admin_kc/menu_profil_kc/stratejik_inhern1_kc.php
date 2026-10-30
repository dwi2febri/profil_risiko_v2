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
CHAR_LENGTH(ket_in_stra_pil1_1) AS l1,
CHAR_LENGTH(ket_in_stra_pil1_1a) AS l2,
CHAR_LENGTH(ket_in_stra_pil1_1b) AS l3,
CHAR_LENGTH(ket_in_stra_pil1_1c) AS l4,
CHAR_LENGTH(ket_in_stra_pil1_1d) AS l5,
CHAR_LENGTH(ket_in_stra_pil1_1e) AS l6,
CHAR_LENGTH(ket_in_stra_pil1_1f) AS l7 FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko = ?", [$id]));

$length2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_stra_pil2_1) AS l8,
CHAR_LENGTH(ket_in_stra_pil2_1a) AS l9,
CHAR_LENGTH(ket_in_stra_pil2_1c) AS l10,
CHAR_LENGTH(ket_in_stra_pil2_1d) AS l11,
CHAR_LENGTH(ket_in_stra_pil2_1e) AS l12,
CHAR_LENGTH(ket_in_stra_pil2_1f) AS l13,
CHAR_LENGTH(ket_in_stra_pil2_1g) AS l14,
CHAR_LENGTH(ket_in_stra_pil2_1h) AS l15,
CHAR_LENGTH(ket_in_stra_pil2_2) AS l16,
CHAR_LENGTH(ket_in_stra_pil2_2a) AS l17,
CHAR_LENGTH(ket_in_stra_pil2_2b) AS l18 FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko = ?", [$id]));

$length3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_stra_pil3_1) AS l19,
CHAR_LENGTH(ket_in_stra_pil3_1a) AS l20,
CHAR_LENGTH(ket_in_stra_pil3_1b) AS l21,
CHAR_LENGTH(ket_in_stra_pil3_1c) AS l22,
CHAR_LENGTH(ket_in_stra_pil3_1d) AS l23,
CHAR_LENGTH(ket_in_stra_pil3_1e) AS l24,
CHAR_LENGTH(ket_in_stra_pil3_1f) AS l25,
CHAR_LENGTH(ket_in_stra_pil3_1g) AS l26,
CHAR_LENGTH(ket_in_stra_pil3_1h) AS l27,
CHAR_LENGTH(ket_in_stra_pil3_1i) AS l28,
CHAR_LENGTH(ket_in_stra_pil3_1j) AS l29,
CHAR_LENGTH(ket_in_stra_pil3_1k) AS l30,
CHAR_LENGTH(ket_in_stra_pil3_1l) AS l31,
CHAR_LENGTH(ket_in_stra_pil3_1m) AS l32,
CHAR_LENGTH(ket_in_stra_pil3_1n) AS l33,
CHAR_LENGTH(ket_in_stra_pil3_1o) AS l34,
CHAR_LENGTH(ket_in_stra_pil3_1p) AS l35,
CHAR_LENGTH(ket_in_stra_pil3_2) AS l36,
CHAR_LENGTH(ket_in_stra_pil3_2a) AS l37,
CHAR_LENGTH(ket_in_stra_pil3_2b) AS l38,
CHAR_LENGTH(ket_in_stra_pil3_2c) AS l39,
CHAR_LENGTH(ket_in_stra_pil3_2d) AS l40,
CHAR_LENGTH(ket_in_stra_pil3_2f) AS l41 FROM ket_inheren_stratejik_pilar3 WHERE id_profil_risiko = ?", [$id]));

$length4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_stra_pil4_1a) AS l42,
CHAR_LENGTH(ket_in_stra_pil4_1c) AS l43 FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko = ?", [$id]));

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = ?", [$dp]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_stratejik WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko = ?", [$id]));
$ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko = ?", [$id]));
$ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar3 WHERE id_profil_risiko = ?", [$id]));
$ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko = ?", [$id]));

//setingan ditetapkan
$set_pil1_par1 = $inheren['inheren_stra_set_pil1_par1'];
$set_pil2_par1 = $inheren['inheren_stra_set_pil2_par1'];
$set_pil2_par2 = $inheren['inheren_stra_set_pil2_par2'];
$set_pil2 = $inheren['inheren_stra_set_pil2'];
$set_pil3_par1 = $inheren['inheren_stra_set_pil3_par1'];
$set_pil3_par2 = $inheren['inheren_stra_set_pil3_par2'];
$set_pil3 = $inheren['inheren_stra_set_pil3'];
$set_pil4_par1 = $inheren['inheren_stra_set_pil4_par1'];
$set_tingkat_risiko = $inheren['inheren_stra_set_tingkat_risiko'];


if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

        //pilar 1
        $pilar1_1 = $_POST['pilar1_1'];
        $pilar1_1a = $_POST['pilar1_1a'];
        $pilar1_1b = $_POST['pilar1_1b'];
        $pilar1_1c = $_POST['pilar1_1c'];
        $pilar1_1d = $_POST['pilar1_1d'];
        $pilar1_1e = $_POST['pilar1_1e'];
        $pilar1_1f = $_POST['pilar1_1f'];
        

        //pilar 1 1
        $hsl_max_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pilar1_1f);
        $max_pil1_1 = max($hsl_max_pil1_1);
    
        $hsl_min_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pilar1_1f);
        $min_pil1_1 = min($hsl_min_pil1_1);
    
        $hsl_avg_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pilar1_1f);
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



        
       



        $ket_in_stra_pil1_1 = $_POST['ket_in_stra_pil1_1'];
        $ket_in_stra_pil1_1a = $_POST['ket_in_stra_pil1_1a'];
        $ket_in_stra_pil1_1b = $_POST['ket_in_stra_pil1_1b'];
        $ket_in_stra_pil1_1c = $_POST['ket_in_stra_pil1_1c'];
        $ket_in_stra_pil1_1d = $_POST['ket_in_stra_pil1_1d'];
        $ket_in_stra_pil1_1e = $_POST['ket_in_stra_pil1_1e'];
        $ket_in_stra_pil1_1f = $_POST['ket_in_stra_pil1_1f'];





        //pilar 2
        $pilar2_1 = $_POST['pilar2_1'];
        $pilar2_1a = $_POST['pilar2_1a'];
        $pilar2_1b = $_POST['pilar2_1b'];
        $pilar2_1c = $_POST['pilar2_1c'];
        $pilar2_1d = $_POST['pilar2_1d'];
        $pilar2_1e = $_POST['pilar2_1e'];
        $pilar2_1f = $_POST['pilar2_1f'];
        $pilar2_1g = $_POST['pilar2_1g'];
        $pilar2_1h = $_POST['pilar2_1h'];
        $pilar2_1i = $_POST['pilar2_1i'];

        $pilar2_2 = $_POST['pilar2_2'];
        $pilar2_2a = $_POST['pilar2_2a'];
        $pilar2_2b = $_POST['pilar2_2b'];
        $pilar2_2c = $_POST['pilar2_2c'];
        


        //pilar 2 1
        $hsl_max_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h);
        $max_pil2_1 = max($hsl_max_pil2_1);
    
        $hsl_min_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h);
        $min_pil2_1 = min($hsl_min_pil2_1);
    
        $hsl_avg_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h);
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





        $ket_in_stra_pil2_1 = $_POST['ket_in_stra_pil2_1'];
        $ket_in_stra_pil2_1a = $_POST['ket_in_stra_pil2_1a'];
        $ket_in_stra_pil2_1b = $_POST['ket_in_stra_pil2_1b'];
        $ket_in_stra_pil2_1c = $_POST['ket_in_stra_pil2_1c'];
        $ket_in_stra_pil2_1d = $_POST['ket_in_stra_pil2_1d'];
        $ket_in_stra_pil2_1f = $_POST['ket_in_stra_pil2_1f'];
        $ket_in_stra_pil2_1d = $_POST['ket_in_stra_pil2_1d'];
        $ket_in_stra_pil2_1e = $_POST['ket_in_stra_pil2_1e'];
        $ket_in_stra_pil2_1f = $_POST['ket_in_stra_pil2_1f'];
        $ket_in_stra_pil2_1g = $_POST['ket_in_stra_pil2_1g'];
        $ket_in_stra_pil2_1h = $_POST['ket_in_stra_pil2_1h'];
        $ket_in_stra_pil2_1i = $_POST['ket_in_stra_pil2_1i'];
        
        $ket_in_stra_pil2_2 = $_POST['ket_in_stra_pil2_2'];
        $ket_in_stra_pil2_2a = $_POST['ket_in_stra_pil2_2a'];
        $ket_in_stra_pil2_2b = $_POST['ket_in_stra_pil2_2b'];
        $ket_in_stra_pil2_2c = $_POST['ket_in_stra_pil2_2c'];



        //pilar 3
        $pilar3_1 = $_POST['pilar3_1'];
        $pilar3_1a = $_POST['pilar3_1a'];
        $pilar3_1b = $_POST['pilar3_1b'];
        $pilar3_1c = $_POST['pilar3_1c'];
        $pilar3_1d = $_POST['pilar3_1d'];
        $pilar3_1e = $_POST['pilar3_1e'];
        $pilar3_1f = $_POST['pilar3_1f'];
        $pilar3_1g = $_POST['pilar3_1g'];
        $pilar3_1h = $_POST['pilar3_1h'];
        $pilar3_1i = $_POST['pilar3_1i'];
        $pilar3_1j = $_POST['pilar3_1j'];
        $pilar3_1k = $_POST['pilar3_1k'];
        $pilar3_1l = $_POST['pilar3_1l'];
        $pilar3_1m = $_POST['pilar3_1m'];
        $pilar3_1n = $_POST['pilar3_1n'];
        $pilar3_1o = $_POST['pilar3_1o'];
        $pilar3_1p = $_POST['pilar3_1p'];

        $pilar3_2 = $_POST['pilar3_2'];
        $pilar3_2a = $_POST['pilar3_2a'];
        $pilar3_2b = $_POST['pilar3_2b'];
        $pilar3_2c = $_POST['pilar3_2c'];
        $pilar3_2d = $_POST['pilar3_2d'];
        $pilar3_2e = $_POST['pilar3_2e'];
        $pilar3_2f = $_POST['pilar3_2f'];
       

        //pilar 3 1
        $hsl_max_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
        $max_pil3_1 = max($hsl_max_pil3_1);
    
        $hsl_min_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
        $min_pil3_1 = min($hsl_min_pil3_1);
    
        $hsl_avg_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
        $sum_pil3_1 = array_sum($hsl_avg_pil3_1);
        $average_pil3_1 = $sum_pil3_1 / count($hsl_avg_pil3_1);

        if ($set_pil3_par1 == 1) {

            $hasil_pil3_par1 = $max_pil3_1;
        } else if ($set_pil3_par1 == 2) {
    
            $hasil_pil3_par1 = $min_pil3_1;
        } else if ($set_pil3_par1 == 3) {
    
            $hasil_pil3_par1 = $average_pil3_1;
        } else {
        $hasil_pil3_par1 = 0;
        }


        
        $hsl_max_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b, $pilar3_2c, $pilar3_2d, $pilar3_2f);
        $max_pil3_2 = max($hsl_max_pil3_2);
    
        $hsl_min_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b, $pilar3_2c, $pilar3_2d, $pilar3_2f);
        $min_pil3_2 = min($hsl_min_pil3_2);
    
        $hsl_avg_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b, $pilar3_2c, $pilar3_2d, $pilar3_2f);
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
$hsl_max_pilar3 = array($hasil_pil3_par1, $hasil_pil3_par2);
$pil3_tertinggi = max($hsl_max_pilar3);

$hsl_min_pilar3 = array($hasil_pil3_par1, $hasil_pil3_par2);
$pil3_terendah = min($hsl_min_pilar3);

$hsl_avg_pilar3 = array($hasil_pil3_par1, $hasil_pil3_par2);
$sum_pil3 = array_sum($hsl_avg_pilar3);
$pil3_rata_rata = $sum_pil3 / count($hsl_avg_pilar3);

if ($set_pil3 == 1) {

    $pil3_tingkat_risiko = $pil3_tertinggi;

} else if ($set_pil3 == 2) {

    $pil3_tingkat_risiko = $pil3_terendah;
} else if ($set_pil3 == 3) {

    $pil3_tingkat_risiko = $pil3_rata_rata;
} else {
$pil3_tingkat_risiko = 0;
}





        $ket_in_stra_pil3_1 = $_POST['ket_in_stra_pil3_1'];
        $ket_in_stra_pil3_1a = $_POST['ket_in_stra_pil3_1a'];
        $ket_in_stra_pil3_1b = $_POST['ket_in_stra_pil3_1b'];
        $ket_in_stra_pil3_1c = $_POST['ket_in_stra_pil3_1c'];
        $ket_in_stra_pil3_1d = $_POST['ket_in_stra_pil3_1d'];
        $ket_in_stra_pil3_1e = $_POST['ket_in_stra_pil3_1e'];
        $ket_in_stra_pil3_1f = $_POST['ket_in_stra_pil3_1f'];
        $ket_in_stra_pil3_1g = $_POST['ket_in_stra_pil3_1g'];
        $ket_in_stra_pil3_1h = $_POST['ket_in_stra_pil3_1h'];
        $ket_in_stra_pil3_1i = $_POST['ket_in_stra_pil3_1i'];
        $ket_in_stra_pil3_1j = $_POST['ket_in_stra_pil3_1j'];
        $ket_in_stra_pil3_1k = $_POST['ket_in_stra_pil3_1k'];
        $ket_in_stra_pil3_1l = $_POST['ket_in_stra_pil3_1l'];
        $ket_in_stra_pil3_1m = $_POST['ket_in_stra_pil3_1m'];
        $ket_in_stra_pil3_1n = $_POST['ket_in_stra_pil3_1n'];
        $ket_in_stra_pil3_1o = $_POST['ket_in_stra_pil3_1o'];
        $ket_in_stra_pil3_1p = $_POST['ket_in_stra_pil3_1p'];
        

        
        $ket_in_stra_pil3_2 = $_POST['ket_in_stra_pil3_2'];
        $ket_in_stra_pil3_2a = $_POST['ket_in_stra_pil3_2a'];
        $ket_in_stra_pil3_2b = $_POST['ket_in_stra_pil3_2b'];
        $ket_in_stra_pil3_2c = $_POST['ket_in_stra_pil3_2c'];
        $ket_in_stra_pil3_2d = $_POST['ket_in_stra_pil3_2d'];
        $ket_in_stra_pil3_2e = $_POST['ket_in_stra_pil3_2e'];
        $ket_in_stra_pil3_2f = $_POST['ket_in_stra_pil3_2f'];



        //pilar 4
        $pilar4_1a = $_POST['pilar4_1a'];
        $pilar4_1b = $_POST['pilar4_1b'];
        $pilar4_1c = $_POST['pilar4_1c'];
        $pilar4_1d = $_POST['pilar4_1d'];
       
        $ket_in_stra_pil4_1a = $_POST['ket_in_stra_pil4_1a'];
        $ket_in_stra_pil4_1b = $_POST['ket_in_stra_pil4_1b'];
        $ket_in_stra_pil4_1c = $_POST['ket_in_stra_pil4_1c'];
        $ket_in_stra_pil4_1d = $_POST['ket_in_stra_pil4_1d'];

        //pilar 4 1
        $hsl_max_pil4_1 = array($pilar4_1a, $pilar4_1c);
        $max_pil4_1 = max($hsl_max_pil4_1);
    
        $hsl_min_pil4_1 = array($pilar4_1a, $pilar4_1c);
        $min_pil4_1 = min($hsl_min_pil4_1);
    
        $hsl_avg_pil4_1 = array($pilar4_1a, $pilar4_1c);
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




      



        //HASIL INHEREN
        $hsl_max_inheren= array($hasil_pil1_par1, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
        $hasil_inheren_tertinggi = max($hsl_max_inheren);
    
        $hsl_min_inheren = array($hasil_pil1_par1, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
        $hasil_inheren_terendah = min($hsl_min_inheren);
    
        $hsl_avg_inheren = array($hasil_pil1_par1, $pil2_tingkat_risiko, $pil3_tingkat_risiko, $hasil_pil4_par1);
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



    simpro_db_query($conn, "UPDATE inheren_stratejik_pilar1 SET 
        pilar1_1 = ?,
        pilar1_1a = ?,
        pilar1_1b = ?,
        pilar1_1c = ?,
        pilar1_1d = ?,
        pilar1_1e = ?,
        pilar1_1f = ?,
        average_pil1_1 = ?,
        min_pil1_1 = ?,
        max_pil1_1 = ?,
        hasil_pil1_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pilar1_1f, $average_pil1_1, $min_pil1_1, $max_pil1_1, $hasil_pil1_par1, $id]);

    simpro_db_query($conn, "UPDATE inheren_stratejik_pilar2 SET 
        pilar2_1 = ?,
        pilar2_1a = ?,
        pilar2_1b = ?,
        pilar2_1c = ?,
        pilar2_1d = ?,
        pilar2_1e = ?,
        pilar2_1f = ?,
        pilar2_1g = ?,
        pilar2_1h = ?,
        pilar2_1i = ?,
        pilar2_2 = ?,
        pilar2_2a = ?,
        pilar2_2b = ?,
        pilar2_2c = ?,
        average_pil2_1 = ?,
        average_pil2_2 = ?,
        min_pil2_1 = ?,
        min_pil2_2 = ?,
        max_pil2_1 = ?,
        max_pil2_2 = ?,
        hasil_pil2_par1 = ?,
        hasil_pil2_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h, $pilar2_1i, $pilar2_2, $pilar2_2a, $pilar2_2b, $pilar2_2c, $average_pil2_1, $average_pil2_2, $min_pil2_1, $min_pil2_2, $max_pil2_1, $max_pil2_2, $hasil_pil2_par1, $hasil_pil2_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_stratejik_pilar3 SET 
        pilar3_1 = ?,
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
        pilar3_1k = ?,
        pilar3_1l = ?,
        pilar3_1m = ?,
        pilar3_1n = ?,
        pilar3_1o = ?,
        pilar3_1p = ?,
        pilar3_2 = ?,
        pilar3_2a = ?,
        pilar3_2b = ?,
        pilar3_2c = ?,
        pilar3_2d = ?,
        pilar3_2e = ?,
        pilar3_2f = ?,
        average_pil3_1 = ?,
        average_pil3_2 = ?,
        min_pil3_1 = ?,
        min_pil3_2 = ?,
        max_pil3_1 = ?,
        max_pil3_2 = ?,
        hasil_pil3_par1 = ?,
         hasil_pil3_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p, $pilar3_2, $pilar3_2a, $pilar3_2b, $pilar3_2c, $pilar3_2d, $pilar3_2e, $pilar3_2f, $average_pil3_1, $average_pil3_2, $min_pil3_1, $min_pil3_2, $max_pil3_1, $max_pil3_2, $hasil_pil3_par1, $hasil_pil3_par2, $id]);


    simpro_db_query($conn, "UPDATE inheren_stratejik_lainnya SET
        pilar4_1a = ?,
        pilar4_1b = ?,
        pilar4_1c = ?,
        pilar4_1d = ?,
        average_pil4_1 = ?,
        min_pil4_1 = ?,
        max_pil4_1 = ?,
        hasil_pil4_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d, $average_pil4_1, $min_pil4_1, $max_pil4_1, $hasil_pil4_par1, $id]);

   




    simpro_db_query($conn, "UPDATE hasil_inheren_stratejik SET 
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
    WHERE id_profil_risiko = ?", [$max_pil1_1, $min_pil1_1, $average_pil1_1, $set_pil1_par1, $hasil_pil1_par1, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $set_pil2, $pil2_tingkat_risiko, $pil3_tertinggi, $pil3_terendah, $pil3_rata_rata, $set_pil3, $pil3_tingkat_risiko, $max_pil4_1, $min_pil4_1, $average_pil4_1, $set_pil4_par1, $hasil_pil4_par1, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata, $set_tingkat_risiko, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

    //kalimat

    simpro_db_query($conn, "UPDATE ket_inheren_stratejik_pilar1 SET 
        ket_in_stra_pil1_1 = ?,
        ket_in_stra_pil1_1a = ?,
        ket_in_stra_pil1_1b = ?,
        ket_in_stra_pil1_1c = ?,
        ket_in_stra_pil1_1d = ?,
        ket_in_stra_pil1_1e = ?,
        ket_in_stra_pil1_1f = ?
    WHERE id_profil_risiko = ?", [$ket_in_stra_pil1_1, $ket_in_stra_pil1_1a, $ket_in_stra_pil1_1b, $ket_in_stra_pil1_1c, $ket_in_stra_pil1_1d, $ket_in_stra_pil1_1e, $ket_in_stra_pil1_1f, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_stratejik_pilar2 SET 
        ket_in_stra_pil2_1 = ?,
        ket_in_stra_pil2_1a = ?,
        ket_in_stra_pil2_1b = ?,
        ket_in_stra_pil2_1c = ?,
        ket_in_stra_pil2_1d = ?,
        ket_in_stra_pil2_1e = ?,
        ket_in_stra_pil2_1f = ?,
        ket_in_stra_pil2_1g = ?,
        ket_in_stra_pil2_1h = ?,
        ket_in_stra_pil2_1i = ?,
        ket_in_stra_pil2_2 = ?,
        ket_in_stra_pil2_2a = ?,
        ket_in_stra_pil2_2b = ?,
        ket_in_stra_pil2_2c = ?
    WHERE id_profil_risiko = ?", [$ket_in_stra_pil2_1, $ket_in_stra_pil2_1a, $ket_in_stra_pil2_1b, $ket_in_stra_pil2_1c, $ket_in_stra_pil2_1d, $ket_in_stra_pil2_1e, $ket_in_stra_pil2_1f, $ket_in_stra_pil2_1g, $ket_in_stra_pil2_1h, $ket_in_stra_pil2_1i, $ket_in_stra_pil2_2, $ket_in_stra_pil2_2a, $ket_in_stra_pil2_2b, $ket_in_stra_pil2_2c, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_stratejik_pilar3 SET 
        ket_in_stra_pil3_1 = ?,
        ket_in_stra_pil3_1a = ?,
        ket_in_stra_pil3_1b = ?,
        ket_in_stra_pil3_1c = ?,
        ket_in_stra_pil3_1d = ?,
        ket_in_stra_pil3_1e = ?,
        ket_in_stra_pil3_1f = ?,
        ket_in_stra_pil3_1g = ?,
        ket_in_stra_pil3_1h = ?,
        ket_in_stra_pil3_1i = ?,
        ket_in_stra_pil3_1j = ?,
        ket_in_stra_pil3_1k = ?,
        ket_in_stra_pil3_1l = ?,
        ket_in_stra_pil3_1m = ?,
        ket_in_stra_pil3_1n = ?,
        ket_in_stra_pil3_1o = ?,
        ket_in_stra_pil3_1p = ?,

        ket_in_stra_pil3_2 = ?,
        ket_in_stra_pil3_2a = ?,
        ket_in_stra_pil3_2b = ?,
        ket_in_stra_pil3_2c = ?,
        ket_in_stra_pil3_2d = ?,
        ket_in_stra_pil3_2e = ?,
        ket_in_stra_pil3_2f = ?
    WHERE id_profil_risiko = ?", [$ket_in_stra_pil3_1, $ket_in_stra_pil3_1a, $ket_in_stra_pil3_1b, $ket_in_stra_pil3_1c, $ket_in_stra_pil3_1d, $ket_in_stra_pil3_1e, $ket_in_stra_pil3_1f, $ket_in_stra_pil3_1g, $ket_in_stra_pil3_1h, $ket_in_stra_pil3_1i, $ket_in_stra_pil3_1j, $ket_in_stra_pil3_1k, $ket_in_stra_pil3_1l, $ket_in_stra_pil3_1m, $ket_in_stra_pil3_1n, $ket_in_stra_pil3_1o, $ket_in_stra_pil3_1p, $ket_in_stra_pil3_2, $ket_in_stra_pil3_2a, $ket_in_stra_pil3_2b, $ket_in_stra_pil3_2c, $ket_in_stra_pil3_2d, $ket_in_stra_pil3_2e, $ket_in_stra_pil3_2f, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_stratejik_lainnya SET
        ket_in_stra_pil4_1a = ?,
        ket_in_stra_pil4_1b = ?,
        ket_in_stra_pil4_1c = ?,
        ket_in_stra_pil4_1d = ?
    WHERE id_profil_risiko = ?", [$ket_in_stra_pil4_1a, $ket_in_stra_pil4_1b, $ket_in_stra_pil4_1c, $ket_in_stra_pil4_1d, $id]);


    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=stra_inhern1&id=$id");
    exit();
}
?>





<script>
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1d').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1e').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil1_1f').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter7').text(charCount);
            });
        });




        $(document).ready(function() {
            $('#ket_in_stra_pil2_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter8').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter9').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter10').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1d').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter11').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1e').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter12').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1f').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter13').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1g').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter14').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_1h').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter15').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter16').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter17').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil2_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter18').text(charCount);
            });
        });




        $(document).ready(function() {
            $('#ket_in_stra_pil3_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter19').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter202').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter21').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter22').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1d').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter23').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1e').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter24').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1f').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter25').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1g').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter26').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1h').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter27').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1i').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter28').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1j').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter29').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1k').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter30').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1l').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter31').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1m').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter32').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1n').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter33').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1o').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter34').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_1p').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter35').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter36').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter37').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter38').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter39').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2d').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter40').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil3_2f').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter41').text(charCount);
            });
        });



        $(document).ready(function() {
            $('#ket_in_stra_pil4_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter42').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_stra_pil4_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter43').text(charCount);
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

                        <h4 class="page-title">Risiko stratejik Inheren 1 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 1 Profil Risiko stratejik</h4>

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
                                                    <center><b>RISIKO STRATEJIK INHEREN 1</b></center>
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
                                                    <b>PILAR 1 : Penetapan Strategi Bisnis</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Penetapan Strategi Bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> </br>
                                            • Tidak terdapat produk/aktivit as baru yang dimiliki  BPR, pilihan strategi sesuai  sumber daya   yang dimiliki dengan tingkat keberhasilan strategi yang tinggi; dan/atau
                                            </br>
                                            • BPR melakukan kegiatan usaha dalam  pangsa pasar/sektor ekonomi    dan nasabah   yang telah dikenal/ada sebelumnya, termasuk tidak ada strategi pengembangan jaringan kantor.
                                            </td>
                                            <td>
                                            <b>(2)</b></br> • BPR memiliki beberapa strategi baru tetapi masih dalam bisnis utama  dan kompetensi BPR (terdapat beberapa produk baru) serta sesuai sumber  daya yang dimiliki dengan tingkat keberhasilan strategi  yang cukup tinggi; dan/atau
                                            </br>• BPR melakukan kegiatan usaha dalam pangsa pasar/sektor ekonomi   dan nasabah  yang telah dikenal/ada sebelumnya, dengan pangsa pasar  yang semakin luas.
                                            </td>
                                            <td>
                                            <b>(3)</b> </br> • BPR memiliki beberapa strategi  baru termasuk adanya produk baru   yang tergolong berisiko tinggi antara lain memerlukan SDM dengan keahlian khusus dan/atau infrastruktur TI yang lebih kompleks dengan tingkat keberhasilan strategi  BPR tergolong moderat; dan/atau
                                            </br> • Sebagian besar kegiatan usaha BPR   berada dalam  pangsa pasar/sektor ekonomi     dan nasabah    yang telah dikenal/ada sebelumnya, terdapat perluasan pangsa pasar dan nasabah
                                            baru namun tanpa melalui strategi pengembangan jaringan kantor.
                                            </td>
                                            <td>
                                            <b>(4)</b> </br> • Mayoritas strategi   BPR beralih kepada strategi  baru dengan produk baru  yang tergolong berisiko tinggi
                                            antara lain memerlukan SDM dengan keahlian khusus dan/atau infrastruktur TI yang  lebih kompleks dengan tingkat keberhasilan yang belum dapat dipastikan; dan/atau
                                            </br> • Sebagian besar kegiatan usaha BPR  berada dalam pangsa pasar/sektor ekonomi    dan nasabah   baru, termasuk melalui strategi pengembangan jaringan kantor.

                                            <td>
                                            <b>(5)</b> </br>• BPR mengubah strategi bisnis untuk memasuki produk   baru yang tergolong berisiko  tinggi antara  lain
                                            memerlukan SDM dengan keahlian khusus dan/atau infrastruktur
                                            TI yang  lebih kompleks yang bukan merupakan bisnis  utama dan  kompetensi BPR dengan tingkat keberhasilan yang  belum dapat dipastikan;
                                            </br>• Seluruh kegiatan usaha BPR  berada dalam pangsa pasar/sektor ekonomi    dan nasabah   baru, termasuk melalui strategi pengembangan jaringan
                                            kantor; dan/atau
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1" form="my_form" name="ket_in_stra_pil1_1" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length1['l1'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                            Evaluasi Posisi Kompetitif di industri
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki kemampuan yang sangat baik dalam menilai posisinya terhadap kompetitor dalam rangka menentukan strategi yang akan dilaksanakan.
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki kemampuan yang baik dalam menilai posisinya terhadap kompetitor dalam rangka menentukan strategi yang akan dilaksanakan.
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki kemampuan yang cukup baik dalam menilai posisinya terhadap kompetitor dalam rangka menentukan strategi yang akan dilaksanakan.
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki kemampuan yang kurang baik dalam menilai posisinya terhadap kompetitor dalam rangka menentukan strategi yang akan dilaksanakan.
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak  memiliki kemampuan dalam menilai posisinya terhadap kompetitor dalam rangka menentukan strategi yang akan dilaksanakan.
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1a" form="my_form" name="ket_in_stra_pil1_1a" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1a'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length1['l2'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Faktor Eksternal
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki kemampuan dalam menilai potensi lingkungan bisnis yang meliputi produk, layanan dan tehnologi dari industri serta dampak yang ditimbulkan terhadap strategi bisnis
                                            Bank memiliki penguasaan terhadap wilayah operasional yang sangat baik yang meliputi penguasaan wilayah pasar sasaran maupun target nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki kemampuan dalam menilai potensi lingkungan bisnis yang meliputi produk, layanan dan tehnologi dari industri serta dampak yang ditimbulkan terhadap strategi bisnis
                                            Bank memiliki penguasaan terhadap wilayah operasional yang baik yang meliputi penguasaan wilayah pasar sasaran maupun target nasabah
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki kemampuan dalam menilai potensi lingkungan bisnis yang meliputi produk, layanan dan tehnologi dari industri 
                                            Bank memiliki penguasaan terhadap wilayah operasional yang cukup baik yang meliputi penguasaan wilayah pasar sasaran maupun target nasabah
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank kurang  memiliki kemampuan dalam menilai potensi lingkungan bisnis yang meliputi produk, layanan dan tehnologi dari industri 
                                            Bank memiliki penguasaan terhadap wilayah operasional yang kurang baik yang meliputi penguasaan wilayah pasar sasaran maupun target nasabah
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak  memiliki kemampuan dalam menilai potensi lingkungan bisnis yang meliputi produk, layanan dan tehnologi dari industri 
                                            Bank tidak memiliki penguasaan terhadap wilayah operasional 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1b" form="my_form" name="pilar1_1b">
                                                    <option <?= $pil1['pilar1_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1b'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1b" form="my_form" name="ket_in_stra_pil1_1b" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1b'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length1['l3'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Rencana Keberlangsungan  Manajerial
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah mempersiapkan kecukupan sumber daya manusia yang kompeten untuk menjalankan fungsi manajerial dalam menjalankan strategi bisnis yang telah ditetapkan pada seluruh unit kerja yang dibutuhkan
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah mempersiapkan kecukupan sumber daya manusia yang kompeten untuk menjalankan fungsi manajerial dalam menjalankan strategi bisnis yang telah ditetapkan pada sebagian besar unit kerja yang dibutuhkan
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah mempersiapkan kecukupan sumber daya manusia yang kompeten untuk menjalankan fungsi manajerial dalam menjalankan strategi bisnis yang telah ditetapkan pada beberapa unit kerja yang dibutuhkan
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank mempersiapkan kecukupan sumber daya manusia yang kompeten untuk menjalankan fungsi manajerial dalam menjalankan strategi bisnis yang telah ditetapkan pada beberapa unit kerja yang dibutuhkan
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank belum mempersiapkan kecukupan sumber daya manusia yang kompeten untuk menjalankan fungsi manajerial dalam menjalankan strategi bisnis yang telah ditetapkan pada beberapa unit kerja yang dibutuhkan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1c" form="my_form" name="pilar1_1c">
                                                    <option <?= $pil1['pilar1_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1c" form="my_form" name="ket_in_stra_pil1_1c" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1c'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length1['l4'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kecukupan Sumber Daya 
                                            </th>
                                            <td>
                                            <b>(1)</b>  Bank memiliki kecukupan sumber daya yang sangat memadai untuk mendukung pelaksanaan rencana strategis 
                                            Sumber daya meliputi kualitas dan kuantitas SDM, infrastruktur dan sumber dana yang mampu memenuhi kebutuhan dalam pelaksanaan rencana strategis
                                            </td>
                                            <td>
                                            <b>(2)</b>  Bank memiliki kecukupan sumber daya yang memadai untuk mendukung pelaksanaan rencana strategis 
                                            Sumber daya meliputi kualitas dan kuantitas SDM, infrastruktur dan sumber dana yang mampu memenuhi kebutuhan dalam pelaksanaan rencana strategis
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki sumber daya yang memadai untuk mendukung pelaksanaan rencana strategis 
                                            Sumber daya meliputi kualitas dan kuantitas SDM, infrastruktur, namun belum didukung sumber dana yang optimal mampu memenuhi kebutuhan dalam pelaksanaan rencana strategis
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki sumber daya yang kurang memadai untuk mendukung pelaksanaan rencana strategis 
                                            Sumber daya meliputi jumlah SDM dan  infrastruktur, namun belum didukung sumber dana yang optimal mampu memenuhi kebutuhan dalam pelaksanaan rencana strategis
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank memiliki sumber daya yang kurang memadai untuk mendukung pelaksanaan rencana strategis 
                                            Sumber daya meliputi jumlah SDM dan  infrastruktur, namun tidak didukung sumber dana yang optimal mampu memenuhi kebutuhan dalam pelaksanaan rencana strategis
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1d" form="my_form" name="pilar1_1d">
                                                    <option <?= $pil1['pilar1_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1d'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1d" form="my_form" name="ket_in_stra_pil1_1d" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1d'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length1['l5'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Beban Kerja pada Seluruh Unit Kerja dalam mencapai target
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Dilakukan setiap Semester
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan setiap 1 (Satu) tahun
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan setiap > 1 (Satu) tahun 
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1e" form="my_form" name="pilar1_1e">
                                                    <option <?= $pil1['pilar1_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1e'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1e" form="my_form" name="ket_in_stra_pil1_1e" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1e'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length1['l6'] ?></span><span> / 500</span></td>

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Potensi Pasar  
                                            </th>
                                            <td>
                                            <b>(1)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT) dan Survey Pasar Setiap Bulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT) dan Survey Pasar Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(3)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT) Setiap Semester
                                            </td>
                                            <td>
                                            <b>(4)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT) Setiap Tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> tidak Melakukan Penelitian Terhadap Potensi Pasar (SWOT)
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1f" form="my_form" name="pilar1_1f">
                                                    <option <?= $pil1['pilar1_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil1['pilar1_1f'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil1_1f" form="my_form" name="ket_in_stra_pil1_1f" cols="35" rows="5"><?= $ketpil1['ket_in_stra_pil1_1f'] ?></textarea>
                                            <span id="penghitung-karakter7"><?= $length1['l7'] ?></span><span> / 500</span></td>
                                        </tr>



<!--pilar2-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 2 : Penyusunan Rencana Bisnis</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> Penyusunan strategi ( rencana dan  model bisnis) BPR telah mempertimbang kan seluruh faktor yang memengaruhi lingkungan bisnis BPR baik faktor internal maupun  faktor eksternal secara komprehensif; dan/atau
                                            • Tingkat kecepatan respon    BPR terhadap perubahan faktor eksternal tergolong tinggi, dilakukan perubahan rencana bisnis jika dibutuhkan secara tepat waktu.
                                            </td>
                                            <td>
                                            <b>(2)</b> Penyusunan strategi (rencana  dan model bisnis) BPR   telah mempertimbang kan seluruh faktor yang memengaruhi lingkungan bisnis BPR baik faktor internal maupun faktor eksternal, namun terdapat beberapa kelemahan; dan/atau
                                            • Tingkat kecepatan respon  BPR terhadap perubahan faktor eksternal tergolong sedang, dilakukan perubahan rencana bisnis jika dibutuhkan namun membutuhkan waktu tidak lama.
                                            </td>
                                            <td>
                                            <b>(3)</b> Penyusunan strategi (rencana  dan model bisnis) BPR telah mempertimbang kan sebagian besar faktor yang memengaruhi lingkungan bisnis BPR baik faktor internal maupun faktor eksternal, namun terdapat beberapa kelemahan; dan/atau
                                            • Tingkat kecepatan respon  BPR terhadap perubahan faktor eksternal tergolong rendah, dilakukan perubahan rencana bisnis jika dibutuhkan Namun membutuhkan waktu cukup lama
                                            </td>
                                            <td>
                                            <b>(4)</b> Penyusunan strategi (rencana dan model bisnis) BPR hanya mempertimbang kan sebagian faktor yang memengaruhi lingkungan bisnis BPR baik faktor internal maupun faktor eksternal, dan terdapat kelemahan yang tergolong sangat signifikan; dan/atau
                                            • Tingkat kecepatan respon BPR terhadap perubahan  faktor eksternal tergolong sangat rendah, dilakukan perubahan rencana  bisnis jika dibutuhkan namun membutuhkan waktu sangat lama.
                                            </td>
                                            <td>
                                            <b>(5)</b> Penyusunan strategi (rencana dan   model bisnis) BPR belum mempertimbang kan lingkungan bisnis BPR baik faktor internal maupun  faktor eksternal; dan/atau
                                            • BPR tidak merespon perubahan faktor eksternal yaitu tidak melakukan perubahan rencana bisnis yang dibutuhkan.
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1" form="my_form" name="ket_in_stra_pil2_1" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1'] ?></textarea>
                                            <span id="penghitung-karakter8"><?= $length2['l8'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Perubahan Lingkungan Bisnis 
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki berbagai alternatif market yang dilengkapi dengan jenis produk dan layanan dalam mengantisipasi terjadinya perubahan lingkungan bisnis, termasuk kelengkapan dukungan sumber daya yang kompeten
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki berbagai alternatif market yang dilengkapi dengan jenis produk dan layanan dalam mengantisipasi terjadinya perubahan lingkungan bisnis, termasuk sumber daya manusia, namun jumlah SDM yang kompeten masih terbatas
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki berbagai alternatif market yang dilengkapi dengan jenis produk dan layanan dalam mengantisipasi terjadinya perubahan lingkungan bisnis,namun belum didukung kecukupan SDM yang kompeten
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki beberapa alternatif market yang dilengkapi dengan jenis produk dan layanan dalam mengantisipasi terjadinya perubahan lingkungan bisnis, namun belum didukung kecukupan SDM yang kompeten
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak  memiliki alternatif market yang dilengkapi dengan jenis produk dan layanan dalam mengantisipasi terjadinya perubahan lingkungan bisnis
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1a" form="my_form" name="ket_in_stra_pil2_1a" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1a'] ?></textarea>
                                            <span id="penghitung-karakter9"><?= $length2['l9'] ?></span><span> / 500</span></td>
                                        </tr>




                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Struktur Organisasi dan SDM
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki struktur organisasi yang lengkap dan kecukupan sumber daya manusia  yang mendukung pelaksanaan rencana strategis 
                                            Bank memiliki kecukupan sumber daya manusia yang meliputi kualifikasi kompetensi, integritas, jaringan komunikasi dan jumlah yang dibutuhkan sesuai dengan kebutuhan masing - masing unit kerja
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki struktur organisasi yang lengkap dan kecukupan sumber daya manusia  yang mendukung pelaksanaan rencana strategis 
                                            Bank memiliki kecukupan sumber daya manusia yang meliputi kualifikasi kompetensi, integritas, jaringan komunikasi dan jumlah yang dibutuhkan namun sesuai dengan kebutuhan masing - masing unit kerja
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki struktur organisasi yang lengkap dan kecukupan sumber daya manusia  yang mendukung pelaksanaan rencana strategis 
                                            Bank memiliki kecukupan sumber daya manusia yang meliputi kualifikasi kompetensi namun belum sesuai dengan kebutuhan.
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki struktur organisasi yang lengkap dan sumber daya manusia  yang mendukung pelaksanaan rencana strategis 
                                            Bank memiliki kecukupan jumlah sumber daya manusia namun belum memenuhi kualifikasi kompetensi sesuai dengan kebutuhan.
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank memiliki struktur organisasi yang kurang lengkap dan sumber daya manusia  yang mendukung pelaksanaan rencana strategis 
                                            Bank memiliki kecukupan jumlah sumber daya manusia namun belum memenuhi kualifikasi kompetensi sesuai dengan kebutuhan.
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1c" form="my_form" name="ket_in_stra_pil2_1c" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1c'] ?></textarea>
                                            <span id="penghitung-karakter10"><?= $length2['l10'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pengendalian Internal
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki mekanisme pengawasan yang mampu mendeteksi kelemahan dan penyimpangan yang terjadi secara tepat waktu dan melakukan tindakan preventif untuk mencegah terjadinya kelemahan dan penyimpangan dalam pencapaian rencana strategis
                                            Bank telah menjadikan pengendalian internal sebagai budaya dalam pelaksanaan tugas tanggungjawab setiap pegawai.
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki mekanisme pengawasan yang mampu mendeteksi kelemahan dan penyimpangan yang terjadi dan melakukan tindakan preventif untuk mencegah terjadinya kelemahan dan penyimpangan dalam pencapaian rencana strategis
                                            Bank telah menjadikan pengendalian internal sebagai budaya dalam pelaksanaan tugas tanggungjawab setiap pegawai.
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki mekanisme pengawasan yang mampu mendeteksi kelemahan dan penyimpangan yang terjadi dan melakukan tindakan preventif untuk mencegah terjadinya kelemahan dan penyimpangan dalam pencapaian rencana strategis, namun dilakukan tidak tepat waktu
                                            Bank telah menjadikan pengendalian internal sebagai budaya dalam pelaksanaan tugas tanggungjawab setiap pegawai.
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki mekanisme pengawasan yang mampu mendeteksi kelemahan dan penyimpangan namun tidak segeran melakukan tindakan preventif untuk mencegah terjadinya kelemahan dan penyimpangan dalam pencapaian rencana strategis
                                            Bank belum sepenuhnya menjadikan pengendalian internal sebagai budaya dalam pelaksanaan tugas tanggungjawab setiap pegawai.
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank belum memiliki mekanisme pengawasan yang mampu mendeteksi kelemahan dan penyimpangan dalam pencapaian rencana strategis
                                            Bank belum  menjadikan pengendalian internal sebagai budaya dalam pelaksanaan tugas tanggungjawab setiap pegawai.
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1d" form="my_form" name="pilar2_1d">
                                                    <option <?= $pil2['pilar2_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1d'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1d" form="my_form" name="ket_in_stra_pil2_1d" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1d'] ?></textarea>
                                            <span id="penghitung-karakter11"><?= $length2['l11'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Produk Eksisting
                                            </th>
                                            <td>
                                            <b>(1)</b> Melakukan Penelitian Produk Terhadap Kinerja (Wilayah, NOA, OSC, NPL) dan Survey Pasar Setiap Bulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Melakukan Penelitian Produk Terhadap Kinerja (Wilayah, NOA, OSC, NPL) dan Survey Pasar Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(3)</b> Melakukan Penelitian Produk Terhadap Kinerja (Wilayah, NOA, OSC, NPL) Setiap Semester
                                            </td>
                                            <td>
                                            <b>(4)</b> Melakukan Penelitian Produk Terhadap Kinerja (Wilayah, NOA, OSC, NPL) Setiap Tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> tidak Melakukan Penelitian Produk Terhadap Kinerja (Wilayah, NOA, OSC, NPL)
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1e" form="my_form" name="pilar2_1e">
                                                    <option <?= $pil2['pilar2_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1e'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1e" form="my_form" name="ket_in_stra_pil2_1e" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1e'] ?></textarea>
                                            <span id="penghitung-karakter12"><?= $length2['l12'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Layanan Eksisting 
                                            </th>
                                            <td>
                                            <b>(1)</b> Melakukan Penelitian Layanan Terhadap Cost and Benefit, Identifikasi Risiko Operasional, Kepatuhan, dan Reputasi Setiap Bulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Melakukan Penelitian Layanan Terhadap Cost and Benefit, Identifikasi Risiko Operasional, Kepatuhan, dan Reputasi Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(3)</b> Melakukan Penelitian Layanan Terhadap Cost and Benefit, Identifikasi Risiko Operasional dan Reputasi Setiap Semester
                                            </td>
                                            <td>
                                            <b>(4)</b> Melakukan Penelitian Layanan Terhadap Cost and Benefit, Identifikasi Risiko Operasional dan Reputasi Setiap Tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Melakukan Penelitian Layanan Terhadap Cost and Benefit, Identifikasi Risiko Operasional dan Reputasi
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1f" form="my_form" name="pilar2_1f">
                                                    <option <?= $pil2['pilar2_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1f'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1f" form="my_form" name="ket_in_stra_pil2_1f" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1f'] ?></textarea>
                                            <span id="penghitung-karakter13"><?= $length2['l13'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Analisa Produk dan Layanan Baru
                                            </th>
                                            <td>
                                            <b>(1)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT), Cost and Benefit,Identifikasi dan mitigasi 6 (Enam) Risiko dan Masa Uji Pengukuran Risiko Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT), Cost and Benefit,Identifikasi dan mitigasi 6 (Enam) Risiko dan Masa Uji Pengukuran RisikoSetiap Semester
                                            </td>
                                            <td>
                                            <b>(3)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT), Cost and Benefit, Identifikasi dan mitigasi 6 (Enam) Risiko Setiap Tahun
                                            </td>
                                            <td>
                                            <b>(4)</b> Melakukan Penelitian Terhadap Potensi Pasar (SWOT), Cost and Benefit, Identifikasi dan mitigasi 6 (Enam) Risiko > 1 (satu) tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Melakukan Penelitian Terhadap Potensi Pasar (SWOT), Cost and Benefit, Identifikasi dan mitigasi 6 risiko
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1g" form="my_form" name="pilar2_1g">
                                                    <option <?= $pil2['pilar2_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1g'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1g'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1g'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1g'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1g'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1g'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1g" form="my_form" name="ket_in_stra_pil2_1g" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1g'] ?></textarea>
                                            <span id="penghitung-karakter14"><?= $length2['l14'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Identifikasi Perubahan Lingkungan Bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> Menyusun Stresstest Dampak Perubahan Lingkungan Bisnis Setiap Triwulanan 
                                            </td>
                                            <td>
                                            <b>(2)</b> Menyusun Stresstest Dampak Perubahan Lingkungan Bisnis Setiap Semester
                                            </td>
                                            <td>
                                            <b>(3)</b> Menyusun Stresstest Dampak Perubahan Lingkungan Bisnis 1 (Satu) Kali Dalam Setahun  
                                            </td>
                                            <td>
                                            <b>(4)</b> Menyusun Stresstest Dampak Perubahan Lingkungan Bisnis 1 (Satu) Kali > 1 Tahun  
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Pernah Menyusun Stresstest Dampak Perubahan Lingkungan Bisnis  
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_1h" form="my_form" name="pilar2_1h">
                                                    <option <?= $pil2['pilar2_1h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1h'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1h'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1h'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1h'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1h'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil2['pilar2_1h'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_1h" form="my_form" name="ket_in_stra_pil2_1h" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_1h'] ?></textarea>
                                            <span id="penghitung-karakter15"><?= $length2['l15'] ?></span><span> / 500</span></td>
                                        </tr>





                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Keunggulan kompetitif BPR dan ancaman dari kompetitor
                                            </th>
                                            <td>
                                            <b>(1)</b> BPR memiliki keunggulan kompetitif yang stabil dan tidak terdapat ancaman dari kompetitor.
                                            </td>
                                            <td>
                                            <b>(2)</b> BPR memiliki keunggulan kompetitif yang moderat namun terdapat ancaman dari kompetitor yang tidak memengaruhi BPR (contoh: pertumbuhan kredit dan dana pihak ketiga (DPK) masih di atas target).
                                            </td>
                                            <td>
                                            <b>(3)</b> BPR memiliki keunggulan kompetitif yang moderat dan terdapat ancaman dari kompetitor yang memengaruhi BPR (contoh: terdapat deviasi pencapaian Pertumbuhan kredit dan DPK namun masih tergolong rendah).
                                            </td>
                                            <td>
                                            <b>(4)</b> BPR kurang memiliki keunggulan kompetitif, dan/atau terdapat ancaman signifikan   dari kompetitor yang berdampak pada kinerja  keuangan BPR (contoh: terdapat deviasi pencapaian pertumbuhan kredit dan DPK yang tergolong sedang).
                                            </td>
                                            <td>
                                            <b>(5)</b> BPR tidak memiliki keunggulan kompetitif, dan/atau terdapat ancaman sangat signifikan  dari kompetitor  dan berdampak signifikan pada Kinerja keuangan BPR (contoh: terdapat deviasi pencapaian pertumbuhan kredit dan DPK yang tergolong tinggi).
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_2" form="my_form" name="ket_in_stra_pil2_2" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_2'] ?></textarea>
                                            <span id="penghitung-karakter16"><?= $length2['l16'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kondisi persaingan / kompetitor
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah melakukan penilaian dan evaluasi tingkat persaingan dari kompetitor dan menentukan target posisi Bank ditengah persaingan dalam penetapan rencana strategis, dan melakukan evaluasi berkala dalam pencapaian target posisi yang telah ditetapkan
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah melakukan penilaian tingkat persaingan dari kompetitor dan menentukan target posisi Bank ditengah persaingan dalam penetapan rencana strategis, dan melakukan evaluasi berkala dalam pencapaian target posisi yang telah ditetapkan
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah melakukan penilaian tingkat persaingan dari kompetitor dan menentukan target posisi Bank ditengah persaingan dalam penetapan rencana strategis, dan namun kurang optimal dalam melakukan evaluasi capaian target posisi yang telah ditetapkan
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank  melakukan penilaian tingkat persaingan dari kompetitor dan menentukan target posisi Bank ditengah persaingan dalam penetapan rencana strategis, namun tidak melakukan evaluasi capaian target posisi yang telah ditetapkan
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak  melakukan penilaian tingkat persaingan dari kompetitor untuk menentukan target posisi Bank ditengah persaingan dalam penetapan rencana strategis
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_2a" form="my_form" name="ket_in_stra_pil2_2a" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_2a'] ?></textarea>
                                            <span id="penghitung-karakter17"><?= $length2['l17'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Preferensi Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah melakukan penelitian kepada masyarakat untuk mengetahui kebutuhan dan keinginan masyarakat terhadap jenis produk dan layanan dalam penetapan rencana strategis
                                            Bank melakukan pemenuhan terhadap preferensi nasabah dengan melakukan up date secara terus menerus terhadap jenis produk dan layanan lama sesuai dengan perkembangan tehnologi informasi dan kebutuhan serta keinginan nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah melakukan penelitian kepada masyarakat untuk mengetahui kebutuhan dan keinginan masyarakat terhadap jenis produk dan layanan dalam penetapan rencana strategis
                                            Bank melakukan pemenuhan terhadap preferensi nasabah dengan melakukan up date  terhadap jenis produk dan layanan lama sesuai dengan kebutuhan serta keinginan nasabah
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank  melakukan penelitian kepada masyarakat untuk mengetahui kebutuhan dan keinginan masyarakat terhadap jenis produk dan layanan dalam penetapan rencana strategis
                                            Bank melakukan pemenuhan terhadap preferensi nasabah dengan melakukan up date  terhadap jenis produk dan layanan
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank  melakukan penelitian kepada masyarakat untuk mengetahui kebutuhan dan keinginan masyarakat terhadap jenis produk dan layanan dalam penetapan rencana strategis
                                            Bank belum melakukan pemenuhan terhadap preferensi nasabah dengan melakukan up date  terhadap jenis produk dan layanan
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank  tidak melakukan penelitian kepada masyarakat untuk mengetahui kebutuhan dan keinginan masyarakat terhadap jenis produk dan layanan dalam penetapan rencana strategis
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil2_2b" form="my_form" name="ket_in_stra_pil2_2b" cols="35" rows="5"><?= $ketpil2['ket_in_stra_pil2_2b'] ?></textarea>
                                            <span id="penghitung-karakter18"><?= $length2['l18'] ?></span><span> / 500</span></td>
                                        </tr>





                                        
<!--pilar 3-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 3 : Pencapaian Target Bisnis</b>
                                                </h4>
                                            </td>
                                        </tr>



                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas
                                            </th>
                                            <td>
                                            <b>(1)</b> </br>• Realisasi   di atas   target kuantitatif atau terdapat deviasi paling besar 5% dari target; dan
                                            </br>• sebagian besar atau seluruh target kualitatif tercapai.
                                            </td>
                                            <td>
                                            <b>(2)</b> </br>• Deviasi rendah dibanding target kuantitatif; dan
                                            </br>• sebagian besar target kualitatif tercapai.
                                            </td>
                                            <td>
                                            <b>(3)</b> </br>• Deviasi sedang dibanding target kuantitatif; dan
                                            </br>• sebagian besar target kualitatif tercapai.
                                            </td>
                                            <td>
                                            <b>(4)</b> </br>• Deviasi tinggi dibanding dari target kuantitatif; dan
                                            </br>• sebagian kecil target kualitatif tercapai.
                                            </td>
                                            <td>
                                            <b>(5)</b> </br>• Deviasi sangat tinggi dibanding target kuantitatif; dan
                                            </br>• sebagian kecil target kualitatif tercapai atau tidak  ada target yang
                                            tercapai.

                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1" form="my_form" name="pilar3_1">
                                                    <option <?= $pil3['pilar3_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1" form="my_form" name="ket_in_stra_pil3_1" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1'] ?></textarea>
                                            <span id="penghitung-karakter19"><?= $length3['l19'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Capaian target kuantitatif terhadap 6 parameter kuantitaif 
                                            </th>
                                            <td>
                                            <b>(1)</b> Seluruh rencana bisnis kuantitatif yang terdiri Aset, Dana Masyarakat, Kredit, Pendapatan, Biaya dan Laba tercapai diatas target. 
                                            Pelampauan realisasi atas target yang ditetapkan melebihi 110%, dan telah merealisasikan seluruh anggaran  dan telah memberikan kesejahteraan yang baik kepada pegawai
                                            </td>
                                            <td>
                                            <b>(2)</b> Seluruh rencana bisnis kuantitatif yang terdiri Aset, Dana Masyarakat, Kredit, Pendapatan, Biaya dan Laba tercapai diatas target. 
                                            Pelampauan realisasi atas target yang ditetapkan melebihi 110%, dan telah merealisasikan seluruh anggaran biaya namun ada perampingan pada beberapa rencana biaya,  dan telah memberikan kesejahteraan yang baik kepada pegawai
                                            </td>
                                            <td>
                                            <b>(3)</b> Seluruh rencana bisnis kuantitatif yang terdiri Aset, Dana Masyarakat, Kredit, Pendapatan, Biaya dan Laba tercapai diatas target. 
                                            Pelampauan realisasi atas target yang ditetapkan melebihi 110%, dan telah merealisasikan seluruh anggaran biaya namun ada perampingan pada beberapa rencana biaya, namun tidak memberikan kesejahteraan yang baik kepada pegawai
                                            </td>
                                            <td>
                                            <b>(4)</b> Rencana bisnis kuantitatif yang terdiri Aset, Dana Masyarakat, Kredit tercapai diatas target , namun Pendapatan, Biaya dan Laba tidak dapat mencapai target. 
                                            Terdapat pelampauan target biaya karena pembentukan PPAP melebihi anggaran, sehingga target  pendapatan dan laba tidak terpenuhi.
                                            </td>
                                            <td>
                                            <b>(5)</b> Seluruh Rencana bisnis kuantitatif yang terdiri Aset, Dana Masyarakat, Kredit,Pendapatan, Biaya dan Laba tidak dapat mencapai target. 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1a" form="my_form" name="pilar3_1a">
                                                    <option <?= $pil3['pilar3_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1a'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1a" form="my_form" name="ket_in_stra_pil3_1a" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1a'] ?></textarea>
                                            <span id="penghitung-karakter20"><?= $length3['l20'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Saldo Kredit Bermasalah 
                                            </th>
                                            <td>
                                            <b>(1)</b> < 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(2)</b>  100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 105% dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 110% dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> > 110% dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1c" form="my_form" name="pilar3_1c">
                                                    <option <?= $pil3['pilar3_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1c" form="my_form" name="ket_in_stra_pil3_1c" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1c'] ?></textarea>
                                            <span id="penghitung-karakter22"><?= $length3['l22'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Laba Sebelum Pajak
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(2)</b>  100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 95% dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 90% dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 90% dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1d" form="my_form" name="pilar3_1d">
                                                    <option <?= $pil3['pilar3_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1d'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1d" form="my_form" name="ket_in_stra_pil3_1d" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1d'] ?></textarea>
                                            <span id="penghitung-karakter23"><?= $length3['l23'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            NIM
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 95% dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 90% dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 90% dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1e" form="my_form" name="pilar3_1e">
                                                    <option <?= $pil3['pilar3_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1e'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1e" form="my_form" name="ket_in_stra_pil3_1e" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1e'] ?></textarea>
                                            <span id="penghitung-karakter24"><?= $length3['l24'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>
                                        
                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Komposisi Tabungan Terhadap Dana Pihak Ketiga
                                            </th>
                                            <td>
                                            <b>(1)</b> >75%
                                            <td>
                                            <b>(2)</b> 72%
                                            </td>
                                            <td>
                                            <b>(3)</b> 70%
                                            </td>
                                            <td>
                                            <b>(4)</b> 65%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 65% 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1f" form="my_form" name="pilar3_1f">
                                                    <option <?= $pil3['pilar3_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1f'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1f" form="my_form" name="ket_in_stra_pil3_1f" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1f'] ?></textarea>
                                            <span id="penghitung-karakter25"><?= $length3['l25'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>
                                        
                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Komposisi Deposito Terhadap Dana Pihak Ketiga
                                            </th>
                                            <td>
                                            <b>(1)</b> < 25%
                                            <td>
                                            <b>(2)</b> 28%
                                            </td>
                                            <td>
                                            <b>(3)</b> 30%
                                            </td>
                                            <td>
                                            <b>(4)</b> 35%
                                            </td>
                                            <td>
                                            <b>(5)</b> > 35%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1g" form="my_form" name="pilar3_1g">
                                                    <option <?= $pil3['pilar3_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1g'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1g'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1g'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1g'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1g'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1g'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1g" form="my_form" name="ket_in_stra_pil3_1g" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1g'] ?></textarea>
                                            <span id="penghitung-karakter26"><?= $length3['l26'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Komposisi Pendapatan Bunga Kontraktual Terhadap Aset Produktif
                                            </th>
                                            <td>
                                            <b>(1)</b> 10%
                                            <td>
                                            <b>(2)</b> 9%
                                            </td>
                                            <td>
                                            <b>(3)</b> 8,75%
                                            </td>
                                            <td>
                                            <b>(4)</b> 8%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 8% 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1h" form="my_form" name="pilar3_1h">
                                                    <option <?= $pil3['pilar3_1h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1h'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1h'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1h'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1h'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1h'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1h'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1h" form="my_form" name="ket_in_stra_pil3_1h" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1h'] ?></textarea>
                                            <span id="penghitung-karakter27"><?= $length3['l27'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Komposisi Pendapatan Bunga Kontraktual Terhadap Pendapatan 
                                            </th>
                                            <td>
                                            <b>(1)</b> > 80%
                                            <td>
                                            <b>(2)</b> 75%
                                            </td>
                                            <td>
                                            <b>(3)</b> 72%
                                            </td>
                                            <td>
                                            <b>(4)</b> 65%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 65% 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1i" form="my_form" name="pilar3_1i">
                                                    <option <?= $pil3['pilar3_1i'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1i'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1i'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1i'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1i'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1i'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1i'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1i" form="my_form" name="ket_in_stra_pil3_1i" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1i'] ?></textarea>
                                            <span id="penghitung-karakter28"><?= $length3['l28'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Komposisi Biaya Tenaga Kerja terhadap Beban Operasional
                                            </th>
                                            <td>
                                            <b>(1)</b> < 35%
                                            <td>
                                            <b>(2)</b> 40%
                                            </td>
                                            <td>
                                            <b>(3)</b> 45%
                                            </td>
                                            <td>
                                            <b>(4)</b> 50%
                                            </td>
                                            <td>
                                            <b>(5)</b> > 50%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1j" form="my_form" name="pilar3_1j">
                                                    <option <?= $pil3['pilar3_1j'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1j'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1j'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1j'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1j'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1j'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1j'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1j" form="my_form" name="ket_in_stra_pil3_1j" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1j'] ?></textarea>
                                            <span id="penghitung-karakter29"><?= $length3['l29'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Aset
                                            </th>
                                            <td>
                                            <b>(1)</b> 6%
                                            <td>
                                            <b>(2)</b> 5%
                                            </td>
                                            <td>
                                            <b>(3)</b> 4%
                                            </td>
                                            <td>
                                            <b>(4)</b> 2%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 2% 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1k" form="my_form" name="pilar3_1k">
                                                    <option <?= $pil3['pilar3_1k'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1k'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1k'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1k'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1k'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1k'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1k'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1k" form="my_form" name="ket_in_stra_pil3_1k" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1k'] ?></textarea>
                                            <span id="penghitung-karakter30"><?= $length3['l30'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Kredit
                                            </th>
                                            <td>
                                            <b>(1)</b> 15%
                                            <td>
                                            <b>(2)</b> 12%
                                            </td>
                                            <td>
                                            <b>(3)</b> 10%
                                            </td>
                                            <td>
                                            <b>(4)</b> 5%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 5%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1l" form="my_form" name="pilar3_1l">
                                                    <option <?= $pil3['pilar3_1l'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1l'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1l'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1l'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1l'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1l'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1l'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1l" form="my_form" name="ket_in_stra_pil3_1l" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1l'] ?></textarea>
                                            <span id="penghitung-karakter31"><?= $length3['l31'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Dana 
                                            </th>
                                            <td>
                                            <b>(1)</b> 10%
                                            <td>
                                            <b>(2)</b> 5%
                                            </td>
                                            <td>
                                            <b>(3)</b> 4%
                                            </td>
                                            <td>
                                            <b>(4)</b> 2%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 2%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1m" form="my_form" name="pilar3_1m">
                                                    <option <?= $pil3['pilar3_1m'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1m'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1m'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1m'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1m'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1m'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1m'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1m" form="my_form" name="ket_in_stra_pil3_1m" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1m'] ?></textarea>
                                            <span id="penghitung-karakter32"><?= $length3['l32'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Trend Pertumbuhan Laba
                                            </th>
                                            <td>
                                            <b>(1)</b> 15%
                                            <td>
                                            <b>(2)</b> 10%
                                            </td>
                                            <td>
                                            <b>(3)</b> 8%
                                            </td>
                                            <td>
                                            <b>(4)</b> 5%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 5%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1n" form="my_form" name="pilar3_1n">
                                                    <option <?= $pil3['pilar3_1n'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1n'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1n'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1n'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1n'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1n'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1n'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1n" form="my_form" name="ket_in_stra_pil3_1n" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1n'] ?></textarea>
                                            <span id="penghitung-karakter33"><?= $length3['l33'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pertumbuhan Penyaluran pada Sektor Usaha Produktif 
                                            </th>
                                            <td>
                                            <b>(1)</b> 2%
                                            <td>
                                            <b>(2)</b> 1,5%
                                            </td>
                                            <td>
                                            <b>(3)</b> 1,2%
                                            </td>
                                            <td>
                                            <b>(4)</b> 0,5%
                                            </td>
                                            <td>
                                            <b>(5)</b> < 0,5% 
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1o" form="my_form" name="pilar3_1o">
                                                    <option <?= $pil3['pilar3_1o'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1o'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1o'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1o'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1o'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1o'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1o'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1o" form="my_form" name="ket_in_stra_pil3_1o" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1o'] ?></textarea>
                                            <span id="penghitung-karakter34"><?= $length3['l34'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Penerimaan Hapus Buku
                                            </th>
                                            <td>
                                            <b>(1)</b> 110% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 75% dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 50% dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 50% dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1p" form="my_form" name="pilar3_1p">
                                                    <option <?= $pil3['pilar3_1p'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1p'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1p'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1p'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1p'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1p'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_1p'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_1p" form="my_form" name="ket_in_stra_pil3_1p" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_1p'] ?></textarea>
                                            <span id="penghitung-karakter35"><?= $length3['l35'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> Secara historis, BPR memiliki rekam jejak yang sangat baik dalam menerapkan keputusan strategis terkait keempat faktor penilaian rekam jejak
                                            </td>
                                            <td>
                                            <b>(2)</b> Secara historis, BPR memiliki rekam jejak yang baik dalam menerapkan keputusan strategis terkait keempat faktor penilaian rekam jejak
                                            </td>
                                            <td>
                                            <b>(3)</b> Secara historis, BPR memiliki rekam jejak yang cukup baik dalam menerapkan keputusan strategis terkait keempat faktor penilaian rekam jejak
                                            </td>
                                            <td>
                                            <b>(4)</b> Secara historis, BPR memiliki rekam jejak yang kurang baik dalam menerapkan keputusan strategis terkait keempat faktor penilaian rekam jejak
                                            </td>
                                            <td>
                                            <b>(5)</b> Secara historis, BPR memiliki rekam jejak yang tidak baik dalam menerapkan keputusan strategis terterkait keempat faktor penilaian rekam jejak
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2" form="my_form" name="pilar3_2">
                                                    <option <?= $pil3['pilar3_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2" form="my_form" name="ket_in_stra_pil3_2" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2'] ?></textarea>
                                            <span id="penghitung-karakter36"><?= $length3['l36'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Capaian target kualitatif 
                                            </th>
                                            <td>
                                            <b>(1)</b> Seluruh rencana bisnis kuatitatif yang terdiri CAR, KAP, PPAP,NPL, LDR, CR, BOPO, ROA, NIM tercapai diatas target. 
                                            Pelampauan realisasi atas target yang ditetapkan melebihi 110%, dan telah sesuai dengan rencana strategis yang ditetapkan 
                                            <td>
                                            <b>(2)</b> Seluruh rencana bisnis kuatitatif yang terdiri CAR, KAP, PPAP,NPL, LDR, CR, BOPO, ROA, NIM tercapai diatas target. 
                                            Pelampauan realisasi atas target yang ditetapkan melebihi target, namun terdapat beberapa penyimpangan yang tidak material terhadap rencana strategis yang ditetapkan 
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat beberapa target kuatitatif atas ri CAR, CR, BOPO, ROA, NIM  yang tidak mencapai target
                                            Terhadap beberapa target kualitatif yang tidak mencapai target, tidak berdampak pada aspek kualitatif lain dalam pencapaian target
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat bebrapa target kuatitatif atas ri CAR, CR, BOPO, ROA, NIM  yang tidak mencapai target
                                            Terhadap beberapa target kualitatif yang tidak mencapai target,  berdampak pada aspek kualitatif lain dalam pencapaian target
                                            </td>
                                            <td>
                                            <b>(5)</b> > Terdapat banyak target kuatitatif atas ri CAR, CR, BOPO, ROA, NIM  yang tidak mencapai target
                                            Terhadap beberapa target kualitatif yang tidak mencapai target,  berdampak pada aspek kualitatif lain dalam pencapaian target
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2a" form="my_form" name="ket_in_stra_pil3_2a" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2a'] ?></textarea>
                                            <span id="penghitung-karakter37"><?= $length3['l37'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Realisasi Pemenuhan Jumlah SDM Terhadap Target RBB
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 90%  dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 80%  dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> <  80%  dari RBB
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2b" form="my_form" name="ket_in_stra_pil3_2b" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2b'] ?></textarea>
                                            <span id="penghitung-karakter38"><?= $length3['l38'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Realisasi Waktu Pemenuhan SDM
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 80%  dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 70%  dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 70%  dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2c" form="my_form" name="pilar3_2c">
                                                    <option <?= $pil3['pilar3_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2c'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2c" form="my_form" name="ket_in_stra_pil3_2c" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2c'] ?></textarea>
                                            <span id="penghitung-karakter39"><?= $length3['l39'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Realisasi Modul Pelatihan dan Pendidikan Terhadap Target
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 80%  dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 70%  dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 70%  dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2d" form="my_form" name="pilar3_2d">
                                                    <option <?= $pil3['pilar3_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2d'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2d" form="my_form" name="ket_in_stra_pil3_2d" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2d'] ?></textarea>
                                            <span id="penghitung-karakter40"><?= $length3['l40'] ?></span><span> / 500</span></td>
                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Realisasi Pemindahan Jaringan Kantor
                                            </th>
                                            <td>
                                            <b>(1)</b> > 100% dari RBB
                                            <td>
                                            <b>(2)</b> 100% dari RBB
                                            </td>
                                            <td>
                                            <b>(3)</b> 80%  dari RBB
                                            </td>
                                            <td>
                                            <b>(4)</b> 70%  dari RBB
                                            </td>
                                            <td>
                                            <b>(5)</b> < 70%  dari RBB
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_2f" form="my_form" name="pilar3_2f">
                                                    <option <?= $pil3['pilar3_2f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</center>
                                            <center><?= $pembanding_pil3['pilar3_2f'] ?></center>
                                            <br></br>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil3_2f" form="my_form" name="ket_in_stra_pil3_2f" cols="35" rows="5"><?= $ketpil3['ket_in_stra_pil3_2f'] ?></textarea>
                                            <span id="penghitung-karakter41"><?= $length3['l41'] ?></span><span> / 500</span></td>
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
                                            Evaluasi Isu Stratejik Akibat Perubahan Lingkungan Bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan Inventarisasi Setiap Bulan
                                            <td>
                                            <b>(2)</b> Dilakukan Inventarisasi Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan InventarisasiSetiap Semester
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan Inventarisasi Setiap Tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan  Inventarisasi
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil4_1a" form="my_form" name="ket_in_stra_pil4_1a" cols="35" rows="5"><?= $ketpil4['ket_in_stra_pil4_1a'] ?></textarea>
                                            <span id="penghitung-karakter42"><?= $length4['l42'] ?></span><span> / 500</span></td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Evaluasi Capaian Target RBB
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan Setiap Minggu
                                            <td>
                                            <b>(2)</b> Dilakukan Setiap Tengah Bulan
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan Setiap 1 (satu) bulan
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan Setiap > 1 (satu) bulan
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan evaluasi
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
                                            <textarea class="form-control" maxlength="500" id="ket_in_stra_pil4_1c" form="my_form" name="ket_in_stra_pil4_1c" cols="35" rows="5"><?= $ketpil4['ket_in_stra_pil4_1c'] ?></textarea>
                                            <span id="penghitung-karakter43"><?= $length4['l43'] ?></span><span> / 500</span></td>
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