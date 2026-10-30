<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
require __DIR__ . '/../admin/includes/monitoring_data.php';
require __DIR__ . '/../admin/includes/monitoring_gemini.php';
function mon_test($condition, string $message): void { if (!$condition) throw new RuntimeException($message); }
function mon_test_snapshot(mysqli $db): array
{
    return mon_rows($db, 'SELECT COUNT(*) reports,SUM(COALESCE(status_korwil,0)) korwil,SUM(COALESCE(status_skmr,0)) skmr FROM frame_laporan_profil_risiko')[0]
        + mon_rows($db, 'SELECT COUNT(*) scores,SUM(total_nilai) total FROM nilai_profil')[0];
}
$before = mon_test_snapshot($conn);
mon_test(mon_score(null) === null && mon_score(0) === null && mon_score(0.43) === null && mon_score(6) === null, 'Missing or invalid score became a low-risk rating');
mon_test(mon_score('3.25') === 3.25, 'Stored score changed');
$sampleFrames = [['id' => 1]];
$partialValues = [1 => ['score' => null, 'risks' => ['kredit' => ['inheren' => 1.0]]]];
mon_test(mon_metric($sampleFrames, $partialValues, null, 'inheren') === null, 'Incomplete six-risk average produced a misleading index');
$fullValues = [1 => ['score' => 2.9, 'risks' => array_fill_keys(array_keys(mon_risks()), ['inheren' => 2.5])]];
mon_test(mon_metric($sampleFrames, $fullValues, null, 'inheren') === 2.5, 'Complete six-risk average changed');
$options = mon_options($conn);
foreach ([['start_year' => 2027, 'end_year' => 2025], ['start_quarter' => 9], ['profile' => '1 OR 1=1'], ['region' => 'unknown']] as $input) {
    try { mon_filters($input, $options); throw new RuntimeException('Invalid filter accepted'); }
    catch (InvalidArgumentException $expected) {}
}
$all = mon_dashboard($conn, []);
$perBranch = mon_dashboard($conn, ['priority_scope'=>'cabang']);
mon_test(!empty($perBranch['priorities']), 'Branch priorities missing');
foreach ($perBranch['priorities'] as $priority) {
    mon_test(str_starts_with($priority['scope'], 'cabang_') && count($priority['branches']) === 1 && $priority['coverage'] === 1, 'Branch priority includes another office or consolidated profile');
    mon_test($priority['score'] === $priority['branches'][0]['score'], 'Branch score was averaged across offices');
}
$oneBranch = mon_dashboard($conn, ['priority_scope'=>'cabang', 'priority_branch'=>8]);
mon_test(!empty($oneBranch['priorities']), 'Selected branch attention missing');
foreach ($oneBranch['priorities'] as $priority) mon_test($priority['scope'] === 'cabang_8', 'Selected branch mixed with another office');
mon_test($oneBranch['summary']['score'] === $all['summary']['score'] && $oneBranch['timeline'] === $all['timeline'], 'Priority branch filter changed bank summary charts');
$branchContext = mon_ai_context($oneBranch);
mon_test($branchContext['cakupan_parameter']['id_cabang'] === 8 && $branchContext['cakupan_parameter']['tampilan'] === 'cabang', 'AI context lost selected branch scope');
foreach ($branchContext['parameter_prioritas'] as $priority) mon_test($priority['cakupan'] === $oneBranch['priorities'][0]['scopeLabel'], 'AI parameter evidence includes another branch');
foreach ([['priority_scope'=>'invalid'], ['priority_branch'=>999], ['priority_branch'=>[]]] as $invalid) {
    try {mon_filters($invalid, $options); throw new RuntimeException('Invalid branch scope accepted');} catch (InvalidArgumentException $expected) {}
}
$withChildren = 0;
foreach ($all['priorities'] as $priority) {
    $contribution = 0.0;
    foreach ($priority['branches'] as $branch) {
        mon_test($branch['source']['table'] !== '' && $branch['source']['field'] !== '', 'Source lineage missing');
        mon_test($branch['breakdown'] !== [], 'Selected parameter missing from hierarchy');
        if ($branch['previous'] !== null) {
            mon_test($branch['previousReport'] !== null && $branch['previousPeriod'] !== null, 'Comparison report lineage missing');
            mon_test(abs($branch['contribution'] - ($branch['score'] - $branch['previous']) / $priority['pairedCount']) < 0.000001, 'Wrong branch contribution');
            $contribution += $branch['contribution'];
        } else mon_test($branch['contribution'] === null, 'Missing comparator became zero contribution');
        foreach ($branch['breakdown'] as $item) {
            if ($item['level'] === 'sub_parameter') $withChildren++;
            mon_test($item['delta'] === ($item['previous'] === null ? null : round($item['score'] - $item['previous'], 3)), 'Subparameter change differs from source scores');
        }
    }
    if ($priority['delta'] !== null) mon_test(abs($contribution - $priority['delta']) < 0.002, 'Contributions do not reconcile to matched mean change');
}
mon_test($withChildren > 0, 'No subparameter hierarchy exposed');
$detailContext = mon_parameter_ai_context($all, $all['priorities'][0]['key']);
mon_test($detailContext['mode'] === 'bedah_parameter' && str_contains($detailContext['skala_skor_risiko'], 'BUKAN bukti kondisi baik') && !empty($detailContext['sumber_dan_subparameter'][0]['source']), 'Gemini detail lost quantitative evidence');
try { mon_parameter_ai_context($all, 'invalid'); throw new RuntimeException('Forged priority accepted'); }
catch (InvalidArgumentException $expected) {}
$crossYear = mon_dashboard($conn, ['start_year' => 2025, 'start_quarter' => 4, 'end_year' => 2026, 'end_quarter' => 2]);
mon_test(count($crossYear['timeline']) === 3 && $crossYear['timeline'][0]['period'] === 'TW 4 · 2025' && $crossYear['timeline'][2]['period'] === 'TW 2 · 2026', 'Cross-year range does not follow quarter order');
mon_test(count($all['regions']) === 4, 'Four regions missing');
mon_test(count($all['timeline']) === $all['filters']['end'] - $all['filters']['start'] + 1, 'Quarter range has missing points');
mon_test(array_sum(array_column($all['regions'], 'reports')) === $all['summary']['branchReports'], 'Duplicate branch reports changed regional counts');
foreach ($all['priorities'] as $p) {
    mon_test($p['name'] !== '' && $p['score'] >= 1 && $p['score'] <= 5, 'Unnamed or invalid priority');
    $paired = array_values(array_filter($p['branches'], fn($b) => $b['previous'] !== null));
    $expectedDelta = $paired ? round(mon_mean(array_column($paired, 'score')) - mon_mean(array_column($paired, 'previous')), 3) : null;
    mon_test($p['delta'] === $expectedDelta, 'Priority delta used different branch samples');
}
$solo = mon_dashboard($conn, ['region' => 'solo']);
mon_test(count($solo['regions']) === 1 && $solo['regions'][0]['key'] === 'solo', 'Region filter ignored');
if ($all['filters']['profile'] !== 3) mon_test($all['summary']['score'] === $solo['summary']['score'], 'Regional filter changed the central profile score');
$branchFocus = mon_dashboard($conn, ['region'=>'solo','branch'=>8]);
mon_test($branchFocus['selection']['mode'] === 'branch' && $branchFocus['summary']['branchReports'] === 1 && $branchFocus['summary']['expectedBranches'] === 1, 'Main branch filter did not restrict coverage to one office');
mon_test($branchFocus['filters']['priority_scope'] === 'cabang' && $branchFocus['filters']['priority_branch'] === 8, 'Main branch filter and attention scope disagree');
foreach ($branchFocus['priorities'] as $p) mon_test($p['scope'] === 'cabang_8', 'Main branch filter leaked central or another branch priorities');
foreach ($branchFocus['risks'] as $card) foreach (['composite','inheren','kpmr'] as $metric) mon_test($card['selectedMetrics'][$metric] === $card['branchMetrics'][$metric], 'Risk card does not follow the selected branch');
foreach ($solo['risks'] as $card) foreach (['composite','inheren','kpmr'] as $metric) mon_test($card['selectedMetrics'][$metric] === $card['branchMetrics'][$metric], 'Risk card does not follow the selected region');
mon_test($solo['selection']['mode'] === 'region', 'Regional selection context missing');
foreach ([['branch'=>999],['branch'=>[]],['region'=>'semarang','branch'=>8]] as $invalid) {
    try {mon_filters($invalid, $options); throw new RuntimeException('Invalid global branch filter accepted');} catch (InvalidArgumentException $expected) {}
}
$empty = mon_dashboard($conn, ['start_year' => 2000, 'end_year' => 2000, 'start_quarter' => 1, 'end_quarter' => 1]);
mon_test($empty['summary']['score'] === null && $empty['priorities'] === [], 'Empty period generated fabricated scores');
$accepted = mon_dashboard($conn, ['receipt' => 'diterima']);
mon_test($accepted['summary']['pending'] === 0, 'Unapproved KC included in accepted filter');
if ($all['filters']['profile'] !== 3) mon_test($accepted['summary']['score'] === $all['summary']['score'], 'KC approval filter removed central reports');
$context = mon_ai_context($all);
foreach ($context['parameter_prioritas'] as $p) mon_test(!isset($p['branches'], $p['report']), 'Individual report details leaked into AI context');
mon_test(mon_test_snapshot($conn) === $before, 'Monitoring mutated reports, scores or approvals');
echo 'PASS monitoring data: range validation, score integrity, regional filtering, matched-sample changes, empty states and read-only behavior', PHP_EOL;
echo 'Dataset: ', count($all['timeline']), ' quarters, ', $all['summary']['branchReports'], ' branch reports, ', count($all['priorities']), ' attention groups', PHP_EOL;
