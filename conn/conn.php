<?php
require_once dirname(__DIR__).'/fungsi/database_security.php';
simpro_database_request_guard();

$conn = mysqli_connect("localhost", "root", "", "profil_risiko_v2");

mysqli_set_charset($conn, 'utf8mb4');
