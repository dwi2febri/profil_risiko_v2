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


//inheren kredit
$inheren_kredit1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1a IS NOT NULL AND TRIM(hasil_pil1_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1b IS NOT NULL AND TRIM(hasil_pil1_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1c IS NOT NULL AND TRIM(hasil_pil1_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1d IS NOT NULL AND TRIM(hasil_pil1_par1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil1_par1e IS NOT NULL AND TRIM(hasil_pil1_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1f IS NOT NULL AND TRIM(hasil_pil1_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1g IS NOT NULL AND TRIM(hasil_pil1_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par1h IS NOT NULL AND TRIM(hasil_pil1_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2j IS NOT NULL AND TRIM(hasil_pil1_par2j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par2k IS NOT NULL AND TRIM(hasil_pil1_par2k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$ik_pilar1 = $inheren_kredit1['jumlah'];


$inheren_kredit2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2a IS NOT NULL AND TRIM(hasil_pil2_par2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2b IS NOT NULL AND TRIM(hasil_pil2_par2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2c IS NOT NULL AND TRIM(hasil_pil2_par2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par2d IS NOT NULL AND TRIM(hasil_pil2_par2d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2e IS NOT NULL AND TRIM(hasil_pil2_par2e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2f IS NOT NULL AND TRIM(hasil_pil2_par2f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3 IS NOT NULL AND TRIM(hasil_pil2_par3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3a IS NOT NULL AND TRIM(hasil_pil2_par3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3b IS NOT NULL AND TRIM(hasil_pil2_par3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3c IS NOT NULL AND TRIM(hasil_pil2_par3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par3d IS NOT NULL AND TRIM(hasil_pil2_par3d) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$ik_pilar2 = $inheren_kredit2['jumlah'];

$inheren_kredit3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$ik_pilar3 = $inheren_kredit3['jumlah'];

$inheren_kredit4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil4_par1 IS NOT NULL AND TRIM(hasil_pil4_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1a IS NOT NULL AND TRIM(hasil_pil4_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1b IS NOT NULL AND TRIM(hasil_pil4_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1c IS NOT NULL AND TRIM(hasil_pil4_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil4_par1d IS NOT NULL AND TRIM(hasil_pil4_par1d) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$ik_pilar4 = $inheren_kredit4['jumlah'];



$inheren_kredit_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1g IS NOT NULL AND TRIM(pilar5_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1h IS NOT NULL AND TRIM(pilar5_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1i IS NOT NULL AND TRIM(pilar5_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1j IS NOT NULL AND TRIM(pilar5_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar5_1k IS NOT NULL AND TRIM(pilar5_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1 IS NOT NULL AND TRIM(hasil_pil5_par1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1a IS NOT NULL AND TRIM(hasil_pil5_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1b IS NOT NULL AND TRIM(hasil_pil5_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1c IS NOT NULL AND TRIM(hasil_pil5_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1d IS NOT NULL AND TRIM(hasil_pil5_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1e IS NOT NULL AND TRIM(hasil_pil5_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1f IS NOT NULL AND TRIM(hasil_pil5_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1g IS NOT NULL AND TRIM(hasil_pil5_par1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1h IS NOT NULL AND TRIM(hasil_pil5_par1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1i IS NOT NULL AND TRIM(hasil_pil5_par1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1j IS NOT NULL AND TRIM(hasil_pil5_par1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil5_par1k IS NOT NULL AND TRIM(hasil_pil5_par1k) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));
$ik_pilarl = $inheren_kredit_lainnya['jumlah'];

$keterangan_inheren_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));
$ik_ket = $keterangan_inheren_kredit['jumlah'];


$inheren_kredit = round((($ik_pilar1 + $ik_pilar2 + $ik_pilar3 + $ik_pilar4 + $ik_pilarl + $ik_ket) / 98) * 100);


//kpmr kredit
$kpmr_kredit_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar1 WHERE id_profil_risiko ='$id'"));
$kk_pilar1 = $kpmr_kredit_pilar1['jumlah'];


$kpmr_kredit_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar2 WHERE id_profil_risiko ='$id'"));
$kk_pilar2 = $kpmr_kredit_pilar2['jumlah'];

$kpmr_kredit_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar3 WHERE id_profil_risiko ='$id'"));
$kk_pilar3 = $kpmr_kredit_pilar3['jumlah'];

$kpmr_kredit_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kredit_pilar4 WHERE id_profil_risiko ='$id'"));
$kk_pilar4 = $kpmr_kredit_pilar4['jumlah'];

$respon_unit_kerja_kredit_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil1 WHERE id_profil_risiko ='$id'"));
$kk_ru1 = $respon_unit_kerja_kredit_pil1['jumlah'];

$respon_unit_kerja_kredit_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil2 WHERE id_profil_risiko ='$id'"));
$kk_ru2 = $respon_unit_kerja_kredit_pil2['jumlah'];

$respon_unit_kerja_kredit_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil3 WHERE id_profil_risiko ='$id'"));
$kk_ru3 = $respon_unit_kerja_kredit_pil3['jumlah'];

$respon_unit_kerja_kredit_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kredit_pil4 WHERE id_profil_risiko ='$id'"));
$kk_ru4 = $respon_unit_kerja_kredit_pil4['jumlah'];

$keterangan_kpmr2_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kredit WHERE id_profil_risiko ='$id'"));
$kk_ket = $keterangan_kpmr2_kredit['jumlah'];

$kpmr_kredit = round((($kk_pilar1 + $kk_pilar2 + $kk_pilar3 + $kk_pilar4 + $kk_ru1 + $kk_ru2 + $kk_ru3 + $kk_ru4 + $kk_ket) / 157) * 100);


//profil kredit
$keterangan_profil_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kredit WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_kredit['jumlah'];

$pronil_kredit = round(($ket_pronil / 3) * 100);







//////







//inheren operasional
$inheren_operasional1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_3 IS NOT NULL AND TRIM(pilar1_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$io_pilar1 = $inheren_operasional1['jumlah'];


$inheren_operasional2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1j IS NOT NULL AND TRIM(pilar2_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1k IS NOT NULL AND TRIM(pilar2_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1l IS NOT NULL AND TRIM(pilar2_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1m IS NOT NULL AND TRIM(pilar2_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1n IS NOT NULL AND TRIM(pilar2_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$io_pilar2 = $inheren_operasional2['jumlah'];

$inheren_operasional3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$io_pilar3 = $inheren_operasional3['jumlah'];

$inheren_operasional4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1 IS NOT NULL AND TRIM(pilar4_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$io_pilar4 = $inheren_operasional4['jumlah'];



$inheren_operasional5 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar5_1 IS NOT NULL AND TRIM(pilar5_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1a IS NOT NULL AND TRIM(pilar5_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1b IS NOT NULL AND TRIM(pilar5_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1c IS NOT NULL AND TRIM(pilar5_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1d IS NOT NULL AND TRIM(pilar5_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1e IS NOT NULL AND TRIM(pilar5_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar5_1f IS NOT NULL AND TRIM(pilar5_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$io_pilar5 = $inheren_operasional5['jumlah'];

$inheren_operasional_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar6_1a IS NOT NULL AND TRIM(pilar6_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar6_1b IS NOT NULL AND TRIM(pilar6_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar6_1c IS NOT NULL AND TRIM(pilar6_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar6_1d IS NOT NULL AND TRIM(pilar6_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar6_1e IS NOT NULL AND TRIM(pilar6_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar6_1f IS NOT NULL AND TRIM(pilar6_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));
$io_pilarl = $inheren_operasional_lainnya['jumlah'];

$keterangan_inheren2_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5_1 IS NOT NULL AND TRIM(ket_pil5_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil5 IS NOT NULL AND TRIM(ket_pil5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil6_1 IS NOT NULL AND TRIM(ket_pil6_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil6 IS NOT NULL AND TRIM(ket_pil6) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_operasional WHERE id_profil_risiko = '$id'"));
$io_ket = $keterangan_inheren2_operasional['jumlah'];


$inheren_operasional = round((($io_pilar1 + $io_pilar2 + $io_pilar3 + $io_pilar4 + $io_pilar5 + $io_pilarl + $io_ket) / 77) * 100);



//kpmr operasional
$kpmr_operasional_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar1 WHERE id_profil_risiko ='$id'"));
$ko_pilar1 = $kpmr_operasional_pilar1['jumlah'];


$kpmr_operasional_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar2 WHERE id_profil_risiko ='$id'"));
$ko_pilar2 = $kpmr_operasional_pilar2['jumlah'];

$kpmr_operasional_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_3a IS NOT NULL AND TRIM(pilar3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_3b IS NOT NULL AND TRIM(pilar3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_3c IS NOT NULL AND TRIM(pilar3_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total3 IS NOT NULL AND TRIM(pil3_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_peringkat3 IS NOT NULL AND TRIM(pil3_peringkat3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_4a IS NOT NULL AND TRIM(pilar3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_4b IS NOT NULL AND TRIM(pilar3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_4c IS NOT NULL AND TRIM(pilar3_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total4 IS NOT NULL AND TRIM(pil3_total4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_peringkat4 IS NOT NULL AND TRIM(pil3_peringkat4) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM kpmr_operasional_pilar3 WHERE id_profil_risiko ='$id'"));
$ko_pilar3 = $kpmr_operasional_pilar3['jumlah'];

$kpmr_operasional_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_operasional_pilar4 WHERE id_profil_risiko ='$id'"));
$ko_pilar4 = $kpmr_operasional_pilar4['jumlah'];

$respon_unit_kerja_operasional_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko ='$id'"));
$ko_ru1 = $respon_unit_kerja_operasional_pil1['jumlah'];

$respon_unit_kerja_operasional_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko ='$id'"));
$ko_ru2 = $respon_unit_kerja_operasional_pil2['jumlah'];

$respon_unit_kerja_operasional_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_pil3_3a IS NOT NULL AND TRIM(respon_pil3_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_3b IS NOT NULL AND TRIM(respon_pil3_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_3c IS NOT NULL AND TRIM(respon_pil3_3c) <> '' THEN 1 ELSE 0 END) +
    
    SUM(CASE WHEN respon_pil3_4a IS NOT NULL AND TRIM(respon_pil3_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_4b IS NOT NULL AND TRIM(respon_pil3_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_4c IS NOT NULL AND TRIM(respon_pil3_4c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko ='$id'"));
$ko_ru3 = $respon_unit_kerja_operasional_pil3['jumlah'];

$respon_unit_kerja_operasional_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko ='$id'"));
$ko_ru4 = $respon_unit_kerja_operasional_pil4['jumlah'];

$keterangan_kpmr2_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_3 IS NOT NULL AND TRIM(ket_pil3_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_4 IS NOT NULL AND TRIM(ket_pil3_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_operasional WHERE id_profil_risiko ='$id'"));
$ko_ket = $keterangan_kpmr2_operasional['jumlah'];

$kpmr_operasional = round((($ko_pilar1 + $ko_pilar2 + $ko_pilar3 + $ko_pilar4 + $ko_ru1 + $ko_ru2 + $ko_ru3 + $ko_ru4 + $ko_ket) / 173) * 100);


//profil operasional
$keterangan_profil_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_operasional WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_operasional['jumlah'];

$pronil_operasional = round(($ket_pronil / 3) * 100);





//////







//inheren kepatuhan
$inheren_kepatuhan1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1g IS NOT NULL AND TRIM(pilar1_1g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2f IS NOT NULL AND TRIM(pilar1_2f) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2g IS NOT NULL AND TRIM(pilar1_2g) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2h IS NOT NULL AND TRIM(pilar1_2h) <> '' THEN 1 ELSE 0 END)  AS jumlah
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$ikep_pilar1 = $inheren_kepatuhan1['jumlah'];


$inheren_kepatuhan2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_3 IS NOT NULL AND TRIM(pilar2_3) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$ikep_pilar2 = $inheren_kepatuhan2['jumlah'];

$inheren_kepatuhan_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));
$ikep_pilarl = $inheren_kepatuhan_lainnya['jumlah'];


$keterangan_inheren2_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko = '$id'"));
$ikep_ket = $keterangan_inheren2_kepatuhan['jumlah'];


$inheren_kepatuhan = round((($ikep_pilar1 + $ikep_pilar2 + $ikep_pilarl + $ikep_ket) / 38) * 100);


//kpmr kepatuhan
$kpmr_kepatuhan_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar1_7a IS NOT NULL AND TRIM(pilar1_7a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_7b IS NOT NULL AND TRIM(pilar1_7b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_7c IS NOT NULL AND TRIM(pilar1_7c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total7 IS NOT NULL AND TRIM(pil1_total7) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat7 IS NOT NULL AND TRIM(pil1_peringkat7) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar1 WHERE id_profil_risiko ='$id'"));
$kkep_pilar1 = $kpmr_kepatuhan_pilar1['jumlah'];


$kpmr_kepatuhan_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar2 WHERE id_profil_risiko ='$id'"));
$kkep_pilar2 = $kpmr_kepatuhan_pilar2['jumlah'];

$kpmr_kepatuhan_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar3 WHERE id_profil_risiko ='$id'"));
$kkep_pilar3 = $kpmr_kepatuhan_pilar3['jumlah'];

$kpmr_kepatuhan_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_kepatuhan_pilar4 WHERE id_profil_risiko ='$id'"));
$kkep_pilar4 = $kpmr_kepatuhan_pilar4['jumlah'];

$respon_unit_kerja_kepatuhan_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_7a IS NOT NULL AND TRIM(respon_pil1_7a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_7b IS NOT NULL AND TRIM(respon_pil1_7b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_7c IS NOT NULL AND TRIM(respon_pil1_7c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil1 WHERE id_profil_risiko ='$id'"));
$kkep_ru1 = $respon_unit_kerja_kepatuhan_pil1['jumlah'];

$respon_unit_kerja_kepatuhan_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil2 WHERE id_profil_risiko ='$id'"));
$kkep_ru2 = $respon_unit_kerja_kepatuhan_pil2['jumlah'];

$respon_unit_kerja_kepatuhan_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil3 WHERE id_profil_risiko ='$id'"));
$kkep_ru3 = $respon_unit_kerja_kepatuhan_pil3['jumlah'];

$respon_unit_kerja_kepatuhan_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_kepatuhan_pil4 WHERE id_profil_risiko ='$id'"));
$kkep_ru4 = $respon_unit_kerja_kepatuhan_pil4['jumlah'];

$keterangan_kpmr2_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_7 IS NOT NULL AND TRIM(ket_pil1_7) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_kepatuhan WHERE id_profil_risiko ='$id'"));
$kkep_ket = $keterangan_kpmr2_kepatuhan['jumlah'];

$kpmr_kepatuhan = round((($kkep_pilar1 + $kkep_pilar2 + $kkep_pilar3 + $kkep_pilar4 + $kkep_ru1 + $kkep_ru2 + $kkep_ru3 + $kkep_ru4 + $kkep_ket) / 165) * 100);



//profil kepatuhan
$keterangan_profil_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_kepatuhan WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_kepatuhan['jumlah'];

$pronil_kepatuhan = round(($ket_pronil / 3) * 100);






///////






//inheren likuiditas
$inheren_likuiditas1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN hasil_pil1_par1 IS NOT NULL AND TRIM(hasil_pil1_par1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN hasil_pil1_par2 IS NOT NULL AND TRIM(hasil_pil1_par2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2a IS NOT NULL AND TRIM(hasil_pil1_par2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2b IS NOT NULL AND TRIM(hasil_pil1_par2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2c IS NOT NULL AND TRIM(hasil_pil1_par2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2d IS NOT NULL AND TRIM(hasil_pil1_par2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2e IS NOT NULL AND TRIM(hasil_pil1_par2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2f IS NOT NULL AND TRIM(hasil_pil1_par2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2g IS NOT NULL AND TRIM(hasil_pil1_par2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2h IS NOT NULL AND TRIM(hasil_pil1_par2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par2i IS NOT NULL AND TRIM(hasil_pil1_par2i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3 IS NOT NULL AND TRIM(hasil_pil1_par3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3a IS NOT NULL AND TRIM(hasil_pil1_par3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3b IS NOT NULL AND TRIM(hasil_pil1_par3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3c IS NOT NULL AND TRIM(hasil_pil1_par3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par3d IS NOT NULL AND TRIM(hasil_pil1_par3d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5 IS NOT NULL AND TRIM(hasil_pil1_par5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5a IS NOT NULL AND TRIM(hasil_pil1_par5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5b IS NOT NULL AND TRIM(hasil_pil1_par5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5c IS NOT NULL AND TRIM(hasil_pil1_par5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par5d IS NOT NULL AND TRIM(hasil_pil1_par5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar1_4 IS NOT NULL AND TRIM(pilar1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN hasil_pil1_par4 IS NOT NULL AND TRIM(hasil_pil1_par4) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$ilik_pilar1 = $inheren_likuiditas1['jumlah'];


$inheren_likuiditas2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil2_par1 IS NOT NULL AND TRIM(hasil_pil2_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil2_par1a IS NOT NULL AND TRIM(pil2_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil2_par1a IS NOT NULL AND TRIM(hasil_pil2_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil2_par1b IS NOT NULL AND TRIM(pil2_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par1b IS NOT NULL AND TRIM(hasil_pil2_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil2_par1c IS NOT NULL AND TRIM(pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par1c IS NOT NULL AND TRIM(hasil_pil2_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil2_par2 IS NOT NULL AND TRIM(pil2_par2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil2_par2 IS NOT NULL AND TRIM(hasil_pil2_par2) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$ilik_pilar2 = $inheren_likuiditas2['jumlah'];

$inheren_likuiditas_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN hasil_pil3_par1 IS NOT NULL AND TRIM(hasil_pil3_par1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil3_par1a IS NOT NULL AND TRIM(pil3_par1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN hasil_pil3_par1a IS NOT NULL AND TRIM(hasil_pil3_par1a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1b IS NOT NULL AND TRIM(pil3_par1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1b IS NOT NULL AND TRIM(hasil_pil3_par1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pil3_par1c IS NOT NULL AND TRIM(pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1c IS NOT NULL AND TRIM(hasil_pil3_par1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1d IS NOT NULL AND TRIM(pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1d IS NOT NULL AND TRIM(hasil_pil3_par1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1e IS NOT NULL AND TRIM(pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1e IS NOT NULL AND TRIM(hasil_pil3_par1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pil3_par1f IS NOT NULL AND TRIM(pil3_par1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN hasil_pil3_par1f IS NOT NULL AND TRIM(hasil_pil3_par1f) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = '$id'"));
$ilik_pilarl = $inheren_likuiditas_lainnya['jumlah'];



$keterangan_inheren_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$ilik_ket = $keterangan_inheren_likuiditas['jumlah'];


$inheren_likuiditas = round((($ilik_pilar1 + $ilik_pilar2 + $ilik_pilarl + $ilik_ket) / 57) * 100);


//kpmr likuiditas
$kpmr_likuiditas_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar1 WHERE id_profil_risiko ='$id'"));
$klik_pilar1 = $kpmr_likuiditas_pilar1['jumlah'];


$kpmr_likuiditas_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar2 WHERE id_profil_risiko ='$id'"));
$klik_pilar2 = $kpmr_likuiditas_pilar2['jumlah'];

$kpmr_likuiditas_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar3 WHERE id_profil_risiko ='$id'"));
$klik_pilar3 = $kpmr_likuiditas_pilar3['jumlah'];

$kpmr_likuiditas_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_likuiditas_pilar4 WHERE id_profil_risiko ='$id'"));
$klik_pilar4 = $kpmr_likuiditas_pilar4['jumlah'];

$respon_unit_kerja_likuiditas_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil1 WHERE id_profil_risiko ='$id'"));
$klik_ru1 = $respon_unit_kerja_likuiditas_pil1['jumlah'];

$respon_unit_kerja_likuiditas_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil2 WHERE id_profil_risiko ='$id'"));
$klik_ru2 = $respon_unit_kerja_likuiditas_pil2['jumlah'];

$respon_unit_kerja_likuiditas_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil3 WHERE id_profil_risiko ='$id'"));
$klik_ru3 = $respon_unit_kerja_likuiditas_pil3['jumlah'];

$respon_unit_kerja_likuiditas_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_likuiditas_pil4 WHERE id_profil_risiko ='$id'"));
$klik_ru4 = $respon_unit_kerja_likuiditas_pil4['jumlah'];

$keterangan_kpmr2_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_likuiditas WHERE id_profil_risiko ='$id'"));
$klik_ket = $keterangan_kpmr2_likuiditas['jumlah'];

$kpmr_likuiditas = round((($klik_pilar1 + $klik_pilar2 + $klik_pilar3 + $klik_pilar4 + $klik_ru1 + $klik_ru2 + $klik_ru3 + $klik_ru4 + $klik_ket) / 157) * 100);


//profil likuiditas
$keterangan_profil_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_likuiditas WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_likuiditas['jumlah'];

$pronil_likuiditas = round(($ket_pronil / 3) * 100);







//////



//inheren reputasi
$inheren_reputasi1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2 IS NOT NULL AND TRIM(pilar1_2) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$irep_pilar1 = $inheren_reputasi1['jumlah'];


$inheren_reputasi2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) 
  AS jumlah
FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$irep_pilar2 = $inheren_reputasi2['jumlah'];

$inheren_reputasi3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$irep_pilar3 = $inheren_reputasi3['jumlah'];


$inheren_reputasi_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));
$irep_pilarl = $inheren_reputasi_lainnya['jumlah'];


$keterangan_inheren2_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_reputasi WHERE id_profil_risiko = '$id'"));
$irep_ket = $keterangan_inheren2_reputasi['jumlah'];


$inheren_reputasi = round((($irep_pilar1 + $irep_pilar2 + $irep_pilar3 + $irep_pilarl + $irep_ket) / 40) * 100);


//kpmr reputasi
$kpmr_reputasi_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar1 WHERE id_profil_risiko ='$id'"));
$krep_pilar1 = $kpmr_reputasi_pilar1['jumlah'];


$kpmr_reputasi_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar2 WHERE id_profil_risiko ='$id'"));
$krep_pilar2 = $kpmr_reputasi_pilar2['jumlah'];

$kpmr_reputasi_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar3 WHERE id_profil_risiko ='$id'"));
$krep_pilar3 = $kpmr_reputasi_pilar3['jumlah'];

$kpmr_reputasi_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_reputasi_pilar4 WHERE id_profil_risiko ='$id'"));
$krep_pilar4 = $kpmr_reputasi_pilar4['jumlah'];

$respon_unit_kerja_reputasi_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil1 WHERE id_profil_risiko ='$id'"));
$krep_ru1 = $respon_unit_kerja_reputasi_pil1['jumlah'];

$respon_unit_kerja_reputasi_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil2 WHERE id_profil_risiko ='$id'"));
$krep_ru2 = $respon_unit_kerja_reputasi_pil2['jumlah'];

$respon_unit_kerja_reputasi_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil3 WHERE id_profil_risiko ='$id'"));
$krep_ru3 = $respon_unit_kerja_reputasi_pil3['jumlah'];

$respon_unit_kerja_reputasi_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_reputasi_pil4 WHERE id_profil_risiko ='$id'"));
$krep_ru4 = $respon_unit_kerja_reputasi_pil4['jumlah'];

$keterangan_kpmr2_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_reputasi WHERE id_profil_risiko ='$id'"));
$krep_ket = $keterangan_kpmr2_reputasi['jumlah'];

$kpmr_reputasi = round((($krep_pilar1 + $krep_pilar2 + $krep_pilar3 + $krep_pilar4 + $krep_ru1 + $krep_ru2 + $krep_ru3 + $krep_ru4 + $krep_ket) / 157) * 100);


//profil reputasi
$keterangan_profil_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_reputasi WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_reputasi['jumlah'];

$pronil_reputasi = round(($ket_pronil / 3) * 100);








///





//inheren stratejik
$inheren_stratejik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar1_1 IS NOT NULL AND TRIM(pilar1_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar1_1f IS NOT NULL AND TRIM(pilar1_1f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$istra_pilar1 = $inheren_stratejik1['jumlah'];


$inheren_stratejik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar2_1 IS NOT NULL AND TRIM(pilar2_1) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1f IS NOT NULL AND TRIM(pilar2_1f) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1g IS NOT NULL AND TRIM(pilar2_1g) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1h IS NOT NULL AND TRIM(pilar2_1h) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_1i IS NOT NULL AND TRIM(pilar2_1i) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2 IS NOT NULL AND TRIM(pilar2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END)
  AS jumlah
FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$istra_pilar2 = $inheren_stratejik2['jumlah'];

$inheren_stratejik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1 IS NOT NULL AND TRIM(pilar3_1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1k IS NOT NULL AND TRIM(pilar3_1k) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1l IS NOT NULL AND TRIM(pilar3_1l) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1m IS NOT NULL AND TRIM(pilar3_1m) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1n IS NOT NULL AND TRIM(pilar3_1n) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1o IS NOT NULL AND TRIM(pilar3_1o) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1p IS NOT NULL AND TRIM(pilar3_1p) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2 IS NOT NULL AND TRIM(pilar3_2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2f IS NOT NULL AND TRIM(pilar3_2f) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$istra_pilar3 = $inheren_stratejik3['jumlah'];


$inheren_stratejik_lainnya = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) + 
  SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));
$istra_pilarl = $inheren_stratejik_lainnya['jumlah'];


$keterangan_inheren2_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
  SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
  SUM(CASE WHEN ket_inheren IS NOT NULL AND TRIM(ket_inheren) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_inheren2_stratejik WHERE id_profil_risiko = '$id'"));
$istra_ket = $keterangan_inheren2_stratejik['jumlah'];


$inheren_stratejik = round((($istra_pilar1 + $istra_pilar2 + $istra_pilar3 + $istra_pilarl + $istra_ket) / 60) * 100);


//kpmr stratejik
$kpmr_stratejik_pilar1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar1_1a IS NOT NULL AND TRIM(pilar1_1a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1b IS NOT NULL AND TRIM(pilar1_1b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1c IS NOT NULL AND TRIM(pilar1_1c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1d IS NOT NULL AND TRIM(pilar1_1d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_1e IS NOT NULL AND TRIM(pilar1_1e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total1 IS NOT NULL AND TRIM(pil1_total1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat1 IS NOT NULL AND TRIM(pil1_peringkat1) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_2a IS NOT NULL AND TRIM(pilar1_2a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2b IS NOT NULL AND TRIM(pilar1_2b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2c IS NOT NULL AND TRIM(pilar1_2c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2d IS NOT NULL AND TRIM(pilar1_2d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_2e IS NOT NULL AND TRIM(pilar1_2e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total2 IS NOT NULL AND TRIM(pil1_total2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat2 IS NOT NULL AND TRIM(pil1_peringkat2) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_3a IS NOT NULL AND TRIM(pilar1_3a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3b IS NOT NULL AND TRIM(pilar1_3b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_3c IS NOT NULL AND TRIM(pilar1_3c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total3 IS NOT NULL AND TRIM(pil1_total3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat3 IS NOT NULL AND TRIM(pil1_peringkat3) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_4a IS NOT NULL AND TRIM(pilar1_4a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4b IS NOT NULL AND TRIM(pilar1_4b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4c IS NOT NULL AND TRIM(pilar1_4c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4d IS NOT NULL AND TRIM(pilar1_4d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_4e IS NOT NULL AND TRIM(pilar1_4e) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total4 IS NOT NULL AND TRIM(pil1_total4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat4 IS NOT NULL AND TRIM(pil1_peringkat4) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_5a IS NOT NULL AND TRIM(pilar1_5a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5b IS NOT NULL AND TRIM(pilar1_5b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5c IS NOT NULL AND TRIM(pilar1_5c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_5d IS NOT NULL AND TRIM(pilar1_5d) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total5 IS NOT NULL AND TRIM(pil1_total5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat5 IS NOT NULL AND TRIM(pil1_peringkat5) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pilar1_6a IS NOT NULL AND TRIM(pilar1_6a) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6b IS NOT NULL AND TRIM(pilar1_6b) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar1_6c IS NOT NULL AND TRIM(pilar1_6c) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil1_total6 IS NOT NULL AND TRIM(pil1_total6) <> '' THEN 1 ELSE 0 END) +  
    SUM(CASE WHEN pil1_peringkat6 IS NOT NULL AND TRIM(pil1_peringkat6) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar1 WHERE id_profil_risiko ='$id'"));
$kstra_pilar1 = $kpmr_stratejik_pilar1['jumlah'];


$kpmr_stratejik_pilar2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar2_1a IS NOT NULL AND TRIM(pilar2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1b IS NOT NULL AND TRIM(pilar2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1c IS NOT NULL AND TRIM(pilar2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1d IS NOT NULL AND TRIM(pilar2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_1e IS NOT NULL AND TRIM(pilar2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total1 IS NOT NULL AND TRIM(pil2_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat1 IS NOT NULL AND TRIM(pil2_peringkat1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2a IS NOT NULL AND TRIM(pilar2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2b IS NOT NULL AND TRIM(pilar2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2c IS NOT NULL AND TRIM(pilar2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2d IS NOT NULL AND TRIM(pilar2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2e IS NOT NULL AND TRIM(pilar2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2f IS NOT NULL AND TRIM(pilar2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2g IS NOT NULL AND TRIM(pilar2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_2h IS NOT NULL AND TRIM(pilar2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total2 IS NOT NULL AND TRIM(pil2_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil2_peringkat2 IS NOT NULL AND TRIM(pil2_peringkat2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3a IS NOT NULL AND TRIM(pilar2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3b IS NOT NULL AND TRIM(pilar2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar2_3c IS NOT NULL AND TRIM(pilar2_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_total3 IS NOT NULL AND TRIM(pil2_total3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil2_peringkat3 IS NOT NULL AND TRIM(pil2_peringkat3) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar2 WHERE id_profil_risiko ='$id'"));
$kstra_pilar2 = $kpmr_stratejik_pilar2['jumlah'];

$kpmr_stratejik_pilar3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar3_1a IS NOT NULL AND TRIM(pilar3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1b IS NOT NULL AND TRIM(pilar3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1c IS NOT NULL AND TRIM(pilar3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1d IS NOT NULL AND TRIM(pilar3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1e IS NOT NULL AND TRIM(pilar3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1f IS NOT NULL AND TRIM(pilar3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1g IS NOT NULL AND TRIM(pilar3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1h IS NOT NULL AND TRIM(pilar3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1i IS NOT NULL AND TRIM(pilar3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_1j IS NOT NULL AND TRIM(pilar3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total1 IS NOT NULL AND TRIM(pil3_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat1 IS NOT NULL AND TRIM(pil3_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar3_2a IS NOT NULL AND TRIM(pilar3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2b IS NOT NULL AND TRIM(pilar3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2c IS NOT NULL AND TRIM(pilar3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2d IS NOT NULL AND TRIM(pilar3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar3_2e IS NOT NULL AND TRIM(pilar3_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil3_total2 IS NOT NULL AND TRIM(pil3_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil3_peringkat2 IS NOT NULL AND TRIM(pil3_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar3 WHERE id_profil_risiko ='$id'"));
$kstra_pilar3 = $kpmr_stratejik_pilar3['jumlah'];

$kpmr_stratejik_pilar4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN pilar4_1a IS NOT NULL AND TRIM(pilar4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1b IS NOT NULL AND TRIM(pilar4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1c IS NOT NULL AND TRIM(pilar4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1d IS NOT NULL AND TRIM(pilar4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_1e IS NOT NULL AND TRIM(pilar4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total1 IS NOT NULL AND TRIM(pil4_total1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat1 IS NOT NULL AND TRIM(pil4_peringkat1) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pilar4_2a IS NOT NULL AND TRIM(pilar4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pilar4_2b IS NOT NULL AND TRIM(pilar4_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN pil4_total2 IS NOT NULL AND TRIM(pil4_total2) <> '' THEN 1 ELSE 0 END) + 
    SUM(CASE WHEN pil4_peringkat2 IS NOT NULL AND TRIM(pil4_peringkat2) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM kpmr_stratejik_pilar4 WHERE id_profil_risiko ='$id'"));
$kstra_pilar4 = $kpmr_stratejik_pilar4['jumlah'];

$respon_unit_kerja_stratejik_pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil1_1a IS NOT NULL AND TRIM(respon_pil1_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1b IS NOT NULL AND TRIM(respon_pil1_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1c IS NOT NULL AND TRIM(respon_pil1_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1d IS NOT NULL AND TRIM(respon_pil1_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_1e IS NOT NULL AND TRIM(respon_pil1_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2a IS NOT NULL AND TRIM(respon_pil1_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2b IS NOT NULL AND TRIM(respon_pil1_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2c IS NOT NULL AND TRIM(respon_pil1_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2d IS NOT NULL AND TRIM(respon_pil1_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_2e IS NOT NULL AND TRIM(respon_pil1_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3a IS NOT NULL AND TRIM(respon_pil1_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3b IS NOT NULL AND TRIM(respon_pil1_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_3c IS NOT NULL AND TRIM(respon_pil1_3c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4a IS NOT NULL AND TRIM(respon_pil1_4a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4b IS NOT NULL AND TRIM(respon_pil1_4b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4c IS NOT NULL AND TRIM(respon_pil1_4c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4d IS NOT NULL AND TRIM(respon_pil1_4d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_4e IS NOT NULL AND TRIM(respon_pil1_4e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5a IS NOT NULL AND TRIM(respon_pil1_5a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5b IS NOT NULL AND TRIM(respon_pil1_5b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5c IS NOT NULL AND TRIM(respon_pil1_5c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_5d IS NOT NULL AND TRIM(respon_pil1_5d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6a IS NOT NULL AND TRIM(respon_pil1_6a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6b IS NOT NULL AND TRIM(respon_pil1_6b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil1_6c IS NOT NULL AND TRIM(respon_pil1_6c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil1 WHERE id_profil_risiko ='$id'"));
$kstra_ru1 = $respon_unit_kerja_stratejik_pil1['jumlah'];

$respon_unit_kerja_stratejik_pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil2_1a IS NOT NULL AND TRIM(respon_pil2_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1b IS NOT NULL AND TRIM(respon_pil2_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1c IS NOT NULL AND TRIM(respon_pil2_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1d IS NOT NULL AND TRIM(respon_pil2_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_1e IS NOT NULL AND TRIM(respon_pil2_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2a IS NOT NULL AND TRIM(respon_pil2_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2b IS NOT NULL AND TRIM(respon_pil2_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2c IS NOT NULL AND TRIM(respon_pil2_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2d IS NOT NULL AND TRIM(respon_pil2_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2e IS NOT NULL AND TRIM(respon_pil2_2e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2f IS NOT NULL AND TRIM(respon_pil2_2f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2g IS NOT NULL AND TRIM(respon_pil2_2g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_2h IS NOT NULL AND TRIM(respon_pil2_2h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3a IS NOT NULL AND TRIM(respon_pil2_3a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3b IS NOT NULL AND TRIM(respon_pil2_3b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil2_3c IS NOT NULL AND TRIM(respon_pil2_3c) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil2 WHERE id_profil_risiko ='$id'"));
$kstra_ru2 = $respon_unit_kerja_stratejik_pil2['jumlah'];

$respon_unit_kerja_stratejik_pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil3_1a IS NOT NULL AND TRIM(respon_pil3_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1b IS NOT NULL AND TRIM(respon_pil3_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1c IS NOT NULL AND TRIM(respon_pil3_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1d IS NOT NULL AND TRIM(respon_pil3_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1e IS NOT NULL AND TRIM(respon_pil3_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1f IS NOT NULL AND TRIM(respon_pil3_1f) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1g IS NOT NULL AND TRIM(respon_pil3_1g) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1h IS NOT NULL AND TRIM(respon_pil3_1h) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1i IS NOT NULL AND TRIM(respon_pil3_1i) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_1j IS NOT NULL AND TRIM(respon_pil3_1j) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2a IS NOT NULL AND TRIM(respon_pil3_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2b IS NOT NULL AND TRIM(respon_pil3_2b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2c IS NOT NULL AND TRIM(respon_pil3_2c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2d IS NOT NULL AND TRIM(respon_pil3_2d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil3_2e IS NOT NULL AND TRIM(respon_pil3_2e) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil3 WHERE id_profil_risiko ='$id'"));
$kstra_ru3 = $respon_unit_kerja_stratejik_pil3['jumlah'];

$respon_unit_kerja_stratejik_pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN respon_pil4_1a IS NOT NULL AND TRIM(respon_pil4_1a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1b IS NOT NULL AND TRIM(respon_pil4_1b) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1c IS NOT NULL AND TRIM(respon_pil4_1c) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1d IS NOT NULL AND TRIM(respon_pil4_1d) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_1e IS NOT NULL AND TRIM(respon_pil4_1e) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2a IS NOT NULL AND TRIM(respon_pil4_2a) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN respon_pil4_2b IS NOT NULL AND TRIM(respon_pil4_2b) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM respon_unit_kerja_stratejik_pil4 WHERE id_profil_risiko ='$id'"));
$kstra_ru4 = $respon_unit_kerja_stratejik_pil4['jumlah'];

$keterangan_kpmr2_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_pil1_1 IS NOT NULL AND TRIM(ket_pil1_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_2 IS NOT NULL AND TRIM(ket_pil1_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_3 IS NOT NULL AND TRIM(ket_pil1_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_4 IS NOT NULL AND TRIM(ket_pil1_4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_5 IS NOT NULL AND TRIM(ket_pil1_5) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1_6 IS NOT NULL AND TRIM(ket_pil1_6) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil1 IS NOT NULL AND TRIM(ket_pil1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_1 IS NOT NULL AND TRIM(ket_pil2_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_2 IS NOT NULL AND TRIM(ket_pil2_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2_3 IS NOT NULL AND TRIM(ket_pil2_3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil2 IS NOT NULL AND TRIM(ket_pil2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_1 IS NOT NULL AND TRIM(ket_pil3_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3_2 IS NOT NULL AND TRIM(ket_pil3_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil3 IS NOT NULL AND TRIM(ket_pil3) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_1 IS NOT NULL AND TRIM(ket_pil4_1) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4_2 IS NOT NULL AND TRIM(ket_pil4_2) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_pil4 IS NOT NULL AND TRIM(ket_pil4) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_kpmr IS NOT NULL AND TRIM(ket_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_kpmr2_stratejik WHERE id_profil_risiko ='$id'"));
$kstra_ket = $keterangan_kpmr2_stratejik['jumlah'];

$kpmr_stratejik = round((($kstra_pilar1 + $kstra_pilar2 + $kstra_pilar3 + $kstra_pilar4 + $kstra_ru1 + $kstra_ru2 + $kstra_ru3 + $kstra_ru4 + $kstra_ket) / 157) * 100);


//profil stratejik
$keterangan_profil_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_profil_risiko IS NOT NULL AND TRIM(ket_profil_risiko) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_inheren IS NOT NULL AND TRIM(ket_profil_inheren) <> '' THEN 1 ELSE 0 END) +
    SUM(CASE WHEN ket_profil_kpmr IS NOT NULL AND TRIM(ket_profil_kpmr) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM keterangan_profil_stratejik WHERE id_profil_risiko ='$id'"));
$ket_pronil = $keterangan_profil_stratejik['jumlah'];

$pronil_stratejik = round(($ket_pronil / 3) * 100);





//profil nilai
$nilai_profil = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_nilai_risiko IS NOT NULL AND TRIM(ket_nilai_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM nilai_profil WHERE id_profil_risiko ='$id'"));
$profil_nilai_uraian = $nilai_profil['jumlah'];

$pronil_uraian = round(($profil_nilai_uraian / 1) * 100);


//profil peringkat
$peringkat_profil = mysqli_fetch_array(mysqli_query($conn, "SELECT 
  	id_profil_risiko,
    SUM(CASE WHEN ket_peringkat_risiko IS NOT NULL AND TRIM(ket_peringkat_risiko) <> '' THEN 1 ELSE 0 END) AS jumlah
FROM peringkat_profil WHERE id_profil_risiko ='$id'"));
$profil_peringkat_uraian = $peringkat_profil['jumlah'];

$proper_uraian = round(($profil_peringkat_uraian / 1) * 100);




/* ============================================================
   FIX PROGRESS DINAMIS - KREDIT, KEPATUHAN, LIKUIDITAS
   Membaca persentase dari form yang benar-benar memiliki skala
   dan sudah diisi nilai penilaiannya.
   ============================================================ */
if (!function_exists('prog_table_exists')) {
function prog_table_exists($conn, $table){
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}}

if (!function_exists('prog_one')) {
function prog_one($conn, $sql){
    $q = mysqli_query($conn, $sql);
    return ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : [];
}}

if (!function_exists('prog_clamp_pct')) {
function prog_clamp_pct($v){
    $v = (float)$v;
    if ($v < 0) $v = 0;
    if ($v > 100) $v = 100;
    return (int)round($v);
}}

if (!function_exists('prog_skala_has_value')) {
function prog_skala_has_value($conn, $table, $periode_col, $periode_id, $ref_tipe, $ref_id){
    // Disamakan dengan halaman form: input Penilaian/Keterangan hanya muncul
    // jika skala 1,2,3,4,5 lengkap semua. Jika tidak lengkap, item tidak dihitung.
    if (!prog_table_exists($conn, $table)) return true; // fallback aman jika tabel skala belum ada
    $table = mysqli_real_escape_string($conn, $table);
    $periode_col = preg_replace('/[^a-zA-Z0-9_]/', '', (string)$periode_col);
    $periode_id = (int)$periode_id;
    $ref_tipe = mysqli_real_escape_string($conn, (string)$ref_tipe);
    $ref_id = (int)$ref_id;

    $q = mysqli_query($conn, "
        SELECT skala, deskripsi
        FROM `$table`
        WHERE ref_tipe = '$ref_tipe'
          AND ref_id = '$ref_id'
          AND `$periode_col` = '$periode_id'
          AND skala BETWEEN 1 AND 5
    ");

    if (!$q) return true;

    $isi = [];
    while($r = mysqli_fetch_assoc($q)){
        $sk = (int)($r['skala'] ?? 0);
        if ($sk < 1 || $sk > 5) continue;
        $v = trim(strip_tags((string)($r['deskripsi'] ?? '')));
        $v = str_replace(["&nbsp;", "Â ", "\xc2\xa0"], ' ', $v);
        $v = trim($v);
        if ($v !== '' && $v !== '-' && $v !== '–') {
            $isi[$sk] = true;
        }
    }

    for ($i = 1; $i <= 5; $i++) {
        if (empty($isi[$i])) return false;
    }
    return true;
}}

if (!function_exists('prog_dynamic_assessment_pct')) {
function prog_dynamic_assessment_pct($conn, $id, $frame, $jenis, $nama_risiko){
    $id = (int)$id;
    if ($id <= 0 || empty($frame)) return null;

    $jenis = strtolower((string)$jenis);
    $isKpmr = ($jenis === 'kpmr');

    $tblPilih       = $isKpmr ? 'kpmr_pilih_parameter'        : 'pr_pilih_parameter';
    $tblPilihDetail = $isKpmr ? 'kpmr_pilih_parameter_detail' : 'pr_pilih_parameter_detail';
    $tblPeriode     = $isKpmr ? 'kpmr_periode'                : 'pr_inheren_periode';
    $tblJenis       = $isKpmr ? 'kpmr_jenis_risiko'           : 'pr_jenis_risiko';
    $tblPilar       = $isKpmr ? 'kpmr_pilar'                  : 'pr_pilar';
    $tblParameter   = $isKpmr ? 'kpmr_parameter'              : 'pr_parameter';
    $tblSub         = $isKpmr ? 'kpmr_sub_parameter'          : 'pr_sub_parameter';
    $tblSkala       = $isKpmr ? 'kpmr_skala'                  : 'pr_skala';
    $periodeCol     = $isKpmr ? 'kpmr_periode_id'             : 'pr_inheren_periode_id';
    $tblAssess      = $isKpmr ? 'assessment_kpmr'             : 'assessment_inheren';
    $tblDetail      = $isKpmr ? 'assessment_kpmr_detail'      : 'assessment_inheren_detail';
    $idAssessCol    = $isKpmr ? 'id_assessment_kpmr'          : 'id_assessment_inheren';

    $required = [$tblPilih, $tblPilihDetail, $tblPeriode, $tblJenis, $tblPilar, $tblParameter, $tblAssess, $tblDetail];
    foreach ($required as $tb) {
        if (!prog_table_exists($conn, $tb)) return null;
    }

    $tahun = mysqli_real_escape_string($conn, (string)($frame['tahun'] ?? ''));
    $user  = (int)($frame['user'] ?? 0);
    if ($tahun === '' || $user <= 0) return null;

    $pilih = prog_one($conn, "
        SELECT pp.*, per.tahun
        FROM `$tblPilih` pp
        INNER JOIN `$tblPeriode` per ON pp.`$periodeCol` = per.id
        WHERE per.tahun = '$tahun'
          AND pp.id_user_profil_risiko = '$user'
        ORDER BY pp.id DESC
        LIMIT 1
    ");
    if (!$pilih) return null;

    $idPilih = (int)$pilih['id'];
    $periodeId = (int)$pilih[$periodeCol];

    $checkedParam = [];
    $checkedSub = [];
    $qCek = mysqli_query($conn, "
        SELECT ref_tipe, ref_id
        FROM `$tblPilihDetail`
        WHERE ".($isKpmr ? "kpmr_pilih_parameter_id" : "pr_pilih_parameter_id")." = '$idPilih'
    ");
    if ($qCek) {
        while($r = mysqli_fetch_assoc($qCek)){
            if ($r['ref_tipe'] === 'parameter') $checkedParam[(int)$r['ref_id']] = true;
            if ($r['ref_tipe'] === 'sub_parameter') $checkedSub[(int)$r['ref_id']] = true;
        }
    }

    $nama_risiko_sql = mysqli_real_escape_string($conn, strtoupper((string)$nama_risiko));
    $hasSub = prog_table_exists($conn, $tblSub);

    $sql = "
        SELECT
            pm.id AS parameter_id,
            ".($hasSub ? "sp.id" : "0")." AS sub_parameter_id
        FROM `$tblJenis` jr
        INNER JOIN `$tblPilar` p
            ON p.jenis_risiko_id = jr.id
           AND p.`$periodeCol` = '$periodeId'
        INNER JOIN `$tblParameter` pm
            ON pm.pilar_id = p.id
           AND pm.`$periodeCol` = '$periodeId'
        ".($hasSub ? "LEFT JOIN `$tblSub` sp ON sp.parameter_id = pm.id AND sp.`$periodeCol` = '$periodeId'" : "")."
        WHERE UPPER(jr.nama_risiko) = '$nama_risiko_sql'
          AND jr.`$periodeCol` = '$periodeId'
        ORDER BY p.urutan, pm.urutan".($hasSub ? ", sp.urutan" : "")."
    ";

    $qData = mysqli_query($conn, $sql);
    if (!$qData) return null;

    /*
      FIX AKURASI DINAMIS:
      Jika suatu parameter mempunyai sub-parameter yang dicentang, progress dihitung dari
      sub-parameter yang tampil/diisi saja. Parent parameter tidak ikut dihitung lagi.
      Penyebab progress nyangkut 89% biasanya karena parent parameter ikut menjadi denominator,
      padahal halaman form hanya menyimpan nilai sub-parameter.
    */
    $paramHasCheckedSub = [];
    $rawRows = [];
    while($r = mysqli_fetch_assoc($qData)){
        $pid = (int)$r['parameter_id'];
        $sid = (int)$r['sub_parameter_id'];
        $rawRows[] = ['pid'=>$pid, 'sid'=>$sid];
        if ($sid > 0 && isset($checkedSub[$sid])) {
            $paramHasCheckedSub[$pid] = true;
        }
    }

    $expected = [];
    foreach($rawRows as $r){
        $pid = (int)$r['pid'];
        $sid = (int)$r['sid'];

        if (isset($checkedParam[$pid]) && empty($paramHasCheckedSub[$pid]) && prog_skala_has_value($conn, $tblSkala, $periodeCol, $periodeId, 'parameter', $pid)) {
            $expected['parameter|'.$pid] = true;
        }

        if ($sid > 0 && isset($checkedSub[$sid]) && prog_skala_has_value($conn, $tblSkala, $periodeCol, $periodeId, 'sub_parameter', $sid)) {
            $expected['sub_parameter|'.$sid] = true;
        }
    }

    $total = count($expected);
    if ($total <= 0) return null;

    $assessment = prog_one($conn, "
        SELECT *
        FROM `$tblAssess`
        WHERE id_profil_risiko = '$id'
          AND UPPER(jenis_risiko) = '$nama_risiko_sql'
        LIMIT 1
    ");
    if (!$assessment) return 0;

    $aid = (int)$assessment[$idAssessCol];
    if ($aid <= 0) return 0;

    $filled = 0;
    $qIsi = mysqli_query($conn, "
        SELECT ref_tipe, ref_id, nilai, keterangan
        FROM `$tblDetail`
        WHERE `$idAssessCol` = '$aid'
    ");
    if ($qIsi) {
        while($r = mysqli_fetch_assoc($qIsi)){
            $key = $r['ref_tipe'].'|'.(int)$r['ref_id'];
            if (!isset($expected[$key])) continue;

            $nilai = (int)($r['nilai'] ?? 0);
            if ($nilai >= 1 && $nilai <= 5) {
                $filled++;
            }
        }
    }

    return prog_clamp_pct(($filled / $total) * 100);
}}

if (!function_exists('prog_profile_pct')) {
function prog_profile_pct($conn, $id, $table){
    $id = (int)$id;
    if ($id <= 0 || !prog_table_exists($conn, $table)) return null;
    $tableSafe = mysqli_real_escape_string($conn, $table);

    /*
      FIX AKURASI PROFIL:
      Untuk halaman Profil per Risiko, progress dibuat 100% ketika kolom
      Analisis Risiko / Risiko Inheren (ket_profil_inheren) sudah diisi.
      Ini mengikuti kebutuhan form cabang: profil tidak menunggu KPMR/field lain.
    */
    $cols = [];
    $qCols = mysqli_query($conn, "SHOW COLUMNS FROM `$tableSafe`");
    if ($qCols) {
        while($c = mysqli_fetch_assoc($qCols)) {
            $cols[$c['Field']] = true;
        }
    }

    $fields = [];
    if (isset($cols['ket_profil_inheren'])) {
        $fields[] = 'ket_profil_inheren';
    } elseif (isset($cols['ket_profil_risiko'])) {
        $fields[] = 'ket_profil_risiko';
    } else {
        foreach (['analisis_risiko','uraian_risiko','keterangan','ket_risiko'] as $f) {
            if (isset($cols[$f])) { $fields[] = $f; break; }
        }
    }

    if (empty($fields)) return null;

    $selectParts = [];
    foreach ($fields as $f) {
        $selectParts[] = "(CASE WHEN `$f` IS NOT NULL AND TRIM(`$f`) <> '' THEN 1 ELSE 0 END)";
    }

    $r = prog_one($conn, "
        SELECT (".implode(' + ', $selectParts).") AS jumlah
        FROM `$tableSafe`
        WHERE id_profil_risiko = '$id'
        LIMIT 1
    ");
    if (!$r) return 0;

    return prog_clamp_pct(((int)$r['jumlah'] / max(1, count($fields))) * 100);
}}

// Rapikan nilai agar tidak lebih dari 100% jika hitungan lama melebihi denominator.
$inheren_kredit      = prog_clamp_pct($inheren_kredit ?? 0);
$kpmr_kredit         = prog_clamp_pct($kpmr_kredit ?? 0);
$pronil_kredit       = prog_clamp_pct($pronil_kredit ?? 0);
$inheren_kepatuhan   = prog_clamp_pct($inheren_kepatuhan ?? 0);
$kpmr_kepatuhan      = prog_clamp_pct($kpmr_kepatuhan ?? 0);
$pronil_kepatuhan    = prog_clamp_pct($pronil_kepatuhan ?? 0);
$inheren_likuiditas  = prog_clamp_pct($inheren_likuiditas ?? 0);
$kpmr_likuiditas     = prog_clamp_pct($kpmr_likuiditas ?? 0);
$pronil_likuiditas   = prog_clamp_pct($pronil_likuiditas ?? 0);

// Override progress dari tabel assessment dinamis untuk Kredit, Kepatuhan, Likuiditas.
$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO KREDIT');
if ($dyn !== null) $kpmr_kredit = $dyn;

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'inheren', 'RISIKO KEPATUHAN');
if ($dyn !== null) $inheren_kepatuhan = $dyn;

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO KEPATUHAN');
if ($dyn !== null) $kpmr_kepatuhan = $dyn;

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO LIKUIDITAS');
if ($dyn !== null) $kpmr_likuiditas = $dyn;

// Profil memakai tabel profil masing-masing agar yang terbaca adalah uraian profil aktif.
$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_kredit');
if ($dynProfil !== null) $pronil_kredit = $dynProfil;

$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_kepatuhan');
if ($dynProfil !== null) $pronil_kepatuhan = $dynProfil;

$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_likuiditas');
if ($dynProfil !== null) $pronil_likuiditas = $dynProfil;


// === TAMBAHAN FIX: progress dinamis untuk Operasional, Reputasi, dan Stratejik ===
// Membaca dari form assessment yang benar-benar dipilih dan mempunyai skala 1-5.
$inheren_operasional = prog_clamp_pct($inheren_operasional ?? 0);
$kpmr_operasional    = prog_clamp_pct($kpmr_operasional ?? 0);
$pronil_operasional  = prog_clamp_pct($pronil_operasional ?? 0);
$inheren_reputasi    = prog_clamp_pct($inheren_reputasi ?? 0);
$kpmr_reputasi       = prog_clamp_pct($kpmr_reputasi ?? 0);
$pronil_reputasi     = prog_clamp_pct($pronil_reputasi ?? 0);
$inheren_stratejik   = prog_clamp_pct($inheren_stratejik ?? 0);
$kpmr_stratejik      = prog_clamp_pct($kpmr_stratejik ?? 0);
$pronil_stratejik    = prog_clamp_pct($pronil_stratejik ?? 0);

// Simpan hitungan lama/referensi Stratejik yang sudah menghitung kolom keterangan.
// Jangan sampai progress dinamis menimpa jadi 100% padahal masih ada keterangan kosong.
$legacy_inheren_stratejik = $inheren_stratejik;
$legacy_kpmr_stratejik    = $kpmr_stratejik;
$pronil_uraian       = prog_clamp_pct($pronil_uraian ?? 0);

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'inheren', 'RISIKO OPERASIONAL');
if ($dyn !== null) $inheren_operasional = $dyn;
$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO OPERASIONAL');
if ($dyn !== null) $kpmr_operasional = $dyn;

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'inheren', 'RISIKO REPUTASI');
if ($dyn !== null) $inheren_reputasi = $dyn;
$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO REPUTASI');
if ($dyn !== null) $kpmr_reputasi = $dyn;

$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'inheren', 'RISIKO STRATEJIK');
if ($dyn !== null) $inheren_stratejik = $dyn;
$dyn = prog_dynamic_assessment_pct($conn, $id, $frame, 'kpmr', 'RISIKO STRATEJIK');
if ($dyn !== null) $kpmr_stratejik = $dyn;

// FIX AKURASI STRATEJIK:
// Hitungan dinamis membaca nilai assessment, sedangkan keterangan Stratejik berada di tabel keterangan_*_stratejik.
// Jika masih ada 1 keterangan kosong, progress tidak boleh menjadi 100%.
if (isset($legacy_inheren_stratejik) && $legacy_inheren_stratejik > 0 && $legacy_inheren_stratejik < 100 && $inheren_stratejik >= 100) {
    $inheren_stratejik = $legacy_inheren_stratejik;
}
if (isset($legacy_kpmr_stratejik) && $legacy_kpmr_stratejik > 0 && $legacy_kpmr_stratejik < 100 && $kpmr_stratejik >= 100) {
    $kpmr_stratejik = $legacy_kpmr_stratejik;
}

$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_operasional');
if ($dynProfil !== null) $pronil_operasional = $dynProfil;
$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_reputasi');
if ($dynProfil !== null) $pronil_reputasi = $dynProfil;
$dynProfil = prog_profile_pct($conn, $id, 'keterangan_profil_stratejik');
if ($dynProfil !== null) $pronil_stratejik = $dynProfil;

// === FIX FINAL: kalau progress nyangkut 75% karena field/form otomatis disembunyikan,
// anggap selesai 100% jika minimal sudah 75%.
// Ini khusus untuk kondisi form dinamis yang kolom penilaian/keterangan tidak tampil
// saat skala tidak lengkap, sehingga denominator lama masih menghitung item yang tidak wajib.
if (!function_exists('prog_finish_75_to_100')) {
function prog_finish_75_to_100($v){
    /*
      FIX AKURASI:
      Jangan paksa 75% menjadi 100%.
      Progress 100% hanya boleh muncul kalau hitungan field wajib benar-benar lengkap.
    */
    return prog_clamp_pct($v);
}}

$inheren_kredit      = prog_finish_75_to_100($inheren_kredit ?? 0);
$kpmr_kredit         = prog_finish_75_to_100($kpmr_kredit ?? 0);
$pronil_kredit       = prog_finish_75_to_100($pronil_kredit ?? 0);

$inheren_operasional = prog_finish_75_to_100($inheren_operasional ?? 0);
$kpmr_operasional    = prog_finish_75_to_100($kpmr_operasional ?? 0);
$pronil_operasional  = prog_finish_75_to_100($pronil_operasional ?? 0);

$inheren_kepatuhan   = prog_finish_75_to_100($inheren_kepatuhan ?? 0);
$kpmr_kepatuhan      = prog_finish_75_to_100($kpmr_kepatuhan ?? 0);
$pronil_kepatuhan    = prog_finish_75_to_100($pronil_kepatuhan ?? 0);

$inheren_likuiditas  = prog_finish_75_to_100($inheren_likuiditas ?? 0);
$kpmr_likuiditas     = prog_finish_75_to_100($kpmr_likuiditas ?? 0);
$pronil_likuiditas   = prog_finish_75_to_100($pronil_likuiditas ?? 0);

$inheren_reputasi    = prog_finish_75_to_100($inheren_reputasi ?? 0);
$kpmr_reputasi       = prog_finish_75_to_100($kpmr_reputasi ?? 0);
$pronil_reputasi     = prog_finish_75_to_100($pronil_reputasi ?? 0);

$inheren_stratejik   = prog_finish_75_to_100($inheren_stratejik ?? 0);
$kpmr_stratejik      = prog_finish_75_to_100($kpmr_stratejik ?? 0);
$pronil_stratejik    = prog_finish_75_to_100($pronil_stratejik ?? 0);

// Profil Nilai selesai jika seluruh profil risiko per jenis sudah selesai.
$__profil_parts = [
    $pronil_kredit ?? 0,
    $pronil_operasional ?? 0,
    $pronil_kepatuhan ?? 0,
    $pronil_likuiditas ?? 0,
    $pronil_reputasi ?? 0,
    $pronil_stratejik ?? 0
];
$__profil_done = true;
foreach ($__profil_parts as $__p) {
    if ((float)$__p < 100) { $__profil_done = false; break; }
}
if ($__profil_done) {
    $pronil_uraian = 100;
} else {
    $pronil_uraian = prog_finish_75_to_100($pronil_uraian ?? 0);
}


?>


<style>
/* ===============================
   MODERN PROGRESS PAGE - FIX CSS RAW TEXT
   =============================== */
.progress-modern-page{
    --pm-primary:#6366f1;
    --pm-primary2:#14b8a6;
    --pm-info:#38bdf8;
    --pm-text:#1e293b;
    --pm-muted:#64748b;
    --pm-border:#e5e7eb;
    --pm-soft:#f8fafc;
    background:linear-gradient(180deg,#f8fafc 0%,#eef2f7 100%);
    min-height:100vh;
}
.progress-modern-page .container-fluid{padding-left:26px;padding-right:26px;}
.progress-modern-page .page-title-box{padding:20px 0 16px;}
.progress-modern-page .page-title{font-weight:800;color:#334155;letter-spacing:.2px;}
.progress-modern-page .breadcrumb a{color:#6366f1;font-weight:700;}
.progress-modern-page .card{
    border:0!important;
    border-radius:24px!important;
    overflow:hidden;
    background:rgba(255,255,255,.96)!important;
    box-shadow:0 18px 46px rgba(15,23,42,.075)!important;
}
.progress-modern-page .card-body{padding:28px!important;}
.progress-modern-page .hero-card{
    position:relative;
    background:
        radial-gradient(circle at 0% 0%,rgba(99,102,241,.14),transparent 30%),
        radial-gradient(circle at 96% 20%,rgba(20,184,166,.16),transparent 32%),
        linear-gradient(135deg,#fff 0%,#f8fbff 100%)!important;
    border:1px solid rgba(99,102,241,.12)!important;
}
.progress-modern-page .hero-card:before{
    content:"";
    position:absolute;
    inset:0 0 auto 0;
    height:5px;
    background:linear-gradient(90deg,#6366f1,#38bdf8,#14b8a6);
}
.progress-modern-page .badge-risk{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 13px;
    border-radius:999px;
    background:#eef2ff;
    color:#4f46e5;
    font-size:12px;
    font-weight:800;
    border:1px solid rgba(99,102,241,.14);
    margin-bottom:13px;
}
.progress-modern-page .hero-title{
    font-size:21px;
    font-weight:850;
    color:var(--pm-text);
    margin:0 0 7px;
    letter-spacing:-.2px;
}
.progress-modern-page .hero-subtitle{
    color:var(--pm-muted);
    margin:0;
    font-size:14px;
    font-weight:500;
}
.progress-modern-page .nav.bg-nav-pills{
    background:#eef2f7!important;
    border-radius:22px;
    padding:10px;
    gap:8px;
    display:flex;
    box-shadow:inset 0 0 0 1px rgba(148,163,184,.22);
}
.progress-modern-page .nav.bg-nav-pills .nav-item{flex:1 1 0;}
.progress-modern-page .nav.bg-nav-pills .nav-link{
    border-radius:16px!important;
    border:1px solid transparent!important;
    color:#475569!important;
    background:transparent!important;
    font-weight:800;
    padding:13px 8px!important;
    transition:all .2s ease;
    letter-spacing:.1px;
}
.progress-modern-page .nav.bg-nav-pills .nav-link:hover{
    background:#fff!important;
    color:#4f46e5!important;
    transform:translateY(-1px);
    box-shadow:0 10px 20px rgba(15,23,42,.06);
}
.progress-modern-page .nav.bg-nav-pills .nav-link.active{
    background:linear-gradient(135deg,#6366f1 0%,#38bdf8 100%)!important;
    color:#fff!important;
    box-shadow:0 14px 26px rgba(79,70,229,.22);
}
.progress-modern-page .tab-content{margin-top:24px;}
.progress-modern-page .table-responsive-sm{
    border-radius:22px;
    background:#fff;
    padding:16px;
    border:1px solid rgba(226,232,240,.95);
    box-shadow:0 14px 30px rgba(15,23,42,.04);
}
.progress-modern-page table.table{
    border-collapse:separate!important;
    border-spacing:0 12px!important;
    background:transparent!important;
    margin-bottom:0!important;
}
.progress-modern-page table.table thead th{
    background:linear-gradient(135deg,#e0f2fe 0%,#ecfeff 100%)!important;
    border:0!important;
    color:#0f172a!important;
    font-weight:850!important;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:.35px;
    padding:18px 16px!important;
}
.progress-modern-page table.table thead th:first-child{border-radius:18px 0 0 18px;}
.progress-modern-page table.table thead th:last-child{border-radius:0 18px 18px 0;}
.progress-modern-page table.table tbody{background:transparent!important;}
.progress-modern-page table.table tbody tr{background:transparent!important;}
.progress-modern-page table.table tbody td{
    border:0!important;
    border-top:1px solid var(--pm-border)!important;
    border-bottom:1px solid var(--pm-border)!important;
    background:#fff!important;
    vertical-align:middle!important;
    padding:18px 16px!important;
    color:#334155;
    font-weight:750;
    box-shadow:0 10px 24px rgba(15,23,42,.04);
}
.progress-modern-page table.table tbody td:first-child{
    border-left:1px solid var(--pm-border)!important;
    border-radius:18px 0 0 18px;
    width:280px;
    color:#1e293b;
}
.progress-modern-page table.table tbody td:last-child{
    border-right:1px solid var(--pm-border)!important;
    border-radius:0 18px 18px 0;
}
.progress-modern-page .progress{
    height:24px!important;
    border-radius:999px!important;
    background:#edf2f7!important;
    overflow:hidden;
    box-shadow:inset 0 2px 6px rgba(15,23,42,.10);
}
.progress-modern-page .progress-bar{
    min-width:38px;
    border-radius:999px!important;
    font-weight:850!important;
    font-size:12px!important;
    color:#fff!important;
    transition:width .4s ease;
    background:linear-gradient(90deg,#14b8a6 0%,#22c55e 100%)!important;
    box-shadow:0 7px 16px rgba(34,197,94,.22);
}
.progress-modern-page .progress-bar[data-progress="0"],
.progress-modern-page .progress-bar[aria-valuenow="0"]{
    min-width:0!important;
    color:transparent!important;
    background:transparent!important;
    box-shadow:none!important;
}
.progress-modern-page .progress-summary-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    border-radius:999px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    padding:8px 12px;
    color:#475569;
    font-weight:800;
    font-size:12px;
    margin-top:10px;
}
@media(max-width:768px){
    .progress-modern-page .container-fluid{padding-left:14px;padding-right:14px;}
    .progress-modern-page .nav.bg-nav-pills{display:grid;grid-template-columns:1fr 1fr;}
    .progress-modern-page table.table tbody td:first-child{width:auto;}
    .progress-modern-page .card-body{padding:20px!important;}
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.progress-modern-page .progress-bar').forEach(function(bar){
        var raw = bar.getAttribute('data-progress') || bar.getAttribute('aria-valuenow') || bar.textContent || '0';
        var val = parseInt(String(raw).replace('%','').trim(), 10);
        if (isNaN(val)) val = 0;
        if (val < 0) val = 0;
        if (val > 100) val = 100;
        // FIX: jangan paksa 75% menjadi 100%.
        // Lebar bar harus selalu mengikuti nilai server, supaya label 100% tidak tampil setengah.
        bar.setAttribute('data-progress', val);
        bar.setAttribute('aria-valuenow', val);
        bar.style.width = val + '%';
        bar.textContent = val > 0 ? (val + ' %') : '';
        if (val >= 100) {
            bar.style.background = 'linear-gradient(90deg,#14b8a6 0%,#22c55e 100%)';
        } else if (val >= 75) {
            bar.style.background = 'linear-gradient(90deg,#06b6d4 0%,#3b82f6 100%)';
        } else if (val >= 40) {
            bar.style.background = 'linear-gradient(90deg,#f59e0b 0%,#f97316 100%)';
        } else if (val > 0) {
            bar.style.background = 'linear-gradient(90deg,#ef4444 0%,#f97316 100%)';
        }
    });
});
</script>


<div class="content-page progress-modern-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Simpro</a></li>
                                <li class="breadcrumb-item active">Laporan Masuk</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Progress Pengerjaan</h4>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card hero-card">
                        <div class="card-body">
                            <div class="badge-risk">Progress Monitoring Profil Risiko</div>
                            <h4 class="hero-title">Progress Pengerjaan Profil Risiko <?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?></h4>
                            <p class="hero-subtitle">Persentase pengerjaan form yang sudah terisi untuk masing-masing risiko.</p>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>
            <!-- end row-->


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <ul class="nav nav-pills nav-justified mb-4 modern-tabs">
                                    <li class="nav-item">
                                        <a href="#kredit" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">

                                            <span class="d-none d-md-block">Kredit</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#operasional" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Operasional</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#kepatuhan" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Kepatuhan</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#likuiditas" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Likuiditas</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#reputasi" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Reputasi</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#stratejik" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Stratejik</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#profil" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0">

                                            <span class="d-none d-md-block">Profil Nilai</span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane show active" id="kredit">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Kredit</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_kredit ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_kredit ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_kredit ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_kredit ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Kredit</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_kredit ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_kredit ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_kredit ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_kredit ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Kredit</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_kredit ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_kredit ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_kredit ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_kredit ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="operasional">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Operasional</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_operasional ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_operasional ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_operasional ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_operasional ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Operasional</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_operasional ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_operasional ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_operasional ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_operasional ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Operasional</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_operasional ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_operasional ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_operasional ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_operasional ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="kepatuhan">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Kepatuhan</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_kepatuhan ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_kepatuhan ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_kepatuhan ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_kepatuhan ?? 0) ?> %</div>
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Kepatuhan</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_kepatuhan ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_kepatuhan ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_kepatuhan ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_kepatuhan ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Kepatuhan</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_kepatuhan ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_kepatuhan ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_kepatuhan ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_kepatuhan ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="likuiditas">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Likuiditas</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_likuiditas ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_likuiditas ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_likuiditas ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_likuiditas ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Likuiditas</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_likuiditas ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_likuiditas ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_likuiditas ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_likuiditas ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Likuiditas</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_likuiditas ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_likuiditas ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_likuiditas ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_likuiditas ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="reputasi">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Reputasi</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_reputasi ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_reputasi ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_reputasi ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_reputasi ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Reputasi</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_reputasi ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_reputasi ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_reputasi ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_reputasi ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Reputasi</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_reputasi ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_reputasi ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_reputasi ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_reputasi ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="stratejik">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Inheren Stratejik</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($inheren_stratejik ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($inheren_stratejik ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($inheren_stratejik ?? 0) ?>%"><?= (int)prog_finish_75_to_100($inheren_stratejik ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Stratejik</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($kpmr_stratejik ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($kpmr_stratejik ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($kpmr_stratejik ?? 0) ?>%"><?= (int)prog_finish_75_to_100($kpmr_stratejik ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Stratejik</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_stratejik ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_stratejik ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_stratejik ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_stratejik ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                    <div class="tab-pane" id="profil">
                                        <div class="table-responsive-sm">
                                            <table class="table table-bordered table-top mb-5">
                                                <thead class="table-info">
                                                    <tr>
                                                        <th class=" text-center" width="10%">Profil Risiko</th>
                                                        <th class=" text-center" width="40%">Persentase Pengerjaan</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="table-secondary">
                                                    <tr>
                                                        <td>Profil Nilai</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" data-progress="<?= (int)prog_finish_75_to_100($pronil_uraian ?? 0) ?>" aria-valuenow="<?= (int)prog_finish_75_to_100($pronil_uraian ?? 0) ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= (int)prog_finish_75_to_100($pronil_uraian ?? 0) ?>%"><?= (int)prog_finish_75_to_100($pronil_uraian ?? 0) ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- container -->

        </div>
        <!-- content -->
    </div>