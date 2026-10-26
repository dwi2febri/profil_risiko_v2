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
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT data_pembanding FROM frame_laporan_profil_risiko WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];



$ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));
$ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$id'"));
$ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id'"));
$ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$id'"));
$ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$id'"));

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
$nil2 = $ket2['tingkat_risiko'];
$nil3 = $ket3['tingkat_risiko'];
$nil5 = $ket5['tingkat_risiko'];


$hsl2 = ($nil2*40)/100;
$hsl3 = ($nil3*30)/100;
$hsl5 = ($nil5*30)/100;

$total_nilai = $nil2+$nil3+$nil5;

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
$pembanding_nil2 = $pembanding_ket2['tingkat_risiko'];
$pembanding_nil3 = $pembanding_ket3['tingkat_risiko'];
$pembanding_nil5 = $pembanding_ket5['tingkat_risiko'];

$pembanding_hsl2 = ($pembanding_nil2*40)/100;
$pembanding_hsl3 = ($pembanding_nil3*30)/100;
$pembanding_hsl5 = ($pembanding_nil5*30)/100;

$pembanding_total_nilai = $pembanding_hsl2+$pembanding_hsl3+$pembanding_hsl5;

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
    $inheren_stratejik = $inheren['hasil_tingkat_risiko'];
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





















<div class="content-page">
    <div class="content">


        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <h4 class="page-title">Penilaian Profil Risiko</h4>
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

                            <div class="row">
                                <div class="col-12">
                                    <div class="col-lg-1 ">
                                        <button class="btn btn-primary" form="my_form" type="submit" name="submit">Simpan</button>
                                    </div>
                                </div>

                            </div>
                           

                            </br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-centered mb-0">
                                    <thead class="table-d" bgcolor="#74c7ff">
                                        <tr style="color: #050505;">

                                            <th colspan="9">
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

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr style="height:  30px;">
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
                                                            <th width="40%" >
                                                                <center>Tingkat Kualitas Manajemen Risiko</center>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko operasional
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket2['inheren_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket2['kpmr_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket2['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket2['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko kepatuhan
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket3['inheren_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket3['kpmr_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket3['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket3['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko reputasi
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket5['inheren_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket5['kpmr_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket5['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $ket5['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>


                                                        <tr bgcolor="#00e6e6" style="height:  30px;">
                                                            <th width="20%" colspan="3">
                                                                <center>Peringkat Risiko ditetapkan berdasarkan pertimbangan BPR </center>
                                                            </th>
                                                           
                                                            <th width="20%">
                                                                <center><?= number_format($total_nilai, 2) ?></center>
                                                            </th>
                                                            <th width="40%" >
                                                            <center><?= $ket_total_nilai ?></center>
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

                                                            <th colspan="5">
                                                                <h4>
                                                                    <center><b>Penilaian Profil Risiko Periode Sebelumnya</b></center>
                                                                </h4>
                                                            </th>

                                                        </tr>

                                                        <tr style="height:  30px;">
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
                                                       

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko operasional
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket2['inheren_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket2['kpmr_operasional'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket2['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket2['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko kepatuhan
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket3['inheren_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket3['kpmr_kepatuhan'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket3['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket3['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                       

                                                        <tr bgcolor="#edebe8" style="height:  180px;">
                                                            <th>
                                                                Risiko reputasi
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket5['inheren_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket5['kpmr_reputasi'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket5['tingkat_risiko'] ?></b></center>
                                                            </th>
                                                            <th>
                                                            <center><b><?= $pembanding_ket5['tingkat_kualitas_mr'] ?></b></center>
                                                            </th>
                                                        </tr>

                                                        <tr bgcolor="#ffc266" style="height:  30px;">
                                                            <th width="20%" colspan="3">
                                                                <center>Dikutip dari laporan sebelumnya </center>
                                                            </th>
                                                           
                                                            <th width="20%">
                                                                <center><?= number_format($pembanding_total_nilai, 2) ?></center>
                                                            </th>
                                                            <th width="40%" >
                                                            <center><?= $pembanding_ket_pembanding_total_nilai ?></center>
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
                                            <th width="80%">
                                                <center>Uraian</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody bgcolor="#edebe8">
                                        <tr>
                                            <th>
                                            <textarea class="form-control" id="ket_nilai_risiko" form="my_form" name="ket_nilai_risiko" cols="60" rows="10"><?= $ket['ket_nilai_risiko'] ?></textarea>
                                            </th>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>












































                            <hr>
                            </hr>

                            <br></br>







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