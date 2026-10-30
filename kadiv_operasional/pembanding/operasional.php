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

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = ?", [$id]));
$pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = ?", [$id]));
$pil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = ?", [$id]));

$pembanding_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = ?", [$dp]));
$pembanding_pil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = ?", [$dp]));

$div_skmr_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));
$div_skmr_pil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));


$div_ops_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_pil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));

$div_sdm_pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_pil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_pil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));

$div_skk_pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM setting_risiko_inheren_operasional WHERE user = ? AND tahun = ? AND periode = ?", [$jenis_pr, $tahun, $periode]));

$ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 WHERE id_profil_risiko = ?", [$id]));
$ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 WHERE id_profil_risiko = ?", [$id]));
$ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 WHERE id_profil_risiko = ?", [$id]));
$ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 WHERE id_profil_risiko = ?", [$id]));
$ketpil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 WHERE id_profil_risiko = ?", [$id]));
$ketpil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya WHERE id_profil_risiko = ?", [$id]));

$div_skmr_ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));
$div_skmr_ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));
$div_skmr_ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));
$div_skmr_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));
$div_skmr_ketpil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));
$div_skmr_ketpil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?  ", [$tahun, $periode]));


$div_ops_ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_ketpil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));
$div_ops_ketpil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));

$div_sdm_ketpil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar1.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_ketpil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar2.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_ketpil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar3.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_ketpil5 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar5.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_sdm_ketpil6 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_lainnya.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));

$div_skk_ketpil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 INNER JOIN frame_laporan_profil_risiko ON ket_inheren_operasional_pilar4.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 135", [$tahun, $periode]));

$div_skmr_ket_inhern_operasional = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ? ", [$tahun, $periode]));

$div_sdm_ket_inhern_operasional = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 134", [$tahun, $periode]));
$div_ops_ket_inhern_operasional = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_operasional INNER JOIN frame_laporan_profil_risiko ON keterangan_inheren2_operasional.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 133", [$tahun, $periode]));


$ket_inhern_operasional = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_inheren2_operasional WHERE id_profil_risiko = ?", [$id]));

//setingan ditetapkan

$set_pil1_par2 = $inheren['inheren_op_set_pil1_par2'];
$set_pil1_par3 = $inheren['inheren_op_set_pil1_par3'];
$set_pil1_par4 = $inheren['inheren_op_set_pil1_par4'];
$set_pil1 = $inheren['inheren_op_set_pil1'];
$set_pil2_par1 = $inheren['inheren_op_set_pil2_par1'];
$set_pil2 = $inheren['inheren_op_set_pil2'];
$set_pil3_par1 = $inheren['inheren_op_set_pil3_par1'];
$set_pil4_par1 = $inheren['inheren_op_set_pil4_par1'];
$set_pil5_par1 = $inheren['inheren_op_set_pil5_par1'];
$set_pil6_par1 = $inheren['inheren_op_set_pil6_par1'];
$set_tingkat_risiko = $inheren['inheren_op_set_tingkat_risiko'];


if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';

        //pilar 1
        $pilar1_1 = $_POST['pilar1_1'];
        $pilar1_2 = $_POST['pilar1_2'];
        $pilar1_2a = $_POST['pilar1_2a'];
        $pilar1_2b = $_POST['pilar1_2b'];
        $pilar1_3 = $_POST['pilar1_3'];
        $pilar1_3a = $_POST['pilar1_3a'];
        $pilar1_3b = $_POST['pilar1_3b'];
        $pilar1_3c = $_POST['pilar1_3c'];
        $pilar1_4 = $_POST['pilar1_4'];
        $pilar1_4a = $_POST['pilar1_4a'];

        //pilar 1 1
        $average_pil1_1 = $_POST['pilar1_1'];
        $max_pil1_1 = $_POST['pilar1_1'];
        $min_pil1_1 = $_POST['pilar1_1'];
        $hasil_pil1_par1 = $_POST['pilar1_1'];
        //pilar 1 2
        $hsl_max_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b);
        $max_pil1_2 = max($hsl_max_pil1_2);
    
        $hsl_min_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b);
        $min_pil1_2 = min($hsl_min_pil1_2);
    
        $hsl_avg_pil1_2 = array($pilar1_2, $pilar1_2a, $pilar1_2b);
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

        //pilar 1 3
        $hsl_max_pil1_3 = array($pilar1_3, $pilar1_3a, $pilar1_3b, $pilar1_3c);
        $max_pil1_3 = max($hsl_max_pil1_3);
    
        $hsl_min_pil1_3 = array($pilar1_3, $pilar1_3a, $pilar1_3b, $pilar1_3c);
        $min_pil1_3 = min($hsl_min_pil1_3);
    
        $hsl_avg_pil1_3 = array($pilar1_3, $pilar1_3a, $pilar1_3b, $pilar1_3c);
        $sum_pil1_3 = array_sum($hsl_avg_pil1_3);
        $average_pil1_3 = $sum_pil1_3 / count($hsl_avg_pil1_3);

        if ($set_pil1_par3 == 1) {

            $hasil_pil1_par3 = $max_pil1_3;
        } else if ($set_pil1_par3 == 2) {
    
            $hasil_pil1_par3 = $min_pil1_3;
        } else if ($set_pil1_par3 == 3) {
    
            $hasil_pil1_par3 = $average_pil1_3;
        } else {
        $hasil_pil1_par3 = 0;
        }
        

        //pilar 1 4
        $hsl_max_pil1_4 = array($pilar1_4, $pilar1_4a);
        $max_pil1_4 = max($hsl_max_pil1_4);
    
        $hsl_min_pil1_4 = array($pilar1_4, $pilar1_4a);
        $min_pil1_4 = min($hsl_min_pil1_4);
    
        $hsl_avg_pil1_4 = array($pilar1_4, $pilar1_4a);
        $sum_pil1_4 = array_sum($hsl_avg_pil1_4);
        $average_pil1_4 = $sum_pil1_4 / count($hsl_avg_pil1_4);

        if ($set_pil1_par4 == 1) {

            $hasil_pil1_par4 = $max_pil1_4;
        } else if ($set_pil1_par4 == 2) {
    
            $hasil_pil1_par4 = $min_pil1_4;
        } else if ($set_pil1_par4 == 3) {
    
            $hasil_pil1_par4 = $average_pil1_4;
        } else {
        $hasil_pil1_par4 = 0;
        }


        //HASIL PILAR 1
        $hsl_max_pilar1= array($hasil_pil1_par1, $hasil_pil1_par2, $hasil_pil1_par3, $hasil_pil1_par4);
        $pil1_tertinggi = max($hsl_max_pilar1);
    
        $hsl_min_pilar1 = array($hasil_pil1_par1, $hasil_pil1_par2, $hasil_pil1_par3, $hasil_pil1_par4);
        $pil1_terendah = min($hsl_min_pilar1);
    
        $hsl_avg_pilar1 = array($hasil_pil1_par1, $hasil_pil1_par2, $hasil_pil1_par3, $hasil_pil1_par4);
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

        $ket_in_op_pil1_1 = $_POST['ket_in_op_pil1_1'];
        $ket_in_op_pil1_2 = $_POST['ket_in_op_pil1_2'];
        $ket_in_op_pil1_2a = $_POST['ket_in_op_pil1_2a'];
        $ket_in_op_pil1_2b = $_POST['ket_in_op_pil1_2b'];
        $ket_in_op_pil1_3 = $_POST['ket_in_op_pil1_3'];
        $ket_in_op_pil1_3a = $_POST['ket_in_op_pil1_3a'];
        $ket_in_op_pil1_3b = $_POST['ket_in_op_pil1_3b'];
        $ket_in_op_pil1_3c = $_POST['ket_in_op_pil1_3c'];
        $ket_in_op_pil1_4 = $_POST['ket_in_op_pil1_4'];
        $ket_in_op_pil1_4a = $_POST['ket_in_op_pil1_4a'];





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
        $pilar2_1j = $_POST['pilar2_1j'];
        $pilar2_1k = $_POST['pilar2_1k'];
        $pilar2_1l = $_POST['pilar2_1l'];
        $pilar2_1m = $_POST['pilar2_1m'];
        $pilar2_1n = $_POST['pilar2_1n'];
        $pilar2_2 = $_POST['pilar2_2'];


        //pilar 2 1
        $hsl_max_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h, $pilar2_1i, $pilar2_1j, $pilar2_1k, $pilar2_1l, $pilar2_1m, $pilar2_1n);
        $max_pil2_1 = max($hsl_max_pil2_1);
    
        $hsl_min_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h, $pilar2_1i, $pilar2_1j, $pilar2_1k, $pilar2_1l, $pilar2_1m, $pilar2_1n);
        $min_pil2_1 = min($hsl_min_pil2_1);
    
        $hsl_avg_pil2_1 = array($pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h, $pilar2_1i, $pilar2_1j, $pilar2_1k, $pilar2_1l, $pilar2_1m, $pilar2_1n);
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
        $average_pil2_2 = $_POST['pilar2_2'];
        $max_pil2_2 = $_POST['pilar2_2'];
        $min_pil2_2 = $_POST['pilar2_2'];
        $hasil_pil2_par2 = $_POST['pilar2_2'];

        //HASIL PILAR 1
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





        $ket_in_op_pil2_1 = $_POST['ket_in_op_pil2_1'];
        $ket_in_op_pil2_1a = $_POST['ket_in_op_pil2_1a'];
        $ket_in_op_pil2_1b = $_POST['ket_in_op_pil2_1b'];
        $ket_in_op_pil2_1c = $_POST['ket_in_op_pil2_1c'];
        $ket_in_op_pil2_1d = $_POST['ket_in_op_pil2_1d'];
        $ket_in_op_pil2_1e = $_POST['ket_in_op_pil2_1e'];
        $ket_in_op_pil2_1f = $_POST['ket_in_op_pil2_1f'];
        $ket_in_op_pil2_1g = $_POST['ket_in_op_pil2_1g'];
        $ket_in_op_pil2_1h = $_POST['ket_in_op_pil2_1h'];
        $ket_in_op_pil2_1i = $_POST['ket_in_op_pil2_1i'];
        $ket_in_op_pil2_1j = $_POST['ket_in_op_pil2_1j'];
        $ket_in_op_pil2_1k = $_POST['ket_in_op_pil2_1k'];
        $ket_in_op_pil2_1l = $_POST['ket_in_op_pil2_1l'];
        $ket_in_op_pil2_1m = $_POST['ket_in_op_pil2_1m'];
        $ket_in_op_pil2_1n = $_POST['ket_in_op_pil2_1n'];
        $ket_in_op_pil2_2 = $_POST['ket_in_op_pil2_2'];



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

        //pilar 3 1
        $hsl_max_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
        $max_pil3_1 = max($hsl_max_pil3_1);
    
        $hsl_min_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
        $min_pil3_1 = min($hsl_min_pil3_1);
    
        $hsl_avg_pil3_1 = array($pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p);
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



        $ket_in_op_pil3_1 = $_POST['ket_in_op_pil3_1'];
        $ket_in_op_pil3_1a = $_POST['ket_in_op_pil3_1a'];
        $ket_in_op_pil3_1b = $_POST['ket_in_op_pil3_1b'];
        $ket_in_op_pil3_1c = $_POST['ket_in_op_pil3_1c'];
        $ket_in_op_pil3_1d = $_POST['ket_in_op_pil3_1d'];
        $ket_in_op_pil3_1e = $_POST['ket_in_op_pil3_1e'];
        $ket_in_op_pil3_1f = $_POST['ket_in_op_pil3_1f'];
        $ket_in_op_pil3_1g = $_POST['ket_in_op_pil3_1g'];
        $ket_in_op_pil3_1h = $_POST['ket_in_op_pil3_1h'];
        $ket_in_op_pil3_1i = $_POST['ket_in_op_pil3_1i'];
        $ket_in_op_pil3_1j = $_POST['ket_in_op_pil3_1j'];
        $ket_in_op_pil3_1k = $_POST['ket_in_op_pil3_1k'];
        $ket_in_op_pil3_1l = $_POST['ket_in_op_pil3_1l'];
        $ket_in_op_pil3_1m = $_POST['ket_in_op_pil3_1m'];
        $ket_in_op_pil3_1n = $_POST['ket_in_op_pil3_1n'];
        $ket_in_op_pil3_1o = $_POST['ket_in_op_pil3_1o'];
        $ket_in_op_pil3_1p = $_POST['ket_in_op_pil3_1p'];




        //pilar 4
        $pilar4_1 = $_POST['pilar4_1'];
        $pilar4_1a = $_POST['pilar4_1a'];
        $pilar4_1b = $_POST['pilar4_1b'];
        $pilar4_1c = $_POST['pilar4_1c'];
        $pilar4_1d = $_POST['pilar4_1d'];

        //pilar 4 1
        $hsl_max_pil4_1 = array($pilar4_1, $pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d);
        $max_pil4_1 = max($hsl_max_pil4_1);
    
        $hsl_min_pil4_1 = array($pilar4_1, $pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d);
        $min_pil4_1 = min($hsl_min_pil4_1);
    
        $hsl_avg_pil4_1 = array($pilar4_1, $pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d);
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

        $ket_in_op_pil4_1 = $_POST['ket_in_op_pil4_1'];
        $ket_in_op_pil4_1a = $_POST['ket_in_op_pil4_1a'];
        $ket_in_op_pil4_1b = $_POST['ket_in_op_pil4_1b'];
        $ket_in_op_pil4_1c = $_POST['ket_in_op_pil4_1c'];
        $ket_in_op_pil4_1d = $_POST['ket_in_op_pil4_1d'];



        //pilar 5
        $pilar5_1 = $_POST['pilar5_1'];
        $pilar5_1a = $_POST['pilar5_1a'];
        $pilar5_1b = $_POST['pilar5_1b'];
        $pilar5_1c = $_POST['pilar5_1c'];
        $pilar5_1d = $_POST['pilar5_1d'];
        $pilar5_1e = $_POST['pilar5_1e'];
        $pilar5_1f = $_POST['pilar5_1f'];


        //pilar 5 1
        $hsl_max_pil5_1 = array($pilar5_1, $pilar5_1a, $pilar5_1b, $pilar5_1c, $pilar5_1d, $pilar5_1e, $pilar5_1f);
        $max_pil5_1 = max($hsl_max_pil5_1);
    
        $hsl_min_pil5_1 = array($pilar5_1, $pilar5_1a, $pilar5_1b, $pilar5_1c, $pilar5_1d, $pilar5_1e, $pilar5_1f);
        $min_pil5_1 = min($hsl_min_pil5_1);
    
        $hsl_avg_pil5_1 = array($pilar5_1, $pilar5_1a, $pilar5_1b, $pilar5_1c, $pilar5_1d, $pilar5_1e, $pilar5_1f);
        $sum_pil5_1 = array_sum($hsl_avg_pil5_1);
        $average_pil5_1 = $sum_pil5_1 / count($hsl_avg_pil5_1);

        if ($set_pil5_par1 == 1) {

            $hasil_pil5_par1 = $max_pil5_1;
        } else if ($set_pil5_par1 == 2) {
    
            $hasil_pil5_par1 = $min_pil5_1;
        } else if ($set_pil5_par1 == 3) {
    
            $hasil_pil5_par1 = $average_pil5_1;
        } else {
        $hasil_pil5_par1 = 0;
        }
        

        $ket_in_op_pil5_1 = $_POST['ket_in_op_pil5_1'];
        $ket_in_op_pil5_1a = $_POST['ket_in_op_pil5_1a'];
        $ket_in_op_pil5_1b = $_POST['ket_in_op_pil5_1b'];
        $ket_in_op_pil5_1c = $_POST['ket_in_op_pil5_1c'];
        $ket_in_op_pil5_1d = $_POST['ket_in_op_pil5_1d'];
        $ket_in_op_pil5_1e = $_POST['ket_in_op_pil5_1e'];
        $ket_in_op_pil5_1f = $_POST['ket_in_op_pil5_1f'];



        //lainnya
        $pilar6_1a = $_POST['pilar6_1a'];
        $pilar6_1b = $_POST['pilar6_1b'];
        $pilar6_1c = $_POST['pilar6_1c'];
        $pilar6_1d = $_POST['pilar6_1d'];
        $pilar6_1e = $_POST['pilar6_1e'];
        $pilar6_1f = $_POST['pilar6_1f'];


        //pilar 6 1
        $hsl_max_pil6_1 = array($pilar6_1a,  $pilar6_1b, $pilar6_1c, $pilar6_1d, $pilar6_1e, $pilar6_1f);
        $max_pil6_1 = max($hsl_max_pil6_1);
    
        $hsl_min_pil6_1 = array($pilar6_1a,  $pilar6_1b, $pilar6_1c, $pilar6_1d, $pilar6_1e, $pilar6_1f);
        $min_pil6_1 = min($hsl_min_pil6_1);
    
        $hsl_avg_pil6_1 = array($pilar6_1a,  $pilar6_1b, $pilar6_1c, $pilar6_1d, $pilar6_1e, $pilar6_1f);
        $sum_pil6_1 = array_sum($hsl_avg_pil6_1);
        $average_pil6_1 = $sum_pil6_1 / count($hsl_avg_pil6_1);

        $ket_in_op_pil6_1a = $_POST['ket_in_op_pil6_1a'];
        $ket_in_op_pil6_1b = $_POST['ket_in_op_pil6_1b'];
        $ket_in_op_pil6_1c = $_POST['ket_in_op_pil6_1c'];
        $ket_in_op_pil6_1d = $_POST['ket_in_op_pil6_1d'];
        $ket_in_op_pil6_1e = $_POST['ket_in_op_pil6_1e'];
        $ket_in_op_pil6_1f = $_POST['ket_in_op_pil6_1f'];

        if ($set_pil6_par1 == 1) {

            $hasil_pil6_par1 = $max_pil6_1;
        } else if ($set_pil6_par1 == 2) {
    
            $hasil_pil6_par1 = $min_pil6_1;
        } else if ($set_pil6_par1 == 3) {
    
            $hasil_pil6_par1 = $average_pil6_1;
        } else {
        $hasil_pil6_par1 = 0;
        }
        





        //HASIL INHEREN
        $hsl_max_inheren= array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1, $hasil_pil4_par1, $hasil_pil5_par1, $hasil_pil6_par1);
        $hasil_inheren_tertinggi = max($hsl_max_inheren);
    
        $hsl_min_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1, $hasil_pil4_par1, $hasil_pil5_par1, $hasil_pil6_par1);
        $hasil_inheren_terendah = min($hsl_min_inheren);
    
        $hsl_avg_inheren = array($pil1_tingkat_risiko, $pil2_tingkat_risiko, $hasil_pil3_par1, $hasil_pil4_par1, $hasil_pil5_par1, $hasil_pil6_par1);
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



    simpro_db_query($conn, "UPDATE inheren_operasional_pilar1 SET 
        pilar1_1 = ?,
        pilar1_2 = ?,
        pilar1_2a = ?,
        pilar1_2b = ?,
        pilar1_3 = ?,
        pilar1_3a = ?,
        pilar1_3b = ?,
        pilar1_3c = ?,
        pilar1_4 = ?,
        pilar1_4a = ?,
        average_pil1_1 = ?,
        average_pil1_2 = ?,
        average_pil1_3 = ?,
        average_pil1_4 = ?,
        min_pil1_1 = ?,
        min_pil1_2 = ?,
        min_pil1_3 = ?,
        min_pil1_4 = ?,
        max_pil1_1 = ?,
        max_pil1_2 = ?,
        max_pil1_3 = ?,
        max_pil1_4 = ?,
        hasil_pil1_par1 = ?,
        hasil_pil1_par2 = ?,
        hasil_pil1_par3 = ?,
        hasil_pil1_par4 = ?
    WHERE id_profil_risiko = ?", [$pilar1_1, $pilar1_2, $pilar1_2a, $pilar1_2b, $pilar1_3, $pilar1_3a, $pilar1_3b, $pilar1_3c, $pilar1_4, $pilar1_4a, $average_pil1_1, $average_pil1_2, $average_pil1_3, $average_pil1_4, $min_pil1_1, $min_pil1_2, $min_pil1_3, $min_pil1_4, $max_pil1_1, $max_pil1_2, $max_pil1_3, $max_pil1_4, $hasil_pil1_par1, $hasil_pil1_par2, $hasil_pil1_par3, $hasil_pil1_par4, $id]);

    simpro_db_query($conn, "UPDATE inheren_operasional_pilar2 SET 
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
        pilar2_1j = ?,
        pilar2_1k = ?,
        pilar2_1l = ?,
        pilar2_1m = ?,
        pilar2_1n = ?,
        pilar2_2 = ?,
        average_pil2_1 = ?,
        average_pil2_2 = ?,
        min_pil2_1 = ?,
        min_pil2_2 = ?,
        max_pil2_1 = ?,
        max_pil2_2 = ?,
        hasil_pil2_par1 = ?,
        hasil_pil2_par2 = ?
    WHERE id_profil_risiko = ?", [$pilar2_1, $pilar2_1a, $pilar2_1b, $pilar2_1c, $pilar2_1d, $pilar2_1e, $pilar2_1f, $pilar2_1g, $pilar2_1h, $pilar2_1i, $pilar2_1j, $pilar2_1k, $pilar2_1l, $pilar2_1m, $pilar2_1n, $pilar2_2, $average_pil2_1, $average_pil2_2, $min_pil2_1, $min_pil2_2, $max_pil2_1, $max_pil2_2, $hasil_pil2_par1, $hasil_pil2_par2, $id]);

    simpro_db_query($conn, "UPDATE inheren_operasional_pilar3 SET 
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
        average_pil3_1 = ?,
        min_pil3_1 = ?,
        max_pil3_1 = ?,
        hasil_pil3_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar3_1, $pilar3_1a, $pilar3_1b, $pilar3_1c, $pilar3_1d, $pilar3_1e, $pilar3_1f, $pilar3_1g, $pilar3_1h, $pilar3_1i, $pilar3_1j, $pilar3_1k, $pilar3_1l, $pilar3_1m, $pilar3_1n, $pilar3_1o, $pilar3_1p, $average_pil3_1, $min_pil3_1, $max_pil3_1, $hasil_pil3_par1, $id]);

    simpro_db_query($conn, "UPDATE inheren_operasional_pilar4 SET 
        pilar4_1 = ?,
        pilar4_1a = ?,
        pilar4_1b = ?,
        pilar4_1c = ?,
        pilar4_1d = ?,
        average_pil4_1 = ?,
        min_pil4_1 = ?,
        max_pil4_1 = ?,
        hasil_pil4_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar4_1, $pilar4_1a, $pilar4_1b, $pilar4_1c, $pilar4_1d, $average_pil4_1, $min_pil4_1, $max_pil4_1, $hasil_pil4_par1, $id]);

    simpro_db_query($conn, "UPDATE inheren_operasional_pilar5 SET 
        pilar5_1 = ?,
        pilar5_1a = ?,
        pilar5_1b = ?,
        pilar5_1c = ?,
        pilar5_1d = ?,
        pilar5_1e = ?,
        pilar5_1f = ?,
        average_pil5_1 = ?,
        min_pil5_1 = ?,
        max_pil5_1 = ?,
        hasil_pil5_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar5_1, $pilar5_1a, $pilar5_1b, $pilar5_1c, $pilar5_1d, $pilar5_1e, $pilar5_1f, $average_pil5_1, $min_pil5_1, $max_pil5_1, $hasil_pil5_par1, $id]);

    simpro_db_query($conn, "UPDATE inheren_operasional_lainnya SET 
        pilar6_1a = ?,
        pilar6_1b = ?,
        pilar6_1c = ?,
        pilar6_1d = ?,
        pilar6_1e = ?,
        pilar6_1f = ?,
        average_pil6_1 = ?,
        min_pil6_1 = ?,
        max_pil6_1 = ?,
        hasil_pil6_par1 = ?
    WHERE id_profil_risiko = ?", [$pilar6_1a, $pilar6_1b, $pilar6_1c, $pilar6_1d, $pilar6_1e, $pilar6_1f, $average_pil6_1, $min_pil6_1, $max_pil6_1, $hasil_pil6_par1, $id]);





    simpro_db_query($conn, "UPDATE hasil_inheren_operasional SET 
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
        pil5_tertinggi = ?,
        pil5_terendah = ?,
        pil5_rata_rata = ?,
        pil5_risiko_ditetapkan = ?,
        pil5_tingkat_risiko = ?,
        pil6_tertinggi = ?,
        pil6_terendah = ?,
        pil6_rata_rata = ?,
        pil6_risiko_ditetapkan = ?,
        pil6_tingkat_risiko = ?,
        hasil_inheren_tertinggi = ?,
        hasil_inheren_terendah = ?,
        hasil_inheren_rata_rata = ?,
        hasil_risiko_ditetapkan = ?,
        hasil_tingkat_risiko = ?,
        hasil_peringkat = ?
    WHERE id_profil_risiko = ?", [$pil1_tertinggi, $pil1_terendah, $pil1_rata_rata, $set_pil1, $pil1_tingkat_risiko, $pil2_tertinggi, $pil2_terendah, $pil2_rata_rata, $set_pil2, $pil2_tingkat_risiko, $max_pil3_1, $min_pil3_1, $average_pil3_1, $set_pil3_par1, $hasil_pil3_par1, $max_pil4_1, $min_pil4_1, $average_pil4_1, $set_pil4_par1, $hasil_pil4_par1, $max_pil5_1, $min_pil5_1, $average_pil5_1, $set_pil5_par1, $hasil_pil5_par1, $max_pil6_1, $min_pil6_1, $average_pil6_1, $set_pil6_par1, $hasil_pil6_par1, $hasil_inheren_tertinggi, $hasil_inheren_terendah, $hasil_inheren_rata_rata, $set_tingkat_risiko, $hasil_tingkat_risiko, $hasil_peringkat, $id]);

    //kalimat

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_pilar1 SET 
        ket_in_op_pil1_1 = ?,
        ket_in_op_pil1_2 = ?,
        ket_in_op_pil1_2a = ?,
        ket_in_op_pil1_2b = ?,
        ket_in_op_pil1_3 = ?,
        ket_in_op_pil1_3a = ?,
        ket_in_op_pil1_3b = ?,
        ket_in_op_pil1_3c = ?,
        ket_in_op_pil1_4 = ?,
        ket_in_op_pil1_4a = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil1_1, $ket_in_op_pil1_2, $ket_in_op_pil1_2a, $ket_in_op_pil1_2b, $ket_in_op_pil1_3, $ket_in_op_pil1_3a, $ket_in_op_pil1_3b, $ket_in_op_pil1_3c, $ket_in_op_pil1_4, $ket_in_op_pil1_4a, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_pilar2 SET 
        ket_in_op_pil2_1 = ?,
        ket_in_op_pil2_1a = ?,
        ket_in_op_pil2_1b = ?,
        ket_in_op_pil2_1c = ?,
        ket_in_op_pil2_1d = ?,
        ket_in_op_pil2_1e = ?,
        ket_in_op_pil2_1f = ?,
        ket_in_op_pil2_1g = ?,
        ket_in_op_pil2_1h = ?,
        ket_in_op_pil2_1i = ?,
        ket_in_op_pil2_1j = ?,
        ket_in_op_pil2_1k = ?,
        ket_in_op_pil2_1l = ?,
        ket_in_op_pil2_1m = ?,
        ket_in_op_pil2_1n = ?,
        ket_in_op_pil2_2 = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil2_1, $ket_in_op_pil2_1a, $ket_in_op_pil2_1b, $ket_in_op_pil2_1c, $ket_in_op_pil2_1d, $ket_in_op_pil2_1e, $ket_in_op_pil2_1f, $ket_in_op_pil2_1g, $ket_in_op_pil2_1h, $ket_in_op_pil2_1i, $ket_in_op_pil2_1j, $ket_in_op_pil2_1k, $ket_in_op_pil2_1l, $ket_in_op_pil2_1m, $ket_in_op_pil2_1n, $ket_in_op_pil2_2, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_pilar3 SET 
        ket_in_op_pil3_1 = ?,
        ket_in_op_pil3_1a = ?,
        ket_in_op_pil3_1b = ?,
        ket_in_op_pil3_1c = ?,
        ket_in_op_pil3_1d = ?,
        ket_in_op_pil3_1e = ?,
        ket_in_op_pil3_1f = ?,
        ket_in_op_pil3_1g = ?,
        ket_in_op_pil3_1h = ?,
        ket_in_op_pil3_1i = ?,
        ket_in_op_pil3_1j = ?,
        ket_in_op_pil3_1k = ?,
        ket_in_op_pil3_1l = ?,
        ket_in_op_pil3_1m = ?,
        ket_in_op_pil3_1n = ?,
        ket_in_op_pil3_1o = ?,
        ket_in_op_pil3_1p = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil3_1, $ket_in_op_pil3_1a, $ket_in_op_pil3_1b, $ket_in_op_pil3_1c, $ket_in_op_pil3_1d, $ket_in_op_pil3_1e, $ket_in_op_pil3_1f, $ket_in_op_pil3_1g, $ket_in_op_pil3_1h, $ket_in_op_pil3_1i, $ket_in_op_pil3_1j, $ket_in_op_pil3_1k, $ket_in_op_pil3_1l, $ket_in_op_pil3_1m, $ket_in_op_pil3_1n, $ket_in_op_pil3_1o, $ket_in_op_pil3_1p, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_pilar4 SET 
        ket_in_op_pil4_1 = ?,
        ket_in_op_pil4_1a = ?,
        ket_in_op_pil4_1b = ?,
        ket_in_op_pil4_1c = ?,
        ket_in_op_pil4_1d = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil4_1, $ket_in_op_pil4_1a, $ket_in_op_pil4_1b, $ket_in_op_pil4_1c, $ket_in_op_pil4_1d, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_pilar5 SET 
        ket_in_op_pil5_1 = ?,
        ket_in_op_pil5_1a = ?,
        ket_in_op_pil5_1b = ?,
        ket_in_op_pil5_1c = ?,
        ket_in_op_pil5_1d = ?,
        ket_in_op_pil5_1e = ?,
        ket_in_op_pil5_1f = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil5_1, $ket_in_op_pil5_1a, $ket_in_op_pil5_1b, $ket_in_op_pil5_1c, $ket_in_op_pil5_1d, $ket_in_op_pil5_1e, $ket_in_op_pil5_1f, $id]);

    simpro_db_query($conn, "UPDATE ket_inheren_operasional_lainnya SET 
        ket_in_op_pil6_1a = ?,
        ket_in_op_pil6_1b = ?,
        ket_in_op_pil6_1c = ?,
        ket_in_op_pil6_1d = ?,
        ket_in_op_pil6_1e = ?,
        ket_in_op_pil6_1f = ?
    WHERE id_profil_risiko = ?", [$ket_in_op_pil6_1a, $ket_in_op_pil6_1b, $ket_in_op_pil6_1c, $ket_in_op_pil6_1d, $ket_in_op_pil6_1e, $ket_in_op_pil6_1f, $id]);



    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=pembanding_operasional&id=$id");
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
                                    
                                        $("#kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e").change(function() {
                                            
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
                                            

                                            var total = parseFloat(kpmr_pil3_1a) + parseFloat(kpmr_pil3_1b) + parseFloat(kpmr_pil3_1c) + parseFloat(kpmr_pil3_1d) + parseFloat(kpmr_pil3_1e) + parseFloat(kpmr_pil3_1f) + parseFloat(kpmr_pil3_1g) + parseFloat(kpmr_pil3_1h) + parseFloat(kpmr_pil3_1i) + parseFloat(kpmr_pil3_1j);
                                            var total_kpmr_pil3_1 = parseFloat(total) / 10;
                                            total_kpmr_pil3_1 = total_kpmr_pil3_1.toFixed(2);

                                            var total = parseFloat(kpmr_pil3_2a) + parseFloat(kpmr_pil3_2b) + parseFloat(kpmr_pil3_2c) + parseFloat(kpmr_pil3_2d) + parseFloat(kpmr_pil3_2e);
                                            var total_kpmr_pil3_2 = parseFloat(total) / 5;
                                            total_kpmr_pil3_2 = total_kpmr_pil3_2.toFixed(2);

                                            const max = [total_kpmr_pil3_1, total_kpmr_pil3_2];
                                            const maxValue = Math.max(...max);
                                            tertinggi_pil3 = maxValue.toFixed(2);

                                            $("#tertinggi_pil3").val(tertinggi_pil3);
                                    

                                            const min = [total_kpmr_pil3_1, total_kpmr_pil3_2];
                                            const minValue = Math.min(...min);
                                            terendah_pil3 = minValue.toFixed(2);

                                            $("#terendah_pil3").val(terendah_pil3);

                                            var total_rata_rata = parseFloat(total_kpmr_pil3_1) + parseFloat(total_kpmr_pil3_2);
                                            
                                            var rata_rata_pil3 = parseFloat(total_rata_rata) / 2;
                                            rata_rata_pil3 = rata_rata_pil3.toFixed(2);

                                            rr3 = rata_rata_pil3;

                                            $("#rata_rata_pil3").val(rata_rata_pil3);

                                        });
                                        $("#kpmr_pil3_1a, #kpmr_pil3_1b, #kpmr_pil3_1c, #kpmr_pil3_1d, #kpmr_pil3_1e, #kpmr_pil3_1f, #kpmr_pil3_1g, #kpmr_pil3_1h, #kpmr_pil3_1i, #kpmr_pil3_1j, #kpmr_pil3_2a, #kpmr_pil3_2b, #kpmr_pil3_2c, #kpmr_pil3_2d, #kpmr_pil3_2e, #opsi_pil3").change(function() {
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
        <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Risiko Operasional Inheren [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #215bb8; color: white;">

                            <h4 class="page-title">Risiko Operasional KPMR</h4>
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
                            <h4 class="header-title">Menu Pembanding Inheren Operasional Usulan SKMR dengan Usulan Divisi</h4>

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
                                                    <center><b>RISIKO OPERASIONAL INHEREN (SKMR DAN DIVISI)</b></center>
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
                                            <th class="text-center" width="5%"rowspan="2">
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
                                                    <b>PILAR 1 : Kompleksitas Bisnis Dan Kelembagaan</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Skala Usaha Dan Struktur Organisasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Skala usaha BPR tergolong kecil atau menengah; dan
                                            Struktur organisasi BPR terpenuhi lengkap sesuai ketentuan tata kelola BPR
                                            </td>
                                            <td>
                                            <b>(2)</b> Skala usaha BPR tergolong besar; dan
                                            Struktur organisasi BPR terpenuhi lengkap sesuai ketentuan tata kelola BPR
                                            </td>
                                            <td>
                                            <b>(3)</b> Skala usaha BPR tergolong kecil atau menengah; dan
                                            Terdapat ketidaklengkapan struktur organisasi BPR pada fungsi yang tidak signifikan
                                            </td>
                                            <td>
                                            <b>(4)</b> Skala usaha BPR tergolong besar; dan
                                            Terdapat ketidaklengkapan struktur organisasi BPR pada fungsi yang tidak signifikan
                                            </td>
                                            <td>
                                            <b>(5)</b> Skala usaha BPR tergolong kecil atau menengah; dan
                                            Terdapat ketidaklengkapan struktur organisasi BPR pada fungsi yang  signifikan
                                            </td>
                                            
                                            <th width="5%">
                                            <center>SKMR </br>
                                            <?= $div_skmr_pil1['pilar1_1'] ?></center>
                                            <center>Operasional </br>
                                            <?= $div_ops_pil1['pilar1_1'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_1" form="my_form" name="ket_in_op_pil1_1" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_1'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_1'];
                                            $div_ke1 = $div_ops_pil1['pilar1_1'];
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
                                            Jaringan Kantor, Rentang Kendali, dan Lokasi Kantor Cabang
                                            </th>
                                            <td>
                                            <b>(1)</b> BPR tidak memiliki jaringan kantor cabang dan/atau kantor kas
                                            </td>
                                            <td>
                                            <b>(2)</b> BPR memiliki jumlah jaringan kantor cabang paling banyak 25 % dari maksimal yang diperkenankan untuk skala KU dan memiliki kantor kas
                                            </td>
                                            <td>
                                            <b>(3)</b> BPR memiliki jumlah jaringan kantor cabang lebih dari 25 % dan paling banyak 50 % dari maksimal yang diperkenankan untuk skala KU dan memiliki kantor kas
                                            </td>
                                            <td>
                                            <b>(4)</b> BPR memiliki jumlah jaringan kantor cabang  lebih dari 50 % dan paling banyak 75 % dari maksimal yang diperkenankan untuk skala KU dan memiliki kantos kas
                                            </td>
                                            <td>
                                            <b>(5)</b> BPR memiliki jumlah jaringan kantor cabang  lebih dari 75 %  dari maksimal yang diperkenankan untuk skala KU dan memiliki kantos kas
                                            </td>
                                            
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_2'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_2'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_2" form="my_form" name="ket_in_op_pil1_2" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_2'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_2'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_2'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2'];
                                            $div_ke1 = $div_ops_pil1['pilar1_2'];
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
                                            Rentang Kendali dan Lokasi Kantor Cabang
                                            </th>
                                            <td>
                                            <b>(1)</b> Rentang kendali sangat kecil dan lokasi kantor cabang dapat diakses dengan sangat mudah
                                            </td>
                                            <td>
                                            <b>(2)</b> Rentang kendali  kecil dan lokasi kantor cabang dapat diakses dengan mudah
                                            </td>
                                            <td>
                                            <b>(3)</b> Rentang kendali  kecil namun terdapat lokasi kantor cabang yang sulit diakses
                                            </td>
                                            <td>
                                            <b>(4)</b> Rentang kendali  besar dan lokasi kantor cabang dapat diakses dengan mudah
                                            </td>
                                            <td>
                                            <b>(5)</b> Rentang kendali  besar dan terdapat lokasi kantor cabang yang sulit diakses
                                            </td>
                                           
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_2a'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_2a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_2a" form="my_form" name="ket_in_op_pil1_2a" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_2a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_2a'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_2a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2a'];
                                            $div_ke1 = $div_ops_pil1['pilar1_2a'];
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
                                            Jangkauan dan Ruang Kendali Kantor
                                            </th>
                                            <td>
                                            <b>(1)</b> 100% Jaringan Kantor Memiliki Peringkat Risiko Cukup
                                            </td>
                                            <td>
                                            <b>(2)</b> 95% Jaringan Kantor Memiliki Peringkat Risiko Cukup
                                            </td>
                                            <td>
                                            <b>(3)</b> 90% Jaringan Kantor Memiliki Peringkat Risiko Cukup
                                            </td>
                                            <td>
                                            <b>(4)</b> 80% Jaringan Kantor Memiliki Peringkat Risiko Cukup
                                            </td>
                                            <td>
                                            <b>(5)</b> 70% Jaringan Kantor Memiliki Peringkat Risiko Cukup
                                            </td>
                                            
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_2b'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_2b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_2b" form="my_form" name="ket_in_op_pil1_2b" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_2b'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_2b'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_2b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_2b'];
                                            $div_ke1 = $div_ops_pil1['pilar1_2b'];
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
                                                <center>3</center>
                                            </th>
                                            <th>
                                            Keberagaman Produk dan/atau Jasa
                                            </th>
                                            <td>
                                            <b>(1)</b> BPR memiliki produk/jasa yang termasuk kegiatan usaha utama
                                            </td>
                                            <td>
                                            <b>(2)</b> BPR memiliki produk/jasa yang termasuk kegiatan usaha utama dan penukaran valuta asing; dan/atau layanan kerjasama pihak ketiga yanag tidak memerlukan kompetensi tinggi dan tidak melibatkan teknologi (misalnya agen pemasaran uang elektronik berbasis kartu atau e-money)
                                            </td>
                                            <td>
                                            <b>(3)</b> BPR memiliki produk/jasa yang termasuk kegiatan usaha utama dan melaksanakan kegiatan usaha layanan kerjasama pihak ketiga yang melibatkan teknologi milik pihak ketiga (misalnya agen uang elektronik berbasis server atau e-cash)
                                            </td>
                                            <td>
                                            <b>(4)</b> BPR melaksanakan kegiatan usaha sebagai penyelenggara layanan berbasis teknologi misalnya sebagai issuer/penerbit kartu ATM. Atau penyelenggara internet banking.
                                            </td>
                                            <td>
                                            <b>(5)</b> BPR yang melaksanakan kegiatan usaha tidak sesuai dengan ketentuan mengenai kegiatan usaha dan wilayah jaringan kantor BPR berdasarkan modal inti (anatara lain kegiatan usaha tidak sesuai dengan kelompok BPRKU, kegiatan usaha tidak dilaporkan atau memperoleh ijin/persetujuan dari OJK atau BI)
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_3'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_3'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_3" form="my_form" name="pilar1_3">
                                                    <option <?= $pil1['pilar1_3'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_3'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_3'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_3'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_3'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_3" form="my_form" name="ket_in_op_pil1_3" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_3'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_3'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_3'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_3'];
                                            $div_ke1 = $div_ops_pil1['pilar1_3'];
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
                                            Keberagaman Produk
                                            </th>
                                            <td>
                                            <b>(1)</b> Tingkat Pemahaman Terhadap Ragam Produk Sangat Baik
                                            </td>
                                            <td>
                                            <b>(2)</b> Tingkat Pemahaman Terhadap Ragam Produk Baik
                                            </td>
                                            <td>
                                            <b>(3)</b> Tingkat Pemahaman Terhadap Ragam Produk Cukup Baik
                                            </td>
                                            <td>
                                            <b>(4)</b> Tingkat Pemahaman Terhadap Ragam Produk Kurang
                                            </td>
                                            <td>
                                            <b>(5)</b> Tingkat Pemahaman Terhadap Ragam Produk Sangat Kurang
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_3a'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_3a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_3a" form="my_form" name="pilar1_3a">
                                                    <option <?= $pil1['pilar1_3a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_3a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_3a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_3a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_3a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_3a" form="my_form" name="ket_in_op_pil1_3a" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_3a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_3a'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_3a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_3a'];
                                            $div_ke1 = $div_ops_pil1['pilar1_3a'];
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
                                            Kompleksitas Produk
                                            </th>
                                            <td>
                                            <b>(1)</b> Produk Bank memiliki jenis dan kompleksitas yang beragam dan telah dilengkapi dengan sistem dan prosedur yang sangat memadai serta dapat dijalankan dengan baik
                                            </td>
                                            <td>
                                            <b>(2)</b> Produk Bank memiliki jenis dan kompleksitas yang beragam dan telah dilengkapi dengan sistem dan prosedur yang memadai serta dapat dijalankan dengan baik
                                            </td>
                                            <td>
                                            <b>(3)</b> Produk Bank memiliki jenis dan kompleksitas yang beragam dan telah dilengkapi dengan sistem dan prosedur yang cukup memadai serta dapat dijalankan dengan baik
                                            </td>
                                            <td>
                                            <b>(4)</b> Produk Bank memiliki jenis dan kompleksitas yang beragam dan telah dilengkapi dengan sistem dan prosedur namun belum memadai serta dapat dijalankan dengan baik
                                            </td>
                                            <td>
                                            <b>(5)</b> Produk Bank memiliki jenis dan kompleksitas yang beragam dan telah dilengkapi dengan sistem dan prosedur namun tidak memadai serta dapat dijalankan dengan baik
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_3b'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_3b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_3b" form="my_form" name="pilar1_3b">
                                                    <option <?= $pil1['pilar1_3b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_3b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_3b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_3b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_3b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_3b" form="my_form" name="ket_in_op_pil1_3b" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_3b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_3b'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_3b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_3b'];
                                            $div_ke1 = $div_ops_pil1['pilar1_3b'];
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
                                            Volume Transaksi
                                            </th>
                                            <td>
                                            <b>(1)</b> Jenis transaksi Bank tidak komplek dan volume transaksi harian dapat tercover oleh kapasitas layanan SDM dan CBS
                                            </td>
                                            <td>
                                            <b>(2)</b> Jenis transaksi Bank kurang komplek dan volume transaksi harian dapat tercover oleh kapasitas layanan SDM dan CBS
                                            </td>
                                            <td>
                                            <b>(3)</b> Jenis transaksi Bank cukup komplek dan volume transaksi harian dapat tercover oleh kapasitas layanan SDM dan CBS
                                            </td>
                                            <td>
                                            <b>(4)</b> Jenis transaksi Bank komplek dan volume transaksi harian tidak sepenuhnya dapat tercover oleh kapasitas layanan SDM dan CBS
                                            </td>
                                            <td>
                                            <b>(5)</b> Jenis transaksi Bank sangat komplek dan volume transaksi harian tidak sepenuhnya dapat tercover oleh kapasitas layanan SDM dan CBS
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_3c'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_3c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_3c" form="my_form" name="pilar1_3c">
                                                    <option <?= $pil1['pilar1_3c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_3c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_3c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_3c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_3c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_3c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_3c" form="my_form" name="ket_in_op_pil1_3c" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_3c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_3c'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_3c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_3c'];
                                            $div_ke1 = $div_ops_pil1['pilar1_3c'];
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
                                                <center>4</center>
                                            </th>
                                            <th>
                                            Tindakan Korporasi
                                            </th>
                                            <td>
                                            <b>(1)</b> BPR tidak dalam proses penggabungan, peleburan dan pengambilalihan; BPR tidak dalam proses pemindahan kantor pusat BPR; dan   
                                            BPR tidak dalam proses penerbitan produk dan/atau pelaksanaan aktivitas baru    
                                            </td>
                                            <td>
                                            <b>(2)</b> BPR tidak dalam proses penggabungan, peleburan dan pengambilalihan; Terdapat proses   pemindahan kantor pusat BPR; dan/atau
                                            BPR dalam proses pengembangan produk dan/atau aktivitas baru (yang hanya memerlukan pelaporan ke OJK)
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat proses pemindahan kantor pusat BPR; BPR menerbitkan produk dan/atau melaksanakan aktivitas baru (memerlukan peresetujuan OJK) bekerja sama dengan pihak ketiga (tidak ada biaya investasi - capital expenditure BPR); dan /atau
                                            BPR melakasanakan penggabungan, peleburan dan pengambilalihan pada jangka waktu sangat lama sebelum periode penilaian; Proses pengambilalihan tidak berpengaruh terhadap strategi bisnis dan budaya perusahaan       
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat proses pemindahan kantor pusat BPR; BPR menerbitkan produk dan/atau melaksanakan aktivitas baru (memerlukan peresetujuan OJK) yang memerlukan biaya investasi - capital expenditure BPR ; dan/atau
                                            BPR melakasanakan penggabungan, peleburan dan pengambilalihan pada jangka waktu  lama sebelum periode penilaian. Proses pengambilalihan berpengaruh terhadap strategi bisnis dan budaya perusahaan
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat proses pemindahan kantor pusat BPR; BPR menerbitkan produk dan/atau melaksanakan aktivitas baru (memerlukan peresetujuan OJK) yang memerlukan biaya investasi - capital expenditure BPR ; dan/atau
                                            BPR melakasanakan penggabungan, peleburan dan pengambilalihan pada jangka waktu tidak  lama sebelum periode penilaian.     Proses pengambilalihan berpengaruh terhadap strategi bisnis dan budaya perusahaan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_4'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_4'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_4" form="my_form" name="pilar1_4">
                                                    <option <?= $pil1['pilar1_4'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_4'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_4'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_4'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_4'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_4" form="my_form" name="ket_in_op_pil1_4" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_4'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_4'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_4'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_4'];
                                            $div_ke1 = $div_ops_pil1['pilar1_4'];
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
                                            Corporate Plan
                                            </th>
                                            <td>
                                            <b>(1)</b> Corporate Plan Telah Disusun > 5 (Lima) Tahun Secara Rinci
                                            </td>
                                            <td>
                                            <b>(2)</b> Corporate Plan Telah Disusun Sampai Dengan 5 (Lima) Tahun Secara Rinci
                                            </td>
                                            <td>
                                            <b>(3)</b> Corporate Plan Telah Disusun Sampai Dengan 5 (Lima) Tahun Secara Garis Besar
                                            </td>
                                            <td>
                                            <b>(4)</b> Corporate Plan Telah Disusun Sampai Dengan < 5 (Lima) Tahun Tahun Secara Rinci
                                            </td>
                                            <td>
                                            <b>(5)</b> Corporate Plan Telah Disusun Sampai Dengan < 5 (Lima) Tahun Secara Garis Besar
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil1['pilar1_4a'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil1['pilar1_4a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar1_4a" form="my_form" name="pilar1_4a">
                                                    <option <?= $pil1['pilar1_4a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil1['pilar1_4a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil1['pilar1_4a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil1['pilar1_4a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil1['pilar1_4a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil1['pilar1_4a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil1_4a" form="my_form" name="ket_in_op_pil1_4a" cols="35" rows="5"><?= $ketpil1['ket_in_op_pil1_4a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil1['ket_in_op_pil1_4a'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil1['ket_in_op_pil1_4a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil1['pilar1_4a'];
                                            $div_ke1 = $div_ops_pil1['pilar1_4a'];
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
                                                    <b>PILAR 2 : Sumber Daya Manusia (SDM)</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Kecukupan Kuantitas dan Kualitas SDM
                                            </th>
                                            <td>
                                            <b>(1)</b> Kuantitas dan Kualitas SDM BPR sangat memadai
                                            </td>
                                            <td>
                                            <b>(2)</b> Kuantitas dan Kualitas SDM BPR memadai
                                            </td>
                                            <td>
                                            <b>(3)</b> Kuantitas dan Kualitas SDM BPR cukup memadai
                                            </td>
                                            <td>
                                            <b>(4)</b> Kuantitas dan Kualitas SDM BPR kurang memadai
                                            </td>
                                            <td>
                                            <b>(5)</b> Kuantitas dan Kualitas SDM BPR tidak memadai
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1" form="my_form" name="ket_in_op_pil2_1" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1'];
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
                                            Kecukupan Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terdapat Kekosongan SOTK
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Kekosongan SOTK Pada 1 (satu) Formasi Non Struktural
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Kekosongan SOTK Pada 3 (Tiga) Formasi Non Struktural
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Kekosongan SOTK Pada 5 (lima) Formasi Non Struktural
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Kekosongan SOTK Pada > 5 (lima) Formasi Non Struktural
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1a'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1a" form="my_form" name="ket_in_op_pil2_1a" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1a'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1a'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1a'];
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
                                            Kecukupan Jumlah SDM  
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terdapat Kekosongan pada Fungsi Layanan dan Operasional
                                            </td>
                                            <td>
                                            <b>(2)</b> Tidak Terdapat Kekosongan pada salah satu fungsi yaitu Layanan atau Operasional
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Kekosongan pada Fungsi Layanan dan Operasional Namun Tidak Berdampak pada Keluhan Nasabah 
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Kekosongan pada Fungsi Layanan dan Operasional dan Cukup Berdampak pada Keluhan Nasabah 
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Kekosongan pada Fungsi Layanan dan Operasional dan Sangat Berdampak pada Keluhan Nasabah 
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1b'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1b" form="my_form" name="ket_in_op_pil2_1b" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1b'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1b'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1b'];
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
                                            Kompetensi SDM
                                            </th>
                                            <td>
                                            <b>(1)</b> > 70% dari jumlah SDM mengikutipelatihan sesuai Bidang Tugasnya Selama Tahun Berjalan
                                            </td>
                                            <td>
                                            <b>(2)</b> 70% dari jumlah SDM mengikutipelatihan sesuai Bidang Tugasnya Selama Tahun Berjalan 
                                            </td>
                                            <td>
                                            <b>(3)</b> 65% dari jumlah SDM mengikuti pelatihan sesuai Bidang Tugasnya Selama Tahun Berjalan  
                                            </td>
                                            <td>
                                            <b>(4)</b> 50%  dari jumlah SDM mengikuti pelatihan sesuai Bidang Tugasnya Selama Tahun Berjalan  
                                            </td>
                                            <td>
                                            <b>(5)</b> < 50%  dari jumlah SDM mengikuti pelatihan sesuai Bidang Tugasnya Selama Tahun Berjalan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1c'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1c" form="my_form" name="ket_in_op_pil2_1c" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1c'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1c'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1c'];
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
                                            Tingkat Turn Over Pegawai Diluar Pensiun dan Pemberhentian Tidak Dengan Hormat
                                            </th>
                                            <td>
                                            <b>(1)</b> < 5 (lima) Orang Selama Periode Penilaian
                                            </td>
                                            <td>
                                            <b>(2)</b> 5 (lima) Orang Selama Periode Penilaian
                                            </td>
                                            <td>
                                            <b>(3)</b> 10 (sepuluh) Orang Selama Periode Penilaian
                                            </td>
                                            <td>
                                            <b>(4)</b> 15 (limabelas) Orang Selama Periode Penilaian
                                            </td>
                                            <td>
                                            <b>(5)</b> > 15 (limabelas) Orang Selama Periode Penilaian
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1d'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1d'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1d" form="my_form" name="ket_in_op_pil2_1d" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1d'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1d'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1d'];
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
                                            Pegawai yang Mendekati Usia Pensiun (usia 50 tahun ke atas) 
                                            </th>
                                            <td>
                                            <b>(1)</b> < 15% dari Jumlah Pegawai
                                            </td>
                                            <td>
                                            <b>(2)</b> 15% dari Jumlah Pegawai
                                            </td>
                                            <td>
                                            <b>(3)</b> 18% dari Jumlah Pegawai
                                            </td>
                                            <td>
                                            <b>(4)</b> 25% dari Jumlah Pegawai
                                            </td>
                                            <td>
                                            <b>(5)</b> > 25% dari Jumlah Pegawai
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1e'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1e'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1e" form="my_form" name="pilar2_1e">
                                                    <option <?= $pil2['pilar2_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1e" form="my_form" name="ket_in_op_pil2_1e" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1e'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1e'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1e'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1e'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1e'];
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
                                            Keseimbangan beban kerja
                                            </th>
                                            <td>
                                            <b>(1)</b> < Terdapat kelengkapan dan kecukupan organisasi yang mendukung tercapainya tujuan perusahaan sesuai visi dan misi dengan optimal. Aktifitas organisasi berjalan sangat optimal sesuai dengan tupoksi masing-masing
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat kelengkapan dan kecukupan organisasi yang mendukung tercapainya tujuan perusahaan sesuai visi dan misi dengan optimal. Aktifitas organisasi berjalan optimal sesuai dengan tupoksi masing-masing
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat kecukupan organisasi yang mendukung tercapainya tujuan perusahaan sesuai visi dan misi dengan optimal. Aktifitas organisasi berjalan sesuai dengan tupoksi masing-masing namun sinergi antar unit kerja belum optimal
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat ketidak lengkapan organisasi sehingga fungsi organisasi dalam mendukung tercapainya tujuan perusahaan sesuai visi dan misi perusahaan menjadi kurang optimal. Aktifitas organisasi berjalan sesuai dengan tupoksi masing-masing namun sinergi antar unit kerja belum optimal. Terdapat ketidakseimbangan beban kerja
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat ketidak lengkapan organisasi sehingga fungsi organisasi dalam mendukung tercapainya tujuan perusahaan sesuai visi dan misi perusahaan menjadi kurang optimal. Aktifitas yang tumpang-tindih dan garis pelaporan kurang jelas. Terdapat ketidak harmonisan sinergi antar unit kerja. Terdapat ketidakseimbangan beban kerja
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1f'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1f'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1f" form="my_form" name="pilar2_1f">
                                                    <option <?= $pil2['pilar2_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1f" form="my_form" name="ket_in_op_pil2_1f" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1f'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1f'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1f'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1f'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1f'];
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
                                            Perbandingan NOA Kredit Terhadap Jumlah SDM di Bidang Kredit
                                            </th>
                                            <td>
                                            <b>(1)</b> > 0.015
                                            </td>
                                            <td>
                                            <b>(2)</b> 0.015
                                            </td>
                                            <td>
                                            <b>(3)</b> 0.013
                                            </td>
                                            <td>
                                            <b>(4)</b> 0.010
                                            </td>
                                            <td>
                                            <b>(5)</b> < 0.010
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1g'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1g'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1g" form="my_form" name="pilar2_1g">
                                                    <option <?= $pil2['pilar2_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1g'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1g'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1g'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1g'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1g'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1g" form="my_form" name="ket_in_op_pil2_1g" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1g'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1g'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1g'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1g'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1g'];
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
                                            Analisa Beban Kerja Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan > 2 (Dua) Kali dalam Setahun 
                                            </td>
                                            <td>
                                            <b>(2)</b> Dilakukan 2 (Dua) Kali dalam Setahun 
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan Sekali dalam Setahun
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan Sekali dalam > 1 tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> Belum pernah dilakukan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1h'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1h'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1h" form="my_form" name="pilar2_1h">
                                                    <option <?= $pil2['pilar2_1h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1h'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1h'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1h'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1h'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1h'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1h" form="my_form" name="ket_in_op_pil2_1h" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1h'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1h'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1h'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1h'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1h'];
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
                                            Pengukuran Kinerja Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Direksi telah melakukan pengukuran kinerja berbasis manajemen risiko dan menerapkan pemberian reward dan punishmen terhadap hasil kinerja pegawai dengan sangat baik.
                                            Pengukuran kinerja pegawai telah dilakukan secara transparan dan konsisten dalam rangka menciptakan SDM yang kompeten dan profesional
                                            </td>
                                            <td>
                                            <b>(2)</b> Direksi telah melakukan pengukuran kinerja berbasis manajemen risiko dan menerapkan pemberian reward dan punishmen terhadap hasil kinerja pegawai dengan baik.
                                            Pengukuran kinerja pegawai telah dilakukan secara transparan dan konsisten dalam rangka menciptakan SDM yang kompeten dan profesional
                                            </td>
                                            <td>
                                            <b>(3)</b> Direksi telah melakukan pengukuran kinerja berbasis manajemen risiko dan menerapkan pemberian reward dan punishmen terhadap hasil kinerja pegawai dengan cukup baik. Pengukuran kinerja pegawai telah dilakukan secara berkala
                                            </td>
                                            <td>
                                            <b>(4)</b> Direksi belum sepenuhnya melakukan pengukuran kinerja berbasis manajemen risiko dan belum optimal menerapkan pemberian reward dan punishmen terhadap hasil kinerja pegawai dengan cukup baik.
                                            </td>
                                            <td>
                                            <b>(5)</b> Direksi belum melakukan pengukuran kinerja berbasis manajemen risiko dan belum menerapkan pemberian reward dan punishment.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1i'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1i'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1i" form="my_form" name="pilar2_1i">
                                                    <option <?= $pil2['pilar2_1i'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1i'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1i'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1i'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1i'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1i'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1i" form="my_form" name="ket_in_op_pil2_1i" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1i'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1i'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1i'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1i'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1i'];
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
                                            Mengembangkan Budaya Organisasi yang sadar risiko dan mengelola risiko
                                            </th>
                                            <td>
                                            <b>(1)</b> Seluruh elemen organisasi telah memiliki pemahaman dan kesadaran yang sangat baik terhadap risiko dan melakukan pengelolaan risiko dengan menerapkan reward dan punishmen.
                                            Terdapat keteladanan dari pucuk pimpinan dalam mengembangkan budaya organisasi yang sadar risiko dan dilakukan edukasi dan pelatihan secara berkelanjutan
                                            </td>
                                            <td>
                                            <b>(2)</b> Seluruh elemen organisasi telah memiliki pemahaman dan kesadaran yang baik terhadap risiko dan melakukan pengelolaan risiko dengan menerapkan reward dan punishmen.
                                            Terdapat keteladanan dari pucuk pimpinan dalam mengembangkan budaya organisasi yang sadar risiko dan dilakukan edukasi dan pelatihan secara berkelanjutan
                                            </td>
                                            <td>
                                            <b>(3)</b> Seluruh elemen organisasi telah memiliki pemahaman dan kesadaran yang cukup baik terhadap risiko dan melakukan pengelolaan risiko serta menerapkan reward dan punishmen.
                                            Terdapat keteladanan dari pucuk pimpinan dalam mengembangkan budaya organisasi yang sadar risiko dan dilakukan edukasi dan pelatihan
                                            </td>
                                            <td>
                                            <b>(4)</b> Belum seluruh elemen organisasi memiliki pemahaman dan kesadaran yang cukup baik terhadap risiko dan penerapan reward dan punishmen tidak optimal. Kurang terdapat keteladanan dari pucuk pimpinan dalam mengembangkan budaya organisasi yang sadar risiko dan kurang dilakukan edukasi dan pelatihan
                                            </td>
                                            <td>
                                            <b>(5)</b> Belum seluruh elemen organisasi memiliki pemahaman dan kesadaran yang cukup baik terhadap risiko dan penerapan reward dan punishmen tidak optimal.
                                            Tidak terdapat keteladanan dari pucuk pimpinan dalam mengembangkan budaya organisasi yang sadar risiko dan tidak dilakukan edukasi dan pelatihan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1j'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1j'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1j" form="my_form" name="pilar2_1j">
                                                    <option <?= $pil2['pilar2_1j'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1j'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1j'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1j'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1j'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1j'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            </th>
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1j" form="my_form" name="ket_in_op_pil2_1j" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1j'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1j'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1j'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1j'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1j'];
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
                                            Rotasi Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Rotasi Dilakukan > 3 (Tiga) Bulan Sebelum Batas Waktu Maksimal Dalam Jabatannya 
                                            </td>
                                            <td>
                                            <b>(2)</b> Rotasi Dilakukan 3 (Tiga) Bulan Sebelum Batas Waktu Maksimal Dalam Jabatannya 
                                            </td>
                                            <td>
                                            <b>(3)</b> Sesuai Ketentuan Batas Waktu Menduduki Jabatan
                                            </td>
                                            <td>
                                            <b>(4)</b> Rotasi Dilakukan 1 (Satu) Bulan  setelah Batas Waktu Maksimal Dalam Jabatannya 
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan rotasi.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1k'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1k'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1k" form="my_form" name="pilar2_1k">
                                                    <option <?= $pil2['pilar2_1k'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1k'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1k'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1k'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1k'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1k'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1k" form="my_form" name="ket_in_op_pil2_1k" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1k'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1k'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1k'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1k'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1k'];
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
                                            Rotasi Pejabat Eksekutif
                                            </th>
                                            <td>
                                            <b>(1)</b> Rotasi Dilakukan > 1 (Satu) TahunSebelum Batas Waktu Maksimal Dalam Jabatannya
                                            </td>
                                            <td>
                                            <b>(2)</b> Rotasi Dilakukan 1 (Satu) TahunSebelum Batas Waktu Maksimal Dalam Jabatannya
                                            </td>
                                            <td>
                                            <b>(3)</b> Sesuai Ketentuan Batas Waktu Menduduki Jabatan
                                            </td>
                                            <td>
                                            <b>(4)</b> Rotasi Dilakukan < 1 (Satu) Tahun Setelah Batas Waktu Maksimal Dalam Jabatannya
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan rotasi.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1l'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1l'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1l" form="my_form" name="pilar2_1l">
                                                    <option <?= $pil2['pilar2_1l'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1l'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1l'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1l'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1l'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1l'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1l" form="my_form" name="ket_in_op_pil2_1l" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1l'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1l'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1l'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1l'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1l'];
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
                                            Kualitas Pelatihan Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Kualitas pelatihan Pegawai sangat memadai dan memberikan hasil yang optimal pada peningkatan kompetensi dan profesionalitas Pegawai untuk mendukung capaian target perusahaan. Terbentuk perilaku, budaya, sinergi dan team work yang kreatif, inovatif dan kompetitif
                                            </td>
                                            <td>
                                            <b>(2)</b> Kualitas pelatihan Pegawai memadai dan memberikan hasil yang optimal pada peningkatan kompetensi dan profesionalitas Pegawai untuk mendukung capaian target perusahaan. Terbentuk perilaku, budaya, sinergi dan team work yang kreatif, inovatif dan kompetitif
                                            </td>
                                            <td>
                                            <b>(3)</b> Kualitas pelatihan Pegawai cukup memadai dan memberikan hasil pada peningkatan kompetensi dan profesionalitas Pegawai untuk mendukung capaian target perusahaan. Terbentuk perilaku, budaya dan sinergi team work
                                            </td>
                                            <td>
                                            <b>(4)</b> Kualitas pelatihan Pegawai kurang memadai dan kurang memberikan hasil pada peningkatan kompetensi dan profesionalitas Pegawai untuk mendukung capaian target perusahaan. Pembentukan perilaku, budaya dan sinergi team work kurang optimal
                                            </td>
                                            <td>
                                            <b>(5)</b> Kualitas pelatihan Pegawai tidak memadai dan kurang memberikan hasil pada peningkatan kompetensi dan profesionalitas Pegawai untuk mendukung capaian target perusahaan. Pembentukan perilaku, budaya dan sinergi team work tidak optimal
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1m'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1m'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1m" form="my_form" name="pilar2_1m">
                                                    <option <?= $pil2['pilar2_1m'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1m'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1m'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1m'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1m'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1m'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1m" form="my_form" name="ket_in_op_pil2_1m" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1m'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1m'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1m'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1m'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1m'];
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
                                            Evaluasi Kualitas Pendidikan dan Pelatihan
                                            </th>
                                            <td>
                                            <b>(1)</b> Dilakukan evaluasi menyeluruh terhadap kegiatan pendidikan dan pelatihan
                                            </td>
                                            <td>
                                            <b>(2)</b> Dilakukan Setiap 1 (Satu) Bulan Sekali
                                            </td>
                                            <td>
                                            <b>(3)</b> Dilakukan Setiap 3 (Tiga) Bulan Sekali
                                            </td>
                                            <td>
                                            <b>(4)</b> Dilakukan > 3 (Tiga) Bulan Sekali
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak dilakukan evaluasi kualitas pendidikan & pelatihan.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_1n'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_1n'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar2_1n" form="my_form" name="pilar2_1n">
                                                    <option <?= $pil2['pilar2_1n'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil2['pilar2_1n'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil2['pilar2_1n'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil2['pilar2_1n'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil2['pilar2_1n'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil2['pilar2_1n'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_1n" form="my_form" name="ket_in_op_pil2_1n" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_1n'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_1n'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_1n'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_1n'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_1n'];
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
                                            Permasalahan Operasional Karena Faktor Manusia (Human Error)
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terjadi human error pada BPR
                                            </td>
                                            <td>
                                            <b>(2)</b> Terjadi human error pada BPR namun tidak berdampak finansial bagi BPR
                                            </td>
                                            <td>
                                            <b>(3)</b> Terjadi human error pada BPR dan mengurangi keuntungan namun tidak menyebabkan BPR membukukan laba negatif.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terjadi human error pada BPR dan BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun namun masih sesuai ketentuan KPMM
                                            </td>
                                            <td>
                                            <b>(5)</b> Terjadi human error pada BPR dan BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun dibawah ketentuan KPMM
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil2['pilar2_2'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil2['pilar2_2'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil2_2" form="my_form" name="ket_in_op_pil2_2" cols="35" rows="5"><?= $ketpil2['ket_in_op_pil2_2'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil2['ket_in_op_pil2_2'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil2['ket_in_op_pil2_2'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil2['pilar2_2'];
                                            $div_ke1 = $div_sdm_pil2['pilar2_2'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>


                                        </tr>
<!--pilar3-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
                                                <h4>
                                                    <b>PILAR 3 : Penyelenggaraan Teknologi Informasi (TI)</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Penyelenggaraan Teknologi Informasi (Ti)
                                            </th>
                                            <td>
                                            <b>(1)</b> TI BPR sesuai dengan ketentuan mengenai SPTI; dan BPR tidak sedang dalam proses melakukan perubahan mendasar penyelenggaraan TI.
                                            </td>
                                            <td>
                                            <b>(2)</b> TI BPR sebagian besar sesuai dengan ketentuan mengenai SPTI; dan BPR tidak sedang dalam proses melakukan perubahan mendasar penyelenggaraan TI.
                                            </td>
                                            <td>
                                            <b>(3)</b> TI BPR sebagian besar sesuai dengan ketentuan mengenai SPTI; dan BPR  sedang dalam proses melakukan perubahan mendasar penyelenggaraan TI.
                                            </td>
                                            <td>
                                            <b>(4)</b> TI BPR sebagian besar tidak sesuai dengan ketentuan mengenai SPTI; dan  BPR  tidak sedang dalam proses melakukan perubahan mendasar penyelenggaraan TI.         
                                            </td>
                                            <td>
                                            <b>(5)</b> TI BPR sebagian besar tidak sesuai dengan ketentuan mengenai SPTI; dan BPR   sedang dalam proses melakukan perubahan mendasar penyelenggaraan TI.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1" form="my_form" name="ket_in_op_pil3_1" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1'];
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
                                            Perubahan Proses Pelaksanaan Tugas Dari Konvensional Ke Sistem Digital
                                            </th>
                                            <td>
                                            <b>(1)</b> Perusahaan telah memiliki infrastruktur digital terkini yang menunjang kelancaran kerja dalam menghadapi kompetitor
                                            </td>
                                            <td>
                                            <b>(2)</b> Perusahaan telah memiliki infrastruktur digital yang menunjang kelancaran kerja dalam menghadapi kompetitor
                                            </td>
                                            <td>
                                            <b>(3)</b> Perusahaan telah memiliki infrastruktur digital namun belum sepenuhnya menunjang kelancaran kerja
                                            </td>
                                            <td>
                                            <b>(4)</b> SDM kurang memiliki pemahaman  untuk mengoperasikan infrastruktur digital dalam menjalankan aktifitas kerja
                                            </td>
                                            <td>
                                            <b>(5)</b> Perusahaan belum memiliki infrastruktur digital yang dapat menunjang kelancaran kerja
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_ops_pil3['pilar3_1a'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1a" form="my_form" name="ket_in_op_pil3_1a" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1a'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1a'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1a'];
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
                                            Keamanan Informasi Dan Database TI
                                            </th>
                                            <td>
                                            <b>(1)</b> Perusahaan telah memiliki sistem keamanan yang sangat baik dalam mendukung ketahanan data dari potensi terjadinya serangan atau gangguan
                                            </td>
                                            <td>
                                            <b>(2)</b> Perusahaan telah memiliki sistem keamanan yang baik dalam mendukung ketahanan data dari potensi terjadinya serangan atau gangguan
                                            Perusahaan telah secara penuh menyediakan pemisahan segmen jaringan untuk eksternal dan untuk internal yang didukung pengamanan seperti Firewall yang membatasi keluar masuknya data
                                            </td>
                                            <td>
                                            <b>(3)</b> Perusahaan telah memiliki sistem keamanan yang cukup baik dalam mendukung ketahanan data dari potensi terjadinya serangan atau gangguan
                                            Perusahaan belum secara penuh menyediakan pemisahan segmen jaringan untuk eksternal dan untuk internal yang didukung pengamanan seperti Firewall yang membatasi keluar masuknya data
                                            </td>
                                            <td>
                                            <b>(4)</b> Perusahaan telah memiliki sistem keamanan namun belum mampu mendukung ketahanan data dari potensi terjadinya serangan atau gangguan
                                            Perusahaan belum secara penuh menyediakan pemisahan segmen jaringan untuk eksternal dan untuk internal yang didukung pengamanan seperti Firewall yang membatasi keluar masuknya data
                                            </td>
                                            <td>
                                            <b>(5)</b> Perusahaan tidak memiliki sistem keamanan yang mampu mendukung ketahanan data dari potensi terjadinya serangan atau gangguan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1b'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1b" form="my_form" name="ket_in_op_pil3_1b" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1b'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1b'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1b'];
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
                                            Kualifikasi Dan Rekam Jejak Penyedia Jasa Teknologi Informasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah menunjuk penyedia jasa TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang handal dalam menyesuaikan regulasi dan perkembangan teknologi
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah menunjuk penyedia jasa TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang mampu menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa TI telah memiliki rekam jejak yang sangat baik terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah menunjuk penyedia jasa TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa TI telah memiliki rekam jejak yang baik terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank menunjuk penyedia jasa TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang kurang dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa TI telah memiliki rekam jejak yang cukup terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank menunjuk penyedia jasa TI yang kurang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang kurang dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa TI telah memiliki rekam jejak yang kurang baik terhadap bidang usahanya
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1c'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1c" form="my_form" name="ket_in_op_pil3_1c" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1c'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1c'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1c'];
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
                                            Kecukupan Sumber Daya Manusia Bidang IT
                                            </th>
                                            <td>
                                            <b>(1)</b> Kualifikasi dan jumlah Pegawai sangat memadai dalam mendukung penyelenggaraan TI
                                            Dilakukan pengembangan SDM terhadap perkembangan IT secara terus-menerus dan berkelanjutan
                                            </td>
                                            <td>
                                            <b>(2)</b> Kualifikasi dan jumlah Pegawai memadai dalam mendukung penyelenggaraan TI
                                            Dilakukan pengembangan SDM terhadap perkembangan IT secara terus-menerus dan berkelanjutan
                                            </td>
                                            <td>
                                            <b>(3)</b> Kualifikasi dan jumlah Pegawai memadai dalam mendukung penyelenggaraan TI
                                            Dilakukan pengembangan SDM terhadap perkembangan IT
                                            </td>
                                            <td>
                                            <b>(4)</b> Kualifikasi dan jumlah Pegawai kurang memadai dalam mendukung penyelenggaraan TI
                                            Belum dilakukan pengembangan SDM terhadap perkembangan IT
                                            </td>
                                            <td>
                                            <b>(5)</b> Kualifikasi dan jumlah Pegawai tidak memadai dalam mendukung penyelenggaraan TI
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1d'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1d'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1d" form="my_form" name="pilar3_1d">
                                                    <option <?= $pil3['pilar3_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1d" form="my_form" name="ket_in_op_pil3_1d" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1d'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1d'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1d'];
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
                                            Pemahaman Dan Penguasaan Pegawai Terhadap CBS Yang Digunakan
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah menyiapkan User Manual atau pedoman penggunaan modul CBS secara lengkap dan rinci
                                            Bank melakukan sosialisasi dan training terhadap aplikasi software kepada seluruh jajaran pegawai
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah menyiapkan User Manual atau pedoman penggunaan modul CBS
                                            Bank melakukan sosialisasi dan training terhadap aplikasi software kepada seluruh jajaran pegawai
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah menyiapkan User Manual atau pedoman penggunaan modul CBS
                                            Bank melakukan sosialisasi terhadap aplikasi software kepada seluruh jajaran pegawai
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank telah menyiapkan User Manual atau pedoman penggunaan modul CBS
                                            Bank belum melakukan sosialisasi terhadap aplikasi software kepada seluruh jajaran pegawai
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak menyiapkan User Manual atau pedoman penggunaan modul CBS
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1e'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1e'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1e" form="my_form" name="pilar3_1e">
                                                    <option <?= $pil3['pilar3_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1e" form="my_form" name="ket_in_op_pil3_1e" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1e'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1e'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1e'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1e'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1e'];
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
                                            Ketersediaan Cbs Ketika  Kondisi Darurat (Rencana Pemulihan Bencana)
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah memiliki rencana pemulihan dan kondisi darurat yang telah teruji
                                            DRC dapat secara penuh berfungsi dalam hal terjadi gangguan yang berasal dari kerusakan, gangguan jaringan, bencana atau hal lainnya
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah memiliki rencana pemulihan dan kondisi darurat
                                            DRC dapat secara penuh berfungsi dalam hal terjadi gangguan yang berasal dari kerusakan, gangguan jaringan, bencana atau hal lainnya
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah memiliki rencana pemulihan dan kondisi darurat
                                            DRC belum secara penuh berfungsi dalam hal terjadi gangguan yang berasal dari kerusakan, gangguan jaringan, bencana atau hal lainnya
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank telah memiliki rencana pemulihan dan kondisi darurat
                                            DRC belum berfungsi dalam hal terjadi gangguan yang berasal dari kerusakan, gangguan jaringan, bencana atau hal lainnya
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak memiliki rencana pemulihan dan kondisi darurat
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1f'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1f'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1f" form="my_form" name="pilar3_1f">
                                                    <option <?= $pil3['pilar3_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1f" form="my_form" name="ket_in_op_pil3_1f" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1f'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1f'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1f'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1f'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1f'];
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
                                            Pengembangan Teknologi Informasi
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank menyediakan alokasi anggaran untuk pengembangan TI sesuai dengan perkembangan pasar dan tuntutan layanan 
                                            Realisasi dan serapan anggaran optimal dalam menunjang pengembangan TI
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank menyediakan alokasi anggaran untuk pengembangan TI sesuai dengan perkembangan pasar dan tuntutan layanan 
                                            Realisasi dan serapan anggaran cukup optimal dalam menunjang pengembangan TI
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank menyediakan alokasi anggaran untuk pengembangan TI dengan jumlah yang terbatas
                                            Realisasi dan serapan anggaran kurang optimal dalam menunjang pengembangan TI
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank menyediakan alokasi anggaran untuk pengembangan TI dengan jumlah yang terbatas
                                            Realisasi dan serapan anggaran tidak optimal dalam menunjang pengembangan TI
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak menyediakan alokasi anggaran untuk pengembangan TI dengan jumlah yang terbatas
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1g'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1g'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1g" form="my_form" name="pilar3_1g">
                                                    <option <?= $pil3['pilar3_1g'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1g'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1g'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1g'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1g'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1g'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1g" form="my_form" name="ket_in_op_pil3_1g" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1g'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1g'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1g'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1g'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1g'];
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
                                            Kualitas Pelayanan Jaringan Komunikasi TI
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah menunjuk penyedia jasa layanan komunikasi TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang handal dalam menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa layanan komunikasi TI telah memiliki rekam jejak yang sangat baik terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah menunjuk penyedia jasa layanan komunikasi TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang mampu menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa layanan komunikasi TI telah memiliki rekam jejak yang sangat baik terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah menunjuk penyedia jasa layanan komunikasi TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa layanan komunikasi TI telah memiliki rekam jejak yang baik terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank menunjuk penyedia jasa layanan komunikasi TI yang memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang kurang dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa layanan komunikasi TI telah memiliki rekam jejak yang cukup terhadap bidang usahanya
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank menunjuk penyedia jasa layanan komunikasi TI yang tidak memiliki kualifikasi yang mencakup lisensi, reputasi, kondisi keuangan, arsitektur sistem yang tidak dapat menyesuaikan regulasi dan perkembangan teknologi
                                            Penyedia jasa layanan komunikasi TI tidak memiliki rekam jejak yang baik terhadap bidang usahanya
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1h'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1h'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1h" form="my_form" name="pilar3_1h">
                                                    <option <?= $pil3['pilar3_1h'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1h'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1h'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1h'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1h'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1h'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1h" form="my_form" name="ket_in_op_pil3_1h" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1h'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1h'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1h'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1h'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1h'];
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
                                            Pelaksanaan Audit Atas TI
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank telah melakukan audit berkala terhadap TI yang diterapkan
                                            Bank telah melakukan tindak lanjut atas hasil audit TI
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank telah melakukan audit terhadap TI yang diterapkan
                                            Bank telah melakukan tindak lanjut atas hasil audit TI
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank telah melakukan audit terhadap TI yang diterapkan
                                            Bank belum sepenuhnya melakukan tindak lanjut atas hasil audit TI
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank telah melakukan audit terhadap TI yang diterapkan
                                            Bank tidak melakukan tindak lanjut atas hasil audit TI
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank tidak melakukan audit terhadap TI yang diterapkan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1i'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1i'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1i" form="my_form" name="pilar3_1i">
                                                    <option <?= $pil3['pilar3_1i'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1i'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1i'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1i'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1i'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1i'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1i" form="my_form" name="ket_in_op_pil3_1i" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1i'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1i'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1i'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1i'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1i'];
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
                                            Ketersediaan Fasilitas dan Teknologi Penunjang Layanan (Qris, EDC, Virtual Account, Mobil Kas Keliling, Mobile Banking, Laku Pandai)
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat > 5 (Lima) Fasilitas Penunjang Kegiatan Layanan Berbasis Teknologi
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat 5 (Lima) Fasilitas Penunjang Kegiatan Layanan Berbasis Teknologi
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat 3 (Tiga) Fasilitas Penunjang Kegiatan Layanan Berbasis Teknologi
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat 2 (Dua) Fasilitas Penunjang Kegiatan Layanan Berbasis Teknologi
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Terdapat Fasilitas Penunjang Kegiatan Layanan Berbasis Teknologi
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1j'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1j'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1j" form="my_form" name="pilar3_1j">
                                                    <option <?= $pil3['pilar3_1j'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1j'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1j'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1j'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1j'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1j'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1j" form="my_form" name="ket_in_op_pil3_1j" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1j'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1j'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1j'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1j'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1j'];
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
                                            Kualitas Keamanan Data Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terjadi Penyalahgunaan Data Nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Terjadi Penyalahgunaan Data Nasabah tapi tidak Berdampak pada Tuntutan Hukum dan reputasi
                                            </td>
                                            <td>
                                            <b>(3)</b> Terjadi Penyalahgunaan Data Nasabah, Berdampak pada reputasi bank tetapi tidak terdapat Tuntutan Hukum
                                            </td>
                                            <td>
                                            <b>(4)</b> Terjadi Penyalahgunaan Data Nasabah yang Berdampak pada Tuntutan Hukum dan reputasi bank, tapi tidak ada kerugian material.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terjadi Penyalahgunaan Data Nasabah yang Berdampak pada Tuntutan Hukum dan reputasi bank, serta terdapat kerugian material.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1k'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1k'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1k" form="my_form" name="pilar3_1k">
                                                    <option <?= $pil3['pilar3_1k'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1k'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1k'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1k'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1k'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1k'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1k" form="my_form" name="ket_in_op_pil3_1k" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1k'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1k'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1k'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1k'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1k'];
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
                                            Kualitas Keamanan Database System (User Access, Data Encripty, Password, Antivirus, Firewall)
                                            </th>
                                            <td>
                                            <b>(1)</b> Memiliki > 4 (Empat) Lapis Sistem Keamanan Database
                                            </td>
                                            <td>
                                            <b>(2)</b> Memiliki 4 (Empat) Lapis Sistem Keamanan Database
                                            </td>
                                            <td>
                                            <b>(3)</b> Memiliki 3 (Tiga) Lapis Sistem Keamanan Database
                                            </td>
                                            <td>
                                            <b>(4)</b> Memiliki 2 (dua) Lapis Sistem Keamanan Database
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak Memiliki Sistem Keamanan Database
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1l'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1l'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1l" form="my_form" name="pilar3_1l">
                                                    <option <?= $pil3['pilar3_1l'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1l'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1l'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1l'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1l'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1l'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1l" form="my_form" name="ket_in_op_pil3_1l" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1l'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1l'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1l'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1l'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1l'];
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
                                            Kelengkapan Modul Aplikasi IntiPerbankan (CBS) dalam Menunjang Kegiatan Operasional (Modul Data Nasabah, Kredit, Tabungan, Deposito, Agunan, Akuntansi, Pelaporan, Antar Bank, Inventaris/Aset Tetap)
                                            </th>
                                            <td>
                                            <b>(1)</b> Tersedia 100% Modul Aplikasi Inti Perbankan Menyesuaikan Kebutuhan Size dan Kompleksitas Usaha
                                            </td>
                                            <td>
                                            <b>(2)</b> Tersedia 90% Modul Aplikasi Inti Perbankan Menyesuaikan Kebutuhan Size dan Kompleksitas Usaha
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Ketidaklengkapan Modul Aplikasi Inti Perbankan Menyesuaikan Kebutuhan Size dan Kompleksitas Usaha Namun Tidak Signifikan 
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Ketidaklengkapan Modul Aplikasi Inti Perbankan Menyesuaikan Kebutuhan Size dan Kompleksitas Usaha Namun Cukup Signifikan 
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Ketidaklengkapan Modul Aplikasi Inti Perbankan Menyesuaikan Kebutuhan Size dan Kompleksitas Usaha yang sangat Signifikan 
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1m'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1m'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1m" form="my_form" name="pilar3_1m">
                                                    <option <?= $pil3['pilar3_1m'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1m'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1m'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1m'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1m'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1m'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1m" form="my_form" name="ket_in_op_pil3_1m" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1m'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1m'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1m'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1m'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1m'];
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
                                            Gangguan Core Banking
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terdapat Gangguan dan DRC Berfungsi Optimal
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Gangguan namun DRC Berfungsi Optimal
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Gangguan Namun Fungsi DRC Memerlukan Jeda 1 jam
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Gangguan Namun Fungsi DRC Memerlukan Jeda > 1 jam
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Gangguan Namun DRC tidak berfungsi
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1n'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1n'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1n" form="my_form" name="pilar3_1n">
                                                    <option <?= $pil3['pilar3_1n'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1n'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1n'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1n'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1n'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1n'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1n" form="my_form" name="ket_in_op_pil3_1n" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1n'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1n'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1n'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1n'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1n'];
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
                                            Pengembangan Teknologi InformasiTerhadap Core Banking System
                                            </th>
                                            <td>
                                            <b>(1)</b> Pengembangan CBS Dilakukan Paling lambat > 1 (Satu)Tahun Sebelum Masa Berlaku Ketentuan dariRegulator
                                            </td>
                                            <td>
                                            <b>(2)</b> Pengembangan CBS Dilakukan Paling lambat 1 (Satu)Tahun Sebelum Masa Berlaku Ketentuan dariRegulator
                                            </td>
                                            <td>
                                            <b>(3)</b> Pengembangan CBS Dilakukan Paling lambat 6 (Enam) Bulan Sebelum Masa Berlaku Ketentuan dari Regulator
                                            </td>
                                            <td>
                                            <b>(4)</b> Pengembangan CBS Dilakukan < 6 (enam) Bulan Sebelum Masa Berlaku Ketentuan dari Regulator
                                            </td>
                                            <td>
                                            <b>(5)</b> Pengembangan CBS Dilakukan melewati masa Berlaku Ketentuan dari Regulator
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1o'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1o'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1o" form="my_form" name="pilar3_1o">
                                                    <option <?= $pil3['pilar3_1o'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1o'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1o'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1o'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1o'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1o'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1o" form="my_form" name="ket_in_op_pil3_1o" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1o'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1o'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1o'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1o'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1o'];
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
                                            Ketersediaan Sistem Informasi Manajemen
                                            </th>
                                            <td>
                                            <b>(1)</b> SIM Tersedia dengan Sangat Baik
                                            </td>
                                            <td>
                                            <b>(2)</b> SIM Tersedia dengan Baik 
                                            </td>
                                            <td>
                                            <b>(3)</b> SIM Tersedia dengan Cukup Baik
                                            </td>
                                            <td>
                                            <b>(4)</b> SIM Tersedia dengan kurang Baik
                                            </td>
                                            <td>
                                            <b>(5)</b> SIM tidak tersedia dengan baik
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil3['pilar3_1p'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil3['pilar3_1p'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar3_1p" form="my_form" name="pilar3_1p">
                                                    <option <?= $pil3['pilar3_1p'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil3['pilar3_1p'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil3['pilar3_1p'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil3['pilar3_1p'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil3['pilar3_1p'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil3['pilar3_1p'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil3_1p" form="my_form" name="ket_in_op_pil3_1p" cols="35" rows="5"><?= $ketpil3['ket_in_op_pil3_1p'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil3['ket_in_op_pil3_1p'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil3['ket_in_op_pil3_1p'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil3['pilar3_1p'];
                                            $div_ke1 = $div_ops_pil3['pilar3_1p'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            

                                        </tr>

<!--pilar4-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
                                                <h4>
                                                    <b>PILAR 4 : Penyimpangan (Fraud)</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Penyimpangan (Fraud)
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat indikasi penyimpangan (fraud) pada BPR
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat indikasi penyimpangan (fraud) pada BPR dengan frekuensi yang rendah; dan belum / tidak berdampak finansial
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat indikasi penyimpangan (fraud) pada BPR dengan frekuensi tinggi; dan mengurangi keuntungan namun tidak menyebabkan BPR membukukan laba negatif dan tidak menyebabkan rasio permodalan menurun
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat indikasi penyimpangan (fraud) pada BPR yang signifikan; dan  mengurangi keuntungan atau BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun namun masih sesuai ketentuan KPMM
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat indikasi penyimpangan (fraud) pada BPR yang sangat signifikan; dan  BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun dibawah ketentuan KPMM
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil4['pilar4_1'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil4['pilar4_1'] ?></center>
                                                <center>SKK </br>
                                                <?= $div_skk_pil4['pilar4_1'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar4_1" form="my_form" name="pilar4_1">
                                                    <option <?= $pil4['pilar4_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil4_1" form="my_form" name="ket_in_op_pil4_1" cols="35" rows="5"><?= $ketpil4['ket_in_op_pil4_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_op_pil4_1'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil4['ket_in_op_pil4_1'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_op_pil4_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1'];
                                            $div_ke1 = $div_sdm_pil4['pilar4_1'];
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
                                            Frekuensi Penyimpangan
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terjadi penyimpangan 
                                            </td>
                                            <td>
                                            <b>(2)</b> Terjadi penyimpangan dengan frekuensi sangat rendah dan tidak berdampak pada kerugian financial, tuntutan hukum dan reputasi; 
                                            Frekuensi sangat rendah ditentukan sebesar kurang dari 0,50 % jumlah SDM
                                            </td>
                                            <td>
                                            <b>(3)</b> Terjadi penyimpangan dengan frekuensi rendah dan tidak berdampak pada kerugian financial dan tuntutan hukum;
                                            Frekuensi rendah ditentukan besar 0,50 - 0,75 % dari jumlah SDM
                                            </td>
                                            <td>
                                            <b>(4)</b> Terjadi penyimpangan dengan frekuensi sedang dan berdampak pada kerugian financial yang signifikan; 
                                            Frekuensi sedang ditentukan sebesar 0,75 - 1 % dari jumlah SDM
                                            </td>
                                            <td>
                                            <b>(5)</b> Terjadi penyimpangan dengan frekuensi tinggi dan berdampak pada kerugian financial, tuntutan hukum dan reputasi; 
                                            Frekuensi tinggi ditentukan sebesar lebih dari 1 % jumlah SDM
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil4['pilar4_1a'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil4['pilar4_1a'] ?></center>
                                                <center>SKK </br>
                                                <?= $div_skk_pil4['pilar4_1a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil4_1a" form="my_form" name="ket_in_op_pil4_1a" cols="35" rows="5"><?= $ketpil4['ket_in_op_pil4_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_op_pil4_1a'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil4['ket_in_op_pil4_1a'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_op_pil4_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1a'];
                                            $div_ke1 = $div_sdm_pil4['pilar4_1a'];
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
                                            Jenis Penyimpangan Pada Pelaksanaan Kegiatan Operasional
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terjadi penyimpangan
                                            </td>
                                            <td>
                                            <b>(2)</b> Terjadi dua jenis variasi penyimpangan 
                                            Tidak berdampak pada kerugian 
                                            </td>
                                            <td>
                                            <b>(3)</b> Terjadi lebih dari dua jenis variasi penyimpangan dan dengan tingkat frekuensi rendah 
                                            Berdampak pada kerugian tidak melebihi 0,5 % dari jumlah modal Bank
                                            </td>
                                            <td>
                                            <b>(4)</b> Terjadi lebih dari dua jenis variasi penyimpangan dan dengan tingkat frekuensi sedang
                                            Berdampak pada kerugian tidak melebihi 1% dari jumlah modal Bank
                                            </td>
                                            <td>
                                            <b>(5)</b> Terjadi lebih dari dua jenis variasi penyimpangan dan dengan tingkat frekuensi tinggi
                                            Berdampak pada kerugian lebih dari 1% dari jumlah modal Bank
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil4['pilar4_1b'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil4['pilar4_1b'] ?></center>
                                                <center>SKK </br>
                                                <?= $div_skk_pil4['pilar4_1b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil4_1b" form="my_form" name="ket_in_op_pil4_1b" cols="35" rows="5"><?= $ketpil4['ket_in_op_pil4_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_op_pil4_1b'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil4['ket_in_op_pil4_1b'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_op_pil4_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1b'];
                                            $div_ke1 = $div_sdm_pil4['pilar4_1b'];
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
                                            Sebaran Penyimpangan / Fraud
                                            </th>
                                            <td>
                                            <b>(1)</b> Penyimpangan terjadi pada 1 unit kerja 
                                            </td>
                                            <td>
                                            <b>(2)</b> Penyimpangan terjadi pada sejumlah kurang dari 5 % dari jumlah unit kerja
                                            </td>
                                            <td>
                                            <b>(3)</b> Penyimpangan terjadi pada sejumlah lebiih dari 5 % - 10 % dari jumlah unit kerja
                                            </td>
                                            <td>
                                            <b>(4)</b> Penyimpangan terjadi pada sejumlah lebih dari 10 % - 15 % dari jumlah unit kerja
                                            </td>
                                            <td>
                                            <b>(5)</b> Penyimpangan terjadi pada sejumlah lebih dari 15 % dari jumlah unit kerja
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil4['pilar4_1c'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil4['pilar4_1c'] ?></center>
                                                <center>SKK </br>
                                                <?= $div_skk_pil4['pilar4_1c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
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
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil4_1c" form="my_form" name="ket_in_op_pil4_1c" cols="35" rows="5"><?= $ketpil4['ket_in_op_pil4_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_op_pil4_1c'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil4['ket_in_op_pil4_1c'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_op_pil4_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1c'];
                                            $div_ke1 = $div_sdm_pil4['pilar4_1c'];
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
                                            Jenis Tindakan Fraud
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak adanya fraud
                                            </td>
                                            <td>
                                            <b>(2)</b> 1 - 2 Jenis Tindakan Fraud
                                            </td>
                                            <td>
                                            <b>(3)</b> 2 - 3 Jenis Tindakan Fraud
                                            </td>
                                            <td>
                                            <b>(4)</b> 4 - 5 Jenis Tindakan Fraud
                                            </td>
                                            <td>
                                            <b>(5)</b> > 5  Jenis Tindakan Fraud
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil4['pilar4_1d'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil4['pilar4_1d'] ?></center>
                                                <center>SKK </br>
                                                <?= $div_skk_pil4['pilar4_1d'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar4_1d" form="my_form" name="pilar4_1d">
                                                    <option <?= $pil4['pilar4_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil4['pilar4_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil4['pilar4_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil4['pilar4_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil4['pilar4_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil4['pilar4_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil4_1d" form="my_form" name="ket_in_op_pil4_1d" cols="35" rows="5"><?= $ketpil4['ket_in_op_pil4_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil4['ket_in_op_pil4_1d'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil4['ket_in_op_pil4_1d'] ?></textarea>
                                            <center>SKK</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skk_ketpil4['ket_in_op_pil4_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil4['pilar4_1d'];
                                            $div_ke1 = $div_sdm_pil4['pilar4_1d'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                            
                                           

                                        </tr>

<!--pilar5-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
                                                <h4>
                                                    <b>PILAR 5 : Faktor Eksternal</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr bgcolor="#edebe8">
                                            <th>
                                                <center>1</center>
                                            </th>
                                            <th>
                                            Faktor Eksternal
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat kejadian eksternal.
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat kejadian eksternal; namun
                                            Tidak berdampak finansial bagi BPR.
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat kejadian eksternal; dan
                                            mengurangi keuntungan namun tidak menyebabkan BPR membukukan laba negatif.
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat kejadian eksternal; dan
                                            BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun, namun masih sesuai ketentuan KPMM.
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat kejadian eksternal; dan
                                            BPR membukukan laba negatif yang menyebabkan rasio permodalan menurun dibawah ketentuan KPMM.
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1" form="my_form" name="pilar5_1">
                                                    <option <?= $pil5['pilar5_1'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>

                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1" form="my_form" name="ket_in_op_pil5_1" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1'];
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
                                            Kebijakan Pemerintah
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat regulasi dari otoritas terkait yang berkaitan dengan kegiatan utama Bank
                                            Tidak berdampak pada kinerja Bank atas penerapan regulasi dari otoritas terkait
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat regulasi dari otoritas terkait yang berkaitan dengan kegiatan utama Bank
                                            Berdampak pada kinerja Bank namun tidak mengakibatkan penurunan kinerja
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat regulasi dari otoritas terkait yang berkaitan dengan kegiatan utama Bank
                                            Berdampak pada kinerja Bank dan mengakibatkan menurunnya pendapatan namun tidak mengakibatkan menurunnya laba
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat regulasi dari otoritas terkait yang berkaitan dengan kegiatan utama Bank
                                            Berdampak pada kinerja Bank dan mengakibatkan menurunnya pendapatan namun tidak mengakibatkan kerugian
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat regulasi dari otoritas terkait yang berkaitan dengan kegiatan utama Bank
                                            Berdampak pada menurunnya kinerja Bank dan mengakibatkan kerugian
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1a'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1a" form="my_form" name="pilar5_1a">
                                                    <option <?= $pil5['pilar5_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1a" form="my_form" name="ket_in_op_pil5_1a" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1a'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1a'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1a'];
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
                                            Sarana & Prasarana
                                            </th>
                                            <td>
                                            <b>(1)</b> Sarana dan prasarana sangat memadai dibanding dengan kompetitor dalam memberikan layanan kepada nasabah 
                                            Performa gedung, Banking hall, area parkir sangat nyaman dan aman Layanan digital mengikuti perkembangan pasar dan tuntutan nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Sarana dan prasarana memadai dibanding dengan kompetitor dalam memberikan layanan kepada nasabah 
                                            Performa gedung, Banking hall, area parkir sangat nyaman dan aman Layanan digital mengikuti perkembangan pasar dan tuntutan nasabah
                                            </td>
                                            <td>
                                            <b>(3)</b> Sarana dan prasarana cukup memadai dibanding dengan kompetitor dalam memberikan layanan kepada nasabah 
                                            Performa gedung, Banking hall, area parkir nyaman dan aman Layanan digital mengikuti tuntutan nasabah
                                            </td>
                                            <td>
                                            <b>(4)</b> Sarana dan prasarana kurang memadai dibanding dengan kompetitor dalam memberikan layanan kepada nasabah 
                                            Performa gedung, Banking hall, area parkir kurang nyaman dan aman Layanan digital mengikuti tuntutan nasabah
                                            </td>
                                            <td>
                                            <b>(5)</b> Sarana dan prasarana kurang memadai dibanding dengan kompetitor dalam memberikan layanan kepada nasabah 
                                            Performa gedung, Banking hall, area parkir kurang nyaman dan aman Belum memiliki layanan digital
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1b'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1b" form="my_form" name="pilar5_1b">
                                                    <option <?= $pil5['pilar5_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1b" form="my_form" name="ket_in_op_pil5_1b" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1b'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1b'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1b'];
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
                                            Standard Layanan
                                            </th>
                                            <td>
                                            <b>(1)</b> Standard dan kualitas layanan pegawai Bank sangat prima dibanding dengan layanan kompetitor
                                            Pegawai mampu memberikan service excelence kepada nasabah
                                            </td>
                                            <td>
                                            <b>(2)</b> Standard dan kualitas layanan pegawai Bank lebih baik dibanding dengan layanan kompetitor
                                            Pegawai memberikan service excelence kepada nasabah dengan baik
                                            </td>
                                            <td>
                                            <b>(3)</b> Standard dan kualitas layanan pegawai Bank setara dengan standar dan layanan kompetitor
                                            Pegawai memberikan service excelence kepada nasabah dengan cukup baik
                                            </td>
                                            <td>
                                            <b>(4)</b> Standard dan kualitas layanan pegawai Bank kurang baik dibanding dengan layanan kompetitor
                                            Pegawai kurang mampu memberikan service excelence kepada nasabah
                                            </td>
                                            <td>
                                            <b>(5)</b> Standard dan kualitas layanan pegawai Bank kurang baik dibanding dengan layanan kompetitor
                                            Pegawai tidak mampu memberikan service excelence kepada nasabah
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1c'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1c" form="my_form" name="pilar5_1c">
                                                    <option <?= $pil5['pilar5_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                           
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1c" form="my_form" name="ket_in_op_pil5_1c" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1c'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1c'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1c'];
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
                                            Keamanan Jaringan Kantor
                                            </th>
                                            <td>
                                            <b>(1)</b> Seluruh jaringan kantor memiliki tingkat keamanan yang sangat baik
                                            Jaringan kantor aman dari risiko bencana alam dan atau tindakan kriminal
                                            </td>
                                            <td>
                                            <b>(2)</b> Seluruh jaringan kantor memiliki tingkat keamanan yang baik
                                            Jaringan kantor aman dari risiko bencana alam dan atau tindakan kriminal
                                            </td>
                                            <td>
                                            <b>(3)</b> Seluruh jaringan kantor memiliki tingkat keamanan yang cukup baik
                                            Jaringan kantor cukup aman dari risiko bencana alam dan atau tindakan kriminal
                                            </td>
                                            <td>
                                            <b>(4)</b> Seluruh jaringan kantor memiliki tingkat keamanan yang kurang baik
                                            Jaringan kantor kurang aman dari risiko bencana alam dan atau tindakan kriminal
                                            </td>
                                            <td>
                                            <b>(5)</b> Seluruh jaringan kantor memiliki tingkat keamanan yang tidak baik
                                            Jaringan kantor tidak aman dari risiko bencana alam dan atau tindakan kriminal
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1d'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1d'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1d" form="my_form" name="pilar5_1d">
                                                    <option <?= $pil5['pilar5_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1d" form="my_form" name="ket_in_op_pil5_1d" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1d'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1d'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1d'];
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
                                            Gangguan Akibat Faktor Eksternal
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak terdapat gangguan
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Gangguan dan Dapat Diatasi
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Gangguan yang Berdampak pada Layanan Tapi Tidak Menimbulkan Kerugian
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Gangguan yang Berdampak pada Layanan dan  Menimbulkan Kerugian
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Gangguan yang Berdampak pada Layanan dan  Menimbulkan Kerugian  materi dan reputasi
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1e'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1e'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1e" form="my_form" name="pilar5_1e">
                                                    <option <?= $pil5['pilar5_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1e" form="my_form" name="ket_in_op_pil5_1e" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1e'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1e'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1e'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1e'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1e'];
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
                                            Regulasi Pemerintah atau Peraturan Perundang-undangan yang Berdampak pada Risiko Operasional
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terdapat Regulasi Baru
                                            </td>
                                            <td>
                                            <b>(2)</b> Terdapat Regulasi Baru dan Tidak Berdampak Risiko
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Regulasi Baru yang Tidak Berdampak Signifikan
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Regulasi Baru yang Berdampak cukup Signifikan
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Regulasi Baru yang Berdampak sangat Signifikan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil5['pilar5_1f'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil5['pilar5_1f'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar5_1f" form="my_form" name="pilar5_1f">
                                                    <option <?= $pil5['pilar5_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil5['pilar5_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil5['pilar5_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil5['pilar5_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil5['pilar5_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil5['pilar5_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil5_1f" form="my_form" name="ket_in_op_pil5_1f" cols="35" rows="5"><?= $ketpil5['ket_in_op_pil5_1f'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil5['ket_in_op_pil5_1f'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil5['ket_in_op_pil5_1f'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil5['pilar5_1f'];
                                            $div_ke1 = $div_ops_pil5['pilar5_1f'];
                                                        if ($ke1 == $div_ke1) {
                                                            echo '<span>-</span> </i>';
                                                        } else {
                                                            echo '<span class="badge badge-danger-lighten rounded-pill">Tidak Sama</span>';
                                                        }
                                                        
                                                        
                                                        ?></center>
                                            </td>
                                            
                                           

                                        </tr>

<!--pilar lainnya-->
                                        <tr bgcolor="#5DE2E7">
                                            <td colspan="11">
                                                <h4>
                                                    <b>LAINNYA : Kecukupan Kuantitas dan Kualitas SDM</b>
                                                </h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                            </th>
                                            <th>
                                            Kesehatan Pegawai
                                            </th>
                                            <td>
                                            <b>(1)</b> Bank memberikan fasilitas dan jaminan kesehatan dan kecelakaan kerja yang sangat layak, berdampak pada kenyamanan dan loyalitas yang tinggi kepada Perusahaan
                                            </td>
                                            <td>
                                            <b>(2)</b> Bank memberikan fasilitas dan jaminan kesehatan dan kecelakaan kerja yang layak, berdampak pada kenyamanan dan loyalitas yang tinggi kepada Perusahaan
                                            </td>
                                            <td>
                                            <b>(3)</b> Bank memberikan fasilitas dan jaminan kesehatan yang layak, berdampak pada kenyamanan dan loyalitas yang tinggi kepada Perusahaan
                                            </td>
                                            <td>
                                            <b>(4)</b> Bank memberikan fasilitas dan jaminan kesehatan yang kurang layak, berdampak pada ketidaknyamanan pada pegawai
                                            </td>
                                            <td>
                                            <b>(5)</b> Bank memberikan fasilitas dan jaminan kesehatan yang tidak layak dan berdampak pada kualitas pekerjaan dan loyalitas pada perusahaan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1a'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil6['pilar6_1a'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1a" form="my_form" name="pilar6_1a">
                                                    <option <?= $pil6['pilar6_1a'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1a'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1a'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1a'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1a'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1a'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1a" form="my_form" name="ket_in_op_pil6_1a" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1a'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1a'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil6['ket_in_op_pil6_1a'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1a'];
                                            $div_ke1 = $div_sdm_pil6['pilar6_1a'];
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
                                            Keselamatan Kerja
                                            </th>
                                            <td>
                                            <b>(1)</b> Kecelakaan kerja minimal dan kualitas kesehatan Pegawai optimal
                                            </td>
                                            <td>
                                            <b>(2)</b> Kecelakaan kerja minimal dan kualitas kesehatan Pegawai optimal
                                            </td>
                                            <td>
                                            <b>(3)</b> Kualitas kesehatan Pegawai cukup baik
                                            </td>
                                            <td>
                                            <b>(4)</b> Kualitas kesehatan Pegawai kurang baik
                                            </td>
                                            <td>
                                            <b>(5)</b> Kualitas kesehatan Pegawai kurang baik
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1b'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_sdm_pil6['pilar6_1b'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1b" form="my_form" name="pilar6_1b">
                                                    <option <?= $pil6['pilar6_1b'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1b'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1b'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1b'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1b'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1b'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1b" form="my_form" name="ket_in_op_pil6_1b" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1b'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1b'] ?></textarea>
                                            <center>SDM</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_sdm_ketpil6['ket_in_op_pil6_1b'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1b'];
                                            $div_ke1 = $div_sdm_pil6['pilar6_1b'];
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
                                            Jumlah Pengaduan Nasabah
                                            </th>
                                            <td>
                                            <b>(1)</b> Terdapat < 10 pengaduan nasabah berdasarkan data yang diperoleh dari Dashboard Pembantu Aplikasi Portal Perlindungan Konsumen (DP APPK)
                                            </td>
                                            <td>
                                            <b>(2)</b>  Terdapat 10 pengaduan nasabah berdasarkan data yang diperoleh dari Dashboard Pembantu Aplikasi Portal Perlindungan Konsumen (DP APPK)
                                            </td>
                                            <td>
                                            <b>(3)</b> 15 (Lima Belas) Aduan dalam 1 (Satu) Tahun
                                            </td>
                                            <td>
                                            <b>(4)</b> 20 (Dua Puluh) Aduan dalam 1 (Satu) Tahun
                                            </td>
                                            <td>
                                            <b>(5)</b> 25 (Dua Puluh Lima) Aduan dalam 1 (Satu) Tahun
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1c'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil6['pilar6_1c'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1c" form="my_form" name="pilar6_1c">
                                                    <option <?= $pil6['pilar6_1c'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1c'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1c'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1c'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1c'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1c'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1c" form="my_form" name="ket_in_op_pil6_1c" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1c'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1c'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil6['ket_in_op_pil6_1c'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1c'];
                                            $div_ke1 = $div_ops_pil6['pilar6_1c'];
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
                                            Kelengkapan Ketentuan dan Pedoman Operasional
                                            </th>
                                            <td>
                                            <b>(1)</b> Review Berkala Setiap Triwulan
                                            </td>
                                            <td>
                                            <b>(2)</b> Review Berkala Setiap Semester
                                            </td>
                                            <td>
                                            <b>(3)</b> Review Berkala setahun 1 (Satu) kali
                                            </td>
                                            <td>
                                            <b>(4)</b> Review Berkala < 2 (dua) tahun  sekali
                                            </td>
                                            <td>
                                            <b>(5)</b> Review Berkala > 2 (dua) tahun  sekali
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1d'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil6['pilar6_1d'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1d" form="my_form" name="pilar6_1d">
                                                    <option <?= $pil6['pilar6_1d'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1d'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1d'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1d'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1d'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1d'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1d" form="my_form" name="ket_in_op_pil6_1d" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1d'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1d'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil6['ket_in_op_pil6_1d'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1d'];
                                            $div_ke1 = $div_ops_pil6['pilar6_1d'];
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
                                            Pengawasan Internal
                                            </th>
                                            <td>
                                            <b>(1)</b> Pengawasan Melekat dari Atasan Langsung dan Pengawasan Berkala dari SKAI  dan kantor pusat
                                            <td>
                                            <b>(2)</b> Pengawasan Melekat dari Atasan Langsung dan Pengawasan Berkala dari SKAI  
                                            </td>
                                            <td>
                                            <b>(3)</b> Pengawasan Melekat dari Atasan langsung 
                                            </td>
                                            <td>
                                            <b>(4)</b> Pengawasan hanya dilakukan berkala oleh SKAI
                                            </td>
                                            <td>
                                            <b>(5)</b> Tidak adanya pengawasan Internal
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1e'] ?></center>
                                                <center>Operasional </br>
                                                <?= $div_ops_pil6['pilar6_1e'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1e" form="my_form" name="pilar6_1e">
                                                    <option <?= $pil6['pilar6_1e'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1e'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1e'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1e'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1e'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1e'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1e" form="my_form" name="ket_in_op_pil6_1e" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1e'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1e'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil6['ket_in_op_pil6_1e'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1e'];
                                            $div_ke1 = $div_ops_pil6['pilar6_1e'];
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
                                            Kejadian Luar Biasa yang Berpengaruh Terhadap Kegiatan Layanan
                                            </th>
                                            <td>
                                            <b>(1)</b> Tidak Terdapat Kejadian Luar Biasa  
                                            <td>
                                            <b>(2)</b> Terdapat Kejadian Luar Biasa Namun Tidak Berpengaruh Pada Layanan 
                                            </td>
                                            <td>
                                            <b>(3)</b> Terdapat Kejadian Luar Biasa Namun Berpengaruh tidak signifikan
                                            </td>
                                            <td>
                                            <b>(4)</b> Terdapat Kejadian Luar Biasa Namun Berpengaruh cukup signifikan
                                            </td>
                                            <td>
                                            <b>(5)</b> Terdapat Kejadian Luar Biasa Namun Berpengaruh sangat signifikan
                                            </td>
                                            <th width="5%">
                                            <center>SKMR </br>
                                                <?= $div_skmr_pil6['pilar6_1f'] ?></center>
                                                <center>SDM </br>
                                                <?= $div_ops_pil6['pilar6_1f'] ?></center>
                                            </th>
                                            <th>
                                            <center>Final</center>
                                                <select class="form-select" id="pilar6_1f" form="my_form" name="pilar6_1f">
                                                    <option <?= $pil6['pilar6_1f'] == null ? "selected" : "" ?>> </option>
                                                    <option value="1" <?= $pil6['pilar6_1f'] == "1" ? "selected" : "" ?>>1</option>
                                                    <option value="2" <?= $pil6['pilar6_1f'] == "2" ? "selected" : "" ?>>2</option>
                                                    <option value="3" <?= $pil6['pilar6_1f'] == "3" ? "selected" : "" ?>>3</option>
                                                    <option value="4" <?= $pil6['pilar6_1f'] == "4" ? "selected" : "" ?>>4</option>
                                                    <option value="5" <?= $pil6['pilar6_1f'] == "5" ? "selected" : "" ?>>5</option>

                                                </select>
                                            </th>
                                            
                                            <th>
                                            <center>Final</center>
                                            <textarea class="form-control" id="ket_in_op_pil6_1f" form="my_form" name="ket_in_op_pil6_1f" cols="35" rows="5"><?= $ketpil6['ket_in_op_pil6_1f'] ?></textarea>
                                            <center>SKMR</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_skmr_ketpil6['ket_in_op_pil6_1f'] ?></textarea>
                                            <center>Operasional</center>
                                            <textarea class="form-control"  form="my_form"  cols="35" rows="5" readonly><?= $div_ops_ketpil6['ket_in_op_pil6_1f'] ?></textarea>
                                            </th>
                                            <td><center>
                                            <?php 
                                            $ke1 = $div_skmr_pil6['pilar6_1f'];
                                            $div_ke1 = $div_ops_pil6['pilar6_1f'];
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
                                                <center>Uraian Untuk Risiko Inheren Operasional (SKMR)</center>
                                            </th>
                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Operasional (SDM)</center>
                                            </th>
                                            <th colspan="9">
                                                <center>Uraian Untuk Risiko Inheren Operasional (Operasional)</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-primary">
                                        <tr>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $div_skmr_ket_inhern_operasional['ket_inheren'] ?></textarea>
                                        
                                            </th>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $div_sdm_ket_inhern_operasional['ket_inheren'] ?></textarea>
                                        
                                            </th>
                                            <th colspan="9">
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $div_ops_ket_inhern_operasional['ket_inheren'] ?></textarea>
                                        
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