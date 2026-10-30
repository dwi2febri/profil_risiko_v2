<?php
// Read-only selection and receipt status for the admin branch-results page.
function hasil_kc_status_badge(?array $frame): string
{
    if (!$frame) return '<span class="badge badge-secondary-lighten">Belum ada laporan</span>';
    $received = (int)($frame['status_korwil'] ?? 0) === 1
        && (int)($frame['status_skmr'] ?? 0) === 1;
    $label = $received ? 'Diterima Korwil & SKMR'
        : ((int)($frame['status_korwil'] ?? 0) === 1 ? 'Diterima Korwil, belum SKMR' : 'Belum diterima');
    $class = $received ? 'badge-success-lighten' : 'badge-warning-lighten';
    return '<span class="badge ' . $class . '">' . htmlspecialchars($label, ENT_QUOTES, 'UTF-8') . '</span>';
}

if (!isset($conn, $tahun, $periode, $status_laporan)) return;

$hasilStatusSql = $status_laporan === 'diterima'
    ? 'AND frame_laporan_profil_risiko.status_korwil=1 AND frame_laporan_profil_risiko.status_skmr=1'
    : '';
$hasilKCFrames = [];
$hasilFrameResult = mysqli_query($conn, 'SELECT id_profil_risiko,kantor_cabang,status_korwil,status_skmr
    FROM frame_laporan_profil_risiko
    WHERE user=3 AND tahun=' . (int)$tahun . ' AND periode=' . (int)$periode . ' ' . $hasilStatusSql . '
    ORDER BY id_profil_risiko DESC');
while ($hasilFrame = mysqli_fetch_assoc($hasilFrameResult)) {
    $hasilBranch = (int)$hasilFrame['kantor_cabang'];
    if (!isset($hasilKCFrames[$hasilBranch])) $hasilKCFrames[$hasilBranch] = $hasilFrame;
}
