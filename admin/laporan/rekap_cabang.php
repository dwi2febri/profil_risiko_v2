<?php
require_once __DIR__ . '/../../conn/conn.php';
require_once __DIR__ . '/../includes/hasil_laporan_cabang_data.php';
$tahun = (int)($_GET['tahun'] ?? 0);
$periode = (int)($_GET['periode'] ?? 0);
if ($tahun < 2000 || $tahun > 2100) $tahun = 0;
if ($periode < 1 || $periode > 4) $periode = 0;
$status_laporan = $_GET['status_laporan'] ?? 'semua';
if (!in_array($status_laporan, ['semua','diterima'], true)) $status_laporan = 'semua';
require __DIR__ . '/../includes/hasil_laporan_cabang_filter.php';
$hasilKCResults = hasil_kc_load_results($conn, $hasilKCFrames);
require __DIR__ . '/../includes/hasil_laporan_cabang_columns.php';
$hasilRegions = hasil_kc_regions($hasilKCFrames, $hasilKCResults);
$hasilTableTitle = 'Profil Risiko Kantor Cabang per Area';
$chartColors = ['kredit'=>'#59b78a','operasional'=>'#5fa5dc','kepatuhan'=>'#d7b449','likuiditas'=>'#d98b8b','reputasi'=>'#7f94d1','stratejik'=>'#7d8795'];
$chartDatasets = [];
foreach ($hasilRiskNames as $risk=>$name) $chartDatasets[] = ['label'=>$name,'data'=>array_values(array_map(fn($region)=>$region['values'][$risk],$hasilRegions)), 'counts'=>array_values(array_map(fn($region)=>$region['counts'][$risk],$hasilRegions)), 'backgroundColor'=>$chartColors[$risk], 'borderWidth'=>0];
?>
<div class="content-page"><div class="content"><div class="container-fluid rekap-korwil-page">
    <div class="page-title-box"><div class="page-title-right"><ol class="breadcrumb m-0"><li class="breadcrumb-item">Simpro</li><li class="breadcrumb-item active">Rekap per Korwil</li></ol></div><h4 class="page-title">Rekap Perbandingan per Korwil</h4></div>
    <div class="card"><div class="card-body">
        <h4 class="header-title mb-3">Filter Laporan</h4>
        <form action="index.php" method="get" class="rekap-korwil-filter">
            <input type="hidden" name="page" value="rekap_cbg">
            <div><label for="rekap-tahun" class="form-label">Tahun</label><select id="rekap-tahun" name="tahun" class="form-select" required><option value="">Pilih tahun</option><?php foreach (range(2024,2037) as $year): ?><option value="<?= $year ?>" <?= $year===$tahun?'selected':'' ?>><?= $year ?></option><?php endforeach; ?></select></div>
            <div><label for="rekap-periode" class="form-label">Periode</label><select id="rekap-periode" name="periode" class="form-select" required><option value="">Pilih periode</option><?php foreach (range(1,4) as $quarter): ?><option value="<?= $quarter ?>" <?= $quarter===$periode?'selected':'' ?>>Triwulan <?= $quarter ?></option><?php endforeach; ?></select></div>
            <div><label for="rekap-status" class="form-label">Status Laporan</label><select id="rekap-status" name="status_laporan" class="form-select"><option value="semua" <?= $status_laporan==='semua'?'selected':'' ?>>Semua laporan</option><option value="diterima" <?= $status_laporan==='diterima'?'selected':'' ?>>Diterima Korwil dan SKMR</option></select></div>
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div></div>
    <div class="card"><div class="card-body">
        <h4 class="header-title mb-3">Perbandingan Nilai Inheren per Area<?= $tahun && $periode ? ' - Triwulan '.$periode.' '.$tahun : '' ?></h4>
        <p class="rekap-korwil-note">Rata-rata nilai inheren cabang yang tersedia, bukan penetapan risiko konsolidasi. Nilai kosong tidak dihitung sebagai nol. Grafik dan tabel menggunakan laporan cabang yang sama.</p>
        <?php if ($hasilKCFrames): ?>
            <div class="rekap-korwil-chart"><canvas id="chart1" role="img" aria-label="Perbandingan rata-rata enam risiko inheren pada empat area"></canvas></div>
            <p class="rekap-korwil-note mt-3">Arahkan kursor ke batang untuk melihat nilai dan jumlah cabang pembentuknya. Klik batang untuk menampilkan cabang pada area tersebut.</p>
        <?php else: ?>
            <p class="alert alert-light border mb-0" role="status"><?= $tahun && $periode ? 'Belum ada laporan cabang yang sesuai dengan filter ini.' : 'Pilih tahun dan periode untuk menampilkan grafik.' ?></p>
        <?php endif; ?>
    </div></div>
    <?php require __DIR__ . '/../includes/hasil_laporan_cabang_table.php'; ?>
</div></div></div>
<style>
.rekap-korwil-page{min-width:0}.rekap-korwil-filter{display:grid;grid-template-columns:1fr 1fr 1.4fr auto;align-items:end;gap:18px}.rekap-korwil-filter>div{min-width:0}.rekap-korwil-note{font-size:12px;color:#64748b;line-height:1.7}.rekap-korwil-chart{position:relative;height:360px;width:100%;min-width:0}
@media(max-width:767px){.rekap-korwil-filter{grid-template-columns:1fr 1fr;gap:14px}.rekap-korwil-filter>div:nth-of-type(3){grid-column:1/-1}.rekap-korwil-filter>button{grid-column:1/-1}.rekap-korwil-chart{height:300px}}
</style>
<?php if ($hasilKCFrames): ?>
<script src="../assets/js/vendor/Chart.bundle.min.js"></script>
<script>
window.rekapAreaData = <?= json_encode(['labels'=>array_column($hasilRegions,'name'), 'datasets'=>$chartDatasets],JSON_THROW_ON_ERROR) ?>;
window.rekapAreaChart = new Chart(document.getElementById('chart1').getContext('2d'), {
    type:'bar', data:window.rekapAreaData,
    options:{responsive:true,maintainAspectRatio:false,animation:{duration:0},
        legend:{position:'bottom',labels:{boxWidth:14,padding:16,fontColor:'#475569'}},
        scales:{yAxes:[{ticks:{beginAtZero:true,min:0,max:5,stepSize:1},scaleLabel:{display:true,labelString:'Rata-rata nilai inheren'},gridLines:{color:'#e8edf3'}}],xAxes:[{gridLines:{display:false}}]},
        tooltips:{callbacks:{label:function(item,data){var dataset=data.datasets[item.datasetIndex];var value=dataset.data[item.index];return dataset.label+': '+Number(value).toFixed(2)+' ('+dataset.counts[item.index]+'/7 cabang)';}},displayColors:true},
        onClick:function(event,elements){if(!elements.length)return;var keys=['semarang','solo','banyumas','pekalongan'];var button=document.querySelector('.hasil-region-tabs button[data-region="'+keys[elements[0]._index]+'"]');if(button)button.click();}
    }
});
</script>
<?php endif; ?>
