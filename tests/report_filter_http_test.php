<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../conn/conn.php';
$base = $argv[1] ?? 'http://127.0.0.1/profil_risiko_v2/';
if (!preg_match('~^http://127\.0\.0\.1(?::[0-9]+)?/profil_risiko_v2/$~D', $base)) exit(1);
function filter_check($value, $message) { if (!$value) throw new RuntimeException($message); }
$cookies = tempnam(sys_get_temp_dir(), 'filter-http-');
$client = curl_init();
curl_setopt_array($client, [CURLOPT_RETURNTRANSFER=>true, CURLOPT_COOKIEJAR=>$cookies,
    CURLOPT_COOKIEFILE=>$cookies, CURLOPT_TIMEOUT=>60, CURLOPT_FOLLOWLOCATION=>false]);
try {
    $account = mysqli_fetch_assoc(simpro_db_query($conn, 'SELECT username,password FROM user WHERE tipe=? ORDER BY user_id LIMIT 1', ['admin']));
    filter_check((bool)$account, 'Missing local test account');
    curl_setopt_array($client, [CURLOPT_URL=>$base, CURLOPT_POST=>true, CURLOPT_POSTFIELDS=>http_build_query($account)]);
    filter_check(curl_exec($client) !== false, 'Login request failed: '.curl_error($client));
    filter_check(curl_getinfo($client, CURLINFO_HTTP_CODE) === 302, 'Login failed');
    foreach (['rekap_dvs'=>'Rekap Per Divisi', 'hasil_lapkc'=>'Hasil Laporan Profil Risiko Kantor Cabang'] as $page=>$title) {
        $cases = [['tahun'=>2026,'periode'=>2], ['tahun'=>2026,'periode'=>3], ['tahun'=>2025,'periode'=>4]];
        if ($page === 'hasil_lapkc') $cases[] = ['tahun'=>2026,'periode'=>3,'status_laporan'=>'diterima'];
        foreach ($cases as $filter) {
            if ($page === 'hasil_lapkc' && !isset($filter['status_laporan'])) $filter['status_laporan'] = 'semua';
            curl_setopt_array($client, [CURLOPT_URL=>$base.'admin/'.$page, CURLOPT_POST=>true,
                CURLOPT_POSTFIELDS=>http_build_query($filter+['submit'=>'1'])]);
            $body = curl_exec($client);
            $status = curl_getinfo($client, CURLINFO_HTTP_CODE);
            filter_check($status === 303, "$page: filter POST returned HTTP $status instead of redirect; complete layout=".(str_contains((string)$body, '</html>') ? 'yes':'no'));
            $location = curl_getinfo($client, CURLINFO_REDIRECT_URL);
            $url = parse_url($location); parse_str($url['query'] ?? '', $query);
            filter_check(($url['path'] ?? '') === '/profil_risiko_v2/admin/'.$page, 'Wrong filter redirect path');
            foreach ($filter as $name=>$value) filter_check((string)($query[$name] ?? '') === (string)$value, 'Filter lost: '.$name);
            filter_check(!isset($query['page']), 'Legacy page parameter leaked into URL');
            curl_setopt_array($client, [CURLOPT_URL=>$location, CURLOPT_POST=>false]);
            $html = curl_exec($client);
            filter_check(curl_getinfo($client, CURLINFO_HTTP_CODE) === 200, 'Filtered GET failed');
            filter_check(str_contains((string)$html, $title) && str_contains((string)$html, '</html>') && str_contains((string)$html, 'assets/js/app.min.js'), 'Filtered HTML stops before layout scripts');
            filter_check(!preg_match('/(?:Fatal error|Parse error|Cannot modify header)/i', $html), 'Filtered page contains PHP error');
            $document = new DOMDocument(); @$document->loadHTML($html);
            $xpath = new DOMXPath($document);
            $forms = $xpath->query('//form[.//select[@name="tahun"] and .//select[@name="periode"]]');
            filter_check($forms->length === 1 && strtolower($forms->item(0)->getAttribute('method')) === 'get', 'Filter must have one GET form');
            filter_check($forms->item(0)->getAttribute('action') === '/profil_risiko_v2/admin/'.$page, 'GET form targets the wrong controller');
            foreach (['tahun','periode'] as $name) {
                $selected = $xpath->query('//select[@name="'.$name.'"]/option[@selected]');
                $matched = false;
                foreach ($selected as $option) if ($option->getAttribute('value') === (string)$filter[$name]) $matched = true;
                filter_check($matched, 'Selected filter missing: '.$name);
            }
            echo 'PASS ', $page, ' ', http_build_query($filter), ': POST redirect, GET filter and complete layout', PHP_EOL;
        }
    }
} finally {
    curl_setopt_array($client, [CURLOPT_URL=>$base.'admin/logout.php', CURLOPT_POST=>false]);
    curl_exec($client); curl_close($client); @unlink($cookies);
}
