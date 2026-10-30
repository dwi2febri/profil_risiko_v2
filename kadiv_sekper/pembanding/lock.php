<?php
require dirname(__DIR__, 2).'/conn/conn.php';
$id = $_GET['id'];


$frame = mysqli_fetch_array(simpro_db_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
 WHERE id_profil_risiko = ?", [$id]));
$tahun = $frame['tahun'];
$periode = $frame['periode'];
$kunci_laporan = 1;
$tgl_lock = date('Y-m-d');

simpro_db_query($conn, "UPDATE frame_laporan_profil_risiko SET
    kunci_laporan = ?,
	tgl_lock = ?
    WHERE tahun = ? AND periode = ? AND user IN(4)", [$kunci_laporan, $tgl_lock, $tahun, $periode]);
    
echo "<script>window.location.href='index.php?page=menu_final';</script>'";
exit;
