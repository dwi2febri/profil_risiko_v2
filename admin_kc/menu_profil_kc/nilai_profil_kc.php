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



$ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));
$ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$id'"));
$ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id'"));
$ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$id'"));
$ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$id'"));

$inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));
$inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));
$inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));
$inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));
$inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));

$pembanding_inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$dp'"));

$pembanding_ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$dp'"));

$ket = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$id'"));



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





//penilaian bpr
$nil1 = $ket1['inheren_kredit'];
$nil2 = $ket2['inheren_operasional'];
$nil3 = $ket3['inheren_kepatuhan'];
$nil4 = $ket4['inheren_likuiditas'];
$nil5 = $ket5['inheren_reputasi'];
$nil6 = $ket6['inheren_stratejik'];

$hsl1 = ($nil1*30)/100;
$hsl2 = ($nil2*30)/100;
$hsl3 = ($nil3*20)/100;
$hsl4 = ($nil4*10)/100;
$hsl5 = ($nil5*5)/100;
$hsl6 = ($nil6*5)/100;

$total_nilai = $hsl1+$hsl2+$hsl3+$hsl4+$hsl5+$hsl6;

//hasil peringkat
if ($total_nilai < 1.00) {
    $ket_total_nilai = " ";
} else if ($total_nilai >= 1.00 && $total_nilai < 1.25) {
    $ket_total_nilai = "Sangat Rendah";
} else if ($total_nilai >= 1.25 && $total_nilai < 2.25) {
    $ket_total_nilai = "Rendah";
} else if ($total_nilai >= 2.25 && $total_nilai < 3.25) {
    $ket_total_nilai = "Sedang";
} else if ($total_nilai >= 3.25 && $total_nilai < 4.25) {
    $ket_total_nilai = "Tinggi";
} else if ($total_nilai >= 4.25 && $total_nilai <= 5.00) {
    $ket_total_nilai = "Sangat Tinggi";
} else {
    $ket_total_nilai = " ";
}


//penilaian bpr
$pembanding_nil1 = $pembanding_ket1['inheren_kredit'];
$pembanding_nil2 = $pembanding_ket2['inheren_operasional'];
$pembanding_nil3 = $pembanding_ket3['inheren_kepatuhan'];
$pembanding_nil4 = $pembanding_ket4['inheren_likuiditas'];
$pembanding_nil5 = $pembanding_ket5['inheren_reputasi'];
$pembanding_nil6 = $pembanding_ket6['inheren_stratejik'];

$pembanding_hsl1 = ($pembanding_nil1*30)/100;
$pembanding_hsl2 = ($pembanding_nil2*30)/100;
$pembanding_hsl3 = ($pembanding_nil3*20)/100;
$pembanding_hsl4 = ($pembanding_nil4*10)/100;
$pembanding_hsl5 = ($pembanding_nil5*5)/100;
$pembanding_hsl6 = ($pembanding_nil6*5)/100;

$pembanding_total_nilai = $pembanding_hsl1+$pembanding_hsl2+$pembanding_hsl3+$pembanding_hsl4+$pembanding_hsl5+$pembanding_hsl6;

//hasil peringkat
if ($pembanding_total_nilai < 1.00) {
    $pembanding_ket_pembanding_total_nilai = " ";
} else if ($pembanding_total_nilai >= 1.00 && $pembanding_total_nilai < 1.25) {
    $pembanding_ket_pembanding_total_nilai = "Sangat Rendah";
} else if ($pembanding_total_nilai >= 1.25 && $pembanding_total_nilai < 2.25) {
    $pembanding_ket_pembanding_total_nilai = "Rendah";
} else if ($pembanding_total_nilai >= 2.25 && $pembanding_total_nilai < 3.25) {
    $pembanding_ket_pembanding_total_nilai = "Sedang";
} else if ($pembanding_total_nilai >= 3.25 && $pembanding_total_nilai < 4.25) {
    $pembanding_ket_pembanding_total_nilai = "Tinggi";
} else if ($pembanding_total_nilai >= 4.25 && $pembanding_total_nilai <= 5.00) {
    $pembanding_ket_pembanding_total_nilai = "Sangat Tinggi";
} else {
    $pembanding_ket_pembanding_total_nilai = " ";
}




if (isset($_POST['submit'])) {
    include "../conn/conn.php";
    $total_nilai = $total_nilai;
    $ket_total_nilai = $ket_total_nilai;
    $ket_nilai_risiko = $_POST['ket_nilai_risiko'];




    mysqli_query($conn, "UPDATE nilai_profil SET 
    total_nilai = '$total_nilai',
    ket_total_nilai = '$ket_total_nilai',
    ket_nilai_risiko = '$ket_nilai_risiko'
    WHERE id_profil_risiko = '$id'");

    echo '
        <script>$.NotificationApp.send("Title","Your awesome message text","Position","Background color","Icon")</script>
        ';

    header("Location: index.php?page=nilpro&id=$id");
    exit();
}

?>





<?php
    $length = mysqli_fetch_array(mysqli_query($conn, "SELECT 
    CHAR_LENGTH(ket_nilai_risiko) AS l1 FROM nilai_profil WHERE id_profil_risiko = '$id'"));
?>
<script>
        $(document).ready(function() {
            $('#ket_nilai_risiko').on('input', function() {
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

                        <h4 class="page-title">Penilaian Profil Risiko [<?= $frame['cabang'] ?> Tahun <?= $frame['tahun'] ?> - <?= $frame['periode_laporan'] ?>]</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="" method="POST" enctype="multipart/form-data" id="my_form"></form>

            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="header-title">Hasil Nilai Profil Risiko</h4>

                            <hr>
                            </hr>

                            
                           

                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th style="font-size: 30px;" colspan="9">
                                                <center>PROFIL NILAI</center>
                                            </th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
</br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card">
                                            <!-- stratejik-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#00e6e6">
                                                        <tr>

                                                            <th style="font-size: 30px;" colspan="5">
                                                               
                                                                    <center><b>Penilaian Profil Risiko</b></center>
                                                                
                                                            </th>

                                                        </tr>

                                                        <tr style="font-size: 20px;" style="height:  30px;">
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Peringkat Risiko</center>
                                                            </th>
                                                         
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th >
                                                                Risiko kredit
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket1['inheren_kredit'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren1['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko operasional
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket2['inheren_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren2['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko kepatuhan
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket3['inheren_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren3['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko likuiditas
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket4['inheren_likuiditas'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren4['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko reputasi
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket5['inheren_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren5['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko stratejik
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket6['inheren_stratejik'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $inheren6['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#00e6e6" style="height:  100px;">
                                                            <th style="font-size: 16px;" width="20%" style="height:  100px;">
                                                                <center>Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR </center>
                                                            </th>
                                                           
                                                            <th style="font-size: 20px;" width="20%">
                                                                <center><?= number_format($total_nilai, 2) ?></center>
                                                                
                                                            </th>
                                                            <th style="font-size: 20px;">
                                                            <center><b><center><?= $ket_total_nilai ?></center></b></center>
                                                            </th>
                                                           
                                                        </tr>

                                                    </tbody>


                                                </table>
                                            </div> <!-- end table-responsive-->
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                            <!-- stratejik-->
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-centered mb-0">
                                                    <thead bgcolor="#ffc266">
                                                        <tr>

                                                            <th style="font-size: 30px;" colspan="5">
                                                                
                                                                    <center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center>
                                                              
                                                            </th>

                                                        </tr>

                                                        <tr style="font-size: 20px;" style="height:  30px;">
                                                            <th width="20%">
                                                                <center>Jenis Risiko</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Tingkat Risiko Inheren</center>
                                                            </th>
                                                            <th width="20%">
                                                                <center>Peringkat Risiko</center>
                                                            </th>

                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko kredit
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket1['inheren_kredit'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren1['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                           
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko operasional
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket2['inheren_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren2['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko kepatuhan
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket3['inheren_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren3['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko likuiditas
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket4['inheren_likuiditas'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren4['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko reputasi
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket5['inheren_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren5['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                            
                                                        </tr>

                                                        <tr style="font-size: 30px;" bgcolor="#edebe8" >
                                                            <th>
                                                                Risiko stratejik
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket6['inheren_stratejik'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_inheren6['hasil_peringkat'] ?></b></center>
                                                            </th>
                                                           
                                                        </tr>
                                                        <tr style="font-size: 20px;" bgcolor="#ffc266" style="height:  100px;">
                                                            <th width="20%" style="height:  100px;">
                                                                <center>Dikutip dari laporan sebelumnya </center>
                                                            </th>
                                                           
                                                            <th width="20%">
                                                                <center><?= number_format($pembanding_total_nilai, 2) ?></center>
                                                          
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket_pembanding_total_nilai ?></b></center>
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
                                            <th width="80%">
                                                <center>Uraian</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        <tr>
                                            <th>
                                            <textarea class="form-control" maxlength="1000" id="ket_nilai_risiko" form="my_form" name="ket_nilai_risiko" cols="60" rows="10"><?= $ket['ket_nilai_risiko'] ?></textarea>
                                            <span id="penghitung-karakter1"><?= $length['l1'] ?></span><span> / 1000</span></th>
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