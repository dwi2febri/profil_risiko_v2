<?php
require_once __DIR__.'/database_security.php';
if (session_status() === PHP_SESSION_NONE) session_start();
if (!empty($_SESSION['user_id'])) {
    require dirname(__DIR__).'/conn/conn.php';
    $GLOBALS['simpro_activity_explicit'] = true;
    $activity = simpro_activity_context($_SERVER, [], []);
    $activity['aktivitas'] = 'Logout';
    simpro_activity_write($conn, $_SESSION, $activity, 302);
}
$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $cookie = session_get_cookie_params();
    setcookie(session_name(), '', time()-42000, $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
}
session_destroy();
header('Location: '.simpro_app_base_path().'?alert=logout', true, 302);
exit;
