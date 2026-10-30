<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
function mon_response(int $status, array $data): never
{
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
    exit;
}
if (empty($_SESSION['user_id']) || ($_SESSION['tipe'] ?? '') !== 'admin') mon_response(401, ['error' => 'Sesi admin diperlukan. Silakan masuk kembali.']);
require_once __DIR__ . '/../conn/conn.php';
mysqli_set_charset($conn, 'utf8mb4');
require_once __DIR__ . '/includes/monitoring_data.php';
require_once __DIR__ . '/includes/monitoring_gemini.php';
try {
    $action = $_GET['action'] ?? 'overview';
    if ($action === 'overview' && $_SERVER['REQUEST_METHOD'] === 'GET') {
        session_write_close();
        $dashboard = mon_dashboard($conn, $_GET);
        $dashboard['geminiConfigured'] = mon_gemini_config()['key'] !== '';
        mon_response(200, $dashboard);
    }
    if (!in_array($action, ['recommend', 'explain'], true) || $_SERVER['REQUEST_METHOD'] !== 'POST') mon_response(405, ['error' => 'Metode permintaan tidak didukung.']);
    if (!hash_equals((string)($_SESSION['monitoring_csrf'] ?? ''), (string)($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '')) || empty($_SESSION['monitoring_csrf'])) mon_response(403, ['error' => 'Token sesi tidak valid. Muat ulang halaman.']);
    $body = file_get_contents('php://input', false, null, 0, 16385);
    if (strlen($body) > 16384) mon_response(413, ['error' => 'Permintaan terlalu besar.']);
    $input = json_decode($body, true, 32, JSON_THROW_ON_ERROR);
    if (!is_array($input)) throw new InvalidArgumentException('Filter rekomendasi tidak valid.');
    if ($action === 'explain' && (!is_string($input['parameter_key'] ?? null) || !preg_match('/^[a-f0-9]{64}$/D', $input['parameter_key']))) throw new InvalidArgumentException('Identitas parameter tidak valid.');
    $dashboard = mon_dashboard($conn, $input);
    $context = $action === 'explain' ? mon_parameter_ai_context($dashboard, (string)($input['parameter_key'] ?? '')) : mon_ai_context($dashboard);
    $fingerprint = hash('sha256', json_encode($context, JSON_THROW_ON_ERROR));
    $cached = $_SESSION['monitoring_ai_cache'][$fingerprint] ?? null;
    if ($cached && time() - $cached['time'] < 600) mon_response(200, $cached['result'] + ['cached' => true]);
    if (time() - (int)($_SESSION['monitoring_ai_last'] ?? 0) < 30) mon_response(429, ['error' => 'Tunggu 30 detik sebelum membuat analisis Gemini berikutnya.']);
    $_SESSION['monitoring_ai_last'] = time();
    session_write_close();
    $recommendation = mon_gemini_recommend($context);
    session_start();
    $_SESSION['monitoring_ai_cache'] = [$fingerprint => ['time' => time(), 'result' => $recommendation]];
    session_write_close();
    mon_response(200, $recommendation);
} catch (InvalidArgumentException | JsonException $error) {
    mon_response(422, ['error' => $error instanceof JsonException ? 'Format data permintaan atau respons tidak valid.' : $error->getMessage()]);
} catch (MonitoringGeminiException $error) {
    mon_response(502, ['error' => $error->getMessage()]);
} catch (Throwable $error) {
    error_log('Monitoring dashboard: ' . get_class($error));
    mon_response(500, ['error' => 'Data monitoring belum dapat dimuat. Silakan coba kembali.']);
}
