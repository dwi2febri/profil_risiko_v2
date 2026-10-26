
<?php
require('fpdf182/fpdf.php');

include 'fetch.php';

$id_kepatuhan = $_GET['id'];


$id = $_GET['id'];
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];
$tahun = $frame['tahun'];
$kc = $frame['cabang'];
$tgl = $frame['dibuat_at'];

$pil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$pil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$pil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$pil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_pilar4 WHERE id_profil_risiko = '$id'"));
$pil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kredit_lainnya WHERE id_profil_risiko = '$id'"));

$pil_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$pil_op5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$pil_op6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));

$ket_pil_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar4 WHERE id_profil_risiko = '$id'"));
$ket_pil_op5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_pilar5 WHERE id_profil_risiko = '$id'"));
$ket_pil_op6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_operasional_lainnya WHERE id_profil_risiko = '$id'"));

$pil_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));

$pil_lik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_lik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_lik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_likuiditas_lainnya WHERE id_profil_risiko = '$id'"));

$pil_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$pil_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$pil_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$pil_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$pil_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));


$ket_pil_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_kepatuhan_lainnya WHERE id_profil_risiko = '$id'"));


$ket_pil_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_reputasi_lainnya WHERE id_profil_risiko = '$id'"));

$ket_pil_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$ket_pil_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ket_inheren_stratejik_lainnya WHERE id_profil_risiko = '$id'"));


$kpmr_kredit1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_kredit4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kredit_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_operasional1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_operasional4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_operasional_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_kepatuhan1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_kepatuhan4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_kepatuhan_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_likuiditas1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_likuiditas4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_likuiditas_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_reputasi1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_reputasi4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_reputasi_pilar4 WHERE id_profil_risiko = '$id'"));

$kpmr_stratejik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar1 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar2 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar3 WHERE id_profil_risiko = '$id'"));
$kpmr_stratejik4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM kpmr_stratejik_pilar4 WHERE id_profil_risiko = '$id'"));


$ru1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil1 WHERE id_profil_risiko = '$id'"));
$ru2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil2 WHERE id_profil_risiko = '$id'"));
$ru3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil3 WHERE id_profil_risiko = '$id'"));
$ru4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kredit_pil4 WHERE id_profil_risiko = '$id'"));

$ru_op1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil1 WHERE id_profil_risiko = '$id'"));
$ru_op2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil2 WHERE id_profil_risiko = '$id'"));
$ru_op3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil3 WHERE id_profil_risiko = '$id'"));
$ru_op4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_operasional_pil4 WHERE id_profil_risiko = '$id'"));

$ru_kep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil1 WHERE id_profil_risiko = '$id'"));
$ru_kep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil2 WHERE id_profil_risiko = '$id'"));
$ru_kep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil3 WHERE id_profil_risiko = '$id'"));
$ru_kep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_kepatuhan_pil4 WHERE id_profil_risiko = '$id'"));


$ru_lik1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil1 WHERE id_profil_risiko = '$id'"));
$ru_lik2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil2 WHERE id_profil_risiko = '$id'"));
$ru_lik3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil3 WHERE id_profil_risiko = '$id'"));
$ru_lik4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_likuiditas_pil4 WHERE id_profil_risiko = '$id'"));


$ru_rep1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil1 WHERE id_profil_risiko = '$id'"));
$ru_rep2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil2 WHERE id_profil_risiko = '$id'"));
$ru_rep3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil3 WHERE id_profil_risiko = '$id'"));
$ru_rep4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_reputasi_pil4 WHERE id_profil_risiko = '$id'"));


$ru_stra1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil1 WHERE id_profil_risiko = '$id'"));
$ru_stra2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil2 WHERE id_profil_risiko = '$id'"));
$ru_stra3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil3 WHERE id_profil_risiko = '$id'"));
$ru_stra4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM respon_unit_kerja_stratejik_pil4 WHERE id_profil_risiko = '$id'"));



$ket_inhern_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren_kredit WHERE id_profil_risiko = '$id'"));
$ket_inhern_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_operasional WHERE id_profil_risiko = '$id'"));
$ket_inhern_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket_inhern_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$ket_inhern_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_reputasi WHERE id_profil_risiko = '$id'"));
$ket_inhern_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_inheren2_stratejik WHERE id_profil_risiko = '$id'"));


$ket_kpmr_kredit = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_kredit WHERE id_profil_risiko = '$id'"));
$ket_kpmr_operasional = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_operasional WHERE id_profil_risiko = '$id'"));
$ket_kpmr_kepatuhan = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket_kpmr_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_likuiditas WHERE id_profil_risiko = '$id'"));
$ket_kpmr_reputasi = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_reputasi WHERE id_profil_risiko = '$id'"));
$ket_kpmr_stratejik = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_kpmr2_stratejik WHERE id_profil_risiko = '$id'"));

$hasil1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));
$hasil2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));
$hasil3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));
$hasil4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$hasil5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));
$hasil6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));


$ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$id'"));
$ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$id'"));
$ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$id'"));
$ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$id'"));
$ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$id'"));
$ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$id'"));

$pembanding_ket1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_ket2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_ket3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_ket4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_ket5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_ket6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM keterangan_profil_stratejik WHERE id_profil_risiko = '$dp'"));

$inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$id'"));
$inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$id'"));
$inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$id'"));
$inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$id'"));
$inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$id'"));
$inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$id'"));

$kpmr1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$id'"));
$kpmr2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = '$id'"));
$kpmr3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$id'"));
$kpmr4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = '$id'"));
$kpmr5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = '$id'"));
$kpmr6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = '$id'"));


$pembanding_inheren1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_inheren6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_inheren_stratejik WHERE id_profil_risiko = '$dp'"));

$pembanding_kpmr1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kredit WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr2 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_operasional WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr3 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_kepatuhan WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr4 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_likuiditas WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr5 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_reputasi WHERE id_profil_risiko = '$dp'"));
$pembanding_kpmr6 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM hasil_kpmr_stratejik WHERE id_profil_risiko = '$dp'"));

$nilpro = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$id'"));
$pembanding_nilpro = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM nilai_profil WHERE id_profil_risiko = '$dp'"));


$master_likuiditas_P1 = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM master_likuiditas_pilar1 WHERE id_profil_risiko = '$id'"));

$aset_likuid = $master_likuiditas_P1['aset_likuid'];
$total_aset = $master_likuiditas_P1['total_aset'];
$total_dpk = $master_likuiditas_P1['total_dpk'];


$ambang_batas_likuiditas = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM ambang_batas_likuiditas WHERE tahun = '$tahun'"));

$p1a_atas =($total_aset - $aset_likuid);
$p1a_bawah =($total_dpk - $aset_likuid);
$p1a = round(($p1a_atas/$p1a_bawah) * 100, 2);

//par1a
$aba = $ambang_batas_likuiditas['ta_al_per_td_al'];
$ab2a = $ambang_batas_likuiditas['rr_ta_al_per_td_al'];
$ab3a = $ambang_batas_likuiditas['rrr_ta_al_per_td_al'];
$ab4a = $ambang_batas_likuiditas['rrrr_ta_al_per_td_al'];
if ($p1a >= $aba) {
    $hsl1a = 1;
} else if ($p1a < $aba && $p1a >= $ab2a) {
    $hsl1a = 2;
} else if ($p1a < $ab2a && $p1a >= $ab3a) {
    $hsl1a = 3;
} elseif ($p1a < $ab3a && $p1a >= $ab4a) {
    $hsl1a = 4;
} else {
    $hsl1a = 5;
}


function GenerateWord()
{
    // Get a random word
    $nb = rand(3, 10);
    $w = '';
    for ($i = 1; $i <= $nb; $i++)
        $w .= chr(rand(ord('a'), ord('z')));
    return $w;
}

function GenerateSentence()
{
    // Get a random sentence
    $nb = rand(1, 10);
    $s = '';
    for ($i = 1; $i <= $nb; $i++)
        $s .= GenerateWord() . ' ';
    return substr($s, 0, -1);
}


class PDF extends FPDF
{



    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data = null, $colors = null)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }
    function Row2($data = null, $colors = null) {
        // Calculate the height of the row
         // Calculate the height of the row
         $nb = 0;
         for ($i = 0; $i < count($data); $i++)
             $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
         $h = 5 * $nb;
         // Issue a page break first if needed
         $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
           
            // Set fill color for the column
            $this->SetFillColor($colors[$i][0], $colors[$i][1], $colors[$i][2]);
            // Draw the cell
            
            
            $this->MultiCell($w, 5, $data[$i], 0, $a, true);
            
            $this->Rect($x, $y, $w, $h);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }
    
    

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }






























    function Header()
    {
        $this->Image('logo.png', 10, 8, 17);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(40);
        $this->Cell(45, 5, ' HASIL PELAPORAN PROFIL RISIKO KANTOR CABANG');
        $this->Cell(200);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(45, 5, '', 0, 1, 'C');
        $this->Cell(75);
        $this->Cell(45, 5, 'PT.BPR BKK JATENG (PERSERODA)', 0, 1, 'C');
        $this->Cell(45);
        $this->Cell(45, 5, '', 0, 1, 'C');
        $this->Cell(90);
        $this->SetFont('Arial', '', 8);
        $this->Cell(15, 5, 'Jl. Tanjung No.11-A Sekayu, Semarang Tengah, Kota Semarang 50132 - info@bprbkkinfo.com - (024) 86405241 - 0815 1400 0400', 0, 1, 'C');

        $this->SetLineWidth(1);
        $this->Line(10, 31, 200, 31);
        $this->SetLineWidth(0);
        $this->Line(10, 32, 200, 32);
        $this->Ln(10);
    }
    function Footer()
    {
        $this->SetY(15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, 'Halaman' . $this->PageNo() . ' / {nb}', 0, 0, 'R');
    }
    function ttd()
    {

        $this->Ln(10);
        $this->SetFont('Arial', '', 12);
        $this->Cell(130);
        $this->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1, 'C');
        $this->Cell(130);
        $this->Cell(190, 5, 'Mengetahui', 0, 1, 'C');
        $this->Cell(130);
        $this->Cell(190, 5, 'Risk Residence', 0, 1, 'C');
        $this->Ln(16);
        $this->Cell(130);
        $this->SetFont('Arial', 'U', 12);
        $this->Cell(190, 5, '', 0, 1, 'C');
        $this->Cell(130);
        $this->SetFont('Arial', '', 12);
    }

}



$pdf = new PDF('P', 'mm', 'A4');


$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Times', '', 12);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60);
$pdf->Cell(10, 5, 'HASIL LAPORAN PROFIL RISIKO ');

$pdf->Ln(10);


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 5, ' ' );
$pdf->Ln(4);
$pdf->Cell(20, 5, 'Tahun Realisasi '. $tahun);
$pdf->Ln(6);
$pdf->Cell(20, 5,'Profil Risiko '. $kc);

$pdf->Ln(6);

$pdf->SetFont('Arial','', 10);
$pdf->Cell(1);
$pdf->Cell(1, 5, 'Sehubungan dengan telah dilaksanakan pengisian aplikasi simpro, pada tanggal : '.tgl_indo($tgl));

$pdf->Ln(6);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1);
$pdf->Cell(10, 5, 'Tingkat risiko yang telah ditetapkan mengacu pada cakupan penerapan secara umum sebagaimana diatur dalam kebijakan');



$pdf->Ln(4);

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1);
$pdf->Cell(10, 5, 'dan pedoman penerapan manajemen risiko. Maka kami informasikan hasil pengukuran sebagai berikut:');



$pdf->Ln(8);
function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
}

$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO KREDIT)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN KREDIT');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));
$pdf->SetFillColor(130,230,230);


$no =1;


$pdf->Row(array('1','Aset Produktif / Total Aset',  $pil1['hasil_pil1_par1'],  $ket_inhern_kredit['ket_pil1_1']));


$pdf->Row2(array('','Penempatan Bank Lain / Total Aset',  $pil1['hasil_pil1_par1a'],''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Aba Pada 1 Bank Tertinggi / Penempatan Bank Lain',  $pil1['hasil_pil1_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Aba Pada BPR / Penempatan Bank Lain',  $pil1['hasil_pil1_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NOA Kredit fon s/d 150 juta / NOA KYD',  $pil1['hasil_pil1_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit PEP / Total KYD',  $pil1['hasil_pil1_par1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit fon > 350jt / Total KYD',  $pil1['hasil_pil1_par1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Saldo PPAP / Total KYD',  $pil1['hasil_pil1_par1g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','AYDA / KYD',  $pil1['hasil_pil1_par1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row(array('2','Kredit Yang Diberikan / Aset Produktif',  $pil1['hasil_pil1_par2'],  $ket_inhern_kredit['ket_pil1_2']));

$pdf->Row2(array('','Kredit Skema Potong Gaji / Total Kredit',  $pil1['hasil_pil1_par2a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Musiman (Grace Period) / Total KYD',  $pil1['hasil_pil1_par2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Jangka Pendek / Total KYD',  $pil1['hasil_pil1_par2c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Jangka Menengah / Total KYD',  $pil1['hasil_pil1_par2d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Jangka Panjang / Total KYD',  $pil1['hasil_pil1_par2e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Dengan Agunan Tanah dan Bangunan / Total KYD',  $pil1['hasil_pil1_par2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Agunan Kendaraan Bermotor / Total KYD',  $pil1['hasil_pil1_par2g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Agunan Kendaraan Roda 2 / KYD',  $pil1['hasil_pil1_par2h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','OSC Produk KUB / Total KYD',  $pil1['hasil_pil1_par2i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Tanpa Agunan / Total KYD',  $pil1['hasil_pil1_par2j'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Korporasi (Non Perorangan) / Total KYD',  $pil1['hasil_pil1_par2k'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row(array('3','25 Debitur Inti / Total Kredit',  $pil1['hasil_pil1_par3'],  $ket_inhern_kredit['ket_pil1_3']));

$pdf->Row(array('4','Kredit Per Sektor Ekonomi / Total Kredit',  $pil1['hasil_pil1_par4'],  $ket_inhern_kredit['ket_pil1_4']));
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 1',$hasil1['pil1_tingkat_risiko'],  $ket_inhern_kredit['ket_pil1']));




$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Kualitas Aset'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Aset Produktif Bermasalah / Total Aset Produktif',  $pil2['hasil_pil2_par1'],  $ket_inhern_kredit['ket_pil2_1']));

$pdf->Row(array('2','Kredit Bermasalah Neto / Total Kredit',  $pil2['hasil_pil2_par2'],  $ket_inhern_kredit['ket_pil2_2']));



$pdf->Row2(array('','NPL Kredit plafond s/d 150 juta / Total KYD plafond s/d 150 jt',  $pil2['hasil_pil2_par2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NPL Kredit plafond diatas 50 juta / Total KYD plafond diatas 50 juta',  $pil2['hasil_pil2_par2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NPL Kredit Dengan Perikatan APHT / Total KYD',  $pil2['hasil_pil2_par2c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NPL Kredit Dengan Perikatan SKMHT / Total KYD',  $pil2['hasil_pil2_par2d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NPL Nilai Agunan Lebih Rendah Dari Baki Debet / Total Kredit Nilai Agunan Lebih Rendah dari Baki Debet',  $pil2['hasil_pil2_par2e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit Macet sudah jatuh tempo / Total KYD',  $pil2['hasil_pil2_par2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Kredit Kualitas Rendah / Total Kredit',  $pil2['hasil_pil2_par3'],  $ket_inhern_kredit['ket_pil2_3']));
$pdf->Row2(array('','Kredit Par 4 / Total Kredit',  $pil2['hasil_pil2_par3a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kredit DP (PAR 3 + PAR 4 ) / Total Kredit',  $pil2['hasil_pil2_par3b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NOA FPD 6 Bulan Terakhir / NOA Ekspansi 6 Bulan Terakhir',  $pil2['hasil_pil2_par3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Nominal FPD 6 Bulan Terakhir / plafond Ekspansi 6 Bulan Terakhir',  $pil2['hasil_pil2_par3d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 2',$hasil1['pil2_tingkat_risiko'],  $ket_inhern_kredit['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Strategi Penyediaan Dana'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Strategi Penyediaan Dana',  $pil3['hasil_pil3_par1'],  $ket_inhern_kredit['ket_pil3_1']));



$pdf->Row2(array('','Pertumbuhan sektor ekonomi yang tidak dikuasai',  $pil3['hasil_pil3_par1a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan sektor ekonomi yang dikuasai',  $pil3['hasil_pil3_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan OSC dan NPL',  $pil3['hasil_pil3_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penempatan dana antar bank',  $pil3['hasil_pil3_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Konsentrasi Penempatan ABA',  $pil3['hasil_pil3_par1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 3',$hasil1['pil3_tingkat_risiko'],  $ket_inhern_kredit['ket_pil3']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : Faktor Eksternal'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Faktor Eksternal',  $hasil1['pil4_tingkat_risiko'],  $ket_inhern_kredit['ket_pil4_1']));



$pdf->Row2(array('','Layanan Digital Kompetitor',  $pil4['hasil_pil4_par1a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kejadian luar biasa yang berpengaruh terhadap kinerja Bank',  $pil4['hasil_pil4_par1b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Persaingan Layanan antar BPR',  $pil4['hasil_pil4_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Regulasi Pemerintah',  $pil4['hasil_pil4_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 4',$hasil1['pil4_tingkat_risiko'],  $ket_inhern_kredit['ket_pil4']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $hasil1['pil5_tingkat_risiko'],  $ket_inhern_kredit['ket_pil5_1']));



$pdf->Row2(array('','Kompetensi AO',  $pil5['hasil_pil5_par1a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kompetensi Analis',  $pil5['hasil_pil5_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komite Kredit',  $pil5['hasil_pil5_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keputusan dan Realisasi Kredit',  $pil5['hasil_pil5_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Monitoring Penggunaan Dana Kredit',  $pil5['hasil_pil5_par1e'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Kredit',  $pil5['hasil_pil5_par1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Jumlah SDM Perkreditan',  $pil5['hasil_pil5_par1g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kompetensi SDM Perkreditan',  $pil5['hasil_pil5_par1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Internal (Risk Taking Unit dan Satuan Kerja Pengendalian) di Bidang Perkreditan',  $pil5['hasil_pil5_par1k'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 5',$hasil1['pil5_tingkat_risiko'],  $ket_inhern_kredit['ket_pil5']));



//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN KREDIT', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Komposisi Portofolio Aset Dan Tingkat Konsentrasi Kredit',$hasil1['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kualitas Aset',$hasil1['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Strategi Penyediaan Dana',$hasil1['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Faktor Eksternal',$hasil1['pil4_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil1['pil5_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil1['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil1['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN KREDIT', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_kredit['ket_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa





$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI KREDIT');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();





$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket1['inheren_kredit'], $inheren1['hasil_peringkat'],  $pembanding_ket1['inheren_kredit'], $pembanding_inheren1['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Risiko Inheren',$ket1['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa



















//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO OPERASIONAL)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN OPERASIONAL');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Kompleksitas Bisnis Dan Kelembagaan'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Skala Usaha dan Struktur Organisasi',  $pil_op1['hasil_pil1_par1'],  $ket_pil_op1['ket_in_op_pil1_1']));


$pdf->Row(array('2','Jaringan Kantor, rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['hasil_pil1_par2'],  $ket_pil_op1['ket_in_op_pil1_2'].$ket_pil_op1['ket_in_op_pil1_2a'].$ket_pil_op1['ket_in_op_pil1_2b']));

$pdf->Row2(array('','Jaringan Kantor, rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['pilar1_2'], '
  '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['pilar1_2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan',$hasil2['pil1_tingkat_risiko'],  $ket_inhern_operasional['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Sumber Daya Manusia'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kecukupan Kuantitas dan Kualitas SDM',  $pil_op2['hasil_pil2_par1'],  $ket_pil_op2['ket_in_op_pil2_1'].$ket_pil_op2['ket_in_op_pil2_1a'].$ket_pil_op2['ket_in_op_pil2_1b'].$ket_pil_op2['ket_in_op_pil2_1c'].$ket_pil_op2['ket_in_op_pil2_1d'].$ket_pil_op2['ket_in_op_pil2_1e'].$ket_pil_op2['ket_in_op_pil2_1f'].$ket_pil_op2['ket_in_op_pil2_1g'].$ket_pil_op2['ket_in_op_pil2_1h']));
$pdf->Row(array('','','' ,$ket_pil_op2['ket_in_op_pil2_1i'].$ket_pil_op2['ket_in_op_pil2_1j'].$ket_pil_op2['ket_in_op_pil2_1k'].$ket_pil_op2['ket_in_op_pil2_1l'].$ket_pil_op2['ket_in_op_pil2_1m'].$ket_pil_op2['ket_in_op_pil2_1n']));
$pdf->Row2(array('','Kecukupan Kuantitas dan Kualitas SDM',  $pil_op2['pilar2_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Pegawai',  $pil_op2['pilar2_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Jumlah SDM',  $pil_op2['pilar2_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kompetensi SDM',  $pil_op2['pilar2_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Tingkat Turn Over Pegawai Diluar Pensiun dan Pemberhentian Tidak Dengan Hormat',  $pil_op2['pilar2_1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pegawai yang Mendekati Usia Pensiun (usia 50 tahun ke atas)',  $pil_op2['pilar2_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perbandingan NOA Kredit Terhadap Jumlah SDM di Bidang Kredit',  $pil_op2['pilar2_1g'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Beban Kerja Pegawai',  $pil_op2['pilar2_1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Mengembangkan Budaya Organisasi yang sadar risiko dan mengelola risiko',  $pil_op2['pilar2_1j'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rotasi Pegawai',  $pil_op2['pilar2_1k'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rotasi Pejabat Eksekutif',  $pil_op2['pilar2_1l'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Permasalahan Operasional Karena Faktor Manusia (Human Error)',  $pil_op2['hasil_pil2_par2'],  $ket_pil_op2['ket_in_op_pil2_2']));





$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Sumber Daya Manusia',$hasil2['pil2_tingkat_risiko'],  $ket_inhern_operasional['ket_pil2']));








$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Penyimpangan (Fraud)'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Penyimpangan (Fraud)',  $pil_op4['hasil_pil4_par1'],  $ket_pil_op4['ket_in_op_pil4_1'].$ket_pil_op4['ket_in_op_pil4_1a'].$ket_pil_op4['ket_in_op_pil4_1b'].$ket_pil_op4['ket_in_op_pil4_1c'].$ket_pil_op4['ket_in_op_pil4_1d']));
$pdf->Row2(array('','Penyimpangan (Fraud)',  $pil_op4['pilar4_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Penyimpangan',  $pil_op4['pilar4_1a'],  



 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Penyimpangan Pada Pelaksanaan Kegiatan Operasional',  $pil_op4['pilar4_1b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Sebaran Penyimpangan / Fraud',  $pil_op4['pilar4_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Tindakan Fraud',  $pil_op4['pilar4_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Penyimpangan (Fraud)',$hasil2['pil4_tingkat_risiko'],  $ket_inhern_operasional['ket_pil4']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : Faktor Eksternal'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Faktor Eksternal',  $pil_op5['hasil_pil5_par1'],  $ket_pil_op5['ket_in_op_pil5_1'].$ket_pil_op5['ket_in_op_pil5_1a'].$ket_pil_op5['ket_in_op_pil5_1b'].$ket_pil_op5['ket_in_op_pil5_1c'].$ket_pil_op5['ket_in_op_pil5_1d'].$ket_pil_op5['ket_in_op_pil5_1e']));
$pdf->Row2(array('','Kesehatan Pegawai',  $pil_op5['pilar5_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keselamatan Kerja',  $pil_op5['pilar5_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pengaduan Nasabah',  $pil_op5['pilar5_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kelengkapan Ketentuan dan Pedoman Operasional',  $pil_op5['pilar5_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Internal',  $pil_op5['pilar5_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kejadian Luar Biasa yang Berpengaruh Terhadap Kegiatan Layanan',  $pil_op5['pilar5_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 -Faktor Eksternal',$hasil2['pil5_tingkat_risiko'],  $ket_inhern_operasional['ket_pil5']));




$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $pil_op6['hasil_pil6_par1'], $ket_pil_op6['ket_in_op_pil6_1a'].$ket_pil_op6['ket_in_op_pil6_1b'].$ket_pil_op6['ket_in_op_pil6_1c'].$ket_pil_op6['ket_in_op_pil6_1d'].$ket_pil_op6['ket_in_op_pil6_1e'].$ket_pil_op6['ket_in_op_pil6_1f']));
$pdf->Row2(array('','Kesehatan Pegawai',  $pil_op6['pilar6_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keselamatan Kerja',  $pil_op6['pilar6_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pengaduan Nasabah',  $pil_op6['pilar6_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Internal',  $pil_op6['pilar6_1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kejadian Luar Biasa yang Berpengaruh Terhadap Kegiatan Layanan',  $pil_op6['pilar6_1f'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil2['pil6_tingkat_risiko'],  $ket_inhern_operasional['ket_pil6']));




//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN OPERASIONAL', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan',$hasil2['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Sumber Daya Manusia',$hasil2['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Penyimpangan (Fraud)',$hasil2['pil4_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 -  Faktor Eksternal',$hasil2['pil5_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil2['pil6_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil2['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil2['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN OPERASIONAL', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_operasional['ket_inheren']));









$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI OPERASIONAL');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();





$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47, 47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket2['inheren_operasional'], $inheren2['hasil_peringkat'],  $pembanding_ket2['inheren_operasional'], $pembanding_inheren2['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Risiko Inheren',$ket2['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa











//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO KEPATUHAN)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Jenis dan Signifikasi Pelanggaran',  $pil_kep1['hasil_pil1_par1'],  $ket_pil_kep1['ket_in_kep_pil1_1'].$ket_pil_kep1['ket_in_kep_pil1_1a'].$ket_pil_kep1['ket_in_kep_pil1_1b'].$ket_pil_kep1['ket_in_kep_pil1_1c'].$ket_pil_kep1['ket_in_kep_pil1_1d'].$ket_pil_kep1['ket_in_kep_pil1_1e'].$ket_pil_kep1['ket_in_kep_pil1_1f'].$ket_pil_kep1['ket_in_kep_pil1_1g']));
$pdf->Row2(array('','Jenis dan Signifikasi Pelanggaran',  $pil_kep1['pilar1_1'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Pelanggaran',  $pil_kep1['pilar1_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Pelanggaran Ketentuan Internal dan Prosedur',  $pil_kep1['pilar1_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->Row(array('2','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['hasil_pil1_par2'],  $ket_pil_kep1['ket_in_kep_pil1_2'].$ket_pil_kep1['ket_in_kep_pil1_2a'].$ket_pil_kep1['ket_in_kep_pil1_2b'].$ket_pil_kep1['ket_in_kep_pil1_2c'].$ket_pil_kep1['ket_in_kep_pil1_2d'].$ket_pil_kep1['ket_in_kep_pil1_2e'].$ket_pil_kep1['ket_in_kep_pil1_2f'].$ket_pil_kep1['ket_in_kep_pil1_2g'].$ket_pil_kep1['ket_in_kep_pil1_2h']));

$pdf->Row2(array('','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['pilar1_2'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row2(array('','Pengembangan Budaya Patuh Pada Semua Jenjang Organisasi',  $pil_kep1['pilar1_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Implementasi Kebijakan dan Prosedur Penerbitan Produk dan/atau Pelaksanaan Aktivitas Baru',  $pil_kep1['pilar1_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Sanksi Administratif yang Diterima dari Pihak Eksternal',  $pil_kep1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Denda Sebagai Akibat Dari Pengenaan Sanksi',  $pil_kep1['pilar1_2e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Tindak Lanjut Hasil Pemeriksaan OJK, Audit KAP',  $pil_kep1['pilar1_2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Monitoring Kewajiban dan Komitmen Bank terhadap OJK, Pemegang Saham dan Otoritas Lain',  $pil_kep1['pilar1_2g'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain',$hasil3['pil1_tingkat_risiko'],  $ket_inhern_kepatuhan['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Faktor Kelemahan Aspek Hukum'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kelemahan Dalam Perikatan',  $pil_kep2['hasil_pil2_par1'],  $ket_pil_kep2['ket_in_kep_pil2_1'].$ket_pil_kep2['ket_in_kep_pil2_1a']));
$pdf->Row2(array('','Kelemahan Dalam Perikatan',  $pil_kep2['pilar2_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Corporate Legal',  $pil_kep2['pilar2_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan',  $pil_kep2['hasil_pil2_par2'],  $ket_pil_kep2['ket_in_kep_pil2_2'].$ket_pil_kep2['ket_in_kep_pil2_2a']));
$pdf->Row2(array('','Litigasi Terkait Nominal Gugatan Atau Estimasi Kerugian Yang Dialami BPR Akibat Gugatan',  $pil_kep2['pilar2_2'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pendampingan Hukum',  $pil_kep2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['hasil_pil2_par3'],  $ket_pil_kep2['ket_in_kep_pil2_3'].$ket_pil_kep2['ket_in_kep_pil2_3a']));
$pdf->Row2(array('','Litigasi Terkait Kerugian Yang Dialami Karena Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['pilar2_3'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kerugian Akibat Putusan Pengadilan Berkekuatan Hukum Tetap',  $pil_kep2['pilar2_3a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Faktor Kelemahan Aspek Hukum',$hasil3['pil2_tingkat_risiko'],  $ket_inhern_kepatuhan['ket_pil2']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_kep3['hasil_pil3_par1'], $ket_pil_kep3['ket_in_kep_pil3_1a'].$ket_pil_kep3['ket_in_kep_pil3_1b'].$ket_pil_kep3['ket_in_kep_pil3_1c'].$ket_pil_kep3['ket_in_kep_pil3_1d'].$ket_pil_kep3['ket_in_kep_pil3_1e'].$ket_pil_kep3['ket_in_kep_pil3_1f'].$ket_pil_kep3['ket_in_kep_pil3_1g']));

$pdf->Row2(array('','Komitmen Capaian Target RBB',  $pil_kep3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Teladan Pucuk Pimpinan',  $pil_kep3['pilar3_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);




$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil3['pil3_tingkat_risiko'],  $ket_inhern_kepatuhan['ket_pil3']));







//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN KEPATUHAN', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain',$hasil3['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Faktor Kelemahan Aspek Hukum',$hasil3['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil3['pil3_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil3['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil3['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN KEPATUHAN', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_kepatuhan['ket_inheren']));









$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI KEPATUAHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();




$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket3['inheren_kepatuhan'], $inheren3['hasil_peringkat'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_inheren3['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;



$pdf->Row(array('Risiko Inheren',$ket3['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa









$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO LIKUIDITAS)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN LIKUIDITAS');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Komposisi dan Konsentrasi Aset dan Kewajiban'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Aset Likuid / Total Aset',  $pil_lik1['hasil_pil1_par1'],  $ket_inhern_likuiditas['ket_pil1_1']));
$pdf->Row2(array('','Total Aset-Aset Likuid / Total DPK-Aset Likuid',  $hsl1a, ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Aset Likuid / Kewajiban Lancar',  $pil_lik1['hasil_pil1_par2'],$ket_inhern_likuiditas['ket_pil1_2']));

$pdf->Row2(array('','Total Aset Likuid / Pendanaan jangka Pendek',  $pil_lik1['hasil_pil1_par2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Aset Likuid / Kewajiban Jangka Pendek',  $pil_lik1['hasil_pil1_par2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Arus Kas Netto / Total DPK',  $pil_lik1['hasil_pil1_par2c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Tabungan / Total DPK',  $pil_lik1['hasil_pil1_par2d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Deposito Jangka Waktu 3 bln / Total DPK',  $pil_lik1['hasil_pil1_par2e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Deposito Jangka Waktu 6 bln / Total DPK',  $pil_lik1['hasil_pil1_par2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Deposito Jangka Waktu 12 bln / Total DPK',  $pil_lik1['hasil_pil1_par2g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank',  $pil_lik1['hasil_pil1_par3'],$ket_inhern_likuiditas['ket_pil1_3']));

$pdf->Row2(array('','DPK Yang Dijamin LPS / DPK',  $pil_lik1['hasil_pil1_par3a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Alat Likuid + Kredit Lancar / Dana Pihak Ke 3',  $pil_lik1['hasil_pil1_par3b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Deposito Tenor Sampai Dengan 6 bln / Alat Likuid',  $pil_lik1['hasil_pil1_par3c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan Kredit / Pertumbuhan Simpanan',  $pil_lik1['hasil_pil1_par3d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','25 Deposan dan Penabung Terbesar / Total DPK',  $pil_lik1['hasil_pil1_par4'],$ket_inhern_likuiditas['ket_pil1_4']));

$pdf->Row(array('5','Kredit Yang Diberikan / Total Dana Pihak Ketiga Bukan Bank',  $pil_lik1['hasil_pil1_par5'],$ket_inhern_likuiditas['ket_pil1_5']));

$pdf->Row2(array('','Pendanaan Non Inti-Alat Likuid / Total Aset-Aset Likuid',  $pil_lik1['hasil_pil1_par5a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Deposito Rate Spesial / Alat Likuid',  $pil_lik1['hasil_pil1_par5b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Aset Likuid / Pendanaan Non Inti',  $pil_lik1['hasil_pil1_par5c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Komposisi dan Konsentrasi Aset dan Kewajiban',$hasil4['pil1_tingkat_risiko'],  $ket_inhern_likuiditas['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan	',  $pil_lik2['hasil_pil2_par1'],  $ket_inhern_likuiditas['ket_pil2_1']));
$pdf->Row2(array('','Sumber Pendanaan Untuk Memenuhi Kebutuhan',  $pil_lik2['hasil_pil2_par1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Terhadap Produk Kredit dan Simpanan',  $pil_lik2['hasil_pil2_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Sumber Pendanaan Non Inti',  $pil_lik2['hasil_pil2_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Penilaian terhadap seberapa luas atau seberapa besar BPR memiliki komitmen pendanaan yang dapat digunakan jika dibutuhkan',  $pil_lik2['hasil_pil2_par2'],  $ket_inhern_likuiditas['ket_pil2_2']));



$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan',$hasil4['pil2_tingkat_risiko'],  $ket_inhern_likuiditas['ket_pil2']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $pil_lik3['hasil_pil3_par1'],  $ket_inhern_likuiditas['ket_pil3_1']));
$pdf->Row2(array('','Identifikasi Risk Events yang Mempengaruhi Kemampuan Likuiditas yang Bersumber dari Eksternal',  $pil_lik3['hasil_pil3_par1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi dan Evaluasi terhadap Jenis Risiko lain yang meningkatkan risiko likuiditas',  $pil_lik3['hasil_pil3_par1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Monitoring Tingkat Suku Bunga Pasar',  $pil_lik3['hasil_pil3_par1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);




$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil4['pil3_tingkat_risiko'],  $ket_inhern_likuiditas['ket_pil3']));







//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN LIKUIDITAS', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Komposisi Portofolio Aset Dan Tingkat Konsentrasi Likuiditas',$hasil4['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kualitas Asetm',$hasil4['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil4['pil3_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil4['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil4['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN LIKUIDITAS', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_likuiditas['ket_inheren']));








$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI LIKUIDITAS');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();





$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket4['inheren_likuiditas'], $inheren4['hasil_peringkat'],  $pembanding_ket4['inheren_likuiditas'], $pembanding_inheren4['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Risiko Inheren',$ket4['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO REPUTASI)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['hasil_pil1_par1'],  $ket_pil_rep1['ket_in_rep_pil1_1'].$ket_pil_rep1['ket_in_rep_pil1_1a'].$ket_pil_rep1['ket_in_rep_pil1_1b'].$ket_pil_rep1['ket_in_rep_pil1_1c'].$ket_pil_rep1['ket_in_rep_pil1_1d']));
$pdf->Row2(array('','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['pilar1_1'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Negatif Terhadap Perusahaan Terkait',  $pil_rep1['pilar1_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->Row(array('2','Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi',  $pil_rep1['hasil_pil1_par2'],  $ket_pil_rep1['ket_in_rep_pil1_2'].$ket_pil_rep1['ket_in_rep_pil1_2a'].$ket_pil_rep1['ket_in_rep_pil1_2b'].$ket_pil_rep1['ket_in_rep_pil1_2c'].$ket_pil_rep1['ket_in_rep_pil1_2d']));

$pdf->Row2(array('','Signifikansi Dan Materualitas Dampak Yang Ditimbulkan Akibat Kejadian Reputasi',  $pil_rep1['pilar1_2'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Dan Variasi Pemberitaan',  $pil_rep1['pilar1_2a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jangkauan Dan Kredibilitas Media Massa',  $pil_rep1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Kejadian Terkait dengan Risiko Reputasi pada Periode Penilaian',  $pil_rep1['pilar1_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pemberitaan Negatif (Regional Jawa Tengah) pada Media Massa Cetak dan Elektronik',  $pil_rep1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR',$hasil5['pil1_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Frekuensi Dan Signifikansi Pengaduan Nasabah'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Administrasi Dan Tindak Lanjut Pengaduan Nasabah',  $pil_rep2['hasil_pil2_par1'],  $ket_pil_rep2['ket_in_rep_pil2_1'].$ket_pil_rep2['ket_in_rep_pil2_1a'].$ket_pil_rep2['ket_in_rep_pil2_1b'].$ket_pil_rep2['ket_in_rep_pil2_1c'].$ket_pil_rep2['ket_in_rep_pil2_1d']));
$pdf->Row2(array('','Administrasi Dan Tindak Lanjut Pengaduan Nasabah',  $pil_rep2['pilar2_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Metode Pengaduan Nasabah',  $pil_rep2['pilar2_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Hasil Analisa Informasi pada Media atau Jejaring Sosial',  $pil_rep2['pilar2_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Informasi dari Lembaga Perlindungan Konsumen dan Konsumen',  $pil_rep2['pilar2_1c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Signifikansi Dan Materialitas Pengaduan nasabah',  $pil_rep2['hasil_pil2_par2'],  $ket_pil_rep2['ket_in_rep_pil2_2'].$ket_pil_rep2['ket_in_rep_pil2_2a'].$ket_pil_rep2['ket_in_rep_pil2_2b']));
$pdf->Row2(array('','Signifikansi Dan Materialitas Pengaduan nasabah',  $pil_rep2['pilar2_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Aduan Nasabah',  $pil_rep2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pengaduan Nasabah yang Dapat Diselesaikan',  $pil_rep2['pilar2_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Frekuensi Dan Signifikansi Pengaduan Nasabah',$hasil5['pil2_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Transparansi Informasi Keuangan'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('2','Transparansi Informasi Keuangan',  $pil_rep3['hasil_pil3_par2'],  $ket_pil_rep3['ket_in_rep_pil3_2'].$ket_pil_rep3['ket_in_rep_pil3_2a'].$ket_pil_rep3['ket_in_rep_pil3_2b']));
$pdf->Row2(array('','Kegiatan Pemasaran',  $pil_rep3['pilar3_2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Fasilitas Produk Dan Layanan',  $pil_rep3['pilar3_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Transparansi Informasi Keuangan',$hasil5['pil3_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_rep4['hasil_pil4_par1'], $ket_pil_rep4['ket_in_rep_pil4_1a'].$ket_pil_rep4['ket_in_rep_pil4_1b'].$ket_pil_rep4['ket_in_rep_pil4_1c']));
$pdf->Row2(array('','Laporan Pemeriksaan SKAI',  $pil_rep4['pilar4_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Laporan Hasil Monitoring Satuan Kerja Kepatuhan',  $pil_rep4['pilar4_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Positif Tentang Kinerja dan Kegiatan Bank',  $pil_rep4['pilar4_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil5['pil4_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil4']));













//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN REPUTASI', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR',$hasil5['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Frekuensi Dan Signifikansi Pengaduan Nasabah',$hasil5['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3- Pelanggaran Etika Bisnis',$hasil5['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil5['pil4_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil5['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil5['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN REPUTASI', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_reputasi['ket_inheren']));









$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();






$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket5['inheren_reputasi'], $inheren5['hasil_peringkat'], $pembanding_ket5['inheren_reputasi'], $pembanding_inheren5['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Risiko Inheren',$ket5['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(8, 5, '(RISIKO STRATEJIK)');
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(1);
$pdf->Cell(8, 5, 'INHEREN STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(74, 5, 'Parameter', 1, 0, 'C', 0);



$pdf->Cell(15, 5, 'Nilai', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Keterangan', 1, 0, 'C', 0);
$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Penetapan Strategi Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Penetapan Strategi Bisnis',  $pil_stra1['hasil_pil1_par1'],  $ket_pil_stra1['ket_in_stra_pil1_1'].$ket_pil_stra1['ket_in_stra_pil1_1a'].$ket_pil_stra1['ket_in_stra_pil1_1b'].$ket_pil_stra1['ket_in_stra_pil1_1c'].$ket_pil_stra1['ket_in_stra_pil1_1d'].$ket_pil_stra1['ket_in_stra_pil1_1e'].$ket_pil_stra1['ket_in_stra_pil1_1f']));
$pdf->Row2(array('','Penetapan Strategi Bisnis',  $pil_stra1['pilar1_1'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Posisi Kompetitif di industri',  $pil_stra1['pilar1_1a'],  
 
 
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Faktor Eksternal',  $pil_stra1['pilar1_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Sumber Daya',  $pil_stra1['pilar1_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Potensi Pasar',  $pil_stra1['pilar1_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis',$hasil6['pil1_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Penyusunan Rencana Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis',  $pil_stra2['hasil_pil2_par1'],  $ket_pil_stra2['ket_in_stra_pil2_1'].$ket_pil_stra2['ket_in_stra_pil2_1a'].$ket_pil_stra2['ket_in_stra_pil2_1b'].$ket_pil_stra2['ket_in_stra_pil2_1c'].$ket_pil_stra2['ket_in_stra_pil2_1d'].$ket_pil_stra2['ket_in_stra_pil2_1e'].$ket_pil_stra2['ket_in_stra_pil2_1f'].$ket_pil_stra2['ket_in_stra_pil2_1g'].$ket_pil_stra2['ket_in_stra_pil2_1h'].$ket_pil_stra2['ket_in_stra_pil2_1i']));
$pdf->Row2(array('','Pertimbangan faktor eksternal dan internal dalam menyusun rencana dan model bisnis',  $pil_stra2['pilar2_1'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perubahan Lingkungan Bisnis',  $pil_stra2['pilar2_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perkembangan Teknologi',  $pil_stra2['pilar2_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Struktur Organisasi dan SDM',  $pil_stra2['pilar2_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengendalian Internal',  $pil_stra2['pilar2_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Produk Eksisting',  $pil_stra2['pilar2_1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Layanan Eksisting',  $pil_stra2['pilar2_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Perubahan Lingkungan Bisnis',  $pil_stra2['pilar2_1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['hasil_pil2_par2'],  $ket_pil_stra2['ket_in_stra_pil2_2'].$ket_pil_stra2['ket_in_stra_pil2_2a'].$ket_pil_stra2['ket_in_stra_pil2_2b'].$ket_pil_stra2['ket_in_stra_pil2_2c']));
$pdf->Row2(array('','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['pilar2_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kondisi persaingan / kompetitor',  $pil_stra2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Preferensi Nasabah',  $pil_stra2['pilar2_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis',$hasil6['pil2_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Pencapaian Target Bisnis'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas',  $pil_stra3['hasil_pil3_par1'],  $ket_pil_stra3['ket_in_stra_pil3_1'].$ket_pil_stra3['ket_in_stra_pil3_1a'].$ket_pil_stra3['ket_in_stra_pil3_1b'].$ket_pil_stra3['ket_in_stra_pil3_1c'].$ket_pil_stra3['ket_in_stra_pil3_1d'].$ket_pil_stra3['ket_in_stra_pil3_1e'].$ket_pil_stra3['ket_in_stra_pil3_1f'].$ket_pil_stra3['ket_in_stra_pil3_1g'].$ket_pil_stra3['ket_in_stra_pil3_1h'].$ket_pil_stra3['ket_in_stra_pil3_1i'].$ket_pil_stra3['ket_in_stra_pil3_1j'].$ket_pil_stra3['ket_in_stra_pil3_1k'].$ket_pil_stra3['ket_in_stra_pil3_1l'].$ket_pil_stra3['ket_in_stra_pil3_1m']));
$pdf->Row(array('','',  '',  $ket_pil_stra3['ket_in_stra_pil3_1n'].$ket_pil_stra3['ket_in_stra_pil3_1o'].$ket_pil_stra3['ket_in_stra_pil3_1p']), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perbandingan realisasi dan target indikator keuangan utama sesuai ketentuan rencana bisnis bpr, khususnya untuk faktor permodalan, kualitas aset, kredit, likuiditas, penyaluran kredit kepada umkm, dan rentabilitas',  $pil_stra3['pilar3_1'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Capaian target kuantitatif terhadap 6 parameter kuantitaif',  $pil_stra3['pilar3_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Modal Inti',  $pil_stra3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Saldo Kredit Bermasalah',  $pil_stra3['pilar3_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Laba Sebelum Pajak',  $pil_stra3['pilar3_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','NIM',  $pil_stra3['pilar3_1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komposisi Tabungan Terhadap Dana Pihak Ketiga',  $pil_stra3['pilar3_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komposisi Deposito Terhadap Dana Pihak Ketiga',  $pil_stra3['pilar3_1g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komposisi Pendapatan Bunga Kontraktual Terhadap Aset Produktif',  $pil_stra3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komposisi Pendapatan Bunga Kontraktual Terhadap Pendapatan',  $pil_stra3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komposisi Biaya Tenaga Kerja terhadap Beban Operasional',  $pil_stra3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Trend Pertumbuhan Aset',  $pil_stra3['pilar3_1k'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Trend Pertumbuhan Kredit',  $pil_stra3['pilar3_1l'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Trend Pertumbuhan Dana',  $pil_stra3['pilar3_1m'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Trend Pertumbuhan Laba',  $pil_stra3['pilar3_1n'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan Penyaluran pada Sektor Usaha Produktif',  $pil_stra3['pilar3_1o'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penerimaan Hapus Buku',  $pil_stra3['pilar3_1p'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis',  $pil_stra3['hasil_pil3_par2'],  $ket_pil_stra3['ket_in_stra_pil3_2'].$ket_pil_stra3['ket_in_stra_pil3_2a'].$ket_pil_stra3['ket_in_stra_pil3_2b'].$ket_pil_stra3['ket_in_stra_pil3_2c'].$ket_pil_stra3['ket_in_stra_pil3_2d'].$ket_pil_stra3['ket_in_stra_pil3_2e'].$ket_pil_stra3['ket_in_stra_pil3_2f']));
$pdf->Row2(array('','Rekam jejak (track record) keberhasilan bpr dalam menerapkan keputusan strategis terkait dengan faktor pengembangan produk/jasa baru, perubahan sasaran bisnis, investasi strategis, rencana penggabungan, peleburan, dan pengambilalihan, serta pencapaian target bisnis',  $pil_stra3['pilar3_2'],  '




 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Capaian target kualitatif',  $pil_stra3['pilar3_2a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Realisasi Pemindahan Jaringan Kantor',  $pil_stra3['pilar3_2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis',$hasil6['pil3_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_stra4['hasil_pil4_par1'], $ket_pil_stra4['ket_in_stra_pil4_1a'].$ket_pil_stra4['ket_in_stra_pil4_1b'].$ket_pil_stra4['ket_in_stra_pil4_1c'].$ket_pil_stra4['ket_in_stra_pil4_1d']));
$pdf->Row2(array('','Evaluasi Isu Stratejik Akibat Perubahan Lingkungan Bisnis',  $pil_stra4['pilar4_1a'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row2(array('','Evaluasi Capaian Target RBB',  $pil_stra4['pilar4_1c'],  '
  '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 8);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Lainnya',$hasil6['pil4_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil4']));













//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN INHEREN STRATEJIK', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 8);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis',$hasil6['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis',$hasil6['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis',$hasil6['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Lainnya',$hasil6['pil4_tingkat_risiko']));
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian Inheren', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $hasil6['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $hasil6['hasil_peringkat'] , 1, 0, 'C', 0);




$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN INHEREN STRATEJIK', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_stratejik['ket_inheren']));







$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();








$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);


$pdf->Cell(47, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(47, 5, 'Peringkat', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 8);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(47, 47, 47, 47));
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket6['inheren_stratejik'], $inheren6['hasil_peringkat'], $pembanding_ket6['inheren_stratejik'], $pembanding_inheren6['hasil_peringkat']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Risiko Inheren',$ket6['ket_profil_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa










//Membuat Koneksi ke database akademik



$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(1);
$pdf->Cell(8, 5, '(PROFIL NILAI KOMPOSIT)');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);


$pdf->Cell(47, 5, 'Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Peringkat', 1, 0, 'C', 0);

$pdf->Cell(47, 5, 'Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Peringkat', 1, 0, 'C', 0);

$pdf->SetWidths(array(47, 23.5, 23.5, 47, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;

$pdf->Cell(47, 5,'Risiko kredit' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket1['inheren_kredit'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren1['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko kredit' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket1['inheren_kredit'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren1['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Risiko operasional' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket2['inheren_operasional'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren2['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko operasional' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket2['inheren_operasional'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren2['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Risiko kepatuhan' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket3['inheren_kepatuhan'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren3['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko kepatuhan' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket3['inheren_kepatuhan'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren3['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Risiko likuiditas' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket4['inheren_likuiditas'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren4['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko likuiditas' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket4['inheren_likuiditas'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren4['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Risiko reputasi' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket5['inheren_reputasi'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren5['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko reputasi' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket5['inheren_reputasi'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren5['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Risiko stratejik' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $ket6['inheren_stratejik'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $inheren6['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Risiko stratejik' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_ket6['inheren_stratejik'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_inheren6['hasil_peringkat'], 1, 0, 'C', 0);

$pdf->Ln();

$pdf->Cell(47, 5,'Peringkat Risiko' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $nilpro['total_nilai'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $nilpro['ket_total_nilai'], 1, 0, 'C', 0);

$pdf->Cell(47, 5,'Dikutip dari laporan sebelumnya' , 1, 0, '', 0);
$pdf->Cell(23.5, 5, $pembanding_nilpro['total_nilai'], 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, $pembanding_nilpro['ket_total_nilai'], 1, 0, 'C', 0);









$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(188, 5, 'Uraian', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 8);

$pdf->SetWidths(array(188));
$pdf->SetAligns(array());
$pdf->Ln();
$no =1;


$pdf->Row(array($nilpro['ket_nilai_risiko']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa




$pdf->Ln(30);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1, 'C');
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Mengetahui', 0, 1, 'C');
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Risk Residence', 0, 1, 'C');
$pdf->Ln(16);
$pdf->Cell(50);
$pdf->SetFont('Arial', 'U', 12);
$pdf->Cell(190, 5,$nama_kc = $frame['nama'], 0, 1, 'C');
$pdf->Cell(50);
$pdf->SetFont('Arial', '', 12);




$pdf->Output();
