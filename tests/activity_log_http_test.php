<?php
// Local HTTP integration using short-lived sessions for existing role accounts.
// Does not change accounts or reports; test requests remain visible in the audit log.
if (PHP_SAPI !== 'cli') exit(1);
ob_start(); // Session fixtures are recreated between requests after progress output.
require dirname(__DIR__).'/conn/conn.php';
require_once dirname(__DIR__).'/fungsi/authentication.php';
require_once dirname(__DIR__).'/fungsi/activity_log_filters.php';
$base = 'http://127.0.0.1/profil_risiko_v2/';
$accounts = $conn->query('SELECT user_id,username,nama,lokasi_kerja,tipe FROM user ORDER BY user_id')->fetch_all(MYSQLI_ASSOC);
$roles = [];
foreach ($accounts as $account) {
    $folder = simpro_role_folder($account['tipe']);
    if ($folder && !isset($roles[$folder])) $roles[$folder] = $account;
}
$client = curl_init();
curl_setopt_array($client, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_FOLLOWLOCATION=>true, CURLOPT_TIMEOUT=>30]);
function activity_http(string $path, ?array $post = null): string {
    global $client, $base;
    curl_setopt($client, CURLOPT_URL, $base.$path);
    curl_setopt($client, CURLOPT_POST, $post !== null);
    if ($post !== null) curl_setopt($client, CURLOPT_POSTFIELDS, http_build_query($post));
    $body = curl_exec($client);
    if ($body === false || curl_getinfo($client, CURLINFO_HTTP_CODE) !== 200) throw new RuntimeException('HTTP request failed: '.$path.' '.curl_error($client));
    if (preg_match('/(?:Fatal error|Parse error|Deprecated|Warning):/', $body)) throw new RuntimeException('PHP error: '.$path);
    return $body;
}
foreach ($roles as $folder=>$account) {
    session_id('activitytest'.bin2hex(random_bytes(12)));
    session_start();
    $_SESSION = $account;
    $sid = session_id();
    session_write_close();
    curl_setopt($client, CURLOPT_COOKIE, session_name().'='.$sid);
    $before = (int)$conn->query('SELECT COALESCE(MAX(id),0) AS id FROM log_aktivitas')->fetch_assoc()['id'];
    $body = activity_http($folder.'/index.php?page=log_aktivitas');
    if (!str_contains($body, 'Riwayat aktivitas') || !str_contains($body, 'Log Aktivitas </span>') || str_contains($body, 'belum tersedia')) throw new RuntimeException('Log page/menu missing: '.$folder);
    $stmt = $conn->prepare('SELECT * FROM log_aktivitas WHERE id > ? AND user_id = ?');
    $stmt->bind_param('ii', $before, $account['user_id']); $stmt->execute();
    $logs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); $stmt->close();
    if (count($logs) !== 1 || $logs[0]['aktivitas'] !== 'Buka halaman') throw new RuntimeException('Expected exactly one page log: '.$folder);
    if (in_array($folder, ['admin', 'admin_kc'], true)) {
        // Compare the full filtered result, including rows beyond page one.
        [, , $clause, $params] = simpro_activity_filters(['aktivitas'=>'Logout'], $account);
        $expected = simpro_db_query($conn, 'SELECT COUNT(*) AS jumlah FROM log_aktivitas'.$clause, $params)->fetch_assoc()['jumlah'];
        $xlsx = activity_http('fungsi/export_log_aktivitas.php?aktivitas=Logout&user_id=999999999');
        $file = tempnam(sys_get_temp_dir(), 'log-http-xlsx-');
        try {
            file_put_contents($file, $xlsx); $zip = new ZipArchive();
            if ($zip->open($file) !== true) throw new RuntimeException('Export is not XLSX');
            $sheet = simplexml_load_string($zip->getFromName('xl/worksheets/sheet1.xml')); $zip->close();
            $sheet->registerXPathNamespace('s', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            if (count($sheet->xpath('//s:row')) !== (int)$expected+1) throw new RuntimeException('Export filters / role scope / row count mismatch');
            if (str_contains($xlsx, 'Password')) throw new RuntimeException('Password column in export');
        } finally { @unlink($file); }
        echo 'PASS: filtered XLSX export with role scope: ', $folder, PHP_EOL;
    }
    $body = activity_http($folder.'/index.php?page=log_aktivitas', ['audit_test'=>'1']);
    $last = $conn->query('SELECT aktivitas FROM log_aktivitas ORDER BY id DESC LIMIT 1')->fetch_assoc();
    if ($last['aktivitas'] !== 'Kirim data') throw new RuntimeException('POST not recorded: '.$folder);
    activity_http($folder.'/logout.php');
    $last = $conn->query('SELECT aktivitas FROM log_aktivitas ORDER BY id DESC LIMIT 1')->fetch_assoc();
    if ($last['aktivitas'] !== 'Logout') throw new RuntimeException('Logout not recorded: '.$folder);
    echo 'PASS: menu, GET/POST logging and logout: ', $folder, PHP_EOL;
}
curl_setopt($client, CURLOPT_COOKIE, '');
curl_setopt($client, CURLOPT_COOKIEFILE, '');
$loginAccount = null;
foreach ($conn->query('SELECT username,password,tipe FROM user ORDER BY user_id')->fetch_all(MYSQLI_ASSOC) as $candidate) {
    if (simpro_role_folder($candidate['tipe']) && empty(password_get_info($candidate['password'])['algo'])) {
        $loginAccount = $candidate; break;
    }
}
if ($loginAccount) {
    activity_http('', ['username'=>$loginAccount['username'], 'password'=>$loginAccount['password']]);
    $rows = $conn->query("SELECT aktivitas FROM log_aktivitas ORDER BY id DESC LIMIT 2")->fetch_all(MYSQLI_ASSOC);
    if (!in_array('Login', array_column($rows, 'aktivitas'), true)) throw new RuntimeException('Successful login not recorded');
    activity_http(simpro_role_folder($loginAccount['tipe']).'/logout.php');
    echo "PASS: successful login through public login form\n";
}
activity_http('', ['username'=>'activity-test-invalid-account', 'password'=>bin2hex(random_bytes(16))]);
$last = $conn->query('SELECT aktivitas FROM log_aktivitas ORDER BY id DESC LIMIT 1')->fetch_assoc();
if ($last['aktivitas'] !== 'Login gagal') throw new RuntimeException('Failed login not recorded');
echo 'PASS: failed login; ', count($roles), " real role controllers checked\n";
curl_close($client);
