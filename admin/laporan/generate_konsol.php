<?php
include __DIR__ . "/../../conn/conn.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!function_exists('gk_esc')) {
    function gk_esc($str)
    {
        return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
    }
}

function gk_rupiah($angka)
{
    return number_format((float)$angka, 0, ',', '.');
}

function gk_ident($name)
{
    return '`' . str_replace('`', '``', $name) . '`';
}

function gk_table_exists($conn, $table)
{
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function gk_column_exists($conn, $table, $column)
{
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}

function gk_columns($conn, $table)
{
    $cols = [];
    $q = mysqli_query($conn, "SHOW COLUMNS FROM " . gk_ident($table));
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $cols[] = $row;
        }
    }
    return $cols;
}

function gk_run($conn, $sql, $label)
{
    if (!mysqli_query($conn, $sql)) {
        throw new Exception($label . ': ' . mysqli_error($conn));
    }
}

function gk_copy_profile_table($conn, $table, $sourceId, $targetId)
{
    if (!gk_column_exists($conn, $table, 'id_profil_risiko')) {
        return;
    }

    $cols = gk_columns($conn, $table);
    if (empty($cols)) {
        return;
    }

    $insertCols = [];
    $selectCols = [];
    foreach ($cols as $col) {
        $field = $col['Field'];
        $extra = strtolower((string)($col['Extra'] ?? ''));
        if (strpos($extra, 'auto_increment') !== false) {
            continue;
        }

        $insertCols[] = gk_ident($field);
        $selectCols[] = ($field === 'id_profil_risiko') ? "'" . (int)$targetId . "'" : gk_ident($field);
    }

    if (empty($insertCols)) {
        return;
    }

    $tableIdent = gk_ident($table);
    gk_run($conn, "DELETE FROM $tableIdent WHERE id_profil_risiko = '" . (int)$targetId . "'", "DELETE $table");
    gk_run(
        $conn,
        "INSERT INTO $tableIdent (" . implode(',', $insertCols) . ")
         SELECT " . implode(',', $selectCols) . "
         FROM $tableIdent
         WHERE id_profil_risiko = '" . (int)$sourceId . "'",
        "COPY $table"
    );
}

function gk_copy_assessment_bundle($conn, $assessmentTable, $detailTable, $pkCol, $fkCol, $sourceId, $targetId)
{
    if (!gk_table_exists($conn, $assessmentTable) || !gk_table_exists($conn, $detailTable)) {
        return;
    }

    $assessmentIdent = gk_ident($assessmentTable);
    $detailIdent = gk_ident($detailTable);
    $pkIdent = gk_ident($pkCol);
    $fkIdent = gk_ident($fkCol);

    $qTarget = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$targetId . "'");
    if ($qTarget) {
        while ($target = mysqli_fetch_assoc($qTarget)) {
            gk_run($conn, "DELETE FROM $detailIdent WHERE $fkIdent = '" . (int)$target['id_header'] . "'", "DELETE $detailTable");
        }
    }
    gk_run($conn, "DELETE FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$targetId . "'", "DELETE $assessmentTable");

    $assessmentCols = gk_columns($conn, $assessmentTable);
    $detailCols = gk_columns($conn, $detailTable);
    if (empty($assessmentCols)) {
        return;
    }

    $headerInsertCols = [];
    $headerSelectCols = [];
    foreach ($assessmentCols as $col) {
        $field = $col['Field'];
        $extra = strtolower((string)($col['Extra'] ?? ''));
        if ($field === $pkCol || strpos($extra, 'auto_increment') !== false) {
            continue;
        }
        $headerInsertCols[] = gk_ident($field);
        $headerSelectCols[] = ($field === 'id_profil_risiko') ? "'" . (int)$targetId . "'" : gk_ident($field);
    }

    $detailInsertCols = [];
    $detailSelectCols = [];
    foreach ($detailCols as $col) {
        $field = $col['Field'];
        $extra = strtolower((string)($col['Extra'] ?? ''));
        if (strpos($extra, 'auto_increment') !== false) {
            continue;
        }
        $detailInsertCols[] = gk_ident($field);
        $detailSelectCols[] = ($field === $fkCol) ? '__NEW_HEADER_ID__' : gk_ident($field);
    }

    $qSource = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$sourceId . "' ORDER BY $pkIdent ASC");
    if (!$qSource) {
        throw new Exception("READ $assessmentTable: " . mysqli_error($conn));
    }

    while ($source = mysqli_fetch_assoc($qSource)) {
        $sourceHeaderId = (int)$source['id_header'];
        gk_run(
            $conn,
            "INSERT INTO $assessmentIdent (" . implode(',', $headerInsertCols) . ")
             SELECT " . implode(',', $headerSelectCols) . "
             FROM $assessmentIdent
             WHERE $pkIdent = '$sourceHeaderId'",
            "COPY $assessmentTable"
        );

        $newHeaderId = (int)mysqli_insert_id($conn);
        if ($newHeaderId > 0 && !empty($detailInsertCols)) {
            $selectForDetail = str_replace('__NEW_HEADER_ID__', "'" . $newHeaderId . "'", $detailSelectCols);
            gk_run(
                $conn,
                "INSERT INTO $detailIdent (" . implode(',', $detailInsertCols) . ")
                 SELECT " . implode(',', $selectForDetail) . "
                 FROM $detailIdent
                 WHERE $fkIdent = '$sourceHeaderId'",
                "COPY $detailTable"
            );
        }
    }
}

function gk_copy_profile_contents($conn, $sourceId, $targetId)
{
    $exclude = [
        'frame_laporan_profil_risiko' => true,
        'assessment_inheren' => true,
        'assessment_inheren_detail' => true,
        'assessment_kpmr' => true,
        'assessment_kpmr_detail' => true,
    ];

    $qTables = mysqli_query($conn, "SHOW TABLES");
    if (!$qTables) {
        throw new Exception('Gagal membaca daftar tabel: ' . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_row($qTables)) {
        $table = $row[0];
        if (isset($exclude[$table])) {
            continue;
        }
        if (gk_column_exists($conn, $table, 'id_profil_risiko')) {
            gk_copy_profile_table($conn, $table, $sourceId, $targetId);
        }
    }

    gk_copy_assessment_bundle($conn, 'assessment_inheren', 'assessment_inheren_detail', 'id_assessment_inheren', 'id_assessment_inheren', $sourceId, $targetId);
    gk_copy_assessment_bundle($conn, 'assessment_kpmr', 'assessment_kpmr_detail', 'id_assessment_kpmr', 'id_assessment_kpmr', $sourceId, $targetId);
}

function gk_inheren_label($nilai)
{
    $nilai = (float)$nilai;
    if ($nilai <= 0) return '';
    if ($nilai <= 1.25) return 'Sangat Rendah';
    if ($nilai <= 2.25) return 'Rendah';
    if ($nilai <= 3.25) return 'Sedang';
    if ($nilai <= 4.25) return 'Tinggi';
    return 'Sangat Tinggi';
}

function gk_kpmr_label($nilai)
{
    $nilai = (float)$nilai;
    if ($nilai <= 0) return '';
    if ($nilai <= 1.25) return 'Sangat Memadai';
    if ($nilai <= 2.25) return 'Memadai';
    if ($nilai <= 3.25) return 'Cukup Memadai';
    if ($nilai <= 4.25) return 'Kurang Memadai';
    return 'Tidak Memadai';
}

function gk_ensure_assessment_header($conn, $table, $pkCol, $profileId, $riskName, $userId)
{
    $tableIdent = gk_ident($table);
    $pkIdent = gk_ident($pkCol);
    $profileId = (int)$profileId;
    $riskSql = mysqli_real_escape_string($conn, $riskName);
    $q = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $tableIdent WHERE id_profil_risiko = '$profileId' AND jenis_risiko = '$riskSql' LIMIT 1");
    if ($q && ($row = mysqli_fetch_assoc($q))) {
        return (int)$row['id_header'];
    }

    gk_run(
        $conn,
        "INSERT INTO $tableIdent (id_profil_risiko, jenis_risiko, dibuat_by)
         VALUES ('$profileId', '$riskSql', '" . (int)$userId . "')",
        "CREATE $table"
    );
    return (int)mysqli_insert_id($conn);
}

function gk_merge_assessment_kind($conn, $targetId, array $divisiIds, $kind, array $riskNames, $userId)
{
    $isInheren = ($kind === 'inheren');
    $assessmentTable = $isInheren ? 'assessment_inheren' : 'assessment_kpmr';
    $detailTable = $isInheren ? 'assessment_inheren_detail' : 'assessment_kpmr_detail';
    $pkCol = $isInheren ? 'id_assessment_inheren' : 'id_assessment_kpmr';
    $fkCol = $pkCol;

    if (!gk_table_exists($conn, $assessmentTable) || !gk_table_exists($conn, $detailTable)) {
        return 0;
    }

    $changed = 0;
    $assessmentIdent = gk_ident($assessmentTable);
    $detailIdent = gk_ident($detailTable);
    $pkIdent = gk_ident($pkCol);
    $fkIdent = gk_ident($fkCol);

    foreach ($riskNames as $riskName) {
        $targetHeaderId = gk_ensure_assessment_header($conn, $assessmentTable, $pkCol, $targetId, $riskName, $userId);
        $current = [];
        $qCurrent = mysqli_query($conn, "SELECT * FROM $detailIdent WHERE $fkIdent = '$targetHeaderId'");
        if ($qCurrent) {
            while ($row = mysqli_fetch_assoc($qCurrent)) {
                $key = $row['ref_tipe'] . '|' . $row['ref_id'];
                $current[$key] = $row;
            }
        }

        foreach ($divisiIds as $divisiId) {
            $riskSql = mysqli_real_escape_string($conn, $riskName);
            $qHeader = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$divisiId . "' AND jenis_risiko = '$riskSql' LIMIT 1");
            if (!$qHeader || !($header = mysqli_fetch_assoc($qHeader))) {
                continue;
            }

            $sourceHeaderId = (int)$header['id_header'];
            $qDetail = mysqli_query($conn, "SELECT * FROM $detailIdent WHERE $fkIdent = '$sourceHeaderId'");
            if (!$qDetail) {
                continue;
            }

            while ($detail = mysqli_fetch_assoc($qDetail)) {
                $nilai = (int)$detail['nilai'];
                if ($nilai <= 0) {
                    continue;
                }

                $key = $detail['ref_tipe'] . '|' . $detail['ref_id'];
                $existingNilai = isset($current[$key]) ? (int)$current[$key]['nilai'] : 0;
                if ($nilai <= $existingNilai) {
                    continue;
                }

                $refTipe = mysqli_real_escape_string($conn, $detail['ref_tipe']);
                $refId = (int)$detail['ref_id'];
                $parameterId = isset($detail['parameter_id']) ? (int)$detail['parameter_id'] : 0;
                $subParameterId = isset($detail['sub_parameter_id']) ? (int)$detail['sub_parameter_id'] : 0;
                $ket = mysqli_real_escape_string($conn, (string)($detail['keterangan'] ?? ''));
                $urutanPilar = isset($detail['urutan_pilar']) ? (int)$detail['urutan_pilar'] : 0;
                $urutanParameter = isset($detail['urutan_parameter']) ? (int)$detail['urutan_parameter'] : 0;
                $urutanSub = isset($detail['urutan_sub']) ? (int)$detail['urutan_sub'] : 0;

                if (isset($current[$key])) {
                    $idDetail = (int)$current[$key]['id_detail'];
                    gk_run(
                        $conn,
                        "UPDATE $detailIdent SET
                            nilai = '$nilai',
                            parameter_id = '$parameterId',
                            sub_parameter_id = '$subParameterId',
                            keterangan = '$ket',
                            urutan_pilar = '$urutanPilar',
                            urutan_parameter = '$urutanParameter',
                            urutan_sub = '$urutanSub'
                         WHERE id_detail = '$idDetail'",
                        "UPDATE $detailTable"
                    );
                    $current[$key]['nilai'] = $nilai;
                } else {
                    gk_run(
                        $conn,
                        "INSERT INTO $detailIdent
                            ($fkIdent, ref_tipe, ref_id, parameter_id, sub_parameter_id, nilai, nilai_sebelumnya, keterangan, urutan_pilar, urutan_parameter, urutan_sub)
                         VALUES
                            ('$targetHeaderId', '$refTipe', '$refId', '$parameterId', '$subParameterId', '$nilai', '0', '$ket', '$urutanPilar', '$urutanParameter', '$urutanSub')",
                        "INSERT $detailTable"
                    );
                    $current[$key] = ['id_detail' => mysqli_insert_id($conn), 'nilai' => $nilai];
                }
                $changed++;
            }
        }

        $qAvg = mysqli_query($conn, "SELECT AVG(NULLIF(nilai, 0)) AS avg_nilai FROM $detailIdent WHERE $fkIdent = '$targetHeaderId'");
        $avg = 0;
        if ($qAvg && ($rowAvg = mysqli_fetch_assoc($qAvg))) {
            $avg = (float)($rowAvg['avg_nilai'] ?? 0);
        }
        $label = $isInheren ? gk_inheren_label($avg) : gk_kpmr_label($avg);
        $labelSql = mysqli_real_escape_string($conn, $label);
        gk_run(
            $conn,
            "UPDATE $assessmentIdent SET total_nilai = '" . number_format($avg, 2, '.', '') . "', tingkat_risiko = '" . number_format($avg, 2, '.', '') . "', peringkat = '$labelSql' WHERE $pkIdent = '$targetHeaderId'",
            "UPDATE $assessmentTable"
        );
    }

    return $changed;
}

function gk_numeric_compare_tables($conn, $targetId, array $divisiIds)
{
    if (empty($divisiIds)) {
        return 0;
    }

    $skipExact = [
        'frame_laporan_profil_risiko' => true,
        'assessment_inheren' => true,
        'assessment_inheren_detail' => true,
        'assessment_kpmr' => true,
        'assessment_kpmr_detail' => true,
        'nilai_profil' => true,
        'peringkat_profil' => true,
    ];
    $changed = 0;
    $qTables = mysqli_query($conn, "SHOW TABLES");
    if (!$qTables) {
        return 0;
    }

    while ($row = mysqli_fetch_row($qTables)) {
        $table = $row[0];
        if (isset($skipExact[$table]) || strpos($table, 'master_') === 0) {
            continue;
        }
        if (!gk_column_exists($conn, $table, 'id_profil_risiko')) {
            continue;
        }

        $cols = gk_columns($conn, $table);
        $numericCols = [];
        $textCols = [];
        foreach ($cols as $col) {
            $field = $col['Field'];
            $type = strtolower($col['Type']);
            $extra = strtolower((string)($col['Extra'] ?? ''));
            if ($field === 'id_profil_risiko' || strpos($field, 'id_') === 0 || in_array($field, ['dibuat_by', 'created_by', 'updated_by'], true) || strpos($extra, 'auto_increment') !== false) {
                continue;
            }
            if (preg_match('/^(tinyint|smallint|mediumint|int|bigint|decimal|float|double)/', $type)) {
                $numericCols[] = $field;
            } elseif (preg_match('/(ket|keterangan|catatan|uraian|analisis|analisa|respon|tindak|saran)/i', $field)) {
                $textCols[] = $field;
            }
        }
        if (empty($numericCols)) {
            continue;
        }

        $tableIdent = gk_ident($table);
        $qTarget = mysqli_query($conn, "SELECT * FROM $tableIdent WHERE id_profil_risiko = '" . (int)$targetId . "' LIMIT 1");
        if (!$qTarget || !($target = mysqli_fetch_assoc($qTarget))) {
            continue;
        }

        $updates = [];
        $textUpdates = [];
        foreach ($divisiIds as $divisiId) {
            $qDiv = mysqli_query($conn, "SELECT * FROM $tableIdent WHERE id_profil_risiko = '" . (int)$divisiId . "' LIMIT 1");
            if (!$qDiv || !($div = mysqli_fetch_assoc($qDiv))) {
                continue;
            }
            foreach ($numericCols as $field) {
                $candidate = is_numeric($div[$field] ?? null) ? (float)$div[$field] : 0;
                $current = isset($updates[$field])
                    ? (float)$updates[$field]
                    : (is_numeric($target[$field] ?? null) ? (float)$target[$field] : 0);
                if ($candidate > $current) {
                    $updates[$field] = $candidate;
                    foreach ($textCols as $textField) {
                        if (array_key_exists($textField, $div)) {
                            $textUpdates[$textField] = $div[$textField];
                        }
                    }
                }
            }
        }

        if (!empty($updates) || !empty($textUpdates)) {
            $set = [];
            foreach ($updates as $field => $value) {
                $set[] = gk_ident($field) . " = '" . mysqli_real_escape_string($conn, (string)$value) . "'";
            }
            foreach ($textUpdates as $field => $value) {
                $set[] = gk_ident($field) . " = '" . mysqli_real_escape_string($conn, (string)$value) . "'";
            }
            gk_run($conn, "UPDATE $tableIdent SET " . implode(', ', $set) . " WHERE id_profil_risiko = '" . (int)$targetId . "'", "COMPARE $table");
            $changed += count($updates);
        }
    }

    return $changed;
}

function gk_year_has_setting($conn, $tahun)
{
    $tahunSql = mysqli_real_escape_string($conn, (string)$tahun);
    $q = mysqli_query($conn, "SELECT id_frame_perumusan FROM frame_perumusan WHERE tahun = '$tahunSql' AND is_aktif = 1 LIMIT 1");
    return $q && mysqli_num_rows($q) > 0;
}

function gk_year_has_complete_setting_for_user($conn, $tahun, $userId)
{
    $tahun = (int)$tahun;
    $userId = (int)$userId;
    if ($tahun <= 0 || $userId <= 0) {
        return false;
    }

    $qFrame = simpro_db_query($conn, "
        SELECT id_frame_perumusan
        FROM frame_perumusan
        WHERE tahun = ?
          AND user_id = ?
          AND is_aktif = 1
          AND (id_divisi_tetapan IS NULL OR id_divisi_tetapan = 0)
        LIMIT 1
    ", [$tahun, $userId]);
    if (!$qFrame || mysqli_num_rows($qFrame) <= 0) {
        return false;
    }

    $qInheren = simpro_db_query($conn, "
        SELECT pp.id
        FROM pr_pilih_parameter pp
        INNER JOIN pr_inheren_periode p ON p.id = pp.pr_inheren_periode_id
        WHERE p.tahun = ?
          AND pp.id_user_profil_risiko = ?
          AND (pp.id_divisi_tetapan IS NULL OR pp.id_divisi_tetapan = 0)
        LIMIT 1
    ", [$tahun, $userId]);
    if (!$qInheren || mysqli_num_rows($qInheren) <= 0) {
        return false;
    }

    $qKpmr = simpro_db_query($conn, "
        SELECT kp.id
        FROM kpmr_pilih_parameter kp
        INNER JOIN kpmr_periode p ON p.id = kp.kpmr_periode_id
        WHERE p.tahun = ?
          AND kp.id_user_profil_risiko = ?
          AND (kp.id_divisi_tetapan IS NULL OR kp.id_divisi_tetapan = 0)
        LIMIT 1
    ", [$tahun, $userId]);
    return $qKpmr && mysqli_num_rows($qKpmr) > 0;
}

function gk_latest_skmr_profile($conn, $tahun, $periode, $lokasiSession)
{
    $tahun = (int)$tahun;
    $periode = (int)$periode;
    $lokasiSql = $lokasiSession > 0 ? "AND kantor_cabang = '" . (int)$lokasiSession . "'" : "";
    $q = mysqli_query($conn, "
        SELECT *
        FROM frame_laporan_profil_risiko
        WHERE user = 1
          AND tahun = '$tahun'
          AND periode = '$periode'
          $lokasiSql
        ORDER BY id_profil_risiko DESC
        LIMIT 1
    ");
    if ($q && ($row = mysqli_fetch_assoc($q))) {
        return $row;
    }

    $qFallback = simpro_db_query($conn, "
        SELECT *
        FROM frame_laporan_profil_risiko
        WHERE user = 1
          AND tahun = ?
          AND periode = ?
        ORDER BY id_profil_risiko DESC
        LIMIT 1
    ", [$tahun, $periode]);
    return $qFallback ? mysqli_fetch_assoc($qFallback) : null;
}

function gk_divisi_profiles($conn, $tahun, $periode)
{
    $ids = [];
    $tahun = (int)$tahun;
    $periode = (int)$periode;
    $q = simpro_db_query($conn, "
        SELECT id_profil_risiko
        FROM frame_laporan_profil_risiko
        WHERE user = 2
          AND tahun = ?
          AND periode = ?
        ORDER BY id_profil_risiko ASC
    ", [$tahun, $periode]);
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $ids[] = (int)$row['id_profil_risiko'];
        }
    }
    return $ids;
}

function gk_divisi_profile_rows($conn, $tahun, $periode)
{
    $rows = [];
    $tahun = (int)$tahun;
    $periode = (int)$periode;
    $q = simpro_db_query($conn, "
        SELECT *
        FROM frame_laporan_profil_risiko
        WHERE user = 2
          AND tahun = ?
          AND periode = ?
        ORDER BY kantor_cabang ASC, id_profil_risiko ASC
    ", [$tahun, $periode]);
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $rows[] = $row;
        }
    }
    return $rows;
}

function gk_divisi_label($id)
{
    $labels = [
        132 => 'Divisi Pemasaran',
        133 => 'Divisi Operasional',
        134 => 'Divisi SDM',
        135 => 'Satker Kepatuhan',
        136 => 'Sekretaris Perusahaan',
        137 => 'Divisi Litbang',
        140 => 'Divisi Penyelesaian Kredit',
        143 => 'SKAI',
    ];
    $id = (int)$id;
    return $labels[$id] ?? ('Divisi #' . $id);
}

function gk_divisi_generate_labels($conn, $tahun, $periode)
{
    $labels = [];
    $tahun = (int)$tahun;
    $periode = (int)$periode;
    $q = simpro_db_query($conn, "
        SELECT DISTINCT kantor_cabang
        FROM frame_laporan_profil_risiko
        WHERE user = 2
          AND tahun = ?
          AND periode = ?
        ORDER BY kantor_cabang ASC
    ", [$tahun, $periode]);
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $labels[] = gk_divisi_label($row['kantor_cabang']);
        }
    }
    return $labels;
}

function gk_generate_final($conn, $tahun, $periode, $jenisUser, $keteranganTambahan, $lokasiSession, $userLoginId)
{
    $source = gk_latest_skmr_profile($conn, $tahun, $periode, $lokasiSession);
    if (!$source) {
        throw new Exception('Profil Risiko SKMR untuk tahun dan periode tersebut belum ada.');
    }

    $sourceId = (int)$source['id_profil_risiko'];
    $jenisUser = (int)$jenisUser;
    $label = $jenisUser === 6 ? 'Final Konsolidasi Otomatis' : 'Final Konsolidasi / Perbaikan';
    $ketFinal = trim('[GENERATE KONSOL] ' . $label . ($keteranganTambahan !== '' ? ' - ' . $keteranganTambahan : ''));
    $ketSql = mysqli_real_escape_string($conn, $ketFinal);
    $tanggal = date('Y-m-d');

    gk_run(
        $conn,
        "INSERT INTO frame_laporan_profil_risiko
            (kantor_cabang, tahun, user, periode, modal_inti, total_aset, keterangan, dibuat_at, dibuat_by, data_pembanding, status_korwil, status_skmr, kunci_laporan)
         VALUES
            ('" . (int)$source['kantor_cabang'] . "', '" . (int)$tahun . "', '$jenisUser', '" . (int)$periode . "', '" . (float)$source['modal_inti'] . "', '" . (float)$source['total_aset'] . "', '$ketSql', '$tanggal', '" . (int)$userLoginId . "', NULL, '0', '0', '0')",
        'INSERT frame_laporan_profil_risiko'
    );

    $targetId = (int)mysqli_insert_id($conn);
    gk_copy_profile_contents($conn, $sourceId, $targetId);

    $divisiIds = gk_divisi_profiles($conn, $tahun, $periode);
    $riskNames = [
        'RISIKO KREDIT',
        'RISIKO OPERASIONAL',
        'RISIKO KEPATUHAN',
        'RISIKO LIKUIDITAS',
        'RISIKO REPUTASI',
        'RISIKO STRATEJIK',
    ];

    $assessmentChanges = 0;
    $assessmentChanges += gk_merge_assessment_kind($conn, $targetId, $divisiIds, 'inheren', $riskNames, $userLoginId);
    $assessmentChanges += gk_merge_assessment_kind($conn, $targetId, $divisiIds, 'kpmr', $riskNames, $userLoginId);
    $numericChanges = gk_numeric_compare_tables($conn, $targetId, $divisiIds);

    if (gk_table_exists($conn, 'nilai_profil')) {
        gk_run($conn, "DELETE FROM nilai_profil WHERE id_profil_risiko = '$targetId'", "RESET nilai_profil");
    }
    if (gk_table_exists($conn, 'peringkat_profil')) {
        gk_run($conn, "DELETE FROM peringkat_profil WHERE id_profil_risiko = '$targetId'", "RESET peringkat_profil");
    }

    return [
        'target_id' => $targetId,
        'source_id' => $sourceId,
        'divisi_count' => count($divisiIds),
        'assessment_changes' => $assessmentChanges,
        'numeric_changes' => $numericChanges,
    ];
}

function gk_generate_rekap_divisi($conn, $tahun, $periode, $keteranganTambahan, $lokasiSession, $userLoginId)
{
    $divisiRows = gk_divisi_profile_rows($conn, $tahun, $periode);
    if (empty($divisiRows)) {
        throw new Exception('Profil Risiko Divisi untuk tahun dan periode tersebut belum ada.');
    }

    $base = $divisiRows[0];
    $sourceId = (int)$base['id_profil_risiko'];
    $divisiIds = array_map(static function ($row) {
        return (int)$row['id_profil_risiko'];
    }, $divisiRows);

    $label = 'Profil Risiko Rekap Divisi';
    $ketFinal = trim('[GENERATE KONSOL] ' . $label . ($keteranganTambahan !== '' ? ' - ' . $keteranganTambahan : ''));
    $ketSql = mysqli_real_escape_string($conn, $ketFinal);
    $tanggal = date('Y-m-d');
    $kantorCabang = $lokasiSession > 0 ? (int)$lokasiSession : 0;

    gk_run(
        $conn,
        "INSERT INTO frame_laporan_profil_risiko
            (kantor_cabang, tahun, user, periode, modal_inti, total_aset, keterangan, dibuat_at, dibuat_by, data_pembanding, status_korwil, status_skmr, kunci_laporan)
         VALUES
            ('$kantorCabang', '" . (int)$tahun . "', '5', '" . (int)$periode . "', '" . (float)($base['modal_inti'] ?? 0) . "', '" . (float)($base['total_aset'] ?? 0) . "', '$ketSql', '$tanggal', '" . (int)$userLoginId . "', NULL, '0', '0', '0')",
        'INSERT frame_laporan_profil_risiko rekap divisi'
    );

    $targetId = (int)mysqli_insert_id($conn);
    gk_copy_profile_contents($conn, $sourceId, $targetId);

    $riskNames = [
        'RISIKO KREDIT',
        'RISIKO OPERASIONAL',
        'RISIKO KEPATUHAN',
        'RISIKO LIKUIDITAS',
        'RISIKO REPUTASI',
        'RISIKO STRATEJIK',
    ];

    $assessmentChanges = 0;
    $assessmentChanges += gk_merge_assessment_kind($conn, $targetId, $divisiIds, 'inheren', $riskNames, $userLoginId);
    $assessmentChanges += gk_merge_assessment_kind($conn, $targetId, $divisiIds, 'kpmr', $riskNames, $userLoginId);
    $numericChanges = gk_numeric_compare_tables($conn, $targetId, $divisiIds);

    if (gk_table_exists($conn, 'nilai_profil')) {
        gk_run($conn, "DELETE FROM nilai_profil WHERE id_profil_risiko = '$targetId'", "RESET nilai_profil");
    }
    if (gk_table_exists($conn, 'peringkat_profil')) {
        gk_run($conn, "DELETE FROM peringkat_profil WHERE id_profil_risiko = '$targetId'", "RESET peringkat_profil");
    }

    return [
        'target_id' => $targetId,
        'source_id' => $sourceId,
        'divisi_count' => count($divisiIds),
        'assessment_changes' => $assessmentChanges,
        'numeric_changes' => $numericChanges,
        'mode' => 'rekap_divisi',
    ];
}

$idAktif = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$lokasiSession = isset($_SESSION['lokasi_kerja']) ? (int)$_SESSION['lokasi_kerja'] : 0;
$userLoginId = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$notif = '';
$notifType = 'success';
$generatedInfo = null;
$activeTab = (isset($_GET['tab']) && $_GET['tab'] === 'rekap_divisi') ? 'rekap_divisi' : 'final';

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if (isset($_GET['hapus_generate'])) {
    $hapusId = (int)$_GET['hapus_generate'];
    $hapusTransactionStarted = false;
    try {
        if ($hapusId <= 0) {
            throw new Exception('Data generate tidak valid.');
        }

        $qHapus = simpro_db_query($conn, "SELECT id_profil_risiko, user FROM frame_laporan_profil_risiko WHERE id_profil_risiko = ? AND user IN (4, 5, 6) LIMIT 1", [$hapusId]);
        if (!$qHapus || mysqli_num_rows($qHapus) <= 0) {
            throw new Exception('Data generate tidak ditemukan atau bukan laporan konsol.');
        }

        mysqli_begin_transaction($conn);
        $hapusTransactionStarted = true;
        if (gk_table_exists($conn, 'assessment_inheren') && gk_table_exists($conn, 'assessment_inheren_detail')) {
            gk_run(
                $conn,
                "DELETE d FROM assessment_inheren_detail d
                 INNER JOIN assessment_inheren h ON d.id_assessment_inheren = h.id_assessment_inheren
                 WHERE h.id_profil_risiko = '$hapusId'",
                'HAPUS assessment_inheren_detail'
            );
        }
        if (gk_table_exists($conn, 'assessment_kpmr') && gk_table_exists($conn, 'assessment_kpmr_detail')) {
            gk_run(
                $conn,
                "DELETE d FROM assessment_kpmr_detail d
                 INNER JOIN assessment_kpmr h ON d.id_assessment_kpmr = h.id_assessment_kpmr
                 WHERE h.id_profil_risiko = '$hapusId'",
                'HAPUS assessment_kpmr_detail'
            );
        }
        $qTables = mysqli_query($conn, "SHOW TABLES");
        if ($qTables) {
            while ($tb = mysqli_fetch_row($qTables)) {
                $table = $tb[0];
                if ($table === 'frame_laporan_profil_risiko') {
                    continue;
                }
                if (gk_column_exists($conn, $table, 'id_profil_risiko')) {
                    gk_run($conn, "DELETE FROM " . gk_ident($table) . " WHERE id_profil_risiko = '$hapusId'", "HAPUS $table");
                }
            }
        }
        gk_run($conn, "DELETE FROM frame_laporan_profil_risiko WHERE id_profil_risiko = '$hapusId' AND user IN (4, 5, 6)", 'HAPUS frame_laporan_profil_risiko');
        mysqli_commit($conn);
        $hapusTransactionStarted = false;

        $notif = 'Data generate laporan konsol berhasil dihapus.';
        $notifType = 'success';
        if ($idAktif === $hapusId) {
            $idAktif = 0;
        }
    } catch (Exception $e) {
        if ($hapusTransactionStarted) {
            mysqli_rollback($conn);
        }
        $notif = $e->getMessage();
        $notifType = 'danger';
    }
}

if ($requestMethod === 'POST' && isset($_POST['generate_final'])) {
    $tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;
    $periode = isset($_POST['periode']) ? (int)$_POST['periode'] : 0;
    $jenisUser = isset($_POST['jenis_user']) ? (int)$_POST['jenis_user'] : 0;
    $keterangan = trim((string)($_POST['keterangan'] ?? ''));
    $transactionStarted = false;

    try {
        if ($tahun <= 0 || $periode < 1 || $periode > 4) {
            throw new Exception('Tahun dan periode wajib dipilih.');
        }
        if (!in_array($jenisUser, [4, 6], true)) {
            throw new Exception('Jenis profil risiko final wajib dipilih.');
        }
        if (!gk_year_has_setting($conn, $tahun)) {
            throw new Exception('Tahun ini belum memiliki setting opsi perumusan aktif.');
        }

        mysqli_begin_transaction($conn);
        $transactionStarted = true;
        $generatedInfo = gk_generate_final($conn, $tahun, $periode, $jenisUser, $keterangan, $lokasiSession, $userLoginId);
        mysqli_commit($conn);
        $transactionStarted = false;

        $idAktif = (int)$generatedInfo['target_id'];
        $notif = 'Generate final konsolidasi berhasil. Profil final ID #' . $idAktif . ' sudah dibuat.';
        if ($generatedInfo['divisi_count'] === 0) {
            $notif .= ' Belum ada profil risiko divisi, jadi data memakai Profil Risiko SKMR.';
        }
    } catch (Exception $e) {
        if ($transactionStarted) {
            mysqli_rollback($conn);
        }
        $notif = $e->getMessage();
        $notifType = 'danger';
    }
}

if ($requestMethod === 'POST' && isset($_POST['generate_rekap_divisi'])) {
    $tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;
    $periode = isset($_POST['periode']) ? (int)$_POST['periode'] : 0;
    $keterangan = trim((string)($_POST['keterangan'] ?? ''));
    $transactionStarted = false;
    $activeTab = 'rekap_divisi';

    try {
        if ($tahun <= 0 || $periode < 1 || $periode > 4) {
            throw new Exception('Tahun dan periode wajib dipilih.');
        }
        if (!gk_year_has_complete_setting_for_user($conn, $tahun, 5)) {
            throw new Exception('Tahun ini belum lengkap untuk Profil Risiko Rekap Divisi. Pastikan opsi perumusan aktif serta pilih parameter inheren dan KPMR sudah dibuat.');
        }

        mysqli_begin_transaction($conn);
        $transactionStarted = true;
        $generatedInfo = gk_generate_rekap_divisi($conn, $tahun, $periode, $keterangan, $lokasiSession, $userLoginId);
        mysqli_commit($conn);
        $transactionStarted = false;

        $idAktif = (int)$generatedInfo['target_id'];
        $notif = 'Generate laporan rekap divisi berhasil. Profil rekap divisi ID #' . $idAktif . ' sudah dibuat.';
    } catch (Exception $e) {
        if ($transactionStarted) {
            mysqli_rollback($conn);
        }
        $notif = $e->getMessage();
        $notifType = 'danger';
    }
}

$tahunOptions = [];
$qYears = mysqli_query($conn, "
    SELECT DISTINCT f.tahun
    FROM frame_laporan_profil_risiko f
    INNER JOIN frame_perumusan fp ON fp.tahun = f.tahun AND fp.is_aktif = 1
    WHERE f.user = 1
    ORDER BY f.tahun DESC
");
if ($qYears) {
    while ($row = mysqli_fetch_assoc($qYears)) {
        $tahunOptions[] = (int)$row['tahun'];
    }
}

$tahunRekapOptions = [];
$qYearsRekap = mysqli_query($conn, "
    SELECT DISTINCT f.tahun
    FROM frame_laporan_profil_risiko f
    WHERE f.user = 2
    ORDER BY f.tahun DESC
");
if ($qYearsRekap) {
    while ($row = mysqli_fetch_assoc($qYearsRekap)) {
        $tahun = (int)$row['tahun'];
        if (gk_year_has_complete_setting_for_user($conn, $tahun, 5)) {
            $tahunRekapOptions[] = $tahun;
        }
    }
}

$finalRows = [];
$qFinal = mysqli_query($conn, "
    SELECT f.*, u.tipe_user
    FROM frame_laporan_profil_risiko f
    INNER JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
    WHERE f.user IN (4, 6)
    ORDER BY f.id_profil_risiko DESC
");
if ($qFinal) {
    while ($row = mysqli_fetch_assoc($qFinal)) {
        $finalRows[] = $row;
    }
}

$rekapRows = [];
$qRekap = mysqli_query($conn, "
    SELECT f.*, u.tipe_user
    FROM frame_laporan_profil_risiko f
    INNER JOIN user_profil_risiko u ON f.user = u.id_user_profil_risiko
    WHERE f.user = 5
    ORDER BY f.id_profil_risiko DESC
");
if ($qRekap) {
    while ($row = mysqli_fetch_assoc($qRekap)) {
        $rekapRows[] = $row;
    }
}
?>

<style>
    .generate-final-tabs {
        display: flex;
        gap: 18px;
        border-bottom: 1px solid #e6e8f0;
        margin-top: 22px;
        margin-bottom: 24px;
    }
    .generate-final-tabs a {
        padding: 14px 22px;
        border-bottom: 2px solid transparent;
        color: #667085;
        font-weight: 700;
        text-decoration: none;
    }
    .generate-final-tabs a.active {
        border-bottom-color: #6b6ff6;
        color: #5d62c7;
    }
    .generate-action-link {
        color: #686cf6;
        font-weight: 600;
        margin-right: 6px;
    }
    .generate-action-link:hover {
        color: #454bd6;
        text-decoration: underline;
    }
    .generate-help {
        color: #6f7787;
        font-size: 13px;
        margin-top: 5px;
    }
    .generate-konsol-page .card {
        overflow: hidden;
    }
    .generate-konsol-page .table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .generate-konsol-page #basic-datatable-generate {
        min-width: 1450px;
    }
    .generate-konsol-page #basic-datatable-generate th:nth-child(2),
    .generate-konsol-page #basic-datatable-generate td.table-action {
        min-width: 360px;
        width: 360px;
        white-space: nowrap;
        vertical-align: middle;
    }
    .generate-konsol-page .gk-action-list {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: nowrap;
        white-space: nowrap;
        width: 100%;
        line-height: 1.2;
    }
    .generate-konsol-page .aksi-aktifkan-wrap {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
        color: #686cf6 !important;
        font-weight: 500;
    }
    .generate-konsol-page .aksi-aktifkan-wrap span {
        color: #686cf6 !important;
    }
    .generate-konsol-page .table-action a,
    .generate-konsol-page .table-action a:visited,
    .generate-konsol-page .table-action a:hover {
        color: #686cf6 !important;
        display: inline-flex;
        align-items: center;
        flex: 0 0 auto;
        text-decoration: none;
    }
    .generate-konsol-page .gk-action-separator {
        color: #98a2b3;
        flex: 0 0 auto;
    }
    .generate-konsol-page .table-action a:hover span {
        text-decoration: underline;
    }
    .generate-konsol-page .aksi-aktifkan-wrap input[type="checkbox"] {
        width: 13px;
        height: 13px;
        margin: 0;
        flex: 0 0 13px;
        accent-color: #b8beca;
    }
    .generate-konsol-page .gk-detail-toggle {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid #6ea8ff;
        background: #0d6efd;
        color: #fff;
        font-size: 14px;
        line-height: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        box-shadow: 0 1px 3px rgba(13,110,253,.25);
        cursor: pointer;
    }
    .generate-konsol-page .gk-detail-toggle.is-open {
        background: #ff6b8a;
        border-color: #ff6b8a;
    }
    .generate-konsol-page .generate-method-detail {
        padding: 12px 16px;
        max-width: 720px;
        line-height: 1.55;
    }
    .generate-konsol-page .generate-method-detail b {
        display: block;
        margin-bottom: 3px;
    }
    .generate-konsol-page .generate-method-detail span {
        color: #667085;
        font-size: 12px;
    }
    .generate-konsol-page .gk-step {
        display: block;
        margin-top: 2px;
        color: #475467 !important;
        font-size: 12px;
    }
    .gk-delete-modal .modal-content {
        border: 0;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 22px 60px rgba(15, 23, 42, .22);
    }
    .gk-delete-modal .modal-header {
        border-bottom: 1px solid #eef2f7;
        padding: 18px 20px;
    }
    .gk-delete-modal .modal-title {
        font-weight: 800;
        color: #111827;
    }
    .gk-delete-modal .delete-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffe4e6;
        color: #e11d48;
        font-size: 22px;
        margin-bottom: 12px;
    }
    .gk-delete-modal .delete-note {
        color: #667085;
        margin: 0;
        line-height: 1.6;
    }
    .gk-delete-modal .modal-footer {
        border-top: 1px solid #eef2f7;
        padding: 14px 20px;
    }
</style>

<div class="content-page generate-konsol-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Simpro</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Generate Laporan Konsol</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Generate Laporan Konsol</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Generate Laporan Konsol</h4>
                            <p class="text-muted font-14">Generate profil risiko final konsolidasi dari Profil Risiko SKMR dan usulan divisi pada tahun/periode yang sama.</p>

                            <?php if ($notif !== '') : ?>
                                <div class="alert alert-<?= gk_esc($notifType) ?>"><?= gk_esc($notif) ?></div>
                            <?php endif; ?>

                            <?php if ($generatedInfo) : ?>
                                <div class="alert alert-info">
                                    Sumber awal: #<?= (int)$generatedInfo['source_id'] ?>,
                                    divisi dibandingkan: <?= (int)$generatedInfo['divisi_count'] ?>,
                                    perubahan assessment: <?= (int)$generatedInfo['assessment_changes'] ?>,
                                    perubahan nilai isian: <?= (int)$generatedInfo['numeric_changes'] ?>.
                                    <a class="generate-action-link" href="index.php?page=nilpro&id=<?= (int)$generatedInfo['target_id'] ?>">Buka Profil Nilai</a>
                                </div>
                            <?php endif; ?>

                            <?php if ($activeTab === 'rekap_divisi') : ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateRekapDivisiModal">Generate Laporan</button>
                            <?php else : ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateFinalModal">Generate Laporan</button>
                            <?php endif; ?>

                            <div class="generate-final-tabs">
                                <a class="<?= $activeTab === 'final' ? 'active' : '' ?>" href="index.php?page=generate_konsol&tab=final">Generate Final Otomatis</a>
                                <a class="<?= $activeTab === 'rekap_divisi' ? 'active' : '' ?>" href="index.php?page=generate_konsol&tab=rekap_divisi">Laporan Rekap Divisi</a>
                            </div>

                            <?php
                            $displayRows = $activeTab === 'rekap_divisi' ? $rekapRows : $finalRows;
                            $emptyTableText = $activeTab === 'rekap_divisi' ? 'Belum ada data laporan rekap divisi.' : 'Belum ada data generate final konsol.';
                            ?>
                            <div class="table-responsive">
                                <table id="basic-datatable-generate" class="table nowrap w-100">
                                    <thead class="table-primary">
                                        <tr>
                                            <th><center>No</center></th>
                                            <th><center>Aksi</center></th>
                                            <th><center>Tgl Lock</center></th>
                                            <th><center>Kunci Laporan</center></th>
                                            <th><center>Kantor Cabang</center></th>
                                            <th><center>Tahun</center></th>
                                            <th><center>Jenis Profil Risiko</center></th>
                                            <th><center>Periode</center></th>
                                            <th><center>Modal Inti</center></th>
                                            <th><center>Total Aset</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($displayRows)) : ?>
                                            <?php $no = 1; foreach ($displayRows as $row) : ?>
                                                <?php
                                                $isAktif = ((int)$row['id_profil_risiko'] === $idAktif);
                                                $divisiGenerateLabels = gk_divisi_generate_labels($conn, (int)$row['tahun'], (int)$row['periode']);
                                                $jumlahDivisiPembanding = count($divisiGenerateLabels);
                                                $divisiText = $jumlahDivisiPembanding > 0 ? implode(', ', $divisiGenerateLabels) : 'Belum ada profil risiko divisi';
                                                if ((int)$row['user'] === 5) {
                                                    $sourceInfo = 'Profil Risiko Divisi ' . (int)$row['tahun'] . ' Triwulan ' . (int)$row['periode'];
                                                    $methodStep = 'Urutan: nilai terbesar antar divisi untuk parameter sama -> nilai dan keterangan dari divisi pemenang masuk ke Laporan Rekap Divisi. Parameter yang belum diisi tetap kosong.';
                                                } else {
                                                    $sourceForRow = gk_latest_skmr_profile($conn, (int)$row['tahun'], (int)$row['periode'], $lokasiSession);
                                                    $sourceInfo = $sourceForRow ? ('Profil Risiko SKMR ' . (int)$row['tahun'] . ' Triwulan ' . (int)$row['periode'] . ' #' . (int)$sourceForRow['id_profil_risiko']) : ('Profil Risiko SKMR ' . (int)$row['tahun'] . ' Triwulan ' . (int)$row['periode']);
                                                    $methodStep = 'Urutan: nilai terbesar antar divisi untuk parameter sama -> dibandingkan dengan SKMR -> nilai dan keterangan dari sumber pemenang masuk ke final.';
                                                }
                                                $detailHtml = '<div class="generate-method-detail">'
                                                    . '<b>Metode Generate: banding nilai terbesar</b>'
                                                    . 'Jenis laporan: ' . gk_esc($row['tipe_user']) . '<br>'
                                                    . 'Data awal: ' . gk_esc($sourceInfo) . '<br>'
                                                    . 'Pembanding: Profil Risiko Divisi ' . (int)$row['tahun'] . ' Triwulan ' . (int)$row['periode'] . ' (' . (int)$jumlahDivisiPembanding . ' divisi)<br>'
                                                    . '<span>' . gk_esc($divisiText) . '</span>'
                                                    . '<span class="gk-step">' . gk_esc($methodStep) . '</span>'
                                                    . '</div>';
                                                ?>
                                                <tr>
                                                    <td>
                                                        <center>
                                                            <button type="button" class="gk-detail-toggle" data-detail="<?= gk_esc($detailHtml) ?>">+</button>
                                                            <?= $no++ ?>
                                                        </center>
                                                    </td>
                                                    <td class="table-action">
                                                        <div class="gk-action-list">
                                                            <a href="index.php?page=generate_konsol&tab=<?= gk_esc($activeTab) ?>&id=<?= (int)$row['id_profil_risiko'] ?>">
                                                                <span class="aksi-aktifkan-wrap">
                                                                    <input type="checkbox" <?= $isAktif ? 'checked' : '' ?> disabled>
                                                                    <span>aktifkan</span>
                                                                </span>
                                                            </a>
                                                            <span class="gk-action-separator">|</span>
                                                            <a href="laporan/cetak_laporan_profil_risiko.php?id=<?= (int)$row['id_profil_risiko'] ?>" target="_blank">cetak pdf</a>
                                                            <span class="gk-action-separator">|</span>
                                                            <a href="javascript:void(0)"
                                                               class="gk-delete-link"
                                                               data-delete-url="index.php?page=generate_konsol&tab=<?= gk_esc($activeTab) ?>&id=<?= (int)$row['id_profil_risiko'] ?>&hapus_generate=<?= (int)$row['id_profil_risiko'] ?>"
                                                               data-delete-title="<?= gk_esc($row['tipe_user'] . ' ' . $row['tahun'] . ' Triwulan ' . (int)$row['periode']) ?>">
                                                                <i class="mdi mdi-delete"></i>hapus
                                                            </a>
                                                            <span class="gk-action-separator">|</span>
                                                            <a href="index.php?page=nilpro&id=<?= (int)$row['id_profil_risiko'] ?>">profil nilai</a>
                                                        </div>
                                                    </td>
                                                    <td><center><?= !empty($row['tgl_lock']) ? gk_esc($row['tgl_lock']) : 'Belum di-lock' ?></center></td>
                                                    <td><center>lock | unlock</center></td>
                                                    <td><center><?= (int)$row['user'] === 5 ? 'Rekap Divisi' : 'Kantor Pusat' ?></center></td>
                                                    <td><center><?= gk_esc($row['tahun']) ?></center></td>
                                                    <td><center><?= gk_esc($row['tipe_user']) ?></center></td>
                                                    <td><center>Triwulan <?= (int)$row['periode'] ?></center></td>
                                                    <td><center>Rp. <?= gk_rupiah($row['modal_inti']) ?></center></td>
                                                    <td><center>Rp. <?= gk_rupiah($row['total_aset']) ?></center></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="generateRekapDivisiModal" tabindex="-1" aria-labelledby="generateRekapDivisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateRekapDivisiModalLabel">GENERATE LAPORAN REKAP DIVISI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tahun</label>
                    <select name="tahun" class="form-control" required>
                        <option value="">- pilih tahun -</option>
                        <?php foreach ($tahunRekapOptions as $tahun) : ?>
                            <option value="<?= (int)$tahun ?>"><?= (int)$tahun ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="generate-help">Dropdown tahun hanya menampilkan tahun yang sudah punya opsi perumusan aktif serta pilih parameter inheren dan KPMR untuk Profil Risiko Rekap Divisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Profil Risiko</label>
                    <select name="jenis_user" class="form-control" required>
                        <option value="5">Profil Risiko Rekap Divisi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Periode</label>
                    <select name="periode" class="form-control" required>
                        <option value="">- pilih periode -</option>
                        <option value="1">Triwulan 1</option>
                        <option value="2">Triwulan 2</option>
                        <option value="3">Triwulan 3</option>
                        <option value="4">Triwulan 4</option>
                    </select>
                    <div class="generate-help">Laporan rekap divisi membandingkan seluruh Profil Risiko Divisi pada tahun/periode yang sama. Jika parameter sama dipakai lebih dari satu divisi, nilai terbesar dipilih dan keterangannya ikut dari divisi dengan nilai terbesar.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan</label>
                    <textarea name="keterangan" rows="4" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="generate_rekap_divisi" value="1" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var generateTable = null;
    if (window.jQuery && $.fn.DataTable && !$.fn.DataTable.isDataTable('#basic-datatable-generate')) {
        generateTable = $('#basic-datatable-generate').DataTable({
            pageLength: 10,
            scrollX: true,
            responsive: false,
            autoWidth: false,
            columnDefs: [
                { targets: 1, width: '360px', className: 'table-action' }
            ],
            language: {
                emptyTable: <?= json_encode($emptyTableText) ?>
            }
        });
    } else if (window.jQuery && $.fn.DataTable && $.fn.DataTable.isDataTable('#basic-datatable-generate')) {
        generateTable = $('#basic-datatable-generate').DataTable();
    }

    if (window.jQuery && generateTable) {
        $('#basic-datatable-generate tbody').on('click', '.gk-detail-toggle', function () {
            var button = $(this);
            var tr = button.closest('tr');
            var row = generateTable.row(tr);
            var detail = button.attr('data-detail') || '';

            if (row.child.isShown()) {
                row.child.hide();
                button.removeClass('is-open').text('+');
            } else {
                row.child(detail).show();
                button.addClass('is-open').text('-');
            }
        });

        $('#basic-datatable-generate tbody').on('click', '.gk-delete-link', function () {
            var link = $(this);
            var url = link.attr('data-delete-url') || '#';
            var title = link.attr('data-delete-title') || 'data generate laporan konsol ini';
            $('#gkDeleteTargetText').text(title);
            $('#gkDeleteConfirmBtn').attr('href', url);

            var el = document.getElementById('gkDeleteModal');
            if (window.bootstrap && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(el).show();
            } else if (window.$ && $('#gkDeleteModal').modal) {
                $('#gkDeleteModal').modal('show');
            }
        });
    }
});
</script>

<div class="modal fade gk-delete-modal" id="gkDeleteModal" tabindex="-1" aria-labelledby="gkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gkDeleteModalLabel">Hapus Generate Laporan Konsol?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 py-4">
                <div class="delete-icon">
                    <i class="mdi mdi-delete-outline"></i>
                </div>
                <h5 class="mb-2" id="gkDeleteTargetText">Data generate laporan konsol</h5>
                <p class="delete-note">
                    Data generate konsol beserta isian yang tersimpan untuk laporan ini akan dihapus. Tindakan ini tidak menghapus Profil Risiko SKMR sumber maupun profil risiko divisi.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-danger" id="gkDeleteConfirmBtn">Hapus</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="generateFinalModal" tabindex="-1" aria-labelledby="generateFinalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateFinalModalLabel">GENERATE LAPORAN KONSOL</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tahun</label>
                    <select name="tahun" class="form-control" required>
                        <option value="">- pilih tahun -</option>
                        <?php foreach ($tahunOptions as $tahun) : ?>
                            <option value="<?= (int)$tahun ?>"><?= (int)$tahun ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="generate-help">Dropdown tahun hanya menampilkan tahun yang punya Profil Risiko SKMR dan setting opsi perumusan aktif.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Jenis Profil Risiko</label>
                    <select name="jenis_user" class="form-control" required>
                        <option value="">- pilih jenis profil risiko -</option>
                        <option value="4">Final Konsolidasi / Perbaikan</option>
                        <option value="6">Final Konsolidasi Otomatis</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Periode</label>
                    <select name="periode" class="form-control" required>
                        <option value="">- pilih periode -</option>
                        <option value="1">Triwulan 1</option>
                        <option value="2">Triwulan 2</option>
                        <option value="3">Triwulan 3</option>
                        <option value="4">Triwulan 4</option>
                    </select>
                    <div class="generate-help">Profil final akan mengambil Profil Risiko SKMR pada tahun/periode ini, lalu dibandingkan dengan profil risiko divisi pada tahun/periode yang sama.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan</label>
                    <textarea name="keterangan" rows="4" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="generate_final" value="1" class="btn btn-primary">Generate</button>
            </div>
        </form>
    </div>
</div>
