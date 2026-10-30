<?php
require dirname(__DIR__, 2).'/conn/conn.php';
$id = $_GET['id'];
simpro_db_query($conn, "DELETE FROM user WHERE user_id=?", [$id]);
echo "<script>window.location.href='index.php?page=list_user';</script>'";
exit;
