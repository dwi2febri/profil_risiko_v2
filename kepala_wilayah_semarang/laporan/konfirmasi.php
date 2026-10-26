<?php
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn, "UPDATE frame_laporan_profil_risiko SET status_korwil = '1' WHERE id_profil_risiko='$id'");

echo "<script>window.location.href='index.php?page=laporan_masuk';</script>'";
exit;
