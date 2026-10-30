<?php
require_once __DIR__.'/fungsi/authentication.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$appBase = simpro_app_base_path();
$id = $_SESSION['user_id'] ?? null;
if (!is_scalar($id) || !ctype_digit((string)$id) || (int)$id <= 0) {
    header('Location: '.$appBase, true, 302); exit;
}
require __DIR__.'/conn/conn.php';
$result = simpro_db_query($conn, 'SELECT user_id,tipe FROM user WHERE user_id = ? LIMIT 1', [(int)$id]);
$data = $result ? mysqli_fetch_assoc($result) : null;
$folder = $data ? simpro_role_folder((string)$data['tipe']) : null;
header('Location: '.$appBase.($folder ? $folder.'/' : ''), true, 302);
exit;
