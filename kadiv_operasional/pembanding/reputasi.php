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

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$id]));


$div_skmr_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));


$div_sekper_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$div_skk_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$div_sekper_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));

$div_sekper_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$div_skai_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));
$div_skk_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));



$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$dp]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_reputasi WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = ?", [$id]));
$ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = ?", [$id]));
$ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = ?", [$id]));
$ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = ?", [$id]));


$div_skmr_ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));

$div_sekper_ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$div_skk_ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$div_sekper_ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));

$div_sekper_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));
$div_skai_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 143", [$tahun, $periode]));
$div_skk_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_reputasi_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));



$div_skmr_ket_inhern_reputasi = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skk_ket_inhern_reputasi = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));
$div_sekper_ket_inhern_reputasi = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_reputasi INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_reputasi.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 136", [$tahun, $periode]));


$ket_inhern_reputasi = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_reputasi WHERE id_profil_risiko = ?", [$id]));


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
        $hsl_max_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d);
        $max_pil1_1 = max($hsl_max_pil1_1);
    
        $hsl_min_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d);
        $min_pil1_1 = min($hsl_min_pil1_1);
    
        $hsl_avg_pil1_1 = array($pilar1_1, $pilar1_1a, $pilar1_1b, $pilar1_1c, $pilar1_1d);
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
        $hsl_max_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d);
        $max_pil2_1 = max($hsl_max_pil2_1);
    
        $hsl_min_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d);
        $min_pil2_1 = min($hsl_min_pil2_1);
    
        $hsl_avg_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d);
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
        $hsl_max_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c);
        $max_pil3_1 = max($hsl_max_pil3_1);
    
        $hsl_min_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c);
        $min_pil3_1 = min($hsl_min_pil3_1);
    
        $hsl_avg_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c);
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



        //pilar 3 2
        $hsl_max_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b);
        $max_pil3_2 = max($hsl_max_pil3_2);

        $hsl_min_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b);
        $min_pil3_2 = min($hsl_min_pil3_2);

        $hsl_avg_pil3_2 = array($pilar3_2, $pilar3_2a, $pilar3_2b);
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
    WHERE id_profil_risiko = ?", [$pil1_tertinggi, $pil1_terendah, $pil1_rata_rata, $set_pil1, $pil1_tingkat_risiko, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $set_pil2, $pil2_tingkat_risiko, $pil3_tertinggi, $pil3_terendah, $pil3_rata_rata, $set_pil3, $pil3_tingkat_risiko, $max_pil4_1, $min_pil4_1, $average_pil4_1, $set_pil4_par1, $hasil_pil4_par1, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata, $set_tingkat_risiko, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

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

    header("Location: index.php?page=pembanding_reputasi&id=$id");
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

                        <h4 class="page-title">Risiko Reputasi Inhern [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #02c3c9; color: white;">

                            <h4 class="page-title">Risiko Reputasi Inheren</h4>
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
                            <h4 class="header-title">Menu Pembanding Inheren Reputasi Usulan SKMR dengan Usulan Divisi</h4>

                            <hr>
                            </hr>





                            </br>


                            <!-- kredit-->
                            <div class="table-responsive">
                                <table class="table table-bordered table-top mb-0" >
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="11">
                                                <h4>
                                                    <center><b>RISIKO REPUTASI INHEREN (SKMR DAN DIVISI)</b></center>
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
                                                PENILAIAN PEMBANDING
                                            </th>
                                            <th class="text-center" width="5%" rowspan="2">
                                                PENILAIAN KONSOL
                                            </th>
                                            <th class="text-center" width="20%"  rowspan="2">
                                                KETERANGAN
                                            </th>
                                            <th class="text-center" width="5%"  rowspan="2">
                                                STATUS
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
                                            <td colspan="11">
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_1'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_1'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_1" form="my_form" name="pilar1_1">
                                                    <option <?= $pil1['pilar1_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_1" form="my_form" name="ket_in_rep_pil1_1" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_1'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_1'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_1a'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_1a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_1a" form="my_form" name="pilar1_1a">
                                                    <option <?= $pil1['pilar1_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_1a" form="my_form" name="ket_in_rep_pil1_1a" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_1a'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1a'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_1a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kerjasama Dengan Mitra Bisnis
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memiliki jumlah kerjasama dengan mitra bisnis yang memiliki kredibilitas sangat baik dan jumlahnya terbatas yang berkaitan dengan operasional dan bisnis Bank Tidak terdapat wanprestasi dalam kerjasama yang dijalin dengan mitra bisnis
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memiliki kerja sama dengan mitra bisnis pada beberapa jenis kegiatan tertentu yang  berkaitan dengan operasional dan bisnis Bank Terdapat wanprestasi dalam kerjasama yang dijalin dengan mitra bisnis, namun tidak pada esensi yang material terhadap isi perjanjian 
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memiliki kerja sama dengan mitra bisnis pada berbagai jenis kegiatan yang  berkaitan dengan operasional dan bisnis Bank Terdapat wanprestasi dalam kerjasama yang dijalin dengan mitra bisnis, namun tidak pada esensi yang material terhadap isi perjanjian 
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memiliki kerja sama dengan mitra bisnis pada berbagai jenis kegiatan yang  berkaitan dengan operasional dan bisnis Bank
                                            Terdapat wanprestasi dalam kerjasama yang dijalin dengan mitra bisnis, namun tidak pada berdampak signifikan terhadap tujuan kerjasama
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank memiliki kerja sama dengan mitra bisnis pada berbagai jenis kegiatan yang  berkaitan dengan operasional dan bisnis Bank
                                            Terdapat wanprestasi dalam kerjasama yang dijalin dengan mitra bisnis, dan berdampak signifikan terhadap tujuan kerjasama 
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_1b'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_1b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_1b" form="my_form" name="pilar1_1b">
                                                    <option <?= $pil1['pilar1_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_1b" form="my_form" name="ket_in_rep_pil1_1b" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_1b'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1b'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_1b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Penyediaan Media untuk Menjaring Kejadian Terkait Risiko Reputasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Call Center, Website, Kuesioner Kepuasan Nasabah, Whatsapp Broadcast
                                            </td>
                                            <td>
                                            <b>(2)</b> Website, Kuesioner Kepuasan Nasabah, Whatsapp Broadcast
                                            </td>
                                            <td>
                                            <b>(3)</b> Website dan Kuesioner Kepuasan Nasabah
                                            </td>
                                            <td>
                                            <b>(4)</b> Hanya Website atau Kuesioner Kepuasan Nasabah
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak tersedianya Media
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_1c'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_1c'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_1c" form="my_form" name="pilar1_1c">
                                                    <option <?= $pil1['pilar1_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_1c" form="my_form" name="ket_in_rep_pil1_1c" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_1c'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1c'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_1c'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>


                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Penunjukan PIC untuk Pemantauan Terhadap Informasi yang Meningkatkan Eksposure Risiko Reputasi
                                            </th>
                                            <td>
                                            <b>(1)</b> SOTK baru Penunjukan PIC dari Divisi Corpsec sebelum Triwulan I
                                            </td>
                                            <td>
                                            <b>(2)</b> SOTK baru Penunjukan PIC dari Divisi Corpsec di Triwulan I
                                            </td>
                                            <td>
                                            <b>(3)</b> SOTK baru Penunjukan PIC dari Divisi Corpsec di Triwulan II
                                            </td>
                                            <td>
                                            <b>(4)</b> SOTK baru Penunjukan PIC dari Divisi Corpsec di Triwulan III
                                            </td>
                                            <td>
                                            <b>(5)</b> SOTK baru Penunjukan PIC dari Divisi Corpsec di Triwulan IV
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_1d'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_1d'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_1d" form="my_form" name="pilar1_1d">
                                                    <option <?= $pil1['pilar1_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_1d" form="my_form" name="ket_in_rep_pil1_1d" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_1d'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1d'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_1d'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_2'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_2'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_2" form="my_form" name="pilar1_2">
                                                    <option <?= $pil1['pilar1_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_2" form="my_form" name="ket_in_rep_pil1_2" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_2'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_2'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_2'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_2a'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_2a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_2a" form="my_form" name="pilar1_2a">
                                                    <option <?= $pil1['pilar1_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_2a" form="my_form" name="ket_in_rep_pil1_2a" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_2a'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_2a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2a'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_2a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_2b'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_2b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_2b" form="my_form" name="pilar1_2b">
                                                    <option <?= $pil1['pilar1_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_2b" form="my_form" name="ket_in_rep_pil1_2b" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_2b'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_2b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2b'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_2b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_2c'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_2c'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_2c" form="my_form" name="pilar1_2c">
                                                    <option <?= $pil1['pilar1_2c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_2c" form="my_form" name="ket_in_rep_pil1_2c" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_2c'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_2c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2c'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_2c'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil1['pilar1_2d'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil1['pilar1_2d'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar1_2d" form="my_form" name="pilar1_2d">
                                                    <option <?= $pil1['pilar1_2d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_2d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_2d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_2d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_2d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_2d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil1_2d" form="my_form" name="ket_in_rep_pil1_2d" cols="35" rows="5"><?= $ketpil1['ket_in_rep_pil1_2d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_rep_pil1_2d'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil1['ket_in_rep_pil1_2d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2d'];
                                            $div_ke1 = $div_sekper_pil1['pilar1_2d'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>


<!--pilar2-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_1'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_1'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_1" form="my_form" name="pilar2_1">
                                                    <option <?= $pil2['pilar2_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_1" form="my_form" name="ket_in_rep_pil2_1" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_1'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1'];
                                            $div_ke1 = $div_skk_pil2['pilar2_1'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_1a'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_1a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_1a" form="my_form" name="pilar2_1a">
                                                    <option <?= $pil2['pilar2_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_1a" form="my_form" name="ket_in_rep_pil2_1a" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_1a'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1a'];
                                            $div_ke1 = $div_skk_pil2['pilar2_1a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_1b'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_1b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_1b" form="my_form" name="pilar2_1b">
                                                    <option <?= $pil2['pilar2_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_1b" form="my_form" name="ket_in_rep_pil2_1b" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_1b'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1b'];
                                            $div_ke1 = $div_skk_pil2['pilar2_1b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_1c'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_1c'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_1c" form="my_form" name="pilar2_1c">
                                                    <option <?= $pil2['pilar2_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_1c" form="my_form" name="ket_in_rep_pil2_1c" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_1c'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1c'];
                                            $div_ke1 = $div_skk_pil2['pilar2_1c'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Prosedur Layanan Pengaduan Konsumen Tertulis 
                                            </th>
                                            <td>
                                            <b>(1)</b> Prosedur Pengaduan Sederhana dan Respon Paling Lama < 15 (Limabelas) hari Kerja Setelah Tanggal Pengaduan 
                                            </td>
                                            <td>
                                            <b>(2)</b> Prosedur Pengaduan Sederhana dan Respon Paling Lama 15 (Limabelas) hari Kerja Setelah Tanggal Pengaduan 
                                            </td>
                                            <td>
                                            <b>(3)</b> Prosedur Pengaduan Sederhana dan Respon Paling Lama 20 (Duapuluh) hari Kerja Setelah Tanggal Pengaduan
                                            </td>
                                            <td>
                                            <b>(4)</b> Prosedur Pengaduan Sederhana dan Respon Paling Lama 25 (Duapuluh Lima) hari Kerja Setelah Tanggal Pengaduan.
                                            </td>
                                            <td>
                                            <b>(5)</b> Prosedur Pengaduan Sederhana dan Respon Paling Lama > 25 (Duapuluh Lima) hari Kerja Setelah Tanggal Pengaduan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_1d'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_1d'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_1d" form="my_form" name="pilar2_1d">
                                                    <option <?= $pil2['pilar2_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_1d" form="my_form" name="ket_in_rep_pil2_1d" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_1d'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1d'];
                                            $div_ke1 = $div_skk_pil2['pilar2_1d'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_2'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_2'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_2" form="my_form" name="pilar2_2">
                                                    <option <?= $pil2['pilar2_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_2" form="my_form" name="ket_in_rep_pil2_2" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_2'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_2'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_2'];
                                            $div_ke1 = $div_skk_pil2['pilar2_2'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_2a'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_2a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_2a" form="my_form" name="pilar2_2a">
                                                    <option <?= $pil2['pilar2_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_2a" form="my_form" name="ket_in_rep_pil2_2a" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_2a'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_2a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_2a'];
                                            $div_ke1 = $div_skk_pil2['pilar2_2a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil2['pilar2_2b'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil2['pilar2_2b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar2_2b" form="my_form" name="pilar2_2b">
                                                    <option <?= $pil2['pilar2_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil2_2b" form="my_form" name="ket_in_rep_pil2_2b" cols="35" rows="5"><?= $ketpil2['ket_in_rep_pil2_2b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_rep_pil2_2b'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil2['ket_in_rep_pil2_2b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_2b'];
                                            $div_ke1 = $div_skk_pil2['pilar2_2b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>

                                        
<!--pilar 3-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
                                                <h4>
                                                    <b>PILAR 3 : Pelanggaran Etika Bisnis</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Transparansi Informasi Keuangan
                                            </th>
                                            <td>
                                            <b>(1)</b> Laporan  dan informasi keuangan yang disampaikan BPR kepada seluruh   pihak yang  memiliki kepentingan dengan BPR lengkap, akurat, kini, dan  utuh sesuai dengan ketentuan yang berlaku.
                                            </td>
                                            <td>
                                            <b>(2)</b> Laporan  dan informasi keuangan yang disampaikan BPR kepada seluruh pihak yang memiliki kepentingan dengan BPR lengkap, akurat, kini, namun tidak utuh.
                                            </td>
                                            <td>
                                            <b>(3)</b> Laporan  dan informasi keuangan yang disampaikan BPR kepada seluruh pihak yang memiliki kepentingan dengan BPR kurang lengkap dan masih terdapat informasi yang disampaikan tidak sesuai dengan ketentuan yang berlaku,   namun tidak mengakibatkan penilaian yang tidak  sesuai dengan kondisi keuangan yang sebenarnya.
                                            </td>
                                            <td>
                                            <b>(4)</b> Laporan  dan informasi keuangan yang disampaikan BPR kepada seluruh pihak yang memiliki kepentingan dengan BPR kurang lengkap dan masih terdapat informasi yang disampaikan tidak sesuai dengan ketentuan yang berlaku, serta mengakibatkan penilaian yang tidak sesuai dengan kondisi keuangan yang sebenarnya.
                                            </td>
                                            <td>
                                            <b>(5)</b> BPR tidak menyampaikan informasi  dan laporan keuangan sesuai dengan ketentuan yang berlaku,   dan mengakibatkan tidak diketahuinya kondisi keuangan BPR yang sebenarnya.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_1'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_1'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_1" form="my_form" name="pilar3_1">
                                                    <option <?= $pil3['pilar3_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_1" form="my_form" name="ket_in_rep_pil3_1" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_1'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_1'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>



                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Transparansi Data Dokumen Dan Informasi Terhadap Laporan Keuangan Dan Non Keuangan
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah diaudit oleh pihak eksternal yang independen dan telah dilakukan pemeriksaan data, dokumen dan informasi terhadap laporan keuangan dan non keuangan secara berkala pada seluruh unit kerja
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah diaudit oleh pihak eksternal dan telah dilakukan pemeriksaan data, dokumen dan informasi terhadap laporan keuangan dan non keuangan namun belum menyeluruh terhadap seluruh unit kerja
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah diaudit oleh pihak eksternal dan telah dilakukan pemeriksaan data, dokumen dan informasi terhadap laporan keuangan dan non keuangan namun pemeriksaan sebagian besar masih berupa sampling
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank telah diaudit oleh pihak eksternal dan telah dilakukan pemeriksaan data, dokumen dan informasi terhadap laporan keuangan dan non keuangan namun pemeriksaan sebagian besar masih berupa sampling dan pemeriksaan belum rutin secara berkala
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank belum diaudit oleh pihak eksternal terhadap data, dokumen dan informasi terhadap laporan keuangan dan non keuangan 
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_1a'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_1a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_1a" form="my_form" name="pilar3_1a">
                                                    <option <?= $pil3['pilar3_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_1a" form="my_form" name="ket_in_rep_pil3_1a" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_1a'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1a'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_1a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Transparansi Rekrutmen Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank melakukan pemberitahuan melalui papan pengumuman danatauatau media massa terkait dengan adanya pengadaan pegawai.
                                            Pengadaan pegawai dilaksanakan secara transparan dan bekerjasama dengan pihak ketiga yang independen
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank melakukan pemberitahuan melalui papan pengumuman atau media internal terkait dengan adanya pengadaan pegawai.
                                            Pengadaan pegawai dilaksanakan secara transparan dan bekerjasama dengan pihak ketiga yang independen
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank melakukan pemberitahuan melalui papan pengumuman atau media internal terkait dengan adanya pengadaan pegawai.
                                            Pengadaan pegawai dilaksanakan secara transparan dan bekerjasama dengan pihak ketiga 
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank melakukan pemberitahuan melalui papan pengumuman atau media internal terkait dengan adanya pengadaan pegawai.
                                            Pengadaan pegawai dilaksanakan oleh pihak internal tanpa melibatkan pihak ketiga yang independen
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak melakukan pemberitahuan melalui papan pengumuman atau media internal atau media massa terkait dengan adanya pengadaan pegawai.
                                            Pengadaan pegawai dilaksanakan oleh pihak internal tanpa melibatkan pihak ketiga yang independen
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_1b'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_1b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_1b" form="my_form" name="pilar3_1b">
                                                    <option <?= $pil3['pilar3_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_1b" form="my_form" name="ket_in_rep_pil3_1b" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_1b'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1b'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_1b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Pemutusan Hubungan Kerja
                                            </th>
                                            <td>
                                            <b>(1)</b> Dalam hal terdapat pemutusan hubungan kerja, Bank menjalankan prosedur dan memberikan hak kepada pegawai sesuai ketentuan yang berlaku secara penuh
                                            </td>
                                            <td>
                                            <b>(2)</b> Dalam hal terdapat pemutusan hubungan kerja, Bank menjalankan prosedur dan memberikan hak kepada pegawai sesuai ketentuan yang berlaku disesuaikan dengan kemampuan perusahaan
                                            </td>
                                            <td>
                                            <b>(3)</b> Dalam hal terdapat pemutusan hubungan kerja, Bank menjalankan prosedur dan memberikan hak kepada pegawai sesuai dengan kemampuan perusahaan dan pemberian hak masih belum optimal sesuai ketentuan yang berlaku
                                            </td>
                                            <td>
                                            <b>(4)</b> Dalam hal terdapat pemutusan hubungan kerja, Bank menjalankan prosedur dan namun hak pegawai diberikan sesuai dengan kemampuan perusahaan dan pemberian hak masih sangat jauh dari ketentuan yang berlaku
                                            </td>
                                            <td>
                                            <b>(5)</b> Dalam hal terdapat pemutusan hubungan kerja, Bank tidak  menjalankan sesuai prosedur dan  hak pegawai tidak diberikan 
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_1c'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_1c'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_1c" form="my_form" name="pilar3_1c">
                                                    <option <?= $pil3['pilar3_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_1c" form="my_form" name="ket_in_rep_pil3_1c" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_1c'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1c'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_1c'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>

                                        </tr>


                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>2</center>
                                            </th>
                                            <th>
                                            Transparansi Produk Dan Layanan BPR
                                            </th>
                                            <td>
                                            <b>(1)</b> Produk dan layanan  BPR memiliki skema sederhana, serta tidak membutuhkan pemahaman khusus nasabah atau mitra bisnis BPR, dan  BPR memberikan informasi terkait spesifikasi produk dan layanan BPR kepada nasabah atau mitra bisnis BPR secara jelas dan lengkap.
                                            </td>
                                            <td>
                                            <b>(2)</b> Produk dan layanan BPR memiliki skema kompleks,  serta membutuhkan pemahaman khusus nasabah atau mitra bisnis BPR, dan   BPR memberikan informasi terkait spesifikasi produk dan layanan BPR kepada nasabah atau mitra bisnis BPR secara jelas dan lengkap.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat produk dan layanan BPR yang memiliki skema kompleks, serta membutuhkan pemahaman khusus nasabah atau mitra bisnis BPR,  namun BPR belum sepenuhnya memberikan informasi terkait spesifikasi produk dan layanan BPR kepada nasabah atau mitra bisnis BPR secara jelas dan lengkap.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat produk dan layanan BPR yang memiliki skema kompleks, serta membutuhkan pemahaman khusus nasabah atau mitra bisnis BPR,  namun BPR tidak memberikan informasi terkait spesifikasi produk dan Layanan BPR kepada nasabah atau mitra bisnis BPR secara jelas dan lengkap.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat produk dan layanan BPR yang memiliki skema kompleks, serta membutuhkan pemahaman khusus nasabah atau mitra bisnis BPR,  namun BPR memberikan informasi yang tidak benar kepada nasabah atau mitra bisnis BPR terkait spesifikasi produk dan layanan BPR.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_2'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_2'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_2" form="my_form" name="pilar3_2">
                                                    <option <?= $pil3['pilar3_2'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_2" form="my_form" name="ket_in_rep_pil3_2" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_2'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_2'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_2'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_2'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_2'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_2a'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_2a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_2a" form="my_form" name="pilar3_2a">
                                                    <option <?= $pil3['pilar3_2a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_2a" form="my_form" name="ket_in_rep_pil3_2a" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_2a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_2a'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_2a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_2a'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_2a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil3['pilar3_2b'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil3['pilar3_2b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar3_2b" form="my_form" name="pilar3_2b">
                                                    <option <?= $pil3['pilar3_2b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_2b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_2b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_2b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_2b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_2b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil3_2b" form="my_form" name="ket_in_rep_pil3_2b" cols="35" rows="5"><?= $ketpil3['ket_in_rep_pil3_2b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_rep_pil3_2b'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil3['ket_in_rep_pil3_2b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_2b'];
                                            $div_ke1 = $div_sekper_pil3['pilar3_2b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>


                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil4['pilar4_1a'] ?></center>
                                            <center>SKAI</center>
                                            <center><?= $div_skai_pil4['pilar4_1a'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar4_1a" form="my_form" name="pilar4_1a">
                                                    <option <?= $pil4['pilar4_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil4_1a" form="my_form" name="ket_in_rep_pil4_1a" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_rep_pil4_1a'] ?></textarea>
                                            <center>SKAI</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skai_ketpil4['ket_in_rep_pil4_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1a'];
                                            $div_ke1 = $div_skai_pil4['pilar4_1a'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil4['pilar4_1b'] ?></center>
                                            <center>SKK</center>
                                            <center><?= $div_skk_pil4['pilar4_1b'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar4_1b" form="my_form" name="pilar4_1b">
                                                    <option <?= $pil4['pilar4_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil4_1b" form="my_form" name="ket_in_rep_pil4_1b" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_rep_pil4_1b'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_rep_pil4_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1b'];
                                            $div_ke1 = $div_skk_pil4['pilar4_1b'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
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
                                            <th width="5%">
                                            <center>SKMR</center>
                                            <center><?= $div_skmr_pil4['pilar4_1c'] ?></center>
                                            <center>SEKPER</center>
                                            <center><?= $div_sekper_pil4['pilar4_1c'] ?></center>
                                            <br></br>
                                            </th>
                                            <th>
                                            <center>FINAL</center>
                                                <select class="form-select" id="pilar4_1c" form="my_form" name="pilar4_1c">
                                                    <option <?= $pil4['pilar4_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>FINAL</center>
                                            <textarea class="form-control" id="ket_in_rep_pil4_1c" form="my_form" name="ket_in_rep_pil4_1c" cols="35" rows="5"><?= $ketpil4['ket_in_rep_pil4_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_rep_pil4_1c'] ?></textarea>
                                            <center>SEKPER</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sekper_ketpil4['ket_in_rep_pil4_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1c'];
                                            $div_ke1 = $div_sekper_pil4['pilar4_1c'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                        </tr>



                                    </tbody>


                                </table>
                            </div> <!-- end table-responsive-->

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">

                                    <thead class="table-primary">
                                        <tr>

                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Reputasi (SKMR)</center>
                                            </th>
                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Reputasi (SKK)</center>
                                            </th>
                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Reputasi (Sekper)</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10"><?= $div_skmr_ket_inhern_reputasi['ket_inheren'] ?></textarea>
                                        
                                            </th>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $div_skk_ket_inhern_reputasi['ket_inheren'] ?></textarea>
                                        
                                            </th>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $div_sekper_ket_inhern_reputasi['ket_inheren'] ?></textarea>
                                        
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

                            <?php endif; ?>
           




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