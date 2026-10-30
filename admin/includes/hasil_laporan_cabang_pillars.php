<?php
/** Dynamic pillar projection from the active parameter checklist; SELECT queries only. */
function hasil_kc_query_rows(mysqli $db, string $sql): array
{
    return mysqli_fetch_all(mysqli_query($db, $sql), MYSQLI_ASSOC);
}
function hasil_kc_selected_pillars(mysqli $db, int $year): array
{
    $header = hasil_kc_query_rows($db, "SELECT pp.* FROM pr_pilih_parameter pp JOIN pr_inheren_periode pi ON pi.id=pp.pr_inheren_periode_id WHERE pi.tahun='$year' AND pp.id_user_profil_risiko=3 ORDER BY pp.id DESC LIMIT 1")[0] ?? null;
    if (!$header) return [];
    $period = (int)$header['pr_inheren_periode_id'];
    $checked = [];
    foreach (hasil_kc_query_rows($db, 'SELECT ref_tipe,ref_id FROM pr_pilih_parameter_detail WHERE pr_pilih_parameter_id=' . (int)$header['id']) as $row) $checked[$row['ref_tipe'] . '|' . $row['ref_id']] = true;
    $groups = [];
    $rows = hasil_kc_query_rows($db, "SELECT jr.nama_risiko,jr.id risk_id,p.id pillar_id,p.nama_pilar,p.urutan,pm.id parameter_id,sp.id sub_id FROM pr_jenis_risiko jr JOIN pr_pilar p ON p.jenis_risiko_id=jr.id AND p.pr_inheren_periode_id=$period JOIN pr_parameter pm ON pm.pilar_id=p.id AND pm.pr_inheren_periode_id=$period LEFT JOIN pr_sub_parameter sp ON sp.parameter_id=pm.id AND sp.pr_inheren_periode_id=$period WHERE jr.pr_inheren_periode_id=$period ORDER BY jr.urutan,p.urutan,p.id,pm.urutan,sp.urutan");
    foreach ($rows as $row) {
        $risk = strtolower(trim(preg_replace('/^RISIKO\s+/i', '', $row['nama_risiko'])));
        if (!in_array($risk, ['operasional','kepatuhan','reputasi','stratejik'], true)) continue;
        $parameter = (int)$row['parameter_id']; $sub = (int)$row['sub_id']; $pillar = (int)$row['pillar_id'];
        $showSub = $sub > 0 && isset($checked['sub_parameter|' . $sub]);
        if (!isset($checked['parameter|' . $parameter]) && !$showSub) continue;
        if (!isset($groups[$risk][$pillar])) $groups[$risk][$pillar] = ['id'=>$pillar, 'name'=>$row['nama_pilar'], 'order'=>(int)$row['urutan'], 'risk_id'=>(int)$row['risk_id'], 'parameters'=>[]];
        if (!isset($groups[$risk][$pillar]['parameters'][$parameter])) $groups[$risk][$pillar]['parameters'][$parameter] = ['subs'=>[]];
        if ($showSub) $groups[$risk][$pillar]['parameters'][$parameter]['subs'][$sub] = $sub;
    }
    return $groups;
}
function hasil_kc_normalize_pillar(string $name): string
{
    return preg_replace('/^PILAR\s*[0-9]+\s*[:|\-]?\s*/', '', preg_replace('/\s+/', ' ', strtoupper(trim($name))));
}
function hasil_kc_calculate_pillar(array $pillar, array $detail, ?array $formula, bool $weighted, float $fallbackWeight): array
{
    $scores = []; $missing = 0;
    foreach ($pillar['parameters'] as $id => $parameter) {
        $keys = $parameter['subs'] ? array_map(fn($sub) => 'sub_parameter|' . $sub, array_values($parameter['subs'])) : ['parameter|' . $id];
        $items = [];
        foreach ($keys as $key) {
            $value = $detail[$key]['nilai'] ?? null;
            if (!hasil_kc_valid_score($value)) $missing++;
            else $items[] = (float)$value;
        }
        if (count($items) === count($keys)) $scores[] = round(array_sum($items) / count($items), 2);
    }
    $method = $weighted ? 'Pembobotan' : match ((int)($formula['perskalaan_metode'] ?? 3)) {1=>'Tertinggi', 2=>'Terendah', default=>'Rata-rata'};
    if ($missing || !$scores) return ['value'=>null, 'method'=>$method, 'missing'=>$missing, 'parameters'=>count($pillar['parameters'])];
    $average = round(array_sum($scores) / count($scores), 2);
    if ($weighted) {
        $weight = (float)($formula['pembobotan'] ?? 0);
        if ($weight <= 0) $weight = $fallbackWeight;
        $value = round($average * $weight / 100, 2);
        $method .= ' ' . $weight . '%';
    } else $value = match ($method) {'Tertinggi'=>max($scores), 'Terendah'=>min($scores), default=>$average};
    return ['value'=>$value, 'method'=>$method, 'missing'=>0, 'parameters'=>count($pillar['parameters'])];
}
function hasil_kc_dynamic_pillars(mysqli $db, array $frames, int $year): array
{
    $definitions = hasil_kc_selected_pillars($db, $year);
    $result = ['definitions'=>$definitions, 'values'=>[]];
    if (!$frames || !$definitions) return $result;
    $ids = implode(',', array_map('intval', array_column($frames, 'id_profil_risiko')));
    $headers = []; $assessmentIds = [];
    foreach (hasil_kc_query_rows($db, "SELECT * FROM assessment_inheren WHERE id_profil_risiko IN ($ids) ORDER BY id_assessment_inheren DESC") as $row) {
        $risk = strtolower(trim(preg_replace('/^RISIKO\s+/i', '', $row['jenis_risiko'])));
        $key = $row['id_profil_risiko'] . '|' . $risk;
        if (isset($headers[$key])) continue;
        $headers[$key] = $row; $assessmentIds[] = (int)$row['id_assessment_inheren'];
    }
    $details = [];
    if ($assessmentIds) foreach (hasil_kc_query_rows($db, 'SELECT id_assessment_inheren,ref_tipe,ref_id,nilai FROM assessment_inheren_detail WHERE id_assessment_inheren IN (' . implode(',', $assessmentIds) . ') ORDER BY id_detail DESC') as $row) {
        $key = $row['ref_tipe'] . '|' . $row['ref_id']; $assessment = (int)$row['id_assessment_inheren'];
        if (!isset($details[$assessment][$key])) $details[$assessment][$key] = $row;
    }
    $formulaFrames = hasil_kc_query_rows($db, "SELECT * FROM frame_perumusan WHERE tahun='$year' AND user_id=3 AND UPPER(COALESCE(triwulan,'')) IN ('CABANG','') ORDER BY is_aktif DESC,id_frame_perumusan DESC");
    $defaultFrame = $formulaFrames[0] ?? null;
    $validFormulaFrames = [];
    foreach (hasil_kc_query_rows($db, "SELECT id_frame_perumusan FROM frame_perumusan WHERE tahun='$year'") as $formulaFrameRow) $validFormulaFrames[(int)$formulaFrameRow['id_frame_perumusan']] = true;
    $formulaMap = [];
    foreach (hasil_kc_query_rows($db, "SELECT r.*,p.id_pilar,p.nama_pilar,p.perskalaan_metode,p.pembobotan pillar_weight FROM perumusan_inheren r LEFT JOIN perumusan_inheren_pilar p ON p.id_perumusan_inheren=r.id_perumusan_inheren ORDER BY r.id_perumusan_inheren DESC,p.id_detail DESC") as $row) {
        $risk = strtolower(trim(preg_replace('/^RISIKO\s+/i', '', $row['nama_risiko'])));
        $frameId = (int)$row['id_frame_perumusan'];
        if (!isset($formulaMap[$frameId][$risk])) $formulaMap[$frameId][$risk] = ['weighted'=>(int)$row['pembobotan'] === 1, 'id'=>(int)$row['id_perumusan_inheren'], 'by_id'=>[], 'by_name'=>[]];
        if ($formulaMap[$frameId][$risk]['id'] !== (int)$row['id_perumusan_inheren']) continue;
        if ($row['id_pilar'] === null) continue;
        $formula = ['perskalaan_metode'=>$row['perskalaan_metode'], 'pembobotan'=>$row['pillar_weight']];
        $id = (int)$row['id_pilar']; $name = hasil_kc_normalize_pillar($row['nama_pilar']);
        if (!isset($formulaMap[$frameId][$risk]['by_id'][$id])) $formulaMap[$frameId][$risk]['by_id'][$id] = $formula;
        if (!isset($formulaMap[$frameId][$risk]['by_name'][$name])) $formulaMap[$frameId][$risk]['by_name'][$name] = $formula;
    }
    foreach (hasil_kc_query_rows($db, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko IN ($ids)") as $frame) {
        $reportId = (int)$frame['id_profil_risiko'];
        $directFrame = (int)($frame['id_frame_perumusan'] ?? 0);
        $formulaFrame = isset($validFormulaFrames[$directFrame]) ? $directFrame : (int)($defaultFrame['id_frame_perumusan'] ?? 0);
        foreach ($definitions as $risk => $pillars) {
            $header = $headers[$reportId . '|' . $risk] ?? [];
            $detail = $details[(int)($header['id_assessment_inheren'] ?? 0)] ?? [];
            $riskFormula = $formulaMap[$formulaFrame][$risk] ?? [];
            $count = count($pillars); $index = 0; $base = floor(100 / $count * 10000) / 10000;
            foreach ($pillars as $id => $pillar) {
                $formula = $riskFormula['by_id'][$id] ?? $riskFormula['by_name'][hasil_kc_normalize_pillar($pillar['name'])] ?? null;
                $fallback = ++$index === $count ? round(100 - $base * ($count - 1), 4) : $base;
                $result['values'][$reportId][$risk][$id] = hasil_kc_calculate_pillar($pillar, $detail, $formula, (bool)($riskFormula['weighted'] ?? false), $fallback);
            }
        }
    }
    return $result;
}
