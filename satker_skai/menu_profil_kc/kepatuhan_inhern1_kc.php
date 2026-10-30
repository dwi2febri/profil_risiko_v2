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
CHAR_LENGTH(ket_in_kep_pil1_1) AS l1,
CHAR_LENGTH(ket_in_kep_pil1_1a) AS l2,
CHAR_LENGTH(ket_in_kep_pil1_1f) AS l3,
CHAR_LENGTH(ket_in_kep_pil1_1g) AS l4,
CHAR_LENGTH(ket_in_kep_pil1_2) AS l5,
CHAR_LENGTH(ket_in_kep_pil1_2b) AS l6,
CHAR_LENGTH(ket_in_kep_pil1_2c) AS l7 FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$id]));

$length2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_kep_pil2_1) AS l8,
CHAR_LENGTH(ket_in_kep_pil2_1a) AS l9,
CHAR_LENGTH(ket_in_kep_pil2_2) AS l10,
CHAR_LENGTH(ket_in_kep_pil2_2a) AS l11,
CHAR_LENGTH(ket_in_kep_pil2_3) AS l12,
CHAR_LENGTH(ket_in_kep_pil2_3a) AS l13 FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$id]));

$length3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT 
CHAR_LENGTH(ket_in_kep_pil3_1b) AS l14,
CHAR_LENGTH(ket_in_kep_pil3_1c) AS l15 FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$id]));

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$dp]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_kepatuhan WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko = ?", [$id]));
$ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko = ?", [$id]));
$ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko = ?", [$id]));

//setingan ditetapkan
$set_pil1_par1 = $inheren['inheren_kep_set_pil1_par1'];
$set_pil1_par2 = $inheren['inheren_kep_set_pil1_par2'];
$set_pil1 = $inheren['inheren_kep_set_pil1'];
$set_pil2_par1 = $inheren['inheren_kep_set_pil2_par1'];
$set_pil2_par2 = $inheren['inheren_kep_set_pil2_par2'];
$set_pil2_par3 = $inheren['inheren_kep_set_pil2_par3'];
$set_pil2 = $inheren['inheren_kep_set_pil2'];
$set_pil3_par1 = $inheren['inheren_kep_set_pil3_par1'];
$set_tingkat_risiko = $inheren['inheren_kep_set_tingkat_risiko'];


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
        $pilar1_1g = $_POST['pilar1_1g'];

        $pilar1_2 = $_POST['pilar1_2'];
        $pilar1_2a = $_POST['pilar1_2a'];
        $pilar1_2b = $_POST['pilar1_2b'];
        $pilar1_2c = $_POST['pilar1_2c'];
        $pilar1_2d = $_POST['pilar1_2d'];
        $pilar1_2e = $_POST['pilar1_2e'];
        $pilar1_2f = $_POST['pilar1_2f'];
        $pilar1_2g = $_POST['pilar1_2g'];
        $pilar1_2h = $_POST['pilar1_2h'];
        

        //pilar 1 1
        $hsl_max_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1f, $pilar1_1g);
        $max_pil1_1 = max($hsl_max_pil1_1);
    
        $hsl_min_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1f, $pilar1_1g);
        $min_pil1_1 = min($hsl_min_pil1_1);
    
        $hsl_avg_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1f, $pilar1_1g);
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
        $hsl_max_pil1_2 = array($pilar1_2, $pilar1_2b, $pilar1_2c);
        $max_pil1_2 = max($hsl_max_pil1_2);
    
        $hsl_min_pil1_2 = array($pilar1_2, $pilar1_2b, $pilar1_2c);
        $min_pil1_2 = min($hsl_min_pil1_2);
    
        $hsl_avg_pil1_2 = array($pilar1_2, $pilar1_2b, $pilar1_2c);
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

        $ket_in_kep_pil1_1 = $_POST['ket_in_kep_pil1_1'];
        $ket_in_kep_pil1_1a = $_POST['ket_in_kep_pil1_1a'];
        $ket_in_kep_pil1_1b = $_POST['ket_in_kep_pil1_1b'];
        $ket_in_kep_pil1_1c = $_POST['ket_in_kep_pil1_1c'];
        $ket_in_kep_pil1_1d = $_POST['ket_in_kep_pil1_1d'];
        $ket_in_kep_pil1_1e = $_POST['ket_in_kep_pil1_1e'];
        $ket_in_kep_pil1_1f = $_POST['ket_in_kep_pil1_1f'];
        $ket_in_kep_pil1_1g = $_POST['ket_in_kep_pil1_1g'];

        $ket_in_kep_pil1_2 = $_POST['ket_in_kep_pil1_2'];
        $ket_in_kep_pil1_2a = $_POST['ket_in_kep_pil1_2a'];
        $ket_in_kep_pil1_2b = $_POST['ket_in_kep_pil1_2b'];
        $ket_in_kep_pil1_2c = $_POST['ket_in_kep_pil1_2c'];
        $ket_in_kep_pil1_2d = $_POST['ket_in_kep_pil1_2d'];
        $ket_in_kep_pil1_2e = $_POST['ket_in_kep_pil1_2e'];
        $ket_in_kep_pil1_2f = $_POST['ket_in_kep_pil1_2f'];
        $ket_in_kep_pil1_2g = $_POST['ket_in_kep_pil1_2g'];
        $ket_in_kep_pil1_2h = $_POST['ket_in_kep_pil1_2h'];





        //pilar 2
        $pilar2_1 = $_POST['pilar2_1'];
        $pilar2_1a = $_POST['pilar2_1a'];
        $pilar2_2 = $_POST['pilar2_2'];
        $pilar2_2a = $_POST['pilar2_2a'];
        $pilar2_3 = $_POST['pilar2_3'];
        $pilar2_3a = $_POST['pilar2_3a'];
        


        //pilar 2 1
        $hsl_max_pil2_1 = array($pilar2_1);
        $max_pil2_1 = max($hsl_max_pil2_1);
    
        $hsl_min_pil2_1 = array($pilar2_1);
        $min_pil2_1 = min($hsl_min_pil2_1);
    
        $hsl_avg_pil2_1 = array($pilar2_1);
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
        $hsl_max_pil2_2 = array($pilar2_2, $pilar2_2a);
        $max_pil2_2 = max($hsl_max_pil2_2);
    
        $hsl_min_pil2_2 = array($pilar2_2, $pilar2_2a);
        $min_pil2_2 = min($hsl_min_pil2_2);
    
        $hsl_avg_pil2_2 = array($pilar2_2, $pilar2_2a);
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


        //pilar 2 3
        $hsl_max_pil2_3 = array($pilar2_3, $pilar2_3a);
        $max_pil2_3 = max($hsl_max_pil2_3);
    
        $hsl_min_pil2_3 = array($pilar2_3, $pilar2_3a);
        $min_pil2_3 = min($hsl_min_pil2_3);
    
        $hsl_avg_pil2_3 = array($pilar2_3, $pilar2_3a);
        $sum_pil2_3 = array_sum($hsl_avg_pil2_3);
        $average_pil2_3 = $sum_pil2_3 / count($hsl_avg_pil2_3);


        if ($set_pil2_par3 == 1) {

            $hasil_pil2_par3 = $max_pil2_3;
        } else if ($set_pil2_par3 == 2) {
    
            $hasil_pil2_par3 = $min_pil2_3;
        } else if ($set_pil2_par3 == 3) {
    
            $hasil_pil2_par3 = $average_pil2_3;
        } else {
        $hasil_pil2_par3 = 0;
        }


        //HASIL PILAR 1
        $hsl_max_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2, $hasil_pil2_par3);
        $pil2_tertinggi = max($hsl_max_pilar2);

        $hsl_min_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2, $hasil_pil2_par3);
        $pil2_terendah = min($hsl_min_pilar2);

        $hsl_avg_pilar2 = array($hasil_pil2_par1, $hasil_pil2_par2, $hasil_pil2_par3);
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





        $ket_in_kep_pil2_1 = $_POST['ket_in_kep_pil2_1'];
        $ket_in_kep_pil2_1a = $_POST['ket_in_kep_pil2_1a'];
        
        $ket_in_kep_pil2_2 = $_POST['ket_in_kep_pil2_2'];
        $ket_in_kep_pil2_2a = $_POST['ket_in_kep_pil2_2a'];

        $ket_in_kep_pil2_3 = $_POST['ket_in_kep_pil2_3'];
        $ket_in_kep_pil2_3a = $_POST['ket_in_kep_pil2_3a'];



        //pilar 3
        $pilar3_1a = $_POST['pilar3_1a'];
        $pilar3_1b = $_POST['pilar3_1b'];
        $pilar3_1c = $_POST['pilar3_1c'];
        $pilar3_1d = $_POST['pilar3_1d'];
        $pilar3_1e = $_POST['pilar3_1e'];
        $pilar3_1f = $_POST['pilar3_1f'];
        $pilar3_1g = $_POST['pilar3_1g'];
       

        //pilar 3 1
        $hsl_max_pil3_1 = array( $pilar3_1b, $pilar3_1c);
        $max_pil3_1 = max($hsl_max_pil3_1);
    
        $hsl_min_pil3_1 = array( $pilar3_1b, $pilar3_1c);
        $min_pil3_1 = min($hsl_min_pil3_1);
    
        $hsl_avg_pil3_1 = array( $pilar3_1b, $pilar3_1c);
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



        
        $ket_in_kep_pil3_1a = $_POST['ket_in_kep_pil3_1a'];
        $ket_in_kep_pil3_1b = $_POST['ket_in_kep_pil3_1b'];
        $ket_in_kep_pil3_1c = $_POST['ket_in_kep_pil3_1c'];
        $ket_in_kep_pil3_1d = $_POST['ket_in_kep_pil3_1d'];
        $ket_in_kep_pil3_1e = $_POST['ket_in_kep_pil3_1e'];
        $ket_in_kep_pil3_1f = $_POST['ket_in_kep_pil3_1f'];
        $ket_in_kep_pil3_1g = $_POST['ket_in_kep_pil3_1g'];
        




      



        //HASIL INHEREN
        $hsl_max_inheren= array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1);
        $hasil_inheren_tertinggi = max($hsl_max_inheren);
    
        $hsl_min_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1);
        $hasil_inheren_terendah = min($hsl_min_inheren);
    
        $hsl_avg_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1);
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



    simpro_db_query($conn, "UPDATE inheren_kepatuhan_pilar1 SET 
        pilar1_1 = ?,
        pilar1_1a = ?,
        pilar1_1b = ?,
        pilar1_1c = ?,
        pilar1_1d = ?,
        pilar1_1e = ?,
        pilar1_1f = ?,
        pilar1_1g = ?,
        pilar1_2 = ?,
        pilar1_2a = ?,
        pilar1_2b = ?,
        pilar1_2c = ?,
        pilar1_2d = ?,
        pilar1_2e = ?,
        pilar1_2f = ?,
        pilar1_2g = ?,
        pilar1_2h = ?,
        average_pil1_1 = ?,
        average_pil1_2 = ?,
        min_pil1_1 = ?,
        min_pil1_2 = ?,
        max_pil1_1 = ?,
        max_pil1_2 = ?,
        hasil_pil1_par1 = ?,
        hasil_pil1_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d, $pilar1_1e, $pilar1_1f, $pilar1_1g, $pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_2c, $pilar1_2d, $pilar1_2e, $pilar1_2f, $pilar1_2g, $pilar1_2h, $average_pil1_1, $average_pil1_2, $min_pil1_1, $min_pil1_2, $max_pil1_1, $max_pil1_2, $hasil_pil1_par1, $hasil_pil1_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_kepatuhan_pilar2 SET 
        pilar2_1 = ?,
        pilar2_1a = ?,
        pilar2_2 = ?,
        pilar2_2a = ?,
        pilar2_3 = ?,
        pilar2_3a = ?,
        average_pil2_1 = ?,
        average_pil2_2 = ?,
        average_pil2_3 = ?,
        min_pil2_1 = ?,
        min_pil2_2 = ?,
        min_pil2_3 = ?,
        max_pil2_1 = ?,
        max_pil2_2 = ?,
        max_pil2_3 = ?,
        hasil_pil2_par1 = ?,
        hasil_pil2_par2 = ?,
        hasil_pil2_par3 = ?
    WHERE id_profil_risiko = ?", [$pilar2_1, $pilar2_1a, $pilar2_2, $pilar2_2a, $pilar2_3, $pilar2_3a, $average_pil2_1, $average_pil2_2, $average_pil2_3, $min_pil2_1, $min_pil2_2, $min_pil2_3, $max_pil2_1, $max_pil2_2, $max_pil2_3, $hasil_pil2_par1, $hasil_pil2_par2, $hasil_pil2_par3, $id]);

    simpro_db_query($conn, "UPDATE inheren_kepatuhan_lainnya SET 
        pilar3_1a = ?,
        pilar3_1b = ?,
        pilar3_1c = ?,
        pilar3_1d = ?,
        pilar3_1e = ?,
        pilar3_1f = ?,
        pilar3_1g = ?,
        average_pil3_1 = ?,
        min_pil3_1 = ?,
        max_pil3_1 = ?,
        hasil_pil3_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $average_pil3_1, $min_pil3_1, $max_pil3_1, $hasil_pil3_par1, $id]);

   




    simpro_db_query($conn, "UPDATE hasil_inheren_kepatuhan SET 
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
        hasil_inheren_tertinggi = ?,
        hasil_inheren_terendah = ?,
        hasil_inheren_rata_rata = ?,
        hasil_risiko_ditetapkan = ?,
        hasil_tingkat_risiko = ?,
        hasil_peringkat = ?
    WHERE id_profil_risiko = ?", [$pil1_tertinggi, $pil1_terendah, $pil1_rata_rata, $set_pil1, $pil1_tingkat_risiko, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $set_pil2, $pil2_tingkat_risiko, $max_pil3_1, $min_pil3_1, $average_pil3_1, $set_pil3_par1, $hasil_pil3_par1, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata, $set_tingkat_risiko, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

    //kalimat

    simpro_db_query($conn, "UPDATE ket_inheren_kepatuhan_pilar1 SET 
        ket_in_kep_pil1_1 = ?,
        ket_in_kep_pil1_1a = ?,
        ket_in_kep_pil1_1b = ?,
        ket_in_kep_pil1_1c = ?,
        ket_in_kep_pil1_1d = ?,
        ket_in_kep_pil1_1e = ?,
        ket_in_kep_pil1_1f = ?,
        ket_in_kep_pil1_1g = ?,
        ket_in_kep_pil1_2 = ?,
        ket_in_kep_pil1_2a = ?,
        ket_in_kep_pil1_2b = ?,
        ket_in_kep_pil1_2c = ?,
        ket_in_kep_pil1_2d = ?,
        ket_in_kep_pil1_2e = ?,
        ket_in_kep_pil1_2f = ?,
        ket_in_kep_pil1_2g = ?,
        ket_in_kep_pil1_2h = ?
    WHERE id_profil_risiko = ?", [$ket_in_kep_pil1_1, $ket_in_kep_pil1_1a, $ket_in_kep_pil1_1b, $ket_in_kep_pil1_1c, $ket_in_kep_pil1_1d, $ket_in_kep_pil1_1e, $ket_in_kep_pil1_1f, $ket_in_kep_pil1_1g, $ket_in_kep_pil1_2, $ket_in_kep_pil1_2a, $ket_in_kep_pil1_2b, $ket_in_kep_pil1_2c, $ket_in_kep_pil1_2d, $ket_in_kep_pil1_2e, $ket_in_kep_pil1_2f, $ket_in_kep_pil1_2g, $ket_in_kep_pil1_2h, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_kepatuhan_pilar2 SET 
        ket_in_kep_pil2_1 = ?,
        ket_in_kep_pil2_1a = ?,
        ket_in_kep_pil2_2 = ?,
        ket_in_kep_pil2_2a = ?,
        ket_in_kep_pil2_3 = ?,
        ket_in_kep_pil2_3a = ?
    WHERE id_profil_risiko = ?", [$ket_in_kep_pil2_1, $ket_in_kep_pil2_1a, $ket_in_kep_pil2_2, $ket_in_kep_pil2_2a, $ket_in_kep_pil2_3, $ket_in_kep_pil2_3a, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_kepatuhan_lainnya SET 
        ket_in_kep_pil3_1a = ?,
        ket_in_kep_pil3_1b = ?,
        ket_in_kep_pil3_1c = ?,
        ket_in_kep_pil3_1d = ?,
        ket_in_kep_pil3_1e = ?,
        ket_in_kep_pil3_1f = ?,
        ket_in_kep_pil3_1g = ?
    WHERE id_profil_risiko = ?", [$ket_in_kep_pil3_1a, $ket_in_kep_pil3_1b, $ket_in_kep_pil3_1c, $ket_in_kep_pil3_1d, $ket_in_kep_pil3_1e, $ket_in_kep_pil3_1f, $ket_in_kep_pil3_1g, $id]);


    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kep_inhern1&id=$id");
    exit();
}
?>





<script>


        $(document).ready(function() {
            $('#ket_in_kep_pil1_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter2').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_1f').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter3').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_1g').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter4').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter5').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_2b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter6').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil1_2c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter7').text(charCount);
            });
        });



        $(document).ready(function() {
            $('#ket_in_kep_pil2_1').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter8').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil2_1a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter9').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil2_2').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter10').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil2_2a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter11').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil2_3').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter12').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil2_3a').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter13').text(charCount);
            });
        });




        $(document).ready(function() {
            $('#ket_in_kep_pil3_1b').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter14').text(charCount);
            });
        });
        $(document).ready(function() {
            $('#ket_in_kep_pil3_1c').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter15').text(charCount);
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

                        <h4 class="page-title">Risiko kepatuhan Inheren 1 [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Isian Kertas Kerja Risiko Inheren 1 Profil Risiko kepatuhan</h4>

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
                                                    <center><b>RISIKO KEPATUHAN INHEREN 1</b></center>
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
                                                PENILAIAN PERIODE SEBELUMNYA</br>
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
                                                    <b>PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Jenis dan SIgnifikasi Pelanggaran
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat pelanggaran thd ketentuan peraturan perundang-undangan dan/ketentuan lain pada periode penilaian
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat pelanggaran thd ketentuan peraturan perundang-undangan  dengan jenis sanksi ringan dan Frekuensi pelanggaran rendah
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat pelanggaran thd ketentuan peraturan perundang-undangan  dengan jenis sanksi ringan dan Frekuensi pelanggaran sedang
                                            </td>
                                            <td>
                                            <b>(4)</b> </br>• Terdapat pelanggaran thd ketentuan peraturan perundang-undangan  dengan jenis sanksi ringan dengan frekuensi pelanggaran tinggi
                                            </br>• Terdapat dugaan pelanggaran terhadap Undang- Undang Perbankan antara  lain pasal 49 yang dilakukan oleh pejabat atau pegawai BPR.
                                            </td>
                                            <td>
                                            <b>(5)</b> </br>• Terdapat pelanggaran dengan  sanksi berat  dan jenis pelanggaran signifikan; dan/atau
                                            </br>• Terdapat dugaan pelanggaran terhadap Undang- Undang Perbankan antara lain pasal 49 yang dilakukan oleh anggota Direksi dan/atau Dewan Komisaris BPR.
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_1'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_1" form="my_form" name="ket_in_kep_pil1_1" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_1'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length1['l1'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                                <center></center>
                                            </th>
                                            <th>
                                            Frekuensi Pelanggaran
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terjadi pelanggaran
                                            </td>
                                            <td>
                                            <b>(2)</b> Terjadi pelanggaran dengan frekuensi sangat rendah dan tidak berdampak pada kerugian financial, tuntutan hukum dan reputasi
                                            </br></br>Frekuensi sangat rendah ditentukan dari periode sebesar kurang dari 0,5 % jumlah SDM
                                            </td>
                                            <td>
                                            <b>(3)</b> Terjadi penyimpangan dengan frekuensi rendah dan tidak berdampak pada kerugian financial dan tuntutan hukum
                                            </br></br>Frekuensi rendah ditentukan sebesar 0,50 - 0,75 % dari jumlah SDM
                                            </td>
                                            <td>
                                            <b>(4)</b> Terjadi penyimpangan dengan frekuensi sedang dan berdampak pada kerugian financial yang signifikan
                                            </br></br>Frekuensi sedang ditentukan sebesar 0,75 - 1 % dari jumlah SDM
                                            </td>
                                            <td>
                                            <b>(5)</b> Terjadi penyimpangan dengan frekuensi tinggi dan berdampak pada kerugian financial, tuntutan hukum dan reputasi
                                            </br></br>Frekuensi tinggi ditentukan sebesar lebih dari 1 % jumlah SDM
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
                                            <td>
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_1a'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_1a" form="my_form" name="ket_in_kep_pil1_1a" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_1a'] ?></textarea>
                                            <span id="penghitung-karakter2"><?= $length1['l2'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                       


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Frekuensi Pelanggaran Ketentuan Internal dan Prosedur
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat Pelanggaran dengan Jumlah Maksimal < 50% dari Jumlah Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Pelanggaran dengan Jumlah Maksimal 50% dari Jumlah Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Pelanggaran dengan Jumlah Maksimal 60% dari Jumlah Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Pelanggaran dengan Jumlah Maksimal 80% dari Jumlah Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Pelanggaran dengan Jumlah Maksimal > 80% dari Jumlah Pelanggaran Tahun Sebelumnya
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_1f'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_1f" form="my_form" name="ket_in_kep_pil1_1f" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_1f'] ?></textarea>
                                            <span id="penghitung-karakter3"><?= $length1['l3'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Sebaran Jenis Pelanggaran Ketentuan Internal dan Prosedur
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat Sebaran Jenis Pelanggaran Maksimal < 50% dari Jumlah Sebaran Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Sebaran Jenis Pelanggaran Maksimal 50% dari Jumlah Sebaran Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Sebaran Jenis Pelanggaran Maksimal 60% dari Jumlah Sebaran Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Sebaran Jenis Pelanggaran Maksimal 80% dari Jumlah Sebaran Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Sebaran Jenis Pelanggaran Maksimal 100% dari Jumlah Sebaran Pelanggaran Tahun Sebelumnya
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar1_1g" form="my_form" name="pilar1_1g">
                                                    <option <?= $pil1['pilar1_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1g'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1g'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1g'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1g'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1g'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_1g'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_1g" form="my_form" name="ket_in_kep_pil1_1g" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_1g'] ?></textarea>
                                            <span id="penghitung-karakter4"><?= $length1['l4'] ?></span><span> / 500</span></td>
                                        </tr>
                                        

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Signifikasi Tindak Lanjut Atas Temuan Pelanggaran
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat pelanggaran berulang,  dan pelanggaran  di periode sebelumnya</br> sudah  selesai ditindaklanjuti.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat pelanggaran berulang  pada dua periode sebelumnya</br> dengan  jenis yang  sama namun terdapat penurunan frekuensi  yang tinggi dibandingkan periode sebelumnya</br>.

                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat pelanggaran berulang  pada dua periode sebelumnya</br> dengan  jenis yang  sama namun terdapat penurunan frekuensi  yang sedang dibandingkan periode sebelumnya</br>.

                                            </td>
                                            <td>
                                            <b>(4)</b> "Terdapat pelanggaran berulang  pada dua periode sebelumnya</br> dengan  jenis yang  sama namun terdapat penurunan frekuensi  yang rendah dibandingkan periode sebelumnya</br>."
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat pelanggaran berulang  pada dua periode sebelumnya</br> dengan  jenis yang  sama dengan frekuensi lebih banyak
                                            dari periode sebelumnya</br>; dan/atau Terdapat pelanggaran berulang yang merupakan pelanggaran yang  bersifat signifikan antara lain terhadap ketentuan  BMPK,   jumlah minimal pengurus, dan permodalan.
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_2'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_2" form="my_form" name="ket_in_kep_pil1_2" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_2'] ?></textarea>
                                            <span id="penghitung-karakter5"><?= $length1['l5'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pengembangan Budaya Patuh Pada Semua Jenjang Organisasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan Sosialisasi, Diskusi, dan Pendampingan Pada >60% dari Jumlah Kantor Cabang/Unit Kerja
                                            </td>
                                            <td>
                                            <b>(2)</b> Dilakukan Sosialisasi, Diskusi, dan Pendampingan Pada 60% dari Jumlah Kantor Cabang/Unit Kerja
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan Sosialisasi, Diskusi, dan Pendampingan Pada 50% dari Jumlah Kantor Cabang/Unit Kerja
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan Sosialisasi, Diskusi, dan Pendampingan Pada < 50% dari Jumlah Kantor Cabang/Unit Kerja
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Dilakukan Sosialisasi, Diskusi, dan Pendampingan Pada Kantor Cabang/Unit Kerja
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_2b'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_2b" form="my_form" name="ket_in_kep_pil1_2b" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_2b'] ?></textarea>
                                            <span id="penghitung-karakter6"><?= $length1['l6'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Implementasi Kebijakan dan Prosedur Penerbitan Produk dan/atau Pelaksanaan Aktivitas Baru
                                            </th>
                                            <td>
                                            <b>(1)</b> Melakukan Review Eksposure Risiko yang Melekat Secara Berkala Setiap Semester Melakukan Review Terhadap Seluruh Risiko Pada Pelaksanaan Produk dan Aktivitas Baru dan Melakukan Uji Coba Terhadap Metode Pengukuran Risiko Setiap 6 Bulan Sekali
                                            </td>
                                            <td>
                                            <b>(2)</b> Melakukan Review Eksposure Risiko yang Melekat Secara Berkala Setiap Tahun Melakukan Review Terhadap Seluruh Risiko Pada Pelaksanaan Produk dan Aktivitas Baru dan Melakukan Uji Coba Terhadap Metode Pengukuran Risiko Setiap 6 Bulan Sekali
                                            </td>
                                            <td>
                                            <b>(3)</b> Melakukan Review Eksposure Risiko yang Melekat Secara Berkala Setiap 1,5 Tahun Melakukan Review Terhadap Seluruh Risiko Pada Pelaksanaan Produk dan Aktivitas Baru dan Melakukan Uji Coba Terhadap Metode Pengukuran Risiko Setiap Setahun Sekali
                                            </td>
                                            <td>
                                            <b>(4)</b> Melakukan Review Eksposure Risiko yang Melekat Secara Berkala Setiap > 1,5 Tahun Melakukan Review Terhadap Seluruh Risiko Pada Pelaksanaan Produk dan Aktivitas Baru dan Melakukan Uji Coba Terhadap Metode Pengukuran Risiko Setiap > 1 (satu) tahun Sekali
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan Review Eksposure Risiko yang Melekat Secara Berkala
                                            Tidak dilakukan Review Terhadap Seluruh Risiko Pada Pelaksanaan Produk dan Aktivitas Baru dan Tidak dilakukan Uji Coba Terhadap Metode Pengukuran Risiko
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil1['pilar1_2c'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil1_2c" form="my_form" name="ket_in_kep_pil1_2c" cols="35" rows="5"><?= $ketpil1['ket_in_kep_pil1_2c'] ?></textarea>
                                            <span id="penghitung-karakter7"><?= $length1['l7'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>



                                       
<!--pilar2-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="10">
                                                <h4>
                                                    <b>PILAR 2 : Faktor Kelemahan Aspek Hukum</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Kelemahan Dalam Perikatan
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat perjanjian kredit atau kerja sama lain yang memenuhi syarat  sah perjanjian; dan Tidak terdapat kelemahan dalam klausula perjanjian.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat perjanjian kredit atau kerja sama lain yang memenuhi syarat  sah perjanjian; dan/atau
                                            Terdapat kelemahan dalam klausula perjanjian dan menyebabkan tidak dapat dilaksanakannya klausula dalam perjanjian namun tidak berpotensi menimbulkan gugatan hukum dan kerugian yang  material.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat perjanjian kredit atau kerja sama lain yang memenuhi syarat  sah perjanjian; dan/atau
                                            Terdapat kelemahan dalam klausula perjanjian yang berpotensi menimbulkan gugatan hukum dan/atau kerugian yang material.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat perjanjian kredit  atau kerja sama lain yang tidak memenuhi syarat   sah perjanjian; dan/atau
                                            Terdapat kelemahan dalam klausula perjanjian yang berpotensi menimbulkan gugatan  hukum dan/atau kerugian yang sangat material.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat pemberian kredit atau kerja sama lain yang tidak didukung  dengan perjanjian tertulis.
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil2['pilar2_1'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil2_1" form="my_form" name="ket_in_kep_pil2_1" cols="35" rows="5"><?= $ketpil2['ket_in_kep_pil2_1'] ?></textarea>
                                            <span id="penghitung-karakter8"><?= $length2['l8'] ?></span><span> / 500</span></td>
                                        </tr>

                                      

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat gugatan  atau tidak terdapat estimasi kerugian  yang dialami BPR akibat gugatan.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat nominal gugatan atau estimasi kerugian   akibat gugatan  dengan nilai    tidak signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat nominal gugatan atau estimasi kerugian   akibat gugatan  dengan nilai  kurang signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat nominal gugatan atau estimasi kerugian   akibat gugatan  dengan nilai   cukup signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat nominal gugatan atau estimasi kerugian akibat gugatan yang menyebabkan permodalan menurun di bawah ketentuan KPMM
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
                                            <center>Periode sebelumnya</br>
                                                <?= $pembanding_pil2['pilar2_2'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil2_2" form="my_form" name="ket_in_kep_pil2_2" cols="35" rows="5"><?= $ketpil2['ket_in_kep_pil2_2'] ?></textarea>
                                            <span id="penghitung-karakter10"><?= $length2['l10'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pendampingan Hukum
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah bekerjasama dalam  pendampingan hukum atau (legal asistant), penanganan litigasi dan pemberian pendapat hukum yang sangat cakap
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah bekerjasama dalam  pendampingan hukum atau (legal asistant), penanganan litigasi dan pemberian pendapat hukum yang cakap
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah bekerjasama dalam  pendampingan hukum atau (legal asistant), penanganan litigasi , memberikan pendapat hukum secara terbatas
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank telah bekerjasama dalam  pendampingan hukum atau (legal asistant) namun belum ada tindakan perbaikan penyelesaian permasalahan hukum
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak bekerjasama dalam pendampingan hukum (legal asistant)
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil2['pilar2_2a'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil2_2a" form="my_form" name="ket_in_kep_pil2_2a" cols="35" rows="5"><?= $ketpil2['ket_in_kep_pil2_2a'] ?></textarea>
                                            <span id="penghitung-karakter11"><?= $length2['l11'] ?></span><span> / 500</span></td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>3</center>
                                            </th>
                                            <th>
                                            Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat gugatan  atau tidak terdapat estimasi kerugian  yang dialami BPR akibat gugatan.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat nominal gugatan atau estimasi kerugian akibat gugatan dengan nilai tidak signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat nominal gugatan atau estimasi kerugian akibat gugatan dengan nilai  kurang signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat nominal gugatan atau estimasi kerugian akibat gugatan dengan nilai   cukup signifikan dibanding modal BPR.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat nominal gugatan atau estimasi kerugian akibat gugatan yang menyebabkan permodalan menurun di bawah ketentuan KPMM
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_3" form="my_form" name="pilar2_3">
                                                    <option <?= $pil2['pilar2_3'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_3'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_3'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_3'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_3'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_3'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil2['pilar2_3'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil2_3" form="my_form" name="ket_in_kep_pil2_3" cols="35" rows="5"><?= $ketpil2['ket_in_kep_pil2_3'] ?></textarea>
                                            <span id="penghitung-karakter12"><?= $length2['l12'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kerugian Akibat Putusan Pengadilan Berkekuatan Hukum Tetap
                                            </th>
                                            <td>
                                            <b>(1)</b> Paling Banyak < 2% dari Jumlah Modal
                                            </td>
                                            <td>
                                            <b>(2)</b> Paling Banyak 2% dari Jumlah Modal
                                            </td>
                                            <td>
                                            <b>(3)</b> Paling Banyak 2,5% dari Jumlah Modal
                                            </td>
                                            <td>
                                            <b>(4)</b> Paling Banyak 3% dari Jumlah Modal
                                            </td>
                                            <td>
                                            <b>(5)</b> Paling Banyak > 3% dari Jumlah Modal
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar2_3a" form="my_form" name="pilar2_3a">
                                                    <option <?= $pil2['pilar2_3a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_3a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_3a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_3a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_3a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_3a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil2['pilar2_3a'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil2_3a" form="my_form" name="ket_in_kep_pil2_3a" cols="35" rows="5"><?= $ketpil2['ket_in_kep_pil2_3a'] ?></textarea>
                                            <span id="penghitung-karakter13"><?= $length2['l13'] ?></span><span> / 500</span></td>
                                        </tr>

                                        
<!--pilar lainnya-->
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
                                            Komitmen Capaian Target RBB
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat Deviasi Paling Banyak < 10%
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Deviasi Paling Banyak 10%
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Deviasi Paling Banyak 15%
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Deviasi Paling Banyak 20%
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Deviasi Paling Banyak >20%
                                            </td>
                                            <td>
                                            <center>Penilaian</center>
                                                <select class="form-select" id="pilar3_1b" form="my_form" name="pilar3_1b">
                                                    <option <?= $pil3['pilar3_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </td>
                                            <td width="5%">
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil3['pilar3_1b'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil3_1b" form="my_form" name="ket_in_kep_pil3_1b" cols="35" rows="5"><?= $ketpil3['ket_in_kep_pil3_1b'] ?></textarea>
                                            <span id="penghitung-karakter14"><?= $length3['l14'] ?></span><span> / 500</span></td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Teladan Pucuk Pimpinan
                                            </th>
                                            <td>
                                            <b>(1)</b> Pucuk Pimpinan Memiliki Sikap, Perilaku, Kompetensi dan Komitmen Melebihi Kualifikasi
                                            </td>
                                            <td>
                                            <b>(2)</b> Pucuk Pimpinan Memiliki Sikap, Perilaku, Kompetensi dan Komitmen Sesuai Kualifikasi
                                            </td>
                                            <td>
                                            <b>(3)</b> Pucuk Pimpinan Memiliki Sikap, Perilaku, Kompetensi, dan Komitmen
                                            </td>
                                            <td>
                                            <b>(4)</b> Pucuk Pimpinan Memiliki 2 jenis teladan dari (Sikap, Perilaku, Kompetensi, dan Komitmen)
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak adanya teladan pucuk pimpinan
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
                                            <center>Periode sebelumnya</br>
                                            <?= $pembanding_pil3['pilar3_1c'] ?>
                                            </center>
                                            </td>
                                            <td>
                                            <textarea class="form-control" maxlength="500" id="ket_in_kep_pil3_1c" form="my_form" name="ket_in_kep_pil3_1c" cols="35" rows="5"><?= $ketpil3['ket_in_kep_pil3_1c'] ?></textarea>
                                            <span id="penghitung-karakter15"><?= $length3['l15'] ?></span><span> / 500</span></td>
                                            
                                           

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