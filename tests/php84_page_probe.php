<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
$folder = $argv[1] ?? 'admin';
if (!in_array($folder, ['admin', 'admin_kc'], true)) exit(1);
$role = $folder === 'admin' ? 'admin' : 'admin kc';
$account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id,username,nama,lokasi_kerja,tipe FROM user WHERE tipe='$role' ORDER BY user_id LIMIT 1"));
session_start();
$_SESSION = $account;
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['PHP_SELF'] = '/' . $folder . '/index.php';
$_SERVER['SCRIPT_NAME'] = $_SERVER['PHP_SELF'];
$_SERVER['HTTP_HOST'] = '127.0.0.1';
$_GET = isset($argv[2]) ? ['page' => $argv[2], 'id' => 555] : [];
ob_start();
register_shutdown_function(function () {
    $last = error_get_last();
    $length = ob_get_length();
    while (ob_get_level()) ob_end_clean();
    if ($last && in_array($last['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_USER_ERROR], true)) {
        echo json_encode($last), PHP_EOL;
        exit(1);
    }
    echo 'PASS: rendered ', $length, ' bytes', PHP_EOL;
});
chdir(__DIR__ . '/../' . $folder);
require 'index.php';
