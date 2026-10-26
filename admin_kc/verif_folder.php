<?php error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE); ?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../login.php");
    exit();
}


?>

<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$cek = $_SESSION['tipe'];
if ($cek != "admin kc") {
    header("Location: ../../login.php");
    exit();
}

?>