<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../conn/conn.php";

function iq_esc($str){
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

function iq_q($conn, $sql){
    $q = mysqli_query($conn, $sql);
    if (!$q) {
        die("Query error: " . mysqli_error($conn));
    }
    return $q;
}

iq_q($conn, "CREATE TABLE IF NOT EXISTS info_kuantitatif_inheren (
    id_info INT AUTO_INCREMENT PRIMARY KEY,
    risiko ENUM('kredit','likuiditas') NOT NULL,
    parameter_key VARCHAR(50) NOT NULL,
    parameter_label VARCHAR(255) NOT NULL,
    info_text TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_info_kuantitatif (risiko, parameter_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$PARAMETERS = [
    'kredit' => [
        'ket_pil1_1' => 'Aset Produktif / Total Aset',
        'ket_pil1_2' => 'Debitur Inti / Total Kredit',
        'ket_pil1_3' => 'Kredit Kepada Pihak Terkait / Total Kredit',
        'ket_pil1_4' => 'Kredit Sektor Ekonomi Utama / Total Kredit',
        'ket_pil2_1' => 'Kredit Bermasalah / Total Kredit',
        'ket_pil2_2' => 'Kredit Kualitas Rendah / Total Kredit',
        'ket_pil2_3' => 'Kredit Restrukturisasi / Total Kredit',
        'ket_pil3_1' => 'Strategi Penyediaan Dana',
        'ket_pil4_1' => 'Faktor Eksternal',
        'ket_pil5_1' => 'Lainnya',
    ],
    'likuiditas' => [
        'ket_pil1_1' => 'Aset Likuid Primer dan Sekunder / Total Aset',
        'ket_pil1_2' => 'Aset Likuid Primer dan Sekunder / Pendanaan Jangka Pendek',
        'ket_pil1_3' => 'Kredit / Dana Pihak Ketiga',
        'ket_pil1_4' => 'Kredit / Total Aset',
        'ket_pil1_5' => 'Aset Likuid / Kewajiban Segera',
        'ket_pil2_1' => 'Ketergantungan Pada Deposan Inti',
        'ket_pil2_2' => 'Sumber Pendanaan',
        'ket_pil3_1' => 'Lainnya',
    ],
];

$notif = '';
$notifType = 'success';

if (isset($_POST['save_info_kuantitatif'])) {
    foreach ($PARAMETERS as $risiko => $rows) {
        foreach ($rows as $key => $label) {
            $field = $risiko . '__' . $key;
            $info = mysqli_real_escape_string($conn, trim((string)($_POST[$field] ?? '')));
            $risikoSql = mysqli_real_escape_string($conn, $risiko);
            $keySql = mysqli_real_escape_string($conn, $key);
            $labelSql = mysqli_real_escape_string($conn, $label);
            iq_q($conn, "
                INSERT INTO info_kuantitatif_inheren
                    (risiko, parameter_key, parameter_label, info_text)
                VALUES
                    ('$risikoSql', '$keySql', '$labelSql', '$info')
                ON DUPLICATE KEY UPDATE
                    parameter_label = VALUES(parameter_label),
                    info_text = VALUES(info_text)
            ");
        }
    }
    $notif = 'Info kuantitatif berhasil disimpan.';
}

$saved = [];
$qSaved = iq_q($conn, "SELECT * FROM info_kuantitatif_inheren");
while ($r = mysqli_fetch_assoc($qSaved)) {
    $saved[$r['risiko']][$r['parameter_key']] = $r['info_text'];
}

$sqlCopy = "CREATE TABLE info_kuantitatif_inheren (
    id_info INT AUTO_INCREMENT PRIMARY KEY,
    risiko ENUM('kredit','likuiditas') NOT NULL,
    parameter_key VARCHAR(50) NOT NULL,
    parameter_label VARCHAR(255) NOT NULL,
    info_text TEXT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_info_kuantitatif (risiko, parameter_key)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
?>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Info Kuantitatif</h4>
                    </div>
                </div>
            </div>

            <?php if ($notif !== '') { ?>
                <div class="alert alert-<?= iq_esc($notifType) ?> alert-dismissible fade show" role="alert">
                    <?= iq_esc($notif) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="card infoq-card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                        <div>
                            <h4 class="header-title mb-1">Setting Info Kuantitatif Inheren</h4>
                            <p class="text-muted mb-0">Isi teks bantuan untuk parameter Inheren Kredit dan Likuiditas. Teks ini muncul dari icon info pada kolom keterangan.</p>
                        </div>
                       
                    </div>

                   

                    <form method="POST">
                        <input type="hidden" name="save_info_kuantitatif" value="1">
                        <ul class="nav nav-tabs infoq-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#infoqKredit" type="button" role="tab">Kredit</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#infoqLikuiditas" type="button" role="tab">Likuiditas</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-3">
                            <?php foreach ($PARAMETERS as $risiko => $rows) { ?>
                                <div class="tab-pane <?= $risiko === 'kredit' ? 'show active' : '' ?>" id="infoq<?= ucfirst($risiko) ?>" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-bordered align-middle infoq-table">
                                            <thead>
                                                <tr>
                                                    <th style="width:58%">Parameter</th>
                                                    <th>Info kuantitatif</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($rows as $key => $label) { ?>
                                                    <tr>
                                                        <td>
                                                            <b><?= iq_esc($label) ?></b>
                                                            <div class="text-muted small"><?= iq_esc(strtoupper($risiko)) ?> - <?= iq_esc($key) ?></div>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control" rows="4" name="<?= iq_esc($risiko . '__' . $key) ?>" placeholder="Tulis info kuantitatif untuk parameter ini..."><?= iq_esc($saved[$risiko][$key] ?? '') ?></textarea>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Info</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.infoq-card{border:0;box-shadow:0 10px 28px rgba(15,23,42,.08);border-radius:10px}
.infoq-tabs .nav-link{font-weight:700}
.infoq-table thead th{background:#d8f2f7;color:#111;text-align:center}
.infoq-table td{background:#f5f6f8}
.infoq-table textarea{min-height:94px;resize:vertical}
.infoq-query{font-family:Consolas,monospace;font-size:12px}
</style>
