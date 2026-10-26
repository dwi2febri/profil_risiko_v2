<?php
if (PHP_SAPI !== 'cli') exit(1);
require_once __DIR__ . '/../admin/includes/pembanding_parameter.php';

function check_pembanding($condition, $message)
{
    if (!$condition) throw new RuntimeException($message);
}

function pembanding_fixture($parameter, $sub = '', $pilar = 'Pilar A', $risk = 'RISIKO KREDIT')
{
    return [
        'ref_tipe' => $sub === '' ? 'parameter' : 'sub_parameter',
        'nama_risiko' => $risk, 'nama_pilar' => $pilar,
        'nama_parameter' => $parameter, 'nama_sub_parameter' => $sub
    ];
}

$source = [
    'parameter|10' => pembanding_fixture('Pertanyaan A'),
    'sub_parameter|11' => pembanding_fixture('Pertanyaan A', 'Sub A'),
    'parameter|12' => pembanding_fixture('Pertanyaan B'),
];
$target = [
    'parameter|20' => pembanding_fixture('  PERTANYAAN&nbsp; A '),
    'sub_parameter|21' => pembanding_fixture('Pertanyaan A', 'Sub A'),
    'parameter|22' => pembanding_fixture('Pertanyaan B'),
    'parameter|23' => pembanding_fixture('Pertanyaan baru'),
    'parameter|24' => pembanding_fixture('Pertanyaan A', '', 'Pilar lain'),
    'parameter|25' => pembanding_fixture('Pertanyaan A', '', 'Pilar A', 'RISIKO LAIN'),
    'sub_parameter|26' => pembanding_fixture('Pertanyaan B', 'Sub A'),
];
$details = ['parameter|10' => ['nilai' => 2], 'sub_parameter|11' => ['nilai' => 3], 'parameter|12' => ['nilai' => 0]];
$mapped = admin_pembanding_map($details, $source, $target);
check_pembanding($mapped === ['parameter|20' => ['nilai' => 2], 'sub_parameter|21' => ['nilai' => 3], 'parameter|22' => ['nilai' => 0]], 'Cross-year matching / hierarchy / genuine zero failed');
check_pembanding(admin_pembanding_map($mapped, $target, $source) === $details, 'Reverse comparison failed');
check_pembanding(admin_pembanding_map($details, $source, $source) === $details, 'Same-master comparison failed');
check_pembanding(admin_pembanding_map([], $source, $target) === [], 'Empty comparison failed');
$duplicates = $source;
$duplicates['parameter|13'] = $source['parameter|10'];
check_pembanding(!isset(admin_pembanding_map($details, $duplicates, $target)['parameter|20']), 'Ambiguous source must not match');
$duplicates = $target;
$duplicates['parameter|27'] = $target['parameter|20'];
check_pembanding(!isset(admin_pembanding_map($details, $source, $duplicates)['parameter|20']), 'Ambiguous target must not match');
check_pembanding(admin_pembanding_map($details, $source, ['parameter|10' => pembanding_fixture('Edited label')])['parameter|10']['nilai'] === 2, 'Exact ID must take priority');
echo "PASS: cross-year, reverse, same-master, empty, hierarchy, ambiguity, zero, exact ID\n";

// Optional read-only regression against two existing reports, e.g. php ... 543 555.
if (isset($argv[1], $argv[2])) {
    require __DIR__ . '/../conn/conn.php';
    mysqli_set_charset($conn, 'utf8mb4');
    $reports = [(int)$argv[1], (int)$argv[2]];
    foreach (['kpmr', 'inheren'] as $kind) {
        $table = 'assessment_' . $kind;
        $idColumn = 'id_' . $table;
        $periodTable = $kind === 'kpmr' ? 'kpmr_periode' : 'pr_inheren_periode';
        $selectionTable = $kind === 'kpmr' ? 'kpmr_pilih_parameter' : 'pr_pilih_parameter';
        $periodColumn = $periodTable . '_id';
        foreach ([[$reports[0], $reports[1]], [$reports[1], $reports[0]], [$reports[0], $reports[0]]] as $pair) {
            [$sourceReport, $targetReport] = $pair;
            $frame = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko WHERE id_profil_risiko=$targetReport"));
            check_pembanding((bool)$frame, 'Target report missing');
            $period = mysqli_fetch_assoc(mysqli_query($conn, "SELECT pp.$periodColumn AS id FROM $selectionTable pp JOIN $periodTable p ON p.id=pp.$periodColumn WHERE p.tahun='".(int)$frame['tahun']."' AND pp.id_user_profil_risiko='".(int)$frame['user']."' ORDER BY pp.id DESC LIMIT 1"));
            check_pembanding((bool)$period, 'Target master missing');
            $headers = mysqli_query($conn, "SELECT * FROM $table WHERE id_profil_risiko=$sourceReport");
            while ($header = mysqli_fetch_assoc($headers)) {
                $rows = mysqli_query($conn, "SELECT * FROM {$table}_detail WHERE $idColumn=".(int)$header[$idColumn]);
                $details = [];
                while ($row = mysqli_fetch_assoc($rows)) $details[$row['ref_tipe'].'|'.$row['ref_id']] = $row;
                $mapped = admin_pembanding_parameter($conn, $details, $kind, $header['jenis_risiko'], $period['id']);
                foreach ($mapped as $row) {
                    check_pembanding($row === $details[$row['ref_tipe'].'|'.$row['ref_id']], 'Source value changed');
                }
                echo "$kind $sourceReport -> $targetReport {$header['jenis_risiko']}: ", count($mapped), '/', count($details), " mapped\n";
                check_pembanding(count($mapped) === count($details), 'Some comparison parameters did not match');
            }
        }
    }
    echo "PASS: existing report comparisons (read-only)\n";
}
