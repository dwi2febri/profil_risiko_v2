<?php
// Included by trend dashboards after the selected period data has been loaded.
if (!empty($periode_list)) return;

$trendRangeValid = (int)$start_year > 0 && (int)$end_year > 0
    && (int)$start_quarter >= 1 && (int)$start_quarter <= 4
    && (int)$end_quarter >= 1 && (int)$end_quarter <= 4
    && $start_key <= $end_key;
$trendAlternatives = [];
$trendSelectedName = '';
if ($trendRangeValid && $trend_filter_kantor > 0) {
    $trendTypeResult = mysqli_query($conn, 'SELECT tipe_user FROM user_profil_risiko WHERE id_user_profil_risiko=' . (int)$user);
    $trendSelectedName = (string)(mysqli_fetch_assoc($trendTypeResult)['tipe_user'] ?? '');
    // Central dashboards offer these same profile types in their filter.
    if ((int)$user !== 3) {
        $trendAvailableResult = mysqli_query($conn, 'SELECT DISTINCT p.id_user_profil_risiko,p.tipe_user
            FROM frame_laporan_profil_risiko f
            INNER JOIN user_profil_risiko p ON p.id_user_profil_risiko=f.user
            WHERE f.kantor_cabang=' . (int)$trend_filter_kantor . '
              AND (f.tahun * 10 + f.periode) BETWEEN ' . (int)$start_key . ' AND ' . (int)$end_key . '
              AND f.user NOT IN (2,3) AND f.user<>' . (int)$user . '
            ORDER BY p.id_user_profil_risiko');
        while ($trendAvailable = mysqli_fetch_assoc($trendAvailableResult)) {
            $trendAlternatives[] = $trendAvailable;
        }
    }
}
?>
<div class="risk-trend-empty" role="status">
    <?php if (!$trendRangeValid): ?>
        <p>Pilih tahun dan triwulan awal serta akhir yang valid, lalu klik <strong>Cari Tren</strong>.</p>
    <?php elseif ($trend_filter_kantor <= 0): ?>
        <p>Pilih kantor cabang untuk menampilkan data tren.</p>
    <?php else: ?>
        <p>Belum ada laporan<?= $trendSelectedName !== '' ? ' ' . htmlspecialchars($trendSelectedName, ENT_QUOTES, 'UTF-8') : '' ?>
            pada Triwulan <?= (int)$start_quarter ?> <?= (int)$start_year ?> sampai Triwulan <?= (int)$end_quarter ?> <?= (int)$end_year ?> untuk kantor yang dipilih.</p>
        <?php if ($trendAlternatives): ?>
            <p>Data tersedia pada jenis profil berikut:</p>
            <div class="risk-trend-empty-options">
                <?php foreach ($trendAlternatives as $trendAlternative):
                    $trendLinkParameters = $_GET;
                    $trendLinkParameters['user22'] = (int)$trendAlternative['id_user_profil_risiko'];
                    $trendLink = 'index.php?' . http_build_query($trendLinkParameters);
                ?>
                    <a href="<?= htmlspecialchars($trendLink, ENT_QUOTES, 'UTF-8') ?>">Tampilkan <?= htmlspecialchars($trendAlternative['tipe_user'], ENT_QUOTES, 'UTF-8') ?></a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
