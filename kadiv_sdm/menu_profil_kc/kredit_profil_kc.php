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
$dp = $frame['data_pembanding'];

$pembanding_inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$dp'"));

$pembanding_kpmr = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$dp'"));

$pem_i = $pembanding_inheren['hasil_peringkat'];
$pem_k = $pembanding_kpmr['hasil_peringkat'];

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$kpmr = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$id'"));

$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));

$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));

$trs = $inheren['hasil_peringkat'];
$matrik_ojk_kre = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_kredit WHERE tingkat_risiko = '$trs'"));


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
    include "../conn/conn.php";



    $inheren_kredit = $inheren['hasil_tingkat_risiko'];
    $ket_profil_inheren = $_POST['ket_profil_inheren'];
    $tindak_lanjut = $_POST['tindak_lanjut'];
    $tingkat_risiko = $tingkat_risiko;
    $ket_tingkat_risiko = $ket_tingkat_risiko;
    $tingkat_kualitas_mr = $tingkat_kualitas_mr;



    mysqli_query($conn, "UPDATE keterangan_profil_kredit SET 
    inheren_kredit = '$inheren_kredit',
    tingkat_risiko = '$tingkat_risiko',
    peringkat_tingkat_risiko = '$ket_tingkat_risiko',
    tingkat_kualitas_mr = '$tingkat_kualitas_mr',
    ket_profil_inheren = '$ket_profil_inheren',
    tindak_lanjut = '$tindak_lanjut'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kre_profil&id=$id");
    exit();
}


    $length = mysqli_fetch_array(mysqli_query($conn, "SELECT 
    CHAR_LENGTH(ket_profil_inheren) AS l1 FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));



$terbesar_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil3_tingkat_risiko'
    WHEN pil4_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil4_tingkat_risiko'
    WHEN pil5_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) THEN 'pil5_tingkat_risiko'
END AS val
FROM hasil_inheren_kredit
WHERE id_profil_risiko = '$id'"));

$que_pilar = $terbesar_pilar['val'];

$terbesar_nilai_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko, pil4_tingkat_risiko, pil5_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));


$terbesar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par2'
    WHEN hasil_pil1_par3 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par3'
    WHEN hasil_pil1_par4 = greatest(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) THEN 'hasil_pil1_par4'
    
END AS val
FROM inheren_kredit_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2, hasil_pil1_par3, hasil_pil1_par4) AS nilai_tertinggi_pilar1
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));

$que_pilar1 = $terbesar_pilar1['val'];

$terbesar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par2'
    WHEN hasil_pil2_par3 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par3'
    
END AS val
FROM inheren_kredit_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) AS nilai_tertinggi_pilar2
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));

$que_pilar2 = $terbesar_pilar2['val'];


$terbesar_pilar3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil3_par1a = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1a'
    WHEN hasil_pil3_par1b = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1b'
    WHEN hasil_pil3_par1c = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1c'
    WHEN hasil_pil3_par1d = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1d'
    WHEN hasil_pil3_par1e = greatest(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) THEN 'hasil_pil3_par1e'
    
END AS val
FROM inheren_kredit_pilar3
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil3_par1a, hasil_pil3_par1b, hasil_pil3_par1c, hasil_pil3_par1d, hasil_pil3_par1e) AS nilai_tertinggi_pilar3
FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));

$que_pilar3 = $terbesar_pilar3['val'];

$terbesar_pilar4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil4_par1a = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1a'
    WHEN hasil_pil4_par1b = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1b'
    WHEN hasil_pil4_par1c = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1c'
    WHEN hasil_pil4_par1d = greatest(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) THEN 'hasil_pil4_par1d'
END AS val
FROM inheren_kredit_pilar4
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil4_par1a, hasil_pil4_par1b, hasil_pil4_par1c, hasil_pil4_par1d) AS nilai_tertinggi_pilar4
FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));


$que_pilar4 = $terbesar_pilar4['val'];

$terbesar_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil5_par1a = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1a'
    WHEN hasil_pil5_par1b = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1b'
    WHEN hasil_pil5_par1c = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1c'
    WHEN hasil_pil5_par1d = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1d'
    WHEN hasil_pil5_par1e = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1e'
    WHEN hasil_pil5_par1f = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1f'
    WHEN hasil_pil5_par1g = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1g'
    WHEN hasil_pil5_par1h = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1h'
    WHEN hasil_pil5_par1i = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1i'
    WHEN hasil_pil5_par1j = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1j'
    WHEN hasil_pil5_par1k = greatest(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) THEN 'hasil_pil5_par1k'
    
END AS val
FROM inheren_kredit_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil5_par1a, hasil_pil5_par1b, hasil_pil5_par1c, hasil_pil5_par1d, hasil_pil5_par1e, hasil_pil5_par1f, hasil_pil5_par1g, hasil_pil5_par1h, hasil_pil5_par1i, hasil_pil5_par1j, hasil_pil5_par1k) AS nilai_tertinggi_pilar5
FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar5 = $terbesar_pilar5['val'];

//hasil bolo



$hasil_a_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar'"));

$hasil_par_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar1'"));

$hasil_par_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar2'"));

$hasil_par_pilar3 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar3'"));

$hasil_par_pilar4 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar4'"));

$hasil_par_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kredit
WHERE kode_parameter = '$que_pilar5'"));

$que_pilar1_sub = $hasil_par_pilar1['kode_pil'];
$que_pilar2_sub = $hasil_par_pilar2['kode_pil'];



if ($que_pilar1_sub == 1) {
$terbesar_pilar1_sub1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1a = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1a'
    WHEN hasil_pil1_par1b = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1b'
    WHEN hasil_pil1_par1c = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1c'
    WHEN hasil_pil1_par1d = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1d'
    WHEN hasil_pil1_par1e = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1e'
    WHEN hasil_pil1_par1f = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1f'
    WHEN hasil_pil1_par1g = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1g'
    WHEN hasil_pil1_par1h = greatest(hasil_pil1_par1a, hasil_pil1_par1b, hasil_pil1_par1c, hasil_pil1_par1d, hasil_pil1_par1e, hasil_pil1_par1f, hasil_pil1_par1g, hasil_pil1_par1h) THEN 'hasil_pil1_par1h'
END AS val
FROM inheren_kredit_pilar1
WHERE id_profil_risiko = '$id'"));
$que_pilar1_sub1 = $terbesar_pilar1_sub1['val'];

$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1a,hasil_pil1_par1b,hasil_pil1_par1c,hasil_pil1_par1d,hasil_pil1_par1e,hasil_pil1_par1f,hasil_pil1_par1g,hasil_pil1_par1h) AS nilai_tertinggi_pilar1_sub
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub1 = $terbesar_nilai_pilar1_sub['nilai_tertinggi_pilar1_sub'];

$query_subpar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar1_sub1'"));
$hasil_subpar_pilar1 = $query_subpar_pilar1['parameter'];
}
else if ($que_pilar1_sub == 2) {
    $terbesar_pilar1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil1_par2a = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2a'
    WHEN hasil_pil1_par2b = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2b'
    WHEN hasil_pil1_par2c = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2c'
    WHEN hasil_pil1_par2d = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2d'
    WHEN hasil_pil1_par2e = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2e'
    WHEN hasil_pil1_par2f = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2f'
    WHEN hasil_pil1_par2g = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2g'
    WHEN hasil_pil1_par2h = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2h'
    WHEN hasil_pil1_par2i = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2i'
    WHEN hasil_pil1_par2j = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2j'
    WHEN hasil_pil1_par2k = greatest(hasil_pil1_par2a, hasil_pil1_par2b, hasil_pil1_par2c, hasil_pil1_par2d, hasil_pil1_par2e, hasil_pil1_par2f, hasil_pil1_par2g, hasil_pil1_par2h, hasil_pil1_par2i, hasil_pil1_par2j, hasil_pil1_par2k) THEN 'hasil_pil1_par2k'
    END AS val
    FROM inheren_kredit_pilar1
    WHERE id_profil_risiko = '$id'"));
    
    
$que_pilar1_sub1 = $terbesar_pilar1_sub2['val'];

$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par2a,hasil_pil1_par2b,hasil_pil1_par2c,hasil_pil1_par2d,hasil_pil1_par2e,hasil_pil1_par2f,hasil_pil1_par2g,hasil_pil1_par2h,hasil_pil1_par2i,hasil_pil1_par2j,hasil_pil1_par2k) AS nilai_tertinggi_pilar1_sub
FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub1 = $terbesar_nilai_pilar1_sub['nilai_tertinggi_pilar1_sub'];

$query_subpar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar1_sub1'"));
$hasil_subpar_pilar1 = $query_subpar_pilar1['parameter'];
}
else if ($que_pilar1_sub == 3) {
    
    $hasil_subpar_pilar1 = '-';
    $maxsub1 = ' ';
}
else if ($que_pilar1_sub == 4) {
    
    $hasil_subpar_pilar1 = '-';
    $maxsub1 = ' ';
}
else {
    $hasil_subpar_pilar11 = '-';
    $maxsub1 = ' ';
}


if ($que_pilar2_sub == 5) {
    $hasil_subpar_pilar2 = '-';
    $maxsub2 = ' ';
}
else if ($que_pilar2_sub == 6) {
    $terbesar_pilar2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil2_par2a = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2a'
    WHEN hasil_pil2_par2b = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2b'
    WHEN hasil_pil2_par2c = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2c'
    WHEN hasil_pil2_par2d = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2d'
    WHEN hasil_pil2_par2e = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2e'
    WHEN hasil_pil2_par2f = greatest(hasil_pil2_par2a, hasil_pil2_par2b, hasil_pil2_par2c, hasil_pil2_par2d, hasil_pil2_par2e, hasil_pil2_par2f) THEN 'hasil_pil2_par2f'
    END AS val
    FROM inheren_kredit_pilar2
    WHERE id_profil_risiko = '$id'"));
    
    
$que_pilar2_sub1 = $terbesar_pilar2_sub2['val'];

$terbesar_nilai_pilar2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par2a,hasil_pil2_par2b,hasil_pil2_par2c,hasil_pil2_par2d,hasil_pil2_par2e,hasil_pil2_par2f,hasil_pil2_par2g,hasil_pil2_par2h,hasil_pil2_par2i,hasil_pil2_par2j,hasil_pil2_par2k) AS nilai_tertinggi_pilar2_sub
FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub2 = $terbesar_nilai_pilar2_sub['nilai_tertinggi_pilar2_sub'];


$query_subpar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar2_sub1'"));
$hasil_subpar_pilar2 = $query_subpar_pilar2['parameter'];
}
else if ($que_pilar2_sub == 7) {
    $terbesar_pilar2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN hasil_pil2_par3a = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3a'
    WHEN hasil_pil2_par3b = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3b'
    WHEN hasil_pil2_par3c = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3c'
    WHEN hasil_pil2_par3d = greatest(hasil_pil2_par3a, hasil_pil2_par3b, hasil_pil2_par3c, hasil_pil2_par3d) THEN 'hasil_pil2_par3d'
   
    END AS val
    FROM inheren_kredit_pilar2
    WHERE id_profil_risiko = '$id'"));
    
    $terbesar_nilai_pilar2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    GREATEST(hasil_pil2_par3a,hasil_pil2_par3b,hasil_pil2_par3c,hasil_pil2_par3d) AS nilai_tertinggi_pilar2_sub
    FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
    $maxsub2 = $terbesar_nilai_pilar2_sub['nilai_tertinggi_pilar2_sub'];

    
$que_pilar2_sub1 = $terbesar_pilar2_sub2['val'];

$query_subpar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kredit
WHERE kode_parameter = '$que_pilar2_sub1'"));
$hasil_subpar_pilar2 = $query_subpar_pilar2['parameter'];
}
else {
    $hasil_subpar_pilar2 = '-';
    $maxsub2 = ' ';
}


?>
<script>
        $(document).ready(function() {
            $('#ket_profil_inheren').on('input', function() {
                var charCount = $(this).val().length;
                $('#penghitung-karakter1').text(charCount);
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

                        <h4 class="page-title">Profil Risiko Kredit [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
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

                                            <th style="font-size: 30px;" colspan="9">
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

                                                            <th style="font-size: 30px;" colspan="5">
                                                                    <center><b>Penilaian Profil Risiko</b></center>
                                                               
                                                            </th>

                                                        </tr>

                                                        <tr style="font-size: 20px;">
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr style="font-size: 30px;" bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko kredit</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                           
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8">
                                                            
                                                            <th>
                                                            <center><b><?= $inheren['hasil_peringkat'] ?></b></center>
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

                                                            <th style="font-size: 30px;" colspan="5">
                                                               
                                                                    <center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center>
                                                                
                                                            </th>

                                                        </tr>

                                                        <tr style="font-size: 20px;">
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8">
                                                            <th rowspan="2">
                                                                <center>Risiko kredit</center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren['hasil_tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8">
                                                          
                                                            <th>
                                                            <center><b><?= $pembanding_inheren['hasil_peringkat'] ?></b></center>
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
                                        <tr style="font-size: 20px;">
                                            <th width="20%">
                                            <center>Komponen</center>
                                            </th>
                                            <th width="80%">
                                                <center>Analisis Risiko Kredit</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Risiko Inheren</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" maxlength="1000" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10"><?= $ket['ket_profil_inheren'] ?>
                                        </textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 1000</span>
                                            </th>
                                            
                                        </tr>

                                        
                                        
                                    </tbody>
                                </table>
                            </div>

                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                               
                                    <thead bgcolor="#ffb3b3">
                                        <tr style="font-size: 20px;">
                                            <th width="20%">
                                            <center>Komponen</center>
                                            </th>
                                            <th width="80%">
                                                <center>Analisa Nilai Tertinggi Risiko Kredit</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Pilar</center>
                                            </th>
                                            <th>Nilai risiko yang tertinggi ada di <?= $hasil_a_pilar['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar['nilai_tertinggi_pilar'] ?>)
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar 1</center>
                                            </th>
                                            <th>Pada PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit </br>
                                            parameter dengan nilai tertinggi ada di <?= $hasil_par_pilar1['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar1['nilai_tertinggi_pilar1'] ?>), dengan sub parameter yg tertiggi pada <?= $hasil_subpar_pilar1 ?> <?= number_format($maxsub1,2) ?>
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar 2</center>
                                            </th>
                                            <th>Pada PILAR 2 : Kualitas Aset. </br>
                                            parameter dengan nilai tertinggi ada di <?= $hasil_par_pilar2['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar2['nilai_tertinggi_pilar2'] ?>), dengan sub parameter yg tertiggi pada <?= $hasil_subpar_pilar2 ?> <?= number_format($maxsub2,2) ?>
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar 3</center>
                                            </th>
                                            <th>Pada PILAR 3 : Strategi Penyediaan Dana. </br>
                                            sub parameter dengan nilai tertinggi ada di <?= $hasil_par_pilar3['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar3['nilai_tertinggi_pilar3'] ?>)
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar 4</center>
                                            </th>
                                            <th>Pada PILAR 4 : Faktor Eksternal. </br>
                                            sub parameter yang tertinggi ada di <?= $hasil_par_pilar4['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar4['nilai_tertinggi_pilar4'] ?>)
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar Lainnya</center>
                                            </th>
                                            <th>Pada Pilar Lainnya. </br>
                                            sub parameter yang tertinggi ada di <?= $hasil_par_pilar5['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar5['nilai_tertinggi_pilar5'] ?>)
                                            </th>
                                            
                                        </tr>

                                        
                                        
                                    </tbody>
                                </table>
                            </div>


                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                               
                                    <thead bgcolor="#ffb3b3">
                                        <tr style="font-size: 20px;">
                                            <th width="20%">
                                            <center>Tingkat Risiko</center>
                                            </th>
                                            <th width="80%">
                                                <center>Definisi Tingkat Risiko Kredit (Matrik OJK)</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center><b><?= $inheren['hasil_peringkat'] ?></b></center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" form="my_form"  cols="60" rows="10" readonly><?= $matrik_ojk_kre['definisi_tingkat_risiko'] ?>
                                        </textarea>
                                            </th>
                                            
                                        </tr>

                                        
                                        
                                    </tbody>
                                </table>
                            </div>


                            <br></br>
                            <hr></hr>

                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                               
                                    <thead bgcolor="#ffb3b3">
                                        <tr style="font-size: 20px;">
                                            <th width="20%">
                                            <center>Komponen</center>
                                            </th>
                                            <th width="80%">
                                                <center>Form Tindak lanjut</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Usulan Perbaikan & Tindak Lanjut</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" id="tindak_lanjut" form="my_form" name="tindak_lanjut" cols="60" rows="10"><?= $ket['tindak_lanjut'] ?></textarea>
                                            
                                            </th>
                                            
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