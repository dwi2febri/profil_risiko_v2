<?php
require_once dirname(__DIR__).'/fungsi/database_security.php';
simpro_database_request_guard();
if (PHP_SAPI !== 'cli') {
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
}

$conn = mysqli_connect("localhost", "root", "", "profil_risiko_v2");

mysqli_set_charset($conn, 'utf8mb4');
