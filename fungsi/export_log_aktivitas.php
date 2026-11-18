<?php
require dirname(__DIR__).'/conn/conn.php'; // Authentication guard runs before exporting.
require_once __DIR__.'/activity_log_filters.php';
require_once __DIR__.'/excel_export.php';
if (empty($_SESSION['user_id'])) { http_response_code(403); exit('Akses ditolak.'); }
if (!class_exists('ZipArchive')) { http_response_code(503); exit('Export Excel memerlukan ekstensi PHP zip.'); }
[, , $clause, $params] = simpro_activity_filters($_GET, $_SESSION);
$target = tempnam(sys_get_temp_dir(), 'simpro-log-');
try {
    $result = simpro_db_query($conn, 'SELECT waktu,nama,role,aktivitas,halaman,id_data,metode,status_http,alamat_ip FROM log_aktivitas'.$clause.' ORDER BY waktu DESC,id DESC', $params);
    if (!$result) throw new RuntimeException('Log tidak tersedia.');
    $rows = (static function() use ($result): Generator {
        while ($row = mysqli_fetch_row($result)) {
            if ($row[1] === '') $row[1] = 'Pengguna tidak dikenal';
            yield $row;
        }
    })();
    simpro_excel_file($target, ['Waktu (WIB)','Pengguna','Role','Aktivitas','Halaman','ID data','Metode','Status HTTP','Alamat IP'], $rows);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="log-aktivitas-'.(new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))->format('Ymd-His').'.xlsx"');
    header('Cache-Control: private, no-store');
    header('Content-Length: '.filesize($target));
    readfile($target);
} catch (Throwable $error) {
    http_response_code(500);
    echo 'Export log gagal. Periksa tabel log_aktivitas dan konfigurasi server.';
} finally {
    @unlink($target);
}
