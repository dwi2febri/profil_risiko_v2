<?php

/** Normalize presentation differences without treating different questions as equal. */
function admin_pembanding_label($value)
{
    $value = strip_tags(html_entity_decode((string)$value, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    $value = preg_replace('/[\s\x{00a0}]+/u', ' ', $value);
    return mb_strtolower(trim($value), 'UTF-8');
}

function admin_pembanding_identity(array $row)
{
    $parts = [$row['ref_tipe'], $row['nama_risiko'], $row['nama_pilar'], $row['nama_parameter']];
    if ($row['ref_tipe'] === 'sub_parameter') {
        $parts[] = $row['nama_sub_parameter'];
    }
    return json_encode(array_map('admin_pembanding_label', $parts), JSON_UNESCAPED_UNICODE);
}

/**
 * Expose selected-report details under the current master's IDs. Exact IDs win;
 * cross-year matches must have a unique, identical question within its hierarchy.
 * Never use row order alone: an inserted/replaced question must not inherit a score.
 */
function admin_pembanding_map(array $details, array $sourceMaster, array $targetMaster)
{
    $sourceByIdentity = [];
    $targetByIdentity = [];
    foreach ($sourceMaster as $key => $row) {
        $sourceByIdentity[admin_pembanding_identity($row)][] = $key;
    }
    foreach ($targetMaster as $key => $row) {
        $targetByIdentity[admin_pembanding_identity($row)][] = $key;
    }

    $mapped = [];
    foreach ($targetMaster as $key => $row) {
        if (array_key_exists($key, $details)) {
            $mapped[$key] = $details[$key];
            continue;
        }
        $identity = admin_pembanding_identity($row);
        $candidates = $sourceByIdentity[$identity] ?? [];
        if (count($candidates) !== 1 || count($targetByIdentity[$identity]) !== 1) {
            continue;
        }
        $sourceKey = $candidates[0];
        if (array_key_exists($sourceKey, $details)) {
            $mapped[$key] = $details[$sourceKey];
        }
    }
    return $mapped;
}

/** Read-only remapping for both KPMR and dynamic inherent assessments. */
function admin_pembanding_parameter($conn, array $details, $jenis, $risk, $targetPeriod)
{
    if (!$details) return [];
    if (!in_array($jenis, ['kpmr', 'inheren'], true)) {
        throw new InvalidArgumentException('Jenis parameter pembanding tidak dikenal.');
    }
    $prefix = $jenis === 'kpmr' ? 'kpmr' : 'pr';
    $periodColumn = $jenis === 'kpmr' ? 'kpmr_periode_id' : 'pr_inheren_periode_id';
    $targetPeriod = (int)$targetPeriod;
    $risk = mysqli_real_escape_string($conn, $risk);
    $parameterIds = [0];
    $subIds = [0];
    foreach ($details as $detail) {
        if ($detail['ref_tipe'] === 'parameter') $parameterIds[] = (int)$detail['ref_id'];
        if ($detail['ref_tipe'] === 'sub_parameter') $subIds[] = (int)$detail['ref_id'];
    }
    $parameterIds = implode(',', array_unique($parameterIds));
    $subIds = implode(',', array_unique($subIds));
    $result = mysqli_query($conn, "
        SELECT jr.nama_risiko, p.nama_pilar, pm.id AS parameter_id,
               pm.nama_parameter, pm.$periodColumn AS periode_id,
               sp.id AS sub_parameter_id, sp.nama_sub_parameter
        FROM {$prefix}_jenis_risiko jr
        INNER JOIN {$prefix}_pilar p ON p.jenis_risiko_id = jr.id
        INNER JOIN {$prefix}_parameter pm ON pm.pilar_id = p.id
        LEFT JOIN {$prefix}_sub_parameter sp ON sp.parameter_id = pm.id
        WHERE jr.nama_risiko = '$risk'
          AND (pm.$periodColumn = $targetPeriod
               OR pm.id IN ($parameterIds) OR sp.id IN ($subIds))
    ");
    if (!$result) {
        throw new RuntimeException('Gagal membaca master parameter pembanding: ' . mysqli_error($conn));
    }
    $sourceMaster = [];
    $targetMaster = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $refs = ['parameter' => (int)$row['parameter_id']];
        if (!empty($row['sub_parameter_id'])) $refs['sub_parameter'] = (int)$row['sub_parameter_id'];
        foreach ($refs as $type => $refId) {
            $key = $type . '|' . $refId;
            $metadata = $row;
            $metadata['ref_tipe'] = $type;
            if (array_key_exists($key, $details)) $sourceMaster[$key] = $metadata;
            if ((int)$row['periode_id'] === $targetPeriod) $targetMaster[$key] = $metadata;
        }
    }
    return admin_pembanding_map($details, $sourceMaster, $targetMaster);
}
