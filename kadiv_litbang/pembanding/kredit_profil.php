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
$jenis_pr = $frame['user'];
$tahun = $frame['tahun'];
$periode = $frame['periode'];

$pembanding_inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit INNER JOIN frame_laporan_profil_risiko ON hasil_inheren_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?", [$tahun, $periode]));

$pembanding_kpmr = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kredit INNER JOIN frame_laporan_profil_risiko ON hasil_kpmr_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?", [$tahun, $periode]));

$pem_i = $pembanding_inheren['hasil_peringkat'];
$pem_k = $pembanding_kpmr['hasil_peringkat'];

$pembanding_div_inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit INNER JOIN frame_laporan_profil_risiko ON hasil_inheren_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));

$pembanding_div_kpmr = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kredit INNER JOIN frame_laporan_profil_risiko ON hasil_kpmr_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND frame_laporan_profil_risiko.dibuat_by = 132", [$tahun, $periode]));

$pem_div_i = $pembanding_div_inheren['hasil_peringkat'];
$pem_div_k = $pembanding_div_kpmr['hasil_peringkat'];

$pil1 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_kredit_pilar1 WHERE id_profil_risiko = ?", [$id]));
$pil2 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_kredit_pilar2 WHERE id_profil_risiko = ?", [$id]));
$pil3 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_kredit_pilar3 WHERE id_profil_risiko = ?", [$id]));
$pil4 = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM kpmr_kredit_pilar4 WHERE id_profil_risiko = ?", [$id]));
$kpmr = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = ?", [$id]));

$inheren = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = ?", [$id]));

$ket = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = ?", [$id]));
$ket_skmr = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=1 AND tahun = ? AND periode = ?", [$tahun, $periode]));
$ket_div = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM keterangan_profil_kredit INNER JOIN frame_laporan_profil_risiko ON keterangan_profil_kredit.id_profil_risiko = frame_laporan_profil_risiko.id_profil_risiko WHERE user=2 AND tahun = ? AND periode = ? AND dibuat_by = 132", [$tahun, $periode]));

$i = $inheren['hasil_peringkat'];
$k =  $kpmr['hasil_peringkat'];
 //tingkat ris
  if ($i == "Sangat Rendah" && $k == "Sangat Memadai") {
     $tingkat_risiko = 1.00;
 } else if ($i == "Sangat Rendah" && $k == "Memadai") {
     $tingkat_risiko = 1.10;
 } else if ($i == "Sangat Rendah" && $k == "Cukup Memadai") {
     $tingkat_risiko = 1.15;
 } else if ($i == "Sangat Rendah" && $k == "Kurang Memadai") {
     $tingkat_risiko = 1.20;
 } else if ($i == "Sangat Rendah" && $k == "Tidak Memadai") {
     $tingkat_risiko = 1.25;
 }
 
 else if ($i == "Rendah" && $k == "Sangat Memadai") {
     $tingkat_risiko = 1.05;
 } else if ($i == "Rendah" && $k == "Memadai") {
     $tingkat_risiko = 1.68;
 } else if ($i == "Rendah" && $k == "Cukup Memadai") {
     $tingkat_risiko = 1.96;
 } else if ($i == "Rendah" && $k == "Kurang Memadai") {
     $tingkat_risiko = 2.11;
 } else if ($i == "Rendah" && $k == "Tidak Memadai") {
     $tingkat_risiko = 2.25;
 }
 
 else if ($i == "Sedang" && $k == "Sangat Memadai") {
     $tingkat_risiko = 1.39;
 } else if ($i == "Sedang" && $k == "Memadai") {
     $tingkat_risiko = 1.82;
 } else if ($i == "Sedang" && $k == "Cukup Memadai") {
     $tingkat_risiko = 2.92;
 } else if ($i == "Sedang" && $k == "Kurang Memadai") {
     $tingkat_risiko = 3.08;
 } else if ($i == "Sedang" && $k == "Tidak Memadai") {
     $tingkat_risiko = 3.25;
 }
 
 else if ($i == "Tinggi" && $k == "Sangat Memadai") {
     $tingkat_risiko = 1.54;
 } else if ($i == "Tinggi" && $k == "Memadai") {
     $tingkat_risiko = 2.58;
 } else if ($i == "Tinggi" && $k == "Cukup Memadai") {
     $tingkat_risiko = 3.50;
 } else if ($i == "Tinggi" && $k == "Kurang Memadai") {
     $tingkat_risiko = 4.00;
 } else if ($i == "Tinggi" && $k == "Tidak Memadai") {
     $tingkat_risiko = 4.25;
 }
 
 else if ($i == "Sangat Tinggi" && $k == "Sangat Memadai") {
     $tingkat_risiko = 2.42;
 } else if ($i == "Sangat Tinggi" && $k == "Memadai") {
     $tingkat_risiko = 2.75;
 } else if ($i == "Sangat Tinggi" && $k == "Cukup Memadai") {
     $tingkat_risiko = 3.75;
 } else if ($i == "Sangat Tinggi" && $k == "Kurang Memadai") {
     $tingkat_risiko = 4.63;
 } else if ($i == "Sangat Tinggi" && $k == "Tidak Memadai") {
     $tingkat_risiko = 5.00;
 }
 
 
 else {
     $tingkat_risiko = " ";
 }


  //hasil peringkat
  if ($tingkat_risiko < 1.00) {
    $ket_tingkat_risiko = " ";
} else if ($tingkat_risiko >= 1.00 && $tingkat_risiko < 1.25) {
    $ket_tingkat_risiko = "Sangat Rendah";
} else if ($tingkat_risiko >= 1.25 && $tingkat_risiko < 2.25) {
    $ket_tingkat_risiko = "Rendah";
} else if ($tingkat_risiko >= 2.25 && $tingkat_risiko < 3.25) {
    $ket_tingkat_risiko = "Sedang";
} else if ($tingkat_risiko >= 3.25 && $tingkat_risiko < 4.25) {
    $ket_tingkat_risiko = "Tinggi";
} else if ($tingkat_risiko >= 4.25 && $tingkat_risiko <= 5.00) {
    $ket_tingkat_risiko = "Sangat Tinggi";
} else {
    $ket_tingkat_risiko = " ";
}


 //tingkat kualitas
 if ($i == "Sangat Rendah" && $k == "Sangat Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($i == "Sangat Rendah" && $k == "Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($i == "Sangat Rendah" && $k == "Cukup Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($i == "Sangat Rendah" && $k == "Kurang Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($i == "Sangat Rendah" && $k == "Tidak Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
}

else if ($i == "Rendah" && $k == "Sangat Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($i == "Rendah" && $k == "Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah";
} else if ($i == "Rendah" && $k == "Cukup Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah";
} else if ($i == "Rendah" && $k == "Kurang Memadai") {
    $tingkat_kualitas_mr = "Risiko rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
} else if ($i == "Rendah" && $k == "Tidak Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
}

else if ($i == "Sedang" && $k == "Sangat Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah";
} else if ($i == "Sedang" && $k == "Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah";
} else if ($i == "Sedang" && $k == "Cukup Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
} else if ($i == "Sedang" && $k == "Kurang Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($i == "Sedang" && $k == "Tidak Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)";
}

else if ($i == "Tinggi" && $k == "Sangat Memadai") {
    $tingkat_kualitas_mr = "Risiko Rendah";
} else if ($i == "Tinggi" && $k == "Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($i == "Tinggi" && $k == "Cukup Memadai") {
    $tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($i == "Tinggi" && $k == "Kurang Memadai") {
    $tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)";
} else if ($i == "Tinggi" && $k == "Tidak Memadai") {
    $tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)";
}

else if ($i == "Sangat Tinggi" && $k == "Sangat Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($i == "Sangat Tinggi" && $k == "Memadai") {
    $tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)";
} else if ($i == "Sangat Tinggi" && $k == "Cukup Memadai") {
    $tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)";
} else if ($i == "Sangat Tinggi" && $k == "Kurang Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)";
} else if ($i == "Sangat Tinggi" && $k == "Tidak Memadai") {
    $tingkat_kualitas_mr = "Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam)";
}


else {
    $tingkat_kualitas_mr = "";
}




////////////////////////////////////////////////////////////////

//tingkat ris
if ($pem_i == "Sangat Rendah" && $pem_k == "Sangat Memadai") {
    $pembanding_tingkat_risiko = 1.00;
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Memadai") {
    $pembanding_tingkat_risiko = 1.10;
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Cukup Memadai") {
    $pembanding_tingkat_risiko = 1.15;
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Kurang Memadai") {
    $pembanding_tingkat_risiko = 1.20;
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Tidak Memadai") {
    $pembanding_tingkat_risiko = 1.25;
}

else if ($pem_i == "Rendah" && $pem_k == "Sangat Memadai") {
    $pembanding_tingkat_risiko = 1.05;
} else if ($pem_i == "Rendah" && $pem_k == "Memadai") {
    $pembanding_tingkat_risiko = 1.68;
} else if ($pem_i == "Rendah" && $pem_k == "Cukup Memadai") {
    $pembanding_tingkat_risiko = 1.96;
} else if ($pem_i == "Rendah" && $pem_k == "Kurang Memadai") {
    $pembanding_tingkat_risiko = 2.11;
} else if ($pem_i == "Rendah" && $pem_k == "Tidak Memadai") {
    $pembanding_tingkat_risiko = 2.25;
}

else if ($pem_i == "Sedang" && $pem_k == "Sangat Memadai") {
    $pembanding_tingkat_risiko = 1.39;
} else if ($pem_i == "Sedang" && $pem_k == "Memadai") {
    $pembanding_tingkat_risiko = 1.82;
} else if ($pem_i == "Sedang" && $pem_k == "Cukup Memadai") {
    $pembanding_tingkat_risiko = 2.92;
} else if ($pem_i == "Sedang" && $pem_k == "Kurang Memadai") {
    $pembanding_tingkat_risiko = 3.08;
} else if ($pem_i == "Sedang" && $pem_k == "Tidak Memadai") {
    $pembanding_tingkat_risiko = 3.25;
}

else if ($pem_i == "Tinggi" && $pem_k == "Sangat Memadai") {
    $pembanding_tingkat_risiko = 1.54;
} else if ($pem_i == "Tinggi" && $pem_k == "Memadai") {
    $pembanding_tingkat_risiko = 2.58;
} else if ($pem_i == "Tinggi" && $pem_k == "Cukup Memadai") {
    $pembanding_tingkat_risiko = 3.50;
} else if ($pem_i == "Tinggi" && $pem_k == "Kurang Memadai") {
    $pembanding_tingkat_risiko = 4.00;
} else if ($pem_i == "Tinggi" && $pem_k == "Tidak Memadai") {
    $pembanding_tingkat_risiko = 4.25;
}

else if ($pem_i == "Sangat Tinggi" && $pem_k == "Sangat Memadai") {
    $pembanding_tingkat_risiko = 2.42;
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Memadai") {
    $pembanding_tingkat_risiko = 2.75;
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Cukup Memadai") {
    $pembanding_tingkat_risiko = 3.75;
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Kurang Memadai") {
    $pembanding_tingkat_risiko = 4.63;
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Tidak Memadai") {
    $pembanding_tingkat_risiko = 5.00;
}


else {
    $pembanding_tingkat_risiko = " ";
}


 //hasil peringkat
 if ($pembanding_tingkat_risiko < 1.00) {
   $pem_ket_tingkat_risiko = " ";
} else if ($pembanding_tingkat_risiko >= 1.00 && $pembanding_tingkat_risiko < 1.25) {
   $pem_ket_tingkat_risiko = "Sangat Rendah";
} else if ($pembanding_tingkat_risiko >= 1.25 && $pembanding_tingkat_risiko < 2.25) {
   $pem_ket_tingkat_risiko = "Rendah";
} else if ($pembanding_tingkat_risiko >= 2.25 && $pembanding_tingkat_risiko < 3.25) {
   $pem_ket_tingkat_risiko = "Sedang";
} else if ($pembanding_tingkat_risiko >= 3.25 && $pembanding_tingkat_risiko < 4.25) {
   $pem_ket_tingkat_risiko = "Tinggi";
} else if ($pembanding_tingkat_risiko >= 4.25 && $pembanding_tingkat_risiko <= 5.00) {
   $pem_ket_tingkat_risiko = "Sangat Tinggi";
} else {
   $pem_ket_tingkat_risiko = " ";
}


//tingkat kualitas
if ($pem_i == "Sangat Rendah" && $pem_k == "Sangat Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Cukup Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Kurang Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($pem_i == "Sangat Rendah" && $pem_k == "Tidak Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
}

else if ($pem_i == "Rendah" && $pem_k == "Sangat Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Rendah";
} else if ($pem_i == "Rendah" && $pem_k == "Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah";
} else if ($pem_i == "Rendah" && $pem_k == "Cukup Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah";
} else if ($pem_i == "Rendah" && $pem_k == "Kurang Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
} else if ($pem_i == "Rendah" && $pem_k == "Tidak Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
}

else if ($pem_i == "Sedang" && $pem_k == "Sangat Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah";
} else if ($pem_i == "Sedang" && $pem_k == "Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah";
} else if ($pem_i == "Sedang" && $pem_k == "Cukup Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan semesteran)";
} else if ($pem_i == "Sedang" && $pem_k == "Kurang Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($pem_i == "Sedang" && $pem_k == "Tidak Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)";
}

else if ($pem_i == "Tinggi" && $pem_k == "Sangat Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Rendah";
} else if ($pem_i == "Tinggi" && $pem_k == "Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($pem_i == "Tinggi" && $pem_k == "Cukup Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($pem_i == "Tinggi" && $pem_k == "Kurang Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan triwulanan)";
} else if ($pem_i == "Tinggi" && $pem_k == "Tidak Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)";
}

else if ($pem_i == "Sangat Tinggi" && $pem_k == "Sangat Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan triwulanan)";
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sedang (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)";
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Cukup Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Tinggi (Dilakukan kaji ulang terbatas, rencana tindak dilaporkan bulanan)";
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Kurang Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Tinggi (Dilakukan kaji ulang menyeluruh, rencana tindak dilaporkan bulanan)";
} else if ($pem_i == "Sangat Tinggi" && $pem_k == "Tidak Memadai") {
   $pembanding_tingkat_kualitas_mr = "Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam";
}


else {
   $pembanding_tingkat_kualitas_mr = "";
}




if (isset($_POST['submit'])) {
    require dirname(__DIR__, 2).'/conn/conn.php';



    $inheren_kredit = $inheren['hasil_tingkat_risiko'];
    $kpmr_kredit = $kpmr['hasil_tingkat_risiko'];
    $ket_profil_risiko = $_POST['ket_profil_risiko'];
    $ket_profil_inheren = $_POST['ket_profil_inheren'];
    $ket_profil_kpmr = $_POST['ket_profil_kpmr'];
    $tingkat_risiko = $tingkat_risiko;
    $ket_tingkat_risiko = $ket_tingkat_risiko;
    $tingkat_kualitas_mr = $tingkat_kualitas_mr;



    simpro_db_query($conn, "UPDATE keterangan_profil_kredit SET 
    inheren_kredit = ?,
    kpmr_kredit = ?,
    tingkat_risiko = ?,
    peringkat_tingkat_risiko = ?,
    tingkat_kualitas_mr = ?,
    ket_profil_risiko = ?,
    ket_profil_inheren = ?,
    ket_profil_kpmr = ?
    WHERE id_profil_risiko = ?", [$inheren_kredit, $kpmr_kredit, $tingkat_risiko, $ket_tingkat_risiko, $tingkat_kualitas_mr, $ket_profil_risiko, $ket_profil_inheren, $ket_profil_kpmr, $id]);

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kre_profil2&id=$id");
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

                        <h4 class="page-title">Risiko Kredit Profil [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #5bf553; color: white;">

                            <h4 class="page-title">Profil Risiko Kredit</h4>
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
                            <h4 class="header-title">Hasil Profil Risiko Kredit</h4>

                            <hr>
                            </hr>


                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
                                                <center>RISIKO KREDIT</center>
                                            </th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
</br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                            <!-- kredit-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#00e6e6">
                                                        <tr>

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko Final</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr>
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat KPMR</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Kualitas Manajemen Risiko</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko kredit</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $kpmr['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format($tingkat_risiko, 2) ?></b></center>
                                                            </th>
                                                            <th rowspan="2">
                                                            <center><b><?= $tingkat_kualitas_mr ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8">
                                                            
                                                            <th>
                                                            <center><b><?= $inheren['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $kpmr['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket_tingkat_risiko ?></b></center>
                                                            </th>
                                                        </tr>


                                                    </tbody>


                                                </table>
                                            </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                            <!-- kredit-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#ffc266">
                                                        <tr>

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko SKMR & Divisi</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr>
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat KPMR</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Kualitas Manajemen Risiko</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko kredit (SKMR)</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_kpmr['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= number_format($pembanding_tingkat_risiko, 2) ?></b></center>
                                                            </th>
                                                            <th rowspan="2">
                                                            <center><b><?= $pembanding_tingkat_kualitas_mr ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8">
                                                          
                                                            <th>
                                                            <center><b><?= $pembanding_inheren['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_kpmr['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pem_ket_tingkat_risiko ?></b></center>
                                                            </th>
                                                        </tr>

                                                       
                                                    </tbody>


                                                </table>
                                            </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                            </div>

                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                               
                                    <thead bgcolor="#ffb3b3">
                                        <tr>
                                            <th width="20%">
                                            <center>Komponen</center>
                                            </th>
                                            <th width="40%">
                                                <center>Analisis Risiko Kredit Final</center>
                                            </th>
                                            <th width="40%">
                                                <center>Analisis Risiko SKMR</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        <tr>
                                            <th>
                                            <center>Tingkat Risiko</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_risiko" form="my_form" name="ket_profil_risiko" cols="60" rows="10"><?= $ket['ket_profil_risiko'] ?></textarea>
                                            </th>
                                            <th>
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $ket_skmr['ket_profil_risiko'] ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                            <center>Risiko Inheren</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10"><?= $ket['ket_profil_inheren'] ?></textarea>
                                            </th>
                                            <th>
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $ket_skmr['ket_profil_inheren'] ?></textarea>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                            <center>Risiko KPMR</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="ket_profil_kpmr" form="my_form" name="ket_profil_kpmr" cols="60" rows="10"><?= $ket['ket_profil_kpmr'] ?></textarea>
                                            </th>
                                            <th>
                                            <textarea class="form-control"  form="my_form"  cols="60" rows="10" readonly><?= $ket_skmr['ket_profil_kpmr'] ?></textarea>
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