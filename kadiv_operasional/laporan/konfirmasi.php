<?php
include "../conn/conn.php";

$id = $_GET['id'] ?? '';

if ($id != '') {
    mysqli_query($conn, "UPDATE frame_laporan_profil_risiko SET status_skmr = '1' WHERE id_profil_risiko='$id'");
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
