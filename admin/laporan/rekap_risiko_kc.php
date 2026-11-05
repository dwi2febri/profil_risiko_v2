<?php
require_once __DIR__.'/../../conn/conn.php';
require_once __DIR__.'/../includes/rekap_risiko_kc_data.php';
$latest=mysqli_fetch_assoc(mysqli_query($conn,'SELECT tahun,periode FROM frame_laporan_profil_risiko WHERE user=3 ORDER BY tahun DESC,periode DESC LIMIT 1'));
$tahun=isset($_GET['tahun'])&&is_scalar($_GET['tahun'])?(int)$_GET['tahun']:(int)($latest['tahun']??date('Y'));
$periode=isset($_GET['periode'])&&is_scalar($_GET['periode'])?(int)$_GET['periode']:(int)($latest['periode']??1);
if ($tahun<2000||$tahun>2100) $tahun=0;
if ($periode<1||$periode>4) $periode=0;
$regions=['semua'=>['Semua kantor wilayah',1,28],'semarang'=>['Semarang',1,7],'solo'=>['Solo',8,14],'banyumas'=>['Banyumas',15,21],'pekalongan'=>['Pekalongan',22,28]];
$wilayah=is_string($_GET['wilayah']??null)&&isset($regions[$_GET['wilayah']])?$_GET['wilayah']:'semua';
$status_laporan='semua';
require __DIR__.'/../includes/hasil_laporan_cabang_filter.php';
$hasilKCFrames=array_filter($hasilKCFrames,fn($frame)=>$frame['kantor_cabang']>=$regions[$wilayah][1]&&$frame['kantor_cabang']<=$regions[$wilayah][2]);
$blocks=rekap_risk_load($conn,$hasilKCFrames,$tahun);
$branches=[];foreach(hasil_kc_query_rows($conn,'SELECT id_cabang,cabang FROM jenis_cabang WHERE id_cabang BETWEEN 1 AND 28 ORDER BY id_cabang') as $branch)$branches[(int)$branch['id_cabang']]=$branch['cabang'];
$riskRoutes=['kredit'=>'kre_inhern','operasional'=>'op_inhern1','kepatuhan'=>'kep_inhern1','likuiditas'=>'lik_inhern','reputasi'=>'rep_inhern1','stratejik'=>'stra_inhern1'];
$targetCount=$regions[$wilayah][2]-$regions[$wilayah][1]+1;
$romanQuarters=[1=>'I',2=>'II',3=>'III',4=>'IV'];
$reportTitle='REKAP HASIL PENILAIAN PER RISIKO INHEREN KANTOR CABANG'.($wilayah==='semua'?'':' AREA '.strtoupper($regions[$wilayah][0]));
$periodTitle='Periode Triwulan '.($romanQuarters[$periode]??'-').' '.$tahun;
$yearOptions=range(min(2024,$tahun?:2024),max((int)date('Y')+1,$tahun));
function rekap_risk_mean(array $values): ?float {$values=array_filter($values,fn($v)=>is_numeric($v));return $values?round(array_sum($values)/count($values),2):null;}
?>
<link rel="stylesheet" href="../assets/css/rekap-risiko-kc.css?v=20261105-04">
<div class="content-page"><div class="content"><div class="container-fluid risk-recap-page">
    <div class="page-title-box"><div class="page-title-right"><ol class="breadcrumb m-0"><li class="breadcrumb-item">Rekap</li><li class="breadcrumb-item active">Rekap per Risiko KC</li></ol></div><h4 class="page-title">Rekap per Risiko KC</h4></div>
    <div class="card"><div class="card-body">
        <form class="risk-recap-filter" method="get" action="<?= hasil_kc_escape(simpro_route_url($simproRouteConfig['roleBase'],['page'=>'rekap_risiko_kc'])) ?>">
            <div><label for="risk-recap-year">Tahun</label><select id="risk-recap-year" name="tahun" class="form-select" required><?php if(!$tahun): ?><option value="">Pilih tahun</option><?php endif; ?><?php foreach($yearOptions as $year): ?><option value="<?= $year ?>" <?= $year===$tahun?'selected':'' ?>><?= $year ?></option><?php endforeach; ?></select></div>
            <div><label for="risk-recap-quarter">Periode</label><select id="risk-recap-quarter" name="periode" class="form-select" required><?php if(!$periode): ?><option value="">Pilih periode</option><?php endif; ?><?php foreach(range(1,4) as $quarter): ?><option value="<?= $quarter ?>" <?= $quarter===$periode?'selected':'' ?>>Triwulan <?= $quarter ?></option><?php endforeach; ?></select></div>
            <div><label for="risk-recap-region">Kantor wilayah</label><select id="risk-recap-region" name="wilayah" class="form-select"><?php foreach($regions as $key=>$region): ?><option value="<?= $key ?>" <?= $key===$wilayah?'selected':'' ?>><?= $region[0] ?></option><?php endforeach; ?></select></div>
            <button class="btn btn-primary" type="submit">Tampilkan</button>
        </form>
    </div></div>
    <div class="card"><div class="card-body">
        <h4 class="header-title mb-2">Rekap Penilaian Inheren per Risiko</h4>
        <p class="risk-recap-note"><?= hasil_kc_escape($regions[$wilayah][0]) ?> · Triwulan <?= $periode ?> <?= $tahun ?> · <?= count($hasilKCFrames) ?>/<?= $targetCount ?> cabang memiliki laporan</p>
        <p class="risk-recap-note">Nilai risiko memakai sumber yang sama dengan Hasil Laporan KC. Pilar mengikuti setting dan isian cabang pada tahun laporan. Parameter tertinggi adalah nilai parameter utama; jika memiliki subparameter, digunakan rata-rata subparameter terpilih. Semua nilai yang seri ditampilkan.</p>
        <p class="risk-recap-note">Batas peringkat: 1–1,25; &gt;1,25–2,25; &gt;2,25–3,25; &gt;3,25–4,25; &gt;4,25–5. Tanda — berarti nilai belum tersedia. Pilar tertinggi dibandingkan dari nilai pilar yang tersedia, termasuk kontribusi pada metode pembobotan.</p>
        <div class="risk-recap-tools"><div class="risk-recap-downloads"><button class="btn btn-outline-secondary" type="button" id="risk-recap-excel">Excel</button><button class="btn btn-outline-secondary" type="button" id="risk-recap-pdf">PDF</button><span id="risk-recap-export-status" role="status" aria-live="polite"></span></div><div><label for="risk-recap-view">Tampilan risiko</label><select id="risk-recap-view" class="form-select"><option value="semua">Semua risiko</option><?php foreach($blocks as $risk=>$block): ?><option value="<?= $risk ?>"><?= $block['name'] ?></option><?php endforeach; ?></select></div><div><label for="risk-recap-search">Cari cabang</label><input id="risk-recap-search" class="form-control" type="search" placeholder="Kode atau nama cabang"></div></div>
        <?php if(!$hasilKCFrames): ?><p class="alert alert-light border" role="status">Belum ada laporan pada filter ini. Seluruh cabang tetap ditampilkan.</p><?php endif; ?>
    </div></div>
    <div class="card"><div class="card-body risk-recap-report">
    <div class="risk-recap-report-heading"><div><?= hasil_kc_escape($reportTitle) ?></div><div>PT BPR BKK JATENG (PERSERODA)</div><div><?= hasil_kc_escape($periodTitle) ?></div></div>
    <?php $riskNumber=0;foreach($blocks as $risk=>$block): $riskNumber++;$pillarCount=count($block['pillars']); ?>
    <section class="risk-recap-section" data-recap-risk="<?= $risk ?>" data-risk-name="Risiko <?= $block['name'] ?>" data-risk-number="<?= $riskNumber ?>" aria-labelledby="risk-recap-title-<?= $risk ?>">
        <h4 class="risk-recap-section-title" id="risk-recap-title-<?= $risk ?>"><?= $riskNumber ?>. RISIKO <?= strtoupper($block['name']) ?></h4>
        <?php if(!$block['pillars']): ?><p class="risk-recap-note">Belum ada pilar terpilih pada setting parameter untuk risiko ini.</p><?php endif; ?>
        <div class="risk-recap-scroll" tabindex="0" role="region" aria-label="Rekap Risiko <?= $block['name'] ?>">
        <table class="risk-recap-table">
        <colgroup><col style="width:62px"><col style="width:180px"><?php foreach($block['pillars'] as $_): ?><col style="width:80px"><?php endforeach; ?><col style="width:90px"><col style="width:120px"><col style="width:250px"><col style="width:330px"></colgroup>
        <thead>
            <tr><th rowspan="3" class="risk-recap-code risk-recap-identity-header" scope="col" data-export-column="0" data-export-label="Kode Cabang">Kode<br>Cabang</th><th rowspan="3" class="risk-recap-branch risk-recap-identity-header" scope="col" data-export-column="1" data-export-label="Nama Cabang">Nama Cabang</th><th colspan="<?= $pillarCount+2 ?>" scope="colgroup">Risiko <?= $block['name'] ?></th><th rowspan="3" scope="col" class="risk-recap-description" data-export-column="<?= $pillarCount+4 ?>" data-export-label="Pilar Tertinggi">Pilar Tertinggi</th><th rowspan="3" scope="col" class="risk-recap-description risk-recap-parameters" data-export-column="<?= $pillarCount+5 ?>" data-export-label="Parameter Tertinggi di Pilar Tersebut">Parameter Tertinggi di Pilar Tersebut</th></tr>
            <tr><th colspan="<?= $pillarCount+1 ?>" scope="colgroup">Inheren</th><th rowspan="2" scope="col" data-kind="rank" data-export-column="<?= $pillarCount+3 ?>" data-export-label="Peringkat">Peringkat</th></tr>
            <tr><?php $pillarIndex=0;foreach($block['pillars'] as $pillar): ?><th scope="col" data-pillar="<?= $pillar['id'] ?>" data-export-column="<?= 2+$pillarIndex++ ?>" data-export-label="<?= hasil_kc_escape($pillar['short']) ?>" title="<?= hasil_kc_escape($pillar['name']) ?>"><?= hasil_kc_escape($pillar['short']) ?></th><?php endforeach; ?><th scope="col" data-kind="score" data-export-column="<?= $pillarCount+2 ?>" data-export-label="Tingkat Risiko">Tingkat Risiko</th></tr>
        </thead><tbody>
        <?php $average=rekap_risk_mean(array_column($block['rows'],'score'));$band=hasil_kc_pillar_band($average); ?>
        <tr class="risk-recap-average"><th colspan="2" scope="row">Rata-rata Cabang</th><?php foreach($block['pillars'] as $id=>$pillar): $values=array_column(array_column($block['rows'],'pillars'),$id);$mean=rekap_risk_mean($values); ?><td <?= hasil_kc_pillar_attributes($mean) ?>><?= $mean===null?'—':number_format($mean,2,',','.') ?><small><?= count(array_filter($values,fn($v)=>is_numeric($v))) ?>/<?= $targetCount ?></small></td><?php endforeach; ?><td <?= hasil_kc_pillar_attributes($average) ?>><?= $average===null?'—':number_format($average,2,',','.') ?></td><td <?= hasil_kc_pillar_attributes($average) ?>><?= $band?ucfirst($band[1]):'—' ?></td><td></td><td></td></tr>
        <?php for($branch=$regions[$wilayah][1];$branch<=$regions[$wilayah][2];$branch++): $name=$branches[$branch]??'Cabang '.$branch;$row=$block['rows'][$branch]??['pillars'=>[],'score'=>null,'rank'=>'—','highest'=>[],'parameters'=>[]]; ?>
        <tr data-branch="<?= hasil_kc_escape(sprintf('%03d',$branch).' '.$name) ?>"><th class="risk-recap-code" scope="row"><?= sprintf('%03d',$branch) ?></th><th class="risk-recap-branch" scope="row"><?= hasil_kc_escape($name) ?></th><?php foreach($block['pillars'] as $id=>$pillar): $value=$row['pillars'][$id]??null; ?><td <?= hasil_kc_pillar_attributes($value) ?>><?= $value===null?'—':number_format($value,2,',','.') ?></td><?php endforeach; ?><td <?= hasil_kc_pillar_attributes($row['score']) ?> data-kind="score"><?php if($row['score']!==null): ?><a href="<?= hasil_kc_escape(simpro_route_url($simproRouteConfig['roleBase'],['page'=>$riskRoutes[$risk],'id'=>$row['report']])) ?>"><?= number_format((float)$row['score'],2,',','.') ?></a><?php else: ?>—<?php endif; ?></td><td <?= hasil_kc_pillar_attributes($row['score']) ?> data-kind="rank"><?= hasil_kc_escape($row['rank']) ?></td><td class="risk-recap-description"><?= $row['highest']?implode('<br>',array_map('hasil_kc_escape',$row['highest'])):'—' ?></td><td class="risk-recap-description risk-recap-parameters"><?= $row['parameters']?implode('<br>',array_map('hasil_kc_escape',$row['parameters'])):'—' ?></td></tr>
        <?php endfor; ?>
        </tbody></table></div>
    </section>
    <?php endforeach; ?>
    </div></div>
    <p class="risk-recap-note" id="risk-recap-count" aria-live="polite"></p><p class="risk-recap-note">Rata-rata menggunakan cabang dengan nilai tersedia dan mengikuti filter wilayah; pencarian hanya menyaring baris cabang. Nilai parameter kredit dan likuiditas memakai hasil parameter tersimpan pada isian inheren. Nilai dan kontribusi pilar tidak mengubah penetapan tingkat risiko.</p>
</div></div></div>
<script>window.riskRecapContext=<?= json_encode(['reportTitle'=>$reportTitle,'periodTitle'=>$periodTitle,'metadata'=>$regions[$wilayah][0].' | Triwulan '.$periode.' '.$tahun,'filename'=>'rekap_per_risiko_kc_'.$wilayah.'_'.$tahun.'_tw'.$periode],JSON_HEX_TAG|JSON_HEX_AMP|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_THROW_ON_ERROR) ?>;</script>
<script src="../assets/js/vendor/pdfmake.min.js?v=0.2.20"></script><script src="../assets/js/vendor/pdfmake-vfs-fonts.js?v=0.2.20"></script><script src="../assets/js/rekap-risiko-kc.js?v=20261105-04"></script>
