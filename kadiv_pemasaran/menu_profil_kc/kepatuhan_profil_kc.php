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

$pembanding_inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$dp'"));

$pembanding_kpmr = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$dp'"));

$pem_i = $pembanding_inheren['hasil_peringkat'];
$pem_k = $pembanding_kpmr['hasil_peringkat'];

$inheren = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));

$kpmr = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$id'"));

$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));

$trs = $inheren['hasil_peringkat'];
$matrik_ojk_kep = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM matrik_ojk_kepatuhan WHERE tingkat_risiko = '$trs'"));

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
    $tingkat_kualitas_mr = "Risiko Sangat Tinggi (Dilakukan pengawasan melekat, membutuhkan pemantauan lebih mendalam";
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
    $inheren_kepatuhan = $inheren['hasil_tingkat_risiko'];
    $ket_profil_inheren = $_POST['ket_profil_inheren'];
    $tingkat_risiko = $tingkat_risiko;
    $ket_tingkat_risiko = $ket_tingkat_risiko;
    $tingkat_kualitas_mr = $tingkat_kualitas_mr;
    $tindak_lanjut = $_POST['tindak_lanjut'];



    mysqli_query($conn, "UPDATE keterangan_profil_kepatuhan SET 
    inheren_kepatuhan = '$inheren_kepatuhan',
    tingkat_risiko = '$tingkat_risiko',
    peringkat_tingkat_risiko = '$ket_tingkat_risiko',
    tingkat_kualitas_mr = '$tingkat_kualitas_mr',
    ket_profil_inheren = '$ket_profil_inheren',
    tindak_lanjut = '$tindak_lanjut'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=kep_profil&id=$id");
    exit();
}

    $length = mysqli_fetch_array(mysqli_query($conn, "SELECT 
    CHAR_LENGTH(ket_profil_inheren) AS l1 FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));





$terbesar_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pil1_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil1_tingkat_risiko'
    WHEN pil2_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil2_tingkat_risiko'
    WHEN pil3_tingkat_risiko = greatest(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) THEN 'pil3_tingkat_risiko'
END AS val
FROM hasil_inheren_kepatuhan
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pil1_tingkat_risiko, pil2_tingkat_risiko, pil3_tingkat_risiko) AS nilai_tertinggi_pilar
FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));


$que_pilar = $terbesar_pilar['val'];


$terbesar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil1_par1 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par1'
    WHEN hasil_pil1_par2 = greatest(hasil_pil1_par1, hasil_pil1_par2) THEN 'hasil_pil1_par2'
END AS val
FROM inheren_kepatuhan_pilar1
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil1_par1, hasil_pil1_par2) AS nilai_tertinggi_pilar1
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));



$que_pilar1 = $terbesar_pilar1['val'];

$terbesar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN hasil_pil2_par1 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par1'
    WHEN hasil_pil2_par2 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par2'
    WHEN hasil_pil2_par3 = greatest(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) THEN 'hasil_pil2_par3'
    END AS val
FROM inheren_kepatuhan_pilar2
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(hasil_pil2_par1, hasil_pil2_par2, hasil_pil2_par3) AS nilai_tertinggi_pilar2
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));


$que_pilar2 = $terbesar_pilar2['val'];


$terbesar_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
CASE 
    WHEN pilar3_1a = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1a'
    WHEN pilar3_1b = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1b'
    WHEN pilar3_1c = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1c'
    WHEN pilar3_1d = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1d'
    WHEN pilar3_1e = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1e'
    WHEN pilar3_1f = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1f'
    WHEN pilar3_1g = greatest(pilar3_1a, pilar3_1b, pilar3_1c, pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) THEN 'pilar3_1g'

END AS val
FROM inheren_kepatuhan_lainnya
WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar3_1a,  pilar3_1b,  pilar3_1c,  pilar3_1d, pilar3_1e, pilar3_1f, pilar3_1g) AS nilai_tertinggi_pilar5
FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));

$que_pilar5 = $terbesar_pilar5['val'];

//hasil bolo



$hasil_a_pilar = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar'"));

$hasil_par_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar1'"));

$hasil_par_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar2'"));

$hasil_par_pilar5 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar5'"));

$que_pilar1_sub = $hasil_par_pilar1['kode_pil'];
$que_pilar2_sub = $hasil_par_pilar2['kode_pil'];



if ($que_pilar1_sub == 1) {
    $terbesar_pilar1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_1 = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1' 
    WHEN pilar1_1a = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1a'
    WHEN pilar1_1b = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1b'
    WHEN pilar1_1c = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1c'
    WHEN pilar1_1d = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1d'
    WHEN pilar1_1e = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1e'
    WHEN pilar1_1f = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1f'
    WHEN pilar1_1g = greatest(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) THEN 'pilar1_1g'

    END AS val
    FROM inheren_kepatuhan_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_1, pilar1_1a, pilar1_1b, pilar1_1c, pilar1_1d, pilar1_1e, pilar1_1f, pilar1_1g) AS nilai_tertinggi_pilar1_sub
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub1 = $terbesar_nilai_pilar1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar1_sub1 = $terbesar_pilar1_sub2['val'];

$query_subpar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar1_sub1'"));
$hasil_subpar_pilar1 = $query_subpar_pilar1['parameter'];
}
else if ($que_pilar1_sub == 2) {
    $terbesar_pilar1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar1_2 = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2' 
    WHEN pilar1_2a = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2a'
    WHEN pilar1_2b = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2b'
    WHEN pilar1_2c = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2c'
    WHEN pilar1_2d = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2d'
    WHEN pilar1_2e = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2e'
    WHEN pilar1_2f = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2f'
    WHEN pilar1_2g = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2g'
    WHEN pilar1_2h = greatest(pilar1_2, pilar1_2a, pilar1_2b, pilar1_2c, pilar1_2d, pilar1_2e, pilar1_2f, pilar1_2g, pilar1_2h) THEN 'pilar1_2h'
    
    END AS val
    FROM inheren_kepatuhan_pilar1
    WHERE id_profil_risiko = '$id'"));

$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar1_2,  pilar1_2a,  pilar1_2b) AS nilai_tertinggi_pilar1_sub
FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$maxsub1 = $terbesar_nilai_pilar1_sub['nilai_tertinggi_pilar1_sub'];

$que_pilar1_sub1 = $terbesar_pilar1_sub2['val'];

$query_subpar_pilar1 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar1_sub1'"));
$hasil_subpar_pilar1 = $query_subpar_pilar1['parameter'];
}
else {
    $hasil_subpar_pilar11 = '-';
    $maxsub1 = ' ';
}


if ($que_pilar2_sub == 3) {
    $terbesar_pilar2_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_1 = greatest(pilar2_1, pilar2_1a) THEN 'pilar2_1'
    WHEN pilar2_1a = greatest(pilar2_1, pilar2_1a) THEN 'pilar2_1a'
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));

$que_pilar2_sub1 = $terbesar_pilar2_sub2['val'];

$terbesar_nilai_pilar2_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_1,  pilar2_1a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub2 = $terbesar_nilai_pilar2_sub['nilai_tertinggi_pilar2_sub'];

$query_subpar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar2_sub1'"));
$hasil_subpar_pilar2 = $query_subpar_pilar2['parameter'];
}
else if ($que_pilar1_sub == 4) {
    $terbesar_pilar1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_2 = greatest(pilar2_2, pilar2_2a) THEN 'pilar2_2'
    WHEN pilar2_2a = greatest(pilar2_2, pilar2_2a) THEN 'pilar2_2a'
    
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));


$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_2,  pilar2_2a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub2 = $terbesar_nilai_pilar2_sub['nilai_tertinggi_pilar2_sub'];

$que_pilar2_sub1 = $terbesar_pilar2_sub2['val'];

$query_subpar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
WHERE kode_parameter = '$que_pilar2_sub1'"));
$hasil_subpar_pilar2 = $query_subpar_pilar2['parameter'];
}
else if ($que_pilar1_sub == 5) {
    $terbesar_pilar1_sub2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
    CASE 
    WHEN pilar2_3 = greatest(pilar2_3, pilar2_3a) THEN 'pilar2_3'
    WHEN pilar2_3a = greatest(pilar2_3, pilar2_3a) THEN 'pilar2_3a'
    
    END AS val
    FROM inheren_kepatuhan_pilar2
    WHERE id_profil_risiko = '$id'"));


$terbesar_nilai_pilar1_sub = mysqli_fetch_assoc(mysqli_query($conn, "SELECT 
GREATEST(pilar2_3,  pilar2_3a) AS nilai_tertinggi_pilar2_sub
FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$maxsub2 = $terbesar_nilai_pilar2_sub['nilai_tertinggi_pilar2_sub'];

$que_pilar2_sub1 = $terbesar_pilar2_sub2['val'];

$query_subpar_pilar2 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT parameter FROM parameter_kepatuhan
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

                        <h4 class="page-title">Profil Risiko kepatuhan [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Hasil Profil Risiko kepatuhan</h4>

                            <hr>
                            </hr>

                           
                           

                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th style="font-size: 30px;" colspan="9">
                                                <center>RISIKO KEPATUHAN</center>
                                            </th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
</br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                            <!-- kepatuhan-->
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
                                                                <center>Risiko kepatuhan</center>
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
                                            <!-- kepatuhan-->
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
                                                                <center>Risiko kepatuhan</center>
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
                                                <center>Analisis Risiko Kepatuhan</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Risiko Inheren</center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" maxlength="1000" id="ket_profil_inheren" form="my_form" name="ket_profil_inheren" cols="60" rows="10"><?= $ket['ket_profil_inheren'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 1000</span></th>
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
                                                <center>Analisa Nilai Tertinggi Risiko Kepatuhan</center>
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
                                            <th>Pada PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain </br>
                                            parameter dengan nilai tertinggi ada di <?= $hasil_par_pilar1['parameter'] ?> dengan nilai (<?=$terbesar_nilai_pilar1['nilai_tertinggi_pilar1'] ?>), dengan sub parameter yg tertiggi pada <?= $hasil_subpar_pilar1 ?> <?= number_format($maxsub1,2) ?>
                                            </th>
                                            
                                        </tr>
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar 2</center>
                                            </th>
                                            <th>Pada PILAR 2 : Faktor Kelemahan Aspek Hukum</br>
                                            parameter dengan nilai tertinggi ada di <?= $hasil_par_pilar2['parameter'] ?>  dengan nilai (<?=$terbesar_nilai_pilar2['nilai_tertinggi_pilar2'] ?>), dengan sub parameter yg tertiggi pada <?= $hasil_subpar_pilar2 ?> <?= number_format($maxsub2,2) ?>
                                            </th>
                                            
                                        </tr>
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center>Parameter Pilar Lainnya</center>
                                            </th>
                                            <th>Pada Pilar Lainnya. </br>
                                            sub parameter yang tertinggi ada di <?= $hasil_par_pilar5['parameter'] ?> dengan nilai (<?= number_format($terbesar_nilai_pilar5['nilai_tertinggi_pilar5'],2) ?>)
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
                                                <center>Definisi Tingkat Risiko Kepatuhan (Matrik OJK)</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        
                                        <tr style="font-size: 20px;">
                                            <th>
                                            <center><b><?= $inheren['hasil_peringkat'] ?></b></center>
                                            </th>
                                            <th>
                                            <textarea class="form-control" form="my_form" cols="60" rows="10" readonly><?= $matrik_ojk_kep['definisi_tingkat_risiko'] ?>
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