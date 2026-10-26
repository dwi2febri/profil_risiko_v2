
<?php
require('fpdf182/fpdf.php');

include 'fetch.php';
error_reporting(0);
ini_set('display_errors', 0);
$id_kepatuhan = $_GET['id'];


$id = $_GET['id'];
$frame = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM frame_laporan_profil_risiko 
INNER JOIN jenis_cabang ON frame_laporan_profil_risiko.kantor_cabang = jenis_cabang.id_cabang
INNER JOIN user ON frame_laporan_profil_risiko.dibuat_by = user.user_id WHERE id_profil_risiko = '$id'"));
$dp = $frame['data_pembanding'];
$tahun = $frame['tahun'];
$kc = $frame['cabang'];
$tgl = $frame['dibuat_at'];

$per = $frame['periode'];
if ($per ==1) {
    $periode_lap = 'Triwulan 1';
} else if ($per ==2) {
    $periode_lap = 'Triwulan 2 / Semester 1';
} else if ($per ==3) {
    $periode_lap = 'Triwulan 3';
} elseif ($per ==4) {
    $periode_lap = 'Triwulan 4 / Semester 2';
} else {
    $periode_lap = '-';
}


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
        $h = 4 * $nb;
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
            $this->MultiCell($w, 4, $data[$i], 0, $a);
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
        $this->Cell(45, 5, ' HASIL PELAPORAN PROFIL RISIKO KANTOR PUSAT');
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
        $this->Cell(190, 5, 'Kepala Satuan Kerja Manajemen Risiko', 0, 1, 'C');
        $this->Ln(16);
        $this->Cell(130);
        $this->SetFont('Arial', 'U', 12);
        $this->Cell(190, 5, '', 0, 1, 'C');
        $this->Cell(130);
        $this->SetFont('Arial', '', 12);
    }

}



$pdf = new PDF('P', 'mm', array(210, 330));


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
$pdf->Cell(20, 5, $periode_lap);
$pdf->Ln(6);
$pdf->Cell(20, 5,'Profil Risiko'. $kc);

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

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO KREDIT)');
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

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 1',$hasil1['pil1_tingkat_risiko'],  $ket_inhern_kredit['ket_pil1']));




$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Kualitas Aset'));

$pdf->SetFont('Arial', '', 7);
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 2',$hasil1['pil2_tingkat_risiko'],  $ket_inhern_kredit['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Strategi Penyediaan Dana'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Strategi Penyediaan Dana',  $pil3['hasil_pil3_par1'],  $ket_inhern_kredit['ket_pil3_1']));



$pdf->Row2(array('','Pertumbuhan sektor ekonomi yang tidak dikuasai',  $pil3['hasil_pil3_par1a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan sektor ekonomi yang dikuasai',  $pil3['hasil_pil3_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pertumbuhan OSC dan NPL',  $pil3['hasil_pil3_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penempatan dana antar bank',  $pil3['hasil_pil3_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Konsentrasi Penempatan ABA',  $pil3['hasil_pil3_par1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 3',$hasil1['pil3_tingkat_risiko'],  $ket_inhern_kredit['ket_pil3']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : Faktor Eksternal'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Faktor Eksternal',  $hasil1['pil4_tingkat_risiko'],  $ket_inhern_kredit['ket_pil4_1']));



$pdf->Row2(array('','Layanan Digital Kompetitor',  $pil4['hasil_pil4_par1a'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kejadian luar biasa yang berpengaruh terhadap kinerja Bank',  $pil4['hasil_pil4_par1b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Persaingan Layanan antar BPR',  $pil4['hasil_pil4_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Regulasi Pemerintah',  $pil4['hasil_pil4_par1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Rekapitulasi penilaian tingkat risiko untuk pilar 4',$hasil1['pil4_tingkat_risiko'],  $ket_inhern_kredit['ket_pil4']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('LAINNYA'));

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Kelengkapan Ketentuan & Pedoman Perkreditan',  $pil5['hasil_pil5_par1i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketersediaan Sistem Informasi Manajemen',  $pil5['hasil_pil5_par1j'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Internal (Risk Taking Unit dan Satuan Kerja Pengendalian) di Bidang Perkreditan',  $pil5['hasil_pil5_par1k'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_kredit['ket_inheren']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa



$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR KREDIT');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko kredit yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_kredit1['pil1_total1'],  $ru1['respon_pil1_1a'].$ru1['respon_pil1_1b'].$ru1['respon_pil1_1c'].$ru1['respon_pil1_1d'].$ru1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko kredit yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP Perkreditan, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_kredit1['pilar1_1a'], '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko kredit yang disetujui Dewan Komisaris telah dilakukan (Ketentuan perkreditan yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_kredit1['pilar1_1b'],  '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kredit dalam menjalankan tugas dan fungsinya',  $kpmr_kredit1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko kredit sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_kredit1['pilar1_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_kredit1['pilar1_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko kredit secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_kredit1['pil1_total2'],  $ru1['respon_pil1_2a'].$ru1['respon_pil1_2b'].$ru1['respon_pil1_2c'].$ru1['respon_pil1_2d'].$ru1['respon_pil1_2e']));

$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko kredit secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_kredit1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko kredit kepada Direksi secara tertulis dan forum rapat',  $kpmr_kredit1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko kredit',  $kpmr_kredit1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko kredit',  $kpmr_kredit1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_kredit1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko kredit, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_kredit1['pil1_total3'],  $ru1['respon_pil1_3a'].$ru1['respon_pil1_3b'].$ru1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kredit (Pelatihan tentang manajemen risiko kredit yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko kredit)',  $kpmr_kredit1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko kredit yang disetujui Direksi apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP Perkreditan, SE Direksi, SK BWMK)',  $kpmr_kredit1['pilar1_3b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko kredit yang disetujui Direksi dilakukan (Ketentuan perkreditan yang diterbitkan selama periode penilaian)',  $kpmr_kredit1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko kredit, dan melakukan komunikasi kebijakan Manajemen Risiko kredit terhadap seluruh jenjang organisasi BPR?',  $kpmr_kredit1['pil1_total4'],  $ru1['respon_pil1_4a'].$ru1['respon_pil1_4b'].$ru1['respon_pil1_4c'].$ru1['respon_pil1_4d'].$ru1['respon_pil1_4e']));

$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko kredit secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_kredit1['pilar1_4a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko kredit',  $kpmr_kredit1['pilar1_4b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko kredit kepada seluruh unit kerja',  $kpmr_kredit1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_kredit1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_kredit1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi kredit dan fungsi Manajemen Risiko kredit?',  $kpmr_kredit1['pil1_total5'],  $ru1['respon_pil1_5a'].$ru1['respon_pil1_5b'].$ru1['respon_pil1_5c'].$ru1['respon_pil1_5d']));

$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perkreditan dan melaksanakan tugasnya secara independen',  $kpmr_kredit1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja perkreditan telah didukung dengan kompetensi yang baik',  $kpmr_kredit1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko perkreditan telah didukung dengan kompetensi yang baik',  $kpmr_kredit1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses perkreditan dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_kredit1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko kredit?',  $kpmr_kredit1['pil1_total6'],  $ru1['respon_pil1_6a'].$ru1['respon_pil1_6b'].$ru1['respon_pil1_6c']));

$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko kredit, tidak terdapat perangkapan jabatan, independen',  $kpmr_kredit1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_kredit1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang perkreditan',  $kpmr_kredit1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr1['pil1_tingkat_risiko'],  $ket_kpmr_kredit['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko kredit yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_kredit2['pil2_total1'],  $ru2['respon_pil2_1a'].$ru2['respon_pil2_1b'].$ru2['respon_pil2_1c'].$ru2['respon_pil2_1d'].$ru2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko kredit',  $kpmr_kredit2['pilar2_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko kredit',  $kpmr_kredit2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko kredit dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_kredit2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko kredit memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko kredit, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_kredit2['pilar2_1d'],  '


  
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_kredit2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki kebijakan Manajemen Risiko kredit yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_kredit2['pil2_total2'],  $ru2['respon_pil2_2a'].$ru2['respon_pil2_2b'].$ru2['respon_pil2_2c'].$ru2['respon_pil2_2d'].$ru2['respon_pil2_2e'].$ru2['respon_pil2_2f'].$ru2['respon_pil2_2g'].$ru2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko kredit yang ditetapkan dalam SK Direksi',  $kpmr_kredit2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko kredit',  $kpmr_kredit2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_kredit2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko kredit',  $kpmr_kredit2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_kredit2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi perkreditan',  $kpmr_kredit2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_kredit2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_kredit2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko kredit sesuai dengan ketentuan?',  $kpmr_kredit2['pil2_total3'],  $ru2['respon_pil2_3a'].$ru2['respon_pil2_3b'].$ru2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_kredit2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_kredit2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_kredit2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr1['pil2_tingkat_risiko'],  $ket_kpmr_kredit['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko kredit yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko kredit?',  $kpmr_kredit3['pil3_total1'],  $ru3['respon_pil3_1a'].$ru3['respon_pil3_1b'].$ru3['respon_pil3_1c'].$ru3['respon_pil3_1d'].$ru3['respon_pil3_1e'].$ru3['respon_pil3_1f'].$ru3['respon_pil3_1g'].$ru3['respon_pil3_1h'].$ru3['respon_pil3_1i'].$ru3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas perkreditan seluruh SDM telah berpedoman pada penerapan manajemen risiko kredit',  $kpmr_kredit3['pilar3_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas perkreditan',  $kpmr_kredit3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses perkreditan dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_kredit3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang perkreditan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_kredit3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko kredit telah didukung dengan data kredit yang akurat dan informatif',  $kpmr_kredit3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko kredit telah melakukan analisa karakteristik risiko kredit yang melekat pada produk dan layanan',  $kpmr_kredit3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko kredit telah dilakukan evaluasi',  $kpmr_kredit3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko kredit telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_kredit3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko kredit telah dilakukan evaluasi terhadap eksposur risiko kredit',  $kpmr_kredit3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko kredit apakah juga dilakukan penyesuaian pelaporan',  $kpmr_kredit3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko kredit serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_kredit3['pil3_total2'],  $ru3['respon_pil3_2a'].$ru3['respon_pil3_2b'].$ru3['respon_pil3_2c'].$ru3['respon_pil3_2d'].$ru3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_kredit3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko kredit dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_kredit3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko kredit yang lengkap dan cepat',  $kpmr_kredit3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan kepatuhan terhadap kebijakan manajemen risiko kredit (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_kredit3['pilar3_2d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_kredit3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr1['pil3_tingkat_risiko'],  $ket_kpmr_kredit['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melaksanakan audit secara berkala terhadap penerapan Manajemen Risiko kredit,menyampaikan laporan hasil audit intern, dan memastikan tindak lanjut atas temuan pemeriksaan?',  $kpmr_kredit4['pil4_total1'],  $ru4['respon_pil4_1a'].$ru4['respon_pil4_1b'].$ru4['respon_pil4_1c'].$ru4['respon_pil4_1d'].$ru4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko kredit di berapa cabang atau unit kerja di bidang manajemen risiko kreditApakah dalam aktvitas perkreditan seluruh SDM telah berpedoman pada penerapan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1a'], '



 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko kredit telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_kredit4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko kredit telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko kredit',  $kpmr_kredit4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko kredit',  $kpmr_kredit4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko kredit telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_kredit4['pil4_total2'],  $ru4['respon_pil4_2a'].$ru4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perkreditan',  $kpmr_kredit4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja perkreditan telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_kredit4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr1['pil4_tingkat_risiko'],  $ket_kpmr_kredit['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR KREDIT', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengawasan Direksi dan Dewan Komisaris',$kpmr1['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr1['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr1['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr1['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr1['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr1['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR KREDIT', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_kredit['ket_kpmr']));





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

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket1['inheren_kredit'], $ket1['kpmr_kredit'], $ket1['tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_ket1['inheren_kredit'], $pembanding_ket1['kpmr_kredit'], $pembanding_ket1['tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
$pdf->Row(array($inheren1['hasil_peringkat'], $kpmr1['hasil_peringkat'], $ket1['peringkat_tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_inheren1['hasil_peringkat'], $pembanding_kpmr1['hasil_peringkat'], $pembanding_ket1['peringkat_tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket1['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket1['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket1['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa


















//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO OPERASIONAL)');
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Skala Usaha dan Struktur Organisasi',  $pil_op1['hasil_pil1_par1'],  $ket_pil_op1['ket_in_op_pil1_1']));


$pdf->Row(array('2','Jaringan Kantor, rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['hasil_pil1_par2'],  $ket_pil_op1['ket_in_op_pil1_2'].$ket_pil_op1['ket_in_op_pil1_2a'].$ket_pil_op1['ket_in_op_pil1_2b']));

$pdf->Row2(array('','Jaringan Kantor, rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['pilar1_2'], '
  '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rentang Kendali dan Lokasi Kantor Cabang',  $pil_op1['pilar1_2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jangkauan dan Ruang Kendali Kantor',  $pil_op1['pilar1_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Keberagaman Produk dan atau Jasa',  $pil_op1['hasil_pil1_par3'],  $ket_pil_op1['ket_in_op_pil1_3'].$ket_pil_op1['ket_in_op_pil1_3a'].$ket_pil_op1['ket_in_op_pil1_3b'].$ket_pil_op1['ket_in_op_pil1_3c']));
$pdf->Row2(array('','Keberagaman Produk dan atau Jasa',  $pil_op1['pilar1_3'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keberagaman Produk',  $pil_op1['pilar1_3a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kompleksitas Produk',  $pil_op1['pilar1_3b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Volume Transaksi',  $pil_op1['pilar1_3c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Tindakan Korporasi',  $pil_op1['hasil_pil1_par4'],  $ket_pil_op1['ket_in_op_pil1_4'].$ket_pil_op1['ket_in_op_pil1_4a']));
$pdf->Row2(array('','Tindakan Korporasi',  $pil_op1['pilar1_4'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Corporate Plan',  $pil_op1['pilar1_4a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan',$hasil2['pil1_tingkat_risiko'],  $ket_inhern_operasional['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Sumber Daya Manusia'));

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Keseimbangan beban kerja',  $pil_op2['pilar2_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perbandingan NOA Kredit Terhadap Jumlah SDM di Bidang Kredit',  $pil_op2['pilar2_1g'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Beban Kerja Pegawai',  $pil_op2['pilar2_1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengukuran Kinerja Pegawai',  $pil_op2['pilar2_1i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Mengembangkan Budaya Organisasi yang sadar risiko dan mengelola risiko',  $pil_op2['pilar2_1j'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rotasi Pegawai',  $pil_op2['pilar2_1k'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rotasi Pejabat Eksekutif',  $pil_op2['pilar2_1l'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kualitas Pelatihan Pegawai',  $pil_op2['pilar2_1m'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Kualitas Pendidikan dan Pelatihan',  $pil_op2['pilar2_1n'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Permasalahan Operasional Karena Faktor Manusia (Human Error)',  $pil_op2['hasil_pil2_par2'],  $ket_pil_op2['ket_in_op_pil2_2']));





$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Sumber Daya Manusia',$hasil2['pil2_tingkat_risiko'],  $ket_inhern_operasional['ket_pil2']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Penyelenggaraan Teknologi Informasi (TI)'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Penyelenggaraan Teknologi Informasi (TI)',  $pil_op3['hasil_pil3_par1'],  $ket_pil_op3['ket_in_op_pil3_1'].$ket_pil_op3['ket_in_op_pil3_1a'].$ket_pil_op3['ket_in_op_pil3_1b'].$ket_pil_op3['ket_in_op_pil3_1c'].$ket_pil_op3['ket_in_op_pil3_1d'].$ket_pil_op3['ket_in_op_pil3_1e'].$ket_pil_op3['ket_in_op_pil3_1f'].$ket_pil_op3['ket_in_op_pil3_1g'].$ket_pil_op3['ket_in_op_pil3_1h']));
$pdf->Row(array('','','' ,$ket_pil_op3['ket_in_op_pil3_1i'].$ket_pil_op3['ket_in_op_pil3_1j'].$ket_pil_op3['ket_in_op_pil3_1k'].$ket_pil_op3['ket_in_op_pil3_1l'].$ket_pil_op3['ket_in_op_pil3_1m'].$ket_pil_op3['ket_in_op_pil3_1n'].$ket_pil_op3['ket_in_op_pil3_1o'].$ket_pil_op3['ket_in_op_pil3_1p']));
$pdf->Row2(array('','Penyelenggaraan Teknologi Informasi (TI)',  $pil_op3['pilar3_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Perubahan Proses Pelaksanaan Tugas Dari Konvensional Ke Sistem Digital',  $pil_op3['pilar3_1a'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keamanan Informasi Dan Database TI',  $pil_op3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kualifikasi Dan Rekam Jejak Penyedia Jasa Teknologi Informasi',  $pil_op3['pilar3_1c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Sumber Daya Manusia Bidang IT',  $pil_op3['pilar3_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemahaman Dan Penguasaan Pegawai Terhadap CBS Yang Digunakan',  $pil_op3['pilar3_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketersediaan Cbs Ketika Kondisi Darurat (Rencana Pemulihan Bencana)',  $pil_op3['pilar3_1f'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengembangan Teknologi Informasi',  $pil_op3['pilar3_1g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kualitas Pelayanan Jaringan Komunikasi TI',  $pil_op3['pilar3_1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pelaksanaan Audit Atas TI',  $pil_op3['pilar3_1i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketersediaan Fasilitas dan Teknologi Penunjang Layanan (Qris, EDC, Virtual Account, Mobil Kas Keliling, Mobile Banking, Laku Pandai)',  $pil_op3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kualitas Keamanan Data Nasabah',  $pil_op3['pilar3_1k'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kualitas Keamanan Database System (User Access, Data Encripty, Password, Antivirus, Firewall)',  $pil_op3['pilar3_1l'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kelengkapan Modul Aplikasi IntiPerbankan (CBS) dalam Menunjang Kegiatan Operasional (Modul Data Nasabah, Kredit, Tabungan, Deposito, Agunan, Akuntansi, Pelaporan, Antar Bank, Inventaris/Aset Tetap)',  $pil_op3['pilar3_1m'],  '

 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Gangguan Core Banking',  $pil_op3['pilar3_1n'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengembangan Teknologi InformasiTerhadap Core Banking System',  $pil_op3['pilar3_1o'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketersediaan Sistem Informasi Manajemen',  $pil_op3['pilar3_1p'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);





$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Penyelenggaraan Teknologi Informasi (TI)',$hasil2['pil3_tingkat_risiko'],  $ket_inhern_operasional['ket_pil3']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : Penyimpangan (Fraud)'));

$pdf->SetFont('Arial', '', 7);
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Penyimpangan (Fraud)',$hasil2['pil4_tingkat_risiko'],  $ket_inhern_operasional['ket_pil4']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 5 : Faktor Eksternal'));

$pdf->SetFont('Arial', '', 7);
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 5 -Faktor Eksternal',$hasil2['pil5_tingkat_risiko'],  $ket_inhern_operasional['ket_pil5']));




$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $pil_op6['hasil_pil6_par1'], $ket_pil_op6['ket_in_op_pil6_1a'].$ket_pil_op6['ket_in_op_pil6_1b'].$ket_pil_op6['ket_in_op_pil6_1c'].$ket_pil_op6['ket_in_op_pil6_1d'].$ket_pil_op6['ket_in_op_pil6_1e'].$ket_pil_op6['ket_in_op_pil6_1f']));
$pdf->Row2(array('','Kesehatan Pegawai',  $pil_op6['pilar6_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Keselamatan Kerja',  $pil_op6['pilar6_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pengaduan Nasabah',  $pil_op6['pilar6_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kelengkapan Ketentuan dan Pedoman Operasional',  $pil_op6['pilar6_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengawasan Internal',  $pil_op6['pilar6_1e'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kejadian Luar Biasa yang Berpengaruh Terhadap Kegiatan Layanan',  $pil_op6['pilar6_1f'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Kompleksitas Bisnis dan Kelembagaan',$hasil2['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Sumber Daya Manusia',$hasil2['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Penyelenggaraan Teknologi Informasi (TI)',$hasil2['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Penyimpangan (Fraud)',$hasil2['pil4_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 5 -  Faktor Eksternal',$hasil2['pil5_tingkat_risiko']));
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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_operasional['ket_inheren']));








$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR OPERASIONAL');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko operasional yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_operasional1['pil1_total1'],  $ru_op1['respon_pil1_1a'].$ru_op1['respon_pil1_1b'].$ru_op1['respon_pil1_1c'].$ru_op1['respon_pil1_1d'].$ru_op1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko operasional yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP operasional, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_operasional1['pilar1_1a'], '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko operasional yang disetujui Dewan Komisaris telah dilakukan (Ketentuan operasional yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_operasional1['pilar1_1b'],  '




 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko operasional dalam menjalankan tugas dan fungsinya',  $kpmr_operasional1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko operasional sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_operasional1['pilar1_1d'],  '

 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_operasional1['pilar1_1e'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko operasional secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_operasional1['pil1_total2'],  $ru_op1['respon_pil1_2a'].$ru_op1['respon_pil1_2b'].$ru_op1['respon_pil1_2c'].$ru_op1['respon_pil1_2d'].$ru_op1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko operasional secara tertulis dan dalam foru rapat (terdapat notulen)',  $kpmr_operasional1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko operasional kepada Direksi secara tertulis dan forum rapat',  $kpmr_operasional1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko operasional',  $kpmr_operasional1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko operasional',  $kpmr_operasional1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_operasional1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko operasional, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_operasional1['pil1_total3'],  $ru_op1['respon_pil1_3a'].$ru_op1['respon_pil1_3b'].$ru_op1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko operasional (Pelatihan tentang manajemen risiko operasional yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko operasional)',  $kpmr_operasional1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko operasional yang disetujui Direksi apa saja yang telah ditetapkan (SK Direksi, SOP operasional, SE Direksi)',  $kpmr_operasional1['pilar1_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko operasional yang disetujui Direksi dilakukan (Ketentuan operasional yang diterbitkan selama periode penilaian)',  $kpmr_operasional1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko operasional, dan melakukan komunikasi kebijakan Manajemen Risiko operasional terhadap seluruh jenjang organisasi BPR?',  $kpmr_operasional1['pil1_total4'],  $ru_op1['respon_pil1_4a'].$ru_op1['respon_pil1_4b'].$ru_op1['respon_pil1_4c'].$ru_op1['respon_pil1_4d'].$ru_op1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko operasional',  $kpmr_operasional1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluruh unit kerja',  $kpmr_operasional1['pilar1_4b'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko operasional kepada seluruh unit kerja',  $kpmr_operasional1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_operasional1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_operasional1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi operasional dan fungsi Manajemen Risiko operasional?',  $kpmr_operasional1['pil1_total5'],  $ru_op1['respon_pil1_5a'].$ru_op1['respon_pil1_5b'].$ru_op1['respon_pil1_5c'].$ru_op1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja operasional dan melaksanakan tugasnya secara independen',  $kpmr_operasional1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja operasional telah didukung dengan kompetensi yang baik',  $kpmr_operasional1['pilar1_5b'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko operasional telah didukung dengan kompetensi yang baik',  $kpmr_operasional1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses operasional dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_operasional1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko operasional?',  $kpmr_operasional1['pil1_total6'],  $ru_op1['respon_pil1_6a'].$ru_op1['respon_pil1_6b'].$ru_op1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko operasional, tidak terdapat perangkapan jabatan, independen',  $kpmr_operasional1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_operasional1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang operasional',  $kpmr_operasional1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr2['pil1_tingkat_risiko'],  $ket_kpmr_operasional['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko operasional yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_operasional2['pil2_total1'],  $ru_op2['respon_pil2_1a'].$ru_op2['respon_pil2_1b'].$ru_op2['respon_pil2_1c'].$ru_op2['respon_pil2_1d'].$ru_op2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko operasional',  $kpmr_operasional2['pilar2_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko operasional',  $kpmr_operasional2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko operasional dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_operasional2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko operasional memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko operasional, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_operasional2['pilar2_1d'],  '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_operasional2['pilar2_1e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR: Memiliki prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional yang ditetapkan oleh Direksi Melaksanakan prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional secara konsisten untuk seluruh aktivitas; dan Melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko operasional dan penetapan limit Risiko operasional secara berkala?',  $kpmr_operasional2['pil2_total2'],  $ru_op2['respon_pil2_2a'].$ru_op2['respon_pil2_2b'].$ru_op2['respon_pil2_2c'].$ru_op2['respon_pil2_2d'].$ru_op2['respon_pil2_2e'].$ru_op2['respon_pil2_2f'].$ru_op2['respon_pil2_2g'].$ru_op2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko operasional yang ditetapkan dalam SK Direksi',  $kpmr_operasional2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko operasional',  $kpmr_operasional2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_operasional2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko operasional',  $kpmr_operasional2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_operasional2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi operasional',  $kpmr_operasional2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_operasional2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_operasional2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko operasional sesuai dengan ketentuan?',  $kpmr_operasional2['pil2_total3'],  $ru_op2['respon_pil2_3a'].$ru_op2['respon_pil2_3b'].$ru_op2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_operasional2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_operasional2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_operasional2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr2['pil2_tingkat_risiko'],  $ket_kpmr_operasional['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko operasional yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko operasional?',  $kpmr_operasional3['pil3_total1'],  $ru_op3['respon_pil3_1a'].$ru_op3['respon_pil3_1b'].$ru_op3['respon_pil3_1c'].$ru_op3['respon_pil3_1d'].$ru_op3['respon_pil3_1e'].$ru_op3['respon_pil3_1f'].$ru_op3['respon_pil3_1g'].$ru_op3['respon_pil3_1h'].$ru_op3['respon_pil3_1i'].$ru_op3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas operasional seluruh SDM telah berpedoman pada penerapan manajemen risiko operasional',  $kpmr_operasional3['pilar3_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas operasional',  $kpmr_operasional3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses operasional dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_operasional3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang operasional dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_operasional3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko operasional telah didukung dengan data operasional yang akurat dan informatif',  $kpmr_operasional3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko operasional telah melakukan analisa karakteristik risiko operasional yang melekat pada produk dan layanan',  $kpmr_operasional3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko operasional telah dilakukan evaluasi',  $kpmr_operasional3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko operasional telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_operasional3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko operasional telah dilakukan evaluasi terhadap eksposur risiko operasional',  $kpmr_operasional3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko operasional apakah juga dilakukan penyesuaian pelaporan',  $kpmr_operasional3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko operasional serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_operasional3['pil3_total2'],  $ru_op3['respon_pil3_2a'].$ru_op3['respon_pil3_2b'].$ru_op3['respon_pil3_2c'].$ru_op3['respon_pil3_2d'].$ru_op3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_operasional3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko operasional dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_operasional3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko operasional yang lengkap dan cepat',  $kpmr_operasional3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan kepatuhan terhadap kebijakan manajemen risiko operasional (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_operasional3['pilar3_2d'],  '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_operasional3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penyelenggaraan TI ?',  $kpmr_operasional3['pil3_total3'],  $ru_op3['respon_pil3_3a'].$ru_op3['respon_pil3_3b'].$ru_op3['respon_pil3_3c']));


$pdf->Row2(array('','Apakah Kebijakan TI telah disusun dan disetujui oleh Direksi',  $kpmr_operasional3['pilar3_3a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Kebijakan TI dilakukan review secara berkala',  $kpmr_operasional3['pilar3_3b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Kebijakan TI dipahami oleh seluruh pegawai dan dijalankan sesuai ketentuan',  $kpmr_operasional3['pilar3_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah BPR telah melakukan langkah mitigasi Risiko terkait kejadian eksternal ?',  $kpmr_operasional3['pil3_total4'],  $ru_op3['respon_pil3_4a'].$ru_op3['respon_pil3_4b'].$ru_op3['respon_pil3_4c']));


$pdf->Row2(array('','Apakah telah memiliki pedoman pengendalian dan mitigasi risiko operasional penyelenggaraan TI akibat faktor eksternal',  $kpmr_operasional3['pilar3_4a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan pedoman pengendalian risiko operasional akibat faktor eksternal telah disosialisasikan ke seluruh pegawai',  $kpmr_operasional3['pilar3_4b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan pedoman tersebut telah dilakukan uji coba penerapnnya dan dilakukan evaluasi secara berkala',  $kpmr_operasional3['pilar3_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr2['pil3_tingkat_risiko'],  $ket_kpmr_operasional['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PE Audit Internal telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko operasional, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_operasional4['pil4_total1'],  $ru_op4['respon_pil4_1a'].$ru_op4['respon_pil4_1b'].$ru_op4['respon_pil4_1c'].$ru_op4['respon_pil4_1d'].$ru_op4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko operasional di berapa cabang atau unit kerja di bidang manajemen risiko operasional',  $kpmr_operasional4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko operasional telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_operasional4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko operasional telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko operasional',  $kpmr_operasional4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko operasional',  $kpmr_operasional4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko operasional',  $kpmr_operasional4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko operasional telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_operasional4['pil4_total2'],  $ru_op4['respon_pil4_2a'].$ru_op4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional peroperasionalan',  $kpmr_operasional4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja operasional telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_operasional4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr2['pil4_tingkat_risiko'],  $ket_kpmr_operasional['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR OPERASIONAL', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr2['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr2['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr2['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr2['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr2['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr2['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR OPERASIONAL', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_operasional['ket_kpmr']));




//Membuat Koneksi ke database akademik






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

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket2['inheren_operasional'], $ket2['kpmr_operasional'], $ket2['tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_ket2['inheren_operasional'], $pembanding_ket2['kpmr_operasional'], $pembanding_ket2['tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
$pdf->Row(array($inheren2['hasil_peringkat'], $kpmr2['hasil_peringkat'], $ket2['peringkat_tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_inheren2['hasil_peringkat'], $pembanding_kpmr2['hasil_peringkat'], $pembanding_ket2['peringkat_tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket2['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket2['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket2['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa












//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO KEPATUHAN)');
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Jenis dan Signifikasi Pelanggaran',  $pil_kep1['hasil_pil1_par1'],  $ket_pil_kep1['ket_in_kep_pil1_1'].$ket_pil_kep1['ket_in_kep_pil1_1a'].$ket_pil_kep1['ket_in_kep_pil1_1b'].$ket_pil_kep1['ket_in_kep_pil1_1c'].$ket_pil_kep1['ket_in_kep_pil1_1d'].$ket_pil_kep1['ket_in_kep_pil1_1e'].$ket_pil_kep1['ket_in_kep_pil1_1f'].$ket_pil_kep1['ket_in_kep_pil1_1g']));
$pdf->Row2(array('','Jenis dan Signifikasi Pelanggaran',  $pil_kep1['pilar1_1'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Pelanggaran',  $pil_kep1['pilar1_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pengkinian Ketentuan Internal Terhadap Peraturan Perundang-undangan yang Berlaku',  $pil_kep1['pilar1_1b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemisahan Fungsi Kepatuhan dan Fungsi Bisnis',  $pil_kep1['pilar1_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Monitoring Ketentuan Baru Dari Regulator',  $pil_kep1['pilar1_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pelanggaran Kewajiban Penyampaian Laporan Kepada OJK/Regulator Lain',  $pil_kep1['pilar1_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Frekuensi Pelanggaran Ketentuan Internal dan Prosedur',  $pil_kep1['pilar1_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Sebaran Jenis Pelanggaran Ketentuan Internal dan Prosedur',  $pil_kep1['pilar1_1g'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->Row(array('2','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['hasil_pil1_par2'],  $ket_pil_kep1['ket_in_kep_pil1_2'].$ket_pil_kep1['ket_in_kep_pil1_2a'].$ket_pil_kep1['ket_in_kep_pil1_2b'].$ket_pil_kep1['ket_in_kep_pil1_2c'].$ket_pil_kep1['ket_in_kep_pil1_2d'].$ket_pil_kep1['ket_in_kep_pil1_2e'].$ket_pil_kep1['ket_in_kep_pil1_2f'].$ket_pil_kep1['ket_in_kep_pil1_2g'].$ket_pil_kep1['ket_in_kep_pil1_2h']));

$pdf->Row2(array('','Signifikasi Tindak Lanjut Atas Temuan Pelanggaran',  $pil_kep1['pilar1_2'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Pegawai yang Menangani Fungsi Kepatuhan',  $pil_kep1['pilar1_2a'],  


 
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
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
$pdf->Row2(array('','Pemberian Sanksi Terhadap Pelaku Pelanggaran Kepatuhan (Kategori pelanggaran kepatuhan adalah berdasarkan temuan pada saat audit (internal maupun eksternal) maupun temuan oleh Unit kerja yang ada di BKK)',  $pil_kep1['pilar1_2h'],  '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Pelanggaran Terhadap Ketentuan Peraturan Perundang-Undangan dan Ketentuan Lain',$hasil3['pil1_tingkat_risiko'],  $ket_inhern_kepatuhan['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Faktor Kelemahan Aspek Hukum'));

$pdf->SetFont('Arial', '', 7);
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



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Faktor Kelemahan Aspek Hukum',$hasil3['pil2_tingkat_risiko'],  $ket_inhern_kepatuhan['ket_pil2']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_kep3['hasil_pil3_par1'], $ket_pil_kep3['ket_in_kep_pil3_1a'].$ket_pil_kep3['ket_in_kep_pil3_1b'].$ket_pil_kep3['ket_in_kep_pil3_1c'].$ket_pil_kep3['ket_in_kep_pil3_1d'].$ket_pil_kep3['ket_in_kep_pil3_1e'].$ket_pil_kep3['ket_in_kep_pil3_1f'].$ket_pil_kep3['ket_in_kep_pil3_1g']));
$pdf->Row2(array('','Pengukuran Index Kepatuhan',  $pil_kep3['pilar3_1a'],  
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Komitmen Capaian Target RBB',  $pil_kep3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Teladan Pucuk Pimpinan',  $pil_kep3['pilar3_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Perangkat Lunak Yang Berupa Ketentuan Internal Meliputi Job Desk, SOP, Pedoman Perkreditan dan Ketentuan Lainnya',  $pil_kep3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Assesment Terhadap Pemahaman dan Implementasi Job Desk dan Tugas Tanggung jawab',  $pil_kep3['pilar3_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Sosialisasi dan Pendampingan Kepada Pegawai dan Unit Kerja Digunakan',  $pil_kep3['pilar3_1f'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Ketentuan dan Peraturan Internal Sesuai Ketentuan Regulator dan Bisnis Bank',  $pil_kep3['pilar3_1g'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);




$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_kepatuhan['ket_inheren']));








$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko kepatuhan yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_kepatuhan1['pil1_total1'],  $ru_kep1['respon_pil1_1a'].$ru_kep1['respon_pil1_1b'].$ru_kep1['respon_pil1_1c'].$ru_kep1['respon_pil1_1d'].$ru_kep1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP kepatuhan, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_kepatuhan1['pilar1_1a'], '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Dewan Komisaris telah dilakukan (Ketentuan kepatuhan yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_kepatuhan1['pilar1_1b'],  '
 
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kepatuhan dalam menjalankan tugas dan fungsinya',  $kpmr_kepatuhan1['pilar1_1c'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko kepatuhan sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_kepatuhan1['pilar1_1d'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_kepatuhan1['pilar1_1e'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko kepatuhan secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_kepatuhan1['pil1_total2'],  $ru_kep1['respon_pil1_2a'].$ru_kep1['respon_pil1_2b'].$ru_kep1['respon_pil1_2c'].$ru_kep1['respon_pil1_2d'].$ru_kep1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko kepatuhan secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_kepatuhan1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko kepatuhan kepada Direksi secara tertulis dan forum rapat',  $kpmr_kepatuhan1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_kepatuhan1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko kepatuhan, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_kepatuhan1['pil1_total3'],  $ru_kep1['respon_pil1_3a'].$ru_kep1['respon_pil1_3b'].$ru_kep1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko kepatuhan (Pelatihan tentang manajemen risiko kepatuhan yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko kepatuhan)',  $kpmr_kepatuhan1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Direksi apa saja yang telah ditetapkan (SK Direksi, SOP kepatuhan, SE Direksi)',  $kpmr_kepatuhan1['pilar1_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko kepatuhan yang disetujui Direksi dilakukan (Ketentuan kepatuhan yang diterbitkan selama periode penilaian)',  $kpmr_kepatuhan1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko kepatuhan, dan melakukan komunikasi kebijakan Manajemen Risiko kepatuhan terhadap seluru_keph jenjang organisasi BPR?',  $kpmr_kepatuhan1['pil1_total4'],  $ru_kep1['respon_pil1_4a'].$ru_kep1['respon_pil1_4b'].$ru_kep1['respon_pil1_4c'].$ru_kep1['respon_pil1_4d'].$ru_kep1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko kepatuhan',  $kpmr_kepatuhan1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_keph unit kerja',  $kpmr_kepatuhan1['pilar1_4b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko kepatuhan kepada seluru_keph unit kerja',  $kpmr_kepatuhan1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_kepatuhan1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_kepatuhan1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi kepatuhan dan fungsi Manajemen Risiko kepatuhan?',  $kpmr_kepatuhan1['pil1_total5'],  $ru_kep1['respon_pil1_5a'].$ru_kep1['respon_pil1_5b'].$ru_kep1['respon_pil1_5c'].$ru_kep1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja kepatuhan dan melaksanakan tugasnya secara independen',  $kpmr_kepatuhan1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja kepatuhan telah didukung dengan kompetensi yang baik',  $kpmr_kepatuhan1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko kepatuhan telah didukung dengan kompetensi yang baik',  $kpmr_kepatuhan1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses kepatuhan dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_kepatuhan1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko kepatuhan?',  $kpmr_kepatuhan1['pil1_total6'],  $ru_kep1['respon_pil1_6a'].$ru_kep1['respon_pil1_6b'].$ru_kep1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko kepatuhan, tidak terdapat perangkapan jabatan, independen',  $kpmr_kepatuhan1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_kepatuhan1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang kepatuhan',  $kpmr_kepatuhan1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('7','Apakah Direksi telah menyusun kebijakan internal yang mendukung terselenggaranya fungsi kepatuhan, memberikan perhatian terhadap ketentuan peraturan perundang- undangan, serta terdapat kebijakan reward and punishment bagi internal BPR?',  $kpmr_kepatuhan1['pil1_total7'],  $ru_kep1['respon_pil1_7a'].$ru_kep1['respon_pil1_7b'].$ru_kep1['respon_pil1_7c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko kepatuhan, tidak terdapat perangkapan jabatan, independen',  $kpmr_kepatuhan1['pilar1_7a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_kepatuhan1['pilar1_7b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang kepatuhan',  $kpmr_kepatuhan1['pilar1_7c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr3['pil1_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko kepatuhan yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_kepatuhan2['pil2_total1'],  $ru_kep2['respon_pil2_1a'].$ru_kep2['respon_pil2_1b'].$ru_kep2['respon_pil2_1c'].$ru_kep2['respon_pil2_1d'].$ru_kep2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko kepatuhan dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_kepatuhan2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko kepatuhan memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko kepatuhan, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_kepatuhan2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_kepatuhan2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko kepatuhan dan penetapan limit Risiko kepatuhan secara berkala?"',  $kpmr_kepatuhan2['pil2_total2'],  $ru_kep2['respon_pil2_2a'].$ru_kep2['respon_pil2_2b'].$ru_kep2['respon_pil2_2c'].$ru_kep2['respon_pil2_2d'].$ru_kep2['respon_pil2_2e'].$ru_kep2['respon_pil2_2f'].$ru_kep2['respon_pil2_2g'].$ru_kep2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko kepatuhan yang ditetapkan dalam SK Direksi',  $kpmr_kepatuhan2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_kepatuhan2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko kepatuhan',  $kpmr_kepatuhan2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_kepatuhan2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi kepatuhan',  $kpmr_kepatuhan2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_kepatuhan2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_kepatuhan2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko kepatuhan sesuai dengan ketentuan?',  $kpmr_kepatuhan2['pil2_total3'],  $ru_kep2['respon_pil2_3a'].$ru_kep2['respon_pil2_3b'].$ru_kep2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_kepatuhan2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_kepatuhan2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_kepatuhan2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr3['pil2_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko kepatuhan yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko kepatuhan?',  $kpmr_kepatuhan3['pil3_total1'],  $ru_kep3['respon_pil3_1a'].$ru_kep3['respon_pil3_1b'].$ru_kep3['respon_pil3_1c'].$ru_kep3['respon_pil3_1d'].$ru_kep3['respon_pil3_1e'].$ru_kep3['respon_pil3_1f'].$ru_kep3['respon_pil3_1g'].$ru_kep3['respon_pil3_1h'].$ru_kep3['respon_pil3_1i'].$ru_kep3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas kepatuhan seluruh SDM telah berpedoman pada penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan3['pilar3_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas kepatuhan',  $kpmr_kepatuhan3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses kepatuhan dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_kepatuhan3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang kepatuhan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_kepatuhan3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko kepatuhan telah didukung dengan data kepatuhan yang akurat dan informatif',  $kpmr_kepatuhan3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko kepatuhan telah melakukan analisa karakteristik risiko kepatuhan yang melekat pada produk dan layanan',  $kpmr_kepatuhan3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko kepatuhan telah dilakukan evaluasi',  $kpmr_kepatuhan3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko kepatuhan telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_kepatuhan3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko kepatuhan telah dilakukan evaluasi terhadap eksposur risiko kepatuhan',  $kpmr_kepatuhan3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko kepatuhan apakah juga dilakukan penyesuaian pelaporan',  $kpmr_kepatuhan3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko kepatuhan serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_kepatuhan3['pil3_total2'],  $ru_kep3['respon_pil3_2a'].$ru_kep3['respon_pil3_2b'].$ru_kep3['respon_pil3_2c'].$ru_kep3['respon_pil3_2d'].$ru_kep3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_kepatuhan3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko kepatuhan dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_kepatuhan3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko kepatuhan yang lengkap dan cepat',  $kpmr_kepatuhan3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan kepatuhan terhadap kebijakan manajemen risiko kepatuhan (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_kepatuhan3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_kepatuhan3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr3['pil3_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko kepatuhan, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_kepatuhan4['pil4_total1'],  $ru_kep4['respon_pil4_1a'].$ru_kep4['respon_pil4_1b'].$ru_kep4['respon_pil4_1c'].$ru_kep4['respon_pil4_1d'].$ru_kep4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko kepatuhan di berapa cabang atau unit kerja di bidang manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko kepatuhan telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_kepatuhan4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko kepatuhan telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk kepatuhan kebijakan manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko kepatuhan',  $kpmr_kepatuhan4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko kepatuhan telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_kepatuhan4['pil4_total2'],  $ru_kep4['respon_pil4_2a'].$ru_kep4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perkepatuhanan',  $kpmr_kepatuhan4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja kepatuhan telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_kepatuhan4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr3['pil4_tingkat_risiko'],  $ket_kpmr_kepatuhan['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR KEPATUHAN', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr3['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr3['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr3['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr3['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr3['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr3['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR KEPATUHAN', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_kepatuhan['ket_kpmr']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'PROFIL NILAI KEPATUHAN');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();






$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 0);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 0);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket3['inheren_kepatuhan'], $ket3['kpmr_kepatuhan'], $ket3['tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_ket3['kpmr_kepatuhan'], $pembanding_ket3['tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
$pdf->Row(array($inheren3['hasil_peringkat'], $kpmr3['hasil_peringkat'], $ket3['peringkat_tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_inheren3['hasil_peringkat'], $pembanding_kpmr3['hasil_peringkat'], $pembanding_ket3['peringkat_tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket3['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket3['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket3['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa









$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO LIKUIDITAS)');
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

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Modal Disetor / Total DPK',  $pil_lik1['hasil_pil1_par2h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pinjaman / Total DPK',  $pil_lik1['hasil_pil1_par2i'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

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
$pdf->Row2(array('','Deposito Inti (100 Deposan) / Total DPK',  $pil_lik1['hasil_pil1_par5d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Komposisi dan Konsentrasi Aset dan Kewajiban',$hasil4['pil1_tingkat_risiko'],  $ket_inhern_likuiditas['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Penilaian kebutuhan pendanaan BPR pada situasi normal maupun krisis, dan kemampuan BPR untuk memenuhi kebutuhan pendanaan	',  $pil_lik2['hasil_pil2_par1'],  $ket_inhern_likuiditas['ket_pil2_1']));
$pdf->Row2(array('','Sumber Pendanaan Untuk Memenuhi Kebutuhan',  $pil_lik2['hasil_pil2_par1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Terhadap Produk Kredit dan Simpanan',  $pil_lik2['hasil_pil2_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Sumber Pendanaan Non Inti',  $pil_lik2['hasil_pil2_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Penilaian terhadap seberapa luas atau seberapa besar BPR memiliki komitmen pendanaan yang dapat digunakan jika dibutuhkan',  $pil_lik2['hasil_pil2_par2'],  $ket_inhern_likuiditas['ket_pil2_2']));



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kerentanan Pada Kebutuhan Pendanaan Serta Akses Pada Sumber Pendanaan',$hasil4['pil2_tingkat_risiko'],  $ket_inhern_likuiditas['ket_pil2']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Faktor Lainnya',  $pil_lik3['hasil_pil3_par1'],  $ket_inhern_likuiditas['ket_pil3_1']));
$pdf->Row2(array('','Penyusunan Profil Maturitas',  $pil_lik3['hasil_pil3_par1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penyusunan Proyeksi Arus Kas',  $pil_lik3['hasil_pil3_par1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penyusunan Stress Testing Kemampuan Likuiditas',  $pil_lik3['hasil_pil3_par1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Risk Events yang Mempengaruhi Kemampuan Likuiditas yang Bersumber dari Eksternal',  $pil_lik3['hasil_pil3_par1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi dan Evaluasi terhadap Jenis Risiko lain yang meningkatkan risiko likuiditas',  $pil_lik3['hasil_pil3_par1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Monitoring Tingkat Suku Bunga Pasar',  $pil_lik3['hasil_pil3_par1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);




$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_likuiditas['ket_inheren']));





$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR LIKUIDITAS');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko likuiditas yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_likuiditas1['pil1_total1'],  $ru_lik1['respon_pil1_1a'].$ru_lik1['respon_pil1_1b'].$ru_lik1['respon_pil1_1c'].$ru_lik1['respon_pil1_1d'].$ru_lik1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko likuiditas yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP likuiditas, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_likuiditas1['pilar1_1a'], '
 

 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko likuiditas yang disetujui Dewan Komisaris telah dilakukan (Ketentuan likuiditas yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_likuiditas1['pilar1_1b'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko likuiditas dalam menjalankan tugas dan fungsinya',  $kpmr_likuiditas1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko likuiditas sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_likuiditas1['pilar1_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_likuiditas1['pilar1_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko likuiditas secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_likuiditas1['pil1_total2'],  $ru_lik1['respon_pil1_2a'].$ru_lik1['respon_pil1_2b'].$ru_lik1['respon_pil1_2c'].$ru_lik1['respon_pil1_2d'].$ru_lik1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko likuiditas secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_likuiditas1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko likuiditas kepada Direksi secara tertulis dan forum rapat',  $kpmr_likuiditas1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko likuiditas',  $kpmr_likuiditas1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko likuiditas',  $kpmr_likuiditas1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_likuiditas1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko likuiditas, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_likuiditas1['pil1_total3'],  $ru_lik1['respon_pil1_3a'].$ru_lik1['respon_pil1_3b'].$ru_lik1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko likuiditas (Pelatihan tentang manajemen risiko likuiditas yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko likuiditas)',  $kpmr_likuiditas1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko likuiditas yang disetujui Direksi apa saja yang telah ditetapkan (SK Direksi, SOP likuiditas, SE Direksi)',  $kpmr_likuiditas1['pilar1_3b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko likuiditas yang disetujui Direksi dilakukan (Ketentuan likuiditas yang diterbitkan selama periode penilaian)',  $kpmr_likuiditas1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko likuiditas, dan melakukan komunikasi kebijakan Manajemen Risiko likuiditas terhadap seluru_likh jenjang organisasi BPR?',  $kpmr_likuiditas1['pil1_total4'],  $ru_lik1['respon_pil1_4a'].$ru_lik1['respon_pil1_4b'].$ru_lik1['respon_pil1_4c'].$ru_lik1['respon_pil1_4d'].$ru_lik1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko likuiditas',  $kpmr_likuiditas1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_likh unit kerja',  $kpmr_likuiditas1['pilar1_4b'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko likuiditas kepada seluru_likh unit kerja',  $kpmr_likuiditas1['pilar1_4c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_likuiditas1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_likuiditas1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi likuiditas dan fungsi Manajemen Risiko likuiditas?',  $kpmr_likuiditas1['pil1_total5'],  $ru_lik1['respon_pil1_5a'].$ru_lik1['respon_pil1_5b'].$ru_lik1['respon_pil1_5c'].$ru_lik1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perlikuiditas dan melaksanakan tugasnya secara independen',  $kpmr_likuiditas1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja likuiditas telah didukung dengan kompetensi yang baik',  $kpmr_likuiditas1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko likuiditas telah didukung dengan kompetensi yang baik',  $kpmr_likuiditas1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses likuiditas dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_likuiditas1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko likuiditas?',  $kpmr_likuiditas1['pil1_total6'],  $ru_lik1['respon_pil1_6a'].$ru_lik1['respon_pil1_6b'].$ru_lik1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko likuiditas, tidak terdapat perangkapan jabatan, independen',  $kpmr_likuiditas1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_likuiditas1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang likuiditas',  $kpmr_likuiditas1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr4['pil1_tingkat_risiko'],  $ket_kpmr_likuiditas['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko likuiditas yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_likuiditas2['pil2_total1'],  $ru_lik2['respon_pil2_1a'].$ru_lik2['respon_pil2_1b'].$ru_lik2['respon_pil2_1c'].$ru_lik2['respon_pil2_1d'].$ru_lik2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko likuiditas',  $kpmr_likuiditas2['pilar2_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko likuiditas',  $kpmr_likuiditas2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko likuiditas dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_likuiditas2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko likuiditas memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko likuiditas, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_likuiditas2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_likuiditas2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko likuiditas dan penetapan limit Risiko likuiditas yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko likuiditas dan penetapan limit Risiko likuiditas secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko likuiditas dan penetapan limit Risiko likuiditas secara berkala?"',  $kpmr_likuiditas2['pil2_total2'],  $ru_lik2['respon_pil2_2a'].$ru_lik2['respon_pil2_2b'].$ru_lik2['respon_pil2_2c'].$ru_lik2['respon_pil2_2d'].$ru_lik2['respon_pil2_2e'].$ru_lik2['respon_pil2_2f'].$ru_lik2['respon_pil2_2g'].$ru_lik2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko likuiditas yang ditetapkan dalam SK Direksi',  $kpmr_likuiditas2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko likuiditas',  $kpmr_likuiditas2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_likuiditas2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko likuiditas',  $kpmr_likuiditas2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_likuiditas2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi likuiditas',  $kpmr_likuiditas2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_likuiditas2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_likuiditas2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko likuiditas sesuai dengan ketentuan?',  $kpmr_likuiditas2['pil2_total3'],  $ru_lik2['respon_pil2_3a'].$ru_lik2['respon_pil2_3b'].$ru_lik2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_likuiditas2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_likuiditas2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_likuiditas2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr4['pil2_tingkat_risiko'],  $ket_kpmr_likuiditas['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko likuiditas yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko likuiditas?',  $kpmr_likuiditas3['pil3_total1'],  $ru_lik3['respon_pil3_1a'].$ru_lik3['respon_pil3_1b'].$ru_lik3['respon_pil3_1c'].$ru_lik3['respon_pil3_1d'].$ru_lik3['respon_pil3_1e'].$ru_lik3['respon_pil3_1f'].$ru_lik3['respon_pil3_1g'].$ru_lik3['respon_pil3_1h'].$ru_lik3['respon_pil3_1i'].$ru_lik3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas likuiditas seluruh SDM telah berpedoman pada penerapan manajemen risiko likuiditas',  $kpmr_likuiditas3['pilar3_1a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas likuiditas',  $kpmr_likuiditas3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses perlikuiditasan dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_likuiditas3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang perlikuiditasan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_likuiditas3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko likuiditas telah didukung dengan data likuiditas yang akurat dan informatif',  $kpmr_likuiditas3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko likuiditas telah melakukan analisa karakteristik risiko likuiditas yang melekat pada produk dan layanan',  $kpmr_likuiditas3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko likuiditas telah dilakukan evaluasi',  $kpmr_likuiditas3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko likuiditas telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_likuiditas3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko likuiditas telah dilakukan evaluasi terhadap eksposur risiko likuiditas',  $kpmr_likuiditas3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko likuiditas apakah juga dilakukan penyesuaian pelaporan',  $kpmr_likuiditas3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko likuiditas serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_likuiditas3['pil3_total2'],  $ru_lik3['respon_pil3_2a'].$ru_lik3['respon_pil3_2b'].$ru_lik3['respon_pil3_2c'].$ru_lik3['respon_pil3_2d'].$ru_lik3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_likuiditas3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko likuiditas dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_likuiditas3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko likuiditas yang lengkap dan cepat',  $kpmr_likuiditas3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan likuiditas terhadap kebijakan manajemen risiko likuiditas (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_likuiditas3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_likuiditas3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr4['pil3_tingkat_risiko'],  $ket_kpmr_likuiditas['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko likuiditas, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_likuiditas4['pil4_total1'],  $ru_lik4['respon_pil4_1a'].$ru_lik4['respon_pil4_1b'].$ru_lik4['respon_pil4_1c'].$ru_lik4['respon_pil4_1d'].$ru_lik4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko likuiditas di berapa cabang atau unit kerja di bidang manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko likuiditas telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_likuiditas4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko likuiditas telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk likuiditas kebijakan manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko likuiditas',  $kpmr_likuiditas4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko likuiditas telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_likuiditas4['pil4_total2'],  $ru_lik4['respon_pil4_2a'].$ru_lik4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perlikuiditasan',  $kpmr_likuiditas4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja likuiditas telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_likuiditas4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr4['pil4_tingkat_risiko'],  $ket_kpmr_likuiditas['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR LIKUIDITAS', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr4['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr4['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr4['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr4['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr4['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr4['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR LIKUIDITAS', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_likuiditas['ket_kpmr']));




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

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket4['inheren_likuiditas'], $ket4['kpmr_likuiditas'], $ket4['tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_ket4['inheren_likuiditas'], $pembanding_ket4['kpmr_likuiditas'], $pembanding_ket4['tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
$pdf->Row(array($inheren4['hasil_peringkat'], $kpmr4['hasil_peringkat'], $ket4['peringkat_tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_inheren4['hasil_peringkat'], $pembanding_kpmr4['hasil_peringkat'], $pembanding_ket4['peringkat_tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket4['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket4['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket4['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






//Membuat Koneksi ke database akademik
$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO REPUTASI)');
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['hasil_pil1_par1'],  $ket_pil_rep1['ket_in_rep_pil1_1'].$ket_pil_rep1['ket_in_rep_pil1_1a'].$ket_pil_rep1['ket_in_rep_pil1_1b'].$ket_pil_rep1['ket_in_rep_pil1_1c'].$ket_pil_rep1['ket_in_rep_pil1_1d']));
$pdf->Row2(array('','Kredibilitas BPR dan Pihak Yang Berasosiasi Dengan BPR',  $pil_rep1['pilar1_1'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Negatif Terhadap Perusahaan Terkait',  $pil_rep1['pilar1_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kerjasama Dengan Mitra Bisnis',  $pil_rep1['pilar1_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penyediaan Media untuk Menjaring Kejadian Terkait Risiko Reputasi',  $pil_rep1['pilar1_1c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Penunjukan PIC untuk Pemantauan Terhadap Informasi yang Meningkatkan Eksposure Risiko Reputasi',  $pil_rep1['pilar1_1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



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
$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengaruh Reputasi Pihak Yang Berasosiasi Dengan BPR',$hasil5['pil1_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Frekuensi Dan Signifikansi Pengaduan Nasabah'));

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Prosedur Layanan Pengaduan Konsumen Tertulis',  $pil_rep2['pilar2_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Signifikansi Dan Materialitas Pengaduan nasabah',  $pil_rep2['hasil_pil2_par2'],  $ket_pil_rep2['ket_in_rep_pil2_2'].$ket_pil_rep2['ket_in_rep_pil2_2a'].$ket_pil_rep2['ket_in_rep_pil2_2b']));
$pdf->Row2(array('','Signifikansi Dan Materialitas Pengaduan nasabah',  $pil_rep2['pilar2_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jenis Aduan Nasabah',  $pil_rep2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Jumlah Pengaduan Nasabah yang Dapat Diselesaikan',  $pil_rep2['pilar2_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Frekuensi Dan Signifikansi Pengaduan Nasabah',$hasil5['pil2_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Transparansi Informasi Keuangan'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Transparansi Informasi Keuangan',  $pil_rep3['hasil_pil3_par1'],  $ket_pil_rep3['ket_in_rep_pil3_1'].$ket_pil_rep3['ket_in_rep_pil3_1a'].$ket_pil_rep3['ket_in_rep_pil3_1b'].$ket_pil_rep3['ket_in_rep_pil3_1c']));
$pdf->Row2(array('','Transparansi Informasi Keuangan',  $pil_rep3['pilar3_1'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Data Dokumen Dan Informasi Terhadap Laporan Keuangan Dan Non Keuangan',  $pil_rep3['pilar3_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Rekrutmen Pegawai',  $pil_rep3['pilar3_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemutusan Hubungan Kerja',  $pil_rep3['pilar3_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Transparansi Produk Dan Layanan BPR',  $pil_rep3['hasil_pil3_par2'],  $ket_pil_rep3['ket_in_rep_pil3_2'].$ket_pil_rep3['ket_in_rep_pil3_2a'].$ket_pil_rep3['ket_in_rep_pil3_2b']));
$pdf->Row2(array('','Transparansi Produk Dan Layanan BPR',  $pil_rep3['pilar3_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kegiatan Pemasaran',  $pil_rep3['pilar3_2a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Transparansi Fasilitas Produk Dan Layanan',  $pil_rep3['pilar3_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Transparansi Informasi Keuangan',$hasil5['pil3_tingkat_risiko'],  $ket_inhern_reputasi['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_rep4['hasil_pil4_par1'], $ket_pil_rep4['ket_in_rep_pil4_1a'].$ket_pil_rep4['ket_in_rep_pil4_1b'].$ket_pil_rep4['ket_in_rep_pil4_1c']));
$pdf->Row2(array('','Laporan Pemeriksaan SKAI',  $pil_rep4['pilar4_1a'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Laporan Hasil Monitoring Satuan Kerja Kepatuhan',  $pil_rep4['pilar4_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Pemberitaan Positif Tentang Kinerja dan Kegiatan Bank',  $pil_rep4['pilar4_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_reputasi['ket_inheren']));






$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR REPUTASI');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko reputasi yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_reputasi1['pil1_total1'],  $ru_rep1['respon_pil1_1a'].$ru_rep1['respon_pil1_1b'].$ru_rep1['respon_pil1_1c'].$ru_rep1['respon_pil1_1d'].$ru_rep1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP reputasi, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_reputasi1['pilar1_1a'], '
 

 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Dewan Komisaris telah dilakukan (Ketentuan reputasi yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_reputasi1['pilar1_1b'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko reputasi dalam menjalankan tugas dan fungsinya',  $kpmr_reputasi1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko reputasi sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_reputasi1['pilar1_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_reputasi1['pilar1_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko reputasi secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_reputasi1['pil1_total2'],  $ru_rep1['respon_pil1_2a'].$ru_rep1['respon_pil1_2b'].$ru_rep1['respon_pil1_2c'].$ru_rep1['respon_pil1_2d'].$ru_rep1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko reputasi secara tertulis dan dalam forum rapat (terdapat notulen)',  $kpmr_reputasi1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko reputasi kepada Direksi secara tertulis dan forum rapat',  $kpmr_reputasi1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko reputasi',  $kpmr_reputasi1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko reputasi',  $kpmr_reputasi1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_reputasi1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko reputasi, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_reputasi1['pil1_total3'],  $ru_rep1['respon_pil1_3a'].$ru_rep1['respon_pil1_3b'].$ru_rep1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko reputasi (Pelatihan tentang manajemen risiko reputasi yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko reputasi)',  $kpmr_reputasi1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko Reputasi yang disetujui Direksi apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP PerReputasian, SE Direksi, SK BWMK)',  $kpmr_reputasi1['pilar1_3b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko reputasi yang disetujui Direksi dilakukan (Ketentuan reputasi yang diterbitkan selama periode penilaian)',  $kpmr_reputasi1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko reputasi, dan melakukan komunikasi kebijakan Manajemen Risiko reputasi terhadap seluruh jenjang organisasi BPR?',  $kpmr_reputasi1['pil1_total4'],  $ru_rep1['respon_pil1_4a'].$ru_rep1['respon_pil1_4b'].$ru_rep1['respon_pil1_4c'].$ru_rep1['respon_pil1_4d'].$ru_rep1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko reputasi',  $kpmr_reputasi1['pilar1_4a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_reph unit kerja',  $kpmr_reputasi1['pilar1_4b'],  '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko reputasi kepada seluru_reph unit kerja',  $kpmr_reputasi1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_reputasi1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_reputasi1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi reputasi dan fungsi Manajemen Risiko reputasi?',  $kpmr_reputasi1['pil1_total5'],  $ru_rep1['respon_pil1_5a'].$ru_rep1['respon_pil1_5b'].$ru_rep1['respon_pil1_5c'].$ru_rep1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perreputasi dan melaksanakan tugasnya secara independen',  $kpmr_reputasi1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja reputasi telah didukung dengan kompetensi yang baik',  $kpmr_reputasi1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko reputasi telah didukung dengan kompetensi yang baik',  $kpmr_reputasi1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses perreputasi dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_reputasi1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko reputasi?',  $kpmr_reputasi1['pil1_total6'],  $ru_rep1['respon_pil1_6a'].$ru_rep1['respon_pil1_6b'].$ru_rep1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko reputasi, tidak terdapat perangkapan jabatan, independen',  $kpmr_reputasi1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_reputasi1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang reputasi',  $kpmr_reputasi1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr5['pil1_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko reputasi yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_reputasi2['pil2_total1'],  $ru_rep2['respon_pil2_1a'].$ru_rep2['respon_pil2_1b'].$ru_rep2['respon_pil2_1c'].$ru_rep2['respon_pil2_1d'].$ru_rep2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko reputasi',  $kpmr_reputasi2['pilar2_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko reputasi',  $kpmr_reputasi2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko reputasi dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_reputasi2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko reputasi memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko reputasi, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_reputasi2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_reputasi2['pilar2_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko reputasi dan penetapan limit Risiko reputasi secara berkala?"',  $kpmr_reputasi2['pil2_total2'],  $ru_rep2['respon_pil2_2a'].$ru_rep2['respon_pil2_2b'].$ru_rep2['respon_pil2_2c'].$ru_rep2['respon_pil2_2d'].$ru_rep2['respon_pil2_2e'].$ru_rep2['respon_pil2_2f'].$ru_rep2['respon_pil2_2g'].$ru_rep2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko reputasi yang ditetapkan dalam SK Direksi',  $kpmr_reputasi2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko reputasi',  $kpmr_reputasi2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_reputasi2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko reputasi',  $kpmr_reputasi2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_reputasi2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi reputasi',  $kpmr_reputasi2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_reputasi2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_reputasi2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko reputasi sesuai dengan ketentuan?',  $kpmr_reputasi2['pil2_total3'],  $ru_rep2['respon_pil2_3a'].$ru_rep2['respon_pil2_3b'].$ru_rep2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_reputasi2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_reputasi2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_reputasi2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr5['pil2_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko reputasi yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko reputasi?',  $kpmr_reputasi3['pil3_total1'],  $ru_rep3['respon_pil3_1a'].$ru_rep3['respon_pil3_1b'].$ru_rep3['respon_pil3_1c'].$ru_rep3['respon_pil3_1d'].$ru_rep3['respon_pil3_1e'].$ru_rep3['respon_pil3_1f'].$ru_rep3['respon_pil3_1g'].$ru_rep3['respon_pil3_1h'].$ru_rep3['respon_pil3_1i'].$ru_rep3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas reputasi seluruh SDM telah berpedoman pada penerapan manajemen risiko reputasi',  $kpmr_reputasi3['pilar3_1a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas reputasi',  $kpmr_reputasi3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses reputasi dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_reputasi3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang perreputasian dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_reputasi3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko reputasi telah didukung dengan data reputasi yang akurat dan informatif',  $kpmr_reputasi3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko reputasi telah melakukan analisa karakteristik risiko reputasi yang melekat pada produk dan layanan',  $kpmr_reputasi3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko reputasi telah dilakukan evaluasi',  $kpmr_reputasi3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko reputasi telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_reputasi3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko reputasi telah dilakukan evaluasi terhadap eksposur risiko reputasi',  $kpmr_reputasi3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko reputasi apakah juga dilakukan penyesuaian pelaporan',  $kpmr_reputasi3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko reputasi serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_reputasi3['pil3_total2'],  $ru_rep3['respon_pil3_2a'].$ru_rep3['respon_pil3_2b'].$ru_rep3['respon_pil3_2c'].$ru_rep3['respon_pil3_2d'].$ru_rep3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_reputasi3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko reputasi dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_reputasi3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko reputasi yang lengkap dan cepat',  $kpmr_reputasi3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan reputasi terhadap kebijakan manajemen risiko reputasi (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_reputasi3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_reputasi3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr5['pil3_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko reputasi, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_reputasi4['pil4_total1'],  $ru_rep4['respon_pil4_1a'].$ru_rep4['respon_pil4_1b'].$ru_rep4['respon_pil4_1c'].$ru_rep4['respon_pil4_1d'].$ru_rep4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko reputasi di berapa cabang atau unit kerja di bidang manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1a'], '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko reputasi telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_reputasi4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko reputasi telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk reputasi kebijakan manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko reputasi',  $kpmr_reputasi4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko reputasi telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_reputasi4['pil4_total2'],  $ru_rep4['respon_pil4_2a'].$ru_rep4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perreputasian',  $kpmr_reputasi4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja reputasi telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_reputasi4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr5['pil4_tingkat_risiko'],  $ket_kpmr_reputasi['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR REPUTASI', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 - Pengawasan Direksi dan Dewan Komisaris',$kpmr5['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr5['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr5['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr5['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr5['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr5['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR REPUTASI', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_reputasi['ket_kpmr']));




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

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket5['inheren_reputasi'], $ket5['kpmr_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket5['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket5['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket5['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa






$pdf->AddPage();


$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(75);$pdf->Cell(8, 5, '(RISIKO STRATEJIK)');
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

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Penetapan Strategi Bisnis',  $pil_stra1['hasil_pil1_par1'],  $ket_pil_stra1['ket_in_stra_pil1_1'].$ket_pil_stra1['ket_in_stra_pil1_1a'].$ket_pil_stra1['ket_in_stra_pil1_1b'].$ket_pil_stra1['ket_in_stra_pil1_1c'].$ket_pil_stra1['ket_in_stra_pil1_1d'].$ket_pil_stra1['ket_in_stra_pil1_1e'].$ket_pil_stra1['ket_in_stra_pil1_1f']));
$pdf->Row2(array('','Penetapan Strategi Bisnis',  $pil_stra1['pilar1_1'], ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Posisi Kompetitif di industri',  $pil_stra1['pilar1_1a'],  
 
 
 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Faktor Eksternal',  $pil_stra1['pilar1_1b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Rencana Keberlangsungan Manajerial',  $pil_stra1['pilar1_1c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kecukupan Sumber Daya',  $pil_stra1['pilar1_1d'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Beban Kerja pada Seluruh Unit Kerja dalam mencapai target',  $pil_stra1['pilar1_1e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Potensi Pasar',  $pil_stra1['pilar1_1f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 - Penetapan Strategi Bisnis',$hasil6['pil1_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil1']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 2 : Penyusunan Rencana Bisnis'));

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Analisa Produk dan Layanan Baru',  $pil_stra2['pilar2_1g'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Identifikasi Perubahan Lingkungan Bisnis',  $pil_stra2['pilar2_1h'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kesesuaian Kebijakan yang Ditetapkan dengan Implementasi Kebijakan Terhadap Rencana Bisnis',  $pil_stra2['pilar2_1i'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['hasil_pil2_par2'],  $ket_pil_stra2['ket_in_stra_pil2_2'].$ket_pil_stra2['ket_in_stra_pil2_2a'].$ket_pil_stra2['ket_in_stra_pil2_2b'].$ket_pil_stra2['ket_in_stra_pil2_2c']));
$pdf->Row2(array('','Keunggulan kompetitif BPR dan ancaman dari kompetitor',  $pil_stra2['pilar2_2'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kondisi persaingan / kompetitor',  $pil_stra2['pilar2_2a'],  

 ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Preferensi Nasabah',  $pil_stra2['pilar2_2b'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Analisa Indikator Utama Posisi Bisnis Peer Group',  $pil_stra2['pilar2_2c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Penyusunan Rencana Bisnis',$hasil6['pil2_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil2']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 3 : Pencapaian Target Bisnis'));

$pdf->SetFont('Arial', '', 7);
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
$pdf->Row2(array('','Realisasi Pemenuhan Jumlah SDM Terhadap Target RBB',  $pil_stra3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Realisasi Waktu Pemenuhan SDM',  $pil_stra3['pilar3_2c'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Realisasi Modul Pelatihan dan Pendidikan Terhadap Target',  $pil_stra3['pilar3_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Realisasi Pelaksanaan Kegiatan Usaha Baru Terhadap Target',  $pil_stra3['pilar3_2e'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Realisasi Pemindahan Jaringan Kantor',  $pil_stra3['pilar3_2f'],  ''), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(79,15,94));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Pencapaian Target Bisnis',$hasil6['pil3_tingkat_risiko'],  $ket_inhern_stratejik['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->SetAligns(array(''));
$pdf->Row(array('PILAR 4 : LAINNYA'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,74,15,94));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;

$pdf->Row(array('1','Lainnya',  $pil_stra4['hasil_pil4_par1'], $ket_pil_stra4['ket_in_stra_pil4_1a'].$ket_pil_stra4['ket_in_stra_pil4_1b'].$ket_pil_stra4['ket_in_stra_pil4_1c'].$ket_pil_stra4['ket_in_stra_pil4_1d']));
$pdf->Row2(array('','Evaluasi Isu Stratejik Akibat Perubahan Lingkungan Bisnis',  $pil_stra4['pilar4_1a'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Pelaksanaan Tugas Core dan Supporting RTU',  $pil_stra4['pilar4_1b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Capaian Target RBB',  $pil_stra4['pilar4_1c'],  '
  '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Evaluasi Penyusunan dan Penerapan Rencana Kontinjensi',  $pil_stra4['pilar4_1d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
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
$pdf->SetFont('Arial', '', 7);

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

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_inhern_stratejik['ket_inheren']));




$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(1);
$pdf->Cell(8, 5, 'KPMR STRATEJIK');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();



$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(5, 5, 'No', 1, 0, 'C', 0);
$pdf->Cell(70, 5, 'Parameter KPMR', 1, 0, 'C', 0);



$pdf->Cell(23, 5, 'Peringkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(90, 5, 'Keterangan', 1, 0, 'C', 0);













//Membuat Koneksi ke database akademik




$pdf->Ln();



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 1 : Pengawasan Direksi dan Dewan Komisaris'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah Dewan Komisaris telah melakukan persetujuan terhadap kebijakan Manajemen Risiko stratejik yang disusun oleh Direksi dan melakukan evaluasi secara berkala?',  $kpmr_stratejik1['pil1_total1'],  $ru_stra1['respon_pil1_1a'].$ru_stra1['respon_pil1_1b'].$ru_stra1['respon_pil1_1c'].$ru_stra1['respon_pil1_1d'].$ru_stra1['respon_pil1_1e']));


$pdf->Row2(array('','Apakah ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Dewan Komisaris apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP stratejik, SE Direksi, SK BWMK, SK Limit dan Toleransi Risiko)',  $kpmr_stratejik1['pilar1_1a'], '
 
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah evaluasi ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Dewan Komisaris telah dilakukan (Ketentuan stratejik yang diterbitkan selama periode penilaian) dan kapan dilakukan secara periodik serta dilakukan kepada siapa saja',  $kpmr_stratejik1['pilar1_1b'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko stratejik dalam menjalankan tugas dan fungsinya',  $kpmr_stratejik1['pilar1_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah memastikan Direksi dan jajarannya dalam penerapan manajemen risiko stratejik sesuai kebijakan manajemen risiko yang ditetapkan',  $kpmr_stratejik1['pilar1_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris dalam melakukan evaluasi telah mempertimbangkan masukan dari Komite Pemantau Risiko',  $kpmr_stratejik1['pilar1_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('2','Apakah Dewan komisaris telah melakukan evaluasi terhadap pertanggungjawaban Direksi atas pelaksanaan kebijakan Manajemen Risiko stratejik secara berkala dan memastikan tindak lanjut hasil evaluasi dimaksud ?',  $kpmr_stratejik1['pil1_total2'],  $ru_stra1['respon_pil1_2a'].$ru_stra1['respon_pil1_2b'].$ru_stra1['respon_pil1_2c'].$ru_stra1['respon_pil1_2d'].$ru_stra1['respon_pil1_2e']));
$pdf->Row2(array('','Apakah Dewan Komisaris melaksanakan pengawasan terhadap pelaksanaan pertanggungjawaban Direksi dalam penerapan manajemen risiko stratejik secara tertulis dan dalam foruam rapat (terdapat notulen)',  $kpmr_stratejik1['pilar1_2a'], '


 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris memberikan masukan dan pengarahan penerapan manajemen risiko stratejik kepada Direksi secara tertulis dan foruam rapat',  $kpmr_stratejik1['pilar1_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Dewan Komisaris melakukan monitoring tindak lanjut evaluasi pertanggungjawaban Direksi penerapan manajemen risiko stratejik',  $kpmr_stratejik1['pilar1_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris secara konsisten mengembangkan budaya sadar risiko stratejik',  $kpmr_stratejik1['pilar1_2d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Dewan Komisaris telah melakukan evaluasi dan memutuskan permohonan Direksi yang berkaitan dengan transaksi yang memerlukan persetujuan Dewan Komisaris',  $kpmr_stratejik1['pilar1_2e'],  '
 

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('3','Apakah Direksi telah menyusun kebijakan Manajemen Risiko stratejik, melaksanakan secara konsisten, dan melakukan pengkinian secara berkala?',  $kpmr_stratejik1['pil1_total3'],  $ru_stra1['respon_pil1_3a'].$ru_stra1['respon_pil1_3b'].$ru_stra1['respon_pil1_3c']));
$pdf->Row2(array('','Direksi mampu mengimplementasikan kompetensi yang dimiliki di bidang manajemen risiko stratejik (Pelatihan tentang manajemen risiko stratejik yang diikuti, pengalaman di bidang yang berkaitan dengan manajemen risiko stratejik)',  $kpmr_stratejik1['pilar1_3a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Direksi apa saja yang telah ditetapkan (PKPB, SK Direksi, SOP Perstratejikan, SE Direksi, SK BWMK)',  $kpmr_stratejik1['pilar1_3b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Kapan evaluasi ketentuan dan kebijakan manajemen risiko stratejik yang disetujui Direksi dilakukan (Ketentuan stratejik yang diterbitkan selama periode penilaian)',  $kpmr_stratejik1['pilar1_3c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->Row(array('4','Apakah Direksi telah memiliki kemampuan untuk mengambil tindakan yang diperlukan dalam rangka mitigasi Risiko stratejik, dan melakukan komunikasi kebijakan Manajemen Risiko stratejik terhadap seluruh jenjang organisasi BPR?',  $kpmr_stratejik1['pil1_total4'],  $ru_stra1['respon_pil1_4a'].$ru_stra1['respon_pil1_4b'].$ru_stra1['respon_pil1_4c'].$ru_stra1['respon_pil1_4d'].$ru_stra1['respon_pil1_4e']));
$pdf->Row2(array('','Apakah Direksi secara konsisten mengambil tindakan yang perlu dilakukan dalam mitigasi risiko stratejik',  $kpmr_stratejik1['pilar1_4a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala menyampaikan tindakan dan kebijakan dalam rangka pengendalian dan mitgasi risiko kepada seluru_strah unit kerja',  $kpmr_stratejik1['pilar1_4b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara konsisten telah mengembangkan budaya sadar risiko stratejik kepada seluru_strah unit kerja',  $kpmr_stratejik1['pilar1_4c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi secara berkala melakukan review atas kebijakan pendelegasian kewenangan yang diberikan',  $kpmr_stratejik1['pilar1_4d'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi telah melakukan evaluasi terhadap usulan transaksi yang diterima sebelum memberikan persetujuan.',  $kpmr_stratejik1['pilar1_4e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('5','Apakah BPR telah memiliki kecukupan organisasi yang menangani fungsi stratejik dan fungsi Manajemen Risiko stratejik?',  $kpmr_stratejik1['pil1_total5'],  $ru_stra1['respon_pil1_5a'].$ru_stra1['respon_pil1_5b'].$ru_stra1['respon_pil1_5c'].$ru_stra1['respon_pil1_5d']));
$pdf->Row2(array('','Fungsi Second Line (SKMR dan SKK) apakah telah terpisah dari Unit Kerja perstratejik dan melaksanakan tugasnya secara independen',  $kpmr_stratejik1['pilar1_5a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di unit kerja stratejik telah didukung dengan kompetensi yang baik',  $kpmr_stratejik1['pilar1_5b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kecukupan organisasi di satuan manajemen risiko stratejik telah didukung dengan kompetensi yang baik',  $kpmr_stratejik1['pilar1_5c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah proses perstratejik dapat dijalankan sesuai dengan ketentuan oleh masing-masing unit kerja secara independen',  $kpmr_stratejik1['pilar1_5d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('6','Apakah Direksi telah menerapkan kebijakan pengelolaan SDM dalam rangka penerapan Manajemen Risiko stratejik?',  $kpmr_stratejik1['pil1_total6'],  $ru_stra1['respon_pil1_6a'].$ru_stra1['respon_pil1_6b'].$ru_stra1['respon_pil1_6c']));
$pdf->Row2(array('','Apakah ketentuan SOTK telah sesuai dengan penerapan manajemen risiko stratejik, tidak terdapat perangkapan jabatan, independen',  $kpmr_stratejik1['pilar1_6a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah pedoman pengelolaan SDM dilakukan review secara berkala',  $kpmr_stratejik1['pilar1_6b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Direksi melakukan evaluasi ketercukupan jumlah SDM bidang stratejik',  $kpmr_stratejik1['pilar1_6c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr6['pil1_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil1']));





$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 2 : Kecukupan Kebijakan, Prosedur dan Limit'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah memiliki kebijakan Manajemen Risiko stratejik yang memadai dan disusun dengan mempertimbang kan visi, misi, skala usaha dan kompleksitas bisnis, serta kecukupan SDM?',  $kpmr_stratejik2['pil2_total1'],  $ru_stra2['respon_pil2_1a'].$ru_stra2['respon_pil2_1b'].$ru_stra2['respon_pil2_1c'].$ru_stra2['respon_pil2_1d'].$ru_stra2['respon_pil2_1e']));


$pdf->Row2(array('','Apakah dalam penyusunan rencana kerja telah merujuk pada penerapan manajemen risiko stratejik',  $kpmr_stratejik2['pilar2_1a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam menyusun rencana kerja telah mendasarkan pada pengalaman dan capaian sebelumya dengan tetap memperhatikan pengelolaan dan mitigasi risiko stratejik',  $kpmr_stratejik2['pilar2_1b'],  '
 
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan manajemen risiko stratejik dilakukan kaji ulang oleh pihak yang independen dan dilaporkan ke Dewan Komisaris dan Direksi',  $kpmr_stratejik2['pilar2_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan dan prosedur Manajemen Risiko serta penetapan limit Risiko stratejik memadai dan telah tersedia untuk seluruh area Manajemen Risiko untuk Risiko stratejik, sejalan dengan penerapan, dan dipahami dengan baik oleh pegawai',  $kpmr_stratejik2['pilar2_1d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan tingkat Risiko yang akan diambil dan toleransi Risiko ditetapkan telah sesuai dengan sasaran strategi dan strategi bisnis',  $kpmr_stratejik2['pilar2_1e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','"Apakah BPR:
1. memiliki prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik yang ditetapkan oleh Direksi ?
2. melaksanakan prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik secara konsisten untuk seluruh aktivitas ? Dan
3. melakukan evaluasi dan pengkinian terhadap prosedur Manajemen Risiko stratejik dan penetapan limit Risiko stratejik secara berkala?"',  $kpmr_stratejik2['pil2_total2'],  $ru_stra2['respon_pil2_2a'].$ru_stra2['respon_pil2_2b'].$ru_stra2['respon_pil2_2c'].$ru_stra2['respon_pil2_2d'].$ru_stra2['respon_pil2_2e'].$ru_stra2['respon_pil2_2f'].$ru_stra2['respon_pil2_2g'].$ru_stra2['respon_pil2_2h']));


$pdf->Row2(array('','Apakah Unit Kerja telah memahami penetapan limit dan toleransi risiko stratejik yang ditetapkan dalam SK Direksi',  $kpmr_stratejik2['pilar2_2a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan pengawasan monitoring limit dan toleransi risiko stratejik',  $kpmr_stratejik2['pilar2_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah Unit Kerja melakukan evaluasi apabila terjadi pelampauan limit dan toleransi risiko yang ditetapkan',  $kpmr_stratejik2['pilar2_2c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SDM telah memahami ketentuan limit dan toleransi risiko yang ditetapkan dan menjadi acuan dalam pengendalian manajemen risiko stratejik',  $kpmr_stratejik2['pilar2_2d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kebijakan penetapan limit dan toleransi risiko dilakukan pengkinian sesuai dengan kondisi usaha dan perkembangan faktor eksternal yang berpengaruh pada ketentuan limit yang telah ditetapkan',  $kpmr_stratejik2['pilar2_2e'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah perumusan untuk penentuan limit dan toleransi risiko dilakukan sesuai dengan arah dan strategi stratejik',  $kpmr_stratejik2['pilar2_2f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit telah dilakukan sesuai dengan prosedur dan didokumentasikan sehingga memudahkan untuk dilakukan audit trail',  $kpmr_stratejik2['pilar2_2g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah penetapan limit dan toleransi risiko meliputi penetapan limit secara keseluruhan, per jenis risiko, dan per aktivitas fungsional yang memiliki eksposure risiko',  $kpmr_stratejik2['pilar2_2h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
//Membuat Koneksi ke database akademik


$pdf->Row(array('3','Apakah BPR telah memiliki kebijakan dan prosedur penerbitan produk dan/atau pelaksanaan aktivitas baru yang mencakup identifikasi dan mitigasi Risiko stratejik sesuai dengan ketentuan?',  $kpmr_stratejik2['pil2_total3'],  $ru_stra2['respon_pil2_3a'].$ru_stra2['respon_pil2_3b'].$ru_stra2['respon_pil2_3c']));


$pdf->Row2(array('','Apakah unit kerja telah memahami ketentuan dan prosedur produk dan aktivitas baru dan risiko yang melekat pada setiap produk dan mitigasinya',  $kpmr_stratejik2['pilar2_3a'], '
 
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dan aktivitas telah didukung dengan ketentuan dan petunjuk kerja yang lengkap',  $kpmr_stratejik2['pilar2_3b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah ketentuan kebijakan produk dilakukan evaluasi secara berkala',  $kpmr_stratejik2['pilar2_3c'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr6['pil2_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil2']));



$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 3 : Kecukupan Proses dan Sistem'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah BPR telah melaksanakan proses Manajemen Risiko stratejik yang melekat pada kegiatan usaha BPR yang terkait dengan Risiko stratejik?',  $kpmr_stratejik3['pil3_total1'],  $ru_stra3['respon_pil3_1a'].$ru_stra3['respon_pil3_1b'].$ru_stra3['respon_pil3_1c'].$ru_stra3['respon_pil3_1d'].$ru_stra3['respon_pil3_1e'].$ru_stra3['respon_pil3_1f'].$ru_stra3['respon_pil3_1g'].$ru_stra3['respon_pil3_1h'].$ru_stra3['respon_pil3_1i'].$ru_stra3['respon_pil3_1j']));


$pdf->Row2(array('','Apakah dalam aktvitas perstratejik seluruh SDM telah berpedoman pada penerapan manajemen risiko stratejik',  $kpmr_stratejik3['pilar3_1a'], '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah seluruh organisasi mampu dan mengedepankan prinsip kehati-hatian dalam aktivitas stratejik',  $kpmr_stratejik3['pilar3_1b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses perstratejik dilakukan verifikasi dual control dan didukung dengan dokumen yang memadai',  $kpmr_stratejik3['pilar3_1c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses pengambilan keputusan bidang perstratejikan dilakukan secara pembahasan bersama dan dilakukan secara transparan',  $kpmr_stratejik3['pilar3_1d'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajamen risiko stratejik telah didukung dengan data stratejik yang akurat dan informatif',  $kpmr_stratejik3['pilar3_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam proses manajemen risiko stratejik telah melakukan analisa karakteristik risiko stratejik yang melekat pada produk dan layanan',  $kpmr_stratejik3['pilar3_1f'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah kesesuaian asumsi, data, dan prosedur yang digunakan untuk mengukur risiko stratejik telah dilakukan evaluasi',  $kpmr_stratejik3['pilar3_1g'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pengukuran risiko stratejik telah dilakukan penyesuaian apabila terdapat perubahan yang material pada kegiatan layanan, produk, dan faktor risiko',  $kpmr_stratejik3['pilar3_1h'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah dalam melakukan pemantauan risiko stratejik telah dilakukan evaluasi terhadap eksposur risiko stratejik',  $kpmr_stratejik3['pilar3_1i'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apabila terdapat perubahan yang material dalam faktor risiko stratejik apakah juga dilakukan penyesuaian pelaporan',  $kpmr_stratejik3['pilar3_1j'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah BPR telah memiliki sistem informasi Manajemen Risiko yang mendukung Direksi dalam pengambilan keputusan terkait Risiko stratejik serta telah dilaporkan kepada Direksi secara berkala?',  $kpmr_stratejik3['pil3_total2'],  $ru_stra3['respon_pil3_2a'].$ru_stra3['respon_pil3_2b'].$ru_stra3['respon_pil3_2c'].$ru_stra3['respon_pil3_2d'].$ru_stra3['respon_pil3_2e']));


$pdf->Row2(array('','Sistem Informasi apa saja yang telah dimiliki termasuk dukungan CBS dan aplikasi bantu lainnya',  $kpmr_stratejik3['pilar3_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi risiko stratejik dapat dan mudah diakses serta laporan yang lengkap',  $kpmr_stratejik3['pilar3_2b'],  '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu mendukung pelaporan risiko stratejik yang lengkap dan cepat',  $kpmr_stratejik3['pilar3_2c'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki mampu meningkatkan stratejik terhadap kebijakan manajemen risiko stratejik (terkait produk, layanan, limit, penilaian, contingency plan, dan fungsi pengawasan)',  $kpmr_stratejik3['pilar3_2d'],  '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah sistem informasi yang dimiliki menyajikan informasi realisasi penerapan manajemen risiko dibandingkan dengan target yang ditetapkan (Risk Control dan tindak lanjut perbaikannya)',  $kpmr_stratejik3['pilar3_2e'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);



$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr6['pil3_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil3']));


$pdf->SetFont('Arial', 'B', 8);
$pdf->SetAligns(array(''));
$pdf->SetWidths(array(188));
$pdf->Row(array('PILAR 4 : Sistem Pengendalian yang Menyeluruh'));

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(5,70,23,90));
$pdf->SetAligns(array('C', '', 'C'));

$no =1;


$pdf->Row(array('1','Apakah SKAI atau PEAI telah melakukan audit secara berkala terhadap penerapan Manajemen Risiko stratejik, menyampaikan laporan hasil audit intern, dan memastikan tindaklanjut atas temuan pemeriksaan?',  $kpmr_stratejik4['pil4_total1'],  $ru_stra4['respon_pil4_1a'].$ru_stra4['respon_pil4_1b'].$ru_stra4['respon_pil4_1c'].$ru_stra4['respon_pil4_1d'].$ru_stra4['respon_pil4_1e']));


$pdf->Row2(array('','Apakah selama periode penilaian SKAI telah melakukan pemeriksaan penerapan manajemen risiko stratejik di berapa cabang atau unit kerja di bidang manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1a'], '



 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah setiap temuan SKAI dalam penerapan manajemen risiko stratejik telah dilakukan monitoring tindak lanjutnya dan telah dilaporkan kepada Direktur Utama',  $kpmr_stratejik4['pilar4_1b'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI dalam penerapan manajemen risiko stratejik telah melakukan pengawasan atas penetapan wewenang dan tanggung jawab untuk stratejik kebijakan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1c'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan pengawasan pada pemisahan fungsi, struktur organisasi,fungsi pelaporan, dan dokumentasi penerapan manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1d'],  '


 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah SKAI telah melakukan verifikasi dan review terhadap sistem pengendalian intern manajemen risiko stratejik',  $kpmr_stratejik4['pilar4_1e'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);


$pdf->Row(array('2','Apakah sistem pengendalian intern terhadap Risiko stratejik telah dilaksanakan oleh seluruh jenjang organisasi BPR?',  $kpmr_stratejik4['pil4_total2'],  $ru_stra4['respon_pil4_2a'].$ru_stra4['respon_pil4_2b']));


$pdf->Row2(array('','Apakah unit kerja pengendalian telah terpisah dari unit kerja operasional perstratejikan',  $kpmr_stratejik4['pilar4_2a'], '
 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);
$pdf->Row2(array('','Apakah unit kerja stratejik telah memahami dan menjalankan tugas dan tanggung jawab sesuai dengan tupoksi',  $kpmr_stratejik4['pilar4_2b'],  '

 '), [[255, 255, 255],[255, 255, 255], [255, 255, 255], [128, 128, 128]]);

$pdf->SetFont('Arial', '', 7);
$pdf->SetWidths(array(75,23,90));
$pdf->SetAligns(array('C','C',''));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr6['pil4_tingkat_risiko'],  $ket_kpmr_stratejik['ket_pil4']));

$pdf->Ln();

$pdf->SetFillColor(224, 224, 23);
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'REKAP PENILAIAN KPMR STRATEJIK', 1, 0, 'C', 0);
$pdf->SetWidths(array(158, 30));
$pdf->SetAligns(array('', 'C'));
$pdf->Ln();
$no =1;
$pdf->SetFont('Arial', '', 7);

$pdf->Row(array('Hasil Penilaian Pilar 1 -Pengawasan Direksi dan Dewan Komisaris',$kpmr6['pil1_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 2 - Kecukupan Kebijakan, Prosedur dan Limit',$kpmr6['pil2_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 3 - Kecukupan Proses dan Sistem',$kpmr6['pil3_tingkat_risiko']));
$pdf->Row(array('Hasil Penilaian Pilar 4 - Sistem Pengendalian yang Menyeluruh',$kpmr6['pil4_tingkat_risiko']));

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(158, 5, 'Hasil Penilaian KPMR', 1, 0, 'C', 0);
$pdf->Cell(30, 5, $kpmr6['hasil_tingkat_risiko'] , 1, 0, 'C', 0);
$pdf->Ln();
$pdf->Cell(158);
$pdf->Cell(30, 5, $kpmr6['hasil_peringkat'] , 1, 0, 'C', 0);


$pdf->Ln();

$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);

$pdf->Cell(188, 5, 'URAIAN KPMR STRATEJIK', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket_kpmr_stratejik['ket_kpmr']));




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

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 0);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 0);






$pdf->SetFont('Arial', '', 7);





//Membuat Koneksi ke database akademik







$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket6['inheren_stratejik'], $ket6['kpmr_stratejik'], $ket6['tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_ket6['inheren_stratejik'], $pembanding_ket6['kpmr_stratejik'], $pembanding_ket6['tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
$pdf->Row(array($inheren6['hasil_peringkat'], $kpmr6['hasil_peringkat'], $ket6['peringkat_tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_inheren6['hasil_peringkat'], $pembanding_kpmr6['hasil_peringkat'], $pembanding_ket6['peringkat_tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(30, 5, 'Komponen', 1, 0, 'C', 0);


$pdf->Cell(158, 5, 'Keterangan', 1, 0, 'C', 0);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(30, 158));
$pdf->SetAligns(array('C'));
$pdf->Ln();
$no =1;


$pdf->Row(array('Tingkat Risiko',$ket6['ket_profil_risiko']));
$pdf->Row(array('Risiko Inheren',$ket6['ket_profil_inheren']));
$pdf->Row(array('Tingkat Kualitas MR',$ket6['ket_profil_kpmr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa









//Membuat Koneksi ke database akademik



$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(1);
$pdf->Cell(8, 5, '(PROFIL NILAI)');
$pdf->Ln(6);
$pdf->Cell(1);

$pdf->Ln();
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Kredit', 1, 0, 'C', 1);
$pdf->Ln();
$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket1['inheren_kredit'], $ket1['kpmr_kredit'], $ket1['tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_ket1['inheren_kredit'], $pembanding_ket1['kpmr_kredit'], $pembanding_ket1['tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
$pdf->Row(array($inheren1['hasil_peringkat'], $kpmr1['hasil_peringkat'], $ket1['peringkat_tingkat_risiko'], $ket1['tingkat_kualitas_mr'],  $pembanding_inheren1['hasil_peringkat'], $pembanding_kpmr1['hasil_peringkat'], $pembanding_ket1['peringkat_tingkat_risiko'], $pembanding_ket1['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();
$pdf->Ln();

$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Operasional', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;
$pdf->Row(array($ket2['inheren_operasional'], $ket2['kpmr_operasional'], $ket2['tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_ket2['inheren_operasional'], $pembanding_ket2['kpmr_operasional'], $pembanding_ket2['tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
$pdf->Row(array($inheren2['hasil_peringkat'], $kpmr2['hasil_peringkat'], $ket2['peringkat_tingkat_risiko'], $ket2['tingkat_kualitas_mr'],  $pembanding_inheren2['hasil_peringkat'], $pembanding_kpmr2['hasil_peringkat'], $pembanding_ket2['peringkat_tingkat_risiko'], $pembanding_ket2['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Kepatuhan', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket3['inheren_kepatuhan'], $ket3['kpmr_kepatuhan'], $ket3['tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_ket3['inheren_kepatuhan'], $pembanding_ket3['kpmr_kepatuhan'], $pembanding_ket3['tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
$pdf->Row(array($inheren3['hasil_peringkat'], $kpmr3['hasil_peringkat'], $ket3['peringkat_tingkat_risiko'], $ket3['tingkat_kualitas_mr'],  $pembanding_inheren3['hasil_peringkat'], $pembanding_kpmr3['hasil_peringkat'], $pembanding_ket3['peringkat_tingkat_risiko'], $pembanding_ket3['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->AddPage();
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Likuiditas', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket4['inheren_likuiditas'], $ket4['kpmr_likuiditas'], $ket4['tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_ket4['inheren_likuiditas'], $pembanding_ket4['kpmr_likuiditas'], $pembanding_ket4['tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
$pdf->Row(array($inheren4['hasil_peringkat'], $kpmr4['hasil_peringkat'], $ket4['peringkat_tingkat_risiko'], $ket4['tingkat_kualitas_mr'],  $pembanding_inheren4['hasil_peringkat'], $pembanding_kpmr4['hasil_peringkat'], $pembanding_ket4['peringkat_tingkat_risiko'], $pembanding_ket4['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Reputasi', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;

$pdf->Row(array($ket5['inheren_reputasi'], $ket5['kpmr_reputasi'], $ket5['tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_ket5['inheren_reputasi'], $pembanding_ket5['kpmr_reputasi'], $pembanding_ket5['tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
$pdf->Row(array($inheren5['hasil_peringkat'], $kpmr5['hasil_peringkat'], $ket5['peringkat_tingkat_risiko'], $ket5['tingkat_kualitas_mr'],  $pembanding_inheren5['hasil_peringkat'], $pembanding_kpmr5['hasil_peringkat'], $pembanding_ket5['peringkat_tingkat_risiko'], $pembanding_ket5['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa
$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(204, 245, 255);
$pdf->Cell(188, 5, 'Risiko Stratejik', 1, 0, 'C', 1);
$pdf->Ln();

$pdf->SetFillColor(51, 204, 255);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(94, 5, 'Periode pelaporan', 1, 0, 'C', 1);
$pdf->Cell(94, 5, 'Periode Sebelumnya', 1, 0, 'C', 1);


$pdf->Cell(0, 5, '', 0, 1);

$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->Cell(23.5, 5, 'Risiko Inheren', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Risiko KPMR', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Tingkat Risiko', 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, 'Kualitas Manrisk', 1, 0, 'C', 1);


$pdf->SetWidths(array(23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5, 23.5));
$pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C', 'C'));
$pdf->Ln();
$no =1;


$pdf->Row(array($ket6['inheren_stratejik'], $ket6['kpmr_stratejik'], $ket6['tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_ket6['inheren_stratejik'], $pembanding_ket6['kpmr_stratejik'], $pembanding_ket6['tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
$pdf->Row(array($inheren6['hasil_peringkat'], $kpmr6['hasil_peringkat'], $ket6['peringkat_tingkat_risiko'], $ket6['tingkat_kualitas_mr'],  $pembanding_inheren6['hasil_peringkat'], $pembanding_kpmr6['hasil_peringkat'], $pembanding_ket6['peringkat_tingkat_risiko'], $pembanding_ket6['tingkat_kualitas_mr']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa

$pdf->SetFillColor(51, 204, 255);
$pdf->Cell(47, 5,'Peringkat Risiko' , 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $nilpro['total_nilai'], 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $nilpro['ket_total_nilai'], 1, 0, 'C', 1);

$pdf->Cell(47, 5,'Dikutip dari laporan sebelumnya' , 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $pembanding_nilpro['total_nilai'], 1, 0, 'C', 1);
$pdf->Cell(23.5, 5, $pembanding_nilpro['ket_total_nilai'], 1, 0, 'C', 1);







$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(51, 204, 255);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(188, 5, 'Uraian', 1, 0, 'C', 1);

$pdf->SetFont('Arial', '', 7);

$pdf->SetWidths(array(188));
$pdf->SetAligns(array());
$pdf->Ln();
$no =1;


$pdf->Row(array($nilpro['ket_nilai_risiko']));
//Query untuk mengambil data mahasiswa pada tabel mahasiswa




$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(1);
$pdf->Cell(10, 5, 'Dengan ini menyatakan bahwa seluruh informasi dalam pengisian profil risiko di BPR BKK Jateng adalah akurat ');
$pdf->Ln();
$pdf->Cell(10, 5, 'dan sesuai dengan kondisi sebenarnya.');
$pdf->Ln(30);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Semarang, ' . tgl_indo(date('Y-m-d')), 0, 1, 'C');
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Mengetahui', 0, 1, 'C');
$pdf->Cell(50);
$pdf->Cell(190, 5, 'Kepala Satuan Kerja Manajemen Risiko', 0, 1, 'C');
$pdf->Ln(16);
$pdf->Cell(50);
$pdf->SetFont('Arial', 'U', 12);
$pdf->Cell(190, 5,'l', 'U', 12);
$pdf->Cell(190, 5,'SHOLEH KUSDIANTO,S.KOM, S.Akun., MM', 0, 1, 'C');
$pdf->Cell(50);
$pdf->SetFont('Arial', '', 12);




$pdf->Output();
