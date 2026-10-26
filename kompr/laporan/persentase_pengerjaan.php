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

$kpmr_kredit = round((($kk_pilar1 + $kk_pilar2 + $kk_pilar3 + $kk_pilar4 + $kk_ru1 + $kk_ru2 + $kk_ru3 + $kk_ru4 + $kk_ket) / 170) * 100);


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


$inheren_operasional = round((($io_pilar1 + $io_pilar2 + $io_pilar3 + $io_pilar4 + $io_pilar5 + $io_pilarl + $io_ket) / 78) * 100);



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

$kpmr_operasional = round((($ko_pilar1 + $ko_pilar2 + $ko_pilar3 + $ko_pilar4 + $ko_ru1 + $ko_ru2 + $ko_ru3 + $ko_ru4 + $ko_ket) / 188) * 100);


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


$inheren_kepatuhan = round((($ikep_pilar1 + $ikep_pilar2 + $ikep_pilarl + $ikep_ket) / 40) * 100);


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

$kpmr_kepatuhan = round((($kkep_pilar1 + $kkep_pilar2 + $kkep_pilar3 + $kkep_pilar4 + $kkep_ru1 + $kkep_ru2 + $kkep_ru3 + $kkep_ru4 + $kkep_ket) / 179) * 100);



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

$kpmr_likuiditas = round((($klik_pilar1 + $klik_pilar2 + $klik_pilar3 + $klik_pilar4 + $klik_ru1 + $klik_ru2 + $klik_ru3 + $klik_ru4 + $klik_ket) / 170) * 100);


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

$kpmr_reputasi = round((($krep_pilar1 + $krep_pilar2 + $krep_pilar3 + $krep_pilar4 + $krep_ru1 + $krep_ru2 + $krep_ru3 + $krep_ru4 + $krep_ket) / 170) * 100);


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

$kpmr_stratejik = round((($kstra_pilar1 + $kstra_pilar2 + $kstra_pilar3 + $kstra_pilar4 + $kstra_ru1 + $kstra_ru2 + $kstra_ru3 + $kstra_ru4 + $kstra_ket) / 170) * 100);


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


?>


<div class="content-page">
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
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Progress Pengerjaan Profil Risiko <?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?></h4>
                            <p class="text-muted font-14">
                                persentase pengerjaan profil risiko
                            </p>
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
                                <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
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

                                            <span class="d-none d-md-block">Profil Nilai & Peringkat</span>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_kredit ?>%"><?= $inheren_kredit ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Kredit</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_kredit ?>%"><?= $kpmr_kredit ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Kredit</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:<?= $pronil_kredit ?>%"><?= $pronil_kredit ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_operasional ?>%"><?= $inheren_operasional ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Operasional</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_operasional ?>%"><?= $kpmr_operasional ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Operasional</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_operasional ?>%"><?= $pronil_operasional ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_kepatuhan ?>%"><?= $inheren_kepatuhan ?> %</div>
                                                            </div> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Kepatuhan</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_kepatuhan ?>%"><?= $kpmr_kepatuhan ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Kepatuhan</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_kepatuhan ?>%"><?= $pronil_kepatuhan ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_likuiditas ?>%"><?= $inheren_likuiditas ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Likuiditas</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_likuiditas ?>%"><?= $kpmr_likuiditas ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Likuiditas</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_likuiditas ?>%"><?= $pronil_likuiditas ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_reputasi ?>%"><?= $inheren_reputasi ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Reputasi</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_reputasi ?>%"><?= $kpmr_reputasi ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Reputasi</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_reputasi ?>%"><?= $pronil_reputasi ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $inheren_stratejik ?>%"><?= $inheren_stratejik ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>KPMR Stratejik</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $kpmr_stratejik ?>%"><?= $kpmr_stratejik ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Stratejik</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_stratejik ?>%"><?= $pronil_stratejik ?> %</div>
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
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $pronil_uraian ?>%"><?= $pronil_uraian ?> %</div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Profil Peringkat</td>
                                                        <td>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: <?= $proper_uraian ?>%"><?= $proper_uraian ?> %</div>
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