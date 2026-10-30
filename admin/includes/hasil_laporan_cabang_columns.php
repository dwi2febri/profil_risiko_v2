<?php
require_once __DIR__ . '/hasil_laporan_cabang_pillars.php';
$hasilKCDynamic = hasil_kc_dynamic_pillars($conn, $hasilKCFrames, $tahun);
$hasilRiskNames = ['kredit'=>'Kredit','operasional'=>'Operasional','kepatuhan'=>'Kepatuhan','likuiditas'=>'Likuiditas','reputasi'=>'Reputasi','stratejik'=>'Stratejik'];
$hasilRoutes = ['kredit'=>'kre_inhern','operasional'=>'op_inhern1','kepatuhan'=>'kep_inhern1','likuiditas'=>'lik_inhern','reputasi'=>'rep_inhern1','stratejik'=>'stra_inhern1'];
$hasilKCColumns = []; $hasilColumnGroups = ['ringkasan'=>[]];
foreach ($hasilRiskNames as $risk => $label) {
    $hasilColumnGroups[$risk] = [];
    if (in_array($risk, ['kredit','likuiditas'], true)) {
        $count = $risk === 'kredit' ? 5 : 3;
        for ($i=1;$i<=$count;$i++) {
            $title = ($i === $count ? 'Lainnya' : 'Pilar ' . $i) . ' ' . $label;
            $hasilColumnGroups[$risk][] = 4 + count($hasilKCColumns);
            $hasilKCColumns[] = ['risk'=>$risk,'kind'=>'legacy_pillar','field'=>'pil'.$i.'_tingkat_risiko','title'=>$title,'name'=>$title];
        }
    } else foreach ($hasilKCDynamic['definitions'][$risk] ?? [] as $pillar) {
        $prefix = preg_match('/PILAR\s*(\d+)/i', $pillar['name'], $number) ? 'Pilar ' . $number[1] : $pillar['name'];
        $hasilColumnGroups[$risk][] = 4 + count($hasilKCColumns);
        $hasilKCColumns[] = ['risk'=>$risk,'kind'=>'dynamic_pillar','id'=>$pillar['id'],'title'=>ucfirst(strtolower($prefix)).' '.$label,'name'=>$pillar['name']];
    }
    $hasilColumnGroups['ringkasan'][] = 4 + count($hasilKCColumns);
    $hasilColumnGroups[$risk][] = 4 + count($hasilKCColumns);
    $hasilKCColumns[] = ['risk'=>$risk,'kind'=>'score','title'=>'Risiko '.$label,'name'=>'Nilai inheren '.$label];
    $hasilColumnGroups[$risk][] = 4 + count($hasilKCColumns);
    $hasilKCColumns[] = ['risk'=>$risk,'kind'=>'rank','title'=>'Peringkat '.$label,'name'=>'Peringkat inheren '.$label];
}
$hasilBaseColumns = [0,1,2,3,4+count($hasilKCColumns),5+count($hasilKCColumns)];
$hasilTotalColumns = 6 + count($hasilKCColumns);
$hasilBranchNames = [];
foreach (hasil_kc_query_rows($conn, 'SELECT id_cabang,cabang FROM jenis_cabang') as $branch) $hasilBranchNames[(int)$branch['id_cabang']] = $branch['cabang'];
