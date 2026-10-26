<?php error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); ?>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}


?>

<?php
session_start();
$cek = $_SESSION['tipe'];
if ($cek != "kepala cabang") {
    header("Location: ../../login.php");
    exit();
}

?>