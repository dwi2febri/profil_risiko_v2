<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require dirname(__DIR__, 2).'/conn/conn.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function q($conn, $sql)
{
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        die("SQL Error: " . mysqli_error($conn) . "<hr><pre>" . e($sql) . "</pre>");
    }
    return $res;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    echo '<div class="content-page"><div class="content"><div class="container-fluid"><div class="alert alert-danger mt-3">ID tidak valid.</div></div></div></div>';
    exit;
}

$q_frame = q($conn, "
    SELECT 
        f.*,
        up.tipe_user,
        us.nama AS nama_pembuat
    FROM frame_perumusan f
    LEFT JOIN user_profil_risiko up 
        ON f.user_id = up.id_user_profil_risiko
    LEFT JOIN user us 
        ON f.dibuat_by = us.user_id
    WHERE f.id_frame_perumusan = '$id'
    LIMIT 1
");

if (mysqli_num_rows($q_frame) == 0) {
    echo '<div class="content-page"><div class="content"><div class="container-fluid"><div class="alert alert-danger mt-3">Data perumusan tidak ditemukan.</div></div></div></div>';
    exit;
}

$frame = mysqli_fetch_assoc($q_frame);

$data_inheren = [];
$q_inheren = q($conn, "
    SELECT *
    FROM perumusan_inheren
    WHERE id_frame_perumusan = '$id'
    ORDER BY id_jenis_risiko ASC, id_perumusan_inheren ASC
");
while ($r = mysqli_fetch_assoc($q_inheren)) {
    $data_inheren[] = $r;
}

$data_kpmr = [];
$q_kpmr = q($conn, "
    SELECT *
    FROM perumusan_kpmr
    WHERE id_frame_perumusan = '$id'
    ORDER BY id_jenis_risiko ASC, id_perumusan_kpmr ASC
");
while ($r = mysqli_fetch_assoc($q_kpmr)) {
    $data_kpmr[] = $r;
}
?>

<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex justify-content-between align-items-center">
                        <h4 class="page-title">Detail Setting Perumusan Risiko</h4>
                        <div>
                            <a href="index.php?page=perumusan" class="btn btn-secondary btn-sm">
                                <i class="mdi mdi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFO HEADER -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold">Tahun</label>
                                    <div><?= e($frame['tahun']) ?></div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold">Triwulan</label>
                                    <div><?= e($frame['triwulan']) ?></div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold">Ditetapkan Untuk User</label>
                                    <div><?= e($frame['tipe_user']) ?></div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold">Tanggal Dibuat</label>
                                    <div><?= e($frame['dibuat_at']) ?></div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label fw-bold">Pembuat</label>
                                    <div><?= e($frame['nama_pembuat']) ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL INHEREN -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Perumusan Risiko Inheren</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th width="60"><center>No</center></th>
                                            <th>Nama Risiko</th>
                                            <th width="140"><center>Perskalaan</center></th>
                                            <th width="140"><center>Pembobotan</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($data_inheren)) { ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data risiko inheren.</td>
                                            </tr>
                                        <?php } else { ?>
                                            <?php $no = 1; foreach ($data_inheren as $row) { ?>
                                                <tr>
                                                    <td><center><?= $no++ ?></center></td>
                                                    <td><?= e($row['nama_risiko']) ?></td>
                                                    <td><center><?= ((int)$row['perskalaan'] === 1 ? '✓ Ya' : '-') ?></center></td>
                                                    <td><center><?= ((int)$row['pembobotan'] === 1 ? '✓ Ya' : '-') ?></center></td>
                                                </tr>
                                            <?php } ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- DETAIL KPMR -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Perumusan Risiko KPMR</h4>

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover align-middle">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th width="60"><center>No</center></th>
                                            <th>Nama Risiko</th>
                                            <th width="140"><center>Perskalaan</center></th>
                                            <th width="140"><center>Pembobotan</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($data_kpmr)) { ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada data risiko KPMR.</td>
                                            </tr>
                                        <?php } else { ?>
                                            <?php $no = 1; foreach ($data_kpmr as $row) { ?>
                                                <tr>
                                                    <td><center><?= $no++ ?></center></td>
                                                    <td><?= e($row['nama_risiko']) ?></td>
                                                    <td><center><?= ((int)$row['perskalaan'] === 1 ? '✓ Ya' : '-') ?></center></td>
                                                    <td><center><?= ((int)$row['pembobotan'] === 1 ? '✓ Ya' : '-') ?></center></td>
                                                </tr>
                                            <?php } ?>
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