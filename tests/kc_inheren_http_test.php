<?php
// Local CLI smoke test: opens the normal KC pages, including their row initialization.
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
$reportId = (int)($argv[1] ?? 610);
$report = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT user FROM frame_laporan_profil_risiko WHERE id_profil_risiko=' . $reportId));
if ((int)($report['user'] ?? 0) !== 3) throw new RuntimeException('Choose an existing KC report ID');
$cookie = tempnam(sys_get_temp_dir(), 'kc-inheren-http-');
$client = curl_init();
curl_setopt_array($client, [CURLOPT_RETURNTRANSFER => true, CURLOPT_COOKIEJAR => $cookie,
    CURLOPT_COOKIEFILE => $cookie, CURLOPT_TIMEOUT => 30, CURLOPT_FOLLOWLOCATION => false]);
function kc_inheren_request($client, $path, $post = null): array
{
    curl_setopt($client, CURLOPT_URL, 'http://127.0.0.1/profil_risiko_v2/' . $path);
    curl_setopt($client, CURLOPT_POST, $post !== null);
    if ($post !== null) curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($post));
    $html = curl_exec($client);
    if ($html === false) throw new RuntimeException(curl_error($client));
    return [curl_getinfo($client, CURLINFO_HTTP_CODE), $html];
}
try {
    foreach (['admin' => 'admin', 'admin kc' => 'admin_kc'] as $role => $folder) {
        $safeRole = mysqli_real_escape_string($conn, $role);
        $account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT username,password FROM user WHERE tipe='$safeRole' ORDER BY user_id LIMIT 1"));
        if (!$account) throw new RuntimeException('No local account for ' . $folder);
        [$status] = kc_inheren_request($client, 'index.php', $account);
        if ($status !== 302) throw new RuntimeException('Login failed for ' . $folder);
        foreach (['kre_inhern' => 'RISIKO KREDIT INHEREN', 'lik_inhern' => 'RISIKO LIKUIDITAS INHEREN'] as $page => $heading) {
            [$status, $html] = kc_inheren_request($client, $folder . '/index.php?page=' . $page . '&id=' . $reportId);
            if ($status !== 200 || strlen($html) < 20000 || !str_contains($html, $heading)
                || preg_match('/(?:Fatal error|Parse error|Warning|Deprecated)(?:<[^>]+>)*:/', $html)) {
                throw new RuntimeException('KC page failed: ' . $folder . '/' . $page . ' HTTP ' . $status);
            }
            echo 'PASS HTTP ', $folder, '/', $page, ' report ', $reportId, ' (', strlen($html), ' bytes)', PHP_EOL;
        }
        kc_inheren_request($client, $folder . '/logout.php');
    }
} finally {
    curl_close($client);
    if (is_file($cookie)) unlink($cookie);
}
