<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require dirname(__DIR__, 2).'/conn/conn.php';
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function q($conn, $sql, $label='SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die('<div style="padding:20px;background:#fff;color:#000;font-family:Arial">'
            .'<h3 style="color:red;margin-bottom:10px;">'.esc($label).' ERROR</h3>'
            .'<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>'
            .'<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>'
            .'</div>');
    }
    return $res;
}

function fetch_one($conn, $sql, $label='SQL'){
    $res = q($conn, $sql, $label);
    return mysqli_fetch_assoc($res);
}

function column_exists($conn, $table, $column){
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $q = mysqli_query($conn, "SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $q && mysqli_num_rows($q) > 0;
}

if (!column_exists($conn, 'ambang_batas_kredit', 'user')) {
    die('Kolom user pada ambang_batas_kredit belum ada. Jalankan query alter table terlebih dahulu.');
}
if (!column_exists($conn, 'ambang_batas_likuiditas', 'user')) {
    die('Kolom user pada ambang_batas_likuiditas belum ada. Jalankan query alter table terlebih dahulu.');
}
if (!column_exists($conn, 'ambang_batas_kredit', 'is_active')) {
    die('Kolom is_active pada ambang_batas_kredit belum ada. Jalankan query alter table terlebih dahulu.');
}
if (!column_exists($conn, 'ambang_batas_likuiditas', 'is_active')) {
    die('Kolom is_active pada ambang_batas_likuiditas belum ada. Jalankan query alter table terlebih dahulu.');
}

function clone_ambang_dari_periode_sebelumnya($conn, $table, $pk, $newId, $tahunBaru, $userProfil=0){
    $table = trim($table);
    $pk    = trim($pk);
    $newId = (int)$newId;
    $tahunBaru = (int)$tahunBaru;

    if ($newId <= 0 || $tahunBaru <= 0 || (int)$userProfil <= 0) return;

    $userProfil = (int)$userProfil;
    $prev = mysqli_query($conn, "SELECT * FROM `$table` WHERE user='$userProfil' AND tahun < '$tahunBaru' ORDER BY tahun DESC, `$pk` DESC LIMIT 1");
    if (!$prev || mysqli_num_rows($prev) === 0) return;

    $prevRow = mysqli_fetch_assoc($prev);
    if (!$prevRow) return;

    $cols = mysqli_query($conn, "SHOW COLUMNS FROM `$table`");
    if (!$cols) return;

    $ignore = [$pk, 'tahun', 'user', 'dibuat_at', 'dibuat_by', 'is_active'];
    $sets = [];

    while($c = mysqli_fetch_assoc($cols)){
        $field = $c['Field'];
        if (in_array($field, $ignore, true)) continue;
        if (!array_key_exists($field, $prevRow)) continue;

        $value = mysqli_real_escape_string($conn, (string)$prevRow[$field]);
        $sets[] = "`$field` = '$value'";
    }

    if (!empty($sets)) {
        mysqli_query($conn, "UPDATE `$table` SET ".implode(', ', $sets)." WHERE `$pk` = '$newId'");
    }
}

if (isset($_POST['submit'])) {
    $tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;
    $userProfil = isset($_POST['user']) ? (int)$_POST['user'] : 0;

    $dibuat_at = date('Y-m-d');
    $dibuat_by = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    $query = simpro_db_query($conn, "SELECT * FROM ambang_batas_kredit WHERE tahun = ? AND user=?", [$tahun, $userProfil]);
    $cek_user = $query ? mysqli_num_rows($query) : 0;

    if ($tahun <= 0 || $userProfil <= 0) {
        echo '<script>alert("Tahun dan jenis profil risiko wajib dipilih.");</script>';
    } elseif ($cek_user > 0) {
        echo '<script>alert("Tahun dan jenis profil risiko tersebut sudah ada.");</script>';
    } else {
        mysqli_begin_transaction($conn);
        try {
            q($conn, "INSERT INTO ambang_batas_kredit(id_ambang_batas_kredit,tahun,user,dibuat_at,dibuat_by,is_active)
            VALUES ('0','$tahun','$userProfil','$dibuat_at','$dibuat_by',0)", 'INSERT KREDIT');
            $newKreditId = mysqli_insert_id($conn);

            q($conn, "INSERT INTO ambang_batas_likuiditas(id_ambang_batas_likuiditas,tahun,user,dibuat_at,dibuat_by,is_active)
            VALUES ('0','$tahun','$userProfil','$dibuat_at','$dibuat_by',0)", 'INSERT LIKUIDITAS');
            $newLikuiditasId = mysqli_insert_id($conn);

            clone_ambang_dari_periode_sebelumnya($conn, 'ambang_batas_kredit', 'id_ambang_batas_kredit', $newKreditId, $tahun, $userProfil);
            clone_ambang_dari_periode_sebelumnya($conn, 'ambang_batas_likuiditas', 'id_ambang_batas_likuiditas', $newLikuiditasId, $tahun, $userProfil);

            mysqli_commit($conn);
            header("Location: index.php?page=frame_ambang");
            exit();
        } catch (Exception $e){
            mysqli_rollback($conn);
            die($e->getMessage());
        }
    }
}

if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    if ($id_hapus > 0) {
        $row = fetch_one($conn, "SELECT * FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id_hapus' LIMIT 1", 'GET HAPUS');
        if ($row) {
            $tahun = (int)$row['tahun'];
            $userProfil = isset($row['user']) && $row['user'] !== null ? (int)$row['user'] : 0;
            mysqli_begin_transaction($conn);
            try {
                /*
                 * FIX HAPUS:
                 * - Hapus berdasarkan pasangan tahun + user agar ambang kredit dan likuiditas ikut bersih.
                 * - Tetap hapus id kredit yang diklik sebagai pengaman.
                 * - Pakai backtick `user` karena nama kolom user rawan bentrok.
                 */
                if ($userProfil > 0) {
                    q($conn, "DELETE FROM ambang_batas_likuiditas WHERE tahun='$tahun' AND `user`='$userProfil'", 'DELETE LIKUIDITAS');
                    q($conn, "DELETE FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id_hapus' OR (tahun='$tahun' AND `user`='$userProfil')", 'DELETE KREDIT');
                } else {
                    q($conn, "DELETE FROM ambang_batas_likuiditas WHERE tahun='$tahun' AND (`user` IS NULL OR `user`=0)", 'DELETE LIKUIDITAS LEGACY');
                    q($conn, "DELETE FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id_hapus' OR (tahun='$tahun' AND (`user` IS NULL OR `user`=0))", 'DELETE KREDIT LEGACY');
                }
                mysqli_commit($conn);
                header("Location: index.php?page=frame_ambang&deleted=1");
                exit();
            } catch (Exception $e){
                mysqli_rollback($conn);
                die($e->getMessage());
            }
        } else {
            header("Location: index.php?page=frame_ambang&notfound=1");
            exit();
        }
    }
}

if (isset($_GET['aktifkan'])) {
    $id_aktif = (int)$_GET['aktifkan'];
    if ($id_aktif > 0) {
        $row = fetch_one($conn, "SELECT * FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id_aktif' LIMIT 1", 'GET AKTIF');
        if ($row) {
            $tahun = (int)$row['tahun'];
            $userProfil = isset($row['user']) && $row['user'] !== null ? (int)$row['user'] : 0;
            mysqli_begin_transaction($conn);
            try {
                /*
                 * FIX MULTI AKTIF:
                 * - Mengaktifkan satu setting TIDAK menonaktifkan setting tahun lain.
                 * - Kredit dan likuiditas pada pasangan tahun + jenis profil risiko yang dipilih
                 *   diaktifkan bersama-sama.
                 */
                if ($userProfil > 0) {
                    q($conn, "UPDATE ambang_batas_kredit SET is_active=1 WHERE tahun='$tahun' AND `user`='$userProfil'", 'SET AKTIF KREDIT');
                    q($conn, "UPDATE ambang_batas_likuiditas SET is_active=1 WHERE tahun='$tahun' AND `user`='$userProfil'", 'SET AKTIF LIK');
                } else {
                    q($conn, "UPDATE ambang_batas_kredit SET is_active=1 WHERE id_ambang_batas_kredit='$id_aktif'", 'SET AKTIF KREDIT LEGACY');
                    q($conn, "UPDATE ambang_batas_likuiditas SET is_active=1 WHERE tahun='$tahun' AND (`user` IS NULL OR `user`=0)", 'SET AKTIF LIK LEGACY');
                }
                mysqli_commit($conn);
                header("Location: index.php?page=frame_ambang&active=1");
                exit();
            } catch (Exception $e){
                mysqli_rollback($conn);
                die($e->getMessage());
            }
        }
    }
}

if (isset($_GET['nonaktifkan'])) {
    $id_aktif = (int)$_GET['nonaktifkan'];
    if ($id_aktif > 0) {
        $row = fetch_one($conn, "SELECT * FROM ambang_batas_kredit WHERE id_ambang_batas_kredit='$id_aktif' LIMIT 1", 'GET NONAKTIF');
        if ($row) {
            $tahun = (int)$row['tahun'];
            $userProfil = isset($row['user']) && $row['user'] !== null ? (int)$row['user'] : 0;
            mysqli_begin_transaction($conn);
            try {
                if ($userProfil > 0) {
                    q($conn, "UPDATE ambang_batas_kredit SET is_active=0 WHERE tahun='$tahun' AND user='$userProfil'", 'NONAKTIF KREDIT');
                    q($conn, "UPDATE ambang_batas_likuiditas SET is_active=0 WHERE tahun='$tahun' AND user='$userProfil'", 'NONAKTIF LIK');
                } else {
                    q($conn, "UPDATE ambang_batas_kredit SET is_active=0 WHERE id_ambang_batas_kredit='$id_aktif'", 'NONAKTIF KREDIT LEGACY');
                    q($conn, "UPDATE ambang_batas_likuiditas SET is_active=0 WHERE tahun='$tahun' AND (user IS NULL OR user=0)", 'NONAKTIF LIK LEGACY');
                }
                mysqli_commit($conn);
                header("Location: index.php?page=frame_ambang&inactive=1");
                exit();
            } catch (Exception $e){
                mysqli_rollback($conn);
                die($e->getMessage());
            }
        }
    }
}
?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Penetapan Ambang Batas Kredit Dan Likuiditas</h4>
                    </div>
                </div>
            </div>

            <style>
                .status-badge{
                    display:inline-block;
                    padding:4px 10px;
                    border-radius:999px;
                    font-size:12px;
                    font-weight:600;
                }
                .status-active{background:#dcfce7;color:#166534;}
                .status-inactive{background:#f1f5f9;color:#64748b;}
            </style>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <form class="needs-validation" action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <label class="form-label" for="validationCustom01">
                                        <span>MASUKAN TAHUN PENETAPAN AMBANG BATAS</span>
                                    </label>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tahun" class="form-label">Tahun</label>
                                            <select class="form-select mb-3" name="tahun" id="tahun" required="">
                                                <option value="" selected></option>
                                                <?php for($y=2024;$y<=2037;$y++): ?>
                                                    <option value="<?= $y ?>"><?= $y ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="user" class="form-label">Settingan ditetapkan untuk user :</label>
                                            <select class="form-select mb-3" name="user" id="user" required="">
                                                <option value="" selected></option>
                                                <?php
                                                $query_periode = mysqli_query($conn, "SELECT * FROM user_profil_risiko ORDER BY id_user_profil_risiko ASC");
                                                while ($data = mysqli_fetch_array($query_periode)) { ?>
                                                    <option value="<?= $data['id_user_profil_risiko'] ?>"><?= ucwords($data['tipe_user']) ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="col-lg-1 ">
                                            <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <hr>

                            <div class="tab-content">
                                <div class="tab-pane show active" id="basic-datatable-preview">
                                    <table id="row-callback-datatable" class="table dt-responsive w-100 nowrap">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th><center>No</center></th>
                                                <th><center>Tahun</center></th>
                                                <th><center>Jenis Profil Risiko</center></th>
                                                <th><center>Status</center></th>
                                                <th><center>Tanggal Ditetapkan</center></th>
                                                <th><center>Pembuat Laporan</center></th>
                                                <th><center>Isi Ambang Batas</center></th>
                                                <th><center>Aksi Status</center></th>
                                                <th><center>Hapus</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT ambang_batas_kredit.*, user.nama, user_profil_risiko.tipe_user
                                                FROM ambang_batas_kredit
                                                INNER JOIN user ON ambang_batas_kredit.dibuat_by = user.user_id
                                                LEFT JOIN user_profil_risiko ON ambang_batas_kredit.user = user_profil_risiko.id_user_profil_risiko
                                                ORDER BY id_ambang_batas_kredit DESC");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td><center><?= $no++ ?></center></td>
                                                    <td><center><?= $data['tahun'] ?></center></td>
                                                    <td><center><?= isset($data['tipe_user']) ? $data['tipe_user'] : '-' ?></center></td>
                                                    <td>
                                                        <center>
                                                            <?php if ((int)$data['is_active'] === 1): ?>
                                                                <span class="status-badge status-active">Aktif</span>
                                                            <?php else: ?>
                                                                <span class="status-badge status-inactive">Tidak Aktif</span>
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td><center><?= strtoupper($data['dibuat_at']) ?></center></td>
                                                    <td><center><?= strtoupper($data['nama']) ?></center></td>
                                                    <td>
                                                        <center>
                                                            <a href="index.php?page=ambang&idam=<?= $data['id_ambang_batas_kredit'] ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <?php if ((int)$data['is_active'] === 1): ?>
                                                                <a href="index.php?page=frame_ambang&nonaktifkan=<?= $data['id_ambang_batas_kredit'] ?>">Nonaktifkan</a>
                                                            <?php else: ?>
                                                                <a href="index.php?page=frame_ambang&aktifkan=<?= $data['id_ambang_batas_kredit'] ?>">Aktifkan</a>
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=frame_ambang&hapus=<?= $data['id_ambang_batas_kredit'] ?>"
                                                               class="js-setting-action-confirm"
                                                               data-confirm-title="Hapus Ambang Batas?"
                                                               data-confirm-message="Data ambang batas kredit dan likuiditas pada setting ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan."
                                                               data-confirm-context="<?= htmlspecialchars((isset($data['tipe_user']) ? $data['tipe_user'] : 'Profil Risiko') . ' | Tahun ' . $data['tahun'], ENT_QUOTES, 'UTF-8') ?>"
                                                               data-confirm-label="Ya, Hapus"
                                                               data-confirm-variant="danger"><i class="mdi mdi-delete"></i> hapus</a>
                                                        </center>
                                                    </td>
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
<?php include __DIR__ . '/confirm_setting_action_modal.php'; ?>
