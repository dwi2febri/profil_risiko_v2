<?php
if(PHP_SAPI!=='cli')exit(1);
require __DIR__.'/../conn/conn.php';require __DIR__.'/../admin/includes/rekap_risiko_kc_data.php';
function recap_assert(bool $ok,string $message): void {if(!$ok)throw new RuntimeException($message);}
recap_assert(rekap_risk_maxima(['missing'=>null,'a'=>4.5,'b'=>4.5,'c'=>3])===['a'=>4.5,'b'=>4.5],'Ties or missing values handled incorrectly');
recap_assert(rekap_risk_maxima(['missing'=>null])===[],'Missing value became a maximum');
$frames=[];$q=mysqli_query($conn,'SELECT * FROM frame_laporan_profil_risiko WHERE user=3 AND tahun=2026 AND periode=2 AND kantor_cabang BETWEEN 8 AND 14 ORDER BY id_profil_risiko DESC');
while($frame=mysqli_fetch_assoc($q))if(!isset($frames[$frame['kantor_cabang']]))$frames[$frame['kantor_cabang']]=$frame;
$before=mysqli_fetch_assoc(mysqli_query($conn,'SELECT COUNT(*) n,SUM(COALESCE(nilai,0)) score FROM assessment_inheren_detail'));
$blocks=rekap_risk_load($conn,$frames,2026);$source=hasil_kc_load_results($conn,$frames);$dynamic=hasil_kc_dynamic_pillars($conn,$frames,2026);$checked=0;
foreach($blocks as $risk=>$block)foreach($block['rows'] as $branch=>$row){
    recap_assert($row['score']===($source[$branch][$risk]['hasil_tingkat_risiko']??null),'Risk score differs from KC results');
    $maxima=rekap_risk_maxima($row['pillars']);recap_assert(count($row['highest'])===count($maxima),'Highest pillar tie lost');
    if(in_array($risk,['kredit','likuiditas'],true)){
        foreach($maxima as $pillar=>$value){
            $last=$pillar===count($block['pillars']);$table='inheren_'.$risk.'_'.($last?'lainnya':'pilar'.$pillar);
            $data=mysqli_fetch_assoc(simpro_db_query($conn,"SELECT * FROM `$table` WHERE id_profil_risiko=? ORDER BY 1 DESC LIMIT 1",[(int)$row['report']]));
            $scores=[];foreach($block['pillars'][$pillar]['parameters'] as $id=>$name){$v=$data['hasil_pil'.$pillar.'_par'.$id]??null;if(hasil_kc_valid_score($v))$scores[$id]=(float)$v;}
            foreach(rekap_risk_maxima($scores) as $id=>$score)recap_assert(in_array($block['pillars'][$pillar]['short'].': '.$block['pillars'][$pillar]['parameters'][$id].' ('.number_format($score,2,',','.').')',$row['parameters'],true),'Legacy highest parameter differs from saved input');
        }
    }else{
        $definition=$dynamic['definitions'][$risk];
        $header=mysqli_fetch_assoc(simpro_db_query($conn,'SELECT * FROM assessment_inheren WHERE id_profil_risiko=? AND jenis_risiko=? ORDER BY id_assessment_inheren DESC LIMIT 1',[(int)$row['report'],'RISIKO '.strtoupper($risk)]));
        $details=[];if($header){$q=simpro_db_query($conn,'SELECT * FROM assessment_inheren_detail WHERE id_assessment_inheren=? ORDER BY id_detail DESC',[(int)$header['id_assessment_inheren']]);while($r=mysqli_fetch_assoc($q))$details[$r['ref_tipe'].'|'.$r['ref_id']]??=$r['nilai'];}
        foreach($maxima as $pillar=>$value){$scores=[];foreach($definition[$pillar]['parameters'] as $id=>$parameter){$keys=$parameter['subs']?array_map(fn($id)=>'sub_parameter|'.$id,array_values($parameter['subs'])):['parameter|'.$id];$values=[];foreach($keys as $key)if(hasil_kc_valid_score($details[$key]??null))$values[]=(float)$details[$key];if(count($values)===count($keys))$scores[$id]=round(array_sum($values)/count($values),2);}
            foreach(rekap_risk_maxima($scores) as $id=>$score)recap_assert(in_array($block['pillars'][$pillar]['short'].': '.$block['pillars'][$pillar]['parameters'][$id].' ('.number_format($score,2,',','.').')',$row['parameters'],true),'Dynamic highest parameter does not match selected subparameter mean');
        }
    }
    $checked++;
}
recap_assert($checked===42,'Expected six risks for seven branches');
recap_assert($before===mysqli_fetch_assoc(mysqli_query($conn,'SELECT COUNT(*) n,SUM(COALESCE(nilai,0)) score FROM assessment_inheren_detail')),'Report changed assessments');
recap_assert(count(rekap_risk_load($conn,[],2099))===6,'Empty range must preserve six risk sections');
echo "PASS: 42 branch/risk rows, risk source parity, highest pillar ties, saved legacy parameter values, selected dynamic subparameter means and read-only empty state\n";
