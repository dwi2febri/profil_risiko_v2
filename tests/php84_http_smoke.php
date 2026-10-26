<?php
// Local-only smoke test. Uses existing accounts without changing their credentials.
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
$base = 'http://127.0.0.1/profil_risiko_v2/';
$cookies = tempnam(sys_get_temp_dir(), 'php84-session-');
$client = curl_init();
curl_setopt_array($client, [CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIEJAR => $cookies,
    CURLOPT_COOKIEFILE => $cookies, CURLOPT_TIMEOUT => 30, CURLOPT_FOLLOWLOCATION => false]);
function smoke_request($client, $url, $post = null, $multipart = false) {
    curl_setopt($client, CURLOPT_URL, $url);
    curl_setopt($client, CURLOPT_POST, $post !== null);
    if ($post !== null) curl_setopt($client, CURLOPT_POSTFIELDS, $multipart ? $post : http_build_query($post));
    $body = curl_exec($client);
    if ($body === false) throw new RuntimeException(curl_error($client));
    $status = curl_getinfo($client, CURLINFO_HTTP_CODE);
    if ($status >= 400 || preg_match('/(?:Fatal error|Parse error|Deprecated|Warning):/', $body)) {
        preg_match('/(?:Fatal error|Parse error|Deprecated|Warning):[^\r\n<]*/', $body, $match);
        throw new RuntimeException($url . ': HTTP ' . $status . ' ' . ($match[0] ?? ''));
    }
    return [$status, $body];
}
try {
    foreach (['admin' => 'admin', 'admin kc' => 'admin_kc'] as $role => $folder) {
        $safeRole = mysqli_real_escape_string($conn, $role);
        $account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username,password FROM user WHERE tipe='$safeRole' ORDER BY user_id LIMIT 1"));
        if (!$account) throw new RuntimeException('No test account for ' . $role);
        [$status] = smoke_request($client, $base . 'index.php', $account);
        if ($status !== 302 || !str_contains(curl_getinfo($client, CURLINFO_REDIRECT_URL), '/' . $folder . '/')) {
            throw new RuntimeException('Login redirect failed for ' . $role);
        }
        foreach (['index.php', 'data_master/upload_kredit.php?template=1', 'data_master/upload_likuiditas.php?template=1'] as $path) {
            [$status, $body] = smoke_request($client, $base . $folder . '/' . $path);
            if ($status !== 200) throw new RuntimeException('Unexpected redirect: ' . $folder . '/' . $path);
            if (str_contains($path, 'template=1') && !str_contains($body, 'field;value')) throw new RuntimeException('CSV template output missing');
            echo 'PASS: ', $folder, '/', $path, PHP_EOL;
        }
        // Exercise the real CSV reader using an unknown field; no master data is updated.
        foreach (['kredit', 'likuiditas'] as $kind) {
            [$status] = smoke_request($client, $base . $folder . '/data_master/upload_' . $kind . '.php?id=555', [
                'upload' => '1',
                'file_csv' => new CURLStringFile("field;value\n__php84_unknown_field__;0\n", 'php84.csv', 'text/csv'),
            ], true);
            $redirect = curl_getinfo($client, CURLINFO_REDIRECT_URL);
            if ($status !== 302 || !str_contains($redirect, '/index.php?page=')) throw new RuntimeException('CSV reader failed: ' . $folder . '/' . $kind);
            echo 'PASS: ', $folder, '/CSV reader ', $kind, ' (no data changed)', PHP_EOL;
        }
        if ($folder === 'admin') {
            foreach (['pembanding', 'kre_kpmr1', 'op_kpmr1', 'kep_kpmr1', 'lik_kpmr1', 'rep_kpmr1', 'stra_kpmr1', 'op_inhern1', 'kep_inhern1', 'rep_inhern1', 'stra_inhern1'] as $page) {
                [$status, $body] = smoke_request($client, $base . 'admin/index.php?page=' . $page . '&id=555');
                if ($status !== 200 || strlen($body) < 1000) throw new RuntimeException('Risk page not rendered: ' . $page);
                echo 'PASS: admin/', $page, PHP_EOL;
            }
        }
        smoke_request($client, $base . $folder . '/logout.php');
    }
} finally {
    curl_close($client);
    if (is_file($cookies)) unlink($cookies);
}
