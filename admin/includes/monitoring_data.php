<?php
// Read-only monitoring: never initializes or recalculates a report.
function mon_rows(mysqli $db, string $sql): array
{
    return mysqli_query($db, $sql)->fetch_all(MYSQLI_ASSOC);
}
function mon_score($value): ?float
{
    return is_numeric($value) && (float)$value >= 1 && (float)$value <= 5 ? (float)$value : null;
}
function mon_mean(array $values): ?float
{
    $values = array_values(array_filter($values, fn($v) => $v !== null));
    return $values ? round(array_sum($values) / count($values), 3) : null;
}
function mon_period(int $ordinal): string
{
    return 'TW ' . ($ordinal % 4 + 1) . ' · ' . intdiv($ordinal, 4);
}
function mon_region(int $office): string
{
    return $office >= 1 && $office <= 28 ? ['semarang', 'solo', 'banyumas', 'pekalongan'][intdiv($office - 1, 7)] : 'pusat';
}
function mon_risks(): array
{
    return ['kredit' => 'Kredit', 'operasional' => 'Operasional', 'kepatuhan' => 'Kepatuhan',
        'likuiditas' => 'Likuiditas', 'reputasi' => 'Reputasi', 'stratejik' => 'Stratejik'];
}
function mon_options(mysqli $db): array
{
    $profiles = mon_rows($db, 'SELECT p.id_user_profil_risiko id,p.tipe_user name,COUNT(f.id_profil_risiko) reports
        FROM user_profil_risiko p LEFT JOIN frame_laporan_profil_risiko f ON f.user=p.id_user_profil_risiko
        GROUP BY p.id_user_profil_risiko,p.tipe_user ORDER BY p.id_user_profil_risiko');
    $years = array_map('intval', array_column(mon_rows($db, 'SELECT DISTINCT tahun FROM frame_laporan_profil_risiko WHERE tahun BETWEEN 2000 AND 2100 ORDER BY tahun DESC'), 'tahun'));
    $profile = 4;
    $available = array_values(array_filter($profiles, fn($p) => (int)$p['reports'] > 0));
    if (!array_filter($available, fn($p) => (int)$p['id'] === 4)) $profile = (int)($available[0]['id'] ?? 1);
    $latest = mon_rows($db, 'SELECT tahun,periode FROM frame_laporan_profil_risiko WHERE user=' . $profile . ' ORDER BY tahun DESC,periode DESC LIMIT 1')[0] ?? [];
    $year = (int)($latest['tahun'] ?? date('Y'));
    return ['profiles' => $profiles, 'years' => $years ?: [$year], 'risks' => mon_risks(),
        'branches' => mon_rows($db, 'SELECT id_cabang id,cabang name FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 28 ORDER BY id_cabang'),
        'regions' => ['semarang' => 'Semarang', 'solo' => 'Solo', 'banyumas' => 'Banyumas', 'pekalongan' => 'Pekalongan'],
        'defaults' => ['profile' => $profile, 'start_year' => $year, 'start_quarter' => 1,
            'end_year' => $year, 'end_quarter' => (int)($latest['periode'] ?? 4), 'region' => 'semua', 'receipt' => 'semua', 'priority_scope' => 'wilayah', 'priority_branch' => 0, 'branch' => 0]];
}
function mon_filters(array $input, array $options): array
{
    $f = $options['defaults'];
    foreach (['profile', 'start_year', 'start_quarter', 'end_year', 'end_quarter', 'priority_branch', 'branch'] as $key) {
        if (isset($input[$key])) {
            if (!is_scalar($input[$key]) || !preg_match('/^\d+$/', (string)$input[$key])) throw new InvalidArgumentException('Filter angka tidak valid.');
            $f[$key] = (int)$input[$key];
        }
    }
    foreach (['region', 'receipt', 'priority_scope'] as $key) if (isset($input[$key])) $f[$key] = is_string($input[$key]) ? $input[$key] : '';
    if (!in_array($f['profile'], array_map('intval', array_column($options['profiles'], 'id')), true)
        || !in_array($f['region'], array_merge(['semua'], array_keys($options['regions'])), true)
        || !in_array($f['receipt'], ['semua', 'diterima'], true)
        || !in_array($f['priority_scope'], ['wilayah', 'cabang'], true)
        || !in_array($f['priority_branch'], array_merge([0], array_map('intval', array_column($options['branches'], 'id'))), true)
        || !in_array($f['branch'], array_merge([0], array_map('intval', array_column($options['branches'], 'id'))), true)) throw new InvalidArgumentException('Pilihan filter tidak dikenal.');
    if ($f['branch'] && $f['region'] !== 'semua' && mon_region($f['branch']) !== $f['region']) throw new InvalidArgumentException('Cabang tidak termasuk wilayah terpilih.');
    if ($f['branch']) { $f['priority_scope'] = 'cabang'; $f['priority_branch'] = $f['branch']; }
    if ($f['priority_scope'] === 'wilayah') $f['priority_branch'] = 0;
    foreach (['start', 'end'] as $side) {
        if ($f[$side . '_year'] < 2000 || $f[$side . '_year'] > 2100 || $f[$side . '_quarter'] < 1 || $f[$side . '_quarter'] > 4) throw new InvalidArgumentException('Tahun atau triwulan tidak valid.');
    }
    $f['start'] = $f['start_year'] * 4 + $f['start_quarter'] - 1;
    $f['end'] = $f['end_year'] * 4 + $f['end_quarter'] - 1;
    if ($f['start'] > $f['end']) throw new InvalidArgumentException('Periode awal harus sebelum atau sama dengan periode akhir.');
    if ($f['end'] - $f['start'] > 39) throw new InvalidArgumentException('Pilih rentang maksimal 10 tahun.');
    return $f;
}
function mon_table(mysqli $db, string $table): bool
{
    static $cache = [];
    if (!array_key_exists($table, $cache)) $cache[$table] = (bool)mon_rows($db, "SHOW TABLES LIKE '" . mysqli_real_escape_string($db, $table) . "'");
    return $cache[$table];
}
function mon_report_values(mysqli $db, array $frames): array
{
    if (!$frames) return [];
    $ids = implode(',', array_map('intval', array_keys($frames)));
    $values = []; $seenTotal = [];
    foreach ($frames as $id => $frame) $values[$id] = ['score' => null, 'risks' => [], 'parameters' => [], 'unmapped' => 0];
    foreach (mon_rows($db, "SELECT id_profil_risiko,total_nilai FROM nilai_profil WHERE id_profil_risiko IN ($ids) ORDER BY id_nilai_profil DESC") as $row) {
        $id = (int)$row['id_profil_risiko'];
        if (!isset($seenTotal[$id])) { $values[$id]['score'] = mon_score($row['total_nilai']); $seenTotal[$id] = true; }
    }
    foreach (mon_risks() as $risk => $label) {
        $table = 'keterangan_profil_' . $risk;
        if (!mon_table($db, $table)) continue;
        $seen = [];
        foreach (mon_rows($db, "SELECT * FROM `$table` WHERE id_profil_risiko IN ($ids) ORDER BY 1 DESC") as $row) {
            $id = (int)$row['id_profil_risiko'];
            if (isset($seen[$id])) continue;
            $seen[$id] = true;
            $values[$id]['risks'][$risk] = ['inheren' => mon_score($row['inheren_' . $risk] ?? null),
                'kpmr' => mon_score($row['kpmr_' . $risk] ?? null), 'composite' => mon_score($row['tingkat_risiko'] ?? null)];
        }
        foreach (['inheren', 'kpmr'] as $kind) {
            $resultTable = 'hasil_' . $kind . '_' . $risk;
            if (!mon_table($db, $resultTable)) continue;
            $seen = [];
            foreach (mon_rows($db, "SELECT id_profil_risiko,hasil_tingkat_risiko FROM `$resultTable` WHERE id_profil_risiko IN ($ids) ORDER BY 1 DESC") as $row) {
                $id = (int)$row['id_profil_risiko'];
                if (isset($seen[$id])) continue;
                $seen[$id] = true;
                if (($values[$id]['risks'][$risk][$kind] ?? null) === null) $values[$id]['risks'][$risk][$kind] = mon_score($row['hasil_tingkat_risiko']);
            }
        }
    }
    $labels = json_decode(file_get_contents(__DIR__ . '/monitoring_parameter_labels.json'), true);
    foreach (['kredit' => ['pilar1', 'pilar2', 'pilar3', 'pilar4', 'lainnya'], 'likuiditas' => ['pilar1', 'pilar2', 'lainnya']] as $risk => $parts) {
        foreach ($parts as $part) {
            $table = 'inheren_' . $risk . '_' . $part;
            if (!mon_table($db, $table)) continue;
            $seen = [];
            foreach (mon_rows($db, "SELECT * FROM `$table` WHERE id_profil_risiko IN ($ids) ORDER BY 1 DESC") as $row) {
                $id = (int)$row['id_profil_risiko'];
                if (isset($seen[$id])) continue;
                $seen[$id] = true;
                $layout = (int)$frames[$id]['type'] === 3 ? 'kc' : 'pusat';
                foreach ($row as $field => $raw) {
                    if (!isset($labels[$layout][$risk][$field]) || mon_score($raw) === null) continue;
                    $key = $risk . '|inheren|' . $part . '|' . $field;
                    $values[$id]['parameters'][$key] = ['key' => $key, 'risk' => $risk, 'kind' => 'Inheren',
                        'name' => $labels[$layout][$risk][$field], 'pillar' => $part === 'lainnya' ? 'Faktor lainnya' : ucfirst(str_replace('pilar', 'Pilar ', $part)), 'value' => mon_score($raw),
                        'parent' => preg_match('/^(hasil_pil\d+_par\d+)[a-z]+$/', $field, $match) ? ($labels[$layout][$risk][$match[1]] ?? $match[1]) : $labels[$layout][$risk][$field],
                        'level' => preg_match('/_par\d+[a-z]+$/', $field) ? 'sub_parameter' : 'parameter',
                        'source' => ['table' => $table, 'field' => $field, 'row' => (int)$row[array_key_first($row)]]];
                }
            }
        }
    }
    foreach (['inheren' => 'pr', 'kpmr' => 'kpmr'] as $kind => $prefix) {
        $header = 'assessment_' . $kind;
        $detail = $header . '_detail';
        if (!mon_table($db, $header) || !mon_table($db, $detail)) continue;
        $assessmentId = 'id_assessment_' . $kind;
        foreach (mon_rows($db, "SELECT a.* FROM `$header` a INNER JOIN
            (SELECT MAX($assessmentId) id FROM `$header` WHERE id_profil_risiko IN ($ids) GROUP BY id_profil_risiko,jenis_risiko) newest ON newest.id=a.$assessmentId") as $assessment) {
            $risk = strtolower(trim(str_replace('RISIKO ', '', strtoupper($assessment['jenis_risiko']))));
            $id = (int)$assessment['id_profil_risiko'];
            if (isset(mon_risks()[$risk]) && ($values[$id]['risks'][$risk][$kind] ?? null) === null) {
                $values[$id]['risks'][$risk][$kind] = mon_score($assessment['tingkat_risiko'] ?? null);
            }
        }
        $sql = "SELECT a.id_profil_risiko,a.jenis_risiko,d.ref_tipe,d.ref_id,d.nilai,d.id_detail,
                p.nama_parameter,s.nama_sub_parameter,pil.nama_pilar
            FROM `$header` a
            INNER JOIN (SELECT MAX($assessmentId) id FROM `$header` WHERE id_profil_risiko IN ($ids) GROUP BY id_profil_risiko,jenis_risiko) newest ON newest.id=a.$assessmentId
            INNER JOIN `$detail` d ON d.$assessmentId=a.$assessmentId
            LEFT JOIN {$prefix}_sub_parameter s ON s.id=CASE WHEN d.ref_tipe='sub_parameter' THEN d.ref_id ELSE d.sub_parameter_id END
            LEFT JOIN {$prefix}_parameter p ON p.id=CASE WHEN d.ref_tipe='parameter' THEN d.ref_id ELSE s.parameter_id END
            LEFT JOIN {$prefix}_pilar pil ON pil.id=p.pilar_id
            ORDER BY d.id_detail DESC";
        $seen = [];
        foreach (mon_rows($db, $sql) as $row) {
            $id = (int)$row['id_profil_risiko'];
            $risk = strtolower(trim(str_replace('RISIKO ', '', strtoupper($row['jenis_risiko']))));
            if (!isset(mon_risks()[$risk]) || mon_score($row['nilai']) === null) continue;
            $name = trim((string)($row['ref_tipe'] === 'sub_parameter' ? $row['nama_sub_parameter'] : $row['nama_parameter']));
            if ($name === '') { $values[$id]['unmapped']++; continue; }
            $identity = mb_strtolower(preg_replace('/\s+/u', ' ', $risk . '|' . $kind . '|' . $row['nama_pilar'] . '|' . $row['nama_parameter'] . '|' . $row['nama_sub_parameter']));
            $key = hash('sha256', $identity);
            if (isset($seen[$id . $key])) continue;
            $seen[$id . $key] = true;
            $values[$id]['parameters'][$key] = ['key' => $key, 'risk' => $risk, 'kind' => $kind === 'kpmr' ? 'KPMR' : 'Inheren',
                'name' => $name, 'pillar' => $row['nama_pilar'] ?? '', 'value' => mon_score($row['nilai']),
                'parent' => $row['nama_parameter'], 'level' => $row['ref_tipe'],
                'source' => ['table' => $detail, 'field' => 'nilai', 'row' => (int)$row['id_detail'], 'reference' => (int)$row['ref_id']]];
        }
    }
    return $values;
}
/** Compare siblings within the same risk, pillar and parent; never infer aggregation weights. */
function mon_parameter_breakdown(array $selected, array $current, array $previous): array
{
    $result = [];
    foreach ($current as $key => $item) {
        if ($item['risk'] !== $selected['risk'] || $item['kind'] !== $selected['kind'] || $item['pillar'] !== $selected['pillar'] || $item['parent'] !== $selected['parent']) continue;
        $old = $previous[$key] ?? null;
        $result[] = ['name' => $item['name'], 'level' => $item['level'], 'selected' => $key === $selected['key'],
            'score' => $item['value'], 'previous' => $old['value'] ?? null,
            'delta' => $old ? round($item['value'] - $old['value'], 3) : null,
            'source' => $item['source'], 'previousSource' => $old['source'] ?? null];
    }
    return $result;
}
function mon_metric(array $frames, array $values, ?string $risk = null, string $metric = 'composite'): ?float
{
    $scores = [];
    foreach ($frames as $frame) {
        $v = $values[$frame['id']] ?? [];
        if ($risk !== null) $scores[] = $v['risks'][$risk][$metric] ?? null;
        elseif ($metric === 'composite') $scores[] = $v['score'] ?? null;
        else {
            $components = array_map(fn($r) => $v['risks'][$r][$metric] ?? null, array_keys(mon_risks()));
            $scores[] = count(array_filter($components, fn($s) => $s !== null)) === 6 ? mon_mean($components) : null;
        }
    }
    return mon_mean($scores);
}
function mon_snapshot(array $frames): array
{
    if (!$frames) return [];
    $latest = max(array_column($frames, 'ordinal'));
    return array_values(array_filter($frames, fn($f) => $f['ordinal'] === $latest));
}
function mon_dashboard(mysqli $db, array $input): array
{
    $options = mon_options($db);
    $filters = mon_filters($input, $options);
    $profile = $filters['profile'];
    $focusRegion = $filters['branch'] ? mon_region($filters['branch']) : $filters['region'];
    $selectionMode = $filters['branch'] ? 'branch' : ($filters['region'] !== 'semua' ? 'region' : 'profile');
    $selectionLabel = $filters['branch'] ? array_column($options['branches'], 'name', 'id')[$filters['branch']] : ($filters['region'] !== 'semua' ? $options['regions'][$filters['region']] : 'Profil pilihan');
    $start = $filters['start'] - 1;
    $end = $filters['end'];
    $receiptSql = $filters['receipt'] === 'diterima' ? 'AND (f.user<>3 OR (f.status_korwil=1 AND f.status_skmr=1))' : '';
    $raw = mon_rows($db, "SELECT f.id_profil_risiko,f.user,f.tahun,f.periode,f.kantor_cabang,f.status_korwil,f.status_skmr,c.cabang
        FROM frame_laporan_profil_risiko f LEFT JOIN jenis_cabang c ON c.id_cabang=f.kantor_cabang
        WHERE f.user IN ($profile,3) AND (f.tahun*4+f.periode-1) BETWEEN $start AND $end $receiptSql
        ORDER BY f.id_profil_risiko DESC");
    $frames = []; $seen = [];
    foreach ($raw as $r) {
        $region = mon_region((int)$r['kantor_cabang']);
        if ((int)$r['user'] === 3 && ($region === 'pusat' || ($filters['region'] !== 'semua' && $region !== $filters['region']))) continue;
        if ((int)$r['user'] === 3 && $filters['branch'] && (int)$r['kantor_cabang'] !== $filters['branch']) continue;
        $identity = $r['user'] . '|' . $r['kantor_cabang'] . '|' . $r['tahun'] . '|' . $r['periode'];
        if (isset($seen[$identity])) continue;
        $seen[$identity] = true;
        $id = (int)$r['id_profil_risiko'];
        $frames[$id] = ['id' => $id, 'type' => (int)$r['user'], 'office' => (int)$r['kantor_cabang'],
            'name' => $r['cabang'] ?: 'Kantor pusat', 'region' => $region,
            'ordinal' => (int)$r['tahun'] * 4 + (int)$r['periode'] - 1,
            'received' => (int)$r['status_korwil'] === 1 && (int)$r['status_skmr'] === 1];
    }
    $values = mon_report_values($db, $frames);
    $inRange = array_values(array_filter($frames, fn($f) => $f['ordinal'] >= $filters['start']));
    $primary = array_values(array_filter($inRange, fn($f) => $f['type'] === $profile));
    $branches = array_values(array_filter($inRange, fn($f) => $f['type'] === 3));
    $current = mon_snapshot($primary); $currentBranches = mon_snapshot($branches);
    $primaryPeriod = $current[0]['ordinal'] ?? null;
    $branchPeriod = $currentBranches[0]['ordinal'] ?? null;
    $previous = [];
    foreach (array_merge($current, $currentBranches) as $frame) {
        $earlier = array_filter($frames, fn($f) => $f['type'] === $frame['type'] && $f['office'] === $frame['office'] && $f['ordinal'] < $frame['ordinal']);
        $previous[$frame['id']] = mon_snapshot($earlier)[0] ?? null;
    }
    $timeline = [];
    for ($o = $filters['start']; $o <= $end; $o++) {
        $a = array_values(array_filter($primary, fn($f) => $f['ordinal'] === $o));
        $b = array_values(array_filter($branches, fn($f) => $f['ordinal'] === $o));
        $point = ['period' => mon_period($o), 'primaryCount' => count($a), 'branchCount' => count($b), 'primary' => [], 'branches' => [], 'regions' => [], 'regionCounts' => [], 'primaryValueCounts' => [], 'regionValueCounts' => []];
        foreach (['composite', 'inheren', 'kpmr'] as $metric) {
            $point['primary'][$metric] = mon_metric($a, $values, null, $metric);
            $point['branches'][$metric] = mon_metric($b, $values, null, $metric);
            $point['primaryValueCounts'][$metric] = count(array_filter($a, fn($f) => mon_metric([$f], $values, null, $metric) !== null));
        }
        foreach ($options['regions'] as $key => $name) {
            if ($focusRegion !== 'semua' && $focusRegion !== $key) continue;
            $regional = array_values(array_filter($b, fn($f) => $f['region'] === $key));
            $point['regionCounts'][$key] = count($regional);
            foreach (['composite', 'inheren', 'kpmr'] as $metric) {
                $point['regions'][$key][$metric] = mon_metric($regional, $values, null, $metric);
                $point['regionValueCounts'][$key][$metric] = count(array_filter($regional, fn($f) => mon_metric([$f], $values, null, $metric) !== null));
            }
        }
        $timeline[] = $point;
    }
    $riskCards = [];
    foreach (mon_risks() as $risk => $label) {
        $old = array_values(array_filter(array_map(fn($f) => $previous[$f['id']] ?? null, $current)));
        $now = mon_metric($current, $values, $risk);
        $before = mon_metric($old, $values, $risk);
        $changes = [];
        foreach (['composite', 'inheren', 'kpmr'] as $metric) {
            $pairedCurrent = []; $pairedPrevious = [];
            foreach ($current as $frame) {
                $earlier = $previous[$frame['id']] ?? null;
                $a = $values[$frame['id']]['risks'][$risk][$metric] ?? null;
                $b = $earlier ? ($values[$earlier['id']]['risks'][$risk][$metric] ?? null) : null;
                if ($a !== null && $b !== null) { $pairedCurrent[] = $a; $pairedPrevious[] = $b; }
            }
            $changes[$metric] = $pairedCurrent ? round(mon_mean($pairedCurrent) - mon_mean($pairedPrevious), 3) : null;
        }
        $selectionFrames = $selectionMode === 'profile' ? $current : $currentBranches;
        $selectedMetrics = []; $selectedChanges = [];
        foreach (['composite','inheren','kpmr'] as $metric) {
            $selectedMetrics[$metric] = mon_metric($selectionFrames, $values, $risk, $metric);
            $a = []; $b = [];
            foreach ($selectionFrames as $frame) {
                $oldFrame = $previous[$frame['id']] ?? null;
                $nowScore = $values[$frame['id']]['risks'][$risk][$metric] ?? null;
                $oldScore = $oldFrame ? ($values[$oldFrame['id']]['risks'][$risk][$metric] ?? null) : null;
                if ($nowScore !== null && $oldScore !== null) {$a[]=$nowScore;$b[]=$oldScore;}
            }
            $selectedChanges[$metric] = $a ? round(mon_mean($a)-mon_mean($b),3) : null;
        }
        $riskCards[] = ['selectedMetrics'=>$selectedMetrics, 'selectedChanges'=>$selectedChanges, 'key' => $risk, 'name' => $label, 'score' => $now, 'previous' => $before,
            'delta' => $changes['composite'], 'changes' => $changes,
            'inheren' => mon_metric($current, $values, $risk, 'inheren'), 'kpmr' => mon_metric($current, $values, $risk, 'kpmr'),
            'branches' => mon_metric($currentBranches, $values, $risk),
            'branchMetrics' => ['composite' => mon_metric($currentBranches, $values, $risk),
                'inheren' => mon_metric($currentBranches, $values, $risk, 'inheren'), 'kpmr' => mon_metric($currentBranches, $values, $risk, 'kpmr')]];
    }
    $regions = [];
    foreach ($options['regions'] as $key => $name) {
        if ($focusRegion !== 'semua' && $focusRegion !== $key) continue;
        $regional = array_values(array_filter($currentBranches, fn($f) => $f['region'] === $key));
        $assessed = count(array_filter($regional, fn($f) => count(array_filter($values[$f['id']]['risks'], fn($r) => ($r['inheren'] ?? null) !== null)) === 6));
        $regions[] = ['key' => $key, 'name' => $name, 'reports' => count($regional), 'assessed' => $assessed, 'expected' => $filters['branch'] ? 1 : 7,
            'score' => mon_metric($regional, $values), 'risks' => [
                'composite' => array_map(fn($r) => mon_metric($regional, $values, $r), array_keys(mon_risks())),
                'inheren' => array_map(fn($r) => mon_metric($regional, $values, $r, 'inheren'), array_keys(mon_risks())),
                'kpmr' => array_map(fn($r) => mon_metric($regional, $values, $r, 'kpmr'), array_keys(mon_risks()))]];
    }
    $groups = []; $currentUnique = [];
    foreach (array_merge($current, $currentBranches) as $f) $currentUnique[$f['id']] = $f;
    foreach ($currentUnique as $f) {
        if ($selectionMode !== 'profile' && $f['type'] !== 3) continue;
        if ($filters['priority_scope'] === 'cabang') {
            if ($f['type'] !== 3 || ($filters['priority_branch'] && $f['office'] !== $filters['priority_branch'])) continue;
            $scope = 'cabang_' . $f['office'];
            $scopeLabel = $f['name'];
        } else {
            $scope = $f['type'] === 3 ? $f['region'] : 'profil';
            $scopeLabel = $scope === 'profil' ? 'Profil pilihan' : $options['regions'][$scope];
        }
        foreach ($values[$f['id']]['parameters'] as $parameter) {
            $key = $scope . '|' . $parameter['key'];
            if (!isset($groups[$key])) $groups[$key] = ['key' => hash('sha256', $key), 'name' => $parameter['name'], 'pillar' => $parameter['pillar'],
                'risk' => $parameter['risk'], 'kind' => $parameter['kind'], 'scope' => $scope, 'scopeLabel' => $scopeLabel, 'scores' => [], 'old' => [], 'branches' => []];
            $oldFrame = $previous[$f['id']] ?? null;
            $oldScore = $oldFrame ? ($values[$oldFrame['id']]['parameters'][$parameter['key']]['value'] ?? null) : null;
            $groups[$key]['scores'][] = $parameter['value'];
            if ($oldScore !== null) $groups[$key]['old'][] = $oldScore;
            $groups[$key]['branches'][] = ['name' => $f['name'], 'report' => $f['id'], 'score' => $parameter['value'], 'previous' => $oldScore,
                'period' => mon_period($f['ordinal']), 'received' => $f['received'],
                'previousReport' => $oldFrame['id'] ?? null, 'previousPeriod' => $oldFrame ? mon_period($oldFrame['ordinal']) : null,
                'source' => $parameter['source'], 'parent' => $parameter['parent'], 'level' => $parameter['level'],
                'breakdown' => mon_parameter_breakdown($parameter, $values[$f['id']]['parameters'], $oldFrame ? $values[$oldFrame['id']]['parameters'] : [])];
        }
    }
    $priorities = []; $monitored = count($groups);
    foreach ($groups as $group) {
        $group['score'] = max($group['scores']);
        $group['average'] = mon_mean($group['scores']);
        // Delta compares matched reports only, avoiding changes caused by a different branch sample.
        $paired = array_values(array_filter($group['branches'], fn($b) => $b['previous'] !== null));
        $group['pairedCount'] = count($paired);
        $group['pairedCurrent'] = mon_mean(array_column($paired, 'score'));
        $group['previous'] = mon_mean(array_column($paired, 'previous'));
        $group['delta'] = $paired ? round(mon_mean(array_column($paired, 'score')) - $group['previous'], 3) : null;
        foreach ($group['branches'] as &$branch) {
            $branch['delta'] = $branch['previous'] === null ? null : round($branch['score'] - $branch['previous'], 3);
            $branch['contribution'] = $branch['delta'] === null ? null : round($branch['delta'] / count($paired), 6);
        }
        unset($branch);
        $group['affected'] = count(array_filter($group['scores'], fn($s) => $s >= 3));
        $group['coverage'] = count($group['scores']);
        $group['severity'] = $group['score'] >= 4 ? 'tinggi' : 'perhatian';
        unset($group['scores'], $group['old']);
        if ($group['score'] >= 3 || ($group['delta'] !== null && $group['delta'] >= 0.25)) $priorities[] = $group;
    }
    usort($priorities, fn($a, $b) => ($b['score'] <=> $a['score']) ?: (($b['delta'] ?? 0) <=> ($a['delta'] ?? 0)) ?: ($b['affected'] <=> $a['affected']));
    $received = count(array_filter($currentBranches, fn($f) => $f['received']));
    $complete = count(array_filter($currentBranches, fn($f) => count(array_filter($values[$f['id']]['risks'], fn($r) => ($r['inheren'] ?? null) !== null)) === 6));
    $primaryName = array_values(array_filter($options['profiles'], fn($p) => (int)$p['id'] === $profile))[0]['name'];
    $primaryScored = count(array_filter($current, fn($f) => $values[$f['id']]['score'] !== null));
    $missingLabels = 0;
    foreach ($currentUnique as $f) if (!$values[$f['id']]['parameters']) $missingLabels++;
    $quality = [];
    if (!$current) $quality[] = 'Belum ada laporan untuk jenis profil dan rentang yang dipilih.';
    if ($primaryScored < count($current)) $quality[] = (count($current) - $primaryScored) . ' laporan profil pilihan belum memiliki nilai komposit valid pada skala 1–5 dan tidak dimasukkan ke rata-rata indeks.';
    if (count($currentBranches) < ($filters['branch'] ? 1 : count($regions) * 7)) $quality[] = 'Belum semua cabang memiliki laporan pada periode fokus wilayah.';
    if ($complete < count($currentBranches)) $quality[] = (count($currentBranches) - $complete) . ' laporan cabang belum memiliki keenam nilai risiko inheren yang valid.';
    foreach (['kpmr' => 'KPMR', 'composite' => 'komposit per jenis risiko'] as $metric => $label) {
        $missing = count(array_filter($currentBranches, fn($f) => count(array_filter($values[$f['id']]['risks'], fn($r) => ($r[$metric] ?? null) !== null)) < 6));
        if ($missing) $quality[] = $missing . ' laporan cabang belum lengkap pada nilai ' . $label . '; grafik bagian ini hanya memakai nilai yang tersedia.';
    }
    if ($missingLabels) $quality[] = $missingLabels . ' laporan fokus belum memiliki nilai parameter yang dapat dipetakan ke master.';
    $unmapped = array_sum(array_map(fn($f) => $values[$f['id']]['unmapped'], $currentUnique));
    if ($unmapped) $quality[] = $unmapped . ' nilai parameter belum dapat ditautkan ke master, sehingga tidak diberi nama atau prioritas secara otomatis.';
    if ($received < count($currentBranches)) $quality[] = (count($currentBranches) - $received) . ' laporan cabang fokus belum berstatus diterima Korwil dan SKMR.';
    if (count($timeline) < 2) $quality[] = 'Pilih minimal dua triwulan untuk membaca perubahan antarperiode.';
    $actions = ['kredit' => 'Tinjau konsentrasi kredit, kualitas debitur, dan tindak lanjut penagihan; tetapkan PIC untuk parameter dengan nilai tertinggi.',
        'likuiditas' => 'Perbarui proyeksi arus kas, evaluasi konsentrasi sumber dana, dan uji kecukupan buffer likuiditas.',
        'operasional' => 'Uji pengendalian proses yang lemah, telusuri kejadian operasional, dan verifikasi penyelesaian temuan.',
        'kepatuhan' => 'Periksa pemenuhan kewajiban dan tenggat pelaporan, lalu pastikan bukti tindak lanjut terdokumentasi.',
        'reputasi' => 'Prioritaskan penyelesaian pengaduan dan evaluasi SLA serta komunikasi kepada pemangku kepentingan.',
        'stratejik' => 'Evaluasi deviasi target dan asumsi rencana bisnis, kemudian susun langkah korektif yang terukur.'];
    $suggestions = []; $seenRisk = [];
    foreach ($priorities as $p) {
        if (isset($seenRisk[$p['risk']])) continue;
        $seenRisk[$p['risk']] = true;
        $suggestions[] = ['title' => mon_risks()[$p['risk']], 'evidence' => $p['name'] . ' · nilai tertinggi ' . number_format($p['score'], 2) . ' · ' . $p['scopeLabel'],
            'actions' => [$actions[$p['risk']]], 'owner' => 'SKMR bersama unit terkait', 'timeframe' => 'Tinjauan awal dalam 7 hari kerja'];
        if (count($suggestions) >= 4) break;
    }
    return ['selection'=>['mode'=>$selectionMode,'label'=>$selectionLabel], 'filters' => $filters, 'options' => $options, 'profileName' => $primaryName,
        'periodLabel' => mon_period($filters['start']) . ' — ' . mon_period($end),
        'primaryPeriod' => $primaryPeriod === null ? null : mon_period($primaryPeriod), 'branchPeriod' => $branchPeriod === null ? null : mon_period($branchPeriod),
        'summary' => ['score' => mon_metric($current, $values), 'reports' => count($inRange), 'primaryReports' => count($current), 'primaryScored' => $primaryScored, 'focusReports' => count($currentUnique),
            'branchReports' => count($currentBranches), 'completeBranches' => $complete, 'expectedBranches' => $filters['branch'] ? 1 : count($regions) * 7,
            'received' => $received, 'pending' => count($currentBranches) - $received, 'monitoredParameters' => $monitored,
            'attention' => count($priorities), 'high' => count(array_filter($priorities, fn($p) => $p['severity'] === 'tinggi'))],
        'timeline' => $timeline, 'risks' => $riskCards, 'regions' => $regions, 'priorities' => $priorities,
        'quality' => $quality, 'suggestions' => $suggestions, 'generatedAt' => date(DATE_ATOM)];
}
