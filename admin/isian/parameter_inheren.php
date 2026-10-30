<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| KONEKSI
|--------------------------------------------------------------------------
*/
$koneksi_candidates = [
    __DIR__ . '/../conn/conn.php',
    __DIR__ . '/conn/conn.php',
    '../conn/conn.php',
    './conn/conn.php',
];

$koneksi_loaded = false;
foreach ($koneksi_candidates as $kfile) {
    if (file_exists($kfile)) {
        include $kfile;
        $koneksi_loaded = true;
        break;
    }
}

if (!$koneksi_loaded || !isset($conn)) {
    die('File koneksi tidak ditemukan / $conn belum terbentuk. Cek path conn.php');
}

/*
|--------------------------------------------------------------------------
| HELPER UMUM
|--------------------------------------------------------------------------
*/
function esc($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function q($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die("SQL Error: " . mysqli_error($conn) . "<hr><pre>" . esc($sql) . "</pre>");
    }
    return $res;
}

function post($key, $default = '')
{
    return isset($_POST[$key]) ? trim($_POST[$key]) : $default;
}

function getv($key, $default = '')
{
    return isset($_GET[$key]) ? trim($_GET[$key]) : $default;
}

function current_page_base_url()
{
    $self = $_SERVER['PHP_SELF'];
    $params = $_GET;

    unset(
        $params['msg'],
        $params['edit_jenis_id'],
        $params['edit_pilar_id'],
        $params['edit_parameter_id'],
        $params['edit_sub_id'],
        $params['open_modal']
    );

    return $self . (count($params) ? '?' . http_build_query($params) : '');
}

function page_url($extra = [])
{
    $self = $_SERVER['PHP_SELF'];
    $params = $_GET;

    unset($params['msg']);

    foreach ($extra as $k => $v) {
        if ($v === null) {
            unset($params[$k]);
        } else {
            $params[$k] = $v;
        }
    }

    return $self . (count($params) ? '?' . http_build_query($params) : '');
}

function redirect_with_msg($msg, $extra = [])
{
    $extra['msg'] = $msg;
    header('Location: ' . page_url($extra));
    exit;
}

function toast($msg, $type = 'success')
{
    echo '<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
            ' . esc($msg) . '
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>';
}

function alphaIndex($i)
{
    $letters = range('a', 'z');
    return isset($letters[$i]) ? $letters[$i] : ($i + 1);
}

function fetch_one($conn, $sql)
{
    $res = q($conn, $sql);
    return mysqli_fetch_assoc($res);
}

function table_exists($conn, $table)
{
    $table = mysqli_real_escape_string($conn, $table);
    $res = mysqli_query($conn, "SHOW TABLES LIKE '$table'");
    return $res && mysqli_num_rows($res) > 0;
}

function column_exists($conn, $table, $column)
{
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $res = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $res && mysqli_num_rows($res) > 0;
}

function index_exists($conn, $table, $index)
{
    $table = mysqli_real_escape_string($conn, $table);
    $index = mysqli_real_escape_string($conn, $index);
    $res = mysqli_query($conn, "SHOW INDEX FROM `$table` WHERE Key_name='$index'");
    return $res && mysqli_num_rows($res) > 0;
}

function ensure_index($conn, $table, $indexName, $sqlAddIndex)
{
    if (!index_exists($conn, $table, $indexName)) {
        mysqli_query($conn, $sqlAddIndex);
    }
}

function insert_setting_year($conn, $tahun, $jenis_parameter)
{
    $tahun = mysqli_real_escape_string($conn, $tahun);
    $jenis_parameter = mysqli_real_escape_string($conn, $jenis_parameter);

    if (column_exists($conn, 'pr_inheren_periode', 'periode')) {
        q($conn, "INSERT INTO pr_inheren_periode (tahun, jenis_parameter, periode)
                  VALUES ('$tahun', '$jenis_parameter', NULL)");
    } else {
        q($conn, "INSERT INTO pr_inheren_periode (tahun, jenis_parameter)
                  VALUES ('$tahun', '$jenis_parameter')");
    }

    return mysqli_insert_id($conn);
}

function get_setting_by_year($conn, $tahun, $jenis_parameter)
{
    $tahun = mysqli_real_escape_string($conn, $tahun);
    $jenis_parameter = mysqli_real_escape_string($conn, $jenis_parameter);

    return fetch_one($conn, "
        SELECT *
        FROM pr_inheren_periode
        WHERE tahun='$tahun'
          AND jenis_parameter='$jenis_parameter'
        ORDER BY id ASC
        LIMIT 1
    ");
}

function get_latest_previous_setting($conn, $tahun, $jenis_parameter)
{
    $tahun = (int)$tahun;
    $jenis_parameter = mysqli_real_escape_string($conn, $jenis_parameter);

    return fetch_one($conn, "
        SELECT *
        FROM pr_inheren_periode
        WHERE CAST(tahun AS UNSIGNED) < '$tahun'
          AND jenis_parameter='$jenis_parameter'
        ORDER BY CAST(tahun AS UNSIGNED) DESC, id DESC
        LIMIT 1
    ");
}

function count_jenis_by_setting($conn, $setting_id)
{
    $setting_id = (int)$setting_id;
    $r = fetch_one($conn, "SELECT COUNT(*) AS jml FROM pr_jenis_risiko WHERE pr_inheren_periode_id='$setting_id'");
    return (int)($r['jml'] ?? 0);
}

function count_legacy_jenis($conn)
{
    $r = fetch_one($conn, "SELECT COUNT(*) AS jml FROM pr_jenis_risiko WHERE pr_inheren_periode_id IS NULL");
    return (int)($r['jml'] ?? 0);
}

/*
|--------------------------------------------------------------------------
| AUTO SCHEMA MIGRATION
|--------------------------------------------------------------------------
*/
function ensure_schema($conn)
{
    if (!table_exists($conn, 'pr_inheren_periode')) {
        q($conn, "CREATE TABLE pr_inheren_periode (
            id INT AUTO_INCREMENT PRIMARY KEY,
            tahun VARCHAR(4) NOT NULL,
            jenis_parameter ENUM('konsolidasi','cabang') NOT NULL DEFAULT 'konsolidasi',
            created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    } else {
        if (!column_exists($conn, 'pr_inheren_periode', 'tahun')) {
            q($conn, "ALTER TABLE pr_inheren_periode ADD COLUMN tahun VARCHAR(4) NOT NULL AFTER id");
        }

        if (!column_exists($conn, 'pr_inheren_periode', 'jenis_parameter')) {
            q($conn, "ALTER TABLE pr_inheren_periode
                      ADD COLUMN jenis_parameter ENUM('konsolidasi','cabang') NOT NULL DEFAULT 'konsolidasi' AFTER tahun");
        }

        if (column_exists($conn, 'pr_inheren_periode', 'periode')) {
            @mysqli_query($conn, "ALTER TABLE pr_inheren_periode MODIFY COLUMN periode VARCHAR(50) NULL DEFAULT NULL");
        }

        if (!column_exists($conn, 'pr_inheren_periode', 'created_at')) {
            q($conn, "ALTER TABLE pr_inheren_periode ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP");
        }

        if (!column_exists($conn, 'pr_inheren_periode', 'updated_at')) {
            q($conn, "ALTER TABLE pr_inheren_periode ADD COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
        }
    }

    $targetTables = [
        'pr_jenis_risiko',
        'pr_pilar',
        'pr_parameter',
        'pr_sub_parameter',
        'pr_skala',
    ];

    foreach ($targetTables as $tb) {
        if (table_exists($conn, $tb) && !column_exists($conn, $tb, 'pr_inheren_periode_id')) {
            q($conn, "ALTER TABLE `$tb` ADD COLUMN pr_inheren_periode_id INT NULL DEFAULT NULL");
        }
    }

    ensure_index($conn, 'pr_inheren_periode', 'idx_pr_inheren_periode_tahun', "ALTER TABLE pr_inheren_periode ADD INDEX idx_pr_inheren_periode_tahun (tahun)");
    ensure_index($conn, 'pr_inheren_periode', 'uniq_tahun_jenis_parameter', "ALTER TABLE pr_inheren_periode ADD UNIQUE KEY uniq_tahun_jenis_parameter (tahun, jenis_parameter)");
    ensure_index($conn, 'pr_jenis_risiko', 'idx_pr_jenis_risiko_periode', "ALTER TABLE pr_jenis_risiko ADD INDEX idx_pr_jenis_risiko_periode (pr_inheren_periode_id)");
    ensure_index($conn, 'pr_pilar', 'idx_pr_pilar_periode', "ALTER TABLE pr_pilar ADD INDEX idx_pr_pilar_periode (pr_inheren_periode_id)");
    ensure_index($conn, 'pr_parameter', 'idx_pr_parameter_periode', "ALTER TABLE pr_parameter ADD INDEX idx_pr_parameter_periode (pr_inheren_periode_id)");
    ensure_index($conn, 'pr_sub_parameter', 'idx_pr_sub_parameter_periode', "ALTER TABLE pr_sub_parameter ADD INDEX idx_pr_sub_parameter_periode (pr_inheren_periode_id)");
    ensure_index($conn, 'pr_skala', 'idx_pr_skala_periode', "ALTER TABLE pr_skala ADD INDEX idx_pr_skala_periode (pr_inheren_periode_id)");
}

ensure_schema($conn);

/*
|--------------------------------------------------------------------------
| COPY DATASET
|--------------------------------------------------------------------------
*/
function clone_dataset($conn, $target_setting_id, $source_setting_id = null)
{
    $target_setting_id = (int)$target_setting_id;

    if ($target_setting_id <= 0) {
        return false;
    }

    q($conn, "DELETE FROM pr_skala WHERE pr_inheren_periode_id='$target_setting_id'");
    q($conn, "DELETE FROM pr_sub_parameter WHERE pr_inheren_periode_id='$target_setting_id'");
    q($conn, "DELETE FROM pr_parameter WHERE pr_inheren_periode_id='$target_setting_id'");
    q($conn, "DELETE FROM pr_pilar WHERE pr_inheren_periode_id='$target_setting_id'");
    q($conn, "DELETE FROM pr_jenis_risiko WHERE pr_inheren_periode_id='$target_setting_id'");

    $whereJenis = is_null($source_setting_id)
        ? "pr_inheren_periode_id IS NULL"
        : "pr_inheren_periode_id='" . (int)$source_setting_id . "'";

    $wherePilar = is_null($source_setting_id)
        ? "pr_inheren_periode_id IS NULL"
        : "pr_inheren_periode_id='" . (int)$source_setting_id . "'";

    $whereParameter = is_null($source_setting_id)
        ? "pr_inheren_periode_id IS NULL"
        : "pr_inheren_periode_id='" . (int)$source_setting_id . "'";

    $whereSub = is_null($source_setting_id)
        ? "pr_inheren_periode_id IS NULL"
        : "pr_inheren_periode_id='" . (int)$source_setting_id . "'";

    $whereSkala = is_null($source_setting_id)
        ? "pr_inheren_periode_id IS NULL"
        : "pr_inheren_periode_id='" . (int)$source_setting_id . "'";

    $mapJenis = [];
    $mapPilar = [];
    $mapParam = [];
    $mapSub   = [];

    $qJenis = q($conn, "SELECT * FROM pr_jenis_risiko WHERE $whereJenis ORDER BY urutan, id");
    while ($r = mysqli_fetch_assoc($qJenis)) {
        $nama_risiko = mysqli_real_escape_string($conn, $r['nama_risiko']);
        $urutan = (int)$r['urutan'];
        $aktif = mysqli_real_escape_string($conn, $r['aktif']);

        q($conn, "INSERT INTO pr_jenis_risiko (nama_risiko, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$nama_risiko', '$urutan', '$aktif', '$target_setting_id')");
        $mapJenis[(int)$r['id']] = mysqli_insert_id($conn);
    }

    $qPilar = q($conn, "SELECT * FROM pr_pilar WHERE $wherePilar ORDER BY urutan, id");
    while ($r = mysqli_fetch_assoc($qPilar)) {
        $oldJenisId = (int)$r['jenis_risiko_id'];
        if (!isset($mapJenis[$oldJenisId])) continue;

        $newJenisId = (int)$mapJenis[$oldJenisId];
        $nama_pilar = mysqli_real_escape_string($conn, $r['nama_pilar']);
        $urutan = (int)$r['urutan'];
        $aktif = mysqli_real_escape_string($conn, $r['aktif']);

        q($conn, "INSERT INTO pr_pilar (jenis_risiko_id, nama_pilar, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$newJenisId', '$nama_pilar', '$urutan', '$aktif', '$target_setting_id')");
        $mapPilar[(int)$r['id']] = mysqli_insert_id($conn);
    }

    $qParam = q($conn, "SELECT * FROM pr_parameter WHERE $whereParameter ORDER BY urutan, id");
    while ($r = mysqli_fetch_assoc($qParam)) {
        $oldPilarId = (int)$r['pilar_id'];
        if (!isset($mapPilar[$oldPilarId])) continue;

        $newPilarId = (int)$mapPilar[$oldPilarId];
        $nomor_parameter = mysqli_real_escape_string($conn, $r['nomor_parameter']);
        $nama_parameter = mysqli_real_escape_string($conn, $r['nama_parameter']);
        $urutan = (int)$r['urutan'];
        $aktif = mysqli_real_escape_string($conn, $r['aktif']);

        q($conn, "INSERT INTO pr_parameter (pilar_id, nomor_parameter, nama_parameter, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$newPilarId', '$nomor_parameter', '$nama_parameter', '$urutan', '$aktif', '$target_setting_id')");
        $mapParam[(int)$r['id']] = mysqli_insert_id($conn);
    }

    $qSub = q($conn, "SELECT * FROM pr_sub_parameter WHERE $whereSub ORDER BY urutan, id");
    while ($r = mysqli_fetch_assoc($qSub)) {
        $oldParamId = (int)$r['parameter_id'];
        if (!isset($mapParam[$oldParamId])) continue;

        $newParamId = (int)$mapParam[$oldParamId];
        $nama_sub_parameter = mysqli_real_escape_string($conn, $r['nama_sub_parameter']);
        $urutan = (int)$r['urutan'];
        $aktif = mysqli_real_escape_string($conn, $r['aktif']);

        q($conn, "INSERT INTO pr_sub_parameter (parameter_id, nama_sub_parameter, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$newParamId', '$nama_sub_parameter', '$urutan', '$aktif', '$target_setting_id')");
        $mapSub[(int)$r['id']] = mysqli_insert_id($conn);
    }

    $qSkala = q($conn, "SELECT * FROM pr_skala WHERE $whereSkala ORDER BY id ASC");
    while ($r = mysqli_fetch_assoc($qSkala)) {
        $ref_tipe = $r['ref_tipe'];
        $oldRefId = (int)$r['ref_id'];
        $skala = (int)$r['skala'];
        $deskripsi = mysqli_real_escape_string($conn, $r['deskripsi']);

        $newRefId = 0;
        if ($ref_tipe === 'parameter' && isset($mapParam[$oldRefId])) {
            $newRefId = (int)$mapParam[$oldRefId];
        }
        if ($ref_tipe === 'sub_parameter' && isset($mapSub[$oldRefId])) {
            $newRefId = (int)$mapSub[$oldRefId];
        }

        if ($newRefId > 0) {
            $ref_tipe = mysqli_real_escape_string($conn, $ref_tipe);

            q($conn, "INSERT IGNORE INTO pr_skala (ref_tipe, ref_id, skala, deskripsi, pr_inheren_periode_id)
                      VALUES ('$ref_tipe', '$newRefId', '$skala', '$deskripsi', '$target_setting_id')");
        }
    }

    return true;
}

/*
|--------------------------------------------------------------------------
| AUTO SEED 2026 DARI DATA LAMA
|--------------------------------------------------------------------------
*/
function ensure_initial_2026_dataset($conn)
{
    $row2026 = get_setting_by_year($conn, '2026', 'konsolidasi');

    if (!$row2026) {
        $newId = insert_setting_year($conn, '2026', 'konsolidasi');
        if (count_legacy_jenis($conn) > 0) {
            clone_dataset($conn, $newId, null);
        }
    } else {
        $id2026 = (int)$row2026['id'];
        if (count_jenis_by_setting($conn, $id2026) == 0 && count_legacy_jenis($conn) > 0) {
            clone_dataset($conn, $id2026, null);
        }
    }
}

/*
 * PENTING:
 * ensure_initial_2026_dataset() adalah proses migrasi/seed satu kali.
 * Jangan dipanggil otomatis pada setiap request, karena setting 2026 yang
 * sudah dihapus akan dibuat kembali setelah redirect halaman.
 *
 * Data pada aplikasi ini sudah terbentuk, sehingga pemanggilan otomatis
 * sengaja dinonaktifkan agar tombol hapus benar-benar permanen.
 */
// ensure_initial_2026_dataset($conn);

/*
|--------------------------------------------------------------------------
| HELPER MASTER
|--------------------------------------------------------------------------
*/
function getSkalaValue($conn, $ref_tipe, $ref_id, $skala)
{
    $ref_tipe = mysqli_real_escape_string($conn, $ref_tipe);
    $ref_id   = (int)$ref_id;
    $skala    = (int)$skala;

    $res = mysqli_query($conn, "SELECT deskripsi
                                FROM pr_skala
                                WHERE ref_tipe='$ref_tipe'
                                  AND ref_id='$ref_id'
                                LIMIT 1");
    if (!$res) {
        return '';
    }

    $res = mysqli_query($conn, "SELECT deskripsi
                                FROM pr_skala
                                WHERE ref_tipe='$ref_tipe'
                                  AND ref_id='$ref_id'
                                  AND skala='$skala'
                                LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        return $r['deskripsi'];
    }
    return '';
}

function saveSkalaSet($conn, $ref_tipe, $ref_id, $setting_id, $postPrefix = 'skala_')
{
    $ref_tipe = mysqli_real_escape_string($conn, $ref_tipe);
    $ref_id = (int)$ref_id;
    $setting_id = (int)$setting_id;

    for ($i = 1; $i <= 5; $i++) {
        $deskripsi = mysqli_real_escape_string($conn, post($postPrefix . $i, ''));

        $cek = q($conn, "SELECT id
                         FROM pr_skala
                         WHERE ref_tipe='$ref_tipe'
                           AND ref_id='$ref_id'
                           AND skala='$i'
                           AND pr_inheren_periode_id='$setting_id'");

        if (mysqli_num_rows($cek) > 0) {
            $r = mysqli_fetch_assoc($cek);
            q($conn, "UPDATE pr_skala
                      SET deskripsi='$deskripsi'
                      WHERE id='" . (int)$r['id'] . "'");
        } else {
            q($conn, "INSERT INTO pr_skala (ref_tipe, ref_id, skala, deskripsi, pr_inheren_periode_id)
                      VALUES ('$ref_tipe', '$ref_id', '$i', '$deskripsi', '$setting_id')");
        }
    }
}

function delete_skala_by_parameter($conn, $parameter_id, $setting_id)
{
    $parameter_id = (int)$parameter_id;
    $setting_id = (int)$setting_id;

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='parameter'
                AND ref_id='$parameter_id'
                AND pr_inheren_periode_id='$setting_id'");

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='sub_parameter'
                AND ref_id IN (
                    SELECT id FROM pr_sub_parameter WHERE parameter_id='$parameter_id' AND pr_inheren_periode_id='$setting_id'
                )
                AND pr_inheren_periode_id='$setting_id'");
}

function delete_skala_by_pilar($conn, $pilar_id, $setting_id)
{
    $pilar_id = (int)$pilar_id;
    $setting_id = (int)$setting_id;

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='parameter'
                AND ref_id IN (
                    SELECT id FROM pr_parameter WHERE pilar_id='$pilar_id' AND pr_inheren_periode_id='$setting_id'
                )
                AND pr_inheren_periode_id='$setting_id'");

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='sub_parameter'
                AND ref_id IN (
                    SELECT sp.id
                    FROM pr_sub_parameter sp
                    JOIN pr_parameter pm ON pm.id = sp.parameter_id
                    WHERE pm.pilar_id='$pilar_id'
                      AND sp.pr_inheren_periode_id='$setting_id'
                      AND pm.pr_inheren_periode_id='$setting_id'
                )
                AND pr_inheren_periode_id='$setting_id'");
}

function delete_skala_by_jenis($conn, $jenis_id, $setting_id)
{
    $jenis_id = (int)$jenis_id;
    $setting_id = (int)$setting_id;

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='parameter'
                AND ref_id IN (
                    SELECT pm.id
                    FROM pr_parameter pm
                    JOIN pr_pilar p ON p.id = pm.pilar_id
                    WHERE p.jenis_risiko_id='$jenis_id'
                      AND p.pr_inheren_periode_id='$setting_id'
                      AND pm.pr_inheren_periode_id='$setting_id'
                )
                AND pr_inheren_periode_id='$setting_id'");

    q($conn, "DELETE FROM pr_skala
              WHERE ref_tipe='sub_parameter'
                AND ref_id IN (
                    SELECT sp.id
                    FROM pr_sub_parameter sp
                    JOIN pr_parameter pm ON pm.id = sp.parameter_id
                    JOIN pr_pilar p ON p.id = pm.pilar_id
                    WHERE p.jenis_risiko_id='$jenis_id'
                      AND p.pr_inheren_periode_id='$setting_id'
                      AND pm.pr_inheren_periode_id='$setting_id'
                      AND sp.pr_inheren_periode_id='$setting_id'
                )
                AND pr_inheren_periode_id='$setting_id'");
}

function getGroupedMatrixData($conn, $setting_id, $namaRisiko, $keyword = '')
{
    $setting_id = (int)$setting_id;
    $namaRisiko = mysqli_real_escape_string($conn, $namaRisiko);
    $keywordSql = '';

    if ($keyword !== '') {
        $keyword = mysqli_real_escape_string($conn, $keyword);
        $keywordSql = " AND (
            p.nama_pilar LIKE '%$keyword%' OR
            pm.nama_parameter LIKE '%$keyword%' OR
            sp.nama_sub_parameter LIKE '%$keyword%'
        ) ";
    }

    $sql = "
        SELECT
            jr.id AS jenis_id,
            jr.nama_risiko,
            p.id AS pilar_id,
            p.nama_pilar,
            p.urutan AS pilar_urutan,
            pm.id AS parameter_id,
            pm.nomor_parameter,
            pm.nama_parameter,
            pm.urutan AS parameter_urutan,
            sp.id AS sub_id,
            sp.nama_sub_parameter,
            sp.urutan AS sub_urutan
        FROM pr_jenis_risiko jr
        JOIN pr_pilar p
            ON p.jenis_risiko_id = jr.id
           AND p.pr_inheren_periode_id = '$setting_id'
        LEFT JOIN pr_parameter pm
            ON pm.pilar_id = p.id
           AND pm.pr_inheren_periode_id = '$setting_id'
        LEFT JOIN pr_sub_parameter sp
            ON sp.parameter_id = pm.id
           AND sp.pr_inheren_periode_id = '$setting_id'
        WHERE jr.nama_risiko = '$namaRisiko'
          AND jr.pr_inheren_periode_id = '$setting_id'
          $keywordSql
        ORDER BY p.urutan, p.id, pm.urutan, pm.id, sp.urutan, sp.id
    ";

    $res = q($conn, $sql);

    $grouped = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $pilarId = (int)$row['pilar_id'];
        $paramId = (int)$row['parameter_id'];
        $subId   = (int)$row['sub_id'];

        if (!isset($grouped[$pilarId])) {
            $grouped[$pilarId] = [
                'jenis_id' => (int)$row['jenis_id'],
                'pilar_id' => $pilarId,
                'nama_pilar' => $row['nama_pilar'],
                'urutan' => $row['pilar_urutan'],
                'parameters' => []
            ];
        }

        if ($paramId > 0 && !isset($grouped[$pilarId]['parameters'][$paramId])) {
            $grouped[$pilarId]['parameters'][$paramId] = [
                'jenis_id' => (int)$row['jenis_id'],
                'pilar_id' => $pilarId,
                'parameter_id' => $paramId,
                'nomor_parameter' => $row['nomor_parameter'],
                'nama_parameter' => $row['nama_parameter'],
                'urutan' => $row['parameter_urutan'],
                'subs' => []
            ];
        }

        if ($paramId > 0 && $subId > 0 && !isset($grouped[$pilarId]['parameters'][$paramId]['subs'][$subId])) {
            $grouped[$pilarId]['parameters'][$paramId]['subs'][$subId] = [
                'jenis_id' => (int)$row['jenis_id'],
                'pilar_id' => $pilarId,
                'parameter_id' => $paramId,
                'sub_id' => $subId,
                'nama_sub_parameter' => $row['nama_sub_parameter'],
                'urutan' => $row['sub_urutan'],
            ];
        }
    }

    return $grouped;
}

function delete_query_or_throw($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    if ($res === false) {
        throw new RuntimeException(mysqli_error($conn));
    }
    return $res;
}

function delete_setting_with_children($conn, $setting_id)
{
    $setting_id = (int)$setting_id;

    if ($setting_id <= 0) {
        return false;
    }

    $cek = simpro_db_query($conn, "SELECT id FROM pr_inheren_periode WHERE id=? LIMIT 1", [$setting_id]);
    if (!$cek || mysqli_num_rows($cek) === 0) {
        return false;
    }

    mysqli_begin_transaction($conn);

    try {
        /* Urutan wajib dari tabel anak paling bawah ke tabel induk. */
        delete_query_or_throw($conn, "DELETE FROM pr_skala WHERE pr_inheren_periode_id='$setting_id'");
        delete_query_or_throw($conn, "DELETE FROM pr_sub_parameter WHERE pr_inheren_periode_id='$setting_id'");
        delete_query_or_throw($conn, "DELETE FROM pr_parameter WHERE pr_inheren_periode_id='$setting_id'");
        delete_query_or_throw($conn, "DELETE FROM pr_pilar WHERE pr_inheren_periode_id='$setting_id'");
        delete_query_or_throw($conn, "DELETE FROM pr_jenis_risiko WHERE pr_inheren_periode_id='$setting_id'");
        delete_query_or_throw($conn, "DELETE FROM pr_inheren_periode WHERE id='$setting_id'");

        if (mysqli_affected_rows($conn) !== 1) {
            throw new RuntimeException('Baris setting tahun tidak terhapus.');
        }

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log('Gagal menghapus setting tahun ID ' . $setting_id . ': ' . $e->getMessage());
        return false;
    }
}

/*
|--------------------------------------------------------------------------
| MODE HALAMAN
|--------------------------------------------------------------------------
*/
$view = getv('view', 'setting');
$setting_id = (int)getv('setting_id', 0);

/*
|--------------------------------------------------------------------------
| TAB AKTIF
|--------------------------------------------------------------------------
*/
/* Tab Kredit dan Likuiditas disembunyikan sesuai request. */
$allowed_tabs = [
    'RISIKO OPERASIONAL',
    'RISIKO KEPATUHAN',
    'RISIKO REPUTASI',
    'RISIKO STRATEJIK'
];
$tab = strtoupper(getv('tab', 'RISIKO OPERASIONAL'));
if (!in_array($tab, $allowed_tabs, true)) {
    $tab = 'RISIKO OPERASIONAL';
}

/*
|--------------------------------------------------------------------------
| ACTION
|--------------------------------------------------------------------------
*/
$action = post('action');

/* =========================
   SETTING TAHUN
   ========================= */
if ($action == 'add_setting_tahun') {
    $tahun = mysqli_real_escape_string($conn, post('tahun'));
    $jenis_parameter = mysqli_real_escape_string($conn, post('jenis_parameter'));

    if ($tahun == '' || $jenis_parameter == '') {
        redirect_with_msg('setting_gagal', ['view' => 'setting']);
    }

    $existing = get_setting_by_year($conn, $tahun, $jenis_parameter);
    if ($existing) {
        redirect_with_msg('setting_duplikat', ['view' => 'setting']);
    }

    $newSettingId = insert_setting_year($conn, $tahun, $jenis_parameter);

    $prev = get_latest_previous_setting($conn, $tahun, $jenis_parameter);
    if ($prev) {
        clone_dataset($conn, $newSettingId, (int)$prev['id']);
        redirect_with_msg('setting_tambah_copy', [
            'view' => 'master',
            'setting_id' => $newSettingId,
            'tab' => 'RISIKO OPERASIONAL'
        ]);
    } else {
        if ($jenis_parameter == 'cabang') {
            $sameYearKonsol = get_setting_by_year($conn, $tahun, 'konsolidasi');
            if ($sameYearKonsol) {
                clone_dataset($conn, $newSettingId, (int)$sameYearKonsol['id']);
                redirect_with_msg('setting_tambah_copy_konsolidasi', [
                    'view' => 'master',
                    'setting_id' => $newSettingId,
                    'tab' => 'RISIKO OPERASIONAL'
                ]);
            }
        }

        if (count_legacy_jenis($conn) > 0) {
            clone_dataset($conn, $newSettingId, null);
            redirect_with_msg('setting_tambah_copy_legacy', [
                'view' => 'master',
                'setting_id' => $newSettingId,
                'tab' => 'RISIKO OPERASIONAL'
            ]);
        } else {
            redirect_with_msg('setting_tambah_kosong', [
                'view' => 'master',
                'setting_id' => $newSettingId,
                'tab' => 'RISIKO OPERASIONAL'
            ]);
        }
    }
}

if ($action == 'delete_setting_tahun') {
    $id = (int)post('id');

    if ($id <= 0) {
        redirect_with_msg('setting_hapus_gagal', ['view' => 'setting']);
    }

    if (delete_setting_with_children($conn, $id)) {
        redirect_with_msg('setting_hapus', ['view' => 'setting']);
    }

    redirect_with_msg('setting_hapus_gagal', ['view' => 'setting']);
}

/* =========================
   MASTER DATA
   ========================= */
if ($action == 'add_jenis_risiko') {
    $setting_id = (int)post('setting_id');
    $nama_risiko = mysqli_real_escape_string($conn, post('nama_risiko'));
    $urutan = (int)post('urutan', 0);

    if ($setting_id > 0 && $nama_risiko != '') {
        q($conn, "INSERT INTO pr_jenis_risiko (nama_risiko, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$nama_risiko', '$urutan', 'Y', '$setting_id')");
        redirect_with_msg('jenis_tambah', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $nama_risiko]);
    }
}

if ($action == 'edit_jenis_risiko') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    $nama_risiko = mysqli_real_escape_string($conn, post('nama_risiko'));
    $urutan = (int)post('urutan', 0);
    $aktif = mysqli_real_escape_string($conn, post('aktif', 'Y'));

    q($conn, "UPDATE pr_jenis_risiko
              SET nama_risiko='$nama_risiko',
                  urutan='$urutan',
                  aktif='$aktif'
              WHERE id='$id'
                AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('jenis_update', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $nama_risiko]);
}

if ($action == 'delete_jenis_risiko') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    delete_skala_by_jenis($conn, $id, $setting_id);
    q($conn, "DELETE FROM pr_sub_parameter WHERE parameter_id IN (
                SELECT id2 FROM (
                    SELECT pm.id AS id2
                    FROM pr_parameter pm
                    JOIN pr_pilar p ON p.id = pm.pilar_id
                    WHERE p.jenis_risiko_id='$id'
                      AND pm.pr_inheren_periode_id='$setting_id'
                      AND p.pr_inheren_periode_id='$setting_id'
              ) x)");
    q($conn, "DELETE FROM pr_parameter WHERE pilar_id IN (
                SELECT id2 FROM (
                    SELECT id AS id2
                    FROM pr_pilar
                    WHERE jenis_risiko_id='$id'
                      AND pr_inheren_periode_id='$setting_id'
              ) x)");
    q($conn, "DELETE FROM pr_pilar WHERE jenis_risiko_id='$id' AND pr_inheren_periode_id='$setting_id'");
    q($conn, "DELETE FROM pr_jenis_risiko WHERE id='$id' AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('jenis_hapus', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'add_pilar') {
    $setting_id = (int)post('setting_id');
    $jenis_risiko_id = (int)post('jenis_risiko_id');
    $nama_pilar = mysqli_real_escape_string($conn, post('nama_pilar'));
    $urutan = (int)post('urutan', 0);

    if ($setting_id > 0 && $jenis_risiko_id > 0 && $nama_pilar != '') {
        q($conn, "INSERT INTO pr_pilar (jenis_risiko_id, nama_pilar, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$jenis_risiko_id', '$nama_pilar', '$urutan', 'Y', '$setting_id')");
        redirect_with_msg('pilar_tambah', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
    }
}

if ($action == 'edit_pilar') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    $jenis_risiko_id = (int)post('jenis_risiko_id');
    $nama_pilar = mysqli_real_escape_string($conn, post('nama_pilar'));
    $urutan = (int)post('urutan', 0);
    $aktif = mysqli_real_escape_string($conn, post('aktif', 'Y'));

    q($conn, "UPDATE pr_pilar
              SET jenis_risiko_id='$jenis_risiko_id',
                  nama_pilar='$nama_pilar',
                  urutan='$urutan',
                  aktif='$aktif'
              WHERE id='$id'
                AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('pilar_update', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'delete_pilar') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    delete_skala_by_pilar($conn, $id, $setting_id);
    q($conn, "DELETE FROM pr_sub_parameter WHERE parameter_id IN (
                SELECT id2 FROM (
                    SELECT id AS id2
                    FROM pr_parameter
                    WHERE pilar_id='$id'
                      AND pr_inheren_periode_id='$setting_id'
                ) x)");
    q($conn, "DELETE FROM pr_parameter WHERE pilar_id='$id' AND pr_inheren_periode_id='$setting_id'");
    q($conn, "DELETE FROM pr_pilar WHERE id='$id' AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('pilar_hapus', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'add_parameter') {
    $setting_id = (int)post('setting_id');
    $pilar_id = (int)post('pilar_id');
    $nomor_parameter = mysqli_real_escape_string($conn, post('nomor_parameter'));
    $nama_parameter = mysqli_real_escape_string($conn, post('nama_parameter'));
    $urutan = (int)post('urutan', 0);

    if ($setting_id > 0 && $pilar_id > 0 && $nama_parameter != '') {
        q($conn, "INSERT INTO pr_parameter (pilar_id, nomor_parameter, nama_parameter, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$pilar_id', '$nomor_parameter', '$nama_parameter', '$urutan', 'Y', '$setting_id')");
        $newId = mysqli_insert_id($conn);
        saveSkalaSet($conn, 'parameter', $newId, $setting_id, 'param_skala_');
        redirect_with_msg('parameter_tambah', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
    }
}

if ($action == 'edit_parameter') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    $pilar_id = (int)post('pilar_id');
    $nomor_parameter = mysqli_real_escape_string($conn, post('nomor_parameter'));
    $nama_parameter = mysqli_real_escape_string($conn, post('nama_parameter'));
    $urutan = (int)post('urutan', 0);
    $aktif = mysqli_real_escape_string($conn, post('aktif', 'Y'));

    q($conn, "UPDATE pr_parameter
              SET pilar_id='$pilar_id',
                  nomor_parameter='$nomor_parameter',
                  nama_parameter='$nama_parameter',
                  urutan='$urutan',
                  aktif='$aktif'
              WHERE id='$id'
                AND pr_inheren_periode_id='$setting_id'");
    saveSkalaSet($conn, 'parameter', $id, $setting_id, 'param_skala_');
    redirect_with_msg('parameter_update', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'delete_parameter') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    delete_skala_by_parameter($conn, $id, $setting_id);
    q($conn, "DELETE FROM pr_sub_parameter WHERE parameter_id='$id' AND pr_inheren_periode_id='$setting_id'");
    q($conn, "DELETE FROM pr_parameter WHERE id='$id' AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('parameter_hapus', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'add_sub_parameter') {
    $setting_id = (int)post('setting_id');
    $parameter_id = (int)post('parameter_id');
    $nama_sub_parameter = mysqli_real_escape_string($conn, post('nama_sub_parameter'));
    $urutan = (int)post('urutan', 0);

    if ($setting_id > 0 && $parameter_id > 0 && $nama_sub_parameter != '') {
        q($conn, "INSERT INTO pr_sub_parameter (parameter_id, nama_sub_parameter, urutan, aktif, pr_inheren_periode_id)
                  VALUES ('$parameter_id', '$nama_sub_parameter', '$urutan', 'Y', '$setting_id')");
        $newId = mysqli_insert_id($conn);
        saveSkalaSet($conn, 'sub_parameter', $newId, $setting_id, 'sub_skala_');
        redirect_with_msg('sub_tambah', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
    }
}

if ($action == 'edit_sub_parameter') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    $parameter_id = (int)post('parameter_id');
    $nama_sub_parameter = mysqli_real_escape_string($conn, post('nama_sub_parameter'));
    $urutan = (int)post('urutan', 0);
    $aktif = mysqli_real_escape_string($conn, post('aktif', 'Y'));

    q($conn, "UPDATE pr_sub_parameter
              SET parameter_id='$parameter_id',
                  nama_sub_parameter='$nama_sub_parameter',
                  urutan='$urutan',
                  aktif='$aktif'
              WHERE id='$id'
                AND pr_inheren_periode_id='$setting_id'");
    saveSkalaSet($conn, 'sub_parameter', $id, $setting_id, 'sub_skala_');
    redirect_with_msg('sub_update', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

if ($action == 'delete_sub_parameter') {
    $id = (int)post('id');
    $setting_id = (int)post('setting_id');
    q($conn, "DELETE FROM pr_skala WHERE ref_tipe='sub_parameter' AND ref_id='$id' AND pr_inheren_periode_id='$setting_id'");
    q($conn, "DELETE FROM pr_sub_parameter WHERE id='$id' AND pr_inheren_periode_id='$setting_id'");
    redirect_with_msg('sub_hapus', ['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab]);
}

/*
|--------------------------------------------------------------------------
| LOAD DATA
|--------------------------------------------------------------------------
*/
$msg = getv('msg');
$qsearch = '';
$openModal = getv('open_modal', '');

$edit_jenis = null;
$edit_pilar = null;
$edit_parameter = null;
$edit_sub = null;

if (getv('edit_jenis_id') != '') {
    $id = (int)getv('edit_jenis_id');
    $edit_jenis = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_jenis_risiko WHERE id='$id'"));
    $openModal = 'modalJenis';
}
if (getv('edit_pilar_id') != '') {
    $id = (int)getv('edit_pilar_id');
    $edit_pilar = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_pilar WHERE id='$id'"));
    $openModal = 'modalPilar';
}
if (getv('edit_parameter_id') != '') {
    $id = (int)getv('edit_parameter_id');
    $edit_parameter = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_parameter WHERE id='$id'"));
    $openModal = 'modalParameter';
}
if (getv('edit_sub_id') != '') {
    $id = (int)getv('edit_sub_id');
    $edit_sub = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_sub_parameter WHERE id='$id'"));
    $openModal = 'modalSub';
}

/*
|--------------------------------------------------------------------------
| DATA AKTIF
|--------------------------------------------------------------------------
*/
$tabEsc = mysqli_real_escape_string($conn, $tab);

$settingAktif = null;
if ($setting_id > 0) {
    $settingAktif = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_inheren_periode WHERE id='$setting_id' LIMIT 1"));
}

$jenisAktif = null;
$jenisAktifId = 0;
$matrixData = [];

if ($setting_id > 0) {
    $jenisAktif = mysqli_fetch_assoc(q($conn, "SELECT * FROM pr_jenis_risiko WHERE nama_risiko='$tabEsc' AND pr_inheren_periode_id='$setting_id' LIMIT 1"));
    $jenisAktifId = isset($jenisAktif['id']) ? (int)$jenisAktif['id'] : 0;
    $matrixData = getGroupedMatrixData($conn, $setting_id, $tab, $qsearch);
}

$listSetting = q($conn, "
    SELECT *
    FROM pr_inheren_periode
    ORDER BY CAST(tahun AS UNSIGNED) DESC,
             FIELD(jenis_parameter, 'konsolidasi', 'cabang'),
             id DESC
");
?>

<style>
    body{background:#f5f6fa;}
    .title-soft{font-size:12px;color:#8b96a5;text-transform:uppercase;letter-spacing:.08em;font-weight:700;}
    .badge-soft{
        background:#eef4ff;
        color:#2563eb;
        padding:.4rem .65rem;
        border-radius:999px;
        font-size:.75rem;
        font-weight:700;
    }
    .tab-risk{
        overflow-x:auto;
        overflow-y:hidden;
        flex-wrap:nowrap;
        white-space:nowrap;
        padding-bottom:2px;
    }
    .tab-risk .nav-link{
        font-weight:700;
        border-radius:8px 8px 0 0;
    }
    .tab-risk .nav-link.active{
        background:#0d6efd;
        color:#fff;
        border-color:#0d6efd;
    }
    .matrix-wrap{
        width:100%;
        overflow-x:hidden;
    }
    .matrix-risk-table{
        width:100%;
        min-width:0;
        margin-bottom:0;
        table-layout:fixed;
    }
    .matrix-risk-table thead th{
        background:#1f252b !important;
        color:#fff !important;
        font-weight:700;
        vertical-align:middle;
        white-space:nowrap;
        border-color:#2b3138 !important;
        padding:.85rem .7rem;
    }
    .matrix-risk-table td{
        vertical-align:top;
        background:#f7f7f7;
        border-color:#e3e6ea !important;
        color:#616b75;
        padding:.9rem .75rem;
        overflow-wrap:anywhere;
        word-break:normal;
    }
    .matrix-pilar-row td{
        background:#59d1d7 !important;
        color:#6b7280 !important;
        font-weight:800;
        font-size:1.05rem;
        padding:1rem 1.1rem !important;
        border-color:#59d1d7 !important;
    }
    .matrix-num{
        width:60px;
        text-align:center;
        font-weight:800;
        color:#6b7280;
        background:#f2f2f2 !important;
    }
    .matrix-risk-table th:first-child,
    .matrix-risk-table td:first-child{
        width:44px !important;
    }
    .matrix-col-parameter{
        width:23%;
        min-width:0;
    }
    .matrix-col-skala{
        width:13.2%;
        min-width:0;
    }
    .matrix-col-aksi{
        width:118px;
        min-width:118px;
        max-width:118px;
    }
    .matrix-param-name{
        font-weight:800;
        color:#5d6772;
        font-size:1.02rem;
        margin-bottom:.2rem;
    }
    .matrix-sub-only{
        font-weight:700;
        color:#6b7280;
        padding-left:18px;
        position:relative;
    }
    .matrix-sub-only:before{
        content:'';
        position:absolute;
        left:6px;
        top:11px;
        width:6px;
        height:6px;
        border-radius:50%;
        background:#8b95a1;
    }
    .matrix-empty{color:#b0b7c3;}
    .matrix-skor{
        line-height:1.55;
        color:#737b86;
        font-size:.9rem;
    }
    .setting-btn{
        display:flex;
        align-items:center;
        justify-content:center;
        width:74px;
        min-width:74px;
        max-width:74px;
        padding:.34rem .45rem;
        font-size:.72rem;
        font-weight:700;
        border-radius:.45rem;
        line-height:1.15;
        margin-left:auto;
        margin-right:auto;
        text-align:center;
        white-space:nowrap;
        box-sizing:border-box;
    }
    .matrix-risk-table td.text-center form{
        display:block !important;
        width:74px;
        margin:0 auto;
    }
    .top-action-btn{
        min-width:170px;
    }
    .modal-lg-2{
        max-width:1100px;
    }
    textarea.form-control{
        min-height:95px;
    }
    .card-clean{
        border:0;
        border-radius:14px;
        box-shadow:0 6px 20px rgba(0,0,0,.05);
    }
    .table-clean thead th{
        background:#eef2f7 !important;
        color:#334155;
        font-weight:700;
        border-color:#e5e7eb !important;
    }
    .table-clean td{
        vertical-align:middle;
    }
    .info-pill{
        display:inline-block;
        padding:.4rem .8rem;
        border-radius:999px;
        background:#f1f5f9;
        color:#0f172a;
        font-weight:600;
        margin-right:.35rem;
    }

    .btn-delete-setting{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        gap:.35rem;
        min-width:82px;
        border-radius:8px;
        font-weight:700;
        box-shadow:0 5px 12px rgba(220,38,38,.16);
    }

    .delete-confirm-modal .modal-dialog{
        max-width:500px;
    }

    .delete-confirm-modal .modal-content{
        border:0;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 28px 80px rgba(15,23,42,.32);
    }

    .delete-confirm-modal .modal-body{
        padding:30px 30px 22px;
        text-align:center;
    }

    .delete-confirm-icon{
        width:72px;
        height:72px;
        margin:0 auto 18px;
        border-radius:22px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:linear-gradient(145deg,#fee2e2,#fff1f2);
        color:#dc2626;
        box-shadow:inset 0 0 0 1px #fecaca;
    }

    .delete-confirm-icon svg{
        width:34px;
        height:34px;
    }

    .delete-confirm-title{
        margin:0 0 8px;
        color:#172033;
        font-size:1.35rem;
        font-weight:800;
    }

    .delete-confirm-text{
        margin:0;
        color:#667085;
        line-height:1.65;
        font-size:.94rem;
    }

    .delete-confirm-record{
        margin:18px 0 14px;
        padding:14px 16px;
        border:1px solid #e5e7eb;
        border-radius:14px;
        background:#f8fafc;
        text-align:left;
    }

    .delete-confirm-record small{
        display:block;
        margin-bottom:3px;
        color:#98a2b3;
        font-size:.7rem;
        font-weight:800;
        letter-spacing:.08em;
        text-transform:uppercase;
    }

    .delete-confirm-record strong{
        color:#1f2937;
        font-size:1rem;
    }

    .delete-confirm-warning{
        display:flex;
        align-items:flex-start;
        gap:10px;
        padding:12px 14px;
        border:1px solid #fed7aa;
        border-radius:12px;
        background:#fff7ed;
        color:#9a3412;
        text-align:left;
        font-size:.82rem;
        line-height:1.55;
    }

    .delete-confirm-warning .warning-mark{
        flex:0 0 auto;
        width:22px;
        height:22px;
        border-radius:50%;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#ffedd5;
        color:#c2410c;
        font-weight:900;
    }

    .delete-confirm-modal .modal-footer{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:10px;
        padding:0 30px 28px;
        border:0;
    }

    .delete-confirm-modal .modal-footer .btn{
        min-height:46px;
        margin:0;
        border-radius:11px;
        font-weight:800;
    }

    @media (max-width:575.98px){
        .delete-confirm-modal .modal-body{padding:24px 20px 18px;}
        .delete-confirm-modal .modal-footer{padding:0 20px 22px;}
    }
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <?php if ($view == 'setting') { ?>
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 mt-3">
                    <div>
                        <div class="title-soft">Setting Awal</div>
                        <h3 class="mb-0">Parameter Inheren</h3>
                    </div>
                </div>

                <?php
                if ($msg == 'setting_tambah') toast('Data tahun berhasil disimpan');
                if ($msg == 'setting_tambah_copy') toast('Tahun baru berhasil dibuat dan otomatis menyalin data dari tahun sebelumnya');
                if ($msg == 'setting_tambah_copy_legacy') toast('Tahun baru berhasil dibuat dan otomatis menyalin data dari data lama / legacy');
                if ($msg == 'setting_tambah_kosong') toast('Tahun baru berhasil dibuat');
                if ($msg == 'setting_hapus') toast('Data setting tahun beserta seluruh isiannya berhasil dihapus', 'success');
                if ($msg == 'setting_hapus_gagal') toast('Data setting gagal dihapus. Silakan cek relasi data atau log server.', 'danger');
                if ($msg == 'setting_duplikat') toast('Tahun tersebut sudah ada', 'warning');
                if ($msg == 'setting_gagal') toast('Tahun wajib diisi', 'danger');
                ?>

                <div class="card card-clean mb-3">
                    <div class="card-body">
                        <form method="post" class="row g-3">
                            <input type="hidden" name="action" value="add_setting_tahun">

                            <div class="col-md-6">
                                <label class="form-label">Masukan tahun</label>
                                <select name="tahun" class="form-select" required>
                                    <option value="">- pilih tahun -</option>
                                    <?php
                                    $tahunAwal = 2026;
                                    $tahunAkhir = (int)date('Y') + 5;
                                    for ($th = $tahunAwal; $th <= $tahunAkhir; $th++) {
                                        echo '<option value="' . $th . '">' . $th . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jenis Parameter</label>
                                <select name="jenis_parameter" class="form-select" required>
                                    <option value="">- pilih jenis parameter -</option>
                                    <option value="konsolidasi">Parameter Konsolidasi</option>
                                    <option value="cabang">Parameter Cabang</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card card-clean">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-clean align-middle">
                                <thead>
                                    <tr>
                                        <th style="width:70px;">No</th>
                                        <th style="width:120px;">Tahun</th>
                                        <th style="width:180px;">Jenis Parameter</th>
                                        <th>Tanggal Dibuat</th>
                                        <th style="width:180px;">Isi Setting</th>
                                        <th style="width:120px;">Hapus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (mysqli_num_rows($listSetting) == 0) {
                                        echo '<tr><td colspan="6" class="text-center text-muted">Belum ada data setting</td></tr>';
                                    } else {
                                        while ($st = mysqli_fetch_assoc($listSetting)) {
                                            echo '<tr>';
                                            echo '<td class="text-center">' . $no++ . '</td>';
                                            echo '<td>' . esc($st['tahun']) . '</td>';
                                            echo '<td>' . esc(ucfirst($st['jenis_parameter'])) . '</td>';
                                            echo '<td>' . esc($st['created_at']) . '</td>';
                                            echo '<td>
                                                    <a href="' . esc(page_url([
                                                        'view' => 'master',
                                                        'setting_id' => $st['id'],
                                                        'tab' => 'RISIKO OPERASIONAL'
                                                    ])) . '" class="btn btn-sm btn-primary">
                                                        Lanjutkan
                                                    </a>
                                                </td>';
                                            $deleteFormId = 'delete-setting-form-' . (int)$st['id'];
                                            $deleteTypeLabel = ucfirst((string)$st['jenis_parameter']);
                                            echo '<td class="text-center">
                                                    <form method="post" action="' . esc(current_page_base_url()) . '" id="' . esc($deleteFormId) . '" class="m-0">
                                                        <input type="hidden" name="action" value="delete_setting_tahun">
                                                        <input type="hidden" name="id" value="' . (int)$st['id'] . '">
                                                        <button type="button"
                                                                class="btn btn-sm btn-danger btn-delete-setting js-open-delete-setting"
                                                                data-form-id="' . esc($deleteFormId) . '"
                                                                data-setting-year="' . esc($st['tahun']) . '"
                                                                data-setting-type="' . esc($deleteTypeLabel) . '">
                                                            <i class="mdi mdi-delete-outline" aria-hidden="true"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php } else { ?>

                <?php if (!$settingAktif) { ?>
                    <div class="alert alert-warning mt-3">
                        Setting tahun belum dipilih.
                        <a href="<?= esc(page_url(['view' => 'setting', 'setting_id' => null])) ?>" class="btn btn-sm btn-primary ms-2">Kembali ke setting awal</a>
                    </div>
                <?php } else { ?>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 mt-3">
                        <div>
                            <div class="title-soft">Master Data</div>
                            <h3 class="mb-1">Profil Risiko Inheren</h3>
                            <div>
                                <span class="info-pill">Tahun: <?= esc($settingAktif['tahun']) ?></span>
<span class="info-pill">Jenis: <?= esc(ucfirst($settingAktif['jenis_parameter'])) ?></span>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="<?= esc(page_url(['view' => 'setting', 'tab' => null, 'edit_jenis_id' => null, 'edit_pilar_id' => null, 'edit_parameter_id' => null, 'edit_sub_id' => null, 'open_modal' => null])) ?>" class="btn btn-outline-secondary">
                                Kembali
                            </a>
                            <div><span class="badge-soft">Popup Input / Edit</span></div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs tab-risk mb-3">
                        <?php foreach ($allowed_tabs as $rt) { ?>
                            <li class="nav-item">
                                <a class="nav-link <?= $tab == $rt ? 'active' : '' ?>"
                                   href="<?= esc(page_url([
                                       'view' => 'master',
                                       'setting_id' => $setting_id,
                                       'tab' => $rt,
                                       'edit_jenis_id' => null,
                                       'edit_pilar_id' => null,
                                       'edit_parameter_id' => null,
                                       'edit_sub_id' => null,
                                       'open_modal' => null
                                   ])) ?>">
                                    <?= esc(str_replace('RISIKO ', '', $rt)) ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <?
                    if ($msg == 'setting_tambah_copy_konsolidasi') toast('Parameter cabang berhasil dibuat dan otomatis menyalin data dari parameter konsolidasi tahun yang sama');
                    if ($msg == 'jenis_tambah') toast('Jenis risiko berhasil ditambahkan');
                    if ($msg == 'jenis_update') toast('Jenis risiko berhasil diubah');
                    if ($msg == 'jenis_hapus') toast('Jenis risiko berhasil dihapus', 'warning');

                    if ($msg == 'pilar_tambah') toast('Pilar berhasil ditambahkan');
                    if ($msg == 'pilar_update') toast('Pilar berhasil diubah');
                    if ($msg == 'pilar_hapus') toast('Pilar berhasil dihapus', 'warning');

                    if ($msg == 'parameter_tambah') toast('Parameter berhasil ditambahkan');
                    if ($msg == 'parameter_update') toast('Parameter berhasil diubah');
                    if ($msg == 'parameter_hapus') toast('Parameter berhasil dihapus', 'warning');

                    if ($msg == 'sub_tambah') toast('Sub parameter berhasil ditambahkan');
                    if ($msg == 'sub_update') toast('Sub parameter berhasil diubah');
                    if ($msg == 'sub_hapus') toast('Sub parameter berhasil dihapus', 'warning');
                    ?>

                    <div class="card mb-3">
                        <div class="card-body d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary top-action-btn" data-bs-toggle="modal" data-bs-target="#modalJenis">Tambah Jenis Risiko</button>
                            <button type="button" class="btn btn-success top-action-btn" data-bs-toggle="modal" data-bs-target="#modalPilar">Tambah Pilar</button>
                            <button type="button" class="btn btn-warning text-dark top-action-btn" data-bs-toggle="modal" data-bs-target="#modalParameter">Tambah Parameter</button>
                            <button type="button" class="btn btn-dark top-action-btn" data-bs-toggle="modal" data-bs-target="#modalSub">Tambah Sub Parameter</button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mb-3">Struktur Master Profil Risiko - <?= esc($tab) ?></h5>

                            <div class="matrix-wrap">
                                <table class="table table-bordered matrix-risk-table">
                                    <thead>
                                        <tr>
                                            <th style="width:60px;">No</th>
                                            <th class="matrix-col-parameter">Parameter / Sub Parameter</th>
                                            <th class="matrix-col-skala">1</th>
                                            <th class="matrix-col-skala">2</th>
                                            <th class="matrix-col-skala">3</th>
                                            <th class="matrix-col-skala">4</th>
                                            <th class="matrix-col-skala">5</th>
                                            <th class="matrix-col-aksi">Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (empty($matrixData)) {
                                        echo '<tr><td colspan="8" class="text-center text-muted">Belum ada data pada tahun ini</td></tr>';
                                    } else {
                                        foreach ($matrixData as $pilar) {
                                            echo '<tr class="matrix-pilar-row">';
                                            echo '<td colspan="7">' . esc($pilar['nama_pilar']) . '</td>';
                                            echo '<td class="text-center">
                                                    <a href="' . esc(page_url(['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab, 'edit_pilar_id' => $pilar['pilar_id'], 'open_modal' => 'modalPilar'])) . '" class="btn btn-sm btn-primary setting-btn mb-1">Edit</a>
                                                    <form method="post" action="' . esc(current_page_base_url()) . '" class="d-inline" onsubmit="return confirm(\'Hapus pilar ini?\')">
                                                        <input type="hidden" name="action" value="delete_pilar">
                                                        <input type="hidden" name="id" value="' . (int)$pilar['pilar_id'] . '">
                                                        <input type="hidden" name="setting_id" value="' . (int)$setting_id . '">
                                                        <button class="btn btn-sm btn-danger setting-btn mb-1">Hapus</button>
                                                    </form>
                                                  </td>';
                                            echo '</tr>';

                                            foreach ($pilar['parameters'] as $param) {
                                                echo '<tr>';
                                                echo '<td class="matrix-num">' . esc($param['nomor_parameter']) . '</td>';
                                                echo '<td class="matrix-col-parameter"><div class="matrix-param-name">' . esc($param['nama_parameter']) . '</div></td>';
                                                echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'parameter', $param['parameter_id'], 1) !== '' ? nl2br(esc(getSkalaValue($conn, 'parameter', $param['parameter_id'], 1))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'parameter', $param['parameter_id'], 2) !== '' ? nl2br(esc(getSkalaValue($conn, 'parameter', $param['parameter_id'], 2))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'parameter', $param['parameter_id'], 3) !== '' ? nl2br(esc(getSkalaValue($conn, 'parameter', $param['parameter_id'], 3))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'parameter', $param['parameter_id'], 4) !== '' ? nl2br(esc(getSkalaValue($conn, 'parameter', $param['parameter_id'], 4))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'parameter', $param['parameter_id'], 5) !== '' ? nl2br(esc(getSkalaValue($conn, 'parameter', $param['parameter_id'], 5))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                echo '<td class="text-center">
                                                        <a href="' . esc(page_url(['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab, 'edit_parameter_id' => $param['parameter_id'], 'open_modal' => 'modalParameter'])) . '" class="btn btn-sm btn-primary setting-btn mb-1">Edit</a>
                                                        <form method="post" action="' . esc(current_page_base_url()) . '" class="d-inline" onsubmit="return confirm(\'Hapus parameter ini?\')">
                                                            <input type="hidden" name="action" value="delete_parameter">
                                                            <input type="hidden" name="id" value="' . (int)$param['parameter_id'] . '">
                                                            <input type="hidden" name="setting_id" value="' . (int)$setting_id . '">
                                                            <button class="btn btn-sm btn-danger setting-btn mb-1">Hapus</button>
                                                        </form>
                                                      </td>';
                                                echo '</tr>';

                                                if (!empty($param['subs'])) {
                                                    $idx = 0;
                                                    foreach ($param['subs'] as $sub) {
                                                        echo '<tr>';
                                                        echo '<td class="matrix-num"></td>';
                                                        echo '<td class="matrix-col-parameter"><div class="matrix-sub-only">' . esc(alphaIndex($idx)) . '. ' . esc($sub['nama_sub_parameter']) . '</div></td>';
                                                        echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 1) !== '' ? nl2br(esc(getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 1))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                        echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 2) !== '' ? nl2br(esc(getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 2))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                        echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 3) !== '' ? nl2br(esc(getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 3))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                        echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 4) !== '' ? nl2br(esc(getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 4))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                        echo '<td class="matrix-skor">' . (getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 5) !== '' ? nl2br(esc(getSkalaValue($conn, 'sub_parameter', $sub['sub_id'], 5))) : '<span class="matrix-empty">-</span>') . '</td>';
                                                        echo '<td class="text-center">
                                                                <a href="' . esc(page_url(['view' => 'master', 'setting_id' => $setting_id, 'tab' => $tab, 'edit_sub_id' => $sub['sub_id'], 'open_modal' => 'modalSub'])) . '" class="btn btn-sm btn-primary setting-btn mb-1">Edit</a>
                                                                <form method="post" action="' . esc(current_page_base_url()) . '" class="d-inline" onsubmit="return confirm(\'Hapus sub parameter ini?\')">
                                                                    <input type="hidden" name="action" value="delete_sub_parameter">
                                                                    <input type="hidden" name="id" value="' . (int)$sub['sub_id'] . '">
                                                                    <input type="hidden" name="setting_id" value="' . (int)$setting_id . '">
                                                                    <button class="btn btn-sm btn-danger setting-btn mb-1">Hapus</button>
                                                                </form>
                                                              </td>';
                                                        echo '</tr>';
                                                        $idx++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>

        </div>
    </div>
</div>


<!-- MODAL KONFIRMASI HAPUS SETTING TAHUN -->
<div class="modal fade delete-confirm-modal" id="deleteSettingModal" tabindex="-1" aria-labelledby="deleteSettingModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="delete-confirm-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18"></path>
                        <path d="M8 6V4h8v2"></path>
                        <path d="M19 6l-1 14H6L5 6"></path>
                        <path d="M10 11v5"></path>
                        <path d="M14 11v5"></path>
                    </svg>
                </div>

                <h5 class="delete-confirm-title" id="deleteSettingModalLabel">Hapus setting tahun?</h5>
                <p class="delete-confirm-text">
                    Periksa kembali data yang akan dihapus. Tindakan ini tidak dapat dibatalkan.
                </p>

                <div class="delete-confirm-record">
                    <small>Setting yang dipilih</small>
                    <strong id="deleteSettingRecord">-</strong>
                </div>

                <div class="delete-confirm-warning">
                    <span class="warning-mark">!</span>
                    <span>Seluruh jenis risiko, pilar, parameter, subparameter, dan skala pada setting tersebut akan ikut dihapus permanen.</span>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Batalkan</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteSettingBtn">
                    <i class="mdi mdi-delete-outline me-1" aria-hidden="true"></i>
                    Ya, Hapus Data
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL JENIS -->
<div class="modal fade" id="modalJenis" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= esc(current_page_base_url()) ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $edit_jenis ? 'Edit Jenis Risiko' : 'Tambah Jenis Risiko' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $edit_jenis ? 'edit_jenis_risiko' : 'add_jenis_risiko' ?>">
                    <input type="hidden" name="setting_id" value="<?= (int)$setting_id ?>">
                    <?php if ($edit_jenis) { ?>
                        <input type="hidden" name="id" value="<?= (int)$edit_jenis['id'] ?>">
                    <?php } ?>

                    <div class="mb-2">
                        <label class="form-label">Nama Risiko</label>
                        <input type="text" name="nama_risiko" class="form-control" value="<?= esc($edit_jenis['nama_risiko'] ?? $tab) ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="<?= esc($edit_jenis['urutan'] ?? ($jenisAktif['urutan'] ?? 0)) ?>">
                    </div>
                    <?php if ($edit_jenis) { ?>
                    <div class="mb-2">
                        <label class="form-label">Aktif</label>
                        <select name="aktif" class="form-select">
                            <option value="Y" <?= (($edit_jenis['aktif'] ?? 'Y') == 'Y' ? 'selected' : '') ?>>Y</option>
                            <option value="N" <?= (($edit_jenis['aktif'] ?? '') == 'N' ? 'selected' : '') ?>>N</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary"><?= $edit_jenis ? 'Update' : 'Simpan' ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PILAR -->
<div class="modal fade" id="modalPilar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= esc(current_page_base_url()) ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $edit_pilar ? 'Edit Pilar' : 'Tambah Pilar' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $edit_pilar ? 'edit_pilar' : 'add_pilar' ?>">
                    <input type="hidden" name="setting_id" value="<?= (int)$setting_id ?>">
                    <?php if ($edit_pilar) { ?>
                        <input type="hidden" name="id" value="<?= (int)$edit_pilar['id'] ?>">
                    <?php } ?>

                    <div class="mb-2">
                        <label class="form-label">Jenis Risiko</label>
                        <select name="jenis_risiko_id" class="form-select" required>
                            <?php
                            $qjr = q($conn, "SELECT * FROM pr_jenis_risiko WHERE nama_risiko='$tabEsc' AND pr_inheren_periode_id='$setting_id' ORDER BY urutan, id");
                            while ($jr = mysqli_fetch_assoc($qjr)) {
                                $sel = (($edit_pilar['jenis_risiko_id'] ?? $jenisAktifId) == $jr['id']) ? 'selected' : '';
                                echo '<option value="' . $jr['id'] . '" ' . $sel . '>' . esc($jr['nama_risiko']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Nama Pilar</label>
                        <input type="text" name="nama_pilar" class="form-control" value="<?= esc($edit_pilar['nama_pilar'] ?? '') ?>" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="<?= esc($edit_pilar['urutan'] ?? 0) ?>">
                    </div>

                    <?php if ($edit_pilar) { ?>
                    <div class="mb-2">
                        <label class="form-label">Aktif</label>
                        <select name="aktif" class="form-select">
                            <option value="Y" <?= (($edit_pilar['aktif'] ?? 'Y') == 'Y' ? 'selected' : '') ?>>Y</option>
                            <option value="N" <?= (($edit_pilar['aktif'] ?? '') == 'N' ? 'selected' : '') ?>>N</option>
                        </select>
                    </div>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success"><?= $edit_pilar ? 'Update' : 'Simpan' ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARAMETER -->
<div class="modal fade" id="modalParameter" tabindex="-1">
    <div class="modal-dialog modal-lg modal-lg-2">
        <div class="modal-content">
            <form method="post" action="<?= esc(current_page_base_url()) ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $edit_parameter ? 'Edit Parameter' : 'Tambah Parameter' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $edit_parameter ? 'edit_parameter' : 'add_parameter' ?>">
                    <input type="hidden" name="setting_id" value="<?= (int)$setting_id ?>">
                    <?php if ($edit_parameter) { ?>
                        <input type="hidden" name="id" value="<?= (int)$edit_parameter['id'] ?>">
                    <?php } ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Pilar</label>
                            <select name="pilar_id" class="form-select" required>
                                <option value="">- pilih -</option>
                                <?php
                                $qp = q($conn, "SELECT p.*, jr.nama_risiko
                                                FROM pr_pilar p
                                                JOIN pr_jenis_risiko jr ON jr.id = p.jenis_risiko_id
                                                WHERE jr.nama_risiko='$tabEsc'
                                                  AND jr.pr_inheren_periode_id='$setting_id'
                                                  AND p.pr_inheren_periode_id='$setting_id'
                                                ORDER BY p.urutan, p.id");
                                while ($p = mysqli_fetch_assoc($qp)) {
                                    $sel = (($edit_parameter['pilar_id'] ?? '') == $p['id']) ? 'selected' : '';
                                    echo '<option value="' . $p['id'] . '" ' . $sel . '>[' . esc($p['nama_risiko']) . '] ' . esc($p['nama_pilar']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nomor Parameter</label>
                            <input type="text" name="nomor_parameter" class="form-control" value="<?= esc($edit_parameter['nomor_parameter'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= esc($edit_parameter['urutan'] ?? 0) ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Parameter</label>
                            <input type="text" name="nama_parameter" class="form-control" value="<?= esc($edit_parameter['nama_parameter'] ?? '') ?>" required>
                        </div>
                        <?php if ($edit_parameter) { ?>
                        <div class="col-md-3">
                            <label class="form-label">Aktif</label>
                            <select name="aktif" class="form-select">
                                <option value="Y" <?= (($edit_parameter['aktif'] ?? 'Y') == 'Y' ? 'selected' : '') ?>>Y</option>
                                <option value="N" <?= (($edit_parameter['aktif'] ?? '') == 'N' ? 'selected' : '') ?>>N</option>
                            </select>
                        </div>
                        <?php } ?>

                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <div class="col-md-6">
                            <label class="form-label">Skala <?= $i ?></label>
                            <textarea name="param_skala_<?= $i ?>" class="form-control"><?= esc($edit_parameter ? getSkalaValue($conn, 'parameter', $edit_parameter['id'], $i) : '') ?></textarea>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning text-dark"><?= $edit_parameter ? 'Update' : 'Simpan' ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL SUB PARAMETER -->
<div class="modal fade" id="modalSub" tabindex="-1">
    <div class="modal-dialog modal-lg modal-lg-2">
        <div class="modal-content">
            <form method="post" action="<?= esc(current_page_base_url()) ?>">
                <div class="modal-header">
                    <h5 class="modal-title"><?= $edit_sub ? 'Edit Sub Parameter' : 'Tambah Sub Parameter' ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="<?= $edit_sub ? 'edit_sub_parameter' : 'add_sub_parameter' ?>">
                    <input type="hidden" name="setting_id" value="<?= (int)$setting_id ?>">
                    <?php if ($edit_sub) { ?>
                        <input type="hidden" name="id" value="<?= (int)$edit_sub['id'] ?>">
                    <?php } ?>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Parameter</label>
                            <select name="parameter_id" class="form-select" required>
                                <option value="">- pilih -</option>
                                <?php
                                $qsp = q($conn, "SELECT pm.id, pm.nama_parameter, pl.nama_pilar, jr.nama_risiko
                                                 FROM pr_parameter pm
                                                 JOIN pr_pilar pl ON pl.id = pm.pilar_id
                                                 JOIN pr_jenis_risiko jr ON jr.id = pl.jenis_risiko_id
                                                 WHERE jr.nama_risiko='$tabEsc'
                                                   AND jr.pr_inheren_periode_id='$setting_id'
                                                   AND pl.pr_inheren_periode_id='$setting_id'
                                                   AND pm.pr_inheren_periode_id='$setting_id'
                                                 ORDER BY pl.urutan, pm.urutan, pm.id");
                                while ($sp = mysqli_fetch_assoc($qsp)) {
                                    $sel = (($edit_sub['parameter_id'] ?? '') == $sp['id']) ? 'selected' : '';
                                    echo '<option value="' . $sp['id'] . '" ' . $sel . '>[' . esc($sp['nama_risiko']) . '] ' . esc($sp['nama_pilar']) . ' - ' . esc($sp['nama_parameter']) . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Urutan</label>
                            <input type="number" name="urutan" class="form-control" value="<?= esc($edit_sub['urutan'] ?? 0) ?>">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Nama Sub Parameter</label>
                            <input type="text" name="nama_sub_parameter" class="form-control" value="<?= esc($edit_sub['nama_sub_parameter'] ?? '') ?>" required>
                        </div>
                        <?php if ($edit_sub) { ?>
                        <div class="col-md-3">
                            <label class="form-label">Aktif</label>
                            <select name="aktif" class="form-select">
                                <option value="Y" <?= (($edit_sub['aktif'] ?? 'Y') == 'Y' ? 'selected' : '') ?>>Y</option>
                                <option value="N" <?= (($edit_sub['aktif'] ?? '') == 'N' ? 'selected' : '') ?>>N</option>
                            </select>
                        </div>
                        <?php } ?>

                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                        <div class="col-md-6">
                            <label class="form-label">Skala <?= $i ?></label>
                            <textarea name="sub_skala_<?= $i ?>" class="form-control"><?= esc($edit_sub ? getSkalaValue($conn, 'sub_parameter', $edit_sub['id'], $i) : '') ?></textarea>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark"><?= $edit_sub ? 'Update' : 'Simpan' ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var openModal = <?= json_encode($openModal) ?>;
    if (openModal) {
        var el = document.getElementById(openModal);
        if (el && typeof bootstrap !== 'undefined') {
            var modal = new bootstrap.Modal(el);
            modal.show();
        }
    }

    var deleteModalEl = document.getElementById('deleteSettingModal');
    var deleteRecordEl = document.getElementById('deleteSettingRecord');
    var confirmDeleteBtn = document.getElementById('confirmDeleteSettingBtn');
    var pendingDeleteForm = null;
    var deleteModal = null;

    if (deleteModalEl && typeof bootstrap !== 'undefined') {
        deleteModal = new bootstrap.Modal(deleteModalEl);
    }

    document.querySelectorAll('.js-open-delete-setting').forEach(function (button) {
        button.addEventListener('click', function () {
            var formId = button.getAttribute('data-form-id');
            var year = button.getAttribute('data-setting-year') || '-';
            var type = button.getAttribute('data-setting-type') || '-';
            pendingDeleteForm = document.getElementById(formId);

            if (!pendingDeleteForm) {
                return;
            }

            if (deleteRecordEl) {
                deleteRecordEl.textContent = 'Tahun ' + year + ' - Parameter ' + type;
            }

            if (deleteModal) {
                deleteModal.show();
            } else if (window.confirm('Hapus setting Tahun ' + year + ' - Parameter ' + type + ' beserta seluruh isinya?')) {
                pendingDeleteForm.submit();
            }
        });
    });

    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', function () {
            if (!pendingDeleteForm) {
                return;
            }

            confirmDeleteBtn.disabled = true;
            confirmDeleteBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>Menghapus...';

            /* submit() dipakai agar form benar-benar dikirim tanpa memicu popup ulang. */
            pendingDeleteForm.submit();
        });
    }

    if (deleteModalEl) {
        deleteModalEl.addEventListener('hidden.bs.modal', function () {
            pendingDeleteForm = null;
            if (confirmDeleteBtn) {
                confirmDeleteBtn.disabled = false;
                confirmDeleteBtn.innerHTML = '<i class="mdi mdi-delete-outline me-1" aria-hidden="true"></i>Ya, Hapus Data';
            }
        });
    }
});
</script>
