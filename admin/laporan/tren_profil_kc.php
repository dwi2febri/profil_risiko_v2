<?php
require_once __DIR__ . '/../../conn/conn.php';
require_once __DIR__ . '/../includes/tren_profil_kc_data.php';
$trenNames = ['kredit'=>'Kredit','operasional'=>'Operasional','kepatuhan'=>'Kepatuhan','likuiditas'=>'Likuiditas','reputasi'=>'Reputasi','stratejik'=>'Stratejik','komposit'=>'Nilai Komposit'];
$trenRoutes = ['kredit'=>'kre_inhern','operasional'=>'op_inhern1','kepatuhan'=>'kep_inhern1','likuiditas'=>'lik_inhern','reputasi'=>'rep_inhern1','stratejik'=>'stra_inhern1','komposit'=>'nilpro'];
$trenRegions = ['semua'=>['Semua kantor wilayah',1,28], 'semarang'=>['Semarang',1,7], 'solo'=>['Solo',8,14], 'banyumas'=>['Banyumas',15,21], 'pekalongan'=>['Pekalongan',22,28]];
$trenLatest = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT tahun,periode FROM frame_laporan_profil_risiko WHERE user=3 ORDER BY tahun DESC,periode DESC LIMIT 1'));
$trenDefaultYear = (int)($trenLatest['tahun'] ?? date('Y'));
function tren_kc_input(string $name, int $default): int {return isset($_GET[$name]) && is_scalar($_GET[$name]) ? (int)$_GET[$name] : $default;}
$trenStartYear = tren_kc_input('start_year', $trenDefaultYear);
$trenStartQuarter = tren_kc_input('start_quarter', 1);
$trenEndYear = tren_kc_input('end_year', $trenDefaultYear);
$trenEndQuarter = tren_kc_input('end_quarter', (int)($trenLatest['periode'] ?? 4));
$trenRegion = is_string($_GET['wilayah'] ?? null) && isset($trenRegions[$_GET['wilayah']]) ? $_GET['wilayah'] : 'semua';
$trenPeriods = []; $trenData = []; $trenError = '';
try {
    $trenPeriods = tren_kc_periods($trenStartYear, $trenStartQuarter, $trenEndYear, $trenEndQuarter);
    $trenData = tren_kc_load($conn, $trenPeriods, $trenRegions[$trenRegion][1], $trenRegions[$trenRegion][2]);
} catch (InvalidArgumentException $error) { $trenError = $error->getMessage(); }
$trenBranches = [];
$trenBranchQuery = mysqli_query($conn, 'SELECT id_cabang,cabang FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 28 ORDER BY id_cabang');
while ($branch = mysqli_fetch_assoc($trenBranchQuery)) $trenBranches[(int)$branch['id_cabang']] = $branch['cabang'];
$trenYearOptions = range(min(2024, max(2000, min($trenStartYear, $trenEndYear))), max((int)date('Y')+1, min(2100, max($trenStartYear, $trenEndYear, $trenDefaultYear))));
$trenBase = $simproRouteConfig['roleBase'];
?>
<link rel="stylesheet" href="../assets/css/tren-profil-kc.css?v=20261105-03">
<div class="content-page"><div class="content"><div class="container-fluid tren-kc-page">
    <div class="page-title-box"><div class="page-title-right"><ol class="breadcrumb m-0"><li class="breadcrumb-item">Rekap</li><li class="breadcrumb-item active">Tren Profil KC</li></ol></div><h4 class="page-title">Tren Profil KC</h4></div>
    <div class="card"><div class="card-body">
        <h4 class="header-title mb-3">Rentang Laporan</h4>
        <form action="<?= hasil_kc_escape(simpro_route_url($trenBase, ['page'=>'tren_profil_kc'])) ?>" method="get" class="tren-kc-filter">
            <div><label for="tren-start-year">Tahun awal</label><select id="tren-start-year" name="start_year" class="form-select"><?php foreach ($trenYearOptions as $year): ?><option value="<?= $year ?>" <?= $year===$trenStartYear?'selected':'' ?>><?= $year ?></option><?php endforeach; ?></select></div>
            <div><label for="tren-start-quarter">Triwulan awal</label><select id="tren-start-quarter" name="start_quarter" class="form-select"><?php foreach (range(1,4) as $quarter): ?><option value="<?= $quarter ?>" <?= $quarter===$trenStartQuarter?'selected':'' ?>>Triwulan <?= $quarter ?></option><?php endforeach; ?></select></div>
            <div><label for="tren-end-year">Tahun akhir</label><select id="tren-end-year" name="end_year" class="form-select"><?php foreach ($trenYearOptions as $year): ?><option value="<?= $year ?>" <?= $year===$trenEndYear?'selected':'' ?>><?= $year ?></option><?php endforeach; ?></select></div>
            <div><label for="tren-end-quarter">Triwulan akhir</label><select id="tren-end-quarter" name="end_quarter" class="form-select"><?php foreach (range(1,4) as $quarter): ?><option value="<?= $quarter ?>" <?= $quarter===$trenEndQuarter?'selected':'' ?>>Triwulan <?= $quarter ?></option><?php endforeach; ?></select></div>
            <div><label for="tren-region">Kantor wilayah</label><select id="tren-region" name="wilayah" class="form-select"><?php foreach ($trenRegions as $key=>$region): ?><option value="<?= $key ?>" <?= $key===$trenRegion?'selected':'' ?>><?= hasil_kc_escape($region[0]) ?></option><?php endforeach; ?></select></div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
    </div></div>
    <div class="card"><div class="card-body">
        <h4 class="header-title mb-2">Tren Nilai Inheren dan Komposit Kantor Cabang</h4>
        <p class="tren-kc-note"><?= hasil_kc_escape($trenRegions[$trenRegion][0]) ?> · <?= hasil_kc_escape('TW '.$trenStartQuarter.' '.$trenStartYear.' sampai TW '.$trenEndQuarter.' '.$trenEndYear) ?></p>
        <?php if ($trenError): ?><div class="alert alert-warning" role="alert"><?= hasil_kc_escape($trenError) ?></div><?php else: ?>
        <p class="tren-kc-note">Nilai menggunakan sumber yang sama dengan Hasil Laporan KC: laporan cabang terbaru pada setiap triwulan, termasuk yang belum diterima. Tanda — berarti nilai belum tersedia. Garis tren terputus pada periode kosong; perubahan dihitung dari periode awal ke akhir. Nilai turun menunjukkan risiko membaik.</p>
        <div class="tren-kc-legend" aria-label="Keterangan warna peringkat"><?php foreach (['blue'=>'Sangat rendah','green'=>'Rendah','yellow'=>'Sedang','orange'=>'Tinggi','red'=>'Sangat tinggi'] as $color=>$label): ?><span class="hasil-pillar-<?= $color ?>"><?= $label ?></span><?php endforeach; ?></div>
        <p class="tren-kc-note">Inheren: 1–1,25; &gt;1,25–2,25; &gt;2,25–3,25; &gt;3,25–4,25; &gt;4,25–5. Komposit: &lt;1,25; 1,25–&lt;2,25; 2,25–&lt;3,25; 3,25–&lt;4,25; ≥4,25.</p>
        <?php if (!$trenData): ?><div class="alert alert-light border" role="status">Belum ada laporan pada rentang dan wilayah ini. Seluruh cabang tetap ditampilkan agar kelengkapan data terlihat.</div><?php endif; ?>
        <div class="tren-kc-tools"><div><label for="tren-risk-view">Tampilan risiko</label><select id="tren-risk-view" class="form-select"><option value="semua">Semua risiko</option><?php foreach ($trenNames as $risk=>$label): if ($risk==='komposit') continue; ?><option value="<?= $risk ?>"><?= $label ?></option><?php endforeach; ?></select></div><div><label for="tren-branch-search">Cari cabang</label><input id="tren-branch-search" type="search" class="form-control" placeholder="Kode atau nama cabang"></div></div>
        <div class="tren-kc-export-tools"><button type="button" class="btn btn-outline-secondary" id="tren-export-excel">Excel</button><button type="button" class="btn btn-outline-secondary" id="tren-export-pdf">PDF</button><span id="tren-export-status" class="tren-kc-note mb-0" role="status" aria-live="polite"></span></div>
        <div class="tren-kc-scroll-top" aria-label="Geser kolom tabel" tabindex="0"><div></div></div>
        <div class="tren-kc-scroll" tabindex="0" role="region" aria-label="Tabel tren per risiko, geser untuk melihat nilai komposit di kanan">
        <table class="tren-kc-table"><caption class="visually-hidden">Tren Profil KC, <?= count($trenPeriods) ?> triwulan. Nilai komposit pada kelompok paling kanan.</caption><thead><tr>
            <th rowspan="2" class="tren-code">Kode</th><th rowspan="2" class="tren-branch">Kantor Cabang</th>
            <?php foreach ($trenNames as $risk=>$label): ?><th colspan="<?= count($trenPeriods)+1 ?>" data-risk="<?= $risk ?>" scope="colgroup"><?= $label ?></th><?php endforeach; ?>
        </tr><tr><?php foreach ($trenNames as $risk=>$label): foreach ($trenPeriods as $period): ?><th data-risk="<?= $risk ?>" scope="col">TW <?= $period['quarter'] ?><br><?= $period['year'] ?></th><?php endforeach; ?><th data-risk="<?= $risk ?>" class="tren-kc-trend" scope="col">Tren<br><small>Δ awal–akhir</small></th><?php endforeach; ?></tr></thead><tbody>
        <?php foreach ($trenRegions as $regionKey=>$region): if ($regionKey==='semua' || ($trenRegion!=='semua' && $trenRegion!==$regionKey)) continue;
            $trenSamples = []; ?>
            <?php for ($branch=$region[1]; $branch<=$region[2]; $branch++): $branchName=$trenBranches[$branch] ?? 'Cabang '.$branch; ?>
            <tr data-branch="<?= hasil_kc_escape(sprintf('%03d', $branch).' '.$branchName) ?>"><th scope="row" class="tren-code"><?= sprintf('%03d', $branch) ?></th><th scope="row" class="tren-branch"><?= hasil_kc_escape($branchName) ?></th>
                <?php foreach ($trenNames as $risk=>$label): $values=[]; foreach ($trenPeriods as $key=>$period):
                    $entry=$trenData[$branch][$key] ?? null; $value=$entry['values'][$risk] ?? null; $values[]=$value;
                    if ($value!==null) $trenSamples[$risk][$key][]=$value;
                    $attributes=$risk==='komposit'?hasil_kc_composite_attributes($value):hasil_kc_pillar_attributes($value);
                    ?>
                    <td data-risk="<?= $risk ?>" <?= $attributes ?>><?php if ($value!==null): ?><a href="<?= hasil_kc_escape(simpro_route_url($trenBase, ['page'=>$trenRoutes[$risk], 'id'=>$entry['id']])) ?>" title="Buka sumber <?= hasil_kc_escape($label.' '.$period['label']) ?>"><?= number_format($value, 2, ',', '.') ?></a><?php else: ?>—<?php endif; ?></td>
                <?php endforeach; ?><td data-risk="<?= $risk ?>" class="tren-kc-trend"><?= tren_kc_sparkline($values) ?></td><?php endforeach; ?>
            </tr>
            <?php endfor; ?>
            <tr class="tren-kc-area" data-region-summary="<?= $regionKey ?>"><th colspan="2" scope="row" class="tren-area-label">Rata-rata <?= $region[0] ?></th>
            <?php foreach ($trenNames as $risk=>$label): $values=[]; foreach ($trenPeriods as $key=>$period): $samples=$trenSamples[$risk][$key] ?? []; $value=$samples?round(array_sum($samples)/count($samples),2):null; $values[]=$value; ?>
                <td data-risk="<?= $risk ?>" <?= $risk==='komposit'?hasil_kc_composite_attributes($value):hasil_kc_pillar_attributes($value) ?>><?= $value!==null?number_format($value,2,',','.'):'—' ?><small><?= count($samples) ?>/7</small></td>
            <?php endforeach; ?><td data-risk="<?= $risk ?>" class="tren-kc-trend"><?= tren_kc_sparkline($values) ?></td><?php endforeach; ?></tr>
        <?php endforeach; ?>
        </tbody></table></div>
        <p class="tren-kc-note mt-3" id="tren-kc-count" aria-live="polite"></p>
        <p class="tren-kc-note mb-0">Baris wilayah adalah rata-rata cabang yang memiliki nilai, bukan penetapan risiko wilayah. Angka n/7 menunjukkan jumlah cabang pembentuk rata-rata; komposisinya dapat berubah antarperiode. Pencarian hanya menyaring baris cabang, rata-rata wilayah tetap mengikuti filter kantor wilayah.</p>
        <?php endif; ?>
    </div></div>
</div></div></div>
<script src="../assets/js/tren-profil-kc.js?v=20261105-02"></script>
<?php if (!$trenError): ?>
<script>window.trenKCExportContext=<?= json_encode(['region'=>$trenRegions[$trenRegion][0], 'range'=>'TW '.$trenStartQuarter.' '.$trenStartYear.' sampai TW '.$trenEndQuarter.' '.$trenEndYear, 'filename'=>'tren_profil_kc_'.$trenRegion.'_'.$trenStartYear.'_tw'.$trenStartQuarter.'_'.$trenEndYear.'_tw'.$trenEndQuarter], JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_THROW_ON_ERROR) ?>;</script>
<script src="../assets/js/vendor/pdfmake.min.js?v=0.2.20"></script>
<script src="../assets/js/vendor/pdfmake-vfs-fonts.js?v=0.2.20"></script>
<script src="../assets/js/tren-kc-export.js?v=20261105-01"></script>
<?php endif; ?>
