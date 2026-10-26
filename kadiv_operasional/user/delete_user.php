<?php
include "../conn/conn.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM user WHERE user_id='$id'");
echo "<script>window.location.href='index.php?page=list_user';</script>'";
exit;
