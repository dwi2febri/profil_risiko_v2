<?php
require_once __DIR__.'/database_security.php';
if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $cookie = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
}
session_destroy();
header('Location: '.simpro_app_base_path().'?alert=logout', true, 302);
exit;
