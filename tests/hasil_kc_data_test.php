<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__ . '/../conn/conn.php';
require __DIR__ . '/../admin/includes/hasil_laporan_cabang_data.php';
require __DIR__ . '/../admin/includes/hasil_laporan_cabang_pillars.php';
function kc_assert($condition, string $message): void {if (!$condition) throw new RuntimeException($message);}
foreach ([[1,'blue'],[1.25,'blue'],[1.26,'green'],[2.25,'green'],[2.26,'yellow'],[3.25,'yellow'],[3.26,'orange'],[4.25,'orange'],[4.26,'red'],[5,'red']] as [$score,$color]) {
    kc_assert(hasil_kc_pillar_band($score)[0] === $color, 'Incorrect pillar boundary: ' . $score);
}
foreach ([null, '', 0, 0.43, 5.01, 'invalid'] as $missing) kc_assert(hasil_kc_pillar_band($missing) === null, 'Invalid or missing pillar received risk color');
foreach ([[1,'blue'],[1.25,'green'],[2.25,'yellow'],[3.25,'orange'],[4.25,'red'],[5,'red']] as [$score,$color]) kc_assert(str_contains(hasil_kc_composite_attributes($score), 'hasil-pillar-' . $color), 'Composite boundary color differs from composite ranking');
kc_assert(!str_contains(hasil_kc_composite_attributes(null), 'hasil-pillar-cell'), 'Missing composite received risk color');
$pillarFixture = ['parameters'=>[10=>['subs'=>[1,2]],20=>['subs'=>[]]]];
$detailFixture = ['sub_parameter|1'=>['nilai'=>1], 'sub_parameter|2'=>['nilai'=>5], 'parameter|20'=>['nilai'=>5], 'parameter|999'=>['nilai'=>1]];
foreach ([[1,5],[2,3],[3,4]] as [$method,$expected]) {
    kc_assert(hasil_kc_calculate_pillar($pillarFixture, $detailFixture, ['perskalaan_metode'=>$method], false, 0)['value'] == $expected, 'Hierarchy or configured scale method is incorrect');
}
kc_assert(hasil_kc_calculate_pillar($pillarFixture, $detailFixture, ['pembobotan'=>25], true, 50)['value'] === 1.0, 'Configured pillar weight ignored');
kc_assert(hasil_kc_calculate_pillar($pillarFixture, $detailFixture, null, true, 50)['value'] === 2.0, 'Fallback equal pillar weights differ from inherent form');
$incompleteFixture = $detailFixture; unset($incompleteFixture['sub_parameter|2']);
kc_assert(hasil_kc_calculate_pillar($pillarFixture, $incompleteFixture, null, false, 0)['value'] === null, 'Incomplete selected subparameter became a zero or partial rating');
$dynamicSnapshot = fn() => hasil_kc_query_rows($conn, 'SELECT COUNT(*) n,SUM(COALESCE(nilai,0)) total FROM assessment_inheren_detail')[0];
$dynamicBefore = $dynamicSnapshot();
$projection = hasil_kc_dynamic_pillars($conn, [1=>['id_profil_risiko'=>545]], 2026);
$dynamicCount = 0;
foreach (['operasional','kepatuhan','reputasi','stratejik'] as $risk) {
    kc_assert(!empty($projection['definitions'][$risk]), 'Selected risk pillars missing: ' . $risk);
    foreach ($projection['definitions'][$risk] as $id => $definition) {
        kc_assert($definition['parameters'] !== [] && $definition['name'] !== '', 'Unselected or unnamed pillar shown');
        $cell = $projection['values'][545][$risk][$id];
        kc_assert($cell['value'] !== null && $cell['missing'] === 0, 'Completed assessment did not produce pillar: ' . $risk . '/' . $id);
        $dynamicCount++;
    }
}
kc_assert($dynamicCount === 16, 'KC 2026 checklist differs from expected selected pillar fixture');
kc_assert(hasil_kc_dynamic_pillars($conn, [], 1900)['definitions'] === [], 'Another year checklist leaked into an unconfigured year');
kc_assert($dynamicBefore === $dynamicSnapshot(), 'Pillar projection wrote to assessment inputs');
$regionFixture = hasil_kc_regions([8=>[],9=>[],10=>[],22=>[]], [8=>['kredit'=>['hasil_tingkat_risiko'=>4]],9=>['kredit'=>['hasil_tingkat_risiko'=>2]],10=>['kredit'=>['hasil_tingkat_risiko'=>0]]]);
kc_assert($regionFixture['solo']['values']['kredit'] === 3.0 && $regionFixture['solo']['counts']['kredit'] === 2, 'Regional average divided by seven or counted missing values as zero');
kc_assert($regionFixture['semarang']['values']['kredit'] === null && $regionFixture['pekalongan']['values']['kredit'] === null, 'Empty region fabricated a zero risk value');
$before = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) n,SUM(COALESCE(status_korwil,0)) korwil,SUM(COALESCE(status_skmr,0)) skmr FROM frame_laporan_profil_risiko'));
$filled = 0;
foreach ([1,2] as $quarter) {
    $frames = [];
    $result = mysqli_query($conn, 'SELECT id_profil_risiko,kantor_cabang FROM frame_laporan_profil_risiko WHERE user=3 AND tahun=2026 AND periode=' . $quarter . ' ORDER BY id_profil_risiko DESC');
    while ($row = mysqli_fetch_assoc($result)) if (!isset($frames[$row['kantor_cabang']])) $frames[$row['kantor_cabang']] = $row;
    $data = hasil_kc_load_results($conn, $frames);
    foreach ($frames as $branch => $frame) {
        foreach (['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'] as $risk) {
            $id = (int)$frame['id_profil_risiko'];
            $old = hasil_kc_latest_rows($conn, 'hasil_inheren_' . $risk, [$id])[$id] ?? [];
            $profile = hasil_kc_latest_rows($conn, 'keterangan_profil_' . $risk, [$id])[$id] ?? [];
            $safeRisk = mysqli_real_escape_string($conn, 'RISIKO ' . strtoupper($risk));
            $assessment = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM assessment_inheren WHERE id_profil_risiko=$id AND jenis_risiko='$safeRisk' ORDER BY id_assessment_inheren DESC LIMIT 1"));
            $expected = hasil_kc_valid_score($old['hasil_tingkat_risiko'] ?? null) ? $old['hasil_tingkat_risiko']
                : (hasil_kc_valid_score($profile['inheren_' . $risk] ?? null) ? $profile['inheren_' . $risk]
                : (hasil_kc_valid_score($assessment['tingkat_risiko'] ?? null) ? $assessment['tingkat_risiko'] : null));
            kc_assert(($data[$branch][$risk]['hasil_tingkat_risiko'] ?? null) === $expected, "Wrong source or report: $quarter/$branch/$risk");
            if (!hasil_kc_valid_score($old['hasil_tingkat_risiko'] ?? null) && $expected !== null) $filled++;
            foreach ($old as $key => $value) if (preg_match('/^pil[0-9]+_tingkat_risiko$/', $key)) kc_assert(($data[$branch][$risk][$key] ?? null) === $value, 'Stored pillar changed');
        }
    }
}
kc_assert($filled > 0, 'No real legacy-to-new assessment coverage verified');
kc_assert(hasil_kc_load_results($conn, []) === [], 'Empty filter fabricated results');
kc_assert(!hasil_kc_valid_score(0) && !hasil_kc_valid_score(null), 'Missing score treated as low risk');
$after = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) n,SUM(COALESCE(status_korwil,0)) korwil,SUM(COALESCE(status_skmr,0)) skmr FROM frame_laporan_profil_risiko'));
kc_assert($before === $after, 'Read-only results changed reports');
echo "PASS branch results: source precedence, same-report matching, stored pillars, empty states; $filled previously missing risk values restored.\n";
