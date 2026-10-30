<?php
require dirname(__DIR__, 2).'/conn/conn.php';
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function esc($str)
{
    return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8');
}

function rupiah_view($angka)
{
    return number_format((float)$angka, 0, ',', '.');
}

function column_exists_menu($conn, $table, $column)
{
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}

function table_exists_menu($conn, $table)
{
    $table = mysqli_real_escape_string($conn, $table);
    $q = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $q && mysqli_num_rows($q) > 0;
}

function sync_master_kredit_awal_menu($conn, $idProfilRisiko, $modalInti, $totalAset)
{
    $idProfilRisiko = (int)$idProfilRisiko;
    if ($idProfilRisiko <= 0) {
        return;
    }

    $modalInti = preg_replace('/[^0-9]/', '', (string)$modalInti);
    $totalAset = preg_replace('/[^0-9]/', '', (string)$totalAset);
    $modalIntiSql = mysqli_real_escape_string($conn, $modalInti === '' ? '0' : $modalInti);
    $totalAsetSql = mysqli_real_escape_string($conn, $totalAset === '' ? '0' : $totalAset);

    if (table_exists_menu($conn, 'master_kredit_pilar1') && column_exists_menu($conn, 'master_kredit_pilar1', 'total_aset')) {
        $cekP1 = simpro_db_query($conn, "SELECT id_profil_risiko FROM master_kredit_pilar1 WHERE id_profil_risiko = ? LIMIT 1", [$idProfilRisiko]);
        if ($cekP1 && mysqli_num_rows($cekP1) > 0) {
            mysqli_query($conn, "UPDATE master_kredit_pilar1 SET total_aset = '$totalAsetSql' WHERE id_profil_risiko = '$idProfilRisiko'");
        } elseif (column_exists_menu($conn, 'master_kredit_pilar1', 'id_profil_risiko')) {
            mysqli_query($conn, "INSERT INTO master_kredit_pilar1 (id_profil_risiko, total_aset) VALUES ('$idProfilRisiko', '$totalAsetSql')");
        }
    }

    if (table_exists_menu($conn, 'master_kredit_pilar2') && column_exists_menu($conn, 'master_kredit_pilar2', 'modal_inti')) {
        $cekP2 = simpro_db_query($conn, "SELECT id_profil_risiko FROM master_kredit_pilar2 WHERE id_profil_risiko = ? LIMIT 1", [$idProfilRisiko]);
        if ($cekP2 && mysqli_num_rows($cekP2) > 0) {
            mysqli_query($conn, "UPDATE master_kredit_pilar2 SET modal_inti = '$modalIntiSql' WHERE id_profil_risiko = '$idProfilRisiko'");
        } elseif (column_exists_menu($conn, 'master_kredit_pilar2', 'id_profil_risiko')) {
            mysqli_query($conn, "INSERT INTO master_kredit_pilar2 (id_profil_risiko, modal_inti) VALUES ('$idProfilRisiko', '$modalIntiSql')");
        }
    }
}

function ident_menu($name)
{
    return '`' . str_replace('`', '``', $name) . '`';
}

function get_columns_menu($conn, $table)
{
    $cols = [];
    $q = mysqli_query($conn, "SHOW COLUMNS FROM " . ident_menu($table));
    if ($q) {
        while ($row = mysqli_fetch_assoc($q)) {
            $cols[] = $row;
        }
    }
    return $cols;
}

function run_copy_query_menu($conn, $sql, $label)
{
    if (!mysqli_query($conn, $sql)) {
        throw new Exception($label . ': ' . mysqli_error($conn));
    }
}

function copy_profile_table_menu($conn, $table, $sourceId, $targetId)
{
    if (!column_exists_menu($conn, $table, 'id_profil_risiko')) {
        return;
    }

    $cols = get_columns_menu($conn, $table);
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

        $insertCols[] = ident_menu($field);
        $selectCols[] = ($field === 'id_profil_risiko') ? "'" . (int)$targetId . "'" : ident_menu($field);
    }

    if (empty($insertCols)) {
        return;
    }

    $tableIdent = ident_menu($table);
    run_copy_query_menu($conn, "DELETE FROM $tableIdent WHERE id_profil_risiko = '" . (int)$targetId . "'", "DELETE $table");
    run_copy_query_menu(
        $conn,
        "INSERT INTO $tableIdent (" . implode(',', $insertCols) . ")
         SELECT " . implode(',', $selectCols) . "
         FROM $tableIdent
         WHERE id_profil_risiko = '" . (int)$sourceId . "'",
        "COPY $table"
    );
}

function copy_assessment_bundle_menu($conn, $assessmentTable, $detailTable, $pkCol, $fkCol, $sourceId, $targetId)
{
    if (!table_exists_menu($conn, $assessmentTable) || !table_exists_menu($conn, $detailTable)) {
        return;
    }

    $assessmentIdent = ident_menu($assessmentTable);
    $detailIdent = ident_menu($detailTable);
    $pkIdent = ident_menu($pkCol);
    $fkIdent = ident_menu($fkCol);

    $qTarget = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$targetId . "'");
    if ($qTarget) {
        while ($target = mysqli_fetch_assoc($qTarget)) {
            run_copy_query_menu($conn, "DELETE FROM $detailIdent WHERE $fkIdent = '" . (int)$target['id_header'] . "'", "DELETE $detailTable");
        }
    }
    run_copy_query_menu($conn, "DELETE FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$targetId . "'", "DELETE $assessmentTable");

    $assessmentCols = get_columns_menu($conn, $assessmentTable);
    $detailCols = get_columns_menu($conn, $detailTable);
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
        $headerInsertCols[] = ident_menu($field);
        $headerSelectCols[] = ($field === 'id_profil_risiko') ? "'" . (int)$targetId . "'" : ident_menu($field);
    }

    $detailInsertCols = [];
    $detailSelectCols = [];
    foreach ($detailCols as $col) {
        $field = $col['Field'];
        $extra = strtolower((string)($col['Extra'] ?? ''));
        if (strpos($extra, 'auto_increment') !== false) {
            continue;
        }
        $detailInsertCols[] = ident_menu($field);
        $detailSelectCols[] = ($field === $fkCol) ? '__NEW_HEADER_ID__' : ident_menu($field);
    }

    $qSource = mysqli_query($conn, "SELECT $pkIdent AS id_header FROM $assessmentIdent WHERE id_profil_risiko = '" . (int)$sourceId . "' ORDER BY $pkIdent ASC");
    if (!$qSource) {
        throw new Exception("READ $assessmentTable: " . mysqli_error($conn));
    }

    while ($source = mysqli_fetch_assoc($qSource)) {
        $sourceHeaderId = (int)$source['id_header'];
        run_copy_query_menu(
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
            run_copy_query_menu(
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

function copy_profile_contents_menu($conn, $sourceId, $targetId)
{
    $sourceId = (int)$sourceId;
    $targetId = (int)$targetId;
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
        if (column_exists_menu($conn, $table, 'id_profil_risiko')) {
            copy_profile_table_menu($conn, $table, $sourceId, $targetId);
        }
    }

    copy_assessment_bundle_menu($conn, 'assessment_inheren', 'assessment_inheren_detail', 'id_assessment_inheren', 'id_assessment_inheren', $sourceId, $targetId);
    copy_assessment_bundle_menu($conn, 'assessment_kpmr', 'assessment_kpmr_detail', 'id_assessment_kpmr', 'id_assessment_kpmr', $sourceId, $targetId);
}

function get_divisi_label_menu($id)
{
    $opts = [
        132 => 'Divisi Pemasaran',
        133 => 'Divisi Operasional',
        134 => 'Divisi SDM',
        135 => 'Satker Kepatuhan',
        136 => 'Sekretaris Perusahaan',
        137 => 'Divisi Litbang',
        140 => 'Divisi Penyelesaian Kredit',
        143 => 'SKAI'
    ];
    $id = (int)$id;
    return isset($opts[$id]) ? $opts[$id] : '';
}

$idAktif         = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$notif           = '';
$notif_type      = 'success';
$lokasiSession   = isset($_SESSION['lokasi_kerja']) ? (int)$_SESSION['lokasi_kerja'] : 0;
$userLoginId     = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;
$selectedTahun   = isset($_POST['tahun']) ? trim((string)$_POST['tahun']) : '';
$selectedFrameId = isset($_POST['frame_perumusan_id']) ? (int)$_POST['frame_perumusan_id'] : 0;

/* =========================================================
   TAB AKTIF
   - Jika klik aktifkan dari tab Profil Risiko Cabang, URL dikasih ?tab=cabang
   - Saat reload, halaman tetap buka tab Profil Risiko Cabang
========================================================= */
$tabParam = $_GET['tab'] ?? '';
$tabAktif = in_array($tabParam, ['cabang', 'divisi'], true) ? $tabParam : 'konsol';

if (isset($_GET['copy']) && $_GET['copy'] === '1') {
    $notif = 'Copy isian profil risiko berhasil.';
    $notif_type = 'success';
}

/* =========================================================
   AMBIL OPSI TAHUN & JENIS PROFIL RISIKO
   SUMBER: FRAME PERUMUSAN + OPSI PERUMUSAN YANG SUDAH DIPILIH
========================================================= */
$profilRisikoByTahun = [];
$qProfilByTahun = mysqli_query($conn, "
    SELECT
        fp.id_frame_perumusan,
        fp.tahun,
        fp.user_id AS id_user_profil_risiko,
        fp.id_divisi_tetapan,
        upr.tipe_user
    FROM frame_perumusan fp
    INNER JOIN user_profil_risiko upr
        ON fp.user_id = upr.id_user_profil_risiko
    WHERE
        EXISTS (
            SELECT 1
            FROM perumusan_inheren pi
            WHERE pi.id_frame_perumusan = fp.id_frame_perumusan
              AND (pi.perskalaan = 1 OR pi.pembobotan = 1)
        )
        OR EXISTS (
            SELECT 1
            FROM perumusan_kpmr pk
            WHERE pk.id_frame_perumusan = fp.id_frame_perumusan
              AND (pk.perskalaan = 1 OR pk.pembobotan = 1)
        )
    ORDER BY CAST(fp.tahun AS UNSIGNED) DESC, upr.tipe_user ASC, fp.id_divisi_tetapan ASC, fp.id_frame_perumusan ASC
");

if ($qProfilByTahun) {
    while ($r = mysqli_fetch_assoc($qProfilByTahun)) {
        $th = (string)$r['tahun'];
        $frameId = (int)$r['id_frame_perumusan'];
        $text = trim((string)$r['tipe_user']);
        $divisiLabel = get_divisi_label_menu((int)$r['id_divisi_tetapan']);

        if ($divisiLabel !== '') {
            $text .= ' - ' . $divisiLabel;
        }

        if (!isset($profilRisikoByTahun[$th])) {
            $profilRisikoByTahun[$th] = [];
        }

        $profilRisikoByTahun[$th][$frameId] = [
            'frame_id' => $frameId,
            'user_id'  => (int)$r['id_user_profil_risiko'],
            'text'     => $text,
            'tipe_user'=> $r['tipe_user'],
            'divisi'   => $divisiLabel,
            'divisi_id'=> (int)$r['id_divisi_tetapan']
        ];
    }
}

$daftarTahun = array_keys($profilRisikoByTahun);
rsort($daftarTahun, SORT_NUMERIC);

/* =========================================================
   PROSES COPY ISIAN PROFIL RISIKO KONSOL
========================================================= */
if (isset($_POST['action']) && $_POST['action'] === 'copy_profil_konsol') {
    $targetId = isset($_POST['target_id']) ? (int)$_POST['target_id'] : 0;
    $sourceId = isset($_POST['source_id']) ? (int)$_POST['source_id'] : 0;

    if ($targetId <= 0 || $sourceId <= 0 || $targetId === $sourceId) {
        $notif = 'Pilih profil risiko sumber yang berbeda.';
        $notif_type = 'danger';
    } else {
        $qValid = simpro_db_query($conn, "
            SELECT id_profil_risiko, user
            FROM frame_laporan_profil_risiko
            WHERE id_profil_risiko IN (?, ?)
              AND user = '1'
        ", [$sourceId, $targetId]);

        if (!$qValid || mysqli_num_rows($qValid) !== 2) {
            $notif = 'Profil risiko sumber atau tujuan tidak valid.';
            $notif_type = 'danger';
        } else {
            try {
                mysqli_begin_transaction($conn);

                $frameCopyFields = [];
                foreach (['modal_inti', 'total_aset', 'keterangan', 'data_pembanding'] as $field) {
                    if (column_exists_menu($conn, 'frame_laporan_profil_risiko', $field)) {
                        $frameCopyFields[] = 'target.' . ident_menu($field) . ' = source.' . ident_menu($field);
                    }
                }

                if (!empty($frameCopyFields)) {
                    run_copy_query_menu(
                        $conn,
                        "UPDATE frame_laporan_profil_risiko target
                         INNER JOIN frame_laporan_profil_risiko source
                            ON source.id_profil_risiko = '$sourceId'
                         SET " . implode(', ', $frameCopyFields) . "
                         WHERE target.id_profil_risiko = '$targetId'
                           AND target.user = '1'",
                        'COPY frame profil risiko'
                    );
                }

                copy_profile_contents_menu($conn, $sourceId, $targetId);
                mysqli_commit($conn);

                header("Location: index.php?page=menulapawal&id=$targetId&copy=1#tab-profil-risiko-konsol");
                exit;
            } catch (Exception $e) {
                mysqli_rollback($conn);
                $notif = 'Gagal copy isian profil risiko: ' . $e->getMessage();
                $notif_type = 'danger';
            }
        }
    }
}

/* =========================================================
   PROSES SIMPAN LAPORAN BARU
========================================================= */
if (isset($_POST['submit'])) {
    $lokasi_kerja      = isset($_POST['lokasi_kerja']) ? (int)$_POST['lokasi_kerja'] : 0;
    $tahun             = trim($_POST['tahun'] ?? '');
    $frame_perumusan_id= isset($_POST['frame_perumusan_id']) ? (int)$_POST['frame_perumusan_id'] : 0;
    $periode           = isset($_POST['periode']) ? (int)$_POST['periode'] : 0;
    $modal_inti        = preg_replace('/[^0-9]/', '', $_POST['modal_inti'] ?? '0');
    $total_aset        = preg_replace('/[^0-9]/', '', $_POST['total_aset'] ?? '0');
    $keterangan        = mysqli_real_escape_string($conn, trim($_POST['keterangan'] ?? ''));

    $dibuat_at         = date('Y-m-d');
    $dibuat_by         = $userLoginId;

    $frameDipilih = null;
    if ($frame_perumusan_id > 0) {
        $qFrameDipilih = simpro_db_query($conn, "
            SELECT
                fp.id_frame_perumusan,
                fp.tahun,
                fp.user_id,
                fp.id_divisi_tetapan,
                upr.tipe_user
            FROM frame_perumusan fp
            INNER JOIN user_profil_risiko upr
                ON fp.user_id = upr.id_user_profil_risiko
            WHERE fp.id_frame_perumusan = ?
              AND (
                    EXISTS (
                        SELECT 1 FROM perumusan_inheren pi
                        WHERE pi.id_frame_perumusan = fp.id_frame_perumusan
                          AND (pi.perskalaan = 1 OR pi.pembobotan = 1)
                    )
                    OR EXISTS (
                        SELECT 1 FROM perumusan_kpmr pk
                        WHERE pk.id_frame_perumusan = fp.id_frame_perumusan
                          AND (pk.perskalaan = 1 OR pk.pembobotan = 1)
                    )
                  )
            LIMIT 1
        ", [$frame_perumusan_id]);
        if ($qFrameDipilih && mysqli_num_rows($qFrameDipilih) > 0) {
            $frameDipilih = mysqli_fetch_assoc($qFrameDipilih);
        }
    }
    if ($frameDipilih && (int)$frameDipilih['user_id'] === 2 && (int)($frameDipilih['id_divisi_tetapan'] ?? 0) > 0) {
        $lokasi_kerja = (int)$frameDipilih['id_divisi_tetapan'];
    }

    // Untuk Profil Risiko Divisi, Modal Inti dan Total Aset hanya dipakai oleh:
    // 132 = Divisi Pemasaran
    // 140 = Divisi Penyelesaian Kredit
    // Divisi lainnya otomatis disimpan 0 walaupun input dimanipulasi dari browser.
    if ($frameDipilih && (int)$frameDipilih['user_id'] === 2) {
        $divisiTetapan = (int)($frameDipilih['id_divisi_tetapan'] ?? 0);

        if (!in_array($divisiTetapan, [132, 140], true)) {
            $modal_inti = 0;
            $total_aset = 0;
        }
    }

    if ($tahun !== '' && empty($profilRisikoByTahun[$tahun])) {
        $notif = 'Gagal membuat laporan. Tahun ' . $tahun . ' belum memiliki setting Opsi Perumusan. Buat dulu di Settingan Rumus > Opsi perumusan.';
        $notif_type = 'danger';
    } elseif ($lokasi_kerja <= 0 || $tahun === '' || $frame_perumusan_id <= 0 || $periode <= 0) {
        $notif = 'Data belum lengkap.';
        $notif_type = 'danger';
    } elseif (!$frameDipilih) {
        $notif = 'Gagal membuat laporan. Jenis profil risiko belum tersedia pada setting Opsi Perumusan untuk tahun ' . $tahun . '.';
        $notif_type = 'danger';
    } elseif ((string)$frameDipilih['tahun'] !== (string)$tahun) {
        $notif = 'Tahun dan jenis profil risiko tidak sinkron. Silakan pilih ulang.';
        $notif_type = 'danger';
    } else {
        $user = (int)$frameDipilih['user_id'];

        $cekDuplikatSql = "
            SELECT id_profil_risiko
            FROM frame_laporan_profil_risiko
            WHERE kantor_cabang = '$lokasi_kerja'
              AND tahun = '$tahun'
              AND user = '$user'
              AND periode = '$periode'
        ";

        if (column_exists_menu($conn, 'frame_laporan_profil_risiko', 'id_frame_perumusan')) {
            $cekDuplikatSql .= " AND id_frame_perumusan = '$frame_perumusan_id'";
        }

        $cekDuplikatSql .= " LIMIT 1";
        $cekDuplikat = mysqli_query($conn, $cekDuplikatSql);

        if ($cekDuplikat && mysqli_num_rows($cekDuplikat) > 0) {
            $rowDup = mysqli_fetch_assoc($cekDuplikat);
            $redirectTab = ((int)$frameDipilih['user_id'] === 2) ? '&tab=divisi#tab-profil-risiko-divisi' : '';
            header("Location: index.php?page=menulapawal&id=" . $rowDup['id_profil_risiko'] . $redirectTab);
            exit;
        } else {
            if (column_exists_menu($conn, 'frame_laporan_profil_risiko', 'id_frame_perumusan')) {
                $insert = mysqli_query($conn, "
                    INSERT INTO frame_laporan_profil_risiko
                    (
                        kantor_cabang,
                        tahun,
                        user,
                        periode,
                        modal_inti,
                        total_aset,
                        keterangan,
                        dibuat_at,
                        dibuat_by,
                        id_frame_perumusan
                    )
                    VALUES
                    (
                        '$lokasi_kerja',
                        '$tahun',
                        '$user',
                        '$periode',
                        '" . ($modal_inti === '' ? 0 : $modal_inti) . "',
                        '" . ($total_aset === '' ? 0 : $total_aset) . "',
                        '$keterangan',
                        '$dibuat_at',
                        '$dibuat_by',
                        '$frame_perumusan_id'
                    )
                ");
            } else {
                $insert = mysqli_query($conn, "
                    INSERT INTO frame_laporan_profil_risiko
                    (
                        kantor_cabang,
                        tahun,
                        user,
                        periode,
                        modal_inti,
                        total_aset,
                        keterangan,
                        dibuat_at,
                        dibuat_by
                    )
                    VALUES
                    (
                        '$lokasi_kerja',
                        '$tahun',
                        '$user',
                        '$periode',
                        '" . ($modal_inti === '' ? 0 : $modal_inti) . "',
                        '" . ($total_aset === '' ? 0 : $total_aset) . "',
                        '$keterangan',
                        '$dibuat_at',
                        '$dibuat_by'
                    )
                ");
            }

            if ($insert) {
                $newId = mysqli_insert_id($conn);
                sync_master_kredit_awal_menu($conn, $newId, $modal_inti, $total_aset);
                $redirectTab = ((int)$frameDipilih['user_id'] === 2) ? '&tab=divisi#tab-profil-risiko-divisi' : '';
                header("Location: index.php?page=menulapawal&id=" . $newId . $redirectTab);
                exit;
            } else {
                $notif = 'Gagal menyimpan data: ' . mysqli_error($conn);
                $notif_type = 'danger';
            }
        }
    }
}

/* =========================================================
   DATA DROPDOWN
========================================================= */
$dataCabang = mysqli_query($conn, "SELECT * FROM jenis_cabang ORDER BY cabang ASC");
$dataCabangFilter = mysqli_query($conn, "SELECT id_cabang, cabang FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 28 ORDER BY id_cabang ASC");
$dataPeriode = mysqli_query($conn, "SELECT * FROM periode_laporan_profil_risiko ORDER BY id_periode ASC");

/* =========================================================
   DATA TABEL
========================================================= */
$queryList = simpro_db_query($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        jc.cabang,
        upr.tipe_user,
        u.nama
    FROM frame_laporan_profil_risiko f
    LEFT JOIN periode_laporan_profil_risiko p
        ON f.periode = p.id_periode
    LEFT JOIN jenis_cabang jc
        ON f.kantor_cabang = jc.id_cabang
    LEFT JOIN user_profil_risiko upr
        ON f.user = upr.id_user_profil_risiko
    LEFT JOIN user u
        ON f.dibuat_by = u.user_id
    WHERE f.kantor_cabang = ?
      AND f.user = '1'
    ORDER BY f.id_profil_risiko DESC
", [$lokasiSession]);

$queryListCabang = mysqli_query($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        jc.cabang,
        upr.tipe_user,
        u.nama,
        u.user_id
    FROM frame_laporan_profil_risiko f
    INNER JOIN periode_laporan_profil_risiko p
        ON f.periode = p.id_periode
    INNER JOIN jenis_cabang jc
        ON f.kantor_cabang = jc.id_cabang
    INNER JOIN user_profil_risiko upr
        ON f.user = upr.id_user_profil_risiko
    INNER JOIN user u
        ON f.dibuat_by = u.user_id
    WHERE f.user = '3'
      AND f.kantor_cabang BETWEEN 1 AND 28
    ORDER BY f.id_profil_risiko DESC
");

$queryListDivisi = mysqli_query($conn, "
    SELECT
        f.*,
        p.periode_laporan,
        upr.tipe_user,
        u.nama
    FROM frame_laporan_profil_risiko f
    INNER JOIN periode_laporan_profil_risiko p
        ON f.periode = p.id_periode
    INNER JOIN user_profil_risiko upr
        ON f.user = upr.id_user_profil_risiko
    INNER JOIN user u
        ON f.dibuat_by = u.user_id
    WHERE f.user = '2'
      AND f.kantor_cabang IN (132,133,134,135,136,137,140,143)
    ORDER BY f.id_profil_risiko DESC
");

$copySourceKonsolOptions = [];
$queryCopySourceKonsol = mysqli_query($conn, "
    SELECT
        f.id_profil_risiko,
        f.tahun,
        f.periode,
        p.periode_laporan,
        jc.cabang,
        upr.tipe_user
    FROM frame_laporan_profil_risiko f
    LEFT JOIN periode_laporan_profil_risiko p
        ON f.periode = p.id_periode
    LEFT JOIN jenis_cabang jc
        ON f.kantor_cabang = jc.id_cabang
    LEFT JOIN user_profil_risiko upr
        ON f.user = upr.id_user_profil_risiko
    WHERE f.user = '1'
    ORDER BY CAST(f.tahun AS UNSIGNED) DESC, f.periode DESC, f.id_profil_risiko DESC
");
if ($queryCopySourceKonsol) {
    while ($copyRow = mysqli_fetch_assoc($queryCopySourceKonsol)) {
        $copySourceKonsolOptions[] = $copyRow;
    }
}
?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Simpro</a></li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Buat laporan</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Menu Profil Risiko</h4>
                    </div>
                </div>
            </div>

            <?php if ($notif != '') { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-<?= esc($notif_type) ?> alert-dismissible fade show" role="alert">
                            <?= esc($notif) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tabel Riwayat Laporan yang Dibuat</h4>
                            <p class="text-muted font-14">
                                Tabel Laporan Profil Risiko yang Dibuat Oleh User
                            </p>

                            <button type="button" class="btn btn-primary" id="btnTambahLaporanKonsol" data-bs-toggle="modal" data-bs-target="#modalTambahLaporan">
                                Tambah Laporan
                            </button>

                            <div id="modalTambahLaporan" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="laporan-modal-head mt-2 mb-4">
                                                <div></div>
                                                <h4><b>PEMBUATAN LAPORAN BARU</b></h4>
                                                <button type="button" class="laporan-info-btn" id="btnAlurLaporanInfo" title="Alur pengisian setting laporan" aria-label="Alur pengisian setting laporan">
                                                    <i class="mdi mdi-information-outline"></i>
                                                </button>
                                            </div>
                                            <div class="laporan-info-pop" id="alurLaporanInfo" aria-hidden="true">
                                                <div class="laporan-info-card">
                                                    <div class="laporan-info-top">
                                                        <div>
                                                            <div class="laporan-info-eyebrow">Panduan singkat</div>
                                                            <h5>Alur sebelum membuat laporan profil risiko</h5>
                                                        </div>
                                                        <button type="button" class="laporan-info-close" id="btnCloseAlurLaporanInfo" aria-label="Tutup">
                                                            <i class="mdi mdi-close"></i>
                                                        </button>
                                                    </div>
                                                    <div class="laporan-flow">
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">1</span>
                                                            <div><b>Settingan Parameter</b><p>Pilih/siapkan parameter Inheren dan KPMR untuk tahun yang akan dibuat.</p></div>
                                                        </div>
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">2</span>
                                                            <div><b>Pilih Parameter Inheren & KPMR</b><p>Tentukan parameter aktif per jenis profil risiko agar tabel pengisian muncul lengkap.</p></div>
                                                        </div>
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">3</span>
                                                            <div><b>Opsi Perumusan</b><p>Buat frame perumusan berdasarkan tahun dan jenis profil risiko, lalu aktifkan setting yang dipakai.</p></div>
                                                        </div>
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">4</span>
                                                            <div><b>Bobot Faktor</b><p>Isi bobot/rumus faktor yang dipakai untuk perhitungan tiap risiko.</p></div>
                                                        </div>
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">5</span>
                                                            <div><b>Bobot Konsolidasi</b><p>Siapkan bobot konsolidasi tahunan untuk rekap profil risiko.</p></div>
                                                        </div>
                                                        <div class="laporan-flow-step">
                                                            <span class="laporan-flow-num">6</span>
                                                            <div><b>Ambang Batas</b><p>Pastikan ambang batas tahun laporan sudah tersedia agar peringkat dan nilai terbaca.</p></div>
                                                        </div>
                                                    </div>
                                                    <div class="laporan-menu-map">
                                                        <b>Lokasi menu setting:</b>
                                                        <span>Settingan Parameter</span>
                                                        <span>Settingan Rumus > Opsi perumusan</span>
                                                        <span>Settingan Rumus > Bobot faktor</span>
                                                        <span>Settingan Rumus > Bobot konsolidasi</span>
                                                        <span>Settingan Rumus > Ambang batas</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <form class="ps-3 pe-3" action="" method="POST">

                                                <div class="mb-3" style="pointer-events:none;">
                                                    <label for="lokasi_kerja" class="form-label" id="lokasiKerjaLabel">Kantor Cabang</label>
                                                    <select class="form-select" name="lokasi_kerja" id="lokasi_kerja" required>
                                                        <?php
                                                        if ($dataCabang) {
                                                            mysqli_data_seek($dataCabang, 0);
                                                            while ($cab = mysqli_fetch_assoc($dataCabang)) {
                                                        ?>
                                                                <option value="<?= $cab['id_cabang'] ?>" <?= ($cab['id_cabang'] == $lokasiSession ? 'selected' : '') ?>>
                                                                    <?= esc(ucwords($cab['cabang'])) ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php foreach ([132,133,134,135,136,137,140,143] as $divId) { ?>
                                                            <option value="<?= $divId ?>"><?= esc(get_divisi_label_menu($divId)) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tahun" class="form-label">Tahun</label>
                                                    <select class="form-select" name="tahun" id="tahun" required>
                                                        <option value="">- pilih tahun -</option>
                                                        <?php foreach ($daftarTahun as $th) { ?>
                                                            <option value="<?= esc($th) ?>" <?= ($selectedTahun === (string)$th ? 'selected' : '') ?>><?= esc($th) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <small class="text-muted">Dropdown tahun hanya menampilkan tahun yang sudah dibuat pada setting opsi perumusan.</small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="frame_perumusan_id" class="form-label">Jenis Profil Risiko</label>
                                                    <select class="form-select" name="frame_perumusan_id" id="frame_perumusan_id" required>
                                                        <option value="">- pilih jenis profil risiko -</option>
                                                    </select>
                                                    <div class="alert alert-danger py-2 px-3 mt-2 mb-0" id="framePerumusanWarning" style="display:none;">
                                                        Tahun ini belum punya setting Opsi Perumusan. Buat dulu di <b>Settingan Rumus &gt; Opsi perumusan</b>.
                                                    </div>
                                                    <small class="text-muted">
                                                        Dropdown ini otomatis menampilkan jenis profil risiko yang sudah disetting pada opsi perumusan sesuai tahun terpilih.
                                                    </small>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="periode" class="form-label">Periode</label>
                                                    <select class="form-select" name="periode" id="periode" required>
                                                        <option value="">- pilih periode -</option>
                                                        <?php
                                                        if ($dataPeriode) {
                                                            mysqli_data_seek($dataPeriode, 0);
                                                            while ($prd = mysqli_fetch_assoc($dataPeriode)) {
                                                        ?>
                                                                <option value="<?= $prd['id_periode'] ?>">
                                                                    <?= esc(ucwords($prd['periode_laporan'])) ?>
                                                                </option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3" id="wrap_modal_inti">
                                                    <label for="modal_inti" class="form-label">Modal Inti</label>
                                                    <input type="text" name="modal_inti" class="form-control uang" id="modal_inti" required>
                                                </div>

                                                <div class="mb-3" id="wrap_total_aset">
                                                    <label for="total_aset" class="form-label">Total Aset</label>
                                                    <input type="text" name="total_aset" class="form-control uang" id="total_aset" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                                                </div>

                                                <div class="mb-3 text-center">
                                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                                    <button type="button" class="btn btn-light ms-1" data-bs-dismiss="modal">Batal</button>
                                                </div>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="mt-3 mb-3">

                            <ul class="nav nav-tabs nav-bordered mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a href="#tab-profil-risiko-konsol"
                                       data-bs-toggle="tab"
                                       aria-expanded="<?= $tabAktif === 'konsol' ? 'true' : 'false' ?>"
                                       class="nav-link <?= $tabAktif === 'konsol' ? 'active' : '' ?>"
                                       role="tab">
                                        Profil Risiko Konsol
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab-profil-risiko-cabang"
                                       data-bs-toggle="tab"
                                       aria-expanded="<?= $tabAktif === 'cabang' ? 'true' : 'false' ?>"
                                       class="nav-link <?= $tabAktif === 'cabang' ? 'active' : '' ?>"
                                       role="tab">
                                        Profil Risiko Cabang
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a href="#tab-profil-risiko-divisi"
                                       data-bs-toggle="tab"
                                       aria-expanded="<?= $tabAktif === 'divisi' ? 'true' : 'false' ?>"
                                       class="nav-link <?= $tabAktif === 'divisi' ? 'active' : '' ?>"
                                       role="tab">
                                        Profil Risiko Divisi
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane <?= $tabAktif === 'konsol' ? 'show active' : '' ?>" id="tab-profil-risiko-konsol" role="tabpanel">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th><center>No</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Tgl Lock</center></th>
                                                <th><center>Kunci Laporan</center></th>
                                                <th><center>Kantor Cabang</center></th>
                                                <th><center>Tahun</center></th>
                                                <th><center>Jenis Profil Risiko</center></th>
                                                <th><center>Periode</center></th>
                                                <th><center>Modal Inti</center></th>
                                                <th><center>Total Aset</center></th>
                                                <th><center>Tanggal Dibuat</center></th>
                                                <th><center>Pembuat</center></th>
                                                <th><center>Keterangan</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            if ($queryList && mysqli_num_rows($queryList) > 0) {
                                                while ($row = mysqli_fetch_assoc($queryList)) {
                                                    $isAktif = ($row['id_profil_risiko'] == $idAktif);
                                            ?>
                                                    <tr>
                                                        <td><center><?= $no++ ?></center></td>
                                                        <td class="table-action">
                                                            <center>
                                                                <a href="index.php?page=menulapawal&id=<?= $row['id_profil_risiko'] ?>">
                                                                    <span class="aksi-aktifkan-wrap">
                                                                        <input type="checkbox" <?= $isAktif ? 'checked' : '' ?> disabled>
                                                                        <span>aktifkan</span>
                                                                    </span>
                                                                </a>
                                                                |
                                                                <a href="javascript:void(0)" onclick="openCetakProfilModal(<?= (int)$row['id_profil_risiko'] ?>)">cetak pdf</a>
                                                                |
                                                                <a href="javascript:void(0)"
                                                                   class="js-delete-profil"
                                                                   data-delete-url="index.php?page=delete_frame&id=<?= (int)$row['id_profil_risiko'] ?>"
                                                                   data-delete-title="<?= esc($row['tipe_user'] . ' ' . $row['tahun'] . ' ' . ucwords($row['periode_laporan'])) ?>">
                                                                    <i class="mdi mdi-delete"></i>hapus
                                                                </a>
                                                            </center>
                                                        </td>
                                                        <td class="table-action">
                                                            <center>
                                                                <?php
                                                                $copyTargetId = (int)$row['id_profil_risiko'];
                                                                $hasCopySource = false;
                                                                foreach ($copySourceKonsolOptions as $copyOptCheck) {
                                                                    if ((int)$copyOptCheck['id_profil_risiko'] !== $copyTargetId) {
                                                                        $hasCopySource = true;
                                                                        break;
                                                                    }
                                                                }
                                                                ?>
                                                                <?php if ($hasCopySource) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#modalCopyProfil<?= $copyTargetId ?>">copy</a>
                                                                <?php } else { ?>
                                                                    <span class="text-muted">copy</span>
                                                                <?php } ?>
                                                            </center>

                                                            <div id="modalCopyProfil<?= $copyTargetId ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content" style="white-space: normal;">
                                                                        <form method="POST">
                                                                            <input type="hidden" name="action" value="copy_profil_konsol">
                                                                            <input type="hidden" name="target_id" value="<?= $copyTargetId ?>">
                                                                            <div class="modal-header border-0 pb-0">
                                                                                <div>
                                                                                    <h5 class="modal-title mb-1">Copy Isian Profil Risiko</h5>
                                                                                    <div class="text-muted small">Salin seluruh isian dari profil risiko lain ke laporan ini.</div>
                                                                                </div>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="copy-warning-box mb-3">
                                                                                    <div class="copy-warning-icon">
                                                                                        <i class="mdi mdi-alert-outline"></i>
                                                                                    </div>
                                                                                    <div>
                                                                                        <b>Data tujuan akan ditimpa.</b>
                                                                                        <p class="mb-0">Seluruh isian profil risiko, termasuk master data kredit dan likuiditas, akan diganti mengikuti profil risiko sumber.</p>
                                                                                    </div>
                                                                                </div>
                                                                                <label class="form-label">Pilih Profil Risiko Konsol Sumber</label>
                                                                                <select name="source_id" class="form-select" required>
                                                                                    <option value="">-- pilih profil risiko --</option>
                                                                                    <?php foreach ($copySourceKonsolOptions as $copyOpt) {
                                                                                        $copySourceId = (int)$copyOpt['id_profil_risiko'];
                                                                                        if ($copySourceId === $copyTargetId) {
                                                                                            continue;
                                                                                        }
                                                                                        $labelCopy = '#' . $copySourceId
                                                                                            . ' - ' . ($copyOpt['tahun'] ?? '')
                                                                                            . ' - ' . ($copyOpt['tipe_user'] ?? '')
                                                                                            . ' - ' . ucwords($copyOpt['periode_laporan'] ?? '')
                                                                                            . ' - ' . ($copyOpt['cabang'] ?? 'Kantor Pusat');
                                                                                    ?>
                                                                                        <option value="<?= $copySourceId ?>"><?= esc($labelCopy) ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <?php
                                                                if (!isset($row['tgl_lock']) || is_null($row['tgl_lock']) || $row['tgl_lock'] == '0000-00-00' || $row['tgl_lock'] == '') {
                                                                    echo 'Belum di-lock';
                                                                } else {
                                                                    echo esc($row['tgl_lock']);
                                                                }
                                                                ?>
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <a href="index.php?page=lock_lap&id=<?= $row['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin lock data?');">lock</a>
                                                                |
                                                                <a href="index.php?page=unlock_lap&id=<?= $row['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin unlock data?');">unlock</a>
                                                            </center>
                                                        </td>
                                                        <td><center><?= esc($row['cabang']) ?></center></td>
                                                        <td><center><?= esc($row['tahun']) ?></center></td>
                                                        <td><center><?= esc($row['tipe_user']) ?></center></td>
                                                        <td><center><?= esc(ucwords($row['periode_laporan'])) ?></center></td>
                                                        <td>Rp. <?= rupiah_view($row['modal_inti']) ?></td>
                                                        <td>Rp. <?= rupiah_view($row['total_aset']) ?></td>
                                                        <td><center><?= esc($row['dibuat_at']) ?></center></td>
                                                        <td><center><?= esc($row['nama']) ?></center></td>
                                                        <td><?= esc($row['keterangan']) ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="tab-pane <?= $tabAktif === 'cabang' ? 'show active' : '' ?>" id="tab-profil-risiko-cabang" role="tabpanel">
                                    <div class="row g-2 mb-3" id="filterProfilCabang">
                                        <div class="col-md-4">
                                            <label for="filterCabangTahun" class="form-label">Tahun</label>
                                            <select class="form-select" id="filterCabangTahun">
                                                <option value="">Semua Tahun</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterCabangPeriode" class="form-label">Periode Laporan</label>
                                            <select class="form-select" id="filterCabangPeriode">
                                                <option value="">Semua Periode</option>
                                                <option value="Triwulan 1">Triwulan 1</option>
                                                <option value="Triwulan 2">Triwulan 2</option>
                                                <option value="Triwulan 3">Triwulan 3</option>
                                                <option value="Triwulan 4">Triwulan 4</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="filterCabangNama" class="form-label">Nama Cabang</label>
                                            <select class="form-select" id="filterCabangNama">
                                                <option value="">Semua Cabang</option>
                                                <?php
                                                if ($dataCabangFilter) {
                                                    while ($cabFilter = mysqli_fetch_assoc($dataCabangFilter)) {
                                                ?>
                                                        <option value="<?= esc($cabFilter['cabang']) ?>"><?= esc(ucwords($cabFilter['cabang'])) ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <table id="basic-datatable-cabang" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th><center>No</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Tgl Lock</center></th>
                                                <th><center>Status Korwil</center></th>
                                                <th><center>Nama Cabang</center></th>
                                                <th><center>Tahun</center></th>
                                                <th><center>Jenis Profil Risiko</center></th>
                                                <th><center>Periode</center></th>
                                                <th><center>Modal Inti</center></th>
                                                <th><center>Total Aset</center></th>
                                                <th><center>Tanggal Dibuat</center></th>
                                                <th><center>Pembuat</center></th>
                                                <th><center>Keterangan</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $noCabang = 1;
                                            if ($queryListCabang && mysqli_num_rows($queryListCabang) > 0) {
                                                while ($data = mysqli_fetch_assoc($queryListCabang)) {
                                                    if ($data['user_id'] == 132) {
                                                        $urlCabang = '../admin/laporan/cetak_pemasaran.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 142) {
                                                        $urlCabang = '../admin/laporan/cetak_dpk.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 135) {
                                                        $urlCabang = '../admin/laporan/cetak_kepatuhan.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 133) {
                                                        $urlCabang = '../admin/laporan/cetak_operasional.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 136) {
                                                        $urlCabang = '../admin/laporan/cetak_sekper.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 134) {
                                                        $urlCabang = '../admin/laporan/cetak_sdm.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 137) {
                                                        $urlCabang = '../admin/laporan/cetak_litbang.php?id=' . $data['id_profil_risiko'];
                                                    } else if ($data['user_id'] == 143) {
                                                        $urlCabang = '../admin/laporan/cetak_skai.php?id=' . $data['id_profil_risiko'];
                                                    } else {
                                                        $urlCabang = 'index.php?page=menulapawal';
                                                    }
                                            ?>
                                                    <tr>
                                                        <td><center><?= $noCabang++ ?></center></td>
                                                        <td class="table-action">
                                                            <center>
                                                                <a href="index.php?page=menulapawal&id=<?= $data['id_profil_risiko'] ?>&tab=cabang#tab-profil-risiko-cabang">
                                                                    <span class="aksi-aktifkan-wrap">
                                                                        <input type="checkbox" <?= ($data['id_profil_risiko'] == $idAktif ? 'checked' : '') ?> disabled>
                                                                        <span>aktifkan</span>
                                                                    </span>
                                                                </a>
                                                                |
                                                                <a href="index.php?page=konfirm&id=<?= $data['id_profil_risiko'] ?>" onclick="return confirm('Yakin laporan cabang sudah benar?');">
                                                                    <span class="aksi-aktifkan-wrap">
                                                                        <input type="checkbox" <?= ((int)($data['status_skmr'] ?? 0) === 1 ? 'checked' : '') ?> disabled>
                                                                        <span>konfirmasi</span>
                                                                    </span>
                                                                </a>
                                                                |
                                                                <a href="javascript:void(0)" onclick="openCetakProfilModal(<?= (int)$data['id_profil_risiko'] ?>)">cetak</a>
                                                                |
                                                                <a href="javascript:void(0)" onclick="openCetakProfilModal(<?= (int)$data['id_profil_risiko'] ?>, 'tindak_lanjut')">cetak tindak lanjut</a>
                                                                |
                                                                <a href="javascript:void(0)"
                                                                   class="js-delete-profil"
                                                                   data-delete-url="index.php?page=hps_div&id=<?= (int)$data['id_profil_risiko'] ?>"
                                                                   data-delete-title="<?= esc($data['tipe_user'] . ' ' . $data['tahun'] . ' ' . ucwords($data['periode_laporan'])) ?>"><i class="mdi mdi-delete"></i>hapus</a>
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <?php
                                                                if (!isset($data['tgl_lock']) || is_null($data['tgl_lock']) || $data['tgl_lock'] == '0000-00-00' || $data['tgl_lock'] == '') {
                                                                    echo 'Belum di-lock';
                                                                } else {
                                                                    echo esc($data['tgl_lock']);
                                                                }
                                                                ?>
                                                            </center>
                                                        </td>
                                                        <td>
                                                            <center>
                                                                <input type="checkbox" <?= ((int)($data['status_korwil'] ?? 0) === 1 ? 'checked' : '') ?> disabled>
                                                            </center>
                                                        </td>
                                                        <td><center><?= esc($data['cabang']) ?></center></td>
                                                        <td><center><?= esc($data['tahun']) ?></center></td>
                                                        <td><center><?= esc($data['tipe_user']) ?></center></td>
                                                        <td><center><?= esc(ucwords($data['periode_laporan'])) ?></center></td>
                                                        <td>
                                                            <?php
                                                            $modalIntiCabang = $data['modal_inti'];
                                                            echo ($modalIntiCabang == 0 || $modalIntiCabang === null) ? '(Tidak Perlu Mengisi)' : 'Rp.' . rupiah($modalIntiCabang);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $totalAsetCabang = $data['total_aset'];
                                                            echo ($totalAsetCabang == 0 || $totalAsetCabang === null) ? '(Tidak Perlu Mengisi)' : 'Rp.' . rupiah($totalAsetCabang);
                                                            ?>
                                                        </td>
                                                        <td><center><?= esc(ucwords($data['dibuat_at'])) ?></center></td>
                                                        <td><center><?= esc(ucwords($data['nama'])) ?></center></td>
                                                        <td><?= esc(ucwords($data['keterangan'])) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="13"><center>Tidak ada data laporan cabang.</center></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane <?= $tabAktif === 'divisi' ? 'show active' : '' ?>" id="tab-profil-risiko-divisi" role="tabpanel">
                                    <table id="basic-datatable-divisi" class="table dt-responsive nowrap w-100">
                                        <thead class="table-primary">
                                            <tr>
                                                <th><center>No</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Tgl Lock</center></th>
                                                <th><center>Kunci Laporan</center></th>
                                                <th><center>Divisi / Satker</center></th>
                                                <th><center>Tahun</center></th>
                                                <th><center>Jenis Profil Risiko</center></th>
                                                <th><center>Periode</center></th>
                                                <th><center>Modal Inti</center></th>
                                                <th><center>Total Aset</center></th>
                                                <th><center>Tanggal Dibuat</center></th>
                                                <th><center>Pembuat</center></th>
                                                <th><center>Keterangan</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $noDivisi = 1;
                                            if ($queryListDivisi && mysqli_num_rows($queryListDivisi) > 0) {
                                                while ($dv = mysqli_fetch_assoc($queryListDivisi)) {
                                                    $isAktifDivisi = ($dv['id_profil_risiko'] == $idAktif);
                                                    $divisiLabel = get_divisi_label_menu((int)$dv['kantor_cabang']);
                                            ?>
                                                    <tr>
                                                        <td><center><?= $noDivisi++ ?></center></td>
                                                        <td class="table-action">
                                                            <center>
                                                                <a href="index.php?page=menulapawal&id=<?= $dv['id_profil_risiko'] ?>&tab=divisi#tab-profil-risiko-divisi">
                                                                    <span class="aksi-aktifkan-wrap">
                                                                        <input type="checkbox" <?= $isAktifDivisi ? 'checked' : '' ?> disabled>
                                                                        <span>aktifkan</span>
                                                                    </span>
                                                                </a>
                                                                |
                                                                <a href="javascript:void(0)" onclick="openCetakProfilModal(<?= (int)$dv['id_profil_risiko'] ?>)">cetak pdf</a>
                                                                |
                                                                <a href="javascript:void(0)"
                                                                   class="js-delete-profil"
                                                                   data-delete-url="index.php?page=delete_frame&id=<?= (int)$dv['id_profil_risiko'] ?>"
                                                                   data-delete-title="<?= esc($dv['tipe_user'] . ' - ' . $divisiLabel . ' ' . $dv['tahun'] . ' ' . ucwords($dv['periode_laporan'])) ?>">
                                                                    <i class="mdi mdi-delete"></i>hapus
                                                                </a>
                                                            </center>
                                                        </td>
                                                        <td><center><?= (!isset($dv['tgl_lock']) || is_null($dv['tgl_lock']) || $dv['tgl_lock'] == '0000-00-00' || $dv['tgl_lock'] == '') ? 'Belum di-lock' : esc($dv['tgl_lock']) ?></center></td>
                                                        <td>
                                                            <center>
                                                                <a href="index.php?page=lock_lap&id=<?= $dv['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin lock data?');">lock</a>
                                                                |
                                                                <a href="index.php?page=unlock_lap&id=<?= $dv['id_profil_risiko'] ?>" onclick="return confirm('Yakin ingin unlock data?');">unlock</a>
                                                            </center>
                                                        </td>
                                                        <td><center><?= esc($divisiLabel !== '' ? $divisiLabel : $dv['kantor_cabang']) ?></center></td>
                                                        <td><center><?= esc($dv['tahun']) ?></center></td>
                                                        <td><center><?= esc($dv['tipe_user']) ?></center></td>
                                                        <td><center><?= esc(ucwords($dv['periode_laporan'])) ?></center></td>
                                                        <td>Rp. <?= rupiah_view($dv['modal_inti']) ?></td>
                                                        <td>Rp. <?= rupiah_view($dv['total_aset']) ?></td>
                                                        <td><center><?= esc($dv['dibuat_at']) ?></center></td>
                                                        <td><center><?= esc($dv['nama']) ?></center></td>
                                                        <td><?= esc($dv['keterangan']) ?></td>
                                                    </tr>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="13"><center>Tidak ada data laporan divisi.</center></td>
                                                </tr>
                                            <?php } ?>
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var tableCabang = null;
    if (window.jQuery && $.fn.DataTable && !$.fn.DataTable.isDataTable('#basic-datatable-cabang')) {
        tableCabang = $('#basic-datatable-cabang').DataTable({
            responsive: true
        });
    } else if (window.jQuery && $.fn.DataTable && $.fn.DataTable.isDataTable('#basic-datatable-cabang')) {
        tableCabang = $('#basic-datatable-cabang').DataTable();
    }
    if (window.jQuery && $.fn.DataTable && !$.fn.DataTable.isDataTable('#basic-datatable-divisi')) {
        $('#basic-datatable-divisi').DataTable({
            responsive: true
        });
    }

    var btnTambahLaporan = document.getElementById('btnTambahLaporanKonsol');
    function syncTambahLaporanButton(activeTarget) {
        if (!btnTambahLaporan) return;
        btnTambahLaporan.style.display = activeTarget === '#tab-profil-risiko-cabang' ? 'none' : '';
    }

    function escapeRegex(value) {
        return String(value || '').replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function addUniqueOption(selectEl, value) {
        value = String(value || '').trim();
        if (!selectEl || value === '') return;
        for (var i = 0; i < selectEl.options.length; i++) {
            if (selectEl.options[i].value === value) return;
        }
        var opt = document.createElement('option');
        opt.value = value;
        opt.textContent = value;
        selectEl.appendChild(opt);
    }

    function sortSelectOptions(selectEl) {
        if (!selectEl) return;
        var first = selectEl.options[0];
        var opts = Array.prototype.slice.call(selectEl.options, 1);
        opts.sort(function(a, b){
            return a.text.localeCompare(b.text, undefined, {numeric:true, sensitivity:'base'});
        });
        selectEl.innerHTML = '';
        selectEl.appendChild(first);
        opts.forEach(function(opt){ selectEl.appendChild(opt); });
    }

    var filterTahun = document.getElementById('filterCabangTahun');
    var filterPeriode = document.getElementById('filterCabangPeriode');
    var filterCabang = document.getElementById('filterCabangNama');

    if (tableCabang) {
        tableCabang.rows().every(function(){
            var node = this.node();
            var cells = node ? node.querySelectorAll('td') : [];
            addUniqueOption(filterTahun, cells[5] ? cells[5].textContent : '');
        });
        sortSelectOptions(filterTahun);

        function applyCabangFilters() {
            tableCabang.column(4).search(filterCabang && filterCabang.value ? '^' + escapeRegex(filterCabang.value) + '$' : '', true, false);
            tableCabang.column(5).search(filterTahun && filterTahun.value ? '^' + escapeRegex(filterTahun.value) + '$' : '', true, false);
            tableCabang.column(7).search(filterPeriode && filterPeriode.value ? '^' + escapeRegex(filterPeriode.value) + '$' : '', true, false);
            tableCabang.draw();
        }

        [filterCabang, filterTahun, filterPeriode].forEach(function(el){
            if (el) el.addEventListener('change', applyCabangFilters);
        });
    }

    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab){
        tab.addEventListener('shown.bs.tab', function(){
            syncTambahLaporanButton(this.getAttribute('href'));
            if (window.jQuery && $.fn.DataTable) {
                $.fn.dataTable.tables({visible: true, api: true}).columns.adjust().responsive.recalc();
            }
        });
    });

    var activeTab = document.querySelector('a[data-bs-toggle="tab"].active');
    syncTambahLaporanButton(activeTab ? activeTab.getAttribute('href') : '#tab-profil-risiko-konsol');

    var params = window.simproRouteParams ? window.simproRouteParams() : new URLSearchParams(window.location.search);
    var tabFromUrl = params.get('tab');

    if (tabFromUrl === 'cabang' || tabFromUrl === 'divisi' || window.location.hash === '#tab-profil-risiko-cabang' || window.location.hash === '#tab-profil-risiko-divisi') {
        var targetHref = (tabFromUrl === 'divisi' || window.location.hash === '#tab-profil-risiko-divisi') ? '#tab-profil-risiko-divisi' : '#tab-profil-risiko-cabang';
        var tabCabang = document.querySelector('a[href="' + targetHref + '"]');

        if (tabCabang) {
            if (window.bootstrap && bootstrap.Tab) {
                bootstrap.Tab.getOrCreateInstance(tabCabang).show();
            } else {
                tabCabang.click();
            }

            syncTambahLaporanButton(targetHref);

            setTimeout(function(){
                if (window.jQuery && $.fn.DataTable) {
                    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust().responsive.recalc();
                }
            }, 250);
        }
    }
});
</script>

<style>
.delete-profil-modal .modal-content{
    border:0;
    border-radius:14px;
    overflow:hidden;
    box-shadow:0 24px 70px rgba(15,23,42,.24);
}
.delete-profil-modal .modal-header{
    border-bottom:1px solid #eef2f7;
    padding:18px 20px;
}
.delete-profil-modal .modal-title{
    font-weight:800;
    color:#111827;
}
.delete-profil-modal .delete-icon{
    width:46px;
    height:46px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#ffe4e6;
    color:#e11d48;
    font-size:24px;
    margin-bottom:12px;
}
.delete-profil-modal .delete-target{
    font-weight:800;
    color:#111827;
    margin-bottom:8px;
}
.delete-profil-modal .delete-note{
    color:#667085;
    line-height:1.6;
    margin:0;
}
.delete-profil-modal .modal-footer{
    border-top:1px solid #eef2f7;
    padding:14px 20px;
}
</style>

<div class="modal fade delete-profil-modal" id="deleteProfilModal" tabindex="-1" aria-labelledby="deleteProfilModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProfilModalLabel">Hapus Laporan Profil Risiko?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center px-4 py-4">
                <div class="delete-icon">
                    <i class="mdi mdi-delete-outline"></i>
                </div>
                <h5 class="delete-target" id="deleteProfilTargetText">Data laporan profil risiko</h5>
                <p class="delete-note">
                    Data laporan beserta isian yang tersimpan untuk profil risiko ini akan dihapus. Tindakan ini tidak bisa dibatalkan.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-danger" id="deleteProfilConfirmBtn">Hapus</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.addEventListener('click', function (event) {
        var link = event.target.closest ? event.target.closest('.js-delete-profil') : null;
        if (!link) return;

        event.preventDefault();
        var url = link.getAttribute('data-delete-url') || '#';
        var title = link.getAttribute('data-delete-title') || 'Data laporan profil risiko';
        var targetText = document.getElementById('deleteProfilTargetText');
        var confirmBtn = document.getElementById('deleteProfilConfirmBtn');
        var modalEl = document.getElementById('deleteProfilModal');

        if (targetText) targetText.textContent = title;
        if (confirmBtn) confirmBtn.setAttribute('href', url);

        if (modalEl && window.bootstrap && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else if (window.jQuery && $('#deleteProfilModal').modal) {
            $('#deleteProfilModal').modal('show');
        } else if (url !== '#') {
            window.location.href = url;
        }
    });
});
</script>

<!-- MODAL CETAK LAPORAN PROFIL RISIKO -->
<div class="modal fade" id="modalCetakProfilRisiko" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog cetak-profil-modal-dialog">
        <div class="modal-content cetak-profil-modal-content">
            <div class="modal-header cetak-profil-modal-header">
                <div class="ms-auto d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-success btn-lg btn-cetak-modal-excel" onclick="exportCetakProfilExcel()">
                        <i class="mdi mdi-file-excel"></i> Cetak Excel
                    </button>
                    <button type="button" class="btn btn-light btn-lg btn-cetak-modal-close" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
            <div class="modal-body p-0 cetak-profil-modal-body">
                <div id="loadingCetakProfilRisiko" class="cetak-profil-loading">
                    <div class="cetak-loader-spinner" aria-hidden="true"></div>
                    <div class="cetak-loader-title">Loading...</div>
                    <div id="loadingCetakProfilRisikoText" class="cetak-loader-subtitle">Menyiapkan preview laporan...</div>
                </div>
                <iframe id="iframeCetakProfilRisiko" src="about:blank" style="width:100%;height:100%;border:0;background:#fff;display:block;"></iframe>
            </div>
        </div>
    </div>
</div>

<style>
.table-action .aksi-aktifkan-wrap{
    display:inline-flex;
    align-items:center;
    gap:5px;
    line-height:1;
    vertical-align:middle;
    white-space:nowrap;
    color:#6658dd!important;
}
.table-action a .aksi-aktifkan-wrap,
.table-action .aksi-aktifkan-wrap span{
    color:#6658dd!important;
}
.table-action .aksi-aktifkan-wrap input[type="checkbox"]{
    margin:0;
    position:relative;
    top:0;
}
.copy-warning-box{
    display:flex;
    gap:12px;
    align-items:flex-start;
    padding:14px 16px;
    border:1px solid #ffe3a3;
    border-radius:8px;
    background:#fff8e6;
    color:#73510a;
    line-height:1.45;
}
.copy-warning-box p{
    color:#8a6818;
}
.copy-warning-icon{
    width:34px;
    height:34px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:0 0 34px;
    background:#ffecb5;
    color:#b7791f;
    font-size:20px;
}
.laporan-modal-head{
    display:grid;
    grid-template-columns:42px 1fr 42px;
    align-items:center;
    gap:10px;
}
.laporan-modal-head h4{
    text-align:center;
    margin:0;
}
.laporan-info-btn{
    width:38px;
    height:38px;
    border:0;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#eef2ff;
    color:#6658dd;
    box-shadow:0 8px 20px rgba(102,88,221,.18);
    font-size:22px;
    transition:.18s ease;
}
.laporan-info-btn:hover{
    background:#6658dd;
    color:#fff;
    transform:translateY(-1px);
}
.laporan-info-pop{
    display:none;
    position:fixed;
    inset:0;
    z-index:1065;
    align-items:center;
    justify-content:center;
    padding:22px;
    background:rgba(15,23,42,.42);
    backdrop-filter:blur(2px);
}
.laporan-info-pop.show{
    display:flex;
}
.laporan-info-card{
    width:min(760px, 96vw);
    max-height:86vh;
    overflow:auto;
    background:#fff;
    border-radius:14px;
    box-shadow:0 24px 70px rgba(15,23,42,.24);
    padding:22px;
}
.laporan-info-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:14px;
    border-bottom:1px solid #eef0f4;
    padding-bottom:14px;
    margin-bottom:16px;
}
.laporan-info-eyebrow{
    color:#6658dd;
    font-weight:700;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:0;
}
.laporan-info-top h5{
    margin:3px 0 0;
    font-weight:800;
}
.laporan-info-close{
    width:34px;
    height:34px;
    border:0;
    border-radius:999px;
    background:#f3f4f6;
    color:#334155;
    font-size:20px;
}
.laporan-flow{
    display:grid;
    grid-template-columns:repeat(2, minmax(0,1fr));
    gap:12px;
}
.laporan-flow-step{
    display:flex;
    gap:11px;
    align-items:flex-start;
    border:1px solid #e8ecf5;
    border-radius:10px;
    padding:12px;
    background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
}
.laporan-flow-num{
    flex:0 0 28px;
    width:28px;
    height:28px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#6658dd;
    color:#fff;
    font-weight:800;
    font-size:13px;
}
.laporan-flow-step b{
    display:block;
    margin-bottom:3px;
}
.laporan-flow-step p{
    margin:0;
    color:#64748b;
    font-size:13px;
    line-height:1.35;
}
.laporan-menu-map{
    margin-top:16px;
    padding:14px;
    border-radius:10px;
    background:#f8fafc;
    border:1px dashed #cbd5e1;
}
.laporan-menu-map b{
    display:block;
    margin-bottom:9px;
}
.laporan-menu-map span{
    display:inline-flex;
    align-items:center;
    margin:0 7px 7px 0;
    padding:6px 10px;
    border-radius:999px;
    background:#fff;
    border:1px solid #e2e8f0;
    color:#334155;
    font-size:12px;
    font-weight:600;
}
@media (max-width: 767px){
    .laporan-flow{grid-template-columns:1fr;}
}
/* Modal cetak dibuat seperti modal Tambah Laporan: ada backdrop + blur */
#modalCetakProfilRisiko{background:transparent!important;}
.modal-backdrop.show{
    opacity:.45!important;
    background:#000!important;
    backdrop-filter:blur(3px);
    -webkit-backdrop-filter:blur(3px);
}
body.modal-open{overflow:hidden!important;padding-right:0!important;}
#modalCetakProfilRisiko .modal-content,
#modalCetakProfilRisiko .modal-body,
#modalCetakProfilRisiko iframe{background:#fff!important;}
#modalCetakProfilRisiko .modal-header{position:sticky;top:0;z-index:10;}
/* Modal dibuat benar-benar besar dan selalu tepat di tengah layar */
#modalCetakProfilRisiko .modal-dialog,
#modalCetakProfilRisiko .cetak-profil-modal-dialog{
    position:fixed!important;
    top:50%!important;
    left:50%!important;
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
    max-width:none!important;
    /* Kompensasi body { zoom:0.6 }: hasil tampil kira-kira 75% layar */
    width:calc(125vw - 18px)!important;
    height:calc(125vh - 18px)!important;
    margin:0!important;
    padding:0!important;
}
#modalCetakProfilRisiko.fade .modal-dialog,
#modalCetakProfilRisiko.show .modal-dialog{
    transform:translate(-50%,-50%)!important;
    -webkit-transform:translate(-50%,-50%)!important;
}
#modalCetakProfilRisiko .cetak-profil-modal-content{
    background:#fff!important;
    border-radius:8px!important;
    overflow:hidden!important;
    width:100%!important;
    max-width:none!important;
    height:100%!important;
    box-shadow:0 10px 35px rgba(0,0,0,.28)!important;
}
#modalCetakProfilRisiko .cetak-profil-modal-header{
    background:#fff!important;
    border-bottom:1px solid #dee2e6!important;
    min-height:60px!important;
    height:60px!important;
    padding:9px 14px!important;
}
#modalCetakProfilRisiko .btn-cetak-modal-excel,
#modalCetakProfilRisiko .btn-cetak-modal-close{
    font-size:15px!important;
    font-weight:800!important;
    padding:10px 20px!important;
    border-radius:6px!important;
    min-height:40px!important;
    min-width:122px!important;
}
#modalCetakProfilRisiko .btn-cetak-modal-excel{min-width:145px!important;}
#modalCetakProfilRisiko .cetak-profil-modal-body{
    background:#fff!important;
    height:calc(125vh - 60px)!important;
    overflow:hidden!important;
    position:relative!important;
}
#modalCetakProfilRisiko #iframeCetakProfilRisiko{
    width:100%!important;
    height:100%!important;
    min-height:calc(125vh - 60px)!important;
}
@media (max-width: 768px){
    #modalCetakProfilRisiko .modal-dialog,
    #modalCetakProfilRisiko .cetak-profil-modal-dialog{
        width:calc(125vw - 8px)!important;
        height:calc(125vh - 8px)!important;
    }
    #modalCetakProfilRisiko .cetak-profil-modal-body{height:calc(125vh - 52px)!important;}
}
#modalCetakProfilRisiko .cetak-profil-loading{
    position:absolute;
    inset:0;
    z-index:50;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.94);
    color:#6c757d;
    font-size:14px;
}
#modalCetakProfilRisiko .cetak-profil-loading.is-hidden{display:none!important;}
#modalCetakProfilRisiko .cetak-loader-spinner{
    width:74px;
    height:74px;
    border-radius:50%;
    border:7px solid #e1e1e1;
    border-top-color:#777;
    animation:cetakProfilSpin .85s linear infinite;
}
#modalCetakProfilRisiko .cetak-loader-title{
    margin-top:12px;
    font-size:18px;
    font-weight:600;
    color:#777;
}
#modalCetakProfilRisiko .cetak-loader-subtitle{
    margin-top:4px;
    font-size:13px;
    color:#777;
}
@keyframes cetakProfilSpin{to{transform:rotate(360deg);}}
</style>

<script>

var currentCetakProfilId = 0;
var currentCetakProfilMode = 'profil';
var cetakProfilLoadingTimer = null;

function setCetakProfilLoading(show, text) {
    var loading = document.getElementById('loadingCetakProfilRisiko');
    var loadingText = document.getElementById('loadingCetakProfilRisikoText');
    if (loadingText && text) loadingText.textContent = text;
    if (!loading) return;
    if (show) loading.classList.remove('is-hidden');
    else loading.classList.add('is-hidden');
}

function startCetakProfilLoadingWatcher() {
    if (cetakProfilLoadingTimer) clearInterval(cetakProfilLoadingTimer);

    var iframe = document.getElementById('iframeCetakProfilRisiko');
    setCetakProfilLoading(true, currentCetakProfilMode === 'tindak_lanjut' ? 'Menyiapkan preview tindak lanjut...' : 'Menyiapkan preview laporan...');

    cetakProfilLoadingTimer = setInterval(function(){
        try {
            if (!iframe || !iframe.contentWindow) return;
            var doc = iframe.contentDocument || iframe.contentWindow.document;
            if (!doc || !doc.body) return;

            var statusEl = doc.getElementById('loadStatus');
            var statusText = statusEl ? (statusEl.textContent || '').trim() : '';
            if (statusText) {
                setCetakProfilLoading(true, statusText);
                if (statusText.toLowerCase().indexOf('selesai') !== -1 || statusText.toLowerCase().indexOf('siap dicetak') !== -1) {
                    clearInterval(cetakProfilLoadingTimer);
                    cetakProfilLoadingTimer = null;
                    setTimeout(function(){ setCetakProfilLoading(false); }, 350);
                }
            } else if (doc.readyState === 'complete') {
                var sections = doc.querySelectorAll('.print-section');
                if (!sections.length) {
                    clearInterval(cetakProfilLoadingTimer);
                    cetakProfilLoadingTimer = null;
                    setTimeout(function(){ setCetakProfilLoading(false); }, 350);
                }
            }
        } catch(e) {
            setCetakProfilLoading(true, 'Memuat preview laporan...');
        }
    }, 350);
}

function openCetakProfilModal(idProfil, mode) {
    currentCetakProfilId = idProfil;
    currentCetakProfilMode = mode || 'profil';

    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe) return;

    if (cetakProfilLoadingTimer) {
        clearInterval(cetakProfilLoadingTimer);
        cetakProfilLoadingTimer = null;
    }

    setCetakProfilLoading(true, currentCetakProfilMode === 'tindak_lanjut'
        ? 'Menyiapkan preview tindak lanjut...'
        : 'Menyiapkan preview laporan...'
    );

    iframe.onload = function(){ startCetakProfilLoadingWatcher(); };
    iframe.src = 'about:blank';

    var el = document.getElementById('modalCetakProfilRisiko');
    if (window.bootstrap && bootstrap.Modal) {
        var modal = bootstrap.Modal.getOrCreateInstance(el, {backdrop:true, keyboard:true, focus:true});
        modal.show();
    } else if (window.$ && $('#modalCetakProfilRisiko').modal) {
        $('#modalCetakProfilRisiko').modal({backdrop:true, keyboard:true}).modal('show');
    }

    setTimeout(function(){
        var src = 'laporan/cetak_laporan_profil_risiko.php'
            + '?id=' + encodeURIComponent(idProfil)
            + '&modal_view=1'
            + '&embed_modal=1'
            + '&print_scale=300';

        if (currentCetakProfilMode === 'tindak_lanjut') {
            src += '&only_tindak_lanjut=1';
        }

        iframe.src = src;
    }, 80);
}

function printCetakProfilModal() {
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe || !iframe.contentWindow) return;

    var orientasi = 'portrait';

    try {
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        if (doc && iframe.contentWindow.setPrintOrientation) {
            iframe.contentWindow.setPrintOrientation(orientasi);
        }
        if (doc && iframe.contentWindow.setPrintScale) {
            iframe.contentWindow.setPrintScale(160);
        } else if (doc) {
            var st = doc.getElementById('dynamicPrintPageSize');
            if (!st) {
                st = doc.createElement('style');
                st.id = 'dynamicPrintPageSize';
                doc.head.appendChild(st);
            }
            st.textContent = '@media print{@page{size:215mm 330mm;margin:6mm;} body{background:#fff!important;} .report-wrap{zoom:1.6!important;width:62.5%!important;max-width:62.5%!important;}}';
            doc.body.classList.remove('print-landscape');
            doc.body.classList.add('print-portrait');
        }
    } catch(e) {}

    setTimeout(function(){
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
    }, 250);
}

function cleanWorksheetName(name, index) {
    name = String(name || ('Sheet ' + index))
        .replace(/[\\\/\?\*\[\]\:]/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();
    if (!name) name = 'Sheet ' + index;
    return name.substring(0, 31);
}

function uniqueWorksheetName(baseName, used, index) {
    var base = cleanWorksheetName(baseName, index);
    var name = base;
    var n = 2;
    while (used[name.toLowerCase()]) {
        var suffix = ' ' + n;
        name = base.substring(0, 31 - suffix.length) + suffix;
        n++;
    }
    used[name.toLowerCase()] = true;
    return name;
}

function xmlEscapeExcel(v) {
    return String(v == null ? '' : v)
        .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&apos;');
}

function cellXml(text, extra, styleId) {
    extra = extra || '';
    styleId = styleId || '';
    text = excelTextClean(text);
    var styleAttr = styleId ? ' ss:StyleID="' + xmlEscapeExcel(styleId) + '"' : '';
    return '<Cell' + styleAttr + extra + '><Data ss:Type="String">' + xmlEscapeExcel(text) + '</Data></Cell>';
}

function normalizeExcelClone(cloned) {
    cloned.querySelectorAll('script, iframe, button, input[type="button"], input[type="submit"], .no-print, .print-toolbar, .modal, .modal-backdrop').forEach(function(el){
        if (el.parentNode) el.parentNode.removeChild(el);
    });
    cloned.querySelectorAll('input, textarea, select').forEach(function(el){
        var text = '';
        if (el.tagName === 'SELECT') text = el.options && el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '';
        else text = el.value || el.textContent || '';
        var div = cloned.ownerDocument.createElement('div');
        div.textContent = text;
        if (el.parentNode) el.parentNode.replaceChild(div, el);
    });
    cloned.querySelectorAll('[style]').forEach(function(el){
        var st = String(el.getAttribute('style') || '');
        st = st.replace(/background(?:-color)?\s*:[^;]+;?/gi, '');
        el.setAttribute('style', st);
    });
    return cloned;
}

function excelTextClean(v) {
    return String(v == null ? '' : v)
        .replace(/\u00a0/g, ' ')
        .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
        .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
        .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2')
        .replace(/[ \t]+/g, ' ')
        .replace(/\n\s*/g, '\n')
        .replace(/\n{3,}/g, '\n\n')
        .trim();
}

function guessCellStyle(td, trIndex) {
    var tag = (td.tagName || '').toLowerCase();
    var txt = excelTextClean(td.innerText || td.textContent || '');
    var bg = '';
    try { bg = window.getComputedStyle(td).backgroundColor || ''; } catch(e) {}

    if (trIndex <= 1 || tag === 'th' || /^(profil|risiko|rekap|hasil nilai|penilaian profil|pembanding)$/i.test(txt)) {
        return 'sHeader';
    }
    if (/^\d+(?:[\.,]\d+)?$/.test(txt) || /^(sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)$/i.test(txt)) {
        return 'sCenter';
    }
    return 'sCell';
}

function htmlTableToExcelRows(table) {
    var rows = [];
    Array.from(table.rows || []).forEach(function(tr, rIndex){
        var cells = [];
        Array.from(tr.cells || []).forEach(function(td){
            var text = td.innerText || td.textContent || '';
            var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
            if (!colspan || colspan < 1) colspan = 1;
            var styleId = guessCellStyle(td, rIndex);

            cells.push(cellXml(text, '', styleId));
            for (var i = 1; i < colspan; i++) {
                cells.push(cellXml('', '', styleId));
            }
        });
        var height = 22;
        if ((tr.innerText || '').length > 160) height = 70;
        if ((tr.innerText || '').length > 350) height = 120;
        rows.push('<Row ss:AutoFitHeight="1" ss:Height="' + height + '">' + cells.join('') + '</Row>');
    });
    return rows;
}

function sectionToWorksheetXml(section, sheetName) {
    var rows = [];
    rows.push('<Row>' + cellXml(sheetName, '') + '</Row>');
    rows.push('<Row></Row>');

    var cloned = normalizeExcelClone(section.cloneNode(true));
    var tables = Array.from(cloned.querySelectorAll('table'));

    if (tables.length) {
        tables.forEach(function(tbl, i){
            if (i > 0) rows.push('<Row></Row>');
            rows = rows.concat(htmlTableToExcelRows(tbl));
        });
    } else {
        var text = (cloned.innerText || cloned.textContent || '').split(/\n+/).map(function(x){return x.trim();}).filter(Boolean);
        text.forEach(function(line){ rows.push('<Row>' + cellXml(line, '') + '</Row>'); });
    }

    return '<Worksheet ss:Name="' + xmlEscapeExcel(sheetName) + '"><Table>' + rows.join('') + '</Table></Worksheet>';
}

function getCetakProfilDoc() {
    var iframe = document.getElementById('iframeCetakProfilRisiko');
    if (!iframe || !iframe.contentWindow) return null;
    try {
        var doc = iframe.contentDocument || iframe.contentWindow.document;
        if (doc && doc.body && doc.body.innerText.trim() !== '') return doc;
    } catch(e) {}
    return null;
}

function downloadExcelXml(workbookXml, filename) {
    var blob = new Blob([workbookXml], {type: 'application/vnd.ms-excel;charset=utf-8;'});

    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
        window.navigator.msSaveOrOpenBlob(blob, filename);
        return;
    }

    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    setTimeout(function(){
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }, 500);
}

function excelHtmlEscape(v) {
    return String(v == null ? '' : v)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function excelHtmlCleanText(v) {
    return String(v == null ? '' : v)
        .replace(/\u00a0/g, ' ')
        .replace(/\r/g, '')
        .replace(/[ \t]+\n/g, '\n')
        .replace(/\n[ \t]+/g, '\n')
        .replace(/[ \t]{2,}/g, ' ')
        .trim();
}

function makeExcelCellText(el) {
    if (!el) return '';

    var cloned = el.cloneNode(true);

    Array.from(cloned.querySelectorAll('textarea')).forEach(function(t){
        var div = cloned.ownerDocument.createElement('div');
        div.innerHTML = excelHtmlEscape(t.value || t.textContent || '').replace(/\n/g, '<br>');
        t.parentNode.replaceChild(div, t);
    });

    Array.from(cloned.querySelectorAll('input')).forEach(function(inp){
        var div = cloned.ownerDocument.createElement('div');
        div.innerHTML = excelHtmlEscape(inp.value || inp.getAttribute('value') || '');
        inp.parentNode.replaceChild(div, inp);
    });

    Array.from(cloned.querySelectorAll('select')).forEach(function(sel){
        var div = cloned.ownerDocument.createElement('div');
        var txt = '';
        if (sel.selectedIndex >= 0 && sel.options && sel.options[sel.selectedIndex]) {
            txt = sel.options[sel.selectedIndex].text || sel.options[sel.selectedIndex].value || '';
        }
        div.innerHTML = excelHtmlEscape(txt);
        sel.parentNode.replaceChild(div, sel);
    });

    var html = cloned.innerHTML || cloned.textContent || '';
    html = html
        .replace(/<script[\s\S]*?<\/script>/gi, '')
        .replace(/<style[\s\S]*?<\/style>/gi, '')
        .replace(/<(?!br\s*\/?)[^>]+>/gi, ' ')
        .replace(/<br\s*\/?\s*>/gi, '\n');

    var temp = document.createElement('textarea');
    temp.innerHTML = html;
    return excelHtmlCleanText(temp.value || html);
}

function cellToSimpleHtml(td) {
    var tag = (td.tagName || '').toLowerCase() === 'th' ? 'th' : 'td';
    var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
    var rowspan = parseInt(td.getAttribute('rowspan') || td.rowSpan || '1', 10);
    if (!colspan || colspan < 1) colspan = 1;
    if (!rowspan || rowspan < 1) rowspan = 1;

    var text = makeExcelCellText(td);
    var isHeader = tag === 'th';
    var style = '';

    try {
        var cs = window.getComputedStyle(td);
        var fw = cs.fontWeight || '';
        if (fw === 'bold' || parseInt(fw, 10) >= 600) isHeader = true;
    } catch(e) {}

    if (isHeader || /^(profil|risiko|rekap|hasil|penilaian|pembanding|no|parameter|nominal|rasio|ambang batas|rumus|koreksi|nilai|keterangan)$/i.test(text)) {
        style += 'font-weight:bold;background:#e6e6e6;text-align:center;';
    }

    if (/^\s*(\d+(?:[\.,]\d+)?|sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)\s*$/i.test(text)) {
        style += 'text-align:center;vertical-align:middle;';
    }

    text = text
        .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
        .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2');

    var attr = '';
    if (colspan > 1) attr += ' colspan="' + colspan + '"';
    if (rowspan > 1) attr += ' rowspan="' + rowspan + '"';

    return '<' + tag + attr + ' style="' + style + '">' + excelHtmlEscape(text).replace(/\n/g, '<br>') + '</' + tag + '>';
}

function tableToSimpleHtml(table) {
    var html = '<table>';
    Array.from(table.rows || []).forEach(function(tr){
        html += '<tr>';
        Array.from(tr.cells || []).forEach(function(td){
            html += cellToSimpleHtml(td);
        });
        html += '</tr>';
    });
    html += '</table>';
    return html;
}

function blockToSimpleExcelHtml(block, title) {
    var html = '';
    if (title) {
        html += '<h3>' + excelHtmlEscape(title) + '</h3>';
    }

    var tables = Array.from(block.querySelectorAll ? block.querySelectorAll('table') : []);
    if (tables.length) {
        tables.forEach(function(tbl){
            var txt = excelHtmlCleanText(tbl.innerText || tbl.textContent || '');
            if (txt === '') return;
            html += tableToSimpleHtml(tbl);
            html += '<br>';
        });
    } else {
        var txt = excelHtmlCleanText(block.innerText || block.textContent || '');
        if (txt !== '') {
            html += '<p>' + excelHtmlEscape(txt).replace(/\n/g, '<br>') + '</p>';
        }
    }
    return html;
}

function exportCetakProfilExcel() {
    var doc = getCetakProfilDoc();
    if (!doc) {
        alert('Preview belum siap. Tunggu sampai tampilan laporan muncul dahulu.');
        return;
    }

    try {
        var root = doc.querySelector('.report-wrap') || doc.querySelector('.print-area') || doc.querySelector('#printArea') || doc.body;
        var usedNames = {};
        var sheets = [];

        function textOnly(el) {
            return excelHtmlCleanText((el && (el.innerText || el.textContent)) ? (el.innerText || el.textContent) : '');
        }

        function hasContent(el) {
            if (!el) return false;
            return textOnly(el) !== '' || (el.querySelectorAll && el.querySelectorAll('table').length > 0);
        }

        function getTitle(sec, idx) {
            var title = sec.getAttribute('data-title')
                || (sec.querySelector('.section-title') ? sec.querySelector('.section-title').textContent : '')
                || (sec.querySelector('h1,h2,h3,h4,.page-title') ? sec.querySelector('h1,h2,h3,h4,.page-title').textContent : '')
                || '';
            title = excelHtmlCleanText(title);
            if (!title) {
                var t = textOnly(sec);
                var m = t.match(/(?:^|\n)\s*(\d+\.\s*[^\n]{3,80})/);
                if (m) title = m[1];
            }
            if (!title) title = idx === 0 ? 'Cover' : 'Bagian ' + (idx + 1);
            if (/laporan profil risiko/i.test(title) && idx === 0) title = 'Cover';
            return title;
        }

        function makeCoverBlock(firstSection) {
            var box = doc.createElement('div');
            if (!root || !firstSection) return box;
            var children = Array.from(root.children || []);
            for (var i = 0; i < children.length; i++) {
                var el = children[i];
                if (el === firstSection || (el.contains && el.contains(firstSection))) break;
                if (hasContent(el)) box.appendChild(el.cloneNode(true));
            }
            return box;
        }

        function addSheet(name, block, fallback) {
            if (!block || !hasContent(block)) return;
            var sheetName = uniqueWorksheetName(name || fallback || ('Sheet ' + (sheets.length + 1)), usedNames, sheets.length + 1);
            sheets.push({name: sheetName, block: block.cloneNode(true)});
        }

        var rawSections = Array.from(doc.querySelectorAll('.print-section, section.print-section, .section-print'));
        var sections = rawSections.filter(function(sec){
            return sec && !(sec.parentElement && sec.parentElement.closest && sec.parentElement.closest('.print-section, section.print-section, .section-print')) && hasContent(sec);
        });

        if (sections.length) {
            var coverCandidate = doc.querySelector('.cover, .cover-page, #cover, .report-cover');
            var coverAdded = false;
            if (coverCandidate && hasContent(coverCandidate)) {
                addSheet('Cover', coverCandidate, 'Cover');
                coverAdded = sheets.length > 0;
            }
            if (!coverAdded) {
                var coverBox = makeCoverBlock(sections[0]);
                if (hasContent(coverBox)) addSheet('Cover', coverBox, 'Cover');
            }
            sections.forEach(function(sec, idx){
                var t = textOnly(sec);
                if (idx === 0 && /laporan profil risiko/i.test(t) && !/1\.\s*Risiko/i.test(t)) return;
                addSheet(getTitle(sec, idx), sec, 'Bagian ' + (idx + 1));
            });
        } else {
            addSheet('Cover', root, 'Cover');
        }

        if (!sheets.length) {
            alert('Data laporan belum terbaca untuk Excel. Tunggu preview selesai dimuat.');
            return;
        }

        function xmlClean(v) {
            return String(v == null ? '' : v)
                .replace(/\u00a0/g, ' ')
                .replace(/[\x00-\x08\x0B\x0C\x0E-\x1F]/g, '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        function textForExcel(el) {
            var txt = makeExcelCellText(el);
            txt = txt
                .replace(/([0-9]+(?:[\.,][0-9]+)?)(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)/gi, '$1\n$2')
                .replace(/(Sangat Rendah|Rendah|Sedang|Tinggi|Sangat Tinggi|Sangat Memadai|Memadai|Cukup Memadai|Kurang Memadai|Tidak Memadai)([0-9]+(?:[\.,][0-9]+)?)/gi, '$1\n$2');
            return txt;
        }

        function styleForCell(td, rIndex) {
            var tag = (td.tagName || '').toLowerCase();
            var txt = excelHtmlCleanText(textForExcel(td));
            if (rIndex <= 1 || tag === 'th' || /^(profil|risiko|rekap|hasil|penilaian|pembanding|no|parameter|nominal|rasio|ambang batas|rumus|koreksi|nilai|keterangan)$/i.test(txt)) {
                return 'Header';
            }
            if (/^\s*(\d+(?:[\.,]\d+)?|sangat rendah|rendah|sedang|tinggi|sangat tinggi|sangat memadai|memadai|cukup memadai|kurang memadai|tidak memadai)\s*$/i.test(txt)) {
                return 'Center';
            }
            return 'Cell';
        }

        function cell(data, style, mergeAcross) {
            var ma = mergeAcross && mergeAcross > 0 ? ' ss:MergeAcross="' + mergeAcross + '"' : '';
            return '<Cell ss:StyleID="' + style + '"' + ma + '><Data ss:Type="String">' + xmlClean(data) + '</Data></Cell>';
        }

        function tableRows(tbl) {
            var out = [];
            Array.from(tbl.rows || []).forEach(function(tr, ri){
                var cells = [];
                Array.from(tr.cells || []).forEach(function(td){
                    var colspan = parseInt(td.getAttribute('colspan') || td.colSpan || '1', 10);
                    if (!colspan || colspan < 1) colspan = 1;
                    cells.push(cell(textForExcel(td), styleForCell(td, ri), colspan > 1 ? (colspan - 1) : 0));
                });
                var len = excelHtmlCleanText(tr.innerText || tr.textContent || '').length;
                var h = len > 450 ? 95 : (len > 220 ? 64 : (len > 90 ? 38 : 20));
                out.push('<Row ss:AutoFitHeight="1" ss:Height="' + h + '">' + cells.join('') + '</Row>');
            });
            return out;
        }

        function blockRows(block, title) {
            var rows = [];
            title = excelHtmlCleanText(title || '');
            if (title) {
                rows.push('<Row ss:Height="24">' + cell(title, 'Title', 7) + '</Row>');
                rows.push('<Row></Row>');
            }
            var cloned = normalizeExcelClone(block.cloneNode(true));
            var tables = Array.from(cloned.querySelectorAll('table'));
            if (tables.length) {
                tables.forEach(function(tbl, i){
                    var t = excelHtmlCleanText(tbl.innerText || tbl.textContent || '');
                    if (!t) return;
                    if (i > 0) rows.push('<Row></Row>');
                    rows = rows.concat(tableRows(tbl));
                });
            } else {
                var lines = textOnly(cloned).split(/\n+/).map(function(x){return x.trim();}).filter(Boolean);
                lines.forEach(function(line){ rows.push('<Row>' + cell(line, 'Cell', 7) + '</Row>'); });
            }
            return rows;
        }

        function worksheetXml(sh, idx) {
            var rows = blockRows(sh.block, sh.name === 'Cover' ? '' : sh.name);
            if (!rows.length) rows.push('<Row>' + cell('Tidak ada data', 'Cell', 2) + '</Row>');
            var cols = '';
            [90,150,150,150,180,135,135,135,160,160,160,160].forEach(function(w){ cols += '<Column ss:Width="' + w + '"/>'; });
            return '<Worksheet ss:Name="' + xmlClean(sh.name) + '"><Table>' + cols + rows.join('') + '</Table><WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel"><DisplayGridlines/></WorksheetOptions></Worksheet>';
        }

        var workbookXml = '\x3c?xml version="1.0"?>' +
            '\x3c?mso-application progid="Excel.Sheet"?>' +
            '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" ' +
            'xmlns:o="urn:schemas-microsoft-com:office:office" ' +
            'xmlns:x="urn:schemas-microsoft-com:office:excel" ' +
            'xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" ' +
            'xmlns:html="http://www.w3.org/TR/REC-html40">' +
            '<Styles>' +
                '<Style ss:ID="Default" ss:Name="Normal"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="11"/><Interior/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Cell"><Alignment ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Center"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Header"><Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/><Borders><Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/><Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/></Borders><Font ss:FontName="Calibri" ss:Size="11" ss:Bold="1"/><Interior ss:Color="#E6E6E6" ss:Pattern="Solid"/><NumberFormat ss:Format="@"/></Style>' +
                '<Style ss:ID="Title"><Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/><Font ss:FontName="Calibri" ss:Size="13" ss:Bold="1"/><NumberFormat ss:Format="@"/></Style>' +
            '</Styles>' +
            sheets.map(worksheetXml).join('') +
            '</Workbook>';

        var blob = new Blob([workbookXml], {type:'application/vnd.ms-excel;charset=utf-8;'});
        var d = new Date();
        var pad = function(n){ return String(n).length < 2 ? '0' + n : String(n); };
        var prefixFile = currentCetakProfilMode === 'tindak_lanjut'
            ? 'laporan_tindak_lanjut_'
            : 'laporan_profil_risiko_';
        var filename = prefixFile + (currentCetakProfilId || 'preview') + '_' + d.getFullYear() + pad(d.getMonth()+1) + pad(d.getDate()) + '.xls';

        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = filename;
            a.style.display = 'none';
            document.body.appendChild(a);
            a.click();
            setTimeout(function(){
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }, 500);
        }
    } catch (e) {
        alert('Gagal membuat file Excel. Error: ' + (e && e.message ? e.message : e));
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var modalCetakEl = document.getElementById('modalCetakProfilRisiko');
    var iframeCetakEl = document.getElementById('iframeCetakProfilRisiko');
    var loadingCetakEl = document.getElementById('loadingCetakProfilRisiko');
    if (modalCetakEl) {
        modalCetakEl.addEventListener('hidden.bs.modal', function(){
            if (cetakProfilLoadingTimer) {
                clearInterval(cetakProfilLoadingTimer);
                cetakProfilLoadingTimer = null;
            }
            if (iframeCetakEl) iframeCetakEl.src = 'about:blank';
            if (loadingCetakEl) loadingCetakEl.classList.add('is-hidden');
            currentCetakProfilMode = 'profil';
        });
    }

    const inputs = document.querySelectorAll('.uang');
    const tahunSelect = document.getElementById('tahun');
    const frameSelect = document.getElementById('frame_perumusan_id');
    const lokasiSelect = document.getElementById('lokasi_kerja');
    const lokasiLabel = document.getElementById('lokasiKerjaLabel');
    const modalIntiInput = document.getElementById('modal_inti');
    const totalAsetInput = document.getElementById('total_aset');
    const modalIntiWrap = document.getElementById('wrap_modal_inti');
    const totalAsetWrap = document.getElementById('wrap_total_aset');
    const frameWarning = document.getElementById('framePerumusanWarning');
    const infoButton = document.getElementById('btnAlurLaporanInfo');
    const infoPopup = document.getElementById('alurLaporanInfo');
    const infoClose = document.getElementById('btnCloseAlurLaporanInfo');
    const profilByTahun = <?= json_encode($profilRisikoByTahun, JSON_UNESCAPED_UNICODE) ?>;
    const selectedFrameId = <?= json_encode((string)$selectedFrameId) ?>;

    function getActiveReportTab() {
        const active = document.querySelector('a[data-bs-toggle="tab"].active');
        const href = active ? active.getAttribute('href') : '#tab-profil-risiko-konsol';
        if (href === '#tab-profil-risiko-divisi') return 'divisi';
        if (href === '#tab-profil-risiko-cabang') return 'cabang';
        return 'konsol';
    }

    function getSelectedFrameItem() {
        const tahun = tahunSelect ? tahunSelect.value : '';
        const frameId = frameSelect ? frameSelect.value : '';
        return tahun && frameId && profilByTahun[tahun] ? profilByTahun[tahun][frameId] : null;
    }

    function updateFinancialRequirement() {
        const activeMode = getActiveReportTab();
        const item = getSelectedFrameItem();
        const divisiId = item && item.divisi_id ? parseInt(item.divisi_id, 10) : 0;

        // Hanya untuk tab Profil Risiko Divisi:
        // tampilkan Modal Inti & Total Aset hanya untuk:
        // 132 = Divisi Pemasaran
        // 140 = Divisi Penyelesaian Kredit
        const tampilKeuangan = activeMode !== 'divisi' || divisiId === 132 || divisiId === 140;

        function setFieldDisplay(wrap, input) {
            if (wrap) {
                wrap.style.display = tampilKeuangan ? '' : 'none';
            }

            if (input) {
                input.required = tampilKeuangan;
                input.disabled = !tampilKeuangan;

                if (!tampilKeuangan) {
                    input.value = '';
                    input.setCustomValidity('');
                }
            }
        }

        setFieldDisplay(modalIntiWrap, modalIntiInput);
        setFieldDisplay(totalAsetWrap, totalAsetInput);
    }

    function formatRibuan(angka) {
        angka = angka.replace(/[^0-9]/g, '');
        if (angka === '') return '';
        return angka.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = formatRibuan(this.value);
        });
    });

    function renderFrameOptions() {
        const tahun = tahunSelect ? tahunSelect.value : '';
        const activeMode = getActiveReportTab();
        frameSelect.innerHTML = '<option value="">- pilih jenis profil risiko -</option>';
        let hasOptions = false;

        if (tahun && profilByTahun[tahun]) {
            const targetUserId = activeMode === 'divisi' ? 2 : 1;
            const items = Object.values(profilByTahun[tahun]).filter(function(item){
                return parseInt(item.user_id || 0, 10) === targetUserId;
            });
            hasOptions = items.length > 0;
            items.forEach(function(item) {
                const opt = document.createElement('option');
                opt.value = item.frame_id;
                opt.textContent = item.text;
                if (String(item.frame_id) === String(selectedFrameId)) {
                    opt.selected = true;
                }
                frameSelect.appendChild(opt);
            });
        }

        if (frameWarning) {
            frameWarning.style.display = (tahun && !hasOptions) ? '' : 'none';
        }
        if (frameSelect) {
            frameSelect.disabled = !!(tahun && !hasOptions);
        }
        updateLokasiFromFrame();
        updateFinancialRequirement();
    }

    function updateLokasiFromFrame() {
        if (!lokasiSelect) return;
        const activeMode = getActiveReportTab();
        if (lokasiLabel) lokasiLabel.textContent = activeMode === 'divisi' ? 'Divisi / Satker' : 'Kantor Cabang';
        if (activeMode !== 'divisi') {
            lokasiSelect.value = <?= json_encode((string)$lokasiSession) ?>;
            return;
        }
        const item = getSelectedFrameItem();
        if (item && item.divisi_id) {
            lokasiSelect.value = String(item.divisi_id);
        }
    }

    function showInfoPopup() {
        if (!infoPopup) return;
        infoPopup.classList.add('show');
        infoPopup.setAttribute('aria-hidden', 'false');
    }

    function hideInfoPopup() {
        if (!infoPopup) return;
        infoPopup.classList.remove('show');
        infoPopup.setAttribute('aria-hidden', 'true');
    }

    if (infoButton) {
        infoButton.addEventListener('click', showInfoPopup);
    }
    if (infoClose) {
        infoClose.addEventListener('click', hideInfoPopup);
    }
    if (infoPopup) {
        infoPopup.addEventListener('click', function(e){
            if (e.target === infoPopup) hideInfoPopup();
        });
    }
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape') hideInfoPopup();
    });

    if (tahunSelect) {
        tahunSelect.addEventListener('change', function(){
            renderFrameOptions();
        });
        renderFrameOptions();
    }
    if (frameSelect) {
        frameSelect.addEventListener('change', function(){
            updateLokasiFromFrame();
            updateFinancialRequirement();
        });
    }
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tab){
        tab.addEventListener('shown.bs.tab', function(){
            renderFrameOptions();
            updateFinancialRequirement();
        });
    });
});
</script>
