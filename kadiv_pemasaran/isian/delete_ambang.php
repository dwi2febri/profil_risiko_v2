<?php
require dirname(__DIR__, 2).'/conn/conn.php';
$id = $_GET['idam'];
simpro_db_query($conn, "DELETE FROM ambang_batas_kredit WHERE id_ambang_batas_kredit=?", [$id]);
simpro_db_query($conn, "DELETE FROM ambang_batas_likuiditas WHERE id_ambang_batas_likuiditas=?", [$id]);

echo "<script>window.location.href='index.php?page=frame_ambang';</script>'";
exit;
