<?php
/** Request audit: never persist form bodies, passwords, cookies or query strings. */
function simpro_activity_context(array $server, array $get, array $post): array
{
    $path = (string)(parse_url((string)($server['REQUEST_URI'] ?? $server['SCRIPT_NAME'] ?? ''), PHP_URL_PATH) ?: '');
    $page = is_string($get['page'] ?? null) && preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/D', $get['page']) ? $get['page'] : '';
    $route = $path.($page !== '' ? ' [page='.$page.']' : '');
    $method = strtoupper((string)($server['REQUEST_METHOD'] ?? 'GET'));
    $action = 'Buka halaman';
    if (preg_match('/hapus|delete|remove/i', $route)) $action = 'Permintaan hapus';
    elseif (preg_match('/cetak|print|export|excel|download/i', $route) || isset($get['print_pdf']) || isset($get['cetak_excel'])) $action = 'Cetak / unduh';
    elseif (!in_array($method, ['GET', 'HEAD'], true)) $action = 'Kirim data';
    elseif (strtolower((string)($server['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest') $action = 'Akses AJAX';
    $ids = [];
    foreach ([$get, $post] as $input) {
        foreach ($input as $key => $value) {
            if (preg_match('/^id(?:_[a-z0-9_]+)?$/iD', (string)$key) && is_scalar($value) && preg_match('/^\d+$/D', (string)$value)) {
                $ids[$key] = $key.'='.$value;
            }
        }
    }
    return ['aktivitas'=>$action, 'halaman'=>$route, 'id_data'=>implode(', ', $ids), 'metode'=>$method,
        'alamat_ip'=>filter_var($server['REMOTE_ADDR'] ?? '', FILTER_VALIDATE_IP) ?: ''];
}

function simpro_activity_write(mysqli $conn, array $actor, array $context, int $status = 200): bool
{
    try {
        $cut = static fn($value, int $length): string => mb_substr((string)$value, 0, $length, 'UTF-8');
        $values = [(new DateTimeImmutable('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s'),
            isset($actor['user_id']) ? (int)$actor['user_id'] : null,
            $cut($actor['username'] ?? '', 191), $cut($actor['nama'] ?? '', 191), $cut($actor['tipe'] ?? '', 100),
            $cut($context['aktivitas'], 50), $cut($context['halaman'], 512), $cut($context['id_data'] ?? '', 100),
            $cut($context['metode'], 10), $status, $cut($context['alamat_ip'] ?? '', 45)];
        // Use a separate statement so legacy affected_rows/insert_id consumers remain intact.
        $stmt = $conn->prepare('INSERT INTO log_aktivitas (waktu,user_id,username,nama,role,aktivitas,halaman,id_data,metode,status_http,alamat_ip) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
        if (!$stmt) return false;
        $stmt->bind_param('sisssssssis', ...$values);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    } catch (Throwable $error) {
        // A missing migration must not interrupt existing application operations.
        error_log('SIMPRO: pencatatan log aktivitas gagal; periksa tabel log_aktivitas dan koneksi database.');
        return false;
    }
}

function simpro_activity_bootstrap(mysqli $conn): void
{
    static $registered = false;
    if ($registered || PHP_SAPI === 'cli' || empty($_SESSION['user_id'])) return;
    $registered = true;
    $actor = array_intersect_key($_SESSION, array_flip(['user_id', 'username', 'nama', 'tipe']));
    $context = simpro_activity_context($_SERVER, $_GET, $_POST);
    register_shutdown_function(static function() use ($conn, $actor, $context): void {
        if (!empty($GLOBALS['simpro_activity_explicit'])) return;
        $last = error_get_last();
        $fatal = $last && in_array($last['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR], true);
        $status = $fatal ? 500 : (http_response_code() ?: 200);
        simpro_activity_write($conn, $actor, $context, $status);
    });
}
