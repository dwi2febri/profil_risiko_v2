<?php
if (PHP_SAPI !== 'cli') exit(1);
require dirname(__DIR__).'/conn/conn.php';
function activity_assert(bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
}
// Temporary table shadows the application table: fixtures never persist.
$schema = file_get_contents(dirname(__DIR__).'/database/20261118_log_aktivitas.sql');
$conn->query(str_replace('CREATE TABLE IF NOT EXISTS', 'CREATE TEMPORARY TABLE', $schema));
$server = ['REQUEST_URI'=>'/admin/index.php?page=edit_user&password=secret', 'REQUEST_METHOD'=>'POST', 'REMOTE_ADDR'=>'127.0.0.1'];
$context = simpro_activity_context($server, ['page'=>'edit_user', 'id'=>123, 'token'=>'secret'], ['password'=>'secret', 'id_user'=>7]);
activity_assert($context['aktivitas'] === 'Kirim data' && !str_contains(json_encode($context), 'secret'), 'Sensitive payload leaked');
activity_assert(simpro_activity_context($server, ['page'=>'delete_user'], [])['aktivitas'] === 'Permintaan hapus', 'Delete classification');
activity_assert(simpro_activity_context($server, ['page'=>'cetak_laporan'], [])['aktivitas'] === 'Cetak / unduh', 'Print classification');
$userA = ['user_id'=>900000001, 'username'=>'audit-user-a', 'nama'=>'<script>alert(1)</script>', 'tipe'=>'admin kc'];
$userB = ['user_id'=>900000002, 'username'=>'audit-user-b', 'nama'=>'Other user', 'tipe'=>'admin'];
activity_assert(simpro_activity_write($conn, $userA, $context, 200), 'Insert user A');
activity_assert(simpro_activity_write($conn, $userB, $context, 500), 'Insert user B');
activity_assert(simpro_activity_write($conn, [], array_replace($context, ['aktivitas'=>'Login gagal']), 302), 'Anonymous login failure');
session_start();
$_SESSION = $userA;
$_GET = ['page'=>'log_aktivitas', 'user_id'=>$userB['user_id']];
function activity_render(): string {
    global $conn;
    ob_start();
    include dirname(__DIR__).'/fungsi/activity_log_page.php';
    return ob_get_clean();
}
$body = activity_render();
activity_assert(str_contains($body, '&lt;script&gt;') && !str_contains($body, 'Other user'), 'Cross-user log disclosure');
activity_assert(!str_contains($body, 'audit-user-a') && !str_contains($body, 'audit-user-b'), 'Username should not be rendered');
activity_assert(str_contains($body, '&lt;script&gt;') && !str_contains($body, '<script>alert'), 'Stored XSS');
$_SESSION = $userB;
$body = activity_render();
activity_assert(str_contains($body, '&lt;script&gt;') && str_contains($body, 'Other user'), 'Admin cannot see all users');
$_GET = ['cari'=>"' OR 1=1 --"];
$body = activity_render();
activity_assert(!str_contains($body, 'Other user'), 'Search SQL injection');
$_GET = ['aktivitas'=>'Login gagal', 'mulai'=>date('Y-m-d'), 'sampai'=>date('Y-m-d')];
$body = activity_render();
activity_assert(str_contains($body, '1 aktivitas tercatat.'), 'Date/action filters');
$conn->query('DROP TEMPORARY TABLE log_aktivitas');
session_destroy();
require dirname(__DIR__).'/fungsi/excel_export.php';
$file = tempnam(sys_get_temp_dir(), 'activity-xlsx-test-');
try {
    simpro_excel_file($file, ['Pengguna','Aktivitas'], [['=HYPERLINK("bad")', "Teks & <xml>\x01"]]);
    $zip = new ZipArchive();
    activity_assert($zip->open($file) === true, 'Invalid XLSX archive');
    $sheet = $zip->getFromName('xl/worksheets/sheet1.xml');
    activity_assert(simplexml_load_string($sheet) !== false, 'Invalid worksheet XML');
    activity_assert(!str_contains($sheet, '<f>') && str_contains($sheet, 'inlineStr') && str_contains($sheet, '=HYPERLINK'), 'Spreadsheet formula injection');
    activity_assert(!str_contains($sheet, "\x01"), 'Invalid XML control character');
    $zip->close();
} finally { @unlink($file); }
echo "PASS: payload privacy, classification, inserts, role isolation, XSS, SQL injection and filters\n";
echo "PASS: XLSX structure, XML escaping, formula safety\n";
