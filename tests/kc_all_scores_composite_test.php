<?php
if (PHP_SAPI !== 'cli') exit(1);
require __DIR__.'/../conn/conn.php';
require __DIR__.'/../admin/includes/hasil_laporan_cabang_data.php';
require __DIR__.'/kc_profile_source_fixture.php';
function all_kc_assert(bool $condition, string $message): void {if (!$condition) throw new RuntimeException($message);}
function fixture_weight_query($db, $sql, $label='') {return mysqli_query($db,$sql);}
function fixture_weight_one($db, $sql, $label='') {return mysqli_fetch_assoc(mysqli_query($db,$sql)) ?: [];}
function fixture_weight_table($db, $table) {$name=mysqli_real_escape_string($db,$table);return mysqli_num_rows(mysqli_query($db,"SHOW TABLES LIKE '$name'"))>0;}
function fixture_weight_column($db, $table, $column) {if(!fixture_weight_table($db,$table))return false;$column=mysqli_real_escape_string($db,$column);return mysqli_num_rows(mysqli_query($db,"SHOW COLUMNS FROM `$table` LIKE '$column'"))>0;}
$original=file_get_contents(__DIR__.'/../admin/kc/nilai_peringkat/nilai_profil.php');
foreach (['get_active_bobot','hitung_total_bobot_inheren','nilai_label'] as $name) {
    $start=strpos($original,'function '.$name.'(');$end=strpos($original,"\n}",$start);
    $function=substr($original,$start,$end-$start+2);
    $function=str_replace(['function '.$name.'(', 'dbq(', 'dbone(', 'table_exists2(', 'col_exists2('],['function fixture_'.$name.'(', 'fixture_weight_query(', 'fixture_weight_one(', 'fixture_weight_table(', 'fixture_weight_column('],$function);
    eval($function);
}
$snapshot=static fn()=>mysqli_fetch_assoc(mysqli_query($conn,'SELECT COUNT(*) n,SUM(COALESCE(total_nilai,0)) score FROM nilai_profil'));
$before=$snapshot();
$customWeights=['kredit'=>10,'operasional'=>20,'kepatuhan'=>30,'likuiditas'=>15,'reputasi'=>15,'stratejik'=>10];
$customRisks=[];$customRows=[];
foreach($customWeights as $risk=>$weight){$score=1+count($customRisks)*0.5;$customRisks[$risk]=['hasil_tingkat_risiko'=>$score];$customRows[$risk]=['nilai_inheren'=>$score];}
all_kc_assert((float)hasil_kc_composite($customRisks,$customWeights)['total_nilai']===fixture_hitung_total_bobot_inheren($customRows,$customWeights),'Nondefault weights or final rounding ignored');
foreach([1.24,1.25,2.25,3.25,4.25,5] as $boundary){$risksForBoundary=array_fill_keys(array_keys($customWeights),['hasil_tingkat_risiko'=>$boundary]);all_kc_assert(hasil_kc_composite($risksForBoundary,$customWeights)['ket_total_nilai']===fixture_nilai_label($boundary),'Composite boundary differs');}
$frames=[];$query=mysqli_query($conn,'SELECT * FROM frame_laporan_profil_risiko WHERE user=3 AND kantor_cabang BETWEEN 1 AND 28 ORDER BY id_profil_risiko');
while($frame=mysqli_fetch_assoc($query))$frames[(int)$frame['id_profil_risiko']]=$frame;
$actual=hasil_kc_load_results($conn,$frames);$risks=['kredit','operasional','kepatuhan','likuiditas','reputasi','stratejik'];
$weights=[];$checks=0;$stale=0;$partial=0;
foreach($frames as $id=>$frame){
    $rows=[];
    foreach($risks as $risk){
        $expected=kc_profile_fixture_result($conn,$id,$risk);
        $score=$actual[$id][$risk]['_profile_score'];
        all_kc_assert((float)$score===(float)$expected['hasil_tingkat_risiko'],"Source differs from individual profile: $id/$risk");
        $visible=$actual[$id][$risk]['hasil_tingkat_risiko']??null;
        all_kc_assert(hasil_kc_valid_score($expected['hasil_tingkat_risiko']) ? (float)$visible===(float)$expected['hasil_tingkat_risiko'] : $visible===null,"Displayed score differs: $id/$risk");
        if($visible!==null)all_kc_assert($actual[$id][$risk]['hasil_peringkat']===$expected['hasil_peringkat'],"Rank differs: $id/$risk");
        $rows[$risk]=['nilai_inheren'=>$expected['hasil_tingkat_risiko']];$checks++;
    }
    $year=(int)$frame['tahun'];$weights[$year]??=fixture_get_active_bobot($conn,$year,3)['bobot'];
    all_kc_assert(hasil_kc_weights($conn,$year,3)['bobot']===$weights[$year],"Weights differ for $year");
    $total=fixture_hitung_total_bobot_inheren($rows,$weights[$year]);
    all_kc_assert((float)$actual[$id]['total']['total_nilai']===$total,"Composite differs from Profile Value page: $id");
    all_kc_assert($actual[$id]['total']['ket_total_nilai']===fixture_nilai_label($total),"Composite rank differs: $id");
    $stored=hasil_kc_latest_rows($conn,'nilai_profil',[$id])[$id]['total_nilai']??null;
    if($stored===null||(float)$stored!==$total)$stale++;
    if($actual[$id]['total']['_missing'])$partial++;
}
all_kc_assert($before===$snapshot(),'Read-only verification changed saved composite values');
all_kc_assert($checks>0 && $stale>0,'No real outdated composite coverage');
all_kc_assert(hasil_kc_load_results($conn,[552=>['id_profil_risiko'=>552]])[552]['total']['total_nilai']==='3.90','Stale 3.61 must be replaced by live profile composite 3.90');
echo 'PASS: '.count($frames)." reports, $checks risk scores and ranks; weights/composite match independent original profile functions; $stale outdated/empty composites; $partial incomplete inputs preserve profile rounding; no stored values changed.\n";
