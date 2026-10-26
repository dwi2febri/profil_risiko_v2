<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../conn/conn.php";
include "../fungsi/fungsi.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page_self = 'bobot_konsolidasi';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$mode = isset($_GET['mode']) ? trim((string)$_GET['mode']) : 'list';

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }

function q($conn, $sql, $label = 'SQL'){
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die(
            '<div style="padding:20px;background:#fff;color:#000;font-family:Arial;">'
            . '<h3 style="color:red;margin-bottom:10px;">'.esc($label).' ERROR</h3>'
            . '<pre style="white-space:pre-wrap;">'.esc(mysqli_error($conn)).'</pre>'
            . '<hr><pre style="white-space:pre-wrap;">'.esc($sql).'</pre>'
            . '</div>'
        );
    }
    return $res;
}

function fetch_one($conn, $sql, $label = 'SQL'){
    $res = q($conn, $sql, $label);
    return mysqli_fetch_assoc($res);
}

function get_default_rows(){
    return [
        ['jenis_risiko' => 'Risiko Kredit',      'bobot' => 30.00, 'urutan' => 1],
        ['jenis_risiko' => 'Risiko Operasional', 'bobot' => 30.00, 'urutan' => 2],
        ['jenis_risiko' => 'Risiko Kepatuhan',   'bobot' => 20.00, 'urutan' => 3],
        ['jenis_risiko' => 'Risiko Likuiditas',  'bobot' => 10.00, 'urutan' => 4],
        ['jenis_risiko' => 'Risiko Reputasi',    'bobot' => 5.00,  'urutan' => 5],
        ['jenis_risiko' => 'Risiko Stratejik',   'bobot' => 5.00,  'urutan' => 6],
    ];
}

function ensure_default_detail($conn, $id_setting){
    $cek = fetch_one(
        $conn,
        "SELECT COUNT(*) AS jml
         FROM setting_bobot_profil_risiko_detail
         WHERE id_setting='".(int)$id_setting."'",
        'CHECK DETAIL'
    );

    if ((int)($cek['jml'] ?? 0) > 0) return;

    foreach(get_default_rows() as $r){
        q(
            $conn,
            "INSERT INTO setting_bobot_profil_risiko_detail
            (id_setting, jenis_risiko, bobot, urutan)
            VALUES
            (
                '".(int)$id_setting."',
                '".mysqli_real_escape_string($conn, $r['jenis_risiko'])."',
                '".number_format((float)$r['bobot'], 2, '.', '')."',
                '".(int)$r['urutan']."'
            )",
            'INSERT DEFAULT DETAIL'
        );
    }
}

function total_bobot($conn, $id_setting){
    $row = fetch_one(
        $conn,
        "SELECT COALESCE(SUM(bobot),0) AS total
         FROM setting_bobot_profil_risiko_detail
         WHERE id_setting='".(int)$id_setting."'",
        'SUM BOBOT'
    );
    return (float)($row['total'] ?? 0);
}

function get_nama_pembuat(){
    foreach (['nama', 'username', 'full_name', 'name'] as $key){
        if (!empty($_SESSION[$key])) return (string)$_SESSION[$key];
    }
    return 'SATUAN KERJA MANAJEMEN RISIKO';
}

function ensure_required_tables_exist($conn){
    $required = ['setting_bobot_profil_risiko', 'setting_bobot_profil_risiko_detail'];

    foreach ($required as $tb){
        $safe = mysqli_real_escape_string($conn, $tb);
        $cek = mysqli_query($conn, "SHOW TABLES LIKE '$safe'");
        if (!$cek || mysqli_num_rows($cek) == 0){
            die(
                '<div style="padding:20px;background:#fff;color:#000;font-family:Arial;">'
                . '<h3 style="color:red;margin-bottom:10px;">TABLE BELUM ADA</h3>'
                . '<p>Silakan jalankan query create table terlebih dahulu untuk tabel: <b>'.esc($tb).'</b></p>'
                . '</div>'
            );
        }
    }
}

ensure_required_tables_exist($conn);

/* =========================
   CREATE HEADER
========================= */
if (isset($_POST['submit_buat_setting'])) {
    $tahun = isset($_POST['tahun']) ? (int)$_POST['tahun'] : 0;

    if ($tahun <= 0) {
        echo "<script>alert('Tahun wajib dipilih.');window.location='index.php?page=".$page_self."';</script>";
        exit;
    }

    $cek = fetch_one(
        $conn,
        "SELECT id_setting
         FROM setting_bobot_profil_risiko
         WHERE tahun='$tahun'
         LIMIT 1",
        'CHECK TAHUN'
    );

    if ($cek) {
        ensure_default_detail($conn, (int)$cek['id_setting']);
        echo "<script>alert('Setting tahun ".$tahun." sudah ada.');window.location='index.php?page=".$page_self."&mode=edit&id=".(int)$cek['id_setting']."';</script>";
        exit;
    }

    $nama_pembuat = mysqli_real_escape_string($conn, get_nama_pembuat());
    $dibuat_oleh = (int)($_SESSION['user_id'] ?? 0);

    q(
        $conn,
        "INSERT INTO setting_bobot_profil_risiko
        (tahun, is_aktif, dibuat_oleh, nama_pembuat)
        VALUES
        ('$tahun', 0, '$dibuat_oleh', '$nama_pembuat')",
        'INSERT HEADER'
    );

    $newId = mysqli_insert_id($conn);
    ensure_default_detail($conn, $newId);

    header("Location: index.php?page=".$page_self."&mode=edit&id=".$newId);
    exit;
}

/* =========================
   AKTIFKAN / NONAKTIFKAN
   HANYA DIPAKAI DARI HALAMAN EDIT
========================= */
if (isset($_GET['action']) && $_GET['action'] === 'aktifkan' && $id > 0) {
    q($conn, "UPDATE setting_bobot_profil_risiko SET is_aktif=0", 'RESET ACTIVE');
    q($conn, "UPDATE setting_bobot_profil_risiko SET is_aktif=1 WHERE id_setting='".(int)$id."'", 'SET ACTIVE');
    header("Location: index.php?page=".$page_self."&mode=edit&id=".$id);
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'nonaktifkan' && $id > 0) {
    q($conn, "UPDATE setting_bobot_profil_risiko SET is_aktif=0 WHERE id_setting='".(int)$id."'", 'SET NONAKTIF');
    header("Location: index.php?page=".$page_self."&mode=edit&id=".$id);
    exit;
}

/* =========================
   HAPUS
========================= */
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && $id > 0) {
    q($conn, "DELETE FROM setting_bobot_profil_risiko WHERE id_setting='".(int)$id."'", 'DELETE HEADER');
    header("Location: index.php?page=".$page_self);
    exit;
}

/* =========================
   SIMPAN DETAIL BOBOT
========================= */
if (isset($_POST['submit_simpan_bobot']) && $id > 0) {
    $detail_ids = isset($_POST['detail_id']) ? (array)$_POST['detail_id'] : [];
    $bobots     = isset($_POST['bobot']) ? (array)$_POST['bobot'] : [];

    foreach ($detail_ids as $k => $detail_id){
        $detail_id = (int)$detail_id;
        $bobot = isset($bobots[$k]) ? (float)str_replace(',', '.', (string)$bobots[$k]) : 0;
        if ($bobot < 0) $bobot = 0;

        q(
            $conn,
            "UPDATE setting_bobot_profil_risiko_detail
             SET bobot='".number_format($bobot, 2, '.', '')."'
             WHERE id_detail='$detail_id'
             AND id_setting='".(int)$id."'",
            'UPDATE DETAIL'
        );
    }

    header("Location: index.php?page=".$page_self."&mode=edit&id=".$id."&saved=1");
    exit;
}

$list = q(
    $conn,
    "SELECT *
     FROM setting_bobot_profil_risiko
     ORDER BY tahun DESC, id_setting DESC",
    'LIST HEADER'
);

$editHeader  = null;
$editDetails = [];
$editTotal   = 0;

if ($mode === 'edit' && $id > 0){
    $editHeader = fetch_one(
        $conn,
        "SELECT *
         FROM setting_bobot_profil_risiko
         WHERE id_setting='".(int)$id."'
         LIMIT 1",
        'READ HEADER'
    );

    if ($editHeader){
        ensure_default_detail($conn, $id);

        $d = q(
            $conn,
            "SELECT *
             FROM setting_bobot_profil_risiko_detail
             WHERE id_setting='".(int)$id."'
             ORDER BY urutan ASC, id_detail ASC",
            'READ DETAIL'
        );

        while($r = mysqli_fetch_assoc($d)){
            $editDetails[] = $r;
        }

        $editTotal = total_bobot($conn, $id);
    }
}

$currentYear = (int)date('Y');
$years = [];
for($y = $currentYear - 2; $y <= $currentYear + 5; $y++){
    $years[] = $y;
}
?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Setting Bobot Profil Risiko</h4>
                    </div>
                </div>
            </div>

            <?php if ($mode === 'edit' && $editHeader): ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background-color:#2f5fa7;color:#fff;">
                                <h4 class="page-title mb-0">Isi Bobot Profil Risiko Tahun <?= esc($editHeader['tahun']) ?></h4>
                            </div>

                            <div class="card-body">
                                <div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
                                    <a href="index.php?page=<?= esc($page_self) ?>"
                                       class="btn btn-secondary btn-sm"
                                       style="background:#7f8c99;border-color:#7f8c99;">
                                        ← Kembali
                                    </a>

                                    <?php if ((int)$editHeader['is_aktif'] !== 1): ?>
                                        <a href="index.php?page=<?= esc($page_self) ?>&action=aktifkan&id=<?= (int)$editHeader['id_setting'] ?>"
                                           class="btn btn-sm"
                                           style="background:#20c997;border-color:#20c997;color:#fff;">
                                            Aktifkan
                                        </a>
                                        <span class="badge" style="background:#adb5bd;font-size:12px;">Nonaktif</span>
                                    <?php else: ?>
                                        <a href="index.php?page=<?= esc($page_self) ?>&action=nonaktifkan&id=<?= (int)$editHeader['id_setting'] ?>"
                                           class="btn btn-sm"
                                           style="background:#dc3545;border-color:#dc3545;color:#fff;">
                                            Nonaktifkan
                                        </a>
                                        <span class="badge" style="background:#20c997;font-size:12px;">Aktif</span>
                                    <?php endif; ?>
                                </div>

                                <form method="POST"
                                      action="index.php?page=<?= esc($page_self) ?>&mode=edit&id=<?= (int)$editHeader['id_setting'] ?>"
                                      id="formBobot">

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-centered mb-0">
                                            <thead>
                                                <tr style="background:#12203a;color:#fff;">
                                                    <th style="width:50%">Jenis Risiko</th>
                                                    <th style="width:50%;text-align:center;">Bobot Penetapan<br>Bobot %</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach($editDetails as $row): ?>
                                                    <tr>
                                                        <th style="background:#f3f4f6;vertical-align:middle;font-size:16px;font-weight:600;text-align:left;padding:16px 14px;color:#5b6777;">
                                                            <?= esc($row['jenis_risiko']) ?>
                                                        </th>

                                                        <td style="background:#fff7d6;vertical-align:middle;text-align:center;padding:16px;">
                                                            <input type="hidden" name="detail_id[]" value="<?= (int)$row['id_detail'] ?>">

                                                            <input type="number"
                                                                   step="0.01"
                                                                   min="0"
                                                                   name="bobot[]"
                                                                   class="form-control bobot-input"
                                                                   value="<?= number_format((float)$row['bobot'], 2, '.', '') ?>"
                                                                   style="max-width:140px;margin:0 auto;text-align:center;font-weight:600;font-size:14px;background:#fff7d6;border:1px solid #d9c27a;color:#495057;height:36px;">
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>

                                                <tr>
                                                    <th style="background:#2f76b7;color:#fff;vertical-align:middle;font-size:16px;font-weight:700;text-align:center;">
                                                        Peringkat Risiko ditetapkan berdasarkan
                                                    </th>

                                                    <th id="totalBobotBox"
                                                        style="background:#2f76b7;color:#fff;vertical-align:middle;font-size:16px;font-weight:700;text-align:center;">
                                                        <?= number_format($editTotal, 2, '.', '') ?>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" name="submit_simpan_bobot" class="btn btn-primary btn-sm">
                                            Simpan Bobot
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php else: ?>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Masukan Tahun Setting Bobot</h4>

                                <form method="POST" action="index.php?page=<?= esc($page_self) ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Tahun</label>
                                            <select name="tahun" class="form-control" required>
                                                <option value="">-- pilih tahun --</option>
                                                <?php foreach($years as $y): ?>
                                                    <option value="<?= $y ?>"><?= $y ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" name="submit_buat_setting" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>

                                <hr>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-centered mb-0">
                                        <thead>
                                            <tr style="background:#eef2f7;">
                                                <th style="width:5%">No</th>
                                                <th style="width:10%">Tahun</th>
                                                <th style="width:15%">Tanggal Ditetapkan</th>
                                                <th style="width:20%">Pembuat Laporan</th>
                                                <th style="width:10%">Status</th>
                                                <th style="width:10%">Isi Bobot</th>
                                                <th style="width:10%">Hapus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            mysqli_data_seek($list, 0);
                                            $no = 1;
                                            while($row = mysqli_fetch_assoc($list)):
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= esc($row['tahun']) ?></td>
                                                <td><?= esc(date('Y-m-d', strtotime($row['created_at']))) ?></td>
                                                <td><?= esc($row['nama_pembuat'] !== '' ? $row['nama_pembuat'] : 'SATUAN KERJA MANAJEMEN RISIKO') ?></td>
                                                <td>
                                                    <?php if ((int)$row['is_aktif'] === 1): ?>
                                                        <span class="badge" style="background:#20c997;">Aktif</span>
                                                    <?php else: ?>
                                                        <span class="badge" style="background:#adb5bd;">Nonaktif</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <a href="index.php?page=<?= esc($page_self) ?>&mode=edit&id=<?= (int)$row['id_setting'] ?>">Lanjutkan</a>
                                                </td>
                                                <td>
                                                    <a href="index.php?page=<?= esc($page_self) ?>&action=hapus&id=<?= (int)$row['id_setting'] ?>"
                                                       class="js-setting-action-confirm"
                                                       data-confirm-title="Hapus Bobot Konsolidasi?"
                                                       data-confirm-message="Seluruh isi bobot konsolidasi untuk tahun ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan."
                                                       data-confirm-context="Tahun <?= esc($row['tahun']) ?>"
                                                       data-confirm-label="Ya, Hapus"
                                                       data-confirm-variant="danger"><i class="mdi mdi-delete-outline"></i> hapus</a>
                                                </td>
                                            </tr>
                                            <?php endwhile; ?>

                                            <?php if (mysqli_num_rows($list) == 0): ?>
                                                <tr>
                                                    <td colspan="7" style="text-align:center;">Belum ada setting bobot.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>

<?php include __DIR__ . '/confirm_setting_action_modal.php'; ?>

<script>
(function(){
    var inputs = document.querySelectorAll('.bobot-input');
    var totalBox = document.getElementById('totalBobotBox');
    if (!inputs.length || !totalBox) return;

    function updateTotal(){
        var total = 0;

        inputs.forEach(function(el){
            var v = parseFloat(el.value || 0);
            if (!isNaN(v)) total += v;
        });

        totalBox.textContent = total.toFixed(2);

        if (total > 100) {
            totalBox.style.background = '#e55353';
            totalBox.style.color = '#fff';
        } else {
            totalBox.style.background = '#2f76b7';
            totalBox.style.color = '#fff';
        }
    }

    inputs.forEach(function(el){
        el.addEventListener('input', updateTotal);
        el.addEventListener('change', updateTotal);
    });

    updateTotal();
})();
</script>
