
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require dirname(__DIR__, 2).'/conn/conn.php';
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_self = 'bobot';

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function postv($k, $d=''){ return isset($_POST[$k]) ? $_POST[$k] : $d; }
function getv($k, $d=''){ return isset($_GET[$k]) ? $_GET[$k] : $d; }

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

if (!column_exists($conn, 'frame_bobot', 'is_aktif')) {
    die('Kolom is_aktif pada tabel frame_bobot belum ada. Jalankan query alter table terlebih dahulu.');
}

function decimal5($n){
    return number_format((float)$n, 5, '.', '');
}

function kredit_default_map(){
    return [
        // Pilar 1
        'sub_parameter1' => decimal5(1/7),
        'sub_parameter2' => decimal5(1/7),
        'sub_parameter3' => decimal5(1/7),
        'sub_parameter5' => decimal5(1/7),
        'sub_parameter6' => decimal5(1/7),
        'sub_parameter7' => decimal5(1/7),
        'sub_parameter8' => decimal5(1/7),

        // Pilar 1 - Kredit yang diberikan
        'sub_parameter2_1' => decimal5(1/11),
        'sub_parameter2_2' => decimal5(1/11),
        'sub_parameter2_3' => decimal5(1/11),
        'sub_parameter2_4' => decimal5(1/11),
        'sub_parameter2_5' => decimal5(1/11),
        'sub_parameter2_6' => decimal5(1/11),
        'sub_parameter2_7' => decimal5(1/11),
        'sub_parameter2_8' => decimal5(1/11),
        'sub_parameter2_9' => decimal5(1/11),
        'sub_parameter2_10' => decimal5(1/11),
        'sub_parameter2_11' => decimal5(1/11),

        // Pilar 2 - Kredit bermasalah neto
        'sub_parameter3_1' => decimal5(1/6),
        'sub_parameter3_2' => decimal5(1/6),
        'sub_parameter3_3' => decimal5(1/6),
        'sub_parameter3_4' => decimal5(1/6),
        'sub_parameter3_5' => decimal5(1/6),
        'sub_parameter3_6' => decimal5(1/6),

        // Pilar 2 - Kredit kualitas rendah
        'sub_parameter4_1' => decimal5(1/4),
        'sub_parameter4_2' => decimal5(1/4),
        'sub_parameter4_3' => decimal5(1/4),
        'sub_parameter4_4' => decimal5(1/4),

        // Pilar 4 - Faktor eksternal
        'sub_parameter6_1' => decimal5(1/4),
        'sub_parameter6_2' => decimal5(1/4),
        'sub_parameter6_3' => decimal5(1/4),
        'sub_parameter6_4' => decimal5(1/4),

        // Lainnya
        'sub_parameter7_1' => decimal5(1/2),
        'sub_parameter7_2' => decimal5(1/2),
    ];
}

function likuiditas_default_map(){
    return [
        // Pilar 1 - Aset likuid / kewajiban lancar
        'sub_parameter2_1' => decimal5(1/9),
        'sub_parameter2_2' => decimal5(1/9),
        'sub_parameter2_3' => decimal5(1/9),
        'sub_parameter2_4' => decimal5(1/9),
        'sub_parameter2_5' => decimal5(1/9),
        'sub_parameter2_6' => decimal5(1/9),
        'sub_parameter2_7' => decimal5(1/9),
        'sub_parameter2_8' => decimal5(1/9),
        'sub_parameter2_9' => decimal5(1/9),

        // Pilar 1 - Kredit diberikan / DPK non bank
        'sub_parameter3_1' => decimal5(1/3),
        'sub_parameter3_2' => decimal5(1/3),
        'sub_parameter3_4' => decimal5(1/3),

        // Pilar 1 - Pendanaan non inti
        'sub_parameter4_1' => decimal5(1/4),
        'sub_parameter4_2' => decimal5(1/4),
        'sub_parameter4_3' => decimal5(1/4),
        'sub_parameter4_4' => decimal5(1/4),

        // Pilar 2
        'sub_parameter5_1' => decimal5(1/3),
        'sub_parameter5_2' => decimal5(1/3),
        'sub_parameter5_3' => decimal5(1/3),

        // Lainnya
        'sub_parameter6_1' => decimal5(1/3),
        'sub_parameter6_2' => decimal5(1/3),
        'sub_parameter6_3' => decimal5(1/3),
    ];
}

function apply_defaults_to_table($conn, $table, $id_bobot, $map){
    if ((int)$id_bobot <= 0 || empty($map)) return;

    $row = fetch_one($conn, "SELECT * FROM `$table` WHERE id_bobot='".(int)$id_bobot."' LIMIT 1", "GET $table");
    if (!$row) return;

    $sets = [];
    foreach ($map as $field => $val){
        $current = isset($row[$field]) ? trim((string)$row[$field]) : '';
        if ($current === '' || $current === '0' || $current === '0.00' || $current === '0.00000'){
            $sets[] = "`$field`='".mysqli_real_escape_string($conn, $val)."'";
        }
    }

    if (!empty($sets)){
        q($conn, "UPDATE `$table` SET ".implode(', ', $sets)." WHERE id_bobot='".(int)$id_bobot."'", "DEFAULT $table");
    }
}

if (isset($_POST['submit'])) {
    $tahun = (int)postv('tahun');
    $user  = (int)postv('user');
    $dibuat_at = date('Y-m-d');
    $dibuat_by = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : 0;

    $dup = fetch_one($conn, "SELECT * FROM frame_bobot WHERE tahun='$tahun' AND user='$user' LIMIT 1", 'CHECK DUP');
    if ($tahun <= 0 || $user <= 0) {
        echo '<script>alert("Tahun dan user wajib dipilih.");</script>';
    } elseif ($dup) {
        echo '<script>alert("Setting bobot untuk tahun dan user tersebut sudah ada.");</script>';
    } else {
        mysqli_begin_transaction($conn);
        try {
            q($conn, "INSERT INTO frame_bobot(id_bobot,tahun,user,is_aktif,dibuat_at,dibuat_by)
                VALUES ('0','$tahun','$user','0','$dibuat_at','$dibuat_by')", 'INSERT frame_bobot');
            $id_bobot = mysqli_insert_id($conn);

            q($conn, "INSERT INTO bobot_kredit_per_pilar(id_bobot_kredit_per_pilar,id_bobot,tahun,dibuat_at,dibuat_by)
                VALUES ('0','$id_bobot','$tahun','$dibuat_at','$dibuat_by')", 'INSERT bobot_kredit_per_pilar');

            q($conn, "INSERT INTO bobot_kredit_per_parameter(id_bobot_kredit_per_parameter,id_bobot,tahun,dibuat_at,dibuat_by)
                VALUES ('0','$id_bobot','$tahun','$dibuat_at','$dibuat_by')", 'INSERT bobot_kredit_per_parameter');

            q($conn, "INSERT INTO bobot_likuiditas_per_pilar(id_bobot_likuiditas_per_pilar,id_bobot,tahun,dibuat_at,dibuat_by)
                VALUES ('0','$id_bobot','$tahun','$dibuat_at','$dibuat_by')", 'INSERT bobot_likuiditas_per_pilar');

            q($conn, "INSERT INTO bobot_likuiditas_per_parameter(id_bobot_likuiditas_per_parameter,id_bobot,tahun,dibuat_at,dibuat_by)
                VALUES ('0','$id_bobot','$tahun','$dibuat_at','$dibuat_by')", 'INSERT bobot_likuiditas_per_parameter');

            apply_defaults_to_table($conn, 'bobot_kredit_per_parameter', $id_bobot, kredit_default_map());
            apply_defaults_to_table($conn, 'bobot_likuiditas_per_parameter', $id_bobot, likuiditas_default_map());

            mysqli_commit($conn);
            header("Location: index.php?page=bobot_tabs&idbobot=".$id_bobot);
            exit();
        } catch (Exception $e){
            mysqli_rollback($conn);
            die($e->getMessage());
        }
    }
}

if (getv('action') === 'aktifkan' && (int)getv('idbobot') > 0) {
    $id_aktif = (int)getv('idbobot');
    $rowAktif = fetch_one($conn, "SELECT id_bobot, user FROM frame_bobot WHERE id_bobot='$id_aktif' LIMIT 1", 'GET frame_bobot aktif');
    if ($rowAktif) {
        $userAktif = (int)$rowAktif['user'];
        q($conn, "UPDATE frame_bobot SET is_aktif='0' WHERE user='$userAktif'", 'NONAKTIFKAN SEMUA PER USER');
        q($conn, "UPDATE frame_bobot SET is_aktif='1' WHERE id_bobot='$id_aktif'", 'AKTIFKAN frame_bobot');
    }
    header("Location: index.php?page=".$page_self."&ok=aktif");
    exit;
}

if (getv('action') === 'nonaktifkan' && (int)getv('idbobot') > 0) {
    $id_nonaktif = (int)getv('idbobot');
    q($conn, "UPDATE frame_bobot SET is_aktif='0' WHERE id_bobot='$id_nonaktif'", 'NONAKTIFKAN frame_bobot');
    header("Location: index.php?page=".$page_self."&ok=nonaktif");
    exit;
}

if (getv('hapus') !== '') {
    $id_hapus = (int)getv('hapus');
    if ($id_hapus > 0){
        mysqli_begin_transaction($conn);
        try {
            q($conn, "DELETE FROM bobot_kredit_per_parameter WHERE id_bobot='$id_hapus'", 'DELETE bobot_kredit_per_parameter');
            q($conn, "DELETE FROM bobot_kredit_per_pilar WHERE id_bobot='$id_hapus'", 'DELETE bobot_kredit_per_pilar');
            q($conn, "DELETE FROM bobot_likuiditas_per_parameter WHERE id_bobot='$id_hapus'", 'DELETE bobot_likuiditas_per_parameter');
            q($conn, "DELETE FROM bobot_likuiditas_per_pilar WHERE id_bobot='$id_hapus'", 'DELETE bobot_likuiditas_per_pilar');
            q($conn, "DELETE FROM frame_bobot WHERE id_bobot='$id_hapus'", 'DELETE frame_bobot');
            mysqli_commit($conn);
            header("Location: index.php?page=".$page_self."&deleted=1");
            exit();
        } catch (Exception $e){
            mysqli_rollback($conn);
            die($e->getMessage());
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
                        <h4 class="page-title">Penetapan Bobot Faktor</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="needs-validation" action="" method="POST">
                                <div class="row">
                                    <label class="form-label" for="validationCustom01">
                                        <span>PENETAPAN BOBOT</span>
                                    </label>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="tahun" class="form-label">Masukan tahun</label>
                                            <select class="form-select mb-3" name="tahun" id="tahun" required>
                                                <option value="" selected></option>
                                                <?php for($y=2024; $y<=2037; $y++): ?>
                                                    <option value="<?= $y ?>"><?= $y ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="user" class="form-label">Settingan ditetapkan untuk user :</label>
                                            <select class="form-select mb-3" name="user" id="user" required>
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
                                        <div class="col-lg-1">
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
                                                <th><center>Settingan Bobot</center></th>
                                                <th><center>Tanggal Ditetapkan</center></th>
                                                <th><center>Pembuat Laporan</center></th>
                                                <th><center>Status</center></th>
                                                <th><center>Aksi</center></th>
                                                <th><center>Isi Bobot Faktor</center></th>
                                                <th><center>hapus</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            $query = mysqli_query($conn, "SELECT * FROM frame_bobot
                                                INNER JOIN user_profil_risiko ON frame_bobot.user = user_profil_risiko.id_user_profil_risiko
                                                INNER JOIN user ON frame_bobot.dibuat_by = user.user_id
                                                ORDER BY id_bobot DESC");
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td><center><?= $no++ ?></center></td>
                                                    <td><center><?= $data['tahun'] ?></center></td>
                                                    <td><center><?= $data['tipe_user'] ?></center></td>
                                                    <td><center><?= strtoupper($data['dibuat_at']) ?></center></td>
                                                    <td><center><?= strtoupper($data['nama']) ?></center></td>
                                                    <td>
                                                        <center>
                                                            <?php if ((int)$data['is_aktif'] === 1): ?>
                                                                <span class="badge bg-success">Aktif</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger">Tidak Aktif</span>
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <?php if ((int)$data['is_aktif'] === 1): ?>
                                                                <a href="index.php?page=<?= $page_self ?>&action=nonaktifkan&idbobot=<?= $data['id_bobot'] ?>" onclick="return confirm('Nonaktifkan setting bobot ini?')">nonaktifkan</a>
                                                            <?php else: ?>
                                                                <a href="index.php?page=<?= $page_self ?>&action=aktifkan&idbobot=<?= $data['id_bobot'] ?>" onclick="return confirm('Aktifkan setting bobot ini?')">aktifkan</a>
                                                            <?php endif; ?>
                                                        </center>
                                                    </td>
                                                    <td>
                                                        <center>
                                                            <a href="index.php?page=bobot_tabs&idbobot=<?= $data['id_bobot'] ?>"><i class="mdi-auto-fix"></i> Lanjutkan</a>
                                                        </center>
                                                    </td>
                                                    <td class="table-action">
                                                        <center>
                                                            <a href="index.php?page=<?= $page_self ?>&hapus=<?= $data['id_bobot'] ?>" onclick="return confirm('Yakin hapus setting bobot ini?')"><i class="mdi mdi-delete"></i> hapus</a>
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
