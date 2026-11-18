<?php
if (session_status() !== PHP_SESSION_ACTIVE || empty($_SESSION['user_id']) || !isset($conn) || !($conn instanceof mysqli)) {
    http_response_code(403);
    exit('Akses ditolak.');
}
$logAdmin = ($_SESSION['tipe'] ?? '') === 'admin';
$logEscape = static fn($value): string => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$logInput = static fn(string $key): string => is_string($_GET[$key] ?? null) ? trim($_GET[$key]) : '';
require_once __DIR__.'/activity_log_filters.php';
[$logFilters, $logActions, $logClause, $logParams] = simpro_activity_filters($_GET, $_SESSION);
$logError = ''; $logRows = []; $logTotal = 0;
$logNumber = max(1, min(1000000, (int)$logInput('nomor')));
try {
    $result = simpro_db_query($conn, 'SELECT COUNT(*) AS jumlah FROM log_aktivitas'.$logClause, $logParams);
    if (!$result) throw new RuntimeException('Log unavailable');
    $logTotal = (int)mysqli_fetch_assoc($result)['jumlah'];
    $logPages = max(1, (int)ceil($logTotal / 50));
    $logNumber = min($logNumber, $logPages);
    $result = simpro_db_query($conn, 'SELECT * FROM log_aktivitas'.$logClause.' ORDER BY waktu DESC, id DESC LIMIT 50 OFFSET '.(($logNumber - 1) * 50), $logParams);
    if (!$result) throw new RuntimeException('Log unavailable');
    $logRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
} catch (Throwable $error) {
    $logError = 'Log aktivitas belum tersedia. Jalankan file SQL database/20261118_log_aktivitas.sql pada database aplikasi.';
}
$logLink = static fn(int $number): string => 'index.php?'.http_build_query(array_merge(['page'=>'log_aktivitas'], $logFilters, ['nomor'=>$number]));
?>
<?php require __DIR__.'/user_page_layout.php'; ?>
<div class="content-page simpro-user-page"><div class="content"><div class="container-fluid">
<div class="row"><div class="col-12"><div class="card"><div class="card-body">
    <h4 class="header-title mb-2">Log Aktivitas</h4>
    <p class="text-muted">Riwayat aktivitas <?= $logAdmin ? 'seluruh pengguna' : 'akun Anda' ?>. Waktu ditampilkan dalam WIB.</p>
    <form method="get" action="index.php" class="row g-2 mb-3">
        <input type="hidden" name="page" value="log_aktivitas">
        <div class="col-md-2"><label class="form-label" for="log-mulai">Dari tanggal</label><input class="form-control" type="date" id="log-mulai" name="mulai" value="<?= $logEscape($logFilters['mulai']) ?>"></div>
        <div class="col-md-2"><label class="form-label" for="log-sampai">Sampai tanggal</label><input class="form-control" type="date" id="log-sampai" name="sampai" value="<?= $logEscape($logFilters['sampai']) ?>"></div>
        <div class="col-md-3"><label class="form-label" for="log-aktivitas">Aktivitas</label><select class="form-select" id="log-aktivitas" name="aktivitas"><option value="">Semua aktivitas</option><?php foreach ($logActions as $action): ?><option <?= $logFilters['aktivitas'] === $action ? 'selected' : '' ?> value="<?= $logEscape($action) ?>"><?= $logEscape($action) ?></option><?php endforeach; ?></select></div>
        <div class="col-md-3"><label class="form-label" for="log-cari">Cari pengguna / halaman / ID data</label><input class="form-control" id="log-cari" name="cari" maxlength="100" value="<?= $logEscape($logFilters['cari']) ?>"></div>
        <div class="col-md-2 d-flex align-items-end gap-1"><button class="btn btn-primary" type="submit">Cari</button><a class="btn btn-light" href="index.php?page=log_aktivitas">Reset</a></div>
    </form>
    <?php if ($logError): ?><div class="alert alert-warning"><?= $logEscape($logError) ?></div><?php else: ?>
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <a class="btn btn-success" href="<?= $logEscape(simpro_app_base_path().'fungsi/export_log_aktivitas.php?'.http_build_query($logFilters)) ?>"><i class="uil-file-download"></i> Export Excel</a>
    <span><?= number_format($logTotal, 0, ',', '.') ?> aktivitas tercatat.</span></div>
    <div class="table-responsive"><table class="table table-bordered table-striped align-middle">
        <thead><tr><th>Waktu (WIB)</th><th>Pengguna</th><th>Role</th><th>Aktivitas</th><th>Halaman / ID data</th><th>Metode</th><th>Status HTTP</th><th>Alamat IP</th></tr></thead>
        <tbody><?php foreach ($logRows as $row): ?><tr>
            <td class="text-nowrap"><?= $logEscape($row['waktu']) ?></td>
            <td><?= $logEscape($row['nama'] ?: 'Pengguna tidak dikenal') ?></td>
            <td><?= $logEscape($row['role']) ?></td><td><?= $logEscape($row['aktivitas']) ?></td>
            <td style="overflow-wrap:anywhere;max-width:420px"><?= $logEscape($row['halaman']) ?><br><small><?= $logEscape($row['id_data']) ?></small></td>
            <td><?= $logEscape($row['metode']) ?></td><td><?= $logEscape($row['status_http']) ?></td><td><?= $logEscape($row['alamat_ip']) ?></td>
        </tr><?php endforeach; ?><?php if (!$logRows): ?><tr><td colspan="8" class="text-center">Belum ada aktivitas sesuai filter.</td></tr><?php endif; ?></tbody>
    </table></div>
    <div class="d-flex justify-content-between align-items-center"><span>Halaman <?= $logNumber ?> dari <?= $logPages ?></span><div>
    <?php if ($logNumber > 1): ?><a class="btn btn-light" href="<?= $logEscape($logLink($logNumber - 1)) ?>">Sebelumnya</a><?php endif; ?>
    <?php if ($logNumber < $logPages): ?><a class="btn btn-light" href="<?= $logEscape($logLink($logNumber + 1)) ?>">Berikutnya</a><?php endif; ?>
    </div></div>
    <?php endif; ?>
    <p class="text-muted mt-3 mb-0"><small>Status HTTP menunjukkan respons permintaan, bukan jaminan perubahan data berhasil. Pencatatan dimulai setelah fitur dan tabel log dipasang.</small></p>
</div></div></div></div>
</div></div></div>
