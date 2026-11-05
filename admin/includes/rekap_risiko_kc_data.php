<?php
require_once __DIR__.'/hasil_laporan_cabang_data.php';
require_once __DIR__.'/hasil_laporan_cabang_pillars.php';

/** Main-parameter labels and stored scores from the credit/liquidity input forms. */
function rekap_risk_legacy(): array
{
    return [
        'kredit'=>[
            1=>['Komposisi Portofolio Aset dan Tingkat Konsentrasi Kredit',['Aset Produktif / Total Aset','Kredit yang Diberikan / Aset Produktif','25 Debitur Inti / Total Kredit','Kredit per Sektor Ekonomi / Total Kredit']],
            2=>['Kualitas Aset',['Aset Produktif Bermasalah / Total Aset Produktif','Kredit Bermasalah Neto / Total Kredit','Kredit Kualitas Rendah / Total Kredit']],
            3=>['Strategi Penyediaan Dana',['Strategi Penyediaan Dana']],
            4=>['Faktor Eksternal',['Faktor Eksternal']],
            5=>['Lainnya',['Faktor Lainnya']],
        ],
        'likuiditas'=>[
            1=>['Komposisi dan Konsentrasi Aset dan Kewajiban',['Aset Likuid / Total Aset','Aset Likuid / Kewajiban Lancar','Kredit yang Diberikan / Total Dana Pihak Ketiga Bukan Bank','25 Deposan dan Penabung Terbesar / Total DPK','Pendanaan Non Inti / Total Pendanaan']],
            2=>['Kerentanan pada Kebutuhan Pendanaan serta Akses pada Sumber Pendanaan',['Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan','Penilaian terhadap seberapa luas atau seberapa besar BPR memiliki komitmen pendanaan yang dapat digunakan jika dibutuhkan']],
            3=>['Lainnya',['Faktor Lainnya']],
        ],
    ];
}
/** Keep every tied maximum, keyed by pillar/parameter ID; never convert absence into zero. */
function rekap_risk_maxima(array $values): array
{
    $values=array_filter($values,static fn($v)=>is_numeric($v) && is_finite((float)$v));
    if (!$values) return [];
    $max=max(array_map('floatval',$values));
    return array_filter($values,static fn($v)=>abs((float)$v-$max)<0.00001);
}
function rekap_risk_pillar_name(string $name, int $order): string
{
    $name=preg_replace('/^(?:PILAR\s*\d+\s*[:.\-]?\s*)+/i','',trim($name));
    return preg_match('/^LAINNYA$/i',$name)?'Lainnya':'Pilar '.$order.': '.$name;
}
function rekap_risk_load(mysqli $db, array $frames, int $year): array
{
    $scores=hasil_kc_load_results($db,$frames);
    $dynamic=hasil_kc_dynamic_pillars($db,$frames,$year);
    $legacy=rekap_risk_legacy();$out=[];
    foreach (['kredit'=>'Kredit','operasional'=>'Operasional','kepatuhan'=>'Kepatuhan','likuiditas'=>'Likuiditas','reputasi'=>'Reputasi','stratejik'=>'Stratejik'] as $risk=>$name) {
        $definitions=[];$legacyRows=[];
        if (isset($legacy[$risk])) foreach ($legacy[$risk] as $id=>[$label,$parameters]) {
            $last=$id===count($legacy[$risk]);
            $definitions[$id]=['id'=>$id,'name'=>$last?'Lainnya':'Pilar '.$id.': '.$label,'short'=>$last?'Lainnya':'Pilar '.$id,'parameters'=>array_combine(range(1,count($parameters)),$parameters)];
            $legacyRows[$id]=hasil_kc_latest_rows($db,'inheren_'.$risk.'_'.($last?'lainnya':'pilar'.$id),array_column($frames,'id_profil_risiko'));
        }
        else foreach ($dynamic['definitions'][$risk]??[] as $id=>$pillar) {
            $definitions[$id]=['id'=>$id,'name'=>rekap_risk_pillar_name($pillar['name'],$pillar['order']),'short'=>preg_match('/LAINNYA/i',$pillar['name'])?'Lainnya':'Pilar '.$pillar['order'],'parameters'=>array_map(static fn($parameter)=>$parameter['name'],$pillar['parameters'])];
        }
        $rows=[];
        foreach ($frames as $branch=>$frame) {
            $report=(int)$frame['id_profil_risiko'];$pillars=[];$parameterValues=[];
            foreach ($definitions as $id=>$definition) {
                if (isset($legacy[$risk])) {
                    $value=$scores[$branch][$risk]['pil'.$id.'_tingkat_risiko']??null;
                    $pillars[$id]=hasil_kc_valid_score($value)?(float)$value:null;
                    foreach ($definition['parameters'] as $parameter=>$label) {
                        $value=$legacyRows[$id][$report]['hasil_pil'.$id.'_par'.$parameter]??null;
                        $parameterValues[$id][$parameter]=hasil_kc_valid_score($value)?(float)$value:null;
                    }
                } else {
                    $projection=$dynamic['values'][$report][$risk][$id]??[];
                    $pillars[$id]=$projection['value']??null;
                    $parameterValues[$id]=$projection['parameter_values']??[];
                }
            }
            $highest=[];$parameters=[];
            foreach (rekap_risk_maxima($pillars) as $id=>$value) {
                $highest[]=$definitions[$id]['name'].' ('.number_format($value,2,',','.').')';
                $top=rekap_risk_maxima($parameterValues[$id]??[]);
                if (!$top) $parameters[]=$definitions[$id]['short'].': nilai parameter belum tersedia';
                foreach ($top as $parameter=>$score) $parameters[]=$definitions[$id]['short'].': '.($definitions[$id]['parameters'][$parameter]??'Parameter '.$parameter).' ('.number_format($score,2,',','.').')';
            }
            $score=$scores[$branch][$risk]['hasil_tingkat_risiko']??null;
            $rows[$branch]=['report'=>$report,'pillars'=>$pillars,'score'=>$score,'rank'=>$scores[$branch][$risk]['hasil_peringkat']??'—','highest'=>$highest,'parameters'=>$parameters];
        }
        $out[$risk]=['name'=>$name,'pillars'=>$definitions,'rows'=>$rows];
    }
    return $out;
}
