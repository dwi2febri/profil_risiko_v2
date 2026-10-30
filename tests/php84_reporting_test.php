<?php
// CLI-only, read-only regression probe for dashboard and recap templates.
if (PHP_SAPI !== 'cli') exit(1);

$root = dirname(__DIR__);
$relative = str_replace('\\', '/', $argv[1] ?? 'pic_area_solo/home.php');
$scenario = $argv[2] ?? 'empty';
$target = realpath($root . '/' . $relative);
if (!$target || !str_starts_with($target, $root . DIRECTORY_SEPARATOR)
    || !preg_match('~^[a-z_]+/(?:laporan/)?(?:home|dash_kc|dash_konsol|dashboard_korwil|tren|file_coba|rekap_cabang|rekap_divisi|hasil_laporan_cabang)\.php$~', $relative)
    || !in_array($scenario, ['empty', 'missing', 'populated', 'trend', 'branch_results'], true)) {
    fwrite(STDERR, "Invalid reporting probe target or scenario\n");
    exit(1);
}

require $root . '/conn/conn.php';
$folder = explode('/', $relative)[0];
$controller = file_get_contents($root . '/' . $folder . '/index.php');
if (!preg_match('/\$cek\s*!=\s*"([^"]+)"/', $controller, $roleMatch)) {
    throw new RuntimeException('Cannot determine role for ' . $folder);
}
$safeRole = mysqli_real_escape_string($conn, $roleMatch[1]);
$account = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id,username,nama,lokasi_kerja,tipe FROM user WHERE tipe='$safeRole' ORDER BY user_id LIMIT 1"));
if (!$account) throw new RuntimeException('No local account for ' . $folder);
session_save_path(sys_get_temp_dir());
session_start();
$_SESSION = $account;
$_POST = [];
$_GET = [];
if ($scenario === 'missing') {
    $_GET = ['tahun' => 1900, 'periode' => 1, 'kode_kantor' => 999999, 'id' => 0];
} elseif ($scenario === 'populated') {
    $fixture = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id_profil_risiko,tahun,periode,kantor_cabang FROM frame_laporan_profil_risiko WHERE user=3 ORDER BY status_skmr DESC,tahun DESC,periode DESC,id_profil_risiko DESC LIMIT 1"));
    if (!$fixture) throw new RuntimeException('No local branch report fixture');
    $_GET = ['tahun' => $fixture['tahun'], 'periode' => $fixture['periode'],
        'kode_kantor' => $fixture['kantor_cabang'], 'id' => $fixture['id_profil_risiko']];
} elseif ($scenario === 'branch_results') {
    if ($relative !== 'admin/laporan/hasil_laporan_cabang.php') throw new RuntimeException('Branch-results scenario targets the admin results page');
    $fixture = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT tahun,periode FROM frame_laporan_profil_risiko
        WHERE user=3 ORDER BY tahun DESC,periode DESC LIMIT 1'));
    if (!$fixture) throw new RuntimeException('No local branch report fixture');
    $_GET = ['tahun' => $fixture['tahun'], 'periode' => $fixture['periode'], 'status_laporan' => $argv[4] ?? 'semua'];
    $expectedBranchFrames = [];
    $expectedFrameQuery = mysqli_query($conn, 'SELECT id_profil_risiko,kantor_cabang,status_korwil,status_skmr
        FROM frame_laporan_profil_risiko WHERE user=3 AND tahun=' . (int)$fixture['tahun'] . '
        AND periode=' . (int)$fixture['periode'] . ' ORDER BY id_profil_risiko DESC');
    while ($expectedFrame = mysqli_fetch_assoc($expectedFrameQuery)) {
        if ($_GET['status_laporan'] === 'diterima'
            && ((int)$expectedFrame['status_korwil'] !== 1 || (int)$expectedFrame['status_skmr'] !== 1)) continue;
        $branch = (int)$expectedFrame['kantor_cabang'];
        if (!isset($expectedBranchFrames[$branch])) $expectedBranchFrames[$branch] = $expectedFrame;
    }
} elseif ($scenario === 'trend') {
    $source = file_get_contents($target);
    $isCentral = str_contains($source, '$kantor_cabang = 100;');
    $fixtureCondition = $isCentral ? 'user NOT IN (2,3) AND kantor_cabang=100' : 'user=3';
    $fixture = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT user,kantor_cabang,tahun,
        MIN(periode) AS first_quarter,MAX(periode) AS last_quarter
        FROM frame_laporan_profil_risiko WHERE ' . $fixtureCondition . '
        GROUP BY user,kantor_cabang,tahun ORDER BY tahun DESC,kantor_cabang,user LIMIT 1'));
    if (!$fixture) throw new RuntimeException('No local trend report fixture');
    $_GET = ['tahun' => $fixture['tahun'], 'periode' => $fixture['last_quarter'],
        'kode_kantor' => $fixture['kantor_cabang'], 'kode_kantor_tren' => $fixture['kantor_cabang'],
        'user' => $fixture['user'], 'user22' => $fixture['user'],
        'start_year' => $fixture['tahun'], 'end_year' => $fixture['tahun'],
        'start_quarter' => $fixture['first_quarter'], 'end_quarter' => $fixture['last_quarter']];
    $expectedTrendRows = [];
    $expectedQuery = mysqli_query($conn, 'SELECT f.tahun,f.periode,k.inheren_kredit
        FROM frame_laporan_profil_risiko f LEFT JOIN keterangan_profil_kredit k ON k.id_profil_risiko=f.id_profil_risiko
        WHERE f.user=' . (int)$fixture['user'] . ' AND f.kantor_cabang=' . (int)$fixture['kantor_cabang'] . '
        AND f.tahun=' . (int)$fixture['tahun'] . ' ORDER BY f.tahun,f.periode');
    while ($expectedRow = mysqli_fetch_assoc($expectedQuery)) $expectedTrendRows[] = $expectedRow;
}
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['PHP_SELF'] = '/' . $folder . '/index.php';
$_SERVER['SCRIPT_NAME'] = $_SERVER['PHP_SELF'];
$_SERVER['HTTP_HOST'] = '127.0.0.1';
$user_id = $account['user_id'];
$id = (int)($_GET['id'] ?? 0);
$data_user = $account;
$get_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko='$id'"));

$diagnostics = [];
error_reporting(E_ALL);
set_error_handler(function ($severity, $message, $file, $line) use (&$diagnostics) {
    // Legacy verif.php starts the already active session twice.
    if ($severity === E_NOTICE && str_contains($message, 'session_start()')) return true;
    $diagnostics[] = basename($file) . ':' . $line . ' ' . $message;
    return true;
});
ob_start();
try {
    chdir($root . '/' . $folder);
    require $target;
} catch (Throwable $error) {
    $diagnostics[] = basename($error->getFile()) . ':' . $error->getLine() . ' '
        . get_class($error) . ': ' . $error->getMessage();
}
$html = ob_get_clean();
restore_error_handler();
session_destroy();
if (isset($argv[3])) file_put_contents($argv[3], $html);
if (strlen($html) < 1000) $diagnostics[] = 'Template did not render sufficient content';
if ($scenario === 'trend') {
    $expectedPeriods = array_map(fn($row) => 'Triwulan ' . $row['periode'] . ' ' . $row['tahun'], $expectedTrendRows);
    $expectedCredit = array_map(fn($row) => $row['inheren_kredit'] ?? '-', $expectedTrendRows);
    if (($periode_list ?? []) !== $expectedPeriods) $diagnostics[] = 'Existing report periods disappeared from the trend table';
    if (($inheren ?? []) !== $expectedCredit) $diagnostics[] = 'Credit trend values do not match the selected reports';
    if (str_contains($html, 'class="risk-trend-empty"')) $diagnostics[] = 'Empty state shown despite matching reports';
}
if ($scenario === 'branch_results') {
    if (($hasilKCFrames ?? []) !== $expectedBranchFrames) $diagnostics[] = 'Selected reports do not match the year, quarter and receipt filter';
    $regions = ['semarang_cnt', 'solo_cnt', 'banyumas_cnt', 'pekalongan_cnt'];
    foreach ($regions as $index => $counter) {
        $expectedCount = count(array_filter(array_keys($expectedBranchFrames), fn($branch) => $branch >= $index * 7 + 1 && $branch <= ($index + 1) * 7));
        if ((int)(${$counter}['total'] ?? -1) !== $expectedCount) $diagnostics[] = 'Incorrect regional report count: ' . $counter;
    }
    foreach ($expectedBranchFrames as $branch => $frame) {
        $expectedValue = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT pil1_tingkat_risiko FROM hasil_inheren_kredit WHERE id_profil_risiko=' . (int)$frame['id_profil_risiko']));
        if ((${'kredit' . $branch}['pil1_tingkat_risiko'] ?? null) !== ($expectedValue['pil1_tingkat_risiko'] ?? null)) $diagnostics[] = 'Missing credit data for branch ' . $branch;
    }
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    $rows = $xpath->query('//table[@id="datatable-buttons1"]/tbody/tr');
    $columns = $xpath->query('//table[@id="datatable-buttons1"]/thead/tr/th')->length;
    if ($rows->length !== count($expectedBranchFrames)) $diagnostics[] = 'Incorrect number of visible branch rows';
    foreach ($rows as $row) {
        $cells = $xpath->query('./td', $row);
        if ($cells->length !== $columns) $diagnostics[] = 'Result table has mismatched columns';
        if (trim($cells->item(3)->textContent) === '') $diagnostics[] = 'Receipt status missing from branch row';
    }
    echo 'Selected branch reports: ', count($expectedBranchFrames), PHP_EOL;
}
echo json_encode(['page' => $relative, 'scenario' => $scenario, 'bytes' => strlen($html),
    'diagnostic_count' => count($diagnostics), 'diagnostics' => array_slice(array_values(array_unique($diagnostics)), 0, 12)], JSON_UNESCAPED_SLASHES), PHP_EOL;
exit($diagnostics ? 1 : 0);
