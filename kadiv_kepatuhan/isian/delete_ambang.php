<?php
include "../conn/conn.php";
$id = $_GET['idam'];
mysqli_query($conn, "DELETE FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id'");
mysqli_query($conn, "DELETE FROM ambang_batas_likuiditas WHERE id_ambang_batas_likuiditas='$id'");

echo "<script>window.location.href='index.php?page=frame_ambang';</script>'";
exit;
