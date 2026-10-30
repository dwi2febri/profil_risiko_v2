<?php
/** Read stored results only; never recalculate ratings or write to assessments. */
function hasil_kc_valid_score($value): bool
{
    return is_numeric($value) && (float)$value >= 1 && (float)$value <= 5;
}
/** Same inherent-risk boundaries used by the credit and dynamic assessment forms. */
function hasil_kc_pillar_band($value): ?array
{
    if (!hasil_kc_valid_score($value)) return null;
    $score = (float)$value;
    if ($score <= 1.25) return ['blue', 'Sangat rendah'];
    if ($score <= 2.25) return ['green', 'Rendah'];
    if ($score <= 3.25) return ['yellow', 'Sedang'];
    if ($score <= 4.25) return ['orange', 'Tinggi'];
    return ['red', 'Sangat tinggi'];
}
function hasil_kc_pillar_attributes($value): string
{
    $band = hasil_kc_pillar_band($value);
    if (!$band) return 'class="hasil-pillar-unavailable"';
    $label = htmlspecialchars((string)$value . ' - ' . $band[1], ENT_QUOTES, 'UTF-8');
    return 'class="hasil-pillar-cell hasil-pillar-' . $band[0] . '" title="' . $label . '" aria-label="' . $label . '"';
}
/** Composite rank boundaries match nilai_peringkat/peringkat_profil.php. */
function hasil_kc_composite_attributes($value): string
{
    if (!hasil_kc_valid_score($value)) return 'class="hasil-pillar-unavailable"';
    $score = (float)$value;
    [$color, $rank] = match (true) {
        $score < 1.25 => ['blue','Sangat rendah'],
        $score < 2.25 => ['green','Rendah'],
        $score < 3.25 => ['yellow','Sedang'],
        $score < 4.25 => ['orange','Tinggi'],
        default => ['red','Sangat tinggi']
    };
    $label = htmlspecialchars((string)$value . ' - ' . $rank, ENT_QUOTES, 'UTF-8');
    return 'class="hasil-pillar-cell hasil-pillar-' . $color . '" title="' . $label . '" aria-label="' . $label . '"';
}
function hasil_kc_latest_rows(mysqli $db, string $table, array $ids): array
{
    if (!$ids) return [];
    $rows = [];
    $result = mysqli_query($db, "SELECT * FROM `$table` WHERE id_profil_risiko IN (" . implode(',', array_map('intval', $ids)) . ") ORDER BY 1 DESC");
    while ($row = mysqli_fetch_assoc($result)) {
        $id = (int)$row['id_profil_risiko'];
        if (!isset($rows[$id])) $rows[$id] = $row;
    }
    return $rows;
}
function hasil_kc_load_results(mysqli $db, array $frames): array
{
    $out = []; $ids = array_column($frames, 'id_profil_risiko');
    if (!$ids) return $out;
    $risks = ['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'];
    foreach ($risks as $risk) {
        $rows = hasil_kc_latest_rows($db, 'hasil_inheren_' . $risk, $ids);
        foreach ($frames as $branch => $frame) {
            $row = $rows[(int)$frame['id_profil_risiko']] ?? [];
            if (!hasil_kc_valid_score($row['hasil_tingkat_risiko'] ?? null)) {
                unset($row['hasil_tingkat_risiko'], $row['hasil_peringkat']);
            } else $row['_source'] = 'Hasil inheren';
            $out[$branch][$risk] = $row;
        }
    }
    $assessments = [];
    $result = mysqli_query($db, 'SELECT * FROM assessment_inheren WHERE id_profil_risiko IN (' . implode(',', array_map('intval', $ids)) . ') ORDER BY id_assessment_inheren DESC');
    while ($row = mysqli_fetch_assoc($result)) {
        $risk = strtolower(trim(preg_replace('/^RISIKO\s+/i', '', $row['jenis_risiko'])));
        $key = (int)$row['id_profil_risiko'] . '|' . $risk;
        if (!isset($assessments[$key])) $assessments[$key] = $row;
    }
    $profiles = [];
    foreach ($risks as $risk) $profiles[$risk] = hasil_kc_latest_rows($db, 'keterangan_profil_' . $risk, $ids);
    $totals = hasil_kc_latest_rows($db, 'nilai_profil', $ids);
    foreach ($frames as $branch => $frame) {
        $id = (int)$frame['id_profil_risiko'];
        foreach ($risks as $risk) {
            $assessment = $assessments[$id . '|' . $risk] ?? [];
            $profile = $profiles[$risk][$id] ?? [];
            if (!isset($out[$branch][$risk]['hasil_tingkat_risiko']) && hasil_kc_valid_score($profile['inheren_' . $risk] ?? null)) {
                $out[$branch][$risk]['hasil_tingkat_risiko'] = $profile['inheren_' . $risk];
                $out[$branch][$risk]['_source'] = 'Profil risiko - nilai inheren';
                // The profile's rank describes the composite risk, not the inherent score.
                if (hasil_kc_valid_score($assessment['tingkat_risiko'] ?? null) && (float)$assessment['tingkat_risiko'] === (float)$profile['inheren_' . $risk]) {
                    $out[$branch][$risk]['hasil_peringkat'] = $assessment['peringkat'] ?? null;
                }
            }
            if (!isset($out[$branch][$risk]['hasil_tingkat_risiko']) && hasil_kc_valid_score($assessment['tingkat_risiko'] ?? null)) {
                $out[$branch][$risk]['hasil_tingkat_risiko'] = $assessment['tingkat_risiko'];
                $out[$branch][$risk]['hasil_peringkat'] = $assessment['peringkat'] ?? null;
                $out[$branch][$risk]['_source'] = 'Assessment inheren';
            }
        }
        $out[$branch]['total'] = $totals[$id] ?? [];
    }
    return $out;
}

function hasil_kc_escape($value): string {return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');}
/** Regional means use the same latest report and score selection as the branch table. */
function hasil_kc_regions(array $frames, array $results): array
{
    $regions = [];
    foreach (['semarang'=>'Area Semarang','solo'=>'Area Solo','banyumas'=>'Area Banyumas','pekalongan'=>'Area Pekalongan'] as $key=>$name) {
        $start = count($regions)*7+1; $end = $start+6;
        $samples = array_fill_keys(['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'], []);
        $reports = 0;
        foreach ($frames as $branch=>$frame) {
            if ($branch < $start || $branch > $end) continue;
            $reports++;
            foreach ($samples as $risk=>$_) {
                $score = $results[$branch][$risk]['hasil_tingkat_risiko'] ?? null;
                if (hasil_kc_valid_score($score)) $samples[$risk][] = (float)$score;
            }
        }
        $values = []; $counts = [];
        foreach ($samples as $risk=>$scores) {$counts[$risk] = count($scores); $values[$risk] = $scores ? round(array_sum($scores)/count($scores), 2) : null;}
        $regions[$key] = ['name'=>$name,'start'=>$start,'end'=>$end,'reports'=>$reports,'values'=>$values,'counts'=>$counts];
    }
    return $regions;
}
