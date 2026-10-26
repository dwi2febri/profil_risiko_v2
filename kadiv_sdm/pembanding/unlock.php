<?php
include "../conn/conn.php";
$id = $_GET['id'];

$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
 WHERE id_profil_risiko = '$id'"));
$tahun = $frame['tahun'];
$periode = $frame['periode'];
$kunci_laporan = 0;

mysqli_query($conn, "UPDATE frame_laporan_profil_risiko SET
    kunci_laporan = '$kunci_laporan',
	tgl_lock = NULL
    WHERE tahun = '$tahun' AND periode = '$periode' AND user IN(4)");
    
echo "<script>window.location.href='index.php?page=menu_final';</script>'";
exit;
